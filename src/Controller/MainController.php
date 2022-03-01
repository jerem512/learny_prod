<?php

namespace App\Controller;

use App\Repository\ClosingRateRepository;
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
    public function index(ReportBugRepository $reportBugRepository, ClosingRateRepository $closingRateRepository): Response
    {
        $user_id = $this->getUser()->getId();
        $show_bugs = $reportBugRepository->findAll();
        $datas = $closingRateRepository->findBy(['user_id' => $user_id]);

        $fup = [];

            $leads = [];
            $leads_valid = [];
            $leads_close = [];

            foreach ($datas as $data) {
                $leads[] = $data->getLeads();
                $leads_valid[] = $data->getLeadsValid();
                $leads_close[] = $data->getLeadsClose();
            }

            $items = [
                'leads' => array_sum($leads),
                'leads_valid' => array_sum($leads_valid),
                'leads_close' => array_sum($leads_close)
            ];

        return $this->render('main/index.html.twig', [
            'bugs' => $show_bugs,
            'rates' => $items
        ]);
    }
}
