<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class CustomAdminSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create Hamza admin
        $hamzaUser = User::create([
            'first_name' => 'Hamza',
            'last_name' => 'Admin',
            'email' => 'hamza@mawidi.com',
            'password' => Hash::make('hamza9999'),
            'phone' => '+212600000001',
            'address' => 'Mawidi Headquarters',
            'user_type' => 'administrator',
            'email_verified_at' => now(),
        ]);

        Administrator::create([
            'user_id' => $hamzaUser->id,
            'department' => 'IT & Systems',
            'hire_date' => now()->subYears(2),
            'permissions_level' => 'high',
        ]);

        // Create Reda admin
        $redaUser = User::create([
            'first_name' => 'Reda',
            'last_name' => 'Admin',
            'email' => 'reda@mawidi.com',
            'password' => Hash::make('reda9999'),
            'phone' => '+212600000002',
            'address' => 'Mawidi Headquarters',
            'user_type' => 'administrator',
            'email_verified_at' => now(),
        ]);

        Administrator::create([
            'user_id' => $redaUser->id,
            'department' => 'Operations',
            'hire_date' => now()->subYears(1),
            'permissions_level' => 'high',
        ]);

        $this->command->info('✓ Created administrators: hamza@mawidi.com and reda@mawidi.com');
    }
}
