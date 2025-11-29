<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfessionalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|string',
            'address' => 'required|string',
            'specialization' => 'required|string|max:255',
            'rpps_number' => 'required|string|unique:medical_professionals',
            'qualifications' => 'required|string',
            'work_address' => 'required|string',
            'consultation_duration' => 'nullable|integer|min:15|max:480',
            'consultation_price' => 'required|numeric|min:0',
            'is_teleconsultation_available' => 'nullable|boolean',
            'spoken_languages' => 'nullable|array',
            'accepted_insurance' => 'nullable|array',
        ];
    }
}
