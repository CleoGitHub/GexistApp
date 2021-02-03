<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
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
}