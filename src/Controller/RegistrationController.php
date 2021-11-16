<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Interfaces\MailServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Security\EmailVerifier;
use App\Service\MailService;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private UserServiceInterface $userService;
    private EmailVerifier $emailVerifier;
    private MailServiceInterface $mailService;

    public function __construct
    (
        UserService $userService,
        EmailVerifier $emailVerifier,
        MailService $mailService
    )
    {
        $this->userService = $userService;
        $this->emailVerifier = $emailVerifier;
        $this->mailService = $mailService;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws
     * @throws Exception
     */
    #[Route('/registration', name: 'registration')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): RedirectResponse|Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->create($form);
            $this->mailService->sendEmail($user, $this->emailVerifier);
            return $this->redirectToRoute('app_login');
        }
        return $this->render(
            'registration/index.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/verify/email', name: 'app_verify_email', methods: ['GET'])]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
            return $this->render('registration/confirmation_email_success.html.twig');
        } catch (VerifyEmailExceptionInterface $exception) {
            return $this->render('registration/confirmation_email_error.html.twig');
        }

    }
}