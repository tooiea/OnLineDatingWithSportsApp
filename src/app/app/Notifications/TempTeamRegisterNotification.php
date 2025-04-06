<?php
declare(strict_types=1);
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TempTeamRegisterNotification extends BaseNotification
{
    const TEMPLATE = 'mail.temp_user_register';
    const SUBJECT = 'OLDWsへの仮登録いただきありがとうございます';

    public function __construct(array $values)
    {
        parent::__construct(self::TEMPLATE, self::SUBJECT, $values);
    }
}
