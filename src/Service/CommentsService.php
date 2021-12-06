<?php


namespace App\Service;


use App\Entity\Comments;
use App\Entity\Parts;
use App\Entity\User;
use App\Repository\PartsRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

class CommentsService
{

    private EntityManagerInterface $em;
    private PartsRepository $partsRepository;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     * @param PartsRepository $partsRepository
     */
    #[Pure] public function __construct
    (
        EntityManagerInterface $em,
        PartsRepository        $partsRepository,
    )
    {
        $this->em = $em;
        $this->partsRepository = $partsRepository;
    }

    public function createComment(string $text, int $id, User $user)
    {
        $comment = new Comments();
        $parts = $this->partsRepository->findOneBy(['id' => $id]);
        $comment->setText($text);
        $comment->setCreatedAt(new DateTimeImmutable());
        $comment->addPart($parts);
        $comment->setUser($user);
        $this->em->persist($comment);
        $this->em->flush();
    }

    public function deleteComment(Comments $comment)
    {
        $this->em->remove($comment);
        $this->em->flush();
    }


}