<?php

namespace App\Services;

use App\Models\MedicalAvailability;

class AvailabilityService
{
    public function setAvailability($professionalId, array $data)
    {
        return MedicalAvailability::updateOrCreate(
            [
                'professional_id' => $professionalId,
                'day_of_week' => $data['day_of_week'],
            ],
            [
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'is_available' => $data['is_available'] ?? true,
            ]
        );
    }

    public function getAvailability($professionalId)
    {
        return MedicalAvailability::where('professional_id', $professionalId)
                                  ->where('is_available', true)
                                  ->get();
    }

    public function getAvailabilityByDay($professionalId, $dayOfWeek)
    {
        return MedicalAvailability::where('professional_id', $professionalId)
                                  ->where('day_of_week', $dayOfWeek)
                                  ->where('is_available', true)
                                  ->first();
    }

    public function isAvailable($professionalId, $dayOfWeek)
    {
        return MedicalAvailability::where('professional_id', $professionalId)
                                  ->where('day_of_week', $dayOfWeek)
                                  ->where('is_available', true)
                                  ->exists();
    }
}
