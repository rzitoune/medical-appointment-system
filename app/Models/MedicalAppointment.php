<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentType;
use App\Enums\AppointmentStatus;

class MedicalAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'professional_id',
        'appointment_date',
        'appointment_time',
        'start_time',
        'end_time',
        'appointment_type',
        'consultation_reason',
        'symptoms',
        'urgency_level',
        'status',
        'cancellation_reason',
        'no_show_reason',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_type' => AppointmentType::class,
        'status' => AppointmentStatus::class,
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional()
    {
        return $this->belongsTo(MedicalProfessional::class, 'professional_id');
    }

    public function medicalProfessional()
    {
        return $this->belongsTo(MedicalProfessional::class, 'professional_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                    ->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function isConfirmed()
    {
        return $this->status === AppointmentStatus::CONFIRMED;
    }

    public function isCancelled()
    {
        return $this->status === AppointmentStatus::CANCELLED;
    }
}