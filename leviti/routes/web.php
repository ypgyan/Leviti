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
    $router->post('/', ['uses' => '\Src\Gatekeeper\Controllers\SignupController@signup', 'name' => 'signup.register']);
});

$router->group(['prefix' => 'api', 'middleware' => ['auth']], function () use ($router) {
    $router->get('/', ['uses' => '\Src\Gatekeeper\Controllers\IndexController@index', 'name' => 'api.index']);
    /**
     * Rotas de Users
     */
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', ['uses' => '\Src\Users\Controllers\UsersController@users', 'name' => 'user.index']);
        $router->post('/', ['uses' => '\Src\Users\Controllers\UsersController@store', 'name' => 'user.store']);
    });

    /**
     * Rotas para ministérios
     */
    $router->group(['prefix' => 'ministrys'], function () use ($router) {
        $router->get('/', ['uses' => '\Src\Users\Controllers\MinistrysController@index', 'name' => 'user.index']);
        $router->post('/', ['uses' => '\Src\Users\Controllers\MinistrysController@store', 'name' => 'user.store']);
    });

});