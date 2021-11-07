<?php

namespace App\Controller;

use App\Entity\Story;
use App\Repository\CategoryRepository;
use App\Repository\CharacterRepository;
use App\Repository\FandomRepository;
use App\Repository\MpaaRatingRepository;
use App\Repository\StatusRepository;
use App\Repository\StoryRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Voter\AdminVoter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private UserRepository $userRepository;
    private FandomRepository $fandomRepository;
    private CategoryRepository $categoryRepository;
    private StatusRepository $statusRepository;
    private TagRepository $tagRepository;
    private CharacterRepository $characterRepository;
    private StoryRepository $storyRepository;
    private MpaaRatingRepository $mpaaRatingRepository;
    private PaginatorInterface $paginator;

    public function __construct
    (
        UserRepository       $userRepository,
        FandomRepository     $fandomRepository,
        CategoryRepository   $categoryRepository,
        StatusRepository     $statusRepository,
        TagRepository        $tagRepository,
        CharacterRepository  $characterRepository,
        StoryRepository      $storyRepository,
        MpaaRatingRepository $mpaaRatingRepository,
        PaginatorInterface   $paginator,
    )
    {
        $this->userRepository = $userRepository;
        $this->fandomRepository = $fandomRepository;
        $this->categoryRepository = $categoryRepository;
        $this->statusRepository = $statusRepository;
        $this->tagRepository = $tagRepository;
        $this->characterRepository = $characterRepository;
        $this->storyRepository = $storyRepository;
        $this->mpaaRatingRepository = $mpaaRatingRepository;
        $this->paginator = $paginator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/user', name: 'admin_user')]
    public function indexUser(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $query = $this->userRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('admin/indexUser.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/admin/fandom', name: 'admin_fandom')]
    public function indexFandom(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $query = $this->fandomRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('admin/indexFandom.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/admin/category', name: 'admin_category')]
    public function indexCategory(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $query = $this->categoryRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('admin/indexCategory.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/admin/status', name: 'admin_status')]
    public function indexStatuses(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $query = $this->statusRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('admin/indexStatus.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/admin/tag', name: 'admin_tag')]
    public function indexTags(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $query = $this->tagRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('admin/indexTag.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/admin/character', name: 'admin_character')]
    public function indexCharacter(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $query = $this->characterRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('admin/indexCharacter.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/admin/mpaaRating', name: 'admin_mpaaRating')]
    public function indexMpaaRating(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $query = $this->mpaaRatingRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );
        return $this->render('admin/indexMpaaRating.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/admin/story', name: 'admin_story')]
    public function indexStory(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $query = $this->storyRepository->queryFindAll()->getQuery();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('admin/indexStory.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
