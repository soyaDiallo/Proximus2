<?php

namespace App\Repository;

use App\Entity\Superviseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Superviseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Superviseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Superviseur[]    findAll()
 * @method Superviseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuperviseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Superviseur::class);
    }

    // /**
    //  * @return Superviseur[] Returns an array of Superviseur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Superviseur
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
