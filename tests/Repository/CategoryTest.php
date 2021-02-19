<?php
namespace App\Tests\Repository;

use App\Repository\CategoryRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase {

    use FixturesTrait, Printer;

    public function testTestsCategoryInsertion() {
        $this->printTestInfo();
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class
        ]);
        $cats = self::$container->get(CategoryRepository::class)->count([]);
        $this->assertEquals(1, $cats);
    }
}
