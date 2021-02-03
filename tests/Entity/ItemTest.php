<?php


namespace App\Tests\Entity;

use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;

class ItemTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors;

    public function getEntity()
    {
        return FakerEntity::item();
    }

    public function testValideEntity() {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalideBlankName() {
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
    }

    public function testInvalideLongName() {
        $this->assertHasErrors($this->getEntity()->setName(
            "ValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideVal"
        ), 0);
        $this->assertHasErrors($this->getEntity()->setName(
            "VValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideVal"
        ), 1);
    }

    public function testInvalideBlankDescription() {
        $this->assertHasErrors($this->getEntity()->setDescription(""), 1);
    }

    public function testValideImgExist() {

        $entity = $this->getEntity();

        $this->assertHasErrors($entity->setImg(new File("tests/files/file.webp")), 0);
        $this->assertFileExists($entity->getImgDir());
    }
}