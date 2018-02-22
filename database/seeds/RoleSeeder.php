<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Administrator can do everything',
            ],
            [
                'name' => 'tester',
                'display_name' => 'Tester',
                'description' => 'Basic tester',
            ],
            [
                'name' => 'ingester',
                'display_name' => 'Ingestion team',
                'description' => 'Developers from ingestion team',
            ],
            [
                'name' => 'hr',
                'display_name' => 'HR manager',
                'description' => 'HR manager',
            ],
        ]);
    }
}
