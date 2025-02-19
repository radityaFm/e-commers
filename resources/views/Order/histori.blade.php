@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Riwayat Pesanan</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info">
            Anda belum memiliki pesanan.
        </div>
    @else
        @foreach($orders as $order)
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Pesanan #{{ $order->id }}</h3>
                    <p class="mb-0">
                        <strong>Status:</strong> 
                        <span class="badge 
                            @if($order->status == 'completed') bg-success 
                            @elseif($order->status == 'pending') bg-warning 
                            @elseif($order->status == 'cancelled') bg-danger 
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p class="mb-0">
                        <strong>Tanggal Pesanan:</strong> 
                        {{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} 
                    </p>
                </div>
                <div class="card-body">
                    <h5>Item Pesanan:</h5>
                    <ul class="list-group mb-3">
                        @foreach($order->items as $item)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>{{ $item->product->name }}</strong>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        {{ $item->quantity }} x 
                                    </div>
                                    <div class="col-md-3 text-end">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-end">
                        <h5>Total Pesanan: Rp {{ number_format($order->total, 0, ',', '.') }}</h5>
                    </div>
                    <div class="card-footer">
                    <a href="{{ route('/', $order->id) }}" class="btn btn-primary">Kembali ke Home</a>
                    
                    <!-- Tombol WhatsApp -->
                    <button class="btn btn-success whatsappOrder" data-order-id="{{ $order->id }}">
                        Pesan Langsung Lewat WhatsApp
                    </button>
                </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
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
                let values = item.querySelectorAll('.col-md-3.text-end');

                // Pastikan ada setidaknya dua elemen (quantity dan price)
                if (values.length >= 2) {
                    let quantity = values[0].innerText.trim().replace(/\D/g, ''); // Hanya angka
                    let price = values[1].innerText.trim().replace(/Rp\s?|[^0-9]/g, ''); // Hapus "Rp" dan non-angka

                    // Pastikan price dan quantity adalah angka
                    price = price ? parseInt(price, 10) : 0;
                    quantity = quantity ? parseInt(quantity, 10) : 0;

                    // Hitung total harga produk
                    let totalProductPrice = price * quantity;
                    totalPriceSum += totalProductPrice; // Tambahkan ke total harga keseluruhan

                    // Tambahkan detail produk ke pesan
                    message += `Produk: ${product}\n`;
                    message += `Harga: Rp ${price.toLocaleString('id-ID')}\n`;
                    message += `Jumlah: ${quantity}\n`;
                    message += `Subtotal: Rp ${totalProductPrice.toLocaleString('id-ID')}\n`;
                    message += `-----------------------------\n`;
                }
            });

            // Ambil elemen total harga di dalam card
            let totalPriceElement = orderCard.querySelector('.text-end h5');

            // Cek apakah elemen ditemukan
            if (!totalPriceElement) {
                console.error("Elemen total harga (h5) tidak ditemukan dalam .text-end");
            } else {
                console.log("Elemen total harga ditemukan:", totalPriceElement.innerText);
            }

            // Ambil teks total harga dan bersihkan angka
            let totalPriceText = totalPriceElement ? totalPriceElement.innerText.trim().replace(/\D/g, '') : '0';

            // Konversi ke angka jika valid, jika tidak, gunakan hasil perhitungan manual
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
@endsection
