<?php


namespace App\Tests\Repository;

use App\Repository\SizeRepository;
use App\Repository\StockRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemColorFixtures;
use App\Tests\Fixtures\SizeFixtures;
use App\Tests\Fixtures\StockFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Repository\ItemRepository;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StockTest extends KernelTestCase
{
    use FixturesTrait, Printer;

    public function testTestsItemInsertion() {
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
        $expected = 0;
        foreach (self::$container->get(SizeRepository::class)->findAll() as $size) {
            $items = self::$container->get(ItemRepository::class)->findBy([
                "subcategory" => $size->getSubcategory()
            ]);
            foreach ($items as $item) {
                $expected += $item->getColors()->count();
            }
        }

        $this->assertEquals(
           $expected,
            self::$container->get(StockRepository::class)->count([])
        );
    }
}