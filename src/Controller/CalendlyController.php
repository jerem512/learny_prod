<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Category;
use App\Entity\Mail;
use App\Entity\NotificationsPathLeads;
use App\Entity\Notifs;
use App\Form\CategoryType;
use App\Form\LeadMembershipFormType;
use App\Form\NotificationsPathLeadsType;
use App\Form\MailType;
use App\Repository\CategoryRepository;
use App\Repository\LeadMembershipRepository;
use App\Repository\LeadRepository;
use App\Repository\ModelMailRepository;
use App\Repository\NotificationsPathLeadsRepository;
use App\Services\CheckTaxNumberService;
use App\Services\ClientLearnyboxService;
use App\Services\FindCalendlyInfos;
use App\Services\InfosCallService;
use App\Services\InfosContactService;
use App\Services\NotificationPathService;
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
     * @Route("/contact-view/{lead_id}", name="contact_view")
     */
    public function contactView(
        Request $request,
        LeadRepository $leadRepository,
        CategoryRepository $categoryRepository,
        NotificationsPathLeadsRepository $notificationsPathLeadsRepository,
        ClientLearnyboxService $clientLearnyboxService,
        InfosContactService $infosContactService,
        InfosCallService $infosCallService,
        CheckTaxNumberService $checkTaxService,
        NotificationPathService $notificationsPathService,
        FindCalendlyInfos $findCalendlyInfos,
        $lead_id
        ): Response {

        $uri = [];
        $contact_response = [];
        $calls_response = [];
        $block_call = true;
        $NaN = false;

        $user = $this->getUser();
        $lead = $leadRepository->findby(['id_contact' => $lead_id])[0];
        $client = $clientLearnyboxService->clientLearnybox();
        $infos = $findCalendlyInfos->setUserInfos($user->getCalendlyToken());
        $findUuid = $findCalendlyInfos->findUuid($lead->getEmail(), $infos, $user->getCalendlyToken());
        if(isset($findUuid) && $findUuid !== false){
            $uri = str_replace('https://api.calendly.com/scheduled_events/', '', $findUuid->{'uri'});
            $contact_response = $infosContactService->getInfosContact($uri, $user);
            $calls_response = $infosCallService->getInfosCall($user, $findUuid->{'start_time'}, $findUuid->{'end_time'});
            $lead_number = $contact_response->{'collection'}[0]->{'questions_and_answers'}[0]->{'answer'};
            $block_call = $checkTaxService->checkTaxNumber($lead_number);

            $NaN = $checkTaxService->isNumber($block_call);
        }

        

        $infos_api = $client->get('mail/contacts/' . $lead_id);
        $paid_state = $client->get('transactions/user/' . $lead_id);

        $category = new Category();

        $form_category = $this->createForm(CategoryType::class, $category);
        $form_category->handleRequest($request);

        if ($form_category->isSubmitted() && $form_category->isValid()) {

            $category->setUserId($lead_id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_view', [
                'lead_id' => $lead_id,
            ]);
        }

        $lead_category = $categoryRepository->findBy(['user_id' => $lead_id]);
        $notifications = new NotificationsPathLeads();

        $form = $this->createForm(NotificationsPathLeadsType::class, $notifications);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notificationsPathService->setNotificationPath($notifications, 'Notes', 'Notes du rendez-vous', $form->getData()->getNotificationBody(), new \DateTimeImmutable('now'), $lead_id);

            return $this->redirectToRoute('app_contact_view', [
                'lead_id' => $lead_id
            ]);
        }


        $notifications_view = $notificationsPathLeadsRepository->findBy(['lead_id' => $lead_id], ['id' => 'DESC']);

        if($calls_response !== null && !empty($calls_response)){
            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, "fr_FR");
            $date_call = $calls_response->{'call_list'}[0]->{'start_time'};
            $date_call_immuable = new \DateTimeImmutable($date_call);
            $date_call_fr = strftime("%A %d %B %G à %H:%M", strtotime($date_call));

            if(!empty($notificationsPathLeadsRepository->findBy(['notification_type' => 'Call', 'lead_id' => $lead_id])) === false){
                $notificationsPathService->setNotificationPath($notifications, 'Call', 'Début de l\'appel', 'Votre appel a débuté le ' . $date_call_fr, $date_call_immuable, $lead_id);
            }
        }

        return $this->render('calendly/contact-view.html.twig', [
            'contact_response' => $contact_response,
            'infos_contact' => $lead,
            'email' => $lead->getEmail(),
            'infos' => $infos_api,
            'paid_state' => $paid_state,
            'lead_id' => $lead_id,
            'infos_call' => $calls_response,
            'notification_form' => $form->createView(),
            'notification_view' => $notifications_view,
            'category_form' => $form_category->createView(),
            'category_lead' => $lead_category,
            'block_call' => $block_call,
            'NaN' => $NaN,
            'uri' => $uri
        ]);
    }

    /**
     * @Route("/sequences-view/{id_sequences}", name="sequences_view")
     */
    public function sequencesView(ClientLearnyboxService $clientLearnyboxService, $id_sequences)
    {
        $client = $clientLearnyboxService->clientLearnybox();

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

        $infos_notif = $notificationspathleadsrepository->findBy(['id' => $id_notif]);

        return $this->render('main/modal/modal_notifs_view.html.twig', [
            'id_notif' => $id_notif,
            'infos_notif' => $infos_notif,
        ]);
    }

    /**
     * @Route("/send_mail/{id}/{lead_id}", name="send_mail")
     */
    public function sendMail(Request $request, MailerInterface $mailer, ClientLearnyboxService $clientLearnyboxService, NotificationPathService $notificationsPathService, Users $users, ModelMailRepository $modelMailRepository,$id, $lead_id) {

        $client = $clientLearnyboxService->clientLearnybox();

        $mail = new Mail();
        $notifications = new NotificationsPathLeads();

        $name = $client->get('users/' . $lead_id)->{'data'}->{'fname'};

        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request); 
 
        if ($form->isSubmitted() && $form->isValid()) {
            
            $sender = $users->getEmail();
            $recipient = $client->get('users/' . $lead_id)->{'data'}->{'email'};
            $message = $mail->getBodyMail();
            
            if($request->request->get('mail_type') == 'Premiumx1' || 
            $request->request->get('mail_type') == 'Premiumx2' ||
            $request->request->get('mail_type') == 'Premiumx3' ||
            $request->request->get('mail_type') == 'Premiumx6' ||
            $request->request->get('mail_type') == 'Premiumx12'){
                $notificationType = 'Proposition';
                $notificationTitle = 'Proposition d\'un pack ' . $request->request->get('mail_type');
            }elseif($request->request->get('mail_type') == 'Accompagnementx1' || 
            $request->request->get('mail_type') == 'Accompagnementx2' ||
            $request->request->get('mail_type') == 'Accompagnementx3' ||
            $request->request->get('mail_type') == 'Accompagnementx6' ||
            $request->request->get('mail_type') == 'Accompagnementx12'){
                $notificationType = 'Proposition';
                $notificationTitle = 'Proposition d\'un pack ' . $request->request->get('mail_type');
            }else{
                $notificationType = 'Mail';
                $notificationTitle =$mail->getObject();
            }
            
            $notificationsPathService->setNotificationPath($notifications, $notificationType, $notificationTitle, $message, new \DateTimeImmutable('now'), $lead_id);
            
            $mail->setSender($sender);
            $mail->setRecipient($recipient);
            $mail->setCreatedAt(new \DateTimeImmutable('now'));

            $adress = new Address($recipient);
            $send = (new TemplatedEmail())
                ->from($sender)
                ->to($adress)
                ->subject($mail->getObject())
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'message' => $message
                ]);
            $mailer->send($send);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mail);
            $entityManager->flush();

            

            return $this->redirectToRoute('app_home', [
                'id' => $id,
                'lead_id' => $lead_id
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
            'lead_id' => $lead_id,
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
