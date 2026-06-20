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
        Schema::create('lahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // pemilik lahan (relasi ke tabel users)
            $table->string('kota');                      // nama kota, dipakai Mhs 2 sebagai parameter API cuaca
            $table->enum('komoditas', ['padi', 'jagung']); // dipakai Mhs 3 untuk logika rekomendasi
            $table->decimal('luas_lahan', 8, 2);         // dalam satuan hektar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahans');
    }
};
