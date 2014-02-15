<?php

namespace FabriceKabongo\Common\Repository;

use Doctrine\DBAL\Connection,
    FabriceKabongo\Common\Repository\IRepository,
    FabriceKabongo\Common\Entity\IEntity,
    Symfony\Component\EventDispatcher\EventDispatcher,
    Symfony\Component\EventDispatcher\GenericEvent;

/**
 * L'implementation standard de l'interface IRepository
 *
 * @author Fabrice Kabongo <fabrice.k.kabongo at gmail.com>
 */
class Repository implements IRepository {

    /**
     * la connection à la base de donnée
     * @var Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * la table sur laquelle s'applique ce repository
     * @var string
     */
    protected $table;

    /**
     * le event dispatcher du systeme
     * @var Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $eventDispatcher;
   
    /**
     * Le nom de l'entité: est surtout utilisé por les événements
     * 
     * @var string
     */
    protected $entityName;
    
    /**
     * Le constructeur
     * 
     * @param \Doctrine\DBAL\Connection $db
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     * @param string $table
     * @param string $entityName
     */
    public function __construct(Connection $db, EventDispatcher $eventDispatcher, $table, $entityName) {
        $this->db = $db;
        $this->table = $table;
        $this->eventDispatcher = $eventDispatcher;
        $this->entityName = $entityName;
    }

    public function count() {
        $statement = $this->db->executeQuery("SELECT count(*) as count FROM " . $this->table . ";");
        $result = $statement->fetch();
        return $result['count'];
    }

    public function delete(IEntity $entity) {
        $eventPre = new GenericEvent($entity);
        $this->eventDispatcher->dispatch("pre-delete-".$this->entityName,$eventPre );
        
        $return = $this->db->delete($this->table, array("id" => $eventPre->getSubject()->getId()));
        
        $eventPost = new GenericEvent($eventPre->getSubject());
        $this->eventDispatcher->dispatch("post-delete-".$this->entityName,new GenericEvent($eventPost));
        
        return $return;
    }

    public function findAll() {
        $result = $this->db->fetchAll("select * from " . $this->table . ";");
        
        $event = new GenericEvent($result);
        $this->eventDispatcher->dispatch("post-findall-".$this->entityName,$event);
        
        return $event->getSubject();
    }

    public function findOneById($id) {
        if(!is_int($id)){
            throw new \InvalidArgumentException("l\'id est sensé etre un integer. vous avez donné: ".$id,500);
        }
        $result = $this->db->fetchAssoc("select * from where id = :id;",array(':id'=>int_val($id)));
        
        if($result == null || empty($result)){
            return null;
        }
        $event = new GenericEvent($result);
        $event->setArgument("id", $id);
        $this->eventDispatcher->dispatch("post-findonebyid-".$this->entityName,$event);
        
        return $event->getSubject();
    }

    public function save(IEntity $entity) {
        $eventPre = new GenericEvent($entity);
        $this->eventDispatcher->dispatch("pre-save-".$this->entityName, $eventPre);
        
        $return = $this->db->insert($this->table, $eventPre->getSubject()->deshydrater());
        
        $eventPost = new GenericEvent($eventPre->getSubject());
        $eventPost->setArgument("nombreResultat", $return);
        $this->eventDispatcher->dispatch("post-save-".$this->entityName,new GenericEvent($eventPost));
        
        return $return;
    }

    public function update(IEntity $entity) {
        
        $eventPre = new GenericEvent($entity);
        $this->eventDispatcher->dispatch("pre-update-".$this->entityName, new GenericEvent($entity));
        
        $return = $this->db->update($this->table, $entity->deshydrater(), array('id'=>$entity->getId()));
        
        $eventPost = new GenericEvent($eventPre->getSubject());
        $eventPost->setArgument("nombreResultat", $return);
        $this->eventDispatcher->dispatch("post-update-".$this->entityName, new GenericEvent($entity));
        
        return $return;
    }

}

?>
