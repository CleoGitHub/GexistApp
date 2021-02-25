<?php


namespace App\Tests\Repository;


use App\Repository\MarkRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\MarkFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Repository\ItemRepository;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MarkTest extends KernelTestCase
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
            MarkFixtures::class
        ]);
        $expected = self::$container->get(ItemRepository::class)->count([]);
        $this->assertEquals($expected, self::$container->get(MarkRepository::class)->count([]));
    }
}