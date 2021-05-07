<?php
use Illuminate\Http\Request;
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
$router->post('login',  ['uses' => 'AuthController@login']);
$router->post('register', ['uses' => 'AuthController@showOneAuthor']);

$router->group(['middleware' => 'auth','prefix'=>'api'], function () use ($router) {

    $router->post('logout', ['uses' => 'AuthController@logout']);

    $router->get('me', ['uses' => 'AuthController@me']);

});
