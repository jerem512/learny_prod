<?php

namespace App\Services;

class OneEventService
{
    public function getOneEvent($uuid, $token, $mail){
        $one_event = curl_init();

        curl_setopt_array($one_event, [
            CURLOPT_URL => "https://api.calendly.com/scheduled_events?user=https://api.calendly.com/users/" . $uuid . "&invitee_email=" . $mail,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer " . $token,
            ],
        ]);

        $event = json_decode(curl_exec($one_event));

        return $event;
    }
}