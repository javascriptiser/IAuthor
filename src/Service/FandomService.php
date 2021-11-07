<?php

namespace App\Service;

use App\Entity\Fandom;
use App\Interfaces\FandomServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class FandomService implements FandomServiceInterface
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
     * @param Fandom $fandom
     */
    public function createFandom(Fandom $fandom): void
    {
        $this->em->persist($fandom);
        $this->em->flush();
    }

    /**
     * @param Fandom $fandom
     */
    public function editFandom(Fandom $fandom): void
    {
        $this->em->flush();
    }

    /**
     * @param Fandom $fandom
     */
    public function deleteFandom(Fandom $fandom): void
    {
        $this->em->remove($fandom);
        $this->em->flush();
    }
}