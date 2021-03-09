<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"get:category"}},
 *     collectionOperations={
 *          "get"
 *      }
 * )
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @UniqueEntity("name")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get:category"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     * @Assert\NotBlank()
     * @Assert\Length(max=70)
     * @Groups({"get:category"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Subcategory::class, mappedBy="category", cascade={"persist"})
     * @Groups({"get:category"})
     */
    private $subcategories;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
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
     * @return Collection|Subcategory[]
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    /**
     * @return array
     */
    public function getSubcategoriesId(): array
    {
        return $this->subcategories->map(function($subcat){
            return $subcat->getId();
        })->toArray();
    }

    public function addSubcategory(Subcategory $subcategory): self
    {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories[] = $subcategory;
            $subcategory->setCategory($this);
        }

        return $this;
    }

    public function removeSubcategory(Subcategory $subcategory): self
    {
        if ($this->subcategories->removeElement($subcategory)) {
            // set the owning side to null (unless already changed)
            if ($subcategory->getCategory() === $this) {
                $subcategory->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
