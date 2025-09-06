@extends('layouts.app')
@section('title', 'Hasil Latihan - ' . $quiz->title)

@section('content')
    <section class="py-8 bg-gradient-to-b from-primary-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="p-6 text-center">
                    <!-- Success Icon -->
                    <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                        @if ($score >= 80)
                            <!-- Hijau -->
                            <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @elseif($score >= 60)
                            <!-- Kuning -->
                            <svg class="w-10 h-10 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <!-- Merah -->
                            <svg class="w-10 h-10 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Latihan Selesai!</h1>
                    <p class="text-gray-600 mb-6">{{ $quiz->title }}</p>

                    <!-- Score Display -->
                    <div
                        class="bg-gradient-to-r from-primary-100 to-primary-200 text-white rounded-xl p-6 mb-6 mx-auto max-w-md">
                        <div class="text-center">
                            <div class="text-5xl font-bold mb-2">{{ number_format($score, 0) }}</div>
                            <div class="text-xl opacity-90">dari 100</div>
                        </div>
                    </div>

                    <!-- Performance Message -->
                    <div class="mb-6">
                        @if ($score >= 80)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-green-800 mb-2">Excellent! 🎉</h3>
                                <p class="text-green-700">Hasil yang sangat baik! Anda telah menguasai materi dengan baik.
                                </p>
                            </div>
                        @elseif($score >= 60)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Good Job! 👍</h3>
                                <p class="text-yellow-700">Hasil yang cukup baik! Masih ada ruang untuk perbaikan.</p>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-red-800 mb-2">Keep Learning! 📚</h3>
                                <p class="text-red-700">Jangan menyerah! Pelajari kembali materi dan coba lagi.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $correctAnswers }}</h3>
                    <p class="text-gray-600">Jawaban Benar</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $totalQuestions - $correctAnswers }}</h3>
                    <p class="text-gray-600">Jawaban Salah</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $totalQuestions }}</h3>
                    <p class="text-gray-600">Total Soal</p>
                </div>
            </div>

            <!-- Detail Jawaban -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Jawaban</h3>
                <div class="space-y-6">
                    @foreach ($answersDetail as $index => $item)
                        <div
                            class="p-4 border rounded-lg {{ $item['is_correct'] ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50' }}">
                            <p class="font-medium text-gray-900 mb-2">
                                Soal {{ $index + 1 }}: {{ $item['question'] }}
                            </p>
                            <ul class="space-y-1 mb-2">
                                @foreach ($item['options'] as $key => $option)
                                    <li
                                        class="text-sm {{ $key == $item['correct_answer'] ? 'font-bold text-green-700' : '' }}">
                                        {{ $key }}. {{ $option }}
                                    </li>
                                @endforeach
                            </ul>
                            <p class="text-sm">
                                Jawaban Anda:
                                <span class="{{ $item['is_correct'] ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item['user_answer'] ?? 'Tidak menjawab' }}
                                </span>
                            </p>
                            <p class="text-sm">Jawaban Benar: <span
                                    class="font-semibold text-green-700">{{ $item['correct_answer'] }}</span></p>
                            <p class="text-sm text-gray-700 mt-2"><strong>Pembahasan:</strong> {{ $item['explanation'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Progress Bar -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Akurasi Jawaban</h3>
                <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                    <div id="progress-bar"
                        class="h-4 rounded-full transition-all duration-1000 {{ $score >= 80 ? 'bg-green-500' : ($score >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                        style="width: 0%">
                    </div>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>0%</span>
                    <span class="font-medium">{{ number_format($score, 1) }}%</span>
                    <span>100%</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url()->previous() }}"
                        class="bg-primary-100 hover:bg-primary-200 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                        Kembali ke Kelas
                    </a>

                    @if ($score < 60)
                        <a href="{{ route('kelas.latihan', $quiz->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                            Coba Lagi
                        </a>
                    @endif

                    <button onclick="shareResult()"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                        Bagikan Hasil
                    </button>
                </div>

                <!-- Tips -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-1">Tips untuk Meningkatkan Hasil:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Pelajari kembali materi yang belum dikuasai</li>
                        <li>• Diskusikan dengan instruktur atau teman sekelas</li>
                        <li>• Praktikkan lebih banyak latihan soal</li>
                        <li>• Catat poin-poin penting untuk review</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        function shareResult() {
            if (navigator.share) {
                navigator.share({
                    title: 'Hasil Latihan KelasSatu',
                    text: `Saya baru saja menyelesaikan latihan "{{ $quiz->title }}" dan mendapat skor {{ number_format($score, 0) }}!`,
                    url: window.location.href
                });
            } else {
                const text =
                    `Saya baru saja menyelesaikan latihan "{{ $quiz->title }}" di KelasSatu dan mendapat skor {{ number_format($score, 0) }}! 🎉`;
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text + ' ' + window.location.href);
                    alert('Link hasil berhasil disalin ke clipboard!');
                }
            }
        }

        // Animate progress bar
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('progress-bar').style.width = '{{ $score }}%';
            }, 300);
        });

        // Confetti untuk skor tinggi
        @if ($score >= 80)
            document.addEventListener('DOMContentLoaded', function() {
                createConfetti();
            });

            function createConfetti() {
                const colors = ['#eb631d', '#254768', '#10B981', '#F59E0B', '#EF4444'];
                const confettiCount = 50;

                for (let i = 0; i < confettiCount; i++) {
                    const confetti = document.createElement('div');
                    confetti.style.position = 'fixed';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.top = '-10px';
                    confetti.style.width = '10px';
                    confetti.style.height = '10px';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRadius = '50%';
                    confetti.style.opacity = '0.8';
                    confetti.style.zIndex = '9999';
                    confetti.style.pointerEvents = 'none';
                    document.body.appendChild(confetti);

                    const fallDuration = Math.random() * 3 + 2;
                    confetti.animate(
                        [{
                                transform: `translateY(0) rotate(0deg)`,
                                opacity: 1
                            },
                            {
                                transform: `translateY(100vh) rotate(${Math.random() * 720}deg)`,
                                opacity: 0
                            }
                        ], {
                            duration: fallDuration * 1000,
                            iterations: 1
                        }
                    );

                    setTimeout(() => confetti.remove(), fallDuration * 1000);
                }
            }
        @endif
    </script>
@endpush
