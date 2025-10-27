<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->nama_halaman ?? 'Guru Inspirator Literasi 2.0' }} - Menginspirasi Negeri, Menyalakan Literasi
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Reset dan variabel */
        :root {
            --primary: {{ $landing->primary_color ?? '#1a56db' }};
            --primary-dark: {{ $landing->primary_color ?? '#1e3a8a' }};
            --secondary: {{ $landing->secondary_color ?? '#059669' }};
            --accent: {{ $landing->accent_color ?? '#f59e0b' }};
            --light: #f8fafc;
            --dark: {{ $landing->dark_color ?? '#1e293b' }};
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
            position: relative;
            width: 100%;
            height: 100vh;
            background: var(--dark) url('{{ $landing->header_background ? asset('storage/' . $landing->header_background) : asset('image/Picture1.png') }}') center center no-repeat;
            background-size: contain;
            background-attachment: fixed;
            background-color: #000;
            background-repeat: no-repeat;
        }

        @media (max-width: 768px) {
            header {
                height: 70vh;
                background-size: contain;
                background-position: center top;
            }
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

            header {
                padding-top: 100px;
            }
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
            color: var(--dark);
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

        /* Tentang Program */
        #tentang {
            padding: 80px 0;
        }

        .tentang-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tentang-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .tentang-content {
            display: flex;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .tentang-text {
            flex: 1;
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--dark);
        }

        .tentang-text p {
            margin-bottom: 15px;
        }

        .tentang-text blockquote {
            border-left: 4px solid var(--accent);
            padding-left: 20px;
            margin-top: 20px;
            color: var(--gray);
            font-style: italic;
            background: #f9fafb;
            border-radius: 6px;
            padding: 15px 20px;
        }

        .tentang-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .tentang-image img {
            width: 100%;
            max-width: 480px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        @media (max-width: 992px) {
            .tentang-content {
                flex-direction: column;
            }

            .tentang-image img {
                max-width: 100%;
                height: auto;
            }

            .tentang-card {
                padding: 25px;
            }
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

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        /* Destination Grid */
        .destination-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .destination-item {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .destination-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .destination-label {
            padding: 10px;
            text-align: center;
            font-weight: 600;
            color: var(--primary-dark);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-top">
            @if ($landing->header_logo1)
                <img src="{{ asset('storage/' . $landing->header_logo1) }}" alt="Logo 1">
            @else
                <img src="{{ asset('image/Picture2.png') }}" alt="Logo 1">
            @endif

            @if ($landing->header_logo2)
                <img src="{{ asset('storage/' . $landing->header_logo2) }}" alt="Logo 2">
            @else
                <img src="{{ asset('image/Picture3.png') }}" alt="Logo 2">
            @endif
        </div>
    </header>

    <!-- Tentang Program -->
    <section id="tentang" style="background-color: #f8fafc;">
        <div class="container">
            <div class="section-title">
                <h2>{{ $landing->tentang_title ?? '✨ Tentang Program' }}</h2>
            </div>

            <div class="tentang-card">
                <div class="tentang-content">
                    <div class="tentang-text">
                        @if ($landing->tentang_paragraph1)
                            <p>{{ $landing->tentang_paragraph1 }}</p>
                        @endif

                        @if ($landing->tentang_paragraph2)
                            <p>{!! str_replace(
                                'Guru Inspirator Literasi 2.0',
                                '<strong>Guru Inspirator Literasi 2.0</strong>',
                                str_replace('Forum Indonesia Menulis', '<strong>Forum Indonesia Menulis</strong>', $landing->tentang_paragraph2),
                            ) !!}</p>
                        @endif

                        @if ($landing->tentang_quote)
                            <blockquote>
                                "{{ $landing->tentang_quote }}"<br>
                                @if ($landing->tentang_quote_author)
                                    <strong>{{ $landing->tentang_quote_author }}</strong>
                                @endif
                            </blockquote>
                        @endif
                    </div>
                    <div class="tentang-image">
                        @if ($landing->tentang_image)
                            <img src="{{ asset('storage/' . $landing->tentang_image) }}"
                                alt="Tentang Program Guru Inspirator Literasi">
                        @else
                            <img src="{{ asset('image/Picture3.png') }}"
                                alt="Tentang Program Guru Inspirator Literasi">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Wisata Literasi Nasional -->
    <section id="wln" style="background-color: #f8fafc;">
        <div class="container">
            <div class="section-title">
                <!-- Logo WLN -->
                <div
                    style="display: flex; justify-content: center; align-items: center; gap: 30px; margin-bottom: 25px;">
                    @if ($landing->wln_logo1)
                        <img src="{{ asset('storage/' . $landing->wln_logo1) }}" alt="Logo WLN 1"
                            style="height: 80px; width: auto;">
                    @else
                        <img src="{{ asset('image/Picture6.png') }}" alt="Logo WLN 1"
                            style="height: 80px; width: auto;">
                    @endif

                    @if ($landing->wln_logo2)
                        <img src="{{ asset('storage/' . $landing->wln_logo2) }}" alt="Logo WLN 2"
                            style="height: 80px; width: auto;">
                    @else
                        <img src="{{ asset('image/Picture7.png') }}" alt="Logo WLN 2"
                            style="height: 80px; width: auto;">
                    @endif
                </div>

                <h2>{{ $landing->wln_title ?? 'WISATA LITERASI NASIONAL & ANUGERAH LITERASI INDONESIA' }}</h2>
                <p class="section-subtitle">{{ $landing->wln_subtitle ?? 'Pesta Raya Literasi Terbesar di Tanah Air' }}
                </p>
            </div>

            <div class="card">
                @if ($landing->wln_paragraph1)
                    <p>{{ $landing->wln_paragraph1 }}</p>
                @endif
                @if ($landing->wln_paragraph2)
                    <p>{{ $landing->wln_paragraph2 }}</p>
                @endif
                @if ($landing->wln_paragraph3)
                    <p>{{ $landing->wln_paragraph3 }}</p>
                @endif
                @if ($landing->wln_paragraph4)
                    <p>{{ $landing->wln_paragraph4 }}</p>
                @endif
                @if ($landing->wln_paragraph5)
                    <p>{{ $landing->wln_paragraph5 }}</p>
                @endif
            </div>

            <!-- Gambar Dokumentasi WLN -->
            <div class="destination-grid">
                @for ($i = 1; $i <= 3; $i++)
                    @if ($landing->{"wln_image$i"})
                        <div class="destination-item">
                            <img src="{{ asset('storage/' . $landing->{"wln_image$i"}) }}"
                                alt="Dokumentasi WLN {{ $i }}">
                        </div>
                    @else
                        @if ($i == 1)
                            <div class="destination-item">
                                <img src="{{ asset('image/Picture4.png') }}" alt="Dokumentasi WLN 1">
                            </div>
                        @elseif($i == 2)
                            <div class="destination-item">
                                <img src="{{ asset('image/Picture8.png') }}" alt="Dokumentasi WLN 2">
                            </div>
                        @else
                            <div class="destination-item">
                                <img src="{{ asset('image/Picture9.png') }}" alt="Dokumentasi WLN 3">
                            </div>
                        @endif
                    @endif
                @endfor
            </div>
        </div>
    </section>

    <!-- Jejak Literasi -->
    <section id="jejak">
        <div class="container">
            <div class="section-title">
                <h2>{{ $landing->jejak_title ?? 'JEJAK LITERASI' }}</h2>
                <p class="section-subtitle">
                    {{ $landing->jejak_subtitle ?? 'WISATA LITERASI NASIONAL (WLN) & ANUGERAH LITERASI INDONESIA (ALI)<br>Sukses Terselenggara di Berbagai Wilayah Tanah Air' }}
                </p>
            </div>

            @if ($landing->jejak_description)
                <p style="text-align: center; margin-bottom: 30px;">{{ $landing->jejak_description }}</p>
            @endif

            <div class="gallery-grid">
                @for ($i = 1; $i <= 10; $i++)
                    @if ($landing->{"jejak_image$i"})
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $landing->{"jejak_image$i"}) }}"
                                alt="Dokumentasi {{ $i }}">
                        </div>
                    @else
                        <!-- Fallback images -->
                        @if ($i == 1)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture5.png') }}" alt="Dokumentasi 1">
                            </div>
                        @elseif($i == 2)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture10.png') }}" alt="Dokumentasi 2">
                            </div>
                        @elseif($i == 3)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture11.png') }}" alt="Dokumentasi 3">
                            </div>
                        @elseif($i == 4)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture12.png') }}" alt="Dokumentasi 4">
                            </div>
                        @elseif($i == 5)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture13.png') }}" alt="Dokumentasi 5">
                            </div>
                        @elseif($i == 6)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture14.png') }}" alt="Dokumentasi 6">
                            </div>
                        @elseif($i == 7)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture15.png') }}" alt="Dokumentasi 7">
                            </div>
                        @elseif($i == 8)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture16.png') }}" alt="Dokumentasi 8">
                            </div>
                        @elseif($i == 9)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture17.png') }}" alt="Dokumentasi 9">
                            </div>
                        @elseif($i == 10)
                            <div class="gallery-item">
                                <img src="{{ asset('image/Picture18.png') }}" alt="Dokumentasi 10">
                            </div>
                        @endif
                    @endif
                @endfor
            </div>
        </div>
    </section>

    <!-- Reward & Apresiasi -->
    <section id="reward" class="reward-section">
        <div class="container">
            <div class="section-title">
                <h2>{{ $landing->reward_title ?? 'REWARD & APRESIASI' }}</h2>
                <p class="section-subtitle">
                    {{ $landing->reward_subtitle ?? '- Pejabat Publik - Tokoh Pendidikan - Guru Inspirator Literasi 2.0 - GIL Mitra Literasi Nasional' }}
                </p>
            </div>

            <div class="reward-cards">
                @if ($landing->reward_kategori_a)
                    <div class="reward-card">
                        <h3>🏆 Anugerah Literasi Indonesia</h3>
                        <h4>A. Kategori: Pejabat Publik</h4>
                        <p>{{ $landing->reward_kategori_a }}</p>
                    </div>
                @endif

                @if ($landing->reward_kategori_b)
                    <div class="reward-card">
                        <h4>B. Kategori Tokoh Pendidikan</h4>
                        <p>{{ $landing->reward_kategori_b }}</p>
                    </div>
                @endif

                @if ($landing->reward_kategori_c)
                    <div class="reward-card">
                        <h4>C. Kategori Guru Inspirator Literasi</h4>
                        <p>{{ $landing->reward_kategori_c }}</p>
                    </div>
                @endif
            </div>

            @if ($landing->reward_gil_title)
                <div class="reward-card" style="margin-top: 30px;">
                    <h3>{{ $landing->reward_gil_title }}</h3>
                    @if ($landing->reward_gil_description)
                        <p>{{ $landing->reward_gil_description }}</p>
                    @endif

                    @if ($landing->reward_gil_characteristics)
                        <p>GIL penerima penghargaan ini adalah sosok yang:</p>
                        <ul>
                            @foreach (explode("\n", $landing->reward_gil_characteristics) as $point)
                                @if (trim($point))
                                    <li>{{ str_replace(['•', '-'], '', trim($point)) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    @if ($landing->reward_gil_rewards)
                        <p>Reward yang diberikan:</p>
                        <ul>
                            @foreach (explode("\n", $landing->reward_gil_rewards) as $reward)
                                @if (trim($reward))
                                    <li>{{ str_replace(['•', '-'], '', trim($reward)) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Reward Utama -->
    <section id="reward-utama" style="background-color: #ffffff;">
        <div class="container">
            <div class="section-title">
                <h2>{{ $landing->reward_utama_title ?? 'REWARD UTAMA' }}</h2>
                <p class="section-subtitle" style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                    {{ $landing->reward_utama_subtitle ?? 'SINGAPURA – MALAYSIA – THAILAND' }}
                </p>
            </div>

            <!-- Gambar Destinasi -->
            <div class="destination-grid">
                @php
                    $destinations = ['Singapura', 'Malaysia', 'Thailand'];
                @endphp
                @foreach ($destinations as $index => $destination)
                    <div class="destination-item">
                        @if ($landing->{'reward_utama_image' . ($index + 1)})
                            <img src="{{ asset('storage/' . $landing->{'reward_utama_image' . ($index + 1)}) }}"
                                alt="Reward {{ $destination }}">
                        @else
                            <img src="{{ asset('image/Picture19.png') }}" alt="Reward {{ $destination }}">
                        @endif
                        <div class="destination-label">{{ $destination }}</div>
                    </div>
                @endforeach
            </div>

            @if ($landing->tour_title)
                <div class="card">
                    <h3>{{ $landing->tour_title }}</h3>
                    @if ($landing->tour_quote)
                        <p style="font-style: italic; margin-bottom: 20px;">{{ $landing->tour_quote }}</p>
                    @endif
                    @if ($landing->tour_description1)
                        <p>{{ $landing->tour_description1 }}</p>
                    @endif
                    @if ($landing->tour_description2)
                        <p>{{ $landing->tour_description2 }}</p>
                    @endif

                    @if ($landing->tour_preparation_points)
                        <p>Mengikuti program ini berarti Anda siap:</p>
                        <ul style="list-style-type: none; margin: 20px 0;">
                            @foreach (explode("\n", $landing->tour_preparation_points) as $point)
                                @if (trim($point))
                                    <li style="margin-bottom: 10px; padding-left: 25px; position: relative;">
                                        {!! str_replace(['•', '-'], '', trim($point)) !!}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    @if ($landing->tour_conclusion)
                        <p>{{ $landing->tour_conclusion }}</p>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Timeline -->
    <section id="timeline" style="background-color: #f8fafc;">
        <div class="container">
            <div class="section-title">
                <h2>{{ $landing->timeline_title ?? 'TIMELINE PROGRAM' }}</h2>
                <p class="section-subtitle">
                    {{ $landing->timeline_subtitle ?? 'GURU INSPIRATOR LITERASI 2.0<br>"Menginspirasi Negeri, Menyalakan Literasi"' }}
                </p>
            </div>

            <div class="timeline">
                @for ($i = 1; $i <= 8; $i++)
                    @if ($landing->{"timeline_date$i"} && $landing->{"timeline_event$i"})
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-date">{{ $landing->{"timeline_date$i"} }}</div>
                                <h3>{{ $landing->{"timeline_event$i"} }}</h3>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </section>

    <!-- Manfaat -->
    <section id="manfaat">
        <div class="container">
            <div class="section-title">
                <h2>{{ $landing->manfaat_title ?? 'Apa yang Anda Dapatkan?' }}</h2>
                <p class="section-subtitle">
                    {{ $landing->manfaat_subtitle ?? 'Menjadi bagian dari GIL 2.0 bukan sekadar mengikuti pelatihan, ini adalah perjalanan transformasi diri dan bangsa!' }}
                </p>
            </div>

            <div class="benefits-grid">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($landing->{"manfaat_item_title$i"})
                        <div class="benefit-item">
                            @if ($landing->{"manfaat_icon$i"})
                                <div class="benefit-icon">{{ $landing->{"manfaat_icon$i"} }}</div>
                            @endif
                            <h3>{{ $landing->{"manfaat_item_title$i"} }}</h3>
                            @if ($landing->{"manfaat_item_description$i"})
                                <p>{{ $landing->{"manfaat_item_description$i"} }}</p>
                            @endif
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </section>

    <!-- Mengapa Bergabung -->
    <section id="mengapa" style="background-color: var(--primary-dark); color: white;">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;">{{ $landing->mengapa_title ?? '💡 Mengapa Harus Bergabung?' }}</h2>
            </div>
            <div class="card" style="background: rgba(255, 255, 255, 0.1); color: white; border: none;">
                @if ($landing->mengapa_opening)
                    <p style="text-align: center; font-size: 1.2rem; margin-bottom: 30px;">
                        {{ $landing->mengapa_opening }}</p>
                @endif

                @if ($landing->mengapa_points)
                    <ul style="list-style-type: none; text-align: center;">
                        @foreach (explode("\n", $landing->mengapa_points) as $point)
                            @if (trim($point))
                                <li style="margin-bottom: 15px; font-size: 1.1rem;">
                                    🔥 {!! str_replace(['•', '-'], '', trim($point)) !!}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif

                @if ($landing->mengapa_quote)
                    <div class="quote"
                        style="border-left-color: var(--accent); margin-top: 40px; color: var(--accent);">
                        "{{ $landing->mengapa_quote }}"
                        @if ($landing->mengapa_quote_author)
                            <div class="quote-author" style="color: var(--light); font-weight: 600; margin-top: 8px;">
                                {{ $landing->mengapa_quote_author }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="daftar"
        style="text-align: center; padding: 100px 0; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;">
        <div class="container">
            <h2 style="font-size: 2.5rem; margin-bottom: 20px;">
                {{ $landing->cta_main_title ?? 'Menuju Indonesia Kiblat Literasi Dunia' }}</h2>
            <p style="max-width: 800px; margin: 0 auto 30px; font-size: 1.2rem;">
                {{ $landing->cta_main_description ?? 'Bersama Guru Inspirator Literasi 2.0, kita menapaki jalan menuju Indonesia yang beradab, berdaya saing, dan berbudaya literasi.' }}
            </p>

            <h3 style="font-size: 1.8rem; margin: 40px 0 20px;">
                {{ $landing->cta_subtitle ?? 'Siap Jadi Pelita Literasi Bangsa?' }}</h3>
            <p style="font-size: 1.3rem; margin-bottom: 30px; font-weight: 600;">
                {{ $landing->cta_call_text ?? 'Sekaranglah waktunya!' }}</p>

            <a href="javascript:void(0);" onclick="openModal()" class="cta-button"
                style="font-size: 1.3rem; padding: 18px 40px;">{{ $landing->cta_button_text ?? '👉 DAFTAR SEKARANG' }}</a>

            @if ($landing->cta_registration_info)
                <div style="margin-top: 40px;">
                    <p style="font-weight: 600; margin-bottom: 10px;">{{ $landing->cta_registration_info }}</p>
                </div>
            @endif
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
                    @if ($landing->footer_whatsapp)
                        <p>📱 WhatsApp: {{ $landing->footer_whatsapp }}</p>
                    @endif
                    @if ($landing->footer_contact)
                        <p>📧 Email: {{ $landing->footer_contact }}</p>
                    @endif
                    <div class="social-links">
                        @if ($landing->footer_instagram)
                            <a href="{{ $landing->footer_instagram }}" target="_blank" class="social-link"
                                aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if ($landing->footer_youtube)
                            <a href="{{ $landing->footer_youtube }}" target="_blank" class="social-link"
                                aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                        @if ($landing->footer_facebook)
                            <a href="{{ $landing->footer_facebook }}" target="_blank" class="social-link"
                                aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
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
                {{ $landing->footer_text ?? '© 2025 Forum Indonesia Menulis. All Rights Reserved.' }}
            </div>
        </div>
    </footer>

    <!-- Modal Pendaftaran -->
    <div id="modalDaftar"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center;">
        <div
            style="background:white; max-width:750px; width:90%; padding:30px; border-radius:15px; overflow-y:auto; max-height:90vh; position:relative;">
            <button onclick="closeModal()"
                style="position:absolute; top:10px; right:15px; font-size:20px; background:none; border:none; cursor:pointer; color:#555;">&times;</button>

            @if ($landing->modal_title)
                <h2 style="text-align:center; color:#1a56db; font-size:1.5rem; margin-bottom:10px;">
                    {{ $landing->modal_title }}</h2>
            @endif

            @if ($landing->modal_warning)
                <p style="text-align:center; font-weight:bold; color:#d32f2f; margin-bottom:20px;">
                    {{ $landing->modal_warning }}</p>
            @endif

            @if ($landing->modal_subtitle)
                <h3 style="text-align:center; color:#059669; margin-bottom:10px;">{{ $landing->modal_subtitle }}</h3>
            @endif

            @if ($landing->modal_period)
                <p style="text-align:center; margin-bottom:20px;">{{ $landing->modal_period }}</p>
            @endif

            @if ($landing->modal_instructions)
                <p style="margin-bottom:15px;">{{ $landing->modal_instructions }}</p>
            @endif

            @if ($landing->modal_instruction_points)
                <ol style="margin-left:20px; margin-bottom:20px;">
                    @foreach (explode("\n", $landing->modal_instruction_points) as $point)
                        @if (trim($point))
                            <li>{!! trim($point) !!}</li>
                        @endif
                    @endforeach
                </ol>
            @endif

            @if ($landing->modal_facilities)
                <ul style="margin-left:20px; margin-bottom:20px;">
                    @foreach (explode("\n", $landing->modal_facilities) as $facility)
                        @if (trim($facility))
                            <li>{!! str_replace(['•', '-'], '', trim($facility)) !!}</li>
                        @endif
                    @endforeach
                </ul>
            @endif

            @if ($landing->modal_note)
                <p style="font-weight:bold; margin-top:15px;">{{ $landing->modal_note }}</p>
            @endif

            @if ($landing->modal_transfer_info)
                <p>{{ $landing->modal_transfer_info }}</p>
            @endif

            @if ($landing->modal_closing1)
                <p style="margin-top:25px;">{{ $landing->modal_closing1 }}</p>
            @endif

            @if ($landing->modal_closing2)
                <p><b>{{ $landing->modal_closing2 }}</b></p>
            @endif

            @php
                $slug =
                    \Illuminate\Support\Str::slug($product->judul) .
                    '--' .
                    \Illuminate\Support\Facades\Crypt::encryptString($product->id);
            @endphp

            <div style="text-align:center; margin-top:30px;">
                <a href="{{ route('landing_page.pendaftaran', ['slug' => $slug]) }}"
                    style="display:inline-block; background:#1a56db; color:white; padding:12px 30px; border-radius:8px; text-decoration:none; font-weight:600;">
                    Lanjut ke Halaman Pendaftaran →
                </a>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modalDaftar').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalDaftar').style.display = 'none';
        }
    </script>
</body>

</html>
