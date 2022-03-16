<?php

namespace App\Services;

use App\Repository\LeadRepository;
use App\Services\FindCalendlyInfos;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;

class FiveEventsService
{
    private $findCalendlyInfos;
    private $leadRepository;

    public function __construct(FindCalendlyInfos $findCalendlyInfos, LeadRepository $leadRepository)
    {
        $this->findCalendlyInfos = $findCalendlyInfos;
        $this->leadRepository = $leadRepository;
    }

    public function fiveEvents($user){

        $token = $user->getCalendlyToken();

        $infos_user = $this->findCalendlyInfos->setUserInfos($token);

        $event = curl_init();

        curl_setopt_array($event, [
            CURLOPT_URL => "https://api.calendly.com/scheduled_events?user=". $infos_user->{'resource'}->{'uri'} . "&status=active&sort=start_time%3Adesc&count=5",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
              "Authorization: Bearer " . $token,
              "Content-Type: application/json"
            ],
          ]);

          $events = json_decode(curl_exec($event));

          
          return $events;

    }

    public function fiveEventsInfos($user, $events){
        
        $token = $user->getCalendlyToken();
        $infos = [];

        foreach($events->{'collection'} as $event){
            
        
            $curl = \curl_init();

            $uri = \str_replace('https://api.calendly.com/scheduled_events/', '', $event->{'uri'});

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.calendly.com/scheduled_events/" . $uri . "/invitees",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                  "Authorization: Bearer " . $token,
                  "Content-Type: application/json"
                ],
              ]);

              $response = \json_decode(\curl_exec($curl));

              $start_time = new DateTime($event->{'start_time'});

              $lead = $this->leadRepository->findOneBy(['email' => $response->{'collection'}[0]->{'email'}]) ? $this->leadRepository->findOneBy(['email' => $response->{'collection'}[0]->{'email'}]) : '';
              $lead_id = $lead ? $lead->getIdContact() : 'null';

              $infos[] = [
                  'name' => $response->{'collection'}[0]->{'name'},
                  'email' => $response->{'collection'}[0]->{'email'},
                  'date' => $start_time->format('d/m'),
                  'lead_id' => $lead_id
              ];
            
        }

        return $infos;
    }
}