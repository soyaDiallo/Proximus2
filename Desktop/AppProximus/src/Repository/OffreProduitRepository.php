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

    public function getProduitOffre($cat)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
       SELECT produit.id,designation,qte,offre_id,categorie_id
       FROM produit
       INNER JOIN offre_produit
       ON produit.id = offre_produit.produit_id
       INNER JOIN categorie_produit
       ON produit.id = categorie_produit.produit_id
       where categorie_produit.categorie_id=:cat
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['cat' => $cat]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
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
