<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;



class CartController extends Controller
{
    // 🔹 Ambil semua item cart milik user login
    public function index()
    {
        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select(
                'carts.id as cart_id',
                'carts.qty',
                'carts.checked',
                'products.id as product_id',
                'products.judul',
                'products.harga',
                'products.thumbnail'
            )
            ->where('carts.user_id', Auth::id())
            ->get();

        return response()->json($carts);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $existing = DB::table('carts')
            ->where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            // jika sudah ada → naikkan qty
            DB::table('carts')
                ->where('id', $existing->id)
                ->update([
                    'qty' => $existing->qty + 1,
                    'updated_at' => now(),
                ]);
            return response()->json([
                'message' => 'Produk sudah ada di keranjang',
                'status' => 'exists'
            ]);
        }

        DB::table('carts')->insert([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'qty' => 1,
            'checked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Produk ditambahkan ke keranjang',
            'status' => 'new'
        ]);
    }

    // 🔹 Update jumlah (qty)
    public function updateQty(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        DB::table('carts')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->update([
                'qty' => $request->qty,
                'updated_at' => now(),
            ]);

        return response()->json(['message' => 'Jumlah diperbarui']);
    }

    // 🔹 Ubah status checked (pilih untuk checkout)
    public function toggleCheck(Request $request, $id)
    {
        $request->validate(['checked' => 'required|boolean']);

        DB::table('carts')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->update([
                'checked' => $request->checked,
                'updated_at' => now(),
            ]);


        return response()->json(['message' => 'Status diperbarui']);
    }


    // 🔹 Hapus item dari cart
    public function remove($id)
    {
        DB::table('carts')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json(['message' => 'Item dihapus dari keranjang']);
    }

    // 🔹 Hitung total belanja item yang dipilih (checked)
    public function total()
    {
        $total = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', Auth::id())
            ->where('carts.checked', true)
            ->sum(DB::raw('products.harga * carts.qty'));

        return response()->json(['total' => $total]);
    }


    public function processCheckout(Request $request)
    {

        try {
            $user = Auth::user();
            // dd($request->all());
            // Validasi input
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|email',
                'no_hp' => 'required|string|max:20',
                'alamat' => 'required|string',
                'provinsi' => 'required|string',
                'provinsi_nama' => 'required|string',
                'kota' => 'required|string',
                'kota_nama' => 'required|string',
                'kecamatan' => 'required|string',
                'kecamatan_nama' => 'required|string',
                'kurir' => 'required|string',
                'layanan_ongkir' => 'required|string',
                'items' => 'required|json',
            ]);



            $items = json_decode($request->items, true);
            if (empty($items)) {
                return response()->json(['success' => false, 'message' => 'Keranjang kosong']);
            }



            $subtotal = collect($items)->sum(fn($i) => $i['harga'] * $i['qty']);
            $ongkir = (int) $request->layanan_ongkir;
            $total = $subtotal + $ongkir;

            // Ambil daftar channel pembayaran dari Tripay
            $apiKey = config('services.tripay.api_key');
            $url = config('services.tripay.sandbox'); // endpoint daftar channel

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])->get($url);


            if (!$response->successful()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengambil channel pembayaran.']);
            }

            $channels = $response->json('data');


            // Kirim ke view pemilihan channel
            return view('produk.pilih_channel', [
                'channels' => $channels,
                'checkoutData' => [
                    'user' => $validated,
                    'items' => $items,
                    'subtotal' => $subtotal,
                    'ongkir' => $ongkir,
                    'total' => $total
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Checkout stage 1 error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }


    public function createPayment(Request $request)
    {
        try {
            $channel = $request->input('channel');
            if (!$channel) {
                return back()->with('error', 'Silakan pilih metode pembayaran.');
            }

            // Decode JSON checkoutData
            $data = json_decode($request->input('checkoutData'), true);
            if (is_string($data)) $data = json_decode($data, true);

            $items = $data['items'] ?? [];
            if (is_string($items)) $items = json_decode($items, true);

            $userData = $data['user'] ?? [];
            $total = (int)($data['total'] ?? 0);
            $ongkir = (int)($data['ongkir'] ?? 0);
            $user = Auth::user();

            // Config Tripay
            $merchantRef = 'INV-' . $user->id . '-' . time();
            $merchantCode = config('services.tripay.merchant_code');
            $privateKey = config('services.tripay.private_key');
            $apiKey = config('services.tripay.api_key');
            $tripayUrl = config('services.tripay.urlcreatetripay');
            $signature = hash_hmac('sha256', $merchantCode . $merchantRef . $total, $privateKey);

            // Format item untuk Tripay
            $orderItems = collect($items)->map(fn($i) => [
                'sku' => 'PROD-' . ($i['product_id'] ?? rand(1000, 9999)),
                'name' => $i['judul'] ?? 'Produk',
                'price' => (int)$i['harga'],
                'quantity' => (int)$i['qty'],
                'subtotal' => (int)$i['harga'] * (int)$i['qty'],
            ])->values()->toArray();

            if ($ongkir > 0) {
                $orderItems[] = [
                    'sku' => 'ONGKIR',
                    'name' => 'Biaya Pengiriman',
                    'price' => $ongkir,
                    'quantity' => 1,
                    'subtotal' => $ongkir,
                ];
            }

            // Payload sesuai dokumentasi Tripay
            $payload = [
                'method'         => $channel,
                'merchant_ref'   => $merchantRef,
                'amount'         => $total,
                'customer_name'  => $userData['nama_lengkap'] ?? $user->name,
                'customer_email' => $userData['email'] ?? $user->email,
                'customer_phone' => $userData['no_hp'] ?? '-',
                'order_items'    => $orderItems,
                'callback_url'   => route('payment.callback'),
                'return_url'     => route('payment.redirect_buku', ['id' => encrypt($merchantRef)]),
                'expired_time'   => now()->addDay()->timestamp,
                'signature'      => $signature,
            ];

            // Kirim request ke Tripay
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post($tripayUrl, $payload);

            if (!$response->successful()) {
                Log::error('Tripay error', ['body' => $response->body()]);
                return back()->with('error', 'Gagal membuat transaksi di Tripay.');
            }

            $result = $response->json();
            if (empty($result['success']) || !$result['success']) {
                return back()->with('error', $result['message'] ?? 'Gagal membuat invoice.');
            }

            $dataTrx = $result['data'];


            // Simpan data ke DB dalam 1 transaksi
            DB::transaction(function () use ($dataTrx, $user, $merchantRef, $total, $items, $data) {
                // Insert transaksi utama
                $transaksiId = DB::table('transactions')->insertGetId([
                    'external_id'       => $merchantRef,
                    'invoice_id'        => $dataTrx['reference'] ?? $merchantRef,
                    'user_id'           => $user->id,
                    'product_id'        => null, // karna multi item, detail di table transaction_items
                    'amount'            => $total,
                    'status'            => $dataTrx['status'] ?? 'UNPAID',
                    'payment_method'    => $dataTrx['payment_method'] ?? '',
                    'payment_channel'   => $dataTrx['payment_name'] ?? '',
                    'paid_at'           => isset($dataTrx['paid_at']) ? date('Y-m-d H:i:s', $dataTrx['paid_at']) : null,
                    'expired_at'        => isset($dataTrx['expired_time']) ? date('Y-m-d H:i:s', $dataTrx['expired_time']) : null,
                    'tripay_data'       => json_encode($dataTrx),
                    'referral_code'     => $data['referral_code'] ?? null,
                    'nama_penerima'     => $data['user']['nama_lengkap'] ?? '-',
                    'telepon_penerima'  => $data['user']['no_hp'] ?? '-',
                    'alamat_lengkap'    => $data['user']['alamat'] ?? '-',
                    'provinsi'          => $data['user']['provinsi_nama'] ?? '-',
                    'kota'              => $data['user']['kota_nama'] ?? '-',
                    'kecamatan'         => $data['user']['kecamatan_nama'] ?? '-',
                    'kode_pos'          => $data['user']['kode_pos'] ?? '-',
                    'kurir'             => $data['user']['kurir'] ?? '-',
                    'layanan_kurir'     => $data['user']['layanan_ongkir'] ?? '-',
                    'ongkir'            => $data['ongkir'] ?? 0,
                    'estimasi_pengiriman' => $data['estimasi_pengiriman'] ?? null,
                    'status_pengiriman' => 'Menunggu Pembayaran',
                    'tipe_produk' => 'buku',
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);





                foreach ($items as $i) {

                    DB::table('transaksi_items')->insert([
                        'transaksi_id'   => $transaksiId,
                        'product_id'     => $i['product_id'],
                        'nama_produk'    => $i['judul'],
                        'harga_satuan'   => (int)$i['harga'],
                        'jumlah'         => (int)$i['qty'],
                        'subtotal'       => (int)$i['harga'] * (int)$i['qty'],
                        'berat'          => $i['berat'] ?? 0,
                        'catatan'        => $i['catatan'] ?? null,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }

                DB::table('carts')->where('user_id', $user->id)->delete();
            });

            // Redirect ke halaman pembayaran Tripay
            return redirect($dataTrx['checkout_url']);
        } catch (\Exception $e) {
            Log::error('CreatePayment error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat membuat transaksi: ' . $e->getMessage());
        }
    }




    public function redirect($id)
    {
        $merchantRef = decrypt($id);
        $trx = DB::table('transactions')->where('external_id', $merchantRef)->first();

        if (!$trx) {
            return redirect('/')->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('produk_buku.payment_success', compact('trx'));
    }


    public function checkoutBuku()
    {
        // 🔹 Ambil asal pengiriman (city_id) dari profile_perusahaan
        $asal = DB::table('profile_perusahaan')->first();

        // 🔹 Ambil daftar provinsi dari RajaOngkir
        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.key')
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        $provinsi = $response->successful() ? ($response->json()['data'] ?? []) : [];

        // 🔹 Ambil produk dari cart yang dicentang
        $checkoutItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select(
                'carts.id as cart_id',
                'carts.qty',
                'products.id as product_id',
                'products.judul',
                'products.harga',
                'products.thumbnail',
                'products.berat'
            )
            ->where('carts.user_id', Auth::id())
            ->where('carts.checked', 1)
            ->get();

        // Jika tidak ada item dipilih, kembali ke halaman utama
        if ($checkoutItems->isEmpty()) {
            return redirect('/')->with('warning', 'Pilih produk terlebih dahulu sebelum checkout.');
        }

        return view('produk.checkout_buku', compact('provinsi', 'asal', 'checkoutItems'));
    }


    public function getKota($provinsi_id)
    {
        try {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key'),
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinsi_id}");

            if ($response->successful()) {
                $json = $response->json();

                // ✅ Ambil dari key "data"
                if (isset($json['data']) && is_array($json['data'])) {
                    return response()->json($json['data']);
                } else {
                    return response()->json([
                        'error' => 'Format respons tidak sesuai',
                        'response' => $json,
                    ], 500);
                }
            }

            return response()->json([
                'error' => 'Gagal mengambil data kota',
                'status' => $response->status(),
                'body' => $response->body(),
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getKecamatan($city_id)
    {
        try {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key')
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$city_id}");

            if ($response->successful()) {
                $json = $response->json();

                if (isset($json['data']) && is_array($json['data'])) {
                    return response()->json($json['data']);
                } else {
                    return response()->json([
                        'error' => 'Format respons tidak sesuai',
                        'response' => $json,
                    ], 500);
                }
            } else {
                return response()->json([
                    'error' => 'Gagal mengambil data kecamatan',
                    'status' => $response->status(),
                    'body' => $response->body(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getOngkir(Request $request)
    {

        try {
            // Ambil origin dari profile_perusahaan (ID district/kecamatan asal pengiriman)
            $asal = DB::table('profile_perusahaan')->value('origin_subdistrict_id');

            // Ambil data dari request
            $destination = $request->input('kecamatan'); // ID district tujuan
            $kurir = $request->input('kurir'); // Contoh: jne / tiki / pos
            $weight = 1000; // gram (1kg)
            $price_mode = 'lowest'; // sesuai dokumentasi

            // Pastikan semua parameter wajib ada
            if (!$asal || !$destination || !$kurir) {
                return response()->json([
                    'error' => 'Data tidak lengkap. Pastikan origin, destination, dan kurir sudah dipilih.'
                ], 422);
            }

            // Panggil API RajaOngkir (POST dengan form-urlencoded)
            $response = Http::asForm()
                ->withHeaders([
                    'key' => config('services.rajaongkir.key'),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])
                ->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', [
                    'origin' => $asal,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $kurir, // bisa lebih dari 1 kurir, misalnya: jne:tiki:pos
                    'price' => $price_mode,
                ]);

            // Tangani jika gagal
            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Gagal menghitung ongkir',
                    'status' => $response->status(),
                    'body' => $response->body(),
                ], $response->status());
            }

            // Parsing hasil JSON
            $data = $response->json();


            if (!isset($data['data']) || !is_array($data['data'])) {
                return response()->json([
                    'error' => 'Format respons tidak sesuai',
                    'response' => $data,
                ], 500);
            }

            // Kirim hasil balik ke frontend
            return response()->json([
                'success' => true,
                'results' => $data['data']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menghitung ongkir',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function pesanan_saya()
    {
        $orders = DB::table('transactions')
            ->where('user_id', Auth::id())
            ->where('tipe_produk', 'buku')
            ->where('status_pengiriman', '!=', 'Menunggu Pembayaran')
            ->orderByDesc('created_at')
            ->get();

        return view('produk_buku.pesanan_saya', compact('orders'));
    }

    // ✅ Konfirmasi penerimaan barang
    public function confirmReceipt($id)
    {
        $order = DB::table('transactions')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order->status_pengiriman !== 'Dikirim') {
            return redirect()->back()->with('warning', 'Pesanan belum dikirim.');
        }

        DB::table('transactions')
            ->where('id', $id)
            ->update([
                'status_pengiriman' => 'Selesai',
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Pesanan dikonfirmasi telah diterima.');
    }
}
