<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BarController extends AbstractController
{

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $http;

    public function __construct(HttpClientInterface $http)
    {
        $this->http = $http;
    }


    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $beerRepo = $this->getDoctrine()->getRepository(Beer::class);

        $beers = $beerRepo->fetchByLimit(3);

        return $this->render('home/home.html.twig', [
            'title' => 'Accueil',
            'beers' => $beers,
        ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {
        return $this->render('mentions/mentions.html.twig', [
            'info' => 'mentions légales',
        ]);
    }


    /**
     * @Route("/beers", name="beers")
     */
    public function beers(): Response
    {
        $em = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Beer::class);

        $beers = $em->findAll();

        return $this->render('beers/beers.html.twig', [
            'beers' => $beers,
        ]);
    }

    /**
     * @Route("/beer/{id}", name="beer")
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $beerRepo = $this
            ->getDoctrine()
            ->getRepository(Beer::class);

        $beer = $beerRepo->findByTerm($id, "special");

        return $this->render('beer/beer.html.twig', [
            'beer' => $beer,
        ]);
    }


    /**
     * @Route("/country/{id}", name="country")
     * @param int $id
     * @return Response
     */
    public function country(int $id): Response
    {
        $beerRepo = $this
            ->getDoctrine()
            ->getRepository(Beer::class);

        $beerInCountry = $beerRepo->findBy(['country' => $id]);

        return $this->render('country/country.html.twig', [
            'beersInCountry' => $beerInCountry,
        ]);
    }
}
