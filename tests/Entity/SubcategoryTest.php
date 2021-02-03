<?php


namespace App\Tests\Entity;


use App\Entity\Category;
use App\Entity\Subcategory;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SubcategoryTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors;

    public function getEntity() {
        return FakerEntity::subcategory();
    }

    public function testValideEntity() {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalideDuplicateCombinationCategoryName() {
        $cat = $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/subcategory.yaml"
        ]);
        $this->assertHasErrors($this->getEntity()->setCategory($cat["cat"]), 1);
    }

    public function testInvalideLongName() {
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideValideValideValideValideValideValideValideValidelideValideValideValideValidd"), 0);
        $this->assertHasErrors($this->getEntity()->setName("ValideValideValideValideValideValideValideValideValideValideValideValidelideValideValideValideValidde"), 1);
    }

    public function testInvalideBlankName() {
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
    }
}