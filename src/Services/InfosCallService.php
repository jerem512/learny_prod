<?php

namespace App\Services;

class InfosCallService
{
    public function getInfosCall($user, $start_date, $end_date){
        $search = ['+', ' '];
        $user_phone_number = str_replace($search, '', $user->getRingoverPhoneNumber());

        $calls = curl_init();

        curl_setopt_array($calls, [
            CURLOPT_URL => 'https://public-api.ringover.com/v2/calls',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "filter": "ADVANCED",
                "start_date": "' . $start_date . '",
                "end_date": "' . $end_date . '",
                "call_type": [
                    "ANSWERED",
                    "MISSED",
                    "VOICEMAIL",
                    "OUT"
                ],
                "advanced": {
                    "int_numbers": ['
            . intval($user_phone_number) .
            ']

                }
            }',
            CURLOPT_HTTPHEADER => [
                'Authorization: fa2fba9a95fd360fcfe6994c7bd03aca11c8a7b0',
                'Content-Type: text/plain',
            ],
        ]);

        $calls_response = json_decode(curl_exec($calls));

        return $calls_response;
    }
}