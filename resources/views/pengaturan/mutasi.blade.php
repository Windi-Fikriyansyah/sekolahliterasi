@extends('layouts.app')

@section('title', 'Mutasi Saldo')

@section('content')
    <div class="min-h-screen bg-gray-50 py-4 sm:py-8">
        <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8">

            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-light text-gray-900 mb-2">Mutasi Saldo</h1>
                        <p class="text-sm sm:text-base text-gray-600">Riwayat Penarikan saldo Referral</p>
                    </div>
                    <a href="{{ route('account.index') }}"
                        class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>


            <!-- Filter Section -->
            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 mb-6">
                <h3 class="text-sm sm:text-base font-medium text-gray-900 mb-4">Filter Transaksi</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="statusFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="">Semua Status</option>
                            <option value="completed">Selesai</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Gagal</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" id="startDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" id="endDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>
                </div>
            </div>




            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900">Riwayat Transaksi</h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table id="mutasiTable" class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-medium text-gray-700 text-sm">Tanggal & Waktu</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-700 text-sm">Keterangan</th>
                                    <th class="text-right py-3 px-4 font-medium text-gray-700 text-sm">Jumlah</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-700 text-sm">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('style')
    <!-- Hapus CSS Bootstrap DataTables, cukup pakai default -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <style>
        table.dataTable thead th {
            @apply bg-gray-100 text-gray-700 font-semibold text-xs sm:text-sm px-4 py-3 uppercase tracking-wider;
        }

        /* Isi tabel */
        table.dataTable tbody td {
            @apply text-gray-600 text-sm px-4 py-3;
        }

        /* Hover row */
        table.dataTable tbody tr:hover {
            @apply bg-gray-50;
        }

        /* Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3 py-1 mx-1 rounded-lg border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600;
        }

        /* Search box */
        .dataTables_wrapper .dataTables_filter input {
            @apply border border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none ml-2;
        }

        /* Length dropdown */
        .dataTables_wrapper .dataTables_length select {
            @apply border border-gray-300 rounded-lg px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none;
        }

        /* Info text */
        .dataTables_wrapper .dataTables_info {
            @apply text-sm text-gray-500 mt-2;
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const mutasiTable = $('#mutasiTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('account.load') }}",
                    type: "POST",
                    data: function(d) {
                        d.status = $('#statusFilter').val();
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                    }
                },
                columns: [{
                        data: 'date_formatted',
                        name: 'created_at'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'amount_formatted',
                        name: 'amount',
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                language: {
                    processing: "Memuat...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "›",
                        previous: "‹"
                    }
                }
            });

            // Filter otomatis reload
            $('#statusFilter, #startDate, #endDate').on('change', function() {
                mutasiTable.ajax.reload();
            });

            // Tombol "Terapkan Filter"
            window.applyFilter = function() {
                mutasiTable.ajax.reload();
            }
        });
    </script>
@endpush
