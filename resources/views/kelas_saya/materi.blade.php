@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-secondary to-blue-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <a href="{{ route('kelas.index') }}"
                    class="inline-flex items-center text-white hover:text-blue-100 mb-4 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Kelas Saya
                </a>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $produk->judul }}</h1>
                <div class="flex items-center gap-4 text-blue-100">
                    <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm">
                        {{ ucfirst($produk->tipe_produk) }}
                    </span>
                    <span><i class="fas fa-book-open mr-2"></i>{{ $materi->count() }} Materi</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-8 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content Area -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Video/PDF Viewer -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div id="content-viewer" class="w-full bg-black" style="min-height: 500px;">
                                <div class="flex items-center justify-center h-full text-white p-12 text-center">
                                    <div>
                                        <i class="fas fa-play-circle text-6xl mb-4 opacity-50"></i>
                                        <p class="text-lg">Pilih materi dari daftar untuk mulai belajar</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Materi Description -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Tentang Kelas</h2>
                            <div class="prose max-w-none text-gray-600">
                                {!! $produk->deskripsi !!}
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar - Daftar Materi -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-4">
                            <div class="bg-gradient-to-r from-secondary to-blue-600 text-white p-4">
                                <h3 class="font-bold text-lg">
                                    <i class="fas fa-list-ul mr-2"></i>Daftar Materi
                                </h3>
                            </div>

                            <div class="max-h-[600px] overflow-y-auto">
                                @if ($materi->isEmpty())
                                    <div class="p-6 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                        <p>Belum ada materi tersedia</p>
                                    </div>
                                @else
                                    <div class="divide-y">
                                        @foreach ($materi as $index => $item)
                                            <button
                                                onclick="loadMateri(
            {{ $item->id }},
            '{{ $item->jenis_materi }}',
            '{{ $item->deskripsi }}',
            '{{ $item->file_path }}',
            {{ $index + 1 }}
        )"
                                                class="materi-item w-full text-left p-4 hover:bg-blue-50 transition-colors duration-200 flex items-start gap-3"
                                                data-materi-id="{{ $item->id }}">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br {{ $item->jenis_materi == 'video' ? 'from-red-500 to-pink-500' : 'from-blue-500 to-purple-500' }} flex items-center justify-center text-white">
                                                    <i
                                                        class="fas {{ $item->jenis_materi == 'video' ? 'fa-play' : 'fa-file-pdf' }}"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-xs font-semibold text-gray-500">Materi
                                                            {{ $index + 1 }}</span>
                                                        <span
                                                            class="px-2 py-0.5 text-xs rounded-full {{ $item->jenis_materi == 'video' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                                            {{ strtoupper($item->jenis_materi) }}
                                                        </span>
                                                    </div>
                                                    <p class="text-sm font-medium text-gray-800 line-clamp-2">
                                                        {{ $item->deskripsi }}
                                                    </p>
                                                </div>
                                            </button>
                                        @endforeach

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .materi-item.active {
            background-color: #dbeafe;
            border-left: 4px solid #0977c2;
        }

        .prose {
            line-height: 1.75;
        }

        /* Custom scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* PDF Viewer Container */
        #pdf-viewer {
            width: 100%;
            height: 100%;
            min-height: 500px;
        }

        /* Video Player */
        video {
            width: 100%;
            height: auto;
            max-height: 500px;
            outline: none;
        }

        /* Disable right click on video */
        video::-webkit-media-controls-panel {
            display: flex !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        let currentMateriId = null;

        function loadMateri(materiId, jenisMateri, deskripsi, filePath, nomor) {
            // Reset active state
            document.querySelectorAll('.materi-item').forEach(item => item.classList.remove('active'));
            document.querySelector(`[data-materi-id="${materiId}"]`).classList.add('active');

            const viewer = document.getElementById('content-viewer');
            currentMateriId = materiId;

            if (jenisMateri === 'video') {
                loadVideo(filePath, viewer);
            } else if (jenisMateri === 'pdf') {
                loadPDF(filePath, viewer);
            }
        }

        function loadVideo(filePath, container) {
            const videoHTML = `
            <video
                id="video-player"
                controls
                controlsList="nodownload"
                oncontextmenu="return false;"
                class="w-full bg-black"
                style="max-height: 500px;">
                <source src="{{ asset('storage') }}/${filePath}" type="video/mp4">
                Browser Anda tidak mendukung video player.
            </video>
        `;
            container.innerHTML = videoHTML;
        }

        function loadPDF(filePath, container) {
            const pdfURL = `{{ asset('storage') }}/${filePath}`;
            container.innerHTML = `
            <iframe
                src="${pdfURL}#toolbar=0&navpanes=0&scrollbar=1"
                id="pdf-viewer"
                style="width: 100%; height: 500px; border: none;">
            </iframe>
        `;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const firstMateri = document.querySelector('.materi-item');
            if (firstMateri) firstMateri.click();
        });
    </script>
@endpush
