<?php

namespace App\DataFixtures;

use App\Entity\Subcategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class SubcategoryFixtures  extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cats = [
            "Haut" => [
                "Chemises",
                "T-Shirts",
                "Vestes"
            ],
            "Bas" => [
                "Pantalons",
                "Joggings",
                "Shorts"
            ],
            "Chaussures" => [
                "Boots",
                "Chaussures de ville",
                "Sneakers"
            ],
            "Accessoire" => [
                "Bracellets",
                "Casquettes",
                "Montres"
            ]
        ];

        foreach ($cats as $catName => $subcats) {
            $cat = $manager->getRepository(Category::class)->findOneByName($catName);
            foreach ($subcats as $name) {
                $cat->addSubcategory((new Subcategory())->setName($name));
            }
            $manager->persist($cat);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['item'];
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}