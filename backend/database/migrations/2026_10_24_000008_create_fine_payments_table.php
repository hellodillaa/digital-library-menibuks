<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fine_payments', function (Blueprint $table) {
            $table->id();

            // Satu pengembalian boleh memiliki 0 atau lebih pembayaran denda
            $table->foreignId('book_return_id')->constrained('book_returns')->onDelete('cascade');

            $table->date('payment_date'); // Tanggal bayar
            $table->unsignedInteger('amount'); // Jumlah bayar
            $table->string('method')->nullable(); // Metode pembayaran
            $table->enum('status', ['Lunas', 'Belum Lunas'])->default('Lunas'); // Status pembayaran

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fine_payments');
    }
};
