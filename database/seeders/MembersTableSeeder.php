<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('members')->insert([
            [
                'code' => 'M001',
                'name' => 'Angga',
                'finalty' => true
            ],
            [
                'code' => 'M002',
                'name' => 'Ferry',
                'finalty' => false
            ],
            [
                'code' => 'M003',
                'name' => 'Putri',
                'finalty' => false
            ]
        ]);
    }
}
