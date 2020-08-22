<?php

namespace App\Repository;

use App\Entity\Repas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repas[]    findAll()
 * @method Repas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repas::class);
    }

    public function entree()
    {
        return $this->createQueryBuilder('u')
            ->select('u, u.produit, u.id, u.type' )
            ->andwhere('u.type= :plat')
            ->setParameter('plat', 'entre')
            ->getQuery()
            ->getResult();
    }

    public function plat()
    {
        return $this->createQueryBuilder('u')
            ->select('u, u.produit, u.id, u.type' )
            ->andwhere('u.type= :plat')
            ->setParameter('plat', 'plat')
            ->getQuery()
            ->getResult();
    }

    public function dessert()
    {
        return $this->createQueryBuilder('u')
            ->select('u, u.produit, u.id, u.type' )
            ->andwhere('u.type= :plat')
            ->setParameter('plat', 'dessert')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Repas[] Returns an array of Repas objects
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
    public function findOneBySomeField($value): ?Repas
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
