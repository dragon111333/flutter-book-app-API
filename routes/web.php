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

$router->group(['prefix' => 'api'], function () use ($router) {
    //จะไปท ำงำนในคลำส ProductsController ที่ฟังกช์ นั readAll ท ำงำนด้วยเมธอด get
    $router->get('facultys', ['uses' => 'FacultysController@readAll']);
    //จะไปท ำงำนในคลำส ProductsController ที่ฟังกช์ นั showOne ท ำงำนด้วยเมธอด get
    $router->get('facultys/{id}', ['uses' => 'FacultysController@readOne']);
    //จะไปท ำงำนในคลำส ProductsController ที่ฟังกช์ นั create ท ำงำนด้วยเมธอด post
    $router->post('facultys', ['uses' => 'FacultysController@create']);
    //จะไปท ำงำนในคลำส ProductsController ที่ฟังกช์ นั update ท ำงำนด้วยเมธอด put
    $router->put('facultys/{id}', ['uses' => 'FacultysController@update']);
    //จะไปท ำงำนในคลำส ProductsController ที่ฟังกช์ นั delete ท ำงำนด้วยเมธอด delete
    $router->delete('facultys/{id}', ['uses' => 'FacultysController@delete']);

    //แสดงข้อมูลทั้งหมด พร้อม url รูปภาพ
    $router->get('facultys_image', ['uses' => 'FacultysController@showAllWithImage']);
    //แสดงข้อมูลตาม id พร้อม url รูปภาพ
    $router->get('facultys_image/{id}', ['uses' => 'FacultysController@showOneWithImage']);

     //ข้อมูลusers
    //แสดงข้อมูลusersทั้งหมด
    $router->get('users', ['uses' => 'UsersController@readAll']);
    //เพิ่มข้อมูลusers
    $router->post('users', ['uses' => 'UsersController@create']);
    //แสดงข้อมูลตามรหัส
    $router->get('users/{id}', ['uses' => 'UsersController@readOne']);
    //login
    $router->post('userslogin', ['uses' => 'UsersController@login']);
     //Update
     $router->put('users/{id}', ['uses' => 'UsersController@update']);
        //ข้อมูลสมาชิก
        $router->post('memberLogin', ['uses' => 'MembersController@login']);

        //แสดงข้อมูลตามรหัส
     $router->get('members', ['uses' => 'MembersController@readAll']);
        //แสดงข้อมูลตามรหัส
    $router->get('members/{id}', ['uses' => 'MembersController@readOne']);
        //เพิ่มข้อมูล
    $router->post('members', ['uses' => 'MembersController@create']);
        //แก้ไขข้อมูล
    $router->put('members/{id}', ['uses' => 'MembersController@update']);
        //ลบข้อมูล
    $router->delete('members/{id}', ['uses' => 'MembersController@delete']);
        //แสดงข้อมูลทั้งหมด พร้อม url รูปภาพ
        $router->get('members_image', ['uses' => 'MembersController@showAllWithImage']);
        //แสดงข้อมูลตาม id พร้อม url รูปภาพ
        $router->get('members_image/{id}', ['uses' => 'MembersController@showOneWithImage']);
   });