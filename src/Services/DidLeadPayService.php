<?php

namespace App\Services;


class DidLeadPayService
{
    private $clientLearnyboxService;

    public function __construct(ClientLearnyboxService $clientLearnyboxService)
    {
        $this->clientLearnyboxService = $clientLearnyboxService;
    }

    public function verfifyPayment($subdomain, $apiKey, $lead_id){

        $client = $this->clientLearnyboxService->clientLearnybox($subdomain, $apiKey);

        $getPayment = $client->get('transactions/user/' . $lead_id . '/')->{'data'};

        $payment = !empty($getPayment) && $getPayment[0]->{'valid'} == true ? $getPayment[0] : false;

        return $payment;

    }
}