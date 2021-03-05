<?php

namespace App\Tests\Repository;

use App\Entity\Item;
use App\Repository\ItemCollectionRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemCollectionFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Repository\ItemRepository;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemCollectionTest extends KernelTestCase
{
    use FixturesTrait, Printer;

    public function testTestsCollectionInsertion() {
        $this->printTestInfo();
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class,
            ItemFixtures::class,
            ItemCollectionFixtures::class
        ]);
        $collection = self::$container->get(ItemCollectionRepository::class)->findOneBy([]);
        $this->assertNotNull($collection);
        $items = self::$container->get(ItemRepository::class)->findAll();

        /**
         * @var Item $item
         */
        foreach ($items as $item)
            $this->assertEquals($collection, $item->getCollections()[0]);
    }
}