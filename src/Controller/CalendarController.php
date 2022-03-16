<?php

namespace App\Controller;

use App\Entity\LeadMembership;
use App\Entity\NotificationsPathLeads;
use App\Repository\LeadMembershipRepository;
use App\Repository\LeadRepository;
use App\Repository\ModelMailRepository;
use App\Repository\NotificationsPathLeadsRepository;
use App\Services\AccessTokenService;
use App\Services\EventCalendarService;
use App\Services\OneEventService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/app", name="app_")
 */
class CalendarController extends AbstractController
{

    /**
     * @Route("/calendly", name="calendly")
     */
    public function index(AccessTokenService $accessTokenService, EventCalendarService $eventCalendarService){

        $user = $this->getUser();
        $user_mail = $user->getEmail();
        $accessToken = $accessTokenService->accessToken($user);
        $range_date = new DateTime('-120 day');
        
        $calendar = curl_init();

        curl_setopt_array($calendar, [
            CURLOPT_URL => "https://www.googleapis.com/calendar/v3/calendars/" . $user_mail ."/events?maxResults=2500&orderBy=startTime&singleEvents=true&timeMin=" . $range_date->format('Y-m-d') . 'T00:00:00Z',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer " . $accessToken,
            ],
        ]);

        $events = json_decode(curl_exec($calendar));
        $case = $eventCalendarService->makeEventCalendarService($events, $user_mail);
        $data = json_encode($case);

        return $this->render('calendar/index.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/add-event", name="add_event")
     */
    public function addEvent(Request $request, AccessTokenService $accessTokenService)
    {
        $user = $this->getUser();
        $user_mail = $user->getEmail();
        $titleEvent = $request->request->get('titleEvent');
        $startTimeEvent = $request->request->get('startTimeEvent');
        $endTimeEvent = $request->request->get('endTimeEvent');
        $descriptionEvent = $request->request->get('descriptionEvent');
        $colorId = $request->request->get('colorId');
        $mailFup = $request->request->get('fupEvent');

        $accessToken = $accessTokenService->accessToken($user);

        $addEvent = curl_init();

        curl_setopt_array($addEvent, [
            CURLOPT_URL => "https://www.googleapis.com/calendar/v3/calendars/" . $user_mail . "/events",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer " . $accessToken,
            ],
            CURLOPT_POSTFIELDS => "{\"end\":{\"dateTime\":\"" . $endTimeEvent .":00+01:00\",\"timeZone\":\"Europe/Paris\"},\"start\":{\"dateTime\":\"" . $startTimeEvent . ":00+01:00\",\"timeZone\":\"Europe/Paris\"},\"attendees\":[{\"email\":\"" . $mailFup ."\"}],\"summary\":\"" . $titleEvent . "\",\"colorId\":\"" . $colorId . "\",\"description\":\"" . $descriptionEvent . "\"}",
            CURLOPT_ENCODING => 'gzip, deflate'
        ]);

        $data = curl_exec($addEvent);

        curl_close($addEvent);

        return new JsonResponse(json_decode($data));
    }

    /**
     * @Route("/one-event", name="one_event")
     */
    public function event(Request $request, LeadRepository $leadRepository, NotificationsPathLeadsRepository $notificationsPathLeadsRepository, LeadMembershipRepository $leadMembershipRepository, OneEventService $oneEventService){


        $user = $this->getUser();
        $token = $user->getCalendlyToken();
        $uuid = $user->getuuidCalendly();
        $mail = $request->request->get('email');
        //dd($mail);
        $lead = $leadRepository->findby(['email' => $mail]);
        
        $lead_id = $lead[0]->getIdContact();
        $lead_name = $lead[0]->getFirstName();
        $date_call_immuable = new \DateTimeImmutable();

        $event = $oneEventService->getOneEvent($uuid, $token, $mail);

        if(!empty($notificationsPathLeadsRepository->findBy(['notification_type' => 'Appointment', 'lead_id' => $lead_id])) === false){
            $date = $event->{'collection'}[0]->{'start_time'};
            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, "fr_FR");
            $date_fr = strftime("%A %d %B %G à %H:%M", strtotime($date));

            $notifications = new NotificationsPathLeads();
            $notifications->setNotificationType('Appointment');
            $notifications->setNotificationTitle($lead_name . ' votre rendez-vous est confirmé.');
            $notifications->setNotificationBody($lead_name . ' votre rendez-vous débutera le ' . $date_fr);
            $notifications->setCreatedAt($date_call_immuable);
            $notifications->setLeadId($lead_id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notifications);
            $entityManager->flush();

        }

        if(!empty($leadMembershipRepository->findBy(['lead_id' => $lead_id])) === false){
            $lead_membership = new LeadMembership();
            $lead_membership->setUser($user);
            $lead_membership->setLeadId($lead_id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lead_membership);
            $entityManager->flush();
        }

        return new JsonResponse($lead_id);
    }

    /**
     * @Route("/preselect", name="preselect")
     */
    public function preselect(Request $request, ModelMailRepository $modelMailRepository){
        $name = $request->request->get('name');
        $model = $modelMailRepository->findBy(['name' => $name]);

        $mail_type = [
            'model_object' => $model[0]->getModelObject(),
            'model_body' => $model[0]->getModelBody()
        ];
        
        return new JsonResponse($mail_type);
    }
}