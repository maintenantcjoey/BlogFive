<?php

namespace Blog\Model\Manager;

use Blog\Model\User;
use Blog\Service\Hydratation;
use PDO;

abstract class AbstractManager
{
    protected $bdd;

    //connexion à la BDD
    //ts les enfants pourrons se connceter à la BDD
    public function __construct()
    {
        $this->bdd = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DBNAME . ';charset=utf8', USER, PASSWORD);
        $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    //méthode qui récupe les éléments de la BDD
    //permet d'éviter les injections sql
    protected function getAll()
    {
        $table = $this->getTable();

        $var = [];
        $req = $this->bdd->prepare('SELECT * FROM ' . $table . ' ORDER BY id desc');
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = Hydratation::hydrate($table, $data);
        }
        return $var;
    }

    private function getTable()
    {
        $explode = explode('\\', get_class($this));
        $class = array_pop($explode);

        return strtolower(substr($class, 0, stripos($class, 'Manager')));
    }

    public function insert($data)
    {
        $table = $this->getTable();

        $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', array_keys($data)) . ') VALUES (' . implode(', ', array_map([$this, 'quote'], array_values($data))) . ')';
        $req = $this->bdd->prepare($sql);
        $req->execute();

    }

    /**
     * @param $data
     * @param bool $unique
     *
     * @return bool|User
     */
    public function get($data, $unique = true)
    {

        $table = $this->getTable();
        $where = '';

        foreach ($data as $key => $value) {
            $where .= " $key = " . $this->quote($value);
        }
        $select = 'SELECT * FROM ' . $table . ' WHERE' . $where . ($unique ? ' LIMIT 1' : '');

        $req = $this->bdd->prepare($select);
        $req->execute();

        $entity = $req->fetch(PDO::FETCH_ASSOC);

        if ($entity) {
            return Hydratation::hydrate($table, $entity);
        }
        return false;
    }

    private function quote($value)
    {
        return $this->bdd->quote($value);
    }

}