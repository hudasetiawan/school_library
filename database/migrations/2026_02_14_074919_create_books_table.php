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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 50)->unique();
            $table->string('judul');
            $table->string('slug')->unique(); // Penting untuk performa URL katalog
            $table->string('penulis');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->foreignId('category_id')->constrained()->restrictOnDelete(); // Relasi ke tabel categories
            $table->integer('total_eksemplar')->default(0); // Total fisik yang tercatat
            $table->integer('stok_tersedia')->default(0); // Real-time jumlah di rak
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
