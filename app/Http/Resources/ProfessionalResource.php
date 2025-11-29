<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'specialization' => $this->specialization,
            'rpps_number' => $this->rpps_number,
            'qualifications' => $this->qualifications,
            'work_address' => $this->work_address,
            'consultation_duration' => $this->consultation_duration,
            'consultation_price' => $this->consultation_price,
            'is_teleconsultation_available' => $this->is_teleconsultation_available,
            'spoken_languages' => $this->spoken_languages,
            'accepted_insurance' => $this->accepted_insurance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
