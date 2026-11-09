<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            AuthorSeeder::class,
            PublisherSeeder::class,
            MemberSeeder::class,
            BookSeeder::class,
        ]);
    }
}