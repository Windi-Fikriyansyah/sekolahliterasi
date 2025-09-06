<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    public function latihan($quizId)
    {
        // Validasi apakah user memiliki akses ke quiz ini
        $quiz = DB::table('quiz')
            ->join('courses', 'quiz.course_id', '=', 'courses.id')
            ->join('enrollments', function ($join) {
                $join->on('courses.id', '=', 'enrollments.course_id')
                    ->where('enrollments.user_id', Auth::id());
            })
            ->select('quiz.*', 'courses.title as course_title')
            ->where('quiz.id', $quizId)
            ->where('quiz.quiz_type', 'latihan')
            ->first();

        if (!$quiz) {
            return redirect()->route('kelas.index')
                ->with('error', 'Anda tidak memiliki akses ke latihan ini.');
        }

        // Ambil semua soal untuk quiz ini
        $questions = DB::table('quiz_questions as qq')
            ->select(
                'qq.id as question_id',
                'qq.question',
                'qq.option_a',
                'qq.option_b',
                'qq.option_c',
                'qq.option_d',
                'qq.option_e',
                'qq.correct_answer'
            )
            ->where('qq.quiz_id', $quizId)
            ->orderBy('qq.id')
            ->get();

        // Format options untuk setiap soal
        foreach ($questions as $question) {
            $question->formatted_options = [
                'A' => $question->option_a,
                'B' => $question->option_b,
                'C' => $question->option_c,
                'D' => $question->option_d,
                'E' => $question->option_e,
            ];
            $question->correct_answer = $question->correct_answer;
        }

        return view('kelas_saya.latihan', compact('quiz', 'questions'));
    }


    // Method untuk menampilkan tryout
    public function tryout($quizId)
    {
        // Validasi apakah user memiliki akses ke quiz ini
        $quiz = DB::table('quiz')
            ->join('courses', 'quiz.course_id', '=', 'courses.id')
            ->join('enrollments', function ($join) {
                $join->on('courses.id', '=', 'enrollments.course_id')
                    ->where('enrollments.user_id', Auth::id());
            })
            ->select('quiz.*', 'courses.title as course_title')
            ->where('quiz.id', $quizId)
            ->where('quiz.quiz_type', 'tryout')
            ->first();

        if (!$quiz) {
            return redirect()->route('kelas.index')->with('error', 'Anda tidak memiliki akses ke tryout ini.');
        }

        // Ambil semua soal untuk quiz ini
        $questions = DB::table('quiz_questions as qq')
            ->leftJoin('quiz_options as qo', 'qq.id', '=', 'qo.question_id')
            ->select(
                'qq.id as question_id',
                'qq.question',
                'qq.question_type',
                'qq.explanation',
                DB::raw('GROUP_CONCAT(qo.option_text ORDER BY qo.id SEPARATOR "|||") as options'),
                DB::raw('GROUP_CONCAT(qo.is_correct ORDER BY qo.id SEPARATOR "|||") as correct_answers')
            )
            ->where('qq.quiz_id', $quizId)
            ->groupBy('qq.id', 'qq.question', 'qq.question_type', 'qq.explanation')
            ->orderBy('qq.id')
            ->get();

        // Format options untuk setiap soal
        foreach ($questions as $question) {
            if ($question->options) {
                $question->formatted_options = explode('|||', $question->options);
                $question->correct_flags = explode('|||', $question->correct_answers);
            } else {
                $question->formatted_options = [];
                $question->correct_flags = [];
            }
        }

        return view('kelas_saya.tryout', compact('quiz', 'questions'));
    }

    public function submitLatihan(Request $request, $quizId)
    {
        $userId = Auth::id();
        $answers = $request->input('answers', []);

        // Ambil quiz
        $quiz = DB::table('quiz')->where('id', $quizId)->first();

        // Ambil semua soal
        $questions = DB::table('quiz_questions')
            ->where('quiz_id', $quizId)
            ->get();

        $totalQuestions = $questions->count();
        $correctAnswers = 0;
        $results = [];

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = $userAnswer === $question->correct_answer;

            if ($isCorrect) {
                $correctAnswers++;
            }

            $results[] = [
                'question'       => $question->question,
                'options'        => [
                    'A' => $question->option_a,
                    'B' => $question->option_b,
                    'C' => $question->option_c,
                    'D' => $question->option_d,
                    'E' => $question->option_e,
                ],
                'user_answer'    => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'explanation'    => $question->pembahasan ?? '-', // pastikan ada kolom explanation/pembahasan di DB
                'is_correct'     => $isCorrect,
            ];
        }

        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        return view('kelas_saya.hasil_latihan', [
            'quiz'           => $quiz,
            'score'          => $score,
            'totalQuestions' => $totalQuestions,
            'correctAnswers' => $correctAnswers,
            'answersDetail'  => $results
        ]);
    }


    // Method untuk menampilkan hasil latihan
    public function hasilLatihan($quizId)
    {
        $quiz = DB::table('quiz')->where('id', $quizId)->first();

        $score = session('score', 0);
        $correctAnswers = session('correct_answers', 0);
        $totalQuestions = session('total_questions', 0);

        return view('kelas_saya.hasil_latihan', compact('quiz', 'score', 'correctAnswers', 'totalQuestions'));
    }
}
