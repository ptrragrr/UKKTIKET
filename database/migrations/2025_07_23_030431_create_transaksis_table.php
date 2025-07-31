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
        Schema::create('transaksis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('kode_transaksi')->unique();
    $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
    $table->enum('metode_pembayaran', ['dana', 'ovo', 'gopay', 'bca', 'bri'])->nullable();
    $table->integer('subtotal');
    $table->integer('tax')->default(0);
    $table->integer('platform_fee')->default(0);
    $table->integer('total_bayar');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
