<?php


namespace App\Tests\Entity;

use App\Entity\Feature;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): Feature
    {
        return FakerEntity::feature($nullElement);
    }

    public function testValidEntity() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidDuplicateCombinationSubcategoryName() {
        $this->printTestInfo();
        $cat = $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/feature.yaml"
        ]);
        $this->assertHasErrors($this->getEntity()->setSubcategory($cat["subcat"]), 1);
    }

    public function testInvalidLongName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideV"), 0);
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideVa"), 1);
    }

    public function testInvalidBlankName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
    }

    public function testInvalidNullName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("name"), 1);
    }

    public function testInvalidNullSubcategory() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("subcategory"), 1);
    }
}