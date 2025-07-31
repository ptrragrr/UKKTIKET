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
        Schema::create('transaksi_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
    $table->foreignId('tiket_id')->constrained('tikets')->onDelete('cascade');
    $table->integer('jumlah');
    $table->integer('harga_satuan'); // disimpan agar tidak berubah jika harga tiket diubah
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_items');
    }
};
