<?php


namespace App\Tests\Repository;

use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\ItemImgFixtures;
use App\Tests\Fixtures\ItemColorFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Tests\Fixtures\ItemFixtures;
use App\Entity\ItemImg;
use App\Repository\ItemColorRepository;
use App\Repository\ItemImgRepository;
use App\Tests\Traits\Files;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class ItemImgTest extends KernelTestCase
{
    use Printer, FixturesTrait, Files;

    public function testTestsImgItemColorInsertion() {
        $this->printTestInfo();
        $this->init();
        $expected = self::$container->get(ItemColorRepository::class)->count([]) * 2;
        $this->assertEquals($expected, self::$container->get(ItemImgRepository::class)->count([]));
        $this->clearFiles();
    }

    public function testTestAddImg() {
        $this->printTestInfo();
        $this->init();
        $manager = self::$container->get('doctrine')->getManager();
        $itemColor = self::$container->get(ItemColorRepository::class)->findOneBy([]);
        $id = $itemColor->getId();

        $nbImgs = $itemColor->getImgs()->count();

        $img = new ItemImg($itemColor);
        $img->setImg("tests/Files/file.webp");
        $img->setImgSmall("tests/Files/file.webp");
        $img->setImgMedium("tests/Files/file.webp");

        $manager->persist($itemColor);
        $manager->flush();
        $idImg = $img->getId();

        $manager->refresh($itemColor);
        $manager->refresh($img);
        $itemColor = self::$container->get(ItemColorRepository::class)->findOneBy(["id" => $id]);

        $this->assertEquals($nbImgs + 1, $itemColor->getImgs()->count());

        $this->assertNotNull(self::$container->get(ItemImgRepository::class)->findOneBy(["id" => $idImg]));

        $this->clearFiles();
    }
}