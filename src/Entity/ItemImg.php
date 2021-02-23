<?php

namespace App\Entity;

use App\Repository\ItemImgRepository;
use App\Services\UploadHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ItemImgRepository::class)
 */
class ItemImg
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
    private $img;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $imgSmall;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $imgMedium;

    /**
     * @ORM\ManyToOne(targetEntity=ItemColor::class, inversedBy="imgs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $itemColor;

    /**
     * ImgItemColor constructor.
     * @param $itemColor
     */
    public function __construct(ItemColor $itemColor)
    {
        $this->setItemColor($itemColor);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemColor(): ?ItemColor
    {
        return $this->itemColor;
    }

    public function setItemColor(?ItemColor $itemColor): self
    {
        $itemColor->addImg($this);

        $this->itemColor = $itemColor;

        return $this;
    }

    /**
     * @return string
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param string|null $img
     * @return ItemImg
     */
    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getImgPath(): string
    {
        return UploadHelper::getImgPublicPath(UploadHelper::ITEM_IMG."/".$this->getImg());
    }

    public function getImgSmall(): ?string
    {
        return $this->imgSmall;
    }

    public function setImgSmall(string $imgSmall): self
    {
        $this->imgSmall = $imgSmall;

        return $this;
    }

    public function getImgSmallPath(): string
    {
        return UploadHelper::getImgPublicPath(UploadHelper::ITEM_IMG."/".$this->getImgSmall());
    }

    public function getImgMedium(): ?string
    {
        return $this->imgMedium;
    }

    public function setImgMedium(string $imgMedium): self
    {
        $this->imgMedium = $imgMedium;

        return $this;
    }

    public function getImgMediumPath(): string
    {
        return UploadHelper::getImgPublicPath(UploadHelper::ITEM_IMG."/".$this->getImgMedium());
    }
}
