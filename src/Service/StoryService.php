<?php

namespace App\Service;

use App\Entity\BaseEntity;
use App\Entity\Story;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class StoryService extends BaseEntityService
{

    private EntityManagerInterface $em;
    private User $user;
    private FileUploader $uploader;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     * @param FileUploader $uploader
     */
    public function __construct
    (
        EntityManagerInterface $em,
        FileUploader           $uploader,
    )
    {
        $this->em = $em;
        $this->uploader = $uploader;
    }

    /**
     * @throws Exception
     */
    public function isStoryInstance(BaseEntity $baseEntity): bool
    {
        if (!$baseEntity instanceof Story) {
            throw new Exception('Entity is not instanceof Story');
        }
        return true;
    }

    /**
     * @param User|UserInterface $user
     */
    public function setUser(UserInterface|User $user): void
    {
        $this->user = $user;
    }

    /**
     * @param FormInterface $form
     * @throws Exception
     */
    public function create(FormInterface $form): void
    {
        $story = $form->getData();
        if ($this->isStoryInstance($story)) {
            $story->setAuthor($this->user);
        }
        $this->em->persist($story);
        $this->em->flush();
    }

    /**
     * @param FormInterface $form
     */
    public function update(FormInterface $form): void
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