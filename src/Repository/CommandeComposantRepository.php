<?php

namespace App\Repository;

use App\Entity\CommandeComposant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandeComposant|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeComposant|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeComposant[]    findAll()
 * @method CommandeComposant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeComposantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeComposant::class);
    }

    public function findByExampleField($id)
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.user= :user_id')
            ->setParameter('user_id', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return CommandeComposant[] Returns an array of CommandeComposant objects
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
    public function findOneBySomeField($value): ?CommandeComposant
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
