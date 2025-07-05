<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class CustomResetPassword extends ResetPasswordNotification
{
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('إعادة تعيين كلمة المرور')
            ->greeting('مرحباً!')
            ->line('تلقينا طلبًا لإعادة تعيين كلمة المرور لحسابك.')
            ->action('إعادة تعيين كلمة المرور', $url)
            ->line('إذا لم تطلب إعادة تعيين كلمة المرور، فيمكنك تجاهل هذا البريد الإلكتروني.')
            ->salutation('مع تحيات,')
            ->line('فريق الدعم.');
    }
}
