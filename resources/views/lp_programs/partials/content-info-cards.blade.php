<div class="info-cards-section" data-section="{{ $sectionId }}">
    @forelse ($content as $index => $item)
        <div class="card mb-3 p-3 border rounded bg-light section-item">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Item {{ $loop->iteration }}</h6>
                <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑 Hapus</button>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">Ikon</label>
                    <input type="text" name="sections[{{ $sectionId }}][content][{{ $index }}][icon]"
                        class="form-control" value="{{ $item['icon'] ?? '' }}" placeholder="Contoh: 📚">
                </div>

                <div class="col-md-5">
                    <label class="form-label">Judul</label>
                    <input type="text" name="sections[{{ $sectionId }}][content][{{ $index }}][title]"
                        class="form-control" value="{{ $item['title'] ?? '' }}" placeholder="Masukkan judul">
                </div>

                <div class="col-md-5">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="sections[{{ $sectionId }}][content][{{ $index }}][description]" rows="2"
                        class="form-control" placeholder="Masukkan deskripsi">{{ $item['description'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada item info card.</p>
    @endforelse

    {{-- Tombol Tambah Item --}}
    <div class="mt-3 text-end">
        <button type="button" class="btn btn-sm btn-success add-info-card-btn" data-section="{{ $sectionId }}">
            <i class="bx bx-plus"></i> Tambah Info Card
        </button>
    </div>
</div>

{{-- Script dinamis tambah/hapus --}}
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tambah Info Card baru
            document.querySelectorAll('.add-info-card-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const sectionId = this.dataset.section;
                    const container = document.querySelector(`#section-items-${sectionId}`);
                    const newIndex = container.querySelectorAll('.section-item').length;

                    const item = document.createElement('div');
                    item.classList.add('card', 'mb-3', 'p-3', 'border', 'rounded', 'bg-light',
                        'section-item');
                    item.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Item ${newIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑 Hapus</button>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Ikon</label>
                        <input type="text" name="content[${newIndex}][icon]" class="form-control" placeholder="Contoh: 📚">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Judul</label>
                        <input type="text" name="content[${newIndex}][title]" class="form-control" placeholder="Masukkan judul">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="content[${newIndex}][description]" rows="2" class="form-control" placeholder="Masukkan deskripsi"></textarea>
                    </div>
                </div>
            `;

                    container.appendChild(item);

                    // Event hapus item
                    item.querySelector('.remove-item-btn').addEventListener('click', function() {
                        item.remove();
                    });
                });
            });

            // Hapus item yang sudah ada
            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.section-item').remove();
                });
            });
        });
    </script>
@endpush
