<?php


namespace App\DataFixtures;


use App\Entity\ItemImg;
use App\Entity\ItemColor;
use App\Entity\Subcategory;
use App\Services\UploadHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;

class ItemImgFixtures  extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
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
            $subcat = $color->getItem()->getSubcategory();
            if($subcat !== $lastSubcat) {
                $files = $this->getFiles($subcat);
            }
            for($i = 0; $i < 3; $i++) {
                $img = new ItemImg($color);
                $filenames = $this->uploadHelper->uploadItemImage($this->fakeUploadImg($files), $color, $img->getImg());
                $img->setImg($filenames["normal"]);
                $img->setImgSmall($filenames["small"]);
                $img->setImgMedium($filenames["medium"]);
            }
            $manager->persist($color);
            $lastSubcat = $subcat;
        }
        $manager->flush();
    }

    private function getFiles(Subcategory $subcat): array
    {
        $pathsToFiles = __DIR__."/Files/items/";
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
        return iterator_to_array($this->finder->files()->in($pathsToFiles));
    }

    public function fakeUploadImg(array $files): File
    {
        $filePath = $this->faker->randomElement($files);
        $fileName = explode("/",$filePath);
        $targetPath = sys_get_temp_dir().'/'.end($fileName);
        $this->fs->copy($filePath,$targetPath,true);
        return new File($targetPath);
    }

    public static function getGroups(): array
    {
        return ["item"];
    }

    public function getDependencies()
    {
        return [
          ItemColorFixtures::class
        ];
    }
}