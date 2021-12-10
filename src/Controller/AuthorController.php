<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private UserRepository $userRepository;
    private PaginatorInterface $paginator;

    public function __construct
    (
        UserRepository $userRepository,
        PaginatorInterface      $paginator
    )
    {
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;
    }

    #[Route('/author', name: 'author')]
    public function index(Request $request): Response
    {
        $query = $this->userRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('author/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
