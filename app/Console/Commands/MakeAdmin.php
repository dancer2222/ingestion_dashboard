<?php

namespace App\Console\Commands;

use App\User;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->checkIfAdminAlreadyExist()) {
            $this->warn('Admin already created.');
            $this->warn('Please use existing credentials to access to app.');

            return;
        }

        $email = $this->ask('Email');
        $password = Hash::make($this->secret('Password'));

        try {
            $adminRole = Role::whereName('admin')->first();

            if (!$adminRole) {
                $this->error('Can\'t create admin. Admin role does not exist.');
                return;
            }

            $this->user->fill([
                'name' => 'Admin',
                'password' => $password,
                'email' => $email
            ]);

            $result = $this->user->save();

            $this->user->attachRole($adminRole);
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return;
        }

        if (!$result) {
            $this->error('An error occurred while creating user.');
        }

        $this->info('User has been successfully created!');
    }

    private function checkIfAdminAlreadyExist()
    {
        return User::whereName('Admin')->count();
    }
}
