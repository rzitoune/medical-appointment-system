<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCancelled extends Notification implements ShouldQueue
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
                    ->subject('Appointment Cancelled')
                    ->greeting('Hello ' . $notifiable->first_name)
                    ->line('Your appointment has been cancelled.')
                    ->line('Date: ' . $this->appointment->appointment_date)
                    ->line('Time: ' . $this->appointment->start_time . ' - ' . $this->appointment->end_time)
                    ->when($this->appointment->cancellation_reason, function ($mail) {
                        return $mail->line('Reason: ' . $this->appointment->cancellation_reason);
                    })
                    ->line('If you have any questions, please contact us.')
                    ->line('Thank you for using Medical System');
    }
}
