<?php


namespace App\Tests;


use App\Entity\Category;
use App\Entity\Feature;
use App\Entity\FeatureValue;
use App\Entity\Item;
use App\Entity\Subcategory;
use Symfony\Component\HttpFoundation\File\File;

class FakerEntity
{
    public static function category():Category {
        return (new Category())->setName("ValideForCategory");
    }

    public static function subcategory(): Subcategory {
        $cat = self::category()->setName("ValideForSubcategory");
        return (new Subcategory())
            ->setName("ValideForSubcategory")
            ->setCategory($cat);
    }

    public static function feature(): Feature {
        $subcat = self::subcategory();
        $subcat->getCategory()->setName("ValideForFeature");
        $subcat->setName("ValideForFeature");
        return (new Feature())
            ->setName("ValideForFeature")
            ->setSubcategory($subcat);
    }

    public static function featureValue(): FeatureValue {
        $feat = self::feature();
        $subcat = $feat->getSubcategory();
        $subcat->getCategory()->setName("ValideForFeatureValue");
        $subcat->setName("ValideForFeatureValue");
        $feat->setName("ValideForFeatureValue");

        $featValue = new FeatureValue();
        $featValue->setOrd(2);
        $featValue->setValue("ValideForFeatureValue");
        $featValue->setFeature($feat);

        return $featValue;
    }

    public static function item(): Item {
        $faker = \Faker\Factory::create('fr_FR');

        $subcat = self::subcategory();
        $subcat->getCategory()->setName("ValideForItem");
        $subcat->setName("ValideForItem");



        $item = new Item();
        $item->setName("ValideForItem");
        $item->setSubcategory($subcat);
        $item->setDescription($faker->text);
        $item->setDiscount(mt_rand(0,100));
        $item->setIsNew($faker->boolean);
        $item->setImg(new File("tests/files/file.webp"));

        return $item;
    }
}