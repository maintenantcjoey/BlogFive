<?php

abstract class Model
{
    private static$bdd;

    //connexion à la BDD
    //ts les enfants pourrons se connceter à la BDD
    private static function setBdd(){
        self::$bdd = new PDO('mysql:host=local;dbname=blog;charset=utf8', 'root', '')
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }


    //connexion "automatique" à la BDD
    protected function getBdd(){
        if(self::$bdd == null) {
            self::setBdd();
            return self::$bdd;
        }
    }

    //méthode qui récupe les éléments de la BDD
    //permet d'éviter les injections sql
    protected function getAll($table, $objet){
        $this->getBdd();
        $var = [];
        $req = self::$bdd->prepare('SELECT * FROM' .$table. 'ORDER BY id desc');
        $req->execute();
        while($data = $req->fetch(PDO::FETCH_ASSOC)){
        $var[] = new $objet($data);}
        return $var;
    }

}

?>