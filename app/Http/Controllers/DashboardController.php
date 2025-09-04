<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function dashboardOwner(Request $request)
    {
        return view('dashboardOwner');
    }
    public function dashboardUser(Request $request)
    {
        $courses = DB::table('courses')
            ->join('kategori', 'courses.id_kategori', '=', 'kategori.id')
            ->select('courses.id', 'courses.title', 'kategori.id as kategori_id', 'courses.description', 'courses.thumbnail', 'courses.price', 'courses.features', 'kategori.nama_kategori')
            ->orderBy('courses.created_at', 'desc')
            ->get();
        $kategori = DB::table('kategori')->get();

        return view('dashboardUser', compact('courses', 'kategori'));
    }
}
