<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RevokeAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:revoke {email} {--to=user : Role to assign after revoking admin (user|translator)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke admin privileges from a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $newRole = $this->option('to');

        // Validate the new role
        if (!in_array($newRole, ['user', 'translator'])) {
            $this->error('Invalid role. Only "user" and "translator" are allowed.');
            return 1;
        }

        // Find the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        if ($user->role !== 'admin') {
            $this->warn("User '{$user->name}' ({$email}) is not an admin. Current role: {$user->role}");
            return 0;
        }

        // Ask for confirmation
        if (!$this->confirm("Are you sure you want to revoke admin privileges from '{$user->name}' ({$email})?")) {
            $this->info('Operation cancelled.');
            return 0;
        }

        // Update the user's role
        $user->role = $newRole;
        $user->save();

        $this->info("Admin privileges revoked from '{$user->name}' ({$email}). New role: {$newRole}");
        return 0;
    }
}
