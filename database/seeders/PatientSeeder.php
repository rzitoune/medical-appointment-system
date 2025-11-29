<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'first_name' => 'Mohammed',
                'last_name' => 'Alaoui',
                'email' => 'patient1@mawidi.com',
                'phone' => '+212611111111',
                'date_of_birth' => '1985-05-15',
                'gender' => 'male',
                'blood_type' => 'O+',
                'insurance_number' => 'INS001',
            ],
            [
                'first_name' => 'Khadija',
                'last_name' => 'Madani',
                'email' => 'patient2@mawidi.com',
                'phone' => '+212622222222',
                'date_of_birth' => '1990-08-22',
                'gender' => 'female',
                'blood_type' => 'A+',
                'insurance_number' => 'INS002',
            ],
            [
                'first_name' => 'Anas',
                'last_name' => 'Benjelloun',
                'email' => 'patient3@mawidi.com',
                'phone' => '+212633333333',
                'date_of_birth' => '2000-12-10',
                'gender' => 'male',
                'blood_type' => 'B+',
                'insurance_number' => 'INS003',
            ],
        ];

        foreach ($patients as $patient) {
            $user = User::create([
                'first_name' => $patient['first_name'],
                'last_name' => $patient['last_name'],
                'email' => $patient['email'],
                'password' => Hash::make('password123'),
                'phone' => $patient['phone'],
                'address' => 'Morocco',
                'user_type' => 'patient',
            ]);

            Patient::create([
                'user_id' => $user->id,
                'date_of_birth' => $patient['date_of_birth'],
                'gender' => $patient['gender'],
                'emergency_contact' => $patient['phone'],
                'blood_type' => $patient['blood_type'],
                'allergies' => [],
                'medical_history' => null,
                'insurance_number' => $patient['insurance_number'],
                'mutual_fund' => 'CNSS',
            ]);
        }

        $this->command->info('Created ' . count($patients) . ' test patients!');
    }
}
