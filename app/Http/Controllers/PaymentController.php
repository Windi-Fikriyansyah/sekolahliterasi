<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

// Import Xendit classes correctly
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceItem;
use Xendit\Invoice\CustomerObject;

class PaymentController extends Controller
{


    public function createPayment($id)
    {


        try {
            $productid = Crypt::decrypt($id);

            $produk   = DB::table('products')->where('id', $productid)->first();
            $user     = Auth::user();
            $referralCode = request()->query('referral_code');

            // dd($referralCode);
            $hasAccess = DB::table('enrollments')
                ->where('user_id', $user->id)
                ->where('product_id', $produk->id)
                ->exists();


            $unpaidTrx = DB::table('transactions')
                ->where('user_id', $user->id)
                ->where('product_id', $produk->id)
                ->whereIn('status', ['UNPAID', 'PENDING'])
                ->orderBy('created_at', 'desc')
                ->first();

            if ($unpaidTrx) {
                return redirect()->route('history.index')
                    ->with('toast', [
                        'type' => 'info',
                        'message' => 'Anda masih memiliki transaksi yang belum dibayar. Silakan selesaikan pembayaran di history.'
                    ]);
            }

            if ($hasAccess) {
                return redirect()->route('produk.detail', $id)
                    ->with('info', 'Anda sudah memiliki akses ke kursus ini.');
            }




            $apiKey = config('services.tripay.api_key');
            $url    = config('services.tripay.sandbox');


            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])->get($url);

            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil channel pembayaran Tripay');
            }



            $channels = $response->json('data');

            // dd($channels);

            return view('produk.checkout', [
                'produk' => $produk,
                'channels' => $channels,
                'encryptedCourseId' => $id,
                'referralCode' => $referralCode,
            ]);
        } catch (\Exception $e) {
            Log::error('Tripay Payment error', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }


    public function processPayment(Request $request, $encryptedCourseId)
    {

        try {

            $productid = Crypt::decrypt($encryptedCourseId);

            $produk   = DB::table('products')->where('id', $productid)->first();
            $user     = Auth::user();


            if (!$produk) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            $unpaidTrx = DB::table('transactions')
                ->where('user_id', $user->id)
                ->where('product_id', $produk->id)
                ->whereIn('status', ['UNPAID', 'PENDING'])
                ->orderBy('created_at', 'desc')
                ->first();


            if ($unpaidTrx) {
                return redirect()->route('history.index')
                    ->with('toast', [
                        'type' => 'info',
                        'message' => 'Anda masih memiliki transaksi yang belum dibayar. Silakan selesaikan pembayaran di history.'
                    ]);
            }

            $channel = $request->input('channel');

            $referralCode = $request->input('referral_code');

            // Data transaksi
            $merchantRef = 'INV-' . $produk->id . '-' . $user->id . '-' . time();
            $amount = (int) $produk->harga;

            $merchantCode = config('services.tripay.merchant_code');
            $privateKey   = config('services.tripay.private_key');
            $apiKey       = config('services.tripay.api_key');

            $signature = hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey);

            $payload = [
                'method'        => $channel,
                'merchant_ref'  => $merchantRef,
                'amount'        => $amount,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? '081234567890',
                'order_items'   => [
                    [
                        'sku'       => 'PRODUK-' . $produk->id,
                        'name'      => $produk->judul,
                        'price'     => $amount,
                        'quantity'  => 1,
                        'subtotal'  => $amount,
                    ]
                ],
                'callback_url'  => route('payment.callback'),
                'return_url'    =>  route('payment.redirect', $encryptedCourseId),
                'expired_time'  => now()->addDay()->timestamp,
                'signature'     => $signature,
            ];


            $url = config('services.tripay.urlcreatetripay');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])->post($url, $payload);


            if (!$response->successful()) {
                Log::error('Tripay transaction failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran.');
            }

            $result = $response->json();

            if (!isset($result['success']) || !$result['success']) {
                return redirect()->back()->with('error', $result['message'] ?? 'Gagal membuat transaksi.');
            }

            $data = $result['data'];

            $invoiceId = $data['reference'] ?? $merchantRef;

            DB::table('transactions')->insert([
                'external_id'     => $merchantRef,
                'invoice_id'      => $invoiceId,
                'user_id'         => $user->id,
                'product_id'       => $produk->id,
                'referral_code'   => $referralCode,
                'amount'          => $amount,
                'status'          => $data['status'],
                'expired_at'      => Carbon::createFromTimestamp($data['expired_time']),
                'payment_method'  => $data['payment_method'],
                'payment_channel' => $channel,
                'tripay_data'     => json_encode($data),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
            Log::info('Transaction created', [
                'merchant_ref' => $merchantRef,
                'invoice_id' => $invoiceId,
                'user_id' => $user->id
            ]);

            return redirect($data['checkout_url']);
        } catch (\Exception $e) {
            Log::error('processTransaction error', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }



    public function redirectAfterPayment(Request $request, $encryptedCourseId)
    {
        try {
            Log::info('RedirectAfterPayment called with parameters:', [
                'all_query_params' => $request->query->all(),
                'encryptedCourseId' => $encryptedCourseId,
                'full_url' => $request->fullUrl()
            ]);
            $reference = $request->query('tripay_reference');

            if (!$reference) {
                return redirect()->route('produk.detail', $encryptedCourseId)
                    ->with('error', 'Parameter referensi pembayaran tidak ditemukan.');
            }

            $trx = DB::table('transactions')->where('invoice_id', $reference)->first();

            if (!$trx) {

                $trx = DB::table('transactions')->where('external_id', $reference)->first();

                if (!$trx) {
                    Log::warning('Transaksi tidak ditemukan', ['reference' => $reference]);
                    return redirect()->route('produk.detail', $encryptedCourseId)
                        ->with('error', 'Transaksi tidak ditemukan. Silakan hubungi admin dengan kode referensi: ' . $reference);
                }
            }


            if ($trx->user_id !== Auth::id()) {
                return redirect()->route('produk.detail', $encryptedCourseId)
                    ->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
            }

            if ($trx->status === 'PAID') {
                return $this->success($encryptedCourseId);
            } elseif (in_array($trx->status, ['UNPAID', 'PENDING'])) {
                return redirect()->route('produk.detail', $encryptedCourseId)
                    ->with('info', 'Pembayaran Anda masih menunggu konfirmasi. Silakan selesaikan pembayaran.');
            } else {
                return $this->failed($encryptedCourseId);
            }
        } catch (\Exception $e) {
            Log::error('Redirect after payment error', [
                'error' => $e->getMessage(),
                'reference' => $request->query('reference')
            ]);

            return redirect()->route('produk.detail', $encryptedCourseId)
                ->with('error', 'Terjadi kesalahan sistem. Silakan hubungi admin.');
        }
    }

    public function callback(Request $request)
    {
        try {
            $privateKey = config('services.tripay.private_key');

            $json = $request->getContent();

            $signature = hash_hmac('sha256', $json, $privateKey);

            if ($request->header('X-Callback-Signature') !== $signature) {
                Log::warning('Invalid callback signature', [
                    'received' => $request->header('X-Callback-Signature'),
                    'expected' => $signature,
                    'body' => $json,
                ]);
                return response()->json(['success' => false, 'message' => 'Invalid signature'], 403);
            }

            $data = json_decode($json, true);

            if ($request->header('X-Callback-Event') !== 'payment_status') {
                return response()->json(['success' => false, 'message' => 'Invalid event'], 400);
            }


            $trx = DB::table('transactions')->where('invoice_id', $data['reference'])->first();

            if (!$trx) {
                Log::error('Callback transaksi tidak ditemukan', ['reference' => $data['reference']]);
                return response()->json(['success' => false], 404);
            }

            DB::table('transactions')
                ->where('id', $trx->id)
                ->update([
                    'status' => $data['status'],
                    'paid_at' => isset($data['paid_at']) ? Carbon::createFromTimestamp($data['paid_at']) : null,
                    'updated_at' => now(),
                ]);


            if ($data['status'] === 'PAID') {

                $this->grantCourseAccess($trx->user_id, $trx->product_id, 'PAID');
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Callback error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }




    private function grantCourseAccess($userId, $productid, $status)
    {
        try {
            $enrollment = DB::table('enrollments')
                ->where('user_id', $userId)
                ->where('product_id', $productid)
                ->first();

            if ($enrollment) {
                // Update payment_status jika sudah ada
                DB::table('enrollments')
                    ->where('id', $enrollment->id)
                    ->update([
                        'payment_status' => $status,
                        'enrolled_at' => now(),
                    ]);
            } else {
                // Insert baru jika belum ada
                DB::table('enrollments')->insert([
                    'user_id' => $userId,
                    'product_id' => $productid,
                    'payment_status' => $status,
                    'enrolled_at' => now(),
                ]);
            }



            $transaction = DB::table('transactions')
                ->where('user_id', $userId)
                ->where('product_id', $productid)
                ->latest()
                ->first();

            if ($transaction && !empty($transaction->referral_code)) {
                $referralUser = DB::table('users')
                    ->where('referral_code', $transaction->referral_code)
                    ->first();

                if ($referralUser && $referralUser->id != $userId) {
                    // Ambil persentase komisi dari tabel komisi
                    $commissionRate = DB::table('komisi')->value('persentase') ?? 10; // default 10%

                    $commissionAmount = ($commissionRate / 100) * $transaction->amount;

                    DB::table('users')
                        ->where('id', $referralUser->id)
                        ->increment('balance', $commissionAmount);
                    DB::table('referral_commissions')->insert([
                        'user_id' => $referralUser->id,
                        'referred_user_id' => $userId,
                        'transaction_id' => $transaction->id,
                        'product_id' => $productid,
                        'amount' => $commissionAmount,
                        'percentage' => $commissionRate,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to grant course access', [
                'error' => $e->getMessage(),
                'user_id' => $userId,
                'product_id' => $productid
            ]);
        }
    }



    public function success($encryptedCourseId)
    {
        $productid = Crypt::decrypt($encryptedCourseId);
        $trx = DB::table('transactions')
            ->where('product_id', $productid)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        if ($trx && $trx->status === 'PAID') {
            return redirect()->route('produk.detail', $encryptedCourseId)
                ->with('success', 'Pembayaran berhasil! Anda sekarang memiliki akses ke kursus ini.');
        }

        return redirect()->route('produk.detail', $encryptedCourseId)
            ->with('error', 'Status pembayaran belum dikonfirmasi. Silakan tunggu atau hubungi admin.');
    }


    public function failed($encryptedCourseId)
    {
        return redirect()->route('produk.detail', $encryptedCourseId)
            ->with('error', 'Pembayaran gagal atau sudah kedaluwarsa. Silakan coba lagi.');
    }
}
