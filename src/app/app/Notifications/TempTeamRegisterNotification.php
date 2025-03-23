<?php
declare(strict_types=1);
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TempTeamRegisterNotification extends BaseNotification
{
    private string $template = 'mail.temp_user_register';
    private string $subject = 'OLDWsへの仮登録いただきありがとうございます';

    public function __construct(array $values)
    {
        parent::__construct($this->template, $this->subject, $values);
    }
}
