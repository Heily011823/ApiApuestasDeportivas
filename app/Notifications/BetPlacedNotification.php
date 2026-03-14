<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BetPlacedNotification extends Notification
{
    use Queueable;

    private $amount;
    private $potentialWin;

    public function __construct($amount, $potentialWin)
    {
        $this->amount = $amount;
        $this->potentialWin = $potentialWin;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Apuesta realizada')
            ->line('Tu apuesta fue registrada correctamente.')
            ->line('Monto apostado: ' . $this->amount)
            ->line('Posible ganancia: ' . $this->potentialWin)
            ->line('Gracias por usar nuestra plataforma.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}