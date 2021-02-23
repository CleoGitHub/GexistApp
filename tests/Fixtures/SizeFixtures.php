<?php


namespace App\Tests\Fixtures;


use App\Entity\Size;
use App\Entity\Subcategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SizeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $subcategories = $manager->getRepository(Subcategory::class)->findAll();
        foreach ($subcategories as $subcategory) {
            $size = new Size($subcategory);
            $size->setValue("sizeA");
            $size->setPosition(1);
            $manager->persist($subcategory);
        }
        $manager->flush();
    }
}