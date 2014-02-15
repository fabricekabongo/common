<?php

namespace FabriceKabongo\Common\Entity;
/**
 * Une implémentation d'une entité
 * 
 * @copyright (c) 2014, Fabrice Kabongo
 * @version 1.0.0.0
 * @author Fabrice Kabongo <fabrice.k.kabongo at gmail.com>
 */
abstract class Entity implements IEntity {
    
    /**
     * l'identifiant de l'entité
     * 
     * @var int
     */
    private $id;
    
    
    public function getId() {
        return $this->id;
    }

    public function hydrater( $donnee) {
        if(!is_array($donnee) || array_key_exists('id', $donnee)){
            throw new Exception ("la fonction hydrater doit recevoir un tableau en paramettre", 500);
        }
        $this->id = int_val($donnee['id']);
    }

    public function deshydrater() {
        $donnee = array();
        $donnee['id'] =int_val($this->id);
        
        return $donnee;
    }    
    
    public static function getEntityName(){
        
    }

    public static function loadValidatorMetadata(\Symfony\Component\Validator\Mapping\ClassMetadata $metadata){
        
    }
}

?>
