<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\HighwayOutlet;
use App\Models\HighwayStructure;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;
class PassportController extends Controller
{

   public $successStatus = 200;
   public $filenotfound = 404;
   public $failure =500;
   private $isolate=[166, 63, 26];
   private $low=[5,69,54];
   private $high=[151,83,34];

   /**

    * login api

    *

    * @return \Illuminate\Http\Response

    */

  /*public function login()
{
    if (Auth::attempt(['email' => request('email'), 'password' => request('password')]))
    {
        $user_lat = request('user_lat');
        $user_lon = request('user_lon');

        $client_logo = [
            120 => 'https://analytics.brandidea.com/bilocaview/public/storage/logo_64-2.jpg',
            112 => 'https://analytics.brandidea.com/bilocaview/public/storage/coke.jpg',
            133 => 'https://analytics.brandidea.com/bilocaview/public/storage/pepsi-logo.jpg'
        ];

        $user = Auth::user();
        $token = $user->createToken($user->email)->accessToken;

        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");

        // Insert user history
        DB::table("user_history")->insert([
            "user_id" => $user->id,
            "lat" => $user_lat,
            "lng" => $user_lon,
            "created_date" => $date,
            "view_app" => "Mobile",
        ]);

        // Type logic
        $type = ($user->login_type_mdlz == 'Rural') ? 1 : (($user->login_type_mdlz == 'Urban') ? 2 : 1);

        // Logo logic
        $logo = isset($client_logo[$user->client_id]) ? $client_logo[$user->client_id] : '';
        if ($user->client_id == 0) {
            $logo = '';
        }

        // Base response
        $userinfo = [
            'status' => true,
            'message' => 'Authentication Successful',
            'data' => [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'email' => $user->email,
                'client_id' => $user->client_id,
                'role' => $user->role,
                'Organiation' => $user->Organization,
                'token' => $token,
                'type' => $type,
                'logo' => $logo,
                'lock_status'=>$user->lock_status,
                'lock_lat'=>$user->lock_lat,
                'lock_long'=>$user->lock_long,
                'menulist' => []
            ]
        ];

        // Fetch menu
        $menu = DB::table('menu_list')
            ->where('type', $type)
            ->where('client_id', $user->client_id)
            ->get();

        // ✅ Convert to ARRAY (not object)
        foreach ($menu as $item) {
            $userinfo['data']['menulist'][] = [
                'id' => $item->id,
                'menu_key' => $item->menu_key,
                'menu_name' => $item->menu_name
            ];
        }

        return response()->json($userinfo, $this->successStatus);
    }
    else
    {
        $user = DB::table('users')
            ->where('email', request('email'))
            ->get();

        if (count($user) > 0) {
            $errorinfo = ['status' => false, 'message' => 'Wrong Password', 'data' => (object)[]];
        } else {
            $errorinfo = ['status' => false, 'message' => 'No user Exists.', 'data' =>(object) []];
        }

        return response()->json($errorinfo, 401);
    }
}*/

/*public function login()
{
    $email = explode("@", request('email'));
    $email_domain = '';

    if (isset($email[1])) {
        $email_domain = strtolower($email[1]);
    }

    $emailaddress = strtolower(request('email'));

    // SSO Login Check
    if ($email_domain == 'mdlz.com') {

        return response()->json([
            'status' => true,
            'message' => 'SSO Login Required',
            'data' => [
                'sso_login' => true,
                'redirect_url' => url('/sso-login')
            ]
        ], 200);
    }

    // Normal Login
    if (Auth::attempt([
        'email' => request('email'),
        'password' => request('password')
    ]))
    {
        $user_lat = request('user_lat');
        $user_lon = request('user_lon');

        $client_logo = [
            120 => 'https://analytics.brandidea.com/bilocaview/public/storage/logo_64-2.jpg',
            112 => 'https://analytics.brandidea.com/bilocaview/public/storage/coke.jpg',
            133 => 'https://analytics.brandidea.com/bilocaview/public/storage/pepsi-logo.jpg'
        ];

        $user = Auth::user();

        // Passport Token
        $token = $user->createToken($user->email)->accessToken;

        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");

        // Login History
        DB::table("user_history")->insert([
            "user_id" => $user->id,
            "lat" => $user_lat,
            "lng" => $user_lon,
            "created_date" => $date,
            "view_app" => "Mobile",
        ]);

        // Login Count
        DB::table("users_log_count")->insert([
            "user_id" => $user->id,
            "login_time" => $date,
            "client_id" => $user->client_id,
        ]);

        // Type Logic
        if ($user->login_type_mdlz == 'Rural') {
            $type = 1;
        } elseif ($user->login_type_mdlz == 'Urban') {
            $type = 2;
        } else {
            $type = 1;
        }

        // Logo Logic
        $logo = isset($client_logo[$user->client_id])
            ? $client_logo[$user->client_id]
            : '';

        if ($user->client_id == 0) {
            $logo = '';
        }

        // Response
        $userinfo = [
            'status' => true,
            'message' => 'Authentication Successful',
            'data' => [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'email' => $user->email,
                'client_id' => $user->client_id,
                'role' => $user->role,
                'login_type_mdlz' => $user->login_type_mdlz,
                'Organiation' => $user->Organization,
                'token' => $token,
                'type' => $type,
                'logo' => $logo,
                'lock_status' => $user->lock_status,
                'lock_lat' => $user->lock_lat,
                'lock_long' => $user->lock_long,
                'sso_login' => false,
                'menulist' => []
            ]
        ];

        // Menu List
        $menu = DB::table('menu_list')
            ->where('type', $type)
            ->where('client_id', $user->client_id)
            ->get();

        foreach ($menu as $item) {
            $userinfo['data']['menulist'][] = [
                'id' => $item->id,
                'menu_key' => $item->menu_key,
                'menu_name' => $item->menu_name
            ];
        }

        return response()->json($userinfo, $this->successStatus);
    }
    else
    {
        $user = DB::table('users')
            ->where('email', request('email'))
            ->get();

        if (count($user) > 0) {

            $errorinfo = [
                'status' => false,
                'message' => 'Wrong Password',
                'data' => (object)[]
            ];

        } else {

            $errorinfo = [
                'status' => false,
                'message' => 'No user Exists.',
                'data' => (object)[]
            ];
        }

        return response()->json($errorinfo, 401);
    }
} */


public function login()
{
    $email = explode("@", request('email')); 
    $email_domain = '';

    if (isset($email[1])) { 
        $email_domain = strtolower($email[1]);
    }

    $emailaddress = strtolower(request('email'));

    /*
    |--------------------------------------------------------------------------
    | 1. SSO Login Check (Must be at the top)
    |--------------------------------------------------------------------------
    | Only trigger SSO if the status is NOT active and domain matches.
    */
    $sso_login = false;
    if (request('status') !== 'active' && $email_domain == 'mdlz.com') {
        $sso_login = true;
        return response()->json([
            'status' => true,
            'message' => 'SSO Login Required',
            'data' => [
                'sso_login' => true,
                
                'redirect_url' => url('/sso-login') 
            ]
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Normal Login & Password-less Active Status Check
    |--------------------------------------------------------------------------
    */
    $authenticated = false;

    if (request('status') === 'active') {
        // Find the user by email directly
        $userInstance = \App\Models\User::where('email', request('email'))->first();
        
        if ($userInstance) {
            // Force login without checking the password
            Auth::login($userInstance);
            $authenticated = true;
        }
    } else {
        // Fallback to standard password authentication
        $authenticated = Auth::attempt([
            'email' => request('email'),
            'password' => request('password')
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Process Successful Authentication
    |--------------------------------------------------------------------------
    */
    if ($authenticated)
    {
        $user_lat = request('user_lat');
        $user_lon = request('user_lon');

        $client_logo = [
            120 => 'https://analytics.brandidea.com/bilocaview/public/storage/logo_64-2.jpg',
            112 => 'https://analytics.brandidea.com/bilocaview/public/storage/coke.jpg',
            133 => 'https://analytics.brandidea.com/bilocaview/public/storage/pepsi-logo.jpg'
        ];

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Passport Token
        |-------------------------------------------------------------------------- */
        $tokenResult = $user->createToken($user->email);
        $tokenModel = $tokenResult->token;
        $tokenModel->expires_at = \Carbon\Carbon::now()->addMinute();
        $tokenModel->save();
        $token = $tokenResult->accessToken; 

        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");

        /*
        |--------------------------------------------------------------------------
        | Login History & Counts
        |--------------------------------------------------------------------------
        */
        DB::table("user_history")->insert([
            "user_id"      => $user->id,
            "lat"          => $user_lat,
            "lng"          => $user_lon,
            "created_date" => $date,
            "view_app"     => "Mobile",
        ]);

        DB::table("users_log_count")->insert([
            "user_id"    => $user->id,
            "login_time" => $date,
            "client_id"  => $user->client_id,
        ]);

        $login_type = strtolower(trim($user->login_type_mdlz));
        $type = [1];

        /*
        |--------------------------------------------------------------------------
        | Menu Logic
        |--------------------------------------------------------------------------
        */
        if ($user->client_id == 133) {
            if ($login_type == 'rural/urban') {
                $type = [1,2];
                if($user->id === 20895) {
                    $type = [1];
                }
                $menu = DB::table('menu_list')
                    ->whereIn('type', $type)
                    ->where('stat', 'A')
                    ->where('client_id', 133)
                    ->get();
            } elseif ($login_type == 'rural') {
                $type = [2];
                $menu = DB::table('menu_list')
                    ->where('type', 2)
                    ->where('stat', 'A')
                    ->where('client_id', 133)
                    ->get();
            } else {
                $type = [1];
                $menu = DB::table('menu_list')
                    ->where('type', 1)
                    ->where('stat', 'A')
                    ->where('client_id', 133)
                    ->get();
            }
        } else {
            $type = ($login_type == 'urban') ? 2 : 1;
            $menu = DB::table('menu_list')
                ->where('type', $type)
                ->where('stat', 'A')
                ->where('client_id', $user->client_id)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Logo Logic
        |--------------------------------------------------------------------------
        */
        $logo = isset($client_logo[$user->client_id]) ? $client_logo[$user->client_id] : '';
        if ($user->client_id == 0) {
            $logo = '';
        }

        /*
        |--------------------------------------------------------------------------
        | Response Data Build
        |--------------------------------------------------------------------------
        */
        $userinfo = [
            'status' => true,
            'message' => 'Authentication Successful',
            'data' => [
                'id'              => $user->id,
                'firstname'       => $user->firstname,
                'email'           => $user->email,
                'client_id'       => $user->client_id,
                'role'            => $user->role,
                'login_type_mdlz' => $user->login_type_mdlz,
                'Organiation'     => $user->Organization,
                'token'           => $token,
                'logo'            => $logo,
                'lock_status'     => $user->lock_status,
                'lock_lat'        => $user->lock_lat,
                'lock_long'       => $user->lock_long,
                'sso_login'       => $sso_login,
                'menulist'        => []
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | Menu Response Formatting
        |--------------------------------------------------------------------------
        */
        if ($user->client_id == 120) {
            $userinfo['data']['menulist'] = [
                [
                    'menu_title' => 'Recommendation',
                    'menu_icon' => 'https://analytics.brandidea.com/bilocaview/public/storage/recommendation-icon.png',
                    'menus' => []
                ],
                [
                    'menu_title' => 'Additional Tools',
                    'menu_icon' => 'https://analytics.brandidea.com/bilocaview/public/storage/additional-tools-icon.png',
                    'menus' => []
                ]
            ];

            foreach ($menu as $item) {
                if (in_array($item->menu_key, ['subrd_recommendation'])) {
                    $userinfo['data']['menulist'][0]['menus'][] = [
                        'id'        => $item->id,
                        'menu_key'  => $item->menu_key,
                        'menu_name' => $item->menu_name
                    ];
                } else {
                    $userinfo['data']['menulist'][1]['menus'][] = [
                        'id'        => $item->id,
                        'menu_key'  => $item->menu_key,
                        'menu_name' => $item->menu_name
                    ];
                }
            }
        } else {
            
        if($user->id == 13289) {
            $userinfo['data']['menulist'] = [
                [
                    'menu_title' => 'Urban',
                    'menu_icon' => 'https://analytics.brandidea.com/bilocaview/public/storage/additional-tools-icon.png',
                    'menus' => []
                ]
            ];
        }
        else
            {
                 $userinfo['data']['menulist'] = [
                [
                    'menu_title' => 'Urban',
                    'menu_icon' => 'https://analytics.brandidea.com/bilocaview/public/storage/additional-tools-icon.png',
                    'menus' => []
                ],
                [
                    'menu_title' => 'Subrd Recommendation',
                    'menu_icon' => 'https://analytics.brandidea.com/bilocaview/public/storage/recommendation-icon.png',
                    'menus' => []
                ]
            ];
            }

            foreach ($menu as $item) {
                if (in_array($item->menu_key, ['uncovered_outlets'])) {
                    $userinfo['data']['menulist'][0]['menus'][] = [
                        'id'        => $item->id,
                        'menu_key'  => $item->menu_key,
                        'menu_name' => $item->menu_name
                    ];
                } else {
                    if (in_array($item->menu_key, ['rural_gtm','rural_merge','rural_newdbr','rural_subnewdbr'])) {
                        $userinfo['data']['menulist'][1]['menus'][] = [
                            'id'        => $item->id,
                            'menu_key'  => $item->menu_key,
                            'menu_name' => $item->menu_name
                        ];
                    }
                }
            }
        }

        return response()->json($userinfo, $this->successStatus ?? 200);
    }
    else
    {
        /*
        |--------------------------------------------------------------------------
        | 4. Invalid Login Handlers
        |--------------------------------------------------------------------------
        */
        $user = DB::table('users')->where('email', request('email'))->get();

        if (count($user) > 0) {
            $message = (request('status') === 'active') ? 'User account found but verification failed.' : 'Wrong Password';
            $errorinfo = [
                'status' => false,
                'message' => $message,
                'data' => (object)[]
            ];
        } else {
            $errorinfo = [
                'status' => false,
                'message' => 'No user Exists.',
                'data' => (object)[]
            ];
        }

        return response()->json($errorinfo, 401);
    }
}

   public function register(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'firstname' => 'required',
           'email' => 'required|email',
           'password' => 'required',
           'c_password' => 'required|same:password',
       ]);


       if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()], 401);            
       }


       $input = $request->all();
       $input['password'] = bcrypt($input['password']);
       $user = User::create($input);
       $success['token'] =  $user->createToken('MyApp')->accessToken;
       $success['firstname'] =  $user->firstname;

       return response()->json(['success'=>$success], $this->successStatus);

   }

   public function menulist_old(Request $request)
   {
       $input = $request->all();
       $user = Auth::user();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $user=DB::table('users')->where([['id','=',$userid]])->first();
       $type=($user->login_type_mdlz=='Rural' || $user->login_type_mdlz=='') ? 1 : (($user->login_type_mdlz=='Urban') ? 2 : 0);
       $menu=DB::table('menu_list')->where([['type','=',$type],['client_id','=',$user->client_id]])->get();
       $count=count($menu);
       if($count>0){
          $message=['status'=>true,'message'=>'data available','data'=>[]];
           $data=[];
           if($user->client_id==120)
           {
            //,[ "menuTitle"=> "Additional Tools","sublist"=>[]],
              $message['data']['menulist']=[[ "menuTitle"=> "Recommendation","sublist"=>[]],[ "menuTitle"=> "Additional Tools","sublist"=>[]]];
               for($i=0;$i<$count;$i++){
                $data['id']=$menu[$i]->id;
                $data['name']= $menu[$i]->menu_name;
                if(in_array($menu[$i]->id,[1,2]))
                    array_push($message['data']['menulist'][0]["sublist"],$data);
                else
                   array_push($message['data']['menulist'][1]["sublist"],$data); 
                    
               }  
           } 
            if($user->client_id==0)
           {
              $message['data']['menulist']=[[ "menuTitle"=> "Retlrs","sublist"=>[]]];
               for($i=0;$i<$count;$i++){
                $data['id']=$menu[$i]->id;
                $data['name']= $menu[$i]->menu_name;
                array_push($message['data']['menulist'][0]["sublist"],$data);
               }  
           }
      
       }
       else
       {
            $message=['status'=>false,'message'=>'No data available','data'=>[]];
       }

       return response()->json($message, $this->successStatus);
   }
   public function menulist(Request $request)
   {
       $input = $request->all();
       $user = Auth::user();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $user=DB::table('users')->where([['id','=',$userid]])->first();
       $type=($user->login_type_mdlz=='Rural' || $user->login_type_mdlz=='') ? 1 : (($user->login_type_mdlz=='Urban') ? 2 : 0);
       $menu=DB::table('menu_list')->join('menu_type','menu_list.menu_section', '=', 'menu_type.id')->select(['menu_list.id','menu_list.menu_section','menu_list.menu_name','menu_type.type_name'])->where([['type','=',$type],['client_id','=',$user->client_id],['menu_list.stat','=','A']])->get();
       $count=count($menu);
       $menutitle=array();

       if($count>0){
          $message=['status'=>true,'message'=>'data available','data'=>['menulist'=>[]]];
           $data=[];
        for($i=0;$i<$count;$i++){
           if(!in_array($menu[$i]->menu_section,$menutitle))
           {
               array_push($menutitle,$menu[$i]->menu_section);
               $temp=[];
               $temp['menuTitle']=$menu[$i]->type_name;
               $temp['sublist']=[];
               array_push($message['data']['menulist'],$temp);
               end($message['data']['menulist']);
               $pos=key($message['data']['menulist']);
               $data[$menu[$i]->menu_section]=$pos;

           }
            array_push($message['data']['menulist'][$data[$menu[$i]->menu_section]]['sublist'],['id'=>$menu[$i]->id,'name'=>$menu[$i]->menu_name]);
        }
           // if($user->client_id==120)
           // {
           //  //,[ "menuTitle"=> "Additional Tools","sublist"=>[]],
           //    $message['data']['menulist']=[[ "menuTitle"=> "Recommendation","sublist"=>[]],[ "menuTitle"=> "Additional Tools","sublist"=>[]]];
               
           //      $data['id']=$menu[$i]->id;
           //      $data['name']= $menu[$i]->menu_name;
           //      if(in_array($menu[$i]->id,[1,2]))
           //          array_push($message['data']['menulist'][0]["sublist"],$data);
           //      else
           //         array_push($message['data']['menulist'][1]["sublist"],$data); 
                    
           //     }  
           // } 
           //  if($user->client_id==0)
           // {
           //    $message['data']['menulist']=[[ "menuTitle"=> "Retlrs","sublist"=>[]]];
           //     for($i=0;$i<$count;$i++){
           //      $data['id']=$menu[$i]->id;
           //      $data['name']= $menu[$i]->menu_name;
           //      array_push($message['data']['menulist'][0]["sublist"],$data);
           //     }  
           // }
      
       }
       else
       {
            $message=['status'=>false,'message'=>'No data available','data'=>[]];
       }

       return response()->json($message, $this->successStatus);
   }

 public function statelist(Request $request)
{
    $input = $request->all();

    $userid   = $input['userid'] ?? null;
    $client_id= $input['client_id'] ?? null;
    $menu_id  = $input['menu_id'] ?? null;

    // ✅ Default structure
    $menu_wise_state = [
        1=>['id'=>1,'statelist'=>[]], 2=>['id'=>2,'statelist'=>[]],
        3=>['id'=>3,'statelist'=>[]], 4=>['id'=>4,'statelist'=>[]],
        5=>['id'=>5,'statelist'=>[]], 11=>['id'=>11,'statelist'=>[]],
        12=>['id'=>12,'statelist'=>[]],13=>['id'=>13,'statelist'=>[]],
        14=>['id'=>14,'statelist'=>[]],15=>['id'=>15,'statelist'=>[]]
    ];

    // ✅ Get user
    $user = DB::table('users')->where('id', $userid)->first();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found'
        ], 404);
    }

    $user_state = [];
    $tsi_id = [];
    $user_detail = [];

    // ✅ ROLE HANDLING
    if ($user->role == 'tsi') {
        $tsi_id[] = $user->id;
    } else {

        switch ($user->role) {
            case 'SE':
                $user_detail = DB::table('users')->where('se_id', $user->id)->pluck('id')->toArray();
                break;

            case 'ASM':
                $user_detail = DB::table('users')->where('asm_id', $user->id)->pluck('id')->toArray();
                break;

            case 'BSM':
                $user_detail = DB::table('users')->where('bsm_id', $user->id)->pluck('id')->toArray();
                break;

            case 'SOE':
                $user_detail = DB::table('users')->where('soe_id', $user->id)->pluck('id')->toArray();
                break;

            case 'BM':
            case 'RSOM':
            case 'HO':
            case 'CE':
                $user_detail = DB::table('users')
                    ->where('client_id', $user->client_id)
                    ->where('status', 'Active')
                    ->pluck('id')
                    ->toArray();
                break;
        }

        $tsi_id = array_merge($tsi_id, $user_detail);
    }

        if (in_array($user->role, ['BM','RSOM','HO','CE'])) {

        if ($user->client_id == 120 && !empty($user->state_id)) {

            $user_state = explode(',', $user->state_id);

        } else {

            $user_state = DB::table('subrd_data')
                ->distinct()
                ->pluck('loc7')
                ->toArray();
        }
    }

    // ✅ STATE FETCH
  /*  if (in_array($user->role, ['BM','RSOM','HO','CE'])) {

        $states = DB::table('subrd_data')
            ->select('loc7 as state_id')
            ->distinct()
            ->pluck('state_id')
            ->toArray();

        $user_state = $states;

    }*/ else {

        if (!empty($tsi_id)) {
            $states = DB::table('tsi_user_master')
                ->whereIn('refid', $tsi_id)
                ->distinct()
                ->pluck('state_id')
                ->toArray();

            $user_state = $states;
        }
    }

    // ✅ FILTER CONDITIONS && !in_array($user->role, ['BM','RSOM','HO','CE'])
    $subr = $subr_1 = $subr_2 = '';

    if (!empty($user_state) ) {

        $ids = implode(',', $user_state);

        $subr   = " AND a.loc7 IN ($ids) AND a.loc7 NOT IN (1,70,18)";
        $subr_1 = " AND a.state_id IN ($ids) AND a.state_id NOT IN (1,70,18)";
        $subr_2 = " AND a.loc7 IN ($ids) AND a.loc7 NOT IN (1,70,18)";
    }

    // ================= MENU LOGIC =================

    if ($menu_id == 1) {

        $data = DB::select(DB::raw("
            SELECT DISTINCT b.refid as state_id, b.location_name as state
            FROM highway_structure a
            JOIN state_master b ON a.state_id = b.refid
            WHERE 1=1 $subr_1
            ORDER BY b.location_name ASC
        "));

        foreach ($data as $row) {
            $menu_wise_state[1]['statelist'][] = [
                'id' => $row->state_id,
                'name' => $row->state
            ];
        }
    }

    if ($menu_id == 2 || $menu_id == 3) {

        $typeFilter = ($menu_id == 2)
            ? " AND a.subrd_type IN (1,2)"
            : " AND a.subrd_type IN (3)";

        $data = DB::select(DB::raw("
            SELECT b.refid as state_id, b.location_name as state, a.subrd_type
            FROM subrd_data a
            JOIN state_master b ON a.loc7 = b.refid
            WHERE 1=1 $typeFilter $subr
            GROUP BY b.refid, a.subrd_type
            ORDER BY b.location_name ASC
        "));

        foreach ($data as $row) {
            if (in_array($row->subrd_type, [1,2])) {
                $menu_wise_state[2]['statelist'][] = ['id'=>$row->state_id,'name'=>$row->state];
            }
            if ($row->subrd_type == 3) {
                $menu_wise_state[3]['statelist'][] = ['id'=>$row->state_id,'name'=>$row->state];
            }
        }
    }

    if ($menu_id == 11 || $menu_id == 12)
    {
         $subr = "";
        $table = ($menu_id == 11) ? 'mdlz_village_with_zero_rla' : 'subrd_data';

        if($client_id  == 133) //client id based get state list
        {
                $table = 'pepsi_subrd_data';
        }

        $data = DB::select(DB::raw("
            SELECT b.refid as state_id, b.location_name as state
            FROM $table a
            JOIN state_master_2011 b ON a.loc7 = b.refid
            WHERE 1=1 $subr
            GROUP BY b.refid
            ORDER BY b.location_name ASC
        "));

          //\Log::info('menu_id:'.$subr);
        foreach ($data as $row) {
            $menu_wise_state[$menu_id]['statelist'][] = [
                'id'=>$row->state_id,
                'name'=>$row->state
            ];
        }
    }

    if ($menu_id == 13 || $menu_id == 14 || $menu_id == 15) {

        $table = ($menu_id == 15)
            ? 'hri_uncvrd_outlets'
            : '0_delhi_uncvrd_outlets';

        $data = DB::table($table)
            ->select('city','city_id')
            ->distinct()
            ->orderBy('city')
            ->get();

        foreach ($data as $row) {
            $menu_wise_state[$menu_id]['statelist'][] = [
                'id'=>$row->city_id,
                'name'=>$row->city
            ];
        }
    }

    if ($menu_id == 4 || $menu_id == 5) {

        $table = ($menu_id == 4) ? 'subrd_outlet' : 'sst_data';

        $data = DB::select(DB::raw("
            SELECT b.refid as state_id, b.location_name as state
            FROM $table a
            JOIN state_master_2011 b ON a.loc7 = b.refid
            WHERE b.refid NOT IN (1,70) $subr
            GROUP BY b.refid
            ORDER BY b.location_name ASC
        "));

        foreach ($data as $row) {
            $menu_wise_state[$menu_id]['statelist'][] = [
                'id'=>$row->state_id,
                'name'=>$row->state
            ];
        }
    }

    // ✅ FINAL RESPONSE
    return response()->json([
        'status'  => true,
        'message' => 'Statelist loaded',
        'data'    => $menu_wise_state[$menu_id]['statelist'] ?? []
    ]);
}
   public function districtlist(Request $request)
   { 
       $input = $request->all();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $menu_id=$input['menu_id'];
       $state_id=(isset($input['state_id']) ? $input['state_id'] : $input['city_id']);
       $menu_wise_state=[1=>['id'=>1,'data_list'=>[]],2=>['id'=>2,'data_list'=>[]],3=>['id'=>3,'data_list'=>[]],4=>['id'=>4,'data_list'=>[]],5=>['id'=>5,'data_list'=>[]],11=>['id'=>11,'data_list'=>[]],12=>['id'=>12,'data_list'=>[]],13=>['id'=>13,'data_list'=>[]],14=>['id'=>14,'data_list'=>[]],15=>['id'=>15,'data_list'=>[]]];
      

       if($menu_id==1) 
       {
          $highway_list = "select refid,highway_name from highway_structure where state_id='".$state_id."' order by highway_name asc";
         $highway_list_ = DB::select(DB::raw($highway_list));
        $highway_list_count=count($highway_list_);
        
        for($i=0;$i<$highway_list_count;$i++)
            array_push($menu_wise_state[1]['data_list'],['id'=>$highway_list_[$i]->refid,'name'=>$highway_list_[$i]->highway_name]);
       }
       if($menu_id==2 || $menu_id==3)
       {

               
         $subrd_type = ($menu_id==2) ? ' and a.subrd_type in (1,2) ' : (($menu_id==3) ? ' and a.subrd_type in (3) ' : '' );
         $subrd_district= "select distinct b.refid,b.location_name, '".$menu_id."' subrd_type from subrd_data as a,district_master_2011 as b where a.loc9=b.refid and a.loc7='".$state_id."' $subrd_type  order by b.location_name asc";
         $subrd_district = DB::select(DB::raw($subrd_district));
        $subrd_district_count=count($subrd_district);
         
        for($i=0;$i<$subrd_district_count;$i++)
        {
            if(in_array($subrd_district[$i]->subrd_type,[1,2]))
            {
                              
                    array_push($menu_wise_state[2]['data_list'],['id'=>$subrd_district[$i]->refid,'name'=>$subrd_district[$i]->location_name]);
                    
            }
            if(in_array($subrd_district[$i]->subrd_type,[3]))
            {
                
                    array_push($menu_wise_state[3]['data_list'],['id'=>$subrd_district[$i]->refid,'name'=>$subrd_district[$i]->location_name]);
            }
        }
        
       }
        if($menu_id==11)
       {
        
            $subrd_district= "select distinct b.refid,b.location_name from mdlz_village_with_zero_rla as a,district_master_2011 as b where a.loc9=b.refid and a.loc7='".$state_id."'  order by b.location_name asc";
            $subrd_district = DB::select(DB::raw($subrd_district));
            $subrd_district_count=count($subrd_district);
             
            for($i=0;$i<$subrd_district_count;$i++)
            {
                array_push($menu_wise_state[11]['data_list'],['id'=>$subrd_district[$i]->refid,'name'=>$subrd_district[$i]->location_name]);
            }
        
       }
       if($menu_id==12)
       {
        
            $user = DB::table('users')
                ->select('district_id')
                ->where('id', $userid)
                ->first();

            $district_condition = '';
            //filter district id base (district id check with users tables)
            if(!empty($user) && !empty($user->district_id))
            {
                 $districtIds = explode(',', $user->district_id);

                 $district_condition = " AND b.refid IN (" . implode(',', array_map('intval', $districtIds)) . ")";
            }


            $subrd_district= "select distinct b.refid,b.location_name from tsi_subrd_data as a,district_master_2011 as b where a.loc9=b.refid and a.loc7='".$state_id."' $district_condition order by b.location_name asc";
            $subrd_district = DB::select(DB::raw($subrd_district));
            $subrd_district_count=count($subrd_district);
             
            for($i=0;$i<$subrd_district_count;$i++)
            {
                array_push($menu_wise_state[12]['data_list'],['id'=>$subrd_district[$i]->refid,'name'=>$subrd_district[$i]->location_name]);
            }
        
       }
        if($menu_id==13 || $menu_id==14)
       {
         $type_id=($menu_id==13) ? 2 : 3;
        
         $ward_list= "SELECT distinct loc15 as refid,nbhrd as location_name from 0_delhi_uncvrd_outlets where city_id='".$state_id."' and type_id='".$type_id."'  order by nbhrd asc";

        // $ward_list= "SELECT distinct loc15 as refid,nbhrd as location_name from ckpl_uncvrd_outlets_test where city_id='".$state_id."' and period='New Data'  order by nbhrd asc";

            $ward_list = DB::select(DB::raw($ward_list));
            $ward_list_count=count($ward_list); 
             
            for($i=0;$i<$ward_list_count;$i++)
            {
                array_push($menu_wise_state[$menu_id]['data_list'],['id'=>$ward_list[$i]->refid,'name'=>$ward_list[$i]->location_name]);
            }
        
       }
        if($menu_id==15)
       {
         
           $ward_list= "SELECT distinct loc15 as refid,nbhrd as location_name from hri_uncvrd_outlets where city_id='".$state_id."'  order by nbhrd asc";
           // $ward_list= "SELECT distinct loc15 as refid,nbhrd as location_name from ckpl_uncvrd_outlets_test where city_id='".$state_id."' and period='New Data'  order by nbhrd asc";
            $ward_list = DB::select(DB::raw($ward_list));
            $ward_list_count=count($ward_list);
             
            for($i=0;$i<$ward_list_count;$i++)
            {
                array_push($menu_wise_state[$menu_id]['data_list'],['id'=>$ward_list[$i]->refid,'name'=>$ward_list[$i]->location_name]);
            }
        
       }
               
     if($menu_id==4)
     {
        $subrd_beat_=" select distinct b.refid,b.location_name from subrd_outlet as a ,district_master_2011 as b where a.loc9=b.refid and a.loc7='".$state_id."' order by b.location_name asc";
        $subrd_beat_ = DB::select(DB::raw($subrd_beat_));
        $subrd_beat_count=count($subrd_beat_);
                 
        for($i=0;$i<$subrd_beat_count;$i++)
                   array_push($menu_wise_state[4]['data_list'],['id'=>$subrd_beat_[$i]->refid,'name'=>$subrd_beat_[$i]->location_name]); 
        
     }
    if($menu_id==5) 
    {
         $SST_beat_="select distinct b.refid,b.location_name from sst_data as a,district_master_2011 as b where a.loc9=b.refid and a.loc7='".$state_id."' order by b.location_name asc";
        $SST_beat_ = DB::select(DB::raw($SST_beat_));
        $SST_beat_count=count($SST_beat_);
         
        for($i=0;$i<$SST_beat_count;$i++)                    
                array_push($menu_wise_state[5]['data_list'],['id'=>$SST_beat_[$i]->refid,'name'=>$SST_beat_[$i]->location_name]);
    }
       
        /*$message=['status'=>true,'message'=>'Data loaded','data'=>[]];
        $message['data']=$menu_wise_state[$menu_id];
       return response()->json($message, $this->successStatus);*/

            $message = [
            'status'  => true,
            'message' => 'Districtlist loaded',
            'data'    => $menu_wise_state[$menu_id]['data_list']  // ✅ directly the array
        ];
        return response()->json($message, $this->successStatus);
       
   }
   public function taluklist(Request $request)
   { 
       $input = $request->all();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $menu_id=$input['menu_id'];
       //$district_id=$input['district_id'];
       $district_id = isset($input['district_id']) ? $input['district_id'] : (isset($input['state_id']) ? $input['state_id'] : null);
       $menu_wise_state=[1=>['id'=>1,'data_list'=>[]],2=>['id'=>2,'data_list'=>[]],3=>['id'=>3,'data_list'=>[]],4=>['id'=>4,'data_list'=>[]],5=>['id'=>5,'data_list'=>[]],11=>['id'=>11,'data_list'=>[]],12=>['id'=>12,'data_list'=>[]]];
      

      
       if($menu_id==2 || $menu_id==3)
       {
         $subrd_type = ($menu_id==2) ? ' and subrd_type in (1,2) ' : (($menu_id==3) ? ' and subrd_type in (3) ' : '' );
         $subrd_taluk="select distinct taluk_census,taluk_name,".$menu_id." subrd_type from subrd_data where taluk_census!='' and taluk_census !=0000 and loc9='".$district_id."' ".$subrd_type." order by taluk_name asc";
      
         $subrd_taluk = DB::select(DB::raw($subrd_taluk));
        $subrd_taluk_count=count($subrd_taluk);
         
        for($i=0;$i<$subrd_taluk_count;$i++)
        {
            if(in_array($subrd_taluk[$i]->subrd_type,[1,2]))
            {
                              
                    array_push($menu_wise_state[2]['data_list'],['id'=>$subrd_taluk[$i]->taluk_census,'name'=>$subrd_taluk[$i]->taluk_name]);
                    
            }
            if(in_array($subrd_taluk[$i]->subrd_type,[3]))
            {
                
                    array_push($menu_wise_state[3]['data_list'],['id'=>$subrd_taluk[$i]->taluk_census,'name'=>$subrd_taluk[$i]->taluk_name]);
            }
        }
        
       }
     if($menu_id==11)
       {
        
            $subrd_taluk="select distinct taluk_census,taluk_name from mdlz_village_with_zero_rla where taluk_census!='' and taluk_census !=0000 and loc9='".$district_id."'  order by taluk_name asc";
      
            $subrd_taluk = DB::select(DB::raw($subrd_taluk));
            $subrd_taluk_count=count($subrd_taluk);
             
            for($i=0;$i<$subrd_taluk_count;$i++)
            {
                 array_push($menu_wise_state[11]['data_list'],['id'=>$subrd_taluk[$i]->taluk_census,'name'=>$subrd_taluk[$i]->taluk_name]);
            }
        
       }
         if($menu_id==12)
       {
        
            $subrd_taluk="select distinct taluk_census,taluk_name from tsi_subrd_data where taluk_census!='' and taluk_census !=0000 and loc9='".$district_id."'  order by taluk_name asc";
      
            $subrd_taluk = DB::select(DB::raw($subrd_taluk));
            $subrd_taluk_count=count($subrd_taluk);
             
            for($i=0;$i<$subrd_taluk_count;$i++)
            {
                 array_push($menu_wise_state[12]['data_list'],['id'=>$subrd_taluk[$i]->taluk_census,'name'=>$subrd_taluk[$i]->taluk_name]);
            }
        
       }
       
               
     if($menu_id==4)
     {
        $subrd_beat_="select distinct subrd_id,concat(subrd_name,':',subrd_code) as subrd_name from subrd_outlet where loc9='".$district_id."' and subrd_id!=0 order by subrd_name asc";
        $subrd_beat_ = DB::select(DB::raw($subrd_beat_));
        $subrd_beat_count=count($subrd_beat_);
        $subrd_id=[];
                 
        for($i=0;$i<$subrd_beat_count;$i++)
        { 
            if(!in_array($subrd_beat_[$i]->subrd_id,$subrd_id))
            { 
                array_push($subrd_id,$subrd_beat_[$i]->subrd_id);

             array_push($menu_wise_state[4]['data_list'],['id'=>$subrd_beat_[$i]->subrd_id,'name'=>$subrd_beat_[$i]->subrd_name]); 
            }

        }
                  
        
     }
    if($menu_id==5) 
    {
         $SST_beat_='select sst as id,sst as name from sst_data where loc9="'.$district_id.'" order by sst asc';
        $SST_beat_ = DB::select(DB::raw($SST_beat_));
        $SST_beat_count=count($SST_beat_);
         
        for($i=0;$i<$SST_beat_count;$i++)                    
                array_push($menu_wise_state[5]['data_list'],['id'=>$SST_beat_[$i]->id,'name'=>$SST_beat_[$i]->name]);
    }
       
       /* $message=['status'=>true,'message'=>'Data loaded','data'=>[]];
        $message['data']=$menu_wise_state[$menu_id];
       return response()->json($message, $this->successStatus);*/

        // With this:
    $message = [
        'status'  => true,
        'message' => 'Taluklist loaded',
        'data'    => $menu_wise_state[$menu_id]['data_list']  // ✅ directly the array
     ];
      return response()->json($message, $this->successStatus);
       
   }

  /* public function getsubrd_response(Request $request) comment date 2026-16-06
   {
    
       //\Log::info('Request Input', $request->all());
       $message=[];
       $message=['status' => true,'message' => false,'maplist'=>[],'data'=>[],'tabledata'=>['column'=>['#','SubRD Cluster ID','Distt. Name','Sub-Distt. Name','Town / Village Name','Market UID','Distance from Recmmd SubRD Locatn (Km)','Outlet Potential (Nos.)','Population (Nos.)','Villg. Choc Consumption (Annual) (Rs.)','SubRD Priority','Cluster Type','Exist SubRD Code','Exist SubRD Name','No of Active Location'],'value'=>[]]];
       $input = $request->all();
       $user = Auth::user();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $view_type=$input['view_type']; //1-district 2-taluk
       if(isset($input['district_id']) || isset($input['taluk_id']))
        $id=(isset($input['district_id'])) ? explode(",",$input['district_id']) : (isset($input['taluk_id']) ? explode(",",$input['taluk_id']) :[0]);
       $type_view=($input['recommdation']==2) ? [1,2] : [3]; //1,2 - recomm subrd,exit subrd 3- wholesale subrd
       $maparray=[];$str='';
       // $summary_count=[];
       // $summary_count['Develpd']=0;
       // $summary_count['Most Develpd']=0;
       // $summary_count['Under-develpd']=0;
       // $summary_count['Transition']=0;
       // $summary_count['Not Rated']=0;
       // $summary_count['total_village']=0;
       // $summary_count['new_village']=0;
       // $summary_count['show_summary']=0;
       $summary_count=[];        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
        $summary_count['show_summary']=0;
        $summary_count['new_village_current']=0;
        $summary_count['new_village_recommand']=0;
       $color=['green','red','lavender','pink','orange','fgreen','chaani'];
        $orwhere=[];
       if($view_type==1)
            array_push($orwhere,"loc9 in (".implode(",",$id).")");
       if($view_type==2)
            array_push($orwhere,"taluk_code in (".implode(",",$id).")");

       $level_id=0;
       $level_id=($view_type==2) ? 10 : 7;
        $map_level = DB::table("map_level")->where("refid", $level_id)->select(["refid", "map_label","main_location","sub_location","sub_location_temp","suffix","child"])->first();
        //  $geo_level = DB::table("Geo_Hrchy_master")->where("refid", $map_level->sub_location)->select(["geo_level", "name1", "name2", "master_table"])->first();
        //  $geo_table = DB::table("Geo_Hrchy_master")->where("refid", $map_level->main_location)->select([ "geo_level","name1","name2", "master_table","table_name"])->first();
        //$subname_table = DB::table("map_level")->where([ ["main_location", $map_level->main_location],["sub_location", $map_level->sub_location]])->select(["map_label"])->first();
      $sql="SELECT   loc7, loc9,refid as loc_id,town_village_code as village_census,if(sector='Rural',concat(town_village_name,' ','Villg.'),if(sector='Urban',concat(town_village_name,' ','Town'),town_village_name)) as location_name,latitude,longitude,0 as nxt_mp_level,taluk_code FROM `town_village_polygon` where stat='A' and  (".join(" or ",$orwhere).")";
      
      $res = DB::select(DB::raw($sql));

      for ($i_ = 0; $i_ < count($res); $i_++) {
        if($res[$i_]->loc7 != 0 && $res[$i_]->loc9 != 0)
        {
            $level_info=['loc7'=>$res[$i_]->loc7,'loc9'=>$res[$i_]->loc9];
             $district_info[$res[$i_]->taluk_code]=$res[$i_]->loc9;
        }
                
         $maparray[$res[$i_]->village_census] = [
                "nxt_mp_level" => $res[$i_]->nxt_mp_level,
                "loc_id" => $res[$i_]->village_census,
                "current_level" => 7,
                "main_location" => $map_level->main_location,
                "sub_location" => $map_level->sub_location,
                "location_name" =>
                    $res[$i_]->location_name,
                "latitude" => $res[$i_]->latitude,
                "longitude" => $res[$i_]->longitude,
                "loc7" => $res[$i_]->loc7,
                "loc9" => $res[$i_]->loc9,
               
            ];
                   
      }
      //$subname = $subname_table->map_label;
      $level_info_=[];$load_file_list=[];
      if($view_type==2)
        {
             $sql_code="Select  loc7,loc9,taluk_code as taluk_id from town_village_polygon where taluk_code in (".implode(",",$id).") and stat='A'";
            $res_code = DB::select(DB::raw($sql_code));
            $level_info_=[];
            for($m=0;$m<count($res_code);$m++)
            {
                        $level_info_[$res_code[$m]->taluk_id]=['state_id'=>$res_code[$m]->loc7,'district_id'=>$res_code[$m]->loc9];
            }


             for($i=0;$i<count($id);$i++){

              $taluk_id=ltrim($id[$i], 0);
              $loadmap ="mapshapes/district_taluk/" .$level_info_[$taluk_id]['state_id'] ."/" .$level_info_[$taluk_id]['district_id']."/".$taluk_id ."_" . $map_level->main_location ."_" . $map_level->sub_location .".geojson";
               if (!in_array($loadmap, $load_file_list)) {
                    array_push($load_file_list, $loadmap);
                    $location_level_id = $res[$i]->loc_id;
                    $path = "https://analytics.brandidea.com/" . $loadmap;
                    array_push($message["maplist"], $path);
                }
           }
        }
          if($view_type==1)
            {
                $sql_code="Select  loc7,loc9 from town_village_polygon where loc9 in (".implode(",",$id).")";
                $res_code = DB::select(DB::raw($sql_code));
                $level_info_=[];
                for($m=0;$m<count($res_code);$m++)
                {
                            $level_info_[$res_code[$m]->loc9]=$res_code[$m]->loc7;
                }



                for($i=0;$i<count($id);$i++){
                 $loadmap ="mapshapes/district_village/" .$level_info_[$id[$i]] ."/" .$id[$i] ."_" .$map_level->main_location ."_" .$map_level->sub_location .".geojson";
                    
                        if (!in_array($loadmap, $load_file_list)) {

                        array_push($load_file_list, $loadmap);
                        $location_level_id = $res[$i]->loc_id;
                        $path = "https://analytics.brandidea.com/" . $loadmap;
                        array_push($message["maplist"], $path);

                    }

               }
            }

       $orwhere=[];

       if($view_type==1)
        array_push($orwhere,"  a.loc9 in (".implode(",",$id).")");
       if($view_type==2)
        array_push($orwhere,"  a.taluk_census in (".implode(",",$id).")");

        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";


      if (($user->role == 'HO' || $user->role == 'SM') && $user->client_id == 112) {
        $tbllist = [
            120 => 'subrd_data',
            123 => 'subrd_data_perfetti',
            112 => 'coke_subrd_data_all',
            133 => 'pepsi_subrd_data',
            1000 => 'subrd_data_haldiram',
            9999 => 'subrd_data_mars'
        ];
    } else {
        $tbllist = [
            120 => 'subrd_data',
            123 => 'subrd_data_perfetti',
            112 => 'coke_subrd_data',
            133 => 'pepsi_subrd_data',
            1000 => 'subrd_data_haldiram',
            9999 => 'subrd_data_mars'
        ];
    }

      $sql="SELECT  a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.`village_choc_consmptn`, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale FROM {$tbllist[$user->client_id]} as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";
      \Log::info($sql); 
      $result = DB::select(DB::raw($sql));
      $result=$this->getarray($result);
      $final_result=[];
      $inc=0;
      $taluk_name=array_column($result,'taluk_name');
      $taluk_name=array_unique($taluk_name);
      $district_name=array_column($result,'district_name');
      $district_name=array_unique($district_name);

        $state_name=array_column($result,'state_name');
      $state_name=array_unique($state_name);
      
      $table_data=[];
      $priority=['Priority 1'=>'https://analytics.brandidea.com//bilocaview/public/rural_icon/r_p1.png','Priority 2'=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/r_p2.png','Priority 3'=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/r_p3.png',''=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/recommendation.png'];
      $without_hub=$result;
      $non_cluster_color=[];
       

      $message['data']=[];
      $parent_count=0; $child_count=0;

      for($i=0;$i<count($result);$i++)
         {
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'],$type_view))
             {
                  
                  $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                  $final_result[$inc]=$result[$i];
                  $final_result[$inc]['child']=[];
                  $filter_id=$result[$i]['cluster_id'];

                  $final_result[$inc]['exist_subrd_marker']=($result[$i]['subrd_type']==1 && $result[$i]['subrd_loaction']!='Existing Urban Distbtr Hub') ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';
                  $final_result[$inc]['recommand_subrd_marker']=($result[$i]['subrd_type']==2) ? $priority[$result[$i]['subrd_priority']] : '';
                  $final_result[$inc]['wholesale_marker']=($result[$i]['subrd_type']==3) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesaler.png' : '';
                   $final_result[$inc]['urbandistributor_marker']=($final_result[$inc]['subrd_type']==1 && $final_result[$inc]['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$inc]['subrd_type'],$type_view)) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png' : '';
                 
                    $hub_child_list = array_filter($result, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                   });
                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                   });

                              
                  $final_result[$inc]['child']=$hub_child_list; 

                  $res_arr=$result[$i];

                  $res_arr['child']=htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                  $res_arr['child_count']=count($hub_child_list);
                  
                 $inc++;
                 array_push($table_data,$res_arr);
                }
                  
             }
             else if($result[$i]['subrd_type'] ==0 || !in_array($result[$i]['subrd_type'],$type_view))
             {
                $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                      $final_result[$inc]=$result[$i];
                      $final_result[$inc]['child']=[];
                      $final_result[$inc]['exist_subrd_marker']='';
                      $final_result[$inc]['recommand_subrd_marker']='';
                      $final_result[$inc]['wholesale_marker']='';
                                           
                    $inc++;
                   
                }
             }
         }
         $without_hub=array_values($without_hub);
         $without_hub_count=count($without_hub);
      
         for($i=0;$i<$without_hub_count;$i++)
         {
      
              $without_hub[$i]['village_census']=ltrim($without_hub[$i]['village_census'], 0);

                if(isset($maparray[$without_hub[$i]['village_census']]))
                {
                    if($without_hub[$i]['subrd_type']==1 && $without_hub[$i]['active_stat'] =='No')
                        $summary_count['new_village_current']++;
                     if($without_hub[$i]['subrd_type']==2)
                        $summary_count['new_village_recommand']++;
                  $final_result[$inc]=$without_hub[$i];
                  $final_result[$inc]['child']=[];
                  $final_result[$inc]['exist_subrd_marker']=($without_hub[$i]['subrd_type']==1) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';
                  $final_result[$inc]['recommand_subrd_marker']=($without_hub[$i]['subrd_type']==2) ? $priority[$without_hub[$i]['subrd_priority']] : '';
                  $final_result[$inc]['wholesale_marker']=($without_hub[$i]['subrd_type']==3) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesaler.png' : '';
                  $final_result[$inc]['urbandistributor_marker']= '';

                   
                    $inc++;
                   
                }
         }

         $result_count=count($final_result);

         $temp=[]; $table_data=[];
         for($k=0;$k<$result_count;$k++)
         {
         //   $temp=$final_result[$k];
           if($final_result[$k]['subrd_type']==1 && $final_result[$k]['is_hub']==1 && in_array($final_result[$k]['subrd_type'],$type_view))
            {
                if($final_result[$k]['subrd_loaction']=='Existing Urban Distbtr Hub' || $final_result[$k]['subrd_loaction']=='Existing Urban Distbtr')
                    $split_color='lblue';
                else
                    $split_color='grey';
            }
           else if(($final_result[$k]['subrd_type']==2) && $final_result[$k]['is_hub']==1 && in_array($final_result[$k]['subrd_type'],$type_view))
           {
              $range=array_rand(range(0,(count($color)-1)));
              $split_color=$color[$range];
           }
           else if(($final_result[$k]['subrd_type']==3) && $final_result[$k]['is_hub']==1 && in_array($final_result[$k]['subrd_type'],$type_view))
           {
                 $split_color='fgreen';
           }

           else if($final_result[$k]['subrd_type']==0)
              $split_color='none';
           else
              $split_color='none';
            if(in_array($final_result[$k]['subrd_type'],[2,3]) && in_array($final_result[$k]['subrd_type'],$type_view))
            {
                $summary_count['total_village']++;               
                $summary_count['show_summary']=$final_result[$k]['subrd_type'];
            }

            // unset($final_result[$k]['child']);
            /*
                    \Log::info([
            'village' => $final_result[$k]['village_census'],
            'subrd_type' => $final_result[$k]['subrd_type'],
            'is_hub' => $final_result[$k]['is_hub'],
            'active_stat' => $final_result[$k]['active_stat'],
            'split_color' => $split_color ?? ''
        ]);
             
            if($final_result[$k]['is_hub'] != 1 && $final_result[$k]['subrd_type']!=0)
             {
                $hub='#ffffff';
                $child='';

                if($final_result[$k]['active_stat']=='Yes' && ($final_result[$k]['subrd_type']==1) && in_array($final_result[$k]['subrd_type'],$type_view))
                          $hub= $this->getcolor_bysubrd('l_grey');
                if(($final_result[$k]['active_stat']=='N' || $final_result[$k]['active_stat']=='No')  && ($final_result[$k]['subrd_type']==1) && in_array($final_result[$k]['subrd_type'],$type_view))
                           $hub= $this->getcolor_bysubrd('yellow');
                if($final_result[$k]['subrd_loaction']=='Existing Urban Distbtr'  && ($final_result[$k]['subrd_type']==1) && in_array($final_result[$k]['subrd_type'],$type_view))
                           $hub= $this->getcolor_bysubrd('l_lblue'); 
                if((($final_result[$k]['subrd_type']==2) || ($final_result[$k]['subrd_type']==3)) && in_array($final_result[$k]['subrd_type'],$type_view))
               {
                  if(isset($non_cluster_color[$final_result[$k]['cluster_name']]) && $final_result[$k]['subrd_type'] !=3)
                            $hub= $this->getcolor_bysubrd('l_'.$non_cluster_color[$final_result[$k]['cluster_name']]); 
                  else if($final_result[$k]['subrd_type'] !=3){

                     $range=array_rand(range(0,(count($color)-1)));
                     $split_color=$color[$range];
                     $hub= $this->getcolor_bysubrd('l_'.$split_color); 
                     $non_cluster_color[$final_result[$k]['cluster_name']]=$split_color;
                  }
                  else if($final_result[$k]['subrd_type'] ==3)
                  {
                      $hub= $this->getcolor_bysubrd('l_fgreen');
                  }
                 
               }
            }             
             else
                $hub= $this->getcolor_bysubrd('d_'.$split_color); 
             $label='';
             $legend="";
             $temp['color']=$hub; 
             $cluster_type=$final_result[$k]['subrd_loaction'];
             
             $final_result[$k]['activate_status']=$final_result[$k]['company_service_id'];
             $cluster_tag=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'SubRD Existing' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Subrd Reco' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $cluster_hub=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existing SubRD' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommd SubRD' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $temp['activate_marker']=($final_result[$k]['company_service_id']==1) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/deactivated.png' :(($final_result[$k]['company_service_id']==4) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/activated.png' :(($final_result[$k]['company_service_id']==5) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/deactivated.png'  : ''))));

            
             if($final_result[$k]['is_hub']!=0)
            {

               $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
            
               $temp['exist_subrd_marker']=($final_result[$k]['subrd_type']==1 && $final_result[$k]['subrd_loaction']!='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';
               $temp['recommand_subrd_marker']=($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? $priority[$final_result[$k]['subrd_priority']] : '';
               $temp['wholesale_marker']=($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesale.png' : '';
               $temp['urbandistributor_marker']=($final_result[$k]['subrd_type']==1 && $final_result[$k]['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png' : '';

               
            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['exist_subrd_marker']='';
               $temp['wholesale_marker']= '';
               $temp['urbandistributor_marker']= '';
               $temp['recommand_subrd_marker']='';

                 
                 
            } 

      $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : 'https://analytics.brandidea.com/bilocaview/public/rural_icon/'.$final_result[$k]['rpi_img'].'.jpg';

     $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? number_format($final_result[$k]['village_choc_consmptn'],0) : $final_result[$k]['village_choc_consmptn'];
     $temp['rpi']=$final_result[$k]['rpi_img'];
     $temp['info']=[];
     $temp['Village']=$maparray[$final_result[$k]['village_census']]['location_name'];
     $temp['Taluk']=$final_result[$k]['taluk_name'];
     $temp['District']=$final_result[$k]['district_name'];
      $temp['State']=$final_result[$k]['state_name'];
      $temp['ClusterID']=$final_result[$k]['cluster_id'];
     $temp['is_hub']=$final_result[$k]['is_hub'];
      $temp['subrd_loaction']=$final_result[$k]['subrd_loaction'];
     $temp['subrd_type']=$final_result[$k]['subrd_type'];
      $temp['refid']=$final_result[$k]['refid'];
         $temp['subrd_cluster_id']='Cluster '.$final_result[$k]['cluster_id'];


    

      array_push($temp['info'],['key'=>'Recommendation','value'=>$cluster_type,'type'=>'text']);
       array_push($temp['info'],['key'=>'Distance from '.$cluster_hub.' (km)','value'=>0 ,'type'=>'number']);
        array_push($temp['info'],['key'=>'Population (2023)','value'=>number_format($final_result[$k]['population'],0),'type'=>'text']);
        array_push($temp['info'],['key'=>'FMCG Retlr Univ Nos.','value'=>$final_result[$k]['retlr_universe'],'type'=>'text']);
         array_push($temp['info'],['key'=>'MDLZ Cvrg Nos.','value'=>$final_result[$k]['mdlz_retlr_universe'],'type'=>'text']);
           array_push($temp['info'],['key'=>'Avg. SubRD Sales (Rs.) (Last 6 mnths)','value'=>number_format($final_result[$k]['avg_monthly_sale'],0),'type'=>'text']);
         
        array_push($temp['info'],['key'=>'Villg. Choc Consumption (Annual) (Rs.)','value'=>$final_result[$k]['village_choc_consmptn'],'type'=>'text']);
        
    if($final_result[$k]['rpi_img']!='')
        array_push($temp['info'],['key'=>'Rural Progressive Index','value'=>$rural_img,'type'=>'img']);
     array_push($temp['info'],['key'=>'Cluster Tag','value'=>$cluster_tag,'type'=>'text']);
     array_push($temp['info'],['key'=>'SubRD Priority','value'=>$final_result[$k]['subrd_priority'],'type'=>'text']);

     array_push($temp['info'],['key'=>'SubRD Cluster Priority','value'=>$final_result[$k]['subrd_priority'],'type'=>'text']);
      array_push($temp['info'],['key'=>'Market UID','value'=>$final_result[$k]['market_id'],'type'=>'text']);
       array_push($temp['info'],['key'=>'BI Location ID','value'=>(string)$final_result[$k]['bi_id'],'type'=>'text']);
      array_push($temp['info'],['key'=>'Exist SubRD Code','value'=>$final_result[$k]['exist_subrd_code'],'type'=>'text']);
     array_push($temp['info'],['key'=>'Exist SubRD Name','value'=>ucwords(strtolower($final_result[$k]['exist_subrd_name'])),'type'=>'text']);

     $table_data[$final_result[$k]['village_census']]=[];
      $parent_count++;
      $child_count=0;
      $table_data[$final_result[$k]['village_census']]['row_id']=$parent_count;
	
     $table_data[$final_result[$k]['village_census']]['subrd_cluster_id']='Cluster '.$final_result[$k]['cluster_id'];
	 
     $table_data[$final_result[$k]['village_census']]['district_name']=$final_result[$k]['district_name'];
     $table_data[$final_result[$k]['village_census']]['taluk_name']=$final_result[$k]['taluk_name'];
     $table_data[$final_result[$k]['village_census']]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
      $table_data[$final_result[$k]['village_census']]['marker_uid']=$final_result[$k]['market_id'];
      $table_data[$final_result[$k]['village_census']]['distance']=0;
      $table_data[$final_result[$k]['village_census']]['outlet_potential']=$final_result[$k]['retlr_universe'];
      $table_data[$final_result[$k]['village_census']]['population']=number_format($final_result[$k]['population'],0);
      $table_data[$final_result[$k]['village_census']]['village_consumption']=$final_result[$k]['village_choc_consmptn'];
      $table_data[$final_result[$k]['village_census']]['subrd_priority']=$final_result[$k]['subrd_priority'];
      $table_data[$final_result[$k]['village_census']]['cluster_type']=$cluster_type;
      $table_data[$final_result[$k]['village_census']]['exist_subrd_code']=$final_result[$k]['exist_subrd_code'];
      $table_data[$final_result[$k]['village_census']]['exist_subrd_name']=ucwords(strtolower($final_result[$k]['exist_subrd_name']));
      $table_data[$final_result[$k]['village_census']]['no_active_location']=count($final_result[$k]['child']);
       $table_data[$final_result[$k]['village_census']]['latitude']=$final_result[$k]['latitude'];
      $table_data[$final_result[$k]['village_census']]['longitude']=$final_result[$k]['longitude'];
        $table_data[$final_result[$k]['village_census']]['id']=$final_result[$k]['village_census'];
      $table_data[$final_result[$k]['village_census']]['child']=[];
     
      

    

     $temp['size']=15;
     $temp['activate_status_icon']=$temp['activate_marker'];
     $temp['activate_status']=$final_result[$k]['activate_status'];
     $temp['latitude']=$maparray[$final_result[$k]['village_census']]['latitude'];
     $temp['longitude']=$maparray[$final_result[$k]['village_census']]['longitude'];
    // $temp['id']=(int)$final_result[$k]['village_census'];
      $temp['id']=$final_result[$k]['village_census'];
     $data=$temp;
     array_push($message['data'],$data);

        if(isset($final_result[$k]['child']) && count($final_result[$k]['child']) > 0)
        {
              foreach($final_result[$k]['child'] as $key=>$value)
            {
               //  $temp=$value;
                  $temp=[];
                   if($value['subrd_type']==1 && $value['active_stat'] =='No')
                    $summary_count['new_village_current']++;
                 if($value['subrd_type']==2)
                    $summary_count['new_village_recommand']++;
                 if(in_array($value['subrd_type'],[2,3])){
                     $summary_count['new_village']++;

                   if(isset($summary_count[$value['rpi']]))
                            $summary_count[$value['rpi']]++;
                 }
                 // if(in_array($value['subrd_type'],[2,3])){
                 //     $summary_count['new_village']++;
                 //   if(isset($summary_count[$value['rpi']])) 
                 //            $summary_count[$value['rpi']]++;
                 // }
                    $temp['color']= $this->getcolor_bysubrd('l_'.$split_color);
                 if($value['subrd_type']==1)    
                 {
                      $temp['subrd_type']=$value['subrd_type'];
                       if($value['active_stat']=='Yes')
                          $temp['color']= $this->getcolor_bysubrd('l_'.$split_color);
                       if($value['active_stat']=='No' || $value['active_stat']=='No')
                           $temp['color']= $this->getcolor_bysubrd('yellow');                      
                 }             
                
                $temp['subrd_type']=$value['subrd_type']; 

                 $cluster_type=$value['subrd_loaction'];
                 $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($value['subrd_type']==1) ? 'Existing SubRD' :(($value['subrd_type']==2) ? 'Recommd SubRD' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                   $value['village_census']=ltrim($value['village_census'], 0);
                  
                  if(isset($maparray[$value['village_census']]))
                {
                    $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ? number_format($value['village_choc_consmptn'],0) : $value['village_choc_consmptn'];
                    $value['population']=($value['population']!='') ? number_format($value['population'],0) : $value['population'];
                    $value['village_name']=$maparray[$value['village_census']]['location_name'];

                       $rural_img=($value['rpi_img'] == '') ? '' : 'https://analytics.brandidea.com/bilocaview/public/rural_icon/'.$value['rpi_img'].'.jpg';
                       $temp['rpi']=$value['rpi_img'];
                     $temp['info']=[];
                     $temp['Village']=$maparray[$value['village_census']]['location_name'];
                     $temp['Taluk']=$value['taluk_name'];
                     $temp['District']=$value['district_name'];
                      $temp['refid']=$value['refid'];
                      $temp['subrd_type']=$value['subrd_type'];
                      $temp['subrd_cluster_id']='Cluster' .$value['cluster_id'];
                     

                     array_push($temp['info'],['key'=>'Recommendation','value'=>$cluster_type,'type'=>'text']);
                     array_push($temp['info'],['key'=>'Distance from '.$cluster_hub.' (km)','value'=>$value['distance_subrd'],'type'=>'text']);
                     array_push($temp['info'],['key'=>'Population (2023)','value'=>$value['population'],'type'=>'text']);

                     array_push($temp['info'],['key'=>'FMCG Retlr Univ Nos.','value'=>$value['retlr_universe'],'type'=>'text']);
                       array_push($temp['info'],['key'=>'MDLZ Cvrg Nos.','value'=>$value['mdlz_retlr_universe'],'type'=>'text']);
                         array_push($temp['info'],['key'=>'Avg. SubRD Sales (Rs.) (Last 6 mnths)','value'=>number_format($value['avg_monthly_sale'],0),'type'=>'text']);
         
                       array_push($temp['info'],['key'=>'Villg. Choc Consumption (Annual) (Rs.)','value'=>$value['village_choc_consmptn'],'type'=>'text']);
         
                if($value['rpi_img']!='')
                     array_push($temp['info'],['key'=>'Rural Progressive Index','value'=>$rural_img,'type'=>'img']);
                     array_push($temp['info'],['key'=>'Cluster Tag','value'=>$cluster_tag,'type'=>'text']);
                     array_push($temp['info'],['key'=>'SubRD Priority','value'=>$value['subrd_priority'],'type'=>'text']);
                     array_push($temp['info'],['key'=>'SubRD Cluster Priority','value'=>$value['subrd_priority'],'type'=>'text']);
                     array_push($temp['info'],['key'=>'Market UID','value'=>$value['market_id'],'type'=>'text']);
                      array_push($temp['info'],['key'=>'BI Location ID','value'=>$value['bi_id'],'type'=>'text']);

                     array_push($temp['info'],['key'=>'Exist SubRD Code','value'=>$value['exist_subrd_code'],'type'=>'text']);
                     array_push($temp['info'],['key'=>'Exist SubRD Name','value'=>ucwords(strtolower($value['exist_subrd_name'])),'type'=>'text']);
                     $child_count++;
                     $temp_child=[];

                    $temp_child['row_id']=$child_count;
                   
                    $temp_child['subrd_cluster_id']='Cluster '.$value['cluster_id'];
                     $temp_child['district_name']=$value['district_name'];
                     $temp_child['taluk_name']=$value['taluk_name'];
                      $temp_child['village_name']=$maparray[$value['village_census']]['location_name'];
                        $temp_child['marker_uid']=$value['market_id'];
                         $temp_child['distance']=$value['distance_subrd'];
                         $temp_child['outlet_potential']=$value['retlr_universe'];
                          $temp_child['population']=$value['population'];
                    $temp_child['village_consumption']=$value['village_choc_consmptn'];
                    $temp_child['subrd_priority']=$value['subrd_priority'];
                    $temp_child['cluster_type']=$cluster_type;
                     $temp_child['exist_subrd_code']=$value['exist_subrd_code'];
                    $temp_child['exist_subrd_name']=ucwords(strtolower($value['exist_subrd_name']));

                    $temp_child['no_active_location']=0;
                     $temp_child['latitude']=$value['latitude'];
                    $temp_child['longitude']=$value['longitude'];
                      $temp_child['id']=$value['village_census'];

                    

                    $temp_child['is_hub']=$value['is_hub'];
                    $temp_child['subrd_type']=$value['subrd_type'];
                   
                    
                   
                  
                   
                   
                    
                   
                   
      
                    array_push($table_data[$final_result[$k]['village_census']]['child'],$temp_child);
                    
                     $temp['size']=10;
                   //  $temp['activate_status_icon']=$temp['activate_marker'];
                     //$temp['activate_status']=$value['activate_status'];
                      $temp['subrd_type']=$value['subrd_type'];
                     $temp['latitude']=$maparray[$value['village_census']]['latitude'];
                     $temp['longitude']=$maparray[$value['village_census']]['longitude'];
                     $temp['id']=$value['village_census'];
                     $value['activate_status']=$value['company_service_id'];
                     $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                    $value['activate_marker']=($value['company_service_id']==1) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/active.png' : (($value['company_service_id']==2) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/activated.png' :(($value['company_service_id']==5) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/deactivated.png'  : ''))));
            
             $temp['size']=8;
             $temp['activate_status_icon']=$value['activate_marker'];
             $temp['activate_status']=$value['activate_status'];
             $temp['subrd_status']=0;
             $temp['exist_subrd_marker']='';
           $temp['wholesale_marker']= '';
           $temp['urbandistributor_marker']= '';
           $temp['recommand_subrd_marker']='';


            

            

            array_push($message['data'],$temp);

             // $temp2['village_census']=ltrim($value['village_census'],0);
           
          //  $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                }

             
            }

            array_push($message['tabledata']['value'],$table_data[$final_result[$k]['village_census']]);

        }
         
      
         
         }

         $message['message'] = count($message['data']) > 0
    ? 'data load success'
    : 'No data found';

         //$message['mapdata']=$maparray;
          $message['status'] = !empty($message['data']);
          $message['status'] = count($message['data']) > 0;
            $rpiKeys = [
    'Develpd',
    'Most Develpd',
    'Under-develpd',
    'Transition',
    'Not Rated'
    ];

            $aLegend = [];
            $rpi = [];
            $items = [];
            $notes=[];

            $notes[] = [
                'label' => 'Zoom Note',
                'value' => 'Zoom into view RPI'
            ];

            $notes[] = [
                "label"  => "Other Dark Note",
                "value"  =>"Other Dark Color(s): Recommended Distributor Anchor Location"
            ];

            $notes[] = [
                "label"  => "Lighter Note",
                "value"  => "Lighter Shade of Same Color: New Spoke Locations"
            ];


            $items[] = [
                'label' => 'Current/Active SubRD Hub',
                'color' => '#555'
            ];

            $items[] = [
                'label' => 'Current/Active Villg.',
                'color' => '#d3d3d3'
            ];

            $items[] = [
                'label' => 'New Villg for Current SubRD',
                'color' => '#fcff00'
            ];

            $items[] = [
                'label' => 'Newly Activated SubRD Hub',
                'color' => '#2184a5'
            ];

            $items[] = [
                'label' => 'Newly Activated Spoke Villg.',
                'color' => '#00EFFF'
            ];

            //$message['legend'] = $items;

            $labels = [
                'total_village' => 'Total Village',
                'new_village' => 'New Village',
                'show_summary' => 'Show Summary',
                'new_village_current' => 'New Village Current',
                'new_village_recommand' => 'New Village Recommended'
            ];

            foreach ($summary_count as $k => $v) {

                    if (in_array($k, $rpiKeys)) {

                

                        $rpi[] = [
                            'label'  => $k,
                            'value' => $v
                        // 'color' => '#fff'
                        ];

                    } 
                    else
                    {
                        $name = isset($labels[$k]) ? $labels[$k] : $k;
                        $aLegend[] = [
                            'label'  => $name,
                            'value' => $v,
                        //  'color' => '#fff'
                        ];
                    }
            }

                $message['legend'] = [
                    'summary' => $aLegend,
                    'rpi' => $rpi,
                    'items' => $items,
                    'notes' => $notes
                ];


         // $message['legend']=$aLegend;
         $message['action_list']=[];
         $message['action_list'][0]=['name'=>'Exist Subrd Hub','img'=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png'];
         $message['action_list'][1]=['name'=>'Urban Distributor Hub','img'=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png'];
          $message['action_list'][2]=['name'=>'Recommanded Subrd Hub','img'=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/recommendation.png'];
         $message['action_list'][3]=['name'=>'Wholesale','img'=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesale.png'];
         
          $message['action_list'][4]=['name'=>'Active','img'=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/active.png'];
           $message['action_list'][5]=['name'=>'RPI','img'=>'https://analytics.brandidea.com/bilocaview/public/rural_icon/rpi-overlay.png'];

      

       return response()->json($message, $this->successStatus);
       
   }*/
  
  public function getsubrd_response_backup(Request $request)
{
    $message = [];
    $message = ['status' => true, 'message' => false, 'maplist' => [], 'data' => [], 'tabledata' => ['column' => ['#', 'SubRD Cluster ID', 'Distt. Name', 'Sub-Distt. Name', 'Town / Village Name', 'Market UID', 'Distance from Recmmd SubRD Locatn (Km)', 'Outlet Potential (Nos.)', 'Population (Nos.)', 'Villg. Choc Consumption (Annual) (Rs.)', 'SubRD Priority', 'Cluster Type', 'Exist SubRD Code', 'Exist SubRD Name', 'No of Active Location'], 'value' => []]];
    $input = $request->all();
    $user = Auth::user();
    $userid = $input['userid'];
    $client_id = $input['client_id'];
    $view_type = $input['view_type'];
  if (isset($input['district_id']) || isset($input['taluk_id'])) {
    if (isset($input['district_id'])) {
        // If it's already an array, use it. If it's a string (e.g., "167,168"), explode it.
        $id = is_array($input['district_id']) ? $input['district_id'] : explode(",", $input['district_id']);
    } elseif (isset($input['taluk_id'])) {
        // Apply the same safety check for taluk_id just in case
        $id = is_array($input['taluk_id']) ? $input['taluk_id'] : explode(",", $input['taluk_id']);
    } else {
        $id = [0];
    }
 }
    $type_view = ($input['recommdation'] == 2) ? [1, 2] : [3];
    $maparray = [];
    $str = '';

    $summary_count = [];
    $summary_count['Develpd'] = 0;
    $summary_count['Most Develpd'] = 0;
    $summary_count['Under-develpd'] = 0;
    $summary_count['Transition'] = 0;
    $summary_count['Not Rated'] = 0;
    $summary_count['total_village'] = 0;
    $summary_count['new_village'] = 0;
    $summary_count['show_summary'] = 0;
    $summary_count['new_village_current'] = 0;
    $summary_count['new_village_recommand'] = 0;

    $color = ['green', 'red', 'lavender', 'pink', 'orange', 'fgreen', 'chaani'];
    $orwhere = [];

    if ($view_type == 1)
        array_push($orwhere, "loc9 in (" . implode(",", $id) . ")");
    if ($view_type == 2)
        array_push($orwhere, "taluk_code in (" . implode(",", $id) . ")");

    $level_id = 0;
    $level_id = ($view_type == 2) ? 10 : 7;
    $map_level = DB::table("map_level")->where("refid", $level_id)->select(["refid", "map_label", "main_location", "sub_location", "sub_location_temp", "suffix", "child"])->first();

    $sql = "SELECT loc7, loc9, refid as loc_id, town_village_code as village_census, if(sector='Rural',concat(town_village_name,' ','Villg.'),if(sector='Urban',concat(town_village_name,' ','Town'),town_village_name)) as location_name, latitude, longitude, 0 as nxt_mp_level, taluk_code FROM `town_village_polygon` where stat='A' and  (" . join(" or ", $orwhere) . ")";
    $res = DB::select(DB::raw($sql));

    for ($i_ = 0; $i_ < count($res); $i_++) {
        if ($res[$i_]->loc7 != 0 && $res[$i_]->loc9 != 0) {
            $level_info = ['loc7' => $res[$i_]->loc7, 'loc9' => $res[$i_]->loc9];
            $district_info[$res[$i_]->taluk_code] = $res[$i_]->loc9;
        }
        $maparray[$res[$i_]->village_census] = [
            "nxt_mp_level"  => $res[$i_]->nxt_mp_level,
            "loc_id"        => $res[$i_]->village_census,
            "current_level" => 7,
            "main_location" => $map_level->main_location,
            "sub_location"  => $map_level->sub_location,
            "location_name" => $res[$i_]->location_name,
            "latitude"      => $res[$i_]->latitude,
            "longitude"     => $res[$i_]->longitude,
            "loc7"          => $res[$i_]->loc7,
            "loc9"          => $res[$i_]->loc9,
        ];
    }

    $level_info_ = [];
    $load_file_list = [];

    if ($view_type == 2) {
        $sql_code = "Select loc7, loc9, taluk_code as taluk_id from town_village_polygon where taluk_code in (" . implode(",", $id) . ") and stat='A'";
        $res_code = DB::select(DB::raw($sql_code));
        $level_info_ = [];
        for ($m = 0; $m < count($res_code); $m++) {
            $level_info_[$res_code[$m]->taluk_id] = ['state_id' => $res_code[$m]->loc7, 'district_id' => $res_code[$m]->loc9];
        }
        for ($i = 0; $i < count($id); $i++) {
            $taluk_id = ltrim($id[$i], 0);
            $loadmap = "mapshapes/district_taluk/" . $level_info_[$taluk_id]['state_id'] . "/" . $level_info_[$taluk_id]['district_id'] . "/" . $taluk_id . "_" . $map_level->main_location . "_" . $map_level->sub_location . ".geojson";
            if (!in_array($loadmap, $load_file_list)) {
                array_push($load_file_list, $loadmap);
                $location_level_id = $res[$i]->loc_id;
                $path = "https://analytics.brandidea.com/" . $loadmap;
                array_push($message["maplist"], $path);
            }
        }
    }

    if ($view_type == 1) {
        $sql_code = "Select loc7, loc9 from town_village_polygon where loc9 in (" . implode(",", $id) . ")";
        $res_code = DB::select(DB::raw($sql_code));
        $level_info_ = [];
        for ($m = 0; $m < count($res_code); $m++) {
            $level_info_[$res_code[$m]->loc9] = $res_code[$m]->loc7;
        }
        for ($i = 0; $i < count($id); $i++) {
            $loadmap = "mapshapes/district_village/" . $level_info_[$id[$i]] . "/" . $id[$i] . "_" . $map_level->main_location . "_" . $map_level->sub_location . ".geojson";
            if (!in_array($loadmap, $load_file_list)) {
                array_push($load_file_list, $loadmap);
                $location_level_id = $res[$i]->loc_id;
                $path = "https://analytics.brandidea.com/" . $loadmap;
                array_push($message["maplist"], $path);
            }
        }
    }

    $orwhere = [];
    if ($view_type == 1)
        array_push($orwhere, "  a.loc9 in (" . implode(",", $id) . ")");
    if ($view_type == 2)
        array_push($orwhere, "  a.taluk_census in (" . implode(",", $id) . ")");
    if (count($orwhere) > 0)
        $str = " and (" . join(" or ", $orwhere) . ") ";

    if (($user->role == 'HO' || $user->role == 'SM') && $user->client_id == 112) {
        $tbllist = [
            120  => 'subrd_data',
            123  => 'subrd_data_perfetti',
            112  => 'coke_subrd_data_all',
            133  => 'pepsi_subrd_data',
            1000 => 'subrd_data_haldiram',
            9999 => 'subrd_data_mars'
        ];
    } else {
        $tbllist = [
            120  => 'subrd_data',
            123  => 'subrd_data_perfetti',
            112  => 'coke_subrd_data',
            133  => 'pepsi_subrd_data',
            1000 => 'subrd_data_haldiram',
            9999 => 'subrd_data_mars'
        ];
    }

    $sql = "SELECT a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.`village_choc_consmptn`, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`, a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`, a.retlr_universe, a.mdlz_retlr_universe, a.exist_subrd_code, a.exist_subrd_name, if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng, b.latitude, b.longitude, a.rpi, a.active_stat, if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name, if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img, a.avg_monthly_sale FROM {$tbllist[$user->client_id]} as a, town_village_polygon as b WHERE a.village_census=b.town_village_code and a.taluk_census=b.taluk_code " . $str . " and b.stat='A'";
    \Log::info($sql);
    $result = DB::select(DB::raw($sql));
    $result = $this->getarray($result);

    $final_result = [];
    $inc = 0;
    $taluk_name = array_unique(array_column($result, 'taluk_name'));
    $district_name = array_unique(array_column($result, 'district_name'));
    $state_name = array_unique(array_column($result, 'state_name'));

    $table_data = [];
    $priority = [
        'Priority 1' => 'https://analytics.brandidea.com//bilocaview/public/rural_icon/r_p1.png',
        'Priority 2' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/r_p2.png',
        'Priority 3' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/r_p3.png',
        ''           => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/recommendation.png'
    ];
    $without_hub = $result;
    $non_cluster_color = [];
    $message['data'] = [];
    $parent_count = 0;
    $child_count = 0;

    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]['is_hub'] == 1 && in_array($result[$i]['subrd_type'], $type_view)) {
            $result[$i]['village_census'] = ltrim($result[$i]['village_census'], 0);
            if (isset($maparray[$result[$i]['village_census']])) {
                $final_result[$inc] = $result[$i];
                $final_result[$inc]['child'] = [];
                $filter_id = $result[$i]['cluster_id'];
                $final_result[$inc]['exist_subrd_marker'] = ($result[$i]['subrd_type'] == 1 && $result[$i]['subrd_loaction'] != 'Existing Urban Distbtr Hub') ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';
                $final_result[$inc]['recommand_subrd_marker'] = ($result[$i]['subrd_type'] == 2) ? $priority[$result[$i]['subrd_priority']] : '';
                $final_result[$inc]['wholesale_marker'] = ($result[$i]['subrd_type'] == 3) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesaler.png' : '';
                $final_result[$inc]['urbandistributor_marker'] = ($final_result[$inc]['subrd_type'] == 1 && $final_result[$inc]['subrd_loaction'] == 'Existing Urban Distbtr Hub' && in_array($final_result[$inc]['subrd_type'], $type_view)) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png' : '';

                $hub_child_list = array_filter($result, function ($var) use ($filter_id) {
                    return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                });
                $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                    return ($var['cluster_id'] != $filter_id);
                });

                $final_result[$inc]['child'] = $hub_child_list;
                $res_arr = $result[$i];
                $res_arr['child'] = htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                $res_arr['child_count'] = count($hub_child_list);
                $inc++;
                array_push($table_data, $res_arr);
            }
        } else if ($result[$i]['subrd_type'] == 0 || !in_array($result[$i]['subrd_type'], $type_view)) {
            $result[$i]['village_census'] = ltrim($result[$i]['village_census'], 0);
            if (isset($maparray[$result[$i]['village_census']])) {
                $final_result[$inc] = $result[$i];
                $final_result[$inc]['child'] = [];
                $final_result[$inc]['exist_subrd_marker'] = '';
                $final_result[$inc]['recommand_subrd_marker'] = '';
                $final_result[$inc]['wholesale_marker'] = '';
                $inc++;
            }
        }
    }

    $without_hub = array_values($without_hub);
    $without_hub_count = count($without_hub);

    for ($i = 0; $i < $without_hub_count; $i++) {
        $without_hub[$i]['village_census'] = ltrim($without_hub[$i]['village_census'], 0);
        if (isset($maparray[$without_hub[$i]['village_census']])) {
            if ($without_hub[$i]['subrd_type'] == 1 && $without_hub[$i]['active_stat'] == 'No')
                $summary_count['new_village_current']++;
            if ($without_hub[$i]['subrd_type'] == 2)
                $summary_count['new_village_recommand']++;
            $final_result[$inc] = $without_hub[$i];
            $final_result[$inc]['child'] = [];
            $final_result[$inc]['exist_subrd_marker'] = ($without_hub[$i]['subrd_type'] == 1) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';
            $final_result[$inc]['recommand_subrd_marker'] = ($without_hub[$i]['subrd_type'] == 2) ? $priority[$without_hub[$i]['subrd_priority']] : '';
            $final_result[$inc]['wholesale_marker'] = ($without_hub[$i]['subrd_type'] == 3) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesaler.png' : '';
            $final_result[$inc]['urbandistributor_marker'] = '';
            $inc++;
        }
    }

    $result_count = count($final_result);
    $temp = [];
    $table_data = [];

    for ($k = 0; $k < $result_count; $k++) {

        if ($final_result[$k]['subrd_type'] == 1 && $final_result[$k]['is_hub'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) {
            if ($final_result[$k]['subrd_loaction'] == 'Existing Urban Distbtr Hub' || $final_result[$k]['subrd_loaction'] == 'Existing Urban Distbtr')
                $split_color = 'lblue';
            else
                $split_color = 'goldbrown';
        } else if (($final_result[$k]['subrd_type'] == 2) && $final_result[$k]['is_hub'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) {
            $range = array_rand(range(0, (count($color) - 1)));
            $split_color = $color[$range];
        } else if (($final_result[$k]['subrd_type'] == 3) && $final_result[$k]['is_hub'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) {
            $split_color = 'fgreen';
        } else if ($final_result[$k]['subrd_type'] == 0) {
            $split_color = 'none';
        } else {
            $split_color = 'none';
        }

        if (in_array($final_result[$k]['subrd_type'], [2, 3]) && in_array($final_result[$k]['subrd_type'], $type_view)) {
            $summary_count['total_village']++;
            $summary_count['show_summary'] = $final_result[$k]['subrd_type'];
        }

        if ($final_result[$k]['is_hub'] != 1 && $final_result[$k]['subrd_type'] != 0) {
            $hub = '#ffffff';
            if ($final_result[$k]['active_stat'] == 'Yes' && ($final_result[$k]['subrd_type'] == 1) && in_array($final_result[$k]['subrd_type'], $type_view))
                $hub = $this->getcolor_bysubrd('l_goldbrown');
            if (($final_result[$k]['active_stat'] == 'N' || $final_result[$k]['active_stat'] == 'No') && ($final_result[$k]['subrd_type'] == 1) && in_array($final_result[$k]['subrd_type'], $type_view))
                $hub = $this->getcolor_bysubrd('yellow');
            if ($final_result[$k]['subrd_loaction'] == 'Existing Urban Distbtr' && ($final_result[$k]['subrd_type'] == 1) && in_array($final_result[$k]['subrd_type'], $type_view))
                $hub = $this->getcolor_bysubrd('l_lblue');
            if ((($final_result[$k]['subrd_type'] == 2) || ($final_result[$k]['subrd_type'] == 3)) && in_array($final_result[$k]['subrd_type'], $type_view)) {
                if (isset($non_cluster_color[$final_result[$k]['cluster_name']]) && $final_result[$k]['subrd_type'] != 3)
                    $hub = $this->getcolor_bysubrd('l_' . $non_cluster_color[$final_result[$k]['cluster_name']]);
                else if ($final_result[$k]['subrd_type'] != 3) {
                    $range = array_rand(range(0, (count($color) - 1)));
                    $split_color = $color[$range];
                    $hub = $this->getcolor_bysubrd('l_' . $split_color);
                    $non_cluster_color[$final_result[$k]['cluster_name']] = $split_color;
                } else if ($final_result[$k]['subrd_type'] == 3) {
                    $hub = $this->getcolor_bysubrd('l_fgreen');
                }
            }
        } else {
            $hub = $this->getcolor_bysubrd('d_' . $split_color);
        }

        $temp['color'] = $hub;
        $cluster_type = $final_result[$k]['subrd_loaction'];
        $final_result[$k]['activate_status'] = $final_result[$k]['company_service_id'];
        $cluster_tag = ($final_result[$k]['subrd_type'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'SubRD Existing' : (($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Subrd Reco' : (($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Wholesaler' : ''));
        $cluster_hub = ($final_result[$k]['subrd_type'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Existing SubRD' : (($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Recommd SubRD' : (($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Wholesaler' : ''));
        $temp['activate_marker'] = ($final_result[$k]['company_service_id'] == 1) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/active.png' : (($final_result[$k]['company_service_id'] == 2) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/initiated.png' : (($final_result[$k]['company_service_id'] == 3) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/deactivated.png' : (($final_result[$k]['company_service_id'] == 4) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/activated.png' : (($final_result[$k]['company_service_id'] == 5) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/deactivated.png' : ''))));

        if ($final_result[$k]['is_hub'] != 0) {
            $temp['subrd_status'] = (in_array($final_result[$k]['subrd_type'], $type_view)) ? $final_result[$k]['subrd_type'] : 0;
            $temp['exist_subrd_marker'] = ($final_result[$k]['subrd_type'] == 1 && $final_result[$k]['subrd_loaction'] != 'Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';
            $temp['recommand_subrd_marker'] = ($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? $priority[$final_result[$k]['subrd_priority']] : '';
            $temp['wholesale_marker'] = ($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesale.png' : '';
            $temp['urbandistributor_marker'] = ($final_result[$k]['subrd_type'] == 1 && $final_result[$k]['subrd_loaction'] == 'Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png' : '';
        } else {
            $temp['subrd_status'] = 0;
            $temp['exist_subrd_marker'] = '';
            $temp['wholesale_marker'] = '';
            $temp['urbandistributor_marker'] = '';
            $temp['recommand_subrd_marker'] = '';
        }

        $rural_img = ($final_result[$k]['rpi_img'] == '') ? '' : 'https://analytics.brandidea.com/bilocaview/public/rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg';

        $final_result[$k]['village_choc_consmptn'] = ($final_result[$k]['village_choc_consmptn'] != '') ? number_format($final_result[$k]['village_choc_consmptn'], 0) : $final_result[$k]['village_choc_consmptn'];

        $temp['rpi'] = $final_result[$k]['rpi_img'];
        $temp['info'] = [];
        $temp['Village'] = $maparray[$final_result[$k]['village_census']]['location_name'];
        $temp['Taluk'] = $final_result[$k]['taluk_name'];
        $temp['District'] = $final_result[$k]['district_name'];
        $temp['State'] = $final_result[$k]['state_name'];
        $temp['ClusterID'] = $final_result[$k]['cluster_id'];
        $temp['is_hub'] = $final_result[$k]['is_hub'];
        $temp['subrd_loaction'] = $final_result[$k]['subrd_loaction'];
        $temp['subrd_type'] = $final_result[$k]['subrd_type'];
        $temp['refid'] = $final_result[$k]['refid'];
      //  $temp['subrd_cluster_id'] = 'Cluster ' . $final_result[$k]['cluster_id'];
         $temp['subrd_cluster_id'] = $final_result[$k]['cluster_id'];

        // ---- PARENT INFO ARRAY (with all popup conditions) ----
        array_push($temp['info'], ['key' => 'Recommendation', 'value' => $cluster_type, 'type' => 'text']);
        array_push($temp['info'], ['key' => 'Distance from ' . $cluster_hub . ' (km)', 'value' => 0 . ' kms.', 'type' => 'number']);

        // Population + FMCG Retlr Universe
        if ($user->client_id != 1000) {
            array_push($temp['info'], ['key' => 'Population (2025)', 'value' => number_format($final_result[$k]['population'], 0), 'type' => 'text']);
            array_push($temp['info'], ['key' => 'FMCG Retlr Univ Nos.', 'value' => $final_result[$k]['retlr_universe'].' Nos.', 'type' => 'text']);
        }
        if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
            array_push($temp['info'], ['key' => 'Population (2025)', 'value' => number_format($final_result[$k]['population'], 0), 'type' => 'text']);
            array_push($temp['info'], ['key' => 'FMCG Retlr Univ Nos.', 'value' => $final_result[$k]['retlr_universe'].' Nos.', 'type' => 'text']);
        }

        // MDLZ Coverage + Avg SubRD Sales: only subrd_type=1 AND client=120
        if ($final_result[$k]['subrd_type'] == 1 && $user->client_id == 120) {
            $mdlz_label = ($userid == 13285) ? 'Covrge Nos' : 'MDLZ Cvrg Nos';
            array_push($temp['info'], ['key' => $mdlz_label, 'value' => $final_result[$k]['mdlz_retlr_universe'].' Nos.', 'type' => 'text']);
           // array_push($temp['info'], ['key' => 'Avg. SubRD Sales (Rs.) (Last 6 mnths)', 'value' => number_format($final_result[$k]['avg_monthly_sale'], 0), 'type' => 'text']);
        }

        // Consumption: skip for client 112 and 9999
        if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999)
            array_push($temp['info'], ['key' => 'Villg. Choc Consumption (Annual) (Rs.)', 'value' => $final_result[$k]['village_choc_consmptn'], 'type' => 'text']);
        if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural')
            array_push($temp['info'], ['key' => 'Villg. Choc Consumption (Annual) (Rs.)', 'value' => $final_result[$k]['village_choc_consmptn'], 'type' => 'text']);

        // ATM / Bank / NH / SH / Railway: only client 9999
        
        // Rural Progressive Index
        if ($final_result[$k]['rpi_img'] != '')
            array_push($temp['info'], ['key' => 'Rural Progressive Index', 'value' => $rural_img, 'type' => 'img']);
            array_push($temp['info'], ['key' => 'Cluster Tag', 'value' => $cluster_tag, 'type' => 'text']);

        // SubRD Priority + Cluster Priority: only subrd_type in [2,3] AND client=120
        if (in_array($final_result[$k]['subrd_type'], [2, 3]) && $user->client_id == 120) {
            array_push($temp['info'], ['key' => 'SubRD Priority',         'value' => $final_result[$k]['subrd_priority'], 'type' => 'text']);
            array_push($temp['info'], ['key' => 'SubRD Cluster Priority', 'value' => $final_result[$k]['subrd_priority'], 'type' => 'text']);
        }

        // Market UID (client 120) vs BI Location ID (all others) exist_subrd_name
        if ($user->client_id == 120)
            array_push($temp['info'], ['key' => 'Market UID', 'value' => $final_result[$k]['market_id'], 'type' => 'text']);
        if ($user->client_id != 120)
            array_push($temp['info'], ['key' => 'BI Location ID', 'value' => (string)$final_result[$k]['bi_id'], 'type' => 'text']);

        // Exist SubRD Code / Name: subrd_type=1
        if (in_array($final_result[$k]['subrd_type'], [1])) {
            array_push($temp['info'], ['key' => 'Exist SubRD Code', 'value' => $final_result[$k]['exist_subrd_code'], 'type' => 'text']);
              array_push($temp['info'], ['key' => 'Exist SubRD Name', 'value' => $final_result[$k]['exist_subrd_name'], 'type' => 'text']);
          //  $subrd_name_label = ($userid == 13285) ? 'Exist SubRD' : 'Exist SubRD Name';
           // array_push($temp['info'], ['key' => $subrd_name_label, 'value' => ucwords(strtolower($final_result[$k]['exist_subrd_name'])), 'type' => 'text']);
        }

        // client 112: DBR label for subrd_type=5
        if ($user->client_id == 112 && in_array($final_result[$k]['subrd_type'], [5])) {
            array_push($temp['info'], ['key' => 'Exist DBR Code', 'value' => $final_result[$k]['exist_subrd_code'], 'type' => 'text']);
            array_push($temp['info'], ['key' => 'Exist DBR Name', 'value' => ucwords(strtolower($final_result[$k]['exist_subrd_name'])), 'type' => 'text']);
        }

        // ---- END PARENT INFO ARRAY ----

        $table_data[$final_result[$k]['village_census']] = [];
        $parent_count++;
        $child_count = 0;

        $table_data[$final_result[$k]['village_census']]['row_id']           = $parent_count;
        $table_data[$final_result[$k]['village_census']]['subrd_cluster_id'] = 'Cluster ' . $final_result[$k]['cluster_id'];
        $table_data[$final_result[$k]['village_census']]['district_name']    = $final_result[$k]['district_name'];
        $table_data[$final_result[$k]['village_census']]['taluk_name']       = $final_result[$k]['taluk_name'];
        $table_data[$final_result[$k]['village_census']]['village_name']     = $maparray[$final_result[$k]['village_census']]['location_name'];
        $table_data[$final_result[$k]['village_census']]['marker_uid']       = $final_result[$k]['market_id'];
        $table_data[$final_result[$k]['village_census']]['distance']         = 0;
        $table_data[$final_result[$k]['village_census']]['outlet_potential'] = $final_result[$k]['retlr_universe'];
        $table_data[$final_result[$k]['village_census']]['population']       = number_format($final_result[$k]['population'], 0);
        $table_data[$final_result[$k]['village_census']]['village_consumption'] = $final_result[$k]['village_choc_consmptn'];
        $table_data[$final_result[$k]['village_census']]['subrd_priority']   = $final_result[$k]['subrd_priority'];
        $table_data[$final_result[$k]['village_census']]['cluster_type']     = $cluster_type;
        $table_data[$final_result[$k]['village_census']]['exist_subrd_code'] = $final_result[$k]['exist_subrd_code'];
        $table_data[$final_result[$k]['village_census']]['exist_subrd_name'] = ucwords(strtolower($final_result[$k]['exist_subrd_name']));
        $table_data[$final_result[$k]['village_census']]['no_active_location'] = count($final_result[$k]['child']);
        $table_data[$final_result[$k]['village_census']]['latitude']         = $final_result[$k]['latitude'];
        $table_data[$final_result[$k]['village_census']]['longitude']        = $final_result[$k]['longitude'];
        $table_data[$final_result[$k]['village_census']]['id']               = $final_result[$k]['village_census'];
        $table_data[$final_result[$k]['village_census']]['child']            = [];

        $temp['size']                = 15;
        $temp['activate_status_icon'] = $temp['activate_marker'];
        $temp['activate_status']     = $final_result[$k]['activate_status'];
        $temp['latitude']            = $maparray[$final_result[$k]['village_census']]['latitude'];
        $temp['longitude']           = $maparray[$final_result[$k]['village_census']]['longitude'];
        $temp['id']                  = $final_result[$k]['village_census'];
        $data = $temp;
        array_push($message['data'], $data);

        // ---- CHILD LOOP ----
        if (isset($final_result[$k]['child']) && count($final_result[$k]['child']) > 0) {
            foreach ($final_result[$k]['child'] as $key => $value) {

                $temp = [];

                if ($value['subrd_type'] == 1 && $value['active_stat'] == 'No')
                    $summary_count['new_village_current']++;
                if ($value['subrd_type'] == 2)
                    $summary_count['new_village_recommand']++;
                if (in_array($value['subrd_type'], [2, 3])) {
                    $summary_count['new_village']++;
                    if (isset($summary_count[$value['rpi']]))
                        $summary_count[$value['rpi']]++;
                }

                $temp['color'] = $this->getcolor_bysubrd('l_' . $split_color);
                if ($value['subrd_type'] == 1) {
                    $temp['subrd_type'] = $value['subrd_type'];
                    if ($value['active_stat'] == 'Yes')
                        $temp['color'] = $this->getcolor_bysubrd('l_' . $split_color);
                    if ($value['active_stat'] == 'No')
                        $temp['color'] = $this->getcolor_bysubrd('yellow');
                }

                $temp['subrd_type'] = $value['subrd_type'];
                $cluster_type = $value['subrd_loaction'];
                $cluster_tag  = ($value['subrd_type'] == 1) ? 'Existing' : (($value['subrd_type'] == 2) ? 'Recommanded' : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));
                $cluster_hub  = ($value['subrd_type'] == 1) ? 'Existing SubRD' : (($value['subrd_type'] == 2) ? 'Recommd SubRD' : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));

                $value['village_census'] = ltrim($value['village_census'], 0);

                if (isset($maparray[$value['village_census']])) {

                    $value['village_choc_consmptn'] = ($value['village_choc_consmptn'] != '') ? number_format($value['village_choc_consmptn'], 0) : $value['village_choc_consmptn'];
                    $value['population']            = ($value['population'] != '') ? number_format($value['population'], 0) : $value['population'];
                    $value['village_name']          = $maparray[$value['village_census']]['location_name'];

                    $rural_img = ($value['rpi_img'] == '') ? '' : 'https://analytics.brandidea.com/bilocaview/public/rural_icon/' . $value['rpi_img'] . '.jpg';

                    $temp['rpi']            = $value['rpi_img'];
                    $temp['info']           = [];
                    $temp['Village']        = $maparray[$value['village_census']]['location_name'];
                    $temp['Taluk']          = $value['taluk_name'];
                    $temp['District']       = $value['district_name'];
                    $temp['refid']          = $value['refid'];
                    $temp['subrd_type']     = $value['subrd_type'];
                   // $temp['subrd_cluster_id'] = 'Cluster ' . $value['cluster_id'];
                     $temp['subrd_cluster_id'] = $final_result[$k]['cluster_id'];

                    // ---- CHILD INFO ARRAY (with all popup conditions) ----

                    array_push($temp['info'], ['key' => 'Recommendation', 'value' => $cluster_type, 'type' => 'text']);
                    array_push($temp['info'], ['key' => 'Distance from ' . $cluster_hub . ' (km)', 'value' => $value['distance_subrd']. ' kms.', 'type' => 'text']);

                    // Population + FMCG Retlr Universe
                    if ($user->client_id != 1000) {
                        array_push($temp['info'], ['key' => 'Population (2025)', 'value' => $value['population'], 'type' => 'text']);
                        array_push($temp['info'], ['key' => 'FMCG Retlr Univ Nos.', 'value' => $value['retlr_universe'], 'type' => 'text']);
                    }
                    if ($user->client_id == 1000 && $value['sector'] == 'Rural') {
                        array_push($temp['info'], ['key' => 'Population (2025)', 'value' => $value['population'], 'type' => 'text']);
                        array_push($temp['info'], ['key' => 'FMCG Retlr Univ Nos.', 'value' => $value['retlr_universe'].' Nos.', 'type' => 'text']);
                    }

                    // MDLZ Coverage + Avg SubRD Sales: only subrd_type=1 AND client=120
                    if ($value['subrd_type'] == 1 && $user->client_id == 120) {
                        $mdlz_label = ($userid == 13285) ? 'Covrge Nos' : 'MDLZ Cvrg Nos';
                        array_push($temp['info'], ['key' => $mdlz_label, 'value' => $value['mdlz_retlr_universe'].' Nos.', 'type' => 'text']);
                        //array_push($temp['info'], ['key' => 'Avg. SubRD Sales (Rs.) (Last 6 mnths)', 'value' => number_format($value['avg_monthly_sale'], 0), 'type' => 'text']);
                    }

                    // Consumption: skip for client 112 and 9999
                    if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999)
                        array_push($temp['info'], ['key' => 'Villg. Choc Consumption (Annual) (Rs.)', 'value' => $value['village_choc_consmptn'], 'type' => 'text']);
                    if ($user->client_id == 1000 && $value['sector'] == 'Rural')
                        array_push($temp['info'], ['key' => 'Villg. Choc Consumption (Annual) (Rs.)', 'value' => $value['village_choc_consmptn'], 'type' => 'text']);

                    // ATM / Bank / NH / SH / Railway: only client 9999
                    if ($user->client_id == 9999) {
                        array_push($temp['info'], ['key' => 'ATM',              'value' => $value['atm'],     'type' => 'text']);
                        array_push($temp['info'], ['key' => 'Bank',             'value' => $value['bank'],    'type' => 'text']);
                        array_push($temp['info'], ['key' => 'National Highway', 'value' => $value['nh'],      'type' => 'text']);
                        array_push($temp['info'], ['key' => 'State Highway',    'value' => $value['sh'],      'type' => 'text']);
                        array_push($temp['info'], ['key' => 'Railway Station',  'value' => $value['rly_stn'], 'type' => 'text']);
                    }

                    // Rural Progressive Index
                    if ($value['rpi_img'] != '')
                        array_push($temp['info'], ['key' => 'Rural Progressive Index', 'value' => $rural_img, 'type' => 'img']);

                    array_push($temp['info'], ['key' => 'Cluster Tag', 'value' => $cluster_tag, 'type' => 'text']);

                    // SubRD Priority + Cluster Priority: only subrd_type in [2,3] AND client=120
                    if (in_array($value['subrd_type'], [2, 3]) && $user->client_id == 120) {
                        array_push($temp['info'], ['key' => 'SubRD Priority',         'value' => $value['subrd_priority'], 'type' => 'text']);
                        array_push($temp['info'], ['key' => 'SubRD Cluster Priority', 'value' => $value['subrd_priority'], 'type' => 'text']);
                    }

                    // Market UID (client 120) vs BI Location ID (non-120, non-112)
                    if ($user->client_id == 120)
                        array_push($temp['info'], ['key' => 'Market UID', 'value' => $value['market_id'], 'type' => 'text']);
                    if ($user->client_id != 120 && $user->client_id != 112)
                        array_push($temp['info'], ['key' => 'BI Location ID', 'value' => $value['bi_id'], 'type' => 'text']);

                    // Exist SubRD Code / Name: subrd_type=1
                    // Note: reads from parent $final_result[$k] intentionally — mirrors popup behaviour
                    if (in_array($value['subrd_type'], [1])) {
                        array_push($temp['info'], ['key' => 'Exist SubRD Code', 'value' => $final_result[$k]['exist_subrd_code'], 'type' => 'text']);
                        $subrd_name_label = ($userid == 13285) ? 'Exist SubRD' : 'Exist SubRD Name';
                        array_push($temp['info'], ['key' => $subrd_name_label, 'value' => ucwords(strtolower($final_result[$k]['exist_subrd_name'])), 'type' => 'text']);
                    }

                    // client 112: DBR label for subrd_type=5
                    if ($user->client_id == 112 && in_array($value['subrd_type'], [5])) {
                        array_push($temp['info'], ['key' => 'Exist DBR Code', 'value' => $final_result[$k]['exist_subrd_code'], 'type' => 'text']);
                        array_push($temp['info'], ['key' => 'Exist DBR Name', 'value' => ucwords(strtolower($final_result[$k]['exist_subrd_name'])), 'type' => 'text']);
                    }

                    // ---- END CHILD INFO ARRAY ----

                    $child_count++;
                    $temp_child = [];
                    $temp_child['row_id']            = $child_count;
                  //  $temp_child['subrd_cluster_id']  = 'Cluster ' . $value['cluster_id'];
                    $temp_child['subrd_cluster_id']  = $value['cluster_id'];
                    $temp_child['district_name']     = $value['district_name'];
                    $temp_child['taluk_name']        = $value['taluk_name'];
                    $temp_child['village_name']      = $maparray[$value['village_census']]['location_name'];
                    $temp_child['marker_uid']        = $value['market_id'];
                    $temp_child['distance']          = $value['distance_subrd'];
                    $temp_child['outlet_potential']  = $value['retlr_universe'];
                    $temp_child['population']        = $value['population'];
                    $temp_child['village_consumption'] = $value['village_choc_consmptn'];
                    $temp_child['subrd_priority']    = $value['subrd_priority'];
                    $temp_child['cluster_type']      = $cluster_type;
                    $temp_child['exist_subrd_code']  = $value['exist_subrd_code'];
                    $temp_child['exist_subrd_name']  = ucwords(strtolower($value['exist_subrd_name']));
                    $temp_child['no_active_location'] = 0;
                    $temp_child['latitude']          = $value['latitude'];
                    $temp_child['longitude']         = $value['longitude'];
                    $temp_child['id']                = $value['village_census'];
                    $temp_child['is_hub']            = $value['is_hub'];
                    $temp_child['subrd_type']        = $value['subrd_type'];

                    array_push($table_data[$final_result[$k]['village_census']]['child'], $temp_child);

                    $value['activate_status'] = $value['company_service_id'];
                    $value['activate_marker'] = ($value['company_service_id'] == 1) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/active.png' : (($value['company_service_id'] == 2) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/initiated.png' : (($value['company_service_id'] == 3) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/deactivated.png' : (($value['company_service_id'] == 4) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/activated.png' : (($value['company_service_id'] == 5) ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/deactivated.png' : ''))));

                    $temp['size']                 = 8;
                    $temp['activate_status_icon'] = $value['activate_marker'];
                    $temp['activate_status']      = $value['activate_status'];
                    $temp['subrd_status']         = 0;
                    $temp['exist_subrd_marker']   = '';
                    $temp['wholesale_marker']     = '';
                    $temp['urbandistributor_marker'] = '';
                    $temp['recommand_subrd_marker']  = '';
                    $temp['subrd_type']           = $value['subrd_type'];
                    $temp['latitude']             = $maparray[$value['village_census']]['latitude'];
                    $temp['longitude']            = $maparray[$value['village_census']]['longitude'];
                    $temp['id']                   = $value['village_census'];

                    array_push($message['data'], $temp);
                }
            }

            array_push($message['tabledata']['value'], $table_data[$final_result[$k]['village_census']]);
        }
    }

    $message['message'] = count($message['data']) > 0 ? 'data load success' : 'No data found';
    $message['status']  = count($message['data']) > 0;

    $rpiKeys = ['Develpd', 'Most Develpd', 'Under-develpd', 'Transition', 'Not Rated'];
    $aLegend = [];
    $rpi     = [];
    $items   = [];
    $notes   = [];

    $notes[] = ['label' => 'Zoom Note',        'value' => 'Zoom into view RPI'];
    $notes[] = ['label' => 'Other Dark Note',   'value' => 'Other Dark Color(s): Recommended Distributor Anchor Location'];
    $notes[] = ['label' => 'Lighter Note',      'value' => 'Lighter Shade of Same Color: New Spoke Locations'];

    $items[] = ['label' => 'Current/Active SubRD Hub',      'color' => '#7e5a05'];
    $items[] = ['label' => 'Current/Active Villg.',         'color' => '#e4ab59'];
    $items[] = ['label' => 'New Villg for Current SubRD',   'color' => '#fcff00'];
    $items[] = ['label' => 'Newly Activated SubRD Hub',     'color' => '#2184a5'];
    $items[] = ['label' => 'Newly Activated Spoke Villg.',  'color' => '#00EFFF'];

    $labels = [
        'total_village'         => 'Total Village',
        'new_village'           => 'New Village',
        'show_summary'          => 'Show Summary',
        'new_village_current'   => 'New Village Current',
        'new_village_recommand' => 'New Village Recommended'
    ];

    foreach ($summary_count as $k => $v) {
        if (in_array($k, $rpiKeys)) {
            $rpi[] = ['label' => $k, 'value' => $v];
        } else {
            $name = isset($labels[$k]) ? $labels[$k] : $k;
            $aLegend[] = ['label' => $name, 'value' => $v];
        }
    }

    $message['legend'] = [
        'summary' => $aLegend,
        'rpi'     => $rpi,
        'items'   => $items,
        'notes'   => $notes
    ];

    $message['action_list'] = [];
    $message['action_list'][0] = ['name' => 'Exist Subrd Hub',         'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png'];
    $message['action_list'][1] = ['name' => 'Urban Distributor Hub',   'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png'];
    $message['action_list'][2] = ['name' => 'Recommanded Subrd Hub',   'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/recommendation.png'];
    $message['action_list'][3] = ['name' => 'Wholesale',               'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesale.png'];
    $message['action_list'][4] = ['name' => 'Active',                  'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/active.png'];
    $message['action_list'][5] = ['name' => 'RPI',                     'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/rpi-overlay.png'];

    return response()->json($message, $this->successStatus);
}
public function getsubrd_response(Request $request)
{
    $message = [
        'status'    => true,
        'message'   => false,
        'maplist'   => [],
        'data'      => [],
        'tabledata' => [
            'column' => [
                '#',
                'SubRD Cluster ID',
                'Distt. Name',
                'Sub-Distt. Name',
                'Town / Village Name',
                'Market UID',
                'Distance from Recmmd SubRD Locatn (Km)',
                'Outlet Potential (Nos.)',
                'Population (Nos.)',
                'Villg. Choc Consumption (Annual) (Rs.)',
                'SubRD Priority',
                'Cluster Type',
                'Exist SubRD Code',
                'Exist SubRD Name',
                'No of Active Location',
            ],
            'value' => [],
        ],
    ];

    try {

        // =====================================================
        // 1. INPUT EXTRACTION
        // =====================================================
        $input     = $request->all();
        $user      = Auth::user();
        $userid    = $input['userid'];
        $client_id = (int)$input['client_id'];
        $view_type = (int)$input['view_type'];   // 1 = district, 2 = taluk

        if (isset($input['district_id']) && !is_null($input['district_id'])) {
            $id = is_array($input['district_id'])
                ? $input['district_id']
                : explode(',', $input['district_id']);
        } elseif (isset($input['taluk_id']) && !is_null($input['taluk_id'])) {
            $id = is_array($input['taluk_id'])
                ? $input['taluk_id']
                : explode(',', $input['taluk_id']);
        } else {
            $id = [0];
        }

        // recommdation=2 → existing(1) + recommended(2); else wholesaler(3)
        $recommdation = isset($input['recommdation']) ? (int)$input['recommdation'] : null;
        $type_view    = ($recommdation == 2) ? [1, 2] : [3];

        // =====================================================
        // 2. STATIC LOOKUPS
        // =====================================================
        $color = ['green', 'red', 'lavender', 'pink', 'orange', 'fgreen', 'chaani'];

        $priority = [
            'Priority 1' => 'https://analytics.brandidea.com//bilocaview/public/rural_icon/r_p1.png',
            'Priority 2' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/r_p2.png',
            'Priority 3' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/r_p3.png',
            ''           => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/recommendation.png',
        ];

        $summary_count = [
            'Develpd'               => 0,
            'Most Develpd'          => 0,
            'Under-develpd'         => 0,
            'Transition'            => 0,
            'Not Rated'             => 0,
            'total_village'         => 0,
            'new_village'           => 0,
            'show_summary'          => 0,
            'new_village_current'   => 0,
            'new_village_recommand' => 0,
        ];

        // =====================================================
        // 3. TABLE ROUTING
        // =====================================================
        if (($user->role == 'HO' || $user->role == 'SM') && $user->client_id == 112) {
            $tbllist = [
                120  => 'subrd_data',
                123  => 'subrd_data_perfetti',
                112  => 'coke_subrd_data_all',
                133  => 'pepsi_subrd_data',
                1000 => 'subrd_data_haldiram',
                9999 => 'subrd_data_mars',
            ];
        } else {
            $tbllist = [
                120  => 'subrd_data',
                123  => 'subrd_data_perfetti',
                112  => 'coke_subrd_data',
                133  => 'pepsi_subrd_data',
                1000 => 'subrd_data_haldiram',
                9999 => 'subrd_data_mars',
            ];
        }

        if (!isset($tbllist[$client_id])) {
            $message['status']  = false;
            $message['message'] = 'Invalid client_id.';
            return response()->json($message, 422);
        }

        $table = $tbllist[$client_id];

        // =====================================================
        // 4. MAP LEVEL
        // =====================================================
        $level_id  = ($view_type == 2) ? 10 : 7;
        $map_level = DB::table('map_level')
            ->where('refid', $level_id)
            ->select(['refid', 'map_label', 'main_location', 'sub_location', 'sub_location_temp', 'suffix', 'child'])
            ->first();

        // =====================================================
        // 5. BUILD maparray
        // =====================================================
        $maparray      = [];
        $district_info = [];
        $orwhere_map   = [];

        if ($view_type == 1)
            $orwhere_map[] = 'loc9 in (' . implode(',', $id) . ')';
        if ($view_type == 2)
            $orwhere_map[] = 'taluk_code in (' . implode(',', $id) . ')';

        $sql_map = "SELECT loc7, loc9, refid as loc_id,
                        town_village_code as village_census,
                        if(sector='Rural',  concat(town_village_name,' ','Villg.'),
                        if(sector='Urban',  concat(town_village_name,' ','Town'),
                        town_village_name)) as location_name,
                        latitude, longitude,
                        0 as nxt_mp_level,
                        taluk_code
                    FROM town_village_polygon
                    WHERE stat='A'
                      AND (" . implode(' or ', $orwhere_map) . ")";

        $res = DB::select(DB::raw($sql_map));

        foreach ($res as $row) {
            if ($row->loc7 != 0 && $row->loc9 != 0) {
                $district_info[$row->taluk_code] = $row->loc9;
            }
            $maparray[$row->village_census] = [
                'nxt_mp_level'  => $row->nxt_mp_level,
                'loc_id'        => $row->village_census,
                'current_level' => 7,
                'main_location' => $map_level->main_location,
                'sub_location'  => $map_level->sub_location,
                'location_name' => $row->location_name,
                'latitude'      => $row->latitude,
                'longitude'     => $row->longitude,
                'loc7'          => $row->loc7,
                'loc9'          => $row->loc9,
            ];
        }

        // =====================================================
        // 6. BUILD maplist (GeoJSON paths)
        // =====================================================
        $load_file_list = [];

        if ($view_type == 2) {
            $res_code = DB::select(DB::raw(
                "SELECT loc7, loc9, taluk_code as taluk_id
                 FROM town_village_polygon
                 WHERE taluk_code in (" . implode(',', $id) . ") AND stat='A'"
            ));
            $level_info_ = [];
            foreach ($res_code as $r) {
                $level_info_[$r->taluk_id] = ['state_id' => $r->loc7, 'district_id' => $r->loc9];
            }
            foreach ($id as $tid) {
                $taluk_id = ltrim($tid, '0');
                if (!isset($level_info_[$taluk_id])) continue;
                $loadmap = "mapshapes/district_taluk/"
                    . $level_info_[$taluk_id]['state_id'] . "/"
                    . $level_info_[$taluk_id]['district_id'] . "/"
                    . $taluk_id . "_"
                    . $map_level->main_location . "_"
                    . $map_level->sub_location . ".geojson";
                if (!in_array($loadmap, $load_file_list)) {
                    $load_file_list[]     = $loadmap;
                    $message['maplist'][] = 'https://analytics.brandidea.com/' . $loadmap;
                }
            }
        }

        if ($view_type == 1) {
            $res_code = DB::select(DB::raw(
                "SELECT loc7, loc9
                 FROM town_village_polygon
                 WHERE loc9 in (" . implode(',', $id) . ")"
            ));
            $level_info_ = [];
            foreach ($res_code as $r) {
                $level_info_[$r->loc9] = $r->loc7;
            }
            foreach ($id as $did) {
                if (!isset($level_info_[$did])) continue;
                $loadmap = "mapshapes/district_village/"
                    . $level_info_[$did] . "/"
                    . $did . "_"
                    . $map_level->main_location . "_"
                    . $map_level->sub_location . ".geojson";
                if (!in_array($loadmap, $load_file_list)) {
                    $load_file_list[]     = $loadmap;
                    $message['maplist'][] = 'https://analytics.brandidea.com/' . $loadmap;
                }
            }
        }

        // =====================================================
        // 7. MAIN subrd SQL
        // =====================================================
        $orwhere_subrd = [];
        if ($view_type == 1)
            $orwhere_subrd[] = ' a.loc9 in (' . implode(',', $id) . ')';
        if ($view_type == 2)
            $orwhere_subrd[] = ' a.taluk_census in (' . implode(',', $id) . ')';

        $str = count($orwhere_subrd) > 0
            ? ' and (' . implode(' or ', $orwhere_subrd) . ') '
            : '';

       $sql = "SELECT a.cluster_village_biscuits_consmptn,a.village_biscuits_consmptn,a.cluster_village_choc_consmptn,b.state_code,
            a.`refid`, a.`cluster_id`, a.`cluster_name`,
            a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`,
            a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`,
            a.`market_id`, a.`bi_id`,
            a.`distance_subrd`, a.`subrd_loaction`,
            a.`outlet_potential`, a.`population`,
            a.`taluk_census`, a.`village_census`,
            a.`village_choc_consmptn`,
            a.`cluster_tag`, a.`stat`,
            a.`subrd_type`, a.`is_hub`, a.`hub_id`,
            a.`subrd_priority`, a.active_stat,
            a.`tsm_id`, a.`village_2011_census`,
            a.`company_service_id`,
            a.retlr_universe,
            a.mdlz_retlr_universe,
            a.exist_subrd_code,
            a.exist_subrd_name,IF(a.company_service_id=1,'Active',
                IF(a.company_service_id=2,'Initd',
                    IF(a.company_service_id=3,'Inactive',
                        IF(a.company_service_id=4,'Activtd',
                            IF(a.company_service_id=5,'Deactivtd','')
                        )
                    )
                )
            ) AS company_servcng,
            b.latitude,
            b.longitude,
            a.rpi,
            a.active_stat,
            IF(a.rpi_id=2,'D',
                IF(a.rpi_id=1,'MD',
                    IF(a.rpi_id=7,'LT',
                        IF(a.rpi_id=8,'MT',
                            IF(a.rpi_id=9,'UT',
                                IF(a.rpi_id=4,'UD',
                                    IF(a.rpi_id=5,'NR','')
                                )
                            )
                        )
                    )
                )
            ) AS rpi_name,
            IF(a.rpi_id=2,'D', IF(a.rpi_id=1,'MD',
                    IF(a.rpi_id=4,'UD',
                        IF(a.rpi_id=5,'NR',
                            IF(a.rpi_id=6,'NR-U',
                                IF(a.rpi_id=7,'LT',
                                    IF(a.rpi_id=8,'MT',
                                        IF(a.rpi_id=9,'UT','')
                                    )
                                )
                            )
                        )
                    )
                )
            ) AS rpi_img,

            a.avg_monthly_sale

        FROM {$table} AS a
        JOIN town_village_polygon AS b
            ON a.village_census = b.town_village_code
           AND a.taluk_census   = b.taluk_code

        WHERE 1=1
            {$str}
            AND b.stat = 'A'";

     // \Log::info('mdlz: ' . json_encode($sql));
        $result = DB::select(DB::raw($sql));
        $result = $this->getarray($result);

        // =====================================================
        // 8. PASS 1 — SEPARATE HUBS FROM SPOKES
        // =====================================================
        $final_result      = [];
        $table_data        = [];
        $non_cluster_color = [];
        $without_hub       = $result;
        $inc               = 0;

        for ($i = 0; $i < count($result); $i++) {

            $result[$i]['village_census'] = ltrim($result[$i]['village_census'], '0');

            if ($result[$i]['is_hub'] == 1 && in_array($result[$i]['subrd_type'], $type_view)) {

                if (!isset($maparray[$result[$i]['village_census']])) continue;

                $final_result[$inc]          = $result[$i];
                $final_result[$inc]['child'] = [];
                $filter_id                   = $result[$i]['cluster_id'];

                $final_result[$inc]['exist_subrd_marker'] =
                    ($result[$i]['subrd_type'] == 1 && $result[$i]['subrd_loaction'] != 'Existing Urban Distbtr Hub')
                        ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';

                $final_result[$inc]['recommand_subrd_marker'] =
                    ($result[$i]['subrd_type'] == 2)
                        ? (isset($priority[$result[$i]['subrd_priority']]) ? $priority[$result[$i]['subrd_priority']] : '')
                        : '';

                $final_result[$inc]['wholesale_marker'] =
                    ($result[$i]['subrd_type'] == 3)
                        ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesaler.png' : '';

                $final_result[$inc]['urbandistributor_marker'] =
                    ($result[$i]['subrd_type'] == 1
                        && $result[$i]['subrd_loaction'] == 'Existing Urban Distbtr Hub'
                        && in_array($result[$i]['subrd_type'], $type_view))
                        ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png' : '';

                $hub_child_list = array_filter($result, function ($var) use ($filter_id) {
                    return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                });

                $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                    return ($var['cluster_id'] != $filter_id);
                });

                $final_result[$inc]['child'] = $hub_child_list;

                $res_arr                = $result[$i];
                $res_arr['child']       = htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                $res_arr['child_count'] = count($hub_child_list);

                $inc++;
                $table_data[] = $res_arr;

            } elseif ($result[$i]['subrd_type'] == 0 || !in_array($result[$i]['subrd_type'], $type_view)) {

                if (!isset($maparray[$result[$i]['village_census']])) continue;

                $final_result[$inc]                                   = $result[$i];
                $final_result[$inc]['child']                          = [];
                $final_result[$inc]['exist_subrd_marker']             = '';
                $final_result[$inc]['recommand_subrd_marker']         = '';
                $final_result[$inc]['wholesale_marker']               = '';
                $inc++;
            }
        }

        // =====================================================
        // 9. PASS 2 — REMAINING SPOKES (without hub)
        // =====================================================
        $without_hub = array_values($without_hub);

        foreach ($without_hub as $row) {
            $row['village_census'] = ltrim($row['village_census'], '0');
            if (!isset($maparray[$row['village_census']])) continue;

            if ($row['subrd_type'] == 1 && $row['active_stat'] == 'No')
                $summary_count['new_village_current']++;
            if ($row['subrd_type'] == 2)
                $summary_count['new_village_recommand']++;

            $row['child']                  = [];
            $row['exist_subrd_marker']     = ($row['subrd_type'] == 1)
                ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';
            $row['recommand_subrd_marker'] = ($row['subrd_type'] == 2)
                ? (isset($priority[$row['subrd_priority']]) ? $priority[$row['subrd_priority']] : '') : '';
            $row['wholesale_marker']       = ($row['subrd_type'] == 3)
                ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesaler.png' : '';
            $row['urbandistributor_marker']= '';

            $final_result[$inc] = $row;
            $inc++;
        }

        // =====================================================
        // 10. PASS 3 — COLOUR + POPUP + TABLE ASSEMBLY
        // =====================================================
        $result_count = count($final_result);
        $split_color  = 'none';
        $parent_count = 0;
        $table_data   = [];

        for ($k = 0; $k < $result_count; $k++) {

            $temp = [];

            // ── Hub polygon colour ─────────────────────────────
            if ($final_result[$k]['subrd_type'] == 1
                && $final_result[$k]['is_hub'] == 1
                && in_array($final_result[$k]['subrd_type'], $type_view)) {

                $split_color = in_array($final_result[$k]['subrd_loaction'],
                    ['Existing Urban Distbtr Hub', 'Existing Urban Distbtr'])
                    ? 'lblue' : 'goldbrown';

            } elseif ($final_result[$k]['subrd_type'] == 2
                && $final_result[$k]['is_hub'] == 1
                && in_array($final_result[$k]['subrd_type'], $type_view)) {

                $range       = array_rand(range(0, count($color) - 1));
                $split_color = $color[$range];

            } elseif ($final_result[$k]['subrd_type'] == 3
                && $final_result[$k]['is_hub'] == 1
                && in_array($final_result[$k]['subrd_type'], $type_view)) {

                $split_color = 'fgreen';

            } elseif ($final_result[$k]['subrd_type'] == 0) {
                $split_color = 'none';
            } else {
                $split_color = 'none';
            }

            // ── Summary counts ─────────────────────────────────
            if (in_array($final_result[$k]['subrd_type'], [2, 3])
                && in_array($final_result[$k]['subrd_type'], $type_view)) {
                $summary_count['total_village']++;
                $summary_count['show_summary'] = $final_result[$k]['subrd_type'];
            }

            // ── Polygon fill colour ────────────────────────────
            if ($final_result[$k]['is_hub'] != 1 && $final_result[$k]['subrd_type'] != 0) {
                $hub = '#ffffff';

                if ($final_result[$k]['active_stat'] == 'Yes'
                    && $final_result[$k]['subrd_type'] == 1
                    && in_array($final_result[$k]['subrd_type'], $type_view))
                    $hub = $this->getcolor_bysubrd('l_goldbrown');

                if (in_array($final_result[$k]['active_stat'], ['N', 'No'])
                    && $final_result[$k]['subrd_type'] == 1
                    && in_array($final_result[$k]['subrd_type'], $type_view))
                    $hub = $this->getcolor_bysubrd('yellow');

                if ($final_result[$k]['subrd_loaction'] == 'Existing Urban Distbtr'
                    && $final_result[$k]['subrd_type'] == 1
                    && in_array($final_result[$k]['subrd_type'], $type_view))
                    $hub = $this->getcolor_bysubrd('l_lblue');

                if (in_array($final_result[$k]['subrd_type'], [2, 3])
                    && in_array($final_result[$k]['subrd_type'], $type_view)) {

                    if (isset($non_cluster_color[$final_result[$k]['cluster_name']])
                        && $final_result[$k]['subrd_type'] != 3) {
                        $hub = $this->getcolor_bysubrd('l_' . $non_cluster_color[$final_result[$k]['cluster_name']]);
                    } elseif ($final_result[$k]['subrd_type'] != 3) {
                        $range       = array_rand(range(0, count($color) - 1));
                        $split_color = $color[$range];
                        $hub         = $this->getcolor_bysubrd('l_' . $split_color);
                        $non_cluster_color[$final_result[$k]['cluster_name']] = $split_color;
                    } else {
                        $hub = $this->getcolor_bysubrd('l_fgreen');
                    }
                }
            } else {
                $hub = $this->getcolor_bysubrd('d_' . $split_color);
            }

            $temp['color'] = $hub;

            // ── Cluster labels ─────────────────────────────────
            $cluster_type = $final_result[$k]['subrd_loaction'];
            $final_result[$k]['activate_status'] = $final_result[$k]['company_service_id'];

            $cluster_tag = ($final_result[$k]['subrd_type'] == 1 && in_array(1, $type_view)) ? 'SubRD Existing'
                : (($final_result[$k]['subrd_type'] == 2 && in_array(2, $type_view)) ? 'SubRD Reco'
                : (($final_result[$k]['subrd_type'] == 3 && in_array(3, $type_view)) ? 'Wholesaler' : ''));

            $cluster_hub = ($final_result[$k]['subrd_type'] == 1 && in_array(1, $type_view)) ? 'SubRD Existing'
                : (($final_result[$k]['subrd_type'] == 2 && in_array(2, $type_view)) ? 'SubRD Reco'
                : (($final_result[$k]['subrd_type'] == 3 && in_array(3, $type_view)) ? 'Wholesaler' : ''));

            // ── Activate marker ────────────────────────────────
            $temp['activate_marker'] = $this->_resolveActivateMarkerUrl((int)$final_result[$k]['company_service_id']);

            // ── SubRD markers ──────────────────────────────────
            if ($final_result[$k]['is_hub'] != 0) {
                $temp['subrd_status'] = in_array($final_result[$k]['subrd_type'], $type_view)
                    ? $final_result[$k]['subrd_type'] : 0;

                $temp['exist_subrd_marker'] = ($final_result[$k]['subrd_type'] == 1
                    && $final_result[$k]['subrd_loaction'] != 'Existing Urban Distbtr Hub'
                    && in_array(1, $type_view))
                    ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png' : '';

                $temp['recommand_subrd_marker'] = ($final_result[$k]['subrd_type'] == 2 && in_array(2, $type_view))
                    ? (isset($priority[$final_result[$k]['subrd_priority']]) ? $priority[$final_result[$k]['subrd_priority']] : '') : '';

                $temp['wholesale_marker'] = ($final_result[$k]['subrd_type'] == 3 && in_array(3, $type_view))
                    ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesale.png' : '';

                $temp['urbandistributor_marker'] = ($final_result[$k]['subrd_type'] == 1
                    && $final_result[$k]['subrd_loaction'] == 'Existing Urban Distbtr Hub'
                    && in_array(1, $type_view))
                    ? 'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png' : '';

            } else {
                $temp['subrd_status']           = 0;
                $temp['exist_subrd_marker']     = '';
                $temp['wholesale_marker']       = '';
                $temp['urbandistributor_marker']= '';
                $temp['recommand_subrd_marker'] = '';
            }

            // ── RPI image ──────────────────────────────────────
            $rural_img = ($final_result[$k]['rpi_img'] == '') ? ''
                : 'https://analytics.brandidea.com/bilocaview/public/rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg';

            // ── Format consumption ─────────────────────────────
            $final_result[$k]['village_choc_consmptn'] =
                ($final_result[$k]['village_choc_consmptn'] != '')
                    ? number_format($final_result[$k]['village_choc_consmptn'], 0)
                    : $final_result[$k]['village_choc_consmptn'];

            // ── Flat fields ────────────────────────────────────
            $temp['rpi']              = $final_result[$k]['rpi_img'];
            $temp['info']             = [];
            $temp['Village']          = $maparray[$final_result[$k]['village_census']]['location_name'];
            $temp['Taluk']            = $final_result[$k]['taluk_name'];
            $temp['District']         = $final_result[$k]['district_name'];
            $temp['State']            = $final_result[$k]['state_name'];
            $temp['ClusterID']        = $final_result[$k]['cluster_id'];
            $temp['is_hub']           = $final_result[$k]['is_hub'];
            $temp['subrd_loaction']   = $final_result[$k]['subrd_loaction'];
            $temp['subrd_type']       = $final_result[$k]['subrd_type'];
            $temp['refid']            = $final_result[$k]['refid'];
            $temp['subrd_cluster_id'] = $final_result[$k]['cluster_id'];

            // ── PARENT info array ──────────────────────────────
            // Skip Recommendation, Distance, Cluster Tag when cluster_id = 0
            $has_cluster = ($final_result[$k]['cluster_id'] != 0 && $final_result[$k]['cluster_id'] != '');

            if ($has_cluster) {
                $temp['info'][] = ['key' => 'Recommendation',                          'value' => $cluster_type, 'type' => 'text'];
                $temp['info'][] = ['key' => 'Distance from ' . $cluster_hub . ' (km)', 'value' => '0 kms.',     'type' => 'text'];
            }

            if ($user->client_id != 1000) {
                $temp['info'][] = ['key' => 'Population (2025)',    'value' => number_format($final_result[$k]['population'], 0),    'type' => 'text'];
                $temp['info'][] = ['key' => 'FMCG Retlr Univ Nos.','value' => $final_result[$k]['retlr_universe'] . ' Nos.',        'type' => 'text'];
            }
            if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
                $temp['info'][] = ['key' => 'Population (2025)',    'value' => number_format($final_result[$k]['population'], 0),    'type' => 'text'];
                $temp['info'][] = ['key' => 'FMCG Retlr Univ Nos.','value' => $final_result[$k]['retlr_universe'] . ' Nos.',        'type' => 'text'];
            }

            if ($final_result[$k]['subrd_type'] == 1 && $user->client_id == 120) {
                $mdlz_label     = ($userid == 13285) ? 'Covrge Nos' : 'MDLZ Cvrg Nos';
                $temp['info'][] = ['key' => $mdlz_label, 'value' => $final_result[$k]['mdlz_retlr_universe'] . ' Nos.', 'type' => 'text'];
            }

            if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999)
                $temp['info'][] = ['key' => 'Villg. Choc Consumption (Annual) (Rs.)', 'value' => $final_result[$k]['village_choc_consmptn'], 'type' => 'text'];
                $temp['info'][] = ['key' => 'Villg. Biscuit Consumption (Annual) (Rs.)', 'value' => $final_result[$k]['village_biscuits_consmptn'], 'type' => 'text'];
            if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural')
                $temp['info'][] = ['key' => 'Villg. Choc Consumption (Annual) (Rs.)', 'value' => $final_result[$k]['village_choc_consmptn'], 'type' => 'text'];
                $temp['info'][] = ['key' => 'Villg. Biscuit Consumption (Annual) (Rs.)', 'value' => $final_result[$k]['village_biscuits_consmptn'], 'type' => 'text'];

            if ($final_result[$k]['rpi_img'] != '')
                $temp['info'][] = ['key' => 'Rural Progressive Index', 'value' => $rural_img, 'type' => 'img'];

            if ($has_cluster)
                $temp['info'][] = ['key' => 'Cluster Tag', 'value' => $cluster_tag, 'type' => 'text'];
                

            if (in_array($final_result[$k]['subrd_type'], [2, 3]) && $user->client_id == 120) {
                $temp['info'][] = ['key' => 'SubRD Priority',         'value' => $final_result[$k]['subrd_priority'], 'type' => 'text'];
                $temp['info'][] = ['key' => 'SubRD Cluster Priority', 'value' => $final_result[$k]['subrd_priority'], 'type' => 'text'];
            }

            if ($user->client_id == 120)
                $temp['info'][] = ['key' => 'Market UID',     'value' => $final_result[$k]['market_id'],     'type' => 'text'];
                $temp['info'][] = [ 'key'   => 'Total Cluster Consumption (Choc)(Annual)(Rs.)','value' => number_format((int)$final_result[$k]['cluster_village_choc_consmptn']),'type'  => 'text'];
                $temp['info'][] = [ 'key'   => 'Total Cluster Consumption (Biscuit)(Annual)(Rs.)','value' => number_format((int)$final_result[$k]['cluster_village_biscuits_consmptn']),'type'  => 'text'];
            if ($user->client_id != 120)
                $temp['info'][] = ['key' => 'BI Location ID', 'value' => (string)$final_result[$k]['bi_id'], 'type' => 'text'];

            if (in_array($final_result[$k]['subrd_type'], [1])) {
                $temp['info'][] = ['key' => 'Exist SubRD Code', 'value' => $final_result[$k]['exist_subrd_code'],                            'type' => 'text'];
                $temp['info'][] = ['key' => 'Exist SubRD Name', 'value' => ucwords(strtolower($final_result[$k]['exist_subrd_name'])),        'type' => 'text'];
            }

            if ($user->client_id == 112 && in_array($final_result[$k]['subrd_type'], [5])) {
                $temp['info'][] = ['key' => 'Exist DBR Code', 'value' => $final_result[$k]['exist_subrd_code'],                              'type' => 'text'];
                $temp['info'][] = ['key' => 'Exist DBR Name', 'value' => ucwords(strtolower($final_result[$k]['exist_subrd_name'])),          'type' => 'text'];
            }

            // ── Table data row (parent) ────────────────────────
            $vc              = $final_result[$k]['village_census'];
            $parent_count++;
            $child_count_row = 0;

            $table_data[$vc] = [
                'row_id'              => $parent_count,
                'subrd_cluster_id'    => $final_result[$k]['cluster_id'],
                'district_name'       => $final_result[$k]['district_name'],
                'taluk_name'          => $final_result[$k]['taluk_name'],
                'village_name'        => $maparray[$vc]['location_name'],
                'marker_uid'          => $final_result[$k]['market_id'],
                'distance'            => 0,
                'outlet_potential'    => $final_result[$k]['retlr_universe'],
                'population'          => number_format($final_result[$k]['population'], 0),
                'village_consumption' => $final_result[$k]['village_choc_consmptn'],
                'subrd_priority'      => $final_result[$k]['subrd_priority'],
                'cluster_type'        => $cluster_type,
                'exist_subrd_code'    => $final_result[$k]['exist_subrd_code'],
                'exist_subrd_name'    => ucwords(strtolower($final_result[$k]['exist_subrd_name'])),
                'no_active_location'  => count($final_result[$k]['child']),
                'latitude'            => $final_result[$k]['latitude'],
                'longitude'           => $final_result[$k]['longitude'],
                'id'                  => $vc,
                'child'               => [],
            ];

            // ── Map data push (parent) ─────────────────────────
            $temp['size']                = 15;
            $temp['activate_status_icon']= $temp['activate_marker'];
            $temp['activate_status']     = $final_result[$k]['activate_status'];
            $temp['latitude']            = $maparray[$vc]['latitude'];
            $temp['longitude']           = $maparray[$vc]['longitude'];
            $temp['id']                  = $vc;

            $message['data'][] = $temp;

            // =====================================================
            // 11. CHILD LOOP
            // =====================================================
            if (!empty($final_result[$k]['child'])) {

                foreach ($final_result[$k]['child'] as $value) {

                    $temp2 = [];

                    if ($value['subrd_type'] == 1 && $value['active_stat'] == 'No')
                        $summary_count['new_village_current']++;
                    if ($value['subrd_type'] == 2)
                        $summary_count['new_village_recommand']++;
                    if (in_array($value['subrd_type'], [2, 3])) {
                        $summary_count['new_village']++;
                        if (isset($summary_count[$value['rpi']]))
                            $summary_count[$value['rpi']]++;
                    }

                    // Child polygon colour
                    $temp2['color'] = $this->getcolor_bysubrd('l_' . $split_color);
                    if ($value['subrd_type'] == 1) {
                        $temp2['color'] = ($value['active_stat'] == 'No')
                            ? $this->getcolor_bysubrd('yellow')
                            : $this->getcolor_bysubrd('l_' . $split_color);
                    }

                    $temp2['subrd_type']      = $value['subrd_type'];
                    $child_cluster_type       = $value['subrd_loaction'];
                    $child_cluster_tag        = ($value['subrd_type'] == 1) ? 'Existing'
                        : (($value['subrd_type'] == 2) ? 'Recommended'
                        : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));
                    $child_cluster_hub        = ($value['subrd_type'] == 1) ? 'Existing SubRD'
                        : (($value['subrd_type'] == 2) ? 'SubRD Recommd'
                        : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));

                    $value['village_census'] = ltrim($value['village_census'], '0');
                    if (!isset($maparray[$value['village_census']])) continue;

                    $value['village_choc_consmptn'] = ($value['village_choc_consmptn'] != '')
                        ? number_format($value['village_choc_consmptn'], 0)
                        : $value['village_choc_consmptn'];

                    $value['population']   = ($value['population'] != '')
                        ? number_format($value['population'], 0)
                        : $value['population'];

                    $value['village_name'] = $maparray[$value['village_census']]['location_name'];

                    $rural_img_child = ($value['rpi_img'] == '') ? ''
                        : 'https://analytics.brandidea.com/bilocaview/public/rural_icon/' . $value['rpi_img'] . '.jpg';

                    $temp2['rpi']             = $value['rpi_img'];
                    $temp2['info']            = [];
                    $temp2['Village']         = $maparray[$value['village_census']]['location_name'];
                    $temp2['Taluk']           = $value['taluk_name'];
                    $temp2['District']        = $value['district_name'];
                    $temp2['refid']           = $value['refid'];
                    $temp2['subrd_type']      = $value['subrd_type'];
                    $temp2['subrd_cluster_id']= $value['cluster_id'];

                    // ── Child info array ───────────────
                    // Skip Recommendation, Distance, Cluster Tag when cluster_id = 0
                    $child_has_cluster = ($value['cluster_id'] != 0 && $value['cluster_id'] != '');

                    if ($child_has_cluster) {
                        $temp2['info'][] = ['key' => 'Recommendation',                                'value' => $child_cluster_type,                'type' => 'text'];
                        $temp2['info'][] = ['key' => 'Distance from ' . $child_cluster_hub . ' (km)', 'value' => $value['distance_subrd'] . ' kms.', 'type' => 'text'];
                    }

                    if ($user->client_id != 1000) {
                        $temp2['info'][] = ['key' => 'Population (2025)',    'value' => $value['population'],             'type' => 'text'];
                        $temp2['info'][] = ['key' => 'FMCG Retlr Univ Nos.','value' => $value['retlr_universe'] . ' Nos.', 'type' => 'text'];
                    }
                    if ($user->client_id == 1000 && $value['sector'] == 'Rural') {
                        $temp2['info'][] = ['key' => 'Population (2025)',    'value' => $value['population'],             'type' => 'text'];
                        $temp2['info'][] = ['key' => 'FMCG Retlr Univ Nos.','value' => $value['retlr_universe'] . ' Nos.', 'type' => 'text'];
                    }

                    if ($value['subrd_type'] == 1 && $user->client_id == 120) {
                        $mdlz_label      = ($userid == 13285) ? 'Covrge Nos' : 'MDLZ Cvrg Nos';
                        $temp2['info'][] = ['key' => $mdlz_label, 'value' => $value['mdlz_retlr_universe'] . ' Nos.', 'type' => 'text'];
                    }

                    if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999)
                        $temp2['info'][] = ['key' => 'Villg. Choc Consumption (Annual) (Rs.)', 'value' => $value['village_choc_consmptn'], 'type' => 'text'];
                    if ($user->client_id == 1000 && $value['sector'] == 'Rural')
                        $temp2['info'][] = ['key' => 'Villg. Choc Consumption (Annual) (Rs.)', 'value' => $value['village_choc_consmptn'], 'type' => 'text'];

                    if ($user->client_id == 9999) {
                        $temp2['info'][] = ['key' => 'ATM',              'value' => $value['atm'],     'type' => 'text'];
                        $temp2['info'][] = ['key' => 'Bank',             'value' => $value['bank'],    'type' => 'text'];
                        $temp2['info'][] = ['key' => 'National Highway', 'value' => $value['nh'],      'type' => 'text'];
                        $temp2['info'][] = ['key' => 'State Highway',    'value' => $value['sh'],      'type' => 'text'];
                        $temp2['info'][] = ['key' => 'Railway Station',  'value' => $value['rly_stn'], 'type' => 'text'];
                    }

                    if ($value['rpi_img'] != '')
                        $temp2['info'][] = ['key' => 'Rural Progressive Index', 'value' => $rural_img_child, 'type' => 'img'];

                    if ($child_has_cluster)
                        $temp2['info'][] = ['key' => 'Cluster Tag', 'value' => $child_cluster_tag, 'type' => 'text'];

                    if (in_array($value['subrd_type'], [2, 3]) && $user->client_id == 120) {
                        $temp2['info'][] = ['key' => 'SubRD Priority',         'value' => $value['subrd_priority'], 'type' => 'text'];
                        $temp2['info'][] = ['key' => 'SubRD Cluster Priority', 'value' => $value['subrd_priority'], 'type' => 'text'];
                    }

                    if ($user->client_id == 120)
                        $temp2['info'][] = ['key' => 'Market UID',     'value' => $value['market_id'], 'type' => 'text'];
                    if ($user->client_id != 120 && $user->client_id != 112)
                        $temp2['info'][] = ['key' => 'BI Location ID', 'value' => $value['bi_id'],     'type' => 'text'];

                    if (in_array($value['subrd_type'], [1])) {
                        $temp2['info'][] = ['key' => 'Exist SubRD Code', 'value' => $final_result[$k]['exist_subrd_code'],                       'type' => 'text'];
                        $subrd_name_label = ($userid == 13285) ? 'Exist SubRD' : 'Exist SubRD Name';
                        $temp2['info'][] = ['key' => $subrd_name_label,  'value' => ucwords(strtolower($final_result[$k]['exist_subrd_name'])),   'type' => 'text'];
                    }

                    if ($user->client_id == 112 && in_array($value['subrd_type'], [5])) {
                        $temp2['info'][] = ['key' => 'Exist DBR Code', 'value' => $final_result[$k]['exist_subrd_code'],                         'type' => 'text'];
                        $temp2['info'][] = ['key' => 'Exist DBR Name', 'value' => ucwords(strtolower($final_result[$k]['exist_subrd_name'])),     'type' => 'text'];
                    }

                    // ── Table data row (child) ─────────────────
                    $child_count_row++;
                    $table_data[$vc]['child'][] = [
                        'row_id'              => $child_count_row,
                        'subrd_cluster_id'    => $value['cluster_id'],
                        'district_name'       => $value['district_name'],
                        'taluk_name'          => $value['taluk_name'],
                        'village_name'        => $maparray[$value['village_census']]['location_name'],
                        'marker_uid'          => $value['market_id'],
                        'distance'            => $value['distance_subrd'],
                        'outlet_potential'    => $value['retlr_universe'],
                        'population'          => $value['population'],
                        'village_consumption' => $value['village_choc_consmptn'],
                        'subrd_priority'      => $value['subrd_priority'],
                        'cluster_type'        => $child_cluster_type,
                        'exist_subrd_code'    => $value['exist_subrd_code'],
                        'exist_subrd_name'    => ucwords(strtolower($value['exist_subrd_name'])),
                        'no_active_location'  => 0,
                        'latitude'            => $value['latitude'],
                        'longitude'           => $value['longitude'],
                        'id'                  => $value['village_census'],
                        'is_hub'              => $value['is_hub'],
                        'subrd_type'          => $value['subrd_type'],
                    ];

                    // ── Map data push (child) ──────────────────
                    $value['activate_status'] = $value['company_service_id'];
                    $value['activate_marker'] = $this->_resolveActivateMarkerUrl((int)$value['company_service_id']);

                    $temp2['size']                 = 8;
                    $temp2['activate_status_icon'] = $value['activate_marker'];
                    $temp2['activate_status']      = $value['activate_status'];
                    $temp2['subrd_status']         = 0;
                    $temp2['exist_subrd_marker']   = '';
                    $temp2['wholesale_marker']     = '';
                    $temp2['urbandistributor_marker'] = '';
                    $temp2['recommand_subrd_marker']  = '';
                    $temp2['subrd_type']           = $value['subrd_type'];
                    $temp2['latitude']             = $maparray[$value['village_census']]['latitude'];
                    $temp2['longitude']            = $maparray[$value['village_census']]['longitude'];
                    $temp2['id']                   = $value['village_census'];

                    $message['data'][] = $temp2;
                }

                $message['tabledata']['value'][] = $table_data[$vc];
            }

        } // end main for loop

        // =====================================================
        // 12. STATUS MESSAGE
        // =====================================================
        $message['message'] = count($message['data']) > 0 ? 'data load success' : 'No data found';
        $message['status']  = count($message['data']) > 0;

        // =====================================================
        // 13. LEGEND  — matches UI panel exactly
        //
        // UI shows:
        //   Recommended SubRD Location : 3    ← total_village  (hub rows of type 2/3)
        //   New Villages               : 247  ← new_village    (spoke children of type 2/3)  [highlighted]
        //   New Villages (Reco Subrd)  : 7    ← new_village_recommand
        //   New Villages (Current Subrd): 240 ← new_village_current
        // =====================================================
        $summary = [
            [
                'label' => 'Recommended SubRD Location',
                'value' => $summary_count['total_village'],
                'style' => 'normal',
            ],
            [
                'label' => 'New Villages',
                'value' => ($summary_count['new_village_current'] + $summary_count['new_village_recommand']) ,
                'style' => 'highlight',      // blue highlighted row in UI
            ],
            [
                'label' => 'New Villages (Reco Subrd)',
                'value' => $summary_count['new_village_recommand'],
                'style' => 'normal',
            ],
            [
                'label' => 'New Villages (Current Subrd)',
                'value' => $summary_count['new_village_current'],
                'style' => 'normal',
            ],
        ];

        $items = [
            ['label' => 'Current/Active SubRD Hub',     'color' => '#7e5a05'],
            ['label' => 'Current/Active Villg.',        'color' => '#e4ab59'],
            ['label' => 'New Villg for Current SubRD',  'color' => '#fcff00'],
           // ['label' => 'Newly Activated SubRD Hub',    'color' => '#2184a5'],
          //  ['label' => 'Newly Activated Spoke Villg.', 'color' => '#00EFFF'], 
        ];

        $notes = [
            ['label' => 'Other Dark Color(s)',       'value' => 'Recommended SubRD Hub Location'],
            ['label' => 'Ligher Shade of Same Color','value' => 'New Spoke Locations belonging to that Hub'],
        ];

        $message['legend'] = [
            'summary' => $summary,
            'items'   => $items,
            'notes'   => $notes,
        ];

        // =====================================================
        // 14. ACTION LIST
        // =====================================================
        $message['action_list'] = [
            ['name' => 'Exist Subrd Hub',       'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png'],
            ['name' => 'Urban Distributor Hub', 'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/urban-distributor.png'],
            ['name' => 'Recommanded Subrd Hub', 'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/recommendation.png'],
            ['name' => 'Wholesale',             'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/Wholesale.png'],
            ['name' => 'Active',                'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/active.png'],
            ['name' => 'RPI',                   'img' => 'https://analytics.brandidea.com/bilocaview/public/rural_icon/rpi-overlay.png'],
        ];

        return response()->json($message, 200);

    } catch (\Exception $e) {
        $message['status']  = false;
        $message['message'] = $e->getMessage();
        return response()->json($message, 500);
    }
}


// =============================================================
// PRIVATE HELPER
// =============================================================

/**
 * Returns full URL for activate marker icon.
 */
private function _resolveActivateMarkerUrl($id)
{
    $base = 'https://analytics.brandidea.com/bilocaview/public/rural_icon/';

    switch ($id) {
        case 1:
            return $base . 'active.png';

        case 2:
            return $base . 'initiated.png';

        case 3:
            return $base . 'deactivated.png';

        case 4:
            return $base . 'activated.png';

        case 5:
            return $base . 'deactivated.png';

        default:
            return '';
    }
}
   public function getsubrd_details(Request $request)
   {
        $input = $request->all();
        $subrd_id=$input['subrd_id'];

        $result=DB::table('subrd_data')->select( "refid", "cluster_id", "cluster_name", "state_name", "district_name", "taluk_name", "village_name", "rpi", "rpi_id", "sector", "sector_code", "loc7", "loc9", "loc10", "loc13", "loc12", "market_id", "bi_id", "distance_subrd", "subrd_loaction", "retlr_universe", "mdlz_retlr_universe", "outlet_potential", "population", "state_census", "district_census", "taluk_census", "village_census", "village_choc_consmptn", "cluster_tag", "stat", "active_stat", "subrd_type",  "is_hub", "subrd_priority", "tsm_id", "village_2011_census", "company_service_id", "exist_subrd_code", "exist_subrd_name", "hub_id")->where([['refid','=',$subrd_id]])->get();
        $parent_result=DB::table('subrd_data')->select( "subrd_priority")->where([['cluster_id','=',$result[0]->cluster_id],['is_hub','=',1],['subrd_type','=',$result[0]->subrd_type]])->get();
      

        $subrd_details=[];

        for($k=0;$k<count($result);$k++)
        {
              $cluster_tag=($result[$k]->subrd_type==1) ? 'Existing' :(($result[$k]->subrd_type==2) ? 'Recommanded' :(($result[$k]->subrd_type==3) ?'Wholesaler' : ''));
              array_push($subrd_details,['id'=>'Cluster ID','value'=>$result[$k]->cluster_id]);
              array_push($subrd_details,['id'=>'State Name','value'=>$result[$k]->state_name]);
              array_push($subrd_details,['id'=>'Distt. Name','value'=>$result[$k]->district_name]);
              array_push($subrd_details,['id'=>'Sub Distt. Name','value'=>$result[$k]->taluk_name]);
              array_push($subrd_details,['id'=>'Town / Village Name','value'=>$result[$k]->village_name]);
              array_push($subrd_details,['id'=>'Market UID','value'=>$result[$k]->market_id]);
              array_push($subrd_details,['id'=>'BI Locatn ID','value'=>$result[$k]->bi_id]);
              array_push($subrd_details,['id'=>'Village Census','value'=>$result[$k]->village_census]);
              array_push($subrd_details,['id'=>'Distance from Recmmd SubRD / Wholesale Locatn (Km)','value'=>$result[$k]->distance_subrd]. ' kms.');
              array_push($subrd_details,['id'=>'Outlet potential','value'=>$result[$k]->outlet_potential]);
              array_push($subrd_details,['id'=>'Population 2025','value'=>$result[$k]->population]);
              array_push($subrd_details,['id'=>'Village Chocolate Consmptn (Rs.)','value'=>$result[$k]->village_choc_consmptn]);
              array_push($subrd_details,['id'=>'Cluster Tag','value'=>$cluster_tag]);
              array_push($subrd_details,['id'=>'SubRD Priority','value'=>$result[$k]->subrd_priority]);

              if($parent_result->count() > 0)
            array_push($subrd_details,['id'=>'SubRD Cluster Priority','value'=>$parent_result[0]->subrd_priority]);
              else
                array_push($subrd_details,['id'=>'SubRD Cluster Priority','value'=>'']);

        }
         $message=['status'=>true,'message'=>'subrd details loaded'];

         $message['data']=$subrd_details;
       
       return response()->json($message, $this->successStatus);
       
   }
   /**
    * details api
    *
    * @return \Illuminate\Http\Response
    */

   public function getDetails()
   {
       $user = Auth::user();
       echo $user->id;
       return response()->json(['success' => $user], $this->successStatus);
   }

   public function getarray($arrayofobj)
    {
       $arrayofobj = array_map(function ($arrayofobj) {
                return (array)$arrayofobj;
            }, $arrayofobj);
       return $arrayofobj;
    }

    public  function getcolor_bysubrd($color)
    {


            switch($color)
             {
                
                    case "yellow":
                           $FillColor = '#fcff00';
                           break;

                    case "d_lblue": //For Active RD Hub
                            $FillColor = '#5784b4';
                            break;


                    case "l_lblue": //For Active RD child
                            $FillColor = '#b3deee';
                            break;


                    case "d_grey": //For Active SubRD Hub
                            $FillColor = '#908d8e';
                            break;


                    case "l_grey": //For Active SubRD child
                            $FillColor = '#d3d3d3';
                            break;
                    

                    case "d_green":
                            $FillColor = '#01875b'; //5CDB94
                            break;
                            
                    case "l_green":
                            $FillColor = '#01ea9e'; //5CDB94
                            break;
                            
                    case "d_blue":
                            $FillColor = '#373784';
                            break;
                            
                    case "l_blue":
                            $FillColor = '#7777ee';
                            break;
                    
                    case "d_lavender":
                            $FillColor = '#982dc5';
                            break;
                            
                    case "l_lavender":
                            $FillColor = '#c18ad8';
                            break;
                    
                    case "d_pink":
                            $FillColor = '#D01176'; //0xFF66CC //CD4457
                            break;
                    
                    case "l_pink":
                            $FillColor = '#f16bb2'; //0xFF66CC //CD4457
                            break;
                    
                    case "d_orange":
                            $FillColor = '#FF8000';
                            break;
                    
                    case "l_orange":
                            $FillColor = '#ffab79';
                            break;
                            
                    case "d_fgreen":
                            $FillColor = '#43CB00';
                            break;
                    
                    case "l_fgreen":
                            $FillColor = '#91FF1D';
                            break;
                            
                    case "d_chaani":
                            $FillColor = '#666633';
                            break;
                            
                    case "l_chaani":
                            $FillColor = '#ccff33';
                            break;
                    case "d_red":
                             $FillColor='#f2020a';
                             break;
                    case 'l_red':
                             $FillColor='#f56c70';
                             break;

                        case "l_goldbrown": //For Active SubRD child
                        $FillColor = '#fad39b';
                        break;

                 case "d_goldbrown": //For Active SubRD child
                        $FillColor = '#7e5a05';
                         break;

                    default:
                          $FillColor = '#ffffff';
             }
     return $FillColor;
    }
   
     public function village_no_rla(Request $request)
   {
       $message=[];
       $message=['maplist'=>[],'mapdata'=>[],'tabledata'=>['column'=>['#','Distt. Name','Sub-Distt. Name','Town / Village Name','Market UID','Outlet Potential (Nos.)','Population (Nos.)','Consmption (Annual) (Rs.)','Exist SubRD Code','Exist SubRD Name','Nearest RD'],'value'=>[]]];
       $input = $request->all();
       $user = Auth::user();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $view_type=$input['view_type']; //1-district 2-taluk
       if(isset($input['district_id']) || isset($input['taluk_id']))
        $id=(isset($input['district_id'])) ? explode(",",$input['district_id']) : (isset($input['taluk_id']) ? explode(",",$input['taluk_id']) :[0]);
      
       $maparray=[];$str='';
       $summary_count=[];
       $summary_count['Develpd']=0;
       $summary_count['Most Develpd']=0;
       $summary_count['Under-develpd']=0;
       $summary_count['Transition']=0;
       $summary_count['Not Rated']=0;
       $summary_count['total_village']=0;
       $summary_count['new_village']=0;
       $summary_count['show_summary']=0;
      
        $orwhere=[];
       if($view_type==1)
            array_push($orwhere,"loc9 in (".implode(",",$id).")");
       if($view_type==2)
            array_push($orwhere,"taluk_code in (".implode(",",$id).")");

       $level_id=0;
       $level_id=($view_type==2) ? 10 : 7;
        $map_level = DB::table("map_level")->where("refid", $level_id)->select(["refid", "map_label","main_location","sub_location","sub_location_temp","suffix","child"])->first();
        //  $geo_level = DB::table("Geo_Hrchy_master")->where("refid", $map_level->sub_location)->select(["geo_level", "name1", "name2", "master_table"])->first();
        //  $geo_table = DB::table("Geo_Hrchy_master")->where("refid", $map_level->main_location)->select([ "geo_level","name1","name2", "master_table","table_name"])->first();
        //$subname_table = DB::table("map_level")->where([ ["main_location", $map_level->main_location],["sub_location", $map_level->sub_location]])->select(["map_label"])->first();
      $sql="SELECT   loc7, loc9,refid as loc_id,town_village_code as village_census,if(sector='Rural',concat(town_village_name,' ','Villg.'),if(sector='Urban',concat(town_village_name,' ','Town'),town_village_name)) as location_name,latitude,longitude,0 as nxt_mp_level,taluk_code FROM `town_village_polygon` where stat='A' and  (".join(" or ",$orwhere).")";
      
      $res = DB::select(DB::raw($sql));

      for ($i_ = 0; $i_ < count($res); $i_++) {
        if($res[$i_]->loc7 != 0 && $res[$i_]->loc9 != 0)
        {
            $level_info=['loc7'=>$res[$i_]->loc7,'loc9'=>$res[$i_]->loc9];
             $district_info[$res[$i_]->taluk_code]=$res[$i_]->loc9;
        }
                
         $maparray[$res[$i_]->village_census] = [
                "nxt_mp_level" => $res[$i_]->nxt_mp_level,
                "loc_id" => $res[$i_]->village_census,
                "current_level" => 7,
                "main_location" => $map_level->main_location,
                "sub_location" => $map_level->sub_location,
                "location_name" =>
                    $res[$i_]->location_name,
                "latitude" => $res[$i_]->latitude,
                "longitude" => $res[$i_]->longitude,
                "loc7" => $res[$i_]->loc7,
                "loc9" => $res[$i_]->loc9,
               
            ];
                   
      }
      //$subname = $subname_table->map_label;
      $level_info_=[];$load_file_list=[];
      if($view_type==2)
        {
             $sql_code="Select  loc7,loc9,taluk_code as taluk_id from town_village_polygon where taluk_code in (".implode(",",$id).") and stat='A'";
            $res_code = DB::select(DB::raw($sql_code));
            $level_info_=[];
            for($m=0;$m<count($res_code);$m++)
            {
                        $level_info_[$res_code[$m]->taluk_id]=['state_id'=>$res_code[$m]->loc7,'district_id'=>$res_code[$m]->loc9];
            }


             for($i=0;$i<count($id);$i++){

              $taluk_id=ltrim($id[$i], 0);
              $loadmap ="mapshapes/district_taluk/" .$level_info_[$taluk_id]['state_id'] ."/" .$level_info_[$taluk_id]['district_id']."/".$taluk_id ."_" . $map_level->main_location ."_" . $map_level->sub_location .".geojson";
               if (!in_array($loadmap, $load_file_list)) {
                    array_push($load_file_list, $loadmap);
                    $location_level_id = $res[$i]->loc_id;
                    $path = "https://analytics.brandidea.com/" . $loadmap;
                    array_push($message["maplist"], $path);
                }
           }
        }
          if($view_type==1)
            {
                $sql_code="Select  loc7,loc9 from town_village_polygon where loc9 in (".implode(",",$id).")";
                $res_code = DB::select(DB::raw($sql_code));
                $level_info_=[];
                for($m=0;$m<count($res_code);$m++)
                {
                            $level_info_[$res_code[$m]->loc9]=$res_code[$m]->loc7;
                }



                for($i=0;$i<count($id);$i++){
                 $loadmap ="mapshapes/district_village/" .$level_info_[$id[$i]] ."/" .$id[$i] ."_" .$map_level->main_location ."_" .$map_level->sub_location .".geojson";
                    
                        if (!in_array($loadmap, $load_file_list)) {

                        array_push($load_file_list, $loadmap);
                        $location_level_id = $res[$i]->loc_id;
                        $path = "https://analytics.brandidea.com/" . $loadmap;
                        array_push($message["maplist"], $path);

                    }

               }
            }

       $orwhere=[];

       if($view_type==1)
        array_push($orwhere,"  a.loc9 in (".implode(",",$id).")");
       if($view_type==2)
        array_push($orwhere,"  a.taluk_census in (".implode(",",$id).")");

        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
        $sql="select a.refid, a.loc7, a.loc9, a.loc10, a.loc12, a.loc13, a.loc14, a.state_census, a.district_census, a.taluk_census, a.village_census, a.taluk_name, a.branch, a.bsm_area, a.bsm_area_1, a.state as state_name, a.district_name, a.asm_area, a.so_territory, a.rd_code, a.nearest_rd_code, a.nearest_rd_distance, a.nearest_sst_code, a.nearest_sst_distance, a.tsi_uid, a.tsi_code, a.tsi_name, a.subrd_code, a.subrd_name, a.subrd_loc14, a.subrd_latitude, a.subrd_longitude, a.subrd_under_subERP, a.silk_opened, a.beat_pjp_uploaded, a.beat_UID, a.beat_name, a.market_UID, a.village_code_1, a.village_name, a.sector, a.latitude, a.longitude, a.population, a.fmcg_retlr_universe, a.consumption, a.rural_progressive_index,  a.villg_population, a.visicooler_ols, a.ws_outlets, a.total_ols_billed, a.total_village_value_billed, a.current_month_frequency_of_visit, a.month_1_frequency_of_visit, a.month_2_frequency_of_visit, a.total, a.l3m_visited, a.total_village, a.planned_beat_pjp, a.pop_bucket, a.village_status, a.village_type, a.rla_in_villg_but_not_reflecting_in_pro_report, a.rla_in_rural_sales_report, a.subrd_status, a.stat,if(rural_progressive_index='Transition','T',if(rural_progressive_index='Develpd','D',if(rural_progressive_index='Most Develpd','MD',if(rural_progressive_index='Under-Develpd','UD',if(rural_progressive_index='Not Rated','NR',''))))) as rpi_img,if(rural_progressive_index='Transition','T',if(rural_progressive_index='Develpd','D',if(rural_progressive_index='Most Develpd','MD',if(rural_progressive_index='Under-Develpd','UD',if(rural_progressive_index='Not Rated','NR',''))))) as rpi_name FROM mdlz_village_with_zero_rla as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";
      $result = DB::select(DB::raw($sql));
      $result=$this->getarray($result);
      
      $taluk_name=array_column($result,'taluk_name');
      $taluk_name=array_unique($taluk_name);
      $district_name=array_column($result,'district_name');
      $district_name=array_unique($district_name);
      $table_data=[];
      $message['mapdata']=[];
      $result_count=count($result);
    
         for($k=0;$k<$result_count;$k++)
         {
         //   $temp=$final_result[$k];
          
             $temp=$result[$k];
             $temp['color']='red';
             $rural_img=($result[$k]['rpi_img'] == '') ? '' : 'https://analytics.brandidea.com/bilocaview/public/rural_icon/'.$result[$k]['rpi_img'].'.jpg';
            
             $temp['rpi']=$result[$k]['rpi_img'];
             $temp['info']=[];
             $temp['Village']=$maparray[$result[$k]['village_census']]['location_name'];
             $temp['Taluk']=$result[$k]['taluk_name'];
             $temp['District']=$result[$k]['district_name'];
             $temp['refid']=$result[$k]['refid'];


    

        array_push($temp['info'],['key'=>'Population (2025)','value'=>number_format($result[$k]['population'],0),'type'=>'text']);
        array_push($temp['info'],['key'=>'FMCG Retlr Univ Nos.','value'=>$result[$k]['fmcg_retlr_universe'],'type'=>'text']);
        array_push($temp['info'],['key'=>'Consumption (Annual) (Rs.)','value'=>$result[$k]['consumption'],'type'=>'text']);
    if($result[$k]['rpi_img']!='')
        array_push($temp['info'],['key'=>'Rural Progressive Index','value'=>$rural_img,'type'=>'img']);
    
        array_push($temp['info'],['key'=>'Exist SubRD Code','value'=>$result[$k]['subrd_code'],'type'=>'text']);
        array_push($temp['info'],['key'=>'Exist SubRD Name','value'=>ucwords(strtolower($result[$k]['subrd_name'])),'type'=>'text']);
        array_push($temp['info'],['key'=>'Nearest RD','value'=>ucwords(strtolower($result[$k]['rd_code'])),'type'=>'text']);

      $table_data[$result[$k]['village_census']]=[];
    
      $table_data[$result[$k]['village_census']]['row_id']=$k+1;
    
   
     $table_data[$result[$k]['village_census']]['district_name']=$result[$k]['district_name'];
     $table_data[$result[$k]['village_census']]['taluk_name']=$result[$k]['taluk_name'];
     $table_data[$result[$k]['village_census']]['village_name']=$maparray[$result[$k]['village_census']]['location_name'];
      $table_data[$result[$k]['village_census']]['marker_uid']=$result[$k]['market_UID'];
      
      $table_data[$result[$k]['village_census']]['outlet_potential']=number_format($result[$k]['fmcg_retlr_universe'],0);
      $table_data[$result[$k]['village_census']]['population']=number_format($result[$k]['population'],0);
      $table_data[$result[$k]['village_census']]['village_consumption']=$result[$k]['consumption'];
      $table_data[$result[$k]['village_census']]['exist_subrd_code']=$result[$k]['subrd_code'];
      $table_data[$result[$k]['village_census']]['exist_subrd_name']=ucwords(strtolower($result[$k]['subrd_name']));
      array_push($message['tabledata']['value'],$table_data[$result[$k]['village_census']]);

    

     $temp['size']=15;
     
     $temp['latitude']=$maparray[$result[$k]['village_census']]['latitude'];
     $temp['longitude']=$maparray[$result[$k]['village_census']]['longitude'];
     $temp['id']=$result[$k]['village_census'];
     $data=$temp;
     array_push($message['mapdata'],$data);

      
         
         }
         //$message['mapdata']=$maparray;


         $message['legend']=[];
         $message['action_list']=[];
        

      

       return response()->json($message, $this->successStatus);
       
   }
       public function khoj_village_no_rla(Request $request)
   {
       $message=[];
       $message=['maplist'=>[],'mapdata'=>[],'tabledata'=>['column'=>['#','Distt. Name','Sub-Distt. Name','Town / Village Name','SubRD Code','SubRD Name','TSI UID','TSI Code','Market UID','Villg. With Zero RLA (Active / Inactive)','Distance from Recmmd SubRD Locatn (km)','Outlet Potential (Nos.)','Population (Nos.)'],'value'=>[]]];
       $input = $request->all();
       $user = Auth::user();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $view_type=$input['view_type']; //1-district 2-taluk
       if(isset($input['district_id']) || isset($input['taluk_id']))
        $id=(isset($input['district_id'])) ? explode(",",$input['district_id']) : (isset($input['taluk_id']) ? explode(",",$input['taluk_id']) :[0]);
      
       $maparray=[];$str='';
      
      
        $orwhere=[];

       if($view_type==1)
            array_push($orwhere,"a.loc9 in (".implode(",",$id).")");
       if($view_type==2)
            array_push($orwhere,"taluk_code in (".implode(",",$id).")");
           $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
       

       $level_id=0;
       $level_id=($view_type==2) ? 10 : 7;
        $map_level = DB::table("map_level")->where("refid", $level_id)->select(["refid", "map_label","main_location","sub_location","sub_location_temp","suffix","child"])->first();
       
      $sql="SELECT  a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.tsi_uid,a.tsi_code,a.tsi_name FROM tsi_subrd_data as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A'";
      
      $result = DB::select(DB::raw($sql));
      $result=$this->getarray($result);

       $taluk_name=array_column($result,'taluk_name');
      $taluk_name=array_unique($taluk_name);
      $district_name=array_column($result,'district_name');
      $district_name=array_unique($district_name);
      $table_data=[];
      $message['mapdata']=[];
      $result_count=count($result);

 for($k=0;$k<$result_count;$k++)
 {
 //   $temp=$final_result[$k];
  
     $temp=[];
     $temp['color']='red';
     $rural_img=($result[$k]['rpi_img'] == '') ? '' : 'https://analytics.brandidea.com/bilocaview/public/rural_icon/'.$result[$k]['rpi_img'].'.jpg';

     $temp['rpi']=$result[$k]['rpi_img'];
     $temp['info']=[];
     $temp['Village']=$result[$k]['village_name'];
     $temp['Taluk']=$result[$k]['taluk_name'];
     $temp['District']=$result[$k]['district_name'];
     $temp['refid']=$result[$k]['refid'];
     $temp['is_hub']=$result[$k]['is_hub'];
     $temp['size']=10;
     $temp['subrd_icon']='https://analytics.brandidea.com/bilocaview/public/rural_icon/mdlz_subrd_purple.png';



    array_push($temp['info'],['key'=>'SubRD Code','value'=>$result[$k]['exist_subrd_code'],'type'=>'text']);
    array_push($temp['info'],['key'=>'SubRD Name','value'=>ucwords(strtolower($result[$k]['exist_subrd_name'])),'type'=>'text']);
    array_push($temp['info'],['key'=>'TSI UID','value'=>$result[$k]['tsi_uid'],'type'=>'text']);
    array_push($temp['info'],['key'=>'TSI Code','value'=>ucwords(strtolower($result[$k]['tsi_code'])),'type'=>'text']);
    array_push($temp['info'],['key'=>'TSI Name','value'=>ucwords(strtolower($result[$k]['tsi_name'])),'type'=>'text']);
    array_push($temp['info'],['key'=>'Market UID','value'=>ucwords(strtolower($result[$k]['market_id'])),'type'=>'text']);

   
      $table_data[$result[$k]['village_census']]=[];
    
      $table_data[$result[$k]['village_census']]['row_id']=$k+1;
    
    $table_data[$result[$k]['village_census']]['id']=$result[$k]['village_census'];
     $table_data[$result[$k]['village_census']]['district_name']=$result[$k]['district_name'];
     $table_data[$result[$k]['village_census']]['taluk_name']=$result[$k]['taluk_name'];
     $table_data[$result[$k]['village_census']]['village_name']=$result[$k]['village_name'];
       $table_data[$result[$k]['village_census']]['subrd_code']=$result[$k]['exist_subrd_code'];
      $table_data[$result[$k]['village_census']]['subrd_name']=ucwords(strtolower($result[$k]['exist_subrd_name']));
      $table_data[$result[$k]['village_census']]['tsi_uid']=$result[$k]['tsi_uid'];
      $table_data[$result[$k]['village_census']]['tsi_code']=$result[$k]['tsi_code'];
      $table_data[$result[$k]['village_census']]['tsi_name']=$result[$k]['tsi_name'];
      $table_data[$result[$k]['village_census']]['Village_with_norla']='Villg. with Zero RLA (Inactive)';
     $table_data[$result[$k]['village_census']]['distance_subrd']=$result[$k]['distance_subrd'];
      $table_data[$result[$k]['village_census']]['outlet_potential']=number_format($result[$k]['mdlz_retlr_universe'],0);
      $table_data[$result[$k]['village_census']]['population']=number_format($result[$k]['population'],0);
    
      array_push($message['tabledata']['value'],$table_data[$result[$k]['village_census']]);

    

     $temp['size']=15;
     
     $temp['latitude']=$result[$k]['latitude'];
     $temp['longitude']=$result[$k]['longitude'];
     $temp['id']=$result[$k]['village_census'];
     $data=$temp;
     array_push($message['mapdata'],$data);

      
         
         }
        $aLegend=[];
  array_push($aLegend,['name'=>0,'value'=>'SubRD Location','color'=>'#fff']);
  array_push($aLegend,['name'=>1,'value'=>'Villgs. with Zero RLA (Activated)','color'=>'#fff']);
   array_push($aLegend,['name'=>2,'value'=>'Villgs. with Zero RLA (Inactive)','color'=>'#fff']);
          $message['legend']=$aLegend;

         $message['action_list']=[];
        

      

       return response()->json($message, $this->successStatus);
   }

 public function getpolygonstatus(Request $request)
 {
    $input = $request->all();

    $user = auth()->user();

    $current_lat = (float) $input['current_lat'];
    $current_lon = (float) $input['current_lon'];

    if ($user->client_id == 112) {

        $sql = "
            SELECT ST_Contains(a.polygon_geo, POINT(?, ?)) AS res
            FROM town_village_polygon a
            JOIN coke_subrd_data_all b
                ON a.town_village_code = b.bi_id
            WHERE b.village_census = ?
            ORDER BY res DESC
            LIMIT 1
        ";

        $result = DB::select($sql, [
            $current_lon,
            $current_lat,
            $input['village_census']
        ]);

    } else {

        $sql = "
            SELECT ST_Contains(a.polygon_geo, POINT(?, ?)) AS res
            FROM town_village_polygon a
            JOIN pepsi_subrd_data b
                ON a.town_village_code = b.bi_id
            WHERE b.bi_id = ?
            ORDER BY res DESC
            LIMIT 1
        ";

        $result = DB::select($sql, [
            $current_lon,
            $current_lat,
            $input['bi_id']
        ]);
    }

    $res = !empty($result) ? (int)$result[0]->res : 0;

    $status=true;
    if($res === 0)
        {
            $status=false;
        }

    return response()->json([
        'status' => $status,
        'res' => $res
       // 'request_data' => $input
    ]);
}

public function saveOutlets(Request $request)
{
    DB::beginTransaction();

    try {

        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $userId = $user->id;
        $formType = $request->form_type;
        $filePath = null;

        // Existing / DBR Status
        $subrdTypeStatus = '';
        if ($request->subrd_type_status == '5') {
            $subrdTypeStatus = 'Dbr';
        } elseif ($request->subrd_type_status == '1') {
            $subrdTypeStatus = 'Existing';
        }

        if ($formType != 'village_suitable') {

            // Upload outlet image
            if ($request->hasFile('outlet_pepsi_image')) {

                $files = $request->file('outlet_pepsi_image');

                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {

                    $filename = $userId . '_' . time() . '.' . $file->getClientOriginalExtension();

                    $destinationPath = public_path(
                        'pepsi/rural/shop_image/'
                    );

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    $file->move($destinationPath, $filename);

                    $filePath = 'pepsi/rural/shop_image/' . $filename;
                }
            }

            $id = DB::table('pepsi_rural_new_outlets')->insertGetId([
                'bi_id'                     => $request->village_bi_id,
                'user_id'                   => $userId,
                'retailer_id'               => 0,
                'outlet_name'               => $request->outlet_name,
                'outlet_type'               => $request->outlet_type_status,
                'state_name'                => $request->state_name,
                'district_name'             => $request->district_name,
                'taluk_name'                => $request->taluk_name,
                'town_village_name'         => $request->village_name,
                'status'                    => 'active',
                'image'                     => $filePath,
                'is_pepsico_stock'          => $request->is_pepsico_status,
                'latitude'                  => $request->village_user_location_lat,
                'longitude'                 => $request->village_user_location_lon,
                'outlet_status'             => $request->outlet_status,
                'visit_notes'               => $request->visit_notes,
                'geo_address'               => $request->geo_address,
                'is_pepsico_stock_channel'  => $request->outlet_stock_from,
                'serviced_new_spoke'        => $request->serviced_new_spoke,
                'existing_DBR'              => $subrdTypeStatus,
                'created_at'                => now(),
               // 'updated_at'                => now(),
            ]);

        } else {

            // Upload DBR image
            if ($request->hasFile('new_dbr_pepsi_image')) {

                $file = $request->file('new_dbr_pepsi_image');

                $filename = $userId . '_' . time() . '.' . $file->getClientOriginalExtension();

                $destinationPath = public_path(
                    'pepsi/rural/shop_image/'
                );

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $filename);

                $filePath = 'pepsi/rural/shop_image/' . $filename;
            }

            $id = DB::table('pepsi_rural_new_dbr')->insertGetId([
                'bi_id'                           => $request->village_bi_id,
                'user_id'                         => $userId,
                'retailer_id'                     => 0,
                'state_name'                      => $request->state_name,
                'district_name'                   => $request->district_name,
                'taluk_name'                      => $request->taluk_name,
                'town_village_name'               => $request->village_name,
                'status'                          => 'active',
                'new_dbr_image'                   => $filePath,
                'latitude'                        => $request->village_user_location_lat,
                'longitude'                       => $request->village_user_location_lon,
                'village_suitable_anchor_status'  => $request->is_Village_suitable_anchor,
                'name_party'                      => $request->name_of_the_party,
                'business_party_deails'           => $request->business_party_deals,
                'party_shortlist_status'          => $request->party_shortlist,
                'cluster_assign_status'           => $request->new_cluster_assign,
                'created_at'                      => now(),
              //  'updated_at'                      => now(),
            ]);
        }

        // Single Log Entry
        DB::table('pepsi_rural_log')->insert([
            'user_id'    => $userId,
            'bi_id'      => $request->village_bi_id,
            'latitude'   => $request->village_user_location_lat,
            'longitude'  => $request->village_user_location_lon,
            'form_name'  => 'Recommend Disbtr form',
            'status'     => 'via mobile app Add',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::commit();

        return response()->json([
            'status'      => true,
            'message'     => 'Saved Successfully',
            'id'          => $id,
            'image'       => $filePath ? asset($filePath) : null,
            'geo_address' => $request->geo_address
        ], 200);

    } catch (\Exception $e) {

        DB::rollBack();

        \Log::error('Save Outlet API Error: ' . $e->getMessage());

        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

}
