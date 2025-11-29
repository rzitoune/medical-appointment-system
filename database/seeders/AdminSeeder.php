<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Mawidi',
            'email' => 'admin@mawidi.com',
            'password' => Hash::make('admin123'),
            'phone' => '+212600000001',
            'address' => 'Mawidi Headquarters, Casablanca',
            'user_type' => 'administrator',
        ]);

        Administrator::create([
            'user_id' => $user->id,
            'department' => 'System Administration',
            'hire_date' => now(),
            'permissions_level' => 'super_admin',
        ]);

        $this->command->info('Admin user created: admin@mawidi.com / admin123');
    }
}
