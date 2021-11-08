<?php

namespace App\Controller;

use App\Entity\MpaaRating;
use App\Form\MpaaRatingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MpaaRatingController extends AbstractController
{
    private BaseController $baseController;

    public function __construct
    (
        BaseController $baseController,
    )
    {
        $this->baseController = $baseController;
    }

    #[Route('/admin/mppaRating/create', name: 'mpaaRating_create')]
    public function createMpaaRating(Request $request): Response
    {
        return $this->baseController->create(
            $request,
            new MpaaRatingType(),
            'admin_mpaaRating',
            'mpaa_rating/mpaaRatingCreate.html.twig',
        );
    }

    #[Route('/admin/mpaaRating/update/{id}', name: 'mpaaRating_update')]
    public function updateMpaaRating(Request $request, MpaaRating $mpaaRating): Response
    {
        return $this->baseController->update(
            $request,
            new MpaaRatingType(),
            $mpaaRating,
            'admin_mpaaRating',
            'mpaa_rating/mpaaRatingCreate.html.twig',
        );
    }

    #[Route('/admin/mpaaRating/delete/{id}', name: 'mpaaRating_delete')]
    public function deleteMpaaRating(MpaaRating $mpaaRating): Response
    {
        return $this->baseController->delete(
            $mpaaRating,
            'admin_mpaaRating',
        );
    }
}
