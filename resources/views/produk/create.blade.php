@extends('template.app')
@section('title', isset($produk) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($produk) ? 'Edit' : 'Tambah' }} Produk</h5>
                        <small class="text-muted float-end">Form Produk</small>
                    </div>
                    <div class="card-body">
                        <form id="produkForm"
                            action="{{ isset($produk) ? route('produk.update', $produk->id) : route('produk.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($produk))
                                @method('PUT')
                            @endif

                            {{-- Judul --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="judul">Judul Produk</label>
                                <div class="col-sm-10">
                                    <input type="text" id="judul" name="judul"
                                        class="form-control @error('judul') is-invalid @enderror"
                                        value="{{ old('judul', $produk->judul ?? '') }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tipe Produk --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tipe_produk">Tipe Produk</label>
                                <div class="col-sm-10">
                                    <select id="tipe_produk" name="tipe_produk"
                                        class="form-control @error('tipe_produk') is-invalid @enderror" required>
                                        <option value="">-- Pilih Tipe Produk --</option>
                                        <option value="ebook"
                                            {{ old('tipe_produk', $produk->tipe_produk ?? '') == 'ebook' ? 'selected' : '' }}>
                                            E-Book</option>
                                        <option value="kelas_video"
                                            {{ old('tipe_produk', $produk->tipe_produk ?? '') == 'kelas_video' ? 'selected' : '' }}>
                                            Kelas Video</option>
                                        <option value="program"
                                            {{ old('tipe_produk', $produk->tipe_produk ?? '') == 'program' ? 'selected' : '' }}>
                                            Program</option>

                                        <option value="mitra"
                                            {{ old('tipe_produk', $produk->tipe_produk ?? '') == 'mitra' ? 'selected' : '' }}>
                                            Kemitraan</option>
                                        <option value="book_masterpiece"
                                            {{ old('tipe_produk', $produk->tipe_produk ?? '') == 'book_masterpiece' ? 'selected' : '' }}>
                                            Book Masterpiece
                                        </option>

                                    </select>
                                    @error('tipe_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Jenis Program (hanya muncul jika tipe_produk = program) --}}
                            <div class="row mb-3" id="jenis_program_group" style="display: none;">
                                <label class="col-sm-2 col-form-label" for="jenis_program">Jenis Program</label>
                                <div class="col-sm-10">
                                    <select id="jenis_program" name="jenis_program"
                                        class="form-control @error('jenis_program') is-invalid @enderror">
                                        <option value="">-- Pilih Jenis Program --</option>
                                        <option value="sekolah"
                                            {{ old('jenis_program', $produk->jenis_program ?? '') == 'sekolah' ? 'selected' : '' }}>
                                            Sekolah</option>
                                        <option value="pribadi"
                                            {{ old('jenis_program', $produk->jenis_program ?? '') == 'pribadi' ? 'selected' : '' }}>
                                            Pribadi</option>
                                    </select>
                                    @error('jenis_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Pilih Formulir (khusus program) --}}
                            <div class="row mb-3" id="formulir_group" style="display:none;">
                                <label class="col-sm-2 col-form-label">Pilih Formulir</label>
                                <div class="col-sm-10">
                                    <select name="form_id" id="form_id" class="form-control">
                                        <option value="">-- Pilih Formulir --</option>
                                        @foreach ($forms as $form)
                                            <option value="{{ $form->id }}"
                                                {{ old('form_id', $produk->form_id ?? '') == $form->id ? 'selected' : '' }}>
                                                {{ $form->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div class="row mb-3" id="payment_group" style="display:none;">
                                <label class="col-sm-2 col-form-label">Metode Pembayaran</label>
                                <div class="col-sm-10">
                                    <select name="payment_type" id="payment_type" class="form-control">
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="manual"
                                            {{ old('payment_type', $produk->payment_type ?? '') == 'manual' ? 'selected' : '' }}>
                                            Manual
                                        </option>
                                        <option value="auto"
                                            {{ old('payment_type', $produk->payment_type ?? '') == 'auto' ? 'selected' : '' }}>
                                            Otomatis
                                        </option>
                                    </select>
                                </div>
                            </div>


                            {{-- Deskripsi --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                                <div class="col-sm-10">
                                    <div id="quillEditor" style="height: 250px;">
                                        {!! old('deskripsi', $produk->deskripsi ?? '') !!}
                                    </div>
                                    <textarea name="deskripsi" id="deskripsi" class="d-none"></textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            {{-- Thumbnail --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="thumbnail">Thumbnail</label>
                                <div class="col-sm-10">
                                    <input type="file" id="thumbnail" name="thumbnail"
                                        class="form-control @error('thumbnail') is-invalid @enderror"
                                        {{ isset($produk) ? '' : 'required' }} accept="image/*">
                                    @if (isset($produk) && $produk->thumbnail)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="Thumbnail"
                                                class="img-thumbnail" style="max-height:150px;">
                                            <small class="d-block text-muted">Thumbnail saat ini</small>
                                        </div>
                                    @endif
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Harga --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="harga">Harga</label>
                                <div class="col-sm-10">
                                    <input type="text" id="harga_display" class="form-control" placeholder="Rp 0"
                                        value="{{ old('harga', isset($produk) ? 'Rp ' . number_format($produk->harga, 0, ',', '.') : '') }}">
                                    <input type="hidden" id="harga" name="harga"
                                        value="{{ old('harga', $produk->harga ?? 0) }}">
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status</label>
                                <div class="col-sm-10">
                                    <select id="status" name="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="aktif"
                                            {{ old('status', $produk->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif"
                                            {{ old('status', $produk->status ?? '') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Manfaat Produk --}}
                            {{-- Manfaat Produk --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="manfaat">Benefit Produk</label>
                                <div class="col-sm-10">
                                    <div id="manfaatContainer">
                                        @php
                                            $manfaatList = old(
                                                'manfaat',
                                                isset($produk->manfaat)
                                                    ? json_decode($produk->manfaat, true)
                                                    : [['judul' => '', 'deskripsi' => '']],
                                            );
                                        @endphp

                                        @foreach ($manfaatList as $index => $manfaat)
                                            <div class="manfaat-item border rounded p-3 mb-3 bg-light position-relative">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 removeManfaat">&times;</button>

                                                <div class="mb-2">
                                                    <label class="form-label">Judul Benefit</label>
                                                    <input type="text" name="manfaat[{{ $index }}][judul]"
                                                        class="form-control" placeholder="Contoh: Konten Berkualitas"
                                                        value="{{ $manfaat['judul'] ?? '' }}">
                                                </div>

                                                <div>
                                                    <label class="form-label">Deskripsi</label>
                                                    <div id="quillManfaat_{{ $index }}"
                                                        class="quill-manfaat-editor" style="height: 150px;">
                                                        {!! $manfaat['deskripsi'] ?? '' !!}
                                                    </div>
                                                    <input type="hidden" name="manfaat[{{ $index }}][deskripsi]"
                                                        id="inputManfaat_{{ $index }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" id="addManfaat" class="btn btn-sm btn-success mt-2">
                                        + Tambah Benefit
                                    </button>

                                    @error('manfaat')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            {{-- Tombol Submit --}}
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit"
                                        class="btn btn-primary">{{ isset($produk) ? 'Update' : 'Simpan' }}</button>
                                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link href="{{ asset('template/dist/assets/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/dist/assets/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/dist/assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script src="{{ asset('template/dist/assets/libs/quill/quill.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi Quill
            var quill = new Quill("#quillEditor", {
                theme: "snow",
                modules: {
                    toolbar: [
                        [{
                            'font': []
                        }, {
                            'size': []
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'script': 'super'
                        }, {
                            'script': 'sub'
                        }],
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }, 'blockquote', 'code-block'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }, {
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        ['direction', {
                            'align': []
                        }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });



            // Format harga
            const hargaDisplay = document.getElementById('harga_display');
            const hargaInput = document.getElementById('harga');
            hargaDisplay.addEventListener('input', function(e) {
                let angka = e.target.value.replace(/\D/g, '');
                hargaInput.value = angka ? parseInt(angka) : 0;
                e.target.value = angka ? 'Rp ' + new Intl.NumberFormat('id-ID').format(angka) : '';
            });

            const manfaatEditors = {};
            document.querySelectorAll('.quill-manfaat-editor').forEach((el, i) => {
                manfaatEditors[i] = new Quill(el, {
                    theme: "snow",
                    modules: {
                        toolbar: [
                            [{
                                'font': []
                            }, {
                                'size': []
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'color': []
                            }, {
                                'background': []
                            }],
                            [{
                                'script': 'super'
                            }, {
                                'script': 'sub'
                            }],
                            [{
                                'header': [1, 2, 3, 4, 5, 6, false]
                            }, 'blockquote', 'code-block'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }, {
                                'indent': '-1'
                            }, {
                                'indent': '+1'
                            }],
                            ['direction', {
                                'align': []
                            }],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    }
                });
            });
            const manfaatContainer = document.getElementById('manfaatContainer');
            const addManfaatBtn = document.getElementById('addManfaat');

            function createManfaatItem(index) {
                const div = document.createElement('div');
                div.classList.add('manfaat-item', 'border', 'rounded', 'p-3', 'mb-3', 'bg-light',
                    'position-relative');
                div.innerHTML = `
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 removeManfaat">&times;</button>
            <div class="mb-2">
                <label class="form-label">Judul Benefit</label>
                <input type="text" name="manfaat[${index}][judul]" class="form-control" placeholder="Contoh: Akses Selamanya">
            </div>
            <div>
                <label class="form-label">Deskripsi</label>
                <div id="quillManfaat_${index}" class="quill-manfaat-editor" style="height: 150px;"></div>
                <input type="hidden" name="manfaat[${index}][deskripsi]" id="inputManfaat_${index}">
            </div>
        `;
                manfaatContainer.appendChild(div);

                // Inisialisasi Quill baru
                manfaatEditors[index] = new Quill(`#quillManfaat_${index}`, {
                    theme: "snow",
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{
                                list: 'ordered'
                            }, {
                                list: 'bullet'
                            }],
                            ['clean']
                        ]
                    }
                });
            }

            addManfaatBtn.addEventListener('click', () => {
                const index = manfaatContainer.querySelectorAll('.manfaat-item').length;
                createManfaatItem(index);
            });

            manfaatContainer.addEventListener('click', (e) => {
                if (e.target.classList.contains('removeManfaat')) {
                    e.target.closest('.manfaat-item').remove();
                }
            });

            // === Submit form ===
            const form = document.getElementById("produkForm");
            form.addEventListener("submit", function() {
                // Simpan deskripsi utama
                document.getElementById("deskripsi").value = quill.root.innerHTML.trim();

                // Simpan deskripsi tiap manfaat
                Object.keys(manfaatEditors).forEach(i => {
                    const inputHidden = document.getElementById(`inputManfaat_${i}`);
                    if (inputHidden) {
                        inputHidden.value = manfaatEditors[i].root.innerHTML.trim();
                    }
                });
            });


        });
    </script>
    <script>
        const tipeProdukInput = document.getElementById("tipe_produk");
        const jenisProgramGroup = document.getElementById("jenis_program_group");
        const formulirGroup = document.getElementById("formulir_group");
        const paymentGroup = document.getElementById("payment_group");

        function toggleProgramFields() {
            if (tipeProdukInput.value === "program") {
                jenisProgramGroup.style.display = "flex";
                formulirGroup.style.display = "flex";
                paymentGroup.style.display = "flex";
            } else {
                jenisProgramGroup.style.display = "none";
                formulirGroup.style.display = "none";
                paymentGroup.style.display = "none";

                document.getElementById("jenis_program").value = "";
                document.getElementById("form_id").value = "";
                document.getElementById("payment_type").value = "";
            }
        }

        toggleProgramFields();
        tipeProdukInput.addEventListener("change", toggleProgramFields);
    </script>
@endpush
