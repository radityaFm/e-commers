<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('phone_number')->nullable(); 
            $table->string('city');
            $table->text('address');
            $table->string('booking_trx_id');
            $table->string('post_code');
            $table->string('proof')->nullable();
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('sub_total_amount');
            $table->unsignedBigInteger('grand_total_amount');
            $table->unsignedBigInteger('discount_amount')->nullable();
            $table->boolean('is_paid');
            $table->foreignId('product_id')->default(1)->constrained()->cascadeOnDelete();
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};
