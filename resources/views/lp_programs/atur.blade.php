@extends('template.app')
@section('title', isset($materi) ? 'Edit Materi' : 'Tambah Materi')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div class="mb-2">
                <h4 class="fw-bold text-dark mb-1">Page Builder - Drag & Drop</h4>
                <p class="text-muted mb-0">Simplify Website Creation — Drag, Drop, Done!</p>
            </div>
            @if ($pages->isEmpty())
                <a href="{{ route('lp_programs.create', ['id_product' => $id_product ?? null]) }}" class="btn btn-success">
                    <i class="bx bx-plus"></i> Add
                </a>
            @endif
        </div>

        <div class="row g-4">
            @forelse ($pages as $item)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">{{ $item->title }}</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-secondary mb-2">{{ $item->short_description }}</p>
                            <small class="text-muted d-block">Last Updated: {{ $item->updated_at }}</small>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between">
                            <a href="{{ route('lp_programs.show', $item->id) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-show"></i> Preview
                            </a>
                            <a href="{{ route('lp_programs.edit', $item->id) }}" class="btn btn-sm btn-warning text-white">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <form action="{{ route('lp_programs.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this page?')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No pages found. Click <b>Add</b> to create a new one.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
