<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function(){
    return str_random(32);
});


$router->group(['prefix' => '/api/v1/usuario/', 'middleware' => ['cors', 'jwt.auth']], function() use ($router) {

    require (__DIR__ . '/user/userData.php');
});





