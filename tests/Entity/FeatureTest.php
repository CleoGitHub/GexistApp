<?php


namespace App\Tests\Entity;


use App\Entity\Category;
use App\Entity\Feature;
use App\Entity\Subcategory;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors;

    public function getEntity() {
        return FakerEntity::feature();
    }

    public function testValideEntity() {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalideDuplicateCombinationSubcategoryName() {
        $cat = $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/feature.yaml"
        ]);
        $this->assertHasErrors($this->getEntity()->setSubcategory($cat["subcat"]), 1);
    }

    public function testInvalideLongName() {
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideV"), 0);
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideVa"), 1);
    }

    public function testInvalideBlankName() {
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
    }
}