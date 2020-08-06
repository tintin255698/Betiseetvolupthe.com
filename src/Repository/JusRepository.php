<?php

namespace App\Repository;

use App\Entity\Jus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jus[]    findAll()
 * @method Jus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jus::class);
    }

    // /**
    //  * @return Jus[] Returns an array of Jus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jus
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
