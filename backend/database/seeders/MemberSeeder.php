<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('members')->insert([
            [
                'member_code' => 'MEM001',
                'name'        => 'Dilla',
                'email'       => 'heydel@gmail.com',
                'phone'       => '08123456789',
                'address'     => 'Banda Aceh',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'member_code' => 'MEM002',
                'name'        => 'Salsabila',
                'email'       => 'haisalsal@gmail.com',
                'phone'       => '08987654321',
                'address'     => 'Banda Aceh',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}