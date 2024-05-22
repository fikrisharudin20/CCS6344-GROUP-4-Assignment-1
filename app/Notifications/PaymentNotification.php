<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentNotification extends Notification
{
    use Queueable;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Successful Payment #' . $this->ticket->payment->id)
                    ->greeting('Hello, ' . $notifiable->name . '!')
                    ->line('Payment has been successfully made for your event.')
                    ->line('Event: ' . $this->ticket->event->name)
                    ->line('Event Attendee Name: ' . $this->ticket->user->name)
                    ->line('Ticket ID: ' . $this->ticket->id)
                    ->line('Payment ID: ' . $this->ticket->payment->id)
                    ->line('Thank you for using our service!');
    }
}
