<?php

namespace App\Services;

use App\Notifications\AppointmentReminder;
use App\Notifications\AppointmentConfirmed;
use App\Notifications\AppointmentCancelled;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function sendAppointmentReminder($user, $appointment)
    {
        $user->notify(new AppointmentReminder($appointment));
    }

    public function sendAppointmentConfirmed($user, $appointment)
    {
        $user->notify(new AppointmentConfirmed($appointment));
    }

    public function sendAppointmentCancelled($user, $appointment)
    {
        $user->notify(new AppointmentCancelled($appointment));
    }

    public function sendBulkNotification($users, $notification)
    {
        Notification::send($users, $notification);
    }
}
