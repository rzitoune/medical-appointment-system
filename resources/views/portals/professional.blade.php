@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Professional Portal</h5>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="#" onclick="loadSection('dashboard')">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" onclick="loadSection('appointments')">My Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" onclick="loadSection('availability')">Availability</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" onclick="loadSection('records')">Patient Records</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" onclick="logout()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div id="content">
                <div class="alert alert-info">Welcome to Professional Portal</div>
            </div>
        </div>
    </div>
</div>

<script>
const token = localStorage.getItem('token');

function loadSection(section) {
    const content = document.getElementById('content');
    
    if (!token) {
        content.innerHTML = '<div class="alert alert-danger">Please login first</div>';
        return;
    }

    switch(section) {
        case 'dashboard':
            content.innerHTML = `
                <h2>Professional Dashboard</h2>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3>--</h3>
                                <p>Today's Appointments</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3>--</h3>
                                <p>Total Patients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3>--</h3>
                                <p>Pending Appointments</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            break;
        case 'appointments':
            content.innerHTML = '<h2>My Appointments</h2><div class="alert alert-info">Appointments will appear here</div>';
            break;
        case 'availability':
            content.innerHTML = '<h2>Manage Availability</h2><div class="alert alert-info">Set your working hours here</div>';
            break;
        case 'records':
            content.innerHTML = '<h2>Patient Records</h2><div class="alert alert-info">Patient medical records will appear here</div>';
            break;
    }
}

function logout() {
    localStorage.removeItem('token');
    window.location.href = '{{ route("home") }}';
}

// Load dashboard on page load
window.addEventListener('load', () => loadSection('dashboard'));
</script>
@endsection
