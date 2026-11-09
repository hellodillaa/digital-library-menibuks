<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul buku
            $table->string('isbn')->unique(); // Kode ISBN
            
            // Relasi ke tabel authors dan publishers
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('cascade');
            
            $table->string('category')->nullable(); // Kategori / genre buku
            $table->integer('stock')->default(0); // Stok total buku
            $table->integer('available_stock')->default(0); // Stok yang masih tersedia
            $table->year('published_year')->nullable(); // Tahun terbit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};