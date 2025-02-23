@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Semua Pesanan</h1>

    <!-- Filter berdasarkan hari -->
    <form method="GET" action="{{ route('order') }}" class="mb-4">
        <label for="dayFilter" class="form-label">Filter berdasarkan hari:</label>
        <select name="day" id="dayFilter" class="form-select" onchange="this.form.submit()">
            <option value=""> Semua Hari </option>
            <option value="senin" {{ request('day') == 'senin' ? 'selected' : '' }}>Senin</option>
            <option value="selasa" {{ request('day') == 'selasa' ? 'selected' : '' }}>Selasa</option>
            <option value="rabu" {{ request('day') == 'rabu' ? 'selected' : '' }}>Rabu</option>
            <option value="kamis" {{ request('day') == 'kamis' ? 'selected' : '' }}>Kamis</option>
            <option value="jumat" {{ request('day') == 'jumat' ? 'selected' : '' }}>Jumat</option>
            <option value="sabtu" {{ request('day') == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
            <option value="minggu" {{ request('day') == 'minggu' ? 'selected' : '' }}>Minggu</option>
        </select>
    </form>

    @if($orders->isEmpty())
        <div class="alert alert-info">Tidak ada pesanan untuk hari yang dipilih.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Tanggal Pesanan</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'completed') bg-success 
                                    @elseif($order->status == 'pending') bg-warning 
                                    @elseif($order->status == 'checkout') bg-primary 
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>Rp{{ number_format($order->items->sum(fn($item) => $item->quantity * $item->price), 0, ',', '.') }}
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetail{{ $order->id }}">
                                    Lihat
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Detail Pesanan -->
                        <div class="modal fade" id="orderDetail{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Pesanan #{{ $order->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>Pemesan: {{ $order->user->name ?? 'Guest' }}</h5>
                                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                        <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

                                        <h5>Item Pesanan:</h5>
                                        <ul class="list-group">
                                            @foreach($order->items as $item)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>{{ $item->product->name }} ({{ $item->quantity }}x)</span>
                                                    <span>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="mt-3 text-end">
                                            <h5>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
