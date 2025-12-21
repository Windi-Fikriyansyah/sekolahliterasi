<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BookmasterpieceController extends Controller
{

    public function index()
    {
        $book_masterpieces = DB::table('products')
            ->where('tipe_produk', 'book_masterpiece')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookmasterpiece', compact('book_masterpieces'));
    }
}
