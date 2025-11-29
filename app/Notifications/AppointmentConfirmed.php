<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Appointment Confirmed')
                    ->greeting('Hello ' . $notifiable->first_name)
                    ->line('Your appointment has been confirmed.')
                    ->line('Date: ' . $this->appointment->appointment_date)
                    ->line('Time: ' . $this->appointment->start_time . ' - ' . $this->appointment->end_time)
                    ->line('Professional: ' . $this->appointment->professional->user->full_name)
                    ->action('View Appointment', url('/appointments/' . $this->appointment->id))
                    ->line('Thank you for using Medical System');
    }
}
