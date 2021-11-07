<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\FandomType;
use App\Interfaces\CategoryServiceInterface;
use App\Service\CategoryService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private CategoryServiceInterface $categoryService;

    public function __construct
    (
        CategoryService $categoryService
    )
    {
        $this->categoryService = $categoryService;
    }

    #[Route('/admin/category/create', name: 'category_create')]
    public function createCategory(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->createCategory($form->getData());
            return new RedirectResponse($this->generateUrl('admin_category'));
        }
        return $this->render('category/categoryCreate.html.twig', [
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
