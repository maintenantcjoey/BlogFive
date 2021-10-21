<?php

namespace Blog\Model\Manager;


use Blog\Service\Hydratation;
use PDO;

class UserManager extends AbstractManager
{

    public function encode($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verify($password, $encoded)
    {
        return password_verify($password, $encoded);
    }

    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM user WHERE email = :email';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return Hydratation::hydrate($this->getTable(), $user);
        }
        return null;
    }

    public function getUserById($id)
    {
        $sql = 'SELECT * FROM user WHERE id = :id';
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('id', $id);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return Hydratation::hydrate($this->getTable(), $user);
        }
        return null;
    }


    public function insert($data)
    {

        $sql = "INSERT INTO user (lastname, firstname, password, email, role) VALUES (:lastname, :firstname, :password, :email, :role)";
        $statement = $this->bdd->prepare($sql);
        $statement->bindParam('lastname', $data['lastname']);
        $statement->bindParam('firstname', $data['firstname']);
        $statement->bindParam('password', $data['password']);
        $statement->bindParam('email', $data['email']);
        $statement->bindParam('role', $data['role'], PDO::PARAM_INT);

        $statement->execute();

    }
}