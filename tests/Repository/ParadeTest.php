<?php

namespace App\Tests\Repository;

use App\Entity\Item;
use App\Repository\ItemCollectionRepository;
use App\Repository\ParadeRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemCollectionFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Repository\ItemRepository;
use App\Tests\Traits\Files;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ParadeTest extends KernelTestCase
{
    use FixturesTrait, Printer, Files;

    public function testTestsCollectionInsertion() {
        $this->printTestInfo();
        $this->initParade();

        $parade = self::$container->get(ParadeRepository::class)->findOneBy([]);
        $this->assertNotNull($parade);
        $items = self::$container->get(ItemRepository::class)->findAll();

        /**
         * @var Item $item
         */
        foreach ($items as $item)
            $this->assertEquals($parade, $item->getParades()[0]);

        $this->clearFilesParade();
    }
}