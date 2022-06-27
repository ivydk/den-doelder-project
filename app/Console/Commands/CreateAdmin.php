<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // email address is taken as an argument
        $email = $this->argument('email');

        // ask for the username
        $name = $this->ask('What is your name?');

        // ask for password and confirmation
        $password = $this->secret('What is the password?');
        $password_confirm = $this->secret('Confirm the password');

        if ($password == $password_confirm) {
            $this->createUser($email, $name, $password);
        } else {
            $this->error('Passwords do not match');
        }
    }

    /**
     * @param $email
     * @param $name
     * @param $password
     */
    private function createUser($email, $name, $password): void
    {
        $user = User::create([
            'email' => $email,
            'name' => $name,
            'language' => 'en',
            'role' => 'admin',
            'password' => Hash::make($password)
        ]);
        // Do stuff here to make the user an admin user
        $user->save();
        $this->info("Admin user $user->name is created");
    }
}
