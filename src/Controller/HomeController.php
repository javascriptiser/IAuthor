<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Fandom;
use App\Entity\Story;
use App\Form\StoryType;
use App\Repository\CategoryRepository;
use App\Repository\FandomRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        FandomRepository   $fandomRepository
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


        $form = $this->createFormBuilder(new Story())
            ->add('title', EntityType::class, [
                'placeholder' => 'Название рассказа',
                'class' => Story::class,
                'choice_label' => 'title',
                'label' => false
            ])->getForm();

        if ($request->isXmlHttpRequest()) {
            $jsonData = json_decode($request->getContent(), true);

            return new JsonResponse($jsonData);
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'fandoms' => $fandoms,
            'categories' => $categories,
        ]);
    }
}
