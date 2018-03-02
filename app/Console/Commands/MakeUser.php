<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

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
            $result = $this->user->fill([
                'name' => 'Admin',
                'password' => $password,
                'email' => $email
            ])->save();
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return;
        }

        if (!$result) {
            $this->error('An error occurred while creating user.');
        }

        $this->info('User has been successfully created!');

        return;
    }

    private function checkIfAdminAlreadyExist()
    {
        $admin = User::whereName('Admin')->first();

        return $admin;
    }
}
