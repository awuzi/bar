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
     * @Route("/bar", name="bar")
     */
    public function index(): Response
    {
        $beers = $this->beersApi();

        return $this->render('bar/index.html.twig', [
            'title' => 'Home',
            'beers' => $beers['beers'],
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
