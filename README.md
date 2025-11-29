 Medical Appointment Management System

A web-based medical appointment management system built with Laravel and React.

 Features

- Patient and medical professional registration
- Appointment booking and management
- Medical records management
- Prescription tracking
- Multi-language support (English, French, Arabic)
- Role-based access control

 Technology Stack

Backend
- Laravel 12
- MySQL
- Laravel Sanctum for API authentication
- Spatie Laravel Permission

Frontend
- React 18
- React Router
- Axios
- i18next for internationalization
- Vite

 Installation

 Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 16 or higher
- MySQL

 Backend Setup

1. Clone the repository
bash
git clone <repository-url>
cd medical-system


2. Install PHP dependencies
bash
composer install


3. Configure environment
bash
cp .env.example .env


Edit .env and set your database credentials:

DB_DATABASE=medical_appointments
DB_USERNAME=root
DB_PASSWORD=your_password


4. Generate application key
bash
php artisan key:generate


5. Run migrations and seed database
bash
php artisan migrate
php artisan db:seed


6. Start the backend server
bash
php artisan serve


The API will be available at http://localhost:8000

 Frontend Setup

1. Navigate to frontend directory
bash
cd frontend


2. Install dependencies
bash
npm install


3. Start development server
bash
npm run dev


The application will be available at http://localhost:5173

 Default Test Accounts

After seeding the database, you can use these accounts:

- Admin: admin@example.com / test1234
- Doctor: test.professional@example.com / test1234
- Patient: test.patient@example.com / test1234

 API Documentation

The API is accessible at http://localhost:8000/api

Key endpoints:
- POST /api/auth/login - User login
- POST /api/auth/register - User registration
- GET /api/doctors - List all doctors
- POST /api/patient/appointments - Book appointment
- GET /api/patient/appointments - View appointments