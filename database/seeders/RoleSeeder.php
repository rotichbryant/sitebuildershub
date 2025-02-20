<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = DB::table('companies')->first();

        DB::table('roles')->insert([
            'id'         => Str::uuid(),
            'company_id' => $company->id,
            'name'       => "admin",
            'state'      => 2,
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s')
        ]);
        DB::table('roles')->insert([
            'id'         => Str::uuid(),
            'company_id' => $company->id,
            'name'       => "staff",
            'state'      => 1,
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s')
        ]);
        DB::table('roles')->insert([
            'id'          => Str::uuid(),
            'company_id'  => $company->id,
            'name'        => "client",
            'state'       => 0,
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s')
        ]);
    }
}
