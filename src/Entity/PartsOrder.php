<?php

namespace App\Entity;

use App\Repository\PartsOrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartsOrderRepository::class)
 */
class PartsOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Parts::class, inversedBy="partsOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $part;

    /**
     * @ORM\Column(type="integer")
     */
    private $listOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPart(): ?Parts
    {
        return $this->part;
    }

    public function setPart(?Parts $part): self
    {
        $this->part = $part;

        return $this;
    }

    public function getListOrder(): ?int
    {
        return $this->listOrder;
    }

    public function setListOrder(int $listOrder): self
    {
        $this->listOrder = $listOrder;

        return $this;
    }
}
