<?php


namespace App\Tests\Fixtures;


use App\Entity\Item;
use App\Entity\Size;
use App\Entity\Stock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StockFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $sizes = $manager->getRepository(Size::class)->findAll();
        foreach ($sizes as $size) {
            $items = $manager->getRepository(Item::class)->findBy([
                "subcategory" => $size->getSubcategory()
            ]);
            foreach ($items as $item) {
                foreach ($item->getColors() as $color) {
                    $stock = new Stock();
                    $stock->setColor($color);
                    $stock->setSize($size);
                    $stock->setQuantity(1);
                    $manager->persist($stock);
                    $manager->persist($color);
                }
            }
            $manager->persist($size);
        }
        $manager->flush();
    }
}