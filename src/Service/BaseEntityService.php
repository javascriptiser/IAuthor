<?php

namespace App\Service;

use App\Entity\BaseEntity;
use App\Interfaces\BaseEntityServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class BaseEntityService implements BaseEntityServiceInterface
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

    public function create(BaseEntity $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param BaseEntity $entity
     */
    public function update(BaseEntity $entity): void
    {
        $this->em->flush();
    }

    /**
     * @param BaseEntity $entity
     */
    public function delete(BaseEntity $entity): void
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}