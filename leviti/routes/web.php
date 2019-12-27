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
     * Rotas para Usuários
     */
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', ['uses' => '\Src\Users\Controllers\UsersController@users', 'name' => 'user.index']);
        $router->post('/', ['uses' => '\Src\Users\Controllers\UsersController@store', 'name' => 'user.store']);
    });

    /**
     * Rotas para ministérios
     */
    $router->group(['prefix' => 'ministries'], function () use ($router) {
        $router->get('/', ['uses' => '\Src\Ministries\Controllers\MinistriesController@index', 'name' => 'user.index']);
        $router->post('/', ['uses' => '\Src\Ministries\Controllers\MinistriesController@store', 'name' => 'user.store']);
    });

    /**
     * Rotas para células
     */
    $router->group(['prefix' => 'cells'], function () use ($router) {
        $router->get('/', ['uses' => '\Src\Cells\Controllers\CellsController@index', 'name' => 'user.index']);
        $router->post('/', ['uses' => '\Src\Cells\Controllers\CellsController@store', 'name' => 'user.store']);
        $router->get('/{idCell}',['uses' => '\Src\Cells\Controllers\CellsController@show', 'name' => 'user.show']);
        $router->post('/{idCell}',['uses' => '\Src\Cells\Controllers\CellsController@update', 'name' => 'user.update']);
        $router->delete('/{idCell}',['uses' => '\Src\Cells\Controllers\CellsController@delete', 'name' => 'user.delete']);
    });

});