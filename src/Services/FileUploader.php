<?php


namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Intl\Exception\MethodNotImplementedException;


class FileUploader
{

    /**
     * @param $directory String le repertoire du fichier
     * @param $objet l'objet qui contient la la variable du fichier
     * @param $variable String le nom de la variable qui contient le nom du fichier dans le bade de données
     * @return String le nom créé lors de l'upload du fichier, c'est le nom original du fichier ou ont a retiré les accents, remplacé les espaces par des - et retiré les majuscules.
     */
    static public function uploadFile(String $directory, $objet, String $variable) {

        $methodGet = 'get'.ucfirst($variable);
        if(method_exists($objet, $methodGet)) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file **/
            $file = $objet->$methodGet();
            $methodSet = 'set'.ucfirst($variable);

            if(method_exists($objet, $methodSet)) {

                if($file != null) {
                    $filename = GeneraterProtectedString::generateProtectedFileName($file->getClientOriginalName());

                    try {
                        $file->move(
                            $directory,
                            $filename
                        );
                    } catch (\Exception $e) {

                    }

                    $objet->$methodSet($filename);

                    return $filename;

                } else {

                    $objet->$methodSet(" ");

                    return " ";
                }

            } else {
                throw new MethodNotImplementedException($methodSet);
            }

        } else {
            throw new MethodNotImplementedException($methodGet);
        }
    }


    /**
     * @param $directory String le repertoire du fichier
     * @param $objet l'objet qui contient la la variable du fichier
     * @param $variable String le nom de la variable qui contient le nom du fichier dans le bade de données
     * @param $oldName String l'ancien nom du fichier
     * @return string le nom créé lors de l'upload du fichier, c'est le nom original du fichier ou ont a retiré les accents, remplacé les espaces par des - et retiré les majuscules.
     */
    static public function updateFile($directory, $objet, $variable, $oldName) {
        $filesystem = new Filesystem();

        $filename = $oldName;

        $methodGet = 'get'.ucfirst($variable);

        if(method_exists($objet, $methodGet)) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file **/
            $file = $objet->$methodGet();

            $methodSet = 'set'.ucfirst($variable);

            if(method_exists($objet, $methodSet)) {

                if($file != null) {

                    if(strlen(trim($filename)) > 0) {
                        try {
                            $filesystem->remove(array($directory.$filename));
                        } catch (\Exception $e) {
                            dump($e->getMessage());
                        }
                    }
                    $filename = GeneraterProtectedString::generateProtectedFileName($file->getClientOriginalName());

                    try {
                        $file->move(
                            $directory,
                            $filename
                        );
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                }

                if($filename != null) {

                    $objet->$methodSet($filename);

                } else {

                    $objet->$methodSet(" ");

                }

                return $filename;


            } else {
                throw new MethodNotImplementedException($methodSet);
            }

        } else {
            throw new MethodNotImplementedException($methodGet);
        }
    }

    /**
     * @param $directory String le repertoire du fichier
     * @param $objet l'objet qui contient l'image à supprimer
     * @param $variable String la variable qui contient le nom du fichier
     * @return mixed retour de la fonction $Filesystem->remove()
     */
    public static function removeFile($directory, $objet, $variable) {
        $filesystem = new Filesystem();

        $methodGet = 'get'.ucfirst($variable);
        dump($methodGet);
        dump($objet->$methodGet());
        if(method_exists($objet, $methodGet) && $objet->$methodGet() != "" && $objet->$methodGet() != NULL) {
            return $filesystem->remove(array($directory.$objet->$methodGet()));
        } else {
            throw new MethodNotImplementedException($methodGet);
        }

    }

}