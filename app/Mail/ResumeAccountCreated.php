<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResumeAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $password;
    public string $loginUrl;

    public function __construct(User $user, string $password, string $loginUrl)
    {
        $this->user = $user;
        $this->password = $password;
        $this->loginUrl = $loginUrl;
    }

    public function build()
    {
        return $this->subject('Your new account for ATS resume report')
            ->view('emails.resume_account_created');
    }
}
