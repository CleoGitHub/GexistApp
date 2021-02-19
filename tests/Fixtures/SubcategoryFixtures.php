<?php

namespace App\Tests\Fixtures;

use App\Entity\Subcategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class SubcategoryFixtures  extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cats = [
            "Category" => [
                "Subcategory",
            ],
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
}