<?php

namespace App\Controller;

use App\Form\PartType;
use App\Interfaces\PartsServiceInterface;
use App\Repository\PartsRepository;
use App\Service\PartService;
use App\Voter\AdminVoter;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartController extends AbstractController
{
    private PartsServiceInterface $partsService;
    private PartsRepository $partsRepository;

    public function __construct
    (
        PartService $partsService,
        PartsRepository $partsRepository,
    )
    {
        $this->partsService = $partsService;
        $this->partsRepository = $partsRepository;
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/user/profile/story/{storyId}/part/{partId}', name: 'part_edit')]
    public function editPart(Request $request, int $storyId, int $partId): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");

        $part = $this->partsRepository->getPartByStoryIdAndPartId($storyId,$partId)->getQuery()->getOneOrNullResult();

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


}
