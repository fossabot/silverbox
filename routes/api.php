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

$router->get('{client}/{fileName}', 'ViewController@view');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->post('{client}', 'UploadController@upload');
    $router->delete('{client}/{fileName}', 'DeleteController@delete');
    $router->options('{client}/{fileName}', 'ViewController@info');
});
