<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Interfaces\CategoryServiceInterface;
use App\Repository\CategoryRepository;
use App\Repository\StoryRepository;
use App\Service\CategoryService;
use App\Voter\AdminVoter;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{
    private BaseController $baseController;
    private CategoryService $categoryService;
    private CategoryRepository $categoryRepository;
    private PaginatorInterface $paginator;

    public function __construct
    (
        BaseController     $baseController,
        CategoryService    $categoryService,
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator,
    )
    {
        $this->baseController = $baseController;
        $this->categoryService = $categoryService;
        $this->baseController->setService($categoryService);
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
    }

    #[Route('/admin/category/create', name: 'category_create')]
    public function createCategory(Request $request): Response
    {
        return $this->baseController->create(
            $request,
            CategoryType::class,
            'admin_category',
            'category/categoryCreate.html.twig',
        );
    }

    /**
     * @throws Exception
     */
    #[Route('/admin/category/update/{id}', name: 'category_update')]
    public function updateCategory(Request $request, Category $category): Response
    {
        $prevImageName = $category->getImage();
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->updateWithImage($prevImageName, $form);
            return new RedirectResponse($this->generateUrl('admin_category'));
        }
        return $this->render('category/categoryCreate.html.twig', [
            'form' => $form->createView(),
            'prevImageName' => $prevImageName
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/admin/category/delete/{id}', name: 'category_delete')]
    public function deleteCategory(Request $request, Category $category): Response
    {

        return $this->baseController->deleteWithConfirmation($request,
            $category,
            'admin_category',
            'admin_category',
        );
    }

    #[Route('/category', name: 'category')]
    public function index(Request $request): Response
    {
        $query = $this->categoryRepository->queryFindAll();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 7),
        );

        return $this->render('category/index.html.twig', [
            'pagination' => $pagination
        ]);
    }


}
