<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@fotokita.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Demo Users ─────────────────────────────────────
        $users = [
            ['name' => 'Budi Santoso',    'email' => 'budi@fotokita.com'],
            ['name' => 'Sari Dewi',       'email' => 'sari@fotokita.com'],
            ['name' => 'Rizky Pratama',   'email' => 'rizky@fotokita.com'],
        ];

        foreach ($users as $data) {
            User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]);
        }

        // ── Activity Logs ──────────────────────────────────
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            ActivityLog::create([
                'user_id'     => $user->id,
                'action'      => 'register',
                'description' => 'User mendaftar akun.',
                'ip_address'  => '127.0.0.1',
                'created_at'  => now()->subDays(rand(1, 10)),
                'updated_at'  => now()->subDays(rand(1, 10)),
            ]);

            ActivityLog::create([
                'user_id'     => $user->id,
                'action'      => 'login',
                'description' => 'User login berhasil.',
                'ip_address'  => '127.0.0.1',
                'created_at'  => now()->subHours(rand(1, 24)),
                'updated_at'  => now()->subHours(rand(1, 24)),
            ]);
        }

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('─────────────────────────────────────────');
        $this->command->info('👤 Admin   : admin@fotokita.com / password');
        $this->command->info('👤 User 1  : budi@fotokita.com  / password');
        $this->command->info('👤 User 2  : sari@fotokita.com  / password');
        $this->command->info('👤 User 3  : rizky@fotokita.com / password');
        $this->command->info('─────────────────────────────────────────');
    }
}
