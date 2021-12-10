<?php

namespace App\Controller;

use App\Entity\Story;
use App\Service\LikesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    private LikesService $likesService;

    public function __construct(LikesService $likesService)
    {
        $this->likesService = $likesService;
    }

    #[Route('/story/{id}/like', name: 'like')]
    public function index(Story $story, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            $storyId = $parametersAsArray['idStory'];
            $likes = $this->likesService->addLike($story->getId(),$this->getUser());

            return new JsonResponse($likes);
        }
        return new JsonResponse(0);
    }
}
