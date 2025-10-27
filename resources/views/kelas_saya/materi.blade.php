<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Course Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .materi-item.active {
            background-color: #dbeafe;
            border-left: 4px solid #0977c2;
        }

        #sidebar-materi.sidebar-hidden-desktop {
            width: 0 !important;
            min-width: 0 !important;
            opacity: 0;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        #content-area.expanded {
            flex: 1;
            max-width: 100%;
        }

        #show-sidebar-desktop {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 15;
            /* lebih rendah dari header, lebih tinggi dari konten */
        }

        /* Saat tombol muncul */
        #show-sidebar-desktop.visible {
            opacity: 1 !important;
            pointer-events: auto !important;
        }


        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0977c2;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #pdf-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        #pdf-container canvas {
            max-width: 100%;
            height: auto !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .pdf-page-placeholder {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .pdf-controls {
            position: sticky;
            top: 0;
            z-index: 10;
            background: white;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
        }
    </style>
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


    <section class="bg-gradient-to-r from-secondary to-blue-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Tombol kembali -->
                <a href="{{ route('kelas.index') }}"
                    class="inline-flex items-center text-white hover:text-blue-100 mb-4 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Kelas Saya
                </a>

                <!-- Judul dan Tombol Download sejajar -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $produk->judul }}</h1>
                        <div class="flex items-center gap-4 text-blue-100">
                            <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm">
                                {{ ucfirst($produk->tipe_produk) }}
                            </span>
                            <span><i class="fas fa-book-open mr-2"></i>{{ $materi->count() }} Materi</span>
                        </div>
                    </div>

                    <!-- Tombol Download Sertifikat -->
                    <div class="relative mt-4 md:mt-0">
                        <button id="dropdownButton"
                            class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fa-solid fa-download mr-2"></i> Download Sertifikat
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div id="dropdownMenu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <a href="{{ route('kelas.certificate.download', ['course' => $produk->id, 'format' => 'pdf']) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fa-solid fa-file-pdf mr-2 text-red-500"></i> Download PDF
                            </a>
                            <a href="{{ route('kelas.certificate.download', ['course' => $produk->id, 'format' => 'image']) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fa-solid fa-image mr-2 text-blue-500"></i> Download Gambar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Main Content -->
    <section class="py-8 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="flex gap-6 relative">

                    <!-- Konten Utama -->
                    <div id="content-area" class="flex-1 transition-all duration-300">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative">
                            <button id="show-sidebar-desktop"
                                class="absolute top-4 right-4 z-50 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 opacity-0 pointer-events-none lg:block hidden"
                                onclick="toggleSidebarDesktop()">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <div id="content-viewer" class="w-full bg-black relative"
                                style="height: calc(100vh - 250px); min-height: 600px;">
                                <div class="flex items-center justify-center h-full text-white p-12 text-center">
                                    <div>
                                        <i class="fas fa-play-circle text-6xl mb-4 opacity-50"></i>
                                        <p class="text-lg">Pilih materi dari daftar untuk mulai belajar</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Materi -->
                    <div id="sidebar-materi"
                        class="w-80 transition-all duration-300 lg:relative fixed right-0 top-0 h-full lg:h-auto z-40 translate-x-full lg:translate-x-0"
                        style="box-shadow: -4px 0 6px rgba(0,0,0,0.1);">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full lg:sticky lg:top-4">
                            <div
                                class="bg-gradient-to-r from-secondary to-blue-600 text-white p-4 flex justify-between items-center">
                                <h3 class="font-bold text-lg">
                                    <i class="fas fa-list-ul mr-2"></i>Daftar Materi
                                </h3>
                                <div class="flex items-center gap-2">
                                    <button id="toggle-sidebar-desktop" onclick="toggleSidebarDesktop()"
                                        class="hidden lg:flex text-white hover:text-gray-200 p-1 rounded transition">
                                        <i class="fas fa-chevron-right" id="desktop-toggle-icon"></i>
                                    </button>
                                    <button onclick="toggleSidebar()"
                                        class="lg:hidden text-white hover:text-gray-200">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-y-auto" style="max-height: calc(100vh - 200px);">
                                @if ($materi->isEmpty())
                                    <div class="p-6 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                        <p>Belum ada materi tersedia</p>
                                    </div>
                                @else
                                    <div class="divide-y">
                                        @foreach ($materi as $index => $item)
                                            <button
                                                onclick="loadMateri('{{ $item->jenis_materi }}', '{{ $item->file_path }}', {{ $item->id }}, {{ $item->tipe_pdf ?? 0 }})"
                                                class="materi-item w-full text-left p-4 hover:bg-blue-50 transition-colors duration-200 flex items-start gap-3"
                                                data-materi-id="{{ $item->id }}">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br {{ $item->jenis_materi == 'video' ? 'from-red-500 to-pink-500' : 'from-blue-500 to-purple-500' }} flex items-center justify-center text-white">
                                                    <i
                                                        class="fas {{ $item->jenis_materi == 'video' ? 'fa-play' : 'fa-file-pdf' }}"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-xs font-semibold text-gray-500">Materi
                                                            {{ $index + 1 }}</span>
                                                        <span
                                                            class="px-2 py-0.5 text-xs rounded-full {{ $item->jenis_materi == 'video' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                                            {{ strtoupper($item->jenis_materi) }}
                                                        </span>
                                                    </div>
                                                    <p class="text-sm font-medium text-gray-800 line-clamp-2">
                                                        {{ $item->deskripsi }}</p>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Overlay Mobile -->
                    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"
                        onclick="toggleSidebar()"></div>
                </div>
            </div>
        </div>
    </section>


    <div id="toast-container" class="fixed top-5 right-5 z-[9999] space-y-3"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                // Tutup jika klik di luar
                document.addEventListener('click', (e) => {
                    if (!dropdownMenu.classList.contains('hidden') &&
                        !dropdownButton.contains(e.target) &&
                        !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById('sidebar-materi');
            const contentArea = document.getElementById('content-area');
            const showSidebarBtn = document.getElementById('show-sidebar-desktop');
            const toggleIcon = document.getElementById('desktop-toggle-icon');
            let sidebarVisible = true;
            let currentPdfDoc = null;
            let renderingQueue = [];
            let isRendering = false;

            window.toggleSidebarDesktop = function() {
                sidebarVisible = !sidebarVisible;

                if (sidebarVisible) {
                    sidebar.classList.remove('sidebar-hidden-desktop');
                    contentArea.classList.remove('expanded');
                    showSidebarBtn.classList.remove('visible');
                    toggleIcon.classList.remove('fa-chevron-left');
                    toggleIcon.classList.add('fa-chevron-right');
                } else {
                    sidebar.classList.add('sidebar-hidden-desktop');
                    contentArea.classList.add('expanded');
                    showSidebarBtn.classList.add('visible');
                    toggleIcon.classList.remove('fa-chevron-right');
                    toggleIcon.classList.add('fa-chevron-left');
                }
            };

            window.toggleSidebar = function() {
                const overlay = document.getElementById('sidebar-overlay');
                sidebar.classList.toggle('translate-x-full');
                overlay.classList.toggle('hidden');
            };

            window.loadMateri = function(jenis, filePath, id, tipe_pdf = 0) {


                if (currentPdfDoc) {
                    renderingQueue = [];
                    currentPdfDoc = null;
                }


                document.querySelectorAll('.materi-item').forEach(el => el.classList.remove('active'));
                const activeItem = document.querySelector(`[data-materi-id="${id}"]`);
                if (activeItem) {
                    activeItem.classList.add('active');
                }

                const viewer = document.getElementById('content-viewer');
                viewer.innerHTML = `
                    <div class='flex justify-center items-center h-full'>
                        <div class='text-center text-white'>
                            <div class='loading-spinner mx-auto mb-4'></div>
                            <p>Memuat konten...</p>
                        </div>
                    </div>`;

                if (jenis === 'video') {
                    setTimeout(() => {
                        viewer.innerHTML = `
                            <video
                                controls
                                controlsList="nodownload"
                                oncontextmenu="return false;"
                                class="w-full h-full bg-black"
                                preload="metadata">
                                <source src="{{ asset('storage') }}/${filePath}" type="video/mp4">
                                Browser Anda tidak mendukung video player.
                            </video>`;
                    }, 300);
                } else if (jenis === 'pdf') {
                    loadPDFOptimized(`{{ asset('storage') }}/${filePath}`, viewer);
                }

                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }
                if (jenis === 'pdf') {
                    loadPDFOptimized(`{{ asset('storage') }}/${filePath}`, viewer, tipe_pdf);
                }
            };

            // Optimized PDF Loading with Lazy Rendering
            function loadPDFOptimized(url, container, tipe_pdf = 0) {
                pdfjsLib.GlobalWorkerOptions.workerSrc =
                    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js";

                container.innerHTML = `
                    <div class="w-full h-full bg-gray-100 overflow-y-auto">
                        <div class="pdf-controls">
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-file-pdf mr-2"></i>
                                <span id="pdf-info">Memuat PDF...</span>
                            </span>

                            ${tipe_pdf == 1 ? `
                                                                            <a href="${url}" download
                                                                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                                                                <i class="fa-solid fa-download mr-2"></i> Download PDF
                                                                            </a>
                                                                            ` : ``}
                        </div>
                        <div id="pdf-container" class="p-4"></div>
                    </div>`;

                const pdfContainer = container.querySelector('#pdf-container');
                const pdfInfo = container.querySelector('#pdf-info');

                const loadingTask = pdfjsLib.getDocument({
                    url: url,
                    cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/cmaps/',
                    cMapPacked: true,
                });

                loadingTask.promise.then(function(pdf) {
                    currentPdfDoc = pdf;
                    const numPages = pdf.numPages;
                    pdfInfo.textContent = `${numPages} Halaman`;

                    pdfContainer.innerHTML = "";
                    if (tipe_pdf != 1) {
                        document.addEventListener('contextmenu', e => e.preventDefault());
                        document.addEventListener('keydown', e => {
                            if ((e.ctrlKey && e.key === 'p') || e.key === 'PrintScreen') {
                                e.preventDefault();
                            }
                        });
                    }


                    // Calculate optimal scale
                    const baseScale = window.innerWidth < 768 ? 0.8 : 1.2;
                    const ratio = window.devicePixelRatio || 1;

                    // Create placeholders for all pages
                    for (let i = 1; i <= numPages; i++) {
                        const placeholder = document.createElement('div');
                        placeholder.id = `page-${i}`;
                        placeholder.className =
                            'pdf-page-placeholder mx-auto block rounded shadow-md mb-4 bg-white';
                        placeholder.style.width = '100%';
                        placeholder.style.maxWidth = '800px';
                        placeholder.style.height = '1000px';
                        pdfContainer.appendChild(placeholder);
                    }

                    // Setup Intersection Observer for lazy loading
                    const observerOptions = {
                        root: container.querySelector('.overflow-y-auto'),
                        rootMargin: '100px',
                        threshold: 0.01
                    };

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const pageNum = parseInt(entry.target.id.split('-')[1]);
                                if (!entry.target.dataset.rendered) {
                                    renderPage(pdf, pageNum, entry.target, baseScale,
                                        ratio);
                                    entry.target.dataset.rendered = 'true';
                                }
                            }
                        });
                    }, observerOptions);

                    // Observe all placeholders
                    document.querySelectorAll('.pdf-page-placeholder').forEach(placeholder => {
                        observer.observe(placeholder);
                    });

                }).catch(function(error) {
                    console.error('Error loading PDF:', error);
                    container.innerHTML = `
                        <div class="flex items-center justify-center h-full text-white">
                            <div class="text-center p-6">
                                <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                                <p class="text-lg mb-2">Gagal memuat PDF</p>
                                <p class="text-sm opacity-75">${error.message || 'Silakan coba lagi'}</p>
                            </div>
                        </div>`;
                });
            }

            // Render individual page
            function renderPage(pdf, pageNum, container, baseScale, ratio) {
                pdf.getPage(pageNum).then(function(page) {
                    const viewport = page.getViewport({
                        scale: baseScale
                    });

                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d', {
                        alpha: false
                    });

                    canvas.width = viewport.width * ratio;
                    canvas.height = viewport.height * ratio;
                    canvas.style.width = '100%';
                    canvas.style.height = 'auto';

                    context.setTransform(ratio, 0, 0, ratio, 0, 0);

                    canvas.classList.add('mx-auto', 'block', 'rounded', 'shadow-md', 'bg-white');

                    // Replace placeholder with canvas
                    container.style.height = 'auto';
                    container.className = 'mb-4';
                    container.innerHTML = '';
                    container.appendChild(canvas);

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    page.render(renderContext).promise.catch(err => {
                        console.error(`Error rendering page ${pageNum}:`, err);
                    });
                }).catch(err => {
                    console.error(`Error getting page ${pageNum}:`, err);
                    container.innerHTML =
                        `<p class="text-center text-red-500 p-4">Error loading page ${pageNum}</p>`;
                });
            }

            // Content protection
            const contentViewer = document.getElementById('content-viewer');
            contentViewer.addEventListener('contextmenu', e => e.preventDefault());
            contentViewer.addEventListener('copy', e => e.preventDefault());

            document.addEventListener('keyup', function(e) {
                if (e.key === 'PrintScreen') {
                    navigator.clipboard.writeText('');
                }
            });
        });
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
            <input type="checkbox" class="mt-1 accent-primary" ${item.checked ? 'checked' : '' }
                onchange="toggleCheck(${item.cart_id}, this.checked)">
            <img src="/storage/${item.thumbnail}" class="w-14 h-14 rounded object-cover">
            <div>
                <h4 class="font-semibold text-sm">${item.judul}</h4>
                <p class="text-primary font-bold text-sm">Rp ${parseInt(item.harga).toLocaleString('id-ID')}</p>
                <div class="flex items-center mt-1 space-x-2">
                    <button onclick="updateQty(${item.cart_id}, ${item.qty - 1})"
                        class="px-2 bg-gray-200 rounded hover:bg-gray-300">-</button>
                    <span class="text-sm font-semibold w-6 text-center">${item.qty}</span>
                    <button onclick="updateQty(${item.cart_id}, ${item.qty + 1})"
                        class="px-2 bg-gray-200 rounded hover:bg-gray-300">+</button>
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
                await
                fetch(`/buku/cart/${id}/qty`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token" ]').content,
                        },
                        body: JSON.stringify({
                            qty
                        }),
                    }).then(res =>
                        res.json())
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
</body>

</html>
