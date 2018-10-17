<?php
use Illuminate\Support\Facades\Hash;
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
$router->options('{all:.*}', ['middleware' => 'cors', function() {  
      return response('');
    }]);

$router->get('/password', function () use ($router) {
    return Hash::make('12345678As');
});

$router->group(['prefix' => '/api/v1/', 'middleware' => ['cors']], function() use ($router) {
    require (__DIR__ . '/auth.php');
});

require (__DIR__ ."/users.php");
