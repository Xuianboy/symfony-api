<?php

namespace App\Repository;

use App\Entity\ProductResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductResponse[]    findAll()
 * @method ProductResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductResponse::class);
    }

    // /**
    //  * @return ProductResponse[] Returns an array of ProductResponse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductResponse
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
