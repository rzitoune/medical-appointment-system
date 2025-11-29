<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalProfessional extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'rpps_number',
        'qualifications',
        'work_address',
        'consultation_duration',
        'consultation_price',
        'is_teleconsultation_available',
        'spoken_languages',
        'accepted_insurance',
    ];

    protected $casts = [
        'spoken_languages' => 'array',
        'accepted_insurance' => 'array',
        'consultation_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(MedicalAppointment::class);
    }

    public function availabilities()
    {
        return $this->hasMany(MedicalAvailability::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}