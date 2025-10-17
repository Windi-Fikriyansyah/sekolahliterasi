@extends('layouts.app')

@section('title', $produk->judul)

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <a href="{{ route('ebook') }}" class="text-gray-600 hover:text-primary">Ebook</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-800 font-medium">{{ Str::limit($produk->judul, 30) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-12">
                <!-- Gambar Produk -->
                <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <div class="relative overflow-hidden rounded-xl mb-4 max-w-md mx-auto">
                        <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="{{ $produk->judul }}"
                            class="w-full h-auto max-h-96 object-contain">
                        <div class="absolute top-4 right-4">
                            <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                {{ $produk->tipe_produk }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                        {{ $produk->judul }}
                    </h1>

                    <!-- Harga -->
                    <div class="mb-6">
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-bold text-primary">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Informasi Singkat -->
                    <div class="border-t border-b border-gray-200 py-6 mb-6 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Tipe Produk:</span>
                            <span class="text-gray-800 font-semibold">{{ $produk->tipe_produk }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Format:</span>
                            <span class="text-gray-800 font-semibold">Digital (PDF/EPUB)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Status:</span>
                            <span class="bg-green-100 text-green-700 text-sm font-semibold px-3 py-1 rounded-full">
                                Tersedia
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="space-y-3">
                        <a href="{{ route('payment.index', Crypt::encrypt($produk->id)) }}"
                            class="block w-full bg-primary text-white font-bold py-4 px-6 rounded-xl hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            Beli Sekarang
                        </a>


                    </div>

                    <!-- Fitur Keamanan -->
                    <div class="mt-6 grid grid-cols-3 gap-4 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            <span class="text-xs text-gray-600 font-medium">Pembayaran Aman</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span class="text-xs text-gray-600 font-medium">Akses Instan</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <span class="text-xs text-gray-600 font-medium">Support 24/7</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Deskripsi -->
            <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <button onclick="showTab('deskripsi')" id="tab-deskripsi"
                            class="tab-button border-b-2 border-primary text-primary font-semibold py-4 px-1">
                            Deskripsi
                        </button>
                        <button onclick="showTab('manfaat')" id="tab-manfaat"
                            class="tab-button border-b-2 border-transparent text-gray-600 hover:text-gray-800 font-semibold py-4 px-1">
                            Benefit
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div id="content-deskripsi" class="tab-content">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi Produk</h3>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {!! $produk->deskripsi !!}
                    </div>
                </div>

                <div id="content-manfaat" class="tab-content hidden">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Benefit yang Anda Dapatkan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $manfaatList = json_decode($produk->manfaat, true);
                        @endphp

                        @if (!empty($manfaatList))
                            @foreach ($manfaatList as $item)
                                <div class="flex items-start space-x-3">
                                    <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">
                                            {{ ucfirst($item['judul']) }}
                                        </h4>
                                        <p class="text-gray-600 text-sm">
                                            {{ $item['deskripsi'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 italic">Belum ada manfaat yang ditambahkan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-primary', 'text-primary');
                button.classList.add('border-transparent', 'text-gray-600');
            });

            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Add active class to selected tab button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.remove('border-transparent', 'text-gray-600');
            activeButton.classList.add('border-primary', 'text-primary');
        }

        function addToCart(ebookId) {
            // Implementasi tambah ke keranjang
            alert('Produk berhasil ditambahkan ke keranjang!');
            // Tambahkan logika AJAX untuk menambah ke keranjang
        }

        function buyNow(ebookId) {
            window.location.href = '/produk/checkout/' + ebookId;
        }
    </script>
@endsection
