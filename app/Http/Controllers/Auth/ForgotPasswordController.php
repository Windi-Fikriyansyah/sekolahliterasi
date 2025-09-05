<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validasi dengan pesan custom dalam bahasa Indonesia
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email wajib diisi untuk melanjutkan proses reset password.',
            'email.email' => 'Format email tidak valid. Contoh: nama@domain.com'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Custom messages dalam bahasa Indonesia
        $customMessages = [
            'passwords.sent' => 'Link reset password telah berhasil dikirim ke email Anda. Silakan periksa kotak masuk dan ikuti petunjuk yang diberikan.',
            'passwords.user' => 'Maaf, kami tidak dapat menemukan akun dengan alamat email tersebut. Pastikan email yang dimasukkan sudah benar.',
            'passwords.throttled' => 'Terlalu banyak permintaan reset password. Silakan tunggu beberapa saat sebelum mencoba lagi.'
        ];

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with([
                'status' => $customMessages['passwords.sent'] ?? 'Link reset password telah dikirim!'
            ]);
        }

        // Handle specific error cases
        $errorMessage = $customMessages[$status] ?? 'Terjadi kesalahan saat mengirim email. Silakan coba lagi.';

        return back()->withErrors([
            'email' => $errorMessage
        ])->withInput();
    }
}
