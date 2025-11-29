@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Register</h2>

                    <form id="registerForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" placeholder="First name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" placeholder="Last name" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email address" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Phone number" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>
                    </form>

                    <div class="text-center">
                        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                        <p><a href="{{ route('home') }}">Back to Home</a></p>
                    </div>

                    <div id="message" class="alert d-none mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const messageDiv = document.getElementById('message');

    const formData = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        date_of_birth: document.getElementById('date_of_birth').value,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('password_confirmation').value
    };

    try {
        const response = await fetch('/api/auth/patient/register', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.setItem('token', data.token);
            messageDiv.className = 'alert alert-success d-block';
            messageDiv.textContent = 'Registration successful! Redirecting...';
            setTimeout(() => window.location.href = '{{ route("patient-portal") }}', 2000);
        } else {
            messageDiv.className = 'alert alert-danger d-block';
            messageDiv.textContent = data.message || 'Registration failed: ' + JSON.stringify(data.errors || data);
        }
    } catch (error) {
        messageDiv.className = 'alert alert-danger d-block';
        messageDiv.textContent = 'Error: ' + error.message;
    }
});
</script>
@endsection
