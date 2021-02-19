<?php


namespace App\Tests\Entity;

use App\Entity\Subcategory;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SubcategoryTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): Subcategory
    {
        return FakerEntity::subcategory($nullElement);
    }

    public function testValidEntity() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidDuplicateCombinationCategoryName() {
        $this->printTestInfo();
        $cat = $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/subcategory.yaml"
        ]);
        $this->assertHasErrors($this->getEntity()->setCategory($cat["cat"]), 1);
    }

    public function testInvalidLongName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideValideValideValideValideValideValideValideValidelideValideValideValideValidd"), 0);
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideValideValideValideValideValideValideValideValidelideValideValideValideValidde"), 1);
    }

    public function testInvalidBlankName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
    }

    public function testInvalidNullName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("name"), 1);
    }

    public function testInvalidNullCategory() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("category"), 1);
    }
}