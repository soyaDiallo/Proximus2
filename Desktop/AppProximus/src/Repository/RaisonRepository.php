<?php

namespace App\Repository;

use App\Entity\Raison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Raison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Raison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Raison[]    findAll()
 * @method Raison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Raison::class);
    }

    // /**
    //  * @return Raison[] Returns an array of Raison objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Raison
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
