<?php

namespace Blog\Model\Manager;

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


    protected function getTable()
    {
        $explode = explode('\\', get_class($this));
        $class = array_pop($explode);

        return strtolower(substr($class, 0, stripos($class, 'Manager')));
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