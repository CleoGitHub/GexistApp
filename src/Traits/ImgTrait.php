<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

Trait ImgTrait {
    private $imgDir = "";

    /**
     * @Assert\Image()
     */
    private $img;

    public function getImgFolderDir(): String {
        return $this->imgDir;
    }

    public function getImgDir():String {
        return $this->getImgFolderDir().$this->imgName;
    }

    public function getImg(): ?File
    {
        if($this->img == null) {
            $this->img = new File("public/".$this->getImgDir());
        }
        return $this->img;
    }

    public function setImg(File $img): self
    {
        //Get the filesystem
        $fs = new Filesystem();

        //Remove old img
        if($this->imgName != null && $fs->exists($this->getImg())) {
            $fs->remove($this->getImg());
        }

        //Create unique file name
        do {
            $fileName = $this->generateFileName();
        }while($fs->exists("public/".$this->getImgFolderDir().$fileName.".".$img->getExtension()));

        $fileName = $fileName.".".$img->getExtension();

        //Copy the file into the good directory
        $fs->copy($img->getPathname(), "public/".$this->getImgFolderDir().$fileName);

        $this->img = new File("public/".$this->getImgFolderDir().$fileName);

        $this->imgName = $fileName;

        return $this;
    }
}