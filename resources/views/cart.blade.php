@extends('layouts.app')

@section('content')
<div class="container">
    @if(empty($cartItems))
        <div class="text-center my-5">
            <h3>Keranjang Anda kosong.</h3>
            <a href="{{ route('user.product') }}" class="btn btn-primary mt-3">Mulai Belanja</a>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Keranjang Belanja</h4>
                <div>
                    <button id="editButton" class="btn btn-warning">Edit Pesanan</button>
                    <button id="submitEditButton" class="btn btn-success d-none">Submit Pesanan</button>
                    <button id="cancelEditButton" class="btn btn-secondary d-none">Batalkan Edit</button>
                </div>
            </div>
            <div class="card-body">
                <!-- Form untuk Checkout -->
                <form id="checkoutForm" action="{{ route('checkout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>{{ $item->product ? $item->product->name : 'Produk tidak ditemukan' }}</td>
                                    <td>Rp <span class="unit-price" data-price="{{ optional($item->product)->price }}">
                                        {{ number_format(optional($item->product)->price ?? 0, 0, ',', '.') }}
                                    </span></td>
                                    <td>
                                        <input type="number" class="quantity-input form-control" 
                                            name="quantity" 
                                            id="quantity-{{ $item->id }}" 
                                            value="{{ $item->quantity }}" 
                                            min="1" 
                                            max="{{ optional($item->product)->stock ?? 0 }}" 
                                            onchange="updateTotalPrice({{ $item->id }})">
                                    </td>
                                    <td>Rp <span class="total-price" id="total-price-{{ $item->id }}">
                                        {{ number_format(optional($item->product)->price * $item->quantity ?? 0, 0, ',', '.') }}
                                    </span></td>
                                    <td>
                                        @if(!$item->is_fixed)
                                            <form action="{{ route('cart.removeCart', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-delete">Hapus</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary" disabled>Pesanan Fixed</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('user.product') }}" class="btn btn-outline-primary">Kembali Belanja</a>
                    <button type="button" class="btn btn-primary" id="checkoutButton">
                        Checkout Sekarang
                    </button>
                </div>

                <!-- Tombol Pesan Lewat WhatsApp -->
                <div class="d-flex justify-content-center mt-3">
                    <button id="whatsappOrder" class="btn btn-success">
                        Pesan Langsung Lewat WhatsApp
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let isEditing = false;
    let originalQuantities = {};

    // Fungsi untuk mengaktifkan/menonaktifkan mode edit
    function toggleEditing(state) {
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.disabled = !state;
            if (state) {
                originalQuantities[input.id] = input.value;
            }
        });

        document.getElementById('submitEditButton').classList.toggle('d-none', !state);
        document.getElementById('cancelEditButton').classList.toggle('d-none', !state);
        document.getElementById('editButton').classList.toggle('d-none', state);
    }

    // Fungsi untuk memperbarui total harga
    function updateTotalPrice(productId) {
        let quantityInput = document.getElementById(`quantity-${productId}`);
        let unitPrice = parseInt(quantityInput.closest('tr').querySelector('.unit-price').dataset.price);
        let totalPriceElement = document.getElementById(`total-price-${productId}`);

        let quantity = parseInt(quantityInput.value);
        let newTotalPrice = quantity * unitPrice;
        totalPriceElement.innerText = newTotalPrice.toLocaleString('id-ID');
    }

    // Tombol Edit
    document.getElementById('editButton').addEventListener('click', () => {
        isEditing = true;
        toggleEditing(true);
    });

    // Tombol Batalkan Edit
    document.getElementById('cancelEditButton').addEventListener('click', () => {
        isEditing = false;
        toggleEditing(false);
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.value = originalQuantities[input.id];
        });
    });

    // Tombol Submit Pesanan
    document.getElementById('submitEditButton').addEventListener('click', () => {
        isEditing = false;
        toggleEditing(false);
        document.getElementById('updateCartForm').submit();
    });

    // Tombol Checkout
    document.getElementById('checkoutButton').addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah form submit default

        if (confirm('Apakah Anda yakin ingin checkout?')) {
            // Kirim form checkout
            document.getElementById('checkoutForm').submit();
        }
    });

    // Tombol Pesan Lewat WhatsApp
    document.getElementById('whatsappOrder').addEventListener('click', function() {
        let phoneNumber = "6287831002289"; // Nomor WhatsApp tanpa + atau -
        let message = "Halo, saya ingin memesan produk berikut:\n\n";

        document.querySelectorAll('.table tbody tr').forEach(function(row) {
            let product = row.querySelector('td:first-child').innerText.trim();
            let price = row.querySelector('.unit-price').dataset.price;
            let quantity = row.querySelector('.quantity-input').value;
            let total = row.querySelector('.total-price').innerText.trim();

            message += `- ${product}\n  Harga: Rp ${parseInt(price).toLocaleString('id-ID')}\n  Jumlah: ${quantity}\n  Total: ${total}\n\n`;
        });

        message += "Terima kasih telah berbelanja di sini! 😊";

        let encodedMessage = encodeURIComponent(message);
        let whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

        window.open(whatsappURL, '_blank');
    });
});
</script>
@endsection