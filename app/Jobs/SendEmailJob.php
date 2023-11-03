<?php

namespace App\Jobs;

use App\Mail\SendVerificationCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $code;

    /**
     * @param  string  $email
     * @param  string  $code
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $code)
    {
        
        $this->email = $email;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new SendVerificationCode($this->code));
    }
}
