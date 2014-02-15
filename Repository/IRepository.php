<?php

namespace FabriceKabongo\Common\Repository;

use FabriceKabongo\Common\Entity\IEntity;
/**
 * L'interface d'un dépot
 * 
 * @copyright (c) 2014, Fabrice Kabongo
 * @version 1.0.0.0
 * @author Fabrice Kabongo <fabrice.k.kabongo at gmail.com>
 */
interface IRepository {
    
    public function save(IEntity $entity);
    
    public function delete(IEntity $entity);
    
    public function update(IEntity $entity);
    
    public function findOneById($id);
    
    public function findAll();
    
    public function count();
}

?>
