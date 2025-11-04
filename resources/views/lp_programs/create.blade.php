@extends('template.app')
@section('title', isset($page) ? 'Edit Page' : 'Tambah Page')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($page) ? 'Edit' : 'Tambah' }} Page</h5>
                        <small class="text-muted float-end">Form Page Builder</small>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ isset($page) ? route('lp_programs.update', $page->id) : route('lp_programs.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($page))
                                @method('PUT')
                            @endif

                            {{-- Input: Title --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="title">Judul Halaman</label>
                                <div class="col-sm-10">
                                    <input type="text" id="title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $page->title ?? '') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Input: Short Description --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="short_description">Deskripsi Singkat</label>
                                <div class="col-sm-10">
                                    <textarea id="short_description" name="short_description" rows="3"
                                        class="form-control @error('short_description') is-invalid @enderror" required>{{ old('short_description', $page->short_description ?? '') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Input: id_product (hidden) --}}
                            @if (isset($id_product))
                                <input type="hidden" name="id_product" value="{{ $id_product }}">
                            @elseif(isset($page->id_product))
                                <input type="hidden" name="id_product" value="{{ $page->id_product }}">
                            @endif

                            {{-- Tombol Aksi --}}
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit"
                                        class="btn btn-primary">{{ isset($page) ? 'Update' : 'Simpan' }}</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>

                                </div>
                            </div>
                        </form>
                    </div> {{-- card-body --}}
                </div> {{-- card --}}
            </div> {{-- col --}}
        </div> {{-- row --}}
    </div>
@endsection
