<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification
{
    use Queueable;

    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    // تحديد قنوات الإرسال (قاعدة بيانات، بريد إلكتروني، ...)
    public function via($notifiable)
    {
        return ['database', 'mail']; // سنرسله إلى قاعدة البيانات والبريد الإلكتروني
    }

    // تنسيق بيانات الإشعار للحفظ في قاعدة البيانات
    public function toDatabase($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => "تنبيه: مخزون المنتج '{$this->product->name}' على وشك النفاد. الكمية المتبقية: {$this->product->quantity}."
        ];
    }

    // تنسيق رسالة البريد الإلكتروني
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('تنبيه انخفاض مخزون المنتج')
                    ->line("تنبيه: مخزون المنتج '{$this->product->name}' على وشك النفاد.")
                    ->line("الكمية المتبقية: {$this->product->quantity}")
                    ->action('عرض المنتج', url('/admin/products/' . $this->product->id))
                    ->line('يرجى اتخاذ الإجراء اللازم.');
    }
}
