<?php

namespace App\Entity;

use App\Repository\LikesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikesRepository::class)
 */
class Likes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Story::class, inversedBy="likes")
     */
    private $story;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likes")
     */
    private $user;


    public function __construct()
    {
        $this->story = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Story[]
     */
    public function getStory(): Collection
    {
        return $this->story;
    }

    public function addStory(Story $story): self
    {
        if (!$this->story->contains($story)) {
            $this->story[] = $story;
        }

        return $this;
    }

    public function removeStory(Story $story): self
    {
        $this->story->removeElement($story);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
