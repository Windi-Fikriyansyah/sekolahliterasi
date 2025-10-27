@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-secondary py-16 md:py-24 overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center text-white animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang Kami</h1>
                <p class="text-xl opacity-90">Mengenal lebih dekat platform pembelajaran online terdepan di Indonesia</p>
            </div>
        </div>
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-white opacity-10 rounded-full"></div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Visi -->
                <div class="animate-slide-in-left">
                    <div class="bg-gradient-to-r from-primary to-secondary p-1 rounded-xl inline-block mb-6">
                        <div class="bg-white p-2 rounded-lg">
                            <i class="fas fa-eye text-3xl text-secondary"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Visi Kami</h2>
                    <p class="text-gray-600 text-lg mb-6">Menjadi platform pembelajaran online terdepan yang memberdayakan
                        masyarakat Indonesia melalui pendidikan berkualitas dan terjangkau.</p>
                    <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-primary">
                        <p class="text-gray-700 italic">"Mencerdaskan kehidupan bangsa melalui akses pendidikan yang merata
                            dan berkualitas untuk semua."</p>
                    </div>
                </div>

                <!-- Misi -->
                <div class="animate-slide-in-right">
                    <div class="bg-gradient-to-r from-secondary to-primary p-1 rounded-xl inline-block mb-6">
                        <div class="bg-white p-2 rounded-lg">
                            <i class="fas fa-bullseye text-3xl text-primary"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Misi Kami</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Menyediakan konten pembelajaran berkualitas tinggi dengan harga
                                terjangkau</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Mengembangkan metode pembelajaran yang inovatif dan efektif</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Menjangkau seluruh pelosok Indonesia dengan teknologi
                                pendidikan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Membangun komunitas pembelajar yang saling mendukung dan
                                berkolaborasi</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Berkontribusi pada peningkatan literasi dan keterampilan digital
                                masyarakat</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Nilai-Nilai Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 animate-fade-in-up">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Nilai-Nilai Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Prinsip-prinsip yang menjadi pedoman dalam setiap langkah kami
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Nilai 1 -->
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-fade-in-up group">
                    <div class="bg-gradient-to-r from-primary to-secondary p-2 rounded-lg inline-block mb-4">
                        <i class="fas fa-heart text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Integritas</h3>
                    <p class="text-gray-600">Kami berkomitmen untuk selalu jujur, transparan, dan bertanggung jawab dalam
                        setiap tindakan.</p>
                </div>

                <!-- Nilai 2 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-fade-in-up group"
                    style="animation-delay: 0.1s;">
                    <div class="bg-gradient-to-r from-secondary to-primary p-2 rounded-lg inline-block mb-4">
                        <i class="fas fa-lightbulb text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Inovasi</h3>
                    <p class="text-gray-600">Terus mengembangkan metode dan teknologi pembelajaran untuk pengalaman belajar
                        terbaik.</p>
                </div>

                <!-- Nilai 3 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-fade-in-up group"
                    style="animation-delay: 0.2s;">
                    <div class="bg-gradient-to-r from-primary to-secondary p-2 rounded-lg inline-block mb-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Kolaborasi</h3>
                    <p class="text-gray-600">Bekerja sama dengan para ahli dan institusi untuk menyajikan konten
                        pembelajaran terbaik.</p>
                </div>

                <!-- Nilai 4 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-fade-in-up group"
                    style="animation-delay: 0.3s;">
                    <div class="bg-gradient-to-r from-secondary to-primary p-2 rounded-lg inline-block mb-4">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Ekselen</h3>
                    <p class="text-gray-600">Selalu berusaha memberikan yang terbaik dalam kualitas konten dan layanan
                        pembelajaran.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 animate-fade-in-up">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Perjalanan Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Cerita perkembangan platform pembelajaran kami dari awal hingga
                    sekarang</p>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Timeline Item 1 -->
                <div class="flex flex-col md:flex-row items-center mb-12 animate-fade-in-up">
                    <div class="md:w-1/2 md:pr-8 mb-6 md:mb-0 text-right">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Awal Mula</h3>
                        <p class="text-gray-600">Platform Sekolahliterasi.com diluncurkan dengan fokus pada literasi dasar
                            dan keterampilan membaca.</p>
                    </div>
                    <div class="md:w-8 flex justify-center">
                        <div class="w-6 h-6 rounded-full bg-primary border-4 border-white shadow-md"></div>
                    </div>
                    <div class="md:w-1/2 md:pl-8 mt-6 md:mt-0">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <span class="text-primary font-bold">2018</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 2 -->
                <div class="flex flex-col md:flex-row items-center mb-12 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="md:w-1/2 md:pr-8 mb-6 md:mb-0 order-3 md:order-1 text-right md:text-left">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <span class="text-primary font-bold">2020</span>
                        </div>
                    </div>
                    <div class="md:w-8 flex justify-center order-2">
                        <div class="w-6 h-6 rounded-full bg-secondary border-4 border-white shadow-md"></div>
                    </div>
                    <div class="md:w-1/2 md:pl-8 mt-6 md:mt-0 order-1 md:order-3">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Ekspansi Konten</h3>
                        <p class="text-gray-600">Memperluas cakupan materi dengan menambahkan kursus keterampilan, bahasa,
                            dan pengembangan diri.</p>
                    </div>
                </div>

                <!-- Timeline Item 3 -->
                <div class="flex flex-col md:flex-row items-center mb-12 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="md:w-1/2 md:pr-8 mb-6 md:mb-0 text-right">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Teknologi Baru</h3>
                        <p class="text-gray-600">Mengintegrasikan sistem pembelajaran adaptif dan platform mobile untuk
                            akses yang lebih mudah.</p>
                    </div>
                    <div class="md:w-8 flex justify-center">
                        <div class="w-6 h-6 rounded-full bg-primary border-4 border-white shadow-md"></div>
                    </div>
                    <div class="md:w-1/2 md:pl-8 mt-6 md:mt-0">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <span class="text-primary font-bold">2022</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 4 -->
                <div class="flex flex-col md:flex-row items-center animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="md:w-1/2 md:pr-8 mb-6 md:mb-0 order-3 md:order-1 text-right md:text-left">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <span class="text-primary font-bold">2025</span>
                        </div>
                    </div>
                    <div class="md:w-8 flex justify-center order-2">
                        <div class="w-6 h-6 rounded-full bg-secondary border-4 border-white shadow-md"></div>
                    </div>
                    <div class="md:w-1/2 md:pl-8 mt-6 md:mt-0 order-1 md:order-3">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Masa Depan</h3>
                        <p class="text-gray-600">Terus berinovasi dengan teknologi AI dan realitas virtual untuk pengalaman
                            belajar yang lebih imersif.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 animate-fade-in-up">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Tim Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Orang-orang berdedikasi di balik kesuksesan platform
                    pembelajaran kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-all duration-300 animate-fade-in-up">
                    <div class="h-48 bg-gradient-to-r from-primary to-secondary relative overflow-hidden">
                        <div
                            class="absolute inset-0 bg-black opacity-20 group-hover:opacity-10 transition-opacity duration-300">
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Ahmad Rizki</h3>
                        <p class="text-primary font-medium mb-3">Founder & CEO</p>
                        <p class="text-gray-600 text-sm">Pendiri platform dengan visi untuk menciptakan akses pendidikan
                            yang merata di Indonesia.</p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-all duration-300 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="h-48 bg-gradient-to-r from-secondary to-primary relative overflow-hidden">
                        <div
                            class="absolute inset-0 bg-black opacity-20 group-hover:opacity-10 transition-opacity duration-300">
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Sari Dewi</h3>
                        <p class="text-primary font-medium mb-3">Head of Content</p>
                        <p class="text-gray-600 text-sm">Bertanggung jawab atas pengembangan dan kurasi konten pembelajaran
                            yang berkualitas.</p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-all duration-300 animate-fade-in-up"
                    style="animation-delay: 0.2s;">
                    <div class="h-48 bg-gradient-to-r from-primary to-secondary relative overflow-hidden">
                        <div
                            class="absolute inset-0 bg-black opacity-20 group-hover:opacity-10 transition-opacity duration-300">
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Budi Santoso</h3>
                        <p class="text-primary font-medium mb-3">CTO</p>
                        <p class="text-gray-600 text-sm">Memimpin pengembangan teknologi untuk menciptakan platform yang
                            stabil dan user-friendly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-secondary text-white">
        <div class="container mx-auto px-4 text-center animate-fade-in-up">
            <h2 class="text-3xl font-bold mb-4">Siap Memulai Perjalanan Belajar Anda?</h2>
            <p class="text-xl opacity-90 max-w-2xl mx-auto mb-8">Bergabunglah dengan ribuan pembelajar lainnya dan raih
                impian Anda melalui pendidikan berkualitas.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('program') }}"
                    class="bg-white text-secondary font-bold py-3 px-8 rounded-lg hover:bg-opacity-90 transition-all transform hover:scale-105 shine-effect">
                    Jelajahi Program
                </a>
                <a href="#"
                    class="bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded-lg hover:bg-white hover:bg-opacity-10 transition-all transform hover:scale-105">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .timeline-line {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 2px;
            background: linear-gradient(to bottom, #fba615, #0977c2);
            transform: translateX(-50%);
        }

        @media (max-width: 768px) {
            .timeline-line {
                left: 30px;
            }
        }
    </style>
@endpush
