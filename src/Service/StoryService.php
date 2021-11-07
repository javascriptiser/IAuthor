<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Story;
use App\Entity\User;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\StoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class StoryService implements StoryServiceInterface
{

    private EntityManagerInterface $em;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Story $story
     * @param UserInterface $user
     */
    public function createStory(Story $story, UserInterface $user): void
    {
        $story->setAuthor($user);
        $this->em->persist($story);
        $this->em->flush();
    }

    /**
     * @param Story $story
     * @param UserInterface $user
     */
    public function editStory(Story $story, UserInterface $user): void
    {
        $this->em->flush();
    }

    /**
     * @param Story $story
     */
    public function deleteStory(Story $story): void
    {
        $this->em->remove($story);
        $this->em->flush();
    }
}