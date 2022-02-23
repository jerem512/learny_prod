<?php

namespace App\Controller;

use App\Repository\LeadRepository;
use App\Services\FindCalendlyInfos;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/app", name="app_")
 */

class ContactMailController extends AbstractController
{
    /**
     * @Route("/contact/mail", name="contact_mail")
     */
    public function index(LeadRepository $leadRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $count_lead = $leadRepository->countLead()[0][1];

        $data = $leadRepository->findBy([], ['id' => 'DESC']);
        
        $leads = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            100
        );

        return $this->render('contact_mail/index.html.twig', [
            'controller_name' => 'ContactMailController',
            'count_lead' => $count_lead,
            'leads' => $leads
        ]);
    }

    /**
     * @Route("/find/appointment", name="find_appointment")
     */
    public function contactToContactView(FindCalendlyInfos $findCalendlyInfos, Request $request, LeadRepository $leadRepository){

        $email = $request->query->get('email');

        $lead = $leadRepository->findBy(['email' => $email])[0];
        
        return $this->redirectToRoute('app_contact_view', [
            'lead_id' => $lead->getIdContact()
        ]);
    }

    /**
     * @Route("/search/contact", name="search_contact")
     */
    public function searchContact(Request $request, LeadRepository $leadRepository){
        $search = $request->request->get('value');
        
        $new_tab = $leadRepository->like($search);

        return $new_tab;
    }
}
