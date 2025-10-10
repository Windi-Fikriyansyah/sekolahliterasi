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
            ->where('tipe_produk', 'buku')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('buku', compact('bukus'));
    }
}
