<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'appointment_date' => 'nullable|date|after:today',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'appointment_type' => 'nullable|in:first_consultation,follow_up,emergency,teleconsultation,home_visit',
            'consultation_reason' => 'nullable|string|max:255',
            'symptoms' => 'nullable|string',
            'urgency_level' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,confirmed,cancelled,completed,no_show',
            'cancellation_reason' => 'nullable|string',
        ];
    }
}
