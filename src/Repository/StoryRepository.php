<?php

namespace App\Repository;

use App\Entity\BaseEntity;
use App\Entity\Category;
use App\Entity\Character;
use App\Entity\Fandom;
use App\Entity\MpaaRating;
use App\Entity\Status;
use App\Entity\Story;
use App\Entity\Tag;
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
            ->select('story,author,category,fandom,status,mpaaRating,tags,characters,storyParts,reviews,parts,comments')
            ->innerJoin('story.author', 'author', 'WITH', 'author = story.author')
            ->innerJoin('story.category', 'category', 'WITH', 'category = story.category')
            ->innerJoin('story.fandom', 'fandom', 'WITH', 'fandom = story.fandom')
            ->innerJoin('story.status', 'status', 'WITH', 'status  = story.status')
            ->innerJoin('story.mpaaRating', 'mpaaRating', 'WITH', 'mpaaRating = story.mpaaRating')
            ->innerJoin('story.tags', 'tags',)
            ->innerJoin('story.characters', 'characters')
            ->leftJoin('story.reviews', 'reviews')
            ->leftJoin('story.storyParts', 'storyParts', 'WITH', 'story = storyParts.story')
            ->leftJoin('storyParts.parts', 'parts')
            ->leftJoin('parts.comments', 'comments');
    }

    public function getAllUsersStories(UserInterface $user): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->andWhere('author.id = :id')
            ->setParameter('id', $user->getId())
            ->orderBy('storyParts.order_number');
        return $qb;
    }

    public function getStoryById(Story $story): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->andWhere('story.id = :id')
            ->setParameter('id', $story->getId());
        return $qb;
    }

    public function getStoryByCategoryId(Category $category): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->andWhere('category.id = :id')
            ->setParameter('id', $category->getId());
        return $qb;
    }

    public function getStoryByFandomId(Fandom $fandom): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->andWhere('fandom.id = :id')
            ->setParameter('id', $fandom->getId());
        return $qb;
    }

    public function getStoryByCharacterId(Character $character): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->andWhere('characters.id = :id')
            ->setParameter('id', $character->getId());
        return $qb;
    }

    public function getStoryByTagId(Tag $tag): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->andWhere('tags.id = :id')
            ->setParameter('id', $tag->getId());
        return $qb;
    }

    public function getStoryByStatusId(Status $status): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->andWhere('status.id = :id')
            ->setParameter('id', $status->getId());
        return $qb;
    }

    public function getStoryByMpaaRatingId(MpaaRating $mpaaRating): QueryBuilder
    {
        $qb = $this->queryFindAll();
        $qb->andWhere('mpaaRating.id = :id')
            ->setParameter('id', $mpaaRating->getId());
        return $qb;
    }


}
