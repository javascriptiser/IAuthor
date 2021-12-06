<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Character;
use App\Entity\Comments;
use App\Entity\Fandom;
use App\Entity\MpaaRating;
use App\Entity\Review;
use App\Entity\Status;
use App\Entity\Story;
use App\Entity\Tag;
use App\Form\CommentType;
use App\Form\ReviewType;
use App\Form\StoryType;
use App\Repository\StoryRepository;
use App\Service\CommentsService;
use App\Service\ReviewsService;
use App\Service\StoryService;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class StoryController extends AbstractController
{
    private BaseController $baseController;
    private PaginatorInterface $paginator;
    private StoryRepository $storyRepository;
    private ReviewsService $reviewsService;
    private CommentsService $commentsService;

    public function __construct
    (
        BaseController     $baseController,
        StoryService       $storyService,
        Security           $security,
        PaginatorInterface $paginator,
        StoryRepository    $storyRepository,
        ReviewsService     $reviewsService,
        CommentsService    $commentsService,
    )
    {
        $this->baseController = $baseController;
        if ($security->getUser()) {
            $storyService->setUser($security->getUser());
        }
        $this->baseController->setService($storyService);
        $this->paginator = $paginator;
        $this->storyRepository = $storyRepository;
        $this->reviewsService = $reviewsService;
        $this->commentsService = $commentsService;
    }

    #[Route('/admin/story/create', name: 'story_create')]
    public function createStory(Request $request): Response
    {

        return $this->baseController->create(
            $request,
            StoryType::class,
            'admin_story',
            'story/index.html.twig',
        );
    }

    #[Route('/admin/story/update/{id}', name: 'story_update')]
    public function updateStory(Request $request, Story $story): Response
    {
        return $this->baseController->update(
            $request,
            StoryType::class,
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
    #[Route('/readstory/{id}', name: 'story_read', methods: ['GET'])]
    public function readStory(Story $story): Response
    {
        $proxyStory = $this->storyRepository->getStoryById($story)->getQuery()->getOneOrNullResult();

        return $this->render('story/readStory.html.twig', [
            'story' => $proxyStory,
        ]);
    }

    #[Route('/createCommentsForPart/{id}', name: 'comments_create', methods: ['POST'])]
    public function readStoryAjax(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            $text = $parametersAsArray['text'];
            $partsId = $parametersAsArray['partsId'];
            $storyId = $parametersAsArray['storyId'];
            $this->commentsService->createComment($text, $partsId, $this->getUser());
            return new JsonResponse(1);
//            return new RedirectResponse($this->generateUrl('story_read', ['id' => $storyId]));
        } else {
//            return new JsonResponse(0);
        }
    }
    #[Route('/comment/{id}/delete', name: 'comments_delete')]
    public function deleteStoryComment(Comments $comments): Response
    {
        $this->commentsService->deleteComment($comments);
        return new RedirectResponse($this->generateUrl('home'));
    }


    /**
     * @throws NonUniqueResultException
     */
    #[Route('/story/{id}/reviews', name: 'story/reviews_read')]
    public function readStoryReviews(Story $story, Request $request): Response
    {
        $proxyStory = $this->storyRepository->getStoryById($story)->getQuery()->getOneOrNullResult();
        $form = $this->createForm(ReviewType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reviewsService->createReview($form->getData(), $story, $this->getUser());
            return new RedirectResponse($this->generateUrl('story/reviews_read', ['id' => $story->getId()]));
        }

        return $this->render('story/readStoryReviews.html.twig', [
            'story' => $proxyStory,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/review/{id}/delete', name: 'reviews_delete')]
    public function deleteStoryReview(Review $review): Response
    {
        $this->reviewsService->deleteReview($review);
        return new RedirectResponse($this->generateUrl('story/reviews_read', ['id' => $review->getStory()->getId()]));
    }

    #[Route('stories/all', name: 'stories/all_show')]
    public function showStoriesAll(Request $request): Response
    {
        $query = $this->storyRepository->queryFindAll()->getQuery()->getResult();
        return $this->baseController->showWithPagination($request, $query, 'story/readStories.html.twig');
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

    #[Route('stories/status/{id}', name: 'stories/status_show')]
    public function showStoriesInStatus(Request $request, Status $status): Response
    {
        $query = $this->storyRepository->getStoryByStatusId($status)->getQuery()->getResult();
        return $this->baseController->showWithPagination($request, $query, 'story/readStories.html.twig');
    }

    #[Route('stories/mpaaRating/{id}', name: 'stories/mpaaRating_show')]
    public function showStoriesInMpaaRating(Request $request, MpaaRating $mpaaRating): Response
    {
        $query = $this->storyRepository->getStoryByMpaaRatingId($mpaaRating)->getQuery()->getResult();
        return $this->baseController->showWithPagination($request, $query, 'story/readStories.html.twig');
    }

}
