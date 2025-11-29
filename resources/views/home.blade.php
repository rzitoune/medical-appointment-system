<!DOCTYPE html>
<html>
<head>
    <title>Medical System</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">Medical Appointment System</h1>
                    <p class="lead mt-3">Streamline healthcare appointments and patient management</p>
                    <div class="mt-4">
                        <a href="#get-started" class="btn btn-light btn-lg me-2">Learn More</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Get Started</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div style="font-size: 80px;">🏥</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Key Features</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size: 50px; margin-bottom: 15px;">📅</div>
                            <h5 class="card-title">Easy Scheduling</h5>
                            <p class="card-text">Book and manage appointments easily with real-time availability</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size: 50px; margin-bottom: 15px;">👨‍⚕️</div>
                            <h5 class="card-title">Professional Network</h5>
                            <p class="card-text">Connect with verified medical professionals in your area</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size: 50px; margin-bottom: 15px;">📋</div>
                            <h5 class="card-title">Medical Records</h5>
                            <p class="card-text">Secure storage and management of medical records</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size: 50px; margin-bottom: 15px;">💊</div>
                            <h5 class="card-title">Prescriptions</h5>
                            <p class="card-text">Digital prescription management and tracking</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size: 50px; margin-bottom: 15px;">🔔</div>
                            <h5 class="card-title">Notifications</h5>
                            <p class="card-text">Instant reminders for appointments and updates</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size: 50px; margin-bottom: 15px;">🔒</div>
                            <h5 class="card-title">Secure & Private</h5>
                            <p class="card-text">HIPAA-compliant data protection and privacy</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="get-started" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Get Started</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">👤 For Patients</h5>
                            <p class="card-text">Register as a patient, search for doctors, and book appointments</p>
                            <a href="{{ route('register') }}" class="btn btn-primary">Register as Patient</a>
                            <a href="{{ route('patient-portal') }}" class="btn btn-outline-primary">Patient Portal</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">👨‍⚕️ For Medical Professionals</h5>
                            <p class="card-text">Create your profile, manage availability, and connect with patients</p>
                            <a href="{{ route('register') }}" class="btn btn-primary">Register as Professional</a>
                            <a href="{{ route('professional-portal') }}" class="btn btn-outline-primary">Professional Portal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
</body>
</html>
