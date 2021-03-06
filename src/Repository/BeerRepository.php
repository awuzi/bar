<?php

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    // /**
    //  * @return Beer[] Returns an array of Beer objects
    //  */

    /**
     * @param int $limit - number of beers to fetch
     * @return Beer[]
     */
    public function fetchByLimit(int $limit): array
    {
        return $this
            ->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByTerm(int $id, string $term): ?Beer
    {
        return $this->createQueryBuilder('beer')
            ->join('beer.categories', 'category')
            ->where('beer.id = :id')
            ->setParameter('id', $id)
            ->andWhere('category.term = :term')
            ->setParameter('term', $term)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function findByCategoryId(int $id): array
    {
        return $this->createQueryBuilder('beer')
            ->join('beer.categories', 'category')
            ->andWhere('category.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

}
