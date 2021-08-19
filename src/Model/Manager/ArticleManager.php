<?php

namespace Blog\Model\Manager;


class ArticleManager extends AbstractManager
{
    //récup ts les aticles ds la BDD
    public function getArticles()
    {
        return $this->get(['status' => ARTICLE_VALIDATE], false);
    }

    //récup 1 article
    public function getArticle($id)
    {
        return $this->get($id);
    }

    public function activate($post)
    {
        $table = $this->getTable();

        $sql = 'UPDATE ' . $table . ' SET status = ' . ARTICLE_VALIDATE . ' WHERE id = ' . $post->getId();
        $req = $this->bdd->prepare($sql);
        $req->execute();
    }
}