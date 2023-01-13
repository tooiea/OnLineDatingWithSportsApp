<?php

namespace App\Notifications;

use App\Mail\TempUserSendMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TempUserNotification extends Notification
{
    use Queueable;

    private $token;
    private $mail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token, TempUserSendMailer $mail)
    {
        $this->token = $token;
        $this->mail = $mail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = sprintf(url(route('web.VERIFY_USERS_ROOT') . "%s"), $this->token);
        return $this->mail
            ->text('tempUserSendMailer.mail')
            ->subject('OLDWsへの仮登録いただきありがとうございます')
            ->with(
                [
                    'url' => $url,
                ]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
