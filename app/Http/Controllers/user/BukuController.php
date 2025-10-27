<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{

    public function index()
    {
        $bukus = DB::table('products')
            ->join('bukus_detail', 'bukus_detail.product_id', '=', 'products.id')
            ->where('products.tipe_produk', 'buku')
            ->where('products.status', 'aktif')
            ->where('bukus_detail.stok', '>', 0) // stok dari tabel bukus_detail
            ->orderBy('products.created_at', 'desc')
            ->select('products.*', 'bukus_detail.stok') // ambil juga stok-nya
            ->limit(4)
            ->get();

        return view('buku', compact('bukus'));
    }
}
