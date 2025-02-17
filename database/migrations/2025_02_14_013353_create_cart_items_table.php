<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Relasi ke tabel carts
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relasi ke tabel products
            $table->integer('quantity')->default(1); // Jumlah produk
            $table->timestamps();
    
            // Tambahkan unique constraint jika diperlukan
            $table->unique(['cart_id', 'product_id']);
        });
    }
    
    public function down(): void {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};