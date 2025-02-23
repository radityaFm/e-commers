@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Riwayat Pesanan</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info">Anda belum memiliki pesanan.</div>
    @else
        @foreach($orders as $order)
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Pesanan #{{ $order->id }}</h3>
                    <p class="mb-0"><strong>Status:</strong> 
                        <span class="badge 
                            @if($order->status == 'completed') bg-success 
                            @elseif($order->status == 'pending') bg-warning 
                            @elseif($order->status == 'checkout') bg-primary 
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p class="mb-0"><strong>Tanggal Pesanan:</strong> 
                        {{ $order->created_at->format('d M Y H:i') }} 
                    </p>
                </div>

                <div class="card-body">
                    <h5>Item Pesanan:</h5>
                    <ul class="list-group">
                        @foreach($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $item->product->name }} ({{ $item->quantity }}x)</span>
                                <span>Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-3 text-end">
                        <h5>Total: Rp{{ number_format($order->items->sum(fn($item) => $item->quantity * $item->price), 0, ',', '.') }}</h5>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-start">
                    <a href="{{ route('/') }}" class="btn btn-primary me-2">Kembali ke Home</a>
                    <button class="btn btn-success whatsappOrder" data-order-id="{{ $order->id }}">
                        Pesan Langsung Lewat WhatsApp
                    </button>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.whatsappOrder').forEach(button => {
        button.addEventListener('click', function() {
            let orderId = this.getAttribute('data-order-id');
            let phoneNumber = "6287831002289"; // Nomor WhatsApp
            let message = `Permisi, saya sudah memesan dan saya ingin membeli\n\n`;
            message += `==============================\n`;
            message += `  STRUK PESANAN #${orderId}\n`;
            message += `==============================\n\n`;

            let orderCard = this.closest('.card');
            let totalPriceSum = 0; // Untuk menyimpan total harga

            // Loop melalui setiap item produk
            orderCard.querySelectorAll('.list-group-item').forEach(function(item) {
                // Ambil nama produk
                let productElement = item.querySelector('.col-md-6 strong');
                let product = productElement ? productElement.innerText.trim() : 'Produk tidak ditemukan';

                // Ambil semua elemen dengan class .col-md-3.text-end
                let values = item.querySelectorAll('.col-md-2.text-end');

                // Pastikan ada setidaknya tiga elemen (quantity, price, total_price)
                if (values.length >= 3) {
                    let quantity = values[0].innerText.trim().replace(/\D/g, ''); // Hanya angka
                    let price = values[1].innerText.trim().replace(/Rp\s?|[^0-9]/g, ''); // Hapus "Rp" dan non-angka
                    let totalPrice = values[2].innerText.trim().replace(/Rp\s?|[^0-9]/g, ''); // Hapus "Rp" dan non-angka

                    // Pastikan price, quantity, dan totalPrice adalah angka
                    price = price ? parseInt(price, 10) : 0;
                    quantity = quantity ? parseInt(quantity, 10) : 0;
                    totalPrice = totalPrice ? parseInt(totalPrice, 10) : 0;

                    // Tambahkan detail produk ke pesan
                    message += `Produk: ${product}\n`;
                    message += `Harga: Rp ${price.toLocaleString('id-ID')}\n`;
                    message += `Jumlah: ${quantity}\n`;
                    message += `Subtotal: Rp ${totalPrice.toLocaleString('id-ID')}\n`;
                    message += `-----------------------------\n`;
                }
            });

            // Ambil elemen total harga di dalam card
            let totalPriceElement = orderCard.querySelector('.text-end h5');

            // Ambil teks total harga dan bersihkan angka
            let totalPriceText = totalPriceElement ? totalPriceElement.innerText.trim().replace(/\D/g, '') : '0';

            // Konversi ke angka jika valid
            let totalPrice = totalPriceText ? parseInt(totalPriceText, 10) : totalPriceSum;

            // Tambahkan total harga ke pesan
            message += `TOTAL: Rp ${totalPrice.toLocaleString('id-ID')}\n`;
            message += `==============================\n\n`;
            message += `Jika ada pesan tambahan, silakan tulis di bawah ini.`;

            // Encode pesan untuk URL WhatsApp
            let encodedMessage = encodeURIComponent(message);
            let whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

            // Buka WhatsApp
            window.open(whatsappURL, '_blank');
        });
    });
});
</script>
@endpush