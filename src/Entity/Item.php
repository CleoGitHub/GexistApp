<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use App\Services\GeneraterProtectedString;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Util\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    private const IMG_DIR = "items/";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex("/^.{1,255}$/")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image()
     */
    private $img;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $discount;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isNew;

    /**
     * @ORM\ManyToMany(targetEntity=FeatureValue::class, inversedBy="items")
     */
    private $filters;

    /**
     * @ORM\ManyToOne(targetEntity=Subcategory::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcategory;

    public function __construct()
    {
        $this->filters = new ArrayCollection();
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

    public function getImgFolderDir() {
        return self::IMG_DIR.$this->getImgFolderName()."/";
    }

    public function getImgFolderName(): String {
        return GeneraterProtectedString::generateProtectedFolderName($this->name);
    }

    public function getImgDir() {
        return $this->getImgFolderDir().$this->img;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(File $img): self
    {
        $fileName = GeneraterProtectedString::generateProtectedFileName(
            "homme ".$this->getSubcategory()->getCategory()." ".$this->getSubcategory()
        );
        $fileName = $fileName.".".$img->getExtension();

        $fs = new Filesystem();
        $fs->copy($img->getPathname(), "public/assets/imgs/".$this->getImgFolderDir().$fileName);

        $this->img = $fileName;

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

    public function __toString() {
        return $this->name;
    }
}
