@extends('layouts.app')

@section('title', 'Ketentuan Layanan')

@section('content')
    <section class="bg-gray-50">
        <div class="container mx-auto px-4 py-16 max-w-5xl">
            <div class="bg-white shadow-sm rounded-2xl p-8 md:p-12">

                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                    Ketentuan Layanan
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
                            Ketentuan Layanan ini mengatur penggunaan platform kami.
                            Dengan mengakses atau menggunakan layanan ini, Anda dianggap
                            telah membaca, memahami, dan menyetujui seluruh ketentuan
                            yang tercantum di bawah ini.
                        </p>
                    </section>

                    {{-- Definisi --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            2. Definisi
                        </h2>
                        <ul class="list-disc list-inside space-y-2">
                            <li><strong>Platform</strong>: Sistem, aplikasi, atau website yang kami kelola.</li>
                            <li><strong>Pengguna</strong>: Setiap individu yang mengakses atau menggunakan layanan.</li>
                            <li><strong>Layanan</strong>: Fitur, konten, dan fasilitas yang disediakan melalui platform.
                            </li>
                        </ul>
                    </section>

                    {{-- Akun Pengguna --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            3. Akun Pengguna
                        </h2>
                        <p>
                            Untuk menggunakan fitur tertentu, pengguna diwajibkan
                            membuat akun dengan memberikan informasi yang benar dan akurat.
                            Pengguna bertanggung jawab penuh atas keamanan akun dan
                            aktivitas yang terjadi di dalamnya.
                        </p>
                    </section>

                    {{-- Hak dan Kewajiban --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            4. Hak dan Kewajiban Pengguna
                        </h2>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Menggunakan layanan sesuai dengan hukum yang berlaku</li>
                            <li>Tidak menyalahgunakan sistem atau melakukan tindakan ilegal</li>
                            <li>Tidak mengunggah konten yang melanggar hukum, SARA, atau hak pihak lain</li>
                            <li>Menjaga kerahasiaan data akun pribadi</li>
                        </ul>
                    </section>

                    {{-- Transaksi --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            5. Transaksi dan Pembayaran
                        </h2>
                        <p>
                            Setiap transaksi yang dilakukan melalui platform harus
                            mengikuti prosedur yang telah ditentukan. Pembayaran
                            diproses melalui penyedia layanan pembayaran pihak ketiga.
                            Kami tidak bertanggung jawab atas gangguan yang disebabkan
                            oleh pihak penyedia pembayaran.
                        </p>
                    </section>

                    {{-- Larangan --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            6. Larangan Penggunaan
                        </h2>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Mengakses sistem secara tidak sah</li>
                            <li>Menyebarkan malware, virus, atau program berbahaya</li>
                            <li>Melakukan manipulasi data atau transaksi</li>
                            <li>Mengganggu operasional layanan</li>
                        </ul>
                    </section>

                    {{-- Pembatasan Tanggung Jawab --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            7. Pembatasan Tanggung Jawab
                        </h2>
                        <p>
                            Layanan disediakan sebagaimana adanya.
                            Kami tidak menjamin layanan akan selalu bebas dari gangguan,
                            kesalahan, atau keterlambatan. Kami tidak bertanggung jawab
                            atas kerugian langsung maupun tidak langsung akibat penggunaan layanan.
                        </p>
                    </section>

                    {{-- Penghentian Layanan --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            8. Penghentian dan Penangguhan Akun
                        </h2>
                        <p>
                            Kami berhak menangguhkan atau menghentikan akun pengguna
                            apabila ditemukan pelanggaran terhadap ketentuan layanan ini,
                            tanpa pemberitahuan sebelumnya.
                        </p>
                    </section>

                    {{-- Perubahan --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            9. Perubahan Ketentuan
                        </h2>
                        <p>
                            Ketentuan Layanan ini dapat diubah sewaktu-waktu.
                            Pengguna disarankan untuk meninjau halaman ini secara berkala.
                            Perubahan berlaku sejak tanggal diperbarui.
                        </p>
                    </section>

                    {{-- Hukum --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            10. Hukum yang Berlaku
                        </h2>
                        <p>
                            Ketentuan Layanan ini diatur dan ditafsirkan berdasarkan
                            hukum yang berlaku di Republik Indonesia.
                        </p>
                    </section>

                    {{-- Kontak --}}
                    <section>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            11. Hubungi Kami
                        </h2>
                        <p>
                            Jika Anda memiliki pertanyaan terkait Ketentuan Layanan,
                            silakan hubungi kami melalui:
                        </p>
                        <p class="mt-2">
                            <strong>Email:</strong> support@domainanda.com <br>
                            <strong>Alamat:</strong> Indonesia
                        </p>
                    </section>

                </div>

            </div>
        </div>
    </section>
@endsection
