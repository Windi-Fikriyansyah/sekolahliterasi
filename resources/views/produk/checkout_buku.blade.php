@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-secondary mb-2">Checkout</h1>
                <p class="text-gray-600">Lengkapi data pembelian Anda</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Checkout -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user-circle text-primary mr-2"></i>
                            Informasi Pembeli
                        </h2>

                        <form id="checkoutForm" class="space-y-4" method="POST" action="{{ route('buku.process') }}">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_lengkap" required value="{{ Auth::user()->name }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" required value="{{ Auth::user()->email }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="email@example.com">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        No. WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="no_hp" value="{{ Auth::user()->no_hp }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat" required rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                    placeholder="Jl. Contoh No. 123, Kota, Provinsi"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <!-- Provinsi -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Provinsi <span class="text-red-500">*</span>
                                    </label>
                                    <!-- Provinsi -->
                                    <select id="provinsi" name="provinsi" class="w-full ...">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinsi as $p)
                                            <option value="{{ $p['id'] }}" data-name="{{ $p['name'] }}">
                                                {{ $p['name'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                                <!-- Kota -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kota/Kabupaten <span class="text-red-500">*</span>
                                    </label>
                                    <select id="kota" name="kota"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                        <option value="">Pilih Kota</option>
                                    </select>
                                </div>

                                <!-- Kecamatan -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan <span
                                            class="text-red-500">*</span></label>
                                    <select id="kecamatan" name="kecamatan"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Kurir -->
                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kurir Pengiriman <span
                                        class="text-red-500">*</span></label>
                                <select id="kurir" name="kurir"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS Indonesia</option>
                                </select>
                            </div>

                            <!-- Layanan & Ongkir -->
                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Layanan & Ongkir <span
                                        class="text-red-500">*</span></label>
                                <select id="layanan_ongkir" name="layanan_ongkir"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    <option value="">Pilih Layanan</option>
                                </select>
                            </div>


                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Catatan (Opsional)
                                </label>
                                <textarea name="catatan" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                    placeholder="Catatan untuk penjual"></textarea>
                            </div>
                        </form>
                    </div>


                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-shopping-bag text-primary mr-2"></i>
                            Ringkasan Pesanan
                        </h2>

                        <div id="checkout-items" class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                            @php $subtotal = 0; @endphp
                            @foreach ($checkoutItems as $item)
                                @php $subtotal += $item->harga * $item->qty; @endphp
                                <div class="flex items-start space-x-3 pb-3 border-b border-gray-100">
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                        class="w-16 h-16 object-cover rounded-lg shadow-sm" alt="{{ $item->judul }}">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-sm text-gray-800 line-clamp-2 mb-1">
                                            {{ $item->judul }}
                                        </h4>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->qty }}</p>
                                        <p class="text-sm font-bold text-primary mt-1">
                                            Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Admin</span>
                                <span class="text-green-600 font-semibold">GRATIS</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkir</span>
                                <span id="ongkir">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold text-gray-800 pt-2 border-t">
                                <span>Total</span>
                                <span id="total" class="text-primary">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>



                        <button type="button" id="btnPesanSekarang"
                            class="w-full mt-6 bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-lg font-bold text-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-lock mr-2"></i>
                            Pesan Sekarang
                        </button>

                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-xs text-gray-600 text-center">
                                <i class="fas fa-shield-alt text-primary mr-1"></i>
                                Transaksi Anda aman dan terlindungi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loading Modal -->
    <div id="loadingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-8 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-primary mx-auto mb-4"></div>
            <p class="text-gray-700 font-semibold">Memproses pesanan Anda...</p>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast"
        class="hidden fixed top-6 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg text-sm font-medium z-50 transition-all duration-500">
    </div>


@endsection
@push('style')
    {{-- ✅ Tambahkan CSS Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Styling agar Select2 serasi dengan Tailwind */
        .select2-container--default .select2-selection--single {
            height: 48px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 8px 12px !important;
        }

        .select2-container--default .select2-selection__rendered {
            line-height: 28px !important;
            color: #374151 !important;
        }

        .select2-container--default .select2-selection__arrow {
            height: 46px !important;
            right: 10px !important;
        }

        .select2-dropdown {
            border-radius: 0.5rem !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('#provinsi, #kota, #kecamatan, #kurir, #layanan_ongkir').select2({
                width: '100%',
                placeholder: "Pilih Opsi",
                allowClear: true,
                theme: 'default'
            });

            $('#provinsi').on('change', function() {
                const provinsi_id = $(this).val();

                // 🧹 Jika provinsi dikosongkan, reset kota & kecamatan tanpa alert
                if (!provinsi_id) {
                    $('#kota').html('<option value="">Pilih Kota</option>').trigger('change');
                    $('#kecamatan').html('<option value="">Pilih Kecamatan</option>').trigger('change');
                    return;
                }

                // Jika ada provinsi terpilih, baru ambil data kota
                $('#kota').html('<option value="">Memuat...</option>').trigger('change');
                $('#kecamatan').html('<option value="">Pilih Kecamatan</option>').trigger('change');

                fetch(`/buku/checkout-buku/kota/${provinsi_id}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);

                        let html = '<option value="">Pilih Kota</option>';
                        data.forEach(k => {
                            html +=
                                `<option value="${k.id}" data-name="${k.name}">${k.name}</option>`;
                        });
                        $('#kota').html(html).trigger('change');
                    })
                    .catch(err => {
                        console.error(err);
                        // ❌ Jangan tampilkan alert supaya user tidak terganggu
                        $('#kota').html('<option value="">Gagal memuat data</option>').trigger(
                            'change');
                    });
            });


            $('#kota').on('change', function() {
                const city_id = $(this).val();

                // 🧹 Jika kota dikosongkan, reset kecamatan tanpa alert
                if (!city_id) {
                    $('#kecamatan').html('<option value="">Pilih Kecamatan</option>').trigger('change');
                    return;
                }

                $('#kecamatan').html('<option value="">Memuat...</option>').trigger('change');

                fetch(`/buku/checkout-buku/kecamatan/${city_id}`)
                    .then(res => {
                        if (!res.ok) throw new Error('HTTP error ' + res.status);
                        return res.json();
                    })
                    .then(data => {
                        let html = '<option value="">Pilih Kecamatan</option>';
                        data.forEach(k => {
                            html +=
                                `<option value="${k.id}" data-name="${k.name}">${k.name}</option>`;
                        });
                        $('#kecamatan').html(html).trigger('change');
                    })
                    .catch(err => {
                        console.error(err);
                        $('#kecamatan').html('<option value="">Gagal memuat data</option>').trigger(
                            'change');
                    });
            });


            // === Hitung Ongkir Berdasarkan Kecamatan + Kurir ===
            $('#kurir, #kecamatan').on('change', function() {
                const kecamatan = $('#kecamatan').val();
                const kurir = $('#kurir').val();

                if (!kecamatan || !kurir) return;

                fetch(`/buku/checkout-buku/ongkir`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        body: JSON.stringify({
                            kecamatan,
                            kurir
                        })
                    })
                    .then(res => res.json())
                    .then(results => {
                        let html = '<option value="">Pilih Layanan</option>';

                        // ✅ Menyesuaikan struktur hasil dari endpoint baru
                        if (results.success && results.results.length > 0) {
                            results.results.forEach(item => {
                                html += `
                    <option value="${item.cost}" data-etd="${item.etd}" data-code="${item.code}">
                        ${item.name} - ${item.service} (${item.etd}) - Rp ${item.cost.toLocaleString('id-ID')}
                    </option>
                `;
                            });
                        } else {
                            html += '<option value="">Tidak ada layanan tersedia</option>';
                        }

                        $('#layanan_ongkir').html(html).trigger('change');
                    })
                    .catch(err => {
                        console.error(err);
                        $('#layanan_ongkir').html('<option value="">Gagal memuat layanan</option>')
                            .trigger('change');
                    });
            });

            // === Update Total saat Layanan Dipilih ===
            $('#layanan_ongkir').on('change', function() {
                const ongkir = parseInt($(this).val() || 0);
                $('#ongkir').text('Rp ' + ongkir.toLocaleString('id-ID'));

                const subtotal = parseInt($('#subtotal').text().replace(/\D/g, '')) || 0;
                const total = subtotal + ongkir;
                $('#total').text('Rp ' + total.toLocaleString('id-ID'));
            });
        });
    </script>
    <script>
        const checkoutItems = @json($checkoutItems);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (checkoutItems.length === 0) {
                window.location.href = '/';
                return;
            }

            // Render items
            function renderCheckoutItems() {
                const container = document.getElementById('checkout-items');
                let html = '';
                let total = 0;

                checkoutItems.forEach(item => {
                    const subtotal = item.harga * item.qty;
                    total += subtotal;

                    html += `
                <div class="flex items-start space-x-3 pb-3 border-b border-gray-100">
                    <img src="/storage/${item.thumbnail}"
                        class="w-16 h-16 object-cover rounded-lg shadow-sm"
                        alt="${item.judul}">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-sm text-gray-800 line-clamp-2 mb-1">
                            ${item.judul}
                        </h4>
                        <p class="text-xs text-gray-500">Qty: ${item.qty}</p>
                        <p class="text-sm font-bold text-primary mt-1">
                            Rp ${subtotal.toLocaleString('id-ID')}
                        </p>
                    </div>
                </div>
            `;
                });

                container.innerHTML = html;
                document.getElementById('subtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            renderCheckoutItems();

            document.getElementById('btnPesanSekarang').addEventListener('click', function() {
                const form = document.getElementById('checkoutForm');

                // Ambil nama provinsi/kota/kecamatan dari data-name
                const provinsiSelect = document.getElementById('provinsi');
                const kotaSelect = document.getElementById('kota');
                const kecSelect = document.getElementById('kecamatan');

                const provinsiName = provinsiSelect.selectedOptions[0]?.getAttribute('data-name') || '';
                const kotaName = kotaSelect.selectedOptions[0]?.getAttribute('data-name') || '';
                const kecamatanName = kecSelect.selectedOptions[0]?.getAttribute('data-name') || '';

                // Tambahkan ke hidden input agar dikirim ke server
                form.insertAdjacentHTML('beforeend', `
        <input type="hidden" name="provinsi_nama" value="${provinsiName}">
        <input type="hidden" name="kota_nama" value="${kotaName}">
        <input type="hidden" name="kecamatan_nama" value="${kecamatanName}">
    `);
                const requiredFields = ['nama_lengkap', 'email', 'no_hp', 'alamat'];
                const selectFields = ['provinsi', 'kota', 'kecamatan', 'kurir', 'layanan_ongkir'];
                let valid = true;

                requiredFields.forEach(name => {
                    const input = form.querySelector(`[name="${name}"]`);
                    if (input && !input.value.trim()) valid = false;
                });

                selectFields.forEach(id => {
                    const select = document.getElementById(id);
                    if (select && !select.value) valid = false;
                });

                if (!valid) {
                    showToast('❌ Lengkapi semua data wajib sebelum melanjutkan!');
                    return;
                }

                // ✅ Tambahkan catatan ke setiap item
                const catatan = form.querySelector('[name="catatan"]').value || null;
                checkoutItems.forEach(item => item.catatan = catatan);

                // ✅ Buat hidden input untuk items
                const hiddenItems = document.createElement('input');
                hiddenItems.type = 'hidden';
                hiddenItems.name = 'items';
                hiddenItems.value = JSON.stringify(checkoutItems);
                form.appendChild(hiddenItems);

                form.submit();
            });




        });

        function showToast(message, type = 'error') {
            const toast = document.getElementById('toast');
            toast.textContent = message;

            // reset class
            toast.classList.remove('hidden', 'opacity-0', 'bg-red-500', 'bg-green-500');

            // warna
            if (type === 'success') {
                toast.classList.add('bg-green-500');
            } else {
                toast.classList.add('bg-red-500');
            }

            // tampilkan
            toast.classList.add('opacity-100');

            // hilangkan setelah 3 detik
            setTimeout(() => {
                toast.classList.remove('opacity-100');
                toast.classList.add('opacity-0');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 500);
            }, 3000);
        }
    </script>
@endpush
