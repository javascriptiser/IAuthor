<?php

namespace App\Service;

use App\Entity\BaseEntity;
use App\Interfaces\BaseEntityServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

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

    /**
     * @param FormInterface $form
     */
    public function create(FormInterface $form): void
    {
        $entity = $form->getData();
        $this->em->persist($entity);
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
     * @param BaseEntity $entity
     */
    public function delete(BaseEntity $entity): void
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}