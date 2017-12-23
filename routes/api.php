<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function () {
    Route::group(['middleware' => 'jwt.auth'], function () {
        //Route::get('products', 'Api\ProductsController@index');
        //Route::get('session', 'Api\PagSeguroController@getSessionId');
        //Route::post('order', 'Api\OrdersController@store');
    });
    Route::post('login', 'Api\AuthController@login');
});*/

Route::group(['middleware' => 'cors'], function () {
    Route::group(['middleware' => 'jwt.auth'], function () {
        //Route::get('products', 'Api\ProductsController@index');
        //Route::get('session', 'Api\PagSeguroController@getSessionId');
        //Route::post('order', 'Api\OrdersController@store');
        Route::get('user', function () {
            $user = JWTAuth::parseToken()->toUser();

            return response()->json(compact('user'));
        });
    });
    Route::post('login', 'Api\AuthController@login');

    //para atualizar o token
    Route::post('refresh_token', function(){
        try {
            $token = JWTAuth::parseToken()->refresh();
            return response()->json(compact('token'));
        }catch (JWTException $exception){
            return response()->json(['error' => 'token_invalid'],400);
        }
    });
});
