<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("/country/{id}", name="country")
     * @param int $id
     * @param CountryRepository $countryRepository
     * @param BeerRepository $beerRepository
     * @return Response
     */
    public function country(
        int $id,
        CountryRepository $countryRepository,
        BeerRepository $beerRepository
    ): Response {
        $beerInCountry = $beerRepository->findBy(['country' => $id]);
        $country = $countryRepository->find($id);

        return $this->render('country/country.html.twig', [
            'beersInCountry' => $beerInCountry,
            'country' => $country,
        ]);
    }
}
