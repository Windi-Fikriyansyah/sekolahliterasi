@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
    <div class="min-h-screen bg-gray-50 py-4 sm:py-8">
        <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8">

            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-light text-gray-900 mb-2">Pengaturan</h1>
                <p class="text-sm sm:text-base text-gray-600">Kelola akun dan preferensi Anda</p>
            </div>

            <!-- Clean Tab Navigation - Mobile Optimized -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <button onclick="switchTab('account')" id="tab-account"
                            class="tab-button active flex-1 py-3 sm:py-4 px-2 sm:px-6 text-xs sm:text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                            <div
                                class="flex flex-col sm:flex-row items-center justify-center space-y-1 sm:space-y-0 sm:space-x-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-center">Akun Saya</span>
                            </div>
                        </button>
                        <button onclick="switchTab('partner')" id="tab-partner"
                            class="tab-button flex-1 py-3 sm:py-4 px-2 sm:px-6 text-xs sm:text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                            <div
                                class="flex flex-col sm:flex-row items-center justify-center space-y-1 sm:space-y-0 sm:space-x-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span class="text-center">Mitra SekolahLiterasi</span>
                            </div>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Akun Saya Tab -->
                <div id="account-content" class="tab-content p-4 sm:p-8">
                    <div class="space-y-8 sm:space-y-12">
                        <!-- Profile Section -->
                        <div>
                            <div class="flex items-center mb-4 sm:mb-6">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0v2m4-2v2">
                                        </path>
                                    </svg>
                                </div>
                                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Informasi Profil</h2>
                            </div>

                            <form action="{{ route('account.updateProfile') }}" method="POST"
                                class="space-y-4 sm:space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                            Lengkap</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', Auth::user()->name) }}"
                                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm sm:text-base">
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', Auth::user()->email) }}"
                                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm sm:text-base">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                            Telepon</label>
                                        <input type="text" name="no_hp" id="no_hp"
                                            value="{{ old('no_hp', Auth::user()->no_hp) }}" placeholder="+62 xxx xxxx xxxx"
                                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm sm:text-base">
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit"
                                        class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 text-sm sm:text-base">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Security Section -->
                        <div>
                            <div class="flex items-center mb-4 sm:mb-6">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Keamanan</h2>
                            </div>

                            <form action="{{ route('account.updatePassword') }}" method="POST"
                                class="space-y-4 sm:space-y-6">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm sm:text-base">
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">
                                    <div>
                                        <label for="new_password"
                                            class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                        <input type="password" name="new_password" id="new_password"
                                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm sm:text-base">
                                    </div>
                                    <div>
                                        <label for="new_password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi
                                            Password</label>
                                        <input type="password" name="new_password_confirmation"
                                            id="new_password_confirmation"
                                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm sm:text-base">
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit"
                                        class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200 text-sm sm:text-base">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mitra KelasSatu Tab -->
                <div id="partner-content" class="tab-content p-4 sm:p-8 hidden">
                    <div class="space-y-8 sm:space-y-12">
                        <!-- Referral Code Section -->
                        <div>
                            <div class="flex items-start sm:items-center mb-4 sm:mb-6">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 mt-1 sm:mt-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Kode Referral</h2>
                                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Bagikan kode ini untuk mendapatkan
                                        bonus referral
                                    </p>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200">
                                <div
                                    class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                                    <input type="text" id="referral-code" readonly
                                        value="{{ Auth::user()->referral_code }}"
                                        class="flex-1 px-3 sm:px-4 py-2 sm:py-3 bg-white border border-gray-300 rounded-lg font-mono text-center text-base sm:text-lg font-semibold text-gray-800 focus:outline-none">
                                    <button onclick="copyReferral()"
                                        class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>
                        <div>
                            <div class="flex items-start sm:items-center mb-4 sm:mb-6">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 mt-1 sm:mt-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 1.343-3 3h6c0-1.657-1.343-3-3-3zm0 0V5m0 6v6m0 6a9 9 0 100-18 9 9 0 000 18z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Saldo Referral</h2>
                                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Saldo yang dapat ditarik ke rekening
                                        bank</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm sm:text-base text-gray-600">Total Saldo</p>
                                    <p class="text-lg sm:text-2xl font-bold text-gray-900">
                                        Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Partner Menu -->
                        <div>
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Menu Mitra</h2>
                            <div class="grid grid-cols-1 gap-3 sm:gap-4 md:gap-6 md:grid-cols-3">
                                <a href="{{ route('account.bank') }}" class="group block">
                                    <div
                                        class="bg-white border-2 border-gray-200 rounded-xl p-3 sm:p-4 md:p-6 hover:border-blue-300 hover:shadow-md transition-all duration-200 text-center">
                                        <div
                                            class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-3 sm:mb-4 group-hover:bg-blue-200 transition-colors duration-200 mx-auto">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">Atur Bank
                                        </h3>
                                        <p class="text-xs sm:text-sm text-gray-600">Kelola informasi rekening bank</p>
                                    </div>
                                </a>

                                <a href="{{ route('account.withdrawal') }}" class="group block">
                                    <div
                                        class="bg-white border-2 border-gray-200 rounded-xl p-3 sm:p-4 md:p-6 hover:border-green-300 hover:shadow-md transition-all duration-200 text-center">
                                        <div
                                            class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-xl flex items-center justify-center mb-3 sm:mb-4 group-hover:bg-green-200 transition-colors duration-200 mx-auto">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">Penarikan
                                            Saldo</h3>
                                        <p class="text-xs sm:text-sm text-gray-600">Tarik saldo ke rekening bank</p>
                                    </div>
                                </a>

                                <a href="{{ route('account.mutasi') }}" class="group block md:col-span-1">
                                    <div
                                        class="bg-white border-2 border-gray-200 rounded-xl p-3 sm:p-4 md:p-6 hover:border-purple-300 hover:shadow-md transition-all duration-200 text-center">
                                        <div
                                            class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-3 sm:mb-4 group-hover:bg-purple-200 transition-colors duration-200 mx-auto">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">Mutasi
                                            Saldo</h3>
                                        <p class="text-xs sm:text-sm text-gray-600">Riwayat transaksi saldo</p>
                                    </div>
                                </a>
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
        /* Clean Tab Styles */
        .tab-button {
            color: #6b7280;
            border-bottom-color: transparent;
        }

        .tab-button:hover {
            color: #374151;
            border-bottom-color: #e5e7eb;
        }

        .tab-button.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        /* Smooth transitions */
        .tab-content {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease-in-out;
        }

        .tab-content:not(.hidden) {
            opacity: 1;
            transform: translateY(0);
        }

        /* Focus styles */
        input:focus,
        button:focus {
            outline: none;
        }

        /* Mobile specific styles */
        @media (max-width: 640px) {
            .tab-button {
                min-height: 60px;
            }

            /* Better touch targets for mobile */
            input,
            button {
                min-height: 44px;
            }

            /* Adjust spacing for mobile */
            .space-y-8>*+* {
                margin-top: 2rem;
            }
        }

        /* Improved mobile form layouts */
        @media (max-width: 480px) {
            .grid.sm\\:grid-cols-2>div {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function copyReferral() {
            const referralInput = document.getElementById('referral-code');
            referralInput.select();
            referralInput.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(referralInput.value)
                .then(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Kode referral berhasil disalin!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#ffffff',
                        color: '#374151'
                    });
                })
                .catch(err => {
                    console.error('Gagal menyalin: ', err);
                });
        }

        function switchTab(tabName) {
            // Hide all tab contents with animation
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.opacity = '0';
                content.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    content.classList.add('hidden');
                }, 150);
            });

            // Remove active class from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Add active class to selected tab
            document.getElementById('tab-' + tabName).classList.add('active');

            // Show selected tab content with animation
            setTimeout(() => {
                const targetContent = document.getElementById(tabName + '-content');
                targetContent.classList.remove('hidden');

                requestAnimationFrame(() => {
                    targetContent.style.opacity = '1';
                    targetContent.style.transform = 'translateY(0)';
                });
            }, 150);
        }

        // Success and error messages
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    background: '#ffffff',
                    color: '#374151'
                });
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: '{{ $error }}',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        background: '#ffffff',
                        color: '#374151'
                    });
                @endforeach
            @endif
        });
    </script>
@endpush
