<?php


namespace App\Tests\Fixtures;


use App\Entity\Item;
use App\Entity\Mark;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarkFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $items = $manager->getRepository(Item::class)->findAll();
        foreach ($items as $item) {
            $mark = new Mark();
            $mark->setGrade(mt_rand(0,5));
            $mark->setItem($item);
            $manager->persist($item);
            $manager->persist($mark);
        }
        $manager->flush();
    }
}