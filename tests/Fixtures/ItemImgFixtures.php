<?php


namespace App\Tests\Fixtures;


use App\Entity\ItemImg;
use App\Entity\ItemColor;
use App\Services\UploadHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;

class ItemImgFixtures extends Fixture
{
    private $uploadHelper;
    private $finder;
    private $fs;
    private $faker;

    public function __construct(UploadHelper $uploadHelper, FilesystemInterface $publicImagesFilesystem) {
        $this->uploadHelper = $uploadHelper;
        $this->finder = new Finder();
        $this->fs = new FileSystem();
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {

        $colors = $manager->getRepository(ItemColor::class)->findBy([],["item" => "ASC"]);
        $lastSubcat = null;

        /**
         * @var ItemColor $color
         */
        foreach ($colors as $color) {
            $files = [
                __DIR__."/../Files/file.webp"
            ];
            for($i = 0; $i < 2; $i++) {
                $img = new ItemImg($color);
                $filenames = $this->uploadHelper->uploadItemImage($this->fakeUploadImg($files), $color, $img->getImg());
                $img->setImg($filenames["normal"]);
                $img->setImgSmall($filenames["small"]);
                $img->setImgMedium($filenames["medium"]);
            }
            $manager->persist($color);
        }
        $manager->flush();
    }

    public function fakeUploadImg(array $files): File
    {
        $filePath = $this->faker->randomElement($files);
        $fileName = explode("/",$filePath);
        $targetPath = sys_get_temp_dir().'/'.end($fileName);
        $this->fs->copy($filePath,$targetPath,true);
        return new File($targetPath);
    }
}