<?php
//je dois mettre cela? 
namespace Blog\Model;
require_once("Model/Model.php");

class PostManager extends Manager
{
    // ...
}

class ArticleManager extends Model
{
    //récup ts les aticles ds la BDD
    public function getArticles(){
        return $this->getAll('article', 'Article');
    }
}









?>