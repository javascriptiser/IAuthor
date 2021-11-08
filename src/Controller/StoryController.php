<?php

namespace App\Controller;

use App\Entity\Story;
use App\Form\StoryType;
use App\Service\StoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class StoryController extends AbstractController
{
    private BaseController $baseController;

    public function __construct
    (
        BaseController $baseController,
        StoryService   $storyService,
        Security       $security,
    )
    {
        $this->baseController = $baseController;
        $storyService->setUser($security->getUser());
        $this->baseController->setService($storyService);
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

    #[Route('/admin/story/delete/{id}', name: 'story_delete')]
    public function deleteStory(Story $story): Response
    {
        return $this->baseController->delete(
            $story,
            'admin_story',
        );
    }
}
