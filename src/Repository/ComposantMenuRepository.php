<?php

namespace App\Repository;

use App\Entity\ComposantMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ComposantMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComposantMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComposantMenu[]    findAll()
 * @method ComposantMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposantMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComposantMenu::class);
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
    //  * @return ComposantMenu[] Returns an array of ComposantMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComposantMenu
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
