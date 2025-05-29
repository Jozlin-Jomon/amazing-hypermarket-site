<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@gmail.com')], // Unique key
            [
                'first_name'    => 'Amazing',
                'last_name'     => 'Admin',
                'email'         => env('ADMIN_EMAIL', 'admin@gmail.com'),
                'phone'         => '1234567890',
                'password'      => Hash::make(env('ADMIN_PASSWORD', 'defaultPass123')), 
                'usertype'      => 'admin',
                'status'        => '1',
            ]
        );
        $this->command->info('Admin user created or updated: ' . $admin->email);
    }
}
