<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasSayaController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProdukBukuController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\user\BukuController;
use App\Http\Controllers\user\EbookController;
use App\Http\Controllers\user\KelasVideoController;
use App\Http\Controllers\user\ProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;



Route::get('/', [ProdukController::class, 'kursus'])->name('home');
Route::get('/program', [ProgramController::class, 'index'])->name('program');
Route::get('/E-book', [EbookController::class, 'index'])->name('ebook');
Route::get('/Buku', [BukuController::class, 'index'])->name('buku');
Route::get('/Kelas-Video', [KelasVideoController::class, 'index'])->name('kelasvideo');
Route::prefix('produk')->name('produk.')->group(function () {
    Route::get('/{id}', [ProdukController::class, 'show'])->name('show');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/home', [DashboardController::class, 'dashboardUser'])->name('dashboardUser');
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

    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::post('/load', [ProdukController::class, 'load'])->name('load');
        Route::get('/create', [ProdukController::class, 'create'])->name('create');
        Route::post('/', [ProdukController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProdukController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('produk_buku')->name('produk_buku.')->group(function () {
        Route::get('/', [ProdukBukuController::class, 'index'])->name('index');
        Route::post('/load', [ProdukBukuController::class, 'load'])->name('load');
        Route::get('/create', [ProdukBukuController::class, 'create'])->name('create');
        Route::post('/', [ProdukBukuController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProdukBukuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProdukBukuController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProdukBukuController::class, 'destroy'])->name('destroy');
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

    Route::prefix('kategori_buku')->name('kategori_buku.')->group(function () {
        Route::get('/', [KategoriBukuController::class, 'index'])->name('index');
        Route::post('/load', [KategoriBukuController::class, 'load'])->name('load');
        Route::get('/create', [KategoriBukuController::class, 'create'])->name('create');
        Route::post('/', [KategoriBukuController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KategoriBukuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KategoriBukuController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriBukuController::class, 'destroy'])->name('destroy');
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

    Route::prefix('withdraw')->name('withdraw.')->group(function () {
        Route::get('/', [WithdrawController::class, 'index'])->name('index');
        Route::post('/load', [WithdrawController::class, 'load'])->name('load');
        Route::post('/{id}/approve', [WithdrawController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [WithdrawController::class, 'reject'])->name('reject');
    });
});




Route::group(['middleware' => 'auth'], function () {


    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/checkout/{id}', [PaymentController::class, 'createPayment'])->name('checkout');
        Route::post('/checkout/{id}/pay', [ProdukController::class, 'pay'])->name('pay');
        Route::get('/detail/{encryptedCourseId}', [ProdukController::class, 'detail'])->name('detail');
    });


    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [KelasSayaController::class, 'index'])->name('index');
        Route::get('/{id}', [KelasSayaController::class, 'show'])->name('show');
        Route::get('/stream-video/{id}', [KelasSayaController::class, 'streamVideo'])->name('stream-video');
    });

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('updateProfile');
        Route::put('/update-password', [AccountController::class, 'updatePassword'])->name('updatePassword');
        Route::get('/bank-accounts', [AccountController::class, 'bank'])->name('bank');
        Route::post('/bank/save', [AccountController::class, 'saveBank'])->name('bank.save');
        Route::post('/bank/delete', [AccountController::class, 'deleteBank'])->name('bank.delete');
        Route::get('/bank/json', [AccountController::class, 'bankJson'])->name('bank.json');
        Route::get('/withdrawal', [AccountController::class, 'withdrawal'])->name('withdrawal');
        Route::post('/withdrawal', [AccountController::class, 'withdrawalProcess'])->name('withdrawalProcess');
        Route::get('/mutasi', [AccountController::class, 'mutasi'])->name('mutasi');
        Route::post('/mutasi/json', [AccountController::class, 'load'])->name('load');
    });

    Route::get('/payment/{id}', [PaymentController::class, 'createPayment'])->name('payment.index');


    Route::get('/payment/success/{id}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed/{id}', [PaymentController::class, 'failed'])->name('payment.failed');
    Route::get('/payment/redirect/{id}', [PaymentController::class, 'redirectAfterPayment'])->name('payment.redirect');
    Route::post('/payment/process/{id}', [PaymentController::class, 'processPayment'])->name('payment.process');


    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('index');
        Route::get('/checkout/{id}', [HistoryController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/{id}/pay', [HistoryController::class, 'pay'])->name('pay');
        Route::get('/show/{encryptedCourseId}', [HistoryController::class, 'show'])->name('show');
    });
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');


require __DIR__ . '/auth.php';
