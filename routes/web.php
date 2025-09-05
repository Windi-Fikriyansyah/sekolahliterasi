<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasSayaController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/', [KursusController::class, 'kursus'])->name('home');
Route::get('/course', [KursusController::class, 'course'])->name('course');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:siswa,guru'])->group(function () {
    Route::get('/dashboard-user', [DashboardController::class, 'dashboardUser'])->name('dashboardUser');
});


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard-admin', [DashboardController::class, 'dashboardAdmin']);
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/dashboard-owner', [DashboardController::class, 'dashboardOwner'])->name('owner.dashboard');
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/load', [UserController::class, 'load'])->name('load');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/load', [AdminController::class, 'load'])->name('load');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('kursus')->name('kursus.')->group(function () {
        Route::get('/', [KursusController::class, 'index'])->name('index');
        Route::post('/load', [KursusController::class, 'load'])->name('load');
        Route::get('/create', [KursusController::class, 'create'])->name('create');
        Route::post('/', [KursusController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KursusController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KursusController::class, 'update'])->name('update');
        Route::delete('/{id}', [KursusController::class, 'destroy'])->name('destroy');
    });



    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::post('/load', [KategoriController::class, 'load'])->name('load');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('module')->name('module.')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('index');
        Route::post('/load', [ModuleController::class, 'load'])->name('load');
        Route::get('/create', [ModuleController::class, 'create'])->name('create');
        Route::post('/', [ModuleController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ModuleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ModuleController::class, 'update'])->name('update');
        Route::delete('/{id}', [ModuleController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('latihan')->name('latihan.')->group(function () {
        Route::get('/', [LatihanController::class, 'index'])->name('index');
        Route::post('/load', [LatihanController::class, 'load'])->name('load');
        Route::post('/{id}/load-quiz', [LatihanController::class, 'load_quiz'])->name('load_quiz');
        Route::get('/{id}/create-soal', [LatihanController::class, 'createSoal'])->name('createSoal');
        Route::post('/', [LatihanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [LatihanController::class, 'edit'])->name('edit');
        Route::get('/{id}/quiz', [LatihanController::class, 'quiz'])->name('quiz');
        Route::put('/{id}', [LatihanController::class, 'update'])->name('update');
        Route::delete('/{id}', [LatihanController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tryout')->name('tryout.')->group(function () {
        Route::get('/', [TryoutController::class, 'index'])->name('index');
        Route::post('/load', [TryoutController::class, 'load'])->name('load');
        Route::post('/{id}/load-quiz', [TryoutController::class, 'load_quiz'])->name('load_quiz');
        Route::get('/{id}/create-soal', [TryoutController::class, 'createSoal'])->name('createSoal');
        Route::post('/', [TryoutController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TryoutController::class, 'edit'])->name('edit');
        Route::get('/{id}/quiz', [TryoutController::class, 'quiz'])->name('quiz');
        Route::put('/{id}', [TryoutController::class, 'update'])->name('update');
        Route::delete('/{id}', [TryoutController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('materi')->name('materi.')->group(function () {
        Route::get('/', [MateriController::class, 'index'])->name('index');
        Route::post('/load', [MateriController::class, 'load'])->name('load');
        Route::get('/create', [MateriController::class, 'create'])->name('create');
        Route::post('/', [MateriController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MateriController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MateriController::class, 'update'])->name('update');
        Route::delete('/{id}', [MateriController::class, 'destroy'])->name('destroy');
        Route::post('/upload-video-chunk', [MateriController::class, 'uploadVideoChunk'])->name('upload-video-chunk');
        Route::delete('/delete-video-chunk', [MateriController::class, 'deleteVideoChunk'])->name('delete-video-chunk');
        Route::post('/materi/upload-pdf-chunk', [MateriController::class, 'uploadPdfChunk'])->name('upload-pdf-chunk');
        Route::delete('/materi/delete-pdf-chunk', [MateriController::class, 'deletePdfChunk'])->name('delete-pdf-chunk');
    });
});


Route::group(['middleware' => 'auth'], function () {
    Route::post('/draft/save', [LatihanController::class, 'saveDraft'])->name('draft.save');
    Route::post('/draft/load', [LatihanController::class, 'loadDraft'])->name('draft.load');
    Route::delete('/draft/delete', [LatihanController::class, 'deleteDraft'])->name('draft.delete');
    Route::get('/draft/check', [LatihanController::class, 'checkDraft'])->name('draft.check');

    Route::prefix('course')->name('course.')->group(function () {
        Route::get('/{slug}', [KursusController::class, 'detail'])->name('detail');
        Route::get('/checkout/{id}', [KursusController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/{id}/pay', [KursusController::class, 'pay'])->name('pay');
        Route::get('/show/{encryptedCourseId}', [KursusController::class, 'show'])->name('show');
    });

    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [KelasSayaController::class, 'index'])->name('index');
        Route::get('/{slug}', [KelasSayaController::class, 'akses'])->name('akses');
    });

    // routes/web.php
    Route::get('/payment/{encryptedCourseId}', [PaymentController::class, 'createPayment'])->name('payment.index');

    Route::get('/payment/success/{course}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed/{course}', [PaymentController::class, 'failed'])->name('payment.failed');


    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('index');
        Route::get('/checkout/{id}', [HistoryController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/{id}/pay', [HistoryController::class, 'pay'])->name('pay');
        Route::get('/show/{encryptedCourseId}', [HistoryController::class, 'show'])->name('show');
    });
});


Route::group(['middleware' => 'auth'], function () {
    Route::post('/draftryout/save', [TryoutController::class, 'saveDraft'])->name('draftryout.save');
    Route::post('/draftryout/load', [TryoutController::class, 'loadDraft'])->name('draftryout.load');
    Route::delete('/draftryout/delete', [TryoutController::class, 'deleteDraft'])->name('draftryout.delete');
    Route::get('/draftryout/check', [TryoutController::class, 'checkDraft'])->name('draftryout.check');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');


require __DIR__ . '/auth.php';
