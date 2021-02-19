<?php


namespace App\Services;


use App\Entity\ItemColor;
use Exception;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Sluggable\Util\Urlizer;

class UploadHelper
{
    const ITEM_IMG = "items";

    private $filesystem;
    private $logger;

    public function __construct(FilesystemInterface $publicImagesFilesystem, LoggerInterface $logger)
    {
        $this->filesystem = $publicImagesFilesystem;
        $this->logger = $logger;
    }

    public function uploadItemImage(File $file, ItemColor $itemColor, ?string $existingFilename): array
    {
        $filenames = [];

        //Remove old file
        if($existingFilename)
            try {
                $result = $this->filesystem->delete(self::ITEM_IMG.'/'.$existingFilename);

                if(!$result)
                    throw new Exception("Could not delete old uploaded file \"$existingFilename\"");

            } catch(FileNotFoundException $e) {
                $this->logger->alert("Old upload file \"$existingFilename\" was missing when trying to delete");
            }

        //Create new filename
        do {
            $name =  $this->uniqid()."-".Urlizer::urlize($itemColor->generateNameForImg());
            $filename = $name.".".$file->guessExtension();

            //Check if filename already exist
            try {
                $exist = $this->filesystem->has(self::ITEM_IMG.'/'.$filename);
            }catch (FileExistsException $e) {
                $exist = true;
            }
        }while($exist);

        $filenames["normal"] = $filename;

        //Write the file
        $stream = fopen($file->getPathname(), 'r');
        $result = $this->filesystem->writeStream(
            self::ITEM_IMG.'/'.$filename,
            $stream
        );

        //If failed throw error
        if(!$result) {
            throw new \Exception("Could not write uploaded file \"$filename\"");
        }

        if(is_resource($stream))
            fclose($stream);

        //Thumbnails options
        $thumbnailInfos = [
            "type" => [
                "small",
                "medium"
            ],
            "resolutions" => [
                [
                    "x" => 150,
                    "y" => 150
                ],
                [
                    "x" => 500,
                    "y" => 500
                ]
            ]
        ];

        //Create the thumbnails
        $thumbnails = $this->createThumbnails($file, $thumbnailInfos["resolutions"]);
        foreach ($thumbnails as $key => $thumbnail) {
            $filename = $name."-".$thumbnailInfos["type"][$key].".".$file->guessExtension();
            $filenames[$thumbnailInfos["type"][$key]] = $filename;
            $result = $this->filesystem->write(
                self::ITEM_IMG.'/'.$filename,
                $thumbnail
            );

            //If failed throw error
            if(!$result) {
                throw new \Exception("Could not write uploaded file \"$filename\"");
            }
        }

        return $filenames;
    }

    private function createThumbnails(File $file, array $resolutions): array
    {
        $imagine = new Imagine();
        $image = $imagine->open($file->getPathname());
        $mode = ImageInterface::THUMBNAIL_INSET;
        $thumbnails = [];
        foreach ($resolutions as $resolution) {
            $size = new Box($resolution["x"], $resolution["y"]);
            $thumbnails[] = $image->thumbnail($size, $mode)->get($file->guessExtension());
        }
        return $thumbnails;
    }

    public static function getImgPublicPath(string $path, string $type = "normal"): string
    {
        return '/assets/images/'.$path;
    }

    public function uniqid() :string
    {
        return substr(str_shuffle(md5(uniqid())), 0, 13);
    }
}