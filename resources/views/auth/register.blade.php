<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | EduCourse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#fba615',
                        secondary: '#0977c2',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-xl w-full max-w-2xl p-8 space-y-6">
            <!-- Header -->
            <div class="text-center">
                <img src="{{ asset('image/logo.png') }}" alt="EduCourse" class="mx-auto h-16 mb-4">
                <h2 class="text-2xl font-bold text-secondary">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm">Lengkapi data berikut untuk mendaftar</p>
            </div>

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama -->

                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama
                            Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Nama Lengkap Anda">
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP
                            (WhatsApp)</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="08xxxxxxxxxx">
                    </div>

                    <!-- Kabupaten -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>

                    <div>
                        <label for="kabupaten" class="block text-sm font-medium text-gray-700">Kabupaten / Kota</label>
                        <input type="text" name="kabupaten" id="kabupaten" value="{{ old('kabupaten') }}" required
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>

                    <!-- Provinsi -->
                    <div>
                        <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi') }}" required
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>

                    <!-- Instansi -->
                    <div>
                        <label for="instansi" class="block text-sm font-medium text-gray-700">Instansi /
                            Universitas</label>
                        <input type="text" name="instansi" value="{{ old('instansi') }}" id="instansi"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Opsional">
                    </div>

                    <div>
                        <label for="profesi" class="block text-sm font-medium text-gray-700">Profesi</label>
                        <input type="text" name="profesi" id="profesi" value="{{ old('profesi') }}"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Guru/Siswa/Mahasiswa/Pelajar/Umum">
                    </div>





                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                        <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Kata
                            Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Ketik ulang kata sandi">
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="2" required
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">{{ old('alamat') }}</textarea>
                    </div>

                    <input type="hidden" id="role" name="role" value="user" required>




                </div>

                <button type="submit"
                    class="w-full py-2 mt-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition-all transform hover:scale-[1.02] font-medium">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-gray-600 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-secondary hover:text-primary font-semibold">Masuk
                    Sekarang</a>
            </p>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Buat container kalau belum ada
                let container = document.getElementById("toast-container");
                if (!container) {
                    container = document.createElement("div");
                    container.id = "toast-container";
                    container.style.position = "fixed";
                    container.style.top = "20px";
                    container.style.right = "20px";
                    container.style.zIndex = "9999";
                    container.style.display = "flex";
                    container.style.flexDirection = "column";
                    container.style.gap = "10px"; // jarak antar toast
                    document.body.appendChild(container);
                }

                @foreach ($errors->all() as $error)
                    showToast("{{ $error }}");
                @endforeach

                function showToast(message) {
                    let toast = document.createElement("div");
                    toast.innerText = message;
                    toast.style.background = "#e74c3c";
                    toast.style.color = "white";
                    toast.style.padding = "12px 20px";
                    toast.style.borderRadius = "8px";
                    toast.style.boxShadow = "0 4px 12px rgba(0,0,0,0.2)";
                    toast.style.opacity = "0";
                    toast.style.transition = "opacity 0.5s ease";
                    toast.style.fontSize = "14px";
                    toast.style.fontWeight = "500";

                    container.appendChild(toast);

                    // animasi muncul
                    setTimeout(() => {
                        toast.style.opacity = "1";
                    }, 100);

                    // hilang setelah 4 detik
                    setTimeout(() => {
                        toast.style.opacity = "0";
                        setTimeout(() => toast.remove(), 500);
                    }, 4000);
                }
            });
        </script>
    @endif
</body>

</html>
