@extends('layouts.app')

@section('content')
<div class="container py-3"> <!-- Menambahkan padding atas dan bawah -->
    <h1 class="text-center mb-5 mt-5 py-4">Daftar Produk</h1>

    <!-- Tampilkan pesan error -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        @foreach($products as $product)
            <div class="col-sm-6 col-md-3 mb-4"> <!-- Memberikan jarak bawah -->
                <div class="card h-100 shadow-sm p-2"> <!-- Memberikan jarak dalam kartu -->
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 150px; object-fit: cover;">
                    <div class="card-body p-3"> <!-- Memberikan padding dalam kartu -->
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        
                        <!-- Harga dan stok di pojok kiri -->
                        <p class="card-text text-start text-success fw-bold mb-1 mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="small text-muted text-start mb-3 ">Stok: {{ $product->stock }}</p>

                        <!-- Form untuk menambahkan produk ke keranjang -->
                        <form action="{{ route('user.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="input-group input-group-sm mb-3 mt-4">
                                <span class="input-group-text">Jumlah</span>
                                <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="form-control" required>
                            </div>
                            
                            <!-- Tombol bersebelahan dengan jarak bawah -->
                            <div class="d-flex justify-content-between mt-2">
                                <button type="submit" class="btn btn-primary btn-sm w-50">Tambah</button>
                                <a href="{{ route('cart') }}" class="btn btn-success btn-sm w-50 ms-2">Keranjang</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
