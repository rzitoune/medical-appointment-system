<?php

namespace App\Services;

use App\Models\MedicalAppointment;
use Carbon\Carbon;

class AppointmentService
{
    public function createAppointment(array $data)
    {
        return MedicalAppointment::create($data);
    }

    public function updateAppointment(MedicalAppointment $appointment, array $data)
    {
        return $appointment->update($data);
    }

    public function cancelAppointment(MedicalAppointment $appointment, string $reason = null)
    {
        return $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
        ]);
    }

    public function confirmAppointment(MedicalAppointment $appointment)
    {
        return $appointment->update(['status' => 'confirmed']);
    }

    public function checkAvailability($professionalId, $appointmentDate, $startTime, $endTime)
    {
        $conflict = MedicalAppointment::where('professional_id', $professionalId)
            ->where('appointment_date', $appointmentDate)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime]);
            })->exists();

        return !$conflict;
    }

    public function getUpcomingAppointments($userId, $userType)
    {
        if ($userType === 'patient') {
            return MedicalAppointment::whereHas('patient', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->upcoming()->get();
        }

        return MedicalAppointment::whereHas('professional', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->upcoming()->get();
    }
}
