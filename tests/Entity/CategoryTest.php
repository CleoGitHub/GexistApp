<?php


namespace App\Tests\Entity;


use App\Entity\Category;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors;

    public function getEntity() {
        return FakerEntity::category();
    }

    public function testValideEntity() {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalideDuplicateName() {
        $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/category.yaml"
        ]);
        $this->assertHasErrors($this->getEntity(), 1);
    }

    public function testInvalideLongName() {
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideValideValideValideValideValideValideValideVali"), 0);
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideValideValideValideValideValideValideValideValid"), 1);
    }

    public function testInvalideBlankName() {
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
    }
}