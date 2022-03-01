<?php

namespace App\Controller;

use App\Entity\ClosingRate;
use App\Repository\ClosingRateRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ClosingRateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
            //dd('oui');
            $closingRate->setUserId($user_id);
            $em->persist($closingRate);
            $em->flush();

            return new JsonResponse($closingRate);
        }

        return $this->render('closing_rate/index.html.twig', [
            'ClosingRatesForm' => $form->createView()
        ]);
    }
}
