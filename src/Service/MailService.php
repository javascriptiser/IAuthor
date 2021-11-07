<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\User;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\MailServiceInterface;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

class MailService implements MailServiceInterface
{

    private EntityManagerInterface $em;
    private UserRepository $userRepository;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     * @param UserRepository $userRepository
     */
    public function __construct(
        EntityManagerInterface $em,
        UserRepository         $userRepository,
    )
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }


    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(User $user, EmailVerifier $emailVerifier): void
    {
        $emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('sendercourse@gmail.com', 'Sender mail bot'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
    }

    public function emailConfirm(int $id): void
    {
        $user = $this->userRepository->find($id);
        if ($user !== null) {
            $user->setEmailIsVerified(true);
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}