<?php


namespace App\Interfaces;


use App\Entity\Fandom;

interface FandomServiceInterface
{
    /**
     * @param Fandom $fandom
     */
    public function createFandom(Fandom $fandom): void;

    /**
     * @param Fandom $fandom
     */
    public function editFandom(Fandom $fandom): void;

    /**
     * @param Fandom $fandom
     */
    public function deleteFandom(Fandom $fandom): void;

}