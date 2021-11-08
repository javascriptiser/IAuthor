<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status extends \App\Entity\BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Story::class, mappedBy="status")
     */
    private $stories;

    public function __construct()
    {
        $this->stories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Story[]
     */
    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(Story $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
            $story->setStatus($this);
        }

        return $this;
    }

    public function removeStory(Story $story): self
    {
        if ($this->stories->removeElement($story)) {
            // set the owning side to null (unless already changed)
            if ($story->getStatus() === $this) {
                $story->setStatus(null);
            }
        }

        return $this;
    }
}
