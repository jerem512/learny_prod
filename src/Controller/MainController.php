<?php

namespace App\Controller;

use App\Entity\Objectives;
use App\Repository\CloseRepository;
use App\Repository\ClosingRateRepository;
use App\Repository\ObjectivesRepository;
use App\Repository\ReportBugRepository;
use App\Services\CheckOfferService;
use App\Services\DidLeadPayService;
use App\Services\FiveEventsService;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(ReportBugRepository $reportBugRepository,
    ClosingRateRepository $closingRateRepository,
    CloseRepository $closeRepository, CheckOfferService $checkOfferService,
    FiveEventsService $fiveEventsService,
    ObjectivesRepository $objectivesRepository,
    EntityManagerInterface $entityManager,
    DidLeadPayService $didLeadPayService): Response
    {
        $account_connected = false;
        $user = $this->getUser();
        $user_id = $user->getId();

        if ($objectivesRepository->findOneBy(['user_id' => $user_id]) === null) {

            $goals = new Objectives;
            $goals->setGoalWeek(500);
            $goals->setGoalMonth(2000);
            $goals->setGoalYear(24000);
            $goals->setUserId($user_id);

            $entityManager->persist($goals);
            $entityManager->flush();
        }

        if ($user->getCalendlyToken() !== null) {
            $account_connected = true;
        }

        $show_bugs = $reportBugRepository->findAll();
        $datas = $closingRateRepository->findBy(['user_id' => $user_id]);
        $sales = $closeRepository->findBy(['user_id' => $user_id]);
        $top = $closeRepository->findByGroup($user_id);
        $events = $account_connected === true ? $fiveEventsService->fiveEvents($user) : false;
        $events_infos = $account_connected === true ? $fiveEventsService->fiveEventsInfos($user, $events) : false;
        $objectives = $objectivesRepository->findOneBy(['user_id' => $user]);

        $close = [];

        $ca = [];
        $top_sales = [];

        foreach ($sales as $sale) {
            $offer = $checkOfferService->checkOffer($sale->getName());
            $close[] = $didLeadPayService->verfifyPayment($user->getSubdomainLearnybox(), $user->getApiKeyLearnybox(), $sale->getLeadId()) ? $offer->getCommission() : 0;
            $ca[] = $didLeadPayService->verfifyPayment($user->getSubdomainLearnybox(), $user->getApiKeyLearnybox(), $sale->getLeadId()) ? $offer->getPriceHt() : 0;
        }

        $percent_week = array_sum($close) / $objectives->getGoalWeek() * 100;
        $percent_month = array_sum($close) / $objectives->getGoalMonth() * 100;
        $percent_year = array_sum($close) / $objectives->getGoalYear() * 100;

        foreach ($top as $top_sale) {
            $top_offer = $checkOfferService->checkOffer($top_sale['name']);

            $top_sales[] = [
                'name' => $top_offer->getName(),
                'count' => $top_sale['count'],
                'price' => $top_offer->getPrice(),
                'nb_monthly_payment' => $top_offer->getNbMonthlyPayment(),
                'front_name' => $top_offer->getFrontName(),
            ];
        }

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
            'leads_close' => array_sum($leads_close),
        ];

        return $this->render('main/index.html.twig', [
            'bugs' => $show_bugs,
            'rates' => $items,
            'sales' => array_sum($close),
            'close' => $sales,
            'ca' => array_sum($ca),
            'top_sales' => $top_sales,
            'objectives_week' => $objectives->getGoalWeek(),
            'objectives_month' => $objectives->getGoalMonth(),
            'objectives_year' => $objectives->getGoalYear(),
            'percent_week' => $percent_week,
            'percent_month' => $percent_month,
            'percent_year' => $percent_year,
            'events' => $events_infos,
            'account_connected' => $account_connected,
        ]);
    }
}
