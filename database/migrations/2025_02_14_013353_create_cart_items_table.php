<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
            
            // Tambahkan unique constraint jika diperlukan
            $table->unique(['cart_id', 'product_id']);
        });
    }
    
    public function down(): void {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['product_id']);
        });
    
        Schema::dropIfExists('cart_items');
    }   
};