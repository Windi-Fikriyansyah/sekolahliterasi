@extends('layouts.app')
@section('title', 'Program Terbaru - EduCourse')
@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-secondary to-primary py-20">
        <div class="container mx-auto px-4">
            <div class="text-center text-white animate-fade-in-up">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Kumpulan Kelas Video</h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90">Temukan Kelas Video terbaru untuk meningkatkan skill dan karir
                    Anda
                </p>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" class="w-full">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,74.7C1120,75,1280,53,1360,42.7L1440,32L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>



    <!-- Programs Grid Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <!-- Stats -->


            <!-- Programs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($kelasVideo as $kelas)
                    <div
                        class="program-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $kelas->thumbnail) }}" alt="{{ $kelas->judul }}"
                                class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-110"
                                loading="lazy" decoding="async">
                            <div class="absolute top-4 right-4">
                                <span
                                    class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $kelas->tipe_produk }}</span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-secondary">
                                {{ $kelas->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {!! Str::limit(strip_tags($kelas->deskripsi), 100) !!}

                            </p>

                            <div class="flex justify-between items-center">
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($kelas->harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('produk.show', Crypt::encrypt($kelas->id)) }}"
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
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

        .filter-btn.active {
            background-color: #fba615;
            color: white;
            border-color: #fba615;
        }

        .program-card {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .program-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .program-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .program-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .program-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .program-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .program-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const programCards = document.querySelectorAll('.program-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    programCards.forEach(card => {
                        if (filterValue === 'all' || card.getAttribute('data-category') ===
                            filterValue) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 100);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // Load more functionality
            const loadMoreBtn = document.querySelector('.load-more-btn');
            const spinner = loadMoreBtn.querySelector('.fa-spinner');

            loadMoreBtn.addEventListener('click', function() {
                spinner.classList.remove('hidden');
                this.disabled = true;

                // Simulate loading
                setTimeout(() => {
                    spinner.classList.add('hidden');
                    this.disabled = false;

                    // Show success message
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check mr-2"></i>Program Berhasil Dimuat';
                    this.classList.add('bg-green-500', 'text-white', 'border-green-500');

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('bg-green-500', 'text-white',
                            'border-green-500');
                    }, 2000);
                }, 1500);
            });

            // Add to wishlist functionality
            const wishlistButtons = document.querySelectorAll('.program-card button:last-child');
            wishlistButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-red-500');
                        this.classList.add('bg-red-50', 'border-red-500');

                        // Show notification
                        showNotification('Program ditambahkan ke wishlist!');
                    } else {
                        icon.classList.remove('fas', 'text-red-500');
                        icon.classList.add('far');
                        this.classList.remove('bg-red-50', 'border-red-500');

                        showNotification('Program dihapus dari wishlist!');
                    }
                });
            });

            function showNotification(message) {
                const notification = document.createElement('div');
                notification.className =
                    'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
                notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle"></i>
                    <span>${message}</span>
                </div>
            `;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            // Search functionality
            const searchInput = document.querySelector('input[type="text"]');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                programCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p').textContent.toLowerCase();

                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 100);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    </script>
@endpush
