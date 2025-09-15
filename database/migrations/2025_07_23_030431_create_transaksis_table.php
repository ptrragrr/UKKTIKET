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
            $table->string('nama_pembeli');
            $table->string('email');
            $table->string('nomer_telpon');
            $table->string('kode_transaksi')->unique();
            $table->enum('status_payment', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->integer('total_harga'); // ✅ tambahan total harga
            // $table->string('kode_tiket', 20)->nullable()->after('total_harga');
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
