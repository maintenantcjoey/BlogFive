<?php

$router = new AltoRouter();

// map homepage
$router->map('GET', '/', 'FrontController#home');

// security
$router->map('GET|POST', '/inscription', 'SecurityController#create');
$router->map('GET|POST', '/connexion', 'SecurityController#login');
$router->map( 'GET', '/post/[i:id]', 'ArticleController#article');
$router->map('GET|POST', '/create', 'ArticleController#create');


//account
$router->map('GET', '/mon-compte', 'AccountController#account');

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
