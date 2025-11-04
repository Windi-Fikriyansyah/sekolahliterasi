<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pendaftaran Program</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        .hidden {
            display: none;
        }

        .active-step {
            background-color: #1173d4;
            color: white;
        }

        .step {
            transition: all 0.3s ease;
        }

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
</head>

<body class="bg-gray-100 font-sans text-gray-900">
    <div class="max-w-2xl mx-auto my-10 bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">Pendaftaran Program SIM Nasional</h1>

        <!-- Step indicator -->
        <div class="flex justify-center mb-8 space-x-2">
            <div id="indicator-step-1"
                class="step w-8 h-8 flex items-center justify-center rounded-full border border-blue-500 text-blue-500 font-semibold">
                1
            </div>
            <div class="w-10 h-1 bg-blue-300 mt-3"></div>
            <div id="indicator-step-2"
                class="step w-8 h-8 flex items-center justify-center rounded-full border border-gray-400 text-gray-400 font-semibold">
                2
            </div>
        </div>

        <form id="multiStepForm" action="{{ route('pendaftaranSekolah.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_product" value="{{ $product->id }}">
            <!-- STEP 1 -->
            <div id="step-1" class="space-y-4">
                <h2 class="text-lg font-bold text-blue-600 mb-4">Data Sekolah/Organisasi</h2>

                <label class="block">
                    <span class="font-medium">Nama Sekolah/Organisasi *</span>
                    <input type="text" name="nama_sekolah" placeholder="Nama sekolah atau organisasi"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <label class="block">
                    <span class="font-medium">NPSN (Nomor Pokok Sekolah Nasional)</span>
                    <input type="text" name="npsn" placeholder="Contoh: 12345678"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <label class="block">
                    <span class="font-medium">Kategori *</span>
                    <select name="kategori" class="w-full mt-1 p-2 border rounded-lg bg-white" required>
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="SD">SD</option>
                        <option value="MI">MI</option>
                        <option value="SMP">SMP</option>
                        <option value="MTs">MTs</option>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                        <option value="MA">MA</option>
                        <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                        <option value="Komunitas/Organisasi">Komunitas/Organisasi</option>
                        <option value="Masyarakat Umum">Masyarakat Umum</option>
                    </select>
                </label>

                <label class="block">
                    <span class="font-medium">Alamat Lengkap Sekolah/Organisasi/Perguruan Tinggi *</span>
                    <textarea name="alamat" rows="3"
                        placeholder="Tuliskan alamat lengkap dengan jalan, kelurahan, kecamatan, dan kode pos"
                        class="w-full mt-1 p-2 border rounded-lg" required></textarea>
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="block space-y-2">
                        <span class="text-sm font-medium">Provinsi</span>
                        <select id="provinsi" name="provinsi" class="select2-provinsi w-full" required>
                            <option value="">Pilih provinsi</option>
                        </select>
                    </label>

                    <label class="block space-y-2">
                        <span class="text-sm font-medium">Kabupaten/Kota</span>
                        <select id="kota" name="kota" class="select2-kota w-full" required>
                            <option value="">Pilih kabupaten/kota</option>
                        </select>
                    </label>
                </div>


                <label class="block">
                    <span class="font-medium">Nama Lengkap Kepala Sekolah/Ketua Organisasi/Pimpinan Instansi *</span>
                    <input type="text" name="kepala" placeholder="Nama lengkap + gelar"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <label class="block">
                    <span class="font-medium">Nomor HP / WhatsApp Kepala Sekolah *</span>
                    <input type="tel" name="hp_kepala" placeholder="Contoh: 081320009207"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <label class="block">
                    <span class="font-medium">Nama Lengkap Koordinator Literasi *</span>
                    <input type="text" name="koordinator" placeholder="Nama koordinator literasi"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <label class="block">
                    <span class="font-medium">Nomor WhatsApp Koordinator Literasi *</span>
                    <input type="tel" name="wa_koordinator" placeholder="Contoh: 081320009207"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <label class="block">
                    <span class="font-medium">Total Jumlah Siswa di Sekolah Anda *</span>
                    <input type="number" name="total_siswa" placeholder="Contoh: 1500"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <div class="flex justify-end mt-6">
                    <button type="button" id="nextBtn"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Lanjut
                        ke Step 2 →</button>
                </div>
            </div>

            <!-- STEP 2 -->
            <div id="step-2" class="hidden space-y-4">
                <h2 class="text-lg font-bold text-blue-600 mb-4">Data Peserta Program</h2>

                <label class="block">
                    <span class="font-medium">Total Jumlah Siswa yang Didaftarkan dalam Program SIM Nasional *</span>
                    <input type="number" name="jumlah_siswa_daftar" placeholder="Contoh: 200"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <label class="block">
                    <span class="font-medium">Total Jumlah Guru/Peserta Umum yang Didaftarkan *</span>
                    <input type="number" name="jumlah_guru_daftar" placeholder="Contoh: 20"
                        class="w-full mt-1 p-2 border rounded-lg" required>
                </label>

                <label class="block">
                    <span class="font-medium">Kategori Karya yang Akan Diikutsertakan *</span>
                    <div class="flex flex-col space-y-2 mt-2">
                        <label><input type="checkbox" name="kategori_karya[]" value="Puisi"
                                class="mr-2">Puisi</label>
                        <label><input type="checkbox" name="kategori_karya[]" value="Pengalaman Pribadi"
                                class="mr-2">Pengalaman Pribadi</label>
                        <label><input type="checkbox" name="kategori_karya[]" value="Cerpen"
                                class="mr-2">Cerpen</label>
                        <label><input type="checkbox" name="kategori_karya[]" value="Opini Kreatif"
                                class="mr-2">Opini Kreatif</label>
                    </div>
                </label>

                <label class="block">
                    <span class="font-medium">Dari mana sumber pembiayaan peserta Anda? *</span>
                    <select name="sumber_biaya" class="w-full mt-1 p-2 border rounded-lg bg-white" required>
                        <option value="" disabled selected>Pilih</option>
                        <option value="Dana BOSP (Tersedia Di SIPLah)">Dana BOSP (Tersedia Di SIPLah)</option>
                        <option value="Dana Mandiri Sekolah/Yayasan/Kampus/Organisasi">Dana Mandiri
                            Sekolah/Yayasan/Kampus/Organisasi</option>
                        <option value="Iuran Siswa atau Walimurid/Mahasiswa/Umum">Iuran Siswa atau
                            Walimurid/Mahasiswa/Umum</option>
                        <option value="Campuran 2 atau 3 Sumber">Campuran 2 atau 3 Sumber</option>
                    </select>
                </label>


                <label class="block">
                    <span class="font-medium">Testimoni terbaik tentang program SIM Nasional</span>
                    <textarea name="testimoni" rows="3" placeholder="Tuliskan kesan, manfaat, atau pengalaman Anda"
                        class="w-full mt-1 p-2 border rounded-lg"></textarea>
                </label>

                <label class="block">
                    <span class="font-medium">Nama Fasilitator Program Literasi Nasional</span>
                    <input type="text" name="fasilitator" placeholder="Isi jika ada (boleh kosong)"
                        class="w-full mt-1 p-2 border rounded-lg">
                </label>

                <div class="flex justify-between mt-6">
                    <button type="button" id="prevBtn"
                        class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500 transition">←
                        Kembali</button>
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">Kirim
                        Pendaftaran</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        const step1 = document.getElementById("step-1");
        const step2 = document.getElementById("step-2");
        const nextBtn = document.getElementById("nextBtn");
        const prevBtn = document.getElementById("prevBtn");
        const indicator1 = document.getElementById("indicator-step-1");
        const indicator2 = document.getElementById("indicator-step-2");

        nextBtn.addEventListener("click", () => {
            step1.classList.add("hidden");
            step2.classList.remove("hidden");
            indicator1.classList.remove("active-step");
            indicator1.classList.add("border-gray-300", "text-gray-400");
            indicator2.classList.add("active-step");
        });

        prevBtn.addEventListener("click", () => {
            step2.classList.add("hidden");
            step1.classList.remove("hidden");
            indicator2.classList.remove("active-step");
            indicator1.classList.add("active-step");
        });
    </script>
</body>

</html>
