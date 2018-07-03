<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
        try {
            // Get default permissions
            $allPerms = Permission::all();

            $createUsers = Permission::whereName('create-users')->firstOrFail();
            $editUsers = Permission::whereName('edit-users')->firstOrFail();
            $deleteUsers = Permission::whereName('delete-users')->firstOrFail();
            $runTools = Permission::whereName('run-tools')->firstOrFail();
            $viewTools = Permission::whereName('view-tools')->firstOrFail();
            $basicSearch = Permission::whereName('basic-search')->firstOrFail();
            $brightcoveSearch = Permission::whereName('brightcove-search')->firstOrFail();
            $viewNotifications = Permission::whereName('view-notifications')->firstOrFail();
            $deleteNotifications = Permission::whereName('delete-notifications')->firstOrFail();

            // Get default roles
            $admin = Role::whereName('admin')->firstOrFail();
            $tester = Role::whereName('tester')->firstOrFail();
            $ingester = Role::whereName('ingester')->firstOrFail();
            $pm = Role::whereName('pm')->firstOrFail();

            // Attach permissions to roles
            $admin->attachPermissions($allPerms);

            $tester->attachPermissions([$basicSearch]);

            $ingester->attachPermissions([
                $createUsers,
                $editUsers,
                $deleteUsers,
                $runTools,
                $viewTools,
                $basicSearch,
                $brightcoveSearch,
                $viewNotifications,
                $deleteNotifications
            ]);

            $pm->attachPermissions([
                $createUsers,
                $editUsers,
                $deleteUsers,
                $basicSearch,
                $brightcoveSearch,
                $viewNotifications
            ]);
        } catch (\Exception $e) {
            echo 'An error occurred. Please check if the permissions and roles were seeded before.' . PHP_EOL;
            echo $e->getMessage() . PHP_EOL;

            throw new Exception(__FILE__);
        }
    }
}
