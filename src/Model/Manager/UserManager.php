<?php

namespace Blog\Model\Manager;


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
}