@extends('template.app')
@section('title', 'Pembayaran Program')

@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pembayaran Program</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pembayaran Program</li>
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
                <h5 class="card-title mb-0">Daftar Pembayaran Program</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="pesanan-table" style="width: 100%">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Nama User</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Bukti Transfer</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    </div>


    <!-- Modal Bukti Transfer -->
    <div class="modal fade" id="modalBuktiTransfer" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="gambarBukti" src="" class="img-fluid rounded" alt="Bukti Transfer">
                    <iframe id="pdfBukti" src="" width="100%" height="500" style="display:none;"></iframe>
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
        $(document).ready(function() {

            $(document).on('click', '.lihat-bukti-btn', function() {
                let url = $(this).data('url');

                // Reset modal
                $('#gambarBukti').hide();
                $('#pdfBukti').hide();

                // Cek apakah PDF?
                if (url.endsWith('.pdf')) {
                    $('#pdfBukti').attr('src', url).show();
                } else {
                    $('#gambarBukti').attr('src', url).show();
                }

                // Tampilkan modal
                $('#modalBuktiTransfer').modal('show');
            });



            const table = $('#pesanan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pesanan_program.load') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'invoice_id'
                    },
                    {
                        data: 'user_name'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'bukti',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });



            $(document).on('click', '.konfirmasi-btn', function() {
                const url = $(this).data('url');

                Swal.fire({
                    title: 'Konfirmasi Pembayaran',
                    text: 'Pilih apakah pembayaran diterima atau ditolak.',
                    icon: 'question',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Terima',
                    denyButtonText: 'Tolak',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    let action = null;

                    if (result.isConfirmed) {
                        action = 'approve';
                    } else if (result.isDenied) {
                        action = 'reject';
                    } else {
                        return;
                    }

                    $.post(url, {
                        _token: '{{ csrf_token() }}',
                        action: action
                    }, function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    }).fail(() => {
                        Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                    });

                });

            });

        });
    </script>
@endpush
