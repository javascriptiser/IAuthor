<?php

namespace App\Repository;

use App\Entity\PartsOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PartsOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartsOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartsOrder[]    findAll()
 * @method PartsOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartsOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartsOrder::class);
    }

    // /**
    //  * @return PartsOrder[] Returns an array of PartsOrder objects
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
    public function findOneBySomeField($value): ?PartsOrder
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
