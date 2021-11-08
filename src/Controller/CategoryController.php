<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private BaseController $baseController;

    public function __construct
    (
        BaseController    $baseController,
    )
    {
        $this->baseController = $baseController;
    }

    #[Route('/admin/category/create', name: 'category_create')]
    public function createCategory(Request $request): Response
    {
        return $this->baseController->create(
            $request,
            new CategoryType(),
            'admin_category',
            'category/categoryCreate.html.twig',
        );
    }

    #[Route('/admin/category/update/{id}', name: 'category_update')]
    public function updateCategory(Request $request, Category $category): Response
    {
        return $this->baseController->update(
            $request,
            new CategoryType(),
            $category,
            'admin_category',
            'category/categoryCreate.html.twig',
        );
    }

    #[Route('/admin/category/delete/{id}', name: 'category_delete')]
    public function deleteCategory(Category $category): Response
    {
        return $this->baseController->delete(
            $category,
            'admin_category',
        );
    }
}
