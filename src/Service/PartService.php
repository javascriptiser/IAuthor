<?php

namespace App\Service;


use App\Entity\BaseEntity;
use App\Entity\Parts;
use App\Entity\Story;
use App\Entity\StoryParts;
use App\Interfaces\PartsServiceInterface;
use App\Repository\StoryPartsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Form\FormInterface;

class PartService extends BaseEntityService implements PartsServiceInterface
{

    private EntityManagerInterface $em;
    private StoryPartsRepository $storyPartsRepository;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     * @param StoryPartsRepository $storyPartsRepository
     */
    public function __construct
    (
        EntityManagerInterface $em,
        StoryPartsRepository   $storyPartsRepository,
    )
    {
        $this->em = $em;
        $this->storyPartsRepository = $storyPartsRepository;
    }

    public function createPart(Story $story, Parts $parts): void
    {
        $storyPart = new StoryParts();
        $storyPart->setStory($story);
        $storyPart->setParts($parts);
        $story->addStoryPart($storyPart);
        $this->em->persist($storyPart);
        $this->em->persist($parts);
        $this->em->flush();
    }

    /**
     * @param Parts $parts
     */
    public function editPart(Parts $parts): void
    {
        $this->em->flush();
    }

    /**
     * @param Parts|BaseEntity $parts
     * @throws NonUniqueResultException
     */
    public function delete(Parts|BaseEntity $parts): void
    {
        $storyParts = $this->storyPartsRepository->findByPartsId($parts->getId());
        $this->em->remove($storyParts);
        $this->em->remove($parts);
        $this->em->flush();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function reorderParts(mixed $jsonData, Story $story): void
    {
        foreach ($jsonData as $key => $value) {
            $part_id = json_decode($value)->part;
            $story_part = $this->storyPartsRepository->findByStoryIdAndByPartId($story->getId(), $part_id);
            $story_part->setOrderNumber($key);
            $this->em->persist($story_part);

        }
        $this->em->flush();
    }
}