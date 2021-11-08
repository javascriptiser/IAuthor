<?php

namespace App\Controller;


use App\Entity\Status;
use App\Form\CategoryType;
use App\Form\StatusType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController
{
    private BaseController $baseController;

    public function __construct
    (
        BaseController $baseController,
    )
    {
        $this->baseController = $baseController;
    }

    #[Route('/admin/status/create', name: 'status_create')]
    public function createStatus(Request $request): Response
    {
        return $this->baseController->create(
            $request,
            new StatusType(),
            'admin_status',
            'status/statusCreate.html.twig',
        );
    }

    #[Route('/admin/status/update/{id}', name: 'status_update')]
    public function updateStatus(Request $request, Status $status): Response
    {
        return $this->baseController->update(
            $request,
            new CategoryType(),
            $status,
            'admin_status',
            'status/statusCreate.html.twig',
        );
    }

    #[Route('/admin/status/delete/{id}', name: 'status_delete')]
    public function deleteStatus(Status $status): Response
    {
        return $this->baseController->delete(
            $status,
            'admin_status',
        );
    }
}
