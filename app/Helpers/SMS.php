<?php

namespace App\Helpers;

use Config;
use App\Models\SmsLog;

class SMS //extends Model
{
    public $mocean_setup;

    public function __construct()
    {
        $this->mocean = new \Mocean\Client(
            new \Mocean\Client\Credentials\Basic(config('secret.sms_key'), config('secret.sms_secret'))
        );
    }

    public function testSend($parameter)
    {
        $response = (object) [];

        $response->expired = false;
        $response->data = false;

        try {
            $result = $this->mocean->message()->send([
                'mocean-to' => $parameter->phoneNo,
                'mocean-from' => config('laradoc.projectName'),
                'mocean-text' => $parameter->content,
                'mocean-resp-format' => 'json',
                'mocean-brand'=> "FIMM"
            ]);

            $response->data = $result;
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                $response->expired = true;
            }
        }

        return $response;
    }

    public function sendTAC($parameter)
    {
        $response = (object) [];

        $response->expired = false;
        $response->data = false;

        try {
            $result = $this->mocean->message()->send([
                'mocean-to' => $parameter->phoneNo,
                'mocean-from' => config('laradoc.projectName'),
                'mocean-text' => "FIMM:Your TAC code is ".$parameter->tac,
                'mocean-resp-format' => 'json',
                'mocean-brand'=> "FIMM"
            ]);
            $response->data = $result;
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                $response->expired = true;
            }
        }

        return $response;
    }
}
