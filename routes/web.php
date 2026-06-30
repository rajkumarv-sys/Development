<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TestController;

use Illuminate\Support\Facades\Http;

// Route::get('/', function () {
//     return view('dashboard');
// });

// Route::get('/map', function () {
//     return view('map');
// })->name('map');


Route::get('/check-table', 'TestController@checkTable');

Route::get('/map', 'DashboardController@generatemenu');
Route::get('/map', 'DashboardController@changejson');


Route::get('chart', 'ChartController@index');
Route::post('/chart/{id}/viewchart', 'ChartController@viewchart');

Route::get('grid', 'GridController@index');
Route::get('map', 'MapController@index');

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::get('/auth/login', function () {
    return view('pages.auth.login');
})->name('login');

/*Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/auth/login?expired=1');
});*/

Route::get ('/logout',function(){
    Auth::logout();
    return Redirect::to('/');
});


Route::group(['middleware' => ['auth']], function() {
   /**
   * Logout Route
   */
   Route::get('/dashboard', 'DashboardController@index');
   Route::post('/store-session-values', 'DashboardController@storeSession');
   Route::post('/update-bi-session', 'DashboardController@updateBiSession');
  // Route::get('/logout', 'DashboardController@perform')->name('logout.perform');
});
Route::get('/sso-login','SSOController@redirectToProvider');

Route::get('/oauth/callback', 'SSOController@handleCallback');


Route::middleware(['auth', 'force.logout'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    });
});

Route::post('/logincheck', function() {
    $email= explode("@",Request::get('email'));
    $email_domain='';
    if(isset($email[1]))
       $email_domain=$email[1];
    $emailaddress=strtolower(Request::get('email'));
//if($emailaddress=='t-brandidea@mdlz.com' || $emailaddress=='sivanova4@mdlz.com' || $emailaddress=='shivika.verma@mdlz.com')
    if($email_domain=='mdlz.com')
    {
        
         return Redirect::to('/sso-login');
        
    }
    else
    {
          $rules = array (
                'email' => 'required|max:255',
                'password' => 'required|max:25',
            );

            $v = Validator::make(Request::all(), $rules);


            if ($v->fails()) {
                Request::flash ("Unauthorized Acesss !!!!");
                return Redirect::to('/auth/login')->withErrors($v->messages());
            } else {
                $remember=Request::get('remember');
                $userdata = array (
                    'email' => Request::get('email'),
                    'password' => Request::get('password')
                );
                If (Auth::attempt($userdata,$remember)) {
                    $user = auth()->user();
                    DB::table("users_log_count")->insert([
                                "user_id" => $user->id,
                                "login_time" => date('Y-m-d h:m:s'),
                                "client_id" => $user->client_id,
                            ]); 
                      Auth::login($user,true);

                      
                        //from reCAPTCHA admin
                        /* $secret = "6Lfg-F0sAAAAAFBhMqN04oQGVJ-ULDJm1FwojEk6"; // from reCAPTCHA admin
                         $token  = $_POST['recaptcha_token'];

                        $response = file_get_contents(
                        "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token"
                        );

                           $result = json_decode($response, true);
                          //print_r($result);
                        //exit;
                         if ($result['success'] == 1 && $result['score'] >= 0.1) {
                                    return Redirect::to('/dashboard');
                          } else {
                                   return Redirect::to('/auth/login')->withErrors('CAPTCHA FAILED');
                          }*/
                                   return Redirect::to('/dashboard');
                          //from reCAPTCHA admin
                } else {
                    return Redirect::to('/auth/login')->withErrors('Incorrect login details');
                }
            }
    }


});

// Route::get('/logout', 'DashboardController@perform')->name('logout.perform');

Route::get('/auth/login', function () {
    return view('pages.auth.login');
})->name('login');

// Route::get ('logout',function(){
//     Auth::logout();
//     return Redirect::to('/auth/login');
// });

Route::resource('dashboard', 'DashboardController');

Route::resource('common', 'CommonController');

Route::resource('profile', 'ProfileController');

Route::resource('common', 'ContentController');



Route::post('dashboard/addoutlet','DashboardController@addoutlet');

