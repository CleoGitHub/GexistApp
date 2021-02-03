<?php


namespace App\Tests\Repository;

use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\FeatureFixtures;
use App\DataFixtures\FeatureValueFixtures;
use App\DataFixtures\SubcategoryFixtures;
use App\Repository\FeatureRepository;
use App\Repository\FeatureValueRepository;
use App\Repository\SubcategoryRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureValueTest extends KernelTestCase {

    use FixturesTrait;

    public function testTestsFeatureValueInsertion() {
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class
        ]);
        $this->assertEquals(82, self::$container->get(FeatureValueRepository::class)->count([]));
        $this->assertEquals(
            3,
            count(self::$container->get(FeatureRepository::class)->findOneBy([
                "name" => "Col",
                "subcategory" => self::$container->get(SubcategoryRepository::class)->findOneByName("Chemises")
            ])->getFeatureValues())
        );
        $this->assertNotNull(self::$container->get(FeatureValueRepository::class)->findOneByValue("Or"));
    }
}