<?php

namespace App\Security;

use App\Interfaces\MailServiceInterface;
use App\Repository\UserRepository;
use App\Service\MailService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;


class EmailVerifier extends AbstractController
{
    private MailerInterface $mailer;
    private MailServiceInterface $mailService;
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private UserRepository $userRepository;

    public function __construct(
        VerifyEmailHelperInterface $helper,
        MailerInterface            $mailer,
        MailService                $mailService,
        UserRepository             $userRepository,
    )
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, UserInterface $user): RedirectResponse
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('home');
        }

        $user = $this->userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('home');
        }

        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

        $this->mailService->emailConfirm($user->getId());

        return $this->redirectToRoute('home');
    }
}
