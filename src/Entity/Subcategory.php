<?php

namespace App\Entity;

use App\Repository\SubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SubcategoryRepository::class)
 * @UniqueEntity(
 *     fields={"name", "category"},
 *     message="Deux sous-catégories ne peuvent pas avoir le même nom si elles appartiennent à la même catégorie"
 * )
 */
class Subcategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:category"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max=100)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subcategories")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Feature::class, mappedBy="subcategory", cascade={"persist"})
     */
    private $features;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="subcategory")
     */
    private $items;

    /**
     * @ORM\OneToMany(targetEntity=Size::class, mappedBy="subcategory", cascade={"persist"})
     */
    private $sizes;

    public function __construct()
    {
        $this->features = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->sizes = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Feature[]
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Feature $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features[] = $feature;
            $feature->setSubcategory($this);
        }

        return $this;
    }

    public function removeFeature(Feature $feature): self
    {
        if ($this->features->removeElement($feature)) {
            // set the owning side to null (unless already changed)
            if ($feature->getSubcategory() === $this) {
                $feature->setSubcategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setSubcategory($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSubcategory() === $this) {
                $item->setSubcategory(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|Size[]
     */
    public function getSizes(): Collection
    {
        return $this->sizes;
    }

    public function addSize(Size $size): self
    {
        if (!$this->sizes->contains($size)) {
            $this->sizes[] = $size;
            $size->setSubcategory($this);
        }

        return $this;
    }

    public function removeSize(Size $size): self
    {
        if ($this->sizes->removeElement($size)) {
            // set the owning side to null (unless already changed)
            if ($size->getSubcategory() === $this) {
                $size->setSubcategory(null);
            }
        }

        return $this;
    }
}
