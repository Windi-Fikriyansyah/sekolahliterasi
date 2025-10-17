<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru Inspirator Literasi 2.0 - Menginspirasi Negeri, Menyalakan Literasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Reset dan variabel */
        :root {
            --primary: #1a56db;
            --primary-dark: #1e3a8a;
            --secondary: #059669;
            --accent: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --light-gray: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            color: var(--dark);
            line-height: 1.6;
            background-color: #ffffff;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .header-top {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 10;
        }

        .header-top img {
            height: 60px;
            width: auto;
            border-radius: 8px;
            background: white;
            padding: 5px;
        }

        header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMTIwMCA4MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0iIzAwMCIgZmlsbC1vcGFjaXR5PSIwLjEiPjxwYXRoIGQ9Ik0wIDQwMEwxMjAwIDQwMEwxMjAwIDgwMEwwIDgwMFoiLz48L2c+PC9zdmc+');
            opacity: 0.1;
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .hero-image {
            max-width: 250px;
            margin: 30px auto 0;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .tagline {
            font-size: 1.2rem;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .intro-text {
            max-width: 800px;
            margin: 0 auto 10px;
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .cta-button {
            display: inline-block;
            background-color: var(--accent);
            color: var(--dark);
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-top: 25px;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            background-color: #fbbf24;
        }

        @media (max-width: 768px) {
            .header-top {
                top: 10px;
                left: 10px;
                gap: 10px;
            }

            .header-top img {
                height: 45px;
            }

            .hero-image {
                max-width: 180px;
                margin-top: 20px;
            }

            .intro-text {
                font-size: 1rem;
            }

            header {
                padding-top: 100px;
            }
        }


        #tentang .content-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 40px;
        }

        #tentang .text {
            flex: 1;
            min-width: 300px;
        }

        #tentang .image {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }

        #tentang .image img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Sections */
        section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }

        .section-title h2 {
            font-size: 2.2rem;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }

        .section-title::after {
            content: "";
            display: block;
            width: 80px;
            height: 4px;
            background: var(--accent);
            margin: 0 auto;
            border-radius: 2px;
        }

        .section-subtitle {
            text-align: center;
            color: white;
            max-width: 700px;
            margin: 0 auto 40px;
            font-size: 1.1rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .quote {
            font-style: italic;
            border-left: 4px solid var(--accent);
            padding-left: 20px;
            margin: 30px 0;
            color: var(--gray);
        }

        .quote-author {
            font-weight: 600;
            color: var(--dark);
            margin-top: 10px;
        }

        /* Timeline */
        .timeline {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--light-gray);
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 50px;
            width: 100%;
        }

        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: 0;
            margin-right: calc(50% + 30px);
            text-align: right;
        }

        .timeline-item:nth-child(even) .timeline-content {
            margin-left: calc(50% + 30px);
        }

        .timeline-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .timeline-content::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--primary);
            border-radius: 50%;
            top: 20px;
        }

        .timeline-item:nth-child(odd) .timeline-content::before {
            right: -40px;
        }

        .timeline-item:nth-child(even) .timeline-content::before {
            left: -40px;
        }

        .timeline-date {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }

        /* Benefits */
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .benefit-item {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .benefit-item:hover {
            transform: translateY(-5px);
        }

        .benefit-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--primary);
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            border-radius: 8px;
            overflow: hidden;
            height: 200px;
            background-color: var(--light-gray);
            position: relative;
        }

        .gallery-item::before {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--gray);
        }

        /* Reward Section */
        .reward-section {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .reward-section .section-title h2 {
            color: white;
        }

        .reward-section .section-title::after {
            background: var(--accent);
        }

        .reward-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .reward-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .reward-card h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .reward-card ul {
            list-style-type: none;
        }

        .reward-card li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
        }

        .reward-card li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--accent);
            font-weight: bold;
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            color: var(--accent);
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .footer-column p,
        .footer-column a {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 10px;
            display: block;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            position: relative;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.3rem;
        }

        .social-link:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }



        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .timeline::before {
                left: 30px;
            }

            .timeline-item:nth-child(odd) .timeline-content,
            .timeline-item:nth-child(even) .timeline-content {
                margin-left: 70px;
                margin-right: 0;
                text-align: left;
            }

            .timeline-item:nth-child(odd) .timeline-content::before,
            .timeline-item:nth-child(even) .timeline-content::before {
                left: -40px;
            }

            header {
                padding: 80px 0 60px;
            }

            section {
                padding: 60px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-top">
            <!-- Ganti src sesuai lokasi gambar logo -->
            <img src="{{ asset('image/Picture2.png') }}" alt="Logo 1">
            <img src="{{ asset('image/Picture3.png') }}" alt="Logo 2">
        </div>

        <div class="container hero-content">
            <h1>PROGRAM BERGENGSI NASIONAL<br>GURU INSPIRATOR LITERASI 2.0</h1>
            <div class="tagline">Menginspirasi Negeri, Menyalakan Literasi Tahun 2025</div>
            <p class="intro-text">Sebuah Gerakan Nasional bagi Guru yang Siap Menjadi Cahaya Perubahan!</p>
            <p class="intro-text">Program Sinergi Literasi 2# di Indonesia</p>

            <!-- Gambar Hero -->
            <img src="{{ asset('image/Picture1.png') }}" alt="Guru Inspirator Literasi" class="hero-image">
        </div>
    </header>

    <!-- Tentang Program -->
    <section id="tentang">
        <div class="container">
            <div class="section-title">
                <h2>✨ Tentang Program</h2>
            </div>

            <div class="content-wrapper">
                <div class="text">
                    <div class="card">
                        <p>Di tengah derasnya arus teknologi dan perubahan zaman, Indonesia membutuhkan guru-guru luar
                            biasa,
                            pendidik yang bukan hanya mengajar, tetapi juga menginspirasi.</p>
                        <p>Program Guru Inspirator Literasi 2.0 adalah gerakan nasional yang digagas oleh Forum
                            Indonesia
                            Menulis, untuk melahirkan agen perubahan pendidikan yang menyalakan semangat literasi,
                            membangun
                            karakter bangsa, dan menjadi promotor utama Wisata Literasi Nasional.</p>
                        <blockquote style="border-left:4px solid var(--accent); padding-left:15px; margin-top:15px;">
                            “Literasi bukan hanya milik kota besar. Literasi dimulai dari halaman rumah kita
                            sendiri.”<br>
                            <strong>- Fakhrul Arrazi, Founder Forum Indonesia Menulis</strong>
                        </blockquote>
                    </div>
                </div>

                <div class="image">
                    <img src="{{ asset('image/Picture3.png') }}" alt="Tentang Program Guru Inspirator Literasi">
                </div>
            </div>
        </div>
    </section>
    <!-- Wisata Literasi Nasional -->
    <!-- Wisata Literasi Nasional -->
    <section id="wln" style="background-color: #f8fafc;">
        <div class="container">
            <div class="section-title">
                <!-- ✅ Dua logo di atas judul -->
                <div
                    style="display: flex; justify-content: center; align-items: center; gap: 30px; margin-bottom: 25px;">
                    <img src="{{ asset('image/Picture6.png') }}" alt="Logo WLN 1" style="height: 80px; width: auto;">
                    <img src="{{ asset('image/Picture7.png') }}" alt="Logo WLN 2" style="height: 80px; width: auto;">
                </div>

                <h2>WISATA LITERASI NASIONAL & ANUGERAH LITERASI INDONESIA</h2>
                <p class="section-subtitle">Pesta Raya Literasi Terbesar di Tanah Air</p>
            </div>

            <div class="card">
                <p>Wisata Literasi Nasional (WLN) dan Anugerah Literasi Indonesia (ALI) merupakan ajang prestisius
                    tahunan yang menjadi magnet bagi ribuan pendidik, pegiat literasi, dan tokoh inspiratif dari seluruh
                    penjuru negeri. Sebuah perhelatan akbar yang menghadirkan semangat kebangkitan literasi nasional,
                    membumikan literasi, menggerakkan peradaban bangsa.</p>
                <p>Dalam satu panggung besar, WLN & ALI menghadirkan rangkaian kegiatan luar biasa: Seminar Literasi
                    Nasional, Peluncuran Buku, Panggung Apresiasi & Hiburan Inspiratif, hingga puncak acara Anugerah
                    Literasi Indonesia, sebuah momentum bersejarah untuk mengangkat karya, merayakan prestasi, dan
                    menyalakan obor literasi bangsa.</p>
                <p>Anugerah Literasi Indonesia (ALI) merupakan bentuk penghargaan tertinggi bagi para Guru Inspirator,
                    Tokoh Literasi, dan Pejabat Publik yang telah menunjukkan dedikasi luar biasa dalam menumbuhkan
                    budaya literasi, menggerakkan ekosistem belajar, dan mendukung kemajuan pendidikan di Indonesia.</p>
                <p>Penghargaan ini menjadi simbol apresiasi atas kerja nyata mereka yang tanpa lelah menyalakan obor
                    literasi di berbagai pelosok negeri, menginspirasi, mengedukasi, dan membawa perubahan nyata bagi
                    generasi bangsa.</p>
                <p>Melalui ALI, Indonesia memberi penghormatan kepada para pejuang literasi yang telah menjadikan
                    literasi bukan sekadar gerakan, melainkan napas peradaban dan fondasi kemajuan bangsa.</p>
            </div>

            <!-- ✅ Tambahan 3 gambar dokumentasi -->
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-top: 40px;">
                <div
                    style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <img src="{{ asset('image/Picture4.png') }}" alt="Dokumentasi WLN 1"
                        style="width: 100%; height: 220px; object-fit: cover;">
                </div>
                <div
                    style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <img src="{{ asset('image/Picture8.png') }}" alt="Dokumentasi WLN 2"
                        style="width: 100%; height: 220px; object-fit: cover;">
                </div>
                <div
                    style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <img src="{{ asset('image/Picture9.png') }}" alt="Dokumentasi WLN 3"
                        style="width: 100%; height: 220px; object-fit: cover;">
                </div>
            </div>
        </div>
    </section>


    <!-- Jejak Literasi -->
    <section id="jejak">
        <div class="container">
            <div class="section-title">
                <h2>JEJAK LITERASI</h2>
                <p class="section-subtitle">WISATA LITERASI NASIONAL (WLN) & ANUGERAH LITERASI INDONESIA (ALI)<br>Sukses
                    Terselenggara di Berbagai Wilayah Tanah Air</p>
            </div>
            <p style="text-align: center; margin-bottom: 30px;">Berikut dokumentasi pelaksanaan Wisata Literasi Nasional
                & Anugerah Literasi Indonesia yang telah sukses terselenggara di berbagai kota di Indonesia. Setiap kota
                menghadirkan semangat, inspirasi, dan karya literasi yang luar biasa, menjadi bukti nyata bahwa gerakan
                literasi kini semakin hidup dan meriah di seluruh Nusantara.</p>

            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture5.png') }}" alt="Dokumentasi 1"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture10.png') }}" alt="Dokumentasi 2"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture11.png') }}" alt="Dokumentasi 3"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture12.png') }}" alt="Dokumentasi 4"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture13.png') }}" alt="Dokumentasi 5"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture14.png') }}" alt="Dokumentasi 6"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture15.png') }}" alt="Dokumentasi 6"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture16.png') }}" alt="Dokumentasi 6"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture17.png') }}" alt="Dokumentasi 6"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('image/Picture18.png') }}" alt="Dokumentasi 6"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
            </div>
        </div>
    </section>

    <!-- Reward & Apresiasi -->
    <section id="reward" class="reward-section">
        <div class="container">
            <div class="section-title">
                <h2>REWARD & APRESIASI</h2>
                <p class="section-subtitle">- Pejabat Publik - Tokoh Pendidikan - Guru Inspirator Literasi 2.0 - GIL
                    Mitra Literasi Nasional</p>
            </div>

            <div class="reward-cards">
                <div class="reward-card">
                    <h3>🏆 Anugerah Literasi Indonesia</h3>
                    <h4>A. Kategori: Pejabat Publik</h4>
                    <p>Anugerah Literasi Indonesia Kategori Pejabat Publik merupakan penghargaan tertinggi bagi para
                        pemimpin daerah dan tokoh pemerintahan yang menunjukkan komitmen visioner dan aksi nyata dalam
                        mengembangkan ekosistem literasi serta memajukan pendidikan di Indonesia.</p>
                </div>

                <div class="reward-card">
                    <h4>B. Kategori Tokoh Pendidikan</h4>
                    <p>Anugerah Literasi Indonesia Kategori Tokoh Pendidikan merupakan penghargaan tertinggi bagi para
                        tokoh berpengaruh, pemimpin lembaga, dan penggerak pendidikan yang telah menunjukkan dedikasi,
                        inovasi, dan kontribusi nyata dalam menumbuhkan budaya literasi di masyarakat.</p>
                </div>

                <div class="reward-card">
                    <h4>C. Kategori Guru Inspirator Literasi</h4>
                    <p>Anugerah Literasi Indonesia Kategori Guru Inspirator Literasi merupakan penghargaan tertinggi
                        bagi para pendidik dan penggerak literasi yang telah menunjukkan dedikasi, kreativitas, dan
                        komitmen luar biasa dalam menumbuhkan budaya literasi di lingkungan sekolah dan masyarakat.</p>
                </div>
            </div>

            <div class="reward-card" style="margin-top: 30px;">
                <h3>🏆 Anugerah Literasi Indonesia Kategori: GIL Mitra Literasi Nasional</h3>
                <p>Kategori GIL Mitra Literasi Nasional diberikan kepada guru penggerak literasi yang secara konsisten
                    mendedikasikan diri setiap tahun untuk memajukan literasi di berbagai wilayah Indonesia. Penghargaan
                    ini menegaskan peran guru sebagai mitra strategis dalam membangun ekosistem literasi yang
                    berkelanjutan dan berdampak luas.</p>
                <p>GIL penerima penghargaan ini adalah sosok yang:</p>
                <ul>
                    <li>Aktif menginisiasi dan menggerakkan kegiatan literasi di sekolah maupun masyarakat.</li>
                    <li>Menjalin kolaborasi erat dengan instansi terkait, seperti Dinas Pendidikan, Dinas Perpustakaan,
                        hingga sekolah-sekolah mitra.</li>
                    <li>Berkomitmen tinggi menjaga keberlanjutan program literasi di tingkat lokal maupun nasional.</li>
                    <li>Menjadi teladan inspiratif bagi rekan guru, siswa, dan komunitas literasi di sekitarnya.</li>
                    <li>Siap menjadi tim dalam penyelenggaraan event literasi nasional dan Internasional dari Forum
                        Indonesia Menulis</li>
                </ul>
                <p>Reward yang diberikan:</p>
                <ul>
                    <li>Gratis mengikuti berbagai event Nasional maupun Internasional yang diselenggarakan oleh Forum
                        Indonesia Menulis (transport dan akomodasi ditanggung FIM)</li>
                    <li>Menjadi Pembicara Nasional maupun Internasional Forum Indonesia Menulis di berbagai event</li>
                    <li>Reward hadiah uang tunai jutaan rupiah</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Reward Utama -->
    <!-- Reward Utama -->
    <section id="reward-utama" style="background-color: #ffffff;">
        <div class="container">
            <div class="section-title">
                <h2>REWARD UTAMA</h2>
                <p class="section-subtitle" style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                    SINGAPURA – MALAYSIA – THAILAND
                </p>
            </div>

            <!-- ✅ Tambahkan gambar destinasi -->
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 40px;">
                <div
                    style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <img src="{{ asset('image/Picture19.png') }}" alt="Reward Singapura"
                        style="width: 100%; height: 220px; object-fit: cover;">
                    <div style="padding: 10px; text-align: center; font-weight: 600; color: var(--primary-dark);">
                        Singapura</div>
                </div>
                <div
                    style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <img src="{{ asset('image/Picture19.png') }}" alt="Reward Malaysia"
                        style="width: 100%; height: 220px; object-fit: cover;">
                    <div style="padding: 10px; text-align: center; font-weight: 600; color: var(--primary-dark);">
                        Malaysia</div>
                </div>
                <div
                    style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <img src="{{ asset('image/Picture19.png') }}" alt="Reward Thailand"
                        style="width: 100%; height: 220px; object-fit: cover;">
                    <div style="padding: 10px; text-align: center; font-weight: 600; color: var(--primary-dark);">
                        Thailand</div>
                </div>
            </div>

            <div class="card">
                <h3>Tour Aksara Internasional</h3>
                <p style="font-style: italic; margin-bottom: 20px;">Bukan sekadar tour, ini adalah gerbang menuju dunia
                    literasi global!</p>
                <p>Tour yang menghadirkan pengalaman luar biasa: perpaduan wisata edukasi, kompetisi, event
                    internasional, serta eksplorasi budaya, teknologi, dan kreativitas dunia.</p>
                <p>Mengikuti program ini berarti Anda siap:</p>
                <ul style="list-style-type: none; margin: 20px 0;">
                    <li style="margin-bottom: 10px; padding-left: 25px; position: relative;">🚀 <strong>Menjadi duta
                            literasi Indonesia</strong> di panggung internasional.</li>
                    <li style="margin-bottom: 10px; padding-left: 25px; position: relative;">🌍 <strong>Menggali
                            inspirasi</strong>
                        dari sistem pendidikan, budaya, dan inovasi negara maju.</li>
                    <li style="margin-bottom: 10px; padding-left: 25px; position: relative;">🏆 <strong>Berkompetisi &
                            tampil</strong> dalam ajang literasi bergengsi tingkat dunia.</li>
                    <li style="margin-bottom: 10px; padding-left: 25px; position: relative;">🎭 <strong>Menikmati
                            wisata
                            kreatif</strong> yang sarat makna, menggabungkan literasi, seni, dan teknologi modern.</li>
                </ul>
                <p>Tour Aksara Internasional bukan hanya perjalanan, melainkan pengalaman berharga yang akan membentuk
                    generasi berprestasi dengan semangat literasi mendunia.</p>
            </div>
        </div>
    </section>


    <!-- Timeline -->
    <section id="timeline" style="background-color: #f8fafc;">
        <div class="container">
            <div class="section-title">
                <h2>TIMELINE PROGRAM</h2>
                <p class="section-subtitle">GURU INSPIRATOR LITERASI 2.0<br>"Menginspirasi Negeri, Menyalakan Literasi"
                </p>
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">30 Oktober 2025</div>
                        <h3>Pengumuman Kandidat GIL 2.0 Terpilih</h3>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">12 November 2025</div>
                        <h3>Training Of Coach Program GIL 2.0</h3>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">13 November – 31 Desember 2025</div>
                        <h3>Diseminasi Kandidat GIL 2.0</h3>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">13 November 2025 – Terlaksana WLN</div>
                        <h3>Pendampingan Kandidat GIL 2.0</h3>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">Sebelum pelaksanaan WLN (13 November 2025 – 15 Juni 2026)</div>
                        <h3>Pembicara Teacher Writer</h3>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">15 April – 19 Juni 2026</div>
                        <h3>Seleksi dan Pendampingan GIL Mitra Literasi Nasional</h3>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">20 Juni 2026</div>
                        <h3>Pengumuman Juara GIL terbaik Nasional</h3>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">25 November 2025 – 20 Juni 2026</div>
                        <h3>Puncak Acara Wisata Literasi Nasional & Anugerah Literasi Indonesia</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Manfaat -->
    <section id="manfaat">
        <div class="container">
            <div class="section-title">
                <h2>Apa yang Anda Dapatkan?</h2>
                <p class="section-subtitle">Menjadi bagian dari GIL 2.0 bukan sekadar mengikuti pelatihan, ini adalah
                    perjalanan transformasi diri dan bangsa!</p>
            </div>

            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-icon">📚</div>
                    <h3>Pelatihan Eksklusif</h3>
                    <p>Belajar langsung dari mentor nasional dan praktisi literasi berpengalaman.</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon">🤝</div>
                    <h3>Pendampingan Intensif & Jejaring Nasional</h3>
                    <p>Bersama ratusan guru inspiratif dari berbagai provinsi, membangun ekosistem literasi
                        berkelanjutan.</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon">📄</div>
                    <h3>E-Sertifikat, Modul Premium, dan Buku Best Seller</h3>
                    <p>Bonus buku "Kitab Suci Penulis" / "30 Hari Sukses Menulis Buku Best Seller".</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon">🏆</div>
                    <h3>Peluang Berprestasi Nasional</h3>
                    <p>Berhak mengikuti Wisata Literasi Nasional & Anugerah Literasi Indonesia, ajang bergengsi bagi
                        pejuang literasi.</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon">🎁</div>
                    <h3>Reward & Penghargaan Eksklusif</h3>
                    <p>Gratis Tour Aksara Internasional ke Singapura – Malaysia – Thailand, hadiah uang tunai jutaan
                        rupiah, dan kesempatan tampil sebagai pembicara nasional maupun internasional.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mengapa Bergabung -->
    <section id="mengapa" style="background-color: var(--primary-dark); color: white;">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;">💡 Mengapa Harus Bergabung?</h2>
            </div>
            <div class="card" style="background: rgba(255, 255, 255, 0.1); color: white; border: none;">
                <p style="text-align: center; font-size: 1.2rem; margin-bottom: 30px;">Karena Anda bukan sekadar guru,
                    Anda adalah pemantik perubahan yang akan:</p>
                <ul style="list-style-type: none; text-align: center;">
                    <li style="margin-bottom: 15px; font-size: 1.1rem;">🔥 Menyalakan semangat literasi di daerah atau
                        wilayah Indonesia</li>
                    <li style="margin-bottom: 15px; font-size: 1.1rem;">🔥 Menggerakkan kolaborasi pendidikan berbasis
                        gotong royong.</li>
                    <li style="margin-bottom: 15px; font-size: 1.1rem;">🔥 Membangun karakter unggul dan budaya
                        literasi berkelanjutan.</li>
                </ul>
                <div class="quote" style="border-left-color: var(--accent); margin-top: 40px; color: var(--accent);">
                    "Literasi adalah jantung peradaban. Tanpa literasi, bangsa hanya akan jadi penonton di tengah arus
                    perubahan."
                    <div class="quote-author" style="color: var(--light); font-weight: 600; margin-top: 8px;">
                        Najwa Shihab
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="daftar"
        style="text-align: center; padding: 100px 0; background: linear-gradient(135deg, var(--secondary), #047857); color: white;">
        <div class="container">
            <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Menuju Indonesia Kiblat Literasi Dunia</h2>
            <p style="max-width: 800px; margin: 0 auto 30px; font-size: 1.2rem;">Bersama Guru Inspirator Literasi 2.0,
                kita menapaki jalan menuju Indonesia yang beradab, berdaya saing, dan berbudaya literasi. Mari buktikan
                bahwa perubahan besar berawal dari guru yang bergerak dan menginspirasi!</p>

            <h3 style="font-size: 1.8rem; margin: 40px 0 20px;">Siap Jadi Pelita Literasi Bangsa?</h3>
            <p style="font-size: 1.3rem; margin-bottom: 30px; font-weight: 600;">Sekaranglah waktunya!</p>
            <p style="margin-bottom: 40px;">Bergabunglah bersama ribuan guru penggerak literasi dari seluruh
                Indonesia.<br>Daftar sekarang dan jadilah bagian dari sejarah gerakan literasi nasional!</p>

            <a href="#" class="cta-button" style="font-size: 1.3rem; padding: 18px 40px;">👉 DAFTAR
                SEKARANG</a>

            <div style="margin-top: 40px;">
                <p style="font-weight: 600; margin-bottom: 10px;">📅 Pendaftaran Kandidat Terbuka hingga 30 Oktober
                    2025</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Forum Indonesia Menulis (FIM)</h3>
                    <p>Sebuah gerakan nasional untuk melahirkan agen perubahan pendidikan yang menyalakan semangat
                        literasi, membangun karakter bangsa, dan menjadi promotor utama Wisata Literasi Nasional.</p>
                </div>

                <div class="footer-column">
                    <h3>Kontak Kami</h3>
                    <p>📱 WhatsApp: 0812-1000-5026</p>
                    <p>📧 Email: fimi.ndonesiamenulis@gmail.com</p>
                    <div class="social-links">
                        <a href="https://www.instagram.com/forumindonesiamenulis" target="_blank" class="social-link"
                            aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@forumindonesiamenulis" target="_blank" class="social-link"
                            aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.facebook.com/forumindonesiamenulis" target="_blank" class="social-link"
                            aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>

                </div>

                <div class="footer-column">
                    <h3>Tautan Cepat</h3>
                    <a href="#tentang">Tentang Program</a>
                    <a href="#wln">Wisata Literasi Nasional</a>
                    <a href="#reward">Reward & Apresiasi</a>
                    <a href="#timeline">Timeline</a>
                    <a href="#daftar">Daftar Sekarang</a>
                </div>
            </div>

            <div class="copyright">
                &copy; 2025 Forum Indonesia Menulis. All Rights Reserved.
            </div>
        </div>
    </footer>
</body>

</html>
