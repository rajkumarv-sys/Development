<?php
  use Illuminate\Support\Facades\Route;
  use Illuminate\Support\Facades\Artisan;
  use Illuminate\Support\Facades\Request;
  // use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;


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
  // Route::post('login',function(){
    
  // echo 'tets';die;
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
    Route::post('getpolygonstatus', 'Api\PassportController@getpolygonstatus');
    Route::post('save-outlets', 'Api\PassportController@saveOutlets');
    
      Route::post('getsubrd_details', 'Api\PassportController@getsubrd_details');
      Route::post('combine_subrd_pepsi', 'Api\SubRDBeatController@combine_subrd_pepsi');


      //village with no RLa
      Route::post('village_no_rla','Api\PassportController@village_no_rla');
      Route::post('khoj_village_no_rla','Api\PassportController@khoj_village_no_rla');



      Route::post('get_subrdbeats','Api\SubRDBeatController@getSubRDBeats');
      Route::post('get_hugli_sstbeats','Api\SubRDBeatController@get_hugli_sstbeats');


      //Outlet -- global

      Route::post('getCityData','Api\FilterController@Cityfilter');
      Route::post('getNbhrdData','Api\FilterController@nbhrdfilter');
      Route::post('uncoveredData','Api\FilterController@uncovered_outlets');
      Route::post('outletaction','Api\FilterController@outlet_action');
      Route::post('locklocationaction','Api\FilterController@user_lock_action');
      Route::post('addoutlet_imageFile','Api\FilterController@addoutlet_image');
      Route::post('getfilterparam','Api\FilterController@getfilter_param');  
      Route::post('pepsi_getuncovereddata','Api\FilterController@pepsi_getuncovereddata');  

      Route::post('/pepsi_rural', 'Api\FilterController@pepsi_getsubrd_new');
        
        
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
      Route::post('gettsi_response','Api\TsiController@getTsi');
      //SST
      Route::post('getsst_beats','Api\SSTController@getsstbeat');
      Route::post('get_statesst','Api\SSTController@getstatesst');
      //OOH
      Route::post('get_oohdata','Api\OutletController@ooh_outlets');
      Route::post('get_delhi_data','Api\OutletController@hri_delhi_outlets');
      Route::post('update_hri_outlet','Api\OutletController@hri_action_outlets');
      Route::post('hri_uncovered_outlets','Api\OutletController@hri_uncovered_outlets');
      Route::post('addoutlet_image','Api\OutletController@addoutlet_image');

      Route::post('hri_fmcg_action_outlets','Api\OutletController@hri_fmcg_action_outlets');
      // Route::post('hri_fmcg_foundaction_outlets','Api\OutletController@hri_fmcg_foundaction_outlets');

      //  Route::post('hri_foundaction_outlets','Api\OutletController@hri_foundaction_outlets');


      Route::post('getfilter_hriparam','Api\OutletController@getfilter_hriparam');   


    
});

// Route::post('get-details', 'Api\PassportController@getDetails')->middleware('auth:api');
/* Web service Routes end here */
