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
                        <div class="mb-4 text-end">
                            <a href="{{ route('lp_programs.create', ['landing_page_id' => $landing->id]) }}"
                                class="btn btn-success btn-sm">
                                <i class="bx bx-plus"></i> Tambah Section Baru
                            </a>
                        </div>

                        {{-- Tabs --}}
                        <ul class="nav nav-tabs mb-4" id="landingTabs" role="tablist">
                            {{-- Tab Utama --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="utama-tab" data-bs-toggle="tab" data-bs-target="#utama"
                                    type="button" role="tab" aria-controls="utama" aria-selected="true">🏠 Section
                                    Utama</button>
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

                                    {{-- HERO SECTION --}}
                                    {{-- HERO SECTION --}}
                                    <div class="mb-4">
                                        <h5 class="mb-3">🎯 Hero Section</h5>

                                        {{-- Judul Hero --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Judul Hero *</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="hero_title" class="form-control"
                                                    value="{{ $landing->hero_title ?? old('hero_title', 'Indonesia Menulis') }}">
                                            </div>
                                        </div>

                                        {{-- Deskripsi 1 --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Deskripsi Pertama *</label>
                                            <div class="col-sm-9">
                                                <textarea name="hero_subtitle" class="form-control" rows="3">{{ $landing->hero_subtitle ?? old('hero_subtitle', 'Wujudkan mimpi Anda menjadi penulis profesional bersama komunitas terbesar di Indonesia') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Deskripsi 2 --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Deskripsi Kedua (opsional)</label>
                                            <div class="col-sm-9">
                                                <textarea name="hero_subtitle_2" class="form-control" rows="3">{{ $landing->hero_subtitle_2 ?? old('hero_subtitle_2', 'Bergabunglah bersama ribuan penulis lain yang telah menerbitkan karya terbaik mereka.') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Gambar Hero --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Gambar Hero</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->hero_image))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->hero_image) }}"
                                                            alt="Hero Image" class="img-fluid rounded shadow-sm"
                                                            style="max-height: 200px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="hero_image" class="form-control">
                                                <small class="text-muted">Format: JPG, PNG, WEBP | Maks 2MB</small>
                                            </div>
                                        </div>

                                        {{-- Logo Header --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Logo Header 1</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->header_logo1))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->header_logo1) }}"
                                                            alt="Logo Header" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="header_logo1" class="form-control">
                                                <small class="text-muted">Format: PNG transparan atau JPG | Maks
                                                    1MB</small>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Logo Header 2</label>
                                            <div class="col-sm-9">
                                                @if (!empty($landing->header_logo2))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $landing->header_logo2) }}"
                                                            alt="Logo Header" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="header_logo2" class="form-control">
                                                <small class="text-muted">Format: PNG transparan atau JPG | Maks
                                                    1MB</small>
                                            </div>
                                        </div>

                                        {{-- Warna Hero --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Warna Hero Start *</label>
                                            <div class="col-sm-9 d-flex align-items-center gap-2">
                                                <input type="color" id="hero_color_start_picker"
                                                    class="form-control form-control-color"
                                                    value="{{ $landing->hero_color_start ?? '#667eea' }}">
                                                <input type="text" id="hero_color_start" name="hero_color_start"
                                                    class="form-control"
                                                    value="{{ $landing->hero_color_start ?? '#667eea' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Warna Hero End *</label>
                                            <div class="col-sm-9 d-flex align-items-center gap-2">
                                                <input type="color" id="hero_color_end_picker"
                                                    class="form-control form-control-color"
                                                    value="{{ $landing->hero_color_end ?? '#764ba2' }}">
                                                <input type="text" id="hero_color_end" name="hero_color_end"
                                                    class="form-control"
                                                    value="{{ $landing->hero_color_end ?? '#764ba2' }}">
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
                                                    value="{{ $landing->primary_color ?? '#667eea' }}">
                                                <input type="text" id="primary_color" name="primary_color"
                                                    class="form-control"
                                                    value="{{ $landing->primary_color ?? '#667eea' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Warna Secondary *</label>
                                            <div class="col-sm-9 d-flex align-items-center gap-2">
                                                <input type="color" id="secondary_color_picker"
                                                    class="form-control form-control-color"
                                                    value="{{ $landing->secondary_color ?? '#764ba2' }}">
                                                <input type="text" id="secondary_color" name="secondary_color"
                                                    class="form-control"
                                                    value="{{ $landing->secondary_color ?? '#764ba2' }}">
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
                                                    value="{{ $landing->footer_text ?? '© 2024 Indonesia Menulis. Semua hak dilindungi.' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Email Kontak</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="footer_contact" class="form-control"
                                                    value="{{ $landing->footer_contact ?? 'info@indonesiamenulis.id' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Nomor Telepon</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="footer_phone" class="form-control"
                                                    value="{{ $landing->footer_phone ?? '+62 812-3456-7890' }}">
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
                    picker: 'hero_color_start_picker',
                    input: 'hero_color_start'
                },
                {
                    picker: 'hero_color_end_picker',
                    input: 'hero_color_end'
                },
                {
                    picker: 'primary_color_picker',
                    input: 'primary_color'
                },
                {
                    picker: 'secondary_color_picker',
                    input: 'secondary_color'
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
            // Form submission handling (dengan file upload support penuh)
            document.getElementById('mainForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData();

                // Tambahkan semua input text dan hidden
                form.querySelectorAll('input:not([type=file]), textarea, select').forEach(input => {
                    if (input.name) formData.append(input.name, input.value);
                });

                // Tambahkan semua file (termasuk gallery)
                form.querySelectorAll('input[type=file]').forEach(fileInput => {
                    if (fileInput.files.length > 0) {
                        for (let i = 0; i < fileInput.files.length; i++) {
                            formData.append(fileInput.name, fileInput.files[i]);
                        }
                    }
                });

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
                            'X-Requested-With': 'XMLHttpRequest'
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
                            }).then(() => location.reload()); // ✅ reload supaya data tersinkron dari DB
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
