<?php


namespace App\Tests\Repository;

use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Repository\FeatureRepository;
use App\Repository\SubcategoryRepository;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureTest extends KernelTestCase {

    use FixturesTrait, Printer;

    public function testTestsFeatureInsertion() {
        $this->printTestInfo();
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class
        ]);
        $this->assertEquals(1, self::$container->get(FeatureRepository::class)->count([]));
        $this->assertEquals(
            1,
            count(self::$container->get(SubcategoryRepository::class)->findOneByName("Subcategory")->getFeatures())
        );
        $this->assertNotNull(self::$container->get(FeatureRepository::class)->findOneByName("Feature"));
    }
}