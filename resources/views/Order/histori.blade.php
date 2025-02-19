@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Pesanan</h1>

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
                        {{ $order->created_at->format('d M Y H:i') }}
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
                </div>
                <div class="card-footer">
                    <a href="{{ route('/', $order->id) }}" class="btn btn-primary">
                        kembali ke home
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection