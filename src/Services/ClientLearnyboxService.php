<?php

namespace App\Services;

use LearnyBox\Client;

class ClientLearnyboxService
{

    public function clientLearnybox($subdomain, $api_key)
    {
        $client = Client::create([
            'api_key' => $api_key,
            'subdomain' => $subdomain,
            'timeout' => 3000,
        ]);

       return $client;
    }
}