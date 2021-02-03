<?php


namespace App\Tests\Repository;


use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\FeatureFixtures;
use App\DataFixtures\FeatureValueFixtures;
use App\DataFixtures\SubcategoryFixtures;
use App\DataFixtures\ItemFixtures;
use App\Repository\ItemRepository;
use App\Repository\SubcategoryRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemTest extends KernelTestCase
{

    use FixturesTrait;

    public function testTestsItemInsertion() {
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class,
            ItemFixtures::class,
        ]);
        $expected = self::$container->get(SubcategoryRepository::class)->count([]) * 75;
        $this->assertEquals($expected, self::$container->get(ItemRepository::class)->count([]));
    }
}