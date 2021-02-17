<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\StatisticRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    /**
     * @Route("/stats", name="stats")
     * @param StatisticRepository $statisticRepository
     * @param ClientRepository $clientRepository
     * @return Response
     */
    public function stats(
        StatisticRepository $statisticRepository,
        ClientRepository $clientRepository
    ): Response {
        return $this->render('stats/stats.html.twig', [
            'nb_client' => count($clientRepository->findAll()),
            'stats' => $statisticRepository->findAll(),
        ]);
    }
}
