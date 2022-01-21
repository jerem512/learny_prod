<?php

namespace App\Services;

class InfosContactService
{
    public function getInfosContact($uri, $user){

        $token_calendly = $user->getCalendlyToken();

        $contact = curl_init();

        curl_setopt_array($contact, [
            CURLOPT_URL => "https://api.calendly.com/scheduled_events/" . $uri . "/invitees?sort=created_at%3Adesc",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer " . $token_calendly,
            ],
        ]);

        $contact_response = json_decode(curl_exec($contact));

        return $contact_response;
    }
}