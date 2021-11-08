<?php


namespace App\Service;

use App\Entity\BaseEntity;
use App\Entity\User;
use App\Interfaces\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends BaseEntityService implements UserServiceInterface
{

    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordHasherInterface $passwordHasher
     */
    #[Pure] public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @throws Exception
     */
    public function isUserInstance(BaseEntity $baseEntity): bool
    {
        if (!$baseEntity instanceof User) {
            throw new Exception('Entity is not instanceof User');
        }
        return true;
    }

    /**
     * @param User|BaseEntity $user
     * @throws Exception
     */
    public function create(User|BaseEntity $user): void
    {
        if ($this->isUserInstance($user)) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    /**
     * @param User|BaseEntity $user
     * @throws Exception
     */
    public function update(User|BaseEntity $user): void
    {
        if ($this->isUserInstance($user)){
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            $this->em->flush();
        }
    }

    /**
     * @param User|BaseEntity $user
     * @throws Exception
     */
    public function delete(User|BaseEntity $user): void
    {
        if ($this->isUserInstance($user)){
            $this->em->remove($user);
            $this->em->flush();
        }
    }
}