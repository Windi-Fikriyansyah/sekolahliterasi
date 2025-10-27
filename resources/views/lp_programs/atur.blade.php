@extends('template.app')
@section('title', isset($landing) ? 'Edit Landing Page' : 'Atur Landing Page')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            {{ isset($landing) ? 'Edit' : 'Atur' }} Landing Page
                        </h5>
                        <small>Form pengaturan tampilan landing page program</small>
                    </div>

                    <div class="card-body p-4">
                        {{-- <div class="mb-4 text-end">
                            <a href="{{ route('lp_programs.create', ['landing_page_id' => $landing->id]) }}"
                                class="btn btn-success btn-sm">
                                <i class="bx bx-plus"></i> Tambah Section Baru
                            </a>
                        </div> --}}

                        {{-- Tabs --}}
                        <ul class="nav nav-tabs mb-4" id="landingTabs" role="tablist">
                            {{-- Tab Utama --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="utama-tab" data-bs-toggle="tab" data-bs-target="#utama"
                                    type="button" role="tab" aria-controls="utama" aria-selected="true">🏠 Section
                                    Utama</button>
                            </li>

                            {{-- Tab Tentang Program --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tentang-tab" data-bs-toggle="tab" data-bs-target="#tentang"
                                    type="button" role="tab" aria-controls="tentang" aria-selected="false">✨ Tentang
                                    Program</button>
                            </li>

                            {{-- Tab Wisata Literasi Nasional --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="wln-tab" data-bs-toggle="tab" data-bs-target="#wln"
                                    type="button" role="tab" aria-controls="wln" aria-selected="false">🌍 Wisata
                                    Literasi Nasional</button>
                            </li>

                            {{-- Tab Jejak Literasi --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="jejak-tab" data-bs-toggle="tab" data-bs-target="#jejak"
                                    type="button" role="tab" aria-controls="jejak" aria-selected="false">📸 Jejak
                                    Literasi</button>
                            </li>

                            {{-- Tab Reward & Apresiasi --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reward-tab" data-bs-toggle="tab" data-bs-target="#reward"
                                    type="button" role="tab" aria-controls="reward" aria-selected="false">🏆 Reward &
                                    Apresiasi</button>
                            </li>

                            {{-- Tab Reward Utama --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reward-utama-tab" data-bs-toggle="tab"
                                    data-bs-target="#reward-utama" type="button" role="tab"
                                    aria-controls="reward-utama" aria-selected="false">✈️ Reward Utama</button>
                            </li>

                            {{-- Tab Timeline --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline"
                                    type="button" role="tab" aria-controls="timeline" aria-selected="false">📅 Timeline
                                    Program</button>
                            </li>

                            {{-- Tab Manfaat --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="manfaat-tab" data-bs-toggle="tab" data-bs-target="#manfaat"
                                    type="button" role="tab" aria-controls="manfaat" aria-selected="false">💎
                                    Manfaat</button>
                            </li>

                            {{-- Tab Mengapa Bergabung --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="mengapa-tab" data-bs-toggle="tab" data-bs-target="#mengapa"
                                    type="button" role="tab" aria-controls="mengapa" aria-selected="false">💡
                                    Mengapa Bergabung</button>
                            </li>

                            {{-- Tab CTA --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="daftar-tab" data-bs-toggle="tab" data-bs-target="#daftar"
                                    type="button" role="tab" aria-controls="daftar" aria-selected="false">📝 Daftar
                                    Sekarang</button>
                            </li>

                            {{-- Tabs Dinamis dari landing_sections_program --}}
                            @foreach ($sections as $section)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-{{ $section->id }}" data-bs-toggle="tab"
                                        data-bs-target="#section-{{ $section->id }}" type="button" role="tab"
                                        aria-controls="section-{{ $section->id }}" aria-selected="false">
                                        {{ $section->section_title ?? 'Tanpa Judul' }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        {{-- FORM UTAMA YANG MENGGABUNGKAN SEMUA DATA --}}
                        <form action="{{ route('lp_programs.updateAll', $program->id) }}" method="POST" id="mainForm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $program->id }}">

                            <div class="tab-content" id="landingTabsContent">
                                {{-- TAB UTAMA (lp_program) --}}
                                <div class="tab-pane fade show active" id="utama" role="tabpanel"
                                    aria-labelledby="utama-tab">
                                    {{-- INFORMASI DASAR --}}
                                    <div class="mb-4">
                                        <h5 class="mb-3">📋 Informasi Dasar</h5>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label fw-semibold">Nama Halaman *</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="nama_halaman" name="nama_halaman"
                                                    class="form-control"
                                                    value="{{ $landing->nama_halaman ?? old('nama_halaman') }}" required>
                                                <small class="text-muted">Nama akan otomatis menjadi slug URL</small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- HEADER SECTION --}}
                                    <div class="mb-4">
                                        <h5 class="mb-3">🎯 Header Section</h5>

                                        {{-- Background Header --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Background Header *</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->header_background))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->header_background) }}"
                                                            alt="Header Background" class="img-fluid rounded shadow-sm"
                                                            style="max-height: 200px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="header_background" class="form-control">
                                                <small class="text-muted">Format: JPG, PNG, WEBP | Maks 2MB</small>
                                            </div>
                                        </div>

                                        {{-- Logo Header 1 --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Logo Header 1</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->header_logo1))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->header_logo1) }}"
                                                            alt="Logo Header 1" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="header_logo1" class="form-control">
                                                <small class="text-muted">Format: PNG transparan atau JPG | Maks
                                                    1MB</small>
                                            </div>
                                        </div>

                                        {{-- Logo Header 2 --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Logo Header 2</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->header_logo2))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->header_logo2) }}"
                                                            alt="Logo Header 2" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="header_logo2" class="form-control">
                                                <small class="text-muted">Format: PNG transparan atau JPG | Maks
                                                    1MB</small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- WARNA TEMA --}}
                                    <div class="mb-4">
                                        <h5 class="mb-3">🎨 Warna Tema</h5>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Warna Primary *</label>
                                            <div class="col-sm-9 d-flex align-items-center gap-2">
                                                <input type="color" id="primary_color_picker"
                                                    class="form-control form-control-color"
                                                    value="{{ $landing->primary_color ?? '#1a56db' }}">
                                                <input type="text" id="primary_color" name="primary_color"
                                                    class="form-control"
                                                    value="{{ $landing->primary_color ?? '#1a56db' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Warna Secondary *</label>
                                            <div class="col-sm-9 d-flex align-items-center gap-2">
                                                <input type="color" id="secondary_color_picker"
                                                    class="form-control form-control-color"
                                                    value="{{ $landing->secondary_color ?? '#059669' }}">
                                                <input type="text" id="secondary_color" name="secondary_color"
                                                    class="form-control"
                                                    value="{{ $landing->secondary_color ?? '#059669' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Warna Accent *</label>
                                            <div class="col-sm-9 d-flex align-items-center gap-2">
                                                <input type="color" id="accent_color_picker"
                                                    class="form-control form-control-color"
                                                    value="{{ $landing->accent_color ?? '#f59e0b' }}">
                                                <input type="text" id="accent_color" name="accent_color"
                                                    class="form-control"
                                                    value="{{ $landing->accent_color ?? '#f59e0b' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Warna Dark *</label>
                                            <div class="col-sm-9 d-flex align-items-center gap-2">
                                                <input type="color" id="dark_color_picker"
                                                    class="form-control form-control-color"
                                                    value="{{ $landing->dark_color ?? '#1e293b' }}">
                                                <input type="text" id="dark_color" name="dark_color"
                                                    class="form-control" value="{{ $landing->dark_color ?? '#1e293b' }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FOOTER --}}
                                    <div class="mb-4">
                                        <h5 class="mb-3">📧 Footer</h5>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Teks Footer</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="footer_text" class="form-control"
                                                    value="{{ $landing->footer_text ?? '© 2025 Forum Indonesia Menulis. All Rights Reserved.' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">WhatsApp Kontak</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="footer_whatsapp" class="form-control"
                                                    value="{{ $landing->footer_whatsapp ?? '0812-1000-5026' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Email Kontak</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="footer_contact" class="form-control"
                                                    value="{{ $landing->footer_contact ?? 'fimi.ndonesiamenulis@gmail.com' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Link Instagram</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="footer_instagram" class="form-control"
                                                    value="{{ $landing->footer_instagram ?? 'https://www.instagram.com/forumindonesiamenulis' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Link YouTube</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="footer_youtube" class="form-control"
                                                    value="{{ $landing->footer_youtube ?? 'https://www.youtube.com/@forumindonesiamenulis' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Link Facebook</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="footer_facebook" class="form-control"
                                                    value="{{ $landing->footer_facebook ?? 'https://www.facebook.com/forumindonesiamenulis' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB TENTANG PROGRAM --}}
                                <div class="tab-pane fade" id="tentang" role="tabpanel" aria-labelledby="tentang-tab">
                                    <h5 class="mb-3">✨ Tentang Program</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="tentang_title" class="form-control"
                                                value="{{ $landing->tentang_title ?? 'Tentang Program' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Paragraf 1</label>
                                        <div class="col-sm-9">
                                            <textarea name="tentang_paragraph1" class="form-control" rows="3">{{ $landing->tentang_paragraph1 ?? 'Di tengah derasnya arus teknologi dan perubahan zaman, Indonesia membutuhkan guru-guru luar biasa, pendidik yang bukan hanya mengajar, tetapi juga menginspirasi.' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Paragraf 2</label>
                                        <div class="col-sm-9">
                                            <textarea name="tentang_paragraph2" class="form-control" rows="3">{{ $landing->tentang_paragraph2 ?? 'Program Guru Inspirator Literasi 2.0 adalah gerakan nasional yang digagas oleh Forum Indonesia Menulis, untuk melahirkan agen perubahan pendidikan yang menyalakan semangat literasi, membangun karakter bangsa, dan menjadi promotor utama Wisata Literasi Nasional.' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Kutipan</label>
                                        <div class="col-sm-9">
                                            <textarea name="tentang_quote" class="form-control" rows="3">{{ $landing->tentang_quote ?? '"Literasi bukan hanya milik kota besar. Literasi dimulai dari halaman rumah kita sendiri."' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Penulis Kutipan</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="tentang_quote_author" class="form-control"
                                                value="{{ $landing->tentang_quote_author ?? '- Fakhrul Arrazi, Founder Forum Indonesia Menulis' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Gambar Tentang Program</label>
                                        <div class="col-sm-9">
                                            @if (!empty($landing->tentang_image))
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $landing->tentang_image) }}"
                                                        alt="Tentang Program Image" class="img-fluid rounded shadow-sm"
                                                        style="max-height: 200px;">
                                                </div>
                                            @endif
                                            <input type="file" name="tentang_image" class="form-control">
                                            <small class="text-muted">Format: JPG, PNG, WEBP | Maks 2MB</small>
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB WISATA LITERASI NASIONAL --}}
                                <div class="tab-pane fade" id="wln" role="tabpanel" aria-labelledby="wln-tab">
                                    <h5 class="mb-3">🌍 Wisata Literasi Nasional</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="wln_title" class="form-control"
                                                value="{{ $landing->wln_title ?? 'WISATA LITERASI NASIONAL & ANUGERAH LITERASI INDONESIA' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Subjudul</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="wln_subtitle" class="form-control"
                                                value="{{ $landing->wln_subtitle ?? 'Pesta Raya Literasi Terbesar di Tanah Air' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Logo WLN 1</label>
                                        <div class="col-sm-9">
                                            @if (!empty($landing->wln_logo1))
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $landing->wln_logo1) }}"
                                                        alt="WLN Logo 1" class="img-thumbnail"
                                                        style="max-height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" name="wln_logo1" class="form-control">
                                            <small class="text-muted">Format: PNG transparan atau JPG | Maks 1MB</small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Logo WLN 2</label>
                                        <div class="col-sm-9">
                                            @if (!empty($landing->wln_logo2))
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $landing->wln_logo2) }}"
                                                        alt="WLN Logo 2" class="img-thumbnail"
                                                        style="max-height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" name="wln_logo2" class="form-control">
                                            <small class="text-muted">Format: PNG transparan atau JPG | Maks 1MB</small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Paragraf 1</label>
                                        <div class="col-sm-9">
                                            <textarea name="wln_paragraph1" class="form-control" rows="3">{{ $landing->wln_paragraph1 ?? 'Wisata Literasi Nasional (WLN) dan Anugerah Literasi Indonesia (ALI) merupakan ajang prestisius tahunan yang menjadi magnet bagi ribuan pendidik, pegiat literasi, dan tokoh inspiratif dari seluruh penjuru negeri. Sebuah perhelatan akbar yang menghadirkan semangat kebangkitan literasi nasional, membumikan literasi, menggerakkan peradaban bangsa.' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Paragraf 2</label>
                                        <div class="col-sm-9">
                                            <textarea name="wln_paragraph2" class="form-control" rows="3">{{ $landing->wln_paragraph2 ?? 'Dalam satu panggung besar, WLN & ALI menghadirkan rangkaian kegiatan luar biasa: Seminar Literasi Nasional, Peluncuran Buku, Panggung Apresiasi & Hiburan Inspiratif, hingga puncak acara Anugerah Literasi Indonesia, sebuah momentum bersejarah untuk mengangkat karya, merayakan prestasi, dan menyalakan obor literasi bangsa.' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Paragraf 3</label>
                                        <div class="col-sm-9">
                                            <textarea name="wln_paragraph3" class="form-control" rows="3">{{ $landing->wln_paragraph3 ?? 'Anugerah Literasi Indonesia (ALI) merupakan bentuk penghargaan tertinggi bagi para Guru Inspirator, Tokoh Literasi, dan Pejabat Publik yang telah menunjukkan dedikasi luar biasa dalam menumbuhkan budaya literasi, menggerakkan ekosistem belajar, dan mendukung kemajuan pendidikan di Indonesia.' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Paragraf 4</label>
                                        <div class="col-sm-9">
                                            <textarea name="wln_paragraph4" class="form-control" rows="3">{{ $landing->wln_paragraph4 ?? 'Penghargaan ini menjadi simbol apresiasi atas kerja nyata mereka yang tanpa lelah menyalakan obor literasi di berbagai pelosok negeri, menginspirasi, mengedukasi, dan membawa perubahan nyata bagi generasi bangsa.' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Paragraf 5</label>
                                        <div class="col-sm-9">
                                            <textarea name="wln_paragraph5" class="form-control" rows="3">{{ $landing->wln_paragraph5 ?? 'Melalui ALI, Indonesia memberi penghormatan kepada para pejuang literasi yang telah menjadikan literasi bukan sekadar gerakan, melainkan napas peradaban dan fondasi kemajuan bangsa.' }}</textarea>
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Gambar Dokumentasi WLN</h6>
                                    @for ($i = 1; $i <= 3; $i++)
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Gambar Dokumentasi
                                                {{ $i }}</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->{"wln_image$i"}))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->{"wln_image$i"}) }}"
                                                            alt="WLN Image {{ $i }}"
                                                            class="img-fluid rounded shadow-sm"
                                                            style="max-height: 150px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="wln_image{{ $i }}"
                                                    class="form-control">
                                                <small class="text-muted">Format: JPG, PNG, WEBP | Maks 2MB</small>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                {{-- TAB JEJAK LITERASI --}}
                                <div class="tab-pane fade" id="jejak" role="tabpanel" aria-labelledby="jejak-tab">
                                    <h5 class="mb-3">📸 Jejak Literasi</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="jejak_title" class="form-control"
                                                value="{{ $landing->jejak_title ?? 'JEJAK LITERASI' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Subjudul</label>
                                        <div class="col-sm-9">
                                            <textarea name="jejak_subtitle" class="form-control" rows="2">{{ $landing->jejak_subtitle ?? 'WISATA LITERASI NASIONAL (WLN) & ANUGERAH LITERASI INDONESIA (ALI) Sukses Terselenggara di Berbagai Wilayah Tanah Air' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <textarea name="jejak_description" class="form-control" rows="3">{{ $landing->jejak_description ?? 'Berikut dokumentasi pelaksanaan Wisata Literasi Nasional & Anugerah Literasi Indonesia yang telah sukses terselenggara di berbagai kota di Indonesia. Setiap kota menghadirkan semangat, inspirasi, dan karya literasi yang luar biasa, menjadi bukti nyata bahwa gerakan literasi kini semakin hidup dan meriah di seluruh Nusantara.' }}</textarea>
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Galeri Jejak Literasi</h6>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Gambar Galeri
                                                {{ $i }}</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->{"jejak_image$i"}))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->{"jejak_image$i"}) }}"
                                                            alt="Jejak Image {{ $i }}"
                                                            class="img-fluid rounded shadow-sm"
                                                            style="max-height: 150px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="jejak_image{{ $i }}"
                                                    class="form-control">
                                                <small class="text-muted">Format: JPG, PNG, WEBP | Maks 2MB</small>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                {{-- TAB REWARD & APRESIASI --}}
                                <div class="tab-pane fade" id="reward" role="tabpanel" aria-labelledby="reward-tab">
                                    <h5 class="mb-3">🏆 Reward & Apresiasi</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="reward_title" class="form-control"
                                                value="{{ $landing->reward_title ?? 'REWARD & APRESIASI' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Subjudul</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="reward_subtitle" class="form-control"
                                                value="{{ $landing->reward_subtitle ?? '- Pejabat Publik - Tokoh Pendidikan - Guru Inspirator Literasi 2.0 - GIL Mitra Literasi Nasional' }}">
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Kategori Anugerah Literasi Indonesia</h6>

                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">A. Kategori: Pejabat Publik</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Deskripsi</label>
                                                <div class="col-sm-9">
                                                    <textarea name="reward_kategori_a" class="form-control" rows="4">{{ $landing->reward_kategori_a ?? 'Anugerah Literasi Indonesia Kategori Pejabat Publik merupakan penghargaan tertinggi bagi para pemimpin daerah dan tokoh pemerintahan yang menunjukkan komitmen visioner dan aksi nyata dalam mengembangkan ekosistem literasi serta memajukan pendidikan di Indonesia.' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">B. Kategori Tokoh Pendidikan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Deskripsi</label>
                                                <div class="col-sm-9">
                                                    <textarea name="reward_kategori_b" class="form-control" rows="4">{{ $landing->reward_kategori_b ?? 'Anugerah Literasi Indonesia Kategori Tokoh Pendidikan merupakan penghargaan tertinggi bagi para tokoh berpengaruh, pemimpin lembaga, dan penggerak pendidikan yang telah menunjukkan dedikasi, inovasi, dan kontribusi nyata dalam menumbuhkan budaya literasi di masyarakat.' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">C. Kategori Guru Inspirator Literasi</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Deskripsi</label>
                                                <div class="col-sm-9">
                                                    <textarea name="reward_kategori_c" class="form-control" rows="4">{{ $landing->reward_kategori_c ?? 'Anugerah Literasi Indonesia Kategori Guru Inspirator Literasi merupakan penghargaan tertinggi bagi para pendidik dan penggerak literasi yang telah menunjukkan dedikasi, kreativitas, dan komitmen luar biasa dalam menumbuhkan budaya literasi di lingkungan sekolah dan masyarakat.' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">GIL Mitra Literasi Nasional</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Judul</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="reward_gil_title" class="form-control"
                                                        value="{{ $landing->reward_gil_title ?? 'Anugerah Literasi Indonesia Kategori: GIL Mitra Literasi Nasional' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Deskripsi</label>
                                                <div class="col-sm-9">
                                                    <textarea name="reward_gil_description" class="form-control" rows="4">{{ $landing->reward_gil_description ?? 'Kategori GIL Mitra Literasi Nasional diberikan kepada guru penggerak literasi yang secara konsisten mendedikasikan diri setiap tahun untuk memajukan literasi di berbagai wilayah Indonesia. Penghargaan ini menegaskan peran guru sebagai mitra strategis dalam membangun ekosistem literasi yang berkelanjutan dan berdampak luas.' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Karakteristik GIL</label>
                                                <div class="col-sm-9">
                                                    <textarea name="reward_gil_characteristics" class="form-control" rows="6">{{ $landing->reward_gil_characteristics ?? "GIL penerima penghargaan ini adalah sosok yang:\n• Aktif menginisiasi dan menggerakkan kegiatan literasi di sekolah maupun masyarakat.\n• Menjalin kolaborasi erat dengan instansi terkait, seperti Dinas Pendidikan, Dinas Perpustakaan, hingga sekolah-sekolah mitra.\n• Berkomitmen tinggi menjaga keberlanjutan program literasi di tingkat lokal maupun nasional.\n• Menjadi teladan inspiratif bagi rekan guru, siswa, dan komunitas literasi di sekitarnya.\n• Siap menjadi tim dalam penyelenggaraan event literasi nasional dan Internasional dari Forum Indonesia Menulis" }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Reward yang Diberikan</label>
                                                <div class="col-sm-9">
                                                    <textarea name="reward_gil_rewards" class="form-control" rows="5">{{ $landing->reward_gil_rewards ?? "Reward yang diberikan:\n• Gratis mengikuti berbagai event Nasional maupun Internasional yang diselenggarakan oleh Forum Indonesia Menulis (transport dan akomodasi ditanggung FIM)\n• Menjadi Pembicara Nasional maupun Internasional Forum Indonesia Menulis di berbagai event\n• Reward hadiah uang tunai jutaan rupiah" }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB REWARD UTAMA --}}
                                <div class="tab-pane fade" id="reward-utama" role="tabpanel"
                                    aria-labelledby="reward-utama-tab">
                                    <h5 class="mb-3">✈️ Reward Utama</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="reward_utama_title" class="form-control"
                                                value="{{ $landing->reward_utama_title ?? 'REWARD UTAMA' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Subjudul</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="reward_utama_subtitle" class="form-control"
                                                value="{{ $landing->reward_utama_subtitle ?? 'SINGAPURA – MALAYSIA – THAILAND' }}">
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Gambar Destinasi</h6>
                                    @php
                                        $destinations = ['Singapura', 'Malaysia', 'Thailand'];
                                    @endphp
                                    @foreach ($destinations as $index => $destination)
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Gambar {{ $destination }}</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->{'reward_utama_image' . ($index + 1)}))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->{'reward_utama_image' . ($index + 1)}) }}"
                                                            alt="Reward {{ $destination }}"
                                                            class="img-fluid rounded shadow-sm"
                                                            style="max-height: 150px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="reward_utama_image{{ $index + 1 }}"
                                                    class="form-control">
                                                <small class="text-muted">Format: JPG, PNG, WEBP | Maks 2MB</small>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Tour Aksara Internasional</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Judul</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="tour_title" class="form-control"
                                                        value="{{ $landing->tour_title ?? 'Tour Aksara Internasional' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Kutipan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="tour_quote" class="form-control"
                                                        value="{{ $landing->tour_quote ?? 'Bukan sekadar tour, ini adalah gerbang menuju dunia literasi global!' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Deskripsi 1</label>
                                                <div class="col-sm-9">
                                                    <textarea name="tour_description1" class="form-control" rows="3">{{ $landing->tour_description1 ?? 'Tour yang menghadirkan pengalaman luar biasa: perpaduan wisata edukasi, kompetisi, event internasional, serta eksplorasi budaya, teknologi, dan kreativitas dunia.' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Deskripsi 2</label>
                                                <div class="col-sm-9">
                                                    <textarea name="tour_description2" class="form-control" rows="3">{{ $landing->tour_description2 ?? 'Mengikuti program ini berarti Anda siap:' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Poin-poin Persiapan</label>
                                                <div class="col-sm-9">
                                                    <textarea name="tour_preparation_points" class="form-control" rows="6">{{ $landing->tour_preparation_points ?? "• Menjadi duta literasi Indonesia di panggung internasional.\n• Menggali inspirasi dari sistem pendidikan, budaya, dan inovasi negara maju.\n• Berkompetisi & tampil dalam ajang literasi bergengsi tingkat dunia.\n• Menikmati wisata kreatif yang sarat makna, menggabungkan literasi, seni, dan teknologi modern." }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Penutup</label>
                                                <div class="col-sm-9">
                                                    <textarea name="tour_conclusion" class="form-control" rows="3">{{ $landing->tour_conclusion ?? 'Tour Aksara Internasional bukan hanya perjalanan, melainkan pengalaman berharga yang akan membentuk generasi berprestasi dengan semangat literasi mendunia.' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB TIMELINE --}}
                                <div class="tab-pane fade" id="timeline" role="tabpanel"
                                    aria-labelledby="timeline-tab">
                                    <h5 class="mb-3">📅 Timeline Program</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="timeline_title" class="form-control"
                                                value="{{ $landing->timeline_title ?? 'TIMELINE PROGRAM' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Subjudul</label>
                                        <div class="col-sm-9">
                                            <textarea name="timeline_subtitle" class="form-control" rows="2">{{ $landing->timeline_subtitle ?? 'GURU INSPIRATOR LITERASI 2.0 "Menginspirasi Negeri, Menyalakan Literasi"' }}</textarea>
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Item Timeline</h6>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Tanggal {{ $i }}</label>
                                                        <input type="text" name="timeline_date{{ $i }}"
                                                            class="form-control"
                                                            value="{{ $landing->{"timeline_date$i"} ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">Kegiatan {{ $i }}</label>
                                                        <input type="text" name="timeline_event{{ $i }}"
                                                            class="form-control"
                                                            value="{{ $landing->{"timeline_event$i"} ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                {{-- TAB MANFAAT --}}
                                <div class="tab-pane fade" id="manfaat" role="tabpanel" aria-labelledby="manfaat-tab">
                                    <h5 class="mb-3">💎 Manfaat</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="manfaat_title" class="form-control"
                                                value="{{ $landing->manfaat_title ?? 'Apa yang Anda Dapatkan?' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Subjudul</label>
                                        <div class="col-sm-9">
                                            <textarea name="manfaat_subtitle" class="form-control" rows="2">{{ $landing->manfaat_subtitle ?? 'Menjadi bagian dari GIL 2.0 bukan sekadar mengikuti pelatihan, ini adalah perjalanan transformasi diri dan bangsa!' }}</textarea>
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Manfaat Program</h6>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-md-2">
                                                        <label class="form-label">Icon {{ $i }}</label>
                                                        <input type="text" name="manfaat_icon{{ $i }}"
                                                            class="form-control"
                                                            value="{{ $landing->{"manfaat_icon$i"} ?? '' }}">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <label class="form-label">Judul Manfaat
                                                            {{ $i }}</label>
                                                        <input type="text"
                                                            name="manfaat_item_title{{ $i }}"
                                                            class="form-control"
                                                            value="{{ $landing->{"manfaat_item_title$i"} ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">Deskripsi Manfaat
                                                            {{ $i }}</label>
                                                        <textarea name="manfaat_item_description{{ $i }}" class="form-control" rows="3">{{ $landing->{"manfaat_item_description$i"} ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                {{-- TAB MENGAPA BERGABUNG --}}
                                <div class="tab-pane fade" id="mengapa" role="tabpanel" aria-labelledby="mengapa-tab">
                                    <h5 class="mb-3">💡 Mengapa Bergabung</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mengapa_title" class="form-control"
                                                value="{{ $landing->mengapa_title ?? 'Mengapa Harus Bergabung?' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Pembuka</label>
                                        <div class="col-sm-9">
                                            <textarea name="mengapa_opening" class="form-control" rows="2">{{ $landing->mengapa_opening ?? 'Karena Anda bukan sekadar guru, Anda adalah pemantik perubahan yang akan:' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Poin-poin Alasan</label>
                                        <div class="col-sm-9">
                                            <textarea name="mengapa_points" class="form-control" rows="6">{{ $landing->mengapa_points ?? "• Menyalakan semangat literasi di daerah atau wilayah Indonesia\n• Menggerakkan kolaborasi pendidikan berbasis gotong royong.\n• Membangun karakter unggul dan budaya literasi berkelanjutan." }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Kutipan</label>
                                        <div class="col-sm-9">
                                            <textarea name="mengapa_quote" class="form-control" rows="3">{{ $landing->mengapa_quote ?? '"Literasi adalah jantung peradaban. Tanpa literasi, bangsa hanya akan jadi penonton di tengah arus perubahan."' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Penulis Kutipan</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mengapa_quote_author" class="form-control"
                                                value="{{ $landing->mengapa_quote_author ?? '- Najwa Shihab' }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB CTA --}}
                                <div class="tab-pane fade" id="daftar" role="tabpanel" aria-labelledby="daftar-tab">
                                    <h5 class="mb-3">📝 Daftar Sekarang</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Judul Utama</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="cta_main_title" class="form-control"
                                                value="{{ $landing->cta_main_title ?? 'Menuju Indonesia Kiblat Literasi Dunia' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Deskripsi Utama</label>
                                        <div class="col-sm-9">
                                            <textarea name="cta_main_description" class="form-control" rows="3">{{ $landing->cta_main_description ?? 'Bersama Guru Inspirator Literasi 2.0, kita menapaki jalan menuju Indonesia yang beradab, berdaya saing, dan berbudaya literasi.' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Subjudul</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="cta_subtitle" class="form-control"
                                                value="{{ $landing->cta_subtitle ?? 'Siap Jadi Pelita Literasi Bangsa?' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Teks Ajakan</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="cta_call_text" class="form-control"
                                                value="{{ $landing->cta_call_text ?? 'Sekaranglah waktunya!' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Teks Tombol</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="cta_button_text" class="form-control"
                                                value="{{ $landing->cta_button_text ?? '👉 DAFTAR SEKARANG' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Informasi Pendaftaran</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="cta_registration_info" class="form-control"
                                                value="{{ $landing->cta_registration_info ?? '📅 Pendaftaran Kandidat Terbuka hingga 30 Oktober 2025' }}">
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Modal Pendaftaran</h6>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Judul Modal</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="modal_title" class="form-control"
                                                        value="{{ $landing->modal_title ?? 'REGISTRASI PROGRAM NASIONAL GURU MOTIVATOR LITERASI 4.0 TAHUN 2025-2026' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Peringatan Modal</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="modal_warning" class="form-control"
                                                        value="{{ $landing->modal_warning ?? '- FORM INI HANYA UNTUK BAPAK IBU YANG LOLOS SEBAGAI KANDIDAT GML 4.0 -' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Subjudul Modal</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="modal_subtitle" class="form-control"
                                                        value="{{ $landing->modal_subtitle ?? 'FORM REGISTRASI PROGRAM GURU MOTIVATOR LITERASI 4.0' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Periode Pendaftaran</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="modal_period" class="form-control"
                                                        value="{{ $landing->modal_period ?? 'DIBUKA 30 September - 7 Oktober 2025' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Instruksi Pendaftaran</label>
                                                <div class="col-sm-9">
                                                    <textarea name="modal_instructions" class="form-control" rows="4">{{ $landing->modal_instructions ?? 'Sebelum mengisi form di bawah:' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Poin-poin Instruksi</label>
                                                <div class="col-sm-9">
                                                    <textarea name="modal_instruction_points" class="form-control" rows="4">{{ $landing->modal_instruction_points ?? "1. Pastikan Bapak Ibu mengisi data diri dengan benar dan lengkap.\n2. Pastikan Bapak Ibu telah mengupload bukti registrasi program sebesar Rp 150.000. Adapun biaya registrasi akan mendapat fasilitas berupa:" }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Fasilitas</label>
                                                <div class="col-sm-9">
                                                    <textarea name="modal_facilities" class="form-control" rows="10">{{ $landing->modal_facilities ?? "• Mengikuti Training Of Coach (TOC) GML 4.0 menjadi penggerak Literasi Nasional.\n• Mendapatkan e-Sertifikat pelatihan sebagai peserta TOC GML.\n• Mendapatkan perangkat support system GML 4.0.\n• Mendapatkan e-modul Panduan Teknis Wisata Literasi Indonesia.\n• Mendapatkan buku Kitab Suci Penulis atau Guru Ndeso Inspirator (ongkir ditanggung peserta).\n• Mendapatkan mentor penggerak program GML.\n• Berkesempatan menjadi pemenang GML terbaik nasional dan meraih Tour Gratis 3 Negara (Malaysia, Singapura, Thailand) bulan Juni 2026 + hadiah uang tunai jutaan rupiah.\n• Berkesempatan menerima penghargaan Anugerah Literasi Indonesia.\n• Berkesempatan mendapatkan reward tambahan uang jutaan rupiah.\n• Berkesempatan mengikuti seleksi GML Mitra Literasi Nasional.\n• Bergabung bersama komunitas GML 4.0 se-Indonesia." }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Catatan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="modal_note" class="form-control"
                                                        value="{{ $landing->modal_note ?? 'Note:' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Informasi Transfer</label>
                                                <div class="col-sm-9">
                                                    <textarea name="modal_transfer_info" class="form-control" rows="3">{{ $landing->modal_transfer_info ?? 'Biaya registrasi program dapat ditransfer melalui Bank BCA 5165827888 a.n. PT Fim Packer Internasional.' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Penutup 1</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="modal_closing1" class="form-control"
                                                        value="{{ $landing->modal_closing1 ?? 'Terima kasih dan selamat mengisi form.' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Penutup 2</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="modal_closing2" class="form-control"
                                                        value="{{ $landing->modal_closing2 ?? 'Admin GML 4.0 (0811-2701-0337)' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB SECTION DINAMIS --}}
                                @foreach ($sections as $section)
                                    <div class="tab-pane fade" id="section-{{ $section->id }}" role="tabpanel"
                                        aria-labelledby="tab-{{ $section->id }}">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">🧩 {{ $section->section_title ?? 'Tanpa Judul' }}</h5>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger delete-section-btn"
                                                data-section-id="{{ $section->id }}">
                                                <i class="bx bx-trash"></i> Hapus Section
                                            </button>
                                        </div>

                                        {{-- Informasi Umum Section --}}
                                        <div class="card mb-4 p-3 border rounded">
                                            <div class="row">
                                                {{-- Dropdown Section Type --}}
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">🧩 Jenis Section</label>
                                                    <select name="sections[{{ $section->id }}][section_type]"
                                                        class="form-select section-type-select"
                                                        data-section="{{ $section->id }}"
                                                        data-current="{{ $section->section_type }}" required>
                                                        @php
                                                            $types = [
                                                                'info_cards',
                                                                'gallery',
                                                                'video',
                                                                'form',
                                                                'text',
                                                                'points',
                                                            ];
                                                        @endphp
                                                        @foreach ($types as $type)
                                                            <option value="{{ $type }}"
                                                                {{ $section->section_type === $type ? 'selected' : '' }}>
                                                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Judul Section --}}
                                                <div class="col-md-5">
                                                    <label class="form-label fw-semibold">🏷️ Judul Section</label>
                                                    <input type="text"
                                                        name="sections[{{ $section->id }}][section_title]"
                                                        class="form-control" value="{{ $section->section_title }}"
                                                        required>
                                                </div>

                                                {{-- Urutan --}}
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold">🔢 Urutan Tampil</label>
                                                    <input type="number" name="sections[{{ $section->id }}][order]"
                                                        class="form-control" value="{{ $section->order ?? 0 }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Konten Dinamis --}}
                                        <h6 class="fw-bold mb-2">📚 Konten Section</h6>
                                        @php
                                            $content = json_decode($section->content, true) ?? [];
                                        @endphp

                                        <div id="section-items-{{ $section->id }}"
                                            data-type="{{ $section->section_type }}"
                                            data-section-id="{{ $section->id }}">
                                            @if ($section->section_type === 'info_cards')
                                                @include('lp_programs.partials.content-info-cards', [
                                                    'content' => $content,
                                                    'sectionId' => $section->id,
                                                ])
                                            @elseif ($section->section_type === 'gallery')
                                                @include('lp_programs.partials.content-gallery', [
                                                    'content' => $content,
                                                    'sectionId' => $section->id,
                                                ])
                                            @elseif ($section->section_type === 'video')
                                                @include('lp_programs.partials.content-video', [
                                                    'content' => $content,
                                                    'sectionId' => $section->id,
                                                ])
                                            @elseif ($section->section_type === 'form')
                                                @include('lp_programs.partials.content-form', [
                                                    'content' => $content,
                                                    'sectionId' => $section->id,
                                                ])
                                            @elseif ($section->section_type === 'text')
                                                @include('lp_programs.partials.content-text', [
                                                    'content' => $content,
                                                    'sectionId' => $section->id,
                                                ])
                                            @elseif ($section->section_type === 'points')
                                                @include('lp_programs.partials.content-points', [
                                                    'content' => $content,
                                                    'sectionId' => $section->id,
                                                ])
                                            @else
                                                <p class="text-muted">Tipe konten belum dikenali.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- TOMBOL SIMPAN SEMUA --}}
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bx bx-save"></i> 💾 Simpan Semua Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Color picker synchronization
            const colorPickers = [{
                    picker: 'primary_color_picker',
                    input: 'primary_color'
                },
                {
                    picker: 'secondary_color_picker',
                    input: 'secondary_color'
                },
                {
                    picker: 'accent_color_picker',
                    input: 'accent_color'
                },
                {
                    picker: 'dark_color_picker',
                    input: 'dark_color'
                }
            ];

            colorPickers.forEach(item => {
                const picker = document.getElementById(item.picker);
                const input = document.getElementById(item.input);

                if (picker && input) {
                    picker.addEventListener('input', function() {
                        input.value = this.value;
                    });

                    input.addEventListener('input', function() {
                        if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                            picker.value = this.value;
                        }
                    });
                }
            });

            // Delete section confirmation
            document.querySelectorAll('.delete-section-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const sectionId = this.dataset.sectionId;

                    Swal.fire({
                        title: 'Hapus Section?',
                        text: "Section yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const deleteUrl =
                                "{{ route('lp_programs.deleteSection', ':id') }}".replace(
                                    ':id', sectionId);

                            fetch(deleteUrl, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: data.message,
                                            timer: 1500,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Gagal!', data.message, 'error');
                                    }
                                })
                                .catch(() => {
                                    Swal.fire('Gagal!', 'Terjadi kesalahan jaringan.',
                                        'error');
                                });
                        }
                    });
                });
            });

            // Form submission handling
            document.getElementById('mainForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                });

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Optional: reload jika diperlukan
                                // location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat menyimpan'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan jaringan',
                        });
                        console.error('Error:', error);
                    });
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        </script>
    @endif
@endpush
