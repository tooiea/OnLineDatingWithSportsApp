<?php

namespace App\Notifications;

use App\Mail\SendMailer;
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
    public function __construct(string $token, string $email, SendMailer $mail)
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
                    ->text('mail.temp_user_register')
                    ->subject(__('mail_messages.subject.temp_user_register'))
                    ->with(
                        [
                            'admin' => config('mail.from.address'),
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
