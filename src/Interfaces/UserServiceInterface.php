<?php


namespace App\Interfaces;


use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

interface UserServiceInterface
{
    /**
     * @param User $user
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function createUser(User $user, UserPasswordHasherInterface $passwordHasher): void;

    /**
     * @param User $user
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function editUser(User $user, UserPasswordHasherInterface $passwordHasher): void;

    /**
     * @param User $user
     */
    public function deleteUser(User $user): void;


}