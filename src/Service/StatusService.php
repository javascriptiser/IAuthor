<?php

namespace App\Service;

use App\Entity\Status;
use App\Interfaces\StatusServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class StatusService implements StatusServiceInterface
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
     * @param Status $status
     */
    public function createStatus(Status $status): void
    {
        $this->em->persist($status);
        $this->em->flush();
    }

    /**
     * @param Status $status
     */
    public function editStatus(Status $status): void
    {
        $this->em->flush();
    }

    /**
     * @param Status $status
     */
    public function deleteStatus(Status $status): void
    {
        $this->em->remove($status);
        $this->em->flush();
    }
}