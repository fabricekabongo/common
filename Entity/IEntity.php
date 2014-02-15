<?php

namespace FabriceKabongo\Common\Entity;

/**
 * Cette interface a les caracteristiques d'une entite
 * 
 * @copyright (c) 2014, Fabrice Kabongo
 * @version 1.0.0.0
 * @author Fabrice Kabongo <fabrice.k.kabongo at gmail.com>
 */
interface IEntity {
    
    /**
     * Renvoi l'identifiant de l'entité
     * 
     * @return int L'identifiant
     */
    public function getId();
    
    /**
     * Permet d'hydrater avec les données en parametre
     * 
     * @param array $donnee les données à hydrater dans l'entité
     * @return FabriceKabongo\Common\IEntity l'entité
     */
    public function hydrater($donnee);
    
    /**
     * Renvoi un tableau contenant les donnees de l'objet
     * 
     * @return array
     */
    public function deshydrater();
    
    /**
     * Renvoi le nom de l'entité
     * 
     * @return string
     */
    public static function getEntityName();
    
    
    static public function loadValidatorMetadata(\Symfony\Component\Validator\Mapping\ClassMetadata $metadata);
}

?>
