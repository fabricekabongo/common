<?php
namespace FabriceKabongo\Common\Upload;

use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Cette classe permet de gérer l'upload des fichiers
 *
 * @author fabrice kabongo fabrice.k.kabongo@gmail.com
 */

class Uploader 
{
    static private $imageMimeType = array('image/gif', 'image/jpeg', 'image/png');

    /**
     * Deplace un fichier uploader vers son dossier de destination en s'assurant que se fichier n'efface pas les fichiers precedents
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $fichier le fichier à uploader
     * @param string $destination le chemin qui mene vers le dossier de destination
     * 
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     * 
     * @return string le nom du fichier deplacer avec ou sans le chemin web
     */
    protected static function uploadFile(UploadedFile &$fichier,$destination)
    {
        $nouveaunom = self::genereNom($destination, $fichier->guessExtension());
        $fichier->move($destination, $nouveaunom);
        return $nouveaunom;
    }
    
    /**
     * Permet de generer un nom unique pour un fichier dans un dossier particulier
     * 
     * @param string $destination le chemin du dossier de destination ou le nom du fichier doit etre unique
     * @param string $extension l'extension du fichier
     * @return string le nom generer
     */
    protected static function genereNom($destination,$extension='')
    {
        $nom_unique = '';
        do
        {
            $strong = true;
            $prefix = openssl_random_pseudo_bytes(30, $strong);
            if(is_bool($prefix))
            {
                $prefix = uniqid();
            }
            else
            {
                $prefix = bin2hex($prefix);
            }
            $nom_unique = sha1(uniqid($prefix, true));

        }while(file_exists($destination.$nom_unique.$extension));
        return $nom_unique.".".$extension;
    }
     /**
     * Deplace un fichier uploader vers son dossier de destination en s'assurant que se fichier n'efface pas les fichiers precedents
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $fichier le fichier à uploader
     * @param string $destination le chemin qui mene vers le dossier de destination
     * @param string $webpath le chemin web du fichier qui sera retourner concatener avec le nom du fichier
     * 
     * @throws \Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException
     *
     * @return string le nom du fichier deplacer avec ou sans le chemin web
     */
    public static function uploadImage(UploadedFile &$fichier,$destination,$webpath='')
    {
        if(in_array($fichier->getMimeType(), self::$imageMimeType))
        {
            return $webpath.self::uploadFile($fichier, $destination);
        }
        else
        {
            $str = '';
            foreach(self::$imageMimeType as $image)
            {
                $str.=$image;
            }
            throw new UnexpectedTypeException($fichier->getMimeType(),$str);
        }
    }
    
}

?>
