<?php
namespace App\Tests\Repository;

use App\DataFixtures\CategoryFixtures;
use App\Repository\CategoryRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase {

    use FixturesTrait;

    public function testTestsCategoryInsertion() {
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class
        ]);
        $cats = self::$container->get(CategoryRepository::class)->count([]);
        $this->assertEquals(4, $cats);
    }
}
