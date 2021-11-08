<?php


namespace App\Interfaces;


use App\Entity\BaseEntity;
use App\Entity\User;

interface UserServiceInterface extends BaseEntityServiceInterface
{
    /**
     * @param User|BaseEntity $baseEntity
     * @return bool
     */
    public function isUserInstance(User|BaseEntity $baseEntity): bool;

    /**
     * @param User|BaseEntity $baseEntity
     */
    public function create(User|BaseEntity $baseEntity): void;

    /**
     * @param User|BaseEntity $baseEntity
     */
    public function update(User|BaseEntity $baseEntity): void;

    /**
     * @param User|BaseEntity $baseEntity
     */
    public function delete(User|BaseEntity $baseEntity): void;


}