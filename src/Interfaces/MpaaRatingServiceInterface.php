<?php


namespace App\Interfaces;


use App\Entity\MpaaRating;

interface MpaaRatingServiceInterface
{
    /**
     * @param MpaaRating $mpaaRating
     */
    public function createMpaaRating(MpaaRating $mpaaRating): void;

    /**
     * @param MpaaRating $mpaaRating
     */
    public function editMpaaRating(MpaaRating $mpaaRating): void;

    /**
     * @param MpaaRating $mpaaRating
     */
    public function deleteMpaaRating(MpaaRating $mpaaRating): void;
}