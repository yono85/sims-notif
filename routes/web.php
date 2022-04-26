<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->group(['prefix' => 'api',  'middleware' => 'cekrequest'],function($router){
    // $router->post('/login', 'access\manage@login');
});


//
$router->group(['prefix'=>'api', 'middleware'=>['cekrequest','auth']],function($router)
{
    // $router->get('/profile', 'access\manage@profile');
    // $router->post('/logout', 'access\manage@logout');
});

$router->group(['prefix'=>'api/notifications', 'middleware'=>['cekrequest','cekKeyAccount']],function($router)
{
    $router->get('/', 'notifications\index@main');
    // $router->get('/notification/admin', 'notifications\admin@main');
    // $router->get('/notification/user', 'notifications\user@main');

    // $router->post('/notification/open/admin', 'notifications\admin@open');
    // $router->post('/notification/open/user', 'notifications\user@open');

    // $router->post('/notification/read/admin', 'notifications\admin@read');
    // $router->post('/notification/read/user', 'notifications\user@read');
});


$router->group(['prefix'=>'api/home', 'middleware'=>['cekrequest','cekKeyAccount']],function($router)
{
    // $router->get('/notifications', 'notifications\home@main');
    // $router->get('/notifications/list', 'notifications\home@list');
    // $router->get('/notifications/list-all', 'notifications\home@listAll');
});


