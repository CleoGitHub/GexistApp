<?php


namespace App\Tests\Repository;

use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\SubcategoryFixtures;
use App\Repository\CategoryRepository;
use App\Repository\SubcategoryRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SubcategoryTest extends KernelTestCase {

    use FixturesTrait;

    public function testTestsSubcategoryInsertion() {
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class
        ]);
        $this->assertEquals(12, self::$container->get(SubcategoryRepository::class)->count([]));
        $this->assertEquals(
            3,
            count(self::$container->get(CategoryRepository::class)->findOneByName("Haut")->getSubcategories())
        );
    }
}