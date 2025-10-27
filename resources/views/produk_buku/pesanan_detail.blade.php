@extends('layouts.app')
@section('title', 'Detail Buku')


@section('content')
    <main class="flex-grow container mx-auto px-4 py-8 md:py-12 bg-background-light dark:bg-gray-900 text-base">
        <div class="max-w-5xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2 text-gray-500 dark:text-gray-400">
                    <li><a class="hover:text-primary transition" href="{{ route('home') }}">Beranda</a></li>
                    <li><span class="mx-1">/</span></li>
                    <li>
                        <span class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $bukus->judul ?? 'Detail Buku' }}
                        </span>
                    </li>
                </ol>
            </nav>

            <!-- Detail Buku -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 md:p-8">

                <!-- Gambar Buku -->
                <div class="w-2/3 md:w-3/4 mx-auto rounded-lg overflow-hidden shadow-md">
                    <img src="{{ asset('storage/' . $bukus->thumbnail) }}" alt="Sampul Buku {{ $bukus->judul }}"
                        class="w-full h-auto object-contain rounded-md transition-transform duration-500 hover:scale-105">
                </div>

                <!-- Info Buku -->
                <div class="flex flex-col gap-4 text-[15px] leading-relaxed">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white leading-snug">
                        {{ $bukus->judul }}
                    </h1>

                    <div class="text-xl font-bold text-primary">
                        Rp {{ number_format($bukus->harga ?? 0, 0, ',', '.') }}
                    </div>

                    <!-- Deskripsi -->
                    <div
                        class="prose prose-base dark:prose-invert text-gray-700 dark:text-gray-300 max-h-56 overflow-y-auto">
                        {!! $bukus->deskripsi ?? '<p>Belum ada deskripsi untuk buku ini.</p>' !!}
                    </div>

                    <!-- Detail Tambahan -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-3">
                        <h3 class="text-base font-semibold mb-3 text-gray-900 dark:text-gray-100">Detail Buku</h3>

                        <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-gray-700 dark:text-gray-300 text-sm">

                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Penulis</p>
                                <p>{{ $bukus->penulis ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">ISBN</p>
                                <p>{{ $bukus->isbn ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Penerbit</p>
                                <p>{{ $bukus->penerbit ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Tanggal Terbit</p>
                                <p>{{ $bukus->tanggal_terbit ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Jumlah Halaman</p>
                                <p>{{ $bukus->jumlah_halaman ? $bukus->jumlah_halaman . ' hlm' : '-' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Berat</p>
                                <p>{{ $bukus->berat ? $bukus->berat . ' gram' : '-' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Jenis Cover</p>
                                <p>{{ $bukus->jenis_cover ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Dimensi</p>
                                <p>{{ $bukus->dimensi ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Bahasa</p>
                                <p>{{ $bukus->bahasa ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 dark:text-gray-400">Stok</p>
                                <p>{{ $bukus->stok ?? 0 }}</p>
                            </div>


                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-5">
                        <button onclick="addToCart({{ $bukus->id }}, '{{ addslashes($bukus->judul) }}')"
                            class="w-full bg-primary text-white font-semibold py-3 px-5 rounded-md shadow-md text-sm hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-200">
                            <i class="fa-solid fa-cart-plus mr-2"></i> Tambahkan ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
