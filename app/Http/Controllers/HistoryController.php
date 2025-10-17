<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $transactions = DB::table('transactions')
            ->leftJoin('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.user_id', Auth::id())
            ->select(
                'transactions.*',
                'products.judul'
            )
            ->orderByDesc('transactions.created_at')
            ->get();

        return view('history.index', compact('transactions'));
    }
}
