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


}