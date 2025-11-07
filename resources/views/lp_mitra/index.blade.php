@extends('template.app')
@section('title', 'Kemitraan')
@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kemitraan</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kemitraan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card radius-10">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Daftar Kemitraan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="materi-table" style="width: 100%">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Jenis Produk</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View File -->
    <div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="viewFileLabel">Lihat Materi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="fileContent">
                    <!-- PDF / VIDEO ditampilkan di sini -->
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Upload PDF -->
    <div class="modal fade" id="uploadPdfModal" tabindex="-1" aria-labelledby="uploadPdfLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="uploadPdfLabel">Upload PDF Kemitraan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="uploadPdfForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="produk_id" name="produk_id">
                        <div class="mb-3">
                            <label for="file_pdf" class="form-label">Pilih File PDF</label>
                            <input type="file" class="form-control" id="file_pdf" name="file_pdf"
                                accept="application/pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
        }

        .status-active {
            background-color: #198754;
            color: #fff;
        }

        .status-inactive {
            background-color: #dc3545;
            color: #fff;
        }

        iframe,
        video {
            width: 100%;
            height: 80vh;
            border-radius: 8px;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const table = $('#materi-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('lp_mitra.load') }}",
                    type: "POST"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'gambar',
                        name: 'gambar',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'tipe_produk',
                        name: 'tipe_produk'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Lihat file
            $(document).on('click', '.view-file', function() {
                const path = $(this).data('path');
                const jenis = $(this).data('jenis');
                let content = '';

                if (jenis === 'pdf') {
                    content = `<iframe src="/storage/${path}" frameborder="0"></iframe>`;
                } else if (jenis === 'video') {
                    content = `<video controls>
                                    <source src="/storage/${path}" type="video/mp4">
                                    Browser Anda tidak mendukung video.
                               </video>`;
                }

                $('#fileContent').html(content);
                $('#viewFileModal').modal('show');
            });


            $(document).on('click', '.upload-btn', function() {
                const produkId = $(this).data('id');
                $('#produk_id').val(produkId);
                $('#file_pdf').val('');
                $('#uploadPdfModal').modal('show');
            });

            // Submit form upload PDF
            $('#uploadPdfForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: "{{ route('lp_mitra.upload_pdf') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#uploadPdfModal').modal('hide');
                            $('#materi-table').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengupload file PDF.'
                        });
                    }
                });
            });

        });
    </script>
@endpush
