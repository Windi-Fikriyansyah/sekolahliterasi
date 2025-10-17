@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-6xl">
            <h1 class="text-2xl font-bold text-secondary mb-6">Pesanan Saya</h1>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @elseif (session('warning'))
                <div class="bg-yellow-100 text-yellow-700 px-4 py-3 rounded mb-4">
                    {{ session('warning') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($orders->isEmpty())
                <p class="text-gray-500 text-center py-8">Belum ada pesanan.</p>
            @else
                <div class="space-y-6">
                    @foreach ($orders as $order)
                        <div class="bg-white shadow rounded-lg p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">#{{ $order->invoice_id }}</h2>
                                <span
                                    class="text-sm px-3 py-1 rounded-full
                                @if ($order->status_pengiriman === 'Menunggu Pembayaran') bg-gray-200 text-gray-700
                                @elseif($order->status_pengiriman === 'Diproses') bg-yellow-100 text-yellow-700
                                @elseif($order->status_pengiriman === 'Dikirim') bg-blue-100 text-blue-700
                                @elseif($order->status_pengiriman === 'Selesai') bg-green-100 text-green-700 @endif">
                                    {{ $order->status_pengiriman }}
                                </span>
                            </div>

                            <div class="text-sm text-gray-600 mb-3">
                                <p><strong>Tanggal:</strong>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</p>
                                <p><strong>Total:</strong> Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="flex items-center space-x-4 mt-4">
                                @php
                                    $steps = ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai'];
                                    $currentStep = array_search($order->status_pengiriman, $steps);
                                @endphp
                                @foreach ($steps as $index => $step)
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 flex items-center justify-center rounded-full text-xs font-bold
                                        @if ($index <= $currentStep) bg-secondary text-white @else bg-gray-200 text-gray-500 @endif">
                                            {{ $index + 1 }}
                                        </div>
                                        <div
                                            class="ml-2 text-sm @if ($index <= $currentStep) text-secondary font-semibold @else text-gray-400 @endif">
                                            {{ $step }}
                                        </div>
                                        @if ($index < count($steps) - 1)
                                            <div
                                                class="w-10 h-1 mx-2 @if ($index < $currentStep) bg-secondary @else bg-gray-200 @endif">
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Tombol Konfirmasi --}}
                            @if ($order->status_pengiriman === 'Dikirim')
                                <form action="{{ route('pesanan_saya.confirm', $order->id) }}" method="POST"
                                    class="mt-6">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        Konfirmasi Terima Barang
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
