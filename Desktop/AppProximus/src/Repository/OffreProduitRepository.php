<?php

namespace App\Repository;

use App\Entity\OffreProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OffreProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreProduit[]    findAll()
 * @method OffreProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreProduit::class);
    }

    // /**
    //  * @return OffreProduit[] Returns an array of OffreProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreProduit
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
