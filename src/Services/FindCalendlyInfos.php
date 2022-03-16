<?php

namespace App\Services;

class FindCalendlyInfos
{
    public function setUserInfos($token_calendly){

        $init = curl_init();

        curl_setopt_array($init, [
            CURLOPT_URL => "https://api.calendly.com/users/me",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
              "Authorization: Bearer " . $token_calendly,
              "Content-Type: application/json"
            ],
        ]);

        $infos = json_decode(curl_exec($init));

        return $infos;
    }

    public function findUuid($email, $infos, $token_calendly){

        $init = curl_init();

        curl_setopt_array($init, [
            CURLOPT_URL => "https://api.calendly.com/scheduled_events?invitee_email=" . $email . "&organization=" . $infos->resource->{'current_organization'},
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
              "Authorization: Bearer " . $token_calendly,
              "Content-Type: application/json"
            ],
        ]);

        $find = json_decode(curl_exec($init));

        if(!empty($find->{'collection'})){
            return $find->{'collection'}[0];
        }else{
            return false;
        }
    }
}