<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{

    public function index()
    {
        $programs = DB::table('products')
            ->where('tipe_produk', 'program')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('program', compact('programs'));
    }

    public function landing_page($product_id)
    {
        // Ambil data landing page berdasarkan product_id
        $landing = DB::table('lp_program')
            ->where('product_id', $product_id)
            ->where('is_active', 1)
            ->first();

        // Jika data landing tidak ditemukan
        if (!$landing) {
            abort(404, 'Halaman tidak ditemukan');
        }
        $sections = DB::table('landing_sections_program')
            ->where('landing_page_id', $landing->id)
            ->where('is_active', 1)
            ->orderBy('order', 'asc')
            ->get();

        // Decode kolom JSON agar bisa di-loop di Blade
        foreach ($sections as $section) {
            $section->content = json_decode($section->content, true);
            $section->settings = json_decode($section->settings, true);
        }

        // Kirim ke view
        return view('landing_page.index', compact('landing', 'sections'));
    }
}
