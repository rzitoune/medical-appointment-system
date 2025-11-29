<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'professional_id',
        'diagnosis',
        'treatment_plan',
        'notes',
        'vital_signs',
        'blood_pressure',
        'heart_rate',
        'temperature',
        'weight',
    ];

    protected $casts = [
        'vital_signs' => 'array',
    ];

    public function appointment()
    {
        return $this->belongsTo(MedicalAppointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional()
    {
        return $this->belongsTo(MedicalProfessional::class, 'professional_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    protected function diagnosis(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? decrypt($value) : null,
            set: fn ($value) => encrypt($value)
        );
    }

    protected function notes(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? decrypt($value) : null,
            set: fn ($value) => encrypt($value)
        );
    }
}
