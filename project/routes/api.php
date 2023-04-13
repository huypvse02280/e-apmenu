<?php

use App\Model\User;
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/checkLastMessage'  , 'Api\StatisticController@checkLastMessage');
// e-kedou
Route::get('/timeline/list'		, 'Api\FilterController@timeLineList');
Route::get('/floor/list'		, 'Api\FilterController@floorList');
Route::get('/user/list'			, 'Api\FilterController@userList');
Route::get('/user/search'		, 'Api\FilterController@userSearch');
Route::get('/search'			, 'Api\FilterController@search');
/*Route::get('/company/list'		, 'Api\CompanyController@companyList');*/
Route::get('/location/history'	, 'Api\FilterController@locationHistory');
Route::get('/statistic'			, 'Api\StatisticController@getDataStatistic');
Route::get('/team/list'			, 'Api\FilterController@teamList');
Route::get('/user/approach'		, 'Api\FilterController@getApproach');

Route::get('/user/all', function() {
    $lstUser = User::where('del_flg', '=', '0')->get(['user_id', 'name', 'email','phone', 'skype_id']);
    return response()->json(['lstUser' => $lstUser]);
});



