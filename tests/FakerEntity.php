<?php


namespace App\Tests;


use App\Entity\Category;
use App\Entity\Feature;
use App\Entity\FeatureValue;
use App\Entity\ItemImg;
use App\Entity\Item;
use App\Entity\ItemColor;
use App\Entity\Mark;
use App\Entity\Size;
use App\Entity\Stock;
use App\Entity\Subcategory;
use Faker\Factory;

class FakerEntity
{
    public static function category($nullElement = null):Category
    {
        $cat = new Category();
        if($nullElement != "name")
            $cat->setName("ValidForCategory");

        return $cat;
    }

    public static function subcategory($nullElement = null): Subcategory
    {
        $cat = self::category()->setName("ValidForSubcategory");

        $subcat = new Subcategory();
        if($nullElement != "name")
            $subcat->setName("ValidForSubcategory");

        if($nullElement != "category")
            $subcat->setCategory($cat);

        return $subcat;
    }

    public static function feature($nullElement = null): Feature
    {
        $subcat = self::subcategory();
        $subcat->getCategory()->setName("ValidForFeature");
        $subcat->setName("ValidForFeature");

        $feat = new Feature();

        if($nullElement != "name")
            $feat->setName("ValidForFeature");

        if($nullElement != "subcategory")
            $feat->setSubcategory($subcat);

        return $feat;
    }

    public static function featureValue($nullElement = null): FeatureValue
    {
        $feat = self::feature();
        $subcat = $feat->getSubcategory();
        $subcat->getCategory()->setName("ValidForFeatureValue");
        $subcat->setName("ValidForFeatureValue");
        $feat->setName("ValidForFeatureValue");

        $featValue = new FeatureValue();
        if($nullElement != "position")
            $featValue->setPosition(2);

        if($nullElement != "value")
            $featValue->setValue("ValidForFeatureValue");

        if($nullElement != "feature")
            $featValue->setFeature($feat);

        return $featValue;
    }

    public static function item($nullElement = null): Item
    {
        $faker = \Faker\Factory::create('fr_FR');

        $subcat = self::subcategory();

        $subcat->getCategory()->setName("ValidForItem");
        $subcat->setName("ValidForItem");

        $item = new Item();

        if($nullElement != "name")
            $item->setName("ValidForItem");

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

    public static function itemColor($nullElement = null): ItemColor
    {

        $faker = Factory::create('fr_FR');

        $item = self::item();

        $item->getSubcategory()->getCategory()->setName("ValidForItemColor");
        $item->getSubcategory()->setName("ValidForItemColor");
        $item->setName("ValidForItemColor");

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

        $item->getSubcategory()->getCategory()->setName("ValidForImgItemColor");
        $item->getSubcategory()->setName("ValidForImgItemColor");
        $item->setName("ValidForImgItemColor");

        $imgItemColor = new ItemImg($itemColor);

        if($nullElement != "img")
            $imgItemColor->setImg("tests/files/file.webp");

        if($nullElement != "imgSmall")
            $imgItemColor->setImgSmall("tests/files/file.webp");

        if($nullElement != "imgMedium")
            $imgItemColor->setImgMedium("tests/files/file.webp");

        return $imgItemColor;
    }

    public static function size(?string $nullElement = null): Size
    {
        $subcategory = self::subcategory();
        $subcategory->setName("ValidForSize");;
        $subcategory->getCategory()->setName("ValidForSize");
        $size = new Size($subcategory);

        if($nullElement != "value")
            $size->setValue("sizeA");

        if($nullElement != "position")
            $size->setPosition(1);

        return $size;
    }

    public static function stock(?string $nullElement): Stock
    {
        $color = self::itemColor();
        $subcategory = $color->getItem()->getSubcategory();
        $subcategory->setName("ValidForStock");
        $subcategory->getCategory()->setName("ValidForStock");
        $size = new Size($subcategory);
        $size->setValue("SizeA");
        $size->setPosition(1);

        $stock = new Stock();

        if($nullElement != "quantity")
            $stock->setQuantity(1);

        if($nullElement != "size")
            $stock->setSize($size);

        if($nullElement != "color")
            $stock->setColor($color);

        return $stock;
    }

    public static function mark(?string $nullElement): Mark
    {
        $item = self::item();

        $item->getSubcategory()->getCategory()->setName("ValidForMark");
        $item->getSubcategory()->setName("ValidForMark");
        $item->setName("ValidForMark");

        $mark = new Mark();

        if($nullElement != "item")
            $mark->setItem($item);

        if($nullElement != "grade")
            $mark->setGrade(mt_rand(0,5));

        return $mark;
    }
}