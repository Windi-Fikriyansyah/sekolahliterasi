@extends('layouts.app')
@section('title', 'Pembayaran Program Sekolah')

@push('style')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@section('content')
    <div x-data="{ openModal: null }" class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
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
                                    <th class="py-3 px-4 text-left font-semibold">#</th>
                                    <th class="py-3 px-4 text-left font-semibold">Nama Program</th>
                                    <th class="py-3 px-4 text-left font-semibold">Jenis Program</th>
                                    <th class="py-3 px-4 text-left font-semibold">Tanggal Pendaftaran</th>
                                    <th class="py-3 px-4 text-left font-semibold">Status</th>
                                    <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($programs as $program)
                                    <tr class="border-t hover:bg-gray-50 transition">
                                        <td class="py-3 px-4">{{ $no++ }}</td>
                                        <td class="py-3 px-4 font-semibold text-gray-900">{{ $program->judul }}</td>
                                        <td class="py-3 px-4 capitalize text-gray-700">{{ $program->jenis_program }}</td>
                                        <td class="py-3 px-4 text-gray-700">
                                            {{ \Carbon\Carbon::parse($program->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $status = strtolower($program->status_pendaftaran);
                                                $color = match ($status) {
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
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                @if ($program->status_pendaftaran === 'pending')
                                                    <a href="{{ route('payment.index', Crypt::encrypt($program->product_id)) }}"
                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs font-medium transition">
                                                        <i class="fa-solid fa-wallet mr-1"></i> Bayar
                                                    </a>
                                                @endif
                                                <button @click="openModal = {{ $program->product_id }}"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-xs font-medium transition">
                                                    <i class="fa-solid fa-file-pdf mr-1"></i> Surat
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Modal Section --}}
                @foreach ($programs as $program)
                    <div x-show="openModal === {{ $program->product_id }}" x-transition
                        class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm" x-cloak>
                        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
                            <div class="flex justify-between items-center bg-blue-600 text-white px-5 py-3 rounded-t-xl">
                                <h2 class="font-semibold text-lg">File Surat - {{ $program->judul }}</h2>
                                <button @click="openModal = null"
                                    class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
                            </div>
                            <div class="p-5 max-h-[60vh] overflow-y-auto">
                                @if ($program->files->isEmpty())
                                    <p class="text-center text-gray-500">Tidak ada file surat tersedia.</p>
                                @else
                                    <ul class="divide-y divide-gray-200">
                                        @foreach ($program->files as $file)
                                            <li class="py-3 flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <i class="fa-solid fa-file-pdf text-red-500 mr-2"></i>
                                                    <span class="text-gray-800 font-medium">{{ $file->judul }}</span>
                                                </div>
                                                <a href="{{ Storage::url($file->file_path) }}" download
                                                    class="text-sm bg-secondary hover:bg-primary text-white px-3 py-1 rounded-lg transition">
                                                    <i class="fa-solid fa-download mr-1"></i> Unduh
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="flex justify-end px-5 py-3 border-t">
                                <button @click="openModal = null"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
