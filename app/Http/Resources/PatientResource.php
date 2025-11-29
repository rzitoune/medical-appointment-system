<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'emergency_contact' => $this->emergency_contact,
            'blood_type' => $this->blood_type,
            'allergies' => $this->allergies,
            'insurance_number' => $this->insurance_number,
            'mutual_fund' => $this->mutual_fund,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
