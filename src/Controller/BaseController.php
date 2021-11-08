<?php

namespace App\Controller;

use App\Entity\BaseEntity;
use App\Interfaces\BaseEntityServiceInterface;
use App\Service\BaseEntityService;
use App\Voter\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class BaseController extends AbstractController
{
    private BaseEntityServiceInterface $baseEntityService;

    public function __construct
    (
        BaseEntityService $baseEntityService,
    )
    {
        $this->baseEntityService = $baseEntityService;
    }

    public function setService(BaseEntityServiceInterface $baseEntityService){
        $this->baseEntityService = $baseEntityService;
    }

    public function create(Request $request, AbstractType $formType, $redirectRoute, $template): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm($formType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->baseEntityService->create($form->getData());
            return new RedirectResponse($this->generateUrl($redirectRoute));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

    public function update(Request $request, AbstractType $formType, BaseEntity $entity, $redirectRoute, $template): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm($formType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->baseEntityService->update($form->getData());
            return new RedirectResponse($this->generateUrl($redirectRoute));
        }
        return $this->render($template, [
            'form' => $form->createView()
        ]);
    }

    public function delete(BaseEntity $entity, $redirectRoute): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->baseEntityService->delete($entity);
        return new RedirectResponse($this->generateUrl($redirectRoute));
    }

}
