@extends('layouts.app')

@section('content')
    {{-- ✅ Toast Notification --}}
    <div x-data="{ show: {{ session('toast') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="fixed top-5 left-1/2 -translate-x-1/2 z-50">
        @if (session('toast'))
            <div :class="{
                'bg-green-500': '{{ session('toast.type') }}'
                === 'success',
                'bg-yellow-500': '{{ session('toast.type') }}'
                === 'info',
                'bg-red-500': '{{ session('toast.type') }}'
                === 'error'
            }"
                class="text-white px-4 py-2 rounded-full text-sm font-medium shadow-md">
                {{ session('toast.message') }}
            </div>
        @endif
    </div>

    {{-- ✅ Main Container --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10" x-data="{ tab: 'all' }">
        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800">Riwayat Transaksi</h1>
            <p class="text-gray-500 mt-1 text-sm">Pantau status pembelian Anda</p>
        </div>

        {{-- ✅ Tabs Filter --}}
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            @php
                $tabs = [
                    ['key' => 'all', 'label' => 'Semua', 'color' => 'gray-600'],
                    ['key' => 'PAID', 'label' => 'Berhasil', 'color' => 'green-500'],
                    ['key' => 'UNPAID', 'label' => 'Menunggu Pembayaran', 'color' => 'yellow-500'],
                    ['key' => 'FAILED', 'label' => 'Gagal', 'color' => 'red-500'],
                    ['key' => 'EXPIRED', 'label' => 'Kadaluarsa', 'color' => 'red-400'],
                ];
            @endphp

            @foreach ($tabs as $t)
                <button type="button" @click="tab = '{{ $t['key'] }}'"
                    :class="tab === '{{ $t['key'] }}'
                        ?
                        'bg-{{ $t['color'] }} text-white' :
                        'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 focus:outline-none">
                    {{ $t['label'] }}
                </button>
            @endforeach
        </div>

        {{-- ✅ Transactions --}}
        @if ($transactions->isEmpty())
            <div class="text-center py-16">
                <div class="w-16 h-16 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Transaksi</h3>
                <p class="text-gray-500 text-sm mb-6">Mulai jelajahi kursus menarik dan lakukan pembelian pertama Anda.</p>

            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($transactions as $t)
                    @php
                        // Terjemahan status ke Bahasa Indonesia
                        $statusMap = [
                            'PAID' => 'Berhasil',
                            'UNPAID' => 'Menunggu Pembayaran',
                            'FAILED' => 'Gagal',
                            'EXPIRED' => 'Kadaluarsa',
                        ];
                        $statusLabel = $statusMap[$t->status] ?? $t->status;
                    @endphp

                    {{-- ✅ Munculkan sesuai tab yang aktif --}}
                    <div x-show="tab === 'all' || tab === '{{ $t->status }}'"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-gray-800 text-base truncate">{{ $t->judul }}</h3>
                            <span
                                class="text-xs font-semibold px-2 py-1 rounded-full
                                {{ $t->status === 'PAID'
                                    ? 'bg-green-100 text-green-700'
                                    : ($t->status === 'UNPAID'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : ($t->status === 'EXPIRED'
                                            ? 'bg-red-100 text-red-600'
                                            : 'bg-red-100 text-red-700')) }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-500 mb-1">
                            {{ \Carbon\Carbon::parse($t->created_at)->format('d M Y, H:i') }}
                        </p>

                        <p class="text-sm text-gray-600">Invoice:
                            <span class="font-mono text-gray-800">{{ $t->invoice_id }}</span>
                        </p>

                        <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-gray-500 text-sm">Total</span>
                            <span class="text-primary font-bold text-base">
                                Rp {{ number_format($t->amount, 0, ',', '.') }}
                            </span>
                        </div>

                        @if ($t->status === 'UNPAID')
                            @php
                                $tripay = json_decode($t->tripay_data, true);
                                $checkoutUrl = $tripay['checkout_url'] ?? null;
                            @endphp
                            @if ($checkoutUrl)
                                <a href="{{ $checkoutUrl }}" target="_blank"
                                    class="block mt-4 text-center w-full bg-primary text-white py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                    Lanjutkan Pembayaran
                                </a>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
