@extends('layouts.app')
@section('title', 'Pembayaran Program Sekolah')

@section('content')
    <div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-secondary mb-6 text-center">
                Daftar Pendaftaran Belum Melakukan Pembayaran
            </h1>

            @if ($programs->isEmpty())
                <div class="bg-white p-6 sm:p-8 rounded-xl shadow-md text-center">
                    <i class="fa-solid fa-circle-info text-3xl sm:text-4xl text-yellow-500 mb-3"></i>
                    <p class="text-gray-600 text-base sm:text-lg">
                        Belum ada data pendaftaran program sekolah yang belum dibayar.
                    </p>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm border border-gray-200">
                            <thead class="bg-gradient-to-r from-primary to-secondary text-white">
                                <tr>
                                    <th class="py-3 px-4 text-left font-semibold whitespace-nowrap">#</th>
                                    <th class="py-3 px-4 text-left font-semibold whitespace-nowrap">Nama Program</th>
                                    <th class="py-3 px-4 text-left font-semibold whitespace-nowrap">Jenis Program</th>
                                    <th class="py-3 px-4 text-left font-semibold whitespace-nowrap">Tanggal Pendaftaran</th>
                                    <th class="py-3 px-4 text-left font-semibold whitespace-nowrap min-w-[130px]">Status
                                    </th>
                                    <th class="py-3 px-4 text-center font-semibold whitespace-nowrap min-w-[180px]">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($programs as $program)
                                    <tr class="border-t hover:bg-gray-50 transition">
                                        <td class="py-3 px-4 whitespace-nowrap">{{ $no++ }}</td>
                                        <td class="py-3 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                            {{ $program->judul }}</td>
                                        <td class="py-3 px-4 capitalize text-gray-700 whitespace-nowrap">
                                            {{ $program->jenis_program }}</td>
                                        <td class="py-3 px-4 text-gray-700 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($program->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            @php
                                                $status = strtolower($program->status_pendaftaran);
                                                $badgeClass = match ($status) {
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'paid' => 'bg-green-100 text-green-700',
                                                    'expired' => 'bg-red-100 text-red-700',
                                                    default => 'bg-gray-100 text-gray-600',
                                                };
                                                $label = match ($status) {
                                                    'pending' => 'Belum Bayar',
                                                    'paid' => 'Lunas',
                                                    'expired' => 'Kadaluarsa',
                                                    default => ucfirst($status),
                                                };
                                            @endphp
                                            <span
                                                class="px-3 py-1 rounded-full text-xs sm:text-sm font-semibold {{ $badgeClass }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center whitespace-nowrap">
                                            <div class="flex justify-center items-center gap-2 flex-wrap sm:flex-nowrap">
                                                @if ($program->status_pendaftaran === 'pending')
                                                    <a href="{{ route('payment.index', Crypt::encrypt($program->product_id)) }}"
                                                        class="bg-yellow-500 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-yellow-600 transition-all duration-300 whitespace-nowrap">
                                                        <i class="fa-solid fa-wallet mr-1"></i> Bayar
                                                    </a>
                                                @endif
                                                <a href=""
                                                    class="bg-blue-500 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-600 transition-all duration-300 whitespace-nowrap">
                                                    <i class="fa-solid fa-file-pdf mr-1"></i> Surat
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
