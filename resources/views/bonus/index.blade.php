@extends('template.app')

@section('title', 'Bonus')

@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Bonus</h3>
            </div>
            <div class="col-12 col-md-6">
                <nav class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('owner.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Bonus</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="page-content">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card radius-10">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Bonus</h5>
                <a href="{{ route('bonus.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Bonus
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="bonus-table">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Judul</th>
                                <th>Icon</th>
                                <th>Deskripsi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            }
        });
        $(function() {
            const table = $('#bonus-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('bonus.load') }}",
                    type: "POST"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'icon'
                    },
                    {
                        data: 'desc'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Bonus?',
                    text: 'File PDF juga akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/bonus/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: () => table.ajax.reload()
                        })
                    }
                })
            })
        })
    </script>
@endpush
