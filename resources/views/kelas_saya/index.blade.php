@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-secondary to-blue-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Kelas Saya</h1>
                <p class="text-lg md:text-xl text-blue-100">Kelola dan akses semua pembelajaran yang telah Anda beli</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @if ($produk->isEmpty())
                <!-- Empty State -->
                <div class="max-w-2xl mx-auto text-center py-16 animate-fade-in-up">
                    <div class="bg-white rounded-2xl shadow-lg p-12">
                        <i class="fas fa-shopping-bag text-gray-300 text-6xl mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Pembelian</h3>
                        <p class="text-gray-600 mb-8">Anda belum memiliki kelas, ebook, atau program. Mulai belajar
                            sekarang!</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('kelasvideo') }}"
                                class="px-6 py-3 bg-secondary text-white rounded-lg hover:bg-opacity-90 transition shine-effect">
                                <i class="fas fa-video mr-2"></i>Lihat Kelas Video
                            </a>
                            <a href="{{ route('ebook') }}"
                                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition shine-effect">
                                <i class="fas fa-book mr-2"></i>Lihat E-Book
                            </a>
                            <a href="{{ route('program') }}"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-opacity-90 transition shine-effect">
                                <i class="fas fa-graduation-cap mr-2"></i>Lihat Program
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Filter Tabs -->
                <div class="max-w-6xl mx-auto mb-8 animate-fade-in-up">
                    <div class="bg-white rounded-lg shadow-md p-2 flex flex-wrap gap-2">
                        <button onclick="filterContent('semua')"
                            class="filter-btn active px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-th-large mr-2"></i>Semua ({{ $produk->count() }})
                        </button>
                        <button onclick="filterContent('program')"
                            class="filter-btn px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-graduation-cap mr-2"></i>Program ({{ $programs->count() }})
                        </button>
                        <button onclick="filterContent('kelas_video')"
                            class="filter-btn px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-video mr-2"></i>Kelas Video ({{ $kelas->count() }})
                        </button>
                        <button onclick="filterContent('ebook')"
                            class="filter-btn px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-book mr-2"></i>E-Book ({{ $ebooks->count() }})
                        </button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($produk as $item)
                            <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl animate-fade-in-up"
                                data-type="{{ strtolower($item->tipe_produk ?? 'kelas_video') }}"
                                style="animation-delay: {{ $loop->index * 0.1 }}s">
                                <!-- Thumbnail -->
                                <div class="relative overflow-hidden group">
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->judul }}"
                                        class="w-full h-48 object-cover transform transition-transform duration-500 group-hover:scale-110">

                                    <!-- Badge Type -->
                                    <div class="absolute top-3 left-3">
                                        @php
                                            $type = strtolower($item->tipe_produk ?? 'kelas_video');
                                            $badgeColors = [
                                                'program' => 'bg-green-600',
                                                'kelas_video' => 'bg-secondary',
                                                'ebook' => 'bg-primary',
                                            ];
                                            $badgeColor = $badgeColors[$type] ?? 'bg-gray-600';
                                            $typeLabels = [
                                                'ebook' => 'E-book',
                                                'kelas_video' => 'Kelas Video',
                                                'program' => 'Program',
                                            ];
                                            $typeLabel = $typeLabels[$type] ?? ucfirst($type);
                                        @endphp
                                        <span
                                            class="px-3 py-1 {{ $badgeColor }} text-white text-xs font-semibold rounded-full">
                                            {{ $typeLabel }}
                                        </span>
                                    </div>

                                    <!-- Overlay -->
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                        <a href="{{ route('kelas.show', $item->id) }}"
                                            class="opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 transition-all duration-300 px-6 py-3 bg-white text-secondary font-semibold rounded-lg shine-effect">
                                            <i class="fas fa-play-circle mr-2"></i>Mulai Belajar
                                        </a>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-6">
                                    <h3
                                        class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 hover:text-secondary transition">
                                        {{ $item->judul }}
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit(strip_tags($item->deskripsi), 100) }}
                                    </p>

                                    <!-- Info -->
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4 pb-4 border-b">
                                        {{-- <div class="flex items-center">
                                            <i class="far fa-calendar-alt mr-2"></i>
                                            <span>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d M Y') }}</span>
                                        </div> --}}
                                        <div class="flex items-center text-green-600 font-semibold">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            <span>Aktif</span>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('kelas.show', $item->id) }}"
                                        class="block w-full text-center px-6 py-3 bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 shine-effect">
                                        <i class="fas fa-arrow-right mr-2"></i>Akses Sekarang
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- No Results Message -->
                    <div id="no-results" class="hidden text-center py-12 animate-fade-in-up">
                        <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ada Hasil</h3>
                        <p class="text-gray-600">Tidak ada produk untuk kategori yang dipilih.</p>
                    </div>
                </div>
            @endif
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

        .filter-btn {
            color: #6b7280;
            background-color: transparent;
        }

        .filter-btn:hover {
            background-color: #f3f4f6;
            color: #0977c2;
        }

        .filter-btn.active {
            background-color: #0977c2;
            color: white;
        }

        .product-card {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@push('js')
    <script>
        function filterContent(type) {
            const cards = document.querySelectorAll('.product-card');
            const buttons = document.querySelectorAll('.filter-btn');
            const noResults = document.getElementById('no-results');
            let visibleCount = 0;

            // Update active button
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.closest('.filter-btn').classList.add('active');

            // Filter cards
            cards.forEach((card, index) => {
                const cardType = card.getAttribute('data-type');

                if (type === 'semua' || cardType === type) {
                    card.style.display = 'block';
                    card.style.animationDelay = `${visibleCount * 0.1}s`;
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Add smooth scroll reveal
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.product-card').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
@endpush
