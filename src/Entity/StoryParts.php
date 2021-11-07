<?php

namespace App\Entity;

use App\Repository\StoryPartsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StoryPartsRepository::class)
 */
class StoryParts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Story::class, inversedBy="storyParts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $story;

    /**
     * @ORM\ManyToOne(targetEntity=Parts::class, inversedBy="storyParts")
     */
    private $parts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStory(): ?Story
    {
        return $this->story;
    }

    public function setStory(?Story $story): self
    {
        $this->story = $story;

        return $this;
    }

    public function getParts(): ?Parts
    {
        return $this->parts;
    }

    public function setParts(?Parts $parts): self
    {
        $this->parts = $parts;

        return $this;
    }
}
