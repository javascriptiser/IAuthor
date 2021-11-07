<?php

namespace App\Controller;

use App\Entity\Fandom;
use App\Repository\CategoryRepository;
use App\Repository\FandomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private FandomRepository $fandomRepository;

    public function __construct
    (
        CategoryRepository $categoryRepository,
        FandomRepository $fandomRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->fandomRepository = $fandomRepository;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();
        $fandoms = $this->fandomRepository->findAll();


        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'fandoms' => $fandoms,
        ]);
    }
}
