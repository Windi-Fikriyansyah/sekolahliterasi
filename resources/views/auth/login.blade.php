<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | EduCourse</title>
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
        <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-8 space-y-6">
            <div class="text-center">
                <img src="{{ asset('image/logo.png') }}" alt="EduCourse" class="mx-auto h-16 mb-4">
                <h2 class="text-2xl font-bold text-secondary">Selamat Datang Kembali</h2>
                <p class="text-gray-500 text-sm">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" name="password" id="password" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="text-primary focus:ring-primary rounded">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-secondary hover:text-primary">Lupa sandi?</a>
                </div>

                <button type="submit"
                    class="w-full py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition-all transform hover:scale-[1.02]">
                    Masuk
                </button>
            </form>

            <p class="text-center text-gray-600 text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-secondary hover:text-primary font-semibold">Daftar
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
