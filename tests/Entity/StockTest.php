<?php


namespace App\Tests\Entity;

use App\Entity\Stock;
use App\Repository\StockRepository;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemColorFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Tests\Fixtures\SizeFixtures;
use App\Tests\Fixtures\StockFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StockTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): Stock
    {
        return FakerEntity::stock($nullElement);
    }

    public function testValidEntity() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNegativeQuantity() {
        $this->printTestInfo();
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setQuantity(-5), 1);
        $entity->setQuantity(5);
        $this->assertHasErrors($entity->subQuantity(6), 1);
    }

    public function testInvalidDuplicateItemColorSizeCombination() {
        $this->printTestInfo();
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class,
            ItemFixtures::class,
            ItemColorFixtures::class,
            SizeFixtures::class,
            StockFixtures::class
        ]);

        /**
         * @var Stock $stock
         */
        $stock = self::$container->get(StockRepository::class)->findOneBy([]);

        $entity = $this->getEntity();
        $entity->setColor($stock->getColor());
        $entity->setSize($stock->getSize());

        $this->assertHasErrors($entity, 1);
    }

    public function testInvalidNullSize() {
        $this->assertHasErrors($this->getEntity("size"), 1);
    }

    public function testInvalidNullColor() {
        $this->assertHasErrors($this->getEntity("color"), 1);
    }

    public function testInvalidNullQuantity() {
        $this->assertHasErrors($this->getEntity("quantity"), 1);
    }
}