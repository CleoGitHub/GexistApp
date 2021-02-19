<?php


namespace App\Tests\Fixtures;


use App\Entity\Category;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ItemFixtures  extends Fixture
{

    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create('fr_FR');

        $cats = $manager->getRepository(Category::class)->findAll();
        foreach ($cats as $cat) {
            foreach ($cat->getSubcategories() as $subcat) {
                $min = 3;
                $max = 150;
                $item = new Item();
                $item->setName($cat." / ".$subcat." / ");
                $item->setSubcategory($subcat);
                $item->setDescription($this->faker->text);
                $item->setDiscount(mt_rand(0,100));
                $item->setIsNew($this->faker->boolean);
                $item->setPrice($this->faker->randomFloat(2,$min,$max));
                foreach ($subcat->getFeatures() as $feat) {
                    foreach ($feat->getFeatureValues() as $filter) {
                        if($this->faker){
                            $item->addFilter($filter);
                            $item->setName($item->getName()." ".$filter);
                        }
                    }
                }
                $manager->persist($item);
            }
        }
        $manager->flush();
    }
}