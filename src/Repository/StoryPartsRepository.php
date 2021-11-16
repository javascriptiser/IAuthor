<?php

namespace App\Repository;

use App\Entity\StoryParts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
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

    /**
     * @throws NonUniqueResultException
     */
    public function findByPartsId($id)
    {
        return $this->createQueryBuilder('story_parts')
            ->andWhere('story_parts.parts = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByStoryId($id)
    {
        return $this->createQueryBuilder('story_parts')
            ->andWhere('story_parts.story = :id')
            ->setParameter('id', $id)
            ->orderBy('story_parts.order_number')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $storyId
     * @param $partId
     * @return StoryParts
     * @throws NonUniqueResultException
     */
    public function findByStoryIdAndByPartId($storyId, $partId): StoryParts
    {
        return $this->createQueryBuilder('story_parts')
            ->andWhere('story_parts.story = :storyId')
            ->andWhere('story_parts.parts = :partId')
            ->setParameter('storyId', $storyId)
            ->setParameter('partId', $partId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
