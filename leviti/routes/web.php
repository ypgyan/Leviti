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

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function() use ($router) {
    $router->get('logs', 'LogViewerController@index');
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
        $router->get('/', ['uses' => '\Src\Users\Controllers\UsersController@index', 'name' => 'users.index']);
        $router->post('/', ['uses' => '\Src\Users\Controllers\UsersController@store', 'name' => 'users.store']);
        $router->get('/{idUser}', ['uses' => '\Src\Users\Controllers\UsersController@show', 'name' => 'users.show']);
        $router->patch('/{idUser}',['uses' => '\Src\Users\Controllers\UsersController@update', 'name' => 'users.update']);
        $router->delete('/{idUser}',['uses' => '\Src\Users\Controllers\UsersController@delete', 'name' => 'users.delete']);
    });

    /**
     * Rotas para ministérios
     */
    $router->group(['prefix' => 'ministries'], function () use ($router) {
        $router->get('/', ['uses' => '\Src\Ministries\Controllers\MinistriesController@index', 'name' => 'ministries.index']);
        $router->post('/', ['uses' => '\Src\Ministries\Controllers\MinistriesController@store', 'name' => 'ministries.store']);
        $router->get('/{idMinistry}', ['uses' => '\Src\Ministries\Controllers\MinistriesController@show', 'name' => 'ministries.show']);
        $router->patch('/{idMinistry}',['uses' => '\Src\Ministries\Controllers\MinistriesController@update', 'name' => 'ministries.update']);
        $router->delete('/{idMinistry}',['uses' => '\Src\Ministries\Controllers\MinistriesController@delete', 'name' => 'ministries.delete']);
    });

    /**
     * Rotas para células
     */
    $router->group(['prefix' => 'cells'], function () use ($router) {
        $router->get('/', ['uses' => '\Src\Cells\Controllers\CellsController@index', 'name' => 'cells.index']);
        $router->post('/', ['uses' => '\Src\Cells\Controllers\CellsController@store', 'name' => 'cells.store']);
        $router->get('/{idCell}',['uses' => '\Src\Cells\Controllers\CellsController@show', 'name' => 'cells.show']);
        $router->patch('/{idCell}',['uses' => '\Src\Cells\Controllers\CellsController@update', 'name' => 'cells.update']);
        $router->delete('/{idCell}',['uses' => '\Src\Cells\Controllers\CellsController@delete', 'name' => 'cells.delete']);
        $router->post('/{idCell}/members', ['uses' => '\Src\Cells\Controllers\CellsController@storeMembers', 'name' => 'cells.members.store']);
        $router->get('/{idCell}/members', ['uses' => '\Src\Cells\Controllers\CellsController@showMembers', 'name' => 'cells.members.show']);
    });
});
