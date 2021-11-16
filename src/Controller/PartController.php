<?php

namespace App\Controller;

use App\Entity\Parts;
use App\Entity\Story;
use App\Form\PartType;
use App\Interfaces\PartsServiceInterface;
use App\Repository\PartsRepository;
use App\Repository\StoryPartsRepository;
use App\Service\PartService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartController extends AbstractController
{
    private PartsServiceInterface $partsService;
    private PartsRepository $partsRepository;
    private BaseController $baseController;
    private StoryPartsRepository $storyPartsRepository;

    public function __construct
    (
        PartService          $partsService,
        PartsRepository      $partsRepository,
        BaseController       $baseController,
        StoryPartsRepository $storyPartsRepository,
    )
    {
        $this->partsService = $partsService;
        $this->partsRepository = $partsRepository;
        $this->storyPartsRepository = $storyPartsRepository;
        $this->baseController = $baseController;
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/user/profile/story/{storyId}/part/{partId}', name: 'user_part_edit')]
    public function editPart(Request $request, int $storyId, int $partId): Response
    {
        $part = $this->partsRepository->getPartByStoryIdAndPartId($storyId, $partId)->getQuery()->getOneOrNullResult();

        $form = $this->createForm(PartType::class, $part);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->partsService->editPart($form->getData());
            return new RedirectResponse($this->generateUrl('user_my_stories'));
        }
        return $this->render('part/partsCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/profile/story/{id}/addPart', name: 'user_part_create')]
    public function createPart(Request $request, Story $story): Response
    {
        $form = $this->createForm(PartType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->partsService->createPart($story, $form->getData());
            return new RedirectResponse($this->generateUrl('user_my_stories'));
        }
        return $this->render('part/partsCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/user/profile/part/{id}/delete', name: 'part_delete')]
    public function deletePart(Request $request, Parts $parts): Response
    {
        $this->baseController->setService($this->partsService);
        return $this->baseController->deleteWithConfirmation(
            $request,
            $parts,
            'user_my_stories',
            'user_my_stories',
        );
    }


    /**
     * @throws NonUniqueResultException
     */
    #[Route('/user/profile/story/{id}/reorderPart', name: 'user_part_reorder', methods: ['GET', 'POST'])]
    public function reorderPart(Request $request, Story $story): Response
    {
        $story_parts = $this->storyPartsRepository->findByStoryId($story->getId());

        if ($request->isXmlHttpRequest()) {
            $jsonData = json_decode($request->getContent(), true);
            $this->partsService->reorderParts($jsonData, $story);
            return new JsonResponse($jsonData);
        }

        return $this->render('part/partsReorder.html.twig', [
            'story_parts' => $story_parts,
            'story' => $story,
        ]);
    }


}
