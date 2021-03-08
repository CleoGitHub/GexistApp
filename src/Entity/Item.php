<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use App\Services\GeneraterProtectedString;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull
     * @Assert\GreaterThan(value = 0.5)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value=0)
     * @Assert\LessThanOrEqual(value="100")
     */
    private $discount;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     */
    private $isNew;

    /**
     * @ORM\ManyToMany(targetEntity=FeatureValue::class, inversedBy="items")
     */
    private $filters;

    /**
     * @ORM\ManyToOne(targetEntity=Subcategory::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $subcategory;

    /**
     * @ORM\OneToMany(targetEntity=ItemColor::class, mappedBy="item", cascade={"persist"})
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $colors;

    /**
     * @ORM\OneToMany(targetEntity=Mark::class, mappedBy="item")
     */
    private $marks;

    /**
     * @ORM\ManyToMany(targetEntity=ItemCollection::class, mappedBy="items")
     */
    private $collections;

    public function __construct()
    {
        $this->filters = new ArrayCollection();
        $this->discount = 0;
        $this->isNew = false;
        $this->colors = new ArrayCollection();
        $this->marks = new ArrayCollection();
        $this->collections = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getIsNew(): ?bool
    {
        return $this->isNew;
    }

    public function setIsNew(bool $isNew): self
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * @return Collection|FeatureValue[]
     */
    public function getFilters(): Collection
    {
        return $this->filters;
    }

    public function addFilter(FeatureValue $filter): self
    {
        if (!$this->filters->contains($filter)) {
            $this->filters[] = $filter;
        }

        return $this;
    }

    public function removeFilter(FeatureValue $filter): self
    {
        $this->filters->removeElement($filter);

        return $this;
    }

    public function getSubcategory(): ?Subcategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(?Subcategory $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * @return Collection|ItemColor[]
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function addColor(ItemColor $color): self
    {
        if (!$this->colors->contains($color)) {
            $this->colors[] = $color;
            $color->setItem($this);
        }

        return $this;
    }

    public function removeColor(ItemColor $color): self
    {
        if ($this->colors->removeElement($color)) {
            // set the owning side to null (unless already changed)
            if ($color->getItem() === $this) {
                $color->setItem(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    /*
     * Important: override default method in trait ImgTrait
     */
    public function generateFileName(): String {
        return GeneraterProtectedString::generateProtectedFileName(
            "homme ".$this->getSubcategory()->getCategory()." ".$this->getSubcategory()
        );
    }

    /**
     * @return Collection|Mark[]
     */
    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(Mark $mark): self
    {
        if (!$this->marks->contains($mark)) {
            $this->marks[] = $mark;
            $mark->setItem($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): self
    {
        if ($this->marks->removeElement($mark)) {
            // set the owning side to null (unless already changed)
            if ($mark->getItem() === $this) {
                $mark->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ItemCollection[]
     */
    public function getCollections(): Collection
    {
        return $this->collections;
    }

    public function addCollection(ItemCollection $collection): self
    {
        if (!$this->collections->contains($collection)) {
            $this->collections[] = $collection;
            $collection->addItem($this);
        }

        return $this;
    }

    public function removeCollection(ItemCollection $collection): self
    {
        if ($this->collections->removeElement($collection)) {
            $collection->removeItem($this);
        }

        return $this;
    }
}
