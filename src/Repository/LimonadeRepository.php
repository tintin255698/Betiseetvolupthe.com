<?php

namespace App\Repository;

use App\Entity\Limonade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Limonade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Limonade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Limonade[]    findAll()
 * @method Limonade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LimonadeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Limonade::class);
    }

    // /**
    //  * @return Limonade[] Returns an array of Limonade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Limonade
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
