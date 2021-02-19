<?php

namespace App\Controller;

use App\Entity\ItemColor;
use App\Services\UploadHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(UploadHelper $uploadHelper): Response
    {
        $color = $this->getDoctrine()->getRepository(ItemColor::class)->findOneBy([]);
        $finder = new Finder();
        $files = iterator_to_array($finder->files()->in(__DIR__.'/../../public/assets/images/'));
        $first = true;
        do{
            if(!$first)
                array_shift($files);
            $first = false;
            $filepath = array_key_first($files);
        }while(strpos($filepath,"webp") != false);

        $file = new File($filepath);
        $retour["files"] = $uploadHelper->uploadItemImage($file, $color, null);

        return $this->json(
            $retour
        );
    }
    /**
     * @Route("/itemImg/insertion", name="test")
     */
    public function itemImgInsertion(): Response
    {

    }

}
