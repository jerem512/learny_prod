<?php

namespace App\Controller;

use App\Services\ClientLearnyboxService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/app", name="app_")
*/

class AccountConnexionsController extends AbstractController
{
    
    /**
     * @Route("/account/connexions", name="account_connexions")
     */
    public function index(ClientLearnyboxService $clientLearnyboxService): Response
    {
        $user = $this->getUser();
        $token_calendly = $user->getCalendlyToken();
        $uuid_calendly = $user->getUuidCalendly();
        $api_key_learnybox = $user->getApiKeyLearnybox();
        $subdomain_learnybox = $user->getSubdomainLearnybox();

        return $this->render('account_connexions/index.html.twig', [
            'token_calendly' => $token_calendly,
            'uuid_calendly' => $uuid_calendly,
            'api_key_learnybox' => $api_key_learnybox,
            'subdomain_learnybox' => $subdomain_learnybox

        ]);
    }

    /**
     * @Route("/account/token/calendly/", name="token_calendly")
     */
    public function calendlyLog(Request $request, EntityManagerInterface $entityManagerInterface){

        $user = $this->getUser();
        $token = $request->request->get('token');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.calendly.com/users/me",
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

        $user_calendly = json_decode(curl_exec($curl));

        if(isset($user_calendly->{'resource'}->{'email'}) && !empty($user_calendly->{'resource'}->{'email'}) && $user_calendly->{'resource'}->{'email'} == $user->getEmail()){
            $uuid = str_replace('https://api.calendly.com/users/', '', $user_calendly->{'resource'}->{'uri'});

            $user->setCalendlyToken($token);
            $user->setUuidCalendly($uuid);
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return new JsonResponse('done', 200);
        }

        return new JsonResponse('echec');
    }

    /**
     * @Route("/account/learnybox/", name="token_calendly")
     */
    public function learnyboxLog(Request $request, ClientLearnyboxService $clientLearnyboxService, EntityManagerInterface $entityManagerInterface){
        $user = $this->getUser();

        $subdomain = $request->request->get('subdomain');
        $api_key = $request->request->get('api_key');

        $client = $clientLearnyboxService->clientLearnybox($subdomain, $api_key);

        $check = $client->get('quota/');

        if(isset($check->{'status'}) && !empty($check->{'status'}) && $check->{'status'} === true){
            $user->setApiKeyLearnybox($api_key);
            $user->setSubdomainLearnybox($subdomain);
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return new JsonResponse('done', 200);
        }
        return new JsonResponse('echec');
    }
}
