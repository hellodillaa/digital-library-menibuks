<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title'          => 'Harry Potter and the Sorcerer Stone',
                'isbn'           => '9780590353403',
                'author_id'      => 1, // J.K. Rowling
                'publisher_id'   => 1,
                'category'       => 'Fantasy',
                'stock'          => 10,
                'available_stock' => 10,
                'published_year' => 1997,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'title'          => 'Percy Jackson & The Olympians - The Lightning Thief',
                'isbn'           => '9780786838654',
                'author_id'      => 3, // Rick Riordan
                'publisher_id'   => 2,
                'category'       => 'Mythology',
                'stock'          => 8,
                'available_stock' => 8,
                'published_year' => 2005,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}