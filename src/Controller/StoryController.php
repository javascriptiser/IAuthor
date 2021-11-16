<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Character;
use App\Entity\Fandom;
use App\Entity\Story;
use App\Entity\Tag;
use App\Form\StoryType;
use App\Repository\StoryRepository;
use App\Service\StoryService;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class StoryController extends AbstractController
{
    private BaseController $baseController;
    private PaginatorInterface $paginator;
    private StoryRepository $storyRepository;

    public function __construct
    (
        BaseController     $baseController,
        StoryService       $storyService,
        Security           $security,
        PaginatorInterface $paginator,
        StoryRepository    $storyRepository,
    )
    {
        $this->baseController = $baseController;
        $storyService->setUser($security->getUser());
        $this->baseController->setService($storyService);
        $this->paginator = $paginator;
        $this->storyRepository = $storyRepository;
    }

    #[Route('/admin/story/create', name: 'story_create')]
    public function createStory(Request $request): Response
    {

        return $this->baseController->create(
            $request,
            new StoryType(),
            'admin_story',
            'story/index.html.twig',
        );
    }

    #[Route('/admin/story/update/{id}', name: 'story_update')]
    public function updateStory(Request $request, Story $story): Response
    {
        return $this->baseController->update(
            $request,
            new StoryType(),
            $story,
            'admin_story',
            'story/index.html.twig',
        );
    }

    /**
     * @throws Exception
     */
    #[Route('/admin/story/delete/{id}', name: 'story_delete')]
    public function deleteStory(Request $request, Story $story): Response
    {
        return $this->baseController->deleteWithConfirmation(
            $request,
            $story,
            'admin_story',
            'admin_story',
        );
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/readstory/{id}', name: 'story_read')]
    public function readStory(Story $story): Response
    {
//        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $proxyStory = $this->storyRepository->getStoryById($story)->getQuery()->getOneOrNullResult();

        return $this->render('story/readStory.html.twig', [
            'story' => $proxyStory,
        ]);
    }

    #[Route('stories/category/{id}', name: 'stories/category_show')]
    public function showStoriesInCategory(Request $request, Category $category): Response
    {
        $query = $this->storyRepository->getStoryByCategoryId($category)->getQuery()->getResult();
        return $this->baseController->showWithPagination($request, $query, 'story/readStories.html.twig');
    }

    #[Route('stories/fandom/{id}', name: 'stories/fandom_show')]
    public function showStoriesInFandom(Request $request, Fandom $fandom): Response
    {
        $query = $this->storyRepository->getStoryByFandomId($fandom)->getQuery()->getResult();
        return $this->baseController->showWithPagination($request, $query, 'story/readStories.html.twig');
    }

    #[Route('stories/character/{id}', name: 'stories/character_show')]
    public function showStoriesInCharacter(Request $request, Character $character): Response
    {
        $query = $this->storyRepository->getStoryByCharacterId($character)->getQuery()->getResult();
        return $this->baseController->showWithPagination($request, $query, 'story/readStories.html.twig');
    }

    #[Route('stories/tag/{id}', name: 'stories/tag_show')]
    public function showStoriesInTags(Request $request, Tag $tag): Response
    {
        $query = $this->storyRepository->getStoryByTagId($tag)->getQuery()->getResult();
        return $this->baseController->showWithPagination($request, $query, 'story/readStories.html.twig');
    }

}
