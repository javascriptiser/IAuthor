<?php


namespace App\Interfaces;


use App\Entity\Status;

interface StatusServiceInterface
{
    /**
     * @param Status $status
     */
    public function createStatus(Status $status): void;

    /**
     * @param Status $status
     */
    public function editStatus(Status $status): void;

    /**
     * @param Status $status
     */
    public function deleteStatus(Status $status): void;
}