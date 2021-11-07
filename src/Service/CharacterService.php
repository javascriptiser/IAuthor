<?php

namespace App\Service;

use App\Entity\Character;
use App\Interfaces\CharacterServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class CharacterService implements CharacterServiceInterface
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
     * @param Character $character
     */
    public function createCharacter(Character $character): void
    {
        $this->em->persist($character);
        $this->em->flush();
    }

    /**
     * @param Character $character
     */
    public function editCharacter(Character $character): void
    {
        $this->em->flush();
    }

    /**
     * @param Character $character
     */
    public function deleteCharacter(Character $character): void
    {
        $this->em->remove($character);
        $this->em->flush();
    }
}