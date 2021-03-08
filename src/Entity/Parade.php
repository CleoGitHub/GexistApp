<?php

namespace App\Entity;

use App\Repository\ParadeRepository;
use App\Services\UploadHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParadeRepository::class)
 */
class Parade
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
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $video;

    /**
     * @ORM\ManyToMany(targetEntity=Item::class, inversedBy="parades")
     */
    private $items;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->isActive = false;
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

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function getVideoPath(): string
    {
        return UploadHelper::getVideoPublicPath(UploadHelper::PARADE_VIDEO."/".$this->getVideo());
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

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
            $item->addParade($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if($this->items->removeElement($item))
            $item->removeParade($this);

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
}
