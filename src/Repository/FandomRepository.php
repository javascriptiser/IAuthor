<?php

namespace App\Repository;

use App\Entity\Fandom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fandom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fandom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fandom[]    findAll()
 * @method Fandom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FandomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fandom::class);
    }

    public function queryFindAll(): Query
    {
        $qb = $this->createQueryBuilder('f');
        return $qb->getQuery();
    }
    // /**
    //  * @return Fandom[] Returns an array of Fandom objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fandom
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
