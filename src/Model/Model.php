<?php

abstract class Model
{
    private $bdd;

    //connexion à la BDD
    //ts les enfants pourrons se connceter à la BDD
    private function __construct(){
        $this->bdd = new PDO('mysql:host=local;dbname=blog;charset=utf8', 'root', '')
        $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    //méthode qui récupe les éléments de la BDD
    //permet d'éviter les injections sql
    protected function getAll($table, $objet){
        $var = [];
        $req = $this->bdd->prepare('SELECT * FROM' .$table. 'ORDER BY id desc');
        $req->execute();
        while($data = $req->fetch(PDO::FETCH_ASSOC)){
        $var[] = new $objet($data);}
        return $var;
    }

}

?>