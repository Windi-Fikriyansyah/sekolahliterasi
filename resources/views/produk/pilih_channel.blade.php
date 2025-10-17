@extends('layouts.app')
@section('title', 'Pilih Metode Pembayaran')

@section('content')
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-2xl font-bold mb-8 text-center text-secondary">Pilih Metode Pembayaran</h1>

            <form method="POST" action="{{ route('buku.createPayment') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="checkoutData" value='@json($checkoutData)'>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($channels as $ch)
                        <label
                            class="payment-option border border-gray-200 rounded-xl p-4 cursor-pointer bg-white hover:border-primary hover:bg-blue-50 transition-all duration-200 flex items-center gap-4 peer-checked:ring-2 peer-checked:ring-primary peer-checked:bg-blue-50">
                            <input type="radio" name="channel" value="{{ $ch['code'] }}" class="hidden peer" required>

                            <div class="w-14 h-14 flex-shrink-0">
                                <img src="{{ $ch['icon_url'] }}" alt="{{ $ch['name'] }}"
                                    class="w-full h-full object-contain">
                            </div>

                            <div class="flex flex-col flex-1">
                                <p class="font-semibold text-gray-800">{{ $ch['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $ch['group'] }}</p>
                            </div>

                            <div
                                class="check-icon hidden peer-checked:flex items-center justify-center w-6 h-6 rounded-full bg-primary text-white">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                        </label>
                    @endforeach
                </div>

                <button type="submit"
                    class="w-full mt-8 bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-lg font-bold text-lg hover:shadow-lg hover:scale-[1.02] transition-all">
                    Lanjutkan ke Pembayaran
                </button>
            </form>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .payment-option:hover {
            transform: translateY(-2px);
        }

        .peer:checked+div+div+div {
            display: flex !important;
        }

        .peer:checked~.flex-1 {
            background-color: #e0f2fe;
        }
    </style>
@endpush

@push('js')
    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const selected = document.querySelector('input[name="channel"]:checked');
            if (!selected) {
                e.preventDefault();
                alert('Pilih salah satu metode pembayaran terlebih dahulu.');
            }
        });
    </script>
@endpush
