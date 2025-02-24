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
    Schema::create('otps', function (Blueprint $table) {
        $table->id();
        $table->string('email'); // Email pengguna
        $table->string('otp_code'); // Kode OTP
        $table->timestamp('expires_at'); // Waktu kedaluwarsa OTP
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
