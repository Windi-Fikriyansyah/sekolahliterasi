@extends('layouts.app')
@section('title', 'Latihan - ' . $quiz->title)
@section('content')
    <section class="py-8 bg-gradient-to-b from-primary-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <a href="{{ url()->previous() }}" class="mr-4 text-gray-600 hover:text-primary-100 transition-colors">
                            <i class="fa-solid fa-arrow-left text-xl"></i>
                        </a>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-primary-200 mb-2">{{ $quiz->title }}</h1>
                            <p class="text-gray-600">{{ $quiz->course_title }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                            {{ $quiz->quiz_type === 'latihan' ? 'Latihan' : 'Tryout' }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fa-solid fa-list mr-1"></i>
                            {{ count($questions) }} soal
                        </span>

                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress</span>
                    <span class="text-sm text-gray-500"><span id="current-question">1</span> dari
                        {{ count($questions) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-primary-100 h-2 rounded-full transition-all duration-300" id="progress-bar"
                        style="width: {{ count($questions) > 0 ? (1 / count($questions)) * 100 : 0 }}%"></div>
                </div>
            </div>

            <!-- Layout 2 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <!-- Navigasi Soal (Kiri) -->
                <div class="bg-white rounded-xl shadow-lg p-6 h-fit lg:sticky lg:top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Navigasi Soal</h3>
                    <div class="grid grid-cols-8 lg:grid-cols-3 gap-2">
                        @foreach ($questions as $index => $question)
                            <button type="button"
                                class="question-nav w-10 h-10 rounded-lg border border-gray-300 text-gray-600 hover:border-primary-100 hover:bg-primary-50 transition-all duration-200 {{ $index === 0 ? 'bg-primary-100 text-white border-primary-100' : '' }}"
                                data-question="{{ $index + 1 }}" onclick="goToQuestion({{ $index + 1 }})">
                                {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>
                    <div class="flex flex-col gap-2 mt-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-primary-100 rounded mr-2"></div>
                            <span class="text-gray-600">Sedang dikerjakan</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                            <span class="text-gray-600">Sudah dijawab</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 border border-gray-300 rounded mr-2"></div>
                            <span class="text-gray-600">Belum dijawab</span>
                        </div>
                    </div>
                </div>

                <!-- Soal & Navigasi (Kanan) -->
                <div class="lg:col-span-3">
                    <form id="quiz-form" method="POST" action="{{ route('kelas.latihan.submit', $quiz->id) }}">
                        @csrf

                        @foreach ($questions as $index => $question)
                            <div class="question-card bg-white rounded-xl shadow-lg overflow-hidden mb-6 {{ $index > 0 ? 'hidden' : '' }}"
                                data-question="{{ $index + 1 }}">
                                <div class="p-6">
                                    <div class="flex items-start mb-6">
                                        <div
                                            class="bg-primary-100 text-white rounded-full w-8 h-8 flex items-center justify-center font-semibold mr-4 flex-shrink-0">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-lg font-medium text-gray-900 mb-4">
                                                {!! nl2br(e($question->question)) !!}
                                            </div>

                                            <div class="space-y-3">
                                                @foreach ($question->formatted_options as $optionKey => $option)
                                                    @if ($option)
                                                        <label
                                                            class="flex items-start p-4 border border-gray-200 rounded-lg hover:border-primary-100 hover:bg-primary-50/30 cursor-pointer transition-all duration-200 option-label">
                                                            <input type="radio"
                                                                name="answers[{{ $question->question_id }}]"
                                                                value="{{ $optionKey }}"
                                                                class="mt-1 mr-4 text-primary-100 focus:ring-primary-100 focus:ring-2"
                                                                onchange="updateProgress()">
                                                            <span class="text-gray-700 leading-relaxed">
                                                                <strong>{{ $optionKey }}.</strong> {{ $option }}
                                                            </span>
                                                        </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Tombol Navigasi -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex justify-between items-center">
                                <button type="button" id="prev-btn"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                                    onclick="previousQuestion()" disabled>
                                    <i class="fa-solid fa-arrow-left mr-2"></i>
                                    Sebelumnya
                                </button>

                                <div class="flex space-x-4">
                                    <button type="button" id="next-btn"
                                        class="bg-primary-100 hover:bg-primary-200 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center"
                                        onclick="nextQuestion()">
                                        Selanjutnya
                                        <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </button>

                                    <button type="button" id="submit-btn"
                                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium transition-colors hidden"
                                        onclick="confirmSubmit()">
                                        Selesai
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Konfirmasi Submit Modal -->
    <div id="submit-modal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-yellow-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-center text-gray-900 mb-2">Konfirmasi Submit</h3>
                    <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menyelesaikan latihan ini? Jawaban
                        tidak dapat diubah setelah submit.</p>
                    <div class="flex space-x-4">
                        <button type="button"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors"
                            onclick="closeModal()">
                            Batal
                        </button>
                        <button type="button"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                            onclick="submitQuiz()">
                            Ya, Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let currentQuestion = 1;
        const totalQuestions = {{ count($questions) }};
        let timer = null;

        @if ($quiz->durasi)
            let timeLeft = {{ $quiz->durasi * 60 }};

            function startTimer() {
                timer = setInterval(function() {
                    let minutes = Math.floor(timeLeft / 60);
                    let seconds = timeLeft % 60;

                    document.getElementById('timer').textContent =
                        (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

                    if (timeLeft <= 300) {
                        document.getElementById('timer-display').classList.add('text-red-600');
                    }

                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        alert('Waktu habis! Latihan akan otomatis disubmit.');
                        document.getElementById('quiz-form').submit();
                    }

                    timeLeft--;
                }, 1000);
            }
            window.addEventListener('load', startTimer);
        @endif

        function updateProgress() {
            const progress = (currentQuestion / totalQuestions) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
            document.getElementById('current-question').textContent = currentQuestion;
            updateQuestionNav();
        }

        function updateQuestionNav() {
            document.querySelectorAll('.question-nav').forEach((btn, index) => {
                const questionNum = index + 1;
                const answered = isQuestionAnswered(questionNum);

                btn.classList.remove('bg-primary-100', 'text-white', 'border-primary-100', 'bg-green-500');

                if (questionNum === currentQuestion) {
                    btn.classList.add('bg-primary-100', 'text-white', 'border-primary-100');
                } else if (answered) {
                    btn.classList.add('bg-green-500', 'text-white');
                }
            });
        }

        function isQuestionAnswered(questionNum) {
            const questionCard = document.querySelector(`.question-card[data-question="${questionNum}"]`);

            if (questionCard.querySelector('input[type="radio"]')) {
                return questionCard.querySelector('input[type="radio"]:checked') !== null;
            } else if (questionCard.querySelector('textarea')) {
                return questionCard.querySelector('textarea').value.trim() !== '';
            }
            return false;
        }

        function showQuestion(questionNum) {
            document.querySelectorAll('.question-card').forEach(card => card.classList.add('hidden'));
            document.querySelector(`.question-card[data-question="${questionNum}"]`).classList.remove('hidden');

            document.getElementById('prev-btn').disabled = questionNum === 1;

            if (questionNum === totalQuestions) {
                document.getElementById('next-btn').classList.add('hidden');
                document.getElementById('submit-btn').classList.remove('hidden');
            } else {
                document.getElementById('next-btn').classList.remove('hidden');
                document.getElementById('submit-btn').classList.add('hidden');
            }

            updateProgress();
        }

        function nextQuestion() {
            if (currentQuestion < totalQuestions) {
                currentQuestion++;
                showQuestion(currentQuestion);
            }
        }

        function previousQuestion() {
            if (currentQuestion > 1) {
                currentQuestion--;
                showQuestion(currentQuestion);
            }
        }

        function goToQuestion(questionNum) {
            currentQuestion = questionNum;
            showQuestion(currentQuestion);
        }

        function confirmSubmit() {
            document.getElementById('submit-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('submit-modal').classList.add('hidden');
        }

        function submitQuiz() {
            if (timer) clearInterval(timer);
            document.getElementById('quiz-form').submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateProgress();

            // Update navigasi kalau ada perubahan jawaban
            document.querySelectorAll('input[type="radio"], textarea').forEach(input => {
                input.addEventListener('change', updateQuestionNav);
                if (input.tagName.toLowerCase() === 'textarea') {
                    input.addEventListener('input', updateQuestionNav);
                }
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowRight') {
                if (currentQuestion < totalQuestions) nextQuestion();
            } else if (e.key === 'ArrowLeft') {
                if (currentQuestion > 1) previousQuestion();
            }
        });
    </script>
@endpush
