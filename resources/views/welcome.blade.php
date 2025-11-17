@extends('layouts.app')
@section('title', 'Course')
@section('content')
    <section class="relative w-full min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 overflow-hidden">

        <!-- Efek warna putih di pojok -->
        <div class="absolute top-10 left-10 w-40 h-40 bg-white/40 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 right-10 w-52 h-52 bg-white/40 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-1/3 w-32 h-32 bg-white/40 rounded-full blur-2xl"></div>

        <div class="container mx-auto px-6 lg:px-12 py-12 lg:py-20 relative z-10">


            <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-8 items-center">

                <!-- Hero Text Content -->
                <div class="relative animate-fade-in text-left space-y-8 order-2 lg:order-1">
                    <!-- Badge/Tag -->
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 border border-white/30 backdrop-blur-sm">
                        <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                        <span class="text-white text-sm font-medium">Platform Literasi #1 di Indonesia</span>
                    </div>

                    <!-- Main Title -->
                    <div class="space-y-4">
                        <h1
                            class="text-4xl sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight tracking-tight">
                            <span class="block animate-fade-in-up">
                                {{ $landingPage->hero_title ?? 'Belajar Tanpa Batas' }}
                            </span>
                            <span class="block text-[#fde047] animate-fade-in-up delay-200 mt-2">
                                {{ $landingPage->hero_subtitle ?? 'Raih Masa Depan' }}
                            </span>
                        </h1>
                    </div>

                    <!-- Description -->
                    <p class="text-lg sm:text-xl text-white/90 max-w-2xl leading-relaxed animate-fade-in-up delay-300">
                        {{ $landingPage->hero_description ?? 'Nikmati Kemudahan lolos TES KEMAMPUAN AKADEMIK (TKA) melalui Kelas Premium Prediksi TKA 2025 dengan metode pembelajaran inovatif dan mentor berpengalaman.' }}
                    </p>



                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up delay-500">
                        <a href="#"
                            class="inline-block bg-white text-primary px-8 py-4 rounded-full font-semibold text-lg shadow-lg hover:bg-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            {{ $content->hero_btn_primary ?? '' }}
                        </a>
                    </div>
                </div>

                <div class="relative animate-fade-in-up delay-300 order-1 lg:order-2 mb-8 lg:mb-0">
                    <div class="relative max-w-lg mx-auto w-full">
                        <!-- Main Image Container -->
                        <div
                            class="relative rounded-3xl overflow-hidden shadow-2xl backdrop-blur-sm bg-white/5 border border-white/20">

                            <!-- Image Slider -->
                            <div class="image-slider relative">
                                <div class="slide active relative">
                                    <img src="{{ $landingPage->hero_image_1
                                        ? asset('storage/' . $landingPage->hero_image_1)
                                        : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80' }}"
                                        alt="Students learning"
                                        class="w-full h-auto object-contain transition-all duration-700">

                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                                    </div>


                                </div>

                                <div class="slide relative">
                                    <img src="{{ $landingPage->hero_image_2 ? asset('storage/' . $landingPage->hero_image_2) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80' }}"
                                        alt="Online learning"
                                        class="w-full h-full object-cover transition-all duration-700">


                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                                    </div>

                                </div>

                                <div class="slide relative">
                                    <img src="{{ $landingPage->hero_image_3 ? asset('storage/' . $landingPage->hero_image_3) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80' }}"
                                        alt="Online learning"
                                        class="w-full h-full object-cover transition-all duration-700">


                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                                    </div>

                                </div>
                            </div>

                            <!-- Navigation Dots -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                                <button
                                    class="slider-dot active w-3 h-3 rounded-full bg-white transition-all duration-300 hover:scale-125"
                                    onclick="currentSlide(1)"></button>
                                <button
                                    class="slider-dot w-3 h-3 rounded-full bg-white/50 transition-all duration-300 hover:scale-125"
                                    onclick="currentSlide(2)"></button>
                                <button
                                    class="slider-dot w-3 h-3 rounded-full bg-white/50 transition-all duration-300 hover:scale-125"
                                    onclick="currentSlide(3)"></button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </section>


    <!-- E-Course Terbaru Section -->
    @if ($programs->count())
        <section id="produk" class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-secondary">{{ $landingPage->judul_program }}</h2>
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
                                    <span
                                        class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    @if ($program->tipe_produk === 'program')
                                        <span class="bg-secondary text-white text-xs font-bold px-2 py-1 rounded">
                                            Program
                                        </span>
                                    @endif

                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-secondary">
                                    {{ $program->judul }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {!! Str::limit(strip_tags($program->deskripsi), 100) !!}

                                </p>

                                @php
                                    $slug =
                                        \Illuminate\Support\Str::slug($program->judul) .
                                        '--' .
                                        \Illuminate\Support\Facades\Crypt::encryptString($program->id);
                                @endphp

                                <div class="flex items-center justify-between mt-4">
                                    @if ($program->tampil_harga == 1)
                                        <div class="text-lg font-bold text-primary">
                                            Rp {{ number_format($program->harga, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="text-lg font-semibold text-gray-400 italic">

                                        </div>
                                    @endif
                                    <a href="{{ route('landing.page', ['slug' => $program->slug]) }}"
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
    @endif




    @if ($kelasVideo->count())
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-secondary">{{ $landingPage->judul_kelas }}</h2>
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
                                    <span
                                        class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    @if ($kelas->tipe_produk === 'kelas_video')
                                        <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                            Kelas Video
                                        </span>
                                    @endif
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
                                    @if ($kelas->tampil_harga == 1)
                                        <div class="text-lg font-bold text-primary">
                                            Rp {{ number_format($kelas->harga, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="text-lg font-semibold text-gray-400 italic">

                                        </div>
                                    @endif
                                    <a href="{{ route('produk.show', Crypt::encrypt($kelas->id)) }}"
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
    @endif


    @if ($ebooks->count())
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-secondary">{{ $landingPage->judul_ebook }}</h2>
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
                                    <span
                                        class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    @if ($ebook->tipe_produk === 'ebook')
                                        <span class="bg-purple-600 text-white text-xs font-bold px-2 py-1 rounded">
                                            E-Book
                                        </span>
                                    @endif

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
                                    @if ($ebook->tampil_harga == 1)
                                        <div class="text-lg font-bold text-primary">
                                            Rp {{ number_format($ebook->harga, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="text-lg font-semibold text-gray-400 italic">

                                        </div>
                                    @endif
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
    @endif




    @if ($bukus->count())
        <!-- E-Book Best Seller Section -->
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-secondary">{{ $landingPage->judul_buku }}</h2>
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
                                    <span
                                        class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    @if ($buku->tipe_produk === 'buku')
                                        <span class="bg-secondary text-white text-xs font-bold px-2 py-1 rounded">
                                            Buku
                                        </span>
                                    @endif

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
                                    @if ($buku->tampil_harga == 1)
                                        <div class="text-lg font-bold text-primary">
                                            Rp {{ number_format($buku->harga, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="text-lg font-semibold text-gray-400 italic">

                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('buku.detail', Str::slug($buku->judul) . '-' . $buku->id) }}"
                                            class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-secondary/90 transition-all duration-300 shadow-md">
                                            Detail
                                        </a>
                                        <button
                                            onclick="addToCart({{ $buku->id }}, '{{ addslashes($buku->judul) }}')"
                                            class="bg-primary text-white p-3 rounded-full hover:bg-secondary transition-all duration-300 shadow-md hover:scale-110"
                                            title="Tambah ke Keranjang">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($mitras->count())
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-secondary">{{ $landingPage->judul_mitra }}</h2>
                </div>

                <!-- Grid 2 kolom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($mitras as $mitra)
                        <div
                            class="program-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">

                            <!-- Gambar Mitra (tampil full tanpa terpotong) -->
                            <div class="w-full bg-gray-100 flex justify-center items-center">
                                <img src="{{ asset('storage/' . $mitra->thumbnail) }}" alt="{{ $mitra->judul }}"
                                    class="max-w-full h-auto transition-transform duration-700 group-hover:scale-105"
                                    loading="lazy" decoding="async">
                            </div>

                            <!-- Konten -->
                            <div class="p-6 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-secondary">
                                        {{ $mitra->judul }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {!! Str::limit(strip_tags($mitra->deskripsi), 120) !!}
                                    </p>
                                </div>

                                <div class="flex justify-end">
                                    <a href="{{ route('kemitraan', ['slug' => $mitra->slug]) }}" target="_blank"
                                        class="bg-secondary text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-secondary/90 transition-all duration-300 shadow-md">
                                        Detail
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif



    <section id="tentang-kami" class="py-16 bg-[#0977c2] text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-blue-900/10"></div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                <!-- Kolom 1: Gambar -->
                <div class="relative animate-fade-in-up order-1 md:order-1">
                    <div class="overflow-hidden rounded-2xl shadow-2xl ring-4 ring-white/10">
                        <img src="{{ asset('storage/' . ($content->about_image ?? 'image/about-us.jpg')) }}"
                            alt="Tentang Kami"
                            class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-white/10 w-48 h-48 rounded-full blur-3xl hidden md:block">
                    </div>
                </div>

                <!-- Kolom 2: Judul dan Deskripsi -->
                <div class="space-y-6 animate-fade-in-up order-2 md:order-2 md:pl-6" style="animation-delay: 0.2s;">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white drop-shadow-md mb-4">
                        {{ $content->about_title ?? 'Tentang Kami' }}
                    </h2>
                    <p class="text-white/90 leading-relaxed text-lg max-w-xl">
                        {{ $content->about_paragraph_1 ?? 'Kami berkomitmen menghadirkan pengalaman belajar yang menyenangkan dan inspiratif bagi semua orang.' }}
                    </p>

                    @if (!empty($content->about_btn))
                        <a href="#program"
                            class="inline-block mt-4 bg-white text-[#0977c2] font-semibold px-6 py-3 rounded-full shadow-md hover:bg-gray-100 hover:scale-105 transition-transform duration-300">
                            {{ $content->about_btn }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>




    <section id="why" class="py-20 bg-primary-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Heading -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-200 mb-4">
                    {{ $landingPage->features_title ?? 'Mengapa Memilih KelasSatu?' }}
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ $landingPage->features_subtitle ?? 'Kami menyediakan pengalaman belajar terbaik dengan fitur-fitur unggulan' }}
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($featurespage as $feature)
                    @if (is_object($feature) && isset($feature->title))
                        <div
                            class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 text-center hover:-translate-y-1">
                            <!-- Icon -->
                            <!-- Icon -->
                            <div
                                class="w-16 h-16 mx-auto mb-5 rounded-full flex items-center justify-center
           bg-gradient-to-br from-primary-100 to-primary-200 text-primary-600 shadow-lg
           group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v12m0-12c-1.2-.8-2.8-1.3-4.5-1.3S4.2 5.2 3 6v12c1.2-.8 2.8-1.3 4.5-1.3S10.8 17.2 12 18m0-12c1.2-.8 2.8-1.3 4.5-1.3S19.8 5.2 21 6v12c-1.2-.8-2.8-1.3-4.5-1.3S13.2 17.2 12 18" />
                                </svg>
                            </div>



                            <!-- Title -->
                            <h3
                                class="text-xl font-semibold text-primary-200 mb-3 group-hover:text-primary-100 transition-colors duration-300">
                                {{ $feature->title }}
                            </h3>

                            <!-- Description -->
                            <p class="text-gray-600 leading-relaxed">
                                {{ $feature->description }}
                            </p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 bg-gradient-to-r from-secondary via-blue-500 to-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 text-center text-white">

                <div class="group transform hover:scale-105 transition duration-300">
                    <div class="text-4xl font-extrabold mb-2 drop-shadow-md">
                        {{ $landingPage->stats_students_count ?? '50,000+' }}
                    </div>
                    <div class="text-blue-100 text-lg font-medium tracking-wide">
                        {{ $landingPage->stats_students_label ?? 'Siswa Aktif' }}
                    </div>
                    <div
                        class="w-12 h-1 bg-white/40 mx-auto mt-3 rounded-full group-hover:w-20 transition-all duration-300">
                    </div>
                </div>

                <div class="group transform hover:scale-105 transition duration-300">
                    <div class="text-4xl font-extrabold mb-2 drop-shadow-md">
                        {{ $landingPage->stats_courses_count ?? '200+' }}
                    </div>
                    <div class="text-blue-100 text-lg font-medium tracking-wide">
                        {{ $landingPage->stats_courses_label ?? 'Kursus Tersedia' }}
                    </div>
                    <div
                        class="w-12 h-1 bg-white/40 mx-auto mt-3 rounded-full group-hover:w-20 transition-all duration-300">
                    </div>
                </div>

                <div class="group transform hover:scale-105 transition duration-300">
                    <div class="text-4xl font-extrabold mb-2 drop-shadow-md">
                        {{ $landingPage->stats_satisfaction_count ?? '95%' }}
                    </div>
                    <div class="text-blue-100 text-lg font-medium tracking-wide">
                        {{ $landingPage->stats_satisfaction_label ?? 'Tingkat Kepuasan' }}
                    </div>
                    <div
                        class="w-12 h-1 bg-white/40 mx-auto mt-3 rounded-full group-hover:w-20 transition-all duration-300">
                    </div>
                </div>

                <div class="group transform hover:scale-105 transition duration-300">
                    <div class="text-4xl font-extrabold mb-2 drop-shadow-md">
                        {{ $landingPage->stats_support_count ?? '24/7' }}
                    </div>
                    <div class="text-blue-100 text-lg font-medium tracking-wide">
                        {{ $landingPage->stats_support_label ?? 'Dukungan' }}
                    </div>
                    <div
                        class="w-12 h-1 bg-white/40 mx-auto mt-3 rounded-full group-hover:w-20 transition-all duration-300">
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Tentang Kami Section -->

    <!-- Testimoni Section -->
    <section id="testimoni" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-secondary text-center mb-4 animate-fade-in-up">
                {{ $content->testimonial_title ?? 'Apa Kata Mereka' }}
            </h2>
            <p class="text-gray-600 text-center mb-12">
                {{ $content->testimonial_subtitle ?? '' }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($testimonials as $testimonial)
                    <div
                        class="testimonial-card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            {{-- Avatar default pakai https://ui-avatars.com --}}
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=0D8ABC&color=fff"
                                alt="{{ $testimonial->name }}"
                                class="w-12 h-12 rounded-full object-cover transition-transform duration-300 hover:scale-110">
                            <div class="ml-4">
                                <h4 class="font-bold text-gray-800">{{ $testimonial->name }}</h4>
                                <p class="text-gray-600 text-sm">{{ $testimonial->role }}</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-4">{{ $testimonial->content }}</p>
                        <div class="text-yellow-500">
                            {{-- Dummy 5 bintang --}}
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada testimoni.</p>
                @endforelse
            </div>
        </div>
    </section>


    <!-- FAQ Section -->
    <!-- FAQ Section -->
    <section id="faq" class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-3xl">
            <h2 class="text-2xl md:text-3xl font-bold text-secondary text-center mb-4 animate-fade-in-up">
                {{ $content->faq_title ?? 'Pertanyaan yang Sering Diajukan' }}
            </h2>
            <p class="text-gray-600 text-center mb-12">
                {{ $content->faq_subtitle ?? '' }}
            </p>

            <div class="space-y-4">
                @forelse ($faqs as $index => $faq)
                    <div
                        class="faq-item border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-primary/30">
                        <button
                            class="faq-question w-full text-left p-5 bg-white hover:bg-gray-50 flex justify-between items-center transition-all duration-300 group"
                            onclick="toggleFaq(this)">
                            <span
                                class="font-semibold text-gray-800 group-hover:text-primary transition-colors duration-300">
                                {{ $faq->question }}
                            </span>
                            <i
                                class="fas fa-chevron-down text-primary transition-transform duration-300 transform group-hover:scale-110"></i>
                        </button>
                        <div class="faq-answer overflow-hidden transition-all duration-500 ease-in-out max-h-0">
                            <div class="p-5 pt-0 bg-gray-50/50">
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $faq->answer }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Belum ada pertanyaan yang ditambahkan.</p>
                @endforelse
            </div>
        </div>


    </section>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                const answer = item.querySelector('.faq-answer');
                const icon = question.querySelector('i');

                question.addEventListener('click', function() {
                    const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

                    // Tutup semua FAQ lainnya
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            const otherAnswer = otherItem.querySelector('.faq-answer');
                            const otherIcon = otherItem.querySelector('.faq-question i');
                            const otherQuestion = otherItem.querySelector('.faq-question');

                            otherAnswer.style.maxHeight = '0px';
                            otherIcon.style.transform = 'rotate(0deg)';
                            otherQuestion.classList.remove('bg-gray-50');
                            otherItem.classList.remove('ring-2', 'ring-primary/20');
                        }
                    });

                    // Toggle FAQ yang diklik
                    if (isOpen) {
                        answer.style.maxHeight = '0px';
                        icon.style.transform = 'rotate(0deg)';
                        question.classList.remove('bg-gray-50');
                        item.classList.remove('ring-2', 'ring-primary/20');
                    } else {
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                        icon.style.transform = 'rotate(180deg)';
                        question.classList.add('bg-gray-50');
                        item.classList.add('ring-2', 'ring-primary/20');
                    }
                });
            });
        });
    </script>
@endpush

@push('style')
    <style>
        /* Image Slider Styles */
        .image-slider .slide {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            transition: opacity 0.7s ease-in-out;
            z-index: 0;
        }

        .image-slider .slide.active {
            opacity: 1;
            position: relative;
            z-index: 1;
        }


        .slider-dot.active {
            background-color: white;
            transform: scale(1.2);
        }

        /* Animasi FAQ yang lebih smooth */
        .faq-answer {
            max-height: 0;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .faq-question i {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .faq-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Efek hover yang lebih halus */
        .faq-item:hover {
            transform: translateY(-2px);
        }

        /* Animasi fade in */
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out;
        }
    </style>
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll(".image-slider .slide");
        const dots = document.querySelectorAll(".slider-dot");
        let slideInterval;

        function showSlide(index) {
            slides.forEach((s, i) => {
                s.classList.remove("active");
                dots[i].classList.remove("active");
                dots[i].classList.add("bg-white/50");
            });
            slides[index].classList.add("active");
            dots[index].classList.add("active", "bg-white");
            dots[index].classList.remove("bg-white/50");
            slideIndex = index;
        }

        function nextSlide() {
            slideIndex = (slideIndex + 1) % slides.length;
            showSlide(slideIndex);
        }

        // Start automatic sliding
        function startSlideShow() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        // Stop and restart slideshow when dot clicked
        function currentSlide(n) {
            clearInterval(slideInterval);
            showSlide(n - 1);
            startSlideShow();
        }

        // Initialize
        showSlide(slideIndex);
        startSlideShow();
    </script>
@endpush
