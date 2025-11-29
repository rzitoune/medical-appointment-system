<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MedicalAvailability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $professionalId = $request->query('professional_id');
        
        if ($professionalId) {
            $availabilities = MedicalAvailability::where('professional_id', $professionalId)
                                                 ->where('is_available', true)
                                                 ->get();
        } else {
            $availabilities = MedicalAvailability::where('professional_id', $request->user()->medicalProfessional->id)
                                                 ->get();
        }

        return response()->json($availabilities);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'nullable|boolean',
        ]);

        $availability = MedicalAvailability::updateOrCreate(
            [
                'professional_id' => $request->user()->medicalProfessional->id,
                'day_of_week' => $validated['day_of_week'],
            ],
            [
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'is_available' => $validated['is_available'] ?? true,
            ]
        );

        return response()->json([
            'message' => 'Availability set successfully',
            'data' => $availability,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $availability = MedicalAvailability::findOrFail($id);
        
        $validated = $request->validate([
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'is_available' => 'nullable|boolean',
        ]);

        $availability->update($validated);

        return response()->json([
            'message' => 'Availability updated successfully',
            'data' => $availability,
        ]);
    }

    public function destroy($id)
    {
        $availability = MedicalAvailability::findOrFail($id);
        $availability->delete();

        return response()->json(['message' => 'Availability deleted successfully']);
    }

    public function getByDay($professionalId, $day)
    {
        $availability = MedicalAvailability::where('professional_id', $professionalId)
                                           ->where('day_of_week', $day)
                                           ->first();

        if (!$availability) {
            return response()->json(['message' => 'No availability found'], 404);
        }

        return response()->json($availability);
    }
}
