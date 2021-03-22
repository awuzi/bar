<?php


namespace App\DataFixtures;

use App\Entity\Quote;
use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class QuoteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new FakerProvider($faker));

        for ($i = 0; $i < 10; $i++) {
            $quote = new Quote();
            $quote->setTitle($faker->catchPhrase)->setContent($faker->markdown);

            $manager->persist($quote);
        }

        $manager->flush();
    }
}
