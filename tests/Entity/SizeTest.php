<?php


namespace App\Tests\Entity;

use App\Entity\Size;
use App\Repository\SizeRepository;
use App\Repository\SubcategoryRepository;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Tests\Fixtures\SizeFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SizeTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): Size
    {
        return FakerEntity::size($nullElement);
    }

    public function testValidEntity() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNullValue() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("value"), 1);
    }

    public function testInvalidBlankValue() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setValue(""), 1);
    }

    public function testInvalidLongValue() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setValue("01234567890"), 1);
        $this->assertHasErrors($this->getEntity()->setValue("0123456789"), 0);
    }

    public function testInvalidDuplicateCombinationPositionSubcategory() {
        $this->printTestInfo();
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class,
            ItemFixtures::class,
            SizeFixtures::class
        ]);
        $subcategory = self::$container->get(SubcategoryRepository::class)->findOneBy([]);
        $this->assertHasErrors($this->getEntity()->setSubcategory($subcategory), 1);
    }
}