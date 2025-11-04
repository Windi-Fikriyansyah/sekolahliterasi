@extends('template.app')
@section('title', 'Upload Materi PDF')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Upload Materi PDF</h5>
                        <small class="text-muted float-end">Tambah dan hapus file dinamis</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('produk.store_file') }}" method="POST" enctype="multipart/form-data"
                            id="materiForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $produk->id }}">
                            <div id="materi-container">
                                @if (isset($materi) && count($materi) > 0)
                                    @foreach ($materi as $item)
                                        <div class="materi-item border rounded p-3 mb-3">
                                            <div class="row align-items-center">
                                                <input type="hidden" name="id_materi[]" value="{{ $item->id }}">
                                                <div class="col-md-5">
                                                    <label class="form-label">Judul</label>
                                                    <input type="text" name="judul[]" class="form-control"
                                                        value="{{ $item->judul }}" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label">Upload PDF</label>
                                                    <input type="file" class="filepond" name="pdf_file[]"
                                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                                        data-existing-url="{{ Storage::url($item->file_path) }}"
                                                        data-existing-path="{{ $item->file_path }}">

                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger remove-materi w-100">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Jika belum ada data --}}
                                    <div class="materi-item border rounded p-3 mb-3">
                                        <input type="hidden" name="id_materi[]" value="">
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <label class="form-label">Judul</label>
                                                <input type="text" name="judul[]" class="form-control"
                                                    placeholder="Tuliskan judul..." required>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Upload File (PDF atau Gambar)</label>
                                                <input type="file" class="filepond" name="pdf_file[]"
                                                    accept="application/pdf,image/png,image/jpeg,image/jpg">
                                            </div>

                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-materi w-100">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>


                            <button type="button" id="addMateri" class="btn btn-outline-primary mb-3">
                                <i class="bi bi-plus-circle"></i> Tambah Materi
                            </button>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />
    <style>
        .filepond--root {
            margin-bottom: 0;
        }

        .filepond--panel-root {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
        }

        .filepond--drop-label {
            color: #6c757d;
        }

        .materi-item {
            background-color: #fff;
            transition: all 0.3s ease;
        }
    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js">
    </script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js">
    </script>
    <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            FilePond.registerPlugin(
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType,
                FilePondPluginFilePoster
            );

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // 🔹 Fungsi inisialisasi FilePond
            function initFilePond(input) {
                const container = input.closest('.materi-item');
                let hidden = container.querySelector('input[name="uploaded_paths[]"]');
                if (!hidden) {
                    hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'uploaded_paths[]';
                    container.appendChild(hidden);
                }

                // 🔹 Cek apakah ini file lama
                const existingFileUrl = input.dataset.existingUrl || null;
                const existingFilePath = input.dataset.existingPath || null;

                // Buat FilePond instance
                const pond = FilePond.create(input, {
                    labelIdle: 'Drag & Drop file (PDF/Gambar) atau <span class="filepond--label-action">Browse</span>',
                    acceptedFileTypes: ['application/pdf', 'image/png', 'image/jpeg'],
                    maxFileSize: '100MB',
                    credits: false,
                    server: {
                        process: {
                            url: '{{ route('produk.upload-pdf-chunk') }}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            onload: (response) => {
                                try {
                                    const res = JSON.parse(response);
                                    if (res.status && res.files && res.files[0]) {
                                        hidden.value = res.files[0].path;
                                    }
                                } catch (e) {
                                    console.error('Invalid JSON response:', response);
                                }
                                return response;
                            },
                        },
                        revert: {
                            url: '{{ route('produk.delete-pdf-chunk') }}',
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            onload: () => {
                                hidden.value = ''; // kosongkan kalau dihapus
                            }
                        }
                    }
                });

                // 🔹 Jika ada file lama, tampilkan di FilePond
                if (existingFileUrl && existingFilePath) {
                    hidden.value = existingFilePath;
                    pond.addFile(existingFileUrl, {
                        type: 'local',
                        file: {
                            name: existingFilePath.split('/').pop(),
                            size: 1234,
                            type: 'application/pdf'
                        },
                        options: {
                            type: 'local',
                            filePoster: existingFileUrl
                        }
                    });
                }
            }

            // Inisialisasi semua FilePond di halaman awal
            document.querySelectorAll('.filepond').forEach(initFilePond);

            // Tombol tambah baris baru
            document.getElementById('addMateri').addEventListener('click', () => {
                const container = document.getElementById('materi-container');
                const item = document.createElement('div');
                item.className = 'materi-item border rounded p-3 mb-3';
                item.innerHTML = `
            <div class="row align-items-center">
                <input type="hidden" name="id_materi[]" value="">
                <div class="col-md-5">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul[]" class="form-control" placeholder="Tuliskan judul..." required>
                </div>
                <div class="col-md-5">
    <label class="form-label">Upload File (PDF atau Gambar)</label>
    <input type="file" class="filepond" name="pdf_file[]"
        accept="application/pdf,image/png,image/jpeg,image/jpg">
</div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-materi w-100">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </div>`;
                container.appendChild(item);
                initFilePond(item.querySelector('.filepond'));
            });

            // Tombol hapus baris
            document.getElementById('materi-container').addEventListener('click', e => {
                if (e.target.closest('.remove-materi')) {
                    e.target.closest('.materi-item').remove();
                }
            });
        });
    </script>
@endpush
