<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'professional_id' => $this->professional_id,
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->start_time,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'appointment_type' => $this->appointment_type,
            'consultation_reason' => $this->consultation_reason,
            'symptoms' => $this->symptoms,
            'urgency_level' => $this->urgency_level,
            'status' => $this->status,
            'patient' => new PatientResource($this->patient),
            'medical_professional' => new ProfessionalResource($this->professional),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
