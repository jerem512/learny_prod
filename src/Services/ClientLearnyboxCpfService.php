<?php

namespace App\Services;

use LearnyBox\Client;

class ClientLearnyboxCpfService
{

    public function clientLearnyboxCpf()
    {
        $client = Client::create([
            'api_key' => 'CpFCxidmbybsmdfwFApBramBatBofgqnG',
            'subdomain' => 'ivvandi-formations',
            'timeout' => 3000,
        ]);

       return $client;
    }
}