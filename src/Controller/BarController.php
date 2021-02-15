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


    /**
     * @Route("/newbeer", name="create_beer")
     */
    public function createBeer(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName('la categorie de la bière archèche');
        //$category->setPublishedAt(new \DateTime());
        $category->setDescription('Ceci est une description');


        $beer = new Beer();
        $beer->setName('archèche');
        $beer->setDescription('Ceci est une description');
        $beer->setPublishedAt(new \DateTime());

        $beer->addCategory($category);

        $em->persist($category);
        $em->persist($beer);


        $em->flush();

        //return new Response('Saved with id '.$beer->getId() .' et la categorie :'. $category->getId());
    }

    /**
     * @Route("/repo", name="repo")
     */
    public function testRepo()
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Category::class);


        dd($em->findByName('categori1'));

    }


    private function beersApi(): array
    {
        $response = $this->http->request('GET', 'https://raw.githubusercontent.com/Antoine07/hetic_symfony/main/Introduction/Data/beers.json');

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();

        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        return $content;

    }
}
