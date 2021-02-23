<?php


namespace App\Tests\Entity;

use App\Entity\Item;
use App\Entity\ItemColor;
use App\Repository\ItemRepository;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemColorFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemColorTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): ItemColor
    {
        return FakerEntity::itemColor($nullElement);
    }

    public function testValidEntity()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNotAvailableColor() {
        $this->printTestInfo();
        $this->expectException(\Exception::class);
        $this->getEntity()->setColor("not available color");
    }

    public function testInvalidNullColor() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("color"), 1);
    }

    public function testValidNullDescription() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("description"), 0);
    }

    public function testValidBlankDescription() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setDescription(""), 0);
    }

    public function testInvalidNullItem() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("item"), 1);
    }

    public function testInvalidDuplicateCombinationColorItem() {
        $this->printTestInfo();
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class,
            ItemFixtures::class,
            ItemColorFixtures::class,
        ]);
        /**
         * @var Item $item
         */
        $item = self::$container->get(ItemRepository::class)->findOneBy([]);
        $colors = $item->getColors();
        $colors[1]->setColor($colors[0]->getColor());
        $this->assertHasErrors($colors[1], 1);
    }
}