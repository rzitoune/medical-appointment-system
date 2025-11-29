@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Patient Portal</h5>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="#" onclick="loadSection('dashboard')">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" onclick="loadSection('appointments')">My Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" onclick="loadSection('professionals')">Find Doctor</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" onclick="loadSection('records')">Medical Records</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" onclick="logout()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div id="content">
                <div class="alert alert-info">Select an option from the menu</div>
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
        setTimeout(() => window.location.href = '{{ route("login") }}', 2000);
        return;
    }

    switch(section) {
        case 'dashboard':
            content.innerHTML = `
                <h2>Welcome to Patient Portal</h2>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 id="appt-count">0</h3>
                                <p>Upcoming Appointments</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 id="record-count">0</h3>
                                <p>Medical Records</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 id="prescription-count">0</h3>
                                <p>Prescriptions</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            loadAppointments(true);
            break;
        case 'appointments':
            loadAppointments(false);
            break;
        case 'professionals':
            loadProfessionals();
            break;
        case 'records':
            loadRecords();
            break;
    }
}

function loadAppointments(dashboard = false) {
    const content = document.getElementById('content');
    content.innerHTML = '<div class="spinner-border"></div> Loading...';

    fetch('/api/appointments', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(r => r.json())
    .then(data => {
        if (data.data && data.data.length > 0) {
            let html = dashboard ? '<h3>Recent Appointments</h3>' : '<h2>My Appointments</h2>';
            html += '<div class="row">';
            data.data.forEach(apt => {
                html += `
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6>${apt.appointment_date}</h6>
                                <p class="mb-0"><strong>Status:</strong> ${apt.status}</p>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            content.innerHTML = html;
        } else {
            content.innerHTML = '<div class="alert alert-warning">No appointments yet</div>';
        }
    })
    .catch(e => content.innerHTML = '<div class="alert alert-danger">Error loading appointments</div>');
}

function loadProfessionals() {
    const content = document.getElementById('content');
    content.innerHTML = '<div class="spinner-border"></div> Loading professionals...';

    fetch('/api/professionals', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(r => r.json())
    .then(data => {
        if (data.data && data.data.length > 0) {
            let html = '<h2>Available Medical Professionals</h2><div class="row">';
            data.data.forEach(prof => {
                html += `
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5>${prof.user.first_name} ${prof.user.last_name}</h5>
                                <p><strong>Specialization:</strong> ${prof.specialization}</p>
                                <p><strong>License Number:</strong> ${prof.license_number}</p>
                                <button class="btn btn-primary btn-sm">Book Appointment</button>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            content.innerHTML = html;
        } else {
            content.innerHTML = '<div class="alert alert-warning">No professionals available</div>';
        }
    })
    .catch(e => content.innerHTML = '<div class="alert alert-danger">Error loading professionals</div>');
}

function loadRecords() {
    const content = document.getElementById('content');
    content.innerHTML = '<h2>Medical Records</h2><div class="alert alert-info">Medical records will appear here</div>';
}

function logout() {
    localStorage.removeItem('token');
    window.location.href = '{{ route("home") }}';
}

// Load dashboard on page load
window.addEventListener('load', () => loadSection('dashboard'));
</script>
@endsection
