<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Tag;
use App\Form\CategoryType;
use App\Form\FandomType;
use App\Form\StatusType;
use App\Form\TagType;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\StatusServiceInterface;
use App\Interfaces\TagServiceInterface;
use App\Service\CategoryService;
use App\Service\StatusService;
use App\Service\TagService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    private TagServiceInterface $tagService;

    public function __construct
    (
        TagService $tagService
    )
    {
        $this->tagService = $tagService;
    }

    #[Route('/admin/tag/create', name: 'tag_create')]
    public function createTag(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(TagType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->createTag($form->getData());
            return new RedirectResponse($this->generateUrl('admin_tag'));
        }
        return $this->render('tag/tagCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/tag/edit/{id}', name: 'tag_edit')]
    public function editTag(Request $request, Tag $tag): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->editTag($form->getData());
            return new RedirectResponse($this->generateUrl('admin_tag'));
        }
        return $this->render('tag/tagCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/tag/delete/{id}', name: 'tag_delete')]
    public function deleteTag (Tag $tag): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->tagService->deleteTag($tag);
        return new RedirectResponse($this->generateUrl('admin_tag'));
    }

}
