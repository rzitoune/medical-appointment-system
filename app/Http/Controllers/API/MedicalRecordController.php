<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalRecordResource;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->user_type === 'patient') {
            $records = MedicalRecord::where('patient_id', $user->patient->id)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15);
        } else {
            $records = MedicalRecord::where('professional_id', $user->medicalProfessional->id)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15);
        }

        return MedicalRecordResource::collection($records);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'nullable|exists:medical_appointments,id',
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'notes' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
        ]);

        $record = MedicalRecord::create([
            'appointment_id' => $validated['appointment_id'] ?? null,
            'patient_id' => $validated['patient_id'],
            'professional_id' => $request->user()->medicalProfessional->id,
            'diagnosis' => $validated['diagnosis'],
            'treatment_plan' => $validated['treatment_plan'],
            'notes' => $validated['notes'],
            'blood_pressure' => $validated['blood_pressure'],
            'heart_rate' => $validated['heart_rate'],
            'temperature' => $validated['temperature'],
            'weight' => $validated['weight'],
        ]);

        return new MedicalRecordResource($record);
    }

    public function show($id)
    {
        $record = MedicalRecord::findOrFail($id);
        return new MedicalRecordResource($record);
    }

    public function update(Request $request, $id)
    {
        $record = MedicalRecord::findOrFail($id);
        
        $validated = $request->validate([
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'notes' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
        ]);

        $record->update($validated);

        return new MedicalRecordResource($record);
    }

    public function destroy($id)
    {
        $record = MedicalRecord::findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'Medical record deleted successfully']);
    }
}
