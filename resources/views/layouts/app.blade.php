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
                <a href="{{ route('program') }}" class="text-gray-700 hover:text-secondary font-medium relative group">
                    Program
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="{{ route('kelasvideo') }}"
                    class="text-gray-700 hover:text-secondary font-medium relative group">
                    Kelas Video
                    <span
                        class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="{{ route('ebook') }}" class="text-gray-700 hover:text-secondary font-medium relative group">
                    E-Book
                    <span
                        class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="{{ route('buku') }}" class="text-gray-700 hover:text-secondary font-medium relative group">
                    Buku
                    <span
                        class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                </a>
                @auth
                    <a href="{{ route('kelas.index') }}"
                        class="text-gray-700 hover:text-secondary font-medium relative group">
                        Kelas Saya
                        <span
                            class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                @endauth

                <a href="#" class="text-gray-700 hover:text-secondary font-medium relative group">
                    Testimoni
                    <span
                        class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#" class="text-gray-700 hover:text-secondary font-medium relative group">
                    FAQ
                    <span
                        class="absolute bottom-0 left-0 w-0.5 bg-secondary transition-all duration-300 group-hover:w-full"></span>
                </a>
            </nav>

            <!-- Tombol Login & Register (Desktop) -->
            <!-- Tombol Login & Register (Desktop) -->
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
                <a href="{{ route('program') }}" class="text-gray-700 hover:text-secondary">Program</a>
                <a href="{{ route('kelasvideo') }}" class="text-gray-700 hover:text-secondary">Kelas Video</a>
                <a href="{{ route('ebook') }}" class="text-gray-700 hover:text-secondary">E-Book</a>
                <a href="{{ route('buku') }}" class="text-gray-700 hover:text-secondary">Buku</a>
                <a href="#" class="text-gray-700 hover:text-secondary">Testimoni</a>
                <a href="#" class="text-gray-700 hover:text-secondary">FAQ</a>
                <div class="flex space-x-2 mt-3">
                    <a href="{{ route('login') }}"
                        class="flex-1 px-4 py-2 border border-secondary text-secondary rounded-md hover:bg-secondary hover:text-white transition-all">Masuk</a>
                    <a href="{{ route('register.index') }}"
                        class="flex-1 px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-all">Daftar</a>
                </div>
            </nav>
        </div>
    </header>



    @yield('content')

    <footer class="bg-secondary text-white pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div class="animate-fade-in-up">
                    <img src="{{ asset('image/logo.png') }}" alt="EduCourse Logo"
                        class="h-14 w-auto object-contain mb-4 transform transition-transform duration-300 hover:scale-105">

                    <p class="mb-4">Platform pembelajaran online terbaik dengan berbagai pilihan E-Course dan E-Book
                        berkualitas.</p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="text-white hover:text-primary transform transition-all duration-300 hover:scale-125 hover:-translate-y-1">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="text-white hover:text-primary transform transition-all duration-300 hover:scale-125 hover:-translate-y-1">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="text-white hover:text-primary transform transition-all duration-300 hover:scale-125 hover:-translate-y-1">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="text-white hover:text-primary transform transition-all duration-300 hover:scale-125 hover:-translate-y-1">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="animate-fade-in-up" style="animation-delay: 0.1s;">
                    <h4 class="font-bold text-lg mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="/"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Beranda</a>
                        </li>
                        <li><a href="#"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Tentang
                                Kami</a></li>
                        <li><a href="{{ route('program') }}"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Program</a>
                        </li>
                        <li><a href="{{ route('kelasvideo') }}"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Kelas
                                Video</a></li>
                        <li>
                            <a href="{{ route('ebook') }}"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">E-Book</a>
                        </li>
                        <li><a href="{{ route('buku') }}"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Buku</a>
                        </li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <h4 class="font-bold text-lg mb-4">Dukungan</h4>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Bantuan</a>
                        </li>
                        <li><a href="#"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">FAQ</a>
                        </li>
                        <li><a href="#"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Kebijakan
                                Privasi</a></li>
                        <li><a href="#"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Syarat
                                & Ketentuan</a></li>
                        <li><a href="#"
                                class="hover:text-primary transition-all duration-300 transform hover:translate-x-1 block">Kontak</a>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                    <h4 class="font-bold text-lg mb-4">Berlangganan Newsletter</h4>
                    <p class="mb-4">Dapatkan informasi terbaru tentang E-Course dan E-Book terbaru.</p>
                    <form class="flex transform transition-all duration-300 hover:scale-105">
                        <input type="email" placeholder="Email Anda"
                            class="px-4 py-2 rounded-l-lg text-gray-800 w-full focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300">
                        <button type="submit"
                            class="bg-primary text-white px-4 py-2 rounded-r-lg hover:bg-opacity-90 transition-all duration-300 shine-effect">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-600 pt-6 text-center animate-fade-in-up">
                <p>&copy; 2023 EduCourse. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Toast Container -->
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
    </script>
    @stack('js')
</body>

</html>
