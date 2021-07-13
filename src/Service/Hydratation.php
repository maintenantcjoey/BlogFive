<?php
/**
 * File Hydratation.php.
 */

namespace Blog\Service;


class Hydratation
{

    public static function hydrate($class, $data)
    {
        $class = 'Blog\\Model\\' . ucfirst($class);
        $entity = new $class;

        foreach ($data as $key => $value) {
            $method = str_replace('_', '', $key);
            $entity->{'set' . ucfirst($method)}($value);
        }

        return $entity;
    }
}