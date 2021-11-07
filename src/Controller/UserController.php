<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserCreateType;
use App\Interfaces\UserServiceInterface;
use App\Service\UserService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserServiceInterface $userService;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct
    (
        UserService        $userService,
        UserPasswordHasherInterface $passwordHasher
    )
    {
        $this->userService = $userService;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/admin/user/create', name: 'user_create')]
    public function createUser(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(UserCreateType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->createUser($form->getData(), $this->passwordHasher);
            return new RedirectResponse($this->generateUrl('admin_user'));
        }
        return $this->render('user/userCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/admin/user/edit/{id}', name: 'user_edit')]
    public function editUser(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(UserCreateType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->editUser($form->getData(), $this->passwordHasher);
            return new RedirectResponse($this->generateUrl('admin_user'));
        }
        return $this->render('user/userCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/user/delete/{id}', name: 'user_delete')]
    public function deleteUser(User $user): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->userService->deleteUser($user);
        return new RedirectResponse($this->generateUrl('admin_user'));
    }
}
