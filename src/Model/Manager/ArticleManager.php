<?php

namespace Blog\Model\Manager;


class ArticleManager extends AbstractManager
{
    //récup ts les aticles ds la BDD
    public function getArticles(){
        return $this->getAll();
    }
}