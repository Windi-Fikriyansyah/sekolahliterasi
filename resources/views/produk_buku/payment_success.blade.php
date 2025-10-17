@extends('layouts.app')
@section('title', 'Status Pembayaran')

@section('content')
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-4xl">
            {{-- ✅ Judul --}}
            <div class="text-center mb-8">
                @if ($trx->status === 'PAID' || $trx->status === 'paid')
                    <div
                        class="mx-auto w-20 h-20 bg-green-100 text-green-600 flex items-center justify-center rounded-full mb-4">
                        <i class="fas fa-check-circle text-5xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-green-600 mb-2">Pembayaran Berhasil</h1>
                    <p class="text-gray-600">Terima kasih! Pesanan Anda sedang diproses.</p>
                @elseif ($trx->status === 'UNPAID' || $trx->status === 'pending')
                    <div
                        class="mx-auto w-20 h-20 bg-yellow-100 text-yellow-600 flex items-center justify-center rounded-full mb-4">
                        <i class="fas fa-clock text-5xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-yellow-600 mb-2">Menunggu Pembayaran</h1>
                    <p class="text-gray-600">Silakan selesaikan pembayaran Anda sebelum waktu berakhir.</p>
                @else
                    <div
                        class="mx-auto w-20 h-20 bg-red-100 text-red-600 flex items-center justify-center rounded-full mb-4">
                        <i class="fas fa-times-circle text-5xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-red-600 mb-2">Pembayaran Gagal</h1>
                    <p class="text-gray-600">Silakan coba lagi atau hubungi admin.</p>
                @endif
            </div>

            {{-- ✅ Detail Transaksi --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-receipt text-primary mr-2"></i> Detail Transaksi
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 text-sm">
                    <p><strong>ID Transaksi:</strong> {{ $trx->invoice_id }}</p>
                    <p><strong>Status:</strong>
                        <span
                            class="px-3 py-1 rounded-full text-white text-xs
                            {{ $trx->status === 'PAID' || $trx->status === 'paid' ? 'bg-green-500' : ($trx->status === 'UNPAID' || $trx->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                            {{ strtoupper($trx->status) }}
                        </span>
                    </p>
                    <p><strong>Metode Pembayaran:</strong> {{ $trx->payment_channel ?? '-' }}</p>
                    <p><strong>Kurir:</strong> {{ $trx->kurir ?? '-' }}</p>
                    <p><strong>Total Pembayaran:</strong> Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y H:i') }}</p>
                </div>
            </div>

            {{-- ✅ Detail Pengiriman --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt text-primary mr-2"></i> Alamat Pengiriman
                </h2>

                <div class="text-sm text-gray-700 leading-relaxed">
                    <p><strong>Nama Penerima:</strong> {{ $trx->nama_penerima }}</p>
                    <p><strong>No. Telepon:</strong> {{ $trx->telepon_penerima }}</p>
                    <p><strong>Alamat:</strong> {{ $trx->alamat_lengkap }}</p>
                    <p><strong>Kecamatan:</strong> {{ $trx->kecamatan }}</p>
                    <p><strong>Kota:</strong> {{ $trx->kota }}</p>
                    <p><strong>Provinsi:</strong> {{ $trx->provinsi }}</p>
                </div>
            </div>

            {{-- ✅ Daftar Item --}}
            @php
                $items = DB::table('transaksi_items')
                    ->join('products', 'transaksi_items.product_id', '=', 'products.id')
                    ->select('transaksi_items.*', 'products.thumbnail')
                    ->where('transaksi_items.transaksi_id', $trx->id)
                    ->get();
            @endphp

            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-box-open text-primary mr-2"></i> Detail Produk
                </h2>

                <div class="divide-y divide-gray-100">


                    @foreach ($items as $item)
                        <div class="py-4 flex items-start gap-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/' . ($item->thumbnail ?? 'default.jpg')) }}" alt="produk"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 text-sm">{{ $item->nama_produk }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->jumlah }}</p>
                                <p class="text-sm text-primary font-bold mt-1">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                                @if ($item->catatan)
                                    <p class="text-xs text-gray-600 italic mt-1">
                                        <i class="fas fa-sticky-note mr-1 text-gray-400"></i> Catatan: {{ $item->catatan }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ✅ Tombol Aksi --}}
            <div class="text-center">
                @if ($trx->status === 'UNPAID' || $trx->status === 'pending')
                    <a href="{{ json_decode($trx->tripay_data)->checkout_url ?? '#' }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg inline-block transition-all duration-300">
                        <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                    </a>
                @endif

                <a href="{{ route('pesanan_saya.index') }}"
                    class="ml-3 bg-secondary hover:bg-primary text-white font-semibold py-3 px-6 rounded-lg inline-block transition-all duration-300">
                    <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>
@endsection
