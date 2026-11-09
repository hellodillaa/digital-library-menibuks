<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_returns', function (Blueprint $table) {
            $table->id();

            // Satu peminjaman hanya boleh dikembalikan satu kali (unique)
            $table->foreignId('loan_id')->unique()->constrained('loans')->onDelete('cascade');
            // Admin yang memproses pengembalian
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');

            $table->date('return_date'); // Tanggal pengembalian
            $table->unsignedInteger('fine_amount')->default(0); // Denda (0 jika tidak ada)
            $table->enum('book_condition', ['Baik', 'Rusak', 'Hilang'])->default('Baik'); // Kondisi buku

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_returns');
    }
};
