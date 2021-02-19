<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures  extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $cats = [
            "Haut",
            "Bas",
            "Chaussures",
            "Accessoire"
        ];

        foreach ($cats as $name) {
            $cat = new Category();
            $cat->setName($name);
            $manager->persist($cat);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['item'];
    }
}