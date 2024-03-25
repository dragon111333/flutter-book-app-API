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
    return $router->app->version()."-----------TEST------------";
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('members', ['uses' => 'MembersController@readAll']);
    $router->post("memberLogin", ["uses"=>'MembersController@login']);
    $router->post("members", ["uses"=>'MembersController@create']);
    $router->delete("members/{id}", ["uses"=>'MembersController@delete']);


    // $router->get('users/{id}', ['uses' => 'UsersController@readOne']);
    // $router->post('userslogin', ['uses' => 'UsersController@login']);
    // $router->put('users/{id}', ['uses' => 'UsersController@update']);
   });
   
