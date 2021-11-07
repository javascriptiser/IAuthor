<?php

namespace App\Controller;

use App\Entity\Fandom;
use App\Form\FandomType;
use App\Interfaces\FandomServiceInterface;
use App\Service\FandomService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FandomController extends AbstractController
{
    private FandomServiceInterface $fandomService;

    public function __construct
    (
        FandomService $fandomService
    )
    {
        $this->fandomService = $fandomService;
    }

    #[Route('/admin/fandom/create', name: 'fandom_create')]
    public function createFandom(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(FandomType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->fandomService->createFandom($form->getData());
            return new RedirectResponse($this->generateUrl('admin_fandom'));
        }
        return $this->render('fandom/fandomCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/fandom/edit/{id}', name: 'fandom_edit')]
    public function editFandom(Request $request, Fandom $fandom): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(FandomType::class, $fandom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->fandomService->editFandom($form->getData());
            return new RedirectResponse($this->generateUrl('admin_fandom'));
        }
        return $this->render('fandom/fandomCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/fandom/delete/{id}', name: 'fandom_delete')]
    public function deleteFandom (Fandom $fandom): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->fandomService->deleteFandom($fandom);
        return new RedirectResponse($this->generateUrl('admin_fandom'));
    }
}
