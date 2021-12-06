<?php


namespace App\Service;

use App\Entity\BaseEntity;
use App\Entity\Category;
use App\Entity\Fandom;
use App\Entity\Review;
use App\Entity\Story;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Form\FormInterface;

class ReviewsService
{

    private EntityManagerInterface $em;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     */
    #[Pure] public function __construct
    (
        EntityManagerInterface $em,
    )
    {
        $this->em = $em;
    }

    public function createReview(Review $review, Story $story, User $user)
    {
        $review->setCreatedAt(new DateTimeImmutable());
        $review->addStory($story);
        $review->setUser($user);
        $this->em->persist($review);
        $this->em->flush();
    }

    public function deleteReview(Review $review)
    {
        $this->em->remove($review);
        $this->em->flush();
    }


}