Route::post('dashboard/addoutlet_image','DashboardController@addoutlet_image');
Route::post('dashboard/show_image','DashboardController@show_image');
Route::post('dashboard/delete_image','DashboardController@delete_image');
Route::post('dashboard/lock_location_save','DashboardController@lock_location_save');
Route::post('dashboard/getrecommandvillage','DashboardController@getrecommandvillage');
Route::post('dashboard/getcalendardata','DashboardController@getcalendardata');
Route::post('dashboard/outletstorenamesave','DashboardController@outlet_storename_save');
Route::post('dashboard/getpolygonstatus','DashboardController@getpolygonstatus');
Route::post('dashboard/saveoutlets','DashboardController@saveoutlets');
Route::post('dashboard/updateoutlets','DashboardController@updateoutlets');

Route::post('dashboard/saveoutlets-mdlz','DashboardController@saveoutlets_mdlz');
Route::post('dashboard/updateoutlets-mdlz','DashboardController@updateoutlets_mdlz');

Route::get('/pepsiruralvillage','DashboardController@pepsiruralvillage');

Route::post('dashboard/updatevillagecoverstatus','DashboardController@villageCoverStatusSave');

Route::post('dashboard/getClusterID','CombineController@get_clusterid');





Route::post('dashboard/updateoutlet_premium','DashboardController@updateoutlet_premium');
Route::post('dashboard/updateoutlet','DashboardController@updateoutlet');
Route::post('dashboard/updateoutlet_potential','DashboardController@updateoutlet_potential');
Route::post('dashboard/updateoutlet_byid','DashboardController@updateoutlet_byid');
Route::post('dashboard/updateoutlet_delhi','DashboardController@updateoutlet_delhi');
Route::post('dashboard/userhistory','DashboardController@userhistory');
Route::post('dashboard/user_activity','DashboardController@user_activity');
Route::post('dashboard/notrelavantoutlet','DashboardController@notrelavantoutlet');
Route::post('dashboard/relavantoutlet','DashboardController@relavantoutlet');
Route::post('dashboard/notfoundoutlet','DashboardController@notfoundoutlet');
Route::post('dashboard/existingoutlet','DashboardController@existingoutlet');
Route::post('dashboard/get_info','DashboardController@get_info');
//Route::post('dashboard/newupdateoutlet/{id}','DashboardController@newupdateOutlet');


Route::post('calendar/statelist','CalendarController@statelist');
Route::post('calendar/districtlist','CalendarController@districtlist');
Route::post('calendar/getcalendardata','CalendarController@getcalendardata');
Route::post('calendar/getcalendardata_byid','CalendarController@getcalendardata_byid');


Route::resource('user', 'User\UserController');
Route::post('/user/setpasswd', 'User\UserController@setpasswd');
Route::post('/user/register', 'User\UserController@register');
Route::get('/user/{id}/changepwd', 'User\UserController@changepwd');
Route::post('/user/resetpwd', 'User\UserController@resetpwd');
Route::post('/user/updatepwd', 'User\UserController@updatepwd');
Route::get('/user/{id}/menu', 'User\UserController@menu');

Route::resource('menumaster', 'MenuMasterController');

Route::group(['prefix' => 'auth'], function(){
   // Route::get('login', function () { return view('pages.auth.login'); });
   Route::get('login', function () { return view('pages.auth.login'); 
})->name('login');

Route::get('/session-check', function () {
    if (!auth()->check()) {
        return response()->json([], 401);
    }
    return response()->json(['status' => 'ok']);
});

    Route::get('register', function () { return view('pages.auth.register'); });
    Route::get('setpasswd', function () { return view('pages.auth.setpasswd'); });

});

Route::group(['prefix' => 'error'], function () {
    Route::get('404', function () {
        return view('pages.error.404');
    });
    Route::get('500', function () {
        return view('pages.error.500');
    });
});

/*Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});*/

Route::get('/clear-cache', function () {
   Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return 'Cache is cleared';
});

// 404 for undefined routes
Route::any('/{page?}', function () {
    return view('pages.error.404');
})->where('page', '.*');


/// Rega // /// Rajkumar //
Route::post('dashboard', 'DashboardController@loadmapPost')->name('loadmap.post');
Route::post('common', 'CommonController@commonactivity')->name('commonactivity.post');
Route::post('dashboard/getsubchannel/{id}','DashboardController@getsubchannel');
Route::post('dashboard/get_level','DashboardController@get_level');

// Route::post('combine/get_level','CombineController@get_level');



/// Rega // /// Rajkumar //
