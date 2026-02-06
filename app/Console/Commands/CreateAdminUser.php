<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make {email} {--name=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an existing user an admin or create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->option('name');
        $password = $this->option('password');

        // Try to find existing user
        $user = User::where('email', $email)->first();

        if ($user) {
            // User exists, update their role to admin
            $user->role = 'admin';
            $user->save();

            $this->info("User '{$user->name}' ({$email}) has been made an admin successfully!");
            return;
        }

        // User doesn't exist, create a new admin user
        if (!$name) {
            $name = $this->ask('Enter the name for the new admin user');
        }

        if (!$password) {
            $password = $this->secret('Enter password for the new admin user');
        }

        if (!$password) {
            $this->error('Password is required to create a new user.');
            return;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'role' => 'admin',
                'status' => 'active',
            ]);

            $this->info("New admin user '{$name}' ({$email}) has been created successfully!");
        } catch (\Exception $e) {
            $this->error("Failed to create admin user: " . $e->getMessage());
        }
    }
}
