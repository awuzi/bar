
<h1 align="center">TP d'initiation au framework Symfony</h1>
<h2 align="center"> <img src="https://travis-ci.com/awuzi/bar.svg?branch=master"></h2>
<p align="center">
 Symfony5 - PHP - Twig - Bootstrap - SCSS
</p>

## Groupe 23:
LAMRI Yahia - SECHER Pierre - SAOUD Imed - NUNES Gena - PONS Charley - BARRE Arthur - THIBAULT Corentin - YAZBECK Petter


## UML
*Diagramme UML :*
![](/schema.png "Diagramme UML")

## Part 4.
```php
public function findCatSpecial(int $id)
    {
        return $this->createQueryBuilder('c')
            ->join('c.beers', 'b') // raisonner en terme de relation
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->andWhere('c.term = :term')
            ->setParameter('term', 'special')
            ->getQuery()
            ->getResult();
    }
```
- Ce code va chercher fait une jointure entre la table `beer` et `category` et va chercher les catégories speciales d'une bière 

## Install 
```
$ > git clone https://github.com/awuzi/bar && cd bar/
$ > composer install && npm install
```
#### 1. Run servers
```
$ > symfony server:start
$ > npm run watch
```

#### 2. Create database & load fixtures
```
$ > php bin/console doctrine:database:create
$ > php bin/console make:migration
$ > php bin/console doctrine:migrations:migrate
$ > php bin/console doctrine:fixtures:load
```

## Build
```
$ > npm run build
```
