<?php

namespace Blog\Model\Manager;


use Blog\Model\Article;
use Blog\Service\Hydratation;
use PDO;

class ArticleManager extends AbstractManager
{
    //récup ts les aticles ds la BDD
    public function getArticles()
    {
        return $this->getPosts(ARTICLE_VALIDATE);
    }


    public function activate(Article $article)
    {
        $table = $this->getTable();
        $status = ARTICLE_VALIDATE;
        $sql = 'UPDATE ' . $table . ' SET status = :status WHERE id = :id';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('status', $status);
        $statement->bindParam('id', $article->getId());
        $statement->execute();
    }

    public function getPostsByUserId($userId)
    {
        $sql = 'SELECT * FROM article WHERE author = :author';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('author', $userId);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        $vars = [];
        foreach ($posts as $post) {
            $vars[] = Hydratation::hydrate($this->getTable(), $post);
        }

        return $vars;
    }

    public function getPostById($id)
    {
        $sql = 'SELECT * FROM article WHERE id = :id';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('id', $id);
        $statement->execute();
        $post = $statement->fetch(PDO::FETCH_ASSOC);
        return Hydratation::hydrate($this->getTable(), $post);
    }

    public function getPosts($status)
    {
        $sql = 'SELECT * FROM article WHERE status = :status';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('status', $status);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        $vars = [];
        foreach ($posts as $post) {
            $vars[] = Hydratation::hydrate($this->getTable(), $post);
        }

        return $vars;
    }


    public function insert($data)
    {

        $sql = "INSERT INTO article (title, chapo, content, author, image, date, status) VALUES (:title, :chapo, :content, :author, :image, :date, :status)";
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('chapo', $data['chapo']);
        $statement->bindParam('content', $data['content']);
        $statement->bindParam('author', $data['author'], PDO::PARAM_INT);
        $statement->bindParam('image', $data['image']);
        $statement->bindParam('date', $data['date']);
        $statement->bindParam('status', $data['status'], PDO::PARAM_INT);

        $statement->execute();

    }

    public function update($data, $id)
    {

        $sql = "UPDATE article SET title = :title, chapo = :chapo, content = :content, image = :image WHERE id = :id";

        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('chapo', $data['chapo']);
        $statement->bindParam('content', $data['content']);
        $statement->bindParam('image', $data['image']);
        $statement->bindParam('id', $id);
        $statement->execute();

    }
}