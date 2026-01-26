<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user via wizard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('--- CREATE NEW ADMIN ACCOUNT ---');

        $name = $this->ask('Enter Full Name');
        $email = $this->ask('Enter Email Address');
        
        // Check if email exists
        if (User::where('email', $email)->exists()) {
            $this->error('Error: This email is already registered!');
            return;
        }

        $password = $this->secret('Enter Password (typing will be hidden)');
        $confirm = $this->secret('Confirm Password');

        if ($password !== $confirm) {
            $this->error('Error: Passwords do not match!');
            return;
        }

        // Create the user
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin', // Force role to admin
            // Add dummy data for required fields if needed
            'section' => null,
            'department' => 'IT Department' 
        ]);

        $this->info('Success! Admin account created.');
        $this->info("Login with: $email");
    }
}