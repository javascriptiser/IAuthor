<?php


namespace App\Service;

use App\Entity\BaseEntity;
use App\Entity\Category;
use App\Entity\Fandom;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Form\FormInterface;

class CategoryService extends BaseEntityService
{

    private EntityManagerInterface $em;
    private FileUploader $uploader;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     * @param FileUploader $uploader
     */
    #[Pure] public function __construct
    (
        EntityManagerInterface $em,
        FileUploader           $uploader
    )
    {
        parent::__construct($em);
        $this->em = $em;
        $this->uploader = $uploader;
    }

    /**
     * @throws Exception
     */
    public function isCategoryInstance(BaseEntity $baseEntity): bool
    {
        if ($baseEntity instanceof Category) {
            return true;
        }
        throw new Exception('Entity is not instanceof Category');
    }

    /**
     * @param FormInterface $form
     * @throws Exception
     */
    public function create(FormInterface $form): void
    {
        $category = $form->getData();
        if ($this->isCategoryInstance($category)) {
            $image = $form->get('image')->getData();
            if ($image) {
                $imageName = $this->uploader->upload($image);
                /** @var Category $category */
                $category->setImage($imageName);
            }
            $this->em->persist($category);
            $this->em->flush();
        }
    }

    /**
     * @param string $prevImageName
     * @param FormInterface $form
     * @throws Exception
     */
    public function updateWithImage(mixed $prevImageName, FormInterface $form): void
    {
        /* @var Category $category */
        $category = $form->getData();
        if ($this->isCategoryInstance($category)) {
            $image = $form->get('image')->getData();
            if ($image) {
                if ($prevImageName) {
                    $this->uploader->removeImage($prevImageName);
                }
                $imageName = $this->uploader->upload($image);
                $category->setImage($imageName);
            } else {
                $category->setImage($prevImageName);
            }
            $this->em->flush();
        }
    }

    /**
     * @param Category|BaseEntity $category
     * @throws Exception
     */
    public function delete(Category|BaseEntity $category): void
    {
        if ($this->isCategoryInstance($category)) {
            if ($category->getImage()) {
                $this->uploader->removeImage($category->getImage());
            }
            $this->em->remove($category);
            $this->em->flush();
        }
    }
}