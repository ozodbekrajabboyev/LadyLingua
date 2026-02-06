<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        $adminEmail = 'admin@ladylingo.uz';

        $admin = User::where('email', $adminEmail)->first();

        if (!$admin) {
            User::create([
                'name' => 'LadyLingo Admin',
                'email' => $adminEmail,
                'phone_number' => '901234567',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            echo "Admin user created successfully!\n";
            echo "Email: {$adminEmail}\n";
            echo "Password: password123\n";
        } else {
            // Update existing user to ensure it's admin
            $admin->update([
                'role' => 'admin',
                'status' => 'active',
            ]);

            echo "Admin user already exists and updated!\n";
            echo "Email: {$adminEmail}\n";
        }
    }
}
