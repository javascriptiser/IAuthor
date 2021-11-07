<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Parts;
use App\Form\CategoryType;
use App\Form\FandomType;
use App\Form\PartType;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\PartsServiceInterface;
use App\Repository\PartsRepository;
use App\Service\CategoryService;
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

    #[Route('/admin/category/edit/{id}', name: 'category_edit')]
    public function editCategory(Request $request, Category $category): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->editCategory($form->getData());
            return new RedirectResponse($this->generateUrl('admin_category'));
        }
        return $this->render('category/categoryCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/category/delete/{id}', name: 'category_delete')]
    public function deleteCategory (Category $category): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->categoryService->deleteCategory($category);
        return new RedirectResponse($this->generateUrl('admin_category'));
    }
}
