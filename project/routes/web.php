<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


/*Route::get('/test',			['as' => 'app.test'			, 'uses' => 'TestController@index']);
Route::get('/testXml',		['as' => 'app.testXml'		, 'uses' => 'TestController@testXml']);
Route::get('/testSuccess',	['as' => 'app.test.success'	, 'uses' => 'TestController@success']);
Route::get('/readTestXml',	['as' => 'app.readTestXml'	, 'uses' => 'TestController@readTestXml']);

Route::get('/testAdd',		['as' => 'app.test.getAdd'	, 'uses' => 'TestController@getAdd']);
Route::post('/testAdd',		['as' => 'app.test.postAdd'	, 'uses' => 'TestController@postAdd']);
Route::get('/userteam/manyuser', ['as' => 'app.test.manyuser', 'uses' => 'TestController@manyUser']);
Route::get('/userteam/manyteam', ['as' => 'app.test.manyteam', 'uses' => 'TestController@manyTeam']);*/


Route::get('/',['as' =>'admin.e-kedou.home','uses' => 'HomeController@index']);

Route::any('/oauth'				,['as' => 'e-kedou.oauth'						, 'uses' => 'AuthController@oauth']);
Route::get('/login'				,['as' => 'e-kedou.login'						, 'uses' => 'AuthController@login']);
Route::get('/loginPartime',[
   'uses' => 'AuthController@buildLoginPartimeForm',
   'as' => 'login.partime'
]);
Route::get('skype-phone', ['as' => 'skype.phone', 'uses' => 'SkypePhoneController@index']);
Route::post('/login',
    [
        'as' => 'auth.login',
        'uses' => 'AuthController@loginPartime'
    ]);
Route::any('/logout'			,['as' => 'e-kedou.logout'						, 'uses' => 'AuthController@logout']);
Route::any('/goto/{siteid}'		,['as' => 'e-kedou.gosite'					, 'uses' => 'SwitchController@gosite']);
Route::any('/log/view'				,['as' => 'e-kedou.logview'					, 'uses' => 'AccessLogController@view']);
Route::any('{all?}', function () {
    return view('errors/404');
})
->where('all','(.*)')
->name('admin.e-kedou.404');
