{{-- === FORM UNTUK SECTION TYPE GALLERY === --}}
<div class="card mb-3 p-3 border rounded bg-light">

    {{-- Judul Galeri --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">🏷️ Judul Galeri</label>
        <input type="text" name="sections[{{ $sectionId }}][content][title]" class="form-control"
            value="{{ $content['title'] ?? '' }}" placeholder="Masukkan judul galeri">
    </div>

    {{-- Deskripsi Galeri --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">📝 Deskripsi Galeri</label>
        <textarea name="sections[{{ $sectionId }}][content][description]" class="form-control" rows="3"
            placeholder="Tuliskan deskripsi galeri">{{ $content['description'] ?? '' }}</textarea>
    </div>

    {{-- Gambar Galeri --}}
    <div class="border rounded p-3 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">📸 Gambar Galeri</h6>
            <button type="button" class="btn btn-sm btn-success add-gallery-btn" data-section="{{ $sectionId }}">
                <i class="bx bx-plus"></i> Tambah Gambar
            </button>
        </div>

        <div id="gallery-items-{{ $sectionId }}">
            @if (!empty($content['images']))
                @foreach ($content['images'] as $index => $img)
                    <div class="card mb-3 p-3 border rounded bg-light section-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Gambar {{ $loop->iteration }}</h6>
                            <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑 Hapus</button>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Upload Gambar</label>
                            <input type="file"
                                name="sections[{{ $sectionId }}][content][images][{{ $index }}][image]"
                                class="form-control image-input" accept="image/*">

                            {{-- Preview --}}
                            @if (!empty($img['image']))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $img['image']) }}" class="img-thumbnail"
                                        style="max-width:200px;" loading="lazy">
                                    <input type="hidden"
                                        name="sections[{{ $sectionId }}][content][images_existing][]"
                                        value="{{ $img['image'] }}">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Belum ada gambar di galeri.</p>
            @endif
        </div>
    </div>
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
                    const container = document.querySelector(`#gallery-items-${sectionId}`);
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
                    <input type="file" name="sections[${sectionId}][content][images][${newIndex}][image]" class="form-control image-input" accept="image/*">
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

            // Preview gambar otomatis
            document.addEventListener('change', function(e) {
                const input = e.target.closest('.image-input');
                if (!input) return;

                const file = input.files[0];
                if (!file) return;

                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Valid!',
                        text: 'Hanya boleh JPG, JPEG, PNG, atau WEBP.',
                        confirmButtonText: 'OK'
                    });
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(ev) {
                    let previewContainer = input.closest('.mb-2').querySelector('.preview-wrapper');
                    if (!previewContainer) {
                        previewContainer = document.createElement('div');
                        previewContainer.classList.add('mt-2', 'preview-wrapper');
                        input.closest('.mb-2').appendChild(previewContainer);
                    }
                    previewContainer.innerHTML =
                        `<img src="${ev.target.result}" class="img-thumbnail" style="max-width:200px;">`;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
