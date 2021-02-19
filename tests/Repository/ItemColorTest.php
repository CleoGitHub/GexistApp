<?php


namespace App\Tests\Repository;


use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemColorFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Repository\ItemColorRepository;
use App\Repository\ItemRepository;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemColorTest extends KernelTestCase
{

    use FixturesTrait, Printer;

    public function testTestsItemColorInsertion() {
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
        $expected = self::$container->get(ItemRepository::class)->count([]) * 2;
        $this->assertEquals($expected, self::$container->get(ItemColorRepository::class)->count([]));
    }
}