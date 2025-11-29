<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Secretary;
use App\Models\MedicalProfessional;
use Illuminate\Support\Facades\Hash;

class SecretarySeeder extends Seeder
{
    public function run(): void
    {
        // Get first professional for assignment
        $professional = MedicalProfessional::first();

        $user = User::create([
            'first_name' => 'Samia',
            'last_name' => 'Tahiri',
            'email' => 'secretary@mawidi.com',
            'password' => Hash::make('secretary123'),
            'phone' => '+212600000002',
            'address' => 'Medical Center, Casablanca',
            'user_type' => 'secretary',
        ]);

        Secretary::create([
            'user_id' => $user->id,
            'professional_id' => $professional ? $professional->id : null,
            'department' => 'Reception & Appointments',
            'hire_date' => now(),
        ]);

        $this->command->info('Secretary user created: secretary@mawidi.com / secretary123');
    }
}
