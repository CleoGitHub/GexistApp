<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;

class ItemFixtures extends Fixture
{

    protected $faker;

    public function load(ObjectManager $manager)
    {
        $finder = new Finder();
        $this->faker = Factory::create('fr_FR');

        $cats = $manager->getRepository(Category::class)->findAll();
        foreach ($cats as $cat) {
            foreach ($cat->getSubcategories() as $subcat) {

                $pathsToFiles = "public/assets/fixtureImgs/items/";
                switch ($subcat->getName()) {
                    case "Chemises":
                        $pathsToFiles .= "haut/chemises";
                        break;
                    case "T-Shirts":
                        $pathsToFiles .= "haut/t-shirts";
                        break;
                    case "Vestes":
                        $pathsToFiles .= "haut/vestes";
                        break;
                    case "Pantalons":
                        $pathsToFiles .= "bas/pantalons";
                        break;
                    case "Joggings":
                        $pathsToFiles .= "bas/joggings";
                        break;
                    case "Shorts":
                        $pathsToFiles .= "bas/shorts";
                        break;
                    case "Boots":
                        $pathsToFiles .= "chaussures/boots";
                        break;
                    case "Chaussures de ville":
                        $pathsToFiles .= "chaussures/chaussuresDeVille";
                        break;
                    case "Sneakers":
                        $pathsToFiles .= "chaussures/sneakers";
                        break;
                    case "Bracellets":
                        $pathsToFiles .= "accessoires/bracelets";
                        break;
                    case "Casquettes":
                        $pathsToFiles .= "accessoires/casquettes";
                        break;
                    case "Montres":
                        $pathsToFiles .= "accessoires/montres";
                        break;
                    default:
                        break;

                }
                $files = iterator_to_array($finder->files()->in($pathsToFiles));

                for($i = 0; $i < 75; $i++) {
                    $item = new Item();

                    $item->setName($cat." / ".$subcat." / ");
                    $item->setSubcategory($subcat);
                    $item->setDescription($this->faker->text);
                    $item->setDiscount(mt_rand(0,100));
                    $item->setIsNew($this->faker->boolean);
                    $item->setImg(new File(($this->faker->randomElement($files))->getPathName()));
                    switch ($item->getSubcategory()->getName()) {
                        case "Montres":
                            $min = 25;
                            $max = 500;
                            break;
                        case "Bracelet":
                            $min = 0.5;
                            $max = 25;
                            break;
                        default:
                            $min = 3;
                            $max = 150;
                            break;
                    }

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
}