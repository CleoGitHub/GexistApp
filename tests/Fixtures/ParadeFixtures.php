<?php


namespace App\Tests\Fixtures;


use App\Entity\Item;
use App\Services\UploadHelper;
use App\Tests\FakerEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;

class ParadeFixtures extends Fixture
{
    private $uploadHelper;
    private $finder;
    private $fs;
    private $faker;

    public function __construct(UploadHelper $uploadHelper) {
        $this->uploadHelper = $uploadHelper;
        $this->finder = new Finder();
        $this->fs = new FileSystem();
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {

        $items = $manager->getRepository(Item::class)->findBy([]);

        $files = [
            __DIR__."/../Files/file_parade.mp4"
        ];

        $parade = FakerEntity::parade();
        $filename = $this->uploadHelper->uploadParadeVideo($this->fakeUploadVideo($files), $parade->getVideo());
        $parade->setVideo($filename);

        foreach ($items as $item) {
            $parade->addItem($item);
        }

        $manager->persist($parade);
        $manager->flush();
    }

    public function fakeUploadVideo(array $files): File
    {
        $filePath = $this->faker->randomElement($files);
        $fileName = explode("/",$filePath);
        $targetPath = sys_get_temp_dir().'/'.end($fileName);
        $this->fs->copy($filePath,$targetPath,true);
        return new File($targetPath);
    }
}