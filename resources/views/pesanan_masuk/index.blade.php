@extends('template.app')
@section('title', 'Pesanan Masuk Buku')

@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pesanan Masuk Buku</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pesanan Masuk Buku</li>
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
                <h5 class="card-title mb-0">Daftar Pesanan Masuk Buku</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="pesanan-table" style="width: 100%">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Nama Penerima</th>
                                <th>Telepon</th>
                                <th>Detail Pengiriman</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Modal Detail Pengiriman -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pengiriman</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th>Nama Penerima</th>
                                <td id="d_nama"></td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td id="d_telepon"></td>
                            </tr>
                            <tr>
                                <th>Alamat Lengkap</th>
                                <td id="d_alamat"></td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td id="d_provinsi"></td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td id="d_kota"></td>
                            </tr>
                            <tr>
                                <th>Kecamatan</th>
                                <td id="d_kecamatan"></td>
                            </tr>
                            <tr>
                                <th>Kurir</th>
                                <td id="d_kurir"></td>
                            </tr>
                            <tr>
                                <th>Ongkir</th>
                                <td id="d_ongkir"></td>
                            </tr>
                            <tr>
                                <th>Total Pembayaran</th>
                                <td id="amount"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            const table = $('#pesanan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pesanan_masuk.load') }}",
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
                        data: 'nama_penerima'
                    },
                    {
                        data: 'telepon_penerima'
                    },
                    {
                        data: 'detail_pengiriman',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status_pengiriman',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // ✅ Klik tombol detail
            $(document).on('click', '.btn-detail', function() {
                const data = $(this).data();
                $('#d_nama').text(data.nama);
                $('#d_telepon').text(data.telepon);
                $('#d_alamat').text(data.alamat);
                $('#d_provinsi').text(data.provinsi);
                $('#d_kota').text(data.kota);
                $('#d_kecamatan').text(data.kecamatan);
                $('#d_kurir').text(data.kurir);
                $('#d_layanan').text(data.layanan);
                $('#d_ongkir').text('Rp ' + parseInt(data.ongkir).toLocaleString());
                $('#amount').text('Rp ' + parseInt(data.amount).toLocaleString());
                $('#detailModal').modal('show');
            });

            // ✅ Konfirmasi kirim
            $(document).on('click', '.kirim-btn', function() {
                const url = $(this).data('url');
                Swal.fire({
                    title: 'Konfirmasi Pengiriman',
                    text: 'Apakah Anda yakin pesanan ini sudah dikirim?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kirim!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(url, {
                            _token: '{{ csrf_token() }}'
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
                    }
                });
            });
        });
    </script>
@endpush
