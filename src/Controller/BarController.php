<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Category;
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
        return $this->render('home/home.html.twig', [
            'title' => 'Accueil',
        ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {
        return $this->render('mentions/mentions.html.twig', [
            'info' => 'mentions',
        ]);
    }


    /**
     * @Route("/beers", name="beers")
     */
    public function beers(): Response
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Beer::class);

        $beers = $em->findAll();

        return $this->render('beers/beers.html.twig', [
            'beers' => $beers,
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
