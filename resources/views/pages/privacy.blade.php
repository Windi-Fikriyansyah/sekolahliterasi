@extends('layouts.app')

@section('title', 'Kebijakan Privasi')

@section('content')
    <section class="bg-gray-50">
        <div class="container mx-auto px-4 py-16 max-w-5xl">
            <div class="bg-white shadow-sm rounded-2xl p-8 md:p-12">

                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                    Kebijakan Privasi
                </h1>

                <p class="text-gray-600 leading-relaxed mb-8">
                    Terakhir diperbarui: <strong>{{ date('d F Y') }}</strong>
                </p>

                <div class="space-y-10 text-gray-700 leading-relaxed">

                    {{-- Pendahuluan --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            1. Pendahuluan
                        </h2>
                        <p>
                            Kami menghargai dan melindungi privasi setiap pengguna.
                            Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan,
                            menggunakan, menyimpan, dan melindungi informasi pribadi Anda
                            saat menggunakan layanan kami.
                        </p>
                    </section>

                    {{-- Informasi yang Dikumpulkan --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            2. Informasi yang Kami Kumpulkan
                        </h2>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Informasi identitas seperti nama, email, dan nomor kontak</li>
                            <li>Informasi akun seperti username dan kata sandi (terenkripsi)</li>
                            <li>Informasi transaksi dan aktivitas penggunaan layanan</li>
                            <li>Data teknis seperti alamat IP, perangkat, dan browser</li>
                        </ul>
                    </section>

                    {{-- Penggunaan Informasi --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            3. Penggunaan Informasi
                        </h2>
                        <p>
                            Informasi yang kami kumpulkan digunakan untuk:
                        </p>
                        <ul class="list-disc list-inside space-y-2 mt-2">
                            <li>Menyediakan dan mengelola layanan</li>
                            <li>Memverifikasi akun dan mencegah penyalahgunaan</li>
                            <li>Memproses transaksi dan pembayaran</li>
                            <li>Meningkatkan kualitas layanan dan pengalaman pengguna</li>
                            <li>Mengirimkan pemberitahuan atau informasi penting</li>
                        </ul>
                    </section>

                    {{-- Penyimpanan & Keamanan --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            4. Penyimpanan dan Keamanan Data
                        </h2>
                        <p>
                            Kami menyimpan data Anda secara aman dan menerapkan
                            langkah-langkah teknis serta organisatoris untuk melindungi
                            data dari akses tidak sah, kehilangan, atau kebocoran.
                        </p>
                    </section>

                    {{-- Pembagian Data --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            5. Pembagian Informasi kepada Pihak Ketiga
                        </h2>
                        <p>
                            Kami tidak menjual atau menyewakan data pribadi Anda.
                            Informasi hanya dapat dibagikan kepada pihak ketiga
                            terpercaya jika diperlukan untuk:
                        </p>
                        <ul class="list-disc list-inside space-y-2 mt-2">
                            <li>Penyedia layanan pembayaran</li>
                            <li>Kepatuhan terhadap hukum dan peraturan</li>
                            <li>Keamanan dan pencegahan penipuan</li>
                        </ul>
                    </section>

                    {{-- Hak Pengguna --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            6. Hak Pengguna
                        </h2>
                        <p>
                            Anda berhak untuk:
                        </p>
                        <ul class="list-disc list-inside space-y-2 mt-2">
                            <li>Mengakses dan memperbarui data pribadi Anda</li>
                            <li>Meminta penghapusan akun dan data tertentu</li>
                            <li>Menarik persetujuan penggunaan data</li>
                        </ul>
                    </section>

                    {{-- Cookie --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            7. Cookie
                        </h2>
                        <p>
                            Kami dapat menggunakan cookie untuk meningkatkan pengalaman
                            pengguna, menyimpan preferensi, dan menganalisis penggunaan layanan.
                            Anda dapat mengatur browser untuk menolak cookie.
                        </p>
                    </section>

                    {{-- Perubahan Kebijakan --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            8. Perubahan Kebijakan Privasi
                        </h2>
                        <p>
                            Kebijakan Privasi ini dapat diperbarui sewaktu-waktu.
                            Perubahan akan diumumkan melalui halaman ini dan berlaku
                            sejak tanggal diperbarui.
                        </p>
                    </section>



                </div>

            </div>
        </div>
    </section>
@endsection
