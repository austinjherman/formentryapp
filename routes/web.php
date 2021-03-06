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
    return $router->app->version();
});

$router->post('auth/login', [
    'uses' => 'AuthController@login'
]);
$router->post('auth/validate-token', [
    'uses' => 'AuthController@validateToken'
]);

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    $router->post('/form-entry', [
        'uses' => 'FormEntryController@create'
    ]);

    $router->get('/form-entry/{id}', [
        'uses' => 'FormEntryController@read'
    ]);

});

$router->group(['prefix' => 'api/v1', 'middleware' => 'jwt.auth'], function () use ($router) {

    $router->get('/user', [
        'uses' => 'UserController@read'
    ]);

    $router->get('/form-entries', [
        'uses' => 'FormEntryController@index'
    ]);

    $router->get('/form-entries/filters', [
        'uses' => 'FormEntryController@filters'
    ]);

    $router->get('/filters', [
        'uses' => 'FilterController@index'
    ]);

    $router->post('/filters', [
        'uses' => 'FilterController@create'
    ]);

    $router->put('/filters/{id}', [
        'uses' => 'FilterController@update'
    ]);

    $router->delete('/filters/{id}', [
        'uses' => 'FilterController@delete'
    ]);

    $router->get('/filter-groups', [
        'uses' => 'FilterGroupController@index'
    ]);

    $router->get('/filter-groups/{id}', [
        'uses' => 'FilterGroupController@read'
    ]);

});