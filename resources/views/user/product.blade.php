@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Our Products</h2>

        <!-- Form Pencarian Produk -->
        <form method="GET" action="{{ route('user.product') }}">
            <div class="row mb-3">
                <div class="col-md-6 offset-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk berdasarkan nama..." value="{{ request()->get('search') }}">
                </div>
                <div class="col-md-2 text-center">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>

        <!-- Daftar Produk -->
        <div class="row mt-4">
            @forelse ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card p-3 border shadow-sm">
                        <h4 class="card-title">{{ $product->name }}</h4>
                        <p class="card-text">Harga: <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                        <p class="card-text">Stock: 
                            @if ($product->stock > 0)
                                <span class="text-success">Tersedia</span>
                            @else
                                <span class="text-danger">Habis</span>
                            @endif
                        </p>
                        @if ($product->stock > 0)
                            <a href="{{ route('user.purchase', ['id' => $product->id, 'quantity' => 1]) }}" class="btn btn-success w-100">Beli Sekarang</a>
                        @else
                            <span class="badge bg-danger w-100 py-2">Stok Habis</span>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Menampilkan pesan jika tidak ada produk ditemukan berdasarkan pencarian -->
                @if (request()->get('search'))
                    <div class="col-12 text-center">
                        <p class="text-muted">❌ Produk dengan nama "<strong>{{ request()->get('search') }}</strong>" tidak ditemukan.</p>
                    </div>
                @else
                    <div class="col-12 text-center">
                        <p class="text-muted">❌ Tidak ada produk untuk ditampilkan.</p>
                    </div>
                @endif
            @endforelse
        </div>
    </div>
@endsection
