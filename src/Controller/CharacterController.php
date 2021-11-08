<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    private BaseController $baseController;

    public function __construct
    (
        BaseController $baseController,
    )
    {
        $this->baseController = $baseController;
    }

    #[Route('/admin/character/create', name: 'character_create')]
    public function createCharacter(Request $request): Response
    {
        return $this->baseController->create(
            $request,
            new CharacterType(),
            'admin_character',
            'character/characterCreate.html.twig',
        );
    }

    #[Route('/admin/character/update/{id}', name: 'character_update')]
    public function updateCharacter(Request $request, Character $character): Response
    {
        return $this->baseController->update(
            $request,
            new CharacterType(),
            $character,
            'admin_character',
            'character/characterCreate.html.twig',
        );
    }

    #[Route('/admin/character/delete/{id}', name: 'character_delete')]
    public function deleteCharacter(Character $character): Response
    {
        return $this->baseController->delete(
            $character,
            'admin_character',
        );
    }
}
