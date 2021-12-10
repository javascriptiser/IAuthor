<?php


namespace App\Service;


use App\Entity\Comments;
use App\Entity\Likes;
use App\Entity\Parts;
use App\Entity\User;
use App\Repository\LikesRepository;
use App\Repository\PartsRepository;
use App\Repository\StoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

class LikesService
{

    private EntityManagerInterface $em;
    private StoryRepository $storyRepository;
    private LikesRepository $likesRepository;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     * @param StoryRepository $storyRepository
     * @param LikesRepository $likesRepository
     */
    #[Pure] public function __construct
    (
        EntityManagerInterface $em,
        StoryRepository        $storyRepository,
        LikesRepository        $likesRepository,
    )
    {
        $this->em = $em;
        $this->storyRepository = $storyRepository;
        $this->likesRepository = $likesRepository;
    }

    public function addLike(int $storyId, User $user)
    {

        $story = $this->storyRepository->findOneBy(['id' => $storyId]);
        $like = $this->likesRepository->findOneBy(['user' => $user]);
        if ($like === null) {
            $like = new Likes();
            $like->setUser($user);
            $like->addStory($story);
            $this->em->persist($like);
            $this->em->flush();
        }else{
            $this->em->remove($like);
            $this->em->flush();
        }
        return $story->getLikes()->count();

    }

    public function deleteLike(Comments $comment)
    {
        $this->em->remove($comment);
        $this->em->flush();
    }


}