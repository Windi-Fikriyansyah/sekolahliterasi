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
                            action="{{ isset($produk) ? route('produk_buku.update', $produk->id) : route('produk_buku.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($produk))
                                @method('PUT')
                            @endif

                            <div class="row">
                                {{-- Kolom kiri --}}
                                <div class="col-md-6">

                                    {{-- Judul Produk --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="judul">Judul Produk</label>
                                        <input type="text" id="judul" name="judul"
                                            class="form-control @error('judul') is-invalid @enderror"
                                            value="{{ old('judul', $produk->judul ?? '') }}" required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Penulis --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="penulis">Penulis</label>
                                        <input type="text" id="penulis" name="penulis"
                                            class="form-control @error('penulis') is-invalid @enderror"
                                            value="{{ old('penulis', $produk->penulis ?? '') }}">
                                        @error('penulis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- No ISBN --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="isbn">No. ISBN</label>
                                        <input type="text" id="isbn" name="isbn"
                                            class="form-control @error('isbn') is-invalid @enderror"
                                            value="{{ old('isbn', $produk->isbn ?? '') }}">
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Penerbit --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="penerbit">Penerbit</label>
                                        <input type="text" id="penerbit" name="penerbit"
                                            class="form-control @error('penerbit') is-invalid @enderror"
                                            value="{{ old('penerbit', $produk->penerbit ?? '') }}">
                                        @error('penerbit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Tanggal Terbit --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="tanggal_terbit">Tanggal Terbit</label>
                                        <input type="date" id="tanggal_terbit" name="tanggal_terbit"
                                            class="form-control @error('tanggal_terbit') is-invalid @enderror"
                                            value="{{ old('tanggal_terbit', $produk->tanggal_terbit ?? '') }}">
                                        @error('tanggal_terbit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Jumlah Halaman --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="jumlah_halaman">Jumlah Halaman</label>
                                        <input type="number" id="jumlah_halaman" name="jumlah_halaman"
                                            class="form-control @error('jumlah_halaman') is-invalid @enderror"
                                            value="{{ old('jumlah_halaman', $produk->jumlah_halaman ?? '') }}">
                                        @error('jumlah_halaman')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Berat --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="berat">Berat (gram)</label>
                                        <input type="number" id="berat" name="berat" step="0.01" min="0"
                                            class="form-control @error('berat') is-invalid @enderror"
                                            value="{{ old('berat', $produk->berat ?? '') }}">
                                        @error('berat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                {{-- Kolom kanan --}}
                                <div class="col-md-6">

                                    {{-- Jenis Cover --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="jenis_cover">Jenis Cover</label>
                                        <input type="text" id="jenis_cover" name="jenis_cover"
                                            class="form-control @error('jenis_cover') is-invalid @enderror"
                                            value="{{ old('jenis_cover', $produk->jenis_cover ?? '') }}">
                                        @error('jenis_cover')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Dimensi --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="dimensi">Dimensi (L x P)</label>
                                        <input type="text" id="dimensi" name="dimensi"
                                            class="form-control @error('dimensi') is-invalid @enderror"
                                            value="{{ old('dimensi', $produk->dimensi ?? '') }}">
                                        @error('dimensi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Kategori --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="kategori">Kategori</label>
                                        <select id="kategori" name="kategori"
                                            class="form-control select2 @error('kategori') is-invalid @enderror" required>
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}"
                                                    {{ old('kategori', $produk->kategori ?? '') == $kategori->id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    {{-- Bahasa --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="bahasa">Bahasa</label>
                                        <input type="text" id="bahasa" name="bahasa"
                                            class="form-control @error('bahasa') is-invalid @enderror"
                                            value="{{ old('bahasa', $produk->bahasa ?? '') }}">
                                        @error('bahasa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Lokasi Stok --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="stok">Stok</label>
                                        <input type="number" id="stok" name="stok"
                                            class="form-control @error('stok') is-invalid @enderror"
                                            value="{{ old('stok', $produk->stok ?? '') }}">
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Thumbnail --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="thumbnail">Thumbnail</label>
                                        <input type="file" id="thumbnail" name="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror"
                                            {{ isset($produk) ? '' : 'required' }} accept="image/*">
                                        @if (isset($produk) && $produk->thumbnail)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="Thumbnail"
                                                    class="img-thumbnail" style="max-height:150px;">
                                            </div>
                                        @endif
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <div id="quillEditor" style="height: 200px;">
                                    {!! old('deskripsi', $produk->deskripsi ?? '') !!}
                                </div>
                                <textarea name="deskripsi" id="deskripsi" class="d-none"></textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Harga dan Status --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="harga">Harga</label>
                                    <input type="text" id="harga_display" class="form-control" placeholder="Rp 0"
                                        value="{{ old('harga', isset($produk) ? 'Rp ' . number_format($produk->harga, 0, ',', '.') : '') }}">
                                    <input type="hidden" id="harga" name="harga"
                                        value="{{ old('harga', $produk->harga ?? 0) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="aktif"
                                            {{ old('status', $produk->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif"
                                            {{ old('status', $produk->status ?? '') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($produk) ? 'Update' : 'Simpan' }}</button>
                                <a href="{{ route('produk_buku.index') }}" class="btn btn-secondary">Kembali</a>
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap5-theme@1.3.2/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

            // ✅ Saat form disubmit, kirim isi Quill ke textarea
            const form = document.getElementById("produkForm");
            form.addEventListener("submit", function() {
                const deskripsi = document.getElementById("deskripsi");
                deskripsi.value = quill.root.innerHTML.trim();
            });

            // Format harga
            const hargaDisplay = document.getElementById('harga_display');
            const hargaInput = document.getElementById('harga');
            hargaDisplay.addEventListener('input', function(e) {
                let angka = e.target.value.replace(/\D/g, '');
                hargaInput.value = angka ? parseInt(angka) : 0;
                e.target.value = angka ? 'Rp ' + new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        });

        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih Produk --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
