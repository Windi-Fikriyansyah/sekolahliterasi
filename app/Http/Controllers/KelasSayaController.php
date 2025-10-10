<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KelasSayaController extends Controller
{
    public function index()
    {
        $produk = DB::table('enrollments')
            ->join('products', 'enrollments.product_id', '=', 'products.id')
            ->select('products.id', 'products.judul', 'products.deskripsi', 'products.tipe_produk', 'products.thumbnail', 'products.harga', 'products.manfaat', 'enrollments.user_id', 'enrollments.payment_status')
            ->where('enrollments.user_id', Auth::id())
            ->where('enrollments.payment_status', 'PAID')
            ->get();


        $ebooks = $produk->where('tipe_produk', 'ebook');
        $kelas = $produk->where('tipe_produk', 'kelas_video');
        $programs = $produk->where('tipe_produk', 'program');

        return view('kelas_saya.index', compact('produk', 'ebooks', 'kelas', 'programs'));
    }

    public function show($id)
    {
        // Verifikasi akses user
        $enrollment = DB::table('enrollments')
            ->where('user_id', Auth::id())
            ->where('product_id', $id)
            ->where('payment_status', 'PAID')
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        // Ambil data produk
        $produk = DB::table('products')
            ->where('id', $id)
            ->first();

        if (!$produk) {
            abort(404, 'Produk tidak ditemukan.');
        }

        // Ambil materi berdasarkan product_id
        $materi = DB::table('materi')
            ->where('product_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kelas_saya.materi', compact('produk', 'materi'));
    }

    public function streamVideo($id)
    {
        // Verifikasi akses
        $materi = DB::table('materi')
            ->join('products', 'materi.product_id', '=', 'products.id')
            ->join('enrollments', function ($join) {
                $join->on('enrollments.product_id', '=', 'products.id')
                    ->where('enrollments.user_id', '=', Auth::id())
                    ->where('enrollments.payment_status', '=', 'PAID');
            })
            ->where('materi.id', $id)
            ->where('materi.jenis_materi', 'video')
            ->select('materi.*')
            ->first();

        if (!$materi) {
            abort(403, 'Akses ditolak.');
        }

        $path = storage_path('app/public/' . $materi->file_path);


        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $stream = new \App\Services\VideoStreamService($path);
        return response()->stream(function () use ($stream) {
            $stream->start();
        }, 200, [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline',
        ]);
    }
}
