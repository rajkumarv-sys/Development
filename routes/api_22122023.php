<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;

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
Route::post('register', 'Api\PassportController@register');
Route::post('login', 'Api\PassportController@login');
// Route::post('check',function(){
//     return 'Hi';
// });

// Route::middleware('auth:api')->get('checkuser', function(Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('get-details', 'Api\PassportController@getDetails');
    Route::post('menulist', 'Api\PassportController@menulist');
    Route::post('districtlist', 'Api\PassportController@districtlist');
    Route::post('statelist', 'Api\PassportController@statelist');
    Route::post('taluklist', 'Api\PassportController@taluklist');
    Route::post('getsubrd_response', 'Api\PassportController@getsubrd_response');
    Route::post('getsubrd_details', 'Api\PassportController@getsubrd_details');

    Route::post('get_subrdbeats','Api\SubRDBeatController@getSubRDBeats');

    
    //Highway
    Route::post('get_highway_info','Api\HighwayController@getHighway');
    Route::post('highway_list','Api\HighwayController@getHighwayList');

    //Covered / Uncovered outlets
    Route::post('getbeatdetails','Api\OutletController@getbeatdetails');
    Route::post('uncovered_outlets','Api\OutletController@uncovered_outlets');
    Route::post('Getfilterparam','Api\OutletController@getfilter_param');

   //Cavin uncovered/covered outlets
    Route::post('GetBeat','Api\Cavin_OutletController@getbeatdetails');
    Route::post('uncovered_data','Api\Cavin_OutletController@uncovered_outlets');
    //TSI section
    Route::post('gettsi_response','Api\TsiController@gettsi');

    
});

// Route::post('get-details', 'Api\PassportController@getDetails')->middleware('auth:api');
/* Web service Routes end here */
