<?php

namespace App\Controller;

use App\Entity\Fandom;
use App\Form\FandomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FandomController extends AbstractController
{
    private BaseController $baseController;

    public function __construct
    (
        BaseController $baseController,
    )
    {
        $this->baseController = $baseController;
    }

    #[Route('/admin/fandom/create', name: 'fandom_create')]
    public function createFandom(Request $request): Response
    {
        return $this->baseController->create(
            $request,
            new FandomType(),
            'admin_fandom',
            'fandom/fandomCreate.html.twig',
        );
    }

    #[Route('/admin/fandom/update/{id}', name: 'fandom_update')]
    public function updateFandom(Request $request, Fandom $fandom): Response
    {
        return $this->baseController->update(
            $request,
            new FandomType(),
            $fandom,
            'admin_fandom',
            'fandom/fandomCreate.html.twig',
        );
    }

    #[Route('/admin/fandom/delete/{id}', name: 'fandom_delete')]
    public function deleteFandom(Fandom $fandom): Response
    {
        return $this->baseController->delete(
            $fandom,
            'admin_fandom',
        );
    }
}
