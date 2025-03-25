<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegisterNotification extends BaseNotification
{
    private string $template = 'mail.user_register';
    private string $subject = 'OLDWsへの本登録いただきありがとうございます';

    public function __construct(array $values)
    {
        parent::__construct($this->template, $this->subject, $values);
    }
}
