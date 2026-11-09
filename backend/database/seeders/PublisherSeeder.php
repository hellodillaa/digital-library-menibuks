<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('publishers')->insert([
            [
                'name' => 'Gramedia Pustaka Utama',
                'address' => 'Jakarta',
                'phone' => '02153650110',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Republika Penerbit',
                'address' => 'Jakarta Selatan',
                'phone' => '0217819127',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}