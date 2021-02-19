<?php


namespace App\Tests\Repository;

use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Repository\CategoryRepository;
use App\Repository\SubcategoryRepository;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SubcategoryTest extends KernelTestCase {

    use FixturesTrait, Printer;

    public function testTestsSubcategoryInsertion() {
        $this->printTestInfo();
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class
        ]);
        $this->assertEquals(1, self::$container->get(SubcategoryRepository::class)->count([]));
        $this->assertEquals(
            1,
            count(self::$container->get(CategoryRepository::class)->findOneByName("Category")->getSubcategories())
        );
    }
}