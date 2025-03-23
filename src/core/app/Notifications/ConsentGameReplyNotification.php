<?php

namespace App\Notifications;

use App\Mail\SendMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConsentGameReplyNotification extends Notification
{
    use Queueable;

    private $user;
    private $myTeam;
    private $sendMailerInstance;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(object $user, object $myTeam, SendMailer $sendMailerInstance)
    {
        $this->user = $user;
        $this->myTeam = $myTeam;
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
        $url = url(__('route_const.login'));
        return $this->sendMailerInstance
                ->from(config('mail.from.address'))
                ->to($this->user->user->email)
                ->text('mail.consent_game_reply')
                ->subject(__('mail_messages.subject.consent_game'))
                ->with([
                        'teamName' => $this->myTeam->team_name,
                        'admin' => config('mail.from.address'),
                        'url' => $url,
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
