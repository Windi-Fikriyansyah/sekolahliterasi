@forelse ($content as $index => $field)
    <div class="card mb-3 p-3 border rounded bg-light section-item">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Field {{ $loop->iteration }}</h6>
            <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑 Hapus</button>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Nama Field</label>
                <input type="text" name="sections[{{ $sectionId }}][content][{{ $index }}][name]"
                    class="form-control" value="{{ $field['name'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Placeholder</label>
                <input type="text" name="sections[{{ $sectionId }}][content][{{ $index }}][placeholder]"
                    class="form-control" value="{{ $field['placeholder'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipe</label>
                <select name="sections[{{ $sectionId }}][content][{{ $index }}][type]" class="form-select">
                    @foreach (['text', 'email', 'number', 'textarea'] as $type)
                        <option value="{{ $type }}" {{ ($field['type'] ?? '') === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">Belum ada field form.</p>
@endforelse

<div class="mt-3 text-end">
    <button type="button" class="btn btn-sm btn-success add-form-btn" data-section="{{ $sectionId }}">
        <i class="bx bx-plus"></i> Tambah Form
    </button>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener tombol tambah form field
            document.querySelectorAll('.add-form-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const sectionId = this.dataset.section;
                    const container = document.querySelector(`#section-items-${sectionId}`);
                    const index = container.querySelectorAll('.section-item')
                        .length; // hitung jumlah form yg sudah ada

                    // buat elemen baru
                    const newField = document.createElement('div');
                    newField.classList.add('card', 'mb-3', 'p-3', 'border', 'rounded', 'bg-light',
                        'section-item');

                    newField.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Field ${index + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-item-btn">🗑 Hapus</button>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Nama Field</label>
                        <input type="text" name="content[${index}][name]" class="form-control" placeholder="Contoh: nama">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Placeholder</label>
                        <input type="text" name="content[${index}][placeholder]" class="form-control" placeholder="Contoh: Masukkan nama Anda">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipe</label>
                        <select name="content[${index}][type]" class="form-select">
                            <option value="text">Text</option>
                            <option value="email">Email</option>
                            <option value="number">Number</option>
                            <option value="textarea">Textarea</option>
                        </select>
                    </div>
                </div>
            `;

                    container.appendChild(newField);

                    // event hapus
                    newField.querySelector('.remove-item-btn').addEventListener('click',
                        function() {
                            newField.remove();
                        });
                });
            });

            // aktifkan hapus pada item lama
            document.querySelectorAll('.remove-item-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.section-item').remove();
                });
            });
        });
    </script>
@endpush
