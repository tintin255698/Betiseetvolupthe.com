<?php

namespace App\Repository;

use App\Entity\Picnic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Picnic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picnic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picnic[]    findAll()
 * @method Picnic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PicnicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picnic::class);
    }

    // /**
    //  * @return Picnic[] Returns an array of Picnic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Picnic
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
