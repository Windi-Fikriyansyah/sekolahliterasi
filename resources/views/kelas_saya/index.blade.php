<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Course Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('style')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#fba615',
                        'secondary': '#0977c2',
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'slide-in-left': 'slideInLeft 0.6s ease-out',
                        'slide-in-right': 'slideInRight 0.6s ease-out',
                        'pulse-gentle': 'pulseGentle 2s infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(30px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        bounceIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.3)'
                            },
                            '50%': {
                                opacity: '1',
                                transform: 'scale(1.05)'
                            },
                            '70%': {
                                transform: 'scale(0.9)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            }
                        },
                        slideInLeft: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(-30px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
                        },
                        slideInRight: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(30px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
                        },
                        pulseGentle: {
                            '0%, 100%': {
                                opacity: '1'
                            },
                            '50%': {
                                opacity: '0.8'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        input[type="checkbox"].accent-primary {
            accent-color: #fba615;
            /* Warna utama */
        }

        #cart-items::-webkit-scrollbar {
            width: 6px;
        }

        #cart-items::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #cart-items::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #fba615, #0977c2);
            border-radius: 10px;
        }

        #cart-items::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #0977c2, #fba615);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #0977c2;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #fba615;
        }

        /* Loading animation */
        .loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #fba615, #0977c2);
            z-index: 9999;
            animation: loading 2s ease-in-out infinite;
        }

        @keyframes loading {
            0% {
                width: 0%;
            }

            50% {
                width: 70%;
            }

            100% {
                width: 100%;
            }
        }

        /* Floating animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Shine effect */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.4),
                    transparent);
            transition: left 0.5s;
        }

        .shine-effect:hover::before {
            left: 100%;
        }
    </style>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .filter-btn {
            color: #6b7280;
            background-color: transparent;
        }

        .filter-btn:hover {
            background-color: #f3f4f6;
            color: #0977c2;
        }

        .filter-btn.active {
            background-color: #0977c2;
            color: white;
        }

        .product-card {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="font-sans">
    <!-- Loading Bar -->
    <div class="loading-bar"></div>

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="#" class="transform transition-transform duration-300 hover:scale-105">
                    <img src="{{ asset('image/logo.png') }}" alt="EduCourse Logo" class="h-14 w-auto object-contain">
                </a>
            </div>

            <!-- Tombol Menu Mobile -->
            <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>

            <!-- Navigation Desktop -->
            <nav class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-700 hover:text-secondary font-medium relative group">
                    Beranda
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <div class="relative">
                    <button id="product-btn"
                        class="flex items-center text-gray-700 hover:text-secondary font-medium focus:outline-none">
                        Product
                        <i id="product-arrow"
                            class="fa-solid fa-chevron-down ml-1 text-xs transition-transform duration-300"></i>
                    </button>

                    <div id="product-dropdown"
                        class="hidden absolute bg-white border border-gray-200 rounded-lg shadow-lg mt-2 w-48 z-50 transition-all duration-300 origin-top opacity-0 scale-95">
                        <a href="{{ route('program') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Program</a>
                        <a href="{{ route('kelasvideo') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Kelas Video</a>
                        <a href="{{ route('ebook') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">E-Book</a>
                        <a href="{{ route('buku') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Buku</a>
                    </div>
                </div>
                @guest
                    <a href="#tentang-kami" class="text-gray-700 hover:text-secondary font-medium relative group">
                        Tentang Kami
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#testimoni" class="text-gray-700 hover:text-secondary font-medium relative group">
                        Testimoni
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>

                    <a href="#faq" class="text-gray-700 hover:text-secondary font-medium relative group">
                        Pertanyaan Umum
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                @endguest
                @auth
                    <a href="{{ route('kelas.index') }}"
                        class="text-gray-700 hover:text-secondary font-medium relative group">
                        Kelas Saya
                        <span
                            class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('account.index') }}"
                        class="text-gray-700 hover:text-secondary font-medium relative group">
                        Pengaturan
                        <span
                            class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('history.index') }}"
                        class="text-gray-700 hover:text-secondary font-medium relative group">
                        Transaksi
                        <span
                            class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('pesanan_saya.index') }}"
                        class="text-gray-700 hover:text-secondary font-medium relative group">
                        Pesanan Saya
                        <span
                            class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('pembayaran_program_sekolah.index') }}"
                        class="text-gray-700 hover:text-secondary font-medium relative group">
                        Pembayaran Program
                        <span
                            class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                @endauth



            </nav>


            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <!-- 🔹 Ikon Keranjang -->
                    <div class="relative">
                        <button id="cart-btn" class="relative text-gray-700 hover:text-primary focus:outline-none">
                            <i class="fa-solid fa-shopping-cart text-2xl"></i>
                            <span id="cart-count"
                                class="absolute -top-2 -right-2 bg-primary text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                0
                            </span>
                        </button>

                        <!-- Dropdown Keranjang -->
                        <!-- Dropdown Keranjang -->
                        <div id="cartDropdown"
                            class="hidden absolute right-0 mt-2 w-96 bg-white border border-gray-200 rounded-xl shadow-2xl z-50 overflow-hidden">

                            <!-- Header Keranjang -->
                            <div class="bg-gradient-to-r from-primary to-secondary p-4 text-white">
                                <h3 class="font-bold text-lg flex items-center justify-between">
                                    <span><i class="fas fa-shopping-cart mr-2"></i>Keranjang Belanja</span>
                                    <span id="cart-count-header"
                                        class="bg-white text-primary text-sm px-2.5 py-1 rounded-full font-bold">0</span>
                                </h3>
                            </div>

                            <!-- Body Keranjang -->
                            <div id="cart-items" class="p-4 max-h-80 overflow-y-auto">
                                <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                                    <i class="fas fa-shopping-basket text-5xl mb-3 opacity-50"></i>
                                    <p class="text-sm">Keranjang Anda masih kosong</p>
                                </div>
                            </div>

                            <!-- Footer Keranjang -->
                            <div id="cart-footer" class="hidden border-t border-gray-200 bg-gray-50 p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="font-semibold text-gray-700">Total Belanja:</span>
                                    <span id="cart-total" class="text-primary font-bold text-xl">Rp 0</span>
                                </div>
                                <button id="checkout-btn" onclick="checkoutSelected()"
                                    class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-lg font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    Checkout Sekarang
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 🔹 Ikon Profil -->
                    <div class="relative">
                        <button id="profile-btn"
                            class="flex items-center space-x-2 focus:outline-none text-gray-700 hover:text-primary">
                            <i class="fa-solid fa-user-circle text-3xl"></i>
                            <i class="fa-solid fa-chevron-down text-gray-600 text-sm"></i>
                        </button>

                        <div id="userDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-secondary font-medium hover:text-primary transition">Masuk</a>
                    <a href="{{ route('register.index') }}"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition shine-effect">Daftar</a>
                @endauth
            </div>


        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 shadow-md">
            <nav class="flex flex-col p-4 space-y-3">
                <a href="/" class="text-gray-700 hover:text-secondary">Beranda</a>

                <!-- Dropdown Produk (versi mobile) -->
                <div class="border-t border-gray-100 pt-2">
                    <button id="mobile-product-btn"
                        class="flex justify-between items-center w-full text-gray-700 font-medium hover:text-secondary focus:outline-none">
                        Product <i id="mobile-product-arrow"
                            class="fa-solid fa-chevron-down text-sm transition-transform duration-300"></i>
                    </button>
                    <div id="mobile-product-dropdown"
                        class="hidden flex flex-col ml-4 mt-2 space-y-2 transition-all duration-300">
                        <a href="{{ route('program') }}" class="text-gray-700 hover:text-secondary">Program</a>
                        <a href="{{ route('kelasvideo') }}" class="text-gray-700 hover:text-secondary">Kelas
                            Video</a>
                        <a href="{{ route('ebook') }}" class="text-gray-700 hover:text-secondary">E-Book</a>
                        <a href="{{ route('buku') }}" class="text-gray-700 hover:text-secondary">Buku</a>
                    </div>
                </div>


                @auth
                    <a href="{{ route('kelas.index') }}" class="text-gray-700 hover:text-secondary">Kelas Saya</a>
                    <a href="{{ route('account.index') }}" class="text-gray-700 hover:text-secondary">Pengaturan</a>
                    <a href="{{ route('history.index') }}" class="text-gray-700 hover:text-secondary">Transaksi</a>
                    <a href="{{ route('pesanan_saya.index') }}" class="text-gray-700 hover:text-secondary">Pesanan
                        Saya</a>
                    <form action="{{ route('logout') }}" method="POST" class="pt-3 border-t border-gray-200">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-red-600 font-semibold hover:bg-red-50 rounded-md transition-all">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                        </button>
                    </form>
                @else
                    <div class="flex space-x-2 mt-3">
                        <a href="{{ route('login') }}"
                            class="flex-1 px-4 py-2 border border-secondary text-secondary rounded-md hover:bg-secondary hover:text-white transition-all">Masuk</a>
                        <a href="{{ route('register.index') }}"
                            class="flex-1 px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-all">Daftar</a>
                    </div>
                @endauth
            </nav>
        </div>

    </header>
    <section class="bg-gradient-to-r from-secondary to-blue-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Kelas Saya</h1>
                <p class="text-lg md:text-xl text-blue-100">Kelola dan akses semua pembelajaran yang telah Anda beli
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @if ($produk->isEmpty())
                <!-- Empty State -->
                <div class="max-w-2xl mx-auto text-center py-16 animate-fade-in-up">
                    <div class="bg-white rounded-2xl shadow-lg p-12">
                        <i class="fas fa-shopping-bag text-gray-300 text-6xl mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Pembelian</h3>
                        <p class="text-gray-600 mb-8">Anda belum memiliki kelas, ebook, atau program. Mulai belajar
                            sekarang!</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('kelasvideo') }}"
                                class="px-6 py-3 bg-secondary text-white rounded-lg hover:bg-opacity-90 transition shine-effect">
                                <i class="fas fa-video mr-2"></i>Lihat Kelas Video
                            </a>
                            <a href="{{ route('ebook') }}"
                                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition shine-effect">
                                <i class="fas fa-book mr-2"></i>Lihat E-Book
                            </a>
                            <a href="{{ route('program') }}"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-opacity-90 transition shine-effect">
                                <i class="fas fa-graduation-cap mr-2"></i>Lihat Program
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Filter Tabs -->
                <div class="max-w-6xl mx-auto mb-8 animate-fade-in-up">
                    <div class="bg-white rounded-lg shadow-md p-2 flex flex-wrap gap-2">
                        <button onclick="filterContent('semua')"
                            class="filter-btn active px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-th-large mr-2"></i>Semua ({{ $produk->count() }})
                        </button>
                        <button onclick="filterContent('program')"
                            class="filter-btn px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-graduation-cap mr-2"></i>Program ({{ $programs->count() }})
                        </button>
                        <button onclick="filterContent('kelas_video')"
                            class="filter-btn px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-video mr-2"></i>Kelas Video ({{ $kelas->count() }})
                        </button>
                        <button onclick="filterContent('ebook')"
                            class="filter-btn px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-book mr-2"></i>E-Book ({{ $ebooks->count() }})
                        </button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($produk as $item)
                            <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl animate-fade-in-up"
                                data-type="{{ strtolower($item->tipe_produk ?? 'kelas_video') }}"
                                style="animation-delay: {{ $loop->index * 0.1 }}s">
                                <!-- Thumbnail -->
                                <div class="relative overflow-hidden group">
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->judul }}"
                                        class="w-full h-48 object-cover transform transition-transform duration-500 group-hover:scale-110">

                                    <!-- Badge Type -->
                                    <div class="absolute top-3 left-3">
                                        @php
                                            $type = strtolower($item->tipe_produk ?? 'kelas_video');
                                            $badgeColors = [
                                                'program' => 'bg-green-600',
                                                'kelas_video' => 'bg-secondary',
                                                'ebook' => 'bg-primary',
                                            ];
                                            $badgeColor = $badgeColors[$type] ?? 'bg-gray-600';
                                            $typeLabels = [
                                                'ebook' => 'E-book',
                                                'kelas_video' => 'Kelas Video',
                                                'program' => 'Program',
                                            ];
                                            $typeLabel = $typeLabels[$type] ?? ucfirst($type);
                                        @endphp
                                        <span
                                            class="px-3 py-1 {{ $badgeColor }} text-white text-xs font-semibold rounded-full">
                                            {{ $typeLabel }}
                                        </span>
                                    </div>

                                    <!-- Overlay -->
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                        <a href="{{ route('kelas.show', ['slug' => Str::slug($item->judul), 'encryptedId' => Crypt::encryptString($item->id)]) }}"
                                            class="opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 transition-all duration-300 px-6 py-3 bg-white text-secondary font-semibold rounded-lg shine-effect">
                                            <i class="fas fa-play-circle mr-2"></i>Mulai Belajar
                                        </a>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-6">
                                    <h3
                                        class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 hover:text-secondary transition">
                                        {{ $item->judul }}
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit(strip_tags($item->deskripsi), 100) }}
                                    </p>

                                    <!-- Info -->
                                    <div
                                        class="flex items-center justify-between text-sm text-gray-500 mb-4 pb-4 border-b">
                                        {{-- <div class="flex items-center">
                                            <i class="far fa-calendar-alt mr-2"></i>
                                            <span>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d M Y') }}</span>
                                        </div> --}}
                                        <div class="flex items-center text-green-600 font-semibold">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            <span>Aktif</span>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('kelas.show', ['slug' => Str::slug($item->judul), 'encryptedId' => Crypt::encryptString($item->id)]) }}"
                                        class="block w-full text-center px-6 py-3 bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 shine-effect">
                                        <i class="fas fa-arrow-right mr-2"></i>Akses Sekarang
                                    </a>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- No Results Message -->
                    <div id="no-results" class="hidden text-center py-12 animate-fade-in-up">
                        <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ada Hasil</h3>
                        <p class="text-gray-600">Tidak ada produk untuk kategori yang dipilih.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div id="toast-container" class="fixed top-5 right-5 z-[9999] space-y-3"></div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cartBtn = document.getElementById("cart-btn");
            const cartDropdown = document.getElementById("cartDropdown");
            const cartCount = document.getElementById("cart-count");
            const cartCountHeader = document.getElementById("cart-count-header");
            const cartItemsContainer = document.getElementById("cart-items");
            const cartFooter = document.getElementById("cart-footer");
            const cartTotal = document.getElementById("cart-total");

            // 🔹 Load data cart dari database
            async function loadCart() {
                try {
                    const res = await fetch("/buku/cart");
                    if (!res.ok) throw new Error("Gagal memuat cart");
                    const items = await res.json();

                    cartCount.textContent = items.length;
                    cartCountHeader.textContent = items.length;

                    if (items.length === 0) {
                        cartItemsContainer.innerHTML = `
            <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                <i class="fas fa-shopping-basket text-5xl mb-3 opacity-50"></i>
                <p class="text-sm">Keranjang Anda masih kosong</p>
            </div>`;
                        cartFooter.classList.add("hidden");
                        return;
                    }

                    let total = 0;
                    cartItemsContainer.innerHTML = items.map(item => {
                        const subtotal = parseInt(item.harga) * item.qty;
                        if (item.checked) total += subtotal;

                        return `
            <div class="flex items-start justify-between border-b py-3">
                <div class="flex items-center space-x-3">
                    <input type="checkbox" class="mt-1 accent-primary"
                        ${item.checked ? 'checked' : ''}
                        onchange="toggleCheck(${item.cart_id}, this.checked)">
                    <img src="/storage/${item.thumbnail}" class="w-14 h-14 rounded object-cover">
                    <div>
                        <h4 class="font-semibold text-sm">${item.judul}</h4>
                        <p class="text-primary font-bold text-sm">Rp ${parseInt(item.harga).toLocaleString('id-ID')}</p>
                        <div class="flex items-center mt-1 space-x-2">
                            <button onclick="updateQty(${item.cart_id}, ${item.qty - 1})" class="px-2 bg-gray-200 rounded hover:bg-gray-300">-</button>
                            <span class="text-sm font-semibold w-6 text-center">${item.qty}</span>
                            <button onclick="updateQty(${item.cart_id}, ${item.qty + 1})" class="px-2 bg-gray-200 rounded hover:bg-gray-300">+</button>
                        </div>
                    </div>
                </div>
                <button onclick="removeFromCart(${item.cart_id})" class="text-gray-400 hover:text-red-500">
                    <i class="fas fa-trash"></i>
                </button>
            </div>`;
                    }).join("");

                    cartTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
                    cartFooter.classList.remove("hidden");

                    // Tombol checkout aktif hanya jika ada yang dipilih
                    document.getElementById("checkout-btn").disabled = total === 0;
                    document.getElementById("checkout-btn").classList.toggle("opacity-50", total === 0);
                } catch (err) {
                    console.error(err);
                    cartItemsContainer.innerHTML =
                        `<p class="text-center text-gray-500 py-4">Gagal memuat data keranjang.</p>`;
                }
            }


            // 🔹 Hapus item dari cart
            window.removeFromCart = async function(id) {
                await fetch(`/buku/cart/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                });
                showToast("🗑️ Item dihapus dari keranjang");
                loadCart();
            }

            // 🔹 Checkout
            window.checkoutSelected = async function() {
                try {
                    const res = await fetch("/buku/cart");
                    const items = await res.json();
                    const selected = items.filter(i => i.checked);

                    if (selected.length === 0) {
                        showToast("⚠️ Pilih produk terlebih dahulu", "warning");
                        return;
                    }

                    showToast("✅ Mengalihkan ke halaman checkout...", "success");

                    // Langsung arahkan ke halaman checkout
                    setTimeout(() => {
                        window.location.href = "{{ route('buku.checkout') }}";
                    }, 800);
                } catch (err) {
                    console.error(err);
                    showToast("❌ Terjadi kesalahan saat checkout", "error");
                }
            };



            // 🔹 Toggle dropdown
            if (cartBtn && cartDropdown) {
                cartBtn.addEventListener("click", (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    cartDropdown.classList.toggle("hidden");
                    if (!cartDropdown.classList.contains("hidden")) {
                        loadCart();
                    }
                });

                document.addEventListener("click", (e) => {
                    if (!cartBtn.contains(e.target) && !cartDropdown.contains(e.target)) {
                        cartDropdown.classList.add("hidden");
                    }
                });
            }

            window.addToCart = function(product_id, title) {
                fetch("/buku/cart/add", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            product_id
                        }),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'exists') {
                            showToast(`⚠️ ${title} sudah ada di keranjang`, "warning");
                        } else {
                            showToast(`✅ ${title} ditambahkan ke keranjang`);
                        }
                        loadCart();
                    })
                    .catch(() => showToast("❌ Gagal menambahkan produk", "error"));
            };

            window.updateQty = async function(id, qty) {
                if (qty < 1) {
                    showToast("Jumlah tidak boleh kurang dari 1", "warning");
                    return;
                }

                await fetch(`/buku/cart/${id}/qty`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            qty
                        }),
                    })
                    .then(res => res.json())
                    .then(() => {
                        loadCart();
                    })
                    .catch(() => showToast("❌ Gagal memperbarui jumlah", "error"));
            };

            window.toggleCheck = async function(id, checked) {
                await fetch(`/buku/cart/${id}/toggle`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            checked
                        }),
                    })
                    .then(() => {
                        loadCart();
                    })
                    .catch(() => showToast("❌ Gagal memperbarui pilihan", "error"));
            };


            // Pertama kali load
            loadCart();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileBtn = document.getElementById('profile-btn');
            const userDropdown = document.getElementById('userDropdown');

            if (profileBtn && userDropdown) {
                // Toggle tampil/sembunyi saat tombol profil diklik
                profileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });

                // Tutup dropdown jika klik di luar area profil/dropdown
                window.addEventListener('click', (e) => {
                    if (!profileBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    <script>
        // Enhanced slider functionality with smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            // Loading animation
            setTimeout(() => {
                document.querySelector('.loading-bar').style.display = 'none';
            }, 2000);

            // Slider
            const sliderWrapper = document.querySelector('.slider-wrapper');
            const slides = document.querySelectorAll('.slider-slide');
            const prevBtn = document.querySelector('.slider-prev');
            const nextBtn = document.querySelector('.slider-next');
            const indicators = document.querySelectorAll('.slider-indicator');

            let currentSlide = 0;
            const totalSlides = slides.length;
            let slideInterval;

            function updateSlider() {
                sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;

                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentSlide) {
                        indicator.classList.add('active', 'bg-opacity-100');
                        indicator.classList.remove('bg-opacity-50');
                    } else {
                        indicator.classList.remove('active', 'bg-opacity-100');
                        indicator.classList.add('bg-opacity-50');
                    }
                });
            }

            // Next slide
            nextBtn.addEventListener('click', function() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
                resetAutoSlide();
            });

            // Previous slide
            prevBtn.addEventListener('click', function() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
                resetAutoSlide();
            });

            // Indicator click
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    currentSlide = index;
                    updateSlider();
                    resetAutoSlide();
                });
            });

            // Auto slide
            function startAutoSlide() {
                slideInterval = setInterval(function() {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    updateSlider();
                }, 5000);
            }

            function resetAutoSlide() {
                clearInterval(slideInterval);
                startAutoSlide();
            }

            startAutoSlide();

            // Enhanced FAQ functionality
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('i');
                    const faqItem = this.parentElement;

                    // Toggle answer visibility with smooth animation
                    if (answer.classList.contains('hidden')) {
                        answer.classList.remove('hidden');
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                        faqItem.classList.add('bg-gray-50');
                    } else {
                        answer.style.maxHeight = '0';
                        setTimeout(() => {
                            answer.classList.add('hidden');
                        }, 300);
                        faqItem.classList.remove('bg-gray-50');
                    }

                    // Rotate icon
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Add scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe elements for animation
            document.querySelectorAll('.course-card, .testimonial-card, .animate-fade-in-up').forEach(el => {
                el.style.animationPlayState = 'paused';
                observer.observe(el);
            });

            // Header scroll effect
            let lastScrollY = window.scrollY;
            const header = document.querySelector('header');

            window.addEventListener('scroll', () => {
                if (window.scrollY > lastScrollY && window.scrollY > 100) {
                    header.style.transform = 'translateY(-100%)';
                } else {
                    header.style.transform = 'translateY(0)';
                }
                lastScrollY = window.scrollY;
            });

            // Add hover sound effects (optional)
            const buttons = document.querySelectorAll('button, a');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });

        // Add floating animation to random elements
        function addFloatingAnimation() {
            const elements = document.querySelectorAll('.course-card, .testimonial-card');
            elements.forEach((el, index) => {
                if (index % 3 === 0) {
                    el.classList.add('float-animation');
                    el.style.animationDelay = `${index * 0.2}s`;
                }
            });
        }

        // Initialize floating animation
        document.addEventListener('DOMContentLoaded', addFloatingAnimation);


        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const icon = menuBtn.querySelector('i');

            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('animate-fade-in-up');

                // Ganti icon antara bars dan times
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });
        });

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const colors = {
                success: 'bg-green-500',
                warning: 'bg-yellow-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
            };

            toast.className =
                `${colors[type]} text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in`;
            toast.innerHTML = `
        <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : type === 'warning' ? 'fa-triangle-exclamation' : type === 'error' ? 'fa-circle-xmark' : 'fa-circle-info'} text-white"></i>
        <span>${message}</span>
    `;

            container.appendChild(toast);

            // Hapus otomatis setelah 3 detik
            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }

        // ✅ Tambahkan animasi CSS sederhana
        const style = document.createElement('style');
        style.innerHTML = `
@keyframes slide-in {
    0% { opacity: 0; transform: translateX(100%); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes fade-out {
    0% { opacity: 1; transform: translateX(0); }
    100% { opacity: 0; transform: translateX(100%); }
}
.animate-slide-in { animation: slide-in 0.4s ease-out; }
.animate-fade-out { animation: fade-out 0.4s ease-in forwards; }
`;
        document.head.appendChild(style);


        document.addEventListener('DOMContentLoaded', function() {
            const mobileBtn = document.getElementById('mobile-product-btn');
            const mobileDropdown = document.getElementById('mobile-product-dropdown');
            const mobileArrow = document.getElementById('mobile-product-arrow');

            if (mobileBtn && mobileDropdown) {
                mobileBtn.addEventListener('click', () => {
                    mobileDropdown.classList.toggle('hidden');
                    mobileArrow.classList.toggle('rotate-180');
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const productBtn = document.getElementById('product-btn');
            const productDropdown = document.getElementById('product-dropdown');
            const productArrow = document.getElementById('product-arrow');

            if (productBtn && productDropdown && productArrow) {
                productBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    productDropdown.classList.toggle('hidden');

                    if (!productDropdown.classList.contains('hidden')) {
                        // buka dropdown
                        productDropdown.classList.remove('opacity-0', 'scale-95');
                        productDropdown.classList.add('opacity-100', 'scale-100');
                        productArrow.classList.add('rotate-180');
                    } else {
                        // tutup dropdown
                        productDropdown.classList.add('opacity-0', 'scale-95');
                        productDropdown.classList.remove('opacity-100', 'scale-100');
                        productArrow.classList.remove('rotate-180');
                    }
                });

                // Tutup dropdown jika klik di luar area
                window.addEventListener('click', (e) => {
                    if (!productBtn.contains(e.target) && !productDropdown.contains(e.target)) {
                        productDropdown.classList.add('hidden', 'opacity-0', 'scale-95');
                        productArrow.classList.remove('rotate-180');
                    }
                });
            }
        });
    </script>


    <script>
        function filterContent(type) {
            const cards = document.querySelectorAll('.product-card');
            const buttons = document.querySelectorAll('.filter-btn');
            const noResults = document.getElementById('no-results');
            let visibleCount = 0;

            // Update active button
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.closest('.filter-btn').classList.add('active');

            // Filter cards
            cards.forEach((card, index) => {
                const cardType = card.getAttribute('data-type');

                if (type === 'semua' || cardType === type) {
                    card.style.display = 'block';
                    card.style.animationDelay = `${visibleCount * 0.1}s`;
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Add smooth scroll reveal
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.product-card').forEach(card => {
                observer.observe(card);
            });
        });
    </script>


</body>

</html>
