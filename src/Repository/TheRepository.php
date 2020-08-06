<?php

namespace App\Repository;

use App\Entity\The;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method The|null find($id, $lockMode = null, $lockVersion = null)
 * @method The|null findOneBy(array $criteria, array $orderBy = null)
 * @method The[]    findAll()
 * @method The[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, The::class);
    }

    // /**
    //  * @return The[] Returns an array of The objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?The
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
