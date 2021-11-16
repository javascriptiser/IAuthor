<?php


namespace App\Service;

use App\Entity\BaseEntity;
use App\Entity\Fandom;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Form\FormInterface;

class FandomService extends BaseEntityService
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
    public function isFandomInstance(BaseEntity $baseEntity): bool
    {
        if ($baseEntity instanceof Fandom) {
            return true;
        }
        throw new Exception('Entity is not instanceof Fandom');
    }

    /**
     * @param FormInterface $form
     * @throws Exception
     */
    public function create(FormInterface $form): void
    {
        $fandom = $form->getData();
        if ($this->isFandomInstance($fandom)) {
            $image = $form->get('image')->getData();
            if ($image) {
                $imageName = $this->uploader->upload($image);
                /** @var Fandom $fandom */
                $fandom->setImage($imageName);
            }
            $this->em->persist($fandom);
            $this->em->flush();
        }
    }

    /**
     * @param string $prevImageName
     * @param FormInterface $form
     * @throws Exception
     */
    public function updateWithImage(string $prevImageName, FormInterface $form): void
    {
        /* @var Fandom $fandom */
        $fandom = $form->getData();
        if ($this->isFandomInstance($fandom)) {
            $image = $form->get('image')->getData();
            if ($image) {
                if ($prevImageName) {
                    $this->uploader->removeImage($prevImageName);
                }
                $imageName = $this->uploader->upload($image);
                $fandom->setImage($imageName);
            } else {
                $fandom->setImage($prevImageName);
            }
            $this->em->flush();
        }
    }

    /**
     * @param Fandom|BaseEntity $fandom
     * @throws Exception
     */
    public function delete(Fandom|BaseEntity $fandom): void
    {
        if ($this->isFandomInstance($fandom)) {
            if ($fandom->getImage()) {
                $this->uploader->removeImage($fandom->getImage());
            }
            $this->em->remove($fandom);
            $this->em->flush();
        }
    }
}