<?php

namespace App\Repository;

use App\Entity\Story;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Story|null find($id, $lockMode = null, $lockVersion = null)
 * @method Story|null findOneBy(array $criteria, array $orderBy = null)
 * @method Story[]    findAll()
 * @method Story[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Story::class);
    }

    public function queryFindAll(): QueryBuilder
    {
        return $this->createQueryBuilder('story')
            ->select('story,author,category,fandom,status,mpaaRating,tags,characters')
            ->innerJoin('story.author', 'author')
            ->innerJoin('story.category', 'category')
            ->innerJoin('story.fandom', 'fandom')
            ->innerJoin('story.status', 'status')
            ->innerJoin('story.mpaaRating', 'mpaaRating')
            ->innerJoin('story.tags', 'tags')
            ->innerJoin('story.characters', 'characters');
    }

    public function getAllUsersStories(UserInterface $user): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->where('author.id = :id')
            ->setParameter('id', $user->getId());
        return $qb;
    }


}
