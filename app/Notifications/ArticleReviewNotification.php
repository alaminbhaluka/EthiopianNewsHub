<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleReviewNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('TribuneBangla নোটিফিকেশন')
            ->line('আপনার অ্যাকাউন্টে একটি নতুন আপডেট রয়েছে।');
    }
}
