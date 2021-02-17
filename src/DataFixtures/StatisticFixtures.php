<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

// Vos entités
use App\Entity\Client;
use App\Entity\Statistic;

class StatisticFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // TODO FIXTURES
    }

    public function getDependencies(): array
    {
        return array(
            AppFixtures::class,
        );
    }
}
