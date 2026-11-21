<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = route('admin.reset-password', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('TribuneBangla অ্যাডমিন পাসওয়ার্ড রিসেট')
            ->line('আপনার অ্যাডমিন অ্যাকাউন্টের পাসওয়ার্ড পরিবর্তনের অনুরোধ পাওয়া গেছে।')
            ->action('পাসওয়ার্ড পরিবর্তন করুন', $url)
            ->line('আপনি অনুরোধ না করলে এই ইমেইলটি উপেক্ষা করুন।');
    }
}
