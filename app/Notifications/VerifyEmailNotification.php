<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email Address - Funshirt')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for registering with Funshirt!')
            ->line('Please verify your email address by clicking the button below.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('This verification link will expire in 60 minutes.')
            ->line('')
            ->line('If you did not create this account, please ignore this email.')
            ->salutation('Best regards, Funshirt Team');
    }
}
