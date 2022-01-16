<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Category;
use App\Entity\Mail;
use App\Entity\NotificationsPathLeads;
use App\Entity\Sms;
use App\Entity\Notifs;
use App\Form\CategoryType;
use App\Form\LeadMembershipFormType;
use App\Form\NotificationsPathLeadsType;
use App\Form\SmsType;
use App\Form\MailType;
use App\Repository\CategoryRepository;
use App\Repository\LeadMembershipRepository;
use App\Repository\LeadRepository;
use App\Repository\ModelMailRepository;
use App\Repository\NotificationsPathLeadsRepository;
use LearnyBox\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @Route("/app", name="app_")
 */

class CalendlyController extends AbstractController
{

    /**
     * @Route("/contact-view/{uri}/{start_date}/{end_date}", name="contact_view")
     */
    public function contactView(
        Request $request,
        LeadRepository $leadrepository,
        CategoryRepository $categoryRepository,
        NotificationsPathLeadsRepository $notificationsPathLeadsRepository,
        $uri,
        $start_date,
        $end_date
        ): Response {

        $client = Client::create([
            'api_key' => 'fdatfECqdfkGcjirnCBsmujGpgGvqFkDb',
            'subdomain' => 'affiliation-ninja',
        ]);

        $token = $this->getUser()->getCalendlyToken();
        $search = ['+', ' '];
        $phone_number = str_replace($search, '', $this->getUser()->getRingoverPhoneNumber());

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
                "authorization: Bearer " . $token,
            ],
        ]);

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
            . intval($phone_number) .
            ']

                }
            }',
            CURLOPT_HTTPHEADER => [
                'Authorization: fa2fba9a95fd360fcfe6994c7bd03aca11c8a7b0',
                'Content-Type: text/plain',
            ],
        ]);

        $calls_response = json_decode(curl_exec($calls));

        $contact_response = curl_exec($contact);

        $contact_parsed = json_decode($contact_response);

        $contact_email = $contact_parsed->{'collection'}[0]->{'email'};

        $infos_contact = $leadrepository->findBy(['email' => $contact_email]);

        $id = $infos_contact[0]->getIdContact();

        $infos_api = $client->get('mail/contacts/' . $id);
        $paid_state = $client->get('transactions/user/' . $id);

        $category = new Category();

        $form_category = $this->createForm(CategoryType::class, $category);
        $form_category->handleRequest($request);

        if ($form_category->isSubmitted() && $form_category->isValid()) {

            $category->setUserId($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_view', [
                'uri' => $uri,
                'start_date' => $start_date,
                'end_date' => $end_date,
                '_fragment' => 'activity',
            ]);
        }

        $lead_category = $categoryRepository->findBy(['user_id' => $id]);

        $notifications = new NotificationsPathLeads();

        $form = $this->createForm(NotificationsPathLeadsType::class, $notifications);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notifications->setCreatedAt(new \DateTimeImmutable('now'));
            $notifications->setLeadId($id);
            $notifications->setNotificationTitle('Notes du rendez-vous');
            $notifications->setNotificationType('Notes');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notifications);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_view', [
                'uri' => $uri,
                'start_date' => $start_date,
                'end_date' => $end_date
            ]);
        }

        $number1 = $infos_api->{'data'}->{'tel'};
        $number2 = $contact_parsed->{'collection'}[0]->{'questions_and_answers'}[0]->{'answer'};
        $suisse = "+41";
        $block_call = true;

        if (strpos($number1, $suisse) || strpos($number2, $suisse) !== false) {
            $block_call = false;
        }

        $notifications_view = $notificationsPathLeadsRepository->findBy(['lead_id' => $id], ['id' => 'DESC']);
        //dd($calls_response);
        if($calls_response !== null){
            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, "fr_FR");
            $date_call = $calls_response->{'call_list'}[0]->{'start_time'};
            $date_call_immuable = new \DateTimeImmutable($date_call);
            $date_call_fr = strftime("%A %d %B %G à %H:%M", strtotime($date_call));

            if(!empty($notificationsPathLeadsRepository->findBy(['notification_type' => 'Call', 'lead_id' => $id])) === false){
                $notifications->setNotificationType('Call');
                $notifications->setNotificationTitle('Début de l\'appel');
                $notifications->setNotificationBody('Votre appel a débuté le ' . $date_call_fr);
                $notifications->setCreatedAt($date_call_immuable);
                $notifications->setLeadId($id);
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($notifications);
                $entityManager->flush();
            }
        }

        
        

        return $this->render('calendly/contact-view.html.twig', [
            'contact_response' => $contact_parsed,
            'infos_contact' => $infos_contact,
            'email' => $contact_email,
            'infos' => $infos_api,
            'paid_state' => $paid_state,
            'user_id' => $id,
            'infos_call' => $calls_response,
            'notification_form' => $form->createView(),
            'notification_view' => $notifications_view,
            'category_form' => $form_category->createView(),
            'category_lead' => $lead_category,
            'block_call' => $block_call,
            'uri' => $uri
        ]);
    }

    /**
     * @Route("/sequences-view/{id_sequences}", name="sequences_view")
     */
    public function sequencesView($id_sequences)
    {

        $client = Client::create([
            'api_key' => 'fdatfECqdfkGcjirnCBsmujGpgGvqFkDb',
            'subdomain' => 'affiliation-ninja',
            'timeout' => 3000,
        ]);

        $infos_sequences = $client->get('mail/sequences/' . $id_sequences);

        return $this->render('main/modal/modal_seq_view.html.twig', [
            'id_sequences' => $id_sequences,
            'infos_sequences' => $infos_sequences,
        ]);
    }

    /**
     * @Route("/notif-view/{id_notif}", name="notif_view")
     */
    public function notifView(NotificationsPathLeadsRepository $notificationspathleadsrepository, $id_notif)
    {

        $client = Client::create([
            'api_key' => 'fdatfECqdfkGcjirnCBsmujGpgGvqFkDb',
            'subdomain' => 'affiliation-ninja',
        ]);

        $infos_notif = $notificationspathleadsrepository->findBy(['id' => $id_notif]);

        return $this->render('main/modal/modal_notifs_view.html.twig', [
            'id_notif' => $id_notif,
            'infos_notif' => $infos_notif,
        ]);
    }

    /**
     * @Route("/send-sms/{id}/{id_user}/{tel_int}/{tel_ext}", name="send_sms")
     */
    public function sendSms(
        Request $request,
        $id,
        $id_user,
        $tel_int,
        $tel_ext,
        NotificationsPathLeadsRepository $notificationsPathLeadsRepository
    ) {
        $sms = new Sms();
        $notifications = new NotificationsPathLeads();

        $form_sms = $this->createForm(SmsType::class, $sms);
        $form_sms->handleRequest($request);

        if ($form_sms->isSubmitted() && $form_sms->isValid()) {
            $sms->setSender($tel_int);
            $sms->setRecipient($tel_ext);
            $sms->setCreatedAt(new \DateTimeImmutable('now'));

            $notifications->setNotificationType('Sms');
            $notifications->setNotificationTitle('Sms');
            $notifications->setNotificationBody($sms->getContent());
            $notifications->setCreatedAt(new \DateTimeImmutable('now'));
            $notifications->setLeadId($id_user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notifications);
            $entityManager->persist($sms);
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [
                'id' => $id,
                'id_user' => $id_user,
            ]);
        }

        return $this->render('main/modal/modal_sms_view.html.twig', [
            'id' => $id,
            'id_user' => $id_user,
            'tel_int' => $tel_int,
            'tel_ext' => $tel_ext,
            'form_sms' => $form_sms->createView(),
        ]);
    }

    /**
     * @Route("/send_mail/{id}/{id_user}", name="send_mail")
     */
    public function sendMail(Request $request, MailerInterface $mailer, NotificationsPathLeadsRepository $notificationsPathLeadsRepository, Users $users, ModelMailRepository $modelMailRepository,$id, $id_user) {

        $client = Client::create([
            'api_key' => 'fdatfECqdfkGcjirnCBsmujGpgGvqFkDb',
            'subdomain' => 'affiliation-ninja'
        ]);

        $mail = new Mail();
        $notifications = new NotificationsPathLeads();

        $name = $client->get('users/' . $id_user)->{'data'}->{'fname'};


        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request); 
 
        if ($form->isSubmitted() && $form->isValid()) {
            
            $sender = $users->getEmail();
            
            $recipient = $client->get('users/' . $id_user)->{'data'}->{'email'};

            $notifications->setCreatedAt(new \DateTimeImmutable('now'));
            $notifications->setLeadId($id_user);
            
            if($_POST['mail_type'] == 'Premiumx1' || 
            $_POST['mail_type'] == 'Premiumx2' ||
            $_POST['mail_type'] == 'Premiumx3' ||
            $_POST['mail_type'] == 'Premiumx6' ||
            $_POST['mail_type'] == 'Premiumx12'){
                $notifications->setNotificationType('Proposition');
                $notifications->setNotificationTitle('Proposition d\'un pack ' . $_POST['mail_type']);
                $notifications->setNotificationBody($mail->getBodyMail());
            }elseif($_POST['mail_type'] == 'Accompagnementx1' || 
            $_POST['mail_type'] == 'Accompagnementx2' ||
            $_POST['mail_type'] == 'Accompagnementx3' ||
            $_POST['mail_type'] == 'Accompagnementx6' ||
            $_POST['mail_type'] == 'Accompagnementx12'){
                $notifications->setNotificationType('Proposition');
                $notifications->setNotificationTitle('Proposition d\'un pack ' . $_POST['mail_type']);
                $notifications->setNotificationBody($mail->getBodyMail());
            }else{
                $notifications->setNotificationType('Mail');
                $notifications->setNotificationTitle($mail->getObject());
                $notifications->setNotificationBody($mail->getBodyMail());
            }
            


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notifications);
            $entityManager->flush();
            

            $mail->setSender($sender);
            $mail->setRecipient($recipient);
            $mail->setCreatedAt(new \DateTimeImmutable('now'));
            $message = $mail->getBodyMail();
            //dd($mail->getBodyMail());

            $adress = new Address($recipient);
            $send = (new TemplatedEmail())
                ->from($sender)
                ->to($adress)
                ->subject($mail->getObject())
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'message' => $message
                ]);
                //dd($send);
            $mailer->send($send);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mail);
            $entityManager->flush();

            

            return $this->redirectToRoute('app_home', [
                'id' => $id,
                'id_user' => $id_user
            ]);
        }

        $accompagnement = $modelMailRepository->findBy(['Type' => 'accompagnement']);
        $premium = $modelMailRepository->findBy(['Type' => 'premium']);
        $mail_closing = $modelMailRepository->findBy(['Type' => 'email']);
        $own_mail = $modelMailRepository->findBy(['Type' => 'own_mail']);

        return $this->render('main/modal/modal_send_mail.html.twig', [
            'form_mail' => $form->createView(),
            'model_mail' => $modelMailRepository->findBy(['model_mail' => $id]),
            'id' => $id,
            'id_user' => $id_user,
            'name' => $name,
            'accompagnement' => $accompagnement,
            'premium' => $premium,
            'mail_closing' => $mail_closing,
            'own_mail' => $own_mail
            
        ]);
    }

    /**
     * @Route("/choose", name="choose")
     */
    public function choose(LeadMembershipRepository $leadMembershipRepository, Request $request){
        
        $user = $this->getUser();
        
        $lead_id = $request->query->get('lead_id');
        //dd($lead_id);
        $form_choose = $this->createForm(LeadMembershipFormType::class);
        $form_choose->handleRequest($request);

        

        if($request->isMethod('POST')){
            $notifications = new Notifs();
            $notifications->setType('give_lead');
            $notifications->setUserFrom($user->getFirstName());
            $notifications->setUserTo($request->request->get('lead_membership_form')['user']);
            $notifications->setLeadId($request->request->get('lead_id'));
            $notifications->setIsValited(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notifications);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('main/modal/modal_change_lead.html.twig', [
            'form_choose' => $form_choose->createView(),
            'lead_id' => $lead_id
        ]);
    }

}
