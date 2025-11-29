<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientTestSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'first_name' => 'Mohammed',
                'last_name' => 'Alami',
                'email' => 'mohammed.alami@example.com',
                'phone' => '+212600000020',
                'date_of_birth' => '1990-05-15',
                'gender' => 'Male',
                'blood_type' => 'A+',
            ],
            [
                'first_name' => 'Khadija',
                'last_name' => 'Bennani',
                'email' => 'khadija.bennani@example.com',
                'phone' => '+212600000021',
                'date_of_birth' => '1985-08-22',
                'gender' => 'Female',
                'blood_type' => 'O+',
            ],
            [
                'first_name' => 'Rachid',
                'last_name' => 'El Fassi',
                'email' => 'rachid.elfassi@example.com',
                'phone' => '+212600000022',
                'date_of_birth' => '1995-03-10',
                'gender' => 'Male',
                'blood_type' => 'B+',
            ],
        ];

        foreach ($patients as $patientData) {
            $user = User::create([
                'first_name' => $patientData['first_name'],
                'last_name' => $patientData['last_name'],
                'email' => $patientData['email'],
                'password' => Hash::make('patient123'),
                'phone' => $patientData['phone'],
                'address' => 'Casablanca, Morocco',
                'user_type' => 'patient',
                'email_verified_at' => now(),
            ]);

            Patient::create([
                'user_id' => $user->id,
                'date_of_birth' => $patientData['date_of_birth'],
                'gender' => $patientData['gender'],
                'blood_type' => $patientData['blood_type'],
                'emergency_contact' => '+212600000099',
                'insurance_number' => 'INS' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                'mutual_fund' => 'CNSS',
            ]);
        }

        $this->command->info('✓ Created 3 test patients');
    }
}
