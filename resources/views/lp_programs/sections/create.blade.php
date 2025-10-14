@extends('template.app')
@section('title', 'Tambah Section Baru')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header text-white">
                        <h5 class="mb-0">➕ Tambah Section Baru</h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('lp_programs.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="landing_page_id" value="{{ $landing->id }}">

                            {{-- Section Type --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">🧩 Jenis Section</label>
                                <select name="section_type" id="section_type" class="form-select" required>
                                    <option value="">-- Pilih Jenis Section --</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}">{{ ucfirst(str_replace('_', ' ', $type)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Jenis ini menentukan struktur konten section.</small>
                            </div>

                            {{-- Judul Section --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">🏷️ Judul Section</label>
                                <input type="text" name="section_title" class="form-control"
                                    placeholder="Masukkan judul section" required>
                            </div>

                            {{-- Urutan --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">🔢 Urutan Tampil</label>
                                <input type="number" name="order" class="form-control" value="0">
                            </div>

                            {{-- Preview Struktur --}}
                            <div id="preview-structure" class="alert alert-info d-none">
                                <strong>Struktur konten:</strong>
                                <ul class="mb-0 mt-1" id="preview-list"></ul>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('lp_programs.atur', encrypt($landing->product_id)) }}"
                                    class="btn btn-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-success">💾 Simpan Section</button>
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
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('section_type');
            const preview = document.getElementById('preview-structure');
            const list = document.getElementById('preview-list');

            const structures = {
                info_cards: ['icon', 'title', 'description'],
                gallery: ['image (URL/link)'],
                video: ['video_url'],
                form: ['name', 'placeholder', 'type'],
                text: ['heading', 'body'],
                points: ['text (list poin)']
            };

            select.addEventListener('change', function() {
                const type = this.value;
                if (type && structures[type]) {
                    list.innerHTML = '';
                    structures[type].forEach(f => {
                        const li = document.createElement('li');
                        li.textContent = f;
                        list.appendChild(li);
                    });
                    preview.classList.remove('d-none');
                } else {
                    preview.classList.add('d-none');
                }
            });
        });
    </script>
@endpush
