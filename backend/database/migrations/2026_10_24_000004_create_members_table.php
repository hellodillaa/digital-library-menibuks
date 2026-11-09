<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique(); // Kode unik anggota
            $table->string('name'); // Nama lengkap anggota
            $table->string('email')->unique(); // Email
            $table->string('phone')->nullable(); // Nomor HP
            $table->text('address')->nullable(); // Alamat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};