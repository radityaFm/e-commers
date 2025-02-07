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
                <div class="card-header bg-white">
                    <h4 class="mb-0">Keranjang Belanja</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>Rp<span class="unit-price" data-price="{{ $item->product->price }}">{{ number_format($item->product->price, 0, ',', '.') }}</span></td>
                                <td>
                                    <input type="number" 
                                           class="quantity-input form-control" 
                                           id="quantity-{{ $item->id }}" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="{{ $item->product->stock }}" 
                                           disabled 
                                           data-product-id="{{ $item->id }}" 
                                           onchange="updateTotalPrice({{ $item->id }}, {{ $item->product->stock }})">
                                </td>
                                <td><span id="total-price-{{ $item->id }}" class="total-price">{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span></td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold">Rp<span id="grand-total">
                {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 0, ',', '.') }}
            </span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Button Section -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('user.product') }}" class="btn btn-outline-primary">Lanjut Belanja</a>
                        <div class="btn-group">
                             <button id="editButton" class="btn btn-warning">Edit Keranjang</button>
                            <button id="submitEditButton" class="btn btn-success" style="display:none;">Submit Edit</button>
                            <button id="cancelEditButton" class="btn btn-secondary" style="display:none;">Batalkan Edit</button>
                            <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm>
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <button type="submit" class="btn btn-primary mt-3" id="checkoutButton">Checkout</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    let isEditing = false;
    let originalQuantities = {};

    function toggleEditing(isEditing) {
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.disabled = !isEditing;
            if (isEditing) {
                originalQuantities[input.id] = input.value;
            }
        });
        document.getElementById('submitEditButton').style.display = isEditing ? 'inline-block' : 'none';
        document.getElementById('cancelEditButton').style.display = isEditing ? 'inline-block' : 'none';
        document.getElementById('editButton').style.display = isEditing ? 'none' : 'inline-block';
    }

    function updateTotalPrice(productId, maxStock) {
        let quantityInput = document.getElementById(`quantity-${productId}`);
        let unitPriceElement = document.querySelector(`#quantity-${productId}`).closest('tr').querySelector('.unit-price');
        let totalPriceElement = document.getElementById(`total-price-${productId}`);

        let quantity = parseInt(quantityInput.value);
        let unitPrice = parseInt(unitPriceElement.dataset.price);

        if (quantity > maxStock) {
            alert('Jumlah melebihi stok yang tersedia.');
            quantityInput.value = maxStock;
            quantity = maxStock;
        }

        let newTotalPrice = quantity * unitPrice;
        totalPriceElement.innerText = newTotalPrice.toLocaleString('id-ID');

        updateGrandTotal();
    }

    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.total-price').forEach(element => {
            total += parseInt(element.innerText.replace(/\./g, ''));
        });
        document.getElementById('grand-total').innerText = total.toLocaleString('id-ID');
    }

    document.getElementById('editButton').addEventListener('click', () => {
        isEditing = true;
        toggleEditing(true);
    });

    document.getElementById('cancelEditButton').addEventListener('click', () => {
        isEditing = false;
        toggleEditing(false);
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.value = originalQuantities[input.id];
        });
        updateGrandTotal();
    });

    document.getElementById('submitEditButton').addEventListener('click', () => {
        const updatedQuantities = {};
        let valid = true;

        document.querySelectorAll('.quantity-input').forEach(input => {
            const quantity = parseInt(input.value);
            const maxStock = parseInt(input.max);

            if (quantity > maxStock) {
                alert('Jumlah melebihi stok yang tersedia');
                valid = false;
                return;
            }

            updatedQuantities[input.dataset.productId] = quantity;
        });

        if (!valid) return;

        alert("Perubahan berhasil diterapkan!");
        isEditing = false;
        toggleEditing(false);
    });

    // Checkout Button Action
    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const cartData = [];
        document.querySelectorAll('.quantity-input').forEach(input => {
            cartData.push({
                product_id: input.dataset.productId,
                quantity: input.value
            });
        });

        document.getElementById('cartData').value = JSON.stringify(cartData);

        this.submit();
    });
    document.getElementById('checkoutButton').addEventListener('click', function (e) {
    e.preventDefault();  // Prevent the form submission initially
    
    // Show an alert before proceeding to checkout
    const confirmation = confirm('Apakah Anda yakin ingin melanjutkan ke checkout?');
    
    if (confirmation) {
        // If confirmed, submit the form with CSRF token
        let form = document.getElementById('checkoutForm');
        let formData = new FormData(form);
        
        // Add CSRF token explicitly in case it's not added via Blade
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Submit the form using AJAX (you can adjust to your needs, like using jQuery or fetch API)
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response (for example, redirect to checkout page)
            if (data.success) {
                window.location.href = data.redirect_url;  // Assuming the response contains a redirect URL
            }
        })
        .catch(error => console.error('Error during checkout submission:', error));
    }
});

</script>
@endsection
