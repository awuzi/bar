<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Beer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // ICI vous devez coder l'insertion des données
        // avec les patterns Faker
    }
}
