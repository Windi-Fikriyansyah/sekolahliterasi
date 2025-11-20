<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pendaftaran</title>
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1173d4",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                        "text-light": "#111827",
                        "text-dark": "#f3f4f6",
                        "subtext-light": "#6b7280",
                        "subtext-dark": "#9ca3af",
                        "input-bg-light": "#ffffff",
                        "input-bg-dark": "#1f2937",
                        "border-light": "#d1d5db",
                        "border-dark": "#4b5563"
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .form-input,
        .form-textarea {
            border: 1px solid;
        }

        .toast {
            transition: all 0.4s ease-in-out;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast.hide {
            opacity: 0;
            transform: translateY(-10px);
        }

        /* Custom Select2 Styling - Modern Look */
        .select2-container--default .select2-selection--single {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            height: 42px;
            padding: 0.5rem 0.75rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
        }

        .dark .select2-container--default .select2-selection--single {
            background-color: #1f2937;
            border-color: #4b5563;
            color: #f3f4f6;
        }

        .select2-container--default .select2-selection--single:hover {
            border-color: #1173d4;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #1173d4;
            box-shadow: 0 0 0 3px rgba(17, 115, 212, 0.1);
            outline: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #111827;
            line-height: 26px;
            padding-left: 0;
        }

        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #f3f4f6;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6b7280;
        }

        .dark .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #6b7280 transparent transparent transparent;
            border-width: 6px 5px 0 5px;
            margin-left: -5px;
            margin-top: -3px;
        }

        /* Dropdown styling */
        .select2-container--default .select2-results__option {
            padding: 0.75rem 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s ease;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #1173d4;
            color: white;
        }

        .select2-dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .dark .select2-dropdown {
            background-color: #1f2937;
            border-color: #4b5563;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            font-family: 'Inter', sans-serif;
            margin: 0.5rem;
            width: calc(100% - 1rem);
        }

        .dark .select2-search--dropdown .select2-search__field {
            background-color: #374151;
            border-color: #4b5563;
            color: #f3f4f6;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #e5e7eb;
        }

        .dark .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #374151;
            color: #f3f4f6;
        }

        .dark .select2-container--default .select2-results__option {
            color: #f3f4f6;
        }

        /* Width fix */
        .select2-container {
            width: 100% !important;
        }

        /* Loading state */
        .select2-container--default .select2-results__option--disabled {
            color: #9ca3af;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }

        .ql-align-center {
            text-align: center;
        }

        .ql-align-right {
            text-align: right;
        }

        .ql-align-justify {
            text-align: justify;
        }

        .ql-align-left {
            text-align: left;
        }
    </style>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</head>

<body class="bg-background-light dark:bg-background-dark font-display text-text-light dark:text-text-dark">
    <div class="max-w-md mx-auto">

        <main class="p-4 space-y-6">
            <h1 class="text-2xl font-bold text-center mb-2">{{ $form->title }}</h1>

            @if ($form->description)
                <div class="text-sm text-gray-700 dark:text-gray-300 mb-4 prose max-w-none">

                    <!-- SHORT VERSION -->
                    <div id="desc-short"></div>

                    <!-- FULL VERSION (disembunyikan) -->
                    <div id="desc-full" class="hidden"></div>

                    <!-- TOGGLE BUTTON -->
                    <button id="toggle-desc"
                        class="mt-2 text-blue-600 dark:text-blue-400 text-sm font-medium underline">
                        Lihat selengkapnya
                    </button>

                </div>
            @endif



            <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
                class="p-4 space-y-6">
                @csrf
                <input type="hidden" name="id_product" value="{{ $product->id }}">
                <input type="hidden" name="form_id" value="{{ $form->id }}">

                <div class="space-y-4">

                    @foreach ($formFields as $field)
                        @php
                            $isRequired = $field->is_required ? 'required' : '';
                            $options = $field->options ? json_decode($field->options) : [];
                        @endphp

                        {{-- TEXT --}}
                        @if ($field->type === 'text')
                            <label class="block space-y-2">
                                <span class="text-sm font-medium">
                                    {{ $field->label }}
                                    @if ($field->is_required)
                                        <span class="text-red-600">*</span>
                                    @endif
                                </span>
                                <input type="text" name="fields[{{ $field->id }}]" {{ $isRequired }}
                                    class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark" />
                            </label>
                        @endif


                        {{-- TEXTAREA --}}
                        @if ($field->type === 'textarea')
                            <label class="block space-y-2">
                                <span class="text-sm font-medium">
                                    {{ $field->label }}
                                    @if ($field->is_required)
                                        <span class="text-red-600">*</span>
                                    @endif
                                </span>

                                <textarea name="fields[{{ $field->id }}]" {{ $isRequired }}
                                    class="form-textarea w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark"></textarea>
                            </label>
                        @endif

                        {{-- SELECT --}}
                        @if ($field->type === 'select')
                            <label class="block space-y-2">
                                <span class="text-sm font-medium">
                                    {{ $field->label }}
                                    @if ($field->is_required)
                                        <span class="text-red-600">*</span>
                                    @endif
                                </span>

                                <select name="fields[{{ $field->id }}]" {{ $isRequired }}
                                    class="form-input w-full rounded-lg">
                                    <option value="">Pilih {{ strtolower($field->label) }}</option>
                                    @foreach ($options as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </label>
                        @endif

                        {{-- CHECKBOX --}}
                        @if ($field->type === 'checkbox')
                            <div class="space-y-1">
                                <span class="text-sm font-medium">
                                    {{ $field->label }}
                                    @if ($field->is_required)
                                        <span class="text-red-600">*</span>
                                    @endif
                                </span>

                                @foreach ($options as $opt)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="fields[{{ $field->id }}][]"
                                            value="{{ $opt }}" />
                                        <span>{{ $opt }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        {{-- RADIO --}}
                        @if ($field->type === 'radio')
                            <div class="space-y-1">
                                <span class="text-sm font-medium">
                                    {{ $field->label }}
                                    @if ($field->is_required)
                                        <span class="text-red-600">*</span>
                                    @endif
                                </span>

                                @foreach ($options as $opt)
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="fields[{{ $field->id }}]"
                                            value="{{ $opt }}" />
                                        <span>{{ $opt }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        @if ($field->type === 'number')
                            <label class="block space-y-2">
                                <span class="text-sm font-medium">
                                    {{ $field->label }}
                                    @if ($field->is_required)
                                        <span class="text-red-600">*</span>
                                    @endif
                                </span>

                                <input type="number" name="fields[{{ $field->id }}]" {{ $isRequired }}
                                    class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark" />
                            </label>
                        @endif

                        {{-- FILE --}}
                        @if ($field->type === 'file')
                            <label class="block space-y-2">
                                <span class="text-sm font-medium">
                                    {{ $field->label }}
                                    @if ($field->is_required)
                                        <span class="text-red-600">*</span>
                                    @endif
                                </span>


                                <input type="file" name="fields[{{ $field->id }}]" {{ $isRequired }}
                                    class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark" />
                            </label>
                        @endif
                    @endforeach

                </div>

                <hr class="border-border-light dark:border-border-dark" />

                <footer class="p-4 bg-background-light dark:bg-background-dark">
                    <button type="submit"
                        class="w-full bg-primary text-white font-bold py-3 px-4 rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-background-light dark:focus:ring-offset-background-dark transition-colors">
                        Daftar
                    </button>
                </footer>
            </form>
        </main>


    </div>

    <div id="toast-container" class="fixed top-4 right-4 space-y-3 z-50"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fullText = `{!! str_replace("\n", '', $form->description) !!}`;
            const maxLength = 150;

            const shortEl = document.getElementById("desc-short");
            const fullEl = document.getElementById("desc-full");
            const toggleBtn = document.getElementById("toggle-desc");

            if (!shortEl || !fullEl || !toggleBtn) return;

            // Hilangkan tag HTML untuk menghitung panjang murni
            const plainText = fullText.replace(/<[^>]+>/g, '').trim();

            // Jika deskripsi pendek, tampilkan langsung
            if (plainText.length <= maxLength) {
                shortEl.innerHTML = fullText;
                toggleBtn.classList.add("hidden");
                return;
            }

            // Buat ringkasan
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = fullText;

            const shortText = tempDiv.textContent.substring(0, maxLength) + "...";

            shortEl.innerHTML = shortText;
            fullEl.innerHTML = fullText;

            let expanded = false;

            toggleBtn.addEventListener("click", function() {
                expanded = !expanded;

                if (expanded) {
                    shortEl.classList.add("hidden");
                    fullEl.classList.remove("hidden");
                    toggleBtn.innerText = "Sembunyikan";
                } else {
                    shortEl.classList.remove("hidden");
                    fullEl.classList.add("hidden");
                    toggleBtn.innerText = "Lihat selengkapnya";
                }
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const provinsiSelect = document.getElementById("provinsi");
            const kotaSelect = document.getElementById("kota");

            // Initialize Select2 dengan konfigurasi modern
            $('.select2-provinsi').select2({
                placeholder: 'Pilih provinsi',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Provinsi tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            $('.select2-kota').select2({
                placeholder: 'Pilih kabupaten/kota',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Kota tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            // --- Ambil daftar provinsi dari Laravel proxy ---
            try {
                const response = await fetch("/api/provinsi");
                const data = await response.json();

                // Clear dan tambahkan placeholder
                $(provinsiSelect).empty().append('<option value="">Pilih provinsi</option>');

                data.data.forEach(prov => {
                    const option = new Option(prov.name, prov.name, false, false);
                    option.dataset.code = prov.code;
                    $(provinsiSelect).append(option);
                });

                // Trigger change untuk update Select2
                $(provinsiSelect).trigger('change');
            } catch (err) {
                console.error("Gagal memuat provinsi:", err);
                showToast('error', 'Gagal memuat data provinsi');
            }

            // --- Saat provinsi dipilih (menggunakan Select2 event) ---
            $(provinsiSelect).on('select2:select', async function(e) {
                const selectedOption = e.params.data.element;
                const provinceCode = selectedOption.dataset.code;

                // Reset kota
                $(kotaSelect).empty().append('<option value="">Pilih kabupaten/kota</option>')
                    .trigger('change');

                if (!provinceCode) return;

                // Tampilkan loading
                $(kotaSelect).prop('disabled', true);
                $(kotaSelect).empty().append('<option value="">Memuat data...</option>').trigger(
                    'change');

                try {
                    const response = await fetch(`/api/kota/${provinceCode}`);
                    const data = await response.json();

                    // Clear dan tambahkan placeholder
                    $(kotaSelect).empty().append('<option value="">Pilih kabupaten/kota</option>');

                    data.data.forEach(city => {
                        const option = new Option(city.name, city.name, false, false);
                        $(kotaSelect).append(option);
                    });

                    // Trigger change dan enable
                    $(kotaSelect).trigger('change');
                    $(kotaSelect).prop('disabled', false);
                } catch (err) {
                    console.error("Gagal memuat kota:", err);
                    showToast('error', 'Gagal memuat data kota');
                    $(kotaSelect).prop('disabled', false);
                }
            });

            // Handle clear selection
            $(provinsiSelect).on('select2:clear', function() {
                $(kotaSelect).empty().append('<option value="">Pilih kabupaten/kota</option>').trigger(
                    'change');
            });
        });
    </script>


    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('upload-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function showToast(type, message) {
            const toastContainer = document.getElementById('toast-container');
            const bgColor = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500'
            } [type] || 'bg-gray-700';

            const toast = document.createElement('div');
            toast.className = `toast px-4 py-3 rounded-lg shadow-lg text-white ${bgColor} opacity-0 translate-y-5`;
            toast.innerHTML = `
            <div class="flex items-center justify-between">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white font-bold">×</button>
            </div>
        `;
            toastContainer.appendChild(toast);

            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // === Laravel session & error binding ===
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                showToast('success', '{{ session('success') }}');
            @endif

            @if (session('error'))
                showToast('error', '{{ session('error') }}');
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showToast('error',
                        '{{ str_replace(['The ', ' field is required.', ' must be an image.', ' may not be greater than 2048 kilobytes.', ' may not be greater than 255 characters.'], ['Kolom ', ' wajib diisi.', ' harus berupa gambar.', ' maksimal ukuran 2MB.', ' maksimal 255 karakter.'], $error) }}'
                    );
                @endforeach
            @endif
        });
    </script>
</body>

</html>
