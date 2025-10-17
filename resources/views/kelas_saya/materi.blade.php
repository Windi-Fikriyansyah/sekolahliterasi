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
            <div class="max-w-7xl mx-auto">
                <div class="flex gap-6 relative">
                    <!-- Main Content Area -->
                    <div id="content-area" class="flex-1 transition-all duration-300">
                        <!-- Video/PDF Viewer -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative">
                            <!-- Tombol tampilkan sidebar untuk desktop - Dipindah ke sini -->
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

                    <!-- Sidebar - Daftar Materi -->
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
                                    <!-- Toggle Button for Desktop -->
                                    <button id="toggle-sidebar-desktop" onclick="toggleSidebarDesktop()"
                                        class="hidden lg:flex text-white hover:text-gray-200 p-1 rounded transition">
                                        <i class="fas fa-chevron-right" id="desktop-toggle-icon"></i>
                                    </button>
                                    <!-- Close Button for Mobile -->
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

                    <!-- Overlay for mobile -->
                    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"
                        onclick="toggleSidebar()">
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

        /* PDF Protection Layer */
        .pdf-protection {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
            background: transparent;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        /* PDF Viewer */
        #pdf-viewer {
            width: 100%;
            height: 100%;
            border: none;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Video Player */
        video {
            width: 100%;
            height: 100%;
            outline: none;
            object-fit: contain;
        }

        /* Sidebar Animation */
        #sidebar-materi.sidebar-hidden-desktop {
            width: 0 !important;
            opacity: 0;
            overflow: hidden;
            margin-right: 0;
            padding: 0;
        }

        #content-area.expanded {
            width: 100%;
            margin-right: 0;
        }

        @media (min-width: 1024px) {
            #sidebar-materi {
                transition: all 0.3s ease;
            }

            #content-area {
                transition: all 0.3s ease;
            }
        }

        /* Loading Spinner */
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
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Show Sidebar Button */
        #show-sidebar-desktop {
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        #show-sidebar-desktop:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        #show-sidebar-desktop.sidebar-visible {
            opacity: 0;
            pointer-events: none;
            transform: scale(0.8) translateX(20px);
        }

        /* Untuk mobile sidebar */
        #sidebar-materi.translate-x-full {
            transform: translateX(100%);
        }

        /* Pastikan sidebar mobile di atas konten */
        @media (max-width: 1023px) {
            #sidebar-materi {
                z-index: 40;
            }
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let desktopSidebarVisible = true;

            window.toggleSidebarDesktop = function() {
                desktopSidebarVisible = !desktopSidebarVisible;
                const sidebar = document.getElementById('sidebar-materi');
                const contentArea = document.getElementById('content-area');
                const showSidebarBtn = document.getElementById('show-sidebar-desktop');
                const desktopToggleIcon = document.getElementById('desktop-toggle-icon');

                if (!sidebar || !contentArea || !showSidebarBtn) {
                    console.error('Required elements not found');
                    return;
                }

                if (desktopSidebarVisible) {
                    // Tampilkan sidebar
                    sidebar.classList.remove('sidebar-hidden-desktop');
                    contentArea.classList.remove('expanded');
                    showSidebarBtn.classList.add('sidebar-visible');

                    // Update icon di header sidebar
                    if (desktopToggleIcon) {
                        desktopToggleIcon.classList.remove('fa-chevron-left');
                        desktopToggleIcon.classList.add('fa-chevron-right');
                    }
                } else {
                    // Sembunyikan sidebar
                    sidebar.classList.add('sidebar-hidden-desktop');
                    contentArea.classList.add('expanded');
                    showSidebarBtn.classList.remove('sidebar-visible');

                    // Update icon di header sidebar
                    if (desktopToggleIcon) {
                        desktopToggleIcon.classList.remove('fa-chevron-right');
                        desktopToggleIcon.classList.add('fa-chevron-left');
                    }
                }
            };

            // Fungsi toggle sidebar mobile
            window.toggleSidebar = function() {
                const sidebar = document.getElementById('sidebar-materi');
                const overlay = document.getElementById('sidebar-overlay');

                sidebar.classList.toggle('translate-x-full');
                overlay.classList.toggle('hidden');
            };

            // Fungsi load materi (video/pdf)
            window.loadMateri = function(materiId, jenisMateri, deskripsi, filePath, nomor) {
                document.querySelectorAll('.materi-item').forEach(item => item.classList.remove('active'));
                document.querySelector(`[data-materi-id="${materiId}"]`).classList.add('active');

                const viewer = document.getElementById('content-viewer');
                viewer.innerHTML = `
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <div class="loading-spinner mx-auto mb-4"></div>
                            <p class="text-white">Memuat konten...</p>
                        </div>
                    </div>
                `;

                if (jenisMateri === 'video') {
                    loadVideo(filePath, viewer);
                } else if (jenisMateri === 'pdf') {
                    loadPDF(filePath, viewer);
                }

                // Auto-close mobile sidebar after selection
                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }
            };

            function loadVideo(filePath, container) {
                const videoHTML = `
                    <video controls controlsList="nodownload" oncontextmenu="return false;"
                        class="w-full h-full bg-black">
                        <source src="{{ asset('storage') }}/${filePath}" type="video/mp4">
                        Browser Anda tidak mendukung video player.
                    </video>`;
                container.innerHTML = videoHTML;
            }

            function loadPDF(filePath, container) {
                const pdfURL = `{{ asset('storage') }}/${filePath}`;
                container.innerHTML = `
                    <div class="relative w-full h-full">
                        <iframe
                            src="${pdfURL}#toolbar=0&navpanes=0&scrollbar=1&view=FitH&zoom=page-fit"
                            id="pdf-viewer"
                            loading="lazy"
                            class="w-full h-full"
                            onload="protectPDF()">
                        </iframe>
                        <div class="pdf-protection"
                            oncontextmenu="return false;"
                            onselectstart="return false;"
                            ondragstart="return false;">
                        </div>
                    </div>`;
            }

            window.protectPDF = function() {
                const iframe = document.getElementById('pdf-viewer');
                if (iframe && iframe.contentWindow) {
                    try {
                        iframe.contentWindow.document.addEventListener('contextmenu', e => e.preventDefault());
                        iframe.contentWindow.document.addEventListener('selectstart', e => e.preventDefault());
                        iframe.contentWindow.document.addEventListener('copy', e => e.preventDefault());
                    } catch (e) {
                        console.log('Cannot access iframe content due to CORS');
                    }
                }
            };

            // Nonaktifkan copy / klik kanan di viewer
            const viewer = document.getElementById('content-viewer');
            viewer.addEventListener('contextmenu', e => e.preventDefault());
            viewer.addEventListener('selectstart', e => e.preventDefault());
            viewer.addEventListener('copy', e => e.preventDefault());

            // Auto-load materi pertama
            const firstMateri = document.querySelector('.materi-item');
            if (firstMateri) firstMateri.click();
        });
    </script>
@endpush
