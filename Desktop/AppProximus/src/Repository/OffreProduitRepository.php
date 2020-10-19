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

    public function getAllVentes()
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.dateSignature IS NOT NULL')
            ->getQuery()
            ->getResult();
    }

    public function getAllOffres()
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.dateSignature IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function getVentesByAgent($agent)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.dateSignature IS NOT NULL')
            ->andWhere('o.agent = :val')
            ->setParameter('val', $agent)
            ->getQuery()
            ->getResult();
    }

    public function getOffresByAgent($agent)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.dateSignature IS NULL')
            ->andWhere('o.agent = :val')
            ->setParameter('val', $agent)
            ->getQuery()
            ->getResult();
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
