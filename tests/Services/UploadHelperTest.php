<?php


namespace App\Tests\Services;

use App\Entity\Item;
use App\Entity\ItemCollection;
use App\Entity\Parade;
use App\Repository\ItemCollectionRepository;
use App\Repository\ItemRepository;
use App\Repository\ParadeRepository;
use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemImgFixtures;
use App\Tests\Fixtures\ItemColorFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Entity\ItemImg;
use App\Repository\ItemImgRepository;
use App\Services\UploadHelper;
use App\Tests\Traits\Files;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class UploadHelperTest extends KernelTestCase
{
    use Printer, FixturesTrait, Files;

    /*public function testUniqueFilename() {
        self::bootKernel();
        $uploadHelper = self::$container->get(UploadHelper::class);
        $uniqids = [];
        for($i = 0; $i < 1000; $i++) {
            $uniqids[] = $uploadHelper->uniqid();
        }

        $this->assertSameSize($uniqids, array_unique($uniqids));
    }*/

    public function testUploadFilesItemImg() {
        $this->printTestInfo();
        $this->initItemImg();

        $imgs = self::$container->get(ItemImgRepository::class)->findBy([],[],100);

        /**
         * @var ItemImg $img
         */
        foreach ($imgs as $img) {
            $this->assertFileExists("public".$img->getImgPath());
            $this->assertFileExists("public".$img->getImgSmallPath());
            $this->assertFileExists("public".$img->getImgMediumPath());
        }

        $this->clearFilesItemImg();
    }



    public function testUploadFilesItemCollection() {
        $this->printTestInfo();
        $this->initItemCollection();

        $imgs = self::$container->get(ItemCollectionRepository::class)->findBy([],[],100);

        /**
         * @var ItemCollection $img
         */
        foreach ($imgs as $img) {
            $this->assertFileExists("public".$img->getImagePath());
        }

        $this->clearFilesItemCollection();
    }

    public function testUploadFilesParade() {
        $this->printTestInfo();
        $this->initParade();

        $parades = self::$container->get(ParadeRepository::class)->findBy([],[],100);

        /**
         * @var Parade $parade
         */
        foreach ($parades as $parade)
            $this->assertFileExists("public".$parade->getVideoPath());

        $this->clearFilesParade();
    }
}