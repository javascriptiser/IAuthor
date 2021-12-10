<?php

namespace App\Entity;

use App\Repository\StoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StoryRepository::class)
 */
class Story extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="stories")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="stories")
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Fandom::class, inversedBy="stories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fandom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $authorsNote;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="stories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;


    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="stories")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Character::class, inversedBy="stories")
     */
    private $characters;

    /**
     * @ORM\ManyToOne(targetEntity=MpaaRating::class, inversedBy="stories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mpaaRating;

    /**
     * @ORM\OneToMany(targetEntity=StoryParts::class, mappedBy="story")
     */
    private $storyParts;

    /**
     * @ORM\ManyToMany(targetEntity=Review::class, mappedBy="story")
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=Likes::class, mappedBy="story")
     */
    private $likes;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->storyParts = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getFandom(): ?Fandom
    {
        return $this->fandom;
    }

    public function setFandom(?Fandom $fandom): self
    {
        $this->fandom = $fandom;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthorsNote(): ?string
    {
        return $this->authorsNote;
    }

    public function setAuthorsNote(string $authorsNote): self
    {
        $this->authorsNote = $authorsNote;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }


    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        $this->characters->removeElement($character);

        return $this;
    }

    public function getMpaaRating(): ?MpaaRating
    {
        return $this->mpaaRating;
    }

    public function setMpaaRating(?MpaaRating $mpaaRating): self
    {
        $this->mpaaRating = $mpaaRating;

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
            $storyPart->setStory($this);
        }

        return $this;
    }

    public function removeStoryPart(StoryParts $storyPart): self
    {
        if ($this->storyParts->removeElement($storyPart)) {
            // set the owning side to null (unless already changed)
            if ($storyPart->getStory() === $this) {
                $storyPart->setStory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->addStory($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            $review->removeStory($this);
        }

        return $this;
    }

    /**
     * @return Collection|Likes[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->addStory($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->removeElement($like)) {
            $like->removeStory($this);
        }

        return $this;
    }
}
