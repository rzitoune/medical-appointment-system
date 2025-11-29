<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MedicalProfessional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Get all doctors
    public function getDoctors(Request $request)
    {
        $query = MedicalProfessional::with('user');

        // Filter by specialization if provided
        if ($request->has('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        $doctors = $query->get();

        return response()->json([
            'data' => $doctors
        ]);
    }

    // Create new doctor
    public function createDoctor(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string',
            'address' => 'required|string',
            'specialization' => 'required|string',
            'rpps_number' => 'required|string|unique:medical_professionals',
            'qualifications' => 'required|string',
            'work_address' => 'required|string',
            'consultation_duration' => 'required|integer',
            'consultation_price' => 'required|numeric',
            'is_teleconsultation_available' => 'required|boolean',
            'spoken_languages' => 'required|array',
            'accepted_insurance' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'user_type' => 'professional',
            ]);

            $professional = MedicalProfessional::create([
                'user_id' => $user->id,
                'specialization' => $validated['specialization'],
                'rpps_number' => $validated['rpps_number'],
                'qualifications' => $validated['qualifications'],
                'work_address' => $validated['work_address'],
                'consultation_duration' => $validated['consultation_duration'],
                'consultation_price' => $validated['consultation_price'],
                'is_teleconsultation_available' => $validated['is_teleconsultation_available'],
                'spoken_languages' => $validated['spoken_languages'],
                'accepted_insurance' => $validated['accepted_insurance'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Doctor created successfully',
                'data' => $professional->load('user')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create doctor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update doctor
    public function updateDoctor(Request $request, $id)
    {
        $professional = MedicalProfessional::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $professional->user_id,
            'phone' => 'sometimes|string',
            'address' => 'sometimes|string',
            'specialization' => 'sometimes|string',
            'rpps_number' => 'sometimes|string|unique:medical_professionals,rpps_number,' . $id,
            'qualifications' => 'sometimes|string',
            'work_address' => 'sometimes|string',
            'consultation_duration' => 'sometimes|integer',
            'consultation_price' => 'sometimes|numeric',
            'is_teleconsultation_available' => 'sometimes|boolean',
            'spoken_languages' => 'sometimes|array',
            'accepted_insurance' => 'sometimes|array',
        ]);

        DB::beginTransaction();
        try {
            // Update user data
            $userFields = ['first_name', 'last_name', 'email', 'phone', 'address'];
            $userData = array_intersect_key($validated, array_flip($userFields));
            if (!empty($userData)) {
                $professional->user->update($userData);
            }

            // Update professional data
            $professionalFields = ['specialization', 'rpps_number', 'qualifications', 'work_address', 
                                   'consultation_duration', 'consultation_price', 'is_teleconsultation_available',
                                   'spoken_languages', 'accepted_insurance'];
            $professionalData = array_intersect_key($validated, array_flip($professionalFields));
            if (!empty($professionalData)) {
                $professional->update($professionalData);
            }

            DB::commit();

            return response()->json([
                'message' => 'Doctor updated successfully',
                'data' => $professional->fresh()->load('user')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update doctor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Delete doctor
    public function deleteDoctor($id)
    {
        $professional = MedicalProfessional::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $user = $professional->user;
            $professional->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'message' => 'Doctor deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete doctor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get statistics
    public function getStats()
    {
        $stats = [
            'total_doctors' => MedicalProfessional::count(),
            'total_patients' => \App\Models\Patient::count(),
            'total_appointments' => \App\Models\MedicalAppointment::count(),
            'total_prescriptions' => \App\Models\Prescription::count(),
        ];

        return response()->json(['data' => $stats]);
    }
}
