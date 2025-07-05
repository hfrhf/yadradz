<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class PaymentReceivedNotification extends Notification
{
    use Queueable;

    protected $amount;

    /**
     * Create a new notification instance.
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database']; // سنرسل الإشعار إلى قاعدة البيانات فقط
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        // تنسيق المبلغ ليظهر بشكل جميل (مثال: 1,250.50)
        $formattedAmount = number_format($this->amount, 2);

        return [
            'amount' => $this->amount,
            'message' => "تم تسجيل دفعة جديدة لك بقيمة: {$formattedAmount} د.ج"
        ];
    }
}
