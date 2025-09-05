@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')
@section('title', 'Materi - ' . $module->title)
@section('content')
    <section class="py-8 bg-gradient-to-b from-primary-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Module Info -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <a href="{{ url()->previous() }}"
                            class="bg-gray-100 hover:bg-gray-200 p-2 rounded-lg mr-4 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-primary-200">{{ $module->title }}</h1>
                            <p class="text-gray-500">Kelas: {{ $module->course_title }}</p>
                        </div>
                    </div>
                    @if ($module->description)
                        <p class="text-gray-600">{{ $module->description }}</p>
                    @endif
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button onclick="switchTab('materi-text', event)"
                            class="tab-button active w-1/2 py-4 px-6 text-center border-b-2 border-primary-100 text-primary-100 font-medium transition-colors duration-200">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Materi
                            </div>
                        </button>
                        <button onclick="switchTab('materi-video', event)"
                            class="tab-button w-1/2 py-4 px-6 text-center border-b-2 border-transparent text-gray-500 font-medium transition-colors duration-200">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm12.553 1.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Materi Video
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Materi Text Tab -->
                    <div id="materi-text-content" class="tab-content">
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-primary-200 mb-2">Materi</h2>
                            <p class="text-gray-600">Pelajari materi dengan sungguh-sungguh</p>
                        </div>

                        @if ($textContents->isEmpty())
                            <div class="text-center py-12 text-gray-500">
                                <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="mt-6 text-lg font-medium">Belum ada materi untuk modul ini.</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach ($textContents as $content)
                                    <div
                                        class="bg-gradient-to-br from-blue-50 to-white rounded-lg border border-blue-200 hover:border-primary-100 hover:shadow-md transition-all duration-300">
                                        <div class="p-6">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-semibold text-primary-200 mb-2">
                                                        {{ $content->title }}
                                                    </h3>
                                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($content->updated_at)->format('d M Y, H:i') }}
                                                    </div>
                                                </div>
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">

                                                </span>
                                            </div>



                                            <!-- PDF File -->
                                            @if ($content->file_pdf)
                                                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                                    <div class="flex items-center">
                                                        <svg class="w-8 h-8 text-red-500 mr-3" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>

                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('kelas.pdf_view', $content->module_id) }}"
                                                            target="_blank"
                                                            class="bg-primary-100 hover:bg-primary-200 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                            Lihat Materi
                                                        </a>

                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Materi Video Tab -->
                    <div id="materi-video-content" class="tab-content hidden">
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-primary-200 mb-2">Materi Video</h2>
                            <p class="text-gray-600">Tonton video pembelajaran</p>
                        </div>

                        @if ($videoContents->isEmpty())
                            <div class="text-center py-12 text-gray-500">
                                <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="mt-6 text-lg font-medium">Belum ada materi video untuk modul ini.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @foreach ($videoContents as $content)
                                    <div
                                        class="bg-gradient-to-br from-purple-50 to-white rounded-lg border border-purple-200 hover:border-primary-100 hover:shadow-md transition-all duration-300">
                                        <div class="p-6">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-semibold text-primary-200 mb-2">
                                                        {{ $content->title }}
                                                    </h3>
                                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($content->created_at)->format('d M Y, H:i') }}
                                                    </div>
                                                </div>
                                                <span
                                                    class="bg-purple-100 text-purple-800 text-xs font-medium px-3 py-1 rounded-full">
                                                    Video
                                                </span>
                                            </div>

                                            <!-- Video Player -->
                                            @if ($content->video)
                                                <div class="relative mb-4">
                                                    <video class="w-full rounded-lg" controls controlsList="nodownload"
                                                        oncontextmenu="return false;" poster="">
                                                        <source src="{{ asset('storage/' . $content->video) }}"
                                                            type="video/mp4">
                                                        Browser Anda tidak mendukung pemutar video.
                                                    </video>
                                                </div>
                                            @endif


                                            <!-- Additional PDF if exists -->
                                            @if ($content->file_pdf)
                                                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                                    <div class="flex items-center">
                                                        <svg class="w-6 h-6 text-red-500 mr-2" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-sm text-gray-600">Materi Pendukung</span>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $content->file_pdf) }}"
                                                        target="_blank"
                                                        class="bg-primary-100 hover:bg-primary-200 text-white px-3 py-1 rounded text-sm transition-colors">
                                                        Buka PDF
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        function switchTab(tabName, event) {
            // Sembunyikan semua tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Reset semua tab button
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-primary-100', 'text-primary-100');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Tampilkan tab content yang dipilih
            document.getElementById(tabName + '-content').classList.remove('hidden');

            // Tambahkan kelas aktif ke tab yang diklik
            event.currentTarget.classList.add('active', 'border-primary-100', 'text-primary-100');
            event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
        }

        // Auto-pause other videos when playing one
        document.addEventListener('play', function(e) {
            var videos = document.querySelectorAll('video');
            for (var i = 0, len = videos.length; i < len; i++) {
                if (videos[i] != e.target) {
                    videos[i].pause();
                }
            }
        }, true);
    </script>
@endpush

@push('style')
    <style>
        .tab-button.active {
            border-bottom: 2px solid #eb631d;
            color: #eb631d;
            font-weight: 600;
        }

        .tab-button {
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .tab-content {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .prose {
            line-height: 1.6;
        }

        .prose p {
            margin-bottom: 1rem;
        }

        /* Video responsive */
        video {
            max-height: 400px;
            object-fit: contain;
        }

        /* Custom scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #eb631d;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #d45615;
        }
    </style>
@endpush
