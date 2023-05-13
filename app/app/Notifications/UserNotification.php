<?php

namespace App\Notifications;

use App\Mail\SendMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;

    private $user;
    private $sendMailerInstance;

    /**
     * Create a new notification instance.
     *
     * @param object $user
     */
    public function __construct(object $user, SendMailer $sendMailerInstance)
    {
        $this->user = $user;
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
        return $this->sendMailerInstance
                    ->from(config('mail.from.address'))
                    ->to($this->user->user->email)
                    ->text('mail.user_register')
                    ->subject(__('mail_messages.subject.user_register'))
                    ->with([
                        'name' => $this->user->user->name,
                        'teamName' => $this->user->team->team_name,
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
