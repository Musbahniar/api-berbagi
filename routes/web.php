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
    // return $router->app->version();
		return ('Building API with Lumen invesy.id');
});

$router->group(['middleware' => 'auth'], function () use ($router) {
	$router->get('/siswa', 'SiswaController@index');
});

$router->get('/siswa/{idbiodata}', 'SiswaController@showById');
$router->get('/siswacomplete/{idbiodata}', 'SiswaController@showByIdCompleted');
$router->delete('/siswa/{idbiodata}', 'SiswaController@destroy');
$router->put('/siswa/{idbiodata}', 'SiswaController@update');
$router->post('/siswa', 'SiswaController@store');

$router->get('/sekolah', 'sekolahController@index');
$router->get('/sekolah/{idsekolah}', 'sekolahController@showById');
$router->delete('/sekolah/{idsekolah}', 'sekolahController@destroy');
$router->put('/sekolah/{idsekolah}', 'sekolahController@update');
$router->post('/sekolah', 'sekolahController@store');

