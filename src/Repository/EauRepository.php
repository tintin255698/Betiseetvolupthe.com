<?php

namespace App\Repository;

use App\Entity\Eau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Eau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Eau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Eau[]    findAll()
 * @method Eau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eau::class);
    }

    // /**
    //  * @return Eau[] Returns an array of Eau objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Eau
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
