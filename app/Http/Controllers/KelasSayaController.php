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

    public function akses($slug)
    {

        // Ekstrak ID dari slug (format: judul-course-id)
        $id = substr($slug, strrpos($slug, '-') + 1);

        // Validasi apakah user memiliki akses ke course ini
        $enrollment = DB::table('enrollments')
            ->where('user_id', Auth::id())
            ->where('course_id', $id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('kelas.index')->with('error', 'Anda tidak memiliki akses ke kelas ini.');
        }

        // Ambil data course
        $course = DB::table('courses')
            ->join('kategori', 'courses.id_kategori', '=', 'kategori.id')
            ->select('courses.*', 'kategori.nama_kategori')
            ->where('courses.id', $id)
            ->first();

        // Ambil modul materi untuk course ini
        $modules = DB::table('course_modules')
            ->where('course_id', $id)
            ->orderBy('order', 'asc')
            ->get();

        $latihan = DB::table('quiz as q')
            ->leftJoin('quiz_questions as qq', 'q.id', '=', 'qq.quiz_id')
            ->select('q.*', DB::raw('COUNT(qq.id) as jumlah_soal'))
            ->where('q.course_id', $id)
            ->where('q.quiz_type', 'latihan')
            ->groupBy('q.id')
            ->get();

        // Tryout
        $tryout = DB::table('quiz as q')
            ->leftJoin('quiz_questions as qq', 'q.id', '=', 'qq.quiz_id')
            ->select('q.*', DB::raw('COUNT(qq.id) as jumlah_soal'))
            ->where('q.course_id', $id)
            ->where('q.quiz_type', 'tryout')
            ->groupBy('q.id')
            ->get();

        // Kirim data ke view
        return view('kelas_saya.materi', compact('course', 'modules', 'latihan', 'tryout'));
    }

    public function mulai_belajar($moduleId)
    {
        // Validasi apakah user memiliki akses ke module ini
        $module = DB::table('course_modules')
            ->join('courses', 'course_modules.course_id', '=', 'courses.id')
            ->join('enrollments', function ($join) {
                $join->on('courses.id', '=', 'enrollments.course_id')
                    ->where('enrollments.user_id', Auth::id());
            })
            ->select('course_modules.*', 'courses.title as course_title')
            ->where('course_modules.id', $moduleId)
            ->first();

        if (!$module) {
            return redirect()->route('kelas.index')->with('error', 'Anda tidak memiliki akses ke materi ini.');
        }

        // Ambil semua content berdasarkan module_id
        $contents = DB::table('contents')
            ->where('module_id', $moduleId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Pisahkan content berdasarkan type
        $textContents = $contents->where('type', 'pdf');
        $videoContents = $contents->where('type', 'video');

        return view('kelas_saya.content', compact('module', 'contents', 'textContents', 'videoContents'));
    }

    public function pdfView($moduleId)
    {
        $module = DB::table('contents')->where('module_id', $moduleId)->first();

        if (!$module || !$module->file_pdf) {
            abort(404, 'Materi PDF tidak ditemukan.');
        }

        return view('kelas_saya.pdf_view', compact('module'));
    }
}
