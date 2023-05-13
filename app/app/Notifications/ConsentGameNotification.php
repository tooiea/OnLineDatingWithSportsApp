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
    private $guest;
    private $invitee;
    private $sendMailerInstance;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $customValues, object $guest, $invitee, SendMailer $sendMailerInstance)
    {
        $this->customValues = $customValues;
        $this->guest = $guest;
        $this->invitee = $invitee;
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
                    ->to($this->guest->user->email)
                    ->text('mail.consent_game')
                    ->subject(__('mail_messages.subject.consent_game'))
                    ->with([
                        'teamName' => $this->invitee->team->team_name,
                        'firstPrefereredDate' => Carbon::parse($this->customValues['first_preferered_date'])->format('Y年m月d日 G時i分'),
                        'secondPrefereredDate' => Carbon::parse($this->customValues['second_preferered_date'])->format('Y年m月d日 G時i分'),
                        'thirdPrefereredDate' => (isset($this->customValues['third_preferered_date'])) ? Carbon::parse($this->customValues['third_preferered_date'])->format('Y年m月d日 G時i分') : '',
                        'comment' => (isset($this->customValues['message'])) ? $this->customValues['message'] : '',
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
