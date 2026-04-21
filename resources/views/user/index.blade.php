@extends('template.app')
@section('title', 'Pengguna')
@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengguna</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
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
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Daftar Pengguna</h5>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="users-table" style="width: 100%">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Email</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                                <th>Instansi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Subscription -->
        <div class="modal fade" id="subscriptionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Langganan User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="location.reload()"></button>
                    </div>
                    <form id="subscriptionForm">
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="subs_user_id">
                            <input type="hidden" name="is_active" id="subs_is_active">

                            <div class="mb-3">
                                <input type="hidden" name="package_id" id="subs_package_id" value="8" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Started At</label>
                                <input type="date" name="started_at" id="subs_started_at" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Expired At</label>
                                <input type="date" name="expired_at" id="subs_expired_at" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" id="subs_status" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="expired">Expired</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                onclick="location.reload()">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Change Password -->
        <div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Password User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="passwordForm">
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="pass_user_id">
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control" required minlength="8">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="8">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pengguna.load') }}",
                    type: "POST"
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'kabupaten',
                    name: 'kabupaten'
                },
                {
                    data: 'provinsi',
                    name: 'provinsi'
                },
                {
                    data: 'instansi',
                    name: 'instansi'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
                ]
            });

            // Hapus pengguna
            $(document).on('click', '.delete-btn', function () {
                const id = $(this).data('id');
                // Membuat URL dengan format yang benar
                const url = "{{ route('pengguna.destroy', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data pengguna akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: response.message
                                    });
                                    table.ajax.reload();
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan'
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('change', '.toggle-status', function () {
                const checkbox = $(this);
                const userId = checkbox.data('id');
                const isActive = checkbox.is(':checked') ? 1 : 0;

                // Reset form
                $('#subscriptionForm')[0].reset();
                $('#subs_user_id').val(userId);
                $('#subs_is_active').val(isActive);

                // Fetch subscription data
                const url = "{{ route('pengguna.get_subscription', ':id') }}".replace(':id', userId);
                $.get(url, function (res) {
                    if (res.success) {
                        // Fill packages
                        let packageOptions = '<option value="">Pilih Paket</option>';
                        res.packages.forEach(pkg => {
                            packageOptions += `<option value="${pkg.id}">${pkg.judul}</option>`;
                        });
                        $('#subs_package_id').html(packageOptions);

                        // Fill data if exists
                        if (res.data) {
                            $('#subs_package_id').val(res.data.package_id);
                            $('#subs_started_at').val(res.data.started_at ? res.data.started_at.split(' ')[0] : '');
                            $('#subs_expired_at').val(res.data.expired_at ? res.data.expired_at.split(' ')[0] : '');
                            $('#subs_status').val(res.data.status);
                        }

                        $('#subscriptionModal').modal('show');
                    } else {
                        Swal.fire('Error', 'Gagal mengambil data langganan', 'error');
                        checkbox.prop('checked', !isActive);
                    }
                }).fail(function () {
                    Swal.fire('Error', 'Gagal mengambil data langganan', 'error');
                    checkbox.prop('checked', !isActive);
                });
            });

            $('#subscriptionForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('pengguna.toggle') }}",
                    type: "POST",
                    data: formData,
                    success: function (res) {
                        if (res.success) {
                            $('#subscriptionModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil diperbarui',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            table.ajax.reload();
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menyimpan data', 'error');
                    }
                });
            });


            // Ubah Password
            $(document).on('click', '.password-btn', function () {
                const id = $(this).data('id');
                $('#passwordForm')[0].reset();
                $('#pass_user_id').val(id);
                $('#passwordModal').modal('show');
            });

            $('#passwordForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('pengguna.update_password') }}",
                    type: "POST",
                    data: formData,
                    success: function (res) {
                        if (res.success) {
                            $('#passwordModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        const message = xhr.responseJSON?.message || 'Gagal mengubah password';
                        Swal.fire('Error', message, 'error');
                    }
                });
            });

        });
    </script>
@endpush