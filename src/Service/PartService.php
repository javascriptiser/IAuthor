<?php

namespace App\Service;


use App\Entity\Parts;
use App\Interfaces\PartsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class PartService implements PartsServiceInterface
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

    public function createPart(Parts $parts): void
    {
        $this->em->persist($parts);
        $this->em->flush();
    }

    /**
     * @param Parts $parts
     */
    public function editPart(Parts $parts): void
    {
        $this->em->flush();
    }

    /**
     * @param Parts $parts
     */
    public function deletePart(Parts $parts): void
    {
        $this->em->remove($parts);
        $this->em->flush();
    }
}