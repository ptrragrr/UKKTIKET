<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained('tikets')->onDelete('cascade'); // relasi ke master tiket
            $table->integer('jumlah');        // jumlah tiket yang dibeli
            $table->integer('harga_satuan');  // harga per tiket
            $table->integer('total_harga');   // total harga per baris detail
           $table->string('kode_tiket', 20)->nullable()->after('total_harga'); // kode unik untuk barcode/QR
            $table->boolean('is_used')->default(false); // apakah sudah dipakai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_details');
    }
};
