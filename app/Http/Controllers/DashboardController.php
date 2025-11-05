<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function tentang()
    {

        return view('tentang_kami');
    }
    public function dashboardOwner(Request $request)
    {
        // Hitung jumlah siswa
        $jumlahSiswa = DB::table('users')->where('role', 'siswa')->count();

        // Hitung jumlah guru
        $jumlahGuru = DB::table('users')->where('role', 'guru')->count();

        // Hitung jumlah transaksi dengan status paid
        $jumlahTransaksiPaid = DB::table('transactions')->where('status', 'PAID')->count();

        // Hitung total amount (misal fieldnya 'amount')
        $totalAmount = DB::table('transactions')->where('status', 'PAID')->sum('amount');

        return view('dashboardOwner', compact(
            'jumlahSiswa',
            'jumlahGuru',
            'jumlahTransaksiPaid',
            'totalAmount'
        ));
    }
    public function dashboardUser(Request $request)
    {
        $programs = DB::table('products')
            ->where('tipe_produk', 'program')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $landingPage = DB::table('landing_page_sections')->first();
        $kelasVideo = DB::table('products')
            ->where('tipe_produk', 'kelas_video')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $ebooks = DB::table('products')
            ->where('tipe_produk', 'ebook')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $bukus = DB::table('products')
            ->join('bukus_detail', 'bukus_detail.product_id', '=', 'products.id')
            ->where('products.tipe_produk', 'buku')
            ->where('products.status', 'aktif')
            ->where('bukus_detail.stok', '>', 0) // stok dari tabel bukus_detail
            ->orderBy('products.created_at', 'desc')
            ->select('products.*', 'bukus_detail.stok') // ambil juga stok-nya
            ->limit(4)
            ->get();
        $content = DB::table('landing_page_sections')->first();
        $testimonials = DB::table('landing_page_testimonials')
            ->where('landing_page_id', $content->id ?? 1)
            ->orderBy('order', 'asc')
            ->get();
        $faqs = DB::table('landing_page_faqs')
            ->where('landing_page_id', $content->id ?? 1)
            ->orderBy('order', 'asc')
            ->get();

        return view('dashboardUser', compact('programs', 'landingPage', 'kelasVideo', 'ebooks', 'bukus', 'content', 'testimonials', 'faqs'));
    }
}
