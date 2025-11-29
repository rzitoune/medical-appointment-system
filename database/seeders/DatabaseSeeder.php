<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DoctorSeeder::class,
            SecretarySeeder::class,
            PatientSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('====================================');
        $this->command->info('Mawidi System - Test Data Created!');
        $this->command->info('====================================');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('------------------');
        $this->command->info('Admin: admin@mawidi.com / admin123');
        $this->command->info('Secretary: secretary@mawidi.com / secretary123');
        $this->command->info('Patient: patient1@mawidi.com / password123');
        $this->command->info('');
        $this->command->info('All doctors: password123');
        $this->command->info('====================================');
    }
}
