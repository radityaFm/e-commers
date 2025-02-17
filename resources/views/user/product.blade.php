@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Produk</h1>

    <!-- Tampilkan pesan error -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tampilkan produk -->
    @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="card-text">Stok: {{ $product->stock }}</p>

                    <!-- Form untuk menambahkan produk ke keranjang -->
                    <form action="{{ route('user.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <label for="quantity">Jumlah</label>
                        <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="form-control mb-2" required>
                        <button type="submit" class="btn btn-primary btn-block">Tambah ke Keranjang</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection