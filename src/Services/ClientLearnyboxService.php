<?php

namespace App\Services;

use LearnyBox\Client;

class ClientLearnyboxService
{

    public function clientLearnybox()
    {
        $client = Client::create([
            'api_key' => 'fdatfECqdfkGcjirnCBsmujGpgGvqFkDb',
            'subdomain' => 'affiliation-ninja',
            'timeout' => 3000,
        ]);

       return $client;
    }
}