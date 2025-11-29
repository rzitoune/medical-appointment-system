<?php

namespace App\Enums;

enum AppointmentType: string
{
    case FIRST_CONSULTATION = 'first_consultation';
    case FOLLOW_UP = 'follow_up';
    case EMERGENCY = 'emergency';
    case TELECONSULTATION = 'teleconsultation';
    case HOME_VISIT = 'home_visit';
}