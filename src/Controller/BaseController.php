<?php

namespace App\Controller;

use App\Entity\BaseEntity;
use App\Interfaces\BaseEntityServiceInterface;
use App\Service\BaseEntityService;
use App\Voter\AdminVoter;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class BaseController extends AbstractController
{
    private BaseEntityServiceInterface $baseEntityService;
    private PaginatorInterface $paginator;

    public function __construct
    (
        BaseEntityService  $baseEntityService,
        PaginatorInterface $paginator,
    )
    {
        $this->baseEntityService = $baseEntityService;
        $this->paginator = $paginator;
    }

    public function setService(BaseEntityServiceInterface $baseEntityService)
    {
        $this->baseEntityService = $baseEntityService;
    }

    public function create(Request $request, string $formType, string $redirectRoute, string $template): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm($formType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->baseEntityService->create($form);
            return new RedirectResponse($this->generateUrl($redirectRoute));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

    public function update(Request $request, string $formType, BaseEntity $entity, string $redirectRoute, string $template): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $form = $this->createForm($formType, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->baseEntityService->update($form);
            return new RedirectResponse($this->generateUrl($redirectRoute));
        }
        return $this->render($template, [
            'form' => $form->createView()
        ]);
    }

    public function showWithPagination(Request $request, $query, string $template, ?int $page = 1, ?int $limit = 10): Response
    {
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $limit),
        );

        return $this->render($template, [
            'stories' => $pagination,
        ]);
    }


    public function delete(BaseEntity $baseEntity, string $redirectRoute): Response
    {
        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");
        $this->baseEntityService->delete($baseEntity);
        return new RedirectResponse($this->generateUrl($redirectRoute));
    }

    /**
     * @throws Exception
     */
    public function deleteWithConfirmation
    (
        Request    $request,
        BaseEntity $entity,
        string     $successRedirect,
        string     $cancelRedirect,
    ): Response
    {
        $DELETE = 'DELETE';
        $CANCEL = 'CANCEL';

        $this->denyAccessUnlessGranted(AdminVoter::VIEW, $this->getUser(), "Access Denied. Only for Admins");

        $form = $this->createFormBuilder()
            ->add($DELETE, SubmitType::class, ['label' => 'Delete'])
            ->add($CANCEL, SubmitType::class, ['label' => 'Cancel'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nextAction = $form->get($DELETE)->isClicked()
                ? $DELETE
                : $CANCEL;

            switch ($nextAction) {
                case $DELETE:
                {
                    $this->baseEntityService->delete($entity);
                    return new RedirectResponse($this->generateUrl($successRedirect));
                }
                case $CANCEL:
                {
                    return new RedirectResponse($this->generateUrl($cancelRedirect));
                }
                default:
                    throw new Exception('Unexpected value');
            }
        }

        return $this->render('layouts/deleteConfirmation.html.twig', [
            'form' => $form->createView(),
            'deleteButton' => $DELETE,
            'cancelButton' => $CANCEL,
        ]);
    }

}
