@extends('layouts.app')

@section('title', 'Checkout - ' . $produk->judul)

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <a href="{{ route('ebook') }}" class="text-gray-600 hover:text-primary">Ebook</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <a href="{{ route('produk.show', Crypt::encrypt($produk->id)) }}"
                                class="text-gray-600 hover:text-primary">{{ Str::limit($produk->judul, 20) }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-800 font-medium">Checkout</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Ubah urutan grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Ringkasan Pesanan (kiri) -->
                <div class="order-2 lg:order-1 bg-white rounded-2xl shadow-lg p-6 lg:p-8 h-fit sticky top-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>

                    <div class="flex items-start space-x-4 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex-shrink-0 w-16 h-20 bg-gray-100 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="{{ $produk->judul }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-800 text-sm leading-tight mb-1">
                                {{ $produk->judul }}
                            </h3>
                            <p class="text-gray-600 text-xs mb-2">
                                @if ($produk->tipe_produk === 'ebook')
                                    E-book
                                @elseif ($produk->tipe_produk === 'kelas_video')
                                    Kelas Video
                                @elseif ($produk->tipe_produk === 'program')
                                    Program
                                @else
                                    {{ ucfirst($produk->tipe_produk) }}
                                @endif
                            </p>
                            <p class="text-primary font-bold text-lg">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-800 font-medium">Rp
                                {{ number_format($produk->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Diskon</span>
                            <span class="text-green-600 font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Biaya Layanan</span>
                            <span class="text-gray-800">Gratis</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-6 border-t border-gray-200 mb-6">
                        <span class="text-lg font-bold text-gray-800">Total</span>
                        <span class="text-2xl font-bold text-primary">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 text-center pt-6 border-t border-gray-200">
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-green-600 mb-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="text-xs text-gray-600">Garansi 100%</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-blue-600 mb-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-xs text-gray-600">Pembayaran Aman</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-purple-600 mb-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs text-gray-600">Support 24/7</span>
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran (kanan) -->
                <div class="order-1 lg:order-2 bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Metode Pembayaran</h2>

                    <form action="{{ route('payment.process', $encryptedCourseId) }}" method="POST" id="checkoutForm">
                        @csrf
                        <div class="mb-6">
                            <label for="referral_code" class="block text-gray-700 font-semibold mb-2">
                                Kode Referral (opsional)
                            </label>
                            <input type="text" name="referral_code" id="referral_code"
                                value="{{ old('referral_code', $referralCode ?? '') }}"
                                placeholder="Masukkan kode referral jika ada"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            @forelse ($channels as $channel)
                                <label class="relative flex cursor-pointer">

                                    <input type="radio" name="channel" value="{{ $channel['code'] }}" class="sr-only"
                                        required>

                                    <div
                                        class="payment-method-card border-2 border-gray-300 rounded-xl p-4 w-full text-center bg-white hover:bg-gray-100 transition-all duration-300">
                                        <div class="flex flex-col items-center space-y-2">
                                            <img src="{{ $channel['icon_url'] ?? asset('image/payment-default.png') }}"
                                                alt="{{ $channel['name'] }}" class="w-12 h-12 object-contain mb-2">
                                            <span class="text-sm font-semibold text-gray-700">{{ $channel['name'] }}</span>
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500 text-sm">Channel pembayaran belum tersedia saat ini.</p>
                            @endforelse
                        </div>

                        <button type="submit"
                            class="w-full bg-primary text-white font-bold py-4 px-6 rounded-xl hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Bayar Sekarang
                        </button>

                        <div class="text-center mt-4">
                            <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Transaksi 100% Aman & Terenkripsi</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentCards = document.querySelectorAll('.payment-method-card');
            const paymentInputs = document.querySelectorAll('input[name="channel"]');

            paymentInputs.forEach(input => {
                input.addEventListener('change', function() {
                    paymentCards.forEach(card => {
                        card.classList.remove(
                            'border-primary', 'bg-primary/10', 'text-primary', 'ring-2',
                            'ring-primary/30'
                        );
                        card.classList.add('border-gray-300', 'bg-white', 'text-gray-700');
                    });

                    if (this.checked) {
                        const card = this.closest('label').querySelector('.payment-method-card');
                        card.classList.add(
                            'border-primary', 'bg-primary/10', 'text-primary', 'ring-2',
                            'ring-primary/30'
                        );
                        card.classList.remove('border-gray-300', 'bg-white', 'text-gray-700');
                    }
                });
            });

            // Validasi form
            const form = document.getElementById('checkoutForm');
            form.addEventListener('submit', function(e) {
                const metodePembayaran = document.querySelector('input[name="channel"]:checked');
                if (!metodePembayaran) {
                    e.preventDefault();
                    alert('Silakan pilih metode pembayaran');
                    return false;
                }
            });
        });
    </script>
@endpush

@push('style')
    <style>
        .payment-method-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .payment-method-card:hover {
            transform: translateY(-3px);
            background-color: #f9fafb;
        }

        /* Warna utama (bisa disesuaikan dengan Tailwind color theme kamu) */
        .bg-primary\/10 {
            background-color: rgba(59, 130, 246, 0.1);
            /* contoh warna biru muda */
        }
    </style>
@endpush
