<?php


namespace App\Service;

use App\Entity\BaseEntity;
use App\Entity\User;
use App\Interfaces\UserServiceInterface;
use App\Utils\Base64FileExtractor;
use App\Utils\UploadedBase64File;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends BaseEntityService implements UserServiceInterface
{

    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $passwordHasher;
    private FileUploader $uploader;
    private Base64FileExtractor $base64FileExtractor;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordHasherInterface $passwordHasher
     * @param FileUploader $uploader
     * @param UploadedBase64File $file
     */
    #[Pure] public function __construct(
        EntityManagerInterface      $em,
        UserPasswordHasherInterface $passwordHasher,
        FileUploader                $uploader,
        Base64FileExtractor         $base64FileExtractor,
    )
    {
        parent::__construct($em);
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
        $this->uploader = $uploader;
        $this->base64FileExtractor = $base64FileExtractor;
    }

    /**
     * @throws Exception
     */
    public function isUserInstance(BaseEntity $baseEntity): bool
    {
        if (!$baseEntity instanceof User) {
            throw new Exception('Entity is not instanceof User');
        }
        return true;
    }

    /**
     * @param FormInterface $form
     * @throws Exception
     */
    public function create(FormInterface $form): void
    {
        $user = $form->getData();
        if ($this->isUserInstance($user)) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    /**
     * @param FormInterface $form
     * @throws Exception
     */
    public function update(FormInterface $form): void
    {
        $user = $form->getData();
        if ($this->isUserInstance($user)) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            $this->em->flush();
        }
    }

    /**
     * @param User|BaseEntity $user
     * @throws Exception
     */
    public function delete(User|BaseEntity $user): void
    {
        if ($this->isUserInstance($user)) {
            $this->em->remove($user);
            $this->em->flush();
        }
    }

    public function updateAvatarAjax($file, User $user)
    {
        $prevImageName = $user->getImage();
        $base64Image = $this->base64FileExtractor->extractBase64String($file);
        $imageFile = new UploadedBase64File($base64Image, "blabla");




        $imageName = $this->uploader->upload($imageFile);
        $user->setImage($imageName);
        $this->em->flush();
    }

    public function updateWithImage(string $prevImageName, FormInterface $form): void
    {
        /* @var User $user */
        $user = $form->getData();
        if ($this->isUserInstance($user)) {
            $image = $form->get('image')->getData();
            if ($image) {
                if ($prevImageName) {
                    $this->uploader->removeImage($prevImageName);
                }
                $imageName = $this->uploader->upload($image);
                $user->setImage($imageName);
            } else {
                $user->setImage($prevImageName);
            }
            $this->em->flush();
        }
    }
}