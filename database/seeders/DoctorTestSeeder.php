<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MedicalProfessional;
use App\Models\MedicalAvailability;
use Illuminate\Support\Facades\Hash;

class DoctorTestSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'first_name' => 'Dr. Sarah',
                'last_name' => 'Johnson',
                'email' => 'sarah.johnson@mawidi.com',
                'phone' => '+212600000010',
                'specialization' => 'Cardiology',
                'rpps_number' => 'RPPS001',
                'qualifications' => 'MD, FACC, Board Certified Cardiologist',
                'consultation_price' => 500.00,
            ],
            [
                'first_name' => 'Dr. Ahmed',
                'last_name' => 'El Amrani',
                'email' => 'ahmed.elamrani@mawidi.com',
                'phone' => '+212600000011',
                'specialization' => 'Pediatrics',
                'rpps_number' => 'RPPS002',
                'qualifications' => 'MD, Pediatric Specialist',
                'consultation_price' => 400.00,
            ],
            [
                'first_name' => 'Dr. Maria',
                'last_name' => 'Garcia',
                'email' => 'maria.garcia@mawidi.com',
                'phone' => '+212600000012',
                'specialization' => 'Dermatology',
                'rpps_number' => 'RPPS003',
                'qualifications' => 'MD, Dermatology Board Certified',
                'consultation_price' => 450.00,
            ],
            [
                'first_name' => 'Dr. Youssef',
                'last_name' => 'Benali',
                'email' => 'youssef.benali@mawidi.com',
                'phone' => '+212600000013',
                'specialization' => 'Orthopedics',
                'rpps_number' => 'RPPS004',
                'qualifications' => 'MD, Orthopedic Surgeon',
                'consultation_price' => 600.00,
            ],
            [
                'first_name' => 'Dr. Fatima',
                'last_name' => 'Zahra',
                'email' => 'fatima.zahra@mawidi.com',
                'phone' => '+212600000014',
                'specialization' => 'Gynecology',
                'rpps_number' => 'RPPS005',
                'qualifications' => 'MD, OB/GYN Specialist',
                'consultation_price' => 500.00,
            ],
            [
                'first_name' => 'Dr. Omar',
                'last_name' => 'Idrissi',
                'email' => 'omar.idrissi@mawidi.com',
                'phone' => '+212600000015',
                'specialization' => 'General Practice',
                'rpps_number' => 'RPPS006',
                'qualifications' => 'MD, Family Medicine',
                'consultation_price' => 300.00,
            ],
        ];

        foreach ($doctors as $doctorData) {
            $user = User::create([
                'first_name' => $doctorData['first_name'],
                'last_name' => $doctorData['last_name'],
                'email' => $doctorData['email'],
                'password' => Hash::make('doctor123'),
                'phone' => $doctorData['phone'],
                'address' => 'Medical Center, Casablanca',
                'user_type' => 'professional',
                'email_verified_at' => now(),
            ]);

            $professional = MedicalProfessional::create([
                'user_id' => $user->id,
                'specialization' => $doctorData['specialization'],
                'rpps_number' => $doctorData['rpps_number'],
                'qualifications' => $doctorData['qualifications'],
                'work_address' => 'Mawidi Medical Center, Boulevard Mohammed V, Casablanca',
                'consultation_duration' => 30,
                'consultation_price' => $doctorData['consultation_price'],
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic', 'English'],
                'accepted_insurance' => ['CNSS', 'CNOPS', 'Private Insurance'],
            ]);

            // Create availability (Monday to Friday, 9 AM - 5 PM)
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            foreach ($days as $day) {
                MedicalAvailability::create([
                    'professional_id' => $professional->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'is_available' => true,
                ]);
            }
        }

        $this->command->info('✓ Created 6 test doctors with availability schedules');
    }
}
