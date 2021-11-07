<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Interfaces\CharacterServiceInterface;
use App\Service\CharacterService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    private CharacterServiceInterface $characterService;

    public function __construct
    (
        CharacterService $characterService
    )
    {
        $this->characterService = $characterService;
    }

    #[Route('/admin/character/create', name: 'character_create')]
    public function createCharacter(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(CharacterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->createCharacter($form->getData());
            return new RedirectResponse($this->generateUrl('admin_character'));
        }
        return $this->render('character/characterCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/character/edit/{id}', name: 'character_edit')]
    public function editCharacter(Request $request, Character $character): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->editCharacter($form->getData());
            return new RedirectResponse($this->generateUrl('admin_character'));
        }
        return $this->render('character/characterCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/character/delete/{id}', name: 'character_delete')]
    public function deleteCharacter(Character $character): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->characterService->deleteCharacter($character);
        return new RedirectResponse($this->generateUrl('admin_character'));
    }
}
