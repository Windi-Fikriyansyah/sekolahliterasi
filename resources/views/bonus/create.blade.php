@extends('template.app')

@section('title', isset($bonus) ? 'Edit Bonus' : 'Tambah Bonus')

@section('content')
    <div class="container-xxl container-p-y">

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between">
                        <h5 class="mb-0">{{ isset($bonus) ? 'Edit' : 'Tambah' }} Bonus</h5>
                        <small class="text-muted">Form Bonus</small>
                    </div>

                    <div class="card-body">
                        <form action="{{ isset($bonus) ? route('bonus.update', $bonus->id) : route('bonus.store') }}"
                            method="POST" enctype="multipart/form-data">

                            @csrf
                            @if (isset($bonus))
                                @method('PUT')
                            @endif

                            {{-- Judul --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $bonus->title ?? '') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Icon --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Icon</label>
                                <div class="col-sm-10">
                                    <input type="text" name="icon" class="form-control"
                                        placeholder="contoh: ti ti-file-text" value="{{ old('icon', $bonus->icon ?? '') }}">
                                    <small class="text-muted">
                                        Gunakan icon Tabler / Bootstrap (opsional)
                                    </small>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea name="desc" class="form-control" rows="3">{{ old('desc', $bonus->desc ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- File PDF --}}
                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label">File PDF</label>
                                <div class="col-sm-10">
                                    <input type="file" name="file"
                                        class="form-control @error('file') is-invalid @enderror" accept="application/pdf"
                                        {{ isset($bonus) ? '' : 'required' }}>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if (isset($bonus))
                                        <small class="text-muted">
                                            Kosongkan jika tidak ingin mengganti file
                                        </small>
                                    @endif
                                </div>
                            </div>

                            {{-- Action --}}
                            <div class="row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($bonus) ? 'Update' : 'Simpan' }}
                                    </button>
                                    <a href="{{ route('bonus.index') }}" class="btn btn-secondary">
                                        Kembali
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
