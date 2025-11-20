<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Animasi muncul */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Animasi icon check */
        @keyframes pop {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-pop {
            animation: pop 0.4s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex justify-center items-center p-6">

    <div class="bg-white p-10 rounded-2xl shadow-2xl max-w-lg w-full text-center animate-fadeInUp">

        <!-- ICON CHECK -->
        <div
            class="mx-auto mb-6 bg-green-100 w-20 h-20 rounded-full flex items-center justify-center animate-pop shadow-md">
            <span class="text-green-600 text-5xl">✔</span>
        </div>

        <!-- TITLE -->
        <h2 class="text-2xl font-extrabold text-gray-800 leading-snug mb-4">
            TERIMA KASIH TELAH MELAKUKAN PENDAFTARAN <br>
            <span class="text-blue-600">WISATA LITERASI NASIONAL JAWA BARAT</span>
        </h2>

        <!-- MESSAGE -->
        <p class="text-gray-700 leading-relaxed mb-6">
            Untuk melanjutkan proses pendaftaran, mohon konfirmasi dengan mengirimkan
            <strong>screenshot bukti telah mengisi form</strong> ke admin:
        </p>

        <!-- CONTACT BOX -->
        <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-6">
            <p class="text-lg font-semibold text-blue-700">📲 0811-xxxx-xxx</p>
            <p class="text-sm text-blue-500">(Admin WLN - Jabar)</p>
        </div>

        <!-- FOOTER TEXT -->
        <p class="text-gray-700 leading-relaxed">
            Untuk informasi selanjutnya, Bapak/Ibu dapat langsung menghubungi admin yang tertera.
            <br><br>
            Salam Literasi 📚✨<br>
            <span class="font-semibold text-gray-900">Admin WLN & ALI 2026</span>
        </p>

        <!-- BUTTON -->
        <a href="/"
            class="mt-8 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition shadow-md">
            Kembali ke Beranda
        </a>

    </div>

</body>

</html>
