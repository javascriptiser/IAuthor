<?php

namespace App\Repository;

use App\Entity\MpaaRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MpaaRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method MpaaRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method MpaaRating[]    findAll()
 * @method MpaaRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MpaaRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MpaaRating::class);
    }
    public function queryFindAll(): Query
    {
        $qb = $this->createQueryBuilder('f');
        return $qb->getQuery();
    }
    // /**
    //  * @return MpaaRating[] Returns an array of MpaaRating objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MpaaRating
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
