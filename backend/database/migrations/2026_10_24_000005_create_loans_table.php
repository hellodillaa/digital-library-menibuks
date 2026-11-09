<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel books dan members
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            
            $table->date('loan_date'); // Tanggal pinjam
            $table->date('due_date'); // Tanggal harus kembali
            $table->date('return_date')->nullable(); // Tanggal benar-benar dikembalikan
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed'); // Status buku
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};