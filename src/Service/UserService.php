<?php

namespace App\Service;

use App\Entity\User;
use App\Interfaces\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserServiceInterface
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
     * @param User $user
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function createUser(User $user, UserPasswordHasherInterface $passwordHasher): void
    {
        $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function editUser(User $user, UserPasswordHasherInterface $passwordHasher): void
    {
        $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function deleteUser(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}