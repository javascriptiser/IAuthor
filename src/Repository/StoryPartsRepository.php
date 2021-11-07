<?php

namespace App\Repository;

use App\Entity\StoryParts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoryParts|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoryParts|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoryParts[]    findAll()
 * @method StoryParts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryPartsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoryParts::class);
    }

    // /**
    //  * @return StoryParts[] Returns an array of StoryParts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StoryParts
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
