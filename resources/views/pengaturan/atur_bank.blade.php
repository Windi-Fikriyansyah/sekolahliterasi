@extends('layouts.app')

@section('title', 'Atur Bank')

@section('content')
    <div class="min-h-screen bg-gray-50 py-4 sm:py-8">
        <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8">

            <!-- Header Section with Back Button -->
            <div class="mb-6 sm:mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('account.index') }}"
                        class="flex items-center text-gray-600 hover:text-gray-900 transition-colors mr-4">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        <span class="text-sm">Kembali</span>
                    </a>
                </div>
                <h1 class="text-2xl sm:text-3xl font-light text-gray-900 mb-2">Atur Bank</h1>
                <p class="text-sm sm:text-base text-gray-600">Kelola informasi rekening bank Anda</p>
            </div>



            <!-- Bank Accounts List -->
            <div class="space-y-4">
                @forelse ($banks as $bank)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <div class="flex-1 mb-4 sm:mb-0">
                                <div class="flex items-center mb-3">
                                    <div
                                        class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $bank->nama_bank }}</h3>
                                        @if (isset($bank->is_primary) && $bank->is_primary)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Utama
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div class="flex flex-col sm:flex-row sm:items-center">
                                        <span class="font-medium text-gray-700 w-24 sm:w-32">Nama:</span>
                                        <span>{{ $bank->nama_pemilik }}</span>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:items-center">
                                        <span class="font-medium text-gray-700 w-24 sm:w-32">No. Rekening:</span>
                                        <span class="font-mono">{{ $bank->no_rekening }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="showEditBankModal({{ $bank->id }})"
                                    class="flex-1 sm:flex-none px-3 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors text-sm">
                                    Edit
                                </button>
                                <button onclick="deleteBankAccount({{ $bank->id }})"
                                    class="flex-1 sm:flex-none px-3 py-2 text-red-600 border border-red-600 rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors text-sm">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada rekening bank</h3>
                        <p class="text-gray-600 mb-4">Tambahkan rekening bank untuk memudahkan penarikan saldo</p>
                        <button onclick="showAddBankModal()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                            Tambah Rekening
                        </button>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Add/Edit Bank Modal -->
    <div id="bankModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="modalTitle" class="text-xl font-semibold text-gray-900">Tambah Rekening Bank</h2>
                        <button onclick="closeBankModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="bankForm" onsubmit="submitBankForm(event)">
                        <input type="hidden" name="bank_id" id="bank_id"> <!-- untuk edit -->
                        <div class="space-y-4">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Bank</label>
                                <input type="text" id="bank_name" name="nama_bank" required
                                    placeholder="Masukkan nama bank"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>

                            <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    Rekening</label>
                                <input type="text" id="account_number" name="no_rekening" required
                                    placeholder="Masukkan nomor rekening"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>

                            <div>
                                <label for="account_holder" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Pemilik Rekening</label>
                                <input type="text" id="account_holder" name="nama_pemilik" required
                                    placeholder="Masukkan nama sesuai rekening"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 mt-6">
                            <button type="button" onclick="closeBankModal()"
                                class="flex-1 px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">Batal</button>
                            <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <span id="submitText">Simpan</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        /* Modal animations */
        #bankModal {
            transition: opacity 0.3s ease;
        }

        #bankModal.hidden {
            opacity: 0;
            pointer-events: none;
        }

        #bankModal:not(.hidden) {
            opacity: 1;
        }

        /* Better mobile spacing */
        @media (max-width: 640px) {
            .space-x-2>*+* {
                margin-left: 0.25rem;
            }

            .flex.space-x-2 {
                gap: 0.5rem;
            }
        }

        /* Improve button layouts on mobile */
        @media (max-width: 480px) {
            .flex.space-x-2 {
                flex-direction: column;
                space-x: 0;
                gap: 0.75rem;
            }

            .flex.space-x-2>button {
                width: 100%;
            }
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentEditId = null;

        function showAddBankModal() {
            currentEditId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Rekening Bank';
            document.getElementById('submitText').textContent = 'Simpan';
            document.getElementById('bankForm').reset();
            document.getElementById('bank_id').value = '';
            document.getElementById('bankModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function showEditBankModal(id) {
            currentEditId = id;
            document.getElementById('modalTitle').textContent = 'Edit Rekening Bank';
            document.getElementById('submitText').textContent = 'Update';

            fetch('{{ route('account.bank.json') }}')
                .then(res => res.json())
                .then(data => {
                    const bank = data.find(b => b.id === id);
                    if (bank) {
                        document.getElementById('bank_name').value = bank.nama_bank;
                        document.getElementById('account_number').value = bank.no_rekening;
                        document.getElementById('account_holder').value = bank.nama_pemilik;
                        document.getElementById('bank_id').value = bank.id;
                        document.getElementById('bankModal').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                });
        }


        function submitBankForm(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch("{{ route('account.bank.save') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(async res => {
                    const data = await res.json();
                    if (res.ok && data.success) {
                        closeBankModal();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        let msg = data.message || 'Terjadi kesalahan!';
                        if (data.errors) {
                            msg = Object.values(data.errors).flat().join('<br>');
                        }
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: msg,
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            html: msg
                        });
                    }
                })
                .catch(err => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Terjadi kesalahan server!',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true
                    });
                    console.error(err);
                });
        }



        function deleteBankAccount(id) {
            Swal.fire({
                title: 'Hapus rekening bank?',
                text: 'Data rekening bank akan dihapus permanen dan tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('account.bank.delete') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: id
                            })
                        })
                        .then(res => res.json())
                        .then(res => {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                            setTimeout(() => location.reload(), 1000); // reload untuk update UI
                        });
                }
            });
        }

        function closeBankModal() {
            document.getElementById('bankModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentEditId = null;
        }


        // Close modal when clicking outside
        document.getElementById('bankModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBankModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('bankModal').classList.contains('hidden')) {
                closeBankModal();
            }
        });

        // Format account number input
        document.getElementById('account_number').addEventListener('input', function(e) {
            // Remove any non-digit characters
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
@endpush
