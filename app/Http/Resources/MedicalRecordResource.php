<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'appointment_id' => $this->appointment_id,
            'patient_id' => $this->patient_id,
            'professional_id' => $this->professional_id,
            'diagnosis' => $this->diagnosis,
            'treatment_plan' => $this->treatment_plan,
            'notes' => $this->notes,
            'blood_pressure' => $this->blood_pressure,
            'heart_rate' => $this->heart_rate,
            'temperature' => $this->temperature,
            'weight' => $this->weight,
            'patient' => new PatientResource($this->patient),
            'professional' => new ProfessionalResource($this->professional),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
