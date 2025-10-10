@extends('layouts.app')

@section('title', $produk->judul)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Notifikasi dengan desain modern --}}
            @foreach (['success', 'error', 'info'] as $msg)
                @if (session($msg))
                    @php
                        $configs = [
                            'success' => ['bg' => 'emerald', 'icon' => '✓'],
                            'error' => ['bg' => 'rose', 'icon' => '✕'],
                            'info' => ['bg' => 'blue', 'icon' => 'ℹ'],
                        ];
                        $config = $configs[$msg];
                    @endphp
                    <div
                        class="notification-alert bg-{{ $config['bg'] }}-50 border border-{{ $config['bg'] }}-200 rounded-xl p-4 mb-6 shadow-sm">
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-{{ $config['bg'] }}-500 text-white rounded-full flex items-center justify-center font-semibold">
                                {{ $config['icon'] }}
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-{{ $config['bg'] }}-800 font-medium">{{ session($msg) }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            {{-- Main Content Card --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden animate-fade-in">

                {{-- Header Section dengan gradient accent --}}
                <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-10 sm:px-12">
                    <div class="absolute inset-0 bg-black opacity-5"></div>
                    <div class="relative">
                        @php

                            $labelTipe = match ($produk->tipe_produk) {
                                'ebook' => 'E-Book',
                                'buku' => 'Buku',
                                'kelas_video' => 'Kelas Video',
                                'program' => 'Program',
                                default => ucfirst($produk->tipe_produk),
                            };
                        @endphp

                        <div
                            class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium mb-3 tracking-wide">
                            {{ $labelTipe }}
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-semibold text-white mb-2 leading-snug">
                            {{ $produk->judul }}
                        </h1>
                    </div>
                </div>

                {{-- Content Body --}}
                <div class="px-8 py-10 sm:px-12">

                    {{-- Deskripsi Section --}}
                    <section class="mb-10">
                        <div class="flex items-center mb-3">
                            <div class="w-1 h-5 bg-blue-600 rounded-full mr-3"></div>
                            <h3 class="text-base font-semibold text-gray-900 tracking-wide">DESKRIPSI KURSUS</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-base">
                            {!! $produk->deskripsi !!}
                        </p>
                    </section>

                    {{-- Divider --}}
                    <div class="border-t border-gray-200 my-8"></div>

                    {{-- Pricing & Action Section --}}
                    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8 border border-gray-200">
                        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">

                            {{-- Price Section --}}
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Investasi Anda
                                </p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-semibold text-gray-900">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-gray-500 text-sm">/kursus</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1.5">
                                    Akses seumur hidup ke semua materi
                                </p>
                            </div>

                            {{-- CTA Button --}}
                            <div class="w-full lg:w-auto">
                                @php
                                    $user = auth()->user();
                                    $hasAccess = DB::table('enrollments')
                                        ->where('user_id', $user->id)
                                        ->where('product_id', $produk->id)
                                        ->exists();
                                @endphp

                                @if ($hasAccess)
                                    <a href="{{ route('kelas.index') }}" class="btn-primary btn-success">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                        Masuk ke Kursus
                                    </a>
                                @else
                                    <a href="{{ route('payment.index', Crypt::encryptString($produk->id)) }}"
                                        class="btn-primary btn-purchase">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        Beli Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Trust Badges --}}
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div
                                class="flex flex-wrap items-center justify-center lg:justify-start gap-6 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Akses Selamanya</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Sertifikat Resmi</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Gratis Update</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .notification-alert {
            animation: slideIn 0.5s ease-out;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 1.75rem;
            border-radius: 0.875rem;
            font-weight: 600;
            font-size: 0.9375rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            min-width: 180px;
            text-align: center;
            letter-spacing: 0.01em;
        }

        .btn-purchase {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .btn-purchase:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3), 0 4px 6px -2px rgba(37, 99, 235, 0.2);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3), 0 4px 6px -2px rgba(5, 150, 105, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }
    </style>
@endpush
