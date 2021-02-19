<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ItemFixtures  extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
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
                switch ($subcat->getName()) {
                    case "Bracellets":
                        $min = 0.5;
                        $max = 25;
                        break;
                    case "Montres":
                        $min = 25;
                        $max = 500;
                        break;
                    default:
                        break;
                }

                for($i = 0; $i < 5; $i++) {
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
            SubcategoryFixtures::class,
            FeatureValueFixtures::class
        ];
    }
}