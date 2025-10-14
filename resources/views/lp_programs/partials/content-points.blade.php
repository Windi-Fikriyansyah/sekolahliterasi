<div class="points-section" data-section="{{ $sectionId }}">
    @forelse ($content as $index => $point)
        <div class="card mb-2 p-2 border rounded bg-light section-item">
            <div class="d-flex justify-content-between align-items-center">
                <input type="text" name="sections[{{ $sectionId }}][content][{{ $index }}][text]"
                    class="form-control me-2" value="{{ $point['text'] ?? '' }}" placeholder="Masukkan poin...">
                <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑</button>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada poin.</p>
    @endforelse

    {{-- Tombol Tambah Poin --}}
    <div class="mt-2 text-end">
        <button type="button" class="btn btn-sm btn-success add-point-btn" data-section="{{ $sectionId }}">
            <i class="bx bx-plus"></i> Tambah Poin
        </button>
    </div>
</div>

{{-- Script untuk tambah/hapus poin --}}
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tambah poin baru
            document.querySelectorAll('.add-point-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const sectionId = this.dataset.section;
                    const section = this.closest('.points-section');
                    const newIndex = section.querySelectorAll('.section-item').length;

                    const item = document.createElement('div');
                    item.classList.add('card', 'mb-2', 'p-2', 'border', 'rounded', 'bg-light',
                        'section-item');
                    item.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <input type="text"
                           name="sections[${sectionId}][content][${newIndex}][text]"
                           class="form-control me-2"
                           placeholder="Masukkan poin...">
                    <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑</button>
                </div>
            `;

                    // Sisipkan elemen baru sebelum tombol tambah
                    section.querySelector('.mt-2').before(item);

                    // Tambahkan event hapus
                    item.querySelector('.remove-item-btn').addEventListener('click', function() {
                        item.remove();
                    });
                });
            });

            // Hapus poin yang sudah ada
            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.section-item').remove();
                });
            });
        });
    </script>
@endpush
