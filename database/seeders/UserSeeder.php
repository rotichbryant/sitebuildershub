<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = DB::table('companies')->first();
        $role    = DB::table('roles')->where('state',0)->first();

        DB::table('users')->insert([
            'id'                => Str::uuid(),
            'company_id'        => $company->id,
            'first_name'        => "Admin",
            'last_name'         => "User",
            'email'             => "info@hostgram.co.ke",
            'email_verified_at' => now()->format('Y-m-d H:i:s'),
            'password'          => Hash::make('password'),
            'role_id'           => $role->id,
            'created_at'        => now()->format('Y-m-d H:i:s'),
            'updated_at'        => now()->format('Y-m-d H:i:s')
        ]);
    }
}
