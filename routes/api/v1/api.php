<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('list', 'api\v1\user\UserController@getList');

Route::prefix('/auth')->group( function() {
    Route::post('login', 'api\v1\loginController@setLogin');

});

Route::prefix('/user')->group( function() {
  // Rutas protegidas
  Route::group([
    'middleware' => 'auth:api'
  ], function() {
      Route::get('logout', 'api\v1\loginController@getLogoutAll');
      Route::get('list', 'api\v1\user\UserController@getList');
      Route::post('register', 'api\v1\user\UserController@setRegister');
     
  });
});

