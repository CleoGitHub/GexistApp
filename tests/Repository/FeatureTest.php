<?php


namespace App\Tests\Repository;

use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\FeatureFixtures;
use App\DataFixtures\SubcategoryFixtures;
use App\Repository\FeatureRepository;
use App\Repository\SubcategoryRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureTest extends KernelTestCase {

    use FixturesTrait;

    public function testTestsFeatureInsertion() {
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class
        ]);
        $this->assertEquals(24, self::$container->get(FeatureRepository::class)->count([]));
        $this->assertEquals(
            2,
            count(self::$container->get(SubcategoryRepository::class)->findOneByName("T-Shirts")->getFeatures())
        );
        $this->assertNotNull(self::$container->get(FeatureRepository::class)->findOneByName("Col"));
    }
}