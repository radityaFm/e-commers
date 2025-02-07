<!-- resources/views/user/product.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="card-text">Stok: {{ $product->stock }}</p>

                    <!-- Form untuk menambahkan produk ke keranjang -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <label for="quantity">Jumlah</label>
                        <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="form-control mb-2" required>
                        <button type="submit" class="btn btn-primary btn-block">Tambah ke Keranjang</button>
                        <a href="{{ route('cart') }}" class="btn btn-success">Kembali ke Keranjang</a>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
