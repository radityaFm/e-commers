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
                                        max="{{ optional($item->product)->stock }}" 
                                        onchange="updateCart({{ $item->id }})">
                                </td>
                                <td>Rp <span class="total-price" id="total-price-{{ $item->id }}">
                                    {{ number_format($item->total_price ?? 0, 0, ',', '.') }}
                                </span></td>
                                <td>
                                    <form action="{{ route('cart.removeCart', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-delete">Hapus</button>
                                    </form>
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
                <div class="d-flex justify-content-center mt-5">
                    <a href="{{ route('order.histori') }}">
                    <button class="btn btn-primary ms-4">
                        Lihat history pemesanan
                    </button>
                    <a>
                </div>
            </div>
        </div>
    @endif
    <div class="container py-4 mx-auto fs-4" style="color:red;">* Ketika sudah checkout pesanan, maka diharap memberi pesan melalui WhatsAPP untuk pembayaran</div>
</div>
@endsection

@section('scripts')
<script>
function updateCart(itemId) {
    const quantityInput = document.getElementById(`quantity-${itemId}`);
    const unitPriceElement = document.querySelector(`#quantity-${itemId}`).closest('tr').querySelector('.unit-price');
    const totalPriceElement = document.getElementById(`total-price-${itemId}`);

    const unitPrice = parseFloat(unitPriceElement.getAttribute('data-price'));
    const quantity = parseInt(quantityInput.value);

    const totalPrice = unitPrice * quantity;

    // Update tampilan total price
    totalPriceElement.textContent = totalPrice.toLocaleString('id-ID', { maximumFractionDigits: 0 });

    // Kirim permintaan AJAX untuk memperbarui quantity dan total price di server
    fetch(`cart.updateCart/${itemId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Jumlah dan harga total diperbarui.');
        } else {
            console.error('Gagal memperbarui jumlah dan harga total.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
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

    document.getElementById('checkoutButton').addEventListener('click', function (e) {
    e.preventDefault(); // Mencegah form submit default

    Swal.fire({
        title: 'Apakah Anda yakin ingin checkout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Checkout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Nonaktifkan tombol "Hapus" sebelum checkout dilakukan
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.disabled = true;
                button.classList.remove('btn-danger'); // Menghapus warna merah
                button.classList.add('btn-secondary'); // Mengubah warna ke abu-abu
                button.innerText = 'Pesanan Fixed'; // Mengubah teks tombol
            });

            // Kirim form checkout setelah perubahan tombol
            document.getElementById('checkoutForm').submit();
        }
    });
});
});
</script>
@endsection