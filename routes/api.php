<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('Admin')->group(function(){
    Route::namespace('Admin')->prefix('goodcatch')->group(function(){
        Route::prefix(module_route_prefix())->group(function(){
            Route::prefix('base')->name('base.')->group(function(){
                Route::group(['middleware'=>'jwt.admin'], function(){
                    Route::apiResources([
                        'modules'=>'ModuleController', // 系统模块化
                    ]);
                });
            });
        });
    });

    /**
     *
     * 商家后台 路由
     *
     */
    Route::prefix('Seller')->namespace('Seller')->group(function(){
        Route::group(['middleware'=>'jwt.user'],function(){

        });
    });

    /**
     *
     * PC端 路由
     *
     */
    Route::namespace('Home')->group(function(){

        Route::group(['middleware'=>'jwt.user'],function(){

        });
    });

    /**
     *
     * App端 路由
     *
     */
    Route::prefix('App')->namespace('App')->group(function(){

        Route::group(['middleware'=>'jwt.user'],function(){

        });
    });
});


