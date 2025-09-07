@extends('layouts.app')
@section('title', 'Latihan - ' . $quiz->title)
@section('content')
    <section class="py-6 bg-gradient-to-b from-primary-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <div class="flex items-center">
                            <a href="javascript:void(0)" onclick="confirmExit()"
                                class="mr-3 text-gray-600 hover:text-primary-100 transition-colors">
                                <i class="fa-solid fa-arrow-left text-lg sm:text-xl"></i>
                            </a>
                            <p class="text-gray-600 text-base sm:text-lg">{{ $quiz->title }}</p>
                        </div>
                        @if ($quiz->durasi)
                            <span id="timer" class="text-base sm:text-lg font-bold text-green-600">00:00:00</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6">

                <!-- Navigasi Soal -->
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 h-fit lg:sticky lg:top-24">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Navigasi Soal</h3>
                    <div class="grid grid-cols-6 sm:grid-cols-8 lg:grid-cols-3 gap-2">
                        @foreach ($questions as $index => $question)
                            <button type="button"
                                class="question-nav w-8 h-8 sm:w-10 sm:h-10 rounded-lg border border-gray-300 text-gray-600 text-sm sm:text-base hover:border-primary-100 hover:bg-primary-50 transition-all duration-200 {{ $index === 0 ? 'bg-primary-100 text-white border-primary-100' : '' }}"
                                data-question="{{ $index + 1 }}" onclick="goToQuestion({{ $index + 1 }})">
                                {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>
                    <div class="flex flex-col gap-2 mt-4 text-xs sm:text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 sm:w-4 sm:h-4 bg-primary-100 rounded mr-2"></div>
                            <span class="text-gray-600">Sedang dikerjakan</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 sm:w-4 sm:h-4 bg-green-500 rounded mr-2"></div>
                            <span class="text-gray-600">Sudah dijawab</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 sm:w-4 sm:h-4 border border-gray-300 rounded mr-2"></div>
                            <span class="text-gray-600">Belum dijawab</span>
                        </div>
                    </div>
                </div>

                <!-- Soal -->
                <div class="lg:col-span-3">
                    <form id="quiz-form" method="POST" action="{{ route('kelas.tryout.submit', $quiz->id) }}">
                        @csrf
                        @foreach ($questions as $index => $question)
                            <div class="question-card bg-white rounded-xl shadow-lg overflow-hidden mb-4 sm:mb-6 {{ $index > 0 ? 'hidden' : '' }}"
                                data-question="{{ $index + 1 }}">
                                <div class="p-4 sm:p-6">
                                    <div class="flex items-start mb-4 sm:mb-6">
                                        <div
                                            class="bg-primary-100 text-white rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center font-semibold mr-3 sm:mr-4 flex-shrink-0">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-base sm:text-lg font-medium text-gray-900 mb-3 sm:mb-4">
                                                {!! nl2br(e($question->question)) !!}
                                            </div>
                                            <div class="space-y-2 sm:space-y-3">
                                                @foreach ($question->formatted_options as $optionKey => $option)
                                                    @if ($option)
                                                        <label
                                                            class="flex items-start p-3 sm:p-4 border border-gray-200 rounded-lg hover:border-primary-100 hover:bg-primary-50/30 cursor-pointer transition-all duration-200 option-label">
                                                            <input type="radio"
                                                                name="answers[{{ $question->question_id }}]"
                                                                value="{{ $optionKey }}"
                                                                class="mt-1 mr-3 sm:mr-4 text-primary-100 focus:ring-primary-100 focus:ring-2"
                                                                onchange="updateQuestionNav()">
                                                            <span
                                                                class="text-gray-700 text-sm sm:text-base leading-relaxed">
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
                        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                                <button type="button" id="prev-btn"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-medium transition-colors flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                                    onclick="previousQuestion()" disabled>
                                    <i class="fa-solid fa-arrow-left mr-2"></i>
                                    Sebelumnya
                                </button>

                                <div class="flex space-x-2 sm:space-x-4">
                                    <button type="button" id="next-btn"
                                        class="bg-primary-100 hover:bg-primary-200 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-medium transition-colors flex items-center justify-center"
                                        onclick="nextQuestion()">
                                        Selanjutnya
                                        <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </button>

                                    <button type="button" id="submit-btn"
                                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 sm:px-8 sm:py-3 rounded-lg font-medium transition-colors hidden"
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
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmExit(url = null) {
            Swal.fire({
                title: 'Yakin mau keluar?',
                text: "Progres tidak akan tersimpan jika keluar sebelum submit.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // hapus data
                    localStorage.removeItem("quiz-{{ $quiz->id }}-endtime");
                    localStorage.removeItem("quiz-{{ $quiz->id }}-answers");

                    if (url) {
                        window.location.href = url; // klik link lain
                    } else {
                        window.history.back(); // tombol back
                    }
                }
            });
        }

        let currentQuestion = 1;
        const totalQuestions = {{ count($questions) }};
        let timer = null;

        // KEY untuk localStorage
        const quizKey = "quiz-{{ $quiz->id }}-endtime";
        const answersKey = "quiz-{{ $quiz->id }}-answers";

        // === TIMER ===
        @if ($quiz->durasi)
            let endTime = localStorage.getItem(quizKey);
            if (!endTime) {
                endTime = Date.now() + ({{ $quiz->durasi * 60 }} * 1000);
                localStorage.setItem(quizKey, endTime);
            } else {
                endTime = parseInt(endTime);
            }

            function startTimer() {
                timer = setInterval(function() {
                    let timeLeft = Math.floor((endTime - Date.now()) / 1000);

                    if (timeLeft < 0) {
                        clearInterval(timer);
                        localStorage.removeItem(quizKey);
                        localStorage.removeItem(answersKey);
                        alert("Waktu habis! Latihan akan otomatis disubmit.");
                        document.getElementById("quiz-form").submit();
                        return;
                    }

                    let hours = Math.floor(timeLeft / 3600);
                    let minutes = Math.floor((timeLeft % 3600) / 60);
                    let seconds = timeLeft % 60;

                    let timeStr =
                        (hours < 10 ? "0" : "") + hours + ":" +
                        (minutes < 10 ? "0" : "") + minutes + ":" +
                        (seconds < 10 ? "0" : "") + seconds;

                    const timerEl = document.getElementById("timer");
                    if (timerEl) {
                        timerEl.textContent = timeStr;
                        timerEl.classList.remove("text-red-600", "text-green-600");
                        if (timeLeft <= 60) {
                            timerEl.classList.add("text-red-600");
                        } else {
                            timerEl.classList.add("text-green-600");
                        }
                    }
                }, 1000);
            }
            window.addEventListener("load", startTimer);
        @endif

        // === SIMPAN & RESTORE JAWABAN ===
        function saveAnswers() {
            let answers = {};
            document.querySelectorAll("input[type='radio']:checked, textarea").forEach(input => {
                if (input.type === "radio") {
                    answers[input.name] = input.value;
                } else if (input.tagName.toLowerCase() === "textarea") {
                    answers[input.name] = input.value.trim();
                }
            });
            localStorage.setItem(answersKey, JSON.stringify(answers));
        }

        function restoreAnswers() {
            let saved = localStorage.getItem(answersKey);
            if (saved) {
                let answers = JSON.parse(saved);
                for (let key in answers) {
                    let value = answers[key];
                    let radios = document.querySelectorAll(`input[name="${key}"]`);
                    if (radios.length > 0) {
                        radios.forEach(r => {
                            if (r.value === value) r.checked = true;
                        });
                    } else {
                        let textarea = document.querySelector(`textarea[name="${key}"]`);
                        if (textarea) textarea.value = value;
                    }
                }
            }
            updateQuestionNav();
        }

        function updateQuestionNav() {
            document.querySelectorAll(".question-nav").forEach((btn, index) => {
                const questionNum = index + 1;
                const answered = isQuestionAnswered(questionNum);

                btn.classList.remove("bg-primary-100", "text-white", "border-primary-100", "bg-green-500");

                if (questionNum === currentQuestion) {
                    btn.classList.add("bg-primary-100", "text-white", "border-primary-100");
                } else if (answered) {
                    btn.classList.add("bg-green-500", "text-white");
                }
            });
            saveAnswers();
        }

        function isQuestionAnswered(questionNum) {
            const questionCard = document.querySelector(`.question-card[data-question="${questionNum}"]`);
            if (questionCard.querySelector('input[type="radio"]')) {
                return questionCard.querySelector('input[type="radio"]:checked') !== null;
            } else if (questionCard.querySelector("textarea")) {
                return questionCard.querySelector("textarea").value.trim() !== "";
            }
            return false;
        }

        function showQuestion(questionNum) {
            document.querySelectorAll(".question-card").forEach(card => card.classList.add("hidden"));
            document.querySelector(`.question-card[data-question="${questionNum}"]`).classList.remove("hidden");

            document.getElementById("prev-btn").disabled = questionNum === 1;

            if (questionNum === totalQuestions) {
                document.getElementById("next-btn").classList.add("hidden");
                document.getElementById("submit-btn").classList.remove("hidden");
            } else {
                document.getElementById("next-btn").classList.remove("hidden");
                document.getElementById("submit-btn").classList.add("hidden");
            }
            updateQuestionNav();
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

        function goToQuestion(num) {
            currentQuestion = num;
            showQuestion(currentQuestion);
        }

        // Modal submit
        function confirmSubmit() {
            Swal.fire({
                title: 'Selesai?',
                text: "Pastikan semua soal sudah dijawab.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, submit',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (timer) clearInterval(timer);
                    localStorage.removeItem(quizKey);
                    localStorage.removeItem(answersKey);
                    document.getElementById("quiz-form").submit();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            restoreAnswers();

            document.querySelectorAll("input[type='radio'], textarea").forEach(input => {
                input.addEventListener("change", updateQuestionNav);
                if (input.tagName.toLowerCase() === "textarea") {
                    input.addEventListener("input", updateQuestionNav);
                }
            });
        });

        // ========== HANDLING EXIT ==========
        // Tangkap semua link keluar
        document.querySelectorAll("a[href]").forEach(link => {
            link.addEventListener("click", function(e) {
                const url = this.getAttribute("href");
                if (url && !url.startsWith("#") && !url.startsWith("javascript")) {
                    e.preventDefault();
                    confirmExit(url);
                }
            });
        });

        // Tangkap tombol back browser
        window.addEventListener("popstate", function(e) {
            e.preventDefault();
            confirmExit();
        });

        // Reload → tidak ada SweetAlert
        // (tidak pakai beforeunload supaya tidak munculkan alert default browser)
    </script>
@endpush
