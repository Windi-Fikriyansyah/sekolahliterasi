<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
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
            ->where('tipe_produk', 'buku')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('dashboardUser', compact('programs', 'kelasVideo', 'ebooks', 'bukus'));
    }
}
