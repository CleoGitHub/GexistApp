<?php


namespace App\Tests\Fixtures;


use App\Entity\Item;
use App\Entity\ItemCollection;
use App\Tests\FakerEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ItemCollectionFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $collection = FakerEntity::itemCollection();

        $items = $manager->getRepository(Item::class)->findAll();
        foreach ($items as $item)
            $collection->addItem($item);

        $manager->persist($collection);
        $manager->flush();
    }
}