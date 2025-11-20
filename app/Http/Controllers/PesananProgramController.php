<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class PesananProgramController extends Controller
{
    public function index()
    {
        return view('pesanan_program.index');
    }

    public function load(Request $request)
    {
        try {
            $pesanan = DB::table('transactions as t')
                ->join('products as p', 'p.id', '=', 't.product_id')
                ->join('users as u', 'u.id', '=', 't.user_id')
                ->leftJoin('pendaftaran_program as pp', 'pp.user_id', '=', 't.user_id')
                ->where('p.payment_type', 'manual')
                ->select([
                    't.id',
                    't.invoice_id',
                    'u.name as user_name',
                    't.status',
                    't.created_at',
                    'pp.value'
                ])
                ->orderByDesc('t.created_at');

            return DataTables::of($pesanan)
                ->addIndexColumn()

                ->addColumn('status', function ($row) {

                    $status = strtoupper($row->status);

                    if ($status === 'PENDING') {
                        return "<span class='badge bg-warning text-dark'>PENDING</span>";
                    }

                    if ($status === 'PAID') {
                        return "<span class='badge bg-success'>PAID</span>";
                    }

                    // Default fallback
                    return "<span class='badge bg-secondary'>$status</span>";
                })


                ->addColumn('bukti', function ($row) {

                    if (!$row->value) {
                        return "<span class='text-muted'>Tidak ada</span>";
                    }

                    $json = json_decode($row->value, true);
                    $file = null;

                    // Auto detect key foto transfer
                    foreach ($json as $key => $val) {
                        if (
                            stripos($key, 'upload') !== false ||
                            stripos($key, 'bukti') !== false ||
                            stripos($key, 'transfer') !== false
                        ) {
                            $file = $val;
                            break;
                        }
                    }

                    if ($file) {

                        // Normalize path
                        if (strpos($file, 'storage') === false) {
                            $file = 'storage/' . ltrim($file, '/');
                        }

                        // Tombol dengan data-url (akan dibaca JS)
                        return '
            <button
                class="btn btn-sm btn-secondary lihat-bukti-btn"
                data-url="/' . $file . '">
                Lihat Bukti
            </button>
        ';
                    }

                    return "<span class='text-muted'>Tidak ada</span>";
                })


                ->addColumn('action', function ($row) {
                    if ($row->status === 'PENDING') {
                        $confirmUrl = route('pesanan_program.konfirmasi', $row->id);
                        return '
            <button class="btn btn-sm btn-primary konfirmasi-btn"
                data-url="' . $confirmUrl . '">
                <i class="bi bi-check2-circle"></i> Konfirmasi
            </button>';
                    }
                    return '<span class="text-muted small">Tidak ada aksi</span>';
                })


                ->rawColumns(['status', 'bukti', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error loading pesanan data: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }



    public function konfirmasi(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $transaksi = DB::table('transactions')->where('id', $id)->first();

            if (!$transaksi) {
                return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
            }

            // Tentukan status baru
            $newStatus = $request->action === 'approve' ? 'PAID' : 'REJECTED';

            DB::table('transactions')
                ->where('id', $id)
                ->update([
                    'status' => $newStatus,
                    'updated_at' => now()
                ]);

            DB::table('pendaftaran_program')
                ->where('user_id', $transaksi->user_id)
                ->where('id_product', $transaksi->product_id)
                ->update([
                    'status' => $newStatus,
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $newStatus === 'PAID'
                    ? 'Pembayaran berhasil dikonfirmasi.'
                    : 'Pembayaran ditolak.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function kirim($id)
    {
        DB::beginTransaction();

        try {

            // 1️⃣ Ambil transaksi berdasarkan ID
            $transaksi = DB::table('transactions')->where('id', $id)->first();

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan.'
                ], 404);
            }

            // 2️⃣ Update status transaksi
            DB::table('transactions')
                ->where('id', $id)
                ->update([
                    'status' => 'PAID',
                    'updated_at' => now()
                ]);

            // 3️⃣ Update status pendaftaran_program (berdasarkan user dan product)
            DB::table('pendaftaran_program')
                ->where('user_id', $transaksi->user_id)
                ->where('id_product', $transaksi->product_id)
                ->update([
                    'status' => 'PAID',
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran telah berhasil dikonfirmasi.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error konfirmasi pesanan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
