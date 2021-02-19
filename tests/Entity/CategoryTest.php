<?php


namespace App\Tests\Entity;


use App\Entity\Category;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): Category
    {
        return FakerEntity::category($nullElement);
    }

    public function testValidEntity() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidDuplicateName() {
        $this->printTestInfo();
        $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/category.yaml"
        ]);
        $this->assertHasErrors($this->getEntity(), 1);
    }

    public function testInvalidLongName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideValideValideValideValideValideValideValideVali"), 0);
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideValideValideValideValideValideValideValideValid"), 1);
    }

    public function testInvalidBlankName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
    }

    public function testInvalidNullName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("name"), 1);
    }
}