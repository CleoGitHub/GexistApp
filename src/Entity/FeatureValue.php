<?php

namespace App\Entity;

use App\Repository\FeatureValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FeatureValueRepository::class)
 * @UniqueEntity(
 *     fields={"value","feature"},
 *     message="Deux options de filtres ne peuvent avoir la même valeur pour le même filtre"
 * )
 * @UniqueEntity(
 *     fields={"position","feature"},
 *     message="Deux filtres ne peuvent avoir la même position pour le même filtre"
 * )
 */
class FeatureValue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\Length(max=25)
     * @Assert\NotBlank()
     */
    private $value;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity=Feature::class, inversedBy="featureValues")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $feature;

    /**
     * @ORM\ManyToMany(targetEntity=Item::class, mappedBy="filters")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getFeature(): ?Feature
    {
        return $this->feature;
    }

    public function setFeature(?Feature $feature): self
    {
        $this->feature = $feature;

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
            $item->addFilter($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            $item->removeFilter($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->feature." => ".$this->value;
    }
}
