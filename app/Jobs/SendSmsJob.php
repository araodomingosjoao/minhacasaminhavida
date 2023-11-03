<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $phoneNumberTo;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @param  string  $phoneNumberFrom
     * @param  string  $phoneNumberTo
     * @param  string  $message
     * @return void
     */
    public function __construct($phoneNumberTo, $message)
    {
        $this->phoneNumberTo = $phoneNumberTo;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $account_sid = config('services.twilio.account_sid');
        $auth_token = config('services.twilio.auth_token');
        $twilio_number = config('services.twilio.twilio_number');

        $client = new Client($account_sid, $auth_token);

        $client->messages->create(
            $this->phoneNumberTo,
            array(
                'from' => $twilio_number,
                'body' => $this->message
            )
        );
    }
}
