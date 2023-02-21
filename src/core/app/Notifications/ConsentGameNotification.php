<?php

namespace App\Notifications;

use App\Mail\SendMailer;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConsentGameNotification extends Notification
{
    use Queueable;

    private $customValues;
    private $user;
    private $mail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $customValues, object $user, SendMailer $mail)
    {
        $this->customValues = $customValues;
        $this->user = $user;
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
        // dd((isset($this->customValues['message'])) ? $this->customValues['message'] : '');
        $url = url(__('route_const.login'));
        return $this->mail
                ->from(config('mail.from.address'))
                ->to($this->user->user->email)
                ->text('mail.consent_game')
                ->subject(__('mail_messages.subject.consent_game'))
                ->with(
                    [
                        'teamName' => $this->user->team->team_name,
                        'firstPrefereredDate' => Carbon::parse($this->customValues['first_preferered_date'])->format('Y年m月d日'),
                        'secondPrefereredDate' => Carbon::parse($this->customValues['second_preferered_date'])->format('Y年m月d日'),
                        'thirdPrefereredDate' => (isset($this->customValues['third_preferered_date'])) ? Carbon::parse($this->customValues['third_preferered_date'])->format('Y年m月d日') : '',
                        'comment' => (isset($this->customValues['message'])) ? $this->customValues['message'] : '',
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
