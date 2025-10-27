<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pendaftaran Program</title>
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
                    <label class="block">
                        <span class="font-medium">Kabupaten/Kota *</span>
                        <input type="text" name="kota" class="w-full mt-1 p-2 border rounded-lg" required>
                    </label>
                    <label class="block">
                        <span class="font-medium">Provinsi *</span>
                        <input type="text" name="provinsi" class="w-full mt-1 p-2 border rounded-lg" required>
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
