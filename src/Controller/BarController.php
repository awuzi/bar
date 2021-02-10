<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
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
            'title' => 'Home',
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
        return $this->render('beers/beers.html.twig', [
            'beers' => $this->beersApi()['beers']
        ]);
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
