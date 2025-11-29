<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MedicalProfessional;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            // Cardiologists
            [
                'first_name' => 'Ahmed',
                'last_name' => 'Benali',
                'email' => 'ahmed.benali@mawidi.com',
                'specialization' => 'Cardiology',
                'rpps_number' => 'RPPS10001',
                'qualifications' => 'MD, FACC, Cardiology Specialist',
                'work_address' => '123 Medical Plaza, Agadir, Morocco',
                'consultation_duration' => 30,
                'consultation_price' => 500.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic', 'English'],
                'accepted_insurance' => ['CNSS', 'CNOPS', 'Private'],
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Alami',
                'email' => 'sarah.alami@mawidi.com',
                'specialization' => 'Cardiology',
                'rpps_number' => 'RPPS10002',
                'qualifications' => 'MD, PhD in Cardiology',
                'work_address' => '456 Heart Center, Agadir, Morocco',
                'consultation_duration' => 30,
                'consultation_price' => 550.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic'],
                'accepted_insurance' => ['CNSS', 'CNOPS'],
            ],
            
            // Neurologists
            [
                'first_name' => 'Karim',
                'last_name' => 'Tazi',
                'email' => 'karim.tazi@mawidi.com',
                'specialization' => 'Neurology',
                'rpps_number' => 'RPPS10003',
                'qualifications' => 'MD, Neurology Specialist',
                'work_address' => '789 Neuro Clinic, Agadir, Morocco',
                'consultation_duration' => 45,
                'consultation_price' => 600.00,
                'is_teleconsultation_available' => false,
                'spoken_languages' => ['French', 'Arabic', 'English'],
                'accepted_insurance' => ['CNSS', 'CNOPS', 'Private'],
            ],
            [
                'first_name' => 'Leila',
                'last_name' => 'Mansouri',
                'email' => 'leila.mansouri@mawidi.com',
                'specialization' => 'Neurology',
                'rpps_number' => 'RPPS10004',
                'qualifications' => 'MD, PhD, Neurologist',
                'work_address' => '321 Brain Institute, Agadir, Morocco',
                'consultation_duration' => 45,
                'consultation_price' => 650.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic'],
                'accepted_insurance' => ['CNOPS', 'Private'],
            ],
            
            // Pediatricians
            [
                'first_name' => 'Omar',
                'last_name' => 'Benjelloun',
                'email' => 'omar.benjelloun@mawidi.com',
                'specialization' => 'Pediatrics',
                'rpps_number' => 'RPPS10005',
                'qualifications' => 'MD, Pediatrics Specialist',
                'work_address' => '555 Children Hospital, Agadir, Morocco',
                'consultation_duration' => 20,
                'consultation_price' => 350.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic', 'English'],
                'accepted_insurance' => ['CNSS', 'CNOPS', 'Private'],
            ],
            [
                'first_name' => 'Fatima',
                'last_name' => 'Zahra',
                'email' => 'fatima.zahra@mawidi.com',
                'specialization' => 'Pediatrics',
                'rpps_number' => 'RPPS10006',
                'qualifications' => 'MD, Child Health Specialist',
                'work_address' => '777 Kids Clinic, Agadir, Morocco',
                'consultation_duration' => 20,
                'consultation_price' => 300.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic'],
                'accepted_insurance' => ['CNSS', 'CNOPS'],
            ],
            
            // Dermatologists
            [
                'first_name' => 'Rachid',
                'last_name' => 'Chakib',
                'email' => 'rachid.chakib@mawidi.com',
                'specialization' => 'Dermatology',
                'rpps_number' => 'RPPS10007',
                'qualifications' => 'MD, Dermatology & Aesthetics',
                'work_address' => '888 Skin Care Center, Agadir, Morocco',
                'consultation_duration' => 30,
                'consultation_price' => 400.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic', 'English'],
                'accepted_insurance' => ['CNSS', 'CNOPS', 'Private'],
            ],
            [
                'first_name' => 'Nadia',
                'last_name' => 'Senhaji',
                'email' => 'nadia.senhaji@mawidi.com',
                'specialization' => 'Dermatology',
                'rpps_number' => 'RPPS10008',
                'qualifications' => 'MD, Dermatology Specialist',
                'work_address' => '999 Derma Clinic, Agadir, Morocco',
                'consultation_duration' => 30,
                'consultation_price' => 450.00,
                'is_teleconsultation_available' => false,
                'spoken_languages' => ['French', 'Arabic'],
                'accepted_insurance' => ['CNOPS', 'Private'],
            ],
            
            // General Practitioners
            [
                'first_name' => 'Hassan',
                'last_name' => 'Idrissi',
                'email' => 'hassan.idrissi@mawidi.com',
                'specialization' => 'General Practice',
                'rpps_number' => 'RPPS10009',
                'qualifications' => 'MD, General Practitioner',
                'work_address' => '111 Family Health Center, Agadir, Morocco',
                'consultation_duration' => 20,
                'consultation_price' => 200.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic', 'English'],
                'accepted_insurance' => ['CNSS', 'CNOPS', 'Private'],
            ],
            [
                'first_name' => 'Amina',
                'last_name' => 'Filali',
                'email' => 'amina.filali@mawidi.com',
                'specialization' => 'General Practice',
                'rpps_number' => 'RPPS10010',
                'qualifications' => 'MD, Family Medicine',
                'work_address' => '222 Community Clinic, Agadir, Morocco',
                'consultation_duration' => 20,
                'consultation_price' => 180.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic'],
                'accepted_insurance' => ['CNSS', 'CNOPS'],
            ],
            [
                'first_name' => 'Youssef',
                'last_name' => 'Berrada',
                'email' => 'youssef.berrada@mawidi.com',
                'specialization' => 'General Practice',
                'rpps_number' => 'RPPS10011',
                'qualifications' => 'MD, General Medicine',
                'work_address' => '333 Health Center, Agadir, Morocco',
                'consultation_duration' => 20,
                'consultation_price' => 220.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic', 'English'],
                'accepted_insurance' => ['CNSS', 'CNOPS', 'Private'],
            ],
            
            // ENT Specialists
            [
                'first_name' => 'Mehdi',
                'last_name' => 'Lahlou',
                'email' => 'mehdi.lahlou@mawidi.com',
                'specialization' => 'ENT',
                'rpps_number' => 'RPPS10012',
                'qualifications' => 'MD, ENT Specialist',
                'work_address' => '444 ENT Center, Agadir, Morocco',
                'consultation_duration' => 30,
                'consultation_price' => 400.00,
                'is_teleconsultation_available' => false,
                'spoken_languages' => ['French', 'Arabic', 'English'],
                'accepted_insurance' => ['CNSS', 'CNOPS', 'Private'],
            ],
            [
                'first_name' => 'Samira',
                'last_name' => 'Bennani',
                'email' => 'samira.bennani@mawidi.com',
                'specialization' => 'ENT',
                'rpps_number' => 'RPPS10013',
                'qualifications' => 'MD, Otolaryngology',
                'work_address' => '666 Hearing Clinic, Agadir, Morocco',
                'consultation_duration' => 30,
                'consultation_price' => 380.00,
                'is_teleconsultation_available' => true,
                'spoken_languages' => ['French', 'Arabic'],
                'accepted_insurance' => ['CNOPS', 'Private'],
            ],
        ];

        foreach ($doctors as $doctor) {
            $user = User::create([
                'first_name' => $doctor['first_name'],
                'last_name' => $doctor['last_name'],
                'email' => $doctor['email'],
                'password' => Hash::make('password123'),
                'phone' => '+212' . rand(600000000, 699999999),
                'address' => $doctor['work_address'],
                'user_type' => 'professional',
            ]);

            MedicalProfessional::create([
                'user_id' => $user->id,
                'specialization' => $doctor['specialization'],
                'rpps_number' => $doctor['rpps_number'],
                'qualifications' => $doctor['qualifications'],
                'work_address' => $doctor['work_address'],
                'consultation_duration' => $doctor['consultation_duration'],
                'consultation_price' => $doctor['consultation_price'],
                'is_teleconsultation_available' => $doctor['is_teleconsultation_available'],
                'spoken_languages' => $doctor['spoken_languages'],
                'accepted_insurance' => $doctor['accepted_insurance'],
            ]);
        }

        $this->command->info('Created ' . count($doctors) . ' doctors successfully!');
    }
}
