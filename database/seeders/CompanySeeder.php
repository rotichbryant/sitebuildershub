<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'id'       => Str::uuid(),
            'address'  => "Nairobi, Kenya",
            'name'     => "Test Company",
            'email'    => "test@example.com",
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s')
        ]);
    }
}
