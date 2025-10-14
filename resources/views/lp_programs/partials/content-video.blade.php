<div class="card p-3 border rounded bg-light">
    <label class="form-label">URL Video</label>
    <input type="text" name="sections[{{ $sectionId }}][content][video_url]" class="form-control"
        value="{{ $content['video_url'] ?? '' }}" placeholder="https://youtube.com/embed/...">
</div>
