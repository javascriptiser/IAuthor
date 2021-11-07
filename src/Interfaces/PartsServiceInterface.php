<?php


namespace App\Interfaces;


use App\Entity\Category;
use App\Entity\Parts;

interface PartsServiceInterface
{
    /**
     * @param Parts $parts
     */
    public function createPart(Parts $parts): void;

    /**
     * @param Parts $parts
     */
    public function editPart(Parts $parts): void;

    /**
     * @param Parts $parts
     */
    public function deletePart(Parts $parts): void;
}