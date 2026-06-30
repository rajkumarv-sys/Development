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

   public function login(){

       if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
       {
            $user = Auth::user();
            $token =  $user->createToken($user->email)->accessToken;

            $type=($user->login_type_mdlz=='Rural') ? 1 : (($user->login_type_mdlz=='Urban') ? 2 : 0);
           $userinfo = array( 'status'=>true,'message'=>'Authentication Successful','data' => array('id' => $user->id, 'firstname' => $user->firstname, 'email' => $user->email,'client_id'=>$user->client_id,'role'=>$user->role,'Organiation'=>$user->Organization, 'token' => $token,'type'=>$type));
           $userinfo['data']['menulist']=[];
           
           
           $menu=DB::table('menu_list')->where([['type','=',$type],['client_id','=',$user->client_id]])->get();
           $count=count($menu);
          
           for($i=0;$i<$count;$i++)
                $userinfo['data']['menulist'][$menu[$i]->id]=$menu[$i]->menu_name;
           

           return response()->json($userinfo, $this->successStatus);
       }

       else
       {
          $user=DB::table('users')->where([['email','=',request('email')]])->get();
          if(count($user) > 0)
             $errorinfo=['status'=>false,'message'=>'Wrong Password','data'=>[]];
          else
             $errorinfo=['status'=>false,'message'=>'No user Exists.','data'=>[]];

           return response()->json($errorinfo, 401);
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

   public function menulist(Request $request)
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
       $message['data']['menulist']=[];
           for($i=0;$i<$count;$i++){
                $data['id']=$menu[$i]->id;
                $data['name']= $menu[$i]->menu_name;
                array_push($message['data']['menulist'],$data);
           }  
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
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $menu_id=$input['menu_id'];
       $menu_wise_state=[1=>['id'=>1,'statelist'=>[]],2=>['id'=>2,'statelist'=>[]],3=>['id'=>3,'statelist'=>[]],4=>['id'=>4,'statelist'=>[]],5=>['id'=>5,'statelist'=>[]]];
       $user=DB::table('users')->where([['id','=',$userid]])->first();
       $user_state=[];$tsi_id=[];

        

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
            $tsimaster = DB::table("subrd_data")->select('loc7 as state_id')->distinct()->get()->toArray(); 

                for($k=0;$k<count($tsimaster);$k++)
                {
                    if(!in_array($tsimaster[$k]->state_id,$user_state))
                      array_push($user_state,$tsimaster[$k]->state_id);

                }
        }
        else
        {
            array_push($tsi_id,$user->id);
              $tsimaster = DB::table("tsi_user_master")->whereIn('refid',$tsi_id)->select('state_id')->distinct()->get()->toArray(); 

                for($k=0;$k<count($tsimaster);$k++)
                {
                    if(!in_array($tsimaster[$k]->state_id,$user_state))
                     array_push($user_state,$tsimaster[$k]->state_id);
                }
        }
        $subr="";$subr_1="";$subr_2="";
        if($user->role!='BM' || $user->role!='RSOM' || $user->role!='HO' )
        {
            $subr=" and  a.loc7 in (".implode(',',$user_state).")";
            $subr_1=" and  a.state_id in (".implode(',',$user_state).")";
            $subr_2="and  a.loc7 in (".implode(',',$user_state).")";
        }
          
       if($menu_id==1) 
       {
          $highway_list = "select distinct b.refid as state_id,b.location_name as state from highway_structure as a ,state_master as b  where a.state_id=b.refid $subr_1 order by b.location_name asc";
         $highway_list_ = DB::select(DB::raw($highway_list));
        $highway_list_count=count($highway_list_);
        
        for($i=0;$i<$highway_list_count;$i++)
            array_push($menu_wise_state[1]['statelist'],['id'=>$highway_list_[$i]->state_id,'name'=>$highway_list_[$i]->state]);
       }
       if($menu_id==2 || $menu_id==3)
       {
         $subrd_type = ($menu_id==2) ? ' and a.subrd_type in (1,2) ' : (($menu_id==3) ? ' and a.subrd_type in (3) ' : '' );
          $subrd_state = "select distinct  b.refid as state_id,b.location_name as state,a.subrd_type from subrd_data as a ,state_master as b  where a.loc7=b.refid $subrd_type $subr group by b.refid order by b.location_name asc";
         $subrd_state = DB::select(DB::raw($subrd_state));
        $subrd_state_count=count($subrd_state);
         
        for($i=0;$i<$subrd_state_count;$i++)
        {
            if(in_array($subrd_state[$i]->subrd_type,[1,2]))
            {
                              
                    array_push($menu_wise_state[2]['statelist'],['id'=>$subrd_state[$i]->state_id,'name'=>$subrd_state[$i]->state]);
                    
            }
            if(in_array($subrd_state[$i]->subrd_type,[3]))
            {
                
                    array_push($menu_wise_state[3]['statelist'],['id'=>$subrd_state[$i]->state_id,'name'=>$subrd_state[$i]->state]);
            }
        }
        
       }
       
               
     if($menu_id==4)
     {
        $subrd_beat_="select  distinct b.location_name as state,b.refid as state_id from subrd_outlet as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70) $subr order by b.location_name asc";
        $subrd_beat_ = DB::select(DB::raw($subrd_beat_));
        $subrd_beat_count=count($subrd_beat_);
                 
        for($i=0;$i<$subrd_beat_count;$i++)
                   array_push($menu_wise_state[4]['statelist'],['id'=>$subrd_beat_[$i]->state_id,'name'=>$subrd_beat_[$i]->state]); 
        
     }
    if($menu_id==5) 
    {
         $SST_beat_="select  distinct b.location_name as state,b.refid as state_id from sst_data as a,state_master_2011 as b where a.loc7=b.refid and b.refid not in (1,70) $subr order by b.location_name asc";
        $SST_beat_ = DB::select(DB::raw($SST_beat_));
        $SST_beat_count=count($SST_beat_);
         
        for($i=0;$i<$SST_beat_count;$i++)                    
                array_push($menu_wise_state[5]['statelist'],['id'=>$SST_beat_[$i]->state_id,'name'=>$SST_beat_[$i]->state]);
    }
       
        $message=['status'=>true,'message'=>'Statelist loaded','data'=>[]];
        $message['data']=$menu_wise_state[$menu_id];
       return response()->json($message, $this->successStatus);
       
   }
   public function districtlist(Request $request)
   { 
       $input = $request->all();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $menu_id=$input['menu_id'];
       $state_id=$input['state_id'];
       $menu_wise_state=[1=>['id'=>1,'data_list'=>[]],2=>['id'=>2,'data_list'=>[]],3=>['id'=>3,'data_list'=>[]],4=>['id'=>4,'data_list'=>[]],5=>['id'=>5,'data_list'=>[]]];
      

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
         $subrd_district= "select distinct b.refid,b.location_name, '".$menu_id."' subrd_type from subrd_data as a,district_master_2011 as b where a.loc9=b.refid and a.loc7='".$state_id."' $subrd_type order by b.location_name asc";
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
       
        $message=['status'=>true,'message'=>'Data loaded','data'=>[]];
        $message['data']=$menu_wise_state[$menu_id];
       return response()->json($message, $this->successStatus);
       
   }
   public function taluklist(Request $request)
   { 
       $input = $request->all();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $menu_id=$input['menu_id'];
       $district_id=$input['district_id'];
       $menu_wise_state=[1=>['id'=>1,'data_list'=>[]],2=>['id'=>2,'data_list'=>[]],3=>['id'=>3,'data_list'=>[]],4=>['id'=>4,'data_list'=>[]],5=>['id'=>5,'data_list'=>[]]];
      

      
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
       
               
     if($menu_id==4)
     {
        $subrd_beat_="select distinct subrd_id,concat(subrd_name,':',subrd_code) as subrd_name from subrd_outlet where loc9='".$district_id."' order by subrd_name asc";
        $subrd_beat_ = DB::select(DB::raw($subrd_beat_));
        $subrd_beat_count=count($subrd_beat_);
                 
        for($i=0;$i<$subrd_beat_count;$i++)
                   array_push($menu_wise_state[4]['data_list'],['id'=>$subrd_beat_[$i]->subrd_id,'name'=>$subrd_beat_[$i]->subrd_name]); 
        
     }
    if($menu_id==5) 
    {
         $SST_beat_='select sst as id,sst as name from sst_data where loc9="'.$district_id.'" order by sst asc';
        $SST_beat_ = DB::select(DB::raw($SST_beat_));
        $SST_beat_count=count($SST_beat_);
         
        for($i=0;$i<$SST_beat_count;$i++)                    
                array_push($menu_wise_state[5]['data_list'],['id'=>$SST_beat_[$i]->id,'name'=>$SST_beat_[$i]->name]);
    }
       
        $message=['status'=>true,'message'=>'Data loaded','data'=>[]];
        $message['data']=$menu_wise_state[$menu_id];
       return response()->json($message, $this->successStatus);
       
   }

   public function getsubrd_response(Request $request)
   {
       $message=[];
       $message=['maplist'=>[],'mapdata'=>[],'tabledata'=>['column'=>['#','SubRD Cluster ID','Distt. Name','Sub-Distt. Name','Town / Village Name','Market UID','Distance from Recmmd SubRD Locatn (Km)','Outlet Potential (Nos.)','Population (Nos.)','Villg. Choc Consumption (Annual) (Rs.)','SubRD Priority','Cluster Type','Exist SubRD Code','Exist SubRD Name','No of Active Location'],'value'=>[]]];
       $input = $request->all();
       $user = Auth::user();
       $userid=$input['userid'];
       $client_id=$input['client_id'];
       $view_type=$input['view_type']; //1-district 2-taluk
       if(isset($input['district_id']) || isset($input['taluk_id']))
        $id=(isset($input['district_id'])) ? explode(",",$input['district_id']) : (isset($input['taluk_id']) ? explode(",",$input['taluk_id']) :[0]);
       $type_view=($input['recommdation']==2) ? [1,2] : [3]; //1,2 - recomm subrd,exit subrd 3- wholesale subrd
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
                    $path = "http://192.168.10.49/" . $loadmap;
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
                        $path = "http://192.168.10.49/" . $loadmap;
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

      $sql="SELECT  a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.`village_choc_consmptn`, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img FROM `subrd_data` as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";
      $result = DB::select(DB::raw($sql));
      $result=$this->getarray($result);
      $final_result=[];
      $inc=0;
      $taluk_name=array_column($result,'taluk_name');
      $taluk_name=array_unique($taluk_name);
      $district_name=array_column($result,'district_name');
      $district_name=array_unique($district_name);
      $table_data=[];
      $priority=['Priority 1'=>'http://192.168.10.49/locaview/public/rural_icon/r_p1.png','Priority 2'=>'http://192.168.10.49/locaview/public/rural_icon/r_p2.png','Priority 3'=>'http://192.168.10.49/locaview/public/rural_icon/r_p3.png',''=>'http://192.168.10.49/locaview/public/rural_icon/recommendation.png'];
      $without_hub=$result;
      $non_cluster_color=[];
       

      $message['mapdata']=[];
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

                  $final_result[$inc]['exist_subrd_marker']=($result[$i]['subrd_type']==1 && $result[$i]['subrd_loaction']!='Existing Urban Distbtr Hub') ? 'http://192.168.10.49/locaview/public/rural_icon/efficient-subrd.png' : '';
                  $final_result[$inc]['recommand_subrd_marker']=($result[$i]['subrd_type']==2) ? $priority[$result[$i]['subrd_priority']] : '';
                  $final_result[$inc]['wholesale_marker']=($result[$i]['subrd_type']==3) ? 'http://192.168.10.49/locaview/public/rural_icon/Wholesaler.png' : '';
                   $final_result[$inc]['urbandistributor_marker']=($final_result[$inc]['subrd_type']==1 && $final_result[$inc]['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$inc]['subrd_type'],$type_view)) ? 'http://192.168.10.49/locaview/public/rural_icon/urban-distributor.png' : '';
                 
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
                  $final_result[$inc]=$without_hub[$i];
                  $final_result[$inc]['child']=[];
                  $final_result[$inc]['exist_subrd_marker']=($without_hub[$i]['subrd_type']==1) ? 'http://192.168.10.49/locaview/public/rural_icon/efficient-subrd.png' : '';
                  $final_result[$inc]['recommand_subrd_marker']=($without_hub[$i]['subrd_type']==2) ? $priority[$without_hub[$i]['subrd_priority']] : '';
                  $final_result[$inc]['wholesale_marker']=($without_hub[$i]['subrd_type']==3) ? 'http://192.168.10.49/locaview/public/rural_icon/Wholesaler.png' : '';
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
            
             
            if($final_result[$k]['is_hub'] != 1 && $final_result[$k]['subrd_type']!=0)
             {
                $hub='#ffffff';
                $child='';

                if($final_result[$k]['active_stat']=='Yes' && ($final_result[$k]['subrd_type']==1) && in_array($final_result[$k]['subrd_type'],$type_view))
                          $hub= $this->getcolor_bysubrd('l_grey');
                if($final_result[$k]['active_stat']=='N'  && ($final_result[$k]['subrd_type']==1) && in_array($final_result[$k]['subrd_type'],$type_view))
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
             $temp['activate_marker']=($final_result[$k]['company_service_id']==1) ? 'http://192.168.10.49/locaview/public/rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'http://192.168.10.49/locaview/public/rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'http://192.168.10.49/locaview/public/rural_icon/deactivated.png' :(($final_result[$k]['company_service_id']==4) ? 'http://192.168.10.49/locaview/public/rural_icon/activated.png' :(($final_result[$k]['company_service_id']==5) ? 'http://192.168.10.49/locaview/public/rural_icon/deactivated.png'  : ''))));

            
             if($final_result[$k]['is_hub']!=0)
            {

               $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
            
               $temp['exist_subrd_marker']=($final_result[$k]['subrd_type']==1 && $final_result[$k]['subrd_loaction']!='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'http://192.168.10.49/locaview/public/rural_icon/efficient-subrd.png' : '';
               $temp['recommand_subrd_marker']=($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? $priority[$final_result[$k]['subrd_priority']] : '';
               $temp['wholesale_marker']=($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'http://192.168.10.49/locaview/public/rural_icon/Wholesale.png' : '';
               $temp['urbandistributor_marker']=($final_result[$k]['subrd_type']==1 && $final_result[$k]['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'http://192.168.10.49/locaview/public/rural_icon/urban-distributor.png' : '';

               
            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['exist_subrd_marker']='';
               $temp['wholesale_marker']= '';
               $temp['urbandistributor_marker']= '';
               $temp['recommand_subrd_marker']='';

                 
                 
            }

      $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : 'http://192.168.10.49/locaview/public/rural_icon/'.$final_result[$k]['rpi_img'].'.jpg';

     $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? number_format($final_result[$k]['village_choc_consmptn'],0) : $final_result[$k]['village_choc_consmptn'];
     $temp['rpi']=$final_result[$k]['rpi_img'];
     $temp['info']=[];
     $temp['Village']=$maparray[$final_result[$k]['village_census']]['location_name'];
     $temp['Taluk']=$final_result[$k]['taluk_name'];
     $temp['District']=$final_result[$k]['district_name'];
     $temp['is_hub']=$final_result[$k]['is_hub'];
     $temp['subrd_type']=$final_result[$k]['subrd_type'];
      $temp['refid']=$final_result[$k]['refid'];


    

      array_push($temp['info'],['key'=>'Recommendation','value'=>$cluster_type,'type'=>'text']);
       array_push($temp['info'],['key'=>'Distance from '.$cluster_hub.' (km)','value'=>0 ,'type'=>'number']);
        array_push($temp['info'],['key'=>'Population (2021)','value'=>number_format($final_result[$k]['population'],0),'type'=>'text']);
        array_push($temp['info'],['key'=>'FMCG Retlr Univ Nos.','value'=>$final_result[$k]['retlr_universe'],'type'=>'text']);
        array_push($temp['info'],['key'=>'Villg. Choc Consumption (Annual) (Rs.)','value'=>$final_result[$k]['village_choc_consmptn'],'type'=>'text']);
    if($final_result[$k]['rpi_img']!='')
        array_push($temp['info'],['key'=>'Rural Progressive Index','value'=>$rural_img,'type'=>'img']);
     array_push($temp['info'],['key'=>'Cluster Tag','value'=>$cluster_tag,'type'=>'text']);
     array_push($temp['info'],['key'=>'SubRD Priority','value'=>$final_result[$k]['subrd_priority'],'type'=>'text']);

     array_push($temp['info'],['key'=>'SubRD Cluster Priority','value'=>$final_result[$k]['subrd_priority'],'type'=>'text']);
      array_push($temp['info'],['key'=>'Market UID','value'=>$final_result[$k]['market_id'],'type'=>'text']);
       array_push($temp['info'],['key'=>'BI Location ID','value'=>$final_result[$k]['bi_id'],'type'=>'text']);
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
      $table_data[$final_result[$k]['village_census']]['child']=[];
     
      

    

     $temp['size']=15;
     $temp['activate_status_icon']=$temp['activate_marker'];
     $temp['activate_status']=$final_result[$k]['activate_status'];
     $temp['latitude']=$maparray[$final_result[$k]['village_census']]['latitude'];
     $temp['longitude']=$maparray[$final_result[$k]['village_census']]['longitude'];
     $temp['id']=$final_result[$k]['village_census'];
     $data=$temp;
     array_push($message['mapdata'],$data);

        if(isset($final_result[$k]['child']) && count($final_result[$k]['child']) > 0)
        {
              foreach($final_result[$k]['child'] as $key=>$value)
            {
                // $temp=$value;
                  $temp=[];
                 if(in_array($value['subrd_type'],[2,3])){
                     $summary_count['new_village']++;
                   if(isset($summary_count[$value['rpi']])) 
                            $summary_count[$value['rpi']]++;
                 }
                    $temp['color']= $this->getcolor_bysubrd('l_'.$split_color);
                 if($value['subrd_type']==1)    
                 {
                       if($value['active_stat']=='Yes')
                          $temp['color']= $this->getcolor_bysubrd('l_'.$split_color);
                       if($value['active_stat']=='N')
                           $temp['color']= $this->getcolor_bysubrd('yellow');                      
                 }             
                
                
                 $cluster_type=$value['subrd_loaction'];
                 $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($value['subrd_type']==1) ? 'Existing SubRD' :(($value['subrd_type']==2) ? 'Recommd SubRD' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                   $value['village_census']=ltrim($value['village_census'], 0);
                  
                  if(isset($maparray[$value['village_census']]))
                {
                    $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ? number_format($value['village_choc_consmptn'],0) : $value['village_choc_consmptn'];
                    $value['population']=($value['population']!='') ? number_format($value['population'],0) : $value['population'];
                    $value['village_name']=$maparray[$value['village_census']]['location_name'];

                       $rural_img=($value['rpi_img'] == '') ? '' : 'http://192.168.10.49/locaview/public/rural_icon/'.$value['rpi_img'].'.jpg';
                       $temp['rpi']=$value['rpi_img'];
                     $temp['info']=[];
                       $temp['Village']=$maparray[$value['village_census']]['location_name'];
                     $temp['Taluk']=$value['taluk_name'];
                     $temp['District']=$value['district_name'];
                      $temp['refid']=$value['refid'];
                     

                     array_push($temp['info'],['key'=>'Recommendation','value'=>$cluster_type,'type'=>'text']);
                     array_push($temp['info'],['key'=>'Distance from '.$cluster_hub.' (km)','value'=>$value['distance_subrd'],'type'=>'text']);
                     array_push($temp['info'],['key'=>'Population (2021)','value'=>$value['population'],'type'=>'text']);

                     array_push($temp['info'],['key'=>'FMCG Retlr Univ Nos.','value'=>$value['retlr_universe'],'type'=>'text']);
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
                    $temp_child['is_hub']=$value['is_hub'];
                    $temp_child['subrd_type']=$value['subrd_type'];
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
      
                    array_push($table_data[$final_result[$k]['village_census']]['child'],$temp_child);
                    
                     $temp['size']=10;
                   //  $temp['activate_status_icon']=$temp['activate_marker'];
                     //$temp['activate_status']=$value['activate_status'];
                     $temp['latitude']=$maparray[$value['village_census']]['latitude'];
                     $temp['longitude']=$maparray[$value['village_census']]['longitude'];
                     $temp['id']=$value['village_census'];
                     $value['activate_status']=$value['company_service_id'];
                     $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                    $value['activate_marker']=($value['company_service_id']==1) ? 'http://192.168.10.49/locaview/public/rural_icon/active.png' : (($value['company_service_id']==2) ? 'http://192.168.10.49/locaview/public/rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'http://192.168.10.49/locaview/public/rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'http://192.168.10.49/locaview/public/rural_icon/activated.png' :(($value['company_service_id']==5) ? 'http://192.168.10.49/locaview/public/rural_icon/deactivated.png'  : ''))));
            
             $temp['size']=8;
             $temp['activate_status_icon']=$value['activate_marker'];
             $temp['activate_status']=$value['activate_status'];
             $temp['subrd_status']=0;
             $temp['exist_subrd_marker']='';
           $temp['wholesale_marker']= '';
           $temp['urbandistributor_marker']= '';
           $temp['recommand_subrd_marker']='';

            

            

            array_push($message['mapdata'],$temp);

             // $temp2['village_census']=ltrim($value['village_census'],0);
           
          //  $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                }

             
            }

            array_push($message['tabledata']['value'],$table_data[$final_result[$k]['village_census']]);

        }
         
      
         
         }
         //$message['mapdata']=$maparray;

        $aLegend = [];
        foreach($summary_count as $k => $v){
            array_push($aLegend,['name'=>$k,'value'=>$v,'color'=>'#fff']);
        }

          $message['legend']=$aLegend;
         $message['action_list']=[];
         $message['action_list'][0]=['name'=>'Exist Subrd Hub','img'=>'http://192.168.10.49/locaview/public/rural_icon/efficient-subrd.png'];
         $message['action_list'][1]=['name'=>'Urban Distributor Hub','img'=>'http://192.168.10.49/locaview/public/rural_icon/urban-distributor.png'];
          $message['action_list'][2]=['name'=>'Recommanded Subrd Hub','img'=>'http://192.168.10.49/locaview/public/rural_icon/recommendation.png'];
         $message['action_list'][3]=['name'=>'Wholesale','img'=>'http://192.168.10.49/locaview/public/rural_icon/Wholesale.png'];
         
          $message['action_list'][4]=['name'=>'Active','img'=>'http://192.168.10.49/locaview/public/rural_icon/active.png'];
           $message['action_list'][5]=['name'=>'RPI','img'=>'http://192.168.10.49/locaview/public/rural_icon/rpi-overlay.png'];

      

       return response()->json($message, $this->successStatus);
       
   }
   public function getsubrd_details(Request $request)
   {
        $input = $request->all();
        $subrd_id=$input['subrd_id'];

        $result=DB::table('subrd_data')->select( "refid", "cluster_id", "cluster_name", "state_name", "district_name", "taluk_name", "village_name", "rpi", "rpi_id", "sector", "sector_code", "loc7", "loc9", "loc10", "loc13", "loc12", "market_id", "bi_id", "distance_subrd", "subrd_loaction", "remakrs", "retlr_universe", "mdlz_retlr_universe", "outlet_potential", "population", "state_census", "district_census", "taluk_census", "village_census", "village_choc_consmptn", "cluster_tag", "stat", "active_stat", "subrd_type", "total_covered_outlets", "total_covered_wholesalers", "total_covered_visicoolers", "total_distance", "is_hub", "subrd_priority", "tsm_id", "village_2011_census", "company_service_id", "exist_subrd_code", "exist_subrd_name", "hub_id", "remaks")->where([['refid','=',$subrd_id]])->get();
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
              array_push($subrd_details,['id'=>'Distance from Recmmd SubRD / Wholesale Locatn (Km)','value'=>$result[$k]->distance_subrd]);
              array_push($subrd_details,['id'=>'Outlet potential','value'=>$result[$k]->outlet_potential]);
              array_push($subrd_details,['id'=>'Population 2021','value'=>$result[$k]->population]);
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
                            $FillColor = '#fec387';
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

                    default:
                          $FillColor = '#ffffff';
             }
     return $FillColor;
    }
}
