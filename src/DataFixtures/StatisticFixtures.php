<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Client;
use App\Entity\Statistic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StatisticFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $beers = $manager->getRepository(Beer::class)->findAll();
        $this->initClients($manager);

        $clients = $manager->getRepository(Client::class)->findAll();

        $this->initStats($manager, $clients, $beers);

        $statsRepo = $manager->getRepository(Statistic::class);

        foreach ($clients as $client) {
            $numberBeers = $statsRepo->findBy(['client' => $client->getId()]);
            $client->setNumberBeer(sizeof($numberBeers) ?? 0);
        }
        $manager->flush();
    }

    /**
     * Init client fixtures
     * @param ObjectManager $manager
     */
    public function initClients(ObjectManager $manager): void
    {
        $clientNames = [
            'Jul',
            'PNL',
            'Kaaris',
            'Booba',
            'PLK',
            'Drake',
            'Ninho',
            'Wejdene',
            'Maes',
            'La Fouine',
        ];

        foreach ($clientNames as $clientName) {
            $client = new Client();
            $client->setName($clientName);
            $client->setEmail('test@test.fr');
            $manager->persist($client);
        }
        $manager->flush();
    }

    public function initStats(ObjectManager $manager, $clients, $beers): void
    {
        for ($i = 1; $i <= 30; $i++) {
            $stat = new Statistic();
            $stat->setScore(rand(10, 70));
            $stat->setClient($clients[rand(0, count($clients) - 1)]);
            $stat->setBeer($beers[rand(0, count($beers) - 1)]);
            $manager->persist($stat);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(AppFixtures::class);
    }
}
