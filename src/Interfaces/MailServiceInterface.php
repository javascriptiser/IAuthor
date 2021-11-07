<?php


namespace App\Interfaces;


use App\Entity\User;
use App\Security\EmailVerifier;

interface MailServiceInterface
{
    /**
     * @param User $user
     */
    public function sendEmail(User $user, EmailVerifier $emailVerifier): void;

    /**
     * @param int $id
     */
    public function emailConfirm(int $id): void;
}