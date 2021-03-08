<?php


namespace App\Tests\Traits;


use App\Entity\ItemCollection;
use App\Entity\ItemImg;
use App\Entity\Parade;
use App\Repository\ItemCollectionRepository;
use App\Repository\ItemImgRepository;
use App\Repository\ParadeRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemCollectionFixtures;
use App\Tests\Fixtures\ItemColorFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Tests\Fixtures\ItemImgFixtures;
use App\Tests\Fixtures\ParadeFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use Symfony\Component\Filesystem\Filesystem;

Trait Files
{
    public function initItemImg() {
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class,
            ItemFixtures::class,
            ItemColorFixtures::class,
            ItemImgFixtures::class,
        ]);
    }

    public function clearFilesItemImg() {
        $fs = new Filesystem();
        /**
         * @var ItemImg $img
         */
        foreach (self::$container->get(ItemImgRepository::class)->findAll() as $img) {
            $fs->remove("public".$img->getImgPath());
            $fs->remove("public".$img->getImgSmallPath());
            $fs->remove("public".$img->getImgMediumPath());
        }
    }


    public function initItemCollection() {
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class,
            ItemFixtures::class,
            ItemCollectionFixtures::class,
        ]);
    }

    public function clearFilesItemCollection() {
        $fs = new Filesystem();
        /**
         * @var ItemCollection $collection
         */
        foreach (self::$container->get(ItemCollectionRepository::class)->findAll() as $collection) {
            $fs->remove("public".$collection->getImagePath());
        }
    }




    public function initParade() {
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class,
            ItemFixtures::class,
            ParadeFixtures::class,
        ]);
    }

    public function clearFilesParade() {
        $fs = new Filesystem();

        /**
         * @var Parade $collection
         */
        foreach (self::$container->get(ParadeRepository::class)->findAll() as $collection) {
            $fs->remove("public".$collection->getVideoPath());
        }
    }
}
