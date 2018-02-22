<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        try {
            $this->call([
                RoleSeeder::class,
                PermissionSeeder::class,
                PermissionRoleSeeder::class,
                RoleUserSeeder::class,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            echo 'An error occurred while seeding ' . __CLASS__ . PHP_EOL;
            echo $e->getMessage() . PHP_EOL;
            die;
        }

        DB::commit();
    }
}
