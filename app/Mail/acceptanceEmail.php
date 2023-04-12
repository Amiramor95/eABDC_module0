<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class acceptanceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (\Schema::hasTable('SETTING_EMAIL')) {
            $settings = DB::table('SETTING_EMAIL')->first();

            if ($settings) //checking if table is not empty
            {
                return $this->from($settings->EMAIL_FROM)
                ->subject('Candidate Acceptance Application Notification')
                ->view('acceptance_email')
                ->with('data', $this->data);
            }
        }

    }
}
