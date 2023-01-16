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
    private $email;
    private $mail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token, string $email, TempUserSendMailer $mail)
    {
        $this->token = $token;
        $this->email = $email;
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
        $url = sprintf(url(__('route_const.temp_mail.register') . "%s"), $this->token);
        return $this->mail
            ->from(config('mail.from.address'))
            ->to($this->email)
            ->text('tempUserSendMailer.mail')
            ->subject(__('tmp_mail_messages.subject'))
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
