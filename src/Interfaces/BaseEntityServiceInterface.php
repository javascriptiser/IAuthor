<?php


namespace App\Interfaces;


use App\Entity\BaseEntity;
use Symfony\Component\Form\FormInterface;

interface BaseEntityServiceInterface
{
    /**
     * @param FormInterface $form
     */
    public function create(FormInterface $form): void;

    /**
     * @param FormInterface $form
     */
    public function update(FormInterface $form): void;

    /**
     * @param BaseEntity $entity
     */
    public function delete(BaseEntity $entity): void;
}