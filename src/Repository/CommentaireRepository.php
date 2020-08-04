<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    /**
    //  * @return Commentaire[] Returns an array of Commentaire objects
    //  */

    public function findByExampleField()
    {
        return $this->createQueryBuilder('c')
            ->select('c, c.id, c.note, c.contenu, u.prenom, u.nom'  )
            ->join('c.user', 'u')
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByExampleField2()
    {
        return $this->createQueryBuilder('c')
            ->select('c, c.id, c.note, c.contenu, u.prenom, u.nom'  )
            ->join('c.user', 'u')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByExampleField3()
    {
        return $this->createQueryBuilder('c')
            ->select('AVG(c.note) as note')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByExampleField4()
    {
        return $this->createQueryBuilder('c')
            ->select('c, c.id, c.note, c.contenu, u.prenom, u.nom, u.id'  )
            ->join('c.user', 'u')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Commentaire
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
