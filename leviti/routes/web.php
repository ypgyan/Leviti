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

$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function () use ($router) {
    $router->get('logs', ['uses' => 'LogViewerController@index', 'name' => 'logs']);
});

$router->group(['prefix' => 'register', 'middleware' => ['watchman']], function () use ($router) {
    $router->get('/', ['uses' => '\Src\Gatekeeper\Controllers\SignupController@index', 'name' => 'signup.index']);
    $router->post('/signup', ['uses' => '\Src\Gatekeeper\Controllers\SignupController@signup', 'name' => 'signup.register']);
});

$router->group(['prefix' => 'api', 'middleware' => ['auth']], function () use ($router) {
    $router->get('/', ['uses' => '\Src\Gatekeeper\Controllers\IndexController@index', 'name' => 'api.index']);

    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', ['uses' => '\Src\Users\Controllers\UsersController@index', 'name' => 'users.index']);
        $router->get('/get', ['uses' => '\Src\Users\Controllers\UsersController@users', 'name' => 'users.get']);
        $router->post('/store', ['uses' => '\Src\Users\Controllers\UsersController@store', 'name' => 'users.store']);
    });
});