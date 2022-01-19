<?php

namespace App\Controller;

use App\Entity\ReportBug;
use App\Form\ReportBugType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportBugController extends AbstractController
{
    /**
     * @Route("/report/bug", name="report_bug")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $report_bug = new ReportBug();
        $user = $this->getUser();
        $form = $this->createForm(ReportBugType::class, $report_bug);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, "fr_FR");
            $report_bug->setSender($user->getFirstName());
            $report_bug->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($report_bug);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('main/modal/modal_report_bug.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
