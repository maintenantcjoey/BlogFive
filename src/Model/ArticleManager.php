<?php

namespace Blog\Model;

class ArticleManager extends Model
{
    //récup ts les aticles ds la BDD
    public function getArticles(){
        return $this->getAll('article', 'Article');
    }
}




?>