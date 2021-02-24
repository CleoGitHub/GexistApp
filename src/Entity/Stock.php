<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 * @UniqueEntity(
 *     fields={"size", "color"},
 *     message="Un stock existe déjà pour cette couleur dans cette taille"
 * )
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\PositiveOrZero()
     * @Assert\NotNull()
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Size::class, inversedBy="stocks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity=ItemColor::class, inversedBy="stocks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $color;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addQuantity(int $quantity): self
    {
        $this->quantity += $quantity;

        return $this;
    }

    public function subQuantity(int $quantity): self
    {
        $this->quantity -= $quantity;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getColor(): ?ItemColor
    {
        return $this->color;
    }

    public function setColor(?ItemColor $color): self
    {
        $this->color = $color;

        return $this;
    }
}
