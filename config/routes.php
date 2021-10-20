<?php

$router = new AltoRouter();

// map homepage
$router->map('GET', '/', 'FrontController#home');

// security
$router->map('GET|POST', '/inscription', 'SecurityController#create');
$router->map('GET|POST', '/connexion', 'SecurityController#login');
$router->map('GET', '/deconnexion', 'SecurityController#logout');

$router->map( 'GET', '/post/[i:id]', 'ArticleController#article');
$router->map( 'GET|POST', '/post/[i:id]/edit', 'ArticleController#edit');
$router->map( 'GET|POST', '/post/[i:id]/delete', 'ArticleController#delete');

$router->map('GET|POST', '/posts', 'ArticleController#create');

$router->map('POST', '/comments/[i:id]/create', 'CommentController#create');

//admin
$router->map('GET', '/admin', 'AdminController#home');
$router->map('GET', '/admin/posts/activate/[i:id]', 'AdminController#activatePost');



//account
$router->map('GET|POST', '/mon-compte', 'AccountController#account');

//post


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
