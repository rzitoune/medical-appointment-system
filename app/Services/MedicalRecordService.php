<?php

namespace App\Services;

use App\Models\MedicalRecord;

class MedicalRecordService
{
    public function createRecord(array $data)
    {
        return MedicalRecord::create($data);
    }

    public function updateRecord(MedicalRecord $record, array $data)
    {
        return $record->update($data);
    }

    public function getPatientRecords($patientId)
    {
        return MedicalRecord::where('patient_id', $patientId)
                            ->orderBy('created_at', 'desc')
                            ->get();
    }

    public function getProfessionalRecords($professionalId)
    {
        return MedicalRecord::where('professional_id', $professionalId)
                            ->orderBy('created_at', 'desc')
                            ->get();
    }

    public function getRecordsByAppointment($appointmentId)
    {
        return MedicalRecord::where('appointment_id', $appointmentId)->first();
    }
}
