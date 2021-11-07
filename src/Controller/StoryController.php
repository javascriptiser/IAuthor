<?php

namespace App\Controller;

use App\Entity\Story;
use App\Form\StoryType;
use App\Interfaces\StoryServiceInterface;
use App\Service\StoryService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoryController extends AbstractController
{
    private StoryServiceInterface $storyService;

    public function __construct
    (
        StoryService  $storyService,
    )
    {
        $this->storyService = $storyService;
    }

    #[Route('/admin/story/create', name: 'story_create')]
    public function createStory(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(StoryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->storyService->createStory($form->getData(), $this->getUser());
            return new RedirectResponse($this->generateUrl('admin_story'));
        }
        return $this->render('story/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/story/edit/{id}', name: 'story_edit')]
    public function editStory(Request $request, Story $story): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(StoryType::class, $story);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->storyService->editStory($form->getData(), $this->getUser());
            return new RedirectResponse($this->generateUrl('admin_story'));
        }
        return $this->render('story/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/story/delete/{id}', name: 'story_delete')]
    public function deleteStory (Story $story): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->storyService->deleteStory($story);
        return new RedirectResponse($this->generateUrl('admin_story'));
    }
}
