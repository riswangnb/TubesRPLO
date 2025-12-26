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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('package_id')->nullable();
            
            // PERBAIKAN: Langsung set default(now()) di sini
            $table->date('tanggal_order')->default(now());
            
            // Default 0 sudah benar
            $table->decimal('total_harga', 10, 2)->default(0);
            
            $table->decimal('berat', 8, 2)->nullable();
            
            // Default 'pending' sudah benar
            $table->enum('status', ['pending', 'proses', 'selesai', 'diambil'])->default('pending');
            
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};