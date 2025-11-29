<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->user_type === 'patient') {
            $prescriptions = Prescription::where('patient_id', $user->patient->id)
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(15);
        } else {
            $prescriptions = Prescription::where('professional_id', $user->medicalProfessional->id)
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(15);
        }

        return response()->json($prescriptions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'patient_id' => 'required|exists:patients,id',
            'medication_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $prescription = Prescription::create([
            'medical_record_id' => $validated['medical_record_id'] ?? null,
            'patient_id' => $validated['patient_id'],
            'professional_id' => $request->user()->medicalProfessional->id,
            'medication_name' => $validated['medication_name'],
            'dosage' => $validated['dosage'],
            'frequency' => $validated['frequency'],
            'duration' => $validated['duration'],
            'instructions' => $validated['instructions'],
            'quantity' => $validated['quantity'] ?? 1,
        ]);

        return response()->json([
            'message' => 'Prescription created successfully',
            'data' => $prescription,
        ], 201);
    }

    public function show($id)
    {
        $prescription = Prescription::findOrFail($id);
        return response()->json($prescription);
    }

    public function update(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);
        
        $validated = $request->validate([
            'medication_name' => 'nullable|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $prescription->update($validated);

        return response()->json([
            'message' => 'Prescription updated successfully',
            'data' => $prescription,
        ]);
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        return response()->json(['message' => 'Prescription deleted successfully']);
    }

    public function getByMedicalRecord($recordId)
    {
        $prescriptions = Prescription::where('medical_record_id', $recordId)->get();
        return response()->json($prescriptions);
    }

    public function getByPatient($patientId)
    {
        $prescriptions = Prescription::where('patient_id', $patientId)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        return response()->json($prescriptions);
    }
}
