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
            <div class="max-w-7xl mx-auto flex gap-6 relative">

                <!-- Konten Utama -->
                <div id="content-area" class="flex-1 transition-all duration-300">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden relative">
                        <button id="show-sidebar-desktop"
                            class="absolute top-4 right-4 z-50 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 hidden lg:block"
                            onclick="toggleSidebarDesktop()">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div id="content-viewer" class="w-full bg-black relative"
                            style="height: calc(100vh - 250px); min-height: 600px;">
                            <div class="flex items-center justify-center h-full text-white p-12 text-center">
                                <div>
                                    <i class="fas fa-play-circle text-6xl mb-4 opacity-50"></i>
                                    <p class="text-lg">Pilih materi dari daftar untuk mulai belajar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Materi -->
                <div id="sidebar-materi"
                    class="w-80 transition-all duration-300 lg:relative fixed right-0 top-0 h-full lg:h-auto z-40 transform lg:transform-none lg:translate-x-0"
                    style="box-shadow: -4px 0 6px rgba(0,0,0,0.1);">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full lg:sticky lg:top-4">
                        <div
                            class="bg-gradient-to-r from-secondary to-blue-600 text-white p-4 flex justify-between items-center">
                            <h3 class="font-bold text-lg">
                                <i class="fas fa-list-ul mr-2"></i>Daftar Materi
                            </h3>
                            <div class="flex items-center gap-2">
                                <button id="toggle-sidebar-desktop" onclick="toggleSidebarDesktop()"
                                    class="hidden lg:flex text-white hover:text-gray-200 p-1 rounded transition">
                                    <i class="fas fa-chevron-right" id="desktop-toggle-icon"></i>
                                </button>
                                <button onclick="toggleSidebar()" class="lg:hidden text-white hover:text-gray-200">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="overflow-y-auto" style="max-height: calc(100vh - 200px);">
                            @if ($materi->isEmpty())
                                <div class="p-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                    <p>Belum ada materi tersedia</p>
                                </div>
                            @else
                                <div class="divide-y">
                                    @foreach ($materi as $index => $item)
                                        <button
                                            onclick="loadMateri('{{ $item->jenis_materi }}', '{{ $item->file_path }}', {{ $item->id }})"
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
                                                    {{ $item->deskripsi }}</p>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Overlay Mobile -->
                <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"
                    onclick="toggleSidebar()"></div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .line-clamp-2 {
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            display: -webkit-box;
        }

        .materi-item.active {
            background-color: #dbeafe;
            border-left: 4px solid #0977c2;
        }

        #sidebar-materi.sidebar-hidden-desktop {
            width: 0 !important;
            opacity: 0;
            overflow: hidden;
        }

        #content-area.expanded {
            width: 100%;
            margin-right: 0;
        }

        #show-sidebar-desktop.visible {
            display: block;
        }

        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0977c2;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0)
            }

            100% {
                transform: rotate(360deg)
            }
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById('sidebar-materi');
            const contentArea = document.getElementById('content-area');
            const showSidebarBtn = document.getElementById('show-sidebar-desktop');
            let sidebarVisible = true;

            window.toggleSidebarDesktop = function() {
                sidebarVisible = !sidebarVisible;
                if (sidebarVisible) {
                    sidebar.classList.remove('sidebar-hidden-desktop');
                    contentArea.classList.remove('expanded');
                    showSidebarBtn.classList.remove('visible');
                } else {
                    sidebar.classList.add('sidebar-hidden-desktop');
                    contentArea.classList.add('expanded');
                    showSidebarBtn.classList.add('visible');
                }
            };

            window.toggleSidebar = function() {
                const overlay = document.getElementById('sidebar-overlay');
                sidebar.classList.toggle('translate-x-full');
                overlay.classList.toggle('hidden');
            };

            window.loadMateri = function(jenis, filePath, id) {
                document.querySelectorAll('.materi-item').forEach(el => el.classList.remove('active'));
                document.querySelector(`[data-materi-id="${id}"]`).classList.add('active');

                const viewer = document.getElementById('content-viewer');
                viewer.innerHTML = `
            <div class='flex justify-center items-center h-full'>
                <div class='text-center text-white'>
                    <div class='loading-spinner mx-auto mb-4'></div>
                    <p>Memuat konten...</p>
                </div>
            </div>`;

                if (jenis === 'video') {
                    viewer.innerHTML = `
                <video controls controlsList="nodownload" oncontextmenu="return false;" class="w-full h-full bg-black" preload="auto">
                    <source src="{{ asset('storage') }}/${filePath}" type="video/mp4">
                    Browser Anda tidak mendukung video player.
                </video>`;
                } else {
                    loadPDF(`{{ asset('storage') }}/${filePath}`, viewer);
                }

                if (window.innerWidth < 1024) toggleSidebar();
            };

            function loadPDF(url, container) {
                container.innerHTML =
                    `<div id="pdf-container" class="overflow-y-auto w-full h-full bg-gray-100 p-4"></div>`;
                const pdfContainer = container.querySelector('#pdf-container');
                pdfjsLib.GlobalWorkerOptions.workerSrc =
                    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js";

                pdfjsLib.getDocument(url).promise.then(pdf => {
                    pdfContainer.innerHTML = "";
                    const baseScale = window.innerWidth < 768 ? 1.0 : 1.2;

                    for (let i = 1; i <= pdf.numPages; i++) {
                        pdf.getPage(i).then(page => {
                            const viewport = page.getViewport({
                                scale: baseScale
                            });
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            const ratio = window.devicePixelRatio || 1;

                            canvas.width = viewport.width * ratio;
                            canvas.height = viewport.height * ratio;
                            ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
                            canvas.style.width = '100%';
                            canvas.style.height = 'auto';
                            canvas.classList.add('mx-auto', 'block', 'rounded', 'shadow-sm',
                                'mb-4');

                            pdfContainer.appendChild(canvas);
                            page.render({
                                canvasContext: ctx,
                                viewport
                            });
                        });
                    }
                }).catch(() => {
                    container.innerHTML = `
                <div class="flex items-center justify-center h-full text-white">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                        <p>Gagal memuat PDF</p>
                    </div>
                </div>`;
                });
            }

            // Proteksi klik kanan dan copy
            document.getElementById('content-viewer').addEventListener('contextmenu', e => e.preventDefault());
        });
    </script>
@endpush
