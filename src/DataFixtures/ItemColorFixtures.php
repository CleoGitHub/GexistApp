<?php


namespace App\DataFixtures;


use App\Entity\Item;
use App\Entity\ItemColor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ItemColorFixtures  extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $items = $manager->getRepository(Item::class)->findAll();

        foreach ($items as $item) {
            for($i = 0; $i < 3; $i++) {
                $color = new ItemColor();
                $color->setColor($faker->randomElement($color->getAvailableColors()));
                $color->setDescription($faker->text);
                $color->setPosition($i);
                $item->addColor($color);
            }
            $manager->persist($item);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ["item"];
    }

    public function getDependencies()
    {
        return [
          ItemFixtures::class
        ];
    }
}