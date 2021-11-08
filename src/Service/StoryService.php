<?php

namespace App\Service;

use App\Entity\BaseEntity;
use App\Entity\Story;
use App\Entity\User;
use App\Interfaces\StoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class StoryService implements StoryServiceInterface
{

    private EntityManagerInterface $em;
    private User $user;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct
    (
        EntityManagerInterface $em,
    )
    {
        $this->em = $em;
    }

    /**
     * @param User|UserInterface $user
     */
    public function setUser(UserInterface|User $user): void
    {
        $this->user = $user;
    }

    /**
     * @param Story|BaseEntity $story
     */
    public function create(Story|BaseEntity $story): void
    {
        $story->setAuthor($this->user);
        $this->em->persist($story);
        $this->em->flush();
    }

    /**
     * @param Story|BaseEntity $story
     */
    public function update(Story|BaseEntity $story): void
    {
        $this->em->flush();
    }

    /**
     * @param Story|BaseEntity $story
     */
    public function delete(Story|BaseEntity $story): void
    {
        $this->em->remove($story);
        $this->em->flush();
    }
}