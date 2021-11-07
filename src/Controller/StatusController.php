<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Status;
use App\Form\CategoryType;
use App\Form\FandomType;
use App\Form\StatusType;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\StatusServiceInterface;
use App\Service\CategoryService;
use App\Service\StatusService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController
{
    private StatusServiceInterface $statusService;

    public function __construct
    (
        StatusService $statusService
    )
    {
        $this->statusService = $statusService;
    }

    #[Route('/admin/status/create', name: 'status_create')]
    public function createStatus(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(StatusType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->statusService->createStatus($form->getData());
            return new RedirectResponse($this->generateUrl('admin_status'));
        }
        return $this->render('status/statusCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/status/edit/{id}', name: 'status_edit')]
    public function editStatus(Request $request, Status $status): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->statusService->editStatus($form->getData());
            return new RedirectResponse($this->generateUrl('admin_status'));
        }
        return $this->render('status/statusCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/status/delete/{id}', name: 'status_delete')]
    public function deleteStatus (Status $status): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->statusService->deleteStatus($status);
        return new RedirectResponse($this->generateUrl('admin_status'));
    }
}
