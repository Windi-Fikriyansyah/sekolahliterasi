@forelse ($content as $index => $item)
    <div class="card mb-3 p-3 border rounded bg-light section-item">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Gambar {{ $loop->iteration }}</h6>
            <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑 Hapus</button>
        </div>

        {{-- Upload File Gambar --}}
        <div class="mb-2">
            <label class="form-label">Upload Gambar</label>
            <input type="file" name="sections[{{ $sectionId }}][content][{{ $index }}][image]"
                class="form-control image-input" accept="image/*">

            {{-- Preview --}}
            @if (!empty($item['image']))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $item['image']) }}" class="img-thumbnail" style="max-width:200px;"
                        loading="lazy" alt="Preview Gambar">
                    <input type="hidden" name="sections[{{ $sectionId }}][content][{{ $index }}][image]"
                        value="{{ $item['image'] }}">
                </div>
            @endif


        </div>
    </div>
@empty
    <p class="text-muted">Belum ada gambar di galeri.</p>
@endforelse

<div class="mt-3 text-end">
    <button type="button" class="btn btn-sm btn-success add-gallery-btn" data-section="{{ $sectionId }}">
        <i class="bx bx-plus"></i> Tambah Gambar
    </button>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                // Tambah item baru
                if (e.target.closest('.add-gallery-btn')) {
                    e.preventDefault();

                    const button = e.target.closest('.add-gallery-btn');
                    const sectionId = button.dataset.section;
                    const container = document.querySelector(`#section-items-${sectionId}`);
                    const newIndex = container.querySelectorAll('.section-item').length;

                    const newItem = document.createElement('div');
                    newItem.classList.add('card', 'mb-3', 'p-3', 'border', 'rounded', 'bg-light',
                        'section-item');
                    newItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Gambar ${newIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑 Hapus</button>
                </div>
                <div class="mb-2">
                    <label class="form-label">Upload Gambar</label>
                    <input type="file" name="sections[${sectionId}][content][${newIndex}][image]"
                           class="form-control image-input" accept="image/*">
                    <div class="mt-2 preview-wrapper"></div>
                </div>
            `;
                    container.appendChild(newItem);
                }

                // Hapus item
                if (e.target.closest('.remove-item-btn')) {
                    e.preventDefault();
                    e.target.closest('.section-item').remove();
                }
            });

            // 🔍 Validasi format file + preview otomatis
            document.addEventListener('change', function(e) {
                const input = e.target.closest('.image-input');
                if (!input) return;

                const file = input.files[0];
                if (!file) return;

                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                // Jika format tidak valid
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Valid!',
                        text: 'Format gambar harus JPG, JPEG, atau PNG.',
                        confirmButtonText: 'OK'
                    });
                    input.value = ''; // reset input
                    return;
                }

                // ✅ Preview otomatis
                const reader = new FileReader();
                reader.onload = function(e) {
                    let previewContainer = input.closest('.mb-2').querySelector('.preview-wrapper');
                    if (!previewContainer) {
                        previewContainer = document.createElement('div');
                        previewContainer.classList.add('mt-2', 'preview-wrapper');
                        input.closest('.mb-2').appendChild(previewContainer);
                    }
                    previewContainer.innerHTML =
                        `<img src="${e.target.result}" class="img-thumbnail" style="max-width:200px;">`;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
