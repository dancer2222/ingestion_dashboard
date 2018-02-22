<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([

            // Users
            [
                'name' => 'create-users',
                'display_name' => 'Create users',
                'description' => 'Can create new users.',
            ],
            [
                'name' => 'edit-users',
                'display_name' => 'Edit users',
                'description' => 'Can edit users.',
            ],
            [
                'name' => 'delete-users',
                'display_name' => 'Delete users',
                'description' => 'Can delete users.',
            ],

            // Tools
            [
                'name' => 'run-tools',
                'display_name' => 'Run tools',
                'description' => 'Can run tools of project_ingestion.',
            ],
            [
                'name' => 'view-tools',
                'display_name' => 'View tools',
                'description' => 'Can view tools of project_ingestion.',
            ],

            // Basic search
            [
                'name' => 'basic-search',
                'display_name' => 'Search',
                'description' => 'Can use the search.',
            ],

            // Brightcove
            [
                'name' => 'brightcove-search',
                'display_name' => 'Brightcove',
                'description' => 'Can use brightcove menu.',
            ],

            // Notifications
            [
                'name' => 'view-notifications',
                'display_name' => 'View notifications',
                'description' => 'Can view notifications.',
            ],
            [
                'name' => 'delete-notifications',
                'display_name' => 'Delete notifications',
                'description' => 'Can delete notifications and mark as read.',
            ],
        ]);
    }
}
