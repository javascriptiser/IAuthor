<?php

namespace App\Controller;

use App\Repository\StoryRepository;
use App\Voter\AdminVoter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    private StoryRepository $storyRepository;
    private PaginatorInterface $paginator;

    public function __construct
    (
        StoryRepository $storyRepository,
        PaginatorInterface $paginator,
    )
    {
        $this->storyRepository = $storyRepository;
        $this->paginator = $paginator;
    }

    #[Route('/user/profile', name: 'user_profile')]
    public function index(): Response
    {
        return $this->render('user_profile/index.html.twig', [
            'controller_name' => 'UserProfileController',
        ]);
    }

    #[Route('/user/profile/mystories', name: 'user_my_stories')]
    public function myStories(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $query = $this->storyRepository->getAllUsersStories($this->getUser())->getQuery();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('user_profile/my_stories.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
