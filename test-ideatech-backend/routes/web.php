<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->group(['prefix' => 'author'], function () use ($router) {
        $router->get('/list', '\App\Http\Controllers\AuthorController@index');
        $router->get('/search/{query}', '\App\Http\Controllers\AuthorController@search');
        $router->get('/{id}/books', '\App\Http\Controllers\AuthorController@booksFromAuthor');
        $router->post('/create', '\App\Http\Controllers\AuthorController@create');
        $router->patch('/update/{id}', '\App\Http\Controllers\AuthorController@update');
        $router->delete('/delete/{id}', '\App\Http\Controllers\AuthorController@delete');
    });

    $router->group(['prefix' => 'book'], function () use ($router) {
        $router->get('/list', '\App\Http\Controllers\BookController@index');
        $router->get('/search/{query}', '\App\Http\Controllers\BookController@search');
        $router->post('/create', '\App\Http\Controllers\BookController@create');
        $router->patch('/update/{id}', '\App\Http\Controllers\BookController@update');
        $router->delete('/delete/{id}', '\App\Http\Controllers\BookController@delete');
    });
});
