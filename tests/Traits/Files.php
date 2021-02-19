<?php


namespace App\Tests\Traits;


use App\Entity\ItemImg;
use App\Repository\ItemImgRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemColorFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Tests\Fixtures\ItemImgFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use Symfony\Component\Filesystem\Filesystem;

Trait Files
{
    public function init() {
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

    public function clearFiles() {
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
}
