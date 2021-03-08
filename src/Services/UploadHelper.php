<?php


namespace App\Services;


use App\Entity\ItemColor;
use Exception;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    const ITEM_IMG = "items";
    const ITEM_COLLECTION_IMG = "collections";
    const PARADE_VIDEO = "parades";

    private $image_filesystem;
    private $video_filesystem;
    private $logger;

    public function __construct(FilesystemInterface $publicImagesFilesystem, FilesystemInterface $publicVideosFilesystem, LoggerInterface $logger)
    {
        $this->image_filesystem = $publicImagesFilesystem;
        $this->video_filesystem = $publicVideosFilesystem;
        $this->logger = $logger;
    }

    /*
     * Upload methods
     */

    public function uploadItemCollectionImage(File $file, $existingFilename): string
    {
        //Remove old file
        if($existingFilename)
            try {
                $result = $this->image_filesystem->delete(self::ITEM_COLLECTION_IMG.'/'.$existingFilename);

                if(!$result)
                    throw new Exception("Could not delete old uploaded file \"$existingFilename\"");

            } catch(FileNotFoundException $e) {
                $this->logger->alert("Old upload file \"$existingFilename\" was missing when trying to delete");
            }

        //Create new filename
        do {
            if($file instanceof UploadedFile)
                $filename = $file->getClientOriginalName();
            else
                $filename = $file->getFilename();

            $filename =  $this->uniqid()."-".Urlizer::urlize($filename).".".$file->guessExtension();

        }while($this->fileExist(self::ITEM_COLLECTION_IMG.'/'.$filename));

        $this->writeStream($file, self::ITEM_COLLECTION_IMG.'/'.$filename, $this->image_filesystem);

        return $filename;
    }

    public function uploadItemImage(File $file, ItemColor $itemColor, ?string $existingFilename): array
    {
        $filenames = [];

        //Remove old file
        if($existingFilename)
            try {
                $result = $this->image_filesystem->delete(self::ITEM_IMG.'/'.$existingFilename);

                if(!$result)
                    throw new Exception("Could not delete old uploaded file \"$existingFilename\"");

            } catch(FileNotFoundException $e) {
                $this->logger->alert("Old upload file \"$existingFilename\" was missing when trying to delete");
            }

        //Create new filename
        do {
            $name =  $this->uniqid()."-".Urlizer::urlize($itemColor->generateNameForImg());
            $filename = $name.".".$file->guessExtension();
        }while($this->fileExist(self::ITEM_IMG.'/'.$filename));

        $filenames["normal"] = $filename;

        $this->writeStream($file, self::ITEM_IMG.'/'.$filename, $this->image_filesystem);

        //Thumbnails options
        $thumbnailInfos = $this->getThumbnailInfos();

        //Create the thumbnails
        $thumbnails = $this->createThumbnails($file, $thumbnailInfos["resolutions"]);

        foreach ($thumbnails as $key => $thumbnail) {
            $filename = $name."-".$thumbnailInfos["type"][$key].".".$file->guessExtension();
            $filenames[$thumbnailInfos["type"][$key]] = $filename;
            $this->write($thumbnail, self::ITEM_IMG.'/'.$filename);
        }

        return $filenames;
    }

    public function uploadParadeVideo(File $file, $existingFilename): string
    {
        //Remove old file
        if($existingFilename)
            try {
                $result = $this->video_filesystem->delete(self::PARADE_VIDEO.'/'.$existingFilename);

                if(!$result)
                    throw new Exception("Could not delete old uploaded file \"$existingFilename\"");

            } catch(FileNotFoundException $e) {
                $this->logger->alert("Old upload file \"$existingFilename\" was missing when trying to delete");
            }

        //Create new filename
        do {
            if($file instanceof UploadedFile)
                $filename = $file->getClientOriginalName();
            else
                $filename = $file->getFilename();

            $filename =  $this->uniqid()."-".Urlizer::urlize($filename).".".$file->guessExtension();

        }while($this->fileExist(self::PARADE_VIDEO.'/'.$filename));

        $this->writeStream($file, self::PARADE_VIDEO.'/'.$filename, $this->video_filesystem);

        return $filename;
    }

    /*
     * Methods related to thumbnail
     */

    private function getThumbnailInfos(): array
    {
        return [
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

    /*
     * Methods related to naming file
     */

    private function uniqid() :string
    {
        return substr(str_shuffle(md5(uniqid())), 0, 13);
    }

    private function fileExist(String $path): bool
    {
        //Check if filename already exist
        try {
            $exist = $this->image_filesystem->has($path);
        }catch (FileExistsException $e) {
            $exist = true;
        }
        return $exist;
    }

    /*
     * Methods in order to write file
     */

    private function writeStream(File $file, String $path, FilesystemInterface $filesystem)
    {
        //Write the file
        $stream = fopen($file->getPathname(), 'r');
        $result = $filesystem->writeStream(
            $path,
            $stream
        );

        //If failed throw error
        if(!$result) {
            throw new \Exception("Could not write uploaded file \"$path\"");
        }

        if(is_resource($stream))
            fclose($stream);
    }

    private function write(String $pathFile, String $path)
    {
        //Write the file
        $result = $this->image_filesystem->write(
            $path,
            $pathFile
        );

        //If failed throw error
        if(!$result)
            throw new \Exception("Could not write uploaded file \"$path\"");
    }

    /*
     * Methods in order to get public path
     */

    public static function getImgPublicPath(string $path, string $type = "normal"): string
    {
        return '/assets/images/'.$path;
    }

    public static function getVideoPublicPath(string $path)
    {
        return '/assets/videos/'.$path;
    }
}