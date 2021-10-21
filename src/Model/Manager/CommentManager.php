<?php

namespace Blog\Model\Manager;


use Blog\Model\Comment;
use Blog\Service\Hydratation;
use PDO;

class CommentManager extends AbstractManager
{
    public function getCommentsBy($post, $status)
    {
        $sql = 'SELECT comment.id, comment.content, user.lastname, user.firstname, comment.date FROM comment 
                INNER JOIN user ON user.id = comment.author
                WHERE comment.post = :post
                AND comment.status = :status';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('post', $post, PDO::PARAM_INT);
        $statement->bindParam('status', $status, PDO::PARAM_INT);
        $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

        $vars = [];
        foreach ($comments as $comment) {
            $vars[] = Hydratation::hydrate($this->getTable(), $comment);
        }

        return $vars;
    }

    public function getComments($status)
    {
        $sql = 'SELECT * FROM comment WHERE status = :status';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('status', $status);
        $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
        $vars = [];
        foreach ($comments as $comment) {
            $vars[] = Hydratation::hydrate($this->getTable(), $comment);
        }

        return $vars;
    }


    public function getCommentById($id)
    {
        $sql = 'SELECT * FROM comment WHERE id = :id';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('id', $id);
        $statement->execute();
        $comment = $statement->fetch(PDO::FETCH_ASSOC);
        if ($comment) {
           return Hydratation::hydrate($this->getTable(), $comment);
        }
        return null;
    }

    public function activate(Comment $comment)
    {
        $table = $this->getTable();
        $status = COMMENT_VALIDATE;
        $sql = 'UPDATE ' . $table . ' SET status = :status WHERE id = :id';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('status', $status);
        $statement->bindParam('id', $comment->getId());
        $statement->execute();
    }


    public function insert($data)
    {

        $sql = "INSERT INTO comment (content, post, author, status) VALUES (:content, :post, :author, :status)";
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('status', $data['status'], PDO::PARAM_INT);
        $statement->bindParam('author', $data['author'], PDO::PARAM_INT);
        $statement->bindParam('post', $data['post'], PDO::PARAM_INT);
        $statement->bindParam('content', $data['content']);

        $statement->execute();

    }
}