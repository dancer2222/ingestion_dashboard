<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('local')) {
            DB::table('users')->insert([
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.admin',
                    'password' => Hash::make(123123),
                ],
            ]);
        }
    }
}
