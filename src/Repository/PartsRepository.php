<?php

namespace App\Repository;

use App\Entity\Parts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Parts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parts[]    findAll()
 * @method Parts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parts::class);
    }

    public function getPartByStoryIdAndPartId($storyId, $partsId): QueryBuilder
    {
        return $this->createQueryBuilder('parts')
            ->select('parts, story_parts')
            ->innerJoin('parts.storyParts', 'story_parts')
            ->innerJoin('story_parts.story', 'story')
            ->where('story.id = :storyId')
            ->andWhere('parts.id = :partsId')
            ->setParameter('storyId', $storyId)
            ->setParameter('partsId', $partsId);
    }
}
