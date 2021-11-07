<?php

namespace App\Service;

use App\Entity\MpaaRating;
use App\Interfaces\mpaaRatingServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class MpaaRatingService implements MpaaRatingServiceInterface
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

    public function createMpaaRating(MpaaRating $mpaaRating): void
    {
        $this->em->persist($mpaaRating);
        $this->em->flush();
    }

    /**
     * @param MpaaRating $mpaaRating
     */
    public function editMpaaRating(MpaaRating $mpaaRating): void
    {
        $this->em->flush();
    }

    /**
     * @param MpaaRating $mpaaRating
     */
    public function deleteMpaaRating(MpaaRating $mpaaRating): void
    {
        $this->em->remove($mpaaRating);
        $this->em->flush();
    }
}