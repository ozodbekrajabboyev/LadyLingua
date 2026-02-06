<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = User::where('role', 'admin')->get();

        if ($admins->isEmpty()) {
            $this->info('No admin users found.');
            return;
        }

        $this->info('Current admin users:');
        $this->table(
            ['ID', 'Name', 'Email', 'Status', 'Created At'],
            $admins->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->status,
                    $user->created_at->format('Y-m-d H:i:s'),
                ];
            })
        );
    }
}
