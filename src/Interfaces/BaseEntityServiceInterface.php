<?php


namespace App\Interfaces;


use App\Entity\BaseEntity;

interface BaseEntityServiceInterface
{
    /**
     * @param BaseEntity $entity
     */
    public function create(BaseEntity $entity): void;

    /**
     * @param BaseEntity $entity
     */
    public function update(BaseEntity $entity): void;

    /**
     * @param BaseEntity $entity
     */
    public function delete(BaseEntity $entity): void;
}