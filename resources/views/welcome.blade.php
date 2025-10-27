@extends('layouts.app')
@section('title', 'Course')
@section('content')
    <section class="relative w-full min-h-screen bg-gradient-to-br from-secondary via-blue-400 to-primary overflow-hidden">
        <div class="container mx-auto px-6 lg:px-12 py-20 lg:py-28 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white space-y-8 animate-fade-in-up">
                    <h1
                        class="font-extrabold text-3xl sm:text-4xl lg:text-5xl xl:text-6xl leading-[1.15] tracking-tight drop-shadow-lg">
                        {{ $content->hero_title ?? 'Judul Default' }} <br><span
                            class="text-yellow-300">{{ $content->hero_subtitle ?? '' }}</span>
                    </h1>
                    <p
                        class="text-sm sm:text-base md:text-lg text-white/90 max-w-md leading-relaxed tracking-wide font-light">
                        {{ $content->hero_description ?? '' }}
                    </p>
                    <div>
                        <a href="#"
                            class="inline-block bg-white text-primary px-8 py-4 rounded-full font-semibold text-lg shadow-lg hover:bg-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            {{ $content->hero_btn_primary ?? '' }}
                        </a>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="relative animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="relative z-10 transform hover:scale-105 transition-transform duration-700">
                        <img src="{{ asset('image/1.png') }}" alt="Dream House"
                            class="w-full max-w-md mx-auto h-auto object-contain drop-shadow-2xl">
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-white/10 rounded-full blur-3xl hidden lg:block">
                    </div>
                </div>
            </div>
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

                            <div class="flex justify-between items-center">
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('landing.page', ['slug' => $slug]) }}"
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
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($kelas->harga, 0, ',', '.') }}
                                </div>
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
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($buku->harga, 0, ',', '.') }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('buku.detail', Str::slug($buku->judul) . '-' . $buku->id) }}"
                                        class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-secondary/90 transition-all duration-300 shadow-md">
                                        Detail
                                    </a>
                                    <button onclick="addToCart({{ $buku->id }}, '{{ addslashes($buku->judul) }}')"
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

    <!-- Testimoni Section -->
    <section class="py-12 bg-gray-50">
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
    <section class="py-12 bg-white">
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
