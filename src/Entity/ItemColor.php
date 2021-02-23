<?php

namespace App\Entity;

use App\Repository\ItemColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ItemColorRepository::class)
 * @UniqueEntity(
 *     fields={"color","item"},
 *     message="Ce produit a déjà une déclinaison dans cette couleur"
 * )
 */
class ItemColor
{
    private $colors;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotNull()
     */
    private $color;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="colors")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $item;

    /**
     * @ORM\OneToMany(targetEntity=ItemImg::class, mappedBy="itemColor", orphanRemoval=true, cascade={"persist"})
     */
    private $imgs;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     */
    private $position;

    /**
     * ItemColor constructor.
     */
    public function __construct()
    {
        $this->colors = include "ColorEnum.php";
        $this->imgs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvailableColors() {
        return $this->colors;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return $this
     * @throws Exception
     */
    public function setColor(string $color): self
    {
        if($this->colors == null)
            $this->colors = include "ColorEnum.php";

        if(!in_array($color, $this->colors))
            throw new Exception("La couleur rentré est inconnue");

        $this->color = $color;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Collection|ItemImg[]
     */
    public function getImgs(): Collection
    {
        return $this->imgs;
    }

    public function addImg(ItemImg $img): self
    {
        if (!$this->imgs->contains($img)) {
            $this->imgs[] = $img;
            $img->setItemColor($this);
        }

        return $this;
    }

    public function removeImg(ItemImg $img): self
    {
        if ($this->imgs->removeElement($img)) {
            // set the owning side to null (unless already changed)
            if ($img->getItemColor() === $this) {
                $img->setItemColor(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function generateNameForImg(): string
    {
        $subcat = $this->getItem()->getSubcategory();
        $cat = $subcat->getCategory();
        return "homme ".$cat->getName()." ".$subcat->getName()." ".$this->getColor();
    }
}
