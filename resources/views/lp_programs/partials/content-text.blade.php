<div class="card p-3 border rounded bg-light">
    <label class="form-label">Heading</label>
    <input type="text" name="sections[{{ $sectionId }}][content][heading]" class="form-control"
        value="{{ $content['heading'] ?? '' }}">

    <label class="form-label mt-2">Isi Teks</label>
    <textarea name="sections[{{ $sectionId }}][content][body]" rows="4" class="form-control">{{ $content['body'] ?? '' }}</textarea>
</div>
