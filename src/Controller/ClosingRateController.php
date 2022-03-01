<?php

namespace App\Controller;

use App\Entity\ClosingRate;
use App\Repository\ClosingRateRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ClosingRateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("/app", name="app_")
*/

class ClosingRateController extends AbstractController
{
    /**
    * @Route("/closingrate", name="closingrate")
    */
    public function index(ClosingRateRepository $closingRateRepository, Request $request, EntityManagerInterface $em)
    {
        $user_id = $this->getUser();
        $date = date('Y-m-d');
        $action = $request->request->get('action');

        $closingRate = new ClosingRate();
        $form = $this->createForm(ClosingRateType::class, $closingRate);
        $form->handleRequest($request);

        if (isset($action) && !empty($action) && $action == 'show' && $request->isXmlHttpRequest()) {
            $data = $closingRateRepository->findBy(['user_id' => $user_id]);
            return new JsonResponse($data);;
        }

        if (isset($action) && $action == 'add' && $request->isXmlHttpRequest() && $request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $closingRate->setUserId($user_id);
            $em->persist($closingRate);
            $em->flush();

            return new JsonResponse($closingRate);
        }

        return $this->render('closing_rate/index.html.twig', [
            'ClosingRatesForm' => $form->createView()
        ]);
    }

    /**
    * @Route("/show-stats", name="showstats")
    */
    public function showStats(Request $request, ClosingRateRepository $closingRateRepository){
        $action = $request->request->get('action');
        $user_id = $this->getUser()->getId();

        if(isset($action) && !empty($action) && $action == 'show'){
            $datas = $closingRateRepository->findBy(['user_id' => $user_id]);

            $fup = [];
            $show_fup = [];
            $back = [];
            $close_fup = [];
            $leads = [];
            $leads_valid = [];
            $leads_contact = [];
            $leads_offer = [];
            $leads_fup = [];
            $leads_close = [];
            $leads_confirm = [];

            foreach ($datas as $data) {
                $fup[] = $data->getFup();
                $show_fup[] = $data->getShofup();
                $back[] = $data->getBack();
                $close_fup[] = $data->getClosefup();
                $leads[] = $data->getLeads();
                $leads_valid[] = $data->getLeadsValid();
                $leads_contact[] = $data->getLeadsContact();
                $leads_offer[] = $data->getLeadsOffer();
                $leads_fup[] = $data->getLeadsFup();
                $leads_close[] = $data->getLeadsClose();
                $leads_confirm[] = $data->getLeadsConfirm();
            }

            $items = [
                'fup' => array_sum($fup),
                'show_fup' => array_sum($show_fup),
                'back' => array_sum($back),
                'close_fup' => array_sum($close_fup),
                'leads' => array_sum($leads),
                'leads_valid' => array_sum($leads_valid),
                'leads_contact' => array_sum($leads_contact),
                'leads_offer' => array_sum($leads_offer),
                'leads_fup' => array_sum($leads_fup),
                'leads_close' => array_sum($leads_close),
                'leads_confirm' => array_sum($leads_confirm)
            ];

            return new JsonResponse($items);

        }
    }
}
