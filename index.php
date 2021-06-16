<?php

require 'vendor/autoload.php'; 

$router = new AltoRouter();

// map homepage
$router->map( 'GET', '/', 'FrontController#home');

$match = $router->match();


if (stripos($match['target'], '#') !== false) {
    list($controller, $method) = explode('#', $match['target'], 2);

    $cname = "Blog\Controller\\" . $controller;
    $controllerName = new $cname;

    if ($match['params']) {
        call_user_func_array(array($controllerName, $method), array($match['params']));
    } else {
        call_user_func(array($controllerName, $method));
    }
} else {
    header('Location: /');
}
