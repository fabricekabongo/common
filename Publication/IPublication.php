<?php
namespace FabriceKabongo\Common\Publication;


use \DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Cette interface represente toute les entités pouvant être publié, daté
 * 
 * @copyright (c) 2014, Fabrice Kabongo
 * @version 1.0.0.0
 * @author Fabrice Kabongo <fabrice.k.kabongo at gmail.com>
 */
interface IPublication {

    /**
     * Renvoi la date à laquelle a été publié la publication
     * 
     * @return \DateTime la date de création
     */
    public function getCreatedAt();
    
    /**
     * Modifie la date de création
     * 
     * @param \DateTime $createAt la date de creation
     */
    public function setCreatedAt(DateTime $createAt);
    
    /**
     * Renvoi le contenu de la publication
     * 
     * @return string le contenu
     */
    public function getContent();
    
    /**
     * Modifie le contenu de la publication
     * 
     * @param string $content le contenu de la publication
     */
    public function setContent($content);
    
    /**
     * Renvoi l'auteur de la publication
     * 
     * @return UserInterface l'auteur
     */
    public function getAuthor();
    
    /**
     * Modifie l'auteur de la publication
     * 
     * @param \Symfony\Component\Security\Core\User\UserInterface $user l'auteur
     */
    public function setAuthor(UserInterface $user);
    
}

?>
