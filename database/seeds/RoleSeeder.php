<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    private $table = 'roles';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->delete();
        DB::table('role_user')->delete();
        DB::table($this->table)->delete();

        DB::table($this->table)->insert([
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
                'name' => 'pm',
                'display_name' => 'pm',
                'description' => 'Project manager',
            ],
        ]);
    }
}
