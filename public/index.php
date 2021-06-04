<?php

require '../vendor/autoload.php'; 

$router = new AltoRouter();

// map homepage
$router->map( 'GET', '/BlogFive/', function() {
    var_dump("yo");
    die;
    require __DIR__ . '../view/home.php';
});

$match = $router->match();


