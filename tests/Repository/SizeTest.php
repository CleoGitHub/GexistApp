<?php


namespace App\Tests\Repository;


use App\Repository\SizeRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\SizeFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Repository\ItemRepository;
use App\Repository\SubcategoryRepository;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SizeTest extends KernelTestCase
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
            SizeFixtures::class
        ]);
        $this->assertEquals(
            self::$container->get(SubcategoryRepository::class)->count([]),
            self::$container->get(SizeRepository::class)->count([])
        );
    }
}