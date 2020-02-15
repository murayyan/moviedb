<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    $res['success'] = true;
    $res['result'] = "Hello there welcome to web api using lumen tutorial!";
    return response($res);
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/users', 'UserController@index');
    $router->post('/register', 'UserController@store');
    $router->get('/user', 'UserController@edit');
    $router->put('/user/{id}', 'UserController@update');
    $router->delete('/user/{id}', 'UserController@destroy');
    $router->get('/movie', 'MovieController@index');
    $router->get('/movie/{id}', 'MovieController@show');
});



$router->post('/login', 'LoginController@index');

// $router->get('/key', function () {
//     return str_random(32);
// });
