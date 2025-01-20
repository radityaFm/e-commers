<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductTransaction; 


class StatsOverview extends BaseWidget
{   
    protected function getStats(): array
    {
        // Count all users
        $totalUsers = User::count();
        // Count all products
        $totalProducts = Product::count();
        // Count all orders
        $totalRevenue = ProductTransaction::sum('grand_total_amount');
        $formattedRevenue = 'IDR ' . number_format($totalRevenue, 0, ',', '.');

        return [
            Stat::make('Total Users', $totalUsers)  
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Total Products', $totalProducts)  
                ->description('Total available products')
                ->descriptionIcon('heroicon-m-cube')
                ->icon('heroicon-o-archive-box')
                ->color('success'),

            Stat::make('Total Revenue', $formattedRevenue)
                ->description('Total revenue from transactions')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->icon('heroicon-o-currency-dollar')
                ->color('warning'),
        ];
    }

    public function getColumnSpan(): int
    {
        return 2;  
    }
}


