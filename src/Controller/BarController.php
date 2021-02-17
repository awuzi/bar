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

/*        $beer = $beerRepo->findByTerm($id, 'special');*/
        $beer = $beerRepo->find($id);

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
        $countryRepo = $this
            ->getDoctrine()
            ->getRepository(Country::class);

        $beerInCountry = $beerRepo->findBy(['country' => $id]);
        $country = $countryRepo->find($id);


        return $this->render('country/country.html.twig', [
            'beersInCountry' => $beerInCountry,
            'country' => $country
        ]);
    }


    /**
     * @Route("/category/{id}", name="category")
     * @param int $id
     * @return Response
     */
    public function category(int $id): Response
    {
        $beerRepo = $this->getDoctrine()->getRepository(Beer::class);
        $categoryRepo = $this->getDoctrine()->getRepository(Category::class);

        $beersInCategory = $beerRepo->findByCategoryId($id);
        $category = $categoryRepo->find($id);
        return $this->render('category/category.html.twig', [
            'beersInCategory' => $beersInCategory,
            'category' => $category
        ]);
    }



    public function mainMenu(): Response
    {
        $categoryRepo = $this
            ->getDoctrine()
            ->getRepository(Category::class);

        $categories = $categoryRepo->findBy(['term' => 'normal']);


        return $this->render('partials/menu.html.twig', [
            'categories' => $categories
        ]);
    }
}











