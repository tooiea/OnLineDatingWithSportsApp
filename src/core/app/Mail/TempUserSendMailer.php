<?php

namespace App\Mail;

use App\Constants\CommonConstant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TempUserSendMailer extends Mailable
{
    use Queueable, SerializesModels;

    private $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = sprintf(url(CommonConstant::VERIFY_USERS_ROOT . "%s"), $this->token);
        return $this
            ->text('tempUserSendMailer.mail')
            ->subject('OLDWSへの仮登録いただきありがとうございます')
            ->with(
                [
                    'url' => $url,
                ]
            );
    }
}
