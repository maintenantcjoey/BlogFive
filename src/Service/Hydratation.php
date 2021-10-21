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
            if  (!$value) {
                continue;
            }
            $method = 'set' . ucfirst(str_replace('_', '', $key));
            if(method_exists($entity, $method)) {
                $entity->$method($value);
            }
        }


        return $entity;
    }
}