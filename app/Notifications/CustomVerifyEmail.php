<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;

class CustomVerifyEmail extends VerifyEmailNotification
{
    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('تأكيد عنوان البريد الإلكتروني')
            ->greeting('مرحباً!')
            ->line('يرجى الضغط على الزر أدناه لتأكيد عنوان بريدك الإلكتروني.')
            ->action('تأكيد عنوان البريد الإلكتروني', $url)
            ->line('إذا لم تقم بإنشاء حساب، فلا حاجة لاتخاذ أي إجراء إضافي.')
            ->salutation('مع تحيات,')
            ->line('فريق الدعم.');
    }
}
