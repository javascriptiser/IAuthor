<?php

namespace App\Entity;

use App\Repository\PartsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartsRepository::class)
 */
class Parts
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment_before_part;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment_after_part;

    /**
     * @ORM\OneToMany(targetEntity=PartsOrder::class, mappedBy="part")
     */
    private $partsOrders;

    /**
     * @ORM\OneToMany(targetEntity=StoryParts::class, mappedBy="parts")
     */
    private $storyParts;

    public function __construct()
    {
        $this->partsOrders = new ArrayCollection();
        $this->storyParts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCommentBeforePart(): ?string
    {
        return $this->comment_before_part;
    }

    public function setCommentBeforePart(?string $comment_before_part): self
    {
        $this->comment_before_part = $comment_before_part;

        return $this;
    }

    public function getCommentAfterPart(): ?string
    {
        return $this->comment_after_part;
    }

    public function setCommentAfterPart(?string $comment_after_part): self
    {
        $this->comment_after_part = $comment_after_part;

        return $this;
    }

    /**
     * @return Collection|PartsOrder[]
     */
    public function getPartsOrders(): Collection
    {
        return $this->partsOrders;
    }

    public function addPartsOrder(PartsOrder $partsOrder): self
    {
        if (!$this->partsOrders->contains($partsOrder)) {
            $this->partsOrders[] = $partsOrder;
            $partsOrder->setPart($this);
        }

        return $this;
    }

    public function removePartsOrder(PartsOrder $partsOrder): self
    {
        if ($this->partsOrders->removeElement($partsOrder)) {
            // set the owning side to null (unless already changed)
            if ($partsOrder->getPart() === $this) {
                $partsOrder->setPart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StoryParts[]
     */
    public function getStoryParts(): Collection
    {
        return $this->storyParts;
    }

    public function addStoryPart(StoryParts $storyPart): self
    {
        if (!$this->storyParts->contains($storyPart)) {
            $this->storyParts[] = $storyPart;
            $storyPart->setParts($this);
        }

        return $this;
    }

    public function removeStoryPart(StoryParts $storyPart): self
    {
        if ($this->storyParts->removeElement($storyPart)) {
            // set the owning side to null (unless already changed)
            if ($storyPart->getParts() === $this) {
                $storyPart->setParts(null);
            }
        }

        return $this;
    }
}
