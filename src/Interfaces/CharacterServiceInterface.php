<?php


namespace App\Interfaces;


use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * @param Character $character
     */
    public function createCharacter(Character $character): void;

    /**
     * @param Character $character
     */
    public function editCharacter(Character $character): void;

    /**
     * @param Character $character
     */
    public function deleteCharacter(Character $character): void;
}