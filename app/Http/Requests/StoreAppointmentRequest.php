<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'professional_id' => 'required|exists:medical_professionals,id',
            'appointment_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'appointment_type' => 'required|in:first_consultation,follow_up,emergency,teleconsultation,home_visit',
            'consultation_reason' => 'required|string|max:255',
            'symptoms' => 'nullable|string',
            'urgency_level' => 'nullable|in:low,medium,high',
        ];
    }
}
