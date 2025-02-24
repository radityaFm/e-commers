<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class DeleteOldOrders extends Command
{
    protected $signature = 'orders:delete-old';
    protected $description = 'Menghapus pesanan yang lebih dari satu minggu';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $deleted = Order::where('created_at', '<', Carbon::now()->subWeek())->delete();

        $this->info("Pesanan lebih dari satu minggu telah dihapus: $deleted pesanan.");
    }
}
