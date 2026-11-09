<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authors')->insert([
            [
                'name' => 'J.K. Rowling',
                'bio' => 'Penulis seri Harry Potter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tere Liye',
                'bio' => 'Penulis novel terkenal Indonesia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rick Riordan',
                'bio' => 'Penulis seri Percy Jackson',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}