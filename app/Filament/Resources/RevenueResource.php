<?php

namespace App\Filament\Resources;

use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;

class RevenueResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationLabel = 'Rekap Penghasilan';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Management';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('day')
                    ->label('Hari')
                    ->sortable(),

                TextColumn::make('total_revenue')
                    ->label('Total Keuntungan')
                    ->formatStateUsing(fn ($record) => 'Rp ' . number_format($record->total_revenue ?? 0, 0, ',', '.'))
                    ->sortable(),
            ])
            ->query(function () {
                return Order::where('orders.status', 'completed')
                    ->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                    ->selectRaw('MIN(orders.id) as id, DAYNAME(orders.created_at) as day, SUM(order_items.quantity * order_items.price) as total_revenue')
                    ->groupBy('day')
                    ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')");
            });
    }

    public static function getTotalCompletedOrdersThisWeek(): array
    {
        $data = Order::where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw('DAYNAME(orders.created_at) as day, SUM(order_items.quantity * order_items.price) as total_revenue')
            ->groupBy('day')
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->get();

        // Format hasilnya agar lebih mudah dibaca
        $result = [];
        foreach ($data as $item) {
            $result[$item->day] = 'Rp ' . number_format($item->total_revenue ?? 0, 0, ',', '.');
        }

        return array_values($result); // Pastikan output dalam bentuk array
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\RevenueResource\Pages\ListRevenues::route('/'),
        ];
    }
}
