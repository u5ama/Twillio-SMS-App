<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->with([
                'name'            => $this->details['name'],
                'actionUrl'       => $this->details['actionUrl'],
                'app_local'       => app()->getLocale(),
                'main_title_text' => $this->details['main_title_text'],
            ])
            ->subject($this->details['reset_password_subject'])
            ->view('emails.resetPassword');


    }
}
