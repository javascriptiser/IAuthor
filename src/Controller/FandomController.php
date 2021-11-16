<?php

namespace App\Controller;

use App\Entity\Fandom;
use App\Form\FandomType;
use App\Service\FandomService;
use App\Service\FileUploader;
use App\Voter\AdminVoter;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FandomController extends AbstractController
{
    private BaseController $baseController;
    private FandomService $fandomService;


    public function __construct
    (
        BaseController $baseController,
        FandomService  $fandomService,
    )
    {
        $this->baseController = $baseController;
        $this->fandomService = $fandomService;
        $this->baseController->setService($fandomService);
    }

    #[Route('/admin/fandom/create', name: 'fandom_create')]
    public function createFandom(Request $request,): Response
    {
        return $this->baseController->create(
            $request,
            FandomType::class,
            'admin_fandom',
            'fandom/fandomCreate.html.twig',
        );
    }

    /**
     * @throws Exception
     */
    #[Route('/admin/fandom/update/{id}', name: 'fandom_update')]
    public function updateFandom(Request $request, Fandom $fandom): Response
    {
        $prevImageName = $fandom->getImage();
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(FandomType::class, $fandom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->fandomService->updateWithImage($prevImageName, $form);
            return new RedirectResponse($this->generateUrl('admin_fandom'));
        }
        return $this->render('fandom/fandomCreate.html.twig', [
            'form' => $form->createView(),
            'prevImageName' => $prevImageName
        ]);
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
