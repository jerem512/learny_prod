<?php

namespace App\Controller;

use App\Repository\ReportBugRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app", name="app_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ReportBugRepository $reportBugRepository): Response
    {
        $show_bugs = $reportBugRepository->findAll();

        return $this->render('main/index.html.twig', [
            'bugs' => $show_bugs
        ]);
    }
}
