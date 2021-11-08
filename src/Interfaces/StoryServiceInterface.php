<?php


namespace App\Interfaces;


use App\Entity\BaseEntity;
use App\Entity\Story;


interface StoryServiceInterface extends BaseEntityServiceInterface
{
    /**
     * @param Story|BaseEntity $baseEntity
     */
    public function create(Story|BaseEntity $baseEntity): void;

    /**
     * @param Story|BaseEntity $entity
     */
    public function update(Story|BaseEntity $entity): void;

    /**
     * @param Story|BaseEntity $entity
     */
    public function delete(Story|BaseEntity $entity): void;
}