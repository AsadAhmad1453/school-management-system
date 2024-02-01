<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventArrangementMail;

class SendEventArrangementMailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $details;

    public function __construct($email, $details)
    {
        $this->email = $email;
        $this->details = $details;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new EventArrangementMail($this->details));
    }
}

