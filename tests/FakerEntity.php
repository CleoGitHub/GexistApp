<?php


namespace App\Tests;


use App\Entity\Category;
use App\Entity\Feature;
use App\Entity\FeatureValue;
use App\Entity\ItemImg;
use App\Entity\Item;
use App\Entity\ItemColor;
use App\Entity\Subcategory;
use Faker\Factory;

class FakerEntity
{
    public static function category($nullElement = null):Category {
        $cat = new Category();
        if($nullElement != "name")
            $cat->setName("ValideForCategory");

        return $cat;
    }

    public static function subcategory($nullElement = null): Subcategory {
        $cat = self::category()->setName("ValideForSubcategory");

        $subcat = new Subcategory();
        if($nullElement != "name")
            $subcat->setName("ValideForSubcategory");

        if($nullElement != "category")
            $subcat->setCategory($cat);

        return $subcat;
    }

    public static function feature($nullElement = null): Feature {
        $subcat = self::subcategory();
        $subcat->getCategory()->setName("ValideForFeature");
        $subcat->setName("ValideForFeature");

        $feat = new Feature();

        if($nullElement != "name")
            $feat->setName("ValideForFeature");

        if($nullElement != "subcategory")
            $feat->setSubcategory($subcat);

        return $feat;
    }

    public static function featureValue($nullElement = null): FeatureValue {
        $feat = self::feature();
        $subcat = $feat->getSubcategory();
        $subcat->getCategory()->setName("ValideForFeatureValue");
        $subcat->setName("ValideForFeatureValue");
        $feat->setName("ValideForFeatureValue");

        $featValue = new FeatureValue();
        if($nullElement != "position")
            $featValue->setPosition(2);

        if($nullElement != "value")
            $featValue->setValue("ValideForFeatureValue");

        if($nullElement != "feature")
            $featValue->setFeature($feat);

        return $featValue;
    }

    public static function item($nullElement = null): Item {
        $faker = \Faker\Factory::create('fr_FR');

        $subcat = self::subcategory();

        $subcat->getCategory()->setName("ValideForItem");
        $subcat->setName("ValideForItem");

        $item = new Item();

        if($nullElement != "name")
            $item->setName("ValideForItem");

        if($nullElement != "subcategory")
            $item->setSubcategory($subcat);

        if($nullElement != "description")
            $item->setDescription($faker->text);

        if($nullElement != "discount")
            $item->setDiscount(mt_rand(0,100));

        if($nullElement != "price")
            $item->setPrice($faker->randomFloat(2,0.5,150));

        if($nullElement != "isNew")
            $item->setIsNew($faker->boolean);

        return $item;
    }

    public static function itemColor($nullElement = null) {

        $faker = Factory::create('fr_FR');

        $item = self::item();

        $item->getSubcategory()->getCategory()->setName("ValideForItemColor");
        $item->getSubcategory()->setName("ValideForItemColor");
        $item->setName("ValideForItemColor");

        $itemColor = new ItemColor();

        if($nullElement != "item")
            $itemColor->setItem($item);

        if($nullElement != "description")
            $itemColor->setDescription($faker->text);

        if($nullElement != "position")
            $itemColor->setPosition(1);

        if($nullElement != "color") {
            try {
                $itemColor->setColor($faker->randomElement($itemColor->getAvailableColors()));
            } catch (\Exception $e) {
            }
        }

        return $itemColor;
    }

    public static function itemImg($nullElement = null): ItemImg {

        $itemColor = self::itemColor();
        $item = $itemColor->getItem();

        $item->getSubcategory()->getCategory()->setName("ValideForImgItemColor");
        $item->getSubcategory()->setName("ValideForImgItemColor");
        $item->setName("ValideForImgItemColor");

        $imgItemColor = new ItemImg($itemColor);

        if($nullElement != "img")
            $imgItemColor->setImg("tests/files/file.webp");

        if($nullElement != "imgSmall")
            $imgItemColor->setImgSmall("tests/files/file.webp");

        if($nullElement != "imgMedium")
            $imgItemColor->setImgMedium("tests/files/file.webp");

        return $imgItemColor;
    }
}