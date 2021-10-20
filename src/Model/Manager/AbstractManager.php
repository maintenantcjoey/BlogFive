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

    protected function getTable()
    {
        $explode = explode('\\', get_class($this));
        $class = array_pop($explode);

        return strtolower(substr($class, 0, stripos($class, 'Manager')));
    }

    public function insert($data)
    {

        $table = $this->getTable();

        $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', array_keys($data)) . ') VALUES (' . implode(', ', array_values($data)) . ')';

        $req = $this->bdd->prepare($sql);
       $res =  $req->execute();

    }


    public function update($data, $id)
    {

        $table = $this->getTable();

        $sql = 'UPDATE ' . $table . ' SET ';


        foreach ($data as $key => $value) {
            $sql .= $key . ' = ' . $this->quote($value) .', ';
        }
        $pos = strrpos($sql, ',');
        $sql = substr($sql, 0, $pos);

        $sql .= ' WHERE id = :id';

        $req = $this->bdd->prepare($sql);
        $req->execute([
            ':id' => $id
        ]);

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
            $where .= " $key = " . $value;
        }
        $select = 'SELECT * FROM ' . $table . ' WHERE' . $where . ($unique ? ' LIMIT 1' : '');

        $req = $this->bdd->prepare($select);
        $req->execute();

       if (!$unique) {
            $entity = $req->fetchAll(PDO::FETCH_ASSOC);
       } else {
            $entity = $req->fetch(PDO::FETCH_ASSOC);
       }

       if ($entity) {
            if ($unique) {
                return Hydratation::hydrate($table, $entity);
            } else {
                $data = [];
                foreach ($entity as $key => $value) {
                    $data[] = Hydratation::hydrate($table, $value);
                }
                return $data;
            }
        }

        return false;
    }

    public function quote($value)
    {
        return $this->bdd->quote($value);
    }


    public function delete($id) {
        $table = $this->getTable();

        $sql = 'DELETE FROM ' . $table . ' WHERE id = :id';
        $req = $this->bdd->prepare($sql);
        $req->execute([
            'id' => $id
        ]);
    }

}