<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $userAdmin = User::whereName('Admin')->firstOrFail();
            $roleAdmin = Role::whereName('admin')->firstOrFail();

            $userAdmin->attachRole($roleAdmin);
        } catch (Exception $e) {
            echo PHP_EOL . "Can't find user or role 'admin'. Please make sure if the both users and roles seeders were run before." . PHP_EOL . PHP_EOL;
            die;
        }
    }
}
