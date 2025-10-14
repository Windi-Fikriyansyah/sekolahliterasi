<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->hero_title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .hero {
            background: linear-gradient(135deg, {{ $landing->hero_color_start }} 0%, {{ $landing->hero_color_end }} 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }

        .hero p {
            font-size: 1.3em;
            margin-bottom: 30px;
            animation: fadeInUp 1s ease;
        }

        .cta-button {
            display: inline-block;
            background: white;
            color: {{ $landing->primary_color }};
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease 0.3s both;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .section-title {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 50px;
            color: {{ $landing->primary_color }};
        }

        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .info-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
        }

        .info-card h3 {
            color: {{ $landing->primary_color }};
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        .info-card p {
            color: #666;
        }

        .icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        /* Gallery */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 60px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            height: 250px;
            background: linear-gradient(135deg, {{ $landing->primary_color }} 0%, {{ $landing->secondary_color }} 100%);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .placeholder-img {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2em;
            text-align: center;
            padding: 20px;
            height: 100%;
        }

        /* Video */
        .video-section {
            background: #f8f9fa;
            padding: 60px 20px;
            text-align: center;
        }

        .video-container {
            max-width: 800px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            background: #000;
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .video-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, {{ $landing->primary_color }} 0%, {{ $landing->secondary_color }} 100%);
            color: white;
            font-size: 1.5em;
            flex-direction: column;
        }

        /* Text Section */
        .text-section {
            white-space: pre-wrap;
            line-height: 1.8;
            color: #4a5568;
        }

        /* Points Section */
        .points-list {
            list-style: none;
            max-width: 800px;
            margin: 0 auto;
            padding: 0;
        }

        .point-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px 20px;
            margin-bottom: 12px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-left: 5px solid {{ $landing->primary_color }};
            font-size: 1.05em;
            color: #333;
            transition: transform 0.2s ease;
        }

        .point-item:hover {
            transform: translateX(5px);
        }

        .check-icon {
            color: #28a745;
            /* Hijau */
            margin-right: 10px;
            font-size: 1.3em;
        }

        .point-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px 20px;
            margin-bottom: 12px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-left: 5px solid {{ $landing->primary_color }};
            font-size: 1.05em;
            color: #333;
            transition: transform 0.2s ease;
        }

        /* Form */
        .form-section {
            background: linear-gradient(135deg, {{ $landing->primary_color }} 0%, {{ $landing->secondary_color }} 100%);
            padding: 80px 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }

        .form-container h2 {
            color: {{ $landing->primary_color }};
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: {{ $landing->primary_color }};
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .submit-button {
            width: 100%;
            background: linear-gradient(135deg, {{ $landing->primary_color }} 0%, {{ $landing->secondary_color }} 100%);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        footer {
            background: #2d3748;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2em;
            }

            .hero p {
                font-size: 1.1em;
            }

            .section-title {
                font-size: 2em;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>{{ $landing->hero_title }}</h1>
            <p>{{ $landing->hero_subtitle }}</p>
            <a href="{{ $landing->hero_button_link }}" class="cta-button">{{ $landing->hero_button_text }}</a>
        </div>
    </section>

    <!-- Dynamic Sections -->
    <!-- Dynamic Sections -->
    @foreach ($sections as $section)
        @php
            $content = $section->content ?? [];
        @endphp

        {{-- INFO CARDS --}}
        @if ($section->section_type === 'info_cards' && is_array($content))
            <section class="container">
                @if ($section->section_title)
                    <h2 class="section-title">{{ $section->section_title }}</h2>
                @endif
                <div class="info-grid">
                    @foreach ($content as $card)
                        <div class="info-card">
                            @if (!empty($card['icon']))
                                <div class="icon">{{ $card['icon'] }}</div>
                            @endif
                            <h3>{{ $card['title'] ?? '-' }}</h3>
                            <p>{{ $card['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @elseif($section->section_type === 'gallery' && is_array($content))
            <section class="container">
                @if ($section->section_title)
                    <h2 class="section-title">{{ $section->section_title }}</h2>
                @endif
                <div class="gallery">
                    @foreach ($content as $item)
                        <div class="gallery-item">
                            @php
                                $imagePath = $item['image'] ?? null;
                                $isUrl = $imagePath && filter_var($imagePath, FILTER_VALIDATE_URL);
                                $fullPath = $isUrl ? $imagePath : asset('storage/' . ltrim($imagePath, '/'));
                            @endphp

                            @if (!empty($imagePath))
                                <img src="{{ $fullPath }}" alt="Gambar" loading="lazy">
                            @else
                                <div class="placeholder-img">Tidak ada gambar</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>


            {{-- VIDEO --}}
        @elseif($section->section_type === 'video' && is_array($content))
            <section class="video-section">
                <div class="container">
                    @if ($section->section_title)
                        <h2 class="section-title" style="color: {{ $landing->primary_color }};">
                            {{ $section->section_title }}</h2>
                    @endif
                    <div class="video-container">
                        @if (!empty($content['video_url']))
                            <iframe src="{{ $content['video_url'] }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        @else
                            <div class="video-placeholder">
                                <div>🎬 {{ $content['video_title'] ?? 'Video Belum Diatur' }}</div>
                                @if (!empty($content['video_description']))
                                    <small style="font-size: 0.6em; margin-top: 10px;">
                                        {{ $content['video_description'] }}
                                    </small>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- TEXT --}}
        @elseif($section->section_type === 'text' && is_array($content))
            <section class="container">
                @if (!empty($content['heading']))
                    <h2 class="section-title">{{ $content['heading'] }}</h2>
                @elseif($section->section_title)
                    <h2 class="section-title">{{ $section->section_title }}</h2>
                @endif
                <div class="text-section">{{ $content['body'] ?? '' }}</div>
            </section>

            {{-- POINTS --}}
            {{-- POINTS --}}
        @elseif($section->section_type === 'points' && is_array($content))
            <section class="container">
                @if ($section->section_title)
                    <h2 class="section-title">{{ $section->section_title }}</h2>
                @endif

                <div class="points-card">
                    <ul class="points-list">
                        @foreach ($content as $point)
                            <li class="point-item">
                                <i class="fa-solid fa-circle-check check-icon"></i>
                                <span class="point-text">{{ $point['text'] ?? '' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @elseif($section->section_type === 'form' && is_array($content))
            <section class="form-section" id="form-{{ $section->id }}">
                <div class="form-container">
                    @if ($section->section_title)
                        <h2>{{ $section->section_title }}</h2>
                    @endif
                    <form id="dynamicForm{{ $section->id }}">
                        @foreach ($content as $field)
                            <div class="form-group">
                                <label for="field_{{ $field['name'] ?? '' }}">
                                    {{ $field['name'] ?? 'Field' }}
                                    @if (!empty($field['required']))
                                        *
                                    @endif
                                </label>

                                @if (($field['type'] ?? '') === 'textarea')
                                    <textarea id="field_{{ $field['name'] }}" name="{{ $field['name'] }}"
                                        {{ !empty($field['required']) ? 'required' : '' }}></textarea>
                                @elseif(($field['type'] ?? '') === 'select')
                                    <select id="field_{{ $field['name'] }}" name="{{ $field['name'] }}"
                                        {{ !empty($field['required']) ? 'required' : '' }}>
                                        <option value="">-- Pilih --</option>
                                    </select>
                                @else
                                    <input type="{{ $field['type'] ?? 'text' }}" id="field_{{ $field['name'] }}"
                                        name="{{ $field['name'] }}"
                                        {{ !empty($field['required']) ? 'required' : '' }}>
                                @endif
                            </div>
                        @endforeach
                        <button type="submit" class="submit-button">Kirim</button>
                    </form>
                </div>
            </section>
        @endif
    @endforeach


    <!-- Footer -->
    <footer>
        @if ($landing->footer_text)
            <p>{{ $landing->footer_text }}</p>
        @endif
        @if ($landing->footer_contact || $landing->footer_phone)
            <p>
                @if ($landing->footer_contact)
                    Hubungi kami: {{ $landing->footer_contact }}
                @endif
                @if ($landing->footer_contact && $landing->footer_phone)
                    |
                @endif
                @if ($landing->footer_phone)
                    {{ $landing->footer_phone }}
                @endif
            </p>
        @endif
    </footer>

    <script>
        // Handle form submissions
        document.querySelectorAll('form[id^="dynamicForm"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);

                alert('Terima kasih! Data Anda telah berhasil dikirim.');
                console.log('Form data:', data);
                this.reset();
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
