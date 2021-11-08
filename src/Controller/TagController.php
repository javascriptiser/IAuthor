<?php

namespace App\Controller;


use App\Entity\Tag;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    private BaseController $baseController;

    public function __construct
    (
        BaseController $baseController,
    )
    {
        $this->baseController = $baseController;
    }

    #[Route('/admin/tag/create', name: 'tag_create')]
    public function createTag(Request $request): Response
    {
        return $this->baseController->create(
            $request,
            new CategoryType(),
            'admin_tag',
            'tag/tagCreate.html.twig',
        );
    }

    #[Route('/admin/tag/update/{id}', name: 'tag_update')]
    public function updateTag(Request $request, Tag $tag): Response
    {
        return $this->baseController->update(
            $request,
            new CategoryType(),
            $tag,
            'admin_tag',
            'tag/tagCreate.html.twig',
        );
    }

    #[Route('/admin/tag/delete/{id}', name: 'tag_delete')]
    public function deleteTag(Tag $tag): Response
    {
        return $this->baseController->delete(
            $tag,
            'admin_tag',
        );
    }

}
