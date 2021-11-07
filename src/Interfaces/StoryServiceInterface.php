<?php


namespace App\Interfaces;


use App\Entity\Story;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

interface StoryServiceInterface
{
    /**
     * @param Story $story
     * @param UserInterface $user
     */
    public function createStory(Story $story, UserInterface $user): void;

    /**
     * @param Story $story
     * @param UserInterface $user
     */
    public function editStory(Story $story, UserInterface $user): void;

    /**
     * @param Story $story
     */
    public function deleteStory(Story $story): void;
}