<div class="card p-3 border rounded bg-light">
    <label class="form-label">Heading</label>
    <input type="text" name="sections[{{ $sectionId }}][content][heading]" class="form-control"
        value="{{ $content['heading'] ?? '' }}">

    <label class="form-label mt-2">Isi Teks</label>
    <textarea name="sections[{{ $sectionId }}][content][body]" rows="4" class="form-control">{{ $content['body'] ?? '' }}</textarea>

    <div class="mt-3">
        <label class="form-label fw-semibold">📸 Gambar (Bisa Lebih dari 1)</label>

        {{-- Tampilkan gambar lama --}}
        <div class="row mb-3" id="existing-images-{{ $sectionId }}">
            @if (!empty($content['images']))
                @foreach ($content['images'] as $index => $img)
                    <div class="col-md-3 mb-2 position-relative">
                        <img src="{{ asset('storage/' . $img) }}" alt="Gambar {{ $index }}"
                            class="img-fluid rounded shadow-sm">
                        <input type="hidden" name="sections[{{ $sectionId }}][content][images_existing][]"
                            value="{{ $img }}">
                        <button type="button"
                            class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-existing-image"
                            data-image="{{ $img }}" style="border-radius: 50%;"><i
                                class="bx bx-x"></i></button>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Upload gambar baru --}}
        <div id="image-container-{{ $sectionId }}">
            <input type="file" name="sections[{{ $sectionId }}][content][images][]" class="form-control mb-2"
                accept="image/*">
        </div>

        <button type="button" class="btn btn-outline-primary btn-sm add-image-btn" data-section="{{ $sectionId }}">
            <i class="bx bx-plus"></i> Tambah Gambar
        </button>
        <small class="d-block mt-1 text-muted">Format: JPG, PNG, WEBP | Maks 2MB per gambar</small>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // tombol tambah input gambar baru
            document.querySelectorAll('.add-image-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const sectionId = this.dataset.section;
                    const container = document.getElementById(`image-container-${sectionId}`);
                    const newInput = document.createElement('input');
                    newInput.type = 'file';
                    newInput.name = `sections[${sectionId}][content][images][]`;
                    newInput.classList.add('form-control', 'mb-2');
                    newInput.accept = 'image/*';
                    container.appendChild(newInput);
                });
            });

            // tombol hapus gambar lama (hanya di UI, data tetap dikirim kalau user tidak hapus manual)
            document.querySelectorAll('.remove-existing-image').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.col-md-3').remove();
                });
            });
        });
    </script>
@endpush
