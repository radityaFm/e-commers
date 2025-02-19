<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // ID item pesanan (primary key)
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relasi ke tabel orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relasi ke tabel products
            $table->integer('quantity'); // Jumlah produk yang dipesan
            $table->decimal('price', 8, 2); // Harga produk saat checkout
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items'); // Hapus tabel jika migrasi di-rollback
    }
};