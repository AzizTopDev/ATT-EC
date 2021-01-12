<?php

namespace Webkul\User\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;

class AdminResetPassword extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
            ->subject(trans('shop::app.mail.forget-password.subject'))
            ->view('shop::emails.admin.forget-password', [
                'user_name' => $notifiable->name,
                'token'     => $this->token,
                'email'     => $notifiable->email,
                'se_template' => 'admin.forget-password',
            ]);
    }
}
