<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\MedicalAppointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->user_type === 'patient') {
            $appointments = MedicalAppointment::where('patient_id', $user->patient->id)
                                              ->orderBy('appointment_date', 'desc')
                                              ->paginate(15);
        } else {
            $appointments = MedicalAppointment::where('professional_id', $user->medicalProfessional->id)
                                              ->orderBy('appointment_date', 'desc')
                                              ->paginate(15);
        }

        return AppointmentResource::collection($appointments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'medical_professional_id' => 'required|exists:medical_professionals,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string'
        ]);

        $patient = $request->user()->patient;
        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        // Get professional to calculate end_time
        $professional = \App\Models\MedicalProfessional::findOrFail($request->medical_professional_id);
        $consultationDuration = $professional->consultation_duration ?? 30; // Default 30 minutes
        
        // Calculate end_time by adding consultation duration to start_time
        $startTime = \Carbon\Carbon::parse($request->appointment_time);
        $endTime = $startTime->copy()->addMinutes($consultationDuration)->format('H:i:s');

        $appointment = MedicalAppointment::create([
            'patient_id' => $patient->id,
            'professional_id' => $request->medical_professional_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->appointment_time,
            'end_time' => $endTime,
            'appointment_type' => 'first_consultation',
            'consultation_reason' => $request->reason ?? 'General consultation',
            'symptoms' => null,
            'urgency_level' => 'low',
            'status' => 'pending',
        ]);

        return new AppointmentResource($appointment->load(['medicalProfessional.user']));
    }

    public function show($id)
    {
        $appointment = MedicalAppointment::findOrFail($id);
        return new AppointmentResource($appointment);
    }

    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = MedicalAppointment::findOrFail($id);
        $appointment->update($request->validated());

        return new AppointmentResource($appointment);
    }

    public function destroy($id)
    {
        $appointment = MedicalAppointment::findOrFail($id);
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }

    public function confirm(Request $request, $id)
    {
        $appointment = MedicalAppointment::findOrFail($id);
        $appointment->update(['status' => 'confirmed']);

        return new AppointmentResource($appointment);
    }

    public function cancel(Request $request, $id)
    {
        $appointment = MedicalAppointment::findOrFail($id);
        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return new AppointmentResource($appointment);
    }

    public function myAppointments(Request $request)
    {
        $patient = $request->user()->patient;
        if (!$patient) {
            return response()->json(['data' => []]);
        }

        $appointments = MedicalAppointment::where('patient_id', $patient->id)
                                          ->with(['medicalProfessional.user'])
                                          ->orderBy('appointment_date', 'desc')
                                          ->orderBy('start_time', 'desc')
                                          ->get();

        return AppointmentResource::collection($appointments);
    }

    public function professionalAppointments(Request $request)
    {
        $professional = $request->user()->medicalProfessional;
        if (!$professional) {
            return response()->json(['data' => []]);
        }

        $appointments = MedicalAppointment::where('professional_id', $professional->id)
                                          ->with(['patient'])
                                          ->orderBy('appointment_date', 'desc')
                                          ->orderBy('start_time', 'desc')
                                          ->get();

        return AppointmentResource::collection($appointments);
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = MedicalAppointment::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $appointment->update(['status' => $request->status]);

        return new AppointmentResource($appointment);
    }
}
