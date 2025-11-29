<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'emergency_contact',
        'blood_type',
        'allergies',
        'medical_history',
        'insurance_number',
        'mutual_fund',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(MedicalAppointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    protected function allergies(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? json_decode(decrypt($value), true) : [],
            set: fn ($value) => $value ? encrypt(json_encode($value)) : null
        );
    }

    protected function medicalHistory(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? decrypt($value) : null,
            set: fn ($value) => $value ? encrypt($value) : null
        );
    }
}