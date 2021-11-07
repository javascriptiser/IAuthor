<?php

namespace App\Controller;

use App\Entity\MpaaRating;
use App\Form\MpaaRatingType;
use App\Interfaces\MpaaRatingServiceInterface;
use App\Service\MpaaRatingService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MpaaRatingController extends AbstractController
{
    private MpaaRatingServiceInterface $mpaaRatingService;

    public function __construct
    (
        MpaaRatingService $mpaaRatingService
    )
    {
        $this->mpaaRatingService = $mpaaRatingService;
    }

    #[Route('/admin/mppaRating/create', name: 'mpaaRating_create')]
    public function createMpaaRating(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(MpaaRatingType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->mpaaRatingService->createMpaaRating($form->getData());
            return new RedirectResponse($this->generateUrl('admin_mpaaRating'));
        }
        return $this->render('mpaa_rating/mpaaRatingCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/mpaaRating/edit/{id}', name: 'mpaaRating_edit')]
    public function editMpaaRating(Request $request, MpaaRating $mpaaRating): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(MpaaRatingType::class, $mpaaRating);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->mpaaRatingService->editMpaaRating($form->getData());
            return new RedirectResponse($this->generateUrl('admin_mpaaRating'));
        }
        return $this->render('mpaa_rating/mpaaRatingCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/mpaaRating/delete/{id}', name: 'mpaaRating_delete')]
    public function deleteMpaaRating (MpaaRating $mpaaRating): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->mpaaRatingService->deleteMpaaRating($mpaaRating);
        return new RedirectResponse($this->generateUrl('admin_mpaaRating'));
    }
}
