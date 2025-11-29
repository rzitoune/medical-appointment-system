<?php

namespace App\Enums;

enum UserRole: string
{
    case PATIENT = 'patient';
    case MEDICAL_PROFESSIONAL = 'professional';
    case SECRETARY = 'secretary';
    case ADMINISTRATOR = 'administrator';
}