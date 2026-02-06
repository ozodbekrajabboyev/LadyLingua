<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class TestAdminAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:admin-access {email?} {--create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test admin access and create admin user if needed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@ladylingo.uz';

        $this->info('=== Admin Access Test ===');
        $this->info('Environment: ' . config('app.env'));
        $this->info('Debug Mode: ' . (config('app.debug') ? 'ON' : 'OFF'));
        $this->info('Session Driver: ' . config('session.driver'));
        $this->info('Cache Driver: ' . config('cache.default'));
        $this->newLine();

        // Check if admin user exists
        $admin = User::where('email', $email)->first();

        if (!$admin) {
            if ($this->option('create') || $this->confirm("Admin user not found. Create one?")) {
                $password = 'admin123';

                $admin = User::create([
                    'name' => 'System Admin',
                    'email' => $email,
                    'phone_number' => '901234567',
                    'password' => Hash::make($password),
                    'role' => 'admin',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]);

                $this->info('✅ Admin user created successfully!');
                $this->info("Email: {$email}");
                $this->info("Password: {$password}");
            } else {
                $this->error('❌ Admin user not found and not created.');
                return 1;
            }
        } else {
            $this->info('✅ Admin user found:');
            $this->info("ID: {$admin->id}");
            $this->info("Name: {$admin->name}");
            $this->info("Email: {$admin->email}");
            $this->info("Role: {$admin->role}");
            $this->info("Status: {$admin->status}");

            // Ensure user is admin and active
            if ($admin->role !== 'admin') {
                $admin->update(['role' => 'admin']);
                $this->info('✅ Updated user role to admin');
            }

            if ($admin->status !== 'active') {
                $admin->update(['status' => 'active']);
                $this->info('✅ Updated user status to active');
            }
        }

        $this->newLine();
        $this->info('=== Environment Check ===');

        // Check important configurations
        $checks = [
            'Session table exists' => $this->checkSessionTable(),
            'Cache table exists' => $this->checkCacheTable(),
            'Admin middleware registered' => class_exists(\App\Http\Middleware\AdminAccess::class),
            'Filament installed' => class_exists(\Filament\Panel::class),
        ];

        foreach ($checks as $check => $result) {
            $status = $result ? '✅' : '❌';
            $this->info("{$status} {$check}");
        }

        $this->newLine();
        $this->info('🔗 Admin Panel URL: ' . config('app.url') . '/platform');

        return 0;
    }

    private function checkSessionTable(): bool
    {
        try {
            return \Schema::hasTable('sessions');
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkCacheTable(): bool
    {
        try {
            return \Schema::hasTable('cache');
        } catch (\Exception $e) {
            return false;
        }
    }
}
