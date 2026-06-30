<?php

namespace App\Http\Controllers;

use App\Models\MasterKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\CategoryshareController;
use Illuminate\Support\Facades\Hash;

use App\User; 
use DB;
//#b4I3d2b12012$
date_default_timezone_set("Asia/Kolkata");

class DashboardController extends Controller
{
    private $low=[5,69,54];
    private $high=[151,83,34];
    private $isolate=[166, 63, 26];
    private $low_town=[0,0,100];
    private $high_town=[241, 41, 36];  
    private $isolate_town=[241, 41, 36];
    public function index(Request $request)
    {
            // Log all request data
             //\Log::info('Request Data:', $request->all());
         if (!isset(auth()->user()->id))
         {
             return Redirect::to("/auth/login")->with(
                    "message",
                    "You are not an existing user. Please contact the admin team."
                );
         } 
        //$bi_id = session('bi_id');
        
        //\Log::info('biid'.$bi_id);
       /*$user=DB::table('users')->where([['id','=',21046]])->get();
        for($k=0;$k<count($user);$k++)
         {
             $generated_string = "";$n=8;
    
           
            $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            
            
            $len = strlen($domain);
            
           
            for ($i = 0; $i < $n; $i++)
            {
                
                $index = rand(0, $len - 1);
                
                // // Concatenating the character 
                // // in resultant string
                 $generated_string = $generated_string . $domain[$index];
            }
            $hashed = Hash::make($generated_string);
           //  $hashed = Hash::make('bi');
        
             DB::table('users')
                 ->where('id',$user[$k]->id)
                 ->update(['password' => $hashed,'readable_password'=>$generated_string]);

             echo $user[$k]->id.' '.$hashed.' '.$generated_string;
        }
        die;*/
 
        $user = auth()->user();
        $tbl='';
         $tbl='nestle';


         
         // \Log::info($split_color);
   
        if (isset(auth()->user()->status) && auth()->user()->status == "Active") {
            $stat = auth()->user()->status;
            $user = auth()->user();
            $userid = $user->id;
            $packageid = $user->package_id;
            $reports_to = DB::table("users")
                ->where([
                    ["reports_to", "=", $userid],
                    ["status", "=", "Active"],
                ])
                ->select("users.*")
                ->orderBy("users.firstname", "ASC")
                ->get();
            $channel_list = [];
            $beat_list = [];
            $subchannel_list = [];
            $channel_ids = [];
            $district_list = [];
            $taluk_list = [];
             $whole_sale_taluk_list = [];
             $zero_taluk_list=[];
            $highway_list=[];
            $subrd_beat=[];
            $user_state=[];
            $taluk_state_list=[];
            $user_district=[];
            $SST_beat=[];
            $city_master=[];
            $city_list=[2=>[],3=>[]];
            $calendar=[];
            $revenue=[];
            $state_list=[];
            $village_state_list=[];
            $perfetti_city_master=[];
            $college_data=[];
            $outlet_state_list =[];
            $village_state_list=[];
            $statehighway_list=[];$ckmaster_beat=[];$sst_state_beat=[];
            $consolidate_taluk_list=[];
            $pepsi_rural_new_outlets=[];
            $login_type_mdlz=Auth::user()->login_type_mdlz;
            //echo "<pre>";
          // print_r($user_state);

             if($user->client_id==999)
              {
                   $city_detail=DB::table('dabar_and_coloba_biotique')->select('loc15 as ward_id','ward');
               
                $city_detail=$city_detail->distinct()->get()->toArray();
                 for($i=0;$i<count($city_detail);$i++)
                  {
                       $city_master[$city_detail[$i]->ward_id]=$city_detail[$i]->ward;
                  }
            }
            if($user->client_id==97)
              {
                   $city_detail=DB::table('ckpl_uncvrd_outlets')->select('city_id as city_id','city');
               
                $city_detail=$city_detail->distinct()->get()->toArray();
                 for($i=0;$i<count($city_detail);$i++)
                  {
                       $city_master[$city_detail[$i]->city_id]=$city_detail[$i]->city;
                  }
            }
            if($user->client_id==97)
            {
                  $channel_list = DB::table("ckpl_uncvrd_outlets")
                   // ->where([["client_id", "=", $user->client_id]])
                    ->distinct()
                    ->get(["type as main_type", "type as maintype_id","type as data_type"]);
            }
            if ($user->client_id == 100 || $user->client_id == 130) {
                //$channel_list =  DB::table('uncovered_outlets')->whereIn('salesman_id',[$userid])->distinct()->get(['maintype_id','main_type']);
                $channel_list = DB::table("uncovered_outlets")
                   // ->where([["client_id", "=", $user->client_id]])
                    ->distinct()
                    ->get(["maintype_id", "main_type","main_type as data_type"]);
                $subchannel_list = DB::table("j_and_j_channel_master")
                    ->where("stat", "A")
                    ->orderBy("name")
                    ->get(["refid", "name"]);
                $beat_list = DB::table("uncovered_outlets")
                    ->join(
                        "beat_master",
                        "uncovered_outlets.beat_id",
                        "=",
                        "beat_master.id"
                    )
                    ->join(
                        "uncovered_user",
                        "uncovered_outlets.rtlr_id",
                        "=",
                        "uncovered_user.uncovered_id"
                    )
                    ->select("beat_master.id", "beat_master.beat_name")
                    ->whereIn("uncovered_user.user_id", [$userid])
                    ->distinct()
                    ->get()
                    ->toArray();

                $beat_list_2 = DB::table("covered_outlets")
                    ->join(
                        "beat_master",
                        "covered_outlets.beat_id",
                        "=",
                        "beat_master.id"
                    )
                    ->select("beat_master.id", "beat_master.beat_name")
                    ->whereIn("covered_outlets.salesman_id", [$userid])
                    ->distinct()
                    ->get()
                    ->toArray();

                $beat_list = array_unique(
                    array_merge($beat_list, $beat_list_2),
                    SORT_REGULAR
                );

                $channel_ids = DB::table("hul_alsi_maintype_master")
                    ->whereIn("refid", [22, 27, 18, 15, 139])
                    ->distinct()
                    ->get(["refid", "name"]);
            }
            //pepsi enable subred recomendation if 
            else if($user->client_id== 133 && $login_type_mdlz == 'Rural/Urban')
            {
                  $tbllist=[133=>'coke_subrd_data_all',123=>'subrd_data_perfetti',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];
                  $user_state=[];$tsi_id=[];$user_district=[];

                if($user->role=='HO' || $user->role=='' || $user->role=='SM'  || $user->role=='CE' )

                   $tsimaster = DB::table($tbllist[$user->client_id])->select('loc9 as district_id','loc7 as state_id')->distinct()->get()->toArray();  

                else
                  $tsimaster = DB::table("tsi_user_master")->whereIn('refid',[$user->id])->select('district_id','state_id')->distinct()->get()->toArray(); 

                  // \Log::info($tsimaster);  
                for($k=0;$k<count($tsimaster);$k++)
                {
                    if(!in_array($tsimaster[$k]->state_id,$user_state))
                     array_push($user_state,$tsimaster[$k]->state_id);
                    if(!in_array($tsimaster[$k]->district_id,$user_district))
                     array_push($user_district,$tsimaster[$k]->district_id);
                  

                }
               
                    if($user->state_id >0)
                    {
                        $specific_state=$user->state_id;
                        $whereCondition ="and a.loc7 in ($specific_state)";
                    }
                    else
                    {
                            $whereCondition ='';
                    }
                    $tbllist[$user->client_id]='pepsi_subrd_data'; // and b.refid in (".implode(",",$user_state).") 
                    $taluk_list_="select distinct b.refid as state_id,b.location_name as state from ".$tbllist[$user->client_id]." as a,state_master_2011 as b where a.loc7=b.refid $whereCondition   order by b.location_name asc";
                   // \Log::info($taluk_list_);  
                    $taluk_list_ = DB::select(DB::raw($taluk_list_));
                     
       
                //if login this user anandsingh01@coca-cola.com and applied this condition
                    $taluk_list_count=count($taluk_list_);

                    
                    
                    for($i=0;$i<$taluk_list_count;$i++)
                    {
                        $taluk_list[$taluk_list_[$i]->state_id]=$taluk_list_[$i]->state;

                       // \Log::info($taluk_list_[$i]->state);
                    }
                     
                 // \Log::info($tbllist); 
            }//pepsi enable subred recomendation if end

             //White space distributor if start 09-03-2026
             else if($user->client_id== 133 && $user->login_type_mdlz=='')
            {
                 $tbllist=[133=>'pepsi.pepsi_sales',123=>'subrd_data_perfetti',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];
                  $user_state=[];$tsi_id=[];$user_district=[];

                if($user->role=='HO' || $user->role=='' || $user->role=='SM' || $user->role=='CE')

                   $tsimaster = DB::table($tbllist[$user->client_id])->select('loc9 as district_id','loc7 as state_id')->distinct()->get()->toArray();  

                else
                  $tsimaster = DB::table("tsi_user_master")->whereIn('refid',[$user->id])->select('district_id','state_id')->distinct()->get()->toArray(); 

                   // \Log::info($tsimaster);  
                for($k=0;$k<count($tsimaster);$k++)
                {
                    if(!in_array($tsimaster[$k]->state_id,$user_state))
                     array_push($user_state,$tsimaster[$k]->state_id);
                    if(!in_array($tsimaster[$k]->district_id,$user_district))
                     array_push($user_district,$tsimaster[$k]->district_id);
                  

                }
               
                    if($user->state_id >0)
                    {
                        $specific_state=$user->state_id;
                        $whereCondition ="and a.loc7 in ($specific_state)";
                    }
                    else
                    {
                            $whereCondition ='';
                    }
                    //$tbllist[$user->client_id]='pepsi_subrd_data'; // and b.refid in (".implode(",",$user_state).") 
                    $taluk_list_="select distinct b.refid as state_id,b.location_name as state from ".$tbllist[$user->client_id]." as a,state_master_2011 as b where a.loc7=b.refid $whereCondition   order by b.location_name asc";
                   // \Log::info($taluk_list_);  
                    $taluk_list_ = DB::select(DB::raw($taluk_list_));


                    $taluk_list_count=count($taluk_list_);
                    for($i=0;$i<$taluk_list_count;$i++)
                    {
                        $taluk_list[$taluk_list_[$i]->state_id]=$taluk_list_[$i]->state;

                       // \Log::info($taluk_list_[$i]->state);
                    }
            }
             //White space distributor if end - 09-03-2026

             else if($user->client_id==112 || $user->client_id==123 || $user->client_id==1000 || $user->client_id==9999 )
             {
                 //\Log::info( $user->client_id);
                   if($user->client_id==112)
                   {
                       $state_list_data = DB::table("coke_whlslrs")->select('State')->distinct()->get()->toArray(); 

                                    for($k=0;$k<count($state_list_data);$k++)
                                         array_push($state_list,$state_list_data[$k]->State);

                        if($user->role!='')
                          $channel_list = DB::table("coke_whlslrs") ->distinct()->get(["sub_type as  maintype_id", "sub_type as main_type","sub_type as data_type"]);
                        else
                          $channel_list = DB::table("colleges_nearby_fmcg_stores") ->distinct()->get(["sub_type as  maintype_id", "sub_type as main_type","sub_type as data_type"]);
                        $college_data = DB::table("colleges_nearby_fmcg_stores") ->distinct()->orderBy('state_name', 'ASC')
                          ->get(["loc7 as  maintype_id", "loc7 as main_type","state_name as data_type"]);


                            $subr_1="";
                            $highway_list_="select distinct b.refid as state_id,b.location_name as state from highway_structure as a ,state_master as b  where a.state_id=b.refid $subr_1 order by b.location_name asc";
                            $highway_list_ = DB::select(DB::raw($highway_list_));
                            $highway_list_count=count($highway_list_);
                              //\Log::info("highway",$highway_list_);
                            
                            for($i=0;$i<$highway_list_count;$i++)
                            {
                                $highway_list[$highway_list_[$i]->state_id]=$highway_list_[$i]->state;
                            }
                            $statehighway_list_="select distinct b.refid as state_id,b.location_name as state from state_highway_structure as a ,state_master as b where a.state_id=b.refid $subr_1 order by b.location_name asc";
                            $statehighway_list_ = DB::select(DB::raw($statehighway_list_));
                            $statehighway_list_count=count($statehighway_list_);
                        
                            for($i=0;$i<$statehighway_list_count;$i++)
                            {
                                $statehighway_list[$statehighway_list_[$i]->state_id]=$statehighway_list_[$i]->state;
                            }
                                
                   }

                   if($user->client_id==123) 
                   {
                      $channel_list = DB::table('perfetti_uncovered_outlets')
                    ->where([["status", "!=", "D"]])
                    ->distinct()
                    ->get(["type as maintype_id", "type as main_type","type as data_type"]);
                  $beat_list = DB::table("perfetti_whole")
                    ->join(
                        "beat_master",
                        "perfetti_whole.beat_id",
                        "=",
                        "beat_master.id"
                    )
                    ->select("beat_master.id", "beat_master.beat_name")
                    ->orderBy("beat_master.beat_name")
                    ->distinct()
                    ->get()
                    ->toArray();
                   $city_detail=DB::table('perfetti_whole')->select('city_id','city');
               
                        $city_detail=$city_detail->distinct()->get()->toArray();
                        for($i=0;$i<count($city_detail);$i++)
                        {
                            $city_master[$city_detail[$i]->city_id]=$city_detail[$i]->city;
                        }
                        $perfetti_city_detail=DB::table('perfetti_uncovered_outlets')->select('city_id','city');
                    
                        $perfetti_city_detail=$perfetti_city_detail->distinct()->get()->toArray();
                            for($i=0;$i<count($perfetti_city_detail);$i++)
                            {
                                $perfetti_city_master[$perfetti_city_detail[$i]->city_id]=$perfetti_city_detail[$i]->city;
                            }
                        }                    
                   
                    // $tbllist=[112=>'coke_subrd_data',123=>'subrd_data_perfetti',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];

                    if($user->id == 13947 || $user->id == 21036 || $user->id == 21037 || $user->id == 21038 || $user->id == 21039 || $user->designation == 'ASM') 
                        {
                            $tbllist=[112=>'coke_subrd_data_all',123=>'subrd_data_perfetti',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];
                            // \Log::info($tbl_arr);
                        }
                        else
                        {
                            $tbllist=[112=>'coke_subrd_data',123=>'subrd_data_perfetti',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars',133=>'pepsi_subrd_data'];
                        }
                        $user_state=[];$tsi_id=[];$user_district=[];
                        if($user->role=='HO' || $user->role=='' || $user->role=='SM')
                        $tsimaster = DB::table($tbllist[$user->client_id])->select('loc9 as district_id','loc7 as state_id')->distinct()->get()->toArray();  

                        else
                        $tsimaster = DB::table("tsi_user_master")->whereIn('refid',[$user->id])->select('district_id','state_id')->distinct()->get()->toArray(); 

                      
                        for($k=0;$k<count($tsimaster);$k++)
                        {
                            if(!in_array($tsimaster[$k]->state_id,$user_state))
                            array_push($user_state,$tsimaster[$k]->state_id);
                            if(!in_array($tsimaster[$k]->district_id,$user_district))
                            array_push($user_district,$tsimaster[$k]->district_id);
                        

                        }
                        \Log::info("raj",$user_state);
      //
                         $taluk_list_="select distinct b.refid as state_id,b.location_name as state from ".$tbllist[$user->client_id]." as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70,18)   and b.refid in (".implode(",",$user_state).")  order by b.location_name asc";
                         $taluk_list_ = DB::select(DB::raw($taluk_list_));

                            //if login this user anandsingh01@coca-cola.com and applied this condition
                       \Log::info($taluk_list_);
                        if($user->id == 13947 || $user->id == 21036 || $user->id == 21037 || $user->id == 21038 || $user->id == 21039 || $user->designation == 'ASM')
                        {
                            if($user->state_id >0)
                            {
                                $specific_state=$user->state_id;
                                $whereCondition ="and a.loc7 in ($specific_state)";
                            }
                            else
                            {
                                    $whereCondition ='';
                            }
                            $tbllist[$user->client_id]='coke_all_state'; // and b.refid in (".implode(",",$user_state).") 

                            $taluk_list_="select distinct b.refid as state_id,b.location_name as state from ".$tbllist[$user->client_id]." as a,state_master_2011 as b where a.loc7=b.refid $whereCondition   order by b.location_name asc";
                            $taluk_list_ = DB::select(DB::raw($taluk_list_));

                            
                        //  \Log::info($taluk_list_);
                        }                      
                       //if login this user anandsingh01@coca-cola.com and applied this condition
                        $taluk_list_count=count($taluk_list_);
                        
                        for($i=0;$i<$taluk_list_count;$i++)
                        {
                            $taluk_list[$taluk_list_[$i]->state_id]=$taluk_list_[$i]->state;
                        }



                
            }

             elseif ($user->client_id == 120) {
                 if(strtotime($user->expire_date) < strtotime(date('d-m-Y')) )
               {
                     return Redirect::to("/auth/login")->with(
                    "message",
                    "Your license has expired. Kindly contact admin."
                );
                }
                
                $user_state=[];$tsi_id=[];$user_district=[];$SST_beat=[];$beat=[];
                if($user->login_type_mdlz=='Urban')
                {
                    $tsimaster = DB::table("tsi_user_master")->whereIn('refid',[$user->id])->select('beat_id')->distinct()->get()->toArray(); 

                                    for($k=0;$k<count($tsimaster);$k++)
                                        array_push($beat,$tsimaster[$k]->beat_id);
                }
        

        $city_detail=DB::table('mdlz_rd_outlets')->select('city_id','city')->whereIn('city_id',[13346]);
        if(count($beat)>0)
        $city_detail=$city_detail->whereIn('beat_id',$beat);
        $city_detail=$city_detail->distinct()->get()->toArray();
         for($i=0;$i<count($city_detail);$i++)
          {
               $city_master[$city_detail[$i]->city_id]=$city_detail[$i]->city;
          }
                $user_detail=[];
                if($user->role=='tsi')
                {
                    $tsi_id=[$user->id];
                }
                else{

                   if($user->role=='SE')                
                     $user_detail=DB::table('users')->select('id')->where([['se_id','=',$user->id]])->get()->toArray();
                    if($user->role=='ASM')
                     $user_detail=DB::table('users')->select('id')->where([['asm_id','=',$user->id]])->get()->toArray();
                    if($user->role=='BSM')
                     $user_detail=DB::table('users')->select('id')->where([['bsm_id','=',$user->id]])->get()->toArray();
                   if($user->role=='SOE')
                     $user_detail=DB::table('users')->select('id')->where([['soe_id','=',$user->id]])->get()->toArray();
                    if($user->role=='BM' || $user->role=='RSOM' || $user->role=='HO' )
                     $user_detail=DB::table('users')->select('id')->where([['client_id','=',$user->client_id],['status','=','Active']])->get()->toArray();

                  for($i=0;$i<count($user_detail);$i++)
                  {
                      array_push($tsi_id,$user_detail[$i]->id);
                  }
                }
               

                if($user->role=='BM' || $user->role=='RSOM' || $user->role=='HO' )
                {
                    $tsimaster = DB::table("subrd_data")->select('loc9 as district_id','loc7 as state_id')->distinct()->get()->toArray(); 

                        for($k=0;$k<count($tsimaster);$k++)
                        {
                            if(!in_array($tsimaster[$k]->state_id,$user_state) && !in_array($tsimaster[$k]->state_id,[8,9,10,18]))
                             array_push($user_state,$tsimaster[$k]->state_id);
                            if(!in_array($tsimaster[$k]->district_id,$user_district))
                             array_push($user_district,$tsimaster[$k]->district_id);
                          

                        }
                }
                else if($user->role!='Country-HO')
                {
                    array_push($tsi_id,$user->id);
                      $tsimaster = DB::table("tsi_user_master")->whereIn('refid',$tsi_id)->select('district_id','state_id')->distinct()->get()->toArray(); 

                        for($k=0;$k<count($tsimaster);$k++)
                        {
                            if(!in_array($tsimaster[$k]->state_id,$user_state)  && !in_array($tsimaster[$k]->state_id,[8,9,10]))
                             array_push($user_state,$tsimaster[$k]->state_id);
                            if(!in_array($tsimaster[$k]->district_id,$user_district))
                             array_push($user_district,$tsimaster[$k]->district_id);
                          

                        }
                        //  var_dump(implode(",",$tsi_id));
                        // var_dump($user_district);die;
                }
               
               if($user->role!='Country-HO' && $user->client_id==120)
               { 

                $subr="";$subr_1="";$subr_2="";
                if($user->role=='BM' || $user->role=='RSOM' || $user->role=='HO' )
                {
                   $subr="";
                   $subr_1="";
                   $subr_2="";
                }
                else
                {
                    $subr=" and  a.loc7 in (".implode(',',$user_state).")";
                    $subr_1=" and  a.state_id in (".implode(',',$user_state).")";
                    $subr_2="and  a.loc7 in (".implode(',',$user_state).")";
                }
                  
                
                 $beat_list = [];
                $subrd_beat_="select  distinct b.location_name as state,b.refid as state_id from subrd_outlet as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70,8,9,10,18) $subr order by b.location_name asc";
              //  \Log::info($subrd_beat_);
                $subrd_beat_ = DB::select(DB::raw($subrd_beat_));
                $subrd_beat_count=count($subrd_beat_);
                 
                for($i=0;$i<$subrd_beat_count;$i++)
                {
                    $subrd_beat[$subrd_beat_[$i]->state_id]=$subrd_beat_[$i]->state;
                }
                 $SST_beat_="select  distinct b.location_name as state,b.refid as state_id from sst_data as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70,8,9,10,18) $subr order by b.location_name asc";
                $SST_beat_ = DB::select(DB::raw($SST_beat_));
                $SST_beat_count=count($SST_beat_);
                 
                for($i=0;$i<$SST_beat_count;$i++)
                {
                    $SST_beat[$SST_beat_[$i]->state_id]=$SST_beat_[$i]->state;
                }
                $highway_list_="select distinct b.refid as state_id,b.location_name as state from highway_structure as a ,state_master as b  where a.state_id=b.refid $subr_1 order by b.location_name asc";
                $highway_list_ = DB::select(DB::raw($highway_list_));
                $highway_list_count=count($highway_list_);
                 
                for($i=0;$i<$highway_list_count;$i++)
                {
                    $highway_list[$highway_list_[$i]->state_id]=$highway_list_[$i]->state;
                }
                 $statehighway_list_="select distinct b.refid as state_id,b.location_name as state from state_highway_structure as a ,state_master as b where a.state_id=b.refid $subr_1 order by b.location_name asc";
                $statehighway_list_ = DB::select(DB::raw($statehighway_list_));
                $statehighway_list_count=count($statehighway_list_);
               
                for($i=0;$i<$statehighway_list_count;$i++)
                {
                    $statehighway_list[$statehighway_list_[$i]->state_id]=$statehighway_list_[$i]->state;
                }
                 $sst_state="select distinct b.refid as state_id,b.location_name as state from chattisgarh_sst_van_beats3 as a ,state_master as b where a.state_id=b.refid order by b.location_name asc";
                $sst_state = DB::select(DB::raw($sst_state));
                $sst_state_count=count($sst_state);
                 
                for($i=0;$i<$sst_state_count;$i++)
                {
                    $sst_state_beat[$sst_state[$i]->state_id]=$sst_state[$i]->state;
                }
                $taluk_list_="select distinct b.refid as state_id,b.location_name as state from subrd_data as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70,8,9,10,18)  $subr_2 order by b.location_name asc";
                 $taluk_list_ = DB::select(DB::raw($taluk_list_));
                $taluk_list_count=count($taluk_list_);
                 
                for($i=0;$i<$taluk_list_count;$i++)
                {
                    $taluk_list[$taluk_list_[$i]->state_id]=$taluk_list_[$i]->state;
                }
               
                    $village_state="select distinct b.refid as state_id,b.location_name as state from mdlz_village_with_zero_rla as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70,18) $subr  order by b.location_name asc";
                   
                    $village_state = DB::select(DB::raw($village_state));
                    $village_state_count=count($village_state);
                     
                    for($i=0;$i<$village_state_count;$i++)
                    {
                        $village_state_list[$village_state[$i]->state_id]=$village_state[$i]->state;
                    }
            $taluk_list_="select distinct b.refid as state_id,b.location_name as state from tsi_subrd_data as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70,18)  order by b.location_name asc";
                 $taluk_list_ = DB::select(DB::raw($taluk_list_));
                $taluk_list_count=count($taluk_list_);
                 
                for($i=0;$i<$taluk_list_count;$i++)
                {
                    $zero_taluk_list[$taluk_list_[$i]->state_id]=$taluk_list_[$i]->state;
                }
                  $taluk_list_3="select distinct b.refid as state_id,b.location_name as state from subrd_consolidation_data as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70,8,9,10,18)  $subr_2 order by b.location_name asc";
                 $taluk_list_3 = DB::select(DB::raw($taluk_list_3));
                $taluk_list_count=count($taluk_list_3);
                 
                for($i=0;$i<$taluk_list_count;$i++)
                {
                    $consolidate_taluk_list[$taluk_list_3[$i]->state_id]=$taluk_list_3[$i]->state;
                }
               
                  $whole_sale_taluk_list_="select distinct b.refid as state_id,b.location_name as state from subrd_data as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70,8,9,10,18) and subrd_type=3  $subr_2 order by b.location_name asc";
                 $whole_sale_taluk_list_ = DB::select(DB::raw($whole_sale_taluk_list_));
                $whole_sale_taluk_list_count=count($whole_sale_taluk_list_);
                 
                for($i=0;$i<$whole_sale_taluk_list_count;$i++)
                {
                    $whole_sale_taluk_list[$whole_sale_taluk_list_[$i]->state_id]=$whole_sale_taluk_list_[$i]->state;
                }

              
                   
               
                $subchannel_list = DB::table("mdlz_channel_master")
                    ->where("stat", "A")
                    ->orderBy("name")
                    ->get(["refid", "name"]);
 
                }
                   

                  
            }
               
            if($user->client_id==97){
                   $ckmaster = DB::table("ck_beats")->select('loc7 as refid','state')->distinct()->get()->toArray(); 

                        for($k=0;$k<count($ckmaster);$k++)
                             $ckmaster_beat[$ckmaster[$k]->refid]=$ckmaster[$k]->state;
            } elseif ($user->client_id == 2) {
                $beat_list = DB::table("pg_mumbai_uncvrd_3ward")
                    ->join(
                        "beat_master",
                        "pg_mumbai_uncvrd_3ward.beat_id",
                        "=",
                        "beat_master.id"
                    )
                    ->select("beat_master.id", "beat_master.beat_name")
                    ->orderBy("beat_master.beat_name")
                    ->distinct()
                    ->get()
                    ->toArray();
            }
             else if($user->client_id==0 || $user->client_id==1000 || $user->client_id==15 || $user->client_id==133 || $user->client_id==150)
                 {
                    
                    if($user->id == 21035)
                    {
                        $client_tbl=[0=>'anderi_west_retlrs_saloon_data',1000=>'haldirams_sample_data_cluster',15=>'anderi_west_retlrs_saloon_data',133=>'pepsi_chennai_notfound_outlets',150=>'maamis_uncovered_outlets'];
                    }
                    else
                    {
                        $client_tbl=[0=>'anderi_west_retlrs_saloon_data',1000=>'haldirams_sample_data_cluster',15=>'anderi_west_retlrs_saloon_data',133=>'pepsi_uncovered_outlets',150=>'maamis_uncovered_outlets'];
                    }
                    
                    
                    
                    $channel_list = DB::table("hul_jaipur_uncvrd_outlets")
                    ->distinct()
                    ->get(["type as maintype_id", "type as main_type","type as data_type"]); 
                      if($user->client_id==1000)
                {
                    $channel_list = DB::table("haldirams_sample_data_cluster")
                    ->distinct()
                    ->get(["type as maintype_id", "type as main_type","type as data_type"]); 
                     $outlet_state_list = DB::table("haldirams_sample_data_new")
                    ->distinct()
                    ->get(["State as state","loc7 as id"]);
                }
				  if($user->client_id==150)
                {
                    $channel_list = DB::table("maamis_uncovered_outlets")
                    ->distinct()
                    ->get(["type as maintype_id", "type as main_type","type as data_type"]); 
                     $outlet_state_list = DB::table("maamis_uncovered_outlets")
                    ->distinct()
                    ->get(["State as state","loc7 as id"]);
                }
                 if($user->client_id==0)
                {
                    $channel_list = DB::table("hri_uncvrd_outlets")->where([['stat','=','A']])
                    ->distinct()
                    ->get(["sub_type as maintype_id", "sub_type as main_type","type_id as data_type"]); 
                }
               
                if($user->client_id!=133)
                {
                   $beat_list = DB::table($client_tbl[$user->client_id])
                    ->join(
                        "beat_master",
                        $client_tbl[$user->client_id].".beat_id",
                        "=",
                        "beat_master.id"
                    )
                    ->select("beat_master.id", "beat_master.beat_name")
                    ->orderBy("beat_master.beat_name")
                    ->where([[$client_tbl[$user->client_id].".user_id",'=',$user->id]])
                    ->distinct()
                    ->get()
                    ->toArray();
                   
                    
                }
                 $client_tble=[0=>'hri_uncvrd_outlets',1000=>'hri_uncvrd_outlets',15=>'hul_jaipur_uncvrd_outlets',133=>'pepsi_uncovered_outlets',150=>'maamis_uncovered_outlets'];
                if($user->client_id!=133)
                 $city_detail=DB::table($client_tble[$user->client_id])->where([['stat','=','A']])->select('city_id','city')->distinct()->get()->toArray();
                else if($user->id==13878)
                   $city_detail=DB::table($client_tble[$user->client_id])->where([['stat','=','A']])->select('loc16 as city_id','locality_name as city','sector')->where([['loc16','=','17379']])->distinct()->get()->toArray(); 
                else
                  $city_detail=[];
                
                 for($i=0;$i<count($city_detail);$i++)
                  {
                      if($user->client_id!=133)
                       $city_master[$city_detail[$i]->city_id]=$city_detail[$i]->city;
                      else
                        $city_master[$city_detail[$i]->city_id]=[$city_detail[$i]->city,$city_detail[$i]->sector];
                  }  
                if($user->client_id==0)
                {
                    $clienttable=[0=>'0_delhi_uncvrd_outlets'];
              
                    $city_detail=DB::table($clienttable[$user->client_id])->where([['stat','=','A']])->select('city_id','city as city','type_id')->distinct()->get()->toArray(); 
                
                     for($i=0;$i<count($city_detail);$i++)
                      {
                        $city_list[$city_detail[$i]->type_id][$city_detail[$i]->city_id]=$city_detail[$i]->city;
                      }  
                }

                   
                     if($user->client_id==15) 
                     {
                         $revenue_scale=['<20000'=>'< 20k','20000-45000'=>'20k - 45k','45000-75000'=> '45k - 75k','75000-150000'=>'75k - 1.5L','150000-250000'=>'1.5L - 2.5L','250000-400000'=>'2.5L - 4L','400000+'=>'4L +'];
                       $revenue_sql=DB::table($client_tble[$user->client_id])->select('revenue','revenue')->distinct()->get()->toArray();
                    
                     for($i=0;$i<count($revenue_sql);$i++)
                      {
                           $revenue[$revenue_sql[$i]->revenue]=$revenue_scale[$revenue_sql[$i]->revenue];
                      }
                     }
                      
             
                 }
             elseif ($user->client_id == 1) {

        $city_detail=DB::table("whole_saler_data")->where([['user_id','=',$user->id]])->select('City/Villg as city')->distinct()->get()->toArray();
         for($i=0;$i<count($city_detail);$i++)
          {
               $city_master[$city_detail[$i]->city]=$city_detail[$i]->city;
          }

                $beat_list = DB::table("whole_saler_data")
                    ->join(
                        "beat_master",
                        "whole_saler_data.beat_id",
                        "=",
                        "beat_master.id"
                    )
                    ->select("beat_master.id", "beat_master.beat_name")
                    ->orderBy("beat_master.beat_name")
                    ->distinct()
                    ->get()
                    ->toArray();
            } elseif ($user->client_id == 86 || $user->client_id==115) {
               // var_dump(strtotime($user->expire_date) < strtotime(date('d-m-Y')));
               // die;
                 if(strtotime($user->expire_date) < strtotime(date('d-m-Y')) )
               {
                     return Redirect::to("/auth/login")->with(
                    "message",
                    "Your license has expired. Kindly contact admin."
                );
                }

                $selected_id=[560013,560014,560015,560016,560022,560036,560037,560048,560054,560057,560058,560066,560067,560073,560088,560089,560090,560094,560097,110091,110051,110034,110009,110095,110085,110086,110092,110032,110035,110096,110031,110081,400104,400102,400092,400088,400064,400037,400059,400050,400067,400071,400058,400063,400078,400080,400070,400093,400072,400086,400053,400095,400068,400074,400097,400043,400055,400012,400022,400060,400051,400008,400017,400066,400083,400101];
                if($user->id==11791)
                    $beat_list = DB::table("nestle")
                    ->join(
                        "beat_master",
                        "nestle.beat_id",
                        "=",
                        "beat_master.id"
                    )
                    ->select("beat_master.id", "beat_master.beat_name as beat_name")
                    ->orderBy("beat_master.beat_name")
                    ->where([["user_id", "=", $user->id]])->distinct()
                    ->get()
                    ->toArray();
                else if($user->client_id==86 || $user->client_id==115){
                   
                      if($user->client_id==86){
                         $tbl='nestle';
                          $channel_tbl='nestle_channel_master';
                          $channel_list = DB::table($tbl)
                    ->where([["status", "!=", "D"]])
                    ->distinct()
                    ->get(["type as maintype_id", "type as main_type","type as data_type"]);
                        
                      }
                       else if($user->client_id==115){
                         $tbl='pedilite';
                        
                          $channel_tbl='pidilite_channel_master';
                          $type='data_type';
                          $channel_list = DB::table($tbl)
                    ->where([["status", "!=", "D"]])
                    ->distinct()
                    ->get(["type as maintype_id", "type as main_type","$type"]);
                       }
                     

                        $beat_list = DB::table($tbl)               
                            ->join(
                                "beat_master",
                                "$tbl.beat_id",
                                "=",
                                "beat_master.id"
                            )
                            ->select("beat_master.id", "beat_master.beat_name")
                            ->orderBy("beat_master.beat_name")
                            ->where([["user_id", "=", $user->id]])->distinct()
                            ->get()
                            ->toArray();
                             
                $subchannel_list = DB::table($channel_tbl)
                    ->where("stat", "A")
                    ->orderBy("name")
                    ->get(["refid", "name"]);        

        $city_detail=DB::table($tbl)->where([['user_id','=',$user->id]])->select('City/Villg as city')->distinct()->get()->toArray();
         for($i=0;$i<count($city_detail);$i++)
          {
               $city_master[$city_detail[$i]->city]=$city_detail[$i]->city;
          }

            }
               
               
                   // var_dump($beat_list);die;
            }

            if(($user->client_id==120) &&  $login_type_mdlz=='Urban')
           {
                $calendar=['period_type'=>[],'view_type'=>[],'timeline'=>[]];
                $period=DB::table('bid_application_master.period_type_master')->select('refid','period_name')->where('stat','A')->orderBy('refid')->get();
                  $k_count=count($period);
                 for($k=0;$k<$k_count;$k++)
                 {
                     $calendar['period_type'][$k]=['refid'=>$period[$k]->refid,'name'=>$period[$k]->period_name];
                 }

                  $view=DB::table('bid_application_master.view_master')->select('refid','view_name')->where('stat','A')->orderBy('refid')->get();
                  $k_count=count($view);
                  $package_map=[120=>1140];
                 for($k=0;$k<$k_count;$k++)
                 {
                     $calendar['view_type'][$k]=['refid'=>$view[$k]->refid,'name'=>$view[$k]->view_name];
                 }
                 $tbl='bid_application_master.'.$package_map[$user->client_id].'_timeline_master';
                 $timeline=DB::table($tbl)->select('refid','period_name')->where('stat','A')->whereIn('refid',[2,4,6])->orderBy('order_fld')->get();
                  $k_count=count($timeline);
                 for($k=0;$k<$k_count;$k++)
                 {
                     $calendar['timeline'][$k]=['refid'=>$timeline[$k]->refid,'name'=>$timeline[$k]->period_name];
                 }

           }
           if($user->client_id==133 && $user->id==13878)
           {
              $user_state=[33];
              $user_state=[460];
              $user_state=[69];
              $taluk_list[69]='Telugana';  
           }
            if($user->client_id==240)//Adani
           {

              $adani_state="select distinct loc7 as state_id,bi_state as state from adani_shape_data where loc7!=0 order by bi_state asc";
                   
                    $adani_state = DB::select(DB::raw($adani_state));
                    $adani_state_count=count($adani_state);
                     
                    for($i=0;$i<$adani_state_count;$i++)
                    {
                        $taluk_list[$adani_state[$i]->state_id]=$adani_state[$i]->state;
                    }
           }
           if($user->client_id==112)
           {
             $city_detail=DB::table("coke_uncvrd_outlets")->select('city as city','city_id as refid')->distinct()->get()->toArray();
             for($i=0;$i<count($city_detail);$i++)
              {
                   $city_master[$city_detail[$i]->refid]=$city_detail[$i]->city;
              }
           }

            $channel = DB::table("mdlz_main_channel_master")
                ->where("stat", "A")
                ->select(["refid", "name"])
                ->get();
			if($user->client_id==133 && $user->id==13878)
			{
				 $channel_list = DB::table("pepsi_uncovered_outlets")
                    ->where([["loc16", "=", 17379]])
                    ->distinct()
                    ->get(["sub_type as maintype_id", "sub_type as main_type","sub_type as data_type"]);
               
			}
            if($user->client_id==133 && $user->id!=13878)
            {
                 $channel_list = DB::table("pepsi_channel_type")                   
                    ->distinct()
                    ->get(["sub_type as maintype_id", "sub_type as main_type","sub_type as data_type"]);
               
            }
            $pepsi_rural_new_outlets = collect();
            if ($user->client_id == 133 && $login_type_mdlz == 'Rural/Urban') {
                   
                     $pepsi_rural_new_outlets = collect();
                    // Fetch the latest bi_id from session
                    $bi_id = session('bi_id');

                    // Make sure bi_id exists
                    if ($bi_id) {
                    $pepsi_rural_new_outlets = DB::table('pepsi_rural_new_outlets')
                    ->where('user_id', $user->id)
                     ->where('bi_id', $bi_id)
                    ->get();
                    } else {
                    $pepsi_rural_new_outlets = collect(); // empty collection if no bi_id
                    }
                    
            }
         //echo  $user->client_id;
         //die;
          //\Log::info($user->id);  
           // \Log::info($pepsi_rural_new_outlets);  
            $page="pages.dashboard";
            if($user->client_id==999)
                $page="pages.pwc";
            if(($user->client_id==120) &&  $login_type_mdlz=='Urban')
                    $page="pages.mdlz_urban_dashboard";
            if(($user->client_id==120) &&  $login_type_mdlz=='Rural')
                    $page="pages.mdlz_rural_dashboard";
            if($user->client_id==112)
                 //\Log::info('pages.coke_dashboard');
                    $page="pages.coke_dashboard";
            if(($user->client_id==1000))
                    $page="pages.haldirams_dashboard";
				 if(($user->client_id==150))
                    $page="pages.maamis_dashboard";
             if(($user->client_id==123))
                    $page="pages.perfetti_dashboard";
             if($user->client_id==133 )
                    $page='pages.pepsi_dashboard';
            if($user->client_id==133 &&  $login_type_mdlz=='Rural/Urban' )
                   // \Log::info($login_type_mdlz);
                    $page='pages.pepsi_rural_dashboard';
            if($user->client_id==133 &&  $user->catgry_status === 'beverages')
                  // \Log::info($user->catgry_status);
                    $page='pages.pepsi_beverage_dashboard';
             if(($user->client_id==97))
                    $page="pages.ck_dashboard";
             if(($user->client_id==240))
                    $page="pages.adani_dashboard";
             if($user->client_id==9999)
                    $page='pages.mars_dashboard';
             if($user->id==13285)
                    $page='pages.demo_dashboard';
                return view($page, [
                "channel" => $channel,
                "usertype" => $user->user_type,
                "subordinate" => $reports_to,
                "user_district"=>$user_district,
                "sst_beat"=>$SST_beat,
                 "college_data"=>$college_data,
                "calendar"=>$calendar,
                "channel_list" => $channel_list,
                 "beat_list" => $beat_list,
                "beat_list" => $beat_list,
                "state_list"=>$state_list,
                "sub_channel_list" => $subchannel_list,
                "jj_channel" => $channel_ids,
                "statehighway_list" => $statehighway_list,
                 "ckmaster_beat"=>$ckmaster_beat,
                "outlet_state_list" => $outlet_state_list ,
                "taluk_list" => $taluk_list,
                "zero_taluk_list"=>$zero_taluk_list,
                "whole_sale_taluk_list"=>$whole_sale_taluk_list,
                "highway_list"=>$highway_list,
                "subrd_beat"=>$subrd_beat,
                "city_master"=>$city_master,
                "revenue_list"=>$revenue,
                "perfetti_city_master"=>$perfetti_city_master,
                "sst_state_beat"=>$sst_state_beat,
                "village_state_list"=>$village_state_list,
                "city_list"=>$city_list,
                "multiple_state"=>(isset($user_state) && count($user_state)>1) ? true : false,
                  "consolidate_taluk_list"=>$consolidate_taluk_list,
                   "pepsi_rural_new_outlets"=>$pepsi_rural_new_outlets
                  
            ]);
            // return view("pages.dashboard", [
            //     "channel" => $channel,
            //     "usertype" => $user->user_type,
            //     "subordinate" => $reports_to,
            //     "district_list"=>$district_list,
            //     "channel_list" => $channel_list,
            //     "beat_list" => $beat_list,
            //     "sub_channel_list" => $subchannel_list,
            //     "jj_channel" => $channel_ids,
            //     "taluk_state_list" => $taluk_state_list,
            //     "taluk_list" => $taluk_list,
            //     "highway_list"=>$highway_list,
            //     "subrd_beat"=>$subrd_beat,
            //     "multiple_state"=>(isset($user_state) && count($user_state)>2) ? true : false,
            // ]);
        } else {
            return Redirect::to("/auth/login")->with(
                "message",
                "Get approval from Admin Team from BrandIdea !!! Thank You"
            );
        }
    }
    public function show()
    {
        //var_dump($this->changejson());
        //var_dump($this->comparejson());
    }
    public function getsubchannel($id)
    {
        $subchannel = DB::table("mdlz_channel_master")
            ->where("fld1751", $id)
            ->pluck("name", "refid");
        return json_encode($subchannel);
    }
    public function getcalendardata(Request $request)
    {
           $input = $request->all();$user = auth()->user();
           $calendar_type=$input['calendar_type'];
           $period_type=$input['period_type'];
           $view_type=$input['view_type'];
            $selected_menu=$input['selected_menu'];

           $where=[];
           if($view_type!=0)
            array_push($where, "  view_master_id='".$view_type."'");
           else
            array_push($where, "  default_view='Y'");
           if($selected_menu!=0)
              array_push($where, "  second_lvl_menu_id='".$selected_menu."'");



           $tbl=$user->client_id.'_timeline_data';
           $sql="SELECT `period_id`, `period_type_id`, `view_master_id`, `default_view`, `period_from`, `period_to`, `period_default_from`, `period_default_to`, `stat`,second_lvl_menu_id FROM ".$tbl." WHERE period_id='".$calendar_type."' and period_type_id='".$period_type."' and stat='A' and ".join(" and ",$where).""; 
        
            $sql = DB::select(DB::raw($sql));

           // $sql=DB::table($tbl)->where([['period_id','=',$calendar_type],['period_type_id','=',$period_type]])->select('period_from','period_to','period_default_from','period_default_to')->get();

           $calendar_data=[];
           for($k=0;$k<count($sql);$k++)
           {
             $calendar_data[$k]['period_from']=$sql[$k]->period_from;
             $calendar_data[$k]['period_to']=$sql[$k]->period_to;
             $calendar_data[$k]['period_default_from']=$sql[$k]->period_default_from;
             $calendar_data[$k]['period_default_to']=$sql[$k]->period_default_to;
             $calendar_data[$k]['second_lvl_menu_id']=$sql[$k]->second_lvl_menu_id;

           }
           return json_encode($calendar_data);

    }
    public function deleteoutlet($id)
    {
        $result = DB::table("outlet_list")
            ->where("refid", "=", $id)
            ->delete();
        if ($result) {
            $message["status"] = "success";
            $message["msg"] = "Outlet deleted successfully";
        } else {
            $message["status"] = "failure";
            $message["msg"] = "Outlet not deleted.";
        }

        return json_encode($message);
    }
    public function perform()
    {
        $sql = DB::table("users_log_count")
            ->where([['user_id','=',auth()->user()->id],['logout_time','=',null]])
            ->update(["logout_time" => date('Y-m-d h:i:s')]);
                                                                           
        Session::flush();
        Auth::logout();
        return Redirect::to('/auth/login');
        
    }
    public function updatestatus(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $message = [];

        //$sql="update uncovered_outlets set status='".$input['status']."' where id='".$input['outlet_id']."'";

        $sql = DB::table("uncovered_outlets")
            ->where("fld580", $input["outlet_id"])
            ->update(["status" => $input["status"]]);
        if ($sql) {
            $message["status"] = "success";
            $message["msg"] = "Outlet status updated successfully";
        } else {
            $message["status"] = "failure";
            $message["msg"] = "Outlet status not updates.";
        }

        return json_encode($message);
    }
    public function updateoutlet_delhi(Request $request)
    {
        $input = $request->all();
        $lat = $input["lat"];
        $lon = $input["lon"];
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");
        //ref_nungambakkam
        $user = auth()->user();
        $userid = $user->id;

        if ($user->client_id == 0 ) {
          
                $tbl="0_delhi_uncvrd_outlets";
            $result = DB::table($tbl)
                ->where("retailer_id", $input["outlet_id"])
                ->update([
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);
        }
         $message = [];
        $message["status"] = "success";
        $message["msg"] = "Outlet status updated.";
        return json_encode($message); 
    }
    public function updateoutlet(Request $request)
    {
        $input = $request->all();
        $lat = $input["lat"];
        $lon = $input["lon"];
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");
        //ref_nungambakkam
        $user = auth()->user();
        $table_name="";

        

         // ADD HERE
        if (!$user || empty($user->id)) {

            $message = [];
            $message["status"] = "error";
            $message["msg"] = "Session expired. Please login again.";

            return json_encode($message);
        }
       // $userid = $user->id;
        $userid = $user->id;

        if ($user->client_id == 120 ) {
            //ref_08oct2021
             if($user->role=='Country-HO')
                $tbl="mdlz_outlets";
            else if($user->id==13285)
                $tbl="ckpl_uncvrd_outlets_new";
            else
                $tbl="mdlz_rd_outlets";

            $result = DB::table($tbl)
                ->where("retailer_id", $input["outlet_id"])
                ->update([
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    "user_id"=>$userid,
                ]);
        }
        elseif ($user->client_id == 133) 
        {
            
           
            if($user->catgry_status == 'beverages')
            {
                $table_name='pepsi_uncovered_outlets_beverages';
            }
            else
            {
                $table_name='pepsi_uncovered_outlets';
            }

            
             if(in_array($input['status'],['A']) )
                $data=[
                        //"status" => $input["status"], 
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "created_date" => $date,
                        "user_id"=>$userid,
                        
                    ];
             if(in_array($input['status'],['NF']) )
                $data=[
                        "status" => $input["status"],
                        "snack_purchase"=>"",
                        "outlet_stock"=>"",
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "created_date" => $date,
                        "user_id"=>$userid,
                        
                    ];
             if(in_array($input['status'],['Y','N']) )
                $data=[
                        "snack_purchase" => $input["status"],
                        "status"=>'A',
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "user_id"=>$userid,
                        "created_date" => $date,
                        
                    ];
            if(in_array($input['status'],['Yes','No']) )
                $data=[
                        "is_catgry_outlet" => $input["status"],
                        "status"=>'A',
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "user_id"=>$userid,
                        "created_date" => $date,
                        
                    ];
            if(in_array($input['status'],['W','D']) )
                $data=[
                        "outlet_stock" => $input["status"],
                        "status"=>'A',
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "user_id"=>$userid,
                        "created_date" => $date,
                        
                    ];
            
            if($user->id == 21035)
            {
                 $result = DB::table("pepsi_chennai_notfound_outlets")
                ->where("retailer_id", $input["outlet_id"])
                ->update($data); 
            }

                // DB::enableQueryLog();

        $result = DB::table($table_name)
            ->where("retailer_id", $input["outlet_id"])
            ->update($data);

        //\Log::info('Update Query', DB::getQueryLog());

            // $result = DB::table($table_name)
               // ->where("retailer_id", $input["outlet_id"])
              //  ->update($data); 

                
        }
        elseif ($user->client_id == 1) {
            $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    
                ];
            
            $result = DB::table("whole_saler_data")
                ->where("refid", $input["outlet_id"])
                ->update($data);
        }
         elseif ($user->client_id == 999) {
            $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    
                ];
            
            $result = DB::table("dabar_and_coloba_biotique")
                ->where("refid", $input["outlet_id"])
                ->update($data);
        }
       elseif ($user->client_id == 112) {
             $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    "user_id"=>$userid,
                    
                ];
            if(isset($input['coke_uncovered']))
            {

                 $tbl="coke_uncvrd_outlets";
                  $result = DB::table($tbl)
                ->where("retailer_id", $input["outlet_id"])
                ->update($data);

            }
            else
            {
                if($user->role=='')
                   $tbl="colleges_nearby_fmcg_stores";
                else
                    $tbl="coke_whlslrs";

               
                $result = DB::table($tbl)
                    ->where("refid", $input["outlet_id"])
                    ->update($data);
            } 
        }
         if ($user->client_id == 15) {
            //ref_08oct2021
            //var_dump($input['uncovered']);die;
            $result = DB::table("hul_jaipur_uncvrd_outlets")
                ->where("retailer_id", $input["outlet_id"])
                ->update([
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);
        }
        if ($user->client_id == 86 ) {
           $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    
                ];
            if(isset($input['retailer_name']) && $input['retailer_name']!='')
                $data['retailer_name']=$input['retailer_name'];
            if(isset($input['contact']) && $input['contact']!='')
                $data['contact_no']=$input['contact'];
             if(isset($input['remark']) && $input['remark']!='')
                $data['remark']=$input['remark'];

            $result = DB::table("nestle")
                ->where("refid", $input["outlet_id"])
                ->update($data);
        } elseif ($user->client_id == 115) {
            $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    
                ];
            
            $result = DB::table("pedilite")
                ->where("refid", $input["outlet_id"])
                ->update($data);
        }
         elseif ($user->client_id == 123) {
            $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    
                ];
              
         if(isset($input['uncovered']))
             $tbl='perfetti_uncovered_outlets';
         else
             $tbl='perfetti_whole';

            $result = DB::table($tbl)
                ->where("refid", $input["outlet_id"])
                ->update($data);
        }
       elseif ($user->client_id == 1000) {
            $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    
                ];
            
            $result = DB::table("haldirams_sample_data_new")
                ->where("refid", $input["outlet_id"])
                ->update($data);
        }
		 elseif ($user->client_id == 150) {
            $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    
                ];
            
            $result = DB::table("maamis_uncovered_outlets")
                ->where("refid", $input["outlet_id"])
                ->update($data);
        }
        else if ($user->client_id == 0 && isset($input['uncovered'])) {
            //ref_08oct2021
            //var_dump($input['uncovered']);die;
            $result = DB::table("hri_uncvrd_outlets")
                ->where("retailer_id", $input["outlet_id"])
                ->update([
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);
        }
         elseif ($user->client_id == 97) {
            if(in_array($input['status'],['A']) )
                $data=[
                        "status" => $input["status"],
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "user_id"=>$userid,
                        "created_date" => $date,
                        
                    ];
             if(in_array($input['status'],['NF']) )
                $data=[
                        "status" => $input["status"],
                        "relevant"=>"",
                        "cooler"=>"",
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "user_id"=>$userid,
                        "created_date" => $date,
                        
                    ];
             if(in_array($input['status'],['R','NR']) )
                $data=[
                        "relevant" => $input["status"],
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "user_id"=>$userid,
                        "created_date" => $date,
                        
                    ];
            if(in_array($input['status'],['C','NC']) )
                $data=[
                        "cooler" => $input["status"],
                        "user_lat" => $lat,
                        "user_lon" => $lon,
                        "user_id"=>$userid,
                        "created_date" => $date,
                        
                    ];
            if(isset($input['type']) && $input['type']==1)
                $result = DB::table("ckpl_uncvrd_outlets_test")
                ->where("retailer_id", $input["outlet_id"])
                ->update($data);
            else
                  $result = DB::table("ckpl_uncvrd_outlets")
                ->where("retailer_id", $input["outlet_id"])
                ->update($data);
        }  

         elseif ($user->client_id == 0)    
         {         $data=[
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                    
                ];
            
            $result = DB::table("anderi_west_retlrs_saloon_data")
                ->where("refid", $input["outlet_id"])
                ->update($data);
        } elseif ($user->client_id != 2) {
            $result = DB::table("alwarpet_uncvrd")
                ->where("refid", $input["outlet_id"])
                ->update([
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);
        } else {
            $result = DB::table("pg_mumbai_uncvrd_3ward")
                ->where("refid", $input["outlet_id"])
                ->update([
                    "status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);
        }

        $message = [];
        $message["status"] = "success";
        $message["msg"] = "Outlet status updated.";
        return json_encode($message);
    }
    public function updateoutlet_premium(Request $request)
    {
        $input = $request->all();
        $lat = $input["lat"];
        $lon = $input["lon"];
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");
        //ref_nungambakkam
        $user = auth()->user();
        $userid = $user->id;
        //if($input['column']=='stock_confectionary')//ref_08oct2021
        $result = DB::table("whole")
            ->where("refid", $input["outlet_id"])
            ->update([
                $input["column_name"] => $input["status"],
                "user_lat" => $lat,
                "user_lon" => $lon,
                "created_date" => $date,
            ]);

        $message = [];
        $message["status"] = "success";
        $message["msg"] = "Outlet status updated.";
        return json_encode($message);
    }
    public function updateoutlet_potential(Request $request)
    {
        $input = $request->all();
        $lat = $input["lat"];
        $lon = $input["lon"];
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");
        //ref_nungambakkam
        $user = auth()->user();
        $userid = $user->id;
        if ($user->client_id == 86 || $user->client_id == 120) {
            $result = DB::table("nestle")
                ->where("refid", $input["outlet_id"])
                ->update([
                    "potential_status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);
        }
        if ($user->client_id == 0 || $user->client_id == 1000  || $user->client_id == 150 || $user->client_id==123) {
            $client_tbl=[0=>'anderi_west_retlrs_saloon_data',1000=>'haldirams_sample_data_new',150=>'maamis_uncovered_outlets',123=>'perfetti_uncovered_outlets'];
            $result = DB::table($client_tbl[$user->client_id])
                ->where("refid", $input["outlet_id"])
                ->update([
                    "potential_status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);
        } else {
            $result = DB::table("ref_08oct2021")
                ->where("refid", $input["outlet_id"])
                ->update([
                    "potential_status" => $input["status"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);
        }

        $message = [];
        $message["status"] = "success";
        $message["msg"] = "Outlet status updated.";
        return json_encode($message);
    }
    public function updateoutlet_byid(Request $request)
    {
        $input = $request->all();
        $result = DB::table("uncovered_outlets")
            ->where("refid", $input["outlet_id"])
            ->update(["status" => $input["status"]]);
        $message = [];
        $message["status"] = "success";
        $message["msg"] = "Outlet status updated.";
        return json_encode($message);
    }
    public function userhistory(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;

        DB::table("user_history")->insert([
            "user_id" => $userid,
            "lat" => $input["lat"],
            "lng" => $input["lon"],
        ]);

        $message = [];
        $message["status"] = "success";
        $message["msg"] = "user lat lng updated.";
        return json_encode($message);
    }
    public function user_activity(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;

        DB::table("user_activity")->insert([
            "user_id" => $userid,
            "lat" => $input["lat"],
            "lng" => $input["lon"],
            "type"=>$input['type']
        ]);

        $message = [];
        $message["status"] = "success";
        $message["msg"] = "user lat lng updated.";
        return json_encode($message);
    }
    public function shownearoutlet(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        if (isset($request["center_coordinates"])) {
            $lat = $request["center_coordinates"][0];
            $lon = $request["center_coordinates"][1];

            $query =
                "select refid,name,channel,address,latitude,longitude,distance,name,icon,shop_image from (SELECT fld580 as refid,ccpname as name,name as channel,address,latitude,longitude,icon,shop_image, (((acos(sin((" .
                $lat .
                "*pi()/180)) * sin((`latitude`*pi()/180)) + cos((" .
                $lat .
                "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" .
                $lon .
                "- `longitude`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance FROM uncovered_outlets) as a where a.distance < 0.2";

            $uncovered_outlets = DB::select(DB::raw($query));

            $uncovered_outlet = [];

            for ($k = 0; $k < count($uncovered_outlets); $k++) {
                array_push($uncovered_outlet, [
                    "refid" => $uncovered_outlets[$k]->refid,
                    "outlet_name" => $uncovered_outlets[$k]->name,
                    "channel_name" => $uncovered_outlets[$k]->channel,
                    "sub_channel_name" => "",
                    "address" => $uncovered_outlets[$k]->address,
                    "lat" => $uncovered_outlets[$k]->latitude,
                    "lon" => $uncovered_outlets[$k]->longitude,
                    "icon" => $uncovered_outlets[$k]->icon,
                    "shop_image" => $uncovered_outlets[$k]->shop_image,
                ]);
            }

            return response()->json($uncovered_outlet);
        }
    }
    public function delete_image(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $refid = $input["refid"];
        $result = DB::table("jj_outlet_image")
            ->where("refid", $refid)
            ->update(["status" => "R"]);

        $message = [];

        $message["status"] = "success";
        $message["msg"] = "Outlet deleted successfully";

        return json_encode($message);
    }
   /* public function addoutlet_image(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $client_id = $user->client_id;
          $message = [];
        $date = date("Y-m-d H:i:s");
        if(isset($request->mobile))
        {
            $data=$request->img[0];
            
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
             $imageName=date("d-m-y") .rand().'_mobileupload.jpg';

            file_put_contents('shop_image/'.$imageName, $data);
             $path = 'shop_image/'.$imageName;
          
             if (isset($request->img) && count($request->img) > 0) {
         
                if ($path) {
                    $result = DB::table("jj_outlet_image")->insert([
                        [
                            "outlet_id" => $request["outlet_id"],
                            "user_id" => $userid,
                            "client_id" => $client_id,
                            "outlet_image" => $path,
                            "created_date" => $date,
                            "status" => "A",
                        ],
                    ]);
                }
            

           
                $message["status"] = "success";
                $message["msg"] = "Outlet added successfully";
            }
            else {
            $message["status"] = "failure";
            $message["msg"] = "Upload the Image";
        }
        } 
        
        else
        {
            $imagePath = $request->img;
             if (isset($request->img) && count($imagePath) > 0) {
            for ($i = 0; $i < count($imagePath); $i++) {
                $imageName =
                    date("d-m-y") .rand().
                    "_" .
                    $imagePath[$i]->getClientOriginalName();

            if($client_id === 133)
            {
                 /* $path = $imagePath[$i]->storeAs( 
                    "RetailerList/pepsi_upload_image",
                    $imageName,
                    "s3"
                );
            }
            else{

                $path = $imagePath[$i]->storeAs(
                    "shop_image",
                    $imageName, 
                    "shop_snap"
                );
            }
               /* $path = $imagePath[$i]->storeAs(
                    "shop_image",
                    $imageName,
                    "shop_snap"
                );
                if ($path) {
                    $result = DB::table("jj_outlet_image")->insert([
                        [
                            "outlet_id" => $request["outlet_id"],
                            "user_id" => $userid,
                            "client_id" => $client_id,
                            "outlet_image" => $path,
                            "created_date" => $date,
                            "status" => "A",
                        ],
                    ]);
                }
            }

            if (count($imagePath) == $i) {
                $message["status"] = "success";
                $message["msg"] = "Outlet added successfully";
            }
        } else {
            $message["status"] = "failure";
            $message["msg"] = "Upload the Image";
        }
      
        }        
            
       if(isset($request['current_status']))
         $message['current_status']=$request['current_status'];
        return json_encode($message);
    }*/
    public function addoutlet_image(Request $request)
{
    $input = $request->all();

    $user = auth()->user();

    $userid = $user->id;

     if($user->catgry_status == 'beverages')
    {
        $folderName='pepsi/beverage/shop_image/';
        $categoryStatus='beverages';
    }
    else
    {
       $folderName='pepsi/snacks/shop_image/';
        $categoryStatus='snacks';
    }
     

    $client_id = $user->client_id;

    $message = [];

    $date = date("Y-m-d H:i:s");

    // MOBILE BASE64 IMAGE UPLOAD
    if (isset($request->mobile)) {

        $data = $request->img[0];

        list($type, $data) = explode(';', $data);

        list(, $data) = explode(',', $data);

        $data = base64_decode($data);

      //  $imageName = date("d-m-y") . rand() . '_mobileupload.jpg';

        $imageName = $userid."_".date("Ymd_His")."_"."_mobileuploade.jpg";

        // CREATE FOLDER IF NOT EXISTS
        if (!file_exists(public_path('shop_image'))) {

            mkdir(public_path('shop_image'), 0777, true);
        }

        file_put_contents(public_path($folderName . $imageName), $data);

        $path = $folderName . $imageName;

        if (isset($request->img) && count($request->img) > 0) {

            if ($path) {

                $result = DB::table("jj_outlet_image")->insert([
                    [
                        "outlet_id" => $request["outlet_id"],
                        "user_id" => $userid,
                        "client_id" => $client_id,
                        "outlet_image" => $path,
                        "created_date" => $date,
                        "status" => "A",
                         "catgry_status" => $categoryStatus,
                    ],
                ]);
            }

            $message["status"] = "success";

            $message["msg"] = "Outlet added successfully";

        } else {

            $message["status"] = "failure";

            $message["msg"] = "Upload the Image";
        }

    } else {

        // NORMAL IMAGE UPLOAD
        $imagePath = $request->img;

        if (isset($request->img) && count($imagePath) > 0) {

            for ($i = 0; $i < count($imagePath); $i++) {

               // $imageName =
                  //  date("d-m-y") .
                  //  rand() .
                  //  "_" .
                 //   $imagePath[$i]->getClientOriginalName();

                 $imageName = $userid."_".date("Ymd_His")."_".$imagePath[$i]->getClientOriginalName();

                // SERVER STORAGE PATH
                $destinationPath = public_path($folderName);

                // CREATE FOLDER IF NOT EXISTS
                if (!file_exists($destinationPath)) {

                    mkdir($destinationPath, 0777, true);
                }

                // MOVE IMAGE TO SERVER
                $imagePath[$i]->move($destinationPath, $imageName);

                // SAVE DB PATH
                $path = $folderName . $imageName;

                if ($path) {

                    $result = DB::table("jj_outlet_image")->insert([
                        [
                            "outlet_id" => $request["outlet_id"],
                            "user_id" => $userid,
                            "client_id" => $client_id,
                            "outlet_image" => $path,
                            "created_date" => $date,
                            "status" => "A",
                            "catgry_status" => $categoryStatus,
                        ],
                    ]);
                }
            }

            $message["status"] = "success";

            $message["msg"] = "Outlet added successfully";

        } else {

            $message["status"] = "failure";

            $message["msg"] = "Upload the Image";
        }
    }

    if (isset($request['current_status'])) {

        $message['current_status'] = $request['current_status'];
    }

    return json_encode($message);
}
    public function show_image(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $outlet_id = $input["outlet_id"];
        $message = [];

        $outletlist = DB::table("jj_outlet_image")
            ->where([
                ["user_id", "=", $userid],
                ["outlet_id", "=", $outlet_id],
                ["status", "=", "A"],
            ])
            ->select("jj_outlet_image.*")
            ->get();

        $outletlist_data = [];
        for ($i = 0; $i < count($outletlist); $i++) {
            $temp = [];
            $temp["refid"] = $outletlist[$i]->refid;
            $temp["outlet_id"] = $outletlist[$i]->outlet_id;
            $temp["outlet_image"] = $outletlist[$i]->outlet_image;

            array_push($outletlist_data, $temp);
        }

        if (count($outletlist) > 0) {
            $message["status"] = "success";
            $message["msg"] = "Outlet added successfully";
            $message["outlet_list"] = $outletlist_data;
        } else {
            $message["status"] = "failure";
            $message["msg"] = "No image";
            $message["outlet_list"] = $outletlist_data;
        }
        return json_encode($message);
    }

    public function addoutlet(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $message = [];
        //  $request->validate([
        //   'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        $imagePath = $request->file("img");
        $imageName = date("d-m-y") . "_" . $imagePath->getClientOriginalName();
        $path = $request
            ->file("img")
            ->storeAs("shop_image", $imageName, "shop_snap");

        $outlet = new OutletController();
        $outlet->outlet_name = $request["outlet_name"];
        $outlet->owner_name = $request["owner_name"];
        $outlet->channel_name = 1;
        $outlet->sub_channel_name = $request["sub_channel_name"];
        $outlet->address = $request["address"];
        $outlet->shop_image = $path;
        $outlet->user_id = $userid;
        $outlet->pan_no = $request["pan_no"];
        $outlet->tan_no = $request["tan_no"];
        $outlet->mobile_no = $request["mobile_no"];
        $outlet->shop_establish_no = $request["shop_establish_no"];
        $outlet->gst_no = $request["gst_no"];
        $geo = explode(",", $request["gio_point"]);
        $outlet->lat = count($geo) > 1 ? $geo[0] : "";
        $outlet->lon = count($geo) > 1 ? $geo[1] : "";
        $result = DB::table("outlet_list")->insert([
            [
                "outlet_name" => $request["outlet_name"],
                "owner_name" => $request["owner_name"],
                "client_id" => $user->client_id,
                "channel_name" => 1,
                "sub_channel_name" => $request["sub_channel_name"],
                "address" => $request["address"],
                "shop_image" => $path,
                "user_id" => $userid,
                "pan_no" => $request["pan_no"],
                "tan_no" => $request["tan_no"],
                "mobile_no" => $request["mobile_no"],
                "shop_establish_no" => $request["shop_establish_no"],
                "gst_no" => $request["gst_no"],
                "lat" => $outlet->lat,
                "lon" => $outlet->lon,
            ],
        ]);

        if ($result) {
            $outletlist = DB::table("outlet_list")
                ->where([["user_id", "=", $userid]])
                ->join(
                    "mdlz_main_channel_master",
                    "outlet_list.channel_name",
                    "=",
                    "mdlz_main_channel_master.refid"
                )
                ->join(
                    "mdlz_channel_master",
                    "outlet_list.sub_channel_name",
                    "=",
                    "mdlz_channel_master.refid"
                )
                ->select(
                    "outlet_list.*",
                    "mdlz_main_channel_master.name as channel",
                    "mdlz_channel_master.name as subchannel"
                )
                ->get();

            $outletlist_data = [];
            for ($i = 0; $i < count($outletlist); $i++) {
                $temp = [];
                $temp["refid"] = $outletlist[$i]->refid;
                $temp["outlet_name"] = $outletlist[$i]->outlet_name;
                $temp["channel"] = $outletlist[$i]->channel;
                $temp["subchannel"] = $outletlist[$i]->subchannel;
                array_push($outletlist_data, $temp);
            }

            $message["status"] = "success";
            $message["msg"] = "Outlet added successfully";
            $message["outletlist"] = $outletlist_data;
        } else {
            $message["status"] = "failure";
            $message["msg"] = "Outlet not added.";
        }

        return json_encode($message);
    }
    public function add()
    {
        $channel = DB::table("mdlz_main_channel_master")
            ->where("stat", "A")
            ->select(["refid", "name"])
            ->get();
        return view("outlet/add", ["channel" => $channel]);
    }

    public function changejson()
    {
        $dir =
            'D:\biappserver\htdocs\bimondlz_app\storage\app\map_shape\1\1\15_16\1';

        $files = scandir($dir);
        $path = "";

        for ($i = 0; $i < count($files); $i++) {
            if ($files[$i] != "." && $files[$i] != "..") {
                $loadmap = "map_shape/1/1/15_16/1/" . $files[$i];
                $tempcontent = Storage::get($loadmap);
                $name = explode(".", $files[$i]);

                $tempmap = "1/" . $name[0] . ".js";

                Storage::delete("map_uploads/" . $tempmap);

                if (
                    !Storage::disk("map_uploads")->put(
                        $tempmap,
                        "var rs=" . $tempcontent
                    )
                ) {
                    return false;
                }

                $path .= url("/") . "/mapshape/1/" . $tempmap;
            }
        }
        return $path;
    }
     public function get_sr_tsi_150($input)
    {
         $input_query=json_decode($input['input']);
          $tsi_list=[];         $tsi_list['tsi_list']=[]; $tsi_list['subrd_sst_list']=[];$tsi_list['sst_list']=[];   $tsi_list['maplist']=[];
          $column=[];       $value_data=[];
         if(!isset($input_query->cluster_name))
         {
             array_push($column, array(
             'title' => '#', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'Cluster Name', 'className' => 'text-left'
             ));
              
              array_push($column, array(
                 'title' => 'No. of subRD in cluster', 'className' => 'text-right'
             ));
              
             //   array_push($column, array(
             //     'title' => 'No. of Sr. TSI Reqd.', 'className' => 'text-right'
             // ));
                array_push($column, array(
                 'title' => 'Total RLA Nos.', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Total VC Nos.', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Cluster Radius (km)', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'SO Territory', 'className' => 'text-left'
             ));
         }
         else
         {
         
            array_push($column, array(
             'title' => '#', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'State', 'className' => 'text-left'
             ));
             //  array_push($column, array(
             //     'title' => 'Year', 'className' => 'text-right'
             // ));
              
             //   array_push($column, array(
             //     'title' => 'Month', 'className' => 'text-right'
             // ));
                array_push($column, array(
                 'title' => 'Branch', 'className' => 'text-left'
             ));
                array_push($column, array(
                 'title' => 'Region', 'className' => 'text-left'
             ));
                array_push($column, array(
                 'title' => 'ASM Area', 'className' => 'text-left'
             ));
                array_push($column, array(
                 'title' => 'SO Territory', 'className' => 'text-left'
             ));

   array_push($column, array(
                 'title' => 'Existing SubRD Code', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Existing SubRD Name', 'className' => 'text-left'
             ));
              array_push($column, array(
                 'title' => 'SubRD Type', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'SubRD Tier', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'SST Code', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'SST Name', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'SST Town', 'className' => 'text-left'
             ));
              array_push($column, array(
                 'title' => 'Town Class', 'className' => 'text-left'
             ));
              array_push($column, array(
                 'title' => 'TSI Name', 'className' => 'text-left'
             ));
              array_push($column, array(
                 'title' => 'TSI Code', 'className' => 'text-right'
             ));
              array_push($column, array(
                 'title' => 'Total RLA Nos.', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'Total VC Nos.', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'Batch', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'Cluster Radius (km)', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'Cluster', 'className' => 'text-left'
             ));
             // array_push($column, array(
             //     'title' => 'No. of SubRD in cluster', 'className' => 'text-right'
             // ));
             // array_push($column, array(
             //     'title' => 'No. of Sr. TSI Reqd.', 'className' => 'text-right'
             // ));
               array_push($column, array(
                 'title' => 'avg_biz', 'className' => 'text-right'
             ));
             
               array_push($column, array(
                 'title' => 'No. of days visitedby TSI  Jan 24th', 'className' => 'text-right'
             ));
               array_push($column, array(
                 'title' => 'No. of days visitedby TSI  Dec 23rd', 'className' => 'text-right'
             ));
               array_push($column, array(
                 'title' => 'No. of days visitedby TSI  Nov 23rd', 'className' => 'text-right'
             ));
               array_push($column, array(
                 'title' => 'No. of days visitedby TSI  Oct 23rd', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Avg. of TSI Mandays', 'className' => 'text-right'
             ));
            
 


         }
          
            
          if(!isset($input_query->cluster_name))
          {

                
                $sql="SELECT sr_tsi_cluster_name as cluster_name,so_territory, `cluster_centroid_latitude` as latitude, `cluster_centroid_longitude` as longitude,`no_of_subrd_in_cluster` no_of_subrd, 1 as  no_of_tsi,sum(ifnull(`avg_sale_monthly`,0)) as avg_sale_monthly,sum(ifnull(`vc_count`,0)) as vc_count,sum(ifnull(`sub_rd_rla`,0)) as sub_rd_rla,  distacnce_km,tsi_name,tsi_uid FROM `sr_tsi_subrd_cluster_150` where  stat='A'group by cluster_name";
          }
          else
          {
             $sql=' SELECT `state`, `year`, `month`, `branch_name`, `region_name`, `asm_area`, `so_territory`, `subrd_villg_bi_id`, `subrd_villg_marketuid`, `subd_state_name`, `subd_distt_name`, `subd_taluk_name`, `subd_villg_name`, `existing_subrd_uid`, `existing_subrd_name`, `subrd_type`, `subrd_tier`, `sst_code`, `sst_latitude`, `sst_longitude`, `sst_village_bi_id`, `sst_village_market_uid`, `2011_census`, `sst_state_name`, `sst_distt_name`, `sst_taluk_name`, if(sst_villg_name!="",concat(`sst_villg_name`," Villg."),concat(sst_town," Town")) as sst_villg_name, `sst_name`, `sst_town`, `town_class`, `tsi_name`, `tsi_uid`, `sub_rd_rla`, `vc_count`, `avg_sale_monthly`, `batch`, `distacnce_km`, `cluster_centroid_latitude` as latitude, `cluster_centroid_longitude` as longitude, `sr_tsi_cluster_name` as cluster_name, `no_of_subrd_in_cluster` no_of_subrd, `no_of_sr_tsi_requird` no_of_tsi, `refid`,latitude as subd_latitude,longitude as subd_longitude,`avg_biz`, `no_of_days_visited_by_tsi_jan24`, `no_of_days_visited_by_tsi_dec23`, `no_of_days_visited_by_tsi_nov23`, `no_of_days_visited_by_tsi_oct23`, `avg_of_tsi_mandays` FROM `sr_tsi_subrd_cluster_150` where  (sr_tsi_cluster_name="Cluster '.$input_query->cluster_name.'" or sr_tsi_cluster_name="'.$input_query->cluster_name.'") and stat="A"  order by distacnce_km desc';

          }

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $already_exist=[];
        $sst_list=[];
        $value_distance=array_column($res,'distacnce_km');
        array_push($value_distance,10);
        $radious_default=(max($value_distance))/2;




        for($k=0;$k<count($res);$k++)
        {
            $temp=[];
            if(!in_array($res[$k]['cluster_name'],$already_exist))
            {
                 array_push($already_exist,$res[$k]['cluster_name']);
               if(isset($input_query->cluster_name))  
               {
                     $cluster_name=$res[$k]['cluster_name'];
                     $filtered=array_filter($res, function($k,$v) use ($cluster_name) {
                       
                        return $k['cluster_name'] == $cluster_name;
                    }, ARRAY_FILTER_USE_BOTH);
                   
                     $subrd_count=array_sum(array_column($filtered, 'sub_rd_rla'));
                    
                     $vc_count=array_sum(array_column($filtered, 'vc_count'));
                     
               }
               else
               {
                  $subrd_count=$res[$k]['sub_rd_rla'];
                  
                  $vc_count=$res[$k]['vc_count'];
               }
                
                 
                 $temp['cluster_name']=$res[$k]['cluster_name'];
                 $temp['latitude']=$res[$k]['latitude'];
                 $temp['longitude']=$res[$k]['longitude'];
                 $temp['no_of_subrd']=$res[$k]['no_of_subrd'];
                 $temp['so_territory']=$res[$k]['so_territory'];
                 $temp['no_of_tsi']=$res[$k]['no_of_tsi'];
                 $temp['sub_rd_rla']=$subrd_count;
                 $temp['vc_count']=$vc_count;
                 $temp['avg_sale_monthly']=$res[$k]['avg_sale_monthly'];

                 $temp['distacnce_km']=($res[$k]['distacnce_km']>0) ? $res[$k]['distacnce_km'] : $radious_default;
                  $cluster=str_replace("Cluster ","",$res[$k]['cluster_name']);
                  $temp['cluster']=(Int)$cluster;
                 if(!isset($input_query->cluster_name)){
                    $temp['color']='#9459cf';
                    $temp['opacity']=0.3;
                }else
                {
                     $temp['color']='#f44336';
                    $temp['opacity']=0;
                }

                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$k]['cluster_name'].'</h5><div class="d-flex" style="height:max-content;"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$temp['cluster'].'"></span></div></span><h5></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">No. of SubRD in cluster: </span>'.$res[$k]['no_of_subrd'].'</p><p><span style="color:rgb(242, 101, 34)">No. of Sr. TSI Reqd.: </span> 1 </p><p><span style="color:rgb(242, 101, 34)">Total RLA Nos.: </span>'.$subrd_count.'</p><p><span style="color:rgb(242, 101, 34)">Total VC Nos.: </span><span >'.$vc_count.'</span> </p><p><span style="color:rgb(242, 101, 34)">Total Avg. Cluster Sale (Rs.)(Lacs)(L6M): </span><span>'.round($res[$k]['avg_sale_monthly'],2).'</span> </p><p><span style="color:rgb(242, 101, 34)">Cluster Radius (km): </span><span>'.round($res[$k]['distacnce_km'],2).'</span> </p><p><span style="color:rgb(242, 101, 34)">SO Territory: </span><span>'.$res[$k]['so_territory'].'</span> </p></div></div>';
                 array_push($tsi_list['tsi_list'],$temp);
            }

               
            if(!isset($input_query->cluster_name))
            {

                 array_push($value_data,[($k+1), '<a href="#" style="text-decoration:underline" onClick="show_subrd_tsi(22,\''.$temp['cluster_name'].'\')">'.$res[$k]['cluster_name'].'</a>',$res[$k]['no_of_subrd'],$res[$k]['sub_rd_rla'],$res[$k]['vc_count'],$res[$k]['avg_sale_monthly'],round($res[$k]['distacnce_km'],2),$res[$k]['so_territory']]);
                 
            } 
            else
            {
                $temp=[];
                $temp['refid']=$res[$k]['existing_subrd_uid'];
                $temp['subrd_name']=$res[$k]['existing_subrd_name'];
                $temp['subrd_type']=$res[$k]['subrd_type'];
                $temp['latitude']=$res[$k]['subd_latitude'];
                $temp['longitude']=$res[$k]['subd_longitude'];
                $temp['image']='rural_icon/efficient-subrd.png';
                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$k]['existing_subrd_name'].'</h5><div class="d-flex" style="height:max-content;"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$k]['existing_subrd_uid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$k]['subd_villg_name'].' Village</span><br><span style="line-height:1rem;">'.$res[$k]['subd_taluk_name'].' Sub-Distt</span><br><span style="line-height:1rem;">'.$res[$k]['subd_distt_name'].' Distt</span><br><span style="line-height:1rem;">'.$res[$k]['subd_state_name'].' State</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Existng SubRD Code: </span>'.$res[$k]['existing_subrd_uid'].'  </p><p><span style="color:rgb(242, 101, 34)">Existng SubRD Name: </span>'.$res[$k]['existing_subrd_name'].'</p><p><span style="color:rgb(242, 101, 34)">SubRD Type: </span>'.$res[$k]['subrd_type'].'  </p><p><span style="color:rgb(242, 101, 34)">SubRD Tier: </span>'.$res[$k]['subrd_tier'].'</p><p><span style="color:rgb(242, 101, 34)">RLA Nos.: </span><span >'.$res[$k]['sub_rd_rla'].'</span> </p><p><span style="color:rgb(242, 101, 34)">VC Nos.: </span><span>'.$res[$k]['vc_count'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Avg. Monthly Sale (Rs.)(Lacs)(L6M): </span><span>'.$res[$k]['avg_sale_monthly'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Servicing SST Code: </span><span>'.$res[$k]['sst_code'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Servicing SST Name: </span><span>'.$res[$k]['sst_name'].'</span> </p><p><span style="color:rgb(242, 101, 34)">TSI UID: </span><span>'.$res[$k]['tsi_uid'].'</span> </p><p><span style="color:rgb(242, 101, 34)">TSI Name: </span><span>'.$res[$k]['tsi_name'].'</span> </p><p><span style="color:rgb(242, 101, 34)">BI ID: </span><span>'.$res[$k]['subrd_villg_bi_id'].'</span> </p><p><span style="color:rgb(242, 101, 34)">MarketUID: </span><span>'.$res[$k]['subrd_villg_marketuid'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Distance from Cluster Centroid (km): </span><span>'.round($res[$k]['distacnce_km'],2).'</span> </p><p><span style="color:rgb(242, 101, 34)">SO Territory: </span><span>'.$res[$k]['so_territory'].'</span> </p></div></div>';
                array_push($tsi_list['subrd_sst_list'],$temp);
            if(!in_array($res[$k]['sst_code'],$sst_list))
            {
                array_push($sst_list,$res[$k]['sst_code']);
                $temp=[];
                $temp['refid']=$res[$k]['sst_code'];               
                $temp['latitude']=$res[$k]['sst_latitude'];
                $temp['longitude']=$res[$k]['sst_longitude'];
                $temp['image']='images/sst.png';
                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$k]['sst_name'].'</h5><div class="d-flex" style="height:max-content;"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$k]['sst_code'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$k]['sst_villg_name'].' </span><br><span style="line-height:1rem;">'.$res[$k]['sst_taluk_name'].' Sub-Distt</span><br><span style="line-height:1rem;">'.$res[$k]['sst_distt_name'].' Distt</span><br><span style="line-height:1rem;">'.$res[$k]['sst_state_name'].' State</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Servicing SST Code: </span>'.$res[$k]['sst_code'].'</p><p><span style="color:rgb(242, 101, 34)">Servicing SST Name: </span>'.$res[$k]['sst_name'].'  </p><p><span style="color:rgb(242, 101, 34)">TSI UID: </span><span>'.$res[$k]['tsi_uid'].'</span> </p><p><span style="color:rgb(242, 101, 34)">TSI Name: </span><span>'.$res[$k]['tsi_name'].'</span> </p><p><span style="color:rgb(242, 101, 34)">BI ID: </span><span>'.$res[$k]['sst_village_bi_id'].'</span> </p><p><span style="color:rgb(242, 101, 34)">MarketUID: </span><span>'.$res[$k]['sst_village_market_uid'].'</span> </p></div></div>';
                array_push($tsi_list['subrd_sst_list'],$temp);
            }
                 

                 array_push($value_data,[($k+1),$res[$k]['state'],$res[$k]['branch_name'],$res[$k]['region_name'],$res[$k]['asm_area'],$res[$k]['so_territory'],$res[$k]['existing_subrd_uid'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$k]['existing_subrd_uid'].','.$res[$k]['subd_latitude'].','.$res[$k]['subd_longitude'].')">'.$res[$k]['existing_subrd_name'].'</a>',$res[$k]['subrd_type'],$res[$k]['subrd_tier'],$res[$k]['sst_code'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$k]['sst_code'].','.$res[$k]['sst_latitude'].','.$res[$k]['sst_longitude'].')">'.$res[$k]['sst_name'].'</a>',$res[$k]['sst_town'],$res[$k]['town_class'],$res[$k]['tsi_name'],$res[$k]['tsi_uid'],$res[$k]['sub_rd_rla'],$res[$k]['vc_count'],round($res[$k]['avg_sale_monthly'],2),$res[$k]['batch'],round($res[$k]['distacnce_km'],2),$res[$k]['cluster_name'],$res[$k]['avg_biz'],$res[$k]['no_of_days_visited_by_tsi_jan24'],$res[$k]['no_of_days_visited_by_tsi_dec23'],$res[$k]['no_of_days_visited_by_tsi_nov23'],$res[$k]['no_of_days_visited_by_tsi_oct23'],$res[$k]['avg_of_tsi_mandays']]);


            }
             
            
        }

         $message['legend']=[];
           $message['maplist']=[];
        array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$tsi_list;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        if(!isset($input_query->cluster_name))
            $message['head']=[];
        else
        {
           
            $cluster=str_replace("Cluster ","",$res[0]['cluster_name']);

            $message['head']=['Sr. TSI - C'.$cluster.' Cluster'];
        }
          
        
        
         return json_encode($message);
    }
     public function get_sr_tsi($input)
    {
         $input_query=json_decode($input['input']);
          $tsi_list=[];         $tsi_list['tsi_list']=[]; $tsi_list['subrd_sst_list']=[];$tsi_list['sst_list']=[];   $tsi_list['maplist']=[];
          $column=[];       $value_data=[];
         if(!isset($input_query->cluster_name))
         {
             array_push($column, array(
             'title' => '#', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'Cluster Name', 'className' => 'text-left'
             ));
              
              array_push($column, array(
                 'title' => 'No. of subRD in cluster', 'className' => 'text-right'
             ));
              
             //   array_push($column, array(
             //     'title' => 'No. of Sr. TSI Reqd.', 'className' => 'text-right'
             // ));
                array_push($column, array(
                 'title' => 'Total RLA Nos.', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Total VC Nos.', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Cluster Radius (km)', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'SO Territory', 'className' => 'text-left'
             ));
         }
         else
         {
         
            array_push($column, array(
             'title' => '#', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'State', 'className' => 'text-left'
             ));
             //  array_push($column, array(
             //     'title' => 'Year', 'className' => 'text-right'
             // ));
              
             //   array_push($column, array(
             //     'title' => 'Month', 'className' => 'text-right'
             // ));
                array_push($column, array(
                 'title' => 'Branch', 'className' => 'text-left'
             ));
                array_push($column, array(
                 'title' => 'Region', 'className' => 'text-left'
             ));
                array_push($column, array(
                 'title' => 'ASM Area', 'className' => 'text-left'
             ));
                array_push($column, array(
                 'title' => 'SO Territory', 'className' => 'text-left'
             ));

   array_push($column, array(
                 'title' => 'Existing SubRD Code', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Existing SubRD Name', 'className' => 'text-left'
             ));
              array_push($column, array(
                 'title' => 'SubRD Type', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'SubRD Tier', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'SST Code', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'SST Name', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'SST Town', 'className' => 'text-left'
             ));
              array_push($column, array(
                 'title' => 'Town Class', 'className' => 'text-left'
             ));
              array_push($column, array(
                 'title' => 'TSI Name', 'className' => 'text-left'
             ));
              array_push($column, array(
                 'title' => 'TSI Code', 'className' => 'text-right'
             ));
              array_push($column, array(
                 'title' => 'Total RLA Nos.', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'Total VC Nos.', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'Batch', 'className' => 'text-left'
             ));
             array_push($column, array(
                 'title' => 'Cluster Radius (km)', 'className' => 'text-right'
             ));
             array_push($column, array(
                 'title' => 'Cluster', 'className' => 'text-left'
             ));
             // array_push($column, array(
             //     'title' => 'No. of SubRD in cluster', 'className' => 'text-right'
             // ));
             // array_push($column, array(
             //     'title' => 'No. of Sr. TSI Reqd.', 'className' => 'text-right'
             // ));
             // array_push($column, array(
             //     'title' => 'avg_biz', 'className' => 'text-right'
             // ));
             
               array_push($column, array(
                 'title' => 'No. of days visitedby TSI  Jan 24th', 'className' => 'text-right'
             ));
               array_push($column, array(
                 'title' => 'No. of days visitedby TSI  Dec 23rd', 'className' => 'text-right'
             ));
               array_push($column, array(
                 'title' => 'No. of days visitedby TSI  Nov 23rd', 'className' => 'text-right'
             ));
               array_push($column, array(
                 'title' => 'No. of days visitedby TSI  Oct 23rd', 'className' => 'text-right'
             ));
                array_push($column, array(
                 'title' => 'Avg. of TSI Mandays', 'className' => 'text-right'
             ));


         }
          
            
          if(!isset($input_query->cluster_name))
          {

                
                $sql="SELECT sr_tsi_cluster_name as cluster_name,so_territory, `cluster_centroid_latitude` as latitude, `cluster_centroid_longitude` as longitude,`no_of_subrd_in_cluster` no_of_subrd, `no_of_sr_tsi_requird` no_of_tsi, sum(ifnull(`avg_sale_monthly`,0)) as avg_sale_monthly,sum(ifnull(`vc_count`,0)) as vc_count,sum(ifnull(`sub_rd_rla`,0)) as sub_rd_rla, max(`distacnce_km`) distacnce_km,priority FROM `sr_tsi_subrd_cluster_new` group by cluster_name";
          }
          else
          {
             $sql=' SELECT `state`, `year`, `month`, `branch_name`, `region_name`, `asm_area`, `so_territory`, `subrd_villg_bi_id`, `subrd_villg_marketuid`, `subd_state_name`, `subd_distt_name`, `subd_taluk_name`, `subd_villg_name`, `existing_subrd_uid`, `existing_subrd_name`, `subrd_type`, `subrd_tier`, `sst_code`, `sst_latitude`, `sst_longitude`, `sst_village_bi_id`, `sst_village_market_uid`, `2011_census`, `sst_state_name`, `sst_distt_name`, `sst_taluk_name`, `sst_villg_name`, `sst_name`, `sst_town`, `town_class`, `tsi_name`, `tsi_uid`, `sub_rd_rla`, `vc_count`, `avg_sale_monthly`, `batch`, `distacnce_km`, `cluster_centroid_latitude` as latitude, `cluster_centroid_longitude` as longitude, `sr_tsi_cluster_name` as cluster_name, `no_of_subrd_in_cluster` no_of_subrd, `no_of_sr_tsi_requird` no_of_tsi, `refid`,latitude as subd_latitude,longitude as subd_longitude,priority,`avg_biz`, `no_of_days_visited_by_tsi_jan24`, `no_of_days_visited_by_tsi_dec23`, `no_of_days_visited_by_tsi_nov23`, `no_of_days_visited_by_tsi_oct23`, `avg_of_tsi_mandays` FROM `sr_tsi_subrd_cluster_new` where sr_tsi_cluster_name="'.$input_query->cluster_name.'" order by distacnce_km desc';

          }
 
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $already_exist=[];

        for($k=0;$k<count($res);$k++)
        {
            $temp=[];
            if(!in_array($res[$k]['cluster_name'],$already_exist))
            {
                 array_push($already_exist,$res[$k]['cluster_name']);
                 $temp['cluster_name']=$res[$k]['cluster_name'];
                 $temp['latitude']=$res[$k]['latitude'];
                 $temp['longitude']=$res[$k]['longitude'];
                 $temp['no_of_subrd']=$res[$k]['no_of_subrd'];
                 $temp['so_territory']=$res[$k]['so_territory'];
                 $temp['no_of_tsi']=$res[$k]['no_of_tsi'];
                 $temp['sub_rd_rla']=$res[$k]['sub_rd_rla'];
                 $temp['vc_count']=$res[$k]['vc_count'];
                 $temp['avg_sale_monthly']=$res[$k]['avg_sale_monthly'];
                 $temp['distacnce_km']=$res[$k]['distacnce_km'];
                 $temp['priority']=$res[$k]['priority'];
                  $cluster=str_replace("Sr. TSI Cluster ","",$res[$k]['cluster_name']);
                  $temp['cluster']=(Int)$cluster;
                 if(!isset($input_query->cluster_name)){
                    $temp['color']='#9459cf';
                    $temp['opacity']=0.3;
                }else
                {
                     $temp['color']='#f44336';
                    $temp['opacity']=0;
                }

                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$k]['cluster_name'].'</h5><div class="d-flex" style="height:max-content;"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$k]['cluster_name'].'"></span></div></span><h5></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">No. of SubRD in cluster: </span>'.$res[$k]['no_of_subrd'].'</p><p><span style="color:rgb(242, 101, 34)">Total RLA Nos.: </span>'.$res[$k]['sub_rd_rla'].'</p><p><span style="color:rgb(242, 101, 34)">Total VC Nos.: </span><span >'.$res[$k]['vc_count'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Total Avg. Cluster Sale (Rs.)(Lacs)(L6M): </span><span>'.round($res[$k]['avg_sale_monthly'],2).'</span> </p><p><span style="color:rgb(242, 101, 34)">Cluster Radius (km): </span><span>'.round($res[$k]['distacnce_km'],2).'</span> </p></p><p><span style="color:rgb(242, 101, 34)">SO Territory: </span><span>'.$res[$k]['so_territory'].'</span> </p></div></div>';
                 array_push($tsi_list['tsi_list'],$temp);
            }

               
            if(!isset($input_query->cluster_name))
            {

                 array_push($value_data,[($k+1), '<a href="#" style="text-decoration:underline" onClick="show_subrd_tsi(21,\''.$temp['cluster_name'].'\')">'.$res[$k]['cluster_name'].'</a>',$res[$k]['no_of_subrd'],number_format($res[$k]['sub_rd_rla'],0),$res[$k]['vc_count'],$res[$k]['avg_sale_monthly'],round($res[$k]['distacnce_km'],2),$res[$k]['so_territory']]);
                 
            }
            else
            {
                $temp=[];
                $temp['refid']=$res[$k]['existing_subrd_uid'];
                $temp['subrd_name']=$res[$k]['existing_subrd_name'];
                $temp['subrd_type']=$res[$k]['subrd_type'];
                $temp['latitude']=$res[$k]['subd_latitude'];
                $temp['longitude']=$res[$k]['subd_longitude'];
                $temp['priority']=$res[$k]['priority'];
                $temp['image']='rural_icon/efficient-subrd.png';
                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$k]['existing_subrd_name'].'</h5><div class="d-flex" style="height:max-content;"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$k]['existing_subrd_uid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$k]['subd_villg_name'].' Village</span><br><span style="line-height:1rem;">'.$res[$k]['subd_taluk_name'].' Sub-Distt</span><br><span style="line-height:1rem;">'.$res[$k]['subd_distt_name'].' Distt</span><br><span style="line-height:1rem;">'.$res[$k]['subd_state_name'].' State</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Existng SubRD Code: </span>'.$res[$k]['existing_subrd_uid'].'  </p><p><span style="color:rgb(242, 101, 34)">Existng SubRD Name: </span>'.$res[$k]['existing_subrd_name'].'</p><p><span style="color:rgb(242, 101, 34)">SubRD Type: </span>'.$res[$k]['subrd_type'].'  </p><p><span style="color:rgb(242, 101, 34)">SubRD Tier: </span>'.$res[$k]['subrd_tier'].'</p><p><span style="color:rgb(242, 101, 34)">RLA Nos.: </span><span >'.$res[$k]['sub_rd_rla'].'</span> </p><p><span style="color:rgb(242, 101, 34)">VC Nos.: </span><span>'.$res[$k]['vc_count'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Avg. Monthly Sale (Rs.)(Lacs)(L6M): </span><span>'.round($res[$k]['avg_sale_monthly'],2).'</span> </p><p><span style="color:rgb(242, 101, 34)">Servicing SST Code: </span><span>'.$res[$k]['sst_code'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Servicing SST Name: </span><span>'.$res[$k]['sst_name'].'</span> </p><p><span style="color:rgb(242, 101, 34)">TSI UID: </span><span>'.$res[$k]['tsi_uid'].'</span> </p><p><span style="color:rgb(242, 101, 34)">TSI Name: </span><span>'.$res[$k]['tsi_name'].'</span> </p><p><span style="color:rgb(242, 101, 34)">BI ID: </span><span>'.$res[$k]['subrd_villg_bi_id'].'</span> </p><p><span style="color:rgb(242, 101, 34)">MarketUID: </span><span>'.$res[$k]['subrd_villg_marketuid'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Distance from Cluster Centroid (km): </span><span>'.round($res[$k]['distacnce_km'],2).'</span> </p><p><span style="color:rgb(242, 101, 34)">SO Territory: </span><span>'.$res[$k]['so_territory'].'</span> </p></div></div>';
                array_push($tsi_list['subrd_sst_list'],$temp);
                $temp=[];
                $temp['refid']=$res[$k]['sst_code'];               
                $temp['latitude']=$res[$k]['sst_latitude'];
                $temp['longitude']=$res[$k]['sst_longitude'];
                $temp['image']='images/sst.png';
                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$k]['sst_name'].'</h5><div class="d-flex" style="height:max-content;"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$k]['sst_code'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$k]['sst_villg_name'].' Village</span><br><span style="line-height:1rem;">'.$res[$k]['sst_taluk_name'].' Sub-Distt</span><br><span style="line-height:1rem;">'.$res[$k]['sst_distt_name'].' Distt</span><br><span style="line-height:1rem;">'.$res[$k]['sst_state_name'].' State</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Servicing SST Code: </span>'.$res[$k]['sst_code'].'</p><p><span style="color:rgb(242, 101, 34)">Servicing SST Name: </span>'.$res[$k]['sst_name'].'  </p><p><span style="color:rgb(242, 101, 34)">RLA Nos.: </span>'.$res[$k]['sub_rd_rla'].'</p><p><span style="color:rgb(242, 101, 34)">VC Nos.: </span><span >'.$res[$k]['vc_count'].'</span> </p><p><span style="color:rgb(242, 101, 34)">Avg. Monthly Sale (Rs.)(Lacs)(L6M): </span><span>'.round($res[$k]['avg_sale_monthly'],2).'</span> </p><p><span style="color:rgb(242, 101, 34)">TSI UID: </span><span>'.$res[$k]['tsi_uid'].'</span> </p><p><span style="color:rgb(242, 101, 34)">TSI Name: </span><span>'.$res[$k]['tsi_name'].'</span> </p><p><span style="color:rgb(242, 101, 34)">BI ID: </span><span>'.$res[$k]['sst_village_bi_id'].'</span> </p><p><span style="color:rgb(242, 101, 34)">MarketUID: </span><span>'.$res[$k]['sst_village_market_uid'].'</span> </p></div></div>';
                array_push($tsi_list['subrd_sst_list'],$temp);

                 array_push($value_data,[($k+1),$res[$k]['state'],$res[$k]['branch_name'],$res[$k]['region_name'],$res[$k]['asm_area'],$res[$k]['so_territory'],$res[$k]['existing_subrd_uid'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$k]['existing_subrd_uid'].','.$res[$k]['subd_latitude'].','.$res[$k]['subd_longitude'].')">'.$res[$k]['existing_subrd_name'].'</a>',$res[$k]['subrd_type'],$res[$k]['subrd_tier'],$res[$k]['sst_code'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$k]['sst_code'].','.$res[$k]['sst_latitude'].','.$res[$k]['sst_longitude'].')">'.$res[$k]['sst_name'].'</a>',$res[$k]['sst_town'],$res[$k]['town_class'],$res[$k]['tsi_name'],$res[$k]['tsi_uid'],number_format($res[$k]['sub_rd_rla'],0),$res[$k]['vc_count'],$res[$k]['avg_sale_monthly'],$res[$k]['batch'],round($res[$k]['distacnce_km'],2),$res[$k]['cluster_name'],$res[$k]['no_of_days_visited_by_tsi_jan24'],$res[$k]['no_of_days_visited_by_tsi_dec23'],$res[$k]['no_of_days_visited_by_tsi_nov23'],$res[$k]['no_of_days_visited_by_tsi_oct23'],number_format($res[$k]['avg_of_tsi_mandays'],2)]);



            }
             
            
        }

         $message['legend']=[];
           $message['maplist']=[];
        array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$tsi_list;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        if(!isset($input_query->cluster_name))
            $message['head']=[];
        else
        {
            $cluster=str_replace("Sr. TSI Cluster ","",$res[0]['cluster_name']);

            $message['head']=['Sr. TSI - C'.$cluster.' Cluster'];
        }
          
        
        
         return json_encode($message);
    }
    public function getrecommandvillage(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $clicked_lat=$input['clicked_lat'];
        $clicked_lon=$input['clicked_lon'];

      $sql="select town_village_code, if(sector='Rural',concat(town_village_name,' ','Villg.'),if(sector='Urban',concat(town_village_name,' ','Town'),town_village_name)) as town_village_name,state_name,polygon_geo from town_village_polygon where ST_CONTAINS(polygon_geo,POINT('".$clicked_lon."', '".$clicked_lat."'))=1";
         $sql_list = DB::select(DB::raw($sql));
         $sql_highway="SELECT refid,(ST_Distance(highway_geo,POINT('".$clicked_lon."', '".$clicked_lat."'))*100) as distance,highway_name FROM highway_structure having distance < 2";
         $sql_list_highway = DB::select(DB::raw($sql_highway));
         $sql_list_highway_count=count($sql_list_highway);
         $point='0';
         if($sql_list_highway_count>0){
            $point=[];
             for($i=0;$i<$sql_list_highway_count;$i++)
          {
             $point[$i]['id']=$sql_list_highway[$i]->refid;
             $point[$i]['highway_name']=$sql_list_highway[$i]->highway_name;
             $point[$i]['distance']=round($sql_list_highway[$i]->distance,1);
          }
            $point=htmlspecialchars(json_encode($point), ENT_QUOTES, 'UTF-8');
          //$point=json_encode($point);
         }

          
        
         
        $sql_list_count=count($sql_list);
         
        if($sql_list_count > 0)
        {
              
                $info="<div class='tooltip-data no-border'><div class=''><div class='' style='color:#fff;'>".$sql_list[0]->town_village_name. "</div></div>";
            $village_code=$sql_list[0]->town_village_code;
              $sql="SELECT  a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, if(b.sector='Rural',concat(b.town_village_name,' ','Villg.'),if(b.sector='Urban',concat(b.town_village_name,' ','Town'),b.town_village_name)) as village_name, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.`village_choc_consmptn`, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.retlr_universe,a.mdlz_retlr_universe, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.exist_subrd_code,a.exist_subrd_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img FROM `subrd_data` as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code and a.village_census='".$village_code."'  and b.stat='A' ";

             
              $result = DB::select(DB::raw($sql));
              $result=CommonController::getarray($result);
             if(count($result) > 0){
                $info='';
                 
                 $shareinfo='';
               
              if($result[0]['subrd_type'] ==0)
             {
               $result[0]['village_census']=ltrim($result[0]['village_census'], 0);

               // if(isset($maparray[$result[0]['village_census']]))
               // {
                    $cluster_type=$result[0]['subrd_loaction'];
                  $cluster_tag=($result[0]['subrd_type']==1) ? 'Existing' :(($result[0]['subrd_type']==2) ? 'Recommended' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($result[0]['subrd_type']==1) ? 'Existing SubRD' :(($result[0]['subrd_type']==2) ? 'Recommd SubRD' :(($result[0]['subrd_type']==3) ?'Wholesaler' : '')) ;
                   $shareinfo='Village: '.$result[0]['village_name'].'; Taluk: '.$result[0]['taluk_name'].'; Distt: '.$result[0]['district_name'].'; State: '.$result[0]['state_name'].'; Population: '.$result[0]['population'].' Nos.; Rural Progressive Index: '.$result[0]['rpi'].'; Outlet Potential: '.$result[0]['outlet_potential'].' Nos.; Villg. Choc Consumption (Annual) (Rs.): '.number_format((int)$result[0]['village_choc_consmptn'],0).'; Market UID: '.$result[0]['market_id'].'; BI Location ID: '.$result[0]['bi_id'].'; 

                ';
                //$result[0]['village_choc_consmptn']=;

                 $info .='<div class="container-fluid p-3 popupbox" id="ttpm" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$result[0]['village_name'].' &nbsp;</h5><div style="height:max-content;margin-right: -0.7rem;"><img class="ml-1"  src="icons/share-icon.png" height="30px" id="share"><img class="ml-1" geocode="'.$result[0]['latitude'].','.$result[0]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$result[0]['taluk_name'].'  Sub-Distt</span><br><span style="line-height:1rem;">'.$result[0]['district_name'].' Dehat Distt</span></span></h5><div id="rem_lddis"><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State: </span>'.$result[0]['state_name'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">District: </span>'.$result[0]['district_name'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Taluk: </span>'.$result[0]['taluk_name'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.number_format($result[0]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progressive Index: </span><span ><img src="rural_icon/'.$result[0]['rpi_img'].'.jpg"></img></span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$result[0]['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Villg. Choc Consumption (Annual) (Rs.): </span>'.number_format((int)$result[0]['village_choc_consmptn'],0).' </p>';
                 
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$result[0]['market_id'].'</span></p>';
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$result[0]['bi_id'].' </span></p></div>';
           // $result[0]['village_name']=$maparray[$result[0]['village_census']]['location_name'];
                $detail=htmlspecialchars(json_encode([$result[0]]), ENT_QUOTES, 'UTF-8');

                $info .='<hr style="border-top: 1px solid white;"><div class="card text-white mb-3 rounded" style="background-color:#424242;"><div id="acc" class="card-header font-weight-bold text-center p-1 load_result" style="cursor: pointer;text-decoration:underline;">What next?<i id="tak" class="fa fa-caret-right float-right" aria-hidden="true"></i></div></div><div class="load_district" style="text-align:center"><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',1)">Load SubRD Recco for <span style="color:white" >'.$result[0]['district_name'].' </span>  distt?</a><br><br>
             <a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',2)">Load Wholesale Recco for <span style="color:white" >'.$result[0]['district_name'].' </span> distt?</a><br><br><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',3,\''.$result[0]['district_name'].'\','.$result[0]['loc7'].')">Load SubRD Beats for <span style="color:white">'.$result[0]['district_name'].' </span> distt?</a><br><br><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;"   onClick="show_result_popup(\''.$point.'\',4)">Show list of nearest Highway(s)</a></div></div>';
                   
               // }
             }
              else if($result[0]['is_hub']==1 && $result[0]['subrd_type']!=0)
              {
                  $cluster_type=$result[0]['subrd_loaction'];
                  $cluster_tag=($result[0]['subrd_type']==1) ? 'Existing' :(($result[0]['subrd_type']==2) ? 'Recommended' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($result[0]['subrd_type']==1) ? 'Existing SubRD' :(($result[0]['subrd_type']==2) ? 'Recommd SubRD' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                   $shareinfo='Village: '.$result[0]['village_name'].'; Taluk: '.$result[0]['taluk_name'].'; Distt: '.$result[0]['district_name'].'; State: '.$result[0]['state_name'].';Recommendation: '.$cluster_type.'; Distance from '.$cluster_hub.' (km): 0Kms.;  Population: '.$result[0]['population'].' Nos.; Rural Progressive Index: '.$result[0]['rpi'].'; Outlet Potential: '.$result[0]['outlet_potential'].' Nos.; Villg. Choc Consumption (Annual) (Rs.): '.number_format((int)$result[0]['village_choc_consmptn'],0).'; Market UID: '.$result[0]['market_id'].'; BI Location ID: '.$result[0]['bi_id'].';';
                
                 $info .='<div class="container-fluid p-3 popupbox" id="ttpm" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$result[0]['village_name'].' &nbsp;</h5><div style="height:max-content;margin-right: -0.7rem;"><img class="ml-1"  src="icons/share-icon.png" height="30px" id="share"><img class="ml-1" geocode="'.$result[0]['latitude'].','.$result[0]['longitude'].'" onclick="location_navigate(this)"  src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" id="tcls"  src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$result[0]['taluk_name'].' Sub-Distt</span><br><span style="line-height:1rem;">'.$result[0]['district_name'].' Distt</span></span></h5><div id="rem_lddis"><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendation:</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from '.$cluster_hub.' (km): </span>0 kms</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.number_format($result[0]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$result[0]['retlr_universe'].' Nos.</p>';
                 if(in_array($result[0]['subrd_type'],[1]))
                    $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">MDLZ Cvrg Nos: </span>'.$result[0]['mdlz_retlr_universe'].' Nos.</p>';
                 $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Villg. Choc Consumption (Annual) (Rs.): </span>'.number_format((int)$result[0]['village_choc_consmptn'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progressive Index: </span><span ><img src="rural_icon/'.$result[0]['rpi_img'].'.jpg"></img></span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
                 if(in_array($result[0]['subrd_type'],[2,3]))
                 {
                    $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$result[0]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$result[0]['subrd_priority'].'</p>';
                    $shareinfo .='SubRD Priority: '.$result[0]['subrd_priority'].'; SubRD Cluster Priority: '.$result[0]['subrd_priority'].'';
                 }
                 
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$result[0]['market_id'].'</span></p>';
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$result[0]['bi_id'].' </span></p></div>';
             if(in_array($result[0]['subrd_type'],[1]))
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$result[0]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($result[0]['exist_subrd_name'])).' </span></p>';
                $detail=htmlspecialchars(json_encode([$result[0]]), ENT_QUOTES, 'UTF-8');
                // $info .='<div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';
                $info .='<hr style="border-top: 1px solid white;"><div class="card text-white mb-3 rounded" style="background-color:#424242;"><div id="acc" class="card-header font-weight-bold text-center p-1 load_result" style="cursor: pointer;text-decoration:underline;">What next?<i id="tak" class="fa fa-caret-right float-right" aria-hidden="true"></i></div></div><div class="load_district" style="text-align:center"><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',1)">Load SubRD Recco for <span style="color:white" >'.$result[0]['district_name'].' </span>  distt?</a><br><br>
             <a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',2)">Load Wholesale Recco for <span style="color:white" >'.$result[0]['district_name'].' </span> distt?</a><br><br><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',3,\''.$result[0]['district_name'].'\','.$result[0]['loc7'].')">Load SubRD Beats for <span style="color:white">'.$result[0]['district_name'].' </span> distt?</a><br><br><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;"   onClick="show_result_popup(\''.$point.'\',4)">Show list of nearest Highway(s)</a></div></div>';
              }
              else if($result[0]['subrd_type']!=0)
            {
                 $value_json=htmlspecialchars(json_encode([$result[0]]), ENT_QUOTES, 'UTF-8');
                 $cluster_type=$result[0]['subrd_loaction'];
                 $cluster_tag=($result[0]['subrd_type']==1) ? 'Existing' :(($result[0]['subrd_type']==2) ? 'Recommended' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($result[0]['subrd_type']==1) ? 'Existing SubRD' :(($result[0]['subrd_type']==2) ? 'Recommd SubRD' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                   $shareinfo='Village: '.$result[0]['village_name'].'; Taluk: '.$result[0]['taluk_name'].'; Distt: '.$result[0]['district_name'].'; State: '.$result[0]['state_name'].'; Recommendation: '.$cluster_type.'; Distance from '.$cluster_hub.' (km): '.$result[0]['distance_subrd'].'Kms.; Population: '.$result[0]['population'].' Nos.; Rural Progressive Index: '.$result[0]['rpi'].'; Outlet Potential: '.$result[0]['outlet_potential'].' Nos.; Villg. Choc Consumption (Annual) (Rs.): '.number_format((int)$result[0]['village_choc_consmptn'],0).'; Market UID: '.$result[0]['market_id'].'; BI Location ID: '.$result[0]['bi_id'].'; ';
                  
                $info ='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$result[0]['village_name'].' &nbsp;</h5><div style="height:max-content;margin-right: -0.7rem;"><img class="ml-1"  src="icons/share-icon.png" height="30px" id="share"><img class="ml-1" geocode="'.$result[0]['latitude'].','.$result[0]['longitude'].'" onclick="location_navigate(this)"  src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$result[0]['taluk_name'].' Sub-Distt</span><br><span style="line-height:1rem;">'.$result[0]['district_name'].' Distt</span></span></h5><div id="rem_lddis"><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendation:</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from  '.$cluster_hub.' (km): </span>'.$result[0]['distance_subrd'].' kms</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.number_format($result[0]['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$result[0]['retlr_universe'].' Nos.</p>';
                if(in_array($result[0]['subrd_type'],[1]))
                    $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">MDLZ Cvrg Nos: </span>'.$result[0]['mdlz_retlr_universe'].' Nos.</p>';
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Villg. Choc Consumption (Annual) (Rs.): </span>'.number_format((int)$result[0]['village_choc_consmptn'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progressive Index: </span><span ><img src="rural_icon/'.$result[0]['rpi_img'].'.jpg"></img></span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';

           if(in_array($result[0]['subrd_type'],[2,3]))  
           {
            $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$result[0]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$result[0]['subrd_priority'].'</p>';
            $shareinfo .='SubRD Priority: '.$result[0]['subrd_priority'].'; SubRD Cluster Priority: '.$result[0]['subrd_priority'].' ';
           }              
             

             $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$result[0]['market_id'].'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$result[0]['bi_id'].' </span></p></div>';
              if($result[0]['exist_subrd_code']!=null && $result[0]['exist_subrd_code']!='')
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$result[0]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($result[0]['exist_subrd_name'])).' </span></p>';
                $detail=htmlspecialchars(json_encode([$result[0]]), ENT_QUOTES, 'UTF-8');
             // $info .='<div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" onclick="view_village_detail('.$value_json.')">More Info</span></div></div>';
            $info .='<hr style="border-top: 1px solid white;"><div class="card text-white mb-3 rounded" style="background-color:#424242;"><div id="acc" class="card-header font-weight-bold text-center p-1 load_result" style="cursor: pointer;text-decoration:underline;">What next?<i id="tak" class="fa fa-caret-right float-right" aria-hidden="true"></i></div></div><div class="load_district"  style="text-align:center"><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',1)">Load SubRD Recco for <span style="color:white" >'.$result[0]['district_name'].' </span>  distt?</a><br><br>
             <a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',2)">Load Wholesale Recco for <span style="color:white" >'.$result[0]['district_name'].' </span> distt?</a><br><br><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;" onClick="show_result_popup('.$result[0]['loc9'].',3,\''.$result[0]['district_name'].'\','.$result[0]['loc7'].')">Load SubRD Beats for <span style="color:white">'.$result[0]['district_name'].' </span> distt?</a><br><br><a href="#" class="" style="color:#1ae3b1;text-decoration:underline;"  onClick="show_result_popup(\''.$point.'\',4)">Show list of nearest Highway(s)</a></div></div>';
            }
             }
              
            $message=[];
            $message['status']='success';
            $message['info']=$info;
             $message['shareinfo']=$shareinfo;


        }
        else
        {
             $message=[];
            $message['status']='failure';
            $message['info']='';
             $message['shareinfo']='';
        }



        return json_encode($message);
    }
    public function getrecommandvillage_old(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $clicked_lat=$input['clicked_lat'];
        $clicked_lon=$input['clicked_lon'];

      $sql="select town_village_code, if(sector='Rural',concat(town_village_name,' ','Villg.'),if(sector='Urban',concat(town_village_name,' ','Town'),town_village_name)) as town_village_name,state_name,polygon_geo from town_village_polygon where ST_CONTAINS(polygon_geo,POINT('".$clicked_lon."', '".$clicked_lat."'))=1";
         $sql_list = DB::select(DB::raw($sql));
        
         
        $sql_list_count=count($sql_list);
         
        if($sql_list_count > 0)
        {
              
                $info="<div class='tooltip-data no-border'><div class=''><div class='' style='color:#fff;'>".$sql_list[0]->town_village_name. "</div></div>";
            $village_code=$sql_list[0]->town_village_code;
              $sql="SELECT  a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, if(b.sector='Rural',concat(b.town_village_name,' ','Villg.'),if(b.sector='Urban',concat(b.town_village_name,' ','Town'),b.town_village_name)) as village_name, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.`village_choc_consmptn`, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.exist_subrd_code,a.exist_subrd_name FROM `subrd_data` as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code and a.village_census='".$village_code."'  and b.stat='A' ";
              $result = DB::select(DB::raw($sql));
              $result=CommonController::getarray($result);
             if(count($result) > 0){
                $info='';
               
              if($result[0]['subrd_type'] ==0)
             {
               $result[0]['village_census']=ltrim($result[0]['village_census'], 0);
               // if(isset($maparray[$result[0]['village_census']]))
               // {
                    $cluster_type=$result[0]['subrd_loaction'];
                  $cluster_tag=($result[0]['subrd_type']==1) ? 'Existing' :(($result[0]['subrd_type']==2) ? 'Recommended' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($result[0]['subrd_type']==1) ? 'Existing SubRD' :(($result[0]['subrd_type']==2) ? 'Recommd SubRD' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                 $info .='<div class="container-fluid p-3" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row "><h5>'.$result[0]['village_name'].' &nbsp;</h5><span class="d-flex float-right" style="height:max-content;width: 1.3rem;"  geocode="'.$result[0]['latitude'].','.$result[0]['longitude'].'" onclick="location_navigate(this)"><img class="ml-2"  src="icons/navigation-icon.png" height="30px"></span></span><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State: </span>'.$result[0]['state_name'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">District: </span>'.$result[0]['district_name'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Taluk: </span>'.$result[0]['taluk_name'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.number_format($result[0]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progressive Index: </span><span style="background-color:white;color:black;" >'.$result[0]['rpi'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Outlet Potential: </span>'.$result[0]['outlet_potential'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Villg. Choc Consumption (Annual) (Rs.): </span>'.number_format((int)$result[0]['village_choc_consmptn'],0).' </p>';
                 
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$result[0]['market_id'].'</span></p>';
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$result[0]['bi_id'].' </span></p>';
           // $result[0]['village_name']=$maparray[$result[0]['village_census']]['location_name'];
                $detail=htmlspecialchars(json_encode([$result[0]]), ENT_QUOTES, 'UTF-8');

                $info .='<div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';
                   
               // }
             }
              else if($result[0]['is_hub']==1 && $result[0]['subrd_type']!=0)
              {
                  $cluster_type=$result[0]['subrd_loaction'];
                  $cluster_tag=($result[0]['subrd_type']==1) ? 'Existing' :(($result[0]['subrd_type']==2) ? 'Recommended' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($result[0]['subrd_type']==1) ? 'Existing SubRD' :(($result[0]['subrd_type']==2) ? 'Recommd SubRD' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                 $info .='<div class="container-fluid p-3" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row "><h5>'.$result[0]['village_name'].' &nbsp;</h5><span class="d-flex float-right" style="height:max-content;width: 1.3rem;"  geocode="'.$result[0]['latitude'].','.$result[0]['longitude'].'" onclick="location_navigate(this)"><img class="ml-2"  src="icons/navigation-icon.png" height="30px"></span></span><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendation:</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from '.$cluster_hub.' (km): </span>0 kms</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.number_format($result[0]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Outlet Potential: </span>'.$result[0]['outlet_potential'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Villg. Choc Consumption (Annual) (Rs.): </span>'.$result[0]['village_choc_consmptn'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
                 if(in_array($result[0]['subrd_type'],[2,3]))
                 $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$result[0]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$result[0]['subrd_priority'].'</p>';
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$result[0]['market_id'].'</span></p>';
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$result[0]['bi_id'].' </span></p>';
             if(in_array($result[0]['subrd_type'],[1]))
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$result[0]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($result[0]['exist_subrd_name'])).' </span></p>';
                $detail=htmlspecialchars(json_encode([$result[0]]), ENT_QUOTES, 'UTF-8');
                $info .='<div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';
              }
              else if($result[0]['subrd_type']!=0)
            {
                 $value_json=htmlspecialchars(json_encode([$result[0]]), ENT_QUOTES, 'UTF-8');
                 $cluster_type=$result[0]['subrd_loaction'];
                 $cluster_tag=($result[0]['subrd_type']==1) ? 'Existing' :(($result[0]['subrd_type']==2) ? 'Recommended' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($result[0]['subrd_type']==1) ? 'Existing SubRD' :(($result[0]['subrd_type']==2) ? 'Recommd SubRD' :(($result[0]['subrd_type']==3) ?'Wholesaler' : ''));
                $info ='<div class="container-fluid p-3" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row "><h5>'.$result[0]['village_name'].' &nbsp;</h5><span class="d-flex float-right" style="height:max-content;width: 1.3rem;" geocode="'.$result[0]['latitude'].','.$result[0]['longitude'].'" onclick="location_navigate(this)"><img class="ml-2" src="icons/navigation-icon.png" height="30px"/></span></span><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendation:</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from  '.$cluster_hub.' (km): </span>'.$result[0]['distance_subrd'].' kms</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.number_format($result[0]['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Outlet Potential: </span>'.$result[0]['outlet_potential'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Villg. Choc Consumption (Annual) (Rs.): </span>'.$result[0]['village_choc_consmptn'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
           if(in_array($result[0]['subrd_type'],[2,3]))                
             $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$result[0]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$result[0]['subrd_priority'].'</p>';

             $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$result[0]['market_id'].'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$result[0]['bi_id'].' </span></p>';
              if($result[0]['exist_subrd_code']!=null && $result[0]['exist_subrd_code']!='')
                $info .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$result[0]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($result[0]['exist_subrd_name'])).' </span></p>';

             $info .='<div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" onclick="view_village_detail('.$value_json.')">More Info</span></div></div>';
            }
             }
              
            $message=[];
            $message['status']='success';
            $message['info']=$info;


        }
        else
        {
             $message=[];
            $message['status']='failure';
            $message['info']='';
        }



        return json_encode($message);
    }
    public function comparejson()
    {
        $dir = "D:\biappserver\htdocs\converter_locality\Json\Agra";

        $files = scandir($dir);
        $path = "";
        $filearray = [];

        for ($i = 0; $i < count($files); $i++) {
            if ($files[$i] != "." && $files[$i] != "..") {
                $exe = explode("_", $files[$i]);
                $filearray[$exe[0]] = $exe[0] . " exists";
            }
        }

        //13941 - Ahmadabad -- gj_d_15_ct_2
        //13346 - mumbai --mh_d_34_ct_1
        //1074 - Coimbatore -tn_12_6_ct_23
        //14216 - Gurugram -hr_d_19_ct_3
        //18590 - Haora -wb_d_16_ct_1
        //18322 - Hyderabad - ap_d_23_ct_1
        //786 -Jaipur - rj_d_15_ct_1
        //15196- Kochi -kl_8_3_ct_14
        //13731-Ludhiana-pb_d_11_ct_1
        //13509-Pimpri Chinchwad-mh_d_22_ct_1
        //13577-Thane-mh_d_20_ct_2
        //18886-Delhi - dl_d_1_ct_22

        $sql =
            "select refid as loc_id,location_name as name,refid,1872 as pc_uid,map_id from ward_master where city_id=1 and stat='A' ";
        $res = DB::select(DB::raw($sql));
        $str = "";
        for ($i = 0; $i < count($res); $i++) {
            if (isset($filearray[$res[$i]->refid])) {
                $str .=
                    "<b>" .
                    $res[$i]->refid .
                    " | " .
                    $res[$i]->name .
                    " | " .
                    $res[$i]->map_id .
                    " | Exist</b><br>";
            } else {
                $str .=
                    "<b>" .
                    $res[$i]->refid .
                    " | " .
                    $res[$i]->name .
                    " | " .
                    $res[$i]->map_id .
                    " | Not Exist</b><br>";
            }
        }

        return $str;
    }

    public function loadmapPost(Request $request)
    {
        $input = $request->all();
        $load_data = [];
        $user = auth()->user();
        $user_id = $user->id;
        $subname = "";
       
        $getfilter = json_decode($input["input"]);
        //\Log::info($getfilter->filter_highway);
        
        // if(!isset($getfilter->filter_highway) && $getfilter->type!=13 && !isset($getfilter->filter_subrdbeat) && $getfilter->type!=14 &&  !isset($getfilter->show_level))
       //  $getfilter->type = isset($getfilter->type) ? $getfilter->type : null;
        if(!isset($getfilter->filter_highway) && !isset($getfilter->filter_sstbeat) && !isset($getfilter->filter_type)  && !in_array($getfilter->type,[13,19,14,15,17,21,22,23,18,180]) && !isset($getfilter->filter_subrdbeat) && !isset($getfilter->filterby_cknbhrd) &&  !isset($getfilter->show_level)  && !isset($getfilter->filter_sstsubrdbeat) && !isset($getfilter->filter_rd))
        {
         $nextlevelarray=[];

        if (!empty($input) && isset($input["initialmap"])) {
            if($user->user_type=='TSM' && ((isset($getfilter->filter_byvillagedist) && count($getfilter->filter_byvillagedist)>0) || (isset($getfilter->filter_byvillagetaluk) && count($getfilter->filter_byvillagetaluk)>0) || (isset($getfilter->filter_byconsolidatedist) && count($getfilter->filter_byconsolidatedist)>0) || (isset($getfilter->filter_byconsolidatetaluk) && count($getfilter->filter_byconsolidatetaluk)>0) || (isset($getfilter->filter_district) && count($getfilter->filter_district)>0) || (isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0) || (isset($getfilter->filter_country) && count($getfilter->filter_country)>0) || (isset($getfilter->filter_byward) && count($getfilter->filter_byward)>0) || (isset($getfilter->filter_village) && count($getfilter->filter_village)>0) )){


                $load_file_list=[];
                $getfilter = json_decode($input["input"]);
                $result = [];
                $message = [];
                $message["maplist"] = [];
                $nextlevelarray = [];
                $level_info=[];
                $district_info=[];
             if((!isset($getfilter->filter_country)) && (!isset($getfilter->filter_village))){
                if((isset($getfilter->filter_district) && count($getfilter->filter_district)>0) || (isset($getfilter->filter_byconsolidatedist) && count($getfilter->filter_byconsolidatedist)>0) || (isset($getfilter->filter_byconsolidatetaluk) && count($getfilter->filter_byconsolidatetaluk)>0) || (isset($getfilter->filter_byvillagedist) && count($getfilter->filter_byvillagedist)>0) || (isset($getfilter->filter_byvillagetaluk) && count($getfilter->filter_byvillagetaluk)>0) ||  (isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0))
                {
                    $level_id=(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0) ? 10 : 7;
                      $map_level = DB::table("map_level")
                    ->where("refid", $level_id)
                    ->select([
                        "refid",
                        "map_label",
                        "main_location",
                        "sub_location",
                        "sub_location_temp",
                        "suffix",
                        "child",
                    ])
                    ->first();
                   
                $geo_level = DB::table("Geo_Hrchy_master")
                    ->where("refid", $map_level->sub_location)
                    ->select(["geo_level", "name1", "name2", "master_table"])
                    ->first();
                $geo_table = DB::table("Geo_Hrchy_master")
                    ->where("refid", $map_level->main_location)
                    ->select([
                        "geo_level",
                        "name1",
                        "name2",
                        "master_table",
                        "table_name",
                    ])
                    ->first();
                $subname_table = DB::table("map_level")
                    ->where([
                        ["main_location", $map_level->main_location],
                        ["sub_location", $map_level->sub_location],
                    ])
                    ->select(["map_label"])
                    ->first();
                $orwhere=[];$andwhere=[];
                if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
                    array_push($orwhere,"loc9 in (".implode(",",$getfilter->filter_district).")");
                if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
                    array_push($orwhere,"taluk_code in (".implode(",",$getfilter->filter_taluk).")");
                 if(isset($getfilter->filter_byvillagetaluk) && count($getfilter->filter_byvillagetaluk)>0)
                    array_push($orwhere,"taluk_code in (".implode(",",$getfilter->filter_byvillagetaluk).")");
                if(isset($getfilter->filter_byvillagedist) && count($getfilter->filter_byvillagedist)>0)
                    array_push($orwhere,"loc9 in (".implode(",",$getfilter->filter_byvillagedist).")");
                 if(isset($getfilter->filter_byconsolidatetaluk) && count($getfilter->filter_byconsolidatetaluk)>0)
                    array_push($orwhere,"taluk_code in (".implode(",",$getfilter->filter_byconsolidatetaluk).")");
                if(isset($getfilter->filter_byconsolidatedist) && count($getfilter->filter_byconsolidatedist)>0)
                    array_push($orwhere,"loc9 in (".implode(",",$getfilter->filter_byconsolidatedist).")");

                array_push($andwhere,"stat='A'");

                   $sql="SELECT   loc7, loc9,refid as loc_id,town_village_code as village_census,if(sector='Rural',concat(town_village_name,' ','villg.'),if(sector='Urban',concat(town_village_name,' ','town'),town_village_name)) as location_name,latitude,longitude,0 as nxt_mp_level,taluk_code FROM `town_village_polygon` where stat='A' and  (".join(" or ",$orwhere).")";
                 
                   // $sql="SELECT   loc7, loc9,refid as loc_id,town_village_code as village_census,town_village_name as location_name,latitude,longitude,0 as nxt_mp_level,taluk_code FROM `town_village_polygon` where stat='A' and  (".join(" or ",$orwhere).")";
                 
                  // $sql="SELECT a.loc7, a.loc9,b.refid,b.refid as loc_id, `village_census`,b.town_village_name as location_name,b.latitude,b.longitude,0 as nxt_mp_level FROM `subrd_data` as a,town_village_polygon as b WHERE a.village_census =b.town_village_code and a.tsm_id=".$user->id." and a.loc9 in (".implode(",",$getfilter->filter_district).")";
                  $res = DB::select(DB::raw($sql));
                $result = [];
                $message = [];
                $message["maplist"] = [];
                $nextlevelarray = [];
                $level_info=[];
                $district_info=[];
               
                for ($i_ = 0; $i_ < count($res); $i_++) {
                    if($res[$i_]->loc7 != 0 && $res[$i_]->loc9 != 0)
                    {
                        $level_info=['loc7'=>$res[$i_]->loc7,'loc9'=>$res[$i_]->loc9];
                         $district_info[$res[$i_]->taluk_code]=$res[$i_]->loc9;
                    }
                            
                     $nextlevelarray[$res[$i_]->village_census] = [
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
               
                $subname = $subname_table->map_label;
               }
           }

                if((isset($getfilter->filter_country) && count($getfilter->filter_country) >0) || (isset($getfilter->filter_village) && count($getfilter->filter_village) >0)  )
            {
                $level_data_id=(isset($getfilter->filter_country)) ? 4 :  5;
                $sql="SELECT `refid`, `location_id`, `level_name`, `level_id`, `stat`, `latitude`, `longitude`, `location_name`, `parent_id`, `child_flag`, `country_id` FROM `country_level_data` WHERE level_id=".$level_data_id." and country_id=91";
                $res = DB::select(DB::raw($sql));
                  for ($i_ = 0; $i_ < count($res); $i_++) {
                $nextlevelarray[$res[$i_]->refid] = [
                            "nxt_mp_level" => 0,
                            "loc_id" => $res[$i_]->refid,
                            "current_level" => 0,
                            "main_location" => 0,
                            "sub_location" => 0,
                            "location_name" =>$res[$i_]->location_name,
                            "latitude" => $res[$i_]->latitude,
                            "longitude" => $res[$i_]->longitude,
                            "loc7" => 0,
                            "loc9" => 0,
                        ];
                 $loadmap =(isset($getfilter->filter_country)) ? "country/indonesia.geojson" : "country/dollok.geojson";
                     
                        if (!in_array($loadmap, $load_file_list)) {
                        array_push($load_file_list, $loadmap);
                        
                        if (file_exists(public_path() . "/" . $loadmap)) {
                           
                            $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $path);
                        }
                        array_push($message["maplist"], $path);

                    }
                }
            }
             if((isset($getfilter->filter_byward) && count($getfilter->filter_byward) >0) || (isset($getfilter->filter_byward) && count($getfilter->filter_byward) >0)  )
            {
               
                $sql="SELECT `refid`,  `loc12`,  `location_name`, `latitude`, `longitude`, `stat` FROM `ward_master` WHERE loc12 in (13941) and stat='A'";
               
                $res = DB::select(DB::raw($sql));
                  for ($i_ = 0; $i_ < count($res); $i_++) {
                $nextlevelarray[$res[$i_]->refid] = [
                            "nxt_mp_level" => 0,
                            "loc_id" => $res[$i_]->refid,
                            "current_level" => 0,
                            "main_location" => 0,
                            "sub_location" => 0,
                            "location_name" =>$res[$i_]->location_name,
                            "latitude" => $res[$i_]->latitude,
                            "longitude" => $res[$i_]->longitude,
                            "loc7" => 0,
                            "loc9" => 0,
                        ];
                 $loadmap ="mapshape/city_ward/13941_12_15.geojson";
                
                        if (!in_array($loadmap, $load_file_list)) {
                        array_push($load_file_list, $loadmap);
                        
                        if (file_exists(public_path() . "/" . $loadmap)) {
                           
                            $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $path);
                        }
                       

                    }
                }
            }
             if(isset($getfilter->filter_byvillagetaluk) && count($getfilter->filter_byvillagetaluk) >0)
            {
                
                 $sql_code="Select  loc7,loc9,taluk_code as taluk_id from town_village_polygon where taluk_code in (".implode(",",$getfilter->filter_byvillagetaluk).") and stat='A'";
                $res_code = DB::select(DB::raw($sql_code));
                $level_info_=[];
                for($m=0;$m<count($res_code);$m++)
                {
                            $level_info_[$res_code[$m]->taluk_id]=['state_id'=>$res_code[$m]->loc7,'district_id'=>$res_code[$m]->loc9];
                }


                 for($i=0;$i<count($getfilter->filter_byvillagetaluk);$i++){

                    $taluk_id=ltrim($getfilter->filter_byvillagetaluk[$i], 0);
                    //$taluk_id=$getfilter->filter_taluk[$i];
                  $loadmap ="mapshape/district_taluk/" .
                        $level_info_[$taluk_id]['state_id'] .
                        "/" .$level_info_[$taluk_id]['district_id']."/".
                      $taluk_id .
                        "_10_" .
                        $map_level->sub_location .
                        ".geojson";
                       
                        if (!in_array($loadmap, $load_file_list)) {
                        array_push($load_file_list, $loadmap);
                        $location_level_id = $res[$i]->loc_id;
                       // array_push($message["maplist"], $loadmap);
                       
                        if (file_exists(public_path() . "/" . $loadmap)) {
                           
                            $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $path);
                        }
                    }

               }
            }
             if(isset($getfilter->filter_byconsolidatetaluk) && count($getfilter->filter_byconsolidatetaluk) >0)
            {
                
                 $sql_code="Select  loc7,loc9,taluk_code as taluk_id from town_village_polygon where taluk_code in (".implode(",",$getfilter->filter_byconsolidatetaluk).") and stat='A'";
                $res_code = DB::select(DB::raw($sql_code));
                $level_info_=[];
                for($m=0;$m<count($res_code);$m++)
                {
                            $level_info_[$res_code[$m]->taluk_id]=['state_id'=>$res_code[$m]->loc7,'district_id'=>$res_code[$m]->loc9];
                }


                 for($i=0;$i<count($getfilter->filter_byconsolidatetaluk);$i++){

                    $taluk_id=ltrim($getfilter->filter_byconsolidatetaluk[$i], 0);
                    //$taluk_id=$getfilter->filter_taluk[$i];
                  $loadmap ="mapshape/district_taluk/" .
                        $level_info_[$taluk_id]['state_id'] .
                        "/" .$level_info_[$taluk_id]['district_id']."/".
                      $taluk_id .
                        "_10_" .
                        $map_level->sub_location .
                        ".geojson";
                       
                        if (!in_array($loadmap, $load_file_list)) {
                        array_push($load_file_list, $loadmap);
                        $location_level_id = $res[$i]->loc_id;
                       // array_push($message["maplist"], $loadmap);
                       
                        if (file_exists(public_path() . "/" . $loadmap)) {
                           
                            $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $path);
                        }
                    }

               }
            }
            if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk) >0)
            {
               
                 $sql_code="Select  loc7,loc9,taluk_code as taluk_id from town_village_polygon where taluk_code in (".implode(",",$getfilter->filter_taluk).") and stat='A'";
                $res_code = DB::select(DB::raw($sql_code));
                $level_info_=[];
                for($m=0;$m<count($res_code);$m++)
                {
                            $level_info_[$res_code[$m]->taluk_id]=['state_id'=>$res_code[$m]->loc7,'district_id'=>$res_code[$m]->loc9];
                }


                 for($i=0;$i<count($getfilter->filter_taluk);$i++){

                    $taluk_id=ltrim($getfilter->filter_taluk[$i], 0);
                    //$taluk_id=$getfilter->filter_taluk[$i];
                  $loadmap ="mapshape/district_taluk/" .
                        $level_info_[$taluk_id]['state_id'] .
                        "/" .$level_info_[$taluk_id]['district_id']."/".
                      $taluk_id .
                        "_" .
                        $map_level->main_location .
                        "_" .
                        $map_level->sub_location .
                        ".geojson";
                      // die;
                        if (!in_array($loadmap, $load_file_list)) {
                        array_push($load_file_list, $loadmap);
                        $location_level_id = $res[$i]->loc_id;

                       
                        if (file_exists(public_path() . "/" . $loadmap)) {
                           
                            $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $path);
                        }
                    }

               }
            }
             if(isset($getfilter->filter_byconsolidatedist) && count($getfilter->filter_byconsolidatedist) >0) 
            {

                $sql_code="Select  loc7,loc9 from town_village_polygon where loc9 in (".implode(",",$getfilter->filter_byconsolidatedist).")";
                $res_code = DB::select(DB::raw($sql_code));
                $level_info_=[];
                for($m=0;$m<count($res_code);$m++)
                {
                            $level_info_[$res_code[$m]->loc9]=$res_code[$m]->loc7;
                }



                for($i=0;$i<count($getfilter->filter_byconsolidatedist);$i++){
                 $loadmap ="./../../mapshapes/district_village/" .
                        $level_info_[$getfilter->filter_byconsolidatedist[$i]] .
                        "/" .
                      $getfilter->filter_byconsolidatedist[$i] .
                        "_" .
                        $map_level->main_location .
                        "_" .
                        $map_level->sub_location .
                        ".geojson";
                      // echo $loadmap;die;
                        if (!in_array($loadmap, $load_file_list)) {
 
                        array_push($load_file_list, $loadmap);
                        $location_level_id = $res[$i]->loc_id;
                         //array_push($message["maplist"], $loadmap);

                       // if (file_exists(public_path() . "/" . $loadmap)) {

                           // $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $loadmap);
                      //  }
                    }

               }
            }
             if(isset($getfilter->filter_byvillagedist) && count($getfilter->filter_byvillagedist) >0) 
            {

                $sql_code="Select  loc7,loc9 from town_village_polygon where loc9 in (".implode(",",$getfilter->filter_byvillagedist).")";
                $res_code = DB::select(DB::raw($sql_code));
                $level_info_=[];
                for($m=0;$m<count($res_code);$m++)
                {
                            $level_info_[$res_code[$m]->loc9]=$res_code[$m]->loc7;
                }



                for($i=0;$i<count($getfilter->filter_byvillagedist);$i++){
                 $loadmap ="mapshape/district_village/" .
                        $level_info_[$getfilter->filter_byvillagedist[$i]] .
                        "/" .
                      $getfilter->filter_byvillagedist[$i] .
                        "_" .
                        $map_level->main_location .
                        "_" .
                        $map_level->sub_location .
                        ".geojson";
                      // echo $loadmap;die;
                        if (!in_array($loadmap, $load_file_list)) {
 
                        array_push($load_file_list, $loadmap);
                        $location_level_id = $res[$i]->loc_id;
                         //array_push($message["maplist"], $loadmap);

                        if (file_exists(public_path() . "/" . $loadmap)) {

                            $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $path);
                        }
                    }

               }
            }
            if(isset($getfilter->filter_district) && count($getfilter->filter_district) >0)
            {
                $sql_code="Select  loc7,loc9,'' rpi_img from town_village_polygon where loc9 in (".implode(",",$getfilter->filter_district).")";
                $res_code = DB::select(DB::raw($sql_code));
                $level_info_=[];
                for($m=0;$m<count($res_code);$m++)
                {
                            $level_info_[$res_code[$m]->loc9]=$res_code[$m]->loc7;
                }



                for($i=0;$i<count($getfilter->filter_district);$i++){
                 $loadmap ="mapshape/district_village/" .
                        $level_info_[$getfilter->filter_district[$i]] .
                        "/" .
                      $getfilter->filter_district[$i] .
                        "_" .
                        $map_level->main_location .
                        "_" .
                        $map_level->sub_location .
                        ".geojson";
                       // echo $loadmap;die;
                        if (!in_array($loadmap, $load_file_list)) {
 
                        array_push($load_file_list, $loadmap);
                        $location_level_id = $res[$i]->loc_id;

                        if (file_exists(public_path() . "/" . $loadmap)) {

                            $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $path);
                        }
                    }

               }
            }

               
                $message["map_nextlevel_info"] = $nextlevelarray;
                $message["label"] = "";
                $namespace = "App\Http\Controllers\\";
                $controllerName = $namespace . "CommonController";
                $combine_obj = new $controllerName();
                $change = json_decode($input["input"], true);
                $value = array_values($nextlevelarray);
                $loc12 = array_unique(array_column($value, "loc12"));
                $head ='';
                $data["head"] = $head;
                $message["head"] = $data["head"];
                $message["griddata"] =[];
                $message["legend"] =[];
                $so_id=0;

                 //return response()->json($message);
                
              


            } else {
               
                // $load_file_list = [];
                // $map_level = DB::table("map_level")
                //     ->where("refid", 26)
                //     ->select([
                //         "refid",
                //         "map_label",
                //         "main_location",
                //         "sub_location",
                //         "sub_location_temp",
                //         "suffix",
                //         "child",
                //     ])
                //     ->first();
                // $geo_level = DB::table("Geo_Hrchy_master")
                //     ->where("refid", $map_level->sub_location)
                //     ->select(["geo_level", "name1", "name2", "master_table"])
                //     ->first();
                // $geo_table = DB::table("Geo_Hrchy_master")
                //     ->where("refid", $map_level->main_location)
                //     ->select([
                //         "geo_level",
                //         "name1",
                //         "name2",
                //         "master_table",
                //         "table_name",
                //     ])
                //     ->first();
                // $subname_table = DB::table("map_level")
                //     ->where([
                //         ["main_location", $map_level->main_location],
                //         ["sub_location", $map_level->sub_location],
                //     ])
                //     ->select(["map_label"])
                //     ->first();

                // // echo  $sql="SELECT distinct(a.loc15) as loc_id,loc12,b.refid,b.name FROM `mdlz_retailer_master` as a, mdlz_distbr_master as b,city_master as c  where a.sheet_ref like '%18%' and a.fld1744=b.refid and loc12=c.refid and a.stat='A' and b.stat='A' and loc15 !=0  and a.salesman_id='".$user_id."' order by b.refid  asc ";die;

                // // $sql="SELECT distinct(a.loc15) as loc_id,GROUP_CONCAT(a.loc16) as loc16,loc12 FROM `mdlz_retailer_master` as a, mdlz_distbr_master as b,city_master as c where a.sheet_ref like '%18%' and a.fld1744=b.refid and loc12=c.refid and a.stat='A' and b.stat='A' and loc15 !=0 and a.salesman_id='".$user_id."' group by a.loc15,a.loc12 order by b.refid asc";
                // $getfilter = json_decode($input["input"]);
                // if ($user->user_type == "TSM") {
                //      $so_id = 0;
                // }
                // else if ($user->user_type == "SO" || $user->user_type == "SUPPORT") {
                //     $so_id = $user->id;
                // } elseif (
                //     $user->user_type == "ASM" &&
                //     isset($getfilter->filter_byso) &&
                //     $getfilter->filter_byso != ""
                // ) {
                //     $so_id = $getfilter->filter_byso;
                // } elseif (
                //     $user->user_type == "ASM" &&
                //     isset($getfilter->filter_so) &&
                //     count($getfilter->filter_so) > 0
                // ) {
                //     $so_id = implode(",", $getfilter->filter_so);
                // }

                // $condn = [];

                // if (
                //     isset($getfilter->filter_pc) &&
                //     count($getfilter->filter_pc) > 0
                // ) {
                //     $pc_user = implode(",", $getfilter->filter_pc);

                //     if ($pc_user != "") {
                //         array_push(
                //             $condn,
                //             "and b.pc_uid in (" . $pc_user . ")"
                //         );
                //     }
                // }
                // if (isset($getfilter->filter_byso)) {
                //     // $so_id=$getfilter->filter_byso;

                //     // $subordinate="select group_concat(pc_uid) as pc_uid from users where reports_to in ('".$selected_so_id."') and status='Active' group by reports_to";
                //     // $res_subordinate = DB::select(DB::raw($subordinate));
                //     // $selected_pc_user=$res_subordinate[0]->pc_uid;
                //     // if($selected_pc_user != '')
                //     //   array_push($condn, "and b.pc_uid in (".$selected_pc_user.")");
                // }

                // if (
                //     isset($getfilter->filter_distributor) &&
                //     count($getfilter->filter_distributor) > 0
                // ) {
                //     $distributor_list = implode(
                //         ",",
                //         $getfilter->filter_distributor
                //     );
                //     array_push(
                //         $condn,
                //         "and b.fld1744 in (" . $distributor_list . ")"
                //     );
                // }
                // $criteria = join(" ", $condn);

                // $sql =
                //     "SELECT distinct(d.refid) as loc_id,group_concat(loc16) as loc16,c.loc12,a.pc_uid  FROM `users` as a,loclty_pc_link as b,colony_master as c, ward_master as d  where a.pc_uid=b.pc_uid and b.loc16=c.refid and c.loc15=d.refid and a.reports_to in (" .
                //     $so_id .
                //     ") $criteria group by d.refid,c.loc12,a.pc_uid ";

                // //$sql="select refid as loc_id,city_id as loc12,location_name as name,refid,1872 as pc_uid from ward_master where city_id=13346 and stat='A' ";

                // $res = DB::select(DB::raw($sql));
                // $result = [];
                // $message = [];
                // $message["maplist"] = [];
                // $nextlevelarray = [];

                // for ($i = 0; $i < count($res); $i++) {
                //     $colony_arr = explode(",", $res[$i]->loc16);

                //     $next_maptable = DB::table($geo_level->master_table)
                //         ->where([
                //             ["loc12", "=", $res[$i]->loc12],
                //             ["loc15", "=", $res[$i]->loc_id],
                //         ])
                //         ->whereIn("refid", $colony_arr)
                //         ->select([
                //             "refid",
                //             "location_name",
                //             "nxt_mp_level",
                //             "loc_id",
                //             "latitude",
                //             "longitude",
                //             "loc12",
                //             "loc15",
                //         ])
                //         ->get();

                //     // $next_maptable = DB::table($geo_level->master_table)->where([['loc12','=',$res[$i]->loc12],['loc15','=',$res[$i]->loc_id]])->select(['refid','location_name','nxt_mp_level','loc_id','latitude','longitude','loc12','loc15'])->get();
                //     $subname = $subname_table->map_label;

                //     for ($i_ = 0; $i_ < count($next_maptable); $i_++) {
                //         $nextlevelarray[$next_maptable[$i_]->refid] = [
                //             "nxt_mp_level" => $next_maptable[$i_]->nxt_mp_level,
                //             "loc_id" => $next_maptable[$i_]->loc_id,
                //             "current_level" => 26,
                //             "main_location" => $map_level->main_location,
                //             "sub_location" => $map_level->sub_location,
                //             "location_name" =>
                //                 $next_maptable[$i_]->location_name,
                //             "latitude" => $next_maptable[$i_]->latitude,
                //             "longitude" => $next_maptable[$i_]->longitude,
                //             "loc12" => $next_maptable[$i_]->loc12,
                //             "loc15" => $next_maptable[$i_]->loc15,
                //             "pc_uid" => $res[$i]->pc_uid,
                //         ];
                //     }
                //     $country_id = 1;

                //     $loadmap =
                //         "mapshape/" .
                //         $res[$i]->loc12 .
                //         "/" .
                //         $res[$i]->loc_id .
                //         "_" .
                //         $map_level->main_location .
                //         "_" .
                //         $map_level->sub_location .
                //         ".txt";
                //     //echo $loadmap . "</br>";
                //     if (!in_array($loadmap, $load_file_list)) {
                //         array_push($load_file_list, $loadmap);
                //         $location_level_id = $res[$i]->loc_id;

                //         if (file_exists(public_path() . "/" . $loadmap)) {
                //             $path = url("/") . "/" . $loadmap;
                //             array_push($message["maplist"], $path);
                //         }
                //     }
                //     if($user->user_type=='TSM' )
                //         $message["maplist"]=[];
                // }

                // $message["map_nextlevel_info"] = $nextlevelarray;
                // $message["label"] = "";
                // $data["griddata"]=[];
                // $namespace = "App\Http\Controllers\\";
                // $controllerName = $namespace . "CommonController";
                // $combine_obj = new $controllerName();
                // $change = json_decode($input["input"], true);
                // $value = array_values($nextlevelarray);
                // $loc12 = array_unique(array_column($value, "loc12"));
                // $head = CommonController::headline($loc12);
                // $data["head"] = $head;
                // //$message["head"] = $data["head"];
                // //$message["griddata"] = $data["griddata"];
                $load_file_list=[];
                $message=[];
                $message["maplist"]=[];
                $restrict_arr=array(21,1,5,9);
          

              if(in_array($input['initialmap'],array(0,-1,2)) && !isset($getfilter->filter_beat))
              {

                  $message=array();$res=array();
                  //$getfilter->location = $getfilter->location ?? null; 
                  if(!isset($getfilter->loc_level))                 
                      $res=array('loc_level'=>16,'loc_id'=>$getfilter->location);               
                  else
                {
                   
                    $res['loc_level']=$getfilter->loc_level;
                    $res['loc_id']=$getfilter->loc_id;
                }
                
                $map_level = DB::table('map_level')->where('refid', $res['loc_level'])->select(['refid', 'map_label', 'main_location', 'sub_location', 'sub_location_temp', 'suffix', 'child','label_toggle as map_label'])
                    ->first();

                $geo_level = DB::table('Geo_Hrchy_master')->where('refid', $map_level->sub_location)
                    ->select(['geo_level', 'name1', 'name2', 'master_table'])
                    ->first();
                $geo_table = DB::table('Geo_Hrchy_master')->where('refid', $map_level->main_location)
                    ->select(['geo_level', 'name1', 'name2', 'master_table', 'table_name'])
                    ->first();

              

                $parent_location = DB::table($geo_table->master_table)
                    ->where('refid', $res['loc_id'])->select(['location_name'])
                    ->first();

          $subname= (!in_array($map_level->main_location,$restrict_arr) && !in_array($map_level->main_location,$restrict_arr)) ? $map_level->map_label : $subname='';
         $master_count=explode(",",$geo_level->master_table);

         if(count($master_count) > 1)
        {
            $maptable = DB::table($master_count[0])->where('refid', $res['loc_id'])->select(['refid', 'location_name', 'nxt_mp_level', 'loc_id'])
                        ->first();
                    if (empty($maptable)) $maptable = DB::table($master_count[1])->where('refid', $res['loc_id'])->select(['refid', 'location_name', 'nxt_mp_level', 'loc_id'])
                        ->first();
                    $sql = 'SELECT loc5,refid,concat(location_name,\' \',\'villg\') as location_name,nxt_mp_level,loc_id,latitude,longitude FROM village_master where loc' . $map_level->main_location . '=' . $res['loc_id'] . ' and stat="A" union select loc5, refid,concat(location_name,\' \',\'town\') as location_name,nxt_mp_level,loc_id,latitude,longitude from city_master where loc' . $map_level->main_location . '=' . $res['loc_id'] . ' and stat="A"';
                    $next_maptable = DB::select(DB::raw($sql));
                    $subname = '';
        }
        else
        {
                 $maptable = DB::table($geo_level->master_table)
                        ->where('refid', $res['loc_id'])->select(['refid', 'location_name', 'nxt_mp_level', 'loc_id'])
                        ->first();

                    if ($geo_level->master_table == 'globe_master' || $geo_level->master_table == 'world_master' || $geo_level->master_table == 'country_master') $next_maptable = DB::table($geo_level->master_table)
                        ->select(['refid','refid as loc5', 'location_name', 'nxt_mp_level', 'loc_id', 'latitude', 'longitude'])
                        ->get();
                    else
                    {
                        if ($geo_level->master_table != 'state_master')
                        {
                            $location_subname = DB::table('map_level')->where([['main_location', $map_level->sub_location], ['sub_location', $map_level
                                ->sub_location]])
                                ->select(['label_toggle as map_label'])
                                ->first();
                                
                            $location = $location_subname->map_label;

                        }
                    
                   if ($map_level->main_location == $map_level->sub_location) $next_maptable = DB::table($geo_level->master_table)
                        ->where([ ['refid', '=', $res['loc_id']]])->select(['loc5','refid', 'location_name', 'nxt_mp_level', 'loc_id', 'latitude', 'longitude'])
                        ->get();
                    if ($map_level->main_location != $map_level->sub_location) $next_maptable = DB::table($geo_level->master_table)
                        ->where([ ['loc' . $map_level->main_location, '=', $res['loc_id']]])->select(['loc5','refid', 'location_name', 'nxt_mp_level', 'loc_id', 'latitude', 'longitude'])
                        ->get();
                  
                    }

                    
        }
        $next_map_level=[];
        if($map_level->main_location==$map_level->sub_location)
        {
            $map_level_1 = DB::table('map_level')->where([['main_location', '=', $map_level->main_location], ['sub_location', '=', $map_level->sub_location]])->select(['refid', 'map_label', 'main_location', 'sub_location', 'sub_location_temp', 'suffix', 'child'])
                ->first();

        $next_map_level[0]=$map_level_1->child;
        }

        $getfilter->main_location=$map_level->main_location;
        $getfilter->sub_location=$map_level->sub_location;
        
        $getfilter->subname=$subname;

        $input['input']=json_encode($getfilter);
               
        //  echo count($next_maptable);die;
            
        $nextlevelarray=array();

        for($i=0;$i<count($next_maptable);$i++)
        {
               $location=$subname;
                if($map_level->main_location!=$map_level->sub_location)
                {
                    $map_level_1 = DB::table('map_level')->where([['main_location', '=', $next_maptable[$i]->nxt_mp_level], ['sub_location', '=', $next_maptable[$i]->nxt_mp_level]])->select(['refid', 'map_label', 'main_location', 'sub_location', 'sub_location_temp', 'suffix', 'child'])
                  ->first();
				 if( $res['loc_level']==16)
				 {
					 $map_level_2 = DB::table('map_level')->where([['child', '=', $map_level_1->child]])->select(['refid', 'map_label', 'main_location', 'sub_location', 'sub_location_temp', 'suffix', 'child'])
					  ->first();
                     $next_map_level[0]=$map_level_2->child;
				 }
				 else{
					 $next_map_level[0]=$map_level_1->refid;
				 }
				  
                }

               $nextlevelarray[$next_maptable[$i]->refid] = array(
                        'nxt_mp_level' => $next_map_level[0],
                        'loc5'=>$next_maptable[$i]->loc5,
                        'loc_id' => $next_maptable[$i]->loc_id,
                        'current_level' => $res['loc_level'],
                         'current_id' => $res['loc_id'],
                        'main_location' => $map_level->main_location,
                        'sub_location' => $map_level->sub_location,
                        'location_name' => $next_maptable[$i]->location_name . ' ' . $location,
                        'latitude' => $next_maptable[$i]->latitude,
                        'longitude' => $next_maptable[$i]->longitude,
                        'city_id'=>$getfilter->location,
                        
                    );
            
        }


            }

            $message["maplist"]=[];
            $message["notload"]=[];
            if(!isset($getfilter->filter_beat) && $getfilter->type!=4)
            {
                 $loadmap ="./../../mapshapes/city_nbhrd/" .
                        $getfilter->location .
                        "/" .$map_level->main_location .
                        "_" .
                        $map_level->sub_location .'/'.
                      $res['loc_id'] .
                        "_" .
                        $map_level->main_location .
                        "_" .
                        $map_level->sub_location .
                        ".geojson";   

                        if (!in_array($loadmap, $load_file_list)) {

                        array_push($load_file_list, $loadmap);
                        

                        if (file_exists(public_path() . "/" . $loadmap)) {
                            $path = url("/") . "/" . $loadmap;
                            array_push($message["maplist"], $path);
                        }
                        else
                         $message["notload"]    =$loadmap;
            }
           
                    }
                    

                $message["map_nextlevel_info"] = $nextlevelarray;
                $message["label"] = "";
                $data["griddata"]=[];
                $namespace = "App\Http\Controllers\\";
                $controllerName = $namespace . "CommonController";
                $combine_obj = new $controllerName();
                $change = json_decode($input["input"], true);
                $value = array_values($nextlevelarray);
                $loc12 = array_unique(array_column($value, "loc12"));
                
                $head = CommonController::headline($loc12);
                $message["maplegend"] ='';
                $data["head"] = $head; 
                $so_id=0;
                }
              
               

            if (
                count($change) > 0 &&
                isset($input["type"]) &&
                $input["type"] != ""
            ) {

                $inputtype = isset($input["type"])
                    ? $input["type"]
                    : $input["input"]["type"];
                     if(!isset($map_level->main_location))
                    {
                       $data = $combine_obj->commonactivity($nextlevelarray,$subname,$inputtype,0,0,$input["input"],$so_id,$input["current_location"]);
                    }
                    else
                    {
                        $data = $combine_obj->commonactivity($nextlevelarray,$subname,$inputtype,$map_level->main_location,$map_level->sub_location,$input["input"],$so_id,$input["current_location"]); 
                    }
                // $data = $combine_obj->commonactivity(
                //     $nextlevelarray,
                //     $subname,
                //     $inputtype,
                //     $map_level->main_location,
                //     $map_level->sub_location,
                //     $input["input"],
                //     $so_id,
                //     $input["current_location"]
                // );

                $message["map_nextlevel_info"] = $data["mapdata"];

                 //\Log::info($message["map_nextlevel_info"]);
                 // \Log::info($data["head"]);
               // $message["griddata"] = $data["griddata"];
                $message["head"] = $data["head"];
                $message["maplegend"] = $data["maplegend"];
                if (isset($data["village_subrd"])) {
                    $message["village_subrd"] = $data["village_subrd"];
                }
                if (isset($data["griddata"])) {
                    $message["griddata"] = $data["griddata"];
                }
                 if(isset($data['icon_data']))
                      $message['icon_data']=$data['icon_data'];  
                if (isset($data["channel_list"])) {
                    $message["channel_list"] = $data["channel_list"];
                }
                  if (isset($data["child_list"])) {
                    $message["child_list"] = $data["child_list"];
                }
                if (isset($data["feedback_question"])) {
                    $message["feedback_question"] = $data["feedback_question"];
                }
             }
            }
           
            return response()->json($message);
        }
        if (isset($input["statuschange"])) {
            $status = $input["status"];
            $colony = $input["layer"];
            $user_id = $user->id;
            $msg = [];
            $msg["statuschange"] = "failure";

            if (
                DB::table("salesman_covered_ward")
                    ->where([
                        ["colony_id", "=", $colony],
                        ["user_id", "=", $user_id],
                    ])
                    ->exists()
            ) {
                if (
                    DB::table("salesman_covered_ward")
                        ->where([
                            ["colony_id", "=", $colony],
                            ["user_id", "=", $user_id],
                        ])
                        ->update([
                            "status" => $status,
                            "modified_date" => date("Y-m-d H:i:s"),
                        ])
                ) {
                    $msg["statuschange"] = "success";
                    $msg["msg"] = "Details updated";
                }
            } else {
                if (
                    DB::table("salesman_covered_ward")->insert([
                        "colony_id" => $colony,
                        "status" => $status,
                        "user_id" => $user_id,
                    ])
                ) {
                    $msg["statuschange"] = "success";
                }
                $msg["msg"] = "Details added";
            }

            return response()->json($msg);
        }
        if (isset($input["showlist"])) {
            $type_of_view = $input["showtype"];
            $data = [];

            if ($type_of_view == "PC") {
                $sql =
                    "SELECT a.pc_uid,concat(a.firstname,' ',a.lastname) as pc_name  FROM `users` as a where  a.reports_to=" .
                    $user_id .
                    " order by pc_name asc";
                $res = DB::select(DB::raw($sql));
                $str = "";
                $data["msg"] = "failure";
                if (count($res) > 0) {
                    $str =
                        '<table id="showlist" class="display" cellspacing="0" style="width:100%">';
                    $str .=
                        ' <thead><tr><th class="no-sort"><input type="checkbox" class="checkbox_all"/></th><th>Pc Name</th></tr></thead><tbody>';

                    for ($i = 0; $i < count($res); $i++) {
                        $str .=
                            ' <tr id="' .
                            $res[$i]->pc_uid .
                            '"><td><input type="checkbox" class="checking_box" value="' .
                            $res[$i]->pc_uid .
                            '"/> </td><td>' .
                            $res[$i]->pc_name .
                            "</td></tr>";
                    }
                    $str .= "</tbody></table>";
                    $data["msg"] = "success";
                    $data["type"] = "pc";
                }
            }
            if ($type_of_view == "Distributor") {
                $sql =
                    "SELECT distinct c.refid,concat(c.distributor_code,'-',c.name) as distributor_name FROM users as a ,loclty_pc_link as b,mdlz_distbr_master as c where a.pc_uid=b.pc_uid and b.fld1744=c.refid and a.reports_to=" .
                    $user_id .
                    " order by distributor_name asc";
                $res = DB::select(DB::raw($sql));
                $str = "";
                $data["msg"] = "failure";
                if (count($res) > 0) {
                    $str =
                        '<table id="showlist" class="display" cellspacing="0" style="width:100%">';
                    $str .=
                        ' <thead><tr><th class="no-sort"><input type="checkbox" class="checkbox_all" /></th><th>Distributor Name</th></tr></thead><tbody>';

                    for ($i = 0; $i < count($res); $i++) {
                        $str .=
                            ' <tr id="' .
                            $res[$i]->refid .
                            '"><td><input type="checkbox" class="checking_box" value="' .
                            $res[$i]->refid .
                            '"/></td><td>' .
                            $res[$i]->distributor_name .
                            "</td></tr>";
                    }
                    $str .= "</tbody></table>";
                    $data["msg"] = "success";
                    $data["type"] = "distributor";
                }
            }
            $data["list_of_user"] = $str;

            return response()->json($data);

        
        }
        // else if($getfilter->type==13 || isset($getfilter->filter_highway))
        //     { 
        //                      return $this->gethighway($input);
        //     }
        
        else if($getfilter->type==13 || isset($getfilter->filter_highway))
        { 
                //\Log::info("Rajkumar".$getfilter->filter_highway);

                if($user->client_id == 112)
                {
                        $getfilter->highway_list_id='filter_byhighway'; //static
                }
                

                 $highway=new HighwayController();
                 if($getfilter->highway_list_id=='filter_byhighway')
                         return $highway->gethighway($input);
                 if($getfilter->highway_list_id=='state_highwaylist')
                         return $highway->state_gethighway($input);

                
        }
        else if($getfilter->type==14 || isset($getfilter->filter_subrdbeat))
        {
                 return $this->getsubrdbeat($input);
        }
         else if($getfilter->type==15 || isset($getfilter->filter_subrdbeat))
        {
                 return $this->getclient_subrdbeat($input);
        }
        else if($getfilter->type==23 || isset($getfilter->filter_sstbeat))
        {
                 return $this->getclient_sstbeat($input);
        }
         else if($getfilter->type==16 || isset($getfilter->filter_sstsubrdbeat))
        {
                 return $this->getsstsubrdbeat($input);
        }
         else if($getfilter->type==19)
        {
                 return $this->getdistrictsst($input);
        }
        else if($getfilter->type==21)
        {
           
                 return $this->get_sr_tsi($input);
        }
          else if($getfilter->type==22)
        {
                 return $this->get_sr_tsi_150($input);
        }
          else if($getfilter->type==24)
        {
                 return ShowoutletController::mdlz_outlet($input);
        }
          else if($getfilter->type==185)
        {
                return ShowoutletController::ckbeat($input);
        }
         else if($getfilter->type==180)
        {
                return ShowoutletController::cokedata($input);
        }
         else if($getfilter->type==18 && isset($getfilter->filter_nbhrd))
        {
            if(isset($getfilter->type_id) && $getfilter->type_id==1 )
                return ShowoutletController::ckverify_getrd($input);
            else
                return ShowoutletController::ck_getrd($input);
        }
        else if($getfilter->type==17 || isset($getfilter->filter_rd))
        {
            
                $user = auth()->user();

            if($user->client_id==0)
            {
                if(isset($getfilter->type_id) && in_array($getfilter->type_id,[2,3]))
                     return $this->hridelhi_getrd($input);
                else
                      return $this->hri_getrd($input);
            }
            if($user->client_id==97)
                return $this->ck_getrd($input);
            if($user->client_id==15)
                return $this->hul_getrd($input);
            if($user->client_id==112 && $user->role!='')
                return $this->coke_getrd($input);
            
           
            if($user->client_id==112 && $user->role=='')
                return ShowoutletController::coke_college($input);
            
            if ($user->client_id == 133) {
            return ($user->catgry_status == 'beverages')
                ? ShowoutletController::pepsi_beverage_getuncovereddata($input)
                : ShowoutletController::pepsi_getuncovereddata($input);
        }
                        
            if($user->client_id==999)
                return ShowoutletController::pwc_getuncovereddata($input);
            if($user->client_id==123)
                return PerfettiController::getuncoveredoutlets($input);
            if($user->client_id==120 && $user->role=='Country-HO')
                return $this->mdlz_getrd($input);
            else if($user->client_id==120 && $user->id==13285)
                return $this->mdlzdemo_getrd($input);
            else
                return $this->getrd($input);
        }
        else if($getfilter->show_level)
        {
                //  \Log::info('Rajkumar elseif');
                 return $this->get_level($input);
              
        }
    }
      public function mdlz_getrd($input)
    {
        $input_query=json_decode($input['input']);
        
         $rd=[];         $rd['beat_list']=[];   $rd['exist_rd']=[];
         $rd['rd_list']=[];         $rd['map_list']=[];         $column=[];       $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));
         array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
          
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'Country', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Province', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Regency', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Kecamatan', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Desa', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Verified status', 'className' => 'text-left'
         ));
           
           
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          $head='';


          
          
          // if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // {
          //    $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_rd).")"; 
          //    $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_rd).")";
          // }
          //  if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          // {
          //    $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
          // }
          // if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          // {
          //    $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
          //    $exit_rd .=" and channel ='".$input_query->filter_bysubchannel."'";  
          // }

          
          if(isset($input_query->filter_bydistrict) && (count($input_query->filter_bydistrict) > 0)  )
          {
             $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_bydistrict).")"; 
          }
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          {
             if($input_query->filter_beat[0]!=null){
                 $rd_str .=" and a.regency_id in (".implode(',',$input_query->filter_beat).")"; 
             
             }
            
          }



     $sql="SELECT a.`refid`,a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, a.`contact`, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`province`, a.`regency`, a.`kecamatan`,  a.`desa_name`,a.loc15 as beat_id, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,b.outlet_id,b.user_id,b.outlet_image,a.country_name,a.verified FROM `mdlz_outlets`  as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str." order by refid asc";

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          
        for($s=0;$s<$total_potential;$s++)
        {
       
            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', $res[$s]['type'],$res[$s]['address'],$res[$s]['contact'],$res[$s]['country_name'],$res[$s]['province'],$res[$s]['regency'],$res[$s]['kecamatan'],$res[$s]['desa_name'],$res[$s]['verified'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
               
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['desa_name'].' desa</span><br><span style="line-height:1rem;">'.$res[$s]['kecamatan'].' kecamatan</span><br><span style="line-height:1rem;">'.$res[$s]['regency'].' regency</span><br><span style="line-height:1rem;">'.$res[$s]['province'].' province</span><br><span style="line-height:1rem;">'.$res[$s]['country_name'].' country</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span>'.$res[$s]['type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p><hr style="border-top: 1px solid white;"><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].',0,0)"  id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$found.' >  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].',0,0)" id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 77%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
        array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        
         return json_encode($message);
    }
    public function getdistrictsst($input)
    {
         $input_query=json_decode($input['input']);
        
         $sst=[];       
         $sst['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'State', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'District', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'No. of SST', 'className' => 'text-left'
         ));
           
         
          $user = auth()->user();
          $userid = $user->id;
          $subrd_id=[];$legend=[];
          $head='';
          $sst_str='';
          
          $head='';
          if(isset($input_query->filter_sstsubrdbeat) && (count($input_query->filter_sstsubrdbeat) > 0)){
                    $sst_str .=" and sst in (".implode(',',$input_query->filter_sstsubrdbeat).")";
            
          }
         
          if(isset($input_query->filter_sstbeat_district) && (count($input_query->filter_sstbeat_district) > 0)  )
          {
             $sst_str .=" and loc9 in (".implode(',',$input_query->filter_sstbeat_district).")"; 
          }
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          {
             $sst_str .=" and beat_no in (".implode(',',$input_query->filter_beat).")"; 
          }
         

         $sql="SELECT a.`refid`, a.`district_id`, a.`state`, concat(a.`district`,' Distt.') as district, a.`no_of_sst`,b.latitude,b.longitude FROM `mdlz_sst_master` as a, district_master as b where a.district_id=b.refid order by a.district asc";
         $res = DB::select(DB::raw($sql));
         $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $message['result']=[];
        $message['map_nextlevel_info']=[];
        $no_sst_bydistrict=array_column($res, 'no_of_sst');
        $maxval=max($no_sst_bydistrict);
        $minval=min($no_sst_bydistrict);
        $total_value=array_sum($no_sst_bydistrict);
         array_push($message["maplist"],'district_sst/Mdlz_SST.geojson');


        $count=count($res);
        
        for($s=0;$s<$count;$s++)
        {
             
            $temp=[];
            $val_data=array(($s+1),$res[$s]['state'],'<a href="#" id="'.$res[$s]['district_id'].'" style="text-decoration:underline;" onClick="showbound(this)">'.$res[$s]['district'].'</a>',$res[$s]['no_of_sst']);
             array_push($value_data,$val_data);
            //  if(!array_key_exists($res[$s]['loc7'], $sst['map_list'])) 
            // {
            //      $sst['map_list'][$res[$s]['loc7']]=file_get_contents('./../../mapshapes/sst_path/'.$res[$s]['sst_file']);
       
            //     // $head .=$res[$s]['village_district'].',';
            // }
             $color_critiea=((float)$res[$s]['no_of_sst']/(float)$maxval)*100;
             $remain=($maxval-$minval);
             $delta=((float)$res[$s]['no_of_sst']-$minval)/$remain;
             $temp['color']=CommonController::getColor($maxval, $minval, $delta,$this->low,$this->high);

              $contribution=round((($res[$s]['no_of_sst']/$total_value)*100),2);
         
             $size=round((50*($contribution/100)),2);
             $temp['size']=($size > 1) ? $size : 1; 
             $temp['latitude']=$res[$s]['latitude'];
             $temp['longitude']=$res[$s]['longitude'];
             $temp['subrd_type']=1;
            
             $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['district'].'</h5><div class="d-flex" style="height:max-content;"><span class=" popup" style="background: transparent;"><img class="ml-1" src="icons/close-icon.png" height="30px" id="'.$res[$s]['district'].'" onClick="closeicon(this)"></span></div></span><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">State: </span>'.$res[$s]['state'].'</p><p><span style="color:rgb(242, 101, 34)">No. of SST: </span>'.$res[$s]['no_of_sst'].' </p></div>';
             $message['map_nextlevel_info'][$res[$s]['district_id']]=$temp;
             array_push($message['result'],$temp);

        }
        $message['legend']=[];
        $label='<div class="range-label"><span>High</span><span>Low</span></div>';
        $legend=" background: linear-gradient( to left, #db4639 0%, #db7f29 17%, #d1bf1f 33%, #92c51b 50%, #48ba17 67%, #12ab24 83%, #0f9f59 100% );";
        $legend ='<div class="col-md-12">'.$label.'<div class="combine-color"><i style="flex: 1;-webkit-box-flex: 1;margin: 4px 5px;text-align: left;font-size: 1em;line-height: 1em;display: block; width: 100px;height: 10px;'.$legend.';"></i><span>SST</span></div></div>';
 $message['legend']=[];
       array_push($message['legend'],$legend);
       
        
        
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
        $message['label'] = '';     
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
       
        $message['tbl'] = '';
        if(isset($input_query->fit_bounds))
            $message['fit_bounds']=1;
        $head='India - Distt. SST Coverage';
        $message['head'] =$head;
        return json_encode($message);
    }
    public function hul_getrd($input)
    {
        $input_query=json_decode($input['input']);
        
         $rd=[];         $rd['beat_list']=[];   $rd['exist_rd']=[];
         $rd['rd_list']=[];         $rd['map_list']=[];         $column=[];       $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Estmtd. mthly Revenue (Rs.)', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          $head='';


          
          
          if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          {
             $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_rd).")"; 
             $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_rd).")";
          }
           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
            // $exit_rd .=" and channel ='".$input_query->filter_bychannel."'"; 
          }
           if(isset($input_query->filter_channel) && (count($input_query->filter_channel) > 0)  )
          {
             $rd_str .=" and a.type  in ('".implode("','",$input_query->filter_channel)."')";
             // $exit_rd .=" and channel in ('".implode("','",$input_query->filter_channel)."')"; 
          }
          if(isset($input_query->filter_channel) && (count($input_query->filter_channel) > 0)  )
          {
             $rd_str .=" and a.type  in ('".implode("','",$input_query->filter_channel)."')"; 
          }
          if(isset($input_query->filter_potential) && (count($input_query->filter_potential) > 0)  )
          {
             $rd_str .=" and a.fld1923  in (".implode(",",$input_query->filter_potential).")"; 
          }
          if(isset($input_query->filter_status) && (count($input_query->filter_status) > 0)  )
          {
             $rd_str .=" and a.status  in ('".implode("','",$input_query->filter_status)."')"; 
          }
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             
          }
          if(isset($input_query->filter_revenue) && (count($input_query->filter_revenue) > 0)  )
          {
             $rd_str .=" and a.revenue  in ('".implode("','",$input_query->filter_revenue)."')"; 
          }
          

          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
           if(isset($input_query->revenue) && ($input_query->revenue!='')  )
          {
             $rd_str .=" and a.revenue ='".$input_query->revenue."'"; 
          }
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          {
             if($input_query->filter_beat[0]!=null){
                 $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_beat).")"; 
             $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_beat).")";
             }
            
          }


        
    $covered_sql=" SELECT `refid`, `loc12`, `loc13`, `loc14`, `loc15` as beat_id,loc15, `loc16`, `loc25`, `mapping_id`,  `retailer_code`, `retailer_name` as name, `fld2019`, `channel` as channel_type, `latitude`, `longitude`, `address`, `pincode`,nbhrd as beat_name,city_name,colony_name,nbhrd FROM `hul_jaipur_covered_master` where stat='A' and latitude!=0 and longitude!=0 ".$exit_rd." order by refid asc";
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);
 

     $sql="SELECT a.`refid`,a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, a.`contact`, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`city`, a.`nbhrd`, a.`locality_name`,a.loc15 as beat_id, a.`beat_name`, a.`rd_code`,a. `rd_name`, a.`beat_choco_consmptn`, a.`beat_biscuit_consmptn`, a.`beat_confec_consmptn`, a.`beat_premium_index`, a.`beat_snacking_index`, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,b.outlet_id,b.user_id,b.outlet_image,a.revenue FROM `hul_jaipur_uncvrd_outlets` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str." order by refid asc";
   
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);

        if(isset($input_query->outlet_type) && (count($input_query->outlet_type)>0))
        {
            if(!in_array(1,$input_query->outlet_type))
                $covered_res=[];
            if(!in_array(2,$input_query->outlet_type))
                $res=[];
            
        }
        
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head=[];
       
        $revenue_scale=['<20000'=>'< 20k','20000-45000'=>'20k - 45k','45000-75000'=> '45k - 75k','75000-150000'=>'75k - 1.5L','150000-250000'=>'1.5L - 2.5L','250000-400000'=>'2.5L - 4L','400000+'=>'4L +'];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {

                $temp=[];
                
              $temp['icon']='images/default_covered.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;"> '.$covered_res[$s]['colony_name'].' Locality</span><br><span style="line-height:1rem;">'.$covered_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city_name'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        for($s=0;$s<$total_potential;$s++)
        {
           if(!in_array($res[$s]['nbhrd'],$head))
             array_push($head,$res[$s]['nbhrd']);
            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['revenue'].'\')">'.$revenue_scale[$res[$s]['revenue']].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
                $temp['beat_name']=$res[$s]['beat_name'];  
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['locality_name'].' Locality</span><br><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span><a href="#" style="text-decoration:underline;cursor:pointer;color:#fff;" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a></p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'"><a onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')" style="text-decoration:underline;cursor:pointer;">'.$res[$s]['outlet_potential'].'</a></span> </p><p><span style="color:rgb(242, 101, 34)">Estmtd. mthly Revenue: </span><a onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['revenue'].'\')" style="text-decoration:underline;cursor:pointer;">Rs.'.$revenue_scale[$res[$s]['revenue']].' </a></p><hr style="border-top: 1px solid white;"><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].',0,0)"  id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$found.' >  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].',0,0)" id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        if(count($head)> 0)
             $message['head']=(strlen(implode(", ",$head)) > 10) ? $head[0].'...' : implode(", ",$head). ' N\'Bhrhd (s).';
        
        
         return json_encode($message);
    }
    public function getclient_subrdbeat($input){
        $subrd=[];
         $subrd['beat_list']=[];         
         $subrd['subrd_retailer']=[];
         $subrd['subrd_list']=[];
         $subrd['map_list']=[];
         $column=[];
         $value_data=[];
            
         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

         
            array_push($column, array(
             'title' => 'Beat', 'className' => 'text-left'
         ));
            
            array_push($column, array(
             'title' => 'Village Market-UID', 'className' => 'text-right'
         ));
           
           
                array_push($column, array(
             'title' => 'Village Name', 'className' => 'text-left'
         ));
                  array_push($column, array(
             'title' => 'Sub-Distt', 'className' => 'text-left'
         ));
                  array_push($column, array(
             'title' => 'District', 'className' => 'text-left'
         ));
                  
                     array_push($column, array(
             'title' => 'State', 'className' => 'text-left'
         ));
                    array_push($column, array(
             'title' => 'Visit Order', 'className' => 'text-right'
         ));
             array_push($column, array(
             'title' => 'One-way Distance (Km)', 'className' => 'text-right'
         ));
        
        array_push($column, array(
             'title' => 'Time (Mins)', 'className' => 'text-right'
         ));
         array_push($column, array(
             'title' => 'Total_Beat_Distance (Km)', 'className' => 'text-right'
         ));
         
         array_push($column, array(
             'title' => 'Total_Beat_Time (Mins)', 'className' => 'text-right'
         ));             

           
           

           

         
         $input_query=json_decode($input['input']);
          $user = auth()->user();
          $userid = $user->id;
          $subrd_id=[];$legend=[];
          $head='';
          $subrd_str='';
          
          $head='';
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)){
                    $subrd_str .=" where beat_name in ('".$input_query->filter_beat[0]."')";
            
          }
         


          if(isset($input_query->filter_subrd) && (count($input_query->filter_subrd) > 0)){
                    $subrd_str .=" and a.subrd_id in (".implode(',',$input_query->filter_subrd).")";            
          }
          else if(isset($input_query->filter_subrdbeat_district) && (count($input_query->filter_subrdbeat_district) > 0)  )
          {
             $subrd_str .=" and a.loc9 in (".implode(',',$input_query->filter_subrdbeat_district).")"; 
          }
         



         $sql="SELECT `refid`,state_id, `state`, `District`, `Village`, `population`, `market_uid`, `village_census`,beat, `beat_name`, `order_id`, `oneway_distance`, `time`, `total_beat_distance`, `total_beat_time`, `subrd_type`, `village_lat`, `village_lon` FROM `subrd_beat_client` ".$subrd_str." order by beat_name asc";

      // echo $sql;die;
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $sub=[];

        $dist_list=['dist'=>[],'subrd'=>[]];
        $total_potential=count($res);
         $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
         $type_subrd=[1=>'Actual',2=>'Assumed'];
        $test=['No Visit'=>3,'No visit'=>3,'Premium'=>0,'Medium'=>1,'Van Beat'=>2];

         $subrd_arr=range(0,30);$colorval=0;$premium=[];
        for($s=0;$s<$total_potential;$s++)
        {
             

            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline;" onClick="show_clientsubrdbeat_filter(0,\''.$res[$s]['beat_name'].'\')">'.$res[$s]['beat'].'</a>',$res[$s]['market_uid'],$res[$s]['Village'],$res[$s]['District'],$res[$s]['District'],$res[$s]['state'],$res[$s]['order_id'],$res[$s]['oneway_distance'],$res[$s]['time'],$res[$s]['total_beat_distance'],$res[$s]['total_beat_time']);
             array_push($value_data,$val_data);
             if(!array_key_exists($res[$s]['state_id'], $subrd['map_list'])) 
            {
                 $subrd['map_list'][$res[$s]['state_id']]='beat_path/Hugli_Visual.geojson';
                 array_push($message["maplist"],$subrd['map_list'][$res[$s]['state_id']]);
                // $head .=$res[$s]['village_district'].',';
            }

           

            

            if(!array_key_exists($res[$s]['village_census'], $subrd['beat_list']))
            {
            $beat_id=$res[$s]['beat_name'];
            $subrd['beat_list'][$res[$s]['village_census'].'#'.$res[$s]['beat_name']]=[];
            $subrd['beat_list'][$res[$s]['village_census'].'#'.$res[$s]['beat_name']]['beat_name']=$res[$s]['beat_name'];
             $subrd['beat_list'][$res[$s]['village_census'].'#'.$res[$s]['beat_name']]['beat_id']=$res[$s]['beat'];
            $subrd['beat_list'][$res[$s]['village_census'].'#'.$res[$s]['beat_name']]['color']='#908D8E';
            $subrd['beat_list'][$res[$s]['village_census'].'#'.$res[$s]['beat_name']]['info']='<div class="tooltip-data popupdata"><div class="card"><div class="card-header"><h3>'.$res[$s]['beat'].'</h3></div><ul class="list-group list-group-flush"><li>State:<span>'.$res[$s]['state'].'</span></li><li>District:<span>'.$res[$s]['District'].'</span></li></ul></div></div>';
            
            }
            if($res[$s]['subrd_type']==2)
            {
                array_push($subrd_id,$res[$s]['refid']);
                $temp=[];
                 $temp['subrd_name']=$res[$s]['Village'];                
                  $temp['type']='';
                  $temp['latitude']=$res[$s]['village_lat'];
                  $temp['longitude']=$res[$s]['village_lon'];
                  $temp['beat_id']=$res[$s]['beat_name'];
                  $temp['beat_unique_id']=$res[$s]['village_census'].'#'.$res[$s]['beat_name'];
                  $temp['color']='#3cb64a';
                 $temp['icon']='images/sst.png'; 
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$temp['subrd_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['village_lat'].','.$res[$s]['village_lon'].'" onclick="location_navigate(this)" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">State: </span>'.$res[$s]['state'].'</p><p><span style="color:rgb(242, 101, 34)">District: </span>'.$res[$s]['District'].' </p><p><span style="color:rgb(242, 101, 34)">Village: </span>'.$res[$s]['Village'].' </p></div>';

                 array_push($subrd['subrd_list'],$temp);

            }
           
                $temp=[];
                $temp['color']='#ffffff';
                $temp['beat_id']=$res[$s]['beat_name'];
                $temp['latitude']=$res[$s]['village_lat'];
                $temp['longitude']=$res[$s]['village_lon'];
                $temp['village_name']=$res[$s]['Village'];
                $temp['state']=$res[$s]['state'];
                $temp['district']=$res[$s]['District'];
              
                $temp['oneway_distance']=$res[$s]['oneway_distance'];
                $temp['time']=$res[$s]['time'];
                $temp['total_beat_distance']=$res[$s]['total_beat_distance'];
                $temp['total_beat_time']=$res[$s]['total_beat_time'];
                $temp['visit_order']=$res[$s]['order_id'];
                $temp['beat_name']=$res[$s]['beat_name'];

              

                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['Village'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['village_lat'].','.$res[$s]['village_lon'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Beat Name: </span>'.$res[$s]['beat_name'].' </p><p><span style="color:rgb(242, 101, 34)">Village Market ID: </span>'.$res[$s]['market_uid'].' </p><p><span style="color:rgb(242, 101, 34)">Visit Order: </span>'.$res[$s]['order_id'].' </p><p><span style="color:rgb(242, 101, 34)">Actual or Assumed Outlet Nos.: </span>'.$type_subrd[$res[$s]['subrd_type']].' </p><p><span style="color:rgb(242, 101, 34)">State: </span>'.$res[$s]['state'].'</p><p><span style="color:rgb(242, 101, 34)">District: </span>'.$res[$s]['District'].' </p><p><span style="color:rgb(242, 101, 34)">Village: </span>'.$res[$s]['Village'].'</p></div>';

               
              array_push($subrd['subrd_retailer'],$temp);

        }
        
        
        $message['result']=$subrd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
       
        $message['legend']=[];
       

                   
        $message['label'] = '';
      //  $message['legend']=[];
        //$message['legend'][0] = array_values($legend);
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = $subrd['beat_list'];
        $message['tbl'] = '';
        
        $message['head'] ='';
         return json_encode($message);
    }
     public function getclient_sstbeat($input){
        $subrd=[];
         $subrd['beat_list']=[];         
         $subrd['subrd_retailer']=[];
         $subrd['subrd_list']=[];
         $subrd['map_list']=[];
         $column=[];
         $value_data=[];
           
         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

         
            array_push($column, array(
             'title' => 'Beat', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'SST Code', 'className' => 'text-left'
         ));
              array_push($column, array(
             'title' => 'SST Name', 'className' => 'text-left'
         ));
            
            array_push($column, array(
             'title' => 'Village Market-UID', 'className' => 'text-right'
         ));
           
           
                array_push($column, array(
             'title' => 'Village Name', 'className' => 'text-left'
         ));
         //          array_push($column, array(
         //     'title' => 'Sub-Distt', 'className' => 'text-left'
         // ));
                  array_push($column, array(
             'title' => 'District', 'className' => 'text-left'
         ));
                  
                     array_push($column, array(
             'title' => 'State', 'className' => 'text-left'
         ));
                    array_push($column, array(
             'title' => 'Visit Order', 'className' => 'text-right'
         ));

                    array_push($column, array(
             'title' => 'No. of Potential outlet', 'className' => 'text-right'
         ));
                     array_push($column, array(
             'title' => 'Chocolate RPI', 'className' => 'text-left'
         ));
                      array_push($column, array(
             'title' => 'Chocolate Potential (Rs.)', 'className' => 'text-right'
         ));
                     
             array_push($column, array(
             'title' => 'One-way Distance (Km)', 'className' => 'text-right'
         ));
        
        array_push($column, array(
             'title' => 'Time (Mins)', 'className' => 'text-right'
         ));
          array_push($column, array(
             'title' => 'Nearest SubRD code', 'className' => 'text-right'
         ));
                         array_push($column, array(
             'title' => 'Distance From Nearest SubRD code (Km)', 'className' => 'text-right'
         ));
                    
         // array_push($column, array(
         //     'title' => 'Total_Beat_Distance (Km)', 'className' => 'text-right'
         // ));
         
         // array_push($column, array(
         //     'title' => 'Total_Beat_Time (Mins)', 'className' => 'text-right'
         // ));             

           
           

           

         
         $input_query=json_decode($input['input']);
          $user = auth()->user();
          $userid = $user->id;
          $subrd_id=[];$legend=[];
          $head='';
          $subrd_str='';
          
          $head='';
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)){
                    $subrd_str .=" and beat_unique_id in ('".$input_query->filter_beat[0]."')";
            
          }
          if(isset($input_query->filter_sstbeat) && (count($input_query->filter_sstbeat) > 0)){
                    $subrd_str .=" and sst_code in (".implode(',',$input_query->filter_sstbeat).")";            
          }
         $sql="SELECT `refid`, `temp_id`, `state` as State, `District`, `Village`, `population`, `sst_code`, `sst_name`, `sst_town`, `sst_lat`, `sst_long`, `beat_unique_id`, `no_of_potnl_outlet`, `chocolate_rpi`, `cholcolate_potentail_rs`, `nearest_subrd_code`, `distance_from_nearest_subrd_km`, `market_uid`, `village_census`, `beat_name`, `order_id`, `oneway_distance`, `time`, `total_beat_distance`, `total_beat_time`, `subrd_type`, `village_lat`, `village_lon`, `state_id`, `beat` FROM `chattisgarh_sst_van_beats3` where stat='A' ".$subrd_str." order by beat_name asc";

      // echo $sql;die;
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $sub=[];

        $dist_list=['dist'=>[],'subrd'=>[]];
        $total_potential=count($res);
         $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
         $type_subrd=[1=>'Actual',2=>'Assumed'];
        $test=['No Visit'=>3,'No visit'=>3,'Premium'=>0,'Medium'=>1,'Van Beat'=>2];

         $subrd_arr=range(0,30);$colorval=0;$premium=[];
        for($s=0;$s<$total_potential;$s++)
        {
             

             $val_data=array(($s+1),'<a href="#" style="text-decoration:underline;" onClick="show_clientsstbeat_filter(0,\''.$res[$s]['beat_unique_id'].'\')">'.$res[$s]['beat'].'</a>',$res[$s]['sst_code'],$res[$s]['sst_name'],$res[$s]['market_uid'],$res[$s]['Village'],$res[$s]['District'],$res[$s]['State'],$res[$s]['order_id'],$res[$s]['no_of_potnl_outlet'],$res[$s]['chocolate_rpi'],number_format($res[$s]['cholcolate_potentail_rs'],0),number_format($res[$s]['oneway_distance'],2),number_format($res[$s]['time'],2),$res[$s]['nearest_subrd_code'],number_format($res[$s]['distance_from_nearest_subrd_km'],2));
                array_push($value_data,$val_data);
             if(!array_key_exists($res[$s]['state_id'], $subrd['map_list'])) 
            {
                 $subrd['map_list'][$res[$s]['state_id']]='beat_path/'.$res[$s]['state_id'].'.geojson';
                 array_push($message["maplist"],$subrd['map_list'][$res[$s]['state_id']]);
                // $head .=$res[$s]['village_district'].',';
            }

           

            

            if(!array_key_exists($res[$s]['beat_unique_id'], $subrd['beat_list']))
            {
            $beat_id=$res[$s]['beat_name'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]=[];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['beat_name']=$res[$s]['beat_name'];
             $subrd['beat_list'][$res[$s]['beat_unique_id']]['beat_id']=$res[$s]['beat'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['color']=CommonController::random_hex_color();
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['info']='<div class="tooltip-data popupdata"><div class="card"><div class="card-header"><h3>'.$res[$s]['beat'].'</h3></div><ul class="list-group list-group-flush"><li>State:<span>'.$res[$s]['State'].'</span></li><li>District:<span>'.$res[$s]['District'].'</span></li></ul></div></div>';
        }
        if(!in_array($res[$s]['sst_code'],$subrd_id)){

            array_push($subrd_id,$res[$s]['sst_code']);
                $temp=[];
                 $temp['sst_name']=$res[$s]['sst_name'];                
                  $temp['type']=1;
                  $temp['latitude']=$res[$s]['sst_lat'];
                  $temp['longitude']=$res[$s]['sst_long'];
                  $temp['beat_id']=$res[$s]['beat_name'];
                  $temp['beat_unique_id']=$res[$s]['beat_unique_id'];
                  $temp['color']='#3cb64a';
                  ///$temp['icon']='highway/actual_subrd.png'; 
                   $temp['icon']='images/sst.png'; 
                

                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$temp['sst_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['sst_lat'].','.$res[$s]['sst_long'].'" onclick="location_navigate(this)" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['sst_town'].' town</span><br><span style="line-height:1rem;">'.$res[$s]['District'].' distt</span><br><span style="line-height:1rem;">'.$res[$s]['State'].' state</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">SST Code: </span>'.$res[$s]['sst_code'].' </p></div>';

                 array_push($subrd['subrd_list'],$temp);

                 $subrd_sql="SELECT `refid`, `sst_code`, `substockist_uid`, `substockist_name`, `state_name`, `district`, `subdistt`, `loc14`, `sector`, `substockist_town_name`, `market_uid`, `2011_census`, `tier`, `subrd_type`, `latitude`, `longitude` FROM `0_mdlz_sst_subd_link_Jan24` WHERE sst_code='".$res[$s]['sst_code']."' ";
                   $subrd_res = DB::select(DB::raw($subrd_sql));
                $subrd_res=CommonController::getarray($subrd_res);
                for($m=0;$m<count($subrd_res);$m++)
                {
                    $temp=[];
                 $temp['substockist_uid']=$subrd_res[$m]['substockist_uid'];                
                  $temp['type']=2;
                  $temp['latitude']=$subrd_res[$m]['latitude'];
                  $temp['longitude']=$subrd_res[$m]['longitude'];
                  $temp['icon']='rural_icon/efficient-subrd.png'; 
                

                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$subrd_res[$m]['substockist_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$subrd_res[$m]['latitude'].','.$subrd_res[$m]['longitude'].'" onclick="location_navigate(this)" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$subrd_res[$m]['substockist_town_name'].' town</span><br><span style="line-height:1rem;">'.$subrd_res[$m]['district'].' distt</span><br><span style="line-height:1rem;">'.$subrd_res[$m]['state_name'].' state</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">Subrd Code: </span>'.$subrd_res[$m]['substockist_uid'].' </p><p><span style="color:rgb(242, 101, 34)">Market-UID: </span>'.$subrd_res[$m]['market_uid'].' </p></div>';

                 array_push($subrd['subrd_list'],$temp);
                }
            
            }
           
           
                $temp=[];
                $temp['color']='#ffffff';
                $temp['beat_id']=$res[$s]['beat_name'];
                $temp['latitude']=$res[$s]['village_lat'];
                $temp['longitude']=$res[$s]['village_lon'];
                $temp['village_name']=$res[$s]['Village'];
                $temp['state']=$res[$s]['State'];
                $temp['district']=$res[$s]['District'];
              
                $temp['visit_order']=$res[$s]['order_id'];
                $temp['beat_name']=$res[$s]['beat_name'];

              

                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['Village'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['village_lat'].','.$res[$s]['village_lon'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['Village'].' villg.</span><br><span style="line-height:1rem;">'.$res[$s]['District'].' District</span><br><span style="line-height:1rem;">'.$res[$s]['State'].' state</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Beat Name: </span>'.$res[$s]['beat'].' </p><p><span style="color:rgb(242, 101, 34)">Village Market ID: </span>'.$res[$s]['market_uid'].' </p><p><span style="color:rgb(242, 101, 34)">Visit Order: </span>'.$res[$s]['order_id'].' </p><p><span style="color:rgb(242, 101, 34)">Actual or Assumed Outlet Nos.: </span>'.$type_subrd[$res[$s]['subrd_type']].' </p><p><span style="color:rgb(242, 101, 34)">SST Code: </span>'.$res[$s]['sst_code'].' </p><p><span style="color:rgb(242, 101, 34)">SST Name: </span>'.$res[$s]['sst_name'].' </p><p><span style="color:rgb(242, 101, 34)">No. of Potential Outlet: </span>'.$res[$s]['no_of_potnl_outlet'].' </p><p><span style="color:rgb(242, 101, 34)">Chocolate RPI: </span>'.$res[$s]['chocolate_rpi'].' </p><p><span style="color:rgb(242, 101, 34)">Chocolate Potential: </span>Rs. '.number_format($res[$s]['cholcolate_potentail_rs'],0).' </p></div>';
              array_push($subrd['subrd_retailer'],$temp);

        }
        
        $message['result']=$subrd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
    
        $head= implode(",",$subrd_id). ' SST(s)';
        $message['legend']=[];
       

                   
        $message['label'] = '';
         $message['head'] = $head;
      //  $message['legend']=[];
        //$message['legend'][0] = array_values($legend);
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = $subrd['beat_list'];
        $message['tbl'] = '';
       
         return json_encode($message);
    }
     public function hri_getrd($input)
    {
        $input_query=json_decode($input['input']);
        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['rd_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
         //  array_push($column, array(
         //     'title' => 'Type', 'className' => 'text-left'
         // ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
           
            
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


           if(isset($input_query->type_id) && ($input_query->type_id!=0)  )
          {
             $rd_str .=" and a.type_id in (".$input_query->type_id.")"; 
             
          }
          
          if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          {
             $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_rd).")"; 
             $exit_rd .=" and beat_id in (".implode(',',$input_query->filter_rd).")";
          }
           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bychannel."'"; 
          }
           if(isset($input_query->filter_channel) && (count($input_query->filter_channel) > 0)  )
          {
             $rd_str .=" and a.sub_type  in ('".implode("','",$input_query->filter_channel)."')"; 
          }
           if(isset($input_query->filter_potential) && (count($input_query->filter_potential) > 0)  )
          {
             $rd_str .=" and a.fld1923  in (".implode(",",$input_query->filter_potential).")"; 
          }
          if(isset($input_query->filter_status) && (count($input_query->filter_status) > 0)  )
          {
             $rd_str .=" and a.status  in ('".implode("','",$input_query->filter_status)."')"; 
          }
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             $exit_rd .=" and channel_type ='".$input_query->filter_bysubchannel."'";  
          }

          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          {
             if($input_query->filter_beat[0]!=null && $input_query->filter_beat[0]!=0) {
                 $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_beat).")"; 
             $exit_rd .=" and beat_id in (".implode(',',$input_query->filter_beat).")";
             }
            
          }

         
     $covered_sql="SELECT `refid`,  `loc12`,`beat_id`, `loc13`, `loc14`, `loc15`, `loc16`, `loc25`, `mapping_id`, `division`, `zone`, `state`, `mapped_user_name`, `fld2020`, `desination`, `fld2018`, `beat_name`, `area_name`, `name`, `latitude`, `longitude`, `fld2019`, `outet_classification`,  `city_name`,channel_type,address  FROM `hri_mumbai_andheri_outlet_master` where stat='A' and latitude!=0 and longitude!=0 ".$exit_rd." order by refid asc";
   
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);


     $sql="SELECT a.`refid`, a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, a.`contact`, a.`latitude`, a.`longitude`, `city`,`city_id`,   `nbhrd`, `locality_name`, `beat_id`, nbhrd as beat_name, `rd_code`, `rd_name`, `beat_choco_consmptn`, `beat_biscuit_consmptn`, `beat_confec_consmptn`, `beat_premium_index`, `beat_snacking_index`, a.loc16,a.status,`stat`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,b.outlet_id,b.user_id,b.outlet_image  FROM `hri_uncvrd_outlets` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str." group by a.refid order by refid asc";

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
         if(isset($input_query->outlet_type) && (count($input_query->outlet_type)>0))
        {
            if(!in_array(1,$input_query->outlet_type))
                $covered_res=[];
            if(!in_array(2,$input_query->outlet_type))
                $res=[];
            
        }
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['nbhrd'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {

                $temp=[];
                
              $temp['icon']='images/default_covered.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$covered_res[$s]['beat_name'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city_name'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        for($s=0;$s<$total_potential;$s++)
        {
             //'<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>',

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
                $temp['beat_name']=$res[$s]['beat_name'];  
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$res[$s]['sub_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'">'.$res[$s]['outlet_potential'].'</span> </p><hr style="border-top: 1px solid white;"><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].',0,0)"  id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].',0,0)" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
            if(!in_array($res[$s]['nbhrd'],$dist_list['nbhrd']))
                array_push($dist_list['nbhrd'],$res[$s]['nbhrd']);
               

        }
        $message['legend']=[];
       array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        $head='';
        $head=$res[0]['city'].' City - '.implode(",",$dist_list['nbhrd']). ' N\'bhrd(s)';
        $message['head'] =$head;
         return json_encode($message);
    }
      public function hridelhi_getrd($input)
    {
        $input_query=json_decode($input['input']);
        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['rd_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
           
            
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
          $user = auth()->user();
          $userid = $user->id;
         
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


           if(isset($input_query->type_id) && ($input_query->type_id!=0)  )
          {
             $rd_str .=" and a.type_id in (".$input_query->type_id.")"; 
             
          }
          
          if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          {
             $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_rd).")"; 
            
          }
           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
          }
           if(isset($input_query->filter_channel) && (count($input_query->filter_channel) > 0)  )
          {
             $rd_str .=" and a.sub_type  in ('".implode("','",$input_query->filter_channel)."')"; 
          }
           if(isset($input_query->filter_potential) && (count($input_query->filter_potential) > 0)  )
          {
             $rd_str .=" and a.fld1923  in (".implode(",",$input_query->filter_potential).")"; 
          }
          if(isset($input_query->filter_status) && (count($input_query->filter_status) > 0)  )
          {
             $rd_str .=" and a.status  in ('".implode("','",$input_query->filter_status)."')"; 
          }
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             
          }

          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          {
             if($input_query->filter_beat[0]!=null && $input_query->filter_beat[0]!=0) {
                 $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_beat).")"; 
             
             }
            
          }
        $covered_res=[];


     $sql="SELECT a.`refid`, a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, a.`contact`, a.`latitude`, a.`longitude`, `city`,`city_id`,   `nbhrd`, `locality_name`, `beat_id`, nbhrd as beat_name, `rd_code`, `rd_name`, `beat_choco_consmptn`, `beat_biscuit_consmptn`, `beat_confec_consmptn`, `beat_premium_index`, `beat_snacking_index`, a.loc16,a.status,`stat`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,b.outlet_id,b.user_id,b.outlet_image  FROM 0_delhi_uncvrd_outlets as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str." group by a.refid order by refid asc";

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
         if(isset($input_query->outlet_type) && (count($input_query->outlet_type)>0))
        {
            if(!in_array(1,$input_query->outlet_type))
                $covered_res=[];
            if(!in_array(2,$input_query->outlet_type))
                $res=[];
            
        }
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['nbhrd'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
       
        for($s=0;$s<$total_potential;$s++)
        {
             //'<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>',

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" id="'.$res[$s]['type'].'"  onClick="hri_filter(\''.$res[$s]['type'].'\',\'\','.$input_query->type_id.')">'.$res[$s]['type'].'</a>', '<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="hri_filter(\'\',\''.$res[$s]['sub_type'].'\','.$input_query->type_id.')">'.$res[$s]['sub_type'].'</a>',$res[$s]['outlet_potential'],$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
                $temp['beat_name']=$res[$s]['beat_name'];  
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$res[$s]['sub_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'">'.$res[$s]['outlet_potential'].'</span> </p><hr style="border-top: 1px solid white;"><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="hri_outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].',0,0,'.$input_query->type_id.')"  id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="hri_outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].',0,0,'.$input_query->type_id.')" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
            if(!in_array($res[$s]['nbhrd'],$dist_list['nbhrd']))
                array_push($dist_list['nbhrd'],$res[$s]['nbhrd']);
               

        }
        $message['legend']=[];
       array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        $head='';
        $head=$res[0]['city'].' City -'.implode(",",$dist_list['nbhrd']). ' N\'bhrd(s)';
        $message['head'] =$head;
         return json_encode($message);
    }
    public function getrd($input)
    {
        $input_query=json_decode($input['input']);
        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['rd_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Locality', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'RD Code', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'RD Name', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Beat', 'className' => 'text-left'
         ));
         //     array_push($column, array(
         //     'title' => 'Beat Premium Index', 'className' => 'text-left'
         // ));
         //     array_push($column, array(
         //     'title' => 'Beat Snacking Index', 'className' => 'text-left'
         // ));
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


          if(isset($input_query->city_id) && ($input_query->city_id !=0)  )
          {
             $rd_str .=" and a.city_id=".$input_query->city_id.""; 
             $exit_rd .=" and loc12=".$input_query->city_id."";
          }
            if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
          {
            if($input_query->sub_location==15)
            {
                 $rd_str .=" and a.loc15=".$input_query->ward_id.""; 
                $exit_rd .=" and loc15=".$input_query->ward_id."";
            }
            else
            {
                 $rd_str .=" and a.loc16=".$input_query->ward_id.""; 
                $exit_rd .=" and loc16=".$input_query->ward_id."";
            }

            
          }
           if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          {
             $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_rd).")"; 
             $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_rd).")";
          }
          // if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // {
          //    $rd_str .=" and a.rd_code in (".implode(',',$input_query->filter_rd).")"; 
          //    $exit_rd .=" and RD_code in (".implode(',',$input_query->filter_rd).")";
          // }
           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
          }
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             $exit_rd .=" and channel_type ='".$input_query->filter_bysubchannel."'";  
          }
          if(isset($input_query->locality) && ($input_query->locality!='')  )
          {
             $rd_str .=" and a.loc16 ='".$input_query->locality."'"; 
             $exit_rd .=" and loc16 ='".$input_query->locality."'"; 
          }
          if(isset($input_query->premium_index) && ($input_query->premium_index!='')  )
          {
             $rd_str .=" and a.beat_premium_index ='".$input_query->premium_index."'"; 
             $exit_rd .=" and premium_index_name ='".$input_query->premium_index."'"; 
             
          }
          if(isset($input_query->snacking_index) && ($input_query->snacking_index!='')  )
          {
             $rd_str .=" and a.beat_snacking_index ='".$input_query->snacking_index."'"; 
          }
          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
          // if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // {
          //    if($input_query->filter_beat[0]!=null){
          //        $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_beat).")"; 
          //    $exit_rd .=" and fld1995 in (".implode(',',$input_query->filter_beat).")";
          //    }
            
          // }
            if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          {
             if($input_query->filter_beat[0]!=null){
                 $rd_str .=" and a.loc16 in (".implode(',',$input_query->filter_beat).")"; 
             $exit_rd .=" and loc16 in (".implode(',',$input_query->filter_beat).")";
             }
            
          }
         
         $covered_sql="SELECT `refid`,`loc12`, `fld1995` as beat_id, `fld1995` as premium_index, locality,`beat_name`, `RD_code`, `RD_name`, `outlet_code`, `outletcode_RD`, `name`, `channel_type`, `address`, `latitude`, `longitude`,locality, `stat`,premium_index_name,nbhrd,city,'' as shop_image FROM `mdlz_urban_outlet_master` where stat='A' and latitude!=0 and longitude!=0 ".$exit_rd." order by refid asc";
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);


       $sql="SELECT a.`refid`, `retailer_id`, `name`, `type`, `sub_type`, `outlet_potential`, `fld1923`, `address`, `contact`, `latitude`, `longitude`, `city`, `city_id`, `nbhrd`, `locality_name`, `beat_id`, rd_code,rd_name,`beat_name`,`beat_premium_index`, `beat_snacking_index`,a.`status`,a.loc16,a.fld1923,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.shop_image,a.icon,b.outlet_id,b.user_id,b.outlet_image FROM `mdlz_rd_outlets` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str." order by refid asc";

     
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head_list=[];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {

                $temp=[];
                
              $temp['icon']='images/mdlz_covered.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
              $temp['refid']=$covered_res[$s]['refid'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$covered_res[$s]['locality'].' Locality</span><br><span style="line-height:1rem;">'.$covered_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">RD Code: </span>'.$covered_res[$s]['RD_code'].'  </p><p><span style="color:rgb(242, 101, 34)">RD Name: </span>'.$covered_res[$s]['RD_name'].'  </p><p><span style="color:rgb(242, 101, 34)">Beat Name: </span>Beat '.$covered_res[$s]['beat_name'].' </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        for($s=0;$s<$total_potential;$s++)
        {
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\''.$res[$s]['loc16'].'\')">'.$res[$s]['locality_name'].'</a>',$res[$s]['rd_code'],$res[$s]['rd_name'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\''.$res[$s]['beat_id'].'\')">'.$res[$s]['beat_name'].'</a>',$res[$s]['outlet_status']);//

            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\''.trim($res[$s]['beat_snacking_index']).'\')">'.$res[$s]['beat_snacking_index'].'</a>',
            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\''.$res[$s]['beat_premium_index'].'\')">'.$res[$s]['beat_premium_index'].'</a>',

             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
                $temp['beat_name']=$res[$s]['beat_name'];  
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
            
              if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
             {
                if($input_query->sub_location==15)
                {
                    if(!in_array($res[$s]['nbhrd'],$head_list))
                    array_push($head_list,$res[$s]['nbhrd']);
                } 
                else
                  if(!in_array($res[$s]['locality_name'],$head_list))
                    array_push($head_list,$res[$s]['locality_name']);

             }
            
              else
             {
                if(!in_array($res[$s]['city'],$head_list))
                    array_push($head_list,$res[$s]['city']);

             }
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['locality_name'].' Locality</span><br><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$res[$s]['sub_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span>'.$res[$s]['contact'].' </p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'">'.$res[$s]['outlet_potential'].'</span> </p><p><span style="color:rgb(242, 101, 34)">RD Code: </span>'.$res[$s]['rd_code'].'  </p><p><span style="color:rgb(242, 101, 34)">RD Name: </span>'.$res[$s]['rd_name'].'  </p><p><span style="color:rgb(242, 101, 34)">Beat Name: </span>Beat '.$res[$s]['beat_name'].' </p><hr style="border-top: 1px solid white;"><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  style="display:block;" id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')" style="display:block;" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        $head='';
        $head=implode(",",$head_list);
      if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
         {
            if($input_query->sub_location==15)
             $message['head'] =$head. ' N\'bhrd (s)';
            else
             
                $message['head'] =$head. ' Loclty (s)';

         }
        
          else
         {
           $message['head'] =$head. ' City';
         }
         
         return json_encode($message);
    }
    public function mdlzdemo_getrd($input)
    {
        $input_query=json_decode($input['input']);
        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['rd_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Locality', 'className' => 'text-left'
         ));
            
         //     array_push($column, array(
         //     'title' => 'Beat Premium Index', 'className' => 'text-left'
         // ));
         //     array_push($column, array(
         //     'title' => 'Beat Snacking Index', 'className' => 'text-left'
         // ));
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


          if(isset($input_query->city_id) && ($input_query->city_id !=0)  )
          {
             $rd_str .=" and a.city_id=".$input_query->city_id.""; 
            
          }
          if(isset($input_query->potential) && ($input_query->potential !=0)  )
          {
             $rd_str .=" and a.fld1923=".$input_query->potential.""; 
            
          }
            if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
          {
            if($input_query->sub_location==15)
            {
                 $rd_str .=" and a.loc15=".$input_query->ward_id.""; 
               
            }
            else
            {
                 $rd_str .=" and a.loc16=".$input_query->ward_id.""; 
                
            }

            
          }
           if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          {
             $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_rd).")"; 

           
          }
          if(isset($input_query->filter_bypotential) && (count($input_query->filter_bypotential) > 0)  )
        {

         $rd_str .=" and a.fld1923 in ('".join("','",$input_query->filter_bypotential)."')";
             
        }
           if(isset($input_query->filter_bychannel) )
          {
            if(is_array($input_query->filter_bychannel) && (count($input_query->filter_bychannel)>0))
            {
                   $rd_str .=" and a.type  in ('".join("','",$input_query->filter_bychannel)."')"; 
            }
            else if(!is_array($input_query->filter_bychannel) && $input_query->filter_bychannel!="")
            {
                 $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
            }
            
          }
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
            
          }
          if(isset($input_query->locality) && ($input_query->locality!='')  )
          {
             $rd_str .=" and a.loc16 ='".$input_query->locality."'"; 
             
          }
        
          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
          // if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // {
          //    if($input_query->filter_beat[0]!=null){
          //        $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_beat).")"; 
          //    $exit_rd .=" and fld1995 in (".implode(',',$input_query->filter_beat).")";
          //    }
            
          // }
          //   if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // {
          //    if($input_query->filter_beat[0]!=null){
          //        $rd_str .=" and a.loc16 in (".implode(',',$input_query->filter_beat).")"; 
           
          //    }
            
          // }
          if(isset($input_query->filter_bystatus) && (count($input_query->filter_bystatus) > 0)  )
        {

        $rd_str .=" and a.status in ('".join("','",$input_query->filter_bystatus)."')";
             
        }
     
         
   

       $sql="SELECT a.`refid`, `retailer_id`, `name`, `type`, `sub_type`, `outlet_potential`, `fld1923`, `address`, `contact`, `latitude`, `longitude`, `city`, `city_id`, `nbhrd`, `locality_name`, `beat_id`, rd_code,rd_name,`beat_name`,`beat_premium_index`, `beat_snacking_index`,a.`status`,a.loc16,a.fld1923,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.shop_image,a.icon,b.outlet_id,b.user_id,b.outlet_image FROM `ckpl_uncvrd_outlets_new` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A' and AGP_status='AGP'  ".$rd_str." group by retailer_id order by refid asc";
//echo $sql;die;
     
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head_list=[];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
         
        for($s=0;$s<$total_potential;$s++)
        {
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\''.$res[$s]['loc16'].'\')">'.$res[$s]['locality_name'].'</a>',$res[$s]['outlet_status']);//

            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\''.trim($res[$s]['beat_snacking_index']).'\')">'.$res[$s]['beat_snacking_index'].'</a>',
            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\''.$res[$s]['beat_premium_index'].'\')">'.$res[$s]['beat_premium_index'].'</a>',

             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
                $temp['beat_name']=$res[$s]['beat_name'];  
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
            
              if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
             {
                if($input_query->sub_location==15)
                {
                    if(!in_array($res[$s]['nbhrd'],$head_list))
                    array_push($head_list,$res[$s]['nbhrd']);
                } 
                else
                  if(!in_array($res[$s]['locality_name'],$head_list))
                    array_push($head_list,$res[$s]['locality_name']);

             }
            
              else
             {
                if(!in_array($res[$s]['city'],$head_list))
                    array_push($head_list,$res[$s]['city']);

             }
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['locality_name'].' Locality</span><br><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$res[$s]['sub_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span>'.$res[$s]['contact'].' </p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'">'.$res[$s]['outlet_potential'].'</span> </p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  style="display:block;" id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')" style="display:block;" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        $head='';
        $head=implode(",",$head_list);
      if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
         {
            if($input_query->sub_location==15)
             $message['head'] =$head. ' N\'bhrd (s)';
            else
             
                $message['head'] =$head. ' Loclty (s)';

         }
        
          else
         {
           $message['head'] =$head. ' City';
         }
         
         return json_encode($message);
    }

     public function ck_getrd($input)
    {

        $input_query=json_decode($input['input']);

        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['uncovered_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Locality', 'className' => 'text-left'
         ));
             
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Relevant', 'className' => 'text-left'
         ));
              array_push($column, array(
             'title' => 'Has Cooler', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


          if(isset($input_query->city_id) && ($input_query->city_id !=0)  )
          {
             $rd_str .=" and a.city_id=".$input_query->city_id.""; 
             $exit_rd .=" and loc12=".$input_query->city_id."";
          }
          //   if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
          // {
          //   if($input_query->sub_location==15)
          //   {
          //        $rd_str .=" and a.loc15=".$input_query->ward_id.""; 
          //       $exit_rd .=" and loc15=".$input_query->ward_id."";
          //   }
          //   else
          //   {
          //        $rd_str .=" and a.loc16=".$input_query->ward_id.""; 
          //       $exit_rd .=" and loc16=".$input_query->ward_id."";
          //   }

            
          // }
          //  if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // {
          //    $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_rd).")"; 
          //    $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_rd).")";
          // }
          // // if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // // {
          // //    $rd_str .=" and a.rd_code in (".implode(',',$input_query->filter_rd).")"; 
          // //    $exit_rd .=" and RD_code in (".implode(',',$input_query->filter_rd).")";
          // // }
           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             if(is_array($input_query->filter_bychannel))
                 {
                     $rd_str .=" and a.type  in ('".implode("','",$input_query->filter_bychannel)."')"; 

                 }
                 else
                 {
                     $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
                 }
            
          }
           if(isset($input_query->filter_bypotential) && ($input_query->filter_bypotential!='')  )
          {
             $rd_str .=" and a.fld1923 in (".implode(',',$input_query->filter_bypotential).")"; 
          }
          
          if(isset($input_query->filter_bystatus) && ($input_query->filter_bystatus!='')  )
          {
             $rd_str .=" and a.status in  ('".implode("','",$input_query->filter_bystatus)."')"; 
          }
          
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             $exit_rd .=" and channel_type ='".$input_query->filter_bysubchannel."'";  
          }
          if(isset($input_query->locality) && ($input_query->locality!='')  )
          {
             $rd_str .=" and a.loc16 ='".$input_query->locality."'"; 
             $exit_rd .=" and loc16 ='".$input_query->locality."'"; 
          }
          // if(isset($input_query->premium_index) && ($input_query->premium_index!='')  )
          // {
          //    $rd_str .=" and a.beat_premium_index ='".$input_query->premium_index."'"; 
          //    $exit_rd .=" and premium_index_name ='".$input_query->premium_index."'"; 
             
          // }
          // if(isset($input_query->snacking_index) && ($input_query->snacking_index!='')  )
          // {
          //    $rd_str .=" and a.beat_snacking_index ='".$input_query->snacking_index."'"; 
          // }
          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
          // // if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // // {
          // //    if($input_query->filter_beat[0]!=null){
          // //        $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_beat).")"; 
          // //    $exit_rd .=" and fld1995 in (".implode(',',$input_query->filter_beat).")";
          // //    }
            
          // // }
          //   if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // {
          //    if($input_query->filter_beat[0]!=null){
          //        $rd_str .=" and a.loc16 in (".implode(',',$input_query->filter_beat).")"; 
          //    $exit_rd .=" and loc16 in (".implode(',',$input_query->filter_beat).")";
          //    }
            
          // }
        //$input['current_location']=[19.13645800,72.88651360];
           if(isset($input['current_location']))
          {
             $rd_str .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
              $exit_rd .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
          } 
 
      $covered_sql="SELECT `refid`,`loc12`,  `name`, `channel_type`, `address`, `latitude`, `longitude`,`stat`,nbhrd,locatlity,city_name,'' as shop_image FROM `ckpl_mumbai_outlet_master` where loc12=13346 and stat='A' and latitude!=0 and longitude!=0 ".$exit_rd." order by refid asc limit 0,100";
     
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);
      // var_dump($covered_res);die; 

     //

       $sql="SELECT a.`refid`, `retailer_id`, `name`, `type`, `sub_type`, `outlet_potential`, `fld1923`, `address`, `contact`, `latitude`, `longitude`, `city_id`, `city`, `nbhrd`, `locality_name`, `stat`, a.`status`, a.`created_date`, `shop_image`, `icon`, `user_lat`,loc15,loc16, `user_lon`,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,if(a.relevant='R','Relevant',if(a.relevant='NR','Not Relevant','')) as outlet_relevant,if(a.cooler='C','Yes',if(a.cooler='NC','No','')) as outlet_cooler,relevant,cooler,b.outlet_id,b.user_id,b.outlet_image FROM `ckpl_uncvrd_outlets` as a  left join jj_outlet_image as b on a.retailer_id=b.outlet_id where  a.stat='A'  and a.period='New Data'  ".$rd_str." order by refid asc limit 0,100";

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);


        if(isset($input_query->outlet_type))
        {
              if(!in_array(1,$input_query->outlet_type))
                 $covered_res=[];
             if(!in_array(2,$input_query->outlet_type))
                 $res=[];
        }

        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head_list=[];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {

                $temp=[];
                
              $temp['icon']='images/coveredblue_2.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
              $temp['refid']=$covered_res[$s]['refid'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$covered_res[$s]['locatlity'].' Locality</span><br><span style="line-height:1rem;">'.$covered_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city_name'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        for($s=0;$s<$total_potential;$s++)
        {
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\''.$res[$s]['loc16'].'\')">'.$res[$s]['locality_name'].'</a>',$res[$s]['outlet_status'],$res[$s]['outlet_relevant'],$res[$s]['outlet_cooler']);//

            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\''.trim($res[$s]['beat_snacking_index']).'\')">'.$res[$s]['beat_snacking_index'].'</a>',
            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\''.$res[$s]['beat_premium_index'].'\')">'.$res[$s]['beat_premium_index'].'</a>',

             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                $temp['locality_name']=$res[$s]['locality_name'];
                $temp['city']=$res[$s]['city'];
                $temp['nbhrd']=$res[$s]['nbhrd'];
                $temp['cooler']=$res[$s]['cooler'];
                $temp['relevant']=$res[$s]['relevant'];
                 $temp['status']=$res[$s]['status'];
                 $temp['name']=$res[$s]['name'];
                 $temp['outlet_potential']=$res[$s]['outlet_potential'];
                 $temp['contact']=$res[$s]['contact'];

                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
             $temp['style_code']= $style_code;
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';

               $relevant='';$not_relevant='';
              $relevant=($res[$s]['relevant']=='R') ? 'checked' : '';
              $not_relevant=($res[$s]['relevant']=='NR') ? 'checked' : '';

               $cooler='';$not_cooler='';
              $cooler=($res[$s]['cooler']=='C') ? 'checked' : '';
              $not_cooler=($res[$s]['cooler']=='NC') ? 'checked' : '';


              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';

             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
             $temp['circle_count']=$cicle_count;
            
             //  if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
             // {
             //    if($input_query->sub_location==15)
             //    {
             //        if(!in_array($res[$s]['nbhrd'],$head_list))
             //        array_push($head_list,$res[$s]['nbhrd']);
             //    } 
             //    else
             //      if(!in_array($res[$s]['locality_name'],$head_list))
             //        array_push($head_list,$res[$s]['locality_name']);

             // }
            
             //  else
             // {
                

             // }
             if(!in_array($res[$s]['city'],$head_list))
                    array_push($head_list,$res[$s]['city']);
                 $temp['info']='';


                 $temp['info'] .='</div>';

                 array_push($rd['uncovered_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        $head='';
        $head=implode(",",$head_list);
      if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
         {
            if($input_query->sub_location==15)
             $message['head'] =$head. ' N\'bhrd (s)';
            else
             
                $message['head'] =$head. ' Loclty (s)';

         }
        
          else
         {
           $message['head'] =$head. ' City';
         }
         
         return json_encode($message);
    }
    public function ck_getrd_old($input)
    {

        $input_query=json_decode($input['input']);

        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['uncovered_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Locality', 'className' => 'text-left'
         ));
             
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


          if(isset($input_query->city_id) && ($input_query->city_id !=0)  )
          {
             $rd_str .=" and a.city_id=".$input_query->city_id.""; 
             $exit_rd .=" and loc12=".$input_query->city_id."";
          }
          //   if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
          // {
          //   if($input_query->sub_location==15)
          //   {
          //        $rd_str .=" and a.loc15=".$input_query->ward_id.""; 
          //       $exit_rd .=" and loc15=".$input_query->ward_id."";
          //   }
          //   else
          //   {
          //        $rd_str .=" and a.loc16=".$input_query->ward_id.""; 
          //       $exit_rd .=" and loc16=".$input_query->ward_id."";
          //   }

            
          // }
          //  if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // {
          //    $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_rd).")"; 
          //    $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_rd).")";
          // }
          // // if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // // {
          // //    $rd_str .=" and a.rd_code in (".implode(',',$input_query->filter_rd).")"; 
          // //    $exit_rd .=" and RD_code in (".implode(',',$input_query->filter_rd).")";
          // // }
           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             if(is_array($input_query->filter_bychannel))
                 {
                     $rd_str .=" and a.type  in ('".implode("','",$input_query->filter_bychannel)."')"; 

                 }
                 else
                 {
                     $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
                 }
            
          }
           if(isset($input_query->filter_bypotential) && ($input_query->filter_bypotential!='')  )
          {
             $rd_str .=" and a.fld1923 in (".implode(',',$input_query->filter_bypotential).")"; 
          }
          
          if(isset($input_query->filter_bystatus) && ($input_query->filter_bystatus!='')  )
          {
             $rd_str .=" and a.status in  ('".implode("','",$input_query->filter_bystatus)."')"; 
          }
          
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             $exit_rd .=" and channel_type ='".$input_query->filter_bysubchannel."'";  
          }
          if(isset($input_query->locality) && ($input_query->locality!='')  )
          {
             $rd_str .=" and a.loc16 ='".$input_query->locality."'"; 
             $exit_rd .=" and loc16 ='".$input_query->locality."'"; 
          }
          // if(isset($input_query->premium_index) && ($input_query->premium_index!='')  )
          // {
          //    $rd_str .=" and a.beat_premium_index ='".$input_query->premium_index."'"; 
          //    $exit_rd .=" and premium_index_name ='".$input_query->premium_index."'"; 
             
          // }
          // if(isset($input_query->snacking_index) && ($input_query->snacking_index!='')  )
          // {
          //    $rd_str .=" and a.beat_snacking_index ='".$input_query->snacking_index."'"; 
          // }
          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
          // // if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // // {
          // //    if($input_query->filter_beat[0]!=null){
          // //        $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_beat).")"; 
          // //    $exit_rd .=" and fld1995 in (".implode(',',$input_query->filter_beat).")";
          // //    }
            
          // // }
          //   if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // {
          //    if($input_query->filter_beat[0]!=null){
          //        $rd_str .=" and a.loc16 in (".implode(',',$input_query->filter_beat).")"; 
          //    $exit_rd .=" and loc16 in (".implode(',',$input_query->filter_beat).")";
          //    }
            
          // }
        //$input['current_location']=[19.13645800,72.88651360];
           if(isset($input['current_location']))
          {
             $rd_str .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
              $exit_rd .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
          } 
 
      $covered_sql="SELECT `refid`,`loc12`,  `name`, `channel_type`, `address`, `latitude`, `longitude`,`stat`,nbhrd,locatlity,city_name,'' as shop_image FROM `ckpl_mumbai_outlet_master` where loc12=13346 and stat='A' and latitude!=0 and longitude!=0 ".$exit_rd." order by refid asc limit 0,100";
     
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);
      // var_dump($covered_res);die; 

     //
      $sql="SELECT a.`refid`, `retailer_id`, `name`, `type`, `sub_type`, `outlet_potential`, `fld1923`, `address`, `contact`, `latitude`, `longitude`, `city_id`, `city`, `nbhrd`, `locality_name`, `stat`, a.`status`, a.`created_date`, `shop_image`, `icon`, `user_lat`,loc15,loc16, `user_lon`,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,if(a.relevant='R','Relevant',if(a.status='NR','Not Relevant','')) as outlet_relevant,if(a.cooler='C','Yes',if(a.cooler='NC','No','')) as outlet_cooler,relevant,cooler,b.outlet_id,b.user_id,b.outlet_image FROM `ckpl_uncvrd_outlets` as a  left join jj_outlet_image as b on a.retailer_id=b.outlet_id where a.stat='A'   ".$rd_str." order by refid asc limit 0,5000";

    
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);


        if(isset($input_query->outlet_type))
        {
              if(!in_array(1,$input_query->outlet_type))
                 $covered_res=[];
             if(!in_array(2,$input_query->outlet_type))
                 $res=[];
        }

        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head_list=[];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {

                $temp=[];
                
              $temp['icon']='images/coveredblue_2.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
              $temp['refid']=$covered_res[$s]['refid'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$covered_res[$s]['locatlity'].' Locality</span><br><span style="line-height:1rem;">'.$covered_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city_name'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        for($s=0;$s<$total_potential;$s++)
        {
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\''.$res[$s]['loc16'].'\')">'.$res[$s]['locality_name'].'</a>',$res[$s]['outlet_status']);//

            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\''.trim($res[$s]['beat_snacking_index']).'\')">'.$res[$s]['beat_snacking_index'].'</a>',
            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\''.$res[$s]['beat_premium_index'].'\')">'.$res[$s]['beat_premium_index'].'</a>',

             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';

               $relevant='';$not_relevant='';
              $relevant=($res[$s]['relevant']=='R') ? 'checked' : '';
              $not_relevant=($res[$s]['relevant']=='NR') ? 'checked' : '';

               $cooler='';$not_cooler='';
              $cooler=($res[$s]['cooler']=='C') ? 'checked' : '';
              $not_cooler=($res[$s]['cooler']=='NC') ? 'checked' : '';


              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';

             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
            
             //  if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
             // {
             //    if($input_query->sub_location==15)
             //    {
             //        if(!in_array($res[$s]['nbhrd'],$head_list))
             //        array_push($head_list,$res[$s]['nbhrd']);
             //    } 
             //    else
             //      if(!in_array($res[$s]['locality_name'],$head_list))
             //        array_push($head_list,$res[$s]['locality_name']);

             // }
            
             //  else
             // {
                

             // }
             if(!in_array($res[$s]['city'],$head_list))
                    array_push($head_list,$res[$s]['city']);
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['locality_name'].' Locality</span><br><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/>';

                 $temp['info'] .='<div class="first_'.$res[$s]['retailer_id'].'"><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$res[$s]['sub_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span>'.$res[$s]['contact'].' </p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'">'.$res[$s]['outlet_potential'].'</span> </p><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault1_'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  style="display:block;" id="flexRadioDefault1_'.$res[$s]['retailer_id'].'" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1_'.$res[$s]['retailer_id'].'" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault2_'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')" style="display:block;" id="flexRadioDefault2_'.$res[$s]['retailer_id'].'" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2_'.$res[$s]['retailer_id'].'" > Not Found </label></div> </p><hr style="border-top: 1px solid white;"><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';
                 // $temp['info'] .='<div class="second_'.$res[$s]['retailer_id'].'" style="display:none;"><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">Relevant for CKPL?</span> </p><p><div class="form-check layout"> <input class="form-check-input" type="radio" name="flexRadioDefault3_'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'R\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  style="display:block;" id="flexRadioDefault3_'.$res[$s]['retailer_id'].'" '.$relevant.' >  <label class="form-check-label" for="flexRadioDefault3_'.$res[$s]['retailer_id'].'" >    Yes  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault4_'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'NR\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')" style="display:block;" id="flexRadioDefault4_'.$res[$s]['retailer_id'].'" '.$not_relevant.'>  <label class="form-check-label" for="flexRadioDefault4_'.$res[$s]['retailer_id'].'" > No </label></div> </p><span id="" style="float:left;padding: 0px;margin: 0px 5px;color:#fff;text-decoration:underline;border-radius: 10%;pointer:cursor !important;">Back</span><span id="" style="float:right;padding: 0px;margin: 0px 5px;color:#fff;text-decoration:underline;border-radius: 10%;pointer:cursor !important;">Next</span><hr style="border-top: 1px solid black;"></div>';

                 //  $temp['info'] .='<div class="third_'.$res[$s]['retailer_id'].'" style="display:none;"><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">Has Cooler?</span></p><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault5_'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'C\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  style="display:block;" id="flexRadioDefault5_'.$res[$s]['retailer_id'].'" '.$cooler.' >  <label class="form-check-label" for="flexRadioDefault5_'.$res[$s]['retailer_id'].'" >    Yes  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault6_'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'NC\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')" style="display:block;" id="flexRadioDefault6_'.$res[$s]['retailer_id'].'" '.$not_cooler.'>  <label class="form-check-label" for="flexRadioDefault6_'.$res[$s]['retailer_id'].'" > No </label></div> </p></div>';


                 $temp['info'] .='</div>';

                 array_push($rd['uncovered_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        $head='';
        $head=implode(",",$head_list);
      if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
         {
            if($input_query->sub_location==15)
             $message['head'] =$head. ' N\'bhrd (s)';
            else
             
                $message['head'] =$head. ' Loclty (s)';

         }
        
          else
         {
           $message['head'] =$head. ' City';
         }
         
         return json_encode($message);
    }
     public function coke_getrd($input)
    {
        $input_query=json_decode($input['input']);
        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['rd_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
         
           array_push($column, array(
             'title' => 'Channel', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Category Stocking', 'className' => 'text-left'
         ));
            
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Verification Status', 'className' => 'text-left'
         ));

            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
         
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
          }
            if(isset($input_query->filter_channel) && ($input_query->filter_channel!='')  )
          {
             $rd_str .=" and a.sub_type in ('".join("','",$input_query->filter_channel)."')"; 
          }
          if(isset($input_query->catgry) && ($input_query->catgry!='')  )
          {
             $rd_str .=" and a.catgry in ('".join("','",$input_query->catgry)."')"; 
          }
          if(isset($input_query->verified) && ($input_query->verified!='')  )
          {
             $rd_str .=" and a.verified_status in ('".join("','",$input_query->verified)."')"; 
          }
            if(isset($input_query->filter_category) && ($input_query->filter_category!='')  )
          {
             $rd_str .=" and a.catgry ='".$input_query->filter_category."'"; 
          }
          if(isset($input_query->verified_status) && ($input_query->verified_status!='')  )
          {
             $rd_str .=" and a.verified_status ='".$input_query->verified_status."'"; 
          }
           if(isset($input_query->filter_status) && ($input_query->filter_status!='')  )
          {
             $rd_str .=" and a.status in ('".join("','",$input_query->filter_status)."')"; 
          }
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
            
          }
       
         
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          {
             if($input_query->filter_beat[0]!=null){
                 $rd_str .=" and a.city_id in (".implode(',',$input_query->filter_beat).")"; 
            
             }
            
          }
         

         


         $sql="SELECT  a.`refid` as retailer_id, a.`State`, a.`District`, a.`Taluk`, a.`City/Villg`, a.`Sector`, a.`nbrhd_name` as nbhrd, a.`CCP_Name` as name, a.`address`, a.`latitude`, a.`longitude`, a.`Contact` as contact, a.`Prirotity`, a.`icon`, a.`shop_image`,a.status,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.`fld1923`,if(a.`fld1923`=1,'Low',if(a.`fld1923`=2,'Medium',if(a.`fld1923`=3,'High',''))) as outlet_potential, a.`type`, a.`beat_id`, a.`city_id`, a.`city`, a.`potential_status`, a.`cluster_id`, a.`retailer_name`, a.`contact_no`, a.`remark`, a.`verified_status`, a.`catgry`, a.`sub_type` FROM `coke_whlslrs` as a left join (SELECT `refid`, `outlet_id`, `user_id`, `outlet_image`, `created_date`, `status`, `client_id` FROM `jj_outlet_image` where client_id='".auth()->user()->client_id."') as b on a.refid=b.outlet_id where a.stat='A' ".$rd_str."  order by a.refid asc";
//echo $sql;die;
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          
        for($s=0;$s<$total_potential;$s++)
        { 
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\''.$res[$s]['catgry'].'\')">'.$res[$s]['catgry'].'</a>',$res[$s]['address'],'<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\'\',\'\',\'\',\''.$res[$s]['verified_status'].'\')">'.$res[$s]['verified_status'].'</a>',$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            { 
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
             
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                 $temp['status']=$res[$s]['status'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span>'.$res[$s]['sub_type'].'</p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Category Stocking: </span>'.$res[$s]['catgry'].'</p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Verification Status: </span>'.$res[$s]['verified_status'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><hr style="border-top: 1px solid white;"><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        // $head='';
        // if(isset($input_query->filter_subrdbeat_district) && (count($input_query->filter_subrdbeat_district)>0))
        // {
        //     $dist_list['dist']=array_unique($dist_list['dist']);
        //     $head=implode(",",$dist_list['dist']). ' Distt(s) - ';
        // }
        // else
        // {
        //     $dist_list['sst']=array_unique($dist_list['sst']);
        //     $head=implode(",",$dist_list['sst']);
        // }
        // $message['head'] =$head. ' SST(s)';
         return json_encode($message);
    }
     public function getsstsubrdbeat($input)
    {
        $input_query=json_decode($input['input']);
         if(isset($input_query->village_id) && $input_query->village_id!=''){

             return $this->highway_outlet($input);

         }
         $sst=[];
         $sst['beat_list']=[];         
         $sst['sst_village']=[];
         $sst['sst_list']=[];
         $sst['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'SST Code', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'SST Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Beat No', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Beat Order', 'className' => 'text-left'
         ));
 
           array_push($column, array(
             'title' => 'Village', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Village Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Sub-Distt', 'className' => 'text-left'
         ));
                  array_push($column, array(
             'title' => 'District', 'className' => 'text-left'
         ));
                  
                     array_push($column, array(
             'title' => 'State', 'className' => 'text-left'
         ));
                     
            array_push($column, array(
             'title' => 'Retailer Count in Village', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'Total Outlets in Beat', 'className' => 'text-right'
         ));
             array_push($column, array(
             'title' => 'Distance from previous Village', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'Total Beat Distance', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'Highway Name', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Total Time (Hrs.)', 'className' => 'text-right'
         ));
           
        
                 
 
         
         
          $user = auth()->user();
          $userid = $user->id;
          $subrd_id=[];$legend=[];
          $head='';
          $sst_str='';
          
          $head='';
          if(isset($input_query->filter_sstsubrdbeat) && (count($input_query->filter_sstsubrdbeat) > 0)){
                    $sst_str .=" and sst in (".implode(',',$input_query->filter_sstsubrdbeat).")";
            
          }
         
          if(isset($input_query->filter_sstbeat_district) && (count($input_query->filter_sstbeat_district) > 0)  )
          {
             $sst_str .=" and loc9 in (".implode(',',$input_query->filter_sstbeat_district).")"; 
          }
          if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          {
             $sst_str .=" and beat_no in (".implode(',',$input_query->filter_beat).")"; 
          }
         



         $sql="SELECT `refid`, `sst`, `sst_latitude`, `sst_longitude`, `beat_no`, `village_code`, `villg_latitude`, `villg_longitude`, `villg_type`,village_type_id, `retailer_count`, `total_retailer_count`, `distance_between_villg`, `distance_beat`, `highway_name`, `total_time_hrs`, `sst_name`, `sst_code`, `loc7`, `loc9`, `sst_file`,concat(sst,'#',beat_no) as beat_unique_id,state_name,district_name,taluk_name,concat(village_name,' villg.') as village_name,popn as population,rpi,visit_order,if(rpi_id=2,'D',if(rpi_id=1,'MD',if(rpi_id=3,'T',if(rpi_id=4,'UD',if(rpi_id=5,'NR',if(rpi_id=6,'NR-U',''))))))  as rpi_img FROM `sst_data` where stat='A'  ".$sst_str." order by refid asc";

     
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $sst_id=[];

        $dist_list=['dist'=>[],'sst'=>[]];
        $total_potential=count($res);
        
        for($s=0;$s<$total_potential;$s++)
        {
             

            $val_data=array(($s+1),$res[$s]['sst'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sst'].'" onClick="show_village_outlet(\'\',this)">'.$res[$s]['sst_name'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sst'].'" beat="'.$res[$s]['beat_no'].'" onClick="show_village_outlet(\'\',\'\',this)">Beat '.$res[$s]['beat_no'].'</a>',$res[$s]['visit_order'],$res[$s]['village_name'],$res[$s]['villg_type'],$res[$s]['taluk_name'],$res[$s]['district_name'],$res[$s]['state_name'],$res[$s]['retailer_count'],$res[$s]['total_retailer_count'],$res[$s]['distance_between_villg'],$res[$s]['distance_beat'],$res[$s]['highway_name'],$res[$s]['total_time_hrs']);
             array_push($value_data,$val_data);
             if(!array_key_exists($res[$s]['loc7'], $sst['map_list'])) 
            {
                 $sst['map_list'][$res[$s]['loc7']]='sst_path/'.$res[$s]['sst_file'];
                 array_push($message["maplist"],$sst['map_list'][$res[$s]['loc7']]);
                // $head .=$res[$s]['village_district'].',';
            }

            array_push($dist_list['dist'],$res[$s]['loc9']);
            array_push($dist_list['sst'],$res[$s]['sst']);


            if(!array_key_exists($res[$s]['beat_unique_id'], $sst['beat_list']))
            {
            $beat_id=$res[$s]['beat_unique_id'];
            $sst['beat_list'][$res[$s]['beat_unique_id']]=[];
            $sst['beat_list'][$res[$s]['beat_unique_id']]['beat_id']=$res[$s]['beat_no'];   
            $sst['beat_list'][$res[$s]['beat_unique_id']]['beat_name']='Beat '.$res[$s]['beat_no'];
            $sst['beat_list'][$res[$s]['beat_unique_id']]['beat_unique_id']=$res[$s]['beat_unique_id'];
            $sst['beat_list'][$res[$s]['beat_unique_id']]['color']=CommonController::random_hex_color();
            $sst['beat_list'][$res[$s]['beat_unique_id']]['village_name']=$res[$s]['village_name'];
            $sst['beat_list'][$res[$s]['beat_unique_id']]['state']=$res[$s]['state_name'];
            $sst['beat_list'][$res[$s]['beat_unique_id']]['district']=$res[$s]['district_name'];
             $sst['beat_list'][$res[$s]['beat_unique_id']]['village_taluk']=$res[$s]['taluk_name'];

            $sst['beat_list'][$res[$s]['beat_unique_id']]['info']='<div class="tooltip-data popupdata"><div class="card"><div class="card-header"><h3>Beat '.$res[$s]['beat_no'].'</h3></div><ul class="list-group list-group-flush"><li>State:<span>'.$res[$s]['state_name'].' </span></li><li>District:<span>'.$res[$s]['district_name'].' </span></li><li>Total Outlets in Beat:<span>'.$res[$s]['total_retailer_count'].' Nos.</span</li><li>Total Beat Distance:<span>'.$res[$s]['distance_beat'].' (Km.)</span></li></ul></div></div>';
           

            }
            if(!in_array($res[$s]['sst'], $sst_id))
            {
                array_push($sst_id,$res[$s]['sst']);
                $temp=[];
                 $temp['sst']=$res[$s]['sst'];  
                 $temp['sst_name']=$res[$s]['sst_name'];  
                  $temp['village_name']=$res[$s]['village_name'];
                $temp['state']=$res[$s]['state_name'];
                $temp['district']=$res[$s]['district_name'];
                $temp['village_taluk']=$res[$s]['taluk_name'];              
                  
                  $temp['latitude']=$res[$s]['sst_latitude'];
                  $temp['longitude']=$res[$s]['sst_longitude'];
                  $temp['beat_id']=$res[$s]['beat_no'];
                  $temp['beat_unique_id']=$res[$s]['beat_unique_id'];
                  $temp['color']='#3cb64a';
                 $temp['icon']='images/sst.png'; 
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$temp['sst_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['sst_latitude'].','.$res[$s]['sst_longitude'].'" onclick="location_navigate(this)" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['state_name'].' state</span><br><span style="line-height:1rem;">'.$res[$s]['district_name'].' distt</span><br><span style="line-height:1rem;">'.$res[$s]['taluk_name'].' sub-distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">SST Code: </span>'.$res[$s]['sst_code'].'</p><p><span style="color:rgb(242, 101, 34)">Village: </span><span style="background-color:white;color:black;" >'.$res[$s]['village_name'].' </span></p><p><span style="color:rgb(242, 101, 34)">Total Outlets in Beat: </span>'.$res[$s]['total_retailer_count'].' Nos. </p></div>';

                 array_push($sst['sst_list'],$temp);

            }
                $temp=[];
                $temp['color']=($res[$s]['village_type_id']==1) ? '#ffd700' : '#ffffff';

                $temp['beat_id']=$res[$s]['beat_no'];
                $temp['latitude']=$res[$s]['villg_latitude'];
                $temp['longitude']=$res[$s]['villg_longitude'];
                $temp['village_name']=$res[$s]['village_name'];
                $temp['state']=$res[$s]['state_name'];
                $temp['district']=$res[$s]['district_name'];
                $temp['village_taluk']=$res[$s]['taluk_name'];
                $temp['villg_type']=$res[$s]['villg_type'];
                $temp['visit_order']=$res[$s]['visit_order'];
                $temp['village_type_id']=$res[$s]['village_type_id'];                
                $temp['retailer_count']=$res[$s]['retailer_count'];
                $temp['total_retailer_count']=$res[$s]['total_retailer_count'];
                $temp['distance_between_villg']=$res[$s]['distance_between_villg'];
                $temp['distance_beat']=$res[$s]['distance_beat'];
                $temp['highway_name']=$res[$s]['highway_name'];
                $temp['total_time_hrs']=$res[$s]['total_time_hrs'];
                $temp['sst_name']=$res[$s]['sst_name'];
                $temp['sst_code']=$res[$s]['sst_code'];
                $temp['village_code']=$res[$s]['village_code'];
                $rural_img=($res[$s]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$res[$s]['rpi_img'].'.jpg"></img>';

                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['village_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['villg_latitude'].','.$res[$s]['villg_longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['state_name'].' state</span><br><span style="line-height:1rem;">'.$res[$s]['district_name'].' distt</span><br><span style="line-height:1rem;">'.$res[$s]['taluk_name'].' sub-distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Beat Name: </span>Beat '.$res[$s]['beat_no'].' </p><p><span style="color:rgb(242, 101, 34)">SST Name: </span>'.$res[$s]['sst_name'].' </p><p><span style="color:rgb(242, 101, 34)">Village Type: </span>'.$res[$s]['villg_type'].' </p><p><span style="color:rgb(242, 101, 34)">Population: </span>'.number_format($res[$s]['population'],0).' Nos.</p><p><span style="color:rgb(242, 101, 34)">Rural Progressive Index: </span>'.$rural_img.' </p><p><span style="color:rgb(242, 101, 34)">Retailer Count: </span>'.$res[$s]['retailer_count'].' Nos. </p><p><span style="color:rgb(242, 101, 34)">Distance from previous Village: </span>'.$res[$s]['distance_between_villg'].' (Km.)</p><p><span style="color:rgb(242, 101, 34)">Visit Order: </span>'.$res[$s]['visit_order'].' </p></div>';

               
              array_push($sst['sst_village'],$temp);

        }
        $message['legend']=[];
        array_push($message['legend'],'<span style="height: 25px;  width: 25px;  background-color: #ffd700;  border-radius: 50%;  display: inline-block;"></span> - Highway Village');
        array_push($message['legend'],'<span style="height: 25px;  width: 25px;  background-color: #ffffff;  border-radius: 50%;  display: inline-block;"></span> <2K Pop. Inactive Village');
        
        $message['result']=$sst;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
       // ksort($legend);
        $message['legend']=[];
      

                   
        $message['label'] = '';

      //  $message['legend']=[];
        //$message['legend'][0] = array_values($legend);
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = $sst['beat_list'];
        $message['tbl'] = '';
        if(isset($input_query->fit_bounds))
            $message['fit_bounds']=1;
        $head='';
        if(isset($input_query->filter_subrdbeat_district) && (count($input_query->filter_subrdbeat_district)>0))
        {
            $dist_list['dist']=array_unique($dist_list['dist']);
            $head=implode(",",$dist_list['dist']). ' Distt(s) - ';
        }
        else
        {
            $dist_list['sst']=array_unique($dist_list['sst']);
            $head=implode(",",$dist_list['sst']);
        }
        $message['head'] ='SST Beats';
         return json_encode($message);
    }
    public function getsubrdbeat($input)
    {
         $subrd=[];
         $subrd['beat_list']=[];         
         $subrd['subrd_retailer']=[];
         $subrd['subrd_list']=[];
         $subrd['map_list']=[];
         $column=[];
         $value_data=[];
            
         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'SubRD Market-UID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'SubRD Code', 'className' => 'text-right'
         ));
          array_push($column, array(
             'title' => 'SubRD Name', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'SubRD District', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'SubRD Sub-Distt', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'SubRD Village', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Beat', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Beat Unique ID', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Village Market-UID', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'Visit Order', 'className' => 'text-right'
         ));
           
         //        array_push($column, array(
         //     'title' => 'Village Name', 'className' => 'text-left'
         // ));
                  array_push($column, array(
             'title' => 'Sub-Distt', 'className' => 'text-left'
         ));
                  array_push($column, array(
             'title' => 'District', 'className' => 'text-left'
         ));
                  
                     array_push($column, array(
             'title' => 'State', 'className' => 'text-left'
         ));
 
             array_push($column, array(
             'title' => 'One Way Distance (Kms) Between Villages', 'className' => 'text-right'
         ));
        
        array_push($column, array(
             'title' => 'One Way Travelling Time between villages (Mins)', 'className' => 'text-right'
         ));
         array_push($column, array(
             'title' => 'One Way Distance Covered (Kms) per Beat', 'className' => 'text-right'
         ));
        
         array_push($column, array(
             'title' => 'No. of Outlets in each Village', 'className' => 'text-right'
         ));
         array_push($column, array(
             'title' => 'Total Outlets Covered per Beat', 'className' => 'text-right'
         ));
        
         array_push($column, array(
             'title' => 'No. of wholesalers in each Village', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'No. of VisiCoolers in each Village', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'No. of Wholesalers per Beat', 'className' => 'text-right'
         ));
             array_push($column, array(
             'title' => 'No. of VisiCooler Outlets Per Beat', 'className' => 'text-right'
         )); 
         array_push($column, array(
             'title' => 'SubRD Type', 'className' => 'text-left'
         ));             

            array_push($column, array(
             'title' => 'Assumed Overall Time (Hrs)', 'className' => 'text-right'
         ));           

            array_push($column, array(
             'title' => 'Classification', 'className' => 'text-left'
         ));
           

           

         
         $input_query=json_decode($input['input']);
          $user = auth()->user();
          $userid = $user->id;
          $subrd_id=[];$legend=[];
          $head='';
          $subrd_str='';
          
          $head='';
          if(isset($input_query->filter_subrdbeat) && (count($input_query->filter_subrdbeat) > 0)){
                    $subrd_str .=" and a.beat_id in (".implode(',',$input_query->filter_subrdbeat).")";
            
          }
         


          if(isset($input_query->filter_subrd) && (count($input_query->filter_subrd) > 0)){
                    $subrd_str .=" and a.subrd_id in (".implode(',',$input_query->filter_subrd).")";            
          }
          else if(isset($input_query->filter_subrdbeat_district) && (count($input_query->filter_subrdbeat_district) > 0)  )
          {
             $subrd_str .=" and a.loc9 in (".implode(',',$input_query->filter_subrdbeat_district).")"; 
          }
         



       $sql="SELECT a.village_name as village,a.`refid`,a.`subrd_code`,a.`subrd_village`,a.`subrd_name`,a.`subrd_id`,a.`subrd_district`,a.`subrd_taluk`,a.`created_date`,a.`subrd_latitude`,a.`subrd_longitude`,a.`beat_id`,a.`beat_unique_id`,a.`village_market_id`,a.`village_state`,a.`village_district`,a.`village_taluk`,a.`oneway_distance`,a.`beatween_distance`,a.`oneway_distance_per_beat`,a.`covered_outlets_beat`,a.`covered_outlets`,a.`covered_wholesaler`,a.`covered_wholesaler_beat`,a.`covered_visicooler`,a.`covered_visicooler_beat`,a.`subrd_type`,a.`overall_time`,a.`stat`,a.`tsm_id`,if(a.sector='Rural',concat(a.`village_name`,' villg.'),if(a.sector='Urban',concat(a.`village_name`,' town'),a.village_name)) as village_name,a.`visit_order`,a.`village_latitude`,a.`village_longitude`,a.`village_id`,b.`beat_name`,b.`refid` as beat,b.`beat_unique_id`,b.`beat_file`,b.`state_id`,b.`stat`,b.`premium_id`,b.`covered_village`,b.`covered_wholesaler` as beat_wholesaler,b.`covered_cooler_outlets`,b.`bi_premium` as premium,b.`bi_premium` FROM `subrd_outlet` as a ,subrd_beat_master as b where a.beat_id=b.refid and b.stat='A' ".$subrd_str." order by b.beat_name desc";

     // \Log::info($sql);
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $sub=[];

        $dist_list=['dist'=>[],'subrd'=>[]];
        $total_potential=count($res);
         $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
         $type_subrd=[1=>'Actual',2=>'Assumed'];
        $test=['No Visit'=>3,'No visit'=>3,'Premium'=>0,'Medium'=>1,'Van Beat'=>2,'Inefficient'=>3,'Average'=>1,'Good'=>0,'Very Good'=>0];

         $subrd_arr=range(0,30);$colorval=0;$premium=[];
        for($s=0;$s<$total_potential;$s++)
        {
            


            $val_data=array(($s+1),$res[$s]['subrd_id'],$res[$s]['subrd_code'],'<a href="#" style="text-decoration:underline;" onClick="show_subrdbeat(0,'.$res[$s]['subrd_id'].')">'.ucwords(strtolower($res[$s]['subrd_name'])).'</a>',$res[$s]['subrd_district'],$res[$s]['subrd_taluk'],$res[$s]['village_name'],'<a href="#" style="text-decoration:underline;" onClick="show_subrdbeat('.$res[$s]['beat_id'].',0)">'.$res[$s]['beat_name'].'</a>',$res[$s]['beat_unique_id'],$res[$s]['village_market_id'],$res[$s]['visit_order'],$res[$s]['village_taluk'],$res[$s]['village_district'],$res[$s]['village_state'],$res[$s]['oneway_distance'],$res[$s]['beatween_distance'],$res[$s]['oneway_distance_per_beat'],$res[$s]['covered_outlets'],$res[$s]['covered_village'],$res[$s]['covered_wholesaler'],$res[$s]['covered_visicooler'],$res[$s]['beat_wholesaler'],$res[$s]['covered_cooler_outlets'],$type_subrd[$res[$s]['subrd_type']],$res[$s]['overall_time'],$res[$s]['premium']);
             array_push($value_data,$val_data);
             if(!array_key_exists($res[$s]['state_id'], $subrd['map_list'])) 
            {
                 $subrd['map_list'][$res[$s]['state_id']]='beat_path/'.$res[$s]['beat_file'];
                 array_push($message["maplist"],$subrd['map_list'][$res[$s]['state_id']]);
                // $head .=$res[$s]['village_district'].',';
            }

            array_push($dist_list['dist'],$res[$s]['village_district']);
            array_push($dist_list['subrd'],$res[$s]['subrd_name']);

            if(!in_array($res[$s]['premium'], $premium))
            {
                array_push($premium,$res[$s]['premium']);
               
                $colorval++;
               
                $sub[$res[$s]['premium']]=CommonController::split_color_variation_beat($test[$res[$s]['premium']]);
                $legend[$test[$res[$s]['premium']]]=[ucwords(strtolower($res[$s]['premium']))=>$sub[$res[$s]['premium']]['hex']];

               // $legend[ucwords(strtolower($res[$s]['premium']))]=$sub[$res[$s]['premium']]['hex'];
            }

            if(!array_key_exists($res[$s]['beat_unique_id'], $subrd['beat_list']))
            {
            $beat_id=$res[$s]['beat_unique_id'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]=[];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['beat_id']=$res[$s]['beat_id'];   
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['beat_name']=$res[$s]['beat_name'];                
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['beat_unique_id']=$res[$s]['beat_unique_id'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['covered_village']=$res[$s]['covered_village'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['covered_wholesaler']=$res[$s]['covered_wholesaler'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['covered_visicooler_beat']=$res[$s]['covered_visicooler_beat'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['premium']=$res[$s]['premium'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['bi_premium']=$res[$s]['bi_premium'];
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['color']=$sub[$res[$s]['premium']]['hex'];
            
    
           
            $subrd['beat_list'][$res[$s]['beat_unique_id']]['info']='<div class="tooltip-data popupdata"><div class="card"><div class="card-header"><h3>'.$res[$s]['beat_name'].'</h3></div><ul class="list-group list-group-flush"><li>State:<span>'.$res[$s]['village_state'].'</span></li><li>District:<span>'.$res[$s]['village_district'].'</span></li><li>Taluk:<span>'.$res[$s]['village_taluk'].'</span></li><li>Covered Outlets:<span>'.$res[$s]['covered_outlets_beat'].' Nos.</span</li><li>Covered Wholesaler:<span>'.$res[$s]['covered_wholesaler_beat'].' Nos.</span</li><li>Covered VisiCooler:<span>'.$res[$s]['covered_visicooler_beat'].' Nos.</span</li><li>One Way Distance Covered per Beat:<span>'.$res[$s]['oneway_distance_per_beat'].' Kms.</span</li><li>Classification:<span>'.$res[$s]['premium'].'</span></li></ul></div></div>';
            
            }
            if(!in_array($res[$s]['subrd_id'], $subrd_id))
            {
                array_push($subrd_id,$res[$s]['subrd_id']);
                $temp=[];
                 $temp['subrd_name']=$res[$s]['subrd_name'];                
                  $temp['type']=$type_subrd[$res[$s]['subrd_type']];
                  $temp['latitude']=$res[$s]['subrd_latitude'];
                  $temp['longitude']=$res[$s]['subrd_longitude'];
                  $temp['beat_id']=$res[$s]['beat_id'];
                  $temp['beat_unique_id']=$res[$s]['beat_unique_id'];
                  $temp['color']='#3cb64a';
                 $temp['icon']='highway/actual_subrd.png'; 
                
                 $temp['info']='<div class="container-fluid pb-2" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$temp['subrd_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['subrd_latitude'].','.$res[$s]['subrd_longitude'].'" onclick="location_navigate(this)" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$res[$s]['beat_unique_id'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">SubRD Code: </span>'.$res[$s]['subrd_code'].'</p><p><span style="color:rgb(242, 101, 34)">State: </span>'.$res[$s]['village_state'].'</p><p><span style="color:rgb(242, 101, 34)">District: </span>'.$res[$s]['subrd_district'].' </p><p><span style="color:rgb(242, 101, 34)">Taluk: </span>'.$res[$s]['subrd_taluk'].' </p><p><span style="color:rgb(242, 101, 34)">Village: </span>'.$res[$s]['subrd_village'].' </p></div>';

                 array_push($subrd['subrd_list'],$temp);

            }
                $temp=[];
                $temp['color']='#ffffff';
                $temp['beat_id']=$res[$s]['beat_id'];
                $temp['latitude']=$res[$s]['village_latitude'];
                $temp['longitude']=$res[$s]['village_longitude'];
                $temp['village_name']=$res[$s]['village_name'];
                $temp['state']=$res[$s]['village_state'];
                $temp['district']=$res[$s]['village_district'];
                $temp['village_taluk']=$res[$s]['village_taluk'];
                $temp['oneway_distance']=$res[$s]['oneway_distance'];
                $temp['beatween_distance']=$res[$s]['beatween_distance'];
                $temp['covered_wholesaler']=$res[$s]['covered_wholesaler'];
                $temp['covered_visicooler']=$res[$s]['covered_visicooler'];
                $temp['covered_outlets']=$res[$s]['covered_outlets'];
                $temp['visit_order']=$res[$s]['visit_order'];
                $temp['beat_unique_id']=$res[$s]['beat_unique_id'];
                $temp['beat_name']=$res[$s]['beat_name'];
                


              

                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['village_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['village_latitude'].','.$res[$s]['village_longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$res[$s]['beat_id'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Beat Name: </span>'.$res[$s]['beat_name'].' </p><p><span style="color:rgb(242, 101, 34)">Village Market ID: </span>'.$res[$s]['village_market_id'].' </p><p><span style="color:rgb(242, 101, 34)">Visit Order: </span>'.$res[$s]['visit_order'].' </p><p><span style="color:rgb(242, 101, 34)">Actual or Assumed Outlet Nos.: </span>'.$type_subrd[$res[$s]['subrd_type']].' </p><p><span style="color:rgb(242, 101, 34)">Covered Outlets: </span>'.$res[$s]['covered_outlets'].' </p><p><span style="color:rgb(242, 101, 34)">Covered VisiCooler: </span>'.$res[$s]['covered_visicooler'].' </p><p><span style="color:rgb(242, 101, 34)">Covered Wholesaler: </span>'.$res[$s]['covered_wholesaler'].' </p><p><span style="color:rgb(242, 101, 34)">State: </span>'.$res[$s]['village_state'].'</p><p><span style="color:rgb(242, 101, 34)">District: </span>'.$res[$s]['village_district'].' </p><p><span style="color:rgb(242, 101, 34)">Taluk: </span>'.$res[$s]['village_taluk'].'</p><p><span style="color:rgb(242, 101, 34)">Village: </span>'.$res[$s]['village'].'</p></div>';

               
              array_push($subrd['subrd_retailer'],$temp);

        }
        
        
        $message['result']=$subrd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
        ksort($legend);
        $message['legend']=[];
        foreach($legend as $k=>$v)
            foreach($v as $key=>$val)
                        $message['legend'][0][$key]=$val;

                   
        $message['label'] = '';
      //  $message['legend']=[];
        //$message['legend'][0] = array_values($legend);
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = $subrd['beat_list'];
        $message['tbl'] = '';
        $head='';
        if(isset($input_query->filter_subrdbeat_district) && (count($input_query->filter_subrdbeat_district)>0))
        {
            $dist_list['dist']=array_unique($dist_list['dist']);
            $head=implode(",",$dist_list['dist']). ' Distt(s) - ';
        }
        else
        {
            $dist_list['subrd']=array_unique($dist_list['subrd']);
            $head=implode(",",$dist_list['subrd']);
        }
        $message['head'] =$head. ' SubRD(s)';
         return json_encode($message);
    }
    public function highway_outlet($input)
    {
         $highway=[];
         $highway['highway_retailer']=[];
         $column=[];
         $value_data=[];
         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Establishment Name', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Channel Type', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            
              array_push($column, array(
             'title' => 'Group', 'className' => 'text-right'
         ));
           
             array_push($column, array(
             'title' => 'City/Village', 'className' => 'text-right'
         ));
              array_push($column, array(
             'title' => 'Taluk', 'className' => 'text-right'
         ));
               array_push($column, array(
             'title' => 'District', 'className' => 'text-right'
         ));
                array_push($column, array(
             'title' => 'State', 'className' => 'text-right'
         ));
          $input_query=json_decode($input['input']);
          $user = auth()->user();
          $userid = $user->id;
          $subrd_id=[];
          $head='';
          $str='';
          

         $sql="SELECT `refid`, `highway_id`, `ccp_id`, `ccp_name`, `address`, `ccp_latitude`, `ccp_longitude`, `group_type`, if(`group_type`=1,'Group A',if(`group_type`=2,'Group B','')) as `group`, `proximity`, `stat`, `subrd_id`, `channel`, `tsm_id`, `status`, `stocking_confictionary`, `stocking_chocolate`, `cluster`, `loc14`, `area`, `city_village`, `taluk`, `district`, `state` FROM `highway_outlet` where loc14='".$input_query->village_id."' ";
       
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
       
        $total_potential=count($res);
        for($s=0;$s<$total_potential;$s++)
        {
            
             
            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['refid'].','.$res[$s]['ccp_latitude'].','.$res[$s]['ccp_longitude'].')">'.$res[$s]['ccp_name'].'</a>',$res[$s]['channel'],$res[$s]['address'],$res[$s]['group'],$res[$s]['city_village'],$res[$s]['taluk'],$res[$s]['district'],$res[$s]['state']
                );

             array_push($value_data,$val_data);

                $temp=[];
                $temp['color']=($res[$s]['group_type']==1) ? '#f8ef1b' :(($res[$s]['group_type']==2) ? '#6bcde3' : '#fff');
                $temp['highway_id']=$res[$s]['highway_id'];
                $temp['latitude']=$res[$s]['ccp_latitude'];
                $temp['longitude']=$res[$s]['ccp_longitude'];
                $temp['ccp_name']=$res[$s]['ccp_name'];                
              
                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['ccp_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['ccp_latitude'].','.$res[$s]['ccp_longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['state'].' State</span><br><span style="line-height:1rem;">'.$res[$s]['district'].' Distt</span><br><span style="line-height:1rem;">'.$res[$s]['taluk'].' Sub-Distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><span style="color:#00CCCC;font-weight:bold;">'.$res[$s]['address'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Channel: </span>'.$res[$s]['channel'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Village: </span>'.$res[$s]['city_village'].' </p></div>';
              array_push($highway['highway_retailer'],$temp);

        }
        
       if($total_potential > 0) 
       {
           $message['result']=$highway;     
            $message['griddata']=array(
                'column' => $column,
                'value' => $value_data
            );  
            $message['label'] = '';
            $message['loc_level'] = 0;
            $message['loc_id'] = 0;
            $message['main_location'] = 0;
            $message['sub_location'] =0;
            $message['status'] = true;
            $message['message'] = 'map loaded successfully.';
            $message['map_nextlevel_info'] = [];
            $message['tbl'] = '';
            $message['head'] = $res[0]['city_village']. ' Outlet(s)';
       }
       else
       {
          $message['status']=0;
          $message['message']='No Data Available';
       }
        
        

         return json_encode($message);

            
    }
     public function gethighway($input)
     {

         $highway=[];
         $highway['highway_list']=[];         
         $highway['highway_retailer']=[];
         $highway['subrd_list']=[];
         $column=[];
         $value_data=[];
           
         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Establishment Name2', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Channel Type1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
              array_push($column, array(
             'title' => 'SubRD Code', 'className' => 'text-left'
         ));
               array_push($column, array(
             'title' => 'SubRD', 'className' => 'text-left'
         ));
                array_push($column, array(
             'title' => 'SubRD Market UID', 'className' => 'text-left'
         ));
                 array_push($column, array(
             'title' => 'SubRD Type', 'className' => 'text-right'
         ));
                 array_push($column, array(
             'title' => 'Recommended Village', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Recommended SubRD Loc ID', 'className' => 'text-right'
         ));
            
            
              array_push($column, array(
             'title' => 'Group', 'className' => 'text-right'
         ));

         
          
          
            array_push($column, array(
             'title' => 'Cluster', 'className' => 'text-right'
         ));
          
         
            
            array_push($column, array(
             'title' => 'Highway', 'className' => 'text-right'
         ));
             array_push($column, array(
             'title' => 'City/Village', 'className' => 'text-right'
         ));
              array_push($column, array(
             'title' => 'Taluk', 'className' => 'text-right'
         ));
               array_push($column, array(
             'title' => 'District', 'className' => 'text-right'
         ));
                array_push($column, array(
             'title' => 'State', 'className' => 'text-right'
         ));
            
           

         
         $input_query=json_decode($input['input']);
          $user = auth()->user();
          $userid = $user->id;
          $subrd_id=[];
          $head='';
          $str='';
          if(!isset($input_query->filter_highway)){

             $input_query->filter_highway=[0];
            
          }
          if(isset($input_query->filter_channel) && $input_query->filter_channel!='')
          {
                $str .=" and a.channel='".$input_query->filter_channel."'";
          }
          if(isset($input_query->filter_subrd) && $input_query->filter_subrd!=0)
          {
                $str .=" and c.subrd_code='".$input_query->filter_subrd."'";
          }

      
         $sql="select a.refid as outlet_id,a.subrd_id,b.refid as highway_id,b.highway_info,b.highway_name,b.start_point,b.end_point,b.length,a.ccp_id,a.ccp_name,a.address,a.ccp_latitude as latitude,a.ccp_longitude as longitude,a.group_type,a.channel,a.status,a.stocking_confictionary,a.stocking_chocolate,b.length,c.state,c.taluk,c.district,c.village,a.city_villge,c.subrd_code,if(c.subrd_type=2,c.loc14,'') as recommand_locid,c.subrd_lat,c.subrd_lon,c.subrd_type,c.address as subrd_address,c.contact_no,if(c.subrd_type=1,c.subrd_name,'') as subrd_name,if(c.subrd_type=2,c.subrd_name,'') as recomend_subrd_name,if(c.subrd_type=1,'Actual SubRD','Recomnd SubRD Location') as subrd_name_type,if(c.subrd_type=1,'SubRD Code','BI Location ID') as subrd_title,c.subrd_type,if( a.group_type=1,'Group A','Group B') as group_name,a.group_type,a.cluster,c.subrd_markt_uid as subrd_market_id,c.state,c.district,c.taluk,c.village  from highway_outlet as a,highway_structure as b,highway_subrd as c  where a.highway_id=b.refid and a.subrd_id=c.refid and a.highway_id in (".implode(',',$input_query->filter_highway).") $str ";

         //\Log::info($sql);
       
     
        $res = DB::select(DB::raw($sql)); 
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $potential_list=[];
        $total_potential=count($res);
        for($s=0;$s<$total_potential;$s++)
        {
            $cluster_name=($res[$s]['cluster']==0) ? '' :'C'.$res[$s]['cluster'];
             
            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['outlet_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['ccp_name'].'</a>','<a href="#" style="text-decoration:underline;" onClick="show_highway(0,\''.$res[$s]['channel'].'\')">'.$res[$s]['channel'].'</a>',$res[$s]['address'], '<a href="#" style="text-decoration:underline;" onClick="show_highway(0,\'\',\''.$res[$s]['subrd_code'].'\')">'.$res[$s]['subrd_code'].'</a>',$res[$s]['subrd_name'],$res[$s]['subrd_market_id'],$res[$s]['subrd_name_type'],$res[$s]['recomend_subrd_name'],$res[$s]['recommand_locid'],$res[$s]['group_name'],$cluster_name,'<a href="#" style="text-decoration:underline;" onClick="show_highway('.$res[$s]['highway_id'].')">'.$res[$s]['highway_name'].'</a>',$res[$s]['city_villge'],$res[$s]['taluk'],$res[$s]['district'],$res[$s]['state']
                );

             array_push($value_data,$val_data);

            if(!array_key_exists($res[$s]['highway_id'], $highway['highway_list']))
            {
                 $highway_id=$res[$s]['highway_id'];
                 $higway_potential=array_filter($res, function($k,$v) use ($highway_id) {
                    
                    return $k['highway_id'] == $highway_id;
                }, ARRAY_FILTER_USE_BOTH);
                  
                 $highway['highway_list'][$res[$s]['highway_id']]=[];
                 $highway['highway_list'][$res[$s]['highway_id']]['highway_potential']=count($higway_potential);
                 array_push($potential_list,$highway['highway_list'][$res[$s]['highway_id']]['highway_potential']);
                 $highway['highway_list'][$res[$s]['highway_id']]['highway_name']=$res[$s]['highway_name'];                
                 $highway_=str_replace(" ", "",$res[$s]['highway_name']);
                
                 $highway['highway_list'][$res[$s]['highway_id']]['highway']='highway_path/'.$highway_.'.geojson';
                 array_push($message["maplist"], $highway['highway_list'][$res[$s]['highway_id']]['highway']);
                 $highway['highway_list'][$res[$s]['highway_id']]['info']='<div class="tooltip-data popupdata"><div class="card"><div class="card-header"><h3>'.$res[$s]['highway_name'].'</h3></div><ul class="list-group list-group-flush"><li class="text-wrap pb-2" style="max-width:15rem;display: inline-block;">'.$res[$s]['highway_info'].'</li><li>Stretch Length:<span>'.$res[$s]['length'].' Km.</span</li><li>Outlet Potential:<span>'.$highway['highway_list'][$res[$s]['highway_id']]['highway_potential'].' Nos.</span</li></ul></div></div>';
                 $head .=$res[$s]['highway_name'].',';
            }
            if(!in_array($res[$s]['subrd_id'], $subrd_id))
            {
                array_push($subrd_id,$res[$s]['subrd_id']);
                  $temp=[];
                 $temp['subrd_name']=$res[$s]['subrd_name'];
                 $temp['address']=$res[$s]['address'];
                 $temp['contact_no']=$res[$s]['contact_no'];
                  $temp['type']=$res[$s]['subrd_name_type'];
                  $temp['latitude']=$res[$s]['subrd_lat'];
                  $temp['longitude']=$res[$s]['subrd_lon'];
                  $temp['highway_id']=$res[$s]['highway_id'];
                  if($res[$s]['subrd_type']==1)
                 {
                    $temp['color']='#3cb64a';
                    $temp['icon']='highway/actual_subrd.png';            
                 }
                 if($res[$s]['subrd_type']==2)
                 {
                    //echo $result[$i]['subrd_type'];die;
                   $temp['color']='#f37121';
                   $temp['icon']='highway/recomnd_subrd.png';          
                 }
                
                  $subrd_name=($res[$s]['subrd_name']!='') ? $res[$s]['subrd_name'] : $res[$s]['recomend_subrd_name'].' Villg.';

                 //    $temp['info']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$subrd_name.'</h3> </div>'.$res[$s]['sub_text'].'</div></div>';


                     $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$subrd_name.'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['subrd_lat'].','.$res[$s]['subrd_lon'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$res[$s]['subrd_code'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['state'].' State</span><br><span style="line-height:1rem;">'.$res[$s]['district'].' Distt</span><br><span style="line-height:1rem;">'.$res[$s]['taluk'].' Sub-Distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">'.$res[$s]['subrd_title'].': </span>'.$res[$s]['subrd_code'].'</p><p><span style="color:rgb(242, 101, 34)">SubRD Type: </span>'.$res[$s]['subrd_name_type'].' </p>';
                    if($res[$s]['subrd_type']==1)
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34)">Village: </span>'.$res[$s]['village'].' </p>';
                    $temp['info'] .='</div>';
                 array_push($highway['subrd_list'],$temp);

            }
                $temp=[];
                $temp['color']=($res[$s]['group_type']==1) ? '#f8ef1b' :(($res[$s]['group_type']==2) ? '#6bcde3' : '#fff');
                $temp['highway_id']=$res[$s]['highway_id'];
                $temp['latitude']=$res[$s]['latitude'];
                $temp['longitude']=$res[$s]['longitude'];
                $temp['ccp_name']=$res[$s]['ccp_name'];
                $temp['subrd_id']=$res[$s]['subrd_id'];
                $temp['cluster']=$res[$s]['cluster'];
                $temp['outlet_id']=$res[$s]['outlet_id'];
                if(!in_array($res[$s]['subrd_id'],$subrd_id))
                    array_push($subrd_id,$res[$s]['subrd_id']);


                $subrd_name_=($res[$s]['subrd_name']!='') ? $res[$s]['subrd_name'] : $res[$s]['recomend_subrd_name'];
                 $subrd_code_title=($res[$s]['subrd_type']==1) ? 'SubRD Code' : 'Bi Location id';
                 $subrd_name_title=($res[$s]['subrd_type']==1) ? 'SubRD Name' : 'Recommended Location';

                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['ccp_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$res[$s]['refid'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['state'].' State</span><br><span style="line-height:1rem;">'.$res[$s]['district'].' Distt</span><br><span style="line-height:1rem;">'.$res[$s]['taluk'].' Sub-Distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><span style="color:#00CCCC;font-weight:bold;">'.$res[$s]['address'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Channel: </span>'.$res[$s]['channel'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$subrd_code_title.': </span>'.$res[$s]['subrd_code'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$subrd_name_title.': </span>'.$subrd_name_.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Village: </span>'.$res[$s]['city_villge'].' </p></div>';

               
              array_push($highway['highway_retailer'],$temp);

        }
        $max=1;$min=1;
        if(count($potential_list) > 0)
        {
             $max=max($potential_list);
             $min=min($potential_list);
        }

        foreach ($highway['highway_list'] as $key => $value) {
            $color_critiea=((float)$value['highway_potential']/(float)$max)*100;
            $remain=$max-$min;
            if($remain==0)
                 $color="hsl(".$this->isolate[0].", ".$this->isolate[1]."%, ".$this->isolate[2]."%)";
            if($remain!=0)
            {
                $delta=((float)$value['highway_potential']-$min)/$remain;
                $color=CommonController::getColor($max, $min, $delta,$this->low,$this->high);
            }
             
             $highway['highway_list'][$key]['color']=$color;
            
        }
        
        
        $message['result']=$highway;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = $highway['highway_list'];
        $message['tbl'] = '';
        $message['head'] = trim($head,","). ' Highway(s)';
         return json_encode($message);


     }


    public function notrelavantoutlet(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $client_id = $user->client_id;
        $feedback_question = [];
        $id = $input["outlet_id"];
        $current_lat = $input["lat"];
        $current_lon = $input["lon"];
        $date = date("Y-m-d H:i:s");
        $update_status = DB::table("uncovered_outlets")
            ->where("refid", "=", $id)
            ->update(["status" => "R", "potential_store" => 0]);
        $inserthistory = DB::table("uncovered_outlet_details")->updateOrInsert(
            ["outlet_refid" => $id],
            [
                "status" => "R",
                "jj_stock" => 0,
                "competition_stock" => 0,
                "jj_baby" => 0,
                "competition_baby" => 0,
                "jj_female" => 0,
                "competition_female" => 0,
                "jj_otc" => 0,
                "competition_facewash" => 0,
                "potential_store" => 0,
                "lat" => $current_lat,
                "lon" => $current_lon,
                "user_id" => $userid,
                "created_date" => $date,
                "competition_facewash" => 0,
                "potential_baby" => 0,
                "potential_female" => 0,
                "potential_otc" => 0,
                "channel_id" => 0,
                "jj_skincare" => 0,
                "competition_otc" => 0,
                "jj_1" => 0,
                "jj_2" => 0,
                "jj_3" => 0,
                "jj_4" => 0,
                "comp_1" => 0,
                "comp_2" => 0,
                "comp_3" => 0,
                "comp_4" => 0,
                "potential_skincare" => 0,
            ]
        );
        $get_headline = DB::table("question_type")
            ->where([["client_id", "=", $client_id], ["stat", "=", "A"]])
            ->get();
        $get_headline_count = count($get_headline);
        for ($i = 0; $i < $get_headline_count; $i++) {
            $feedback_question[$get_headline[$i]->refid] = [
                "title" => [$get_headline[$i]->question_type],
                "question" => [],
            ];
            $feedback_question_sl = DB::table("feedback_question")
                ->where([
                    ["question_type", "=", $get_headline[$i]->refid],
                    ["client_id", "=", $client_id],
                    ["stat", "=", "A"],
                ])
                ->get();
            $feed_question_count = count($feedback_question_sl);
            for ($j = 0; $j < $feed_question_count; $j++) {
                $temp = [];
                $temp["refid"] = $feedback_question_sl[$j]->refid;
                $temp["question"] = $feedback_question_sl[$j]->question;
                $temp["option_1"] = $feedback_question_sl[$j]->option_1;
                $temp["option_2"] = $feedback_question_sl[$j]->option_2;
                $temp["option_3"] = $feedback_question_sl[$j]->option_3;
                $temp["option_4"] = $feedback_question_sl[$j]->option_4;
                $temp["parent"] = $feedback_question_sl[$j]->parent;
                $temp["type"] = $feedback_question_sl[$j]->type;

                array_push(
                    $feedback_question[$get_headline[$i]->refid]["question"],
                    $temp
                );
            }
        }

        $message["feedback_question"] = $feedback_question;

        if ($inserthistory) {
            $message["status"] = "success";
            $message["msg"] = "Outlet status updated successfully";
        } else {
            $message["status"] = "failure";
            $message["msg"] = "Outlet not deleted.";
        }

        return json_encode($message);
    }
    public function relavantoutlet(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $clientid = $user->client_id;
        $id = $input["outlet_id"];
        $current_lat = $input["lat"];
        $current_lon = $input["lon"];
        $date = date("Y-m-d H:i:s");

        $detail = json_decode($input["detail"], true);
        $channel_id = isset($detail["channel_id"]) ? $detail["channel_id"] : 0;
        $potential = isset($detail["potential"]) ? $detail["potential"] : 0;
        $freezer = isset($detail["freezer"]) ? $detail["freezer"] : 0;

        foreach ($detail as $key => $value) {
            if (is_int($key)) {
                $inserthistory = DB::table(
                    "uncovered_outlet_feedback"
                )->updateOrInsert(
                    ["outlet_id" => $id, "question" => $key],
                    [
                        "user_id" => $userid,
                        "created_date" => $date,
                        "freezer" => $freezer,
                        "channel_id" => $channel_id,
                        "ans" => $value,
                        "client_id" => $clientid,
                    ]
                );
            }
        }

        $update_status = DB::table("uncovered_outlets")
            ->where("refid", "=", $id)
            ->update(["status" => "A", "potential_store" => $potential]);
        $inserthistory = DB::table("uncovered_outlet_details")->updateOrInsert(
            ["outlet_refid" => $id],
            [
                "status" => "A",
                "jj_stock" => 0,
                "competition_stock" => 0,
                "jj_baby" => 0,
                "competition_baby" => 0,
                "jj_female" => 0,
                "competition_female" => 0,
                "jj_otc" => 0,
                "competition_facewash" => 0,
                "potential_store" => $potential,
                "lat" => $current_lat,
                "lon" => $current_lon,
                "user_id" => $userid,
                "created_date" => $date,
                "competition_facewash" => 0,
                "potential_baby" => 0,
                "potential_female" => 0,
                "potential_otc" => 0,
                "channel_id" => $channel_id,
                "jj_skincare" => 0,
                "competition_otc" => 0,
                "jj_1" => 0,
                "jj_2" => 0,
                "jj_3" => 0,
                "jj_4" => 0,
                "comp_1" => 0,
                "comp_2" => 0,
                "comp_3" => 0,
                "comp_4" => 0,
                "potential_skincare" => 0,
                "freezer" => $freezer,
            ]
        );
        $get_headline = DB::table("question_type")
            ->where([["client_id", "=", $clientid], ["stat", "=", "A"]])
            ->get();
        $get_headline_count = count($get_headline);
        for ($i = 0; $i < $get_headline_count; $i++) {
            $feedback_question[$get_headline[$i]->refid] = [
                "title" => [$get_headline[$i]->question_type],
                "question" => [],
            ];
            $feedback_question_sl = DB::table("feedback_question")
                ->where([
                    ["question_type", "=", $get_headline[$i]->refid],
                    ["client_id", "=", $clientid],
                    ["stat", "=", "A"],
                ])
                ->get();
            $feed_question_count = count($feedback_question_sl);
            for ($j = 0; $j < $feed_question_count; $j++) {
                $temp = [];
                $temp["refid"] = $feedback_question_sl[$j]->refid;
                $temp["question"] = $feedback_question_sl[$j]->question;
                $temp["option_1"] = $feedback_question_sl[$j]->option_1;
                $temp["option_2"] = $feedback_question_sl[$j]->option_2;
                $temp["option_3"] = $feedback_question_sl[$j]->option_3;
                $temp["option_4"] = $feedback_question_sl[$j]->option_4;
                $temp["parent"] = $feedback_question_sl[$j]->parent;
                $temp["type"] = $feedback_question_sl[$j]->type;

                array_push(
                    $feedback_question[$get_headline[$i]->refid]["question"],
                    $temp
                );
            }
        }
        $message["feedback_question"] = $feedback_question;

        if ($inserthistory) {
            $message["status"] = "success";
            $message["msg"] = "Outlet status updated successfully";
        } else {
            $message["status"] = "failure";
            $message["msg"] = "Outlet not deleted.";
        }

        return json_encode($message);
    }

    public function notfoundoutlet(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $clientid = $user->client_id;
        $id = $input["outlet_id"];
        $current_lat = $input["lat"];
        $current_lon = $input["lon"];
        $date = date("Y-m-d H:i:s");
        $update_status = DB::table("uncovered_outlets")
            ->where("refid", "=", $id)
            ->update(["status" => "NF", "potential_store" => 0]);
        $inserthistory = DB::table("uncovered_outlet_details")->updateOrInsert(
            ["outlet_refid" => $id],
            [
                "status" => "NF",
                "jj_stock" => 0,
                "competition_stock" => 0,
                "jj_baby" => 0,
                "competition_baby" => 0,
                "jj_female" => 0,
                "competition_female" => 0,
                "jj_otc" => 0,
                "competition_facewash" => 0,
                "potential_store" => 0,
                "lat" => $current_lat,
                "lon" => $current_lon,
                "user_id" => $userid,
                "created_date" => $date,
                "competition_facewash" => 0,
                "potential_baby" => 0,
                "potential_female" => 0,
                "potential_otc" => 0,
                "channel_id" => 0,
                "jj_skincare" => 0,
                "competition_otc" => 0,
                "jj_1" => 0,
                "jj_2" => 0,
                "jj_3" => 0,
                "jj_4" => 0,
                "comp_1" => 0,
                "comp_2" => 0,
                "comp_3" => 0,
                "comp_4" => 0,
            ]
        );
        $get_headline = DB::table("question_type")
            ->where([["client_id", "=", $clientid], ["stat", "=", "A"]])
            ->get();
        $get_headline_count = count($get_headline);
        for ($i = 0; $i < $get_headline_count; $i++) {
            $feedback_question[$get_headline[$i]->refid] = [
                "title" => [$get_headline[$i]->question_type],
                "question" => [],
            ];
            $feedback_question_sl = DB::table("feedback_question")
                ->where([
                    ["question_type", "=", $get_headline[$i]->refid],
                    ["client_id", "=", $clientid],
                    ["stat", "=", "A"],
                ])
                ->get();
            $feed_question_count = count($feedback_question_sl);
            for ($j = 0; $j < $feed_question_count; $j++) {
                $temp = [];
                $temp["refid"] = $feedback_question_sl[$j]->refid;
                $temp["question"] = $feedback_question_sl[$j]->question;
                $temp["option_1"] = $feedback_question_sl[$j]->option_1;
                $temp["option_2"] = $feedback_question_sl[$j]->option_2;
                $temp["option_3"] = $feedback_question_sl[$j]->option_3;
                $temp["option_4"] = $feedback_question_sl[$j]->option_4;
                $temp["parent"] = $feedback_question_sl[$j]->parent;
                $temp["type"] = $feedback_question_sl[$j]->type;

                array_push(
                    $feedback_question[$get_headline[$i]->refid]["question"],
                    $temp
                );
            }
        }

        $message["feedback_question"] = $feedback_question;

        if ($inserthistory) {
            $message["status"] = "success";
            $message["msg"] = "Outlet status updated successfully";
        } else {
            $message["status"] = "failure";
            $message["msg"] = "Outlet not deleted.";
        }

        return json_encode($message);
    }
    public function existingoutlet(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $client_id = $user->client_id;
        $id = $input["outlet_id"];
        $current_lat = $input["lat"];
        $current_lon = $input["lon"];
        $date = date("Y-m-d H:i:s");
        $update_status = DB::table("uncovered_outlets")
            ->where("refid", "=", $id)
            ->update(["status" => "E"]);
        $inserthistory = DB::table("uncovered_outlet_details")->updateOrInsert(
            ["outlet_refid" => $id],
            [
                "status" => "E",
                "jj_stock" => 0,
                "competition_stock" => 0,
                "jj_baby" => 0,
                "competition_baby" => 0,
                "jj_female" => 0,
                "competition_female" => 0,
                "jj_otc" => 0,
                "competition_facewash" => 0,
                "potential_store" => 0,
                "lat" => $current_lat,
                "lon" => $current_lon,
                "user_id" => $userid,
                "created_date" => $date,
                "competition_facewash" => 0,
                "potential_baby" => 0,
                "potential_female" => 0,
                "potential_otc" => 0,
                "channel_id" => 0,
                "jj_skincare" => 0,
                "competition_otc" => 0,
                "jj_1" => 0,
                "jj_2" => 0,
                "jj_3" => 0,
                "jj_4" => 0,
                "comp_1" => 0,
                "comp_2" => 0,
                "comp_3" => 0,
                "comp_4" => 0,
            ]
        );

        $get_headline = DB::table("question_type")
            ->where([["client_id", "=", $client_id], ["stat", "=", "A"]])
            ->get();
        $get_headline_count = count($get_headline);
        for ($i = 0; $i < $get_headline_count; $i++) {
            $feedback_question[$get_headline[$i]->refid] = [
                "title" => [$get_headline[$i]->question_type],
                "question" => [],
            ];
            $feedback_question_sl = DB::table("feedback_question")
                ->where([
                    ["question_type", "=", $get_headline[$i]->refid],
                    ["client_id", "=", $client_id],
                    ["stat", "=", "A"],
                ])
                ->get();
            $feed_question_count = count($feedback_question_sl);
            for ($j = 0; $j < $feed_question_count; $j++) {
                $temp = [];
                $temp["refid"] = $feedback_question_sl[$j]->refid;
                $temp["question"] = $feedback_question_sl[$j]->question;
                $temp["option_1"] = $feedback_question_sl[$j]->option_1;
                $temp["option_2"] = $feedback_question_sl[$j]->option_2;
                $temp["option_3"] = $feedback_question_sl[$j]->option_3;
                $temp["option_4"] = $feedback_question_sl[$j]->option_4;
                $temp["parent"] = $feedback_question_sl[$j]->parent;
                $temp["type"] = $feedback_question_sl[$j]->type;

                array_push(
                    $feedback_question[$get_headline[$i]->refid]["question"],
                    $temp
                );
            }
        }

        $message["feedback_question"] = $feedback_question;

        if ($inserthistory) {
            $message["status"] = "success";
            $message["msg"] = "Outlet status updated successfully";
        } else {
            $message["status"] = "failure";
            $message["msg"] = "Outlet not deleted.";
        }

        return json_encode($message);
    }
    public function get_level($input)
    {
        $input=json_decode($input['input']);
         //$input=$request->all();
         //var_dump($input->id);die;
         $id=$input->id;
         $show_level=$input->show_level;
        // \Log::info('INPUT DATA', (array) $input);

         $district=$input->district;
          $user = auth()->user();
            $role = $user->role;
         $msg=[];
         $msg['status']='failure';
         $msg['data']='';
         $msg['msg']='No Data Found';
          if($show_level=='get_nextlevel')
         {
             $country_id_=$input->country_id;
             $level_id_=$input->level_id;
            if($id ==='back')
            {
              
              
              $result=DB::table('country_level_data')->select('refid','level_name','location_id','location_name','child_flag','parent_id','country_id','level_id')->where([['country_id','=',$country_id_],['level_id','=',$level_id_]])->distinct()->orderBy("location_name","ASC")->get()->toArray();

            } 
            if($id!=='back')  
            {
                
                 $result=DB::table('country_level_data')->select('refid','level_name','location_id','location_name','child_flag','parent_id','country_id','level_id','country_id')->where([['parent_id','=',$id]])->distinct()->orderBy("location_name","ASC")->get()->toArray();
            }
               

              $count_=count($result);
              

              $str='';$level_info='';$is_back=false;$country_id=0;$level_id=0;
              if($count_>0)
              {
               
                $resut_arr=CommonController::getarray($result);
                $child_flag=array_unique(array_column($resut_arr,'child_flag'));
                $parent_id=array_unique(array_column($resut_arr,'parent_id'));
                $country_id=array_unique(array_column($resut_arr,'country_id'));
                $parent_id=array_unique(array_column($resut_arr,'parent_id'));
                $is_apply=false;
                $is_apply_fn='none';
                


                 for($i=0;$i<$count_;$i++)
                 {
                    $country_id=$result[$i]->country_id;
                    $level_id=$result[$i]->level_id;
                    $level_info=$result[$i]->level_name;
                    $is_back=($parent_id[0]==0) ? false : true;
                    if($child_flag[0]=='Y')
                    {

                       $str .='<div class="form-check form-check-inline filter-data talukstate">
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="talukstate_list" value="'.$result[$i]->refid.'" class="show_subordinate" hidden="true" onClick="ajax_action('.$result[$i]->refid.',\''.$result[$i]->location_name.'\',\'get_nextlevel\')"> '.$result[$i]->location_name.'</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                </div>';

                    }
                    if($child_flag[0]=='YN')
                    {

                      
                $str .='<div class="form-check form-check-inline filter-data talukstate">
                  
                        <input type="checkbox" class="form-check-input pre_level" name="pre_level" value="'.$result[$i]->refid.'" />
                       <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick="ajax_action('.$result[$i]->refid.',\''.$result[$i]->location_name.'\',\'get_nextlevel\')">'.$result[$i]->location_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                   
                     $is_apply=true;

                    }
                    if($child_flag[0]=='N')
                    {

                       $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input post_level" name="post_level" value="'.$result[$i]->refid.'" />
                      '.$result[$i]->location_name.'
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                   
                    $is_apply=true;
                   
                    }

                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['is_back']=$is_back;
                 $msg['is_apply']=$is_apply;
                 $msg['is_apply_fn']=$is_apply_fn;
                 $msg['parent_id']=$parent_id[0];
                 $msg['is_child']=$child_flag[0];
                 $msg['country_id']=$country_id;
                 $msg['level_id']=$level_id-1;
                 $msg['msg']='Data Available';
                 $msg['level_name']='Select '.$level_info;

              }
              else
              {
                $msg['msg']='No Data Available';

              }

         }
         if($show_level=='Get_ckDistrict')
         {
              $result=DB::table('ck_beats')->select('loc9','district')->distinct()->where([['loc7','=',$id]]);
           
             $result=$result->distinct()->orderBy("district","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                      $str .='<div class="form-check form-check-inline filter-data ">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio"  class="show_subordinate" hidden="true" name="beat" value="'.$result[$i]->loc9.'"  onClick=show_dist(this) id="'.$result[$i]->loc9.'" district_name="'.$result[$i]->district.'" >'.$result[$i]->district.'</input> 
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        ';

                    //    $str .='<div class="form-check form-check-inline filter-data">
                  
                    //     <input type="checkbox" class="form-check-input show_district" name="ckbeat" value="'.$result[$i]->loc9.'" />
                    //    <a href="#" id="'.$result[$i]->loc9.'" district_name="'.$result[$i]->district.'" style="color:white;text-decoration: underline" onClick=show_dist(this)>'.$result[$i]->district.'</a>
                    //     <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    // </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
         if($show_level=='Get_Distributor')
         {
              $result=DB::table('ck_beats')->select('ss_code','ss_name')->distinct()->where([['loc9','=',$id]]);
           
             $result=$result->distinct()->orderBy("ss_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input show_district" name="ckbeat" value="'.$result[$i]->ss_code.'" />
                       <a href="#" id="'.$result[$i]->ss_code.'" district_name="'.$result[$i]->ss_name.'" style="color:white;text-decoration: underline" onClick=show_beat(this)>'.$result[$i]->ss_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
          if($show_level=='Getnbhrd')
         {
              $result=DB::table('coke_uncvrd_outlets')->select('loc15 as refid','nbhrd')->distinct()->where([['city_id','=',$id]]);
           
             $result=$result->distinct()->orderBy("nbhrd","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input show_district" name="nbhrd" value="'.$result[$i]->refid.'" />
                       <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->nbhrd.'" style="color:white;text-decoration: underline" onClick=show_beat(this)>'.$result[$i]->nbhrd.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
         if($show_level=='Get_collegelist')
         {
              $result=DB::table('colleges_nearby_fmcg_stores')->select('college as college_id','college')->distinct()->where([['loc7','=',$id]]);
           
             $result=$result->distinct()->orderBy("college","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                      
                       $str .='<div class="form-check form-check-inline filter-data talukstate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="college_list" value="'.$result[$i]->college_id.'" class="show_subordinate" hidden="true" onClick="getcollege_data(this)"> '.$result[$i]->college.'</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
           if($show_level=='Getnbhrd1')
         {
              $result=DB::table('coke_uncvrd_outlets')->select('loc15 as refid','nbhrd')->distinct()->where([['loc7','=',$id]]);
           
             $result=$result->distinct()->orderBy("college","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                      
                       $str .='<div class="form-check form-check-inline filter-data talukstate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="college_list" value="'.$result[$i]->refid.'" class="show_subordinate" hidden="true" onClick="getcollege_data(this)"> '.$result[$i]->nbhrd.'</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
          if($show_level=='Get_ckBeat')
         {
              $result=DB::table('ck_beats')->select('unique_beat_id','unique_beat_id')->distinct()->where([['ss_code','=',$id]]);
           
             $result=$result->distinct()->orderBy("unique_beat_id","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                     
                        <input type="checkbox" class="form-check-input show_rdbeat" name="ckbeat" value="'.$result[$i]->unique_beat_id.'">
                        <a href="#"  style="color:white;" >'.$result[$i]->unique_beat_id.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
         if($show_level=='Getsstbeat_district')
         {
            
            if($role=='SOE')
             $result=DB::table('sst_data')->join('district_master_2011', "sst_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['sst_data.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
         else
            $result=DB::table('sst_data')->join('district_master_2011', "sst_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['sst_data.loc7','=',$id]])->whereIn('sst_data.loc9',$district)->distinct()->orderBy("district_master_2011.location_name","ASC")->get();

             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input show_sstdistrict" name="sst_districtlistbeat" value="'.$result[$i]->refid.'" />
                       <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=show_sstsubrd(this)>'.$result[$i]->location_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';

                  //     $str .='   <label class="container1 filter-data">One
                  // <input type="checkbox" class="form-check-input show_district" name="districtlist" checked="checked">
                  // <span class="checkmark1"></span>
                  // </label>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available1';
              }
         }
         if($show_level=="Get_uncovered_nbhrd")
         {
            $result=DB::table('perfetti_uncovered_outlets')->select('nbrhd_name','nbrhd_name')->where([['city_id','=',$id]]);
           
             $result=$result->distinct()->orderBy("nbrhd_name","ASC")->get();
              $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {

                     $str .='<div class="form-check form-check-inline filter-data">
                   
                        <input type="checkbox" class="form-check-input show_beat" name="citylist" value="'.$result[$i]->nbrhd_name.'">
                        <a href="#"  style="color:white;" >'.$result[$i]->nbrhd_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label></a>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }

         }
         if($show_level=='Get_wholesalebeat')
         {
            $beat_id=[];
             $result=DB::table('coke_whlslrs')->select('city_id','city')->where([['State','=',$id]]);
           
             $result=$result->distinct()->orderBy("city","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {

                     $str .='<div class="form-check form-check-inline filter-data menulist">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio"  class="show_subordinate" hidden="true" name="beat" value="'.$result[$i]->city_id.'" onclick="filter_bychannel()">'.$result[$i]->city.'</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        ';
            //            $str .='<div class="form-check form-check-inline filter-data">
                     
            //             <input type="checkbox" class="form-check-input show_rdbeat" name="beat" value="'.$result[$i]->city_id.'">
            //             <a href="#"  style="color:white;" >'.$result[$i]->city.'</a>
            //             <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            // </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
          if($show_level=='Getck_nbhrd')
         {
          
            $result=DB::table('ckpl_uncvrd_outlets')->select('loc15','nbhrd','city')->where([['city_id','=',$id],['period','=','New Data']])->distinct()->orderBy("nbhrd","ASC")->get();

             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input show_district" name="nbhrd" value="'.$result[$i]->loc15.'" />
                       <a href="#" id="'.$result[$i]->loc15.'" city_name="'.$result[$i]->city.'" style="color:white;" onClick=show_subrd(this)>'.$result[$i]->nbhrd.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available2';
              }
         }
         if($show_level=='Getsubrd_district')
         {
             $user = auth()->user();
            $role = $user->role;
            if($role=='SOE')
             $result=DB::table('subrd_outlet')->join('district_master_2011', "subrd_outlet.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_outlet.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
         else
            $result=DB::table('subrd_outlet')->join('district_master_2011', "subrd_outlet.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_outlet.loc7','=',$id]])->whereIn('subrd_outlet.loc9',$district)->distinct()->orderBy("district_master_2011.location_name","ASC")->get();

             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input show_district" name="districtlistbeat" value="'.$result[$i]->refid.'" />
                       <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=show_subrd(this)>'.$result[$i]->location_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available3';
              }
         }
         if($show_level=='Get_RD_beat')
         {
            $beat_id=[];$user = auth()->user();
             $tsimaster = DB::table("tsi_user_master")->whereIn('refid',[$user->id])->select('beat_id')->distinct()->get()->toArray(); 
                        for($k=0;$k<count($tsimaster);$k++)
                             array_push($beat_id,$tsimaster[$k]->beat_id);
             $result=DB::table('mdlz_rd_outlets')->select('loc16 as beat_id','locality_name as beat_name')->where([['loc15','=',$id]]);
             // if(count($beat_id) > 0)
             //    $result=$result->whereIn("beat_id",$beat_id);

             $result=$result->distinct()->orderBy("beat_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                     
                        <input type="checkbox" class="form-check-input show_rdbeat" name="rd_beat" value="'.$result[$i]->beat_id.'">
                        <a href="#"  style="color:white;" >'.$result[$i]->beat_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
          if($show_level=='Get_nbhrd')
         {
            
            
             $result=DB::table('0_delhi_uncvrd_outlets')->select('loc15 as beat_id','nbhrd as beat_name')->where([['city_id','=',$id],['type_id','=',$input->data_type]]);
          
             $result=$result->distinct()->orderBy("beat_name","ASC")->get();
            
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                     
                        <input type="checkbox" class="form-check-input show_nbhrdbeat" name="nbhrd_name" value="'.$result[$i]->beat_id.'">
                        <a href="#"  style="color:white;" >'.$result[$i]->beat_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No Beat Available';
              }
         }
         if($show_level=='Get_RD' && ($user->client_id!=0 && $user->client_id!=15))
         {
            $rd_code=[];$user = auth()->user();
             $tsimaster = DB::table("tsi_user_master")->whereIn('refid',[$user->id])->select('rd_code')->distinct()->get()->toArray(); 
                        for($k=0;$k<count($tsimaster);$k++)
                             array_push($rd_code,$tsimaster[$k]->rd_code);
          
            if($user->id==13285)                 
              $result=DB::table('mdlz_rd_outlets')->select('loc15 as rd_code','nbhrd as rd_name','city_id')->where([['city_id','=',$id]]);
            else
             $result=DB::table('ckpl_uncvrd_outlets_new')->select('loc15 as rd_code','nbhrd as rd_name','city_id')->where([['city_id','=',$id]]);
             if(count($rd_code)>0)
                $result=$result->whereIn('rd_code',$rd_code);
            $result=$result->distinct()->orderBy("rd_name","ASC")->get(); 
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';  
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
            //            $str .='<div class="form-check form-check-inline filter-data">
                     
            //             <input type="checkbox" class="form-check-input show_rdbeat" name="rdbeat" value="'.$result[$i]->rd_code.'">
            //             <a href="#"  style="color:white;" >'.ucwords(strtolower($result[$i]->rd_name)).'</a>
            //             <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            // </div>';
            if($user->id==13285)     
              $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input show_rdbeat" name="rdbeat" value="'.$result[$i]->rd_code.'" city_id="'.$result[$i]->city_id.'"/>
                      '.$result[$i]->rd_name.'
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
            else
             $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input show_rdbeat" name="rdbeat" value="'.$result[$i]->rd_code.'" city_id="'.$result[$i]->city_id.'"/>
                       <a href="#" id="'.$result[$i]->rd_code.'" rd_name="'.$result[$i]->rd_name.'" style="color:white;text-decoration: underline" city_id="'.$result[$i]->city_id.'" onClick=show_rdlist(this)>'.$result[$i]->rd_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available4';
              }
         }

         if($show_level=='Get_RD' && ($user->client_id==0 || $user->client_id==15))
         {

            if($user->client_id==0)
             $result=DB::table('hri_uncvrd_outlets')->select('beat_id','nbhrd')->where([['city_id','=',$id]])->distinct()->orderBy("nbhrd","ASC")->get();
           if($user->client_id==15)
             $result=DB::table('hul_jaipur_uncvrd_outlets')->select('loc15 as beat_id','nbhrd')->where([['city_id','=',$id]])->distinct()->orderBy("nbhrd","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
            //            $str .='<div class="form-check form-check-inline filter-data">
                     
            //             <input type="checkbox" class="form-check-input show_rdbeat" name="rdbeat" value="'.$result[$i]->rd_code.'">
            //             <a href="#"  style="color:white;" >'.ucwords(strtolower($result[$i]->rd_name)).'</a>
            //             <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            // </div>';
             $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input show_rdbeat" name="rdbeat" value="'.$result[$i]->beat_id.'" />'.$result[$i]->nbhrd.'
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available5';
              }
         }
         if($show_level=='Get_Beat')
         {
             $data_type=$input->data_type;
             if(auth()->user()->client_id==115)
               $result=DB::table('pedilite')->select('beat_id','nbrhd_name')->where([['City/Villg','=',$id],['data_type','=',$data_type]])->distinct()->orderBy("nbrhd_name","ASC")->get();
           if(auth()->user()->client_id==123)
               $result=DB::table('perfetti_whole')->select('beat_id','nbrhd_name')->where([['city_id','=',$id]])->distinct()->orderBy("nbrhd_name","ASC")->get();
             if(auth()->user()->client_id==1)
               $result=DB::table('whole_saler_data')->select('beat_id','nbrhd_name')->where([['City/Villg','=',$id],['user_id','=',auth()->user()->id]])->distinct()->orderBy("nbrhd_name","ASC")->get();
            if(auth()->user()->client_id==133)
               $result=DB::table('pepsi_uncovered_outlets_unnao')->select('beat_id','nbrhd_name')->where([['city_id','=',$id]])->distinct()->orderBy("nbrhd_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);

              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                     
                        <input type="checkbox" class="form-check-input show_rdbeat" name="beat" value="'.$result[$i]->beat_id.'">
                        <a href="#"  style="color:white;" >'.ucwords(strtolower($result[$i]->nbrhd_name)).'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            </div>';
        //      $str .='<div class="form-check form-check-inline filter-data">
        //             <a href="#" style="color:white;"> <label class="form-check-label" style="text-decoration: underline">
        //                 <input type="checkbox" class="form-check-input show_beat" name="beat" value="'.$result[$i]->beat_id.'">
        //                 <a href="#"  style="color:white;" >'.$result[$i]->nbrhd_name.'</a>
        //                 <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label></a>
        //     </div>
        // ';
        
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available6';
              }
         }
         if($show_level=='Getsst_subrd')
         {
             $result=DB::table('sst_data')->select('sst','sst','sst')->where([['loc9','=',$id]])->distinct()->orderBy("sst","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                     
                        <input type="checkbox" class="form-check-input show_beat" name="sstsubrd_beat" value="'.$result[$i]->sst.'">
                        <a href="#"  style="color:white;" >'.$result[$i]->sst.':'.$result[$i]->sst.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available7';
              }
         }
         if($show_level=='Get_SST')
         {
             $result=DB::table('chattisgarh_sst_van_beats3')->select('sst_code','sst_name')->where([['state_id','=',$id]])->distinct()->orderBy("sst_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                     
                        <input type="checkbox" class="form-check-input show_beat" name="sst_beat" value="'.$result[$i]->sst_code.'">
                        <a href="#"  style="color:white;" >'.$result[$i]->sst_code.': '.$result[$i]->sst_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available8';
              }
         }
         if($show_level=='Getsubrd_subrd')
         {
             $result=DB::table('subrd_outlet')->select('subrd_id','subrd_name','subrd_code')->where([['loc9','=',$id],['subrd_id','!=',0]])->distinct()->orderBy("subrd_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                     
                        <input type="checkbox" class="form-check-input show_beat" name="subrd_beat" value="'.$result[$i]->subrd_id.'">
                        <a href="#"  style="color:white;" >'.$result[$i]->subrd_code.':'.$result[$i]->subrd_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available9';
              }
         }
          if($show_level=='Get_outletdistrict')
         {
            $data_tbl=[150=>"maamis_uncovered_outlets",1000=>"haldirams_sample_data_new"];          
            $result=DB::table($data_tbl[auth()->user()->client_id])->select('loc9','district')->where([['loc7','=',$id]])->distinct()->orderBy("district","ASC")->limit(5)->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0) 
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                  
                        <input type="checkbox" class="form-check-input outlet_district" name="outlet_district" value="'.$result[$i]->loc9.'" />
                       <a href="#" id="'.$result[$i]->loc9.'" district_name="'.$result[$i]->district.'" style="color:white;text-decoration: underline" onClick=show_outlettaluk(this)>'.$result[$i]->district.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
            
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available10';
              }
         }
         if($show_level=='Get_outlettaluk')
         {
             $data_tbl=[150=>"maamis_uncovered_outlets",1000=>"haldirams_sample_data_new"];        
             $result=DB::table($data_tbl[auth()->user()->client_id])->select('loc10','Taluk')->where([['loc9','=',$id]])->distinct()->orderBy("Taluk","ASC")->limit(5)->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0) 
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                     
                        <input type="checkbox" class="form-check-input outlet_taluk" name="outlet_taluk" value="'.$result[$i]->loc10.'">
                        <a href="#"  style="color:white;" >'.$result[$i]->Taluk.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
            </div>';
            
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available11';
              }
         }
         
         // if($show_level=='Get_highway')
         // {
         //     $result=DB::table('highway_structure')->select('refid','highway_name')->where([['state_id','=',$id]])->distinct()->orderBy("highway_name","ASC")->get();
         //     // $result = DB::select(DB::raw($sql));
         //     $count_=count($result);
         //      $str='';
         //      if($count_>0)
         //      {
         //         for($i=0;$i<$count_;$i++)
         //         {
         //               $str .='<div class="form-check form-check-inline filter-data" id="checkchng" >
         //            <a href="#" style="color:white;"> 
         //                <input type="checkbox" class="form-check-input" state_id="'.$id.'" name="highwaylist" value="'.$result[$i]->refid.'"/>
         //               <a href="#" id="'.$result[$i]->refid.'" style="color:white;">'.$result[$i]->highway_name.'</a>
         //                <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
         //    </div>';
         //         }
         //         $msg['status']='success';
         //         $msg['data']=$str;
         //         $msg['msg']='Data Available';

         //      }
         //      else
         //      {
         //        $msg['msg']='No District Available';
         //      }
         // }
          if($show_level=='Get_highway')
         {
            
          if(auth()->user()->client_id == 112)
          {
              $input->highway_type=1;
          }
            
            $highway_type=$input->highway_type;
            $highway_tbl=[1=>['highway_structure','highwaylist'],2=>['state_highway_structure','statehighwaylist']];
             $result=DB::table($highway_tbl[$highway_type][0])->select('refid','highway_name')->where([['state_id','=',$id]])->distinct()->orderBy("highway_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             //\Log::info($result);
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data" id="checkchng" >
                    <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input" state_id="'.$id.'" name="'.$highway_tbl[$highway_type][1].'" value="'.$result[$i]->refid.'"/>
                       <a href="#" id="'.$result[$i]->refid.'" style="color:white;">'.$result[$i]->highway_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available13';
              }
         }
         if($show_level=='Get_consolidatesubrddistrict')
         {
            $user = auth()->user();
            $role = $user->role;
            
            if($user->client_id==120){            

            if($role=='SOE' || $role=='HO')
                $result=DB::table('subrd_consolidation_data')->join('district_master_2011', "subrd_consolidation_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_consolidation_data.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            else
              $result=DB::table('subrd_data')->join('district_master_2011', "subrd_consolidation_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_consolidation_data.loc7','=',$id]])->whereIn('subrd_consolidation_data.loc9',$district)->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            }
           
         
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                   <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_district" name="consolidate_districtlist" value="'.$result[$i]->refid.'" /><a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showconsolidatetaluk(this)>'.$result[$i]->location_name.'</a>


                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
            // <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showtaluk(this)>'.$result[$i]->location_name.'</a>
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available14';
              }
         }
          if($show_level=='Get_consolidatesubrdtaluk')
         {
            $user=auth()->user();
           
              $result=DB::table('subrd_consolidation_data')->select('taluk_census','taluk_name')->where([['subrd_consolidation_data.loc9','=',$id],['taluk_census','!=','0000'],['taluk_census','!=','']])->distinct()->orderBy("taluk_name","ASC")->get();
            
          
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .=' <div class="form-check form-check-inline filter-data" >
                    <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_taluk dist_" district_id="'.$id.'" name="consolidate_taluklist" value="'.$result[$i]->taluk_census.'"/>
                       <a href="#" id="'.$result[$i]->taluk_census.'" style="color:white;">'.$result[$i]->taluk_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available15';
              }
         }
          if($show_level=='Get_zerosubrddistrict')
         {
            $user = auth()->user();
            $role = $user->role;
            
              $result=DB::table('tsi_subrd_data')->join('district_master_2011', "tsi_subrd_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['tsi_subrd_data.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
           
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                   <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_district" name="zerodistrictlist" value="'.$result[$i]->refid.'" /><a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=zeroshowtaluk(this)>'.$result[$i]->location_name.'</a>


                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
            // <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showtaluk(this)>'.$result[$i]->location_name.'</a>
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available16';
              }
         }
         if($show_level=='Get_zerosubrdtaluk')
         {
            $user=auth()->user();
           
              $result=DB::table('tsi_subrd_data')->select('taluk_census','taluk_name')->where([['tsi_subrd_data.loc9','=',$id],['taluk_census','!=','0000'],['taluk_census','!=','']])->distinct()->orderBy("taluk_name","ASC")->get();
            
          
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .=' <div class="form-check form-check-inline filter-data" >
                    <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_taluk dist_" district_id="'.$id.'" name="zerotaluklist" value="'.$result[$i]->taluk_census.'"/>
                       <a href="#" id="'.$result[$i]->taluk_census.'" style="color:white;">'.$result[$i]->taluk_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available17';
              }
         }
          if($show_level=='Get_villagedistrict')
         {
            $user = auth()->user();
            $role = $user->role;
           
            if($user->client_id==120){            

            if($role=='SOE' || $role=='HO')
                $result=DB::table('mdlz_village_with_zero_rla')->join('district_master_2011', "mdlz_village_with_zero_rla.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['mdlz_village_with_zero_rla.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            else
              $result=DB::table('mdlz_village_with_zero_rla')->join('district_master_2011', "mdlz_village_with_zero_rla.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['mdlz_village_with_zero_rla.loc7','=',$id]])->whereIn('mdlz_village_with_zero_rla.loc9',$district)->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            } 
           
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                   <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_district" name="villagedistrictlist" value="'.$result[$i]->refid.'" /><a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=villageshowtaluk(this)>'.$result[$i]->location_name.'</a>


                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
            // <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showtaluk(this)>'.$result[$i]->location_name.'</a>
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available18';
              }
         }
           if($show_level=='Get_villagetaluk')
         {
           
              $result=DB::table('mdlz_village_with_zero_rla')->select('taluk_census','taluk_name')->where([['mdlz_village_with_zero_rla.loc9','=',$id],['taluk_census','!=','0000'],['taluk_census','!=','']])->distinct()->orderBy("taluk_name","ASC")->get();
            
             // $result=DB::table('subrd_data')->select('taluk_census','taluk_name')->where([['subrd_data.loc9','=',$id],['taluk_census','!=','0000'],['taluk_census','!=','']])->distinct()->orderBy("taluk_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .=' <div class="form-check form-check-inline filter-data" >
                    <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_taluk dist_" district_id="'.$id.'" name="village_taluklist" value="'.$result[$i]->taluk_census.'"/>
                       <a href="#" id="'.$result[$i]->taluk_census.'" style="color:white;">'.$result[$i]->taluk_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available19';
              }
         }
          if($show_level=='Get_subrddistrict')
         {
            $user = auth()->user();
            $role = $user->role;
            //pepsi subrd recomendation.
          //  \Log::info($show_level);
            if($user->client_id==133)
            {
                 $result=DB::table('subrd_data_pepsi')->join('district_master_2011', "subrd_data_pepsi.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_data_pepsi.loc7','=',$id],['subrd_data_pepsi.loc9','=',811]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
                 //\Log::info($id);
            } //pepsi subrd recomendation.

          

            if($user->client_id==120){            

            if($role=='SOE' || $role=='HO')
                $result=DB::table('subrd_data')->join('district_master_2011', "subrd_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_data.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            else
              $result=DB::table('subrd_data')->join('district_master_2011', "subrd_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_data.loc7','=',$id]])->whereIn('subrd_data.loc9',$district)->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            }
            if($user->client_id==123)
             $result=DB::table('subrd_data_perfetti')->join('district_master_2011', "subrd_data_perfetti.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_data_perfetti.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            if($user->client_id==1000)
             $result=DB::table('subrd_data_haldiram')->join('district_master_2011', "subrd_data_haldiram.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_data_haldiram.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
              if($user->client_id==112 || $user->client_id==133)
                //if($user->id == 13947 || $user->id == 21036 || $user->id == 21037 || $user->id == 21038 || $user->id == 21039 || $user->designation == 'ASM')
               // {
                    
                     if($user->designation == 'TSM' && $user->client_id==133) //pepse
                {
                                                    $query = DB::table('pepsi_subrd_data')
                        ->join('district_master_2011', 'pepsi_subrd_data.loc9', '=', 'district_master_2011.refid')
                        ->select('district_master_2011.refid', 'district_master_2011.location_name')
                        ->where('pepsi_subrd_data.loc7', $id);

                    // ✅ Apply district filter BEFORE get()
                    if (!empty($user->district_id) ) {
                        $query->whereIn('pepsi_subrd_data.loc9', explode(',', $user->district_id));
                    }

                    $result = $query->distinct()
                        ->orderBy('district_master_2011.location_name', 'ASC')
                        ->get();

                    // ✅ Proper logging
                   // \Log::info('District Result:', $result->toArray());
                }
                elseif(($user->designation == 'ASM' || $user->designation == 'TSM')  && $user->client_id==112) //coke
                    {
                         $result = DB::table('coke_all_state')->join('district_master_2011', "coke_all_state.loc9", "=", "district_master_2011.refid")->select('district_master_2011.refid', 'district_master_2011.location_name')->where('coke_all_state.loc7', '=', $id);

                            if (!empty($user->district_id)) {
                            $result->whereIn('coke_all_state.loc9', explode(',', $user->district_id));
                        }

                     $result = $result->distinct()
                        ->orderBy("district_master_2011.location_name", "ASC")
                        ->get();

                        // \Log::info('District Result Coke:', $result->toArray());

                    }
                else
                {
                        $result=DB::table('coke_all_state')->join('district_master_2011', "coke_all_state.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['coke_all_state.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();

                }
                       

                     

                     
                //}
               // else
               // {
                //     $result=DB::table('coke_subrd_data')->join('district_master_2011', "coke_subrd_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['coke_subrd_data.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
                //     \Log::info("else".$result);
               // }
               
           if($user->client_id==9999)
             $result=DB::table('subrd_data_mars')->join('district_master_2011', "subrd_data_mars.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['subrd_data_mars.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
               if($user->client_id==240)
             $result=DB::table('adani_shape_data')->join('district_master_2011', "adani_shape_data.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['adani_shape_data.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();

               if($user->client_id==133 && $user->login_type_mdlz == 'Rural/Urban') // pepse rural data

                    $query = DB::table('pepsi_subrd_data')
                    ->join('district_master_2011', 'pepsi_subrd_data.loc9', '=', 'district_master_2011.refid')
                    ->select('district_master_2011.refid', 'district_master_2011.location_name')
                    ->where('pepsi_subrd_data.loc7', $id);

                    if (!empty($user->district_id)) { // specific district filter and displayed front end 17032026
                        $query->whereIn('pepsi_subrd_data.loc9', explode(',', $user->district_id));
                    }

                    //$result = $query->distinct()
                    //->orderBy('district_master_2011.location_name', 'ASC') hidden data 03-04-2026
                    //->get();
                    // $result = DB::select(DB::raw($sql));

                      //Distributor white space recomendation.
                    if($user->client_id==133 && $user->login_type_mdlz == '' )
                    {
                                        $query = DB::table('pepsi.pepsi_sales')
                            ->join('district_master_2011', 'pepsi.pepsi_sales.loc9', '=', 'district_master_2011.refid')
                            ->select('district_master_2011.refid','district_master_2011.location_name')
                            ->where([
                                ['pepsi.pepsi_sales.loc7','=',$id]
                                
                            ])
                            ->distinct()
                            ->orderBy('district_master_2011.location_name','ASC');
                            $sql = vsprintf(str_replace('?', '%s', $query->toSql()), $query->getBindings());

                        //\Log::info($sql);
                        //\Log::info($id);

                        $result = $query->get();

                                    // \Log::info($result);
                    } ///Distributor white space recomendation.

                    $count_=count($result);
                    $str='';
                    if($count_>0)
                    {
                        for($i=0;$i<$count_;$i++)
                        {
                            $str .='<div class="form-check form-check-inline filter-data">
                        <a href="#" style="color:white;"> 
                                <input type="checkbox" class="form-check-input show_district" name="districtlist" value="'.$result[$i]->refid.'" /><a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showtaluk(this)>'.$result[$i]->location_name.'</a>


                            
                                <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
                    </div>';
                    // <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showtaluk(this)>'.$result[$i]->location_name.'</a>
                        }
                        $msg['status']='success';
                        $msg['data']=$str;
                        $msg['msg']='Data Available';

                    }
                    else
                    {
                        $msg['msg']='No District Available20';
                    }
         }
         if($show_level=='Get_subrdkrishnagiridistrict')
         {
            $user = auth()->user();
            $role = $user->role;
            $userid = $user->id;
         
              if($user->client_id==112)
             
                $result=DB::table('coke_subrd_data_krishnagiri')->join('district_master_2011', "coke_subrd_data_krishnagiri.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['coke_subrd_data_krishnagiri.loc9','=',719]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
                
                //if login this user anandsingh01@coca-cola.com and applied this condition
                if($user->role == '13947')
                {
                     //$result=DB::table('coke_subrd_data_all')->join('state_master_2011', "coke_subrd_data_all.loc7","=","state_master_2011.refid")->select('state_master_2011.refid','state_master_2011.location_name')->whereIn('coke_subrd_data_all.loc7', [16, 29])->distinct()->orderBy("state_master_2011.location_name","ASC")->get();

                     //\Log::info($result);
                }
                 //if login this user anandsingh01@coca-cola.com and applied this condition

             $count_=count($result);
             
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                   <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_district" name="districtlist" value="'.$result[$i]->refid.'" /><a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showtaluk(this)>'.$result[$i]->location_name.'</a>


                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
            // <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showtaluk(this)>'.$result[$i]->location_name.'</a>
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available21';
              }
         }
          if($show_level=='Get_villagedistrict')
         {
            $user = auth()->user();
            $role = $user->role;
           
            if($user->client_id==120){            

            if($role=='SOE' || $role=='HO')
                $result=DB::table('mdlz_village_with_zero_rla')->join('district_master_2011', "mdlz_village_with_zero_rla.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['mdlz_village_with_zero_rla.loc7','=',$id]])->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            else
              $result=DB::table('mdlz_village_with_zero_rla')->join('district_master_2011', "mdlz_village_with_zero_rla.loc9","=","district_master_2011.refid")->select('district_master_2011.refid','district_master_2011.location_name')->where([['mdlz_village_with_zero_rla.loc7','=',$id]])->whereIn('mdlz_village_with_zero_rla.loc9',$district)->distinct()->orderBy("district_master_2011.location_name","ASC")->get();
            }
           
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .='<div class="form-check form-check-inline filter-data">
                   <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_district" name="villagedistrictlist" value="'.$result[$i]->refid.'" /><a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=villageshowtaluk(this)>'.$result[$i]->location_name.'</a>


                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
            // <a href="#" id="'.$result[$i]->refid.'" district_name="'.$result[$i]->location_name.'" style="color:white;text-decoration: underline" onClick=showtaluk(this)>'.$result[$i]->location_name.'</a>
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available22';
              }
         }
          if($show_level=='Get_subrdtaluk')
         {
            $user=auth()->user();
            // $tbl_arr=[133=>'subrd_data',112=>'coke_subrd_data',120=>'subrd_data',123=>'subrd_data_perfetti',1000=>'subrd_data_haldiram',240=>'adani_shape_data',9999=>'subrd_data_mars'];
             if($user->id == 13947 || $user->id == 21036 || $user->id == 21037 || $user->id == 21038 || $user->id == 21039 || $user->designation == 'ASM')
                {
                    $tbl_arr=[133=>'subrd_data',112=>'coke_subrd_data_all',120=>'subrd_data',123=>'subrd_data_perfetti',1000=>'subrd_data_haldiram',240=>'adani_shape_data',9999=>'subrd_data_mars'];
                    //\Log::info($tbl_arr);
                } 
                else
                {
                    $tbl_arr=[133=>'subrd_data',112=>'coke_subrd_data',120=>'subrd_data',123=>'subrd_data_perfetti',1000=>'subrd_data_haldiram',240=>'adani_shape_data',9999=>'subrd_data_mars'];
                }
              $result=DB::table($tbl_arr[$user->client_id])->select('taluk_census','taluk_name')->where([[$tbl_arr[$user->client_id].'.loc9','=',$id],['taluk_census','!=','0000'],['taluk_census','!=','']])->distinct()->orderBy("taluk_name","ASC")->get();
            
             // $result=DB::table('subrd_data')->select('taluk_census','taluk_name')->where([['subrd_data.loc9','=',$id],['taluk_census','!=','0000'],['taluk_census','!=','']])->distinct()->orderBy("taluk_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .=' <div class="form-check form-check-inline filter-data" >
                    <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_taluk dist_" district_id="'.$id.'" name="taluklist" value="'.$result[$i]->taluk_census.'"/>
                       <a href="#" id="'.$result[$i]->taluk_census.'" style="color:white;">'.$result[$i]->taluk_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available23';
              }
         }

         if($show_level=='Get_villagetaluk')
         {
           
              $result=DB::table('mdlz_village_with_zero_rla')->select('taluk_census','taluk_name')->where([['mdlz_village_with_zero_rla.loc9','=',$id],['taluk_census','!=','0000'],['taluk_census','!=','']])->distinct()->orderBy("taluk_name","ASC")->get();
            
             // $result=DB::table('subrd_data')->select('taluk_census','taluk_name')->where([['subrd_data.loc9','=',$id],['taluk_census','!=','0000'],['taluk_census','!=','']])->distinct()->orderBy("taluk_name","ASC")->get();
             // $result = DB::select(DB::raw($sql));
             $count_=count($result);
              $str='';
              if($count_>0)
              {
                 for($i=0;$i<$count_;$i++)
                 {
                       $str .=' <div class="form-check form-check-inline filter-data" >
                    <a href="#" style="color:white;"> 
                        <input type="checkbox" class="form-check-input show_taluk dist_" district_id="'.$id.'" name="village_taluklist" value="'.$result[$i]->taluk_census.'"/>
                       <a href="#" id="'.$result[$i]->taluk_census.'" style="color:white;">'.$result[$i]->taluk_name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
                 }
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';

              }
              else
              {
                $msg['msg']='No District Available24';
              }
         }
         if($show_level=='Getchild')
         {
            $view_optn=isset($input->view_optn) ? $input->view_optn :0 ;
           
             $menu_result=DB::table('menu_master')->select('refid','menu_name','type','menu_id','level_id','menu_item_id')->where([['parent_id','=',$id]])->distinct()->orderBy("menu_name","ASC")->first();
             $menu_obj=DB::table('menu_object_master')->select('table_name')->where([['refid','=',$menu_result->menu_id]])->first();
             $type_view=$menu_result->type;

             if(in_array($id,[186,187]))
             {
                 if($id==186)
                    $result=DB::table($menu_obj->table_name)->select('refid','name')->where([['stat','=','A'],['refid','!=',6]])->get();
                 if($id==187)
                    $result=DB::table($menu_obj->table_name)->select('refid','name')->where([['stat','=','A'],['refid','=',6]])->get();

             }
             else
             {
                 if(in_array($type_view,[1,2,0]))
                    $result=DB::table($menu_obj->table_name)->select('refid','name')->where([['stat','=','A']])->get();
                 if(in_array($type_view,[3]))
                    $result=DB::table('menu_master')->select('refid','menu_name as name','type','menu_id','level_id','menu_item_id')->where([['parent_id','=',$id]])->distinct()->orderBy("menu_name","ASC")->get();
             }

             $count_=count($result);
              $str='';
              if($count_>0)
              {
                
                if($type_view==1)
                {
                    for($i=0;$i<$count_;$i++)
                     {
                           $str .=' <div class="form-check form-check-inline filter-data orngchk" >
                        
                            <input type="checkbox" class="form-check-input show_menulist" type=1 level_id="'.$menu_result->level_id.'" menu_item_id="'.$result[$i]->refid.'" view_optn="'.$view_optn.'" menu_id="'.$menu_result->menu_id.'"  name="list_menu" parent_id="'.$id.'"  value="'.$result[$i]->refid.'"/>
                           <a href="#" id="'.$result[$i]->refid.'" style="color:white;">'.$result[$i]->name.'</a>
                            <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i>
                          </div>';
                     }
               }
                if($type_view==2)
                {
                     for($i=0;$i<$count_;$i++)
                     {
                         $str .='<div class="form-check form-check-inline filter-data menulist">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="list_menu" level_id="'.$menu_result->level_id.'" type=2 menu_item_id="'.$result[$i]->refid.'" menu_id="'.$menu_result->menu_id.'" name="list_menu" view_optn="'.$view_optn.'" value="'.$result[$i]->refid.'"  value="'.$result[$i]->refid.'" parent_id="'.$id.'" class="show_subordinate" hidden="true" onClick="show_result(this)">'.$result[$i]->name.'</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        ';
                     }
                }
                if($type_view==3)
                {
                     for($i=0;$i<$count_;$i++)
                     {

                         $str .='<div class="form-check form-check-inline filter-data menulist">
                   <a href="#" style="color:white;"> 
                       <a href="#" id="'.$result[$i]->refid.'" list_menu="'.$result[$i]->name.'"  view_optn="'.$view_optn.'" type=3 style="color:white;text-decoration: underline" class="nextmenu_section">'.$result[$i]->name.'</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a>
            </div>';
                        
                     }
                }
                 
                 $msg['status']='success';
                 $msg['data']=$str;
                 $msg['msg']='Data Available';
                 $msg['type_view']=$type_view;

              }
              else
              {
                $msg['msg']='No District Available25';
              }
         }
        
         
          return response()->json($msg);
    }
    public function get_info(Request $request)
    {
        $input=$request->all();
        $locid=$input['locid'];
        $sub_location=$input['sub_location'];
        $input_obj=$input['obj'];
        $message['status']='failure';
        $message['data']=[];
        $mscore_list=[];$consmption_id=[];
    
        $menu_id=array_unique(array_column($input_obj['menu_list'],'menu_item_id'));

        $period=isset($input_obj['calendar_data']['year'][0]) ? $input_obj['calendar_data']['year'][0] : 2023;
        $quarter_view=false;
        if(isset($input_obj['calendar_data']['quarter']) && $input_obj['calendar_data']['quarter']!='')
        {
            $quarter=$input_obj['calendar_data']['quarter'];
            $quarter_view=true;
        }
        $nearest_list=[];
        if($sub_location==15 || $sub_location==16)
        { 
            if(!$quarter_view)
            {
                 $result_str='result';
                 $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];
            }
            else
            {
                  $result_str='Q'.$quarter;
                 $tbl=[15=>'mdlz.calendar_result_dump_qtr',16=>'mdlz.calendar_result_dump_qtr_loc16'];
            }


         $get_detail1=DB::table($tbl[$sub_location])->where([['loc'.$sub_location,'=',$locid]])->whereIn('type_id',[5,12])->select('loc'.$sub_location,  'period', 'menu_id', 'loc12', 'city_avg', 'type', 'created_date', 'type_id',DB::raw('ifnull('.$result_str.',0) as result') )->groupBy('loc'.$sub_location.'','type_id');
         $get_detail2=DB::table($tbl[$sub_location])->where([['loc'.$sub_location,'=',$locid],['period','=',$period]])->whereIn('type_id',[8,10,11])->select('loc'.$sub_location,  'period', 'menu_id', 'loc12', 'city_avg', 'type', 'created_date', 'type_id',DB::raw('ifnull('.$result_str.',0) as result') )->groupBy('loc'.$sub_location.'','type_id');
        

            $menu_id_list=[];
            foreach($menu_id as $k=>$v)
            {
                if($v==5)
                    $v=3;
                array_push($menu_id_list,$v);
            }
            $boolean=0;
            if(in_array(3,$menu_id) && in_array(5,$menu_id))
                $boolean=1;
            

        
          $get_detail3=DB::table($tbl[$sub_location])->where([['loc'.$sub_location,'=',$locid],['period','=',$period]])->whereIn('menu_id',$menu_id)->whereIn('type_id',[9,4,7])->select('loc'.$sub_location,  'period', 'menu_id', 'loc12', 'city_avg', 'type', 'created_date', 'type_id',DB::raw('sum(ifnull('.$result_str.',0)) as result') )->groupBy('loc'.$sub_location.'','type_id');

         //  if(in_array(3,$menu_id) && in_array(5,$menu_id))
               // $get_detail4=DB::raw('SELECT loc15,period, AVG(result) AS res FROM calendar_result_dump WHERE type_id in (4,7) AND menu_id IN (3, 5) where loc15='.$locid.' and period='.$period.' GROUP BY loc15,`period`');


          $get_detail=DB::table($tbl[$sub_location])->where([['loc'.$sub_location,'=',$locid],['period','=',$period]])->whereIn('menu_id',$menu_id)->whereIn('type_id',[1,2,3,6])->select('loc'.$sub_location,  'period', 'menu_id', 'loc12', 'city_avg', 'type', 'created_date', 'type_id',DB::raw('if(( type_id=1  ||  type_id=5 ),avg(ifnull('.$result_str.',0)),sum(ifnull('.$result_str.',0))) as result') )->groupBy('loc'.$sub_location.'','type_id')->union($get_detail1)->union($get_detail2)->union($get_detail3)->get(); 
         
         $similar_tbl=[15=>'mdlz_similar_nbrhds',16=>'mdlz_similar_nbrhds_and_localities'];
         $nearest_data=DB::table($similar_tbl[$sub_location])->where([['loc'.$sub_location,'=',$locid]])->select(['similar_nbrhds'])->first();
        $nearest_data_list=DB::table($similar_tbl[$sub_location])->where([['similar_nbrhds','=',$nearest_data->similar_nbrhds],['loc'.$sub_location,'!=',$locid]])->select('loc'.$sub_location.' as loc_id')->orderBy('final_rank')->get();

        for($k=0;($k<count($nearest_data_list) && $k<12) ;$k++)
            $nearest_list[$nearest_data_list[$k]->loc_id]=0;
            

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $fld1987_sql='select distinct bi_catgry_id  from mdlz_urban_brand_master where fld1987 in ('.implode(",",$index_type).') and stat="A"';
          $fld1987_sql = DB::select(DB::raw($fld1987_sql));
          $fld1987_sql=CommonController::getarray($fld1987_sql);

          foreach ($fld1987_sql as $key => $value) {
              array_push($consmption_id,$value['bi_catgry_id']);
          }
    if(isset($get_detail[0]->loc12))
          $consmptn_result=CategoryshareController::getcategoryshare($consmption_id,12,$sub_location,$get_detail[0]->loc12,$period,$input_obj,$locid);

          $message['data']['nearest']=[];
          $fetch_tbl=[15=>'ward_master',16=>'colony_master'];

        $message['category_share']='';
        if(isset($consmptn_result) && count($consmptn_result) >0 )
        {
               foreach($consmptn_result as $k=>$v)
          {
            if(array_key_exists($k,$nearest_list) || $k==$locid)
            {
                unset($nearest_list[$k]);
              $fetch_data=DB::table($fetch_tbl[$sub_location])->select('location_name')->where([['loc_id','=',$k]])->first();
              if($k==$locid)
                 $message['category_share']=(($v > 100) ? 100 : $v).'%';
              else
                 array_push($message['data']['nearest'],['loc_id'=>$k,'location_name'=>$fetch_data->location_name. ' ('.(($v > 100) ? 100 : $v).'%)','sub_location'=>$sub_location]);
            }

             
          } 
        }
         

 if(isset($get_detail[0]->loc12))
        $city_data=DB::table('city_master')->select('location_name')->where([['refid','=',$get_detail[0]->loc12]])->first();
         $fetch_data=DB::table($fetch_tbl[$sub_location])->select('location_name')->where([['loc_id','=',$locid]])->first();
         $city_avg=[];
           if(!$quarter_view)
            $tbl='mdlz.calendar_result_dump';
           else
             $tbl='mdlz.calendar_result_dump_qtr';
        
            if(count($get_detail)>0)
            {
                for($m=1;$m<=12;$m++)
                {
                    if(in_array($m,[1,2,3,6,9]))
                       $avgcity="select loc12,loc15,if((type_id=4 || type_id=2 || type_id=3),sum(".$result_str.")/100,(round(avg(".$result_str."),2))) as city_avg,0 as result from ".$tbl." where loc12=".$get_detail[0]->loc12." and period=".$period." and menu_id in (".implode(",",$menu_id).") and type_id=".$m."  group by loc12";
                   else if(in_array($m,[9,4,7]))
                       $avgcity="select loc12,loc15,if((type_id=0),(round(".$result_str.",0)),(round(avg(".$result_str."),2))) as city_avg,0 as result from ".$tbl." where loc12=".$get_detail[0]->loc12." and period=".$period." and menu_id in (".implode(",",$menu_id_list).") and type_id=".$m."  group by loc12";
                    else  if(in_array($m,[5,12]))
                        $avgcity="select loc12,loc15,if(type_id=5,round(avg(".$result_str."),2),round(avg(".$result_str."),0)) as city_avg,0 as result from ".$tbl." where loc12=".$get_detail[0]->loc12."  and type_id=".$m."  group by loc12"; 
                    else
                        $avgcity="select loc12,loc15,round(avg(".$result_str."),0) as city_avg,0 as result from ".$tbl." where loc12=".$get_detail[0]->loc12." and period=".$period." and type_id=".$m."  group by loc12"; 
             // if($m==4 && $sub_location==16)
             //        {echo $avgcity;die;}
                   
                  
                    $avg_result = DB::select(DB::raw($avgcity));
                   
                    $city_avg[$m]=$avg_result;
                    if(isset($avg_result[0]))
                    {

                     $message['data'][$m]['data']=$avg_result[0];
                    }
                   

                }
               
                for($k=0;$k<count($get_detail);$k++)
                {

                     
                    $message['data']['city']=$city_data->location_name;
                    $message['data']['nbhrd']=$fetch_data->location_name;

                    if(isset($message['data'][$get_detail[$k]->type_id]['data']->city_avg))
                    {
                         if(in_array($get_detail[$k]->type_id,[1,4,7,8,9,10,11,12]))
                         $get_detail[$k]->city_avg=number_format(round($message['data'][$get_detail[$k]->type_id]['data']->city_avg,2),2);

                        else
                         $get_detail[$k]->city_avg=round($message['data'][$get_detail[$k]->type_id]['data']->city_avg,0);
                    }
                    
                
                    if(in_array($get_detail[$k]->type_id,[1,4,7,8,9,10,11,12]))
                         $get_detail[$k]->result=number_format(round($get_detail[$k]->result,2),2);

                     else
                         $get_detail[$k]->result=round($get_detail[$k]->result,0);

                    $message['data'][$get_detail[$k]->type_id]['data']=$get_detail[$k];
                   

                }
         $message['rd_list']=[];
         $message['se_list']=[];
         $message['pc_list']=[];
       //  $sub_location=15;
         $nbhrdl=[15=>'mdlz.mdlz_RD_PC_SE_status',16=>'mdlz.mdlz_RD_PC_SE_status_loc16'];
        $se_list="SELECT loc".$sub_location.",'' `status`,`name` as se, `result` se_status ,role FROM ".$nbhrdl[$sub_location]." WHERE `role` LIKE 'SE' AND `loc12` = ".$get_detail[0]->loc12." and loc".$sub_location."=".$locid."  AND `period_Y` =  ".$period." ORDER BY result desc";

        

      $se_list_result = DB::select(DB::raw($se_list));
      $se_list_result_count=count($se_list_result);
      for($m=0;$m<$se_list_result_count;$m++)
         {
          array_push($message['se_list'],['name'=>$se_list_result[$m]->se,'value'=>round($se_list_result[$m]->se_status,2),'status'=>$se_list_result[$m]->status]);
         }
 $rdlist="SELECT loc".$sub_location.",'' `status`,`name` as rd, `result` rd_status ,role FROM ".$nbhrdl[$sub_location]." WHERE `role` LIKE 'RD' AND `loc12` = ".$get_detail[0]->loc12." and loc".$sub_location."=".$locid."  AND `period_Y` =  ".$period." ORDER BY result desc";
                 $rdlist_result = DB::select(DB::raw($rdlist));
                 $rdlist_result_count=count($rdlist_result);
                 

                  for($m=0;$m<$rdlist_result_count;$m++)
                 {
                    array_push($message['rd_list'],['name'=>$rdlist_result[$m]->rd,'value'=>round($rdlist_result[$m]->rd_status,2),'status'=>$rdlist_result[$m]->status]);
                     
                 }
                 $pclist="SELECT loc".$sub_location.",'' `status`,`name` as pc, `result` pc_status ,role FROM ".$nbhrdl[$sub_location]." WHERE `role` LIKE 'PC' AND `loc12` = ".$get_detail[0]->loc12." and loc".$sub_location."=".$locid."  AND `period_Y` =  ".$period." ORDER BY result desc";

     
         
                 $pclist_result = DB::select(DB::raw($pclist));
                 $pclist_result_count=count($pclist_result);
                 

                  for($m=0;$m<$pclist_result_count;$m++)
                 {
                    array_push($message['pc_list'],['name'=>$pclist_result[$m]->pc,'value'=>round($pclist_result[$m]->pc_status,2),'status'=>$pclist_result[$m]->status]);
                     
                 }


            
             $message['status']='success';
            }

    }
    
         return response()->json($message);
    }
     public function get_info_old(Request $request)
    {
        $input=$request->all();
        $locid=$input['locid'];
        $sub_location=$input['sub_location'];
        $input_obj=$input['obj'];
        $message['status']='failure';
        $message['data']=[];
        $mscore_list=[];$consmption_id=[];
        $menu_id=array_unique(array_column($input_obj['menu_list'],'menu_item_id'));
        $period=isset($input['period']) ? $input['period'] : 2022;
        $nearest_list=[];
        if($sub_location==15 || $sub_location==16)
        {
         $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];
         $get_detail=DB::table($tbl[$sub_location])->where([['loc'.$sub_location,'=',$locid],['period','=',$period]])->whereIn('menu_id',$menu_id)->select('loc'.$sub_location,  'period', 'menu_id', 'loc12', 'city_avg', 'type', 'created_date', 'type_id',DB::raw('if((type_id=4 || type_id=1),ifnull(result,0),sum(ifnull(result,0))) as result') )->groupBy('loc'.$sub_location.'','type_id')->get();
         
         $similar_tbl=[15=>'mdlz_similar_nbrhds',16=>'mdlz_similar_nbrhds_and_localities'];
         $nearest_data=DB::table($similar_tbl[$sub_location])->where([['loc'.$sub_location,'=',$locid]])->select(['similar_nbrhds'])->first();
        $nearest_data_list=DB::table($similar_tbl[$sub_location])->where([['similar_nbrhds','=',$nearest_data->similar_nbrhds]])->select('loc'.$sub_location.' as loc_id')->orderBy('final_rank')->get();
        for($k=0;$k<count($nearest_data_list);$k++)
            $nearest_list[$nearest_data_list[$k]->loc_id]=0;
            

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $fld1987_sql='select distinct bi_catgry_id  from mdlz_urban_brand_master where fld1988 in ('.implode(",",$index_type).') and stat="A"';
          $fld1987_sql = DB::select(DB::raw($fld1987_sql));
          $fld1987_sql=CommonController::getarray($fld1987_sql);

          foreach ($fld1987_sql as $key => $value) {
              array_push($consmption_id,$value['bi_catgry_id']);
          }

          $consmptn_result=CategoryshareController::getcategoryshare($consmption_id,12,$sub_location,$get_detail[0]->loc12,$period,$input_obj,$locid);

          $message['data']['nearest']=[];
          $fetch_tbl=[15=>'ward_master',16=>'colony_master'];

         $count_consmptn=count($consmptn_result);
        for($m=0;$m<$count_consmptn;$m++)
        {
            foreach($consmptn_result[$m] as $k=>$v)
          {
            if(array_key_exists($k,$nearest_list))
            {
                unset($nearest_list[$k]);
              $fetch_data=DB::table($fetch_tbl[$sub_location])->select('location_name')->where([['loc_id','=',$k]])->first();
              array_push($message['data']['nearest'],['loc_id'=>$k,'location_name'=>$fetch_data->location_name,'sub_location'=>$sub_location]);
            }
             
          } 
        }
        foreach($nearest_list as $k=>$v)
        {
            if(count($message['data']['nearest']) <= 4)
            {
              $fetch_data=DB::table($fetch_tbl[$sub_location])->select('location_name')->where([['loc_id','=',$k]])->first();
             
              array_push($message['data']['nearest'],['loc_id'=>$k,'location_name'=>$fetch_data->location_name,'sub_location'=>$sub_location]); 
            }
           
        }
       


        $city_data=DB::table('city_master')->select('location_name')->where([['refid','=',$get_detail[0]->loc12]])->first();
         $fetch_data=DB::table($fetch_tbl[$sub_location])->select('location_name')->where([['loc_id','=',$locid]])->first();
        
            if(count($get_detail)>0)
            {
                for($k=0;$k<count($get_detail);$k++)
                {

                     
                    $message['data']['city']=$city_data->location_name;
                    $message['data']['nbhrd']=$fetch_data->location_name;
                    $avgcity="select loc12,loc".$sub_location.",round(avg(result),0) as result from ".$tbl[$sub_location]." where loc12=".$get_detail[$k]->loc12." and period=".$period." and menu_id in (".implode(",",$menu_id).") and type_id=".$get_detail[$k]->type_id."  group by loc12";
                    $avg_result = DB::select(DB::raw($avgcity));
                      
                    $get_detail[$k]->city_avg=$avg_result[0]->result;
                    $message['data'][$get_detail[$k]->type_id]['data']=$get_detail[$k];
                   

                }
         $message['rd_list']=[];
         $message['se_list']=[];
         $message['pc_list']=[];
        $se_list="SELECT a.loc".$sub_location.",a.SE as se,(count(DISTINCT(a.retailer_code))/b.total_cnt *100) se_status FROM mdlz.mdlz_urban_3cities_sales a,(SELECT loc".$sub_location.",count(DISTINCT(retailer_code)) total_cnt FROM mdlz.`mdlz_urban_3cities_sales` WHERE `period_Y` = ".$period." AND `sub2_M4` > 2000 AND `sub2_M5` > 2000 AND `sub2_M6` > 2000 AND `sub2_M7` > 2000 AND `sub2_M8` > 2000 AND `sub2_M9` > 2000 AND `sub2_M10` > 2000 AND `sub2_M11` > 2000 AND `sub2_M12` > 2000 and `loc12` = ".$get_detail[0]->loc12." and loc".$sub_location."=".$locid."  group by loc".$sub_location.") b WHERE a.loc".$sub_location."=b.loc".$sub_location." and a.`period_Y` = ".$period." AND a.`sub2_M4` > 2000 AND a.`sub2_M5` > 2000 AND a.`sub2_M6` > 2000 AND a.`sub2_M7` > 2000 AND a.`sub2_M8` > 2000 AND a.`sub2_M9` > 2000 AND a.`sub2_M10` > 2000 AND a.`sub2_M11` > 2000 AND a.`sub2_M12` > 2000 and a.`loc12` = ".$get_detail[0]->loc12."  and a.loc".$sub_location."=".$locid." GROUP BY a.loc".$sub_location.",a.SE order by se_status desc";
      $se_list_result = DB::select(DB::raw($se_list));
      $se_list_result_count=count($se_list_result);
      for($m=0;$m<$se_list_result_count;$m++)
         {
             array_push($message['se_list'],['name'=>$se_list_result[$m]->se,'value'=>round($se_list_result[$m]->se_status,2)]);
              //  $message['se_list'][$se_list_result[$m]->se]=round($se_list_result[$m]->se_status,2);
         }

        $rdlist="SELECT a.loc".$sub_location.",a.`RD_code` as rd,(count(DISTINCT(a.retailer_code))/b.total_cnt *100) rd_status FROM mdlz.mdlz_urban_3cities_sales a,(SELECT loc".$sub_location.",count(DISTINCT(retailer_code)) total_cnt FROM mdlz.`mdlz_urban_3cities_sales` WHERE `period_Y` = ".$period." AND `sub2_M4` > 2000 AND `sub2_M5` > 2000 AND `sub2_M6` > 2000 AND `sub2_M7` > 2000 AND `sub2_M8` > 2000 AND `sub2_M9` > 2000 AND `sub2_M10` > 2000 AND `sub2_M11` > 2000 AND `sub2_M12` > 2000 and `loc12` = ".$get_detail[0]->loc12." and loc".$sub_location."=".$locid." group by loc".$sub_location.") b WHERE a.loc".$sub_location."=b.loc".$sub_location." and a.`period_Y` = ".$period." AND a.`sub2_M4` > 2000 AND a.`sub2_M5` > 2000 AND a.`sub2_M6` > 2000 AND a.`sub2_M7` > 2000 AND a.`sub2_M8` > 2000 AND a.`sub2_M9` > 2000 AND a.`sub2_M10` > 2000 AND a.`sub2_M11` > 2000 AND a.`sub2_M12` > 2000 and a.`loc12` = ".$get_detail[0]->loc12."  and a.loc".$sub_location."=".$locid." GROUP BY a.loc".$sub_location.",a.`RD_code` order by rd_status desc ";
                 $rdlist_result = DB::select(DB::raw($rdlist));
                 $rdlist_result_count=count($rdlist_result);
                 

                  for($m=0;$m<$rdlist_result_count;$m++)
                 {
                    
                    array_push($message['rd_list'],['name'=>$rdlist_result[$m]->rd,'value'=>round($rdlist_result[$m]->rd_status,2)]);
                         // $message['rd_list'][$rdlist_result[$m]->rd]=round($rdlist_result[$m]->rd_status,2);
                     
                 }
         $pclist="SELECT a.loc".$sub_location.",a.`PC_name` as pc,(count(DISTINCT(a.retailer_code))/b.total_cnt *100) pc_status FROM mdlz.mdlz_urban_3cities_sales a, (SELECT loc".$sub_location.",count(DISTINCT(retailer_code)) total_cnt FROM mdlz.`mdlz_urban_3cities_sales` WHERE `period_Y` = ".$period." AND `sub2_M4` > 2000 AND `sub2_M5` > 2000 AND `sub2_M6` > 2000 AND `sub2_M7` > 2000 AND `sub2_M8` > 2000 AND `sub2_M9` > 2000 AND `sub2_M10` > 2000 AND `sub2_M11` > 2000 AND `sub2_M12` > 2000 and  `loc12` = ".$get_detail[0]->loc12." and loc".$sub_location."=".$locid." group by loc".$sub_location.") b WHERE a.loc".$sub_location."=b.loc".$sub_location." and a.`period_Y` = ".$period." AND a.`sub2_M4` > 2000 AND a.`sub2_M5` > 2000 AND a.`sub2_M6` > 2000 AND a.`sub2_M7` > 2000 AND a.`sub2_M8` > 2000 AND a.`sub2_M9` > 2000 AND a.`sub2_M10` > 2000 AND a.`sub2_M11` > 2000 AND a.`sub2_M12` > 2000 and a.`loc12` = ".$get_detail[0]->loc12."  and a.loc".$sub_location."=".$locid." GROUP BY a.loc".$sub_location.",a.`PC_name` order by pc_status desc ";
                 $pclist_result = DB::select(DB::raw($pclist));
                 $pclist_result_count=count($pclist_result);
                 

                  for($m=0;$m<$pclist_result_count;$m++)
                 {
                       array_push($message['pc_list'],['name'=>$pclist_result[$m]->pc,'value'=>round($pclist_result[$m]->pc_status,2)]);
                       // $message['pc_list'][$pclist_result[$m]->pc]=round($pclist_result[$m]->pc_status,2);
                     
                 }


            
             $message['status']='success';
            }

    }
    
         return response()->json($message);
    }
     public function get_info_old1(Request $request)
    {
        $input=$request->all();
        $locid=$input['locid'];
        $sub_location=$input['sub_location'];
        $input_obj=$input['obj'];
        $message['status']='failure';
        $message['data']=[];
        $mscore_list=[];$consmption_id=[];
        $menu_id=array_unique(array_column($input_obj['menu_list'],'menu_item_id'));
        
        if($sub_location==15)
        {
            $get_detail=DB::table('numeric_distribution_data')->where([['loc15','=',$locid],['type','!=',4],['type','!=',2],['type','!=',3]])->get();

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $fld1987_sql='select distinct bi_catgry_id  from mdlz_urban_brand_master where fld1988 in ('.implode(",",$index_type).') and stat="A"';
          $fld1987_sql = DB::select(DB::raw($fld1987_sql));
          $fld1987_sql=CommonController::getarray($fld1987_sql);

          foreach ($fld1987_sql as $key => $value) {
              array_push($consmption_id,$value['bi_catgry_id']);
          }
          $consmptn_result=CategoryshareController::getcategoryshare($consmption_id,12,15,$get_detail[0]->loc12,2022,$input_obj,$locid);
          $message['data']['nearest']=[];
        for($m=0;$m<count($consmptn_result);$m++)
        {
            foreach($consmptn_result[$m] as $k=>$v)
          {

              $ward_data=DB::table('ward_master')->select('location_name')->where([['loc_id','=',$k]])->first();
             
             array_push($message['data']['nearest'],['loc_id'=>$k,'location_name'=>$ward_data->location_name,'sub_location'=>15]);
          } 
        }
          
           
            if(count($get_detail)>0)
            {
               
                 // $message['data'][5]['data']=['loc15'=>$locid,'m_score'=>0];
                 //    $message['data'][5]['nearest']=[];
                for($k=0;$k<count($get_detail);$k++)
                {

                     
                    $message['data']['city']=$get_detail[$k]->city_name;
                    $message['data']['nbhrd']=$get_detail[$k]->nbhrd_name;
                    $message['data'][$get_detail[$k]->type]['nearest']=[];

                     if($get_detail[$k]->type==1) 
                         $column='numeric_distribution';                         
                     // if($get_detail[$k]->type==2) 
                     //     $column='ulb';
                     // if($get_detail[$k]->type==3) 
                     //     $column='premium_ulb';
                      // if($get_detail[$k]->type==4) 
                      //    $column='vc_penetration';

                      $avgcity="select loc12,loc15,round(avg(".$column."),0) as result from numeric_distribution_data where loc12=".$get_detail[$k]->loc12." group by loc12";
                      $avg_result = DB::select(DB::raw($avgcity));
                      
                      $get_detail[$k]->city_avg=$avg_result[0]->result;
                      $message['data'][$get_detail[$k]->type]['data']=$get_detail[$k];




                   $nearestvalue="select a.loc12,a.loc15,round(a.".$column.",0) as result,a.city_name,a.nbhrd_name from ((select loc12,loc15,".$column.",city_name,nbhrd_name from numeric_distribution_data where ".$column." < ".$get_detail[$k]->$column." and loc12=".$get_detail[$k]->loc12." order by ".$column." desc limit 3) union all (select loc12,loc15,".$column.",city_name,nbhrd_name from numeric_distribution_data where ".$column." >= ".$get_detail[$k]->$column." and loc12=".$get_detail[$k]->loc12." order by ".$column." asc limit 3)) as a ORDER BY ".$column." LIMIT 3";
                  
                          $nearestvalue_result = DB::select(DB::raw($nearestvalue));
                    $n_count=count($nearestvalue_result);
                          for($i=0;$i<$n_count;$i++)
                             array_push($message['data'][$get_detail[$k]->type]['nearest'],$nearestvalue_result[$i]);

                   


                }
                 $rdlist="SELECT loc15,`RD_name` as rd, `SE` as se, `PC_name` as pc,(count(DISTINCT(`RD_code`))/count(DISTINCT(retailer_code))) *100 as rd_status,(count(DISTINCT(`SE`))/count(DISTINCT(retailer_code))) *100 as se_status,(count(DISTINCT(`PC_name`))/count(DISTINCT(retailer_code))) * 100 as pc_status FROM mdlz.`mdlz_urban_3cities_sales` WHERE `period_Y` = 2022 AND `sub2_M4` > 2000 AND `sub2_M5` > 2000 AND `sub2_M6` > 2000 AND `sub2_M7` > 2000 AND `sub2_M8` > 2000 AND `sub2_M9` > 2000 AND `sub2_M10` > 2000 AND `sub2_M11` > 2000 AND `sub2_M12` > 2000 and loc15=".$locid." and loc12=".$get_detail[0]->loc12." group by loc15,`RD_name`, `SE`, `PC_name` ";
                 $rdlist_result = DB::select(DB::raw($rdlist));
                 $rdlist_result_count=count($rdlist_result);
                 $message['rd_list']=[];
                 $message['se_list']=[];
                 $message['pc_list']=[];

                  for($m=0;$m<$rdlist_result_count;$m++)
                 {
                     if(!array_key_exists($rdlist_result[$m]->rd,$message['rd_list']))
                        $message['rd_list'][$rdlist_result[$m]->rd]=round($rdlist_result[$m]->rd_status,2);
                     if(!array_key_exists($rdlist_result[$m]->se,$message['se_list']))
                        $message['se_list'][$rdlist_result[$m]->se]=round($rdlist_result[$m]->se_status,2);
                     if(!array_key_exists($rdlist_result[$m]->pc,$message['pc_list']))
                        $message['pc_list'][$rdlist_result[$m]->pc]=round($rdlist_result[$m]->pc_status,2);
                 }
                $premium_ulb_penatration_avg="SELECT loc12 ,COUNT(DISTINCT(fld1991)) city_avg,period_Y FROM mdlz.mdlz_urban_3cities_sales WHERE loc5 = 1 AND loc12 != 0 AND fld2004 IN (1) AND  period_Y=2022 and loc12=".$get_detail[0]->loc12." and fld1987 in (".implode(",",$menu_id).") AND (sub2_Q1!=0 OR sub2_Q2!=0 OR sub2_Q3!=0 OR sub2_Q4!=0) GROUP BY loc12";
              $premium_ulb_penatration_avg_result = DB::select(DB::raw($premium_ulb_penatration_avg));
             
              $premium_ulb_penatrate="SELECT loc15 ,COUNT(DISTINCT(fld1991)) premium_ulb,period_Y FROM mdlz.mdlz_urban_3cities_sales WHERE loc5 = 1 AND loc12 != 0 AND fld2004 IN (1) AND  period_Y=2022 and loc12=".$get_detail[0]->loc12." and fld1987 in (".implode(",",$menu_id).") AND (sub2_Q1!=0 OR sub2_Q2!=0 OR sub2_Q3!=0 OR sub2_Q4!=0) GROUP BY loc15";
              $premium_ulb_penatrate_result = DB::select(DB::raw($premium_ulb_penatrate));
              
                 $message['data'][3]['data']= (object) ['city_avg' => $premium_ulb_penatration_avg_result[0]->city_avg,'store_score' => 0];
                 $message['data'][3]['nearest']=[];
                 $premium_ulb_count=count($premium_ulb_penatrate_result);
                 for($m=0;$m<$premium_ulb_count;$m++)
                 {
                   $premium_ulb_penatrate_result[$m]->city_avg=0;
                   $premium_ulb_penatrate_result[$m]->city_avg=$premium_ulb_penatration_avg_result[0]->city_avg;
                   $message['data'][3]['data']=$premium_ulb_penatrate_result[$m];
                 }   

              $ulb_penatration_avg="SELECT loc12,round(count(DISTINCT(`fld1991`))/ COUNT(DISTINCT(fld1986)),2) ulb_avg FROM mdlz.`mdlz_urban_3cities_sales` WHERE  period_Y=2022 and loc12=".$get_detail[0]->loc12." and fld1987 in (".implode(",",$menu_id).")  and (`sub2_M4`!=0 OR `sub2_M5`!=0 OR `sub2_M6`!=0 OR `sub2_M7`!=0 OR `sub2_M8`!=0 OR `sub2_M9`!=0 OR `sub2_M10`!=0 OR `sub2_M11`!=0 OR `sub2_M12`!=0) GROUP BY loc12";
              $ulb_penatration_avg_result = DB::select(DB::raw($ulb_penatration_avg));
             
              $ulb_penatrate="SELECT loc15,round(count(DISTINCT(`fld1991`))/ COUNT(DISTINCT(fld1986)),2) ulb FROM mdlz.`mdlz_urban_3cities_sales` WHERE period_Y=2022 and loc15=".$locid." and loc12=".$get_detail[0]->loc12." and fld1987 in (".implode(",",$menu_id).")  and (`sub2_M4`!=0 OR `sub2_M5`!=0 OR `sub2_M6`!=0 OR `sub2_M7`!=0 OR `sub2_M8`!=0 OR `sub2_M9`!=0 OR `sub2_M10`!=0 OR `sub2_M11`!=0 OR `sub2_M12`!=0)  GROUP BY loc15";
              $ulb_penatrate_result = DB::select(DB::raw($ulb_penatrate));
              
                 $message['data'][2]['data']= (object) ['city_avg' => $ulb_penatration_avg_result[0]->ulb_avg,'store_score' => 0];
                 $message['data'][2]['nearest']=[];
                 $ulb_count=count($ulb_penatrate_result);
                 for($m=0;$m<$ulb_count;$m++)
                 {
                   $ulb_penatrate_result[$m]->city_avg=0;
                   $ulb_penatrate_result[$m]->city_avg=$ulb_penatration_avg_result[0]->ulb_avg;
                   $message['data'][2]['data']=$ulb_penatrate_result[$m];
                 }
            $mscore_avg="SELECT loc12,round((sum(`m_score`)/count(`fld1986`)),2) as city_avg FROM mdlz.mdlz_urban_3cities_sales WHERE loc12=".$get_detail[0]->loc12."  and m_score!=0 group by loc12";
            $mscore_avg_result = DB::select(DB::raw($mscore_avg));

            $message['data'][5]['data']= (object) ['loc15'=>$locid,'city_avg' => ((count($mscore_avg_result)>0) ? $mscore_avg_result[0]->city_avg : 0),'m_score' => 0];
            $message['data'][5]['nearest']=[];
                
            // $mscore="SELECT loc15,sum(`m_score`)/count(refid) as m_score FROM `mdlz_urban_outlet_master` WHERE loc15=".$locid." and m_score!=0 group by loc15";
            $mscore="SELECT a.loc15,round((sum(`m_score`)/count(`fld1986`)),2) as  m_score FROM mdlz.mdlz_urban_3cities_sales as a  WHERE a.loc15=".$locid." and  a.m_score!=0 and period_Y=2022 and a.fld1987 in (".implode(",",$menu_id).") GROUP BY loc15";
           $mscore_result = DB::select(DB::raw($mscore));
           $mscore_count=count($mscore_result);
             for($m=0;$m<$mscore_count;$m++)
             {

                $mscore_result[$m]->city_avg=0;
                $mscore_result[$m]->city_avg=$mscore_avg_result[0]->city_avg;

// $mc_nearest="SELECT loc15,((sum(`m_score`)/count(refid))*100) as m_score,loc12,loc15 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and m_score > ".$mscore_result[$m]->m_score."   limit 0,1";     
// $mc_nearest="SELECT a.loc15,round((sum(`m_score`)/count(`fld1986`)),2) as  m_score,loc12,loc15,fld1987 FROM mdlz.mdlz_urban_3cities_sales as a group by loc15  having loc15!=".$locid."  and loc12=".$get_detail[0]->loc12." and  a.fld1987 in (".implode(",",$menu_id).") and m_score > ".$mscore_result[$m]->m_score." limit 0,1";          
//                  $mc_nearest_result = DB::select(DB::raw($mc_nearest));
//                 if(count($mc_nearest_result) > 0)
//                 $message['data'][5]['nearest']=$mc_nearest_result;
                 $message['data'][5]['data']=$mscore_result[$m];
               
             }
            $vc_cooler_avg="SELECT loc12,((sum(`visi_cooler_status`)/count(fld1986)) *100) as vc_avg FROM mdlz.mdlz_urban_3cities_sales WHERE loc12=".$get_detail[0]->loc12."  and fld1987 in (".implode(",",$menu_id).") and period_Y=2022  group by loc12";
            $vc_cooler_avg_result = DB::select(DB::raw($vc_cooler_avg));
          
            $vc_cooler="SELECT loc15,((sum(`visi_cooler_status`)/count(fld1986)) *100) as vc_penetration FROM mdlz.mdlz_urban_3cities_sales WHERE  loc15=".$locid."  and fld1987 in (".implode(",",$menu_id).") and period_Y=2022 group by loc15";
             $vc_cooler_result = DB::select(DB::raw($vc_cooler));
            
             $message['data'][4]['data']= (object) ['city_avg' => $vc_cooler_avg_result[0]->vc_avg,
    'vc_penetration' => 0];
              $message['data'][4]['nearest']=[];
              $vc_count=count($vc_cooler_result);
                 for($m=0;$m<$vc_count;$m++)
                 {
                            $vc_cooler_result[$m]->city_avg=0;
                            $vc_cooler_result[$m]->city_avg=$vc_cooler_avg_result[0]->vc_avg;
// $vc_nearest="SELECT loc15,((sum(`visi_cooler_status`)/count(refid))*100) as vc_score,loc12,loc15 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and vc_score > ".$vc_cooler_result[$m]->vc_penetration."   limit 0,1";               
//                  $vc_nearest_result = DB::select(DB::raw($vc_nearest));
//                 if(count($vc_nearest_result) > 0)
//                 $message['data'][4]['nearest']=$vc_nearest_result;

                            $message['data'][4]['data']=$vc_cooler_result[$m];
                           
                    
                 }
            $vpo_avg="SELECT loc12,((sum(`vpo_score`)/count(refid)) *100) as vpo_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12." and `visi_cooler`!='' group by loc12";
            $vpo_avg_result = DB::select(DB::raw($vpo_avg));
            $vpo="SELECT loc15,((sum(`vpo_score`)/count(refid)) *100) as vpo_score FROM `mdlz_urban_outlet_master` WHERE  loc15=".$locid." group by loc15";
             $vpo_result = DB::select(DB::raw($vpo));
            
             $message['data'][6]['data']= (object) ['city_avg' => $vpo_avg_result[0]->vpo_avg,
    'vpo_score' => 0];
              $message['data'][6]['nearest']=[];
              $vpo_count=count($vpo_result);
                 for($m=0;$m<$vpo_count;$m++)
                 {
                            $vpo_result[$m]->city_avg=0;
                            $vpo_result[$m]->city_avg=$vpo_avg_result[0]->vpo_avg;
                 $vpo_score_nearest="SELECT loc15,((sum(`vpo_score`)/count(refid))*100) as vpo_score,loc12,loc15 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and vpo_score > ".$vpo_result[$m]->vpo_score."   limit 0,1";               
                 $vpo_score_nearest_result = DB::select(DB::raw($vpo_score_nearest));
                if(count($vpo_score_nearest_result) > 0)
                $message['data'][6]['nearest']=$vpo_score_nearest_result;

                            $message['data'][6]['data']=$vpo_result[$m];
                           
                    
                 }

            //
            $store_penatration_avg="SELECT loc12,round(((sum(`prgm_target_data`)/count(fld1986))*100),2)  as store_penatration FROM mdlz.mdlz_urban_3cities_sales WHERE loc12=".$get_detail[0]->loc12." and fld1987 in (".implode(",",$menu_id).") group by loc12";
            $store_penatration_avg_result = DB::select(DB::raw($store_penatration_avg));
           
            $store_penatrate="SELECT loc15,round(((sum(`prgm_target_data`)/count(fld1986))*100),2)  as store_score FROM mdlz.mdlz_urban_3cities_sales WHERE  loc15=".$locid." and loc12=".$get_detail[0]->loc12." and fld1987 in (".implode(",",$menu_id).") group by loc15";
            $store_penatrate_result = DB::select(DB::raw($store_penatrate));


            
             $message['data'][7]['data']= (object) ['city_avg' => $store_penatration_avg_result[0]->store_penatration,'store_score' => 0];
             $message['data'][7]['nearest']=[];
             $store_count=count($store_penatrate_result);
             for($m=0;$m<$store_count;$m++)
             {
               $store_penatrate_result[$m]->city_avg=0;
               $store_penatrate_result[$m]->city_avg=$store_penatration_avg_result[0]->store_penatration;
                // $store_penatrate_nearest="SELECT loc15,((sum(`prgm_target_data`)/count(refid))*100) as store_score,loc12,loc15 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and store_score > ".$store_penatrate_result[$m]->store_score."   limit 0,1";               
                //  $store_penatrate_nearest_result = DB::select(DB::raw($store_penatrate_nearest));
                // if(count($store_penatrate_nearest_result) > 0)
                // $message['data'][7]['nearest']=$store_penatrate_nearest_result;

                        $message['data'][7]['data']=$store_penatrate_result[$m];
                       
                
             }
            $store_woa_avg="SELECT loc12,((count(DISTINCT(case when `M1_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M2_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M3_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M4_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M5_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100) +(count(DISTINCT(case when `M6_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M7_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M8_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M9_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M10_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M11_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M12_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100))/12 as store_woa FROM mdlz.mdlz_urban_3cities_sales where loc12=".$get_detail[0]->loc12."  and period_Y=2022  and period_Y=2022 and m_score!=0 and fld1987 in (".implode(",",$menu_id).")  group by loc12";

            $store_woa_avg_result = DB::select(DB::raw($store_woa_avg));
            $store_woa="SELECT loc15,((count(DISTINCT(case when `M1_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M2_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M3_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M4_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M5_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100) +(count(DISTINCT(case when `M6_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M7_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M8_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M9_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M10_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M11_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+(count(DISTINCT(case when `M12_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100))/12 as store_woa FROM mdlz.mdlz_urban_3cities_sales where loc15=".$locid." and fld1987 in (".implode(",",$menu_id).") and period_Y=2022 and m_score!=0   and loc12=".$get_detail[0]->loc12."  group by loc15";
            $store_woa_result = DB::select(DB::raw($store_woa));

            
             $message['data'][8]['data']= (object) ['city_avg' => $store_woa_avg_result[0]->store_woa,'store_woa' => 0];
             $message['data'][8]['nearest']=[];
             $store_wo_count=count($store_woa_result);
             for($m=0;$m<$store_wo_count;$m++)
             {
               $store_woa_result[$m]->city_avg=0;
               $store_woa_result[$m]->city_avg=$store_woa_avg_result[0]->store_woa;
                // $store_woa_nearest="SELECT loc12,loc15,((((sum(`M1_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M2_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M3_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M4_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M5_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M6_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M7_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M8_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M9_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M10_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M11_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M12_achived_status`)/count(DISTINCT(`retailer_code`)))* 100))/12) as store_woa FROM `mdlz_target_sales_org` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and store_woa > ".$store_woa_result[$m]->store_woa."   limit 0,1";  

                //  $store_woa_nearest_result = DB::select(DB::raw($store_woa_nearest));
                // if(count($store_woa_nearest_result) > 0)
                // $message['data'][8]['nearest']=$store_woa_nearest_result;

                        $message['data'][8]['data']=$store_woa_result[$m];
                       
                
             }
            //  //

                $message['status']='success';
            }

    }
    if($sub_location==16)
    {
          $get_detail=DB::table('numeric_distribution_data_colony')->where([['loc16','=',$locid],['type','!=',4]])->get();
           $index_type=array_column($input_obj['menu_list'],'menu_item_id');
           $fld1987_sql='select distinct bi_catgry_id  from mdlz_urban_brand_master where fld1988 in ('.implode(",",$index_type).') and stat="A"';
          $fld1987_sql = DB::select(DB::raw($fld1987_sql));
          $fld1987_sql=CommonController::getarray($fld1987_sql);

          foreach ($fld1987_sql as $key => $value) {
              array_push($consmption_id,$value['bi_catgry_id']);
          }
           
           $consmptn_result=CategoryshareController::getcategoryshare($consmption_id,12,16,$get_detail[0]->loc12,2022,$input_obj,$locid);
          $message['data']['nearest']=[];
       
        for($m=0;$m<count($consmptn_result);$m++)
        {
            foreach($consmptn_result[$m] as $k=>$v)
          {

              $ward_data=DB::table('colony_master')->select('location_name')->where([['loc_id','=',$k]])->first();
             
             array_push($message['data']['nearest'],['loc_id'=>$k,'location_name'=>$ward_data->location_name,'sub_location'=>16]);
          } 
        }
          
           
            if(count($get_detail)>0)
            {
               
                 // $message['data'][5]['data']=['loc15'=>$locid,'m_score'=>0];
                 //    $message['data'][5]['nearest']=[];
                for($k=0;$k<count($get_detail);$k++)
                {

                     
                    $message['data']['city']=$get_detail[$k]->city_name;
                    $message['data']['nbhrd']=$get_detail[$k]->nbhrd_name;
                    $message['data'][$get_detail[$k]->type]['nearest']=[];

                     if($get_detail[$k]->type==1) 
                         $column='numeric_distribution';                         
                     if($get_detail[$k]->type==2) 
                         $column='ulb';
                     if($get_detail[$k]->type==3) 
                         $column='premium_ulb';
                      // if($get_detail[$k]->type==4) 
                      //    $column='vc_penetration';

                      $avgcity="select loc12,loc16,round(avg(".$column."),0) as result from numeric_distribution_data_colony where loc12=".$get_detail[$k]->loc12." group by loc12";
                      $avg_result = DB::select(DB::raw($avgcity));
                      
                      $get_detail[$k]->city_avg=$avg_result[0]->result;
                      $message['data'][$get_detail[$k]->type]['data']=$get_detail[$k];
                   $nearestvalue="select a.loc12,a.loc16,round(a.".$column.",0) as result,a.city_name,a.nbhrd_name from ((select loc12,loc16,".$column.",city_name,nbhrd_name from numeric_distribution_data_colony where ".$column." < ".$get_detail[$k]->$column." and loc12=".$get_detail[$k]->loc12." order by ".$column." desc limit 3) union all (select loc12,loc16,".$column.",city_name,nbhrd_name from numeric_distribution_data_colony where ".$column." >= ".$get_detail[$k]->$column." and loc12=".$get_detail[$k]->loc12." order by ".$column." asc limit 3)) as a ORDER BY ".$column." LIMIT 3";
                  
                          $nearestvalue_result = DB::select(DB::raw($nearestvalue));

                          for($i=0;$i<count($nearestvalue_result);$i++)
                             array_push($message['data'][$get_detail[$k]->type]['nearest'],$nearestvalue_result[$i]);

                   


                }
                // SELECT a.loc'.$details["sub_location"].' as loc_id,fld1987,round((sum(`m_score`)/count(`fld1986`)),2) as  result , period_Y FROM '.$fetch_table.' as a  WHERE  a.m_score!=0  and '.join(" and ",$where).'  GROUP BY loc_id,fld1987

            $mscore_avg="SELECT loc12,sum(`m_score`)/count(refid) as city_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12."  and m_score!=0 group by loc12";
            $mscore_avg_result = DB::select(DB::raw($mscore_avg));

            $message['data'][5]['data']= (object) ['loc16'=>$locid,'city_avg' => ((count($mscore_avg_result)>0) ? $mscore_avg_result[0]->city_avg : 0),'m_score' => 0];
            $message['data'][5]['nearest']=[];
                
            $mscore="SELECT loc16,sum(`m_score`)/count(refid) as m_score FROM `mdlz_urban_outlet_master` WHERE loc15=".$locid." and m_score!=0 group by loc16";
           $mscore_result = DB::select(DB::raw($mscore));
             for($m=0;$m<count($mscore_result);$m++)
             {

                $mscore_result[$m]->city_avg=0;
                $mscore_result[$m]->city_avg=$mscore_avg_result[0]->city_avg;

$mc_nearest="SELECT loc16,((sum(`m_score`)/count(refid))*100) as m_score,loc12,loc16 FROM `mdlz_urban_outlet_master` group by loc16 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and m_score > ".$mscore_result[$m]->m_score."   limit 0,1";               
                 $mc_nearest_result = DB::select(DB::raw($mc_nearest));
                if(count($mc_nearest_result) > 0)
                $message['data'][5]['nearest']=$mc_nearest_result;
                $message['data'][5]['data']=$mscore_result[$m];
               
             }
            $vc_cooler_avg="SELECT loc12,((sum(`visi_cooler_status`)/count(refid)) *100) as vc_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12."  group by loc12";
            $vc_cooler_avg_result = DB::select(DB::raw($vc_cooler_avg));
            $vc_cooler="SELECT loc16,((sum(`visi_cooler_status`)/count(refid)) *100) as vc_penetration FROM `mdlz_urban_outlet_master` WHERE  loc15=".$locid." group by loc16";
             $vc_cooler_result = DB::select(DB::raw($vc_cooler));
            
             $message['data'][4]['data']= (object) ['city_avg' => $vc_cooler_avg_result[0]->vc_avg,
    'vc_penetration' => 0];
              $message['data'][4]['nearest']=[];
                 for($m=0;$m<count($vc_cooler_result);$m++)
                 {
                            $vc_cooler_result[$m]->city_avg=0;
                            $vc_cooler_result[$m]->city_avg=$vc_cooler_avg_result[0]->vc_avg;
$vc_nearest="SELECT loc16,((sum(`visi_cooler_status`)/count(refid))*100) as vc_score,loc12,loc16 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and vc_score > ".$vc_cooler_result[$m]->vc_penetration."   limit 0,1";               
                 $vc_nearest_result = DB::select(DB::raw($vc_nearest));
                if(count($vc_nearest_result) > 0)
                $message['data'][4]['nearest']=$vc_nearest_result;

                            $message['data'][4]['data']=$vc_cooler_result[$m];
                           
                    
                 }
            $vpo_avg="SELECT loc12,((sum(`vpo_score`)/count(refid)) *100) as vpo_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12." and `visi_cooler`!='' group by loc12";
            $vpo_avg_result = DB::select(DB::raw($vpo_avg));
            $vpo="SELECT loc16,((sum(`vpo_score`)/count(refid)) *100) as vpo_score FROM `mdlz_urban_outlet_master` WHERE  loc16=".$locid." group by loc16";
             $vpo_result = DB::select(DB::raw($vpo));
            
             $message['data'][6]['data']= (object) ['city_avg' => $vpo_avg_result[0]->vpo_avg,
    'vpo_score' => 0];
              $message['data'][6]['nearest']=[];
                 for($m=0;$m<count($vpo_result);$m++)
                 {
                            $vpo_result[$m]->city_avg=0;
                            $vpo_result[$m]->city_avg=$vpo_avg_result[0]->vpo_avg;
                 $vpo_score_nearest="SELECT loc15,((sum(`vpo_score`)/count(refid))*100) as vpo_score,loc12,loc16 FROM `mdlz_urban_outlet_master` group by loc15 having loc16!=".$locid." and loc12=".$get_detail[0]->loc12." and vpo_score > ".$vpo_result[$m]->vpo_score."   limit 0,1";               
                 $vpo_score_nearest_result = DB::select(DB::raw($vpo_score_nearest));
                if(count($vpo_score_nearest_result) > 0)
                $message['data'][6]['nearest']=$vpo_score_nearest_result;

                            $message['data'][6]['data']=$vpo_result[$m];
                           
                    
                 }

            //
            $store_penatration_avg="SELECT loc12,((sum(`prgm_target_data`)/count(refid))*100) as store_penatration FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12." group by loc12";
            $store_penatration_avg_result = DB::select(DB::raw($store_penatration_avg));
            $store_penatrate="SELECT loc16,((sum(`prgm_target_data`)/count(refid))*100) as store_score FROM `mdlz_urban_outlet_master` WHERE  loc15=".$locid." and loc12=".$get_detail[0]->loc12." group by loc16";
            $store_penatrate_result = DB::select(DB::raw($store_penatrate));


            
             $message['data'][7]['data']= (object) ['city_avg' => $store_penatration_avg_result[0]->store_penatration,'store_score' => 0];
             $message['data'][7]['nearest']=[];
             for($m=0;$m<count($store_penatrate_result);$m++)
             {
               $store_penatrate_result[$m]->city_avg=0;
               $store_penatrate_result[$m]->city_avg=$store_penatration_avg_result[0]->store_penatration;
                $store_penatrate_nearest="SELECT loc16,((sum(`prgm_target_data`)/count(refid))*100) as store_score,loc12,loc16 FROM `mdlz_urban_outlet_master` group by loc16 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and store_score > ".$store_penatrate_result[$m]->store_score."   limit 0,1";               
                 $store_penatrate_nearest_result = DB::select(DB::raw($store_penatrate_nearest));
                if(count($store_penatrate_nearest_result) > 0)
                $message['data'][7]['nearest']=$store_penatrate_nearest_result;

                        $message['data'][7]['data']=$store_penatrate_result[$m];
                       
                
             }


                $message['status']='success';
            }
            

           

    }
         return response()->json($message);
    }
    public function get_info_old2(Request $request)
    {
        $input=$request->all();
        $locid=$input['locid'];
        $sub_location=$input['sub_location'];
        $input_obj=$input['obj'];
        $message['status']='failure';
        $message['data']=[];
        $mscore_list=[];$consmption_id=[];

        if($sub_location==15)
        {
            $get_detail=DB::table('numeric_distribution_data')->where([['loc15','=',$locid],['type','!=',4]])->get();

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $fld1987_sql='select distinct bi_catgry_id  from mdlz_urban_brand_master where fld1988 in ('.implode(",",$index_type).') and stat="A"';
          $fld1987_sql = DB::select(DB::raw($fld1987_sql));
          $fld1987_sql=CommonController::getarray($fld1987_sql);

          foreach ($fld1987_sql as $key => $value) {
              array_push($consmption_id,$value['bi_catgry_id']);
          }
          $consmptn_result=CategoryshareController::getcategoryshare($consmption_id,12,15,$get_detail[0]->loc12,2022,$input_obj,$locid);
          $message['data']['nearest']=[];
        for($m=0;$m<count($consmptn_result);$m++)
        {
            foreach($consmptn_result[$m] as $k=>$v)
          {

              $ward_data=DB::table('ward_master')->select('location_name')->where([['loc_id','=',$k]])->first();
             
             array_push($message['data']['nearest'],['loc_id'=>$k,'location_name'=>$ward_data->location_name,'sub_location'=>15]);
          } 
        }
          
           
            if(count($get_detail)>0)
            {
               
                 // $message['data'][5]['data']=['loc15'=>$locid,'m_score'=>0];
                 //    $message['data'][5]['nearest']=[];
                for($k=0;$k<count($get_detail);$k++)
                {

                     
                    $message['data']['city']=$get_detail[$k]->city_name;
                    $message['data']['nbhrd']=$get_detail[$k]->nbhrd_name;
                    $message['data'][$get_detail[$k]->type]['nearest']=[];

                     if($get_detail[$k]->type==1) 
                         $column='numeric_distribution';                         
                     if($get_detail[$k]->type==2) 
                         $column='ulb';
                     if($get_detail[$k]->type==3) 
                         $column='premium_ulb';
                      // if($get_detail[$k]->type==4) 
                      //    $column='vc_penetration';

                      $avgcity="select loc12,loc15,round(avg(".$column."),0) as result from numeric_distribution_data where loc12=".$get_detail[$k]->loc12." group by loc12";
                      $avg_result = DB::select(DB::raw($avgcity));
                      
                      $get_detail[$k]->city_avg=$avg_result[0]->result;
                      $message['data'][$get_detail[$k]->type]['data']=$get_detail[$k];




                   $nearestvalue="select a.loc12,a.loc15,round(a.".$column.",0) as result,a.city_name,a.nbhrd_name from ((select loc12,loc15,".$column.",city_name,nbhrd_name from numeric_distribution_data where ".$column." < ".$get_detail[$k]->$column." and loc12=".$get_detail[$k]->loc12." order by ".$column." desc limit 3) union all (select loc12,loc15,".$column.",city_name,nbhrd_name from numeric_distribution_data where ".$column." >= ".$get_detail[$k]->$column." and loc12=".$get_detail[$k]->loc12." order by ".$column." asc limit 3)) as a ORDER BY ".$column." LIMIT 3";
                  
                          $nearestvalue_result = DB::select(DB::raw($nearestvalue));

                          for($i=0;$i<count($nearestvalue_result);$i++)
                             array_push($message['data'][$get_detail[$k]->type]['nearest'],$nearestvalue_result[$i]);

                   


                }
            $mscore_avg="SELECT loc12,sum(`m_score`)/count(refid) as city_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12."  and m_score!=0 group by loc12";
            $mscore_avg_result = DB::select(DB::raw($mscore_avg));

            $message['data'][5]['data']= (object) ['loc15'=>$locid,'city_avg' => ((count($mscore_avg_result)>0) ? $mscore_avg_result[0]->city_avg : 0),'m_score' => 0];
            $message['data'][5]['nearest']=[];
                
            $mscore="SELECT loc15,sum(`m_score`)/count(refid) as m_score FROM `mdlz_urban_outlet_master` WHERE loc15=".$locid." and m_score!=0 group by loc15";
           $mscore_result = DB::select(DB::raw($mscore));
             for($m=0;$m<count($mscore_result);$m++)
             {

                $mscore_result[$m]->city_avg=0;
                $mscore_result[$m]->city_avg=$mscore_avg_result[0]->city_avg;

$mc_nearest="SELECT loc15,((sum(`m_score`)/count(refid))*100) as m_score,loc12,loc15 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and m_score > ".$mscore_result[$m]->m_score."   limit 0,1";               
                 $mc_nearest_result = DB::select(DB::raw($mc_nearest));
                if(count($mc_nearest_result) > 0)
                $message['data'][5]['nearest']=$mc_nearest_result;
                $message['data'][5]['data']=$mscore_result[$m];
               
             }
            $vc_cooler_avg="SELECT loc12,((sum(`visi_cooler_status`)/count(refid)) *100) as vc_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12."  group by loc12";
            $vc_cooler_avg_result = DB::select(DB::raw($vc_cooler_avg));
            $vc_cooler="SELECT loc15,((sum(`visi_cooler_status`)/count(refid)) *100) as vc_penetration FROM `mdlz_urban_outlet_master` WHERE  loc15=".$locid." group by loc15";
             $vc_cooler_result = DB::select(DB::raw($vc_cooler));
            
             $message['data'][4]['data']= (object) ['city_avg' => $vc_cooler_avg_result[0]->vc_avg,
    'vc_penetration' => 0];
              $message['data'][4]['nearest']=[];
                 for($m=0;$m<count($vc_cooler_result);$m++)
                 {
                            $vc_cooler_result[$m]->city_avg=0;
                            $vc_cooler_result[$m]->city_avg=$vc_cooler_avg_result[0]->vc_avg;
$vc_nearest="SELECT loc15,((sum(`visi_cooler_status`)/count(refid))*100) as vc_score,loc12,loc15 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and vc_score > ".$vc_cooler_result[$m]->vc_penetration."   limit 0,1";               
                 $vc_nearest_result = DB::select(DB::raw($vc_nearest));
                if(count($vc_nearest_result) > 0)
                $message['data'][4]['nearest']=$vc_nearest_result;

                            $message['data'][4]['data']=$vc_cooler_result[$m];
                           
                    
                 }
            $vpo_avg="SELECT loc12,((sum(`vpo_score`)/count(refid)) *100) as vpo_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12." and `visi_cooler`!='' group by loc12";
            $vpo_avg_result = DB::select(DB::raw($vpo_avg));
            $vpo="SELECT loc15,((sum(`vpo_score`)/count(refid)) *100) as vpo_score FROM `mdlz_urban_outlet_master` WHERE  loc15=".$locid." group by loc15";
             $vpo_result = DB::select(DB::raw($vpo));
            
             $message['data'][6]['data']= (object) ['city_avg' => $vpo_avg_result[0]->vpo_avg,
    'vpo_score' => 0];
              $message['data'][6]['nearest']=[];
                 for($m=0;$m<count($vpo_result);$m++)
                 {
                            $vpo_result[$m]->city_avg=0;
                            $vpo_result[$m]->city_avg=$vpo_avg_result[0]->vpo_avg;
                 $vpo_score_nearest="SELECT loc15,((sum(`vpo_score`)/count(refid))*100) as vpo_score,loc12,loc15 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and vpo_score > ".$vpo_result[$m]->vpo_score."   limit 0,1";               
                 $vpo_score_nearest_result = DB::select(DB::raw($vpo_score_nearest));
                if(count($vpo_score_nearest_result) > 0)
                $message['data'][6]['nearest']=$vpo_score_nearest_result;

                            $message['data'][6]['data']=$vpo_result[$m];
                           
                    
                 }

            //
            $store_penatration_avg="SELECT loc12,((sum(`prgm_target_data`)/count(refid))*100) as store_penatration FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12." group by loc12";
            $store_penatration_avg_result = DB::select(DB::raw($store_penatration_avg));
            $store_penatrate="SELECT loc15,((sum(`prgm_target_data`)/count(refid))*100) as store_score FROM `mdlz_urban_outlet_master` WHERE  loc15=".$locid." and loc12=".$get_detail[0]->loc12." group by loc15";
            $store_penatrate_result = DB::select(DB::raw($store_penatrate));


            
             $message['data'][7]['data']= (object) ['city_avg' => $store_penatration_avg_result[0]->store_penatration,'store_score' => 0];
             $message['data'][7]['nearest']=[];
             for($m=0;$m<count($store_penatrate_result);$m++)
             {
               $store_penatrate_result[$m]->city_avg=0;
               $store_penatrate_result[$m]->city_avg=$store_penatration_avg_result[0]->store_penatration;
                $store_penatrate_nearest="SELECT loc15,((sum(`prgm_target_data`)/count(refid))*100) as store_score,loc12,loc15 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and store_score > ".$store_penatrate_result[$m]->store_score."   limit 0,1";               
                 $store_penatrate_nearest_result = DB::select(DB::raw($store_penatrate_nearest));
                if(count($store_penatrate_nearest_result) > 0)
                $message['data'][7]['nearest']=$store_penatrate_nearest_result;

                        $message['data'][7]['data']=$store_penatrate_result[$m];
                       
                
             }
             //

              $store_woa_avg="SELECT loc12,((((sum(`M1_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M2_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M3_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M4_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M5_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M6_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M7_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M8_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M9_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M10_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M11_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M12_achived_status`)/count(DISTINCT(`retailer_code`)))* 100))/12)  as store_woa  FROM `mdlz_target_sales_org` where loc12=".$get_detail[0]->loc12." group by loc12";
            $store_woa_avg_result = DB::select(DB::raw($store_woa_avg));
            $store_woa="SELECT loc15,((((sum(`M1_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M2_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M3_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M4_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M5_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M6_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M7_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M8_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M9_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M10_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M11_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M12_achived_status`)/count(DISTINCT(`retailer_code`)))* 100))/12)  as store_woa  FROM `mdlz_target_sales_org` where  loc15=".$locid." and loc12=".$get_detail[0]->loc12." group by loc15";
            $store_woa_result = DB::select(DB::raw($store_woa));


            
             $message['data'][8]['data']= (object) ['city_avg' => $store_woa_avg_result[0]->store_woa,'store_woa' => 0];
             $message['data'][8]['nearest']=[];
             for($m=0;$m<count($store_woa_result);$m++)
             {
               $store_woa_result[$m]->city_avg=0;
               $store_woa_result[$m]->city_avg=$store_woa_avg_result[0]->store_woa;
                $store_woa_nearest="SELECT loc12,loc15,((((sum(`M1_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M2_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M3_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M4_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M5_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M6_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M7_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M8_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M9_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M10_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M11_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M12_achived_status`)/count(DISTINCT(`retailer_code`)))* 100))/12) as store_woa FROM `mdlz_target_sales_org` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and store_woa > ".$store_woa_result[$m]->store_woa."   limit 0,1";  

                 $store_woa_nearest_result = DB::select(DB::raw($store_woa_nearest));
                if(count($store_woa_nearest_result) > 0)
                $message['data'][8]['nearest']=$store_woa_nearest_result;

                        $message['data'][8]['data']=$store_woa_result[$m];
                       
                
             }
            //  //

                $message['status']='success';
            }

    }
    if($sub_location==16)
    {
          $get_detail=DB::table('numeric_distribution_data_colony')->where([['loc16','=',$locid],['type','!=',4]])->get();
           $index_type=array_column($input_obj['menu_list'],'menu_item_id');
           $fld1987_sql='select distinct bi_catgry_id  from mdlz_urban_brand_master where fld1988 in ('.implode(",",$index_type).') and stat="A"';
          $fld1987_sql = DB::select(DB::raw($fld1987_sql));
          $fld1987_sql=CommonController::getarray($fld1987_sql);

          foreach ($fld1987_sql as $key => $value) {
              array_push($consmption_id,$value['bi_catgry_id']);
          }
         
           $consmptn_result=CategoryshareController::getcategoryshare($consmption_id,12,16,$get_detail[0]->loc12,2022,$input_obj,$locid);
          $message['data']['nearest']=[];
       
        for($m=0;$m<count($consmptn_result);$m++)
        {
            foreach($consmptn_result[$m] as $k=>$v)
          {

              $ward_data=DB::table('colony_master')->select('location_name')->where([['loc_id','=',$k]])->first();
             
             array_push($message['data']['nearest'],['loc_id'=>$k,'location_name'=>$ward_data->location_name,'sub_location'=>16]);
          } 
        }
          
           
            if(count($get_detail)>0)
            {
               
                 // $message['data'][5]['data']=['loc15'=>$locid,'m_score'=>0];
                 //    $message['data'][5]['nearest']=[];
                for($k=0;$k<count($get_detail);$k++)
                {

                     
                    $message['data']['city']=$get_detail[$k]->city_name;
                    $message['data']['nbhrd']=$get_detail[$k]->nbhrd_name;
                    $message['data'][$get_detail[$k]->type]['nearest']=[];

                     if($get_detail[$k]->type==1) 
                         $column='numeric_distribution';                         
                     if($get_detail[$k]->type==2) 
                         $column='ulb';
                     if($get_detail[$k]->type==3) 
                         $column='premium_ulb';
                      // if($get_detail[$k]->type==4) 
                      //    $column='vc_penetration';

                      $avgcity="select loc12,loc16,round(avg(".$column."),0) as result from numeric_distribution_data_colony where loc12=".$get_detail[$k]->loc12." group by loc12";
                      $avg_result = DB::select(DB::raw($avgcity));
                      
                      $get_detail[$k]->city_avg=$avg_result[0]->result;
                      $message['data'][$get_detail[$k]->type]['data']=$get_detail[$k];
                   $nearestvalue="select a.loc12,a.loc16,round(a.".$column.",0) as result,a.city_name,a.nbhrd_name from ((select loc12,loc16,".$column.",city_name,nbhrd_name from numeric_distribution_data_colony where ".$column." < ".$get_detail[$k]->$column." and loc12=".$get_detail[$k]->loc12." order by ".$column." desc limit 3) union all (select loc12,loc16,".$column.",city_name,nbhrd_name from numeric_distribution_data_colony where ".$column." >= ".$get_detail[$k]->$column." and loc12=".$get_detail[$k]->loc12." order by ".$column." asc limit 3)) as a ORDER BY ".$column." LIMIT 3";
                  
                          $nearestvalue_result = DB::select(DB::raw($nearestvalue));

                          for($i=0;$i<count($nearestvalue_result);$i++)
                             array_push($message['data'][$get_detail[$k]->type]['nearest'],$nearestvalue_result[$i]);

                   


                }
            $mscore_avg="SELECT loc12,sum(`m_score`)/count(refid) as city_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12."  and m_score!=0 group by loc12";
            $mscore_avg_result = DB::select(DB::raw($mscore_avg));

            $message['data'][5]['data']= (object) ['loc16'=>$locid,'city_avg' => ((count($mscore_avg_result)>0) ? $mscore_avg_result[0]->city_avg : 0),'m_score' => 0];
            $message['data'][5]['nearest']=[];
                
            $mscore="SELECT loc16,sum(`m_score`)/count(refid) as m_score FROM `mdlz_urban_outlet_master` WHERE loc15=".$locid." and m_score!=0 group by loc16";
           $mscore_result = DB::select(DB::raw($mscore));
             for($m=0;$m<count($mscore_result);$m++)
             {

                $mscore_result[$m]->city_avg=0;
                $mscore_result[$m]->city_avg=$mscore_avg_result[0]->city_avg;

$mc_nearest="SELECT loc16,((sum(`m_score`)/count(refid))*100) as m_score,loc12,loc16 FROM `mdlz_urban_outlet_master` group by loc16 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and m_score > ".$mscore_result[$m]->m_score."   limit 0,1";               
                 $mc_nearest_result = DB::select(DB::raw($mc_nearest));
                if(count($mc_nearest_result) > 0)
                $message['data'][5]['nearest']=$mc_nearest_result;
                $message['data'][5]['data']=$mscore_result[$m];
               
             }
            $vc_cooler_avg="SELECT loc12,((sum(`visi_cooler_status`)/count(refid)) *100) as vc_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12."  group by loc12";
            $vc_cooler_avg_result = DB::select(DB::raw($vc_cooler_avg));
            $vc_cooler="SELECT loc16,((sum(`visi_cooler_status`)/count(refid)) *100) as vc_penetration FROM `mdlz_urban_outlet_master` WHERE  loc15=".$locid." group by loc16";
             $vc_cooler_result = DB::select(DB::raw($vc_cooler));
            
             $message['data'][4]['data']= (object) ['city_avg' => $vc_cooler_avg_result[0]->vc_avg,
    'vc_penetration' => 0];
              $message['data'][4]['nearest']=[];
                 for($m=0;$m<count($vc_cooler_result);$m++)
                 {
                            $vc_cooler_result[$m]->city_avg=0;
                            $vc_cooler_result[$m]->city_avg=$vc_cooler_avg_result[0]->vc_avg;
$vc_nearest="SELECT loc16,((sum(`visi_cooler_status`)/count(refid))*100) as vc_score,loc12,loc16 FROM `mdlz_urban_outlet_master` group by loc15 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and vc_score > ".$vc_cooler_result[$m]->vc_penetration."   limit 0,1";               
                 $vc_nearest_result = DB::select(DB::raw($vc_nearest));
                if(count($vc_nearest_result) > 0)
                $message['data'][4]['nearest']=$vc_nearest_result;

                            $message['data'][4]['data']=$vc_cooler_result[$m];
                           
                    
                 }
            $vpo_avg="SELECT loc12,((sum(`vpo_score`)/count(refid)) *100) as vpo_avg FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12." and `visi_cooler`!='' group by loc12";
            $vpo_avg_result = DB::select(DB::raw($vpo_avg));
            $vpo="SELECT loc16,((sum(`vpo_score`)/count(refid)) *100) as vpo_score FROM `mdlz_urban_outlet_master` WHERE  loc16=".$locid." group by loc16";
             $vpo_result = DB::select(DB::raw($vpo));
            
             $message['data'][6]['data']= (object) ['city_avg' => $vpo_avg_result[0]->vpo_avg,
    'vpo_score' => 0];
              $message['data'][6]['nearest']=[];
                 for($m=0;$m<count($vpo_result);$m++)
                 {
                            $vpo_result[$m]->city_avg=0;
                            $vpo_result[$m]->city_avg=$vpo_avg_result[0]->vpo_avg;
                 $vpo_score_nearest="SELECT loc15,((sum(`vpo_score`)/count(refid))*100) as vpo_score,loc12,loc16 FROM `mdlz_urban_outlet_master` group by loc15 having loc16!=".$locid." and loc12=".$get_detail[0]->loc12." and vpo_score > ".$vpo_result[$m]->vpo_score."   limit 0,1";               
                 $vpo_score_nearest_result = DB::select(DB::raw($vpo_score_nearest));
                if(count($vpo_score_nearest_result) > 0)
                $message['data'][6]['nearest']=$vpo_score_nearest_result;

                            $message['data'][6]['data']=$vpo_result[$m];
                           
                    
                 }

            //
            $store_penatration_avg="SELECT loc12,((sum(`prgm_target_data`)/count(refid))*100) as store_penatration FROM `mdlz_urban_outlet_master` WHERE loc12=".$get_detail[0]->loc12." group by loc12";
            $store_penatration_avg_result = DB::select(DB::raw($store_penatration_avg));
            $store_penatrate="SELECT loc16,((sum(`prgm_target_data`)/count(refid))*100) as store_score FROM `mdlz_urban_outlet_master` WHERE  loc15=".$locid." and loc12=".$get_detail[0]->loc12." group by loc16";
            $store_penatrate_result = DB::select(DB::raw($store_penatrate));


            
             $message['data'][7]['data']= (object) ['city_avg' => $store_penatration_avg_result[0]->store_penatration,'store_score' => 0];
             $message['data'][7]['nearest']=[];
             for($m=0;$m<count($store_penatrate_result);$m++)
             {
               $store_penatrate_result[$m]->city_avg=0;
               $store_penatrate_result[$m]->city_avg=$store_penatration_avg_result[0]->store_penatration;
                $store_penatrate_nearest="SELECT loc16,((sum(`prgm_target_data`)/count(refid))*100) as store_score,loc12,loc16 FROM `mdlz_urban_outlet_master` group by loc16 having loc15!=".$locid." and loc12=".$get_detail[0]->loc12." and store_score > ".$store_penatrate_result[$m]->store_score."   limit 0,1";               
                 $store_penatrate_nearest_result = DB::select(DB::raw($store_penatrate_nearest));
                if(count($store_penatrate_nearest_result) > 0)
                $message['data'][7]['nearest']=$store_penatrate_nearest_result;

                        $message['data'][7]['data']=$store_penatrate_result[$m];
                       
                
             }


                $message['status']='success';
            }
            

           

    }
         return response()->json($message);
    }

    /*Rajkumar 31-12-2025 created */
    public function outlet_storename_save(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $retailer_id = $input["outlet_id"];
        $message = [];
        if($input["status"]!='')
        {
             $result = DB::table("pepsi_uncovered_outlets")
            ->where("retailer_id", $retailer_id)
            ->update(["revsed_name" => $input["status"]]);
            $message["status"] = "success";
            $message["msg"] = "Store Name updated successfully";

        }
        return json_encode($message);
    }
    //location locked function Rajkumar
    public function lock_location_save(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $userid = $user->id;
        $lock_status = $input["lock_status"];
        $lock_lat = $input["lock_lat"];
        $lock_lon = $input["lock_lon"];
        $result = DB::table("users")
            ->where("id", $userid)
            ->update(["lock_status" => $lock_status,"lock_lat" => $lock_lat,"lock_long" => $lock_lon]);

        $message = [];

        $message["status"] = "success";
        if($lock_status == 1)
        {
            $message["msg"] = "Your current location is locked";
        }
        else
        {
            $message["msg"] = "Your current location has been reset";
        }
        

        return json_encode($message);
    } //location locked function Rajkumar

    public function getpolygonstatus(Request $request)
    {
        $input = $request->all();
         $user = auth()->user();
        $userid = $user->id;
      // \Log::info($input);
        $current_lat = (float)$input["current_lat"];
        $current_lon = (float)$input["current_lon"];
       
        $current_lat = '26.748637707744553'; //Existing Dbr 1
        $current_lon ="84.4014386895364";

        $current_lat = '26.80836633026007'; //Recommend Dbr 5
        $current_lon = '84.32906869811333';

        switch ($user->client_id) {

        case 112:
            // Recommend DBR
            $sql = "SELECT ST_Contains(a.polygon_geo, POINT($current_lon, $current_lat)) AS res
                    FROM town_village_polygon a
                    JOIN coke_subrd_data_all b ON a.town_village_code = b.bi_id
                    WHERE b.village_census = ".$input["village_census"]."
                    ORDER BY res DESC
                    LIMIT 1";
            break;

        case 1201:
            // Recommend DBR
            $sql = "SELECT ST_Contains(a.polygon_geo, POINT($current_lon, $current_lat)) AS res
                    FROM town_village_polygon a
                    JOIN subrd_data b ON a.town_village_code = b.bi_id
                    WHERE b.village_census = ".$input["village_census"]."
                    ORDER BY res DESC
                    LIMIT 1";
            break;

        

        default:
            $sql = "SELECT ST_Contains(a.polygon_geo, POINT($current_lon, $current_lat)) AS res
                    FROM town_village_polygon a
                    JOIN pepsi_subrd_data b ON a.town_village_code = b.bi_id
                    WHERE b.bi_id = ".$input["bi_id"]."
                    ORDER BY res DESC
                    LIMIT 1";
            break;
        }
        

            // \Log::info($sql);

           // $result = DB::select(DB::raw($sql));
          // $result[0]->res=1;
            return response()->json([
                'status' => true,
                'res' => 1,
                'request_data' => $input   // ✅ add this line
            ]);
    }
    

    

   /* public function newupdateOutlet(Request $request, $id)
{
   // dd($id, $request->all());
    try {
         //\Log::info($id);

        $data = [
            'visit_outlet' => $request->visit_outlet,
            'outlet_name' => $request->outlet_name,
            'outlet_type' => $request->outlet_type_status,
            'is_pepsico_stock' => $request->is_pepsico_status,
            'is_pepsico_stock_channel' => $request->is_pepsico_stock_status,
        ];

        
        // ✅ image update (optional)
        if ($request->hasFile('outlet_pepsi_image')) {

            $file = $request->file('outlet_pepsi_image');
            $filename = time().'_'.$file->getClientOriginalName();

            $destinationPath = public_path('uploads/outlets');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);

            $data['image'] = 'uploads/outlets/'.$filename;
        }

        DB::table('pepsi_rural_new_outlets')
            ->where('refid', $id)
            ->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Outlet updated successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
}*/

public function saveoutlets(Request $request)
{
    try {

        $user = auth()->user();
        $userid = $user->id ?? 0;
        $form_type = $request->form_type;

      //  \Log::info($request->all());
        $subrd_type_status = '';
       if( $request->subrd_type_status == '5')
        {
            $subrd_type_status='Dbr';
        }
        else if($request->subrd_type_status == '1')
        {
            $subrd_type_status='Existing';
        }
       // \Log::info($subrd_type_status);
        $filePath = null;
        if ($form_type != 'village_suitable') {

             
            // \Log::info('if condition');
            // Use allFiles to be safe
            $files = $request->file('outlet_pepsi_image');

            if ($files) {
                // Wrap single file into array
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    $filename = $userid . '_' .  time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('shop_image/pepsi/rural/existing_disbtr/');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    $file->move($destinationPath, $filename);

                    $filePath = 'shop_image/pepsi/rural/existing_disbtr/' . $filename;

                    //\Log::info('Uploaded outlet_pepsi_image: ' . $filePath);
                }
            } else {
                //\Log::info('No outlet_pepsi_image detected.');
            }
          // \Log::info($filePath);
            $id = DB::table('pepsi_rural_new_outlets')->insertGetId([
                'bi_id' => $request->village_bi_id,
                'user_id' => $userid,
                'retailer_id' => 0,
                'outlet_name' => $request->outlet_name,
                'outlet_type' => $request->outlet_type_status,
                'state_name' => $request->state_name,
                'district_name' => $request->district_name,
                'taluk_name' => $request->taluk_name,
                'town_village_name' => $request->village_name,
                'status' => 'active',
                'image' => $filePath,
                'is_pepsico_stock' => $request->is_pepsico_status,
                'latitude' => $request->village_user_location_lat,
                'longitude' => $request->village_user_location_lon,
                'outlet_status' => $request->outlet_status,
                'visit_notes' => $request->visit_notes,
                'geo_address' => $request->geo_address,
                'is_pepsico_stock_channel' => $request->outlet_stock_from,
                'serviced_new_spoke' => $request->serviced_new_spoke,
                'existing_DBR'=>  $subrd_type_status
            ]);

              //log tables
             //log tables
              DB::table('pepsi_rural_log')->insertGetId([
                 'user_id' => $userid,
                  'bi_id' => $request->village_bi_id,
                 'latitude' => $request->village_user_location_lat,
                 'longitude' => $request->village_user_location_lon,
                 'form_name'=> 'Recommend Disbtr form',
                 'status'   => 'Add',
                 'client_id' => 133
                ]);

            

        } else {

            if ($request->hasFile('new_dbr_pepsi_image')) {

                $file = $request->file('new_dbr_pepsi_image');

                $filename = $userid . '_' .time() . '.' . $file->getClientOriginalExtension();

                $destinationPath = public_path('shop_image/pepsi/rural/recommed_subrd/');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $filename);

                $filePath = 'shop_image/pepsi/rural/recommed_subrd/' . $filename;
            }

            $id = DB::table('pepsi_rural_new_dbr')->insertGetId([
                'bi_id' => $request->village_bi_id,
                'user_id' => $userid,
                'retailer_id' => 0,
                'state_name' => $request->state_name,
                'district_name' => $request->district_name,
                'taluk_name' => $request->taluk_name,
                'town_village_name' => $request->village_name,
                'status' => 'active',
                'new_dbr_image' => $filePath,
                'latitude' => $request->village_user_location_lat,
                'longitude' => $request->village_user_location_lon,
                'village_suitable_anchor_status' => $request->is_Village_suitable_anchor,
                'name_party' => $request->name_of_the_party,
                'business_party_deails' => $request->business_party_deals,
                'party_shortlist_status' => $request->party_shortlist,
                'cluster_assign_status' => $request->new_cluster_assign
                
                
            ]);
        }
        
             //log tables
              DB::table('pepsi_rural_log')->insertGetId([
                 'user_id' => $userid,
                  'bi_id' => $request->village_bi_id,
                 'latitude' => $request->village_user_location_lat,
                 'longitude' => $request->village_user_location_lon,
                 'form_name'=> 'Recommend Disbtr form',
                 'status'   => 'Add',
                 'client_id' => 133
                ]);
        return response()->json([
            'status' => true,
            'message' => 'Saved Successfully',
            'id' => $id,
            'image' => $filePath ? asset($filePath) : '',
            'geo_address' => $request->geo_address
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function updateoutlets(Request $request)
{
    $outletId = $request->outlet_id;

    // DBR update block
    if ($request->record_type == 'dbr') {

        $currentData = DB::table('pepsi_rural_new_dbr')
            ->where('refid', $outletId)
            ->first();

        $updateData = [
            'name_party' => $request->name_party,
            'business_party_deails' => $request->business_party_deails,
            'village_suitable_anchor_status' => $request->village_suitable_anchor_status,
            'party_shortlist_status' => $request->party_shortlist_status,
            'updated_date' => now()
        ];

        /*if ($request->hasFile('new_dbr_image')) {

            $file = $request->file('new_dbr_image');

            $filename = auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = 'shop_image/pepsi/rural/existing_disbtr/';

            $file->move(public_path($path), $filename);

            $updateData['new_dbr_image'] = $path . $filename;
        }*/

        DB::table('pepsi_rural_new_dbr')
            ->where('refid', $outletId)
            ->update($updateData);

        return response()->json([
            'status' => 'success',
            'id' => $outletId,
            'type' => 'dbr'
        ]);
    }

    // Existing outlet functionality remains unchanged
    $currentData = DB::table('pepsi_rural_new_outlets')
                     ->where('refid', $outletId)
                     ->first();

    $updateData = [
        'outlet_name' => $request->outlet_name,
        'is_pepsico_stock' => $request->is_pepsico_status,
        'outlet_type' => $request->outlet_type_status,
        'geo_address' => $request->geo_address,
        'is_pepsico_stock_channel' => $request->outlet_stock_from,
        'updated_date' => now()
    ];

    DB::table('pepsi_rural_new_outlets')
        ->where('refid', $outletId)
        ->update($updateData);

    $logData = [];

    foreach ($updateData as $field => $newValue) {

        if ($field === 'updated_date') {
            continue;
        }

        $oldValue = $currentData->$field ?? null;

        if ($oldValue != $newValue) {
            $logData[] = [
                'user_id'    => auth()->id(),
                'bi_id'      => $currentData->bi_id,
                'field_name' => $field,
                'old_value'  => $oldValue,
                'new_value'  => $newValue,
                'form_name'  => 'Existing Distributor Form',
                'status'     => 'update',
                 'latitude'   => $request->village_user_location_lat ?? '',
                'longitude'  => $request->village_user_location_lon ?? '',
            ];
        }
    }

    if (!empty($logData)) {
        DB::table('pepsi_rural_log')->insert($logData);
    }

    return response()->json([
        'status' => 'success',
        'id' => $outletId,
        'type' => 'outlet'
    ]);
}
public function saveoutlets_mdlz(Request $request)
{
    try {

        $user = auth()->user();
        $userid = $user->id ?? 0;
        $form_type = $request->form_type;

      //  \Log::info($request->all());
        $subrd_type_status = '';
       if( $request->subrd_type_status == '5')
        {
            $subrd_type_status='Dbr';
        }
        else if($request->subrd_type_status == '1')
        {
            $subrd_type_status='Existing';
        }
        \Log::info($subrd_type_status);
        $filePath = null;
        if ($form_type != 'village_suitable') {

             
            // \Log::info('if condition');
            // Use allFiles to be safe
            $files = $request->file('outlet_pepsi_image');

            if ($files) {
                // Wrap single file into array
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    $filename = $userid . '_' .  time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('mdlz/rural/shop_image/');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    $file->move($destinationPath, $filename);

                    $filePath = 'mdlz/rural/shop_image/' . $filename;

                    //\Log::info('Uploaded outlet_pepsi_image: ' . $filePath);
                }
            } else {
                //\Log::info('No outlet_pepsi_image detected.');
            }
          // \Log::info($filePath);
            $id = DB::table('mdlz_rural_new_outlets')->insertGetId([
                'bi_id' => $request->village_bi_id,
                'user_id' => $userid,
                'retailer_id' => 0,
                'outlet_name' => $request->outlet_name,
                'outlet_type' => $request->outlet_type_status,
                'state_name' => $request->state_name,
                'district_name' => $request->district_name,
                'taluk_name' => $request->taluk_name,
                'town_village_name' => $request->village_name,
                'status' => 'active',
                'image' => $filePath,
                'is_pepsico_stock' => $request->is_pepsico_status,
                'latitude' => $request->village_user_location_lat,
                'longitude' => $request->village_user_location_lon,
                'outlet_status' => $request->outlet_status,
                'visit_notes' => $request->visit_notes,
                'geo_address' => $request->geo_address,
                'is_pepsico_stock_channel' => $request->outlet_stock_from,
                'serviced_new_spoke' => $request->serviced_new_spoke,
                'existing_DBR'=>  $subrd_type_status
            ]);

              //log tables
             //log tables
              DB::table('pepsi_rural_log')->insertGetId([
                 'user_id' => $userid,
                  'bi_id' => $request->village_bi_id,
                 'latitude' => $request->village_user_location_lat,
                 'longitude' => $request->village_user_location_lon,
                 'form_name'=> 'Recommend Disbtr form',
                 'status'   => 'Add',
                 'client_id' =>  120
                ]);

            

        } else {

            if ($request->hasFile('new_dbr_pepsi_image')) {

                $file = $request->file('new_dbr_pepsi_image');

                $filename = $userid . '_' .time() . '.' . $file->getClientOriginalExtension();

                $destinationPath = public_path('mdlz/rural/shop_image/');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $filename);

                $filePath = 'mdlz/rural/shop_image/' . $filename;
            }

            $id = DB::table('mdlz_rural_new_dbr')->insertGetId([
                'bi_id' => $request->village_bi_id,
                'user_id' => $userid,
                'retailer_id' => 0,
                'state_name' => $request->state_name,
                'district_name' => $request->district_name,
                'taluk_name' => $request->taluk_name,
                'town_village_name' => $request->village_name,
                'status' => 'active',
                'new_dbr_image' => $filePath,
                'latitude' => $request->village_user_location_lat,
                'longitude' => $request->village_user_location_lon,
                'village_suitable_anchor_status' => $request->is_Village_suitable_anchor,
                'name_party' => $request->name_of_the_party,
                'business_party_deails' => $request->business_party_deals,
                'party_shortlist_status' => $request->party_shortlist,
                'cluster_assign_status' => $request->new_cluster_assign
                
                
            ]);
        }
        
             //log tables
              DB::table('pepsi_rural_log')->insertGetId([
                 'user_id' => $userid,
                  'bi_id' => $request->village_bi_id,
                 'latitude' => $request->village_user_location_lat,
                 'longitude' => $request->village_user_location_lon,
                 'form_name'=> 'Recommend Disbtr form',
                  'status'   => 'Add',
                 'client_id' =>  120
                ]);
        return response()->json([
            'status' => true,
            'message' => 'Saved Successfully',
            'id' => $id,
            'image' => $filePath ? asset($filePath) : '',
            'geo_address' => $request->geo_address
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function updateoutlets_mdlz(Request $request)
{
    $outletId = $request->outlet_id;

    // DBR update block
    if ($request->record_type == 'dbr') {

        $currentData = DB::table('mdlz_rural_new_dbr')
            ->where('refid', $outletId)
            ->first();

        $updateData = [
            'name_party' => $request->name_party,
            'business_party_deails' => $request->business_party_deails,
            'village_suitable_anchor_status' => $request->village_suitable_anchor_status,
            'party_shortlist_status' => $request->party_shortlist_status,
            'updated_date' => now()
        ];

        /*if ($request->hasFile('new_dbr_image')) {

            $file = $request->file('new_dbr_image');

            $filename = auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = 'shop_image/pepsi/rural/existing_disbtr/';

            $file->move(public_path($path), $filename);

            $updateData['new_dbr_image'] = $path . $filename;
        }*/

        DB::table('mdlz_rural_new_dbr')
            ->where('refid', $outletId)
            ->update($updateData);

        return response()->json([
            'status' => 'success',
            'id' => $outletId,
            'type' => 'dbr'
        ]);
    }

    // Existing outlet functionality remains unchanged
    $currentData = DB::table('mdlz_rural_new_outlets')
                     ->where('refid', $outletId)
                     ->first();

    $updateData = [
        'outlet_name' => $request->outlet_name,
        'is_pepsico_stock' => $request->is_pepsico_status,
        'outlet_type' => $request->outlet_type_status,
        'geo_address' => $request->geo_address,
        'is_pepsico_stock_channel' => $request->outlet_stock_from,
        'updated_date' => now()
    ];

    DB::table('mdlz_rural_new_outlets')
        ->where('refid', $outletId)
        ->update($updateData);

    $logData = [];

    foreach ($updateData as $field => $newValue) {

        if ($field === 'updated_date') {
            continue;
        }

        $oldValue = $currentData->$field ?? null;

        if ($oldValue != $newValue) {
            $logData[] = [
                'user_id'    => auth()->id(),
                'bi_id'      => $currentData->bi_id,
                'field_name' => $field,
                'old_value'  => $oldValue,
                'new_value'  => $newValue,
                'form_name'  => 'Existing Distributor Form',
                'status'     => 'update',
                 'latitude'   => $request->village_user_location_lat ?? '',
                'longitude'  => $request->village_user_location_lon ?? '',
            ];
        }
    }

    if (!empty($logData)) {
        DB::table('pepsi_rural_log')->insert($logData);
    }

    return response()->json([
        'status' => 'success',
        'id' => $outletId,
        'type' => 'outlet'
    ]);
}
public function storeSession(Request $request)
{
    session([
        'type'  => $request->type,
        'bi_id' => $request->bi_id
    ]);

    return response()->json([
        'status' => true,
         'bi_id' => $request->bi_id
    ]);
}
public function updateBiSession(Request $request)
{
    // Validate bi_id
    $request->validate([
        'bi_id' => 'required|integer',
    ]);

    // Update session
    session(['bi_id' => $request->bi_id]);

    //\Log::info('Session BI ID updated: ' . $request->bi_id);


      $user = auth()->user();
           // $userid = $user->id;

            $pepsi_rural_new_outlets = collect();
            if ($user->client_id == 133 ) {
                   
                     $pepsi_rural_new_outlets = collect();
                    // Fetch the latest bi_id from session
                    $bi_id = session('bi_id');

                    // Make sure bi_id exists
                    if ($bi_id) {
                    $pepsi_rural_new_outlets = DB::table('pepsi_rural_new_outlets')
                    ->where('user_id', $user->id)
                     ->where('bi_id', $request->bi_id)
                   
                     
                    ->get();
                    } else {
                    $pepsi_rural_new_outlets = collect(); // empty collection if no bi_id
                    }
            }

            $pepsi_rural_new_dbr = collect();
            if ($user->client_id == 133 ) {
                   
                     $pepsi_rural_new_dbr = collect();
                    // Fetch the latest bi_id from session
                    $bi_id = session('bi_id');

                    // Make sure bi_id exists
                    if ($bi_id) {
                    $pepsi_rural_new_dbr = DB::table('pepsi_rural_new_dbr')
                    ->where('user_id', $user->id)
                     ->where('bi_id', $request->bi_id)
                   
                     
                    ->get();
                    } else {
                    $pepsi_rural_new_dbr = collect(); // empty collection if no bi_id
                    }
            }

    // Return JSON response
    return response()->json([
        'status' => 'success',
        'bi_id' => $request->bi_id,
        'pepsi_rural_new_outlets' =>$pepsi_rural_new_outlets,
         'pepsi_rural_new_dbr' =>$pepsi_rural_new_dbr

        
    ]);
}

public function villageCoverStatusSave(Request $request)
{
    try {
        $user = auth()->user();
        $userid = $user->id ?? 0;

        $updateData = [
            'village_cover_status' => $request->village_cover_status,
            'user_id' => $userid,
            'update_date' => now()
        ];

        $updated = DB::table('coke_subrd_data_all')
            ->where('village_census', $request->bi_id)
            ->update($updateData);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Your input was saved',
                'data' => $updateData
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No record found or no changes made'
            ], 404);
        }

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}


}
