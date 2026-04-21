<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\BuatFormController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasSayaController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MateriProgramController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PesananMasukController;
use App\Http\Controllers\PesananProgramController;
use App\Http\Controllers\ProdukBukuController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\user\BookmasterpieceController;
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
Route::get('/Kumpulan-Kemitraan', [MitraController::class, 'halaman_mitra'])->name('kumpulan.kemitraan');
Route::get('/Kelas-Video', [KelasVideoController::class, 'index'])->name('kelasvideo');
Route::get('/Tentang-Kami', [DashboardController::class, 'tentang'])->name('tentang-kami');
Route::get('/Book-Masterpiece-AI', [BookmasterpieceController::class, 'index'])->name('book-masterpiece');


Route::get('/kebijakan-privasi', [PageController::class, 'privacy'])->name('privacy');
Route::get('/ketentuan-layanan', [PageController::class, 'terms'])->name('terms');
Route::get('/kontak-support', [PageController::class, 'support'])->name('support');



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
        Route::post('/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('toggle');
        Route::get('/get-subscription/{id}', [UserController::class, 'getSubscription'])
            ->name('get_subscription');
        Route::post('/update-password', [UserController::class, 'updatePassword'])
            ->name('update_password');
    });

    Route::prefix('bonus')->name('bonus.')->group(function () {
        Route::get('/', [BonusController::class, 'index'])->name('index');
        Route::post('/load', [BonusController::class, 'load'])->name('load');
        Route::get('/create', [BonusController::class, 'create'])->name('create');
        Route::post('/', [BonusController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BonusController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BonusController::class, 'update'])->name('update');
        Route::delete('/{id}', [BonusController::class, 'destroy'])->name('destroy');
        Route::get('/view/{slug}', [BonusController::class, 'view'])->name('view');
    });

    Route::prefix('landing')->name('landing.')->group(function () {
        Route::get('/', [LandingController::class, 'index'])->name('index');
        Route::post('/', [LandingController::class, 'store'])->name('store');
        Route::put('/{id}', [LandingController::class, 'update'])->name('update');
        Route::post('/delete-how-to-join-step', [LandingController::class, 'deleteHowToJoinStep'])->name('delete.how_to_join_step');
    });

    Route::prefix('pesanan_masuk')->name('pesanan_masuk.')->group(function () {
        Route::get('/', [PesananMasukController::class, 'index'])->name('index');
        Route::post('/load', [PesananMasukController::class, 'load'])->name('load');
        Route::post('/kirim/{id}', [PesananMasukController::class, 'kirim'])->name('kirim');
    });
    Route::prefix('pesanan_program')->name('pesanan_program.')->group(function () {
        Route::get('/', [PesananProgramController::class, 'index'])->name('index');
        Route::post('/load', [PesananProgramController::class, 'load'])->name('load');
        Route::post('/kirim/{id}', [PesananProgramController::class, 'kirim'])->name('kirim');
        Route::post('/konfirmasi/{id}', [PesananProgramController::class, 'konfirmasi'])
            ->name('konfirmasi');
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
        Route::post('/copy/{id}', [ProdukController::class, 'copy'])->name('copy');
        Route::get('/upload-file/{id}', [ProdukController::class, 'uploadfile'])->name('upload_file');
        Route::post('/store-file', [ProdukController::class, 'store_file'])->name('store_file');
        Route::post('/upload-pdf-chunk', [ProdukController::class, 'uploadPdfChunk'])->name('upload-pdf-chunk');
        Route::delete('/delete-pdf-chunk', [ProdukController::class, 'deletePdfChunk'])->name('delete-pdf-chunk');
        Route::post('/toggle-status/{id}', [ProdukController::class, 'toggleStatus'])->name('toggle_status');
        Route::post('/toggle-harga', [ProdukController::class, 'toggleHarga'])
            ->name('toggle_harga');
    });

    Route::prefix('produk_buku')->name('produk_buku.')->group(function () {
        Route::get('/', [ProdukBukuController::class, 'index'])->name('index');
        Route::post('/load', [ProdukBukuController::class, 'load'])->name('load');
        Route::get('/create', [ProdukBukuController::class, 'create'])->name('create');
        Route::post('/', [ProdukBukuController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProdukBukuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProdukBukuController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProdukBukuController::class, 'destroy'])->name('destroy');
        Route::post('/toggle-status/{id}', [ProdukBukuController::class, 'toggleStatus'])->name('toggle_status');
        Route::post('/toggle-harga', [ProdukBukuController::class, 'toggleHarga'])
            ->name('toggle_harga');
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

    Route::prefix('materi_program')->name('materi_program.')->group(function () {
        Route::get('/', [MateriProgramController::class, 'index'])->name('index');
        Route::post('/load', [MateriProgramController::class, 'load'])->name('load');
        Route::get('/create', [MateriProgramController::class, 'create'])->name('create');
        Route::post('/', [MateriProgramController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MateriProgramController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MateriProgramController::class, 'update'])->name('update');
        Route::delete('/{id}', [MateriProgramController::class, 'destroy'])->name('destroy');
        Route::post('/upload-video-chunk', [MateriProgramController::class, 'uploadVideoChunk'])->name('upload-video-chunk');
        Route::delete('/delete-video-chunk', [MateriProgramController::class, 'deleteVideoChunk'])->name('delete-video-chunk');
        Route::post('/materi/upload-pdf-chunk', [MateriProgramController::class, 'uploadPdfChunk'])->name('upload-pdf-chunk');
        Route::delete('/materi/delete-pdf-chunk', [MateriProgramController::class, 'deletePdfChunk'])->name('delete-pdf-chunk');
    });

    Route::prefix('lp_programs')->name('lp_programs.')->group(function () {
        Route::get('/', [ProgramsController::class, 'index'])->name('index');
        Route::get('/create/{id_product?}', [ProgramsController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [ProgramsController::class, 'edit'])->name('edit');
        Route::delete('/destroy/{id}', [ProgramsController::class, 'destroy'])->name('destroy');
        Route::post('/store', [ProgramsController::class, 'store'])->name('store');
        Route::get('/show/{id}', [ProgramsController::class, 'show'])->name('show');
        Route::post('/load', [ProgramsController::class, 'load'])->name('load');
        Route::get('/atur/{id}', [ProgramsController::class, 'atur'])->name('atur');
        Route::put('/update/{id}', [ProgramsController::class, 'update'])->name('update');
        Route::get('/pdf/{id}', [ProgramsController::class, 'pdf'])->name('pdf');

        Route::post('/store', [ProgramsController::class, 'store'])
            ->name('store');
        Route::post('/pdf/save', [ProgramsController::class, 'savePdf'])
            ->name('save_pdf');
        Route::post('/save-link', [ProgramsController::class, 'saveLink'])
            ->name('saveLink');
    });

    Route::prefix('lp_mitra')->name('lp_mitra.')->group(function () {
        Route::get('/', [MitraController::class, 'index'])->name('index');
        Route::post('/load', [MitraController::class, 'load'])->name('load');
        Route::post('/upload-pdf', [MitraController::class, 'uploadPdf'])->name('upload_pdf');
    });

    Route::prefix('buat_form')->name('buat_form.')->group(function () {
        Route::get('/', [BuatFormController::class, 'index'])->name('index');
        Route::post('/load', [BuatFormController::class, 'load'])->name('load');
        Route::get('/create', [BuatFormController::class, 'create'])->name('create');
        Route::post('/store', [BuatFormController::class, 'store'])->name('store');
        Route::put('/{id}', [BuatFormController::class, 'update'])->name('update');
        Route::get('/{id}/edit', [BuatFormController::class, 'edit'])->name('edit');
        Route::delete('/{id}', [BuatFormController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/fields', [BuatFormController::class, 'fields'])->name('fields');
    });

    Route::prefix('withdraw')->name('withdraw.')->group(function () {
        Route::get('/', [WithdrawController::class, 'index'])->name('index');
        Route::post('/load', [WithdrawController::class, 'load'])->name('load');
        Route::post('/{id}/approve', [WithdrawController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [WithdrawController::class, 'reject'])->name('reject');
    });
});




Route::get('/pendaftaran/sukses', function () {
    return view('landing_page.sukses');
})->name('pendaftaran.sukses');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/pembayaran-program', [ProgramController::class, 'pembayaran'])->name('pembayaran_program_sekolah.index');
    Route::get('/pendaftaran/{slug}', [ProgramController::class, 'daftar'])->name('landing_page.pendaftaran');
    Route::get('/pendaftaran-program/{slug}', [ProgramController::class, 'daftarProgram'])->name('landing_page.pendaftaran_program');
    Route::post('/pendaftaran', [ProgramController::class, 'store'])->name('pendaftaran.store');
    Route::post('/pendaftaran-program', [ProgramController::class, 'storesekolah'])->name('pendaftaranSekolah.store');


    Route::get('/api/provinsi', [ProgramController::class, 'getProvinsi']);
    Route::get('/api/kota/{kode}', [ProgramController::class, 'getKota']);

    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/checkout/{id}', [PaymentController::class, 'createPayment'])->name('checkout');
        Route::post('/checkout/{id}/pay', [ProdukController::class, 'pay'])->name('pay');
        Route::get('/detail/{encryptedCourseId}', [ProdukController::class, 'detail'])->name('detail');
    });

    Route::prefix('buku')->name('buku.')->group(function () {
        Route::get('/checkout', [CartController::class, 'checkoutBuku'])->name('checkout');
        Route::get('/checkout-buku/kota/{provinsi_id}', [CartController::class, 'getKota']);
        Route::get('/checkout-buku/kecamatan/{city_id}', [CartController::class, 'getKecamatan']);
        Route::post('/checkout-buku/ongkir', [CartController::class, 'getOngkir']);
        Route::post('/checkout-process', [CartController::class, 'processCheckout'])->name('process');
        Route::post('/create-payment', [CartController::class, 'createPayment'])->name('createPayment');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::put('/cart/{cart}/qty', [CartController::class, 'updateQty'])->name('cart.updateQty');
        Route::put('/cart/{id}/toggle', [CartController::class, 'toggleCheck'])->name('cart.toggleCheck');
        Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/cart-total', [CartController::class, 'total'])->name('cart.total');
    });

    Route::prefix('pesanan_saya')->name('pesanan_saya.')->group(function () {
        Route::get('/', [CartController::class, 'pesanan_saya'])->name('index');

        Route::post('/konfirmasi/{id}', [CartController::class, 'confirmReceipt'])->name('confirm');
    });


    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/certificate/download', [CertificateController::class, 'download'])
            ->name('certificate.download');


        Route::get('/certificate/preview', [CertificateController::class, 'preview'])
            ->name('certificate.preview');

        Route::get('/', [KelasSayaController::class, 'index'])->name('index');
        Route::get('/{slug}/{encryptedId}', [KelasSayaController::class, 'show'])->name('show');
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
    Route::get('/payment/redirectbuku/{id}', [CartController::class, 'redirect'])->name('payment.redirect_buku');



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

Route::get('/landing/{slug}', [ProgramController::class, 'landing_page'])->name('landing.page');
Route::get('/kemitraan/{slug}', [MitraController::class, 'landing_page'])->name('kemitraan');

Route::prefix('produk')->name('produk.')->group(function () {
    Route::get('/{id}', [ProdukController::class, 'show'])->name('show');
});

Route::get('buku/{slug}', [ProdukBukuController::class, 'detail'])
    ->name('buku.detail');


require __DIR__ . '/auth.php';
