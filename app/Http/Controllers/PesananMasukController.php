<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class PesananMasukController extends Controller
{
    public function index()
    {
        return view('pesanan_masuk.index');
    }

    public function load(Request $request)
    {
        try {
            $pesanan = DB::table('transactions')
                ->where('tipe_produk', 'buku')
                ->where('status', 'paid')
                ->where('status_pengiriman', '!=', 'Menunggu Pembayaran')
                ->select([
                    'id',
                    'invoice_id',
                    'nama_penerima',
                    'telepon_penerima',
                    'alamat_lengkap',
                    'provinsi',
                    'kota',
                    'kecamatan',
                    'kurir',
                    'amount',
                    'layanan_kurir',
                    'ongkir',
                    'estimasi_pengiriman',
                    'status_pengiriman',
                    'created_at'
                ])
                ->orderByRaw("
                CASE
                    WHEN status_pengiriman = 'Diproses' THEN 1
                    WHEN status_pengiriman = 'Menunggu Pengiriman' THEN 2
                    WHEN status_pengiriman = 'Dikirim' THEN 3
                    WHEN status_pengiriman = 'Selesai' THEN 4
                    ELSE 5
                END ASC
            ")
                ->orderByDesc('created_at');

            return DataTables::of($pesanan)
                ->addIndexColumn()
                ->addColumn('detail_pengiriman', function ($row) {
                    return '
                    <button class="btn btn-sm btn-info btn-detail"
                        data-nama="' . e($row->nama_penerima) . '"
                        data-telepon="' . e($row->telepon_penerima) . '"
                        data-alamat="' . e($row->alamat_lengkap) . '"
                        data-provinsi="' . e($row->provinsi) . '"
                        data-kota="' . e($row->kota) . '"
                        data-kecamatan="' . e($row->kecamatan) . '"
                        data-kurir="' . e($row->kurir) . '"
                        data-layanan="' . e($row->layanan_kurir) . '"
                        data-ongkir="' . e($row->ongkir) . '"
                        data-amount="' . e($row->amount) . '">
                        <i class="bi bi-eye"></i> Detail
                    </button>
                ';
                })
                ->addColumn('status_pengiriman', function ($row) {
                    $badgeClass = match ($row->status_pengiriman) {
                        'Selesai' => 'bg-success',
                        'Diproses' => 'bg-warning',
                        'Menunggu Pengiriman' => 'bg-secondary',
                        'Dikirim' => 'bg-info',
                        default => 'bg-light text-dark'
                    };
                    return '<span class="badge ' . $badgeClass . '">' . e($row->status_pengiriman) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    if ($row->status_pengiriman === 'Diproses') {
                        $confirmUrl = route('pesanan_masuk.kirim', $row->id);
                        return '
                        <button class="btn btn-sm btn-primary kirim-btn"
                            data-url="' . $confirmUrl . '">
                            <i class="bi bi-truck"></i> Tandai Dikirim
                        </button>';
                    }
                    return '<span class="text-muted small">Tidak ada aksi</span>';
                })
                ->rawColumns(['detail_pengiriman', 'status_pengiriman', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error loading pesanan data: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function kirim($id)
    {
        try {
            $updated = DB::table('transactions')
                ->where('id', $id)
                ->update(['status_pengiriman' => 'Dikirim']);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan telah dikonfirmasi sebagai dikirim.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan.'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error updating pesanan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
