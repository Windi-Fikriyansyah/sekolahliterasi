<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pendaftaran</title>
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
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
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-text-light dark:text-text-dark">
    <div class="max-w-md mx-auto">
        <header class="p-4 sticky top-0 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm z-10">
            <h1 class="text-xl font-bold text-center">Pendaftaran</h1>
        </header>
        <main class="p-4 space-y-6">
            <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
                class="p-4 space-y-6">
                @csrf
                <input type="hidden" name="id_product" value="{{ $product->id }}">
                <div class="space-y-4">
                    <label class="block space-y-2">
                        <span class="text-sm font-medium">Nama Lengkap + Titel</span>
                        <input
                            class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary placeholder:text-subtext-light dark:placeholder:text-subtext-dark"
                            placeholder="Masukkan nama lengkap dan gelar" name="nama_lengkap" type="text" />
                    </label>
                    <label class="block space-y-2">
                        <span class="text-sm font-medium">Asal Instansi</span>
                        <input
                            class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary placeholder:text-subtext-light dark:placeholder:text-subtext-dark"
                            placeholder="Masukkan asal instansi" name="asal_instansi" type="text" />
                    </label>
                    <label class="block space-y-2">
                        <span class="text-sm font-medium">Profesi/Jabatan</span>
                        <input
                            class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary placeholder:text-subtext-light dark:placeholder:text-subtext-dark"
                            placeholder="Masukkan profesi atau jabatan" name="profesi" type="text" />
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="block space-y-2">
                            <span class="text-sm font-medium">Kabupaten/Kota</span>
                            <input
                                class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary placeholder:text-subtext-light dark:placeholder:text-subtext-dark"
                                placeholder="Pilih kabupaten atau kota" name="kota" type="text" />
                        </label>
                        <label class="block space-y-2">
                            <span class="text-sm font-medium">Provinsi</span>
                            <input
                                class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary placeholder:text-subtext-light dark:placeholder:text-subtext-dark"
                                placeholder="Pilih provinsi" name="provinsi" type="text" />
                        </label>
                    </div>
                    <label class="block space-y-2">
                        <span class="text-sm font-medium">No WhatsApp</span>
                        <input
                            class="form-input w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary placeholder:text-subtext-light dark:placeholder:text-subtext-dark"
                            placeholder="Masukkan nomor WhatsApp" name="no_wa" type="tel" />
                    </label>
                </div>
                <hr class="border-border-light dark:border-border-dark" />
                <div class="space-y-4">
                    <h2 class="text-lg font-bold">Unggah Dokumen</h2>
                    <div class="space-y-2">
                        <label class="text-sm font-medium" for="photo-upload">Upload Foto terbaik Anda</label>
                        <div class="flex items-center justify-center w-full">
                            <label
                                class="relative flex flex-col items-center justify-center w-full h-32 border-2 border-border-light dark:border-border-dark border-dashed rounded-lg cursor-pointer bg-input-bg-light dark:bg-input-bg-dark hover:bg-primary/5 dark:hover:bg-primary/10 overflow-hidden"
                                for="photo-upload">

                                <!-- Area default (ikon + teks) -->
                                <div id="upload-placeholder"
                                    class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg aria-hidden="true"
                                        class="w-8 h-8 mb-2 text-subtext-light dark:text-subtext-dark" fill="none"
                                        viewBox="0 0 20 16" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"></path>
                                    </svg>
                                    <p class="text-xs text-subtext-light dark:text-subtext-dark"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                </div>

                                <!-- Preview foto -->
                                <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden"
                                    alt="Preview Foto" />

                                <input class="hidden" name="foto" id="photo-upload" type="file" accept="image/*"
                                    onchange="previewImage(event)" />
                            </label>
                        </div>
                    </div>

                </div>
                <hr class="border-border-light dark:border-border-dark" />
                <div class="space-y-4">
                    <h2 class="text-lg font-bold">Alamat Pengiriman</h2>
                    <p class="text-sm text-subtext-light dark:text-subtext-dark">
                        Alamat lengkap untuk pengiriman buku "kitab suci penulis atau Guru Ndeso Inspirator"
                    </p>
                    <label class="block space-y-2">
                        <span class="text-sm font-medium">Alamat Lengkap</span>
                        <textarea
                            class="form-textarea w-full rounded-lg bg-input-bg-light dark:bg-input-bg-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary placeholder:text-subtext-light dark:placeholder:text-subtext-dark min-h-[8rem]"
                            placeholder="Nama jalan/gang, kelurahan/desa/kecamatan, kota/kabupaten/provinsi" name="alamat"></textarea>
                    </label>
                </div>
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
                    placeholder.classList.add('hidden'); // sembunyikan ikon upload
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

            // animasi muncul
            setTimeout(() => toast.classList.add('show'), 100);
            // otomatis hilang
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
