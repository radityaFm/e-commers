@extends('layouts.app')

@section('content')
<div class="container">
    @if($cartItems->isEmpty())
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
                <div class="table-responsive">
                <form action="{{ route('cart.updateCart', ['id' => $item->id]) }}" method="GET">
                        @csrf
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Status</th>
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
                                            name="quantities[{{ $item->id }}]" 
                                            id="quantity-{{ $item->id }}" 
                                            value="{{ $item->quantity }}" 
                                            min="1" 
                                            max="{{ optional($item->product)->stock ?? 0 }}" 
                                            disabled 
                                            onchange="updateTotalPrice({{ $item->id }})">
                                    </td>
                                    <td>Rp <span class="total-price" id="total-price-{{ $item->id }}">
                                        {{ number_format(optional($item->product)->price * $item->quantity ?? 0, 0, ',', '.') }}
                                    </span></td>
                                    <td>
                                        @if(method_exists($item, 'isCheckedOut') && $item->isCheckedOut())
                                            <span class="badge bg-success">Checked Out</span>
                                        @else
                                            <span class="badge bg-warning">Belum Checkout</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$item->isCheckedOut())
                                        <form action="{{ route('cart.removeCart', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                        @else
                                            <button class="btn btn-secondary" disabled>Sudah Checkout</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('user.product') }}" class="btn btn-outline-primary">Kembali Belanja</a>
                    <button type="submit" class="btn btn-primary" id="checkoutButton" {{ $cartItems->every->isCheckedOut() ? 'disabled' : '' }}>
                        Checkout Sekarang
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

    // Konfirmasi Checkout
    document.getElementById('checkoutButton').addEventListener('click', function (e) {
        e.preventDefault();
        if (confirm('Apakah Anda yakin ingin melanjutkan ke checkout?')) {
            document.getElementById('checkoutForm').submit();
        }
    });
});
</script>
@endsection
