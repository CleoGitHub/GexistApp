<?php

namespace App\Entity;

use App\Repository\ItemCollectionRepository;
use App\Services\UploadHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ItemCollectionRepository::class)
 */
class ItemCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     * @Assert\NotBlank()
     * @Assert\Length(max=70)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=70)
     * @Assert\NotBlank()
     * @Assert\Length(max=70)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     * @Assert\Length(max=70)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Item::class, inversedBy="collections")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->isActive = false;
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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }


    public function getImagePath(): string
    {
        return UploadHelper::getImgPublicPath(UploadHelper::ITEM_COLLECTION_IMG."/".$this->getImage());
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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
            $item->addCollection($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if($this->items->removeElement($item))
            $item->removeCollection($this);

        return $this;
    }
}
