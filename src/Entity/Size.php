<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SizeRepository::class)
 * @UniqueEntity(
 *     fields={"position", "subcategory"},
 *     message="Deux sous-catégories ne peuvent pas avoir le même nom si elles appartiennent à la même catégorie"
 * )
 */
class Size
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Regex("/^.{1,10}$/")
     * @Assert\NotBlank()
     */
    private $value;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity=Subcategory::class, inversedBy="sizes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcategory;

    /**
     * Size constructor.
     * @param $subcategory
     */
    public function __construct(Subcategory $subcategory)
    {
        $this->setSubcategory($subcategory);
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

    public function getSubcategory(): ?Subcategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(?Subcategory $subcategory): self
    {
        if($this->subcategory == $subcategory)
            return $this;

        if($this->subcategory != null)
            $this->subcategory->removeSize($this);

        $this->subcategory = $subcategory;

        if($this->subcategory != null)
            $this->subcategory->addSize($this);

        return $this;
    }
}