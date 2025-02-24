@extends('layouts.app')

@section('content')
<div class="container mt-5 pt-4">
    <h1 class="my-4">Riwayat Pesanan</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info my-4 mt-5">Anda belum memiliki pesanan.</div>
    @else
        @foreach($orders as $order)
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Pesanan ku</h3>
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
                                <div>
                                    <strong>{{ $item->product->name }}</strong> ({{ $item->quantity }}x) <br>
                                    <small class="text-muted">Harga awal: Rp{{ number_format($item->price, 0, ',', '.') }}</small>
                                </div>
                                <span class="fw-bold">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
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
                        Lanjut via WhatsAPP
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
            message += `  STRUK PESANANKU\n`;
            message += `==============================\n\n`;

            let orderCard = this.closest('.card');
            if (!orderCard) return;

            let totalPriceSum = 0; // Untuk menyimpan total harga

            // Loop melalui setiap item produk
            orderCard.querySelectorAll('.list-group-item').forEach(function(item) {
                let productText = item.querySelector('strong')?.textContent.trim() || "Produk Tidak Diketahui";
                let quantityText = item.querySelector('div')?.textContent.match(/\d+x/) || ["1x"];
                let quantity = parseInt(quantityText[0].replace('x', ''), 10) || 1;

                let totalText = item.querySelector('span.fw-bold')?.textContent.replace(/\D/g, '') || "0";
                let totalPrice = parseInt(totalText, 10) || 0;
                let price = Math.floor(totalPrice / quantity); // Hitung harga awal per item

                // Tambahkan detail produk ke pesan
                message += `Produk: ${productText}\n`;
                message += `Harga Awal: Rp ${price.toLocaleString('id-ID')}\n`;
                message += `Jumlah: ${quantity}\n`;
                message += `Subtotal: Rp ${totalPrice.toLocaleString('id-ID')}\n`;
                message += `-----------------------------\n`;

                totalPriceSum += totalPrice;
            });

            // Ambil total harga dari elemen HTML
            let totalPriceElement = orderCard.querySelector('.text-end h5');
            let totalPrice = totalPriceElement ? parseInt(totalPriceElement.textContent.replace(/\D/g, ''), 10) : totalPriceSum;

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