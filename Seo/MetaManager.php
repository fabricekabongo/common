<?php

namespace FabriceKabongo\Common\Seo;

use Doctrine\DBAL\Connection;

/**
 * @author fabrice kabongo <fabrice.k.kabongo@gmail.com>
 */
class MetaManager {

    protected $data;
    protected static $conn;
    protected static $tablename;

    protected function __construct() {
        $this->data = array();
    }

    public function __set($name, $value) {
        if (is_string($value)) {
            $this->data[$name] = $value;
        } else {
            throw new \InvalidArgumentException();
        }
    }

    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            throw new \LogicException();
        }
    }

    public function loadMeta(Connection $conn, $tablename) {
        self::$conn = $conn;
        self::$tablename = $tablename;

        $metamanager = new MetaManager();
        $data = self::$conn->fetchAll('select * from ' . self::$tablename . ';');
        $donneeTraitee = array();
        foreach ($data as $meta) {
            $donneeTraitee[$meta['name']] = $meta['value'];
        }
        $metamanager->setTitle($donneeTraitee['title']);
        $metamanager->setDescription($donneeTraitee['description']);
        $metamanager->setContentType($donneeTraitee['contentType']);
        $metamanager->setRobots($donneeTraitee['robots']);
        $metamanager->setOgTitle($donneeTraitee['ogTitle']);
        $metamanager->setOgUrl($donneeTraitee['ogUrl']);
        $metamanager->setOgSiteName($donneeTraitee['ogSiteName']);
        $metamanager->setOgDescription($donneeTraitee['ogDescription']);
        return $metamanager;
    }

    public function updateMeta(MetaManager $meta) {
        foreach ($this->data as $key => $value) {
            try {
                self::$conn->update(self::$tablename, array('value' => $value), array('name' => $key));
            } catch (\Doctrine\DBAL\DBALException $ex) {
                self::$conn->insert(self::$tablename, array('value' => $value, 'name' => $key));
            }
        }
    }

}

?>
