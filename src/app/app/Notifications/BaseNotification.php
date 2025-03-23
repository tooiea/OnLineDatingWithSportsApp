<?php
declare(strict_types=1);
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification
{
    use Queueable;

    private string $template;
    private string $subject;
    private array $values;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $template, string $subject, array $values)
    {
        $this->template = $template;
        $this->subject = $subject;
        $this->values = $values;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->text($this->template, $this->values)
                    ->from(config('mail.from.address'))
                    ->subject($this->subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
