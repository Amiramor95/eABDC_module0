<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class distributorRegistrationApprovalEmail extends Mailable
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
                ->subject('Distributor Registration Notification')
                ->view('dist_email_notification')
                ->with('data', $this->data);
            }
        }

    }
}
