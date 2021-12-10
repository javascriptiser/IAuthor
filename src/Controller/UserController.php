<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserCreateType;
use App\Interfaces\UserServiceInterface;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private BaseController $baseController;

    public function __construct
    (
        UserService    $userService,
        BaseController $baseController,
    )
    {
        $this->baseController = $baseController;
        $this->baseController->setService($userService);
    }

    #[Route('/admin/user/create', name: 'user_create')]
    public function createUser(Request $request): Response
    {
        return $this->baseController->create(
            $request,
            UserCreateType::class,
            'admin_user',
            'user/userCreate.html.twig',
        );
    }


    #[Route('/admin/user/update/{id}', name: 'user_update')]
    public function editUser(Request $request, User $user): Response
    {
        return $this->baseController->update(
            $request,
            UserCreateType::class,
            $user,
            'admin_user',
            'user/userCreate.html.twig',
        );
    }

    #[Route('/admin/user/delete/{id}', name: 'user_delete')]
    public function deleteUser(User $user): Response
    {
        return $this->baseController->delete(
            $user,
            'admin_user',
        );
    }
}
