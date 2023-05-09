<?php

namespace App\Notifications;

use App\Mail\SendMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $token;
    private $sendMailerInstance;

    /**
     * トークンとsendmailerのインスタンスをセット
     *
     * @param string $token
     * @param SendMailer $sendMailerInstance
     */
    public function __construct(string $token, SendMailer $sendMailerInstance)
    {
        $this->token = $token;
        $this->sendMailerInstance = $sendMailerInstance;
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
        // パスワードリセット用のURLを生成
        $url = sprintf(url(__('route_const.reset_password') . "%s?email=%s"), $this->token, $notifiable->email);
        return $this->sendMailerInstance
                    ->from(config('mail.from.address'))
                    ->to($notifiable->email)
                    ->text('mail.reset_password')
                    ->subject(__('mail_messages.subject.reset_password'))
                    ->with([
                        'url' => $url,
                        'admin' => config('mail.from.address')
                    ]);
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
