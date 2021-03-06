<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Country;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // catégories normals
        $categoriesNormals = [
            'blonde',
            'brune',
            'blanche',
        ];

        // catégories specials
        $categoriesSpecials = [
            'houblon',
            'rose',
            'menthe',
            'grenadine',
            'réglisse',
            'marron',
            'whisky',
            'bio',
        ];

        foreach ($categoriesNormals as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }

        foreach ($categoriesSpecials as $name) {
            $category = new Category();
            $category->setName($name);
            $category->setTerm('special');
            $manager->persist($category);
        }

        $manager->flush();

        $countries = ['belgium', 'french', 'English', 'germany'];

        foreach ($countries as $name) {
            $country = new Country();
            $country->setName($name);
            $manager->persist($country);
        }

        $manager->flush();

        // associé à vos bières un nom aléatoirement
        // dans le tableau suivant
        $names = [
            'beer super',
            'beer cool',
            'beer strange',
            'beer very bad trip',
            'beer super strange',
            'beer very sweet',
            'beer hyper cool',
            'beer without alcool',
            'beer simple',
            'beer very simple',
        ];

        $count = 0;
        $repoCountry = $manager->getRepository(Country::class);
        $repoCategory = $manager->getRepository(Category::class);
        $specialCategories = $repoCategory->findBy(['term' => 'special']);
        $normalCategories = $repoCategory->findBy(['term' => 'normal']);

        while ($count < 30) {
            $beer = new Beer();
            // associer un pays une fois sur deux à une bière
            $name = $countries[rand(0, count($countries) - 1)];
            $country = $repoCountry->findOneBy(['name' => $name,]);

            $beer->addCategory($normalCategories[random_int(0, count($normalCategories) - 1)]);
            $beer->addCategory($normalCategories[random_int(0, count($normalCategories) - 1)]);
            $beer->addCategory($specialCategories[random_int(0, count($specialCategories) - 1)]);
            // ajout d'un country
            $beer->setCountry($country);

            $beer->setName($names[random_int(0, count($names) - 1)]);
            $beer->setDescription($this->lorem(random_int(5, 20)));

            $date = new \DateTime('2000-01-01');
            $day = random_int(10, 1000);
            $date->add(new \DateInterval("P".$day."D"));


            $beer->setPrice(rand(40, 200) / 10);
            $beer->setDegree(rand(40, 90) / 10);
            $beer->setPublishedAt($date);

            $manager->persist($beer);
            $count++;
        }

        $manager->flush();
    }

    private function lorem(int $nb): string
    {
        $wordList = [
            'alias',
            'consequatur',
            'aut',
            'perferendis',
            'sit',
            'voluptatem',
            'accusantium',
            'doloremque',
            'aperiam',
            'eaque',
            'ipsa',
            'quae',
            'ab',
            'illo',
            'inventore',
            'veritatis',
            'et',
            'quasi',
            'architecto',
            'beatae',
            'vitae',
            'dicta',
            'sunt',
            'explicabo',
            'aspernatur',
            'aut',
            'odit',
            'aut',
            'fugit',
            'sed',
            'quia',
            'consequuntur',
            'magni',
            'dolores',
            'eos',
            'qui',
            'ratione',
            'voluptatem',
            'sequi',
            'nesciunt',
            'neque',
            'dolorem',
            'ipsum',
            'quia',
            'dolor',
            'sit',
            'amet',
            'consectetur',
            'adipisci',
            'velit',
            'sed',
            'quia',
            'non',
            'numquam',
            'eius',
            'modi',
            'tempora',
            'incidunt',
            'ut',
            'labore',
            'et',
            'dolore',
            'magnam',
            'aliquam',
            'quaerat',
            'voluptatem',
            'ut',
            'enim',
            'ad',
            'minima',
            'veniam',
            'quis',
            'nostrum',
            'exercitationem',
            'ullam',
            'corporis',
            'nemo',
            'enim',
            'ipsam',
            'voluptatem',
            'quia',
            'voluptas',
            'sit',
            'suscipit',
            'laboriosam',
            'nisi',
            'ut',
            'aliquid',
            'ex',
            'ea',
            'commodi',
            'consequatur',
            'quis',
            'autem',
            'vel',
            'eum',
            'iure',
            'reprehenderit',
            'qui',
            'in',
            'ea',
            'voluptate',
            'velit',
            'esse',
            'quam',
            'nihil',
            'molestiae',
            'et',
            'iusto',
            'odio',
            'dignissimos',
            'ducimus',
            'qui',
            'blanditiis',
            'praesentium',
            'laudantium',
            'totam',
            'rem',
            'voluptatum',
            'deleniti',
            'atque',
            'corrupti',
            'quos',
            'dolores',
            'et',
            'quas',
            'molestias',
            'excepturi',
            'sint',
            'occaecati',
            'cupiditate',
            'non',
            'provident',
            'sed',
            'ut',
            'perspiciatis',
            'unde',
            'omnis',
            'iste',
            'natus',
            'error',
            'similique',
            'sunt',
            'in',
            'culpa',
            'qui',
            'officia',
            'deserunt',
            'mollitia',
            'animi',
            'id',
            'est',
            'laborum',
            'et',
            'dolorum',
            'fuga',
            'et',
            'harum',
            'quidem',
            'rerum',
            'facilis',
            'est',
            'et',
            'expedita',
            'distinctio',
            'nam',
            'libero',
            'tempore',
            'cum',
            'soluta',
            'nobis',
            'est',
            'eligendi',
            'optio',
            'cumque',
            'nihil',
            'impedit',
            'quo',
            'porro',
            'quisquam',
            'est',
            'qui',
            'minus',
            'id',
            'quod',
            'maxime',
            'placeat',
            'facere',
            'possimus',
            'omnis',
            'voluptas',
            'assumenda',
            'est',
            'omnis',
            'dolor',
            'repellendus',
            'temporibus',
            'autem',
            'quibusdam',
            'et',
            'aut',
            'consequatur',
            'vel',
            'illum',
            'qui',
            'dolorem',
            'eum',
            'fugiat',
            'quo',
            'voluptas',
            'nulla',
            'pariatur',
            'at',
            'vero',
            'eos',
            'et',
            'accusamus',
            'officiis',
            'debitis',
            'aut',
            'rerum',
            'necessitatibus',
            'saepe',
            'eveniet',
            'ut',
            'et',
            'voluptates',
            'repudiandae',
            'sint',
            'et',
            'molestiae',
            'non',
            'recusandae',
            'itaque',
            'earum',
            'rerum',
            'hic',
            'tenetur',
            'a',
            'sapiente',
            'delectus',
            'ut',
            'aut',
            'reiciendis',
            'voluptatibus',
            'maiores',
            'doloribus',
            'asperiores',
            'repellat',
        ];
        $sentences = [];
        shuffle($wordList);
        for ($i = 0; $i < $nb; $i++) {
            $sentences[] = $wordList[$i];
        }

        return implode(' ', $sentences);
    }
}
