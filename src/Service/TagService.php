<?php

namespace App\Service;

use App\Entity\Tag;
use App\Interfaces\TagServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class TagService implements TagServiceInterface
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
     * @param Tag $tag
     */
    public function createTag(Tag $tag): void
    {
        $this->em->persist($tag);
        $this->em->flush();
    }

    /**
     * @param Tag $tag
     */
    public function editTag(Tag $tag): void
    {
        $this->em->flush();
    }

    /**
     * @param Tag $tag
     */
    public function deleteTag(Tag $tag): void
    {
        $this->em->remove($tag);
        $this->em->flush();
    }
}