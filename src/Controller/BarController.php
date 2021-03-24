<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use App\Repository\CategoryRepository;
use App\Repository\QuoteRepository;
use App\Services\Hello;
use App\Services\HelperParser;
use App\Services\QuoteService;
use cebe\markdown\Markdown;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BarController extends AbstractController
{

    /**
     * @var HttpClientInterface
     */
    private $http;

    public function __construct(HttpClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * @Route("/home", name="home")
     * @param BeerRepository $beerRepository
     * @return Response
     */
    public function index(BeerRepository $beerRepository): Response
    {
        $beers = $beerRepository->fetchByLimit(3);

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
     * @param BeerRepository $beerRepository
     * @return Response
     */
    public function beers(BeerRepository $beerRepository): Response
    {
        return $this->render('beers/beers.html.twig', [
            'beers' => $beerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/beer/{id}", name="beer")
     * @param int $id
     * @param BeerRepository $beerRepository
     * @return Response
     */
    public function show(int $id, BeerRepository $beerRepository): Response
    {
        // $beer = $beerRepository->findByTerm($id, 'special');
        return $this->render('beer/beer.html.twig', [
            'beer' => $beerRepository->find($id),
        ]);
    }

    public function mainMenu(
        string $routeName,
        string $category_id,
        CategoryRepository $categoryRepository
    ): Response {
        $categories = $categoryRepository->findBy(['term' => 'normal']);

        return $this->render('partials/menu.html.twig', [
            'categories' => $categories,
            'routeName' => $routeName,
            'category_id' => $category_id,
        ]);
    }
}











