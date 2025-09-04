<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KelasSayaController extends Controller
{
    public function index()
    { // Ambil semua data course dari tabel 'courses'
        $courses = DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select('courses.id', 'courses.title', 'courses.description', 'courses.thumbnail', 'courses.price', 'courses.features', 'enrollments.user_id', 'enrollments.payment_status')
            ->where('enrollments.user_id', Auth::id())
            ->get();

        // Kirim data ke view (misalnya ke halaman landing page kamu)
        return view('kelas_saya.index', compact('courses'));
    }

    public function akses()
    { // Ambil semua data course dari tabel 'courses'
        $courses = DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select('courses.id', 'courses.title', 'courses.description', 'courses.thumbnail', 'courses.price', 'courses.features', 'enrollments.user_id', 'enrollments.payment_status')
            ->where('enrollments.user_id', Auth::id())
            ->get();

        return view('kelas_saya.index', compact('courses'));
    }
}
