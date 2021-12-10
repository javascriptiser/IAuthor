<?php

namespace App\Controller;

use App\Entity\Story;
use App\Repository\StoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    private StoryRepository $storyRepository;

    public function __construct
    (
        StoryRepository    $storyRepository,
    )
    {
        $this->storyRepository = $storyRepository;
    }
    #[Route('/statistics/{id}', name: 'statistics')]
    public function index(Story $story): Response
    {
        $proxyStory = $this->storyRepository->getStoryById($story)->getQuery()->getOneOrNullResult();
        $likes = $proxyStory->getLikes();
        $reviews = $proxyStory->getReviews();
        $story_part = $proxyStory->getStoryParts();

        return $this->render('statistics/index.html.twig', [
            'proxyStory' => $proxyStory,
            'likes' => $likes,
            'reviews' => $reviews,
            'story_part' => $story_part,
        ]);
    }
}
