@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Login</h2>
                    
                    <form id="loginForm">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    </form>

                    <div class="text-center">
                        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                        <p><a href="{{ route('home') }}">Back to Home</a></p>
                    </div>

                    <div id="message" class="alert d-none mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const messageDiv = document.getElementById('message');

    try {
        const response = await fetch('/api/auth/patient/login', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.setItem('token', data.token);
            messageDiv.className = 'alert alert-success d-block';
            messageDiv.textContent = 'Login successful! Redirecting...';
            setTimeout(() => window.location.href = '{{ route("patient-portal") }}', 2000);
        } else {
            messageDiv.className = 'alert alert-danger d-block';
            messageDiv.textContent = data.message || 'Login failed: ' + JSON.stringify(data.errors || data);
        }
    } catch (error) {
        messageDiv.className = 'alert alert-danger d-block';
        messageDiv.textContent = 'Error: ' + error.message;
    }
});
</script>
@endsection
