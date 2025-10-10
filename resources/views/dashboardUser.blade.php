@extends('layouts.app')
@section('title', 'Course')
@section('content')
    <section class="relative">
        <div class="slider-container overflow-hidden">
            <div class="slider-wrapper flex transition-transform duration-500 ease-in-out">
                <div class="slider-slide min-w-full">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1171&q=80"
                        alt="E-Course 1" class="w-full h-64 md:h-96 object-cover">
                </div>
                <div class="slider-slide min-w-full">
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                        alt="E-Course 2" class="w-full h-64 md:h-96 object-cover">
                </div>
                <div class="slider-slide min-w-full">
                    <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80"
                        alt="E-Course 3" class="w-full h-64 md:h-96 object-cover">
                </div>
            </div>
        </div>

        <!-- Slider Controls -->
        <button
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 rounded-full p-2 slider-prev hover:bg-opacity-90 transition-all duration-300 hover:scale-110">
            <i class="fas fa-chevron-left text-secondary"></i>
        </button>
        <button
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 rounded-full p-2 slider-next hover:bg-opacity-90 transition-all duration-300 hover:scale-110">
            <i class="fas fa-chevron-right text-secondary"></i>
        </button>

        <!-- Slider Indicators -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <button
                class="w-3 h-3 bg-white rounded-full slider-indicator active transition-all duration-300 hover:scale-125"></button>
            <button
                class="w-3 h-3 bg-white rounded-full slider-indicator transition-all duration-300 hover:scale-125"></button>
            <button
                class="w-3 h-3 bg-white rounded-full slider-indicator transition-all duration-300 hover:scale-125"></button>
        </div>
    </section>

    <!-- E-Course Terbaru Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-secondary">Program Terbaru</h2>
                <a href="{{ route('program') }}" class="text-primary font-medium hover:underline">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($programs as $program)
                    <div
                        class="program-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $program->thumbnail) }}" alt="{{ $program->judul }}"
                                class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-110"
                                loading="lazy" decoding="async">
                            <div class="absolute top-4 right-4">
                                <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-secondary text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $program->tipe_produk }}</span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-secondary">
                                {{ $program->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {!! Str::limit(strip_tags($program->deskripsi), 100) !!}

                            </p>

                            <div class="flex justify-between items-center">
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('produk.show', $program->id) }}"
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-secondary">Kelas Video Terbaru</h2>
                <a href="{{ route('kelasvideo') }}" class="text-primary font-medium hover:underline">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($kelasVideo as $kelas)
                    <div
                        class="program-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $kelas->thumbnail) }}" alt="{{ $kelas->judul }}"
                                class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-110"
                                loading="lazy" decoding="async">
                            <div class="absolute top-4 right-4">
                                <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-secondary text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $kelas->tipe_produk }}</span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-secondary">
                                {{ $kelas->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {!! Str::limit(strip_tags($kelas->deskripsi), 100) !!}

                            </p>

                            <div class="flex justify-between items-center">
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($kelas->harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('produk.show', $kelas->id) }}"
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-secondary">Ebook Terbaru</h2>
                <a href="{{ route('ebook') }}" class="text-primary font-medium hover:underline">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($ebooks as $ebook)
                    <div
                        class="program-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $ebook->thumbnail) }}" alt="{{ $ebook->judul }}"
                                class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-110"
                                loading="lazy" decoding="async">
                            <div class="absolute top-4 right-4">
                                <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-purple-600 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $ebook->tipe_produk }}</span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-secondary">
                                {{ $ebook->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {!! Str::limit(strip_tags($ebook->deskripsi), 100) !!}
                            </p>

                            <div class="flex justify-between items-center">
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($ebook->harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('produk.show', Crypt::encrypt($ebook->id)) }}"
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>




    <!-- E-Book Best Seller Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-secondary">Buku Terbaru</h2>
                <a href="{{ route('buku') }}" class="text-primary font-medium hover:underline">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($bukus as $buku)
                    <div
                        class="program-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $buku->thumbnail) }}" alt="{{ $buku->judul }}"
                                class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-110"
                                loading="lazy" decoding="async">
                            <div class="absolute top-4 right-4">
                                <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-secondary text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $buku->tipe_produk }}</span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-secondary">
                                {{ $buku->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {!! Str::limit(strip_tags($buku->deskripsi), 100) !!}

                            </p>

                            <div class="flex justify-between items-center">
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($buku->harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('produk.show', $buku->id) }}"
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-secondary text-center mb-12 animate-fade-in-up">Apa Kata Mereka?
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div
                    class="testimonial-card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="User"
                            class="w-12 h-12 rounded-full object-cover transition-transform duration-300 hover:scale-110">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Sarah Wijaya</h4>
                            <p class="text-gray-600 text-sm">Web Developer</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"E-Course Web Development sangat membantu karir saya. Materinya
                        lengkap dan mudah dipahami."</p>
                    <div class="text-yellow-500">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div
                    class="testimonial-card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="User"
                            class="w-12 h-12 rounded-full object-cover transition-transform duration-300 hover:scale-110">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Budi Santoso</h4>
                            <p class="text-gray-600 text-sm">Data Analyst</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"E-Book tentang Data Science sangat informatif. Saya bisa langsung
                        menerapkan ilmunya di pekerjaan."</p>
                    <div class="text-yellow-500">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div
                    class="testimonial-card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User"
                            class="w-12 h-12 rounded-full object-cover transition-transform duration-300 hover:scale-110">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Dewi Lestari</h4>
                            <p class="text-gray-600 text-sm">UI/UX Designer</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"Platform ini sangat user-friendly. Saya bisa belajar kapan saja dan
                        di mana saja."</p>
                    <div class="text-yellow-500">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-3xl">
            <h2 class="text-2xl md:text-3xl font-bold text-secondary text-center mb-12 animate-fade-in-up">Pertanyaan yang
                Sering Diajukan
            </h2>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div
                    class="faq-item border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-question w-full text-left p-4 bg-gray-50 hover:bg-gray-100 flex justify-between items-center transition-all duration-300">
                        <span class="font-medium text-gray-800">Bagaimana cara mendaftar di platform ini?</span>
                        <i class="fas fa-chevron-down text-secondary transition-transform duration-300"></i>
                    </button>
                    <div class="faq-answer p-4 bg-white hidden transition-all duration-300">
                        <p class="text-gray-700">Anda bisa mendaftar dengan mengklik tombol "Daftar" di pojok kanan
                            atas, lalu mengisi formulir pendaftaran dengan data diri yang valid.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div
                    class="faq-item border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-question w-full text-left p-4 bg-gray-50 hover:bg-gray-100 flex justify-between items-center transition-all duration-300">
                        <span class="font-medium text-gray-800">Apakah tersedia metode pembayaran cicilan?</span>
                        <i class="fas fa-chevron-down text-secondary transition-transform duration-300"></i>
                    </button>
                    <div class="faq-answer p-4 bg-white hidden transition-all duration-300">
                        <p class="text-gray-700">Ya, kami menyediakan opsi cicilan untuk beberapa E-Course premium.
                            Anda bisa memilih metode pembayaran yang tersedia saat checkout.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div
                    class="faq-item border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-question w-full text-left p-4 bg-gray-50 hover:bg-gray-100 flex justify-between items-center transition-all duration-300">
                        <span class="font-medium text-gray-800">Berapa lama akses ke E-Course yang sudah dibeli?</span>
                        <i class="fas fa-chevron-down text-secondary transition-transform duration-300"></i>
                    </button>
                    <div class="faq-answer p-4 bg-white hidden transition-all duration-300">
                        <p class="text-gray-700">Akses ke E-Course yang sudah dibeli adalah seumur hidup. Anda bisa
                            mengulang materi kapan saja tanpa batas waktu.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div
                    class="faq-item border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-question w-full text-left p-4 bg-gray-50 hover:bg-gray-100 flex justify-between items-center transition-all duration-300">
                        <span class="font-medium text-gray-800">Apakah tersedia sertifikat setelah menyelesaikan
                            E-Course?</span>
                        <i class="fas fa-chevron-down text-secondary transition-transform duration-300"></i>
                    </button>
                    <div class="faq-answer p-4 bg-white hidden transition-all duration-300">
                        <p class="text-gray-700">Ya, setiap peserta yang menyelesaikan E-Course akan mendapatkan
                            sertifikat digital yang bisa diunduh dan dibagikan.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div
                    class="faq-item border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-question w-full text-left p-4 bg-gray-50 hover:bg-gray-100 flex justify-between items-center transition-all duration-300">
                        <span class="font-medium text-gray-800">Bagaimana jika saya mengalami kendala teknis?</span>
                        <i class="fas fa-chevron-down text-secondary transition-transform duration-300"></i>
                    </button>
                    <div class="faq-answer p-4 bg-white hidden transition-all duration-300">
                        <p class="text-gray-700">Tim support kami siap membantu 24/7 melalui live chat, email, atau
                            telepon. Jangan ragu untuk menghubungi kami jika mengalami kendala.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
