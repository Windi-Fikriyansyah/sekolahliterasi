@extends('template.app')
@section('title', isset($course) ? 'Edit Course' : 'Tambah Course')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($course) ? 'Edit' : 'Tambah' }} Course</h5>
                        <small class="text-muted float-end">Form Course</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($course) ? route('kursus.update', $course->id) : route('kursus.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($course))
                                @method('PUT')
                            @endif

                            <!-- Title -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="title">Judul Course</label>
                                <div class="col-sm-10">
                                    <input type="text" id="title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $course->title ?? '') }}" required />
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="description">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                        rows="4" required>{{ old('description', $course->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Thumbnail -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="thumbnail">Thumbnail</label>
                                <div class="col-sm-10">
                                    <input type="file" id="thumbnail" name="thumbnail"
                                        class="form-control @error('thumbnail') is-invalid @enderror"
                                        {{ isset($course) ? '' : 'required' }} accept="image/*">

                                    @if (isset($course) && $course->thumbnail)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail"
                                                class="img-thumbnail" style="max-height: 150px;">
                                            <small class="d-block text-muted">Thumbnail saat ini</small>
                                        </div>
                                    @endif

                                    <div id="thumbnail-preview" class="mt-2 d-none">
                                        <img id="preview-image" src="#" alt="Preview" class="img-thumbnail"
                                            style="max-height: 150px;">
                                        <small class="d-block text-muted">Preview thumbnail baru</small>
                                    </div>

                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="price">Harga</label>
                                <div class="col-sm-10">
                                    <input type="text" id="price" name="price_display"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', isset($course->price) ? 'Rp ' . number_format($course->price, 0, ',', '.') : '') }}"
                                        required />
                                    <input type="hidden" id="price_numeric" name="price"
                                        value="{{ old('price', $course->price ?? 0) }}">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Is Free -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="is_free">Gratis?</label>
                                <div class="col-sm-10">
                                    <select id="is_free" name="is_free"
                                        class="form-control @error('is_free') is-invalid @enderror" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="1"
                                            {{ old('is_free', $course->is_free ?? '') == 1 ? 'selected' : '' }}>Ya</option>
                                        <option value="0"
                                            {{ old('is_free', $course->is_free ?? '') == 0 ? 'selected' : '' }}>Tidak
                                        </option>
                                    </select>
                                    @error('is_free')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status</label>
                                <div class="col-sm-10">
                                    <select id="status" name="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="active"
                                            {{ old('status', $course->status ?? '') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $course->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit"
                                        class="btn btn-primary">{{ isset($course) ? 'Update' : 'Simpan' }}</button>
                                    <a href="{{ route('kursus.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
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
        // Format currency input
        const priceInput = document.getElementById('price');
        const priceNumeric = document.getElementById('price_numeric');

        priceInput.addEventListener('input', function(e) {
            // Hapus semua karakter non-digit
            let numericValue = e.target.value.replace(/\D/g, '');

            // Simpan nilai numerik di input hidden
            priceNumeric.value = numericValue ? parseInt(numericValue) : 0;

            // Format tampilan dengan separator ribuan
            if (numericValue) {
                e.target.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(numericValue);
            } else {
                e.target.value = '';
            }
        });

        // Inisialisasi nilai saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const initialValue = priceNumeric.value;
            if (initialValue && initialValue > 0) {
                priceInput.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(initialValue);
            }
        });

        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            // Pastikan nilai numerik sudah terisi
            if (!priceNumeric.value || priceNumeric.value == 0) {
                // Jika gratis, set nilai ke 0
                if (document.getElementById('is_free').value === '1') {
                    priceNumeric.value = 0;
                } else {
                    // Jika tidak gratis, tampilkan error
                    e.preventDefault();
                    alert('Harap isi harga dengan benar');
                    priceInput.focus();
                }
            }
        });

        // Toggle price field based on is_free selection
        document.getElementById('is_free').addEventListener('change', function(e) {
            if (e.target.value === '1') {
                priceInput.value = 'Rp 0';
                priceNumeric.value = 0;
                priceInput.setAttribute('readonly', 'readonly');
            } else {
                priceInput.removeAttribute('readonly');
                if (priceInput.value === 'Rp 0') {
                    priceInput.value = '';
                    priceNumeric.value = '';
                }
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const isFreeSelect = document.getElementById('is_free');
            if (isFreeSelect.value === '1') {
                priceInput.setAttribute('readonly', 'readonly');
            }
        });
        // Preview thumbnail
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('thumbnail-preview').classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('thumbnail-preview').classList.add('d-none');
            }
        });
    </script>
@endpush
