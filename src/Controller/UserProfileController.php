<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserCreateType;
use App\Repository\StoryPartsRepository;
use App\Repository\StoryRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Voter\AdminVoter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    private StoryRepository $storyRepository;
    private PaginatorInterface $paginator;
    private UserService $userService;

    public function __construct
    (
        StoryRepository    $storyRepository,
        PaginatorInterface $paginator,
        UserService        $userService,
    )
    {
        $this->storyRepository = $storyRepository;
        $this->paginator = $paginator;
        $this->userService = $userService;
    }

    #[Route('/user/{id}', name: 'user_profile')]
    public function index(User $user, UserRepository $userRepository): Response
    {

        return $this->render('user_profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/avatar/{id}', name: 'user_avatar_update', methods: ['GET', 'POST'])]
    public function updateAvatar(Request $request, User $user): Response
    {
        if ($request->isXmlHttpRequest()) {
            $this->userService->updateAvatarAjax($request->request->get('image'), $user);
//            $this->userService->updateAvatarAjax($request->files->get('image'), $user);
            return new JsonResponse(1);
        }
        $prevImageName = $user->getImage();
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createFormBuilder($user)
            ->add('image', FileType::class)
            ->add('save', SubmitType::class, ['label' => 'Подтвердить'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $this->userService->updateWithImage($prevImageName, $form);
            return new RedirectResponse($this->generateUrl('user_profile', ['id' => $user->getId()]));
        }
        return $this->render('user/changeAvatar.html.twig', [
            'form' => $form->createView(),
            'prevImageName' => $prevImageName
        ]);
    }

    #[Route('/user/profile/mystories', name: 'user_my_stories')]
    public function myStories(): Response
    {
        $stories = $this->storyRepository->getAllUsersStories($this->getUser())->getQuery()->getResult();

        return $this->render('user_profile/my_stories.html.twig', [
            'stories' => $stories,
        ]);
    }
}
