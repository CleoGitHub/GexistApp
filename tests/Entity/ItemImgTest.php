<?php


namespace App\Tests\Entity;

use App\Entity\ItemImg;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemImgTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): ItemImg
    {
        return FakerEntity::itemImg($nullElement);
    }

    public function testValidEntity()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNullImg()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("img"), 2);
    }

    public function testInvalidBlankImg()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setImg(""), 1);
    }

    public function testInvalidNullImgSmall()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("imgSmall"), 2);
    }

    public function testInvalidBlankImgSmall()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setImgSmall(""), 1);
    }

    public function testInvalidNullImgMedium()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("imgMedium"), 2);
    }

    public function testInvalidBlankImgMedium()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setImgMedium(""), 1);
    }
}