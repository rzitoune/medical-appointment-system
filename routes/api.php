<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AdminAuthController;
use App\Http\Controllers\API\Auth\SecretaryAuthController;
use App\Http\Controllers\API\Auth\PatientAuthController;
use App\Http\Controllers\API\Auth\ProfessionalAuthController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\MedicalProfessionalController;
use App\Http\Controllers\API\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes - Mawidi Medical System
|--------------------------------------------------------------------------
*/

// Test endpoint
Route::get('/test', function () {
    return response()->json(['message' => 'Mawidi API is working']);
});

// ========== AUTHENTICATION ENDPOINTS ==========

// Admin Authentication
Route::prefix('auth/admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Secretary Authentication
Route::prefix('auth/secretary')->group(function () {
    Route::post('/login', [SecretaryAuthController::class, 'login']);
});

// Patient Authentication
Route::prefix('auth/patient')->group(function () {
    Route::post('/register', [PatientAuthController::class, 'register']);
    Route::post('/login', [PatientAuthController::class, 'login']);
});

// Professional Authentication
Route::prefix('auth/professional')->group(function () {
    Route::post('/register', [ProfessionalAuthController::class, 'register']);
    Route::post('/login', [ProfessionalAuthController::class, 'login']);
});

// ========== PUBLIC ENDPOINTS ==========

// Get doctors (with optional filtering by specialization)
Route::get('/doctors', [MedicalProfessionalController::class, 'index']);
Route::get('/doctors/{id}', [MedicalProfessionalController::class, 'show']);

// Get specializations list
Route::get('/specializations', function () {
    return response()->json([
        'data' => [
            'Cardiology',
            'Neurology',
            'Pediatrics',
            'Dermatology',
            'General Practice',
            'ENT',
        ]
    ]);
});

// ========== PROTECTED ENDPOINTS (Require Authentication) ==========

Route::middleware('auth:sanctum')->group(function () {
    
    // Common logout
    Route::post('/auth/logout', function (\Illuminate\Http\Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    });

    // Get current user
    Route::get('/auth/me', function (\Illuminate\Http\Request $request) {
        return response()->json(['user' => $request->user()]);
    });

    // ========== ADMIN ROUTES ==========
    Route::prefix('admin')->middleware('check.user.type:administrator')->group(function () {
        Route::get('/doctors', [AdminController::class, 'getDoctors']);
        Route::post('/doctors', [AdminController::class, 'createDoctor']);
        Route::put('/doctors/{id}', [AdminController::class, 'updateDoctor']);
        Route::delete('/doctors/{id}', [AdminController::class, 'deleteDoctor']);
        Route::get('/stats', [AdminController::class, 'getStats']);
    });

    // ========== SECRETARY ROUTES ==========
    Route::prefix('secretary')->middleware('check.user.type:secretary')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::post('/appointments', [AppointmentController::class, 'store']);
        Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
        Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
    });


    // ========== PATIENT ROUTES ==========
    Route::prefix('patient')->middleware('check.user.type:patient')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'myAppointments']);
        Route::post('/appointments', [AppointmentController::class, 'store']);
        Route::get('/records', function () {
            return response()->json(['data' => []]);
        });
        Route::get('/prescriptions', function () {
            return response()->json(['data' => []]);
        });
    });

    // ========== PROFESSIONAL ROUTES ==========
    Route::prefix('professional')->middleware('check.user.type:professional')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'professionalAppointments']);
        Route::put('/appointments/{id}', [AppointmentController::class, 'updateStatus']);
        Route::get('/stats', function (\Illuminate\Http\Request $request) {
            $professional = $request->user()->medicalProfessional;
            if (!$professional) {
                return response()->json(['data' => ['total_patients' => 0]]);
            }
            
            $totalPatients = \App\Models\MedicalAppointment::where('professional_id', $professional->id)
                ->distinct('patient_id')
                ->count('patient_id');
                
            return response()->json(['data' => ['total_patients' => $totalPatients]]);
        });
    });
});
