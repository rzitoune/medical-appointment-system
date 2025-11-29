<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:male,female,other',
            'emergency_contact' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|array',
            'medical_history' => 'nullable|string',
            'insurance_number' => 'nullable|string',
            'mutual_fund' => 'nullable|string',
        ];
    }
}
