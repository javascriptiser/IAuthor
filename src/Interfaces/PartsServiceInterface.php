<?php


namespace App\Interfaces;


use App\Entity\Parts;
use App\Entity\Story;

interface PartsServiceInterface
{
    /**
     * @param Story $story
     * @param Parts $parts
     */
    public function createPart(Story $story, Parts $parts): void;

    /**
     * @param Parts $parts
     */
    public function editPart(Parts $parts): void;

    /**
     * @param mixed $jsonData
     * @param Story $story
     */
    public function reorderParts(mixed $jsonData, Story $story): void;
}