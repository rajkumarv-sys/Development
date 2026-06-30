<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class PassportController_28072023 extends Controller
{

   public $successStatus = 200;
   public $filenotfound = 404;
   public $failure =500;

   /**

    * login api

    *

    * @return \Illuminate\Http\Response

    */

   public function login(){

       if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
       {
           $user = Auth::user();

           $token =  $user->createToken('MyApp')->accessToken;

           $userinfo = array( 'status'=>true,'message'=>'Authentication Successful','data' => array('id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'token' => $user->api_token));

           return response()->json($userinfo, $this->successStatus);
       }

       else
       {
         $user=DB::table("users")
                ->select("users.*")
                ->orderBy("users.firstname", "ASC")
                ->get();
         if(count($user) > 0)
            $errorinfo=['status'=>false,'message'=>'Wrong Password','data'=>[]];
         else
            $errorinfo=['status'=>false,'message'=>'No user Exists.','data'=>[]];

           return response()->json(['error'=>'Unauthorised'], 401);
       }

   }



   /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */

   public function register(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'name' => 'required',
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
       $success['name'] =  $user->name;

       return response()->json(['success'=>$success], $this->successStatus);

   }



   /**
    * details api
    *
    * @return \Illuminate\Http\Response
    */

   public function getDetails()

   {
       $user = Auth::user();
       return response()->json(['success' => $user], $this->successStatus);
   }


   public function getstates(Request $request)
   {
       $user = $request->uid;
       $user = 666;
       $states = array( 'data' => array ( array("id"=>31, "name"=>"Tamil Nadu"), array("id"=>18, "name"=>"Kerala"), array("id"=>17, "name"=>"Karnataka"), array("id"=>2, "name"=>"Andhra Pradesh"), array("id"=>21, "name"=>"Maharashtra") ), 'status' => true, 'message' => 'States Listing Successful');
       return response()->json($states, $this->successStatus);
   }

}
