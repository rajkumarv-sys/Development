<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\BeatMaster;
use App\Models\HighwayOutlet;
use App\Models\HighwayStructure;
use App\Http\Controllers\CommonController;

class OutletController extends Controller
{
    public $successStatus = 200;    
    public $filenotfound = 404;
    public $failure =500;
    private $isolate=[166, 63, 26];
    private $low=[5,69,54];
    private $high=[151,83,34];

    public function getbeatdetails(Request $request){
        $message=[];
        $input = $request->all();
        $user = Auth::user();
        $client_id = $user->client_id;
        $getBeat=BeatMaster::select("beat_master.id","beat_master.beat_name")->distinct()->join('haldirams_sample_data_cluster as b','beat_master.id','=','b.beat_id')->where([['client_id','=',$client_id]])->get();
        $message=['status'=>true,'message'=>'BeatList Data.','data'=>[]];
        $message['data']=$getBeat;
        return response()->json($message, $this->successStatus);

    }

    public function hri_delhi_outlets(Request $request)
    {
     $input = $request->all();
       $message=['covered'=>[],'uncovered'=>[],'ward_id'=>[$input['ward_id']],'tabledata'=>['column'=>['#','Retailer ID','Name','Type','Sub Type','Potential Status','Address','Contact','City','Neighborhood','Status'],'value'=>[]]];
    
       $loc15=explode(",",$input['ward_id']);
       $type_id=$input['type_id'];

       $uncovered=DB::table("0_delhi_uncvrd_outlets")->select( "refid", "retailer_id", "name", "type", "sub_type", "outlet_potential", "locality_name", "nbhrd", "address", "latitude", "longitude", "contact", "beat_id", "icon", "shop_image", "status",DB::raw("if(status='N','New',if(status='A','Found',if(status='NF','Not Found',''))) as outlet_status"),DB::raw("if(fld1923=3,'High',if(fld1923=2,'Medium',if(fld1923=1,'Low',''))) as outlet_potential_status"),"loc15","loc16", "beat_id", "fld1923", "city_id", "city", "nbhrd as beat_name","app_status");
       if(isset($loc15) && $loc15!='')
         $uncovered=$uncovered->whereIn("loc15",$loc15);
       //  if(isset($input['filter']))
       // {
          
       //    if(isset($input['channel_type']))
       //    {
       //         $input['channel_type']=explode(",",$input['channel_type']);
       //         $input['channel_type']= array_map(function($el) {
       //                 $el=str_replace("'","",$el);
       //                $el = (String)($el);
       //                return $el;
       //              }, $input['channel_type']);
       //       if(count($input['channel_type'])>0)
       //         $uncovered=$uncovered->whereIn('sub_type',$input['channel_type']);
       //    }
       //      if(isset($input['potential_type']))
       //    {
       //         $input['potential_type']=explode(",",$input['potential_type']);
       //         $input['potential_type']= array_map(function($el) {
       //                 $el=str_replace("'","",$el);
       //                $el = (Int)($el);
       //                return $el;
       //              }, $input['potential_type']);
               
       //       if(count($input['potential_type'])>0)
       //         $uncovered=$uncovered->whereIn('fld1923',$input['potential_type']);
       //    }
       //    if(isset($input['status_type']))
       //    {
       //         $input['status_type']=explode(",",$input['status_type']);
       //         $input['status_type']= array_map(function($el) {
       //              $el=str_replace("'","",$el);
       //                $el = (String)($el);
       //                return $el;
       //              }, $input['status_type']);
               
       //       if(count($input['status_type'])>0)
       //         $uncovered=$uncovered->whereIn('status',$input['status_type']);
       //    }
       //     if(isset($input['outlet_type']))
       //     {
       //       $input['outlet_type']=explode(",",$input['outlet_type']);
       //        $input['outlet_type']= array_map(function($el) {
       //                 $el=str_replace("'","",$el);
       //                $el = (Int)($el);
       //                return $el;
       //              }, $input['outlet_type']);
       //         if(isset($input['outlet_type']) && count($input['outlet_type'])>0 && !in_array(2,$input['outlet_type']))
       //           $uncovered=$uncovered->where([['status','=','NO']]);
       //     }
         
          
       // }
     // $uncovered=$uncovered->limit(30)->offset(30);
      $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['status','=','A'],['client_id','=',0]])               
               ->select('outlet_id','outlet_image')
             //  ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
            if(!array_key_exists($data_outlet_imagelist[$i]->outlet_id,$imagelist))
                    $imagelist[$data_outlet_imagelist[$i]->outlet_id]=[];
            array_push($imagelist[$data_outlet_imagelist[$i]->outlet_id],'https://analytics.brandidea.com/bilocaview/public/'.$data_outlet_imagelist[$i]->outlet_image);
            
          }
       // if(isset($input['cluster_id']))
       //   $uncovered=$uncovered->where([['cluster_id','=',$input['cluster_id']]]);
       $uncovered=$uncovered->get();

       $uncovered_count=count($uncovered);
       $cluster_list=[];

       for($k=0;$k<$uncovered_count;$k++)
       {
       
            $temp=[];
            $temp['id']=$uncovered[$k]->refid;
             $temp['apt_for']=$uncovered[$k]->app_status;
            
            $temp['city']=$uncovered[$k]->city;
            $temp['city_id']=$uncovered[$k]->city_id;
            $temp['ward_id']=$uncovered[$k]->loc15;
            $temp['retailer_id']=$uncovered[$k]->retailer_id;
            $temp['contact']=$uncovered[$k]->contact;
            $temp['retailer_name']=$uncovered[$k]->name;
            $temp['nbhrd']=$uncovered[$k]->nbhrd;
            $temp['address']=$uncovered[$k]->address;
            $temp['latitude']=$uncovered[$k]->latitude;
            $temp['longitude']=$uncovered[$k]->longitude;
            $temp['icon']='https://analytics.brandidea.com/bilocaview/public/'.$uncovered[$k]->icon;
            $temp['shop_image']=$uncovered[$k]->shop_image;
            $temp['outlet_status']=$uncovered[$k]->outlet_status;
            $temp['locality_name']=$uncovered[$k]->locality_name;
            $temp['beat_name']=$uncovered[$k]->beat_name;
            $temp['info']=[];
            $temp['picked_shop_image']=(isset($imagelist[$uncovered[$k]->retailer_id])) ? $imagelist[$uncovered[$k]->retailer_id] : [];


             array_push($temp['info'],['key'=>'Name','value'=>$uncovered[$k]->name,'type'=>'text']);
            array_push($temp['info'],['key'=>'Channel','value'=>$uncovered[$k]->type,'type'=>'text']);
            array_push($temp['info'],['key'=>'Sub-Channel','value'=>$uncovered[$k]->sub_type,'type'=>'text']);
             array_push($temp['info'],['key'=>'Address','value'=>$uncovered[$k]->address,'type'=>'text']);
            array_push($message['uncovered'],$temp);
            $temp=[];
            $temp=['row_id'=>$k+1,'retailer_ID'=>$uncovered[$k]->retailer_id,'Name'=>$uncovered[$k]->name,'Type'=>$uncovered[$k]->type,'Sub Type'=>$uncovered[$k]->sub_type,'Potential Status'=>$uncovered[$k]->outlet_status,'Address'=>$uncovered[$k]->address,'Contact'=>$uncovered[$k]->contact,'City'=>$uncovered[$k]->city,'Neighborhood'=>$uncovered[$k]->nbhrd,'Status'=>$uncovered[$k]->outlet_status];
             $temp['info']=[];
             array_push($temp['info'],['key'=>'row_id','value'=>$k+1,'type'=>'number']);
             array_push($temp['info'],['key'=>'retailer_ID','value'=>$uncovered[$k]->retailer_id,'type'=>'number']);
             array_push($temp['info'],['key'=>'Name','value'=>$uncovered[$k]->name,'type'=>'text']);
             array_push($temp['info'],['key'=>'type','value'=>$uncovered[$k]->type,'type'=>'text']);
             array_push($temp['info'],['key'=>'sub_type','value'=>$uncovered[$k]->sub_type,'type'=>'text']);
             array_push($temp['info'],['key'=>'Outlet Potential status','value'=>$uncovered[$k]->outlet_status,'type'=>'text']);
             array_push($temp['info'],['key'=>'Address','value'=>$uncovered[$k]->address,'type'=>'text']);
             array_push($temp['info'],['key'=>'Contact','value'=>$uncovered[$k]->contact,'type'=>'number']);
             array_push($temp['info'],['key'=>'City','value'=>$uncovered[$k]->city,'type'=>'text']);
             array_push($temp['info'],['key'=>'Neighborhood','value'=>$uncovered[$k]->nbhrd,'type'=>'text']);
             array_push($temp['info'],['key'=>'Outlet status','value'=>$uncovered[$k]->outlet_status,'type'=>'text']);
                    array_push($message['tabledata']['value'],$temp);
           
       }
       $heading=implode(",",array_unique(array_column($message['uncovered'], 'nbhrd'))). ' N\'bhrd';
       $message['head']=$heading;

        $message['status']=true;$message['message']='Uncovered Data.';
        return response()->json($message, $this->successStatus);
    }
     public function  hri_action_outlets(Request $request)
    {
       $message=['message'=>'Outlet updated','status'=>true];
       $input = $request->all();
       $retailer_id=$input['retailer_id'];
       $action=$input['action'];
       $lat = $input["lat"];
       $lon = $input["lon"];
       $app_status = $input["apt_for"];


       $message['action_status']= $input["action"];
       date_default_timezone_set("Asia/Kolkata");
       $date = date("Y-m-d H:i:s");
      
        $result = DB::table("0_delhi_uncvrd_outlets")
                ->where("retailer_id", $input["retailer_id"])
                ->update([
                    "status" => $input["action"],
                     "app_status"=> $input["apt_for"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);

        return response()->json($message, $this->successStatus);
    }
    public function  hri_foundaction_outlets(Request $request)
    {
       $message=['message'=>'Outlet updated','status'=>true];
       $input = $request->all();
       $retailer_id=$input['retailer_id'];
       $action=$input['action'];
       $lat = $input["lat"];
       $lon = $input["lon"];
       $message['action_status']= $input["action"];
       date_default_timezone_set("Asia/Kolkata");
       $date = date("Y-m-d H:i:s");
      
        $result = DB::table("0_delhi_uncvrd_outlets")
                ->where("retailer_id", $input["retailer_id"])
                ->update([
                    "app_status" => $input["action"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);

        return response()->json($message, $this->successStatus);
    }
     public function  hri_fmcg_action_outlets(Request $request)
    {
       $message=['message'=>'Outlet updated','status'=>true];
       $input = $request->all();
       $retailer_id=$input['retailer_id'];
       $action=$input['action'];
       $lat = $input["lat"];
       $lon = $input["lon"];
       $app_status = $input["apt_for"];

       $message['action_status']= $input["action"];
       date_default_timezone_set("Asia/Kolkata");
       $date = date("Y-m-d H:i:s");
      
        $result = DB::table("hri_uncvrd_outlets")
                ->where("retailer_id", $input["retailer_id"])
                ->update([
                    "status" => $input["action"],
                    "app_status"=> $input["apt_for"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);

        return response()->json($message, $this->successStatus);
    }
     public function  hri_fmcg_foundaction_outlets(Request $request)
    {
       $message=['message'=>'Outlet updated','status'=>true];
       $input = $request->all();
       $retailer_id=$input['retailer_id'];
       $action=$input['action'];
       $lat = $input["lat"];
       $lon = $input["lon"];
       $message['action_status']= $input["apt_for"];
       date_default_timezone_set("Asia/Kolkata");
       $date = date("Y-m-d H:i:s");
      
        $result = DB::table("hri_uncvrd_outlets")
                ->where("retailer_id", $input["retailer_id"])
                ->update([
                    "app_status" => $input["apt_for"],
                    "user_lat" => $lat,
                    "user_lon" => $lon,
                    "created_date" => $date,
                ]);

        return response()->json($message, $this->successStatus);
    }
    public function  uncovered_outlets(Request $request)
    {
       $message=['covered'=>[],'uncovered'=>[],'tabledata'=>['column'=>['#','Outlet Name','Channel','Address','Estimated Potential','Status'],'value'=>[]]];
       $input = $request->all();
       $beat_list=$input['beat_id'];

     

       if(!isset($input['cluster_id']))
       {
         
         $message['tabledata']=['column'=>['#','Cluster Name','High','Medium','Low','Total'],'value'=>[]];
       }

       $uncovered=DB::table("haldirams_sample_data_new")->select( "id", "refid", "State", "District", "Taluk", "City/Villg", "Sector", "nbrhd_name", "CCP_Name", "address", "latitude", "longitude", "Contact", "Prirotity", "icon", "shop_image", "status",DB::raw("if(status='N','New',if(status='A','Found',if(status='R','Not Found',''))) as outlet_status"),DB::raw("if(fld1923=3,'High',if(fld1923=2,'Medium',if(fld1923=1,'Low',''))) as outlet_potential_status"), "type", "sub_type", "pincode", "beat_id", "fld1923", "city_id", "city", "potential_status","cluster_id");
        if(isset($input['filter']))
       {
           
          if(isset($input['channel_type']))
          {
               $input['channel_type']=explode(",",$input['channel_type']);
               $input['channel_type']= array_map(function($el) {
                       $el=str_replace("'","",$el);
                      $el = (String)($el);
                      return $el;
                    }, $input['channel_type']);
             if(count($input['channel_type'])>0)
               $uncovered=$uncovered->whereIn('sub_type',$input['channel_type']);
          }
            if(isset($input['potential_type']))
          {
               $input['potential_type']=explode(",",$input['potential_type']);
               $input['potential_type']= array_map(function($el) {
                       $el=str_replace("'","",$el);
                      $el = (Int)($el);
                      return $el;
                    }, $input['potential_type']);
               
             if(count($input['potential_type'])>0)
               $uncovered=$uncovered->whereIn('fld1923',$input['potential_type']);
          }
          if(isset($input['status_type']))
          {
               $input['status_type']=explode(",",$input['status_type']);
               $input['status_type']= array_map(function($el) {
                    $el=str_replace("'","",$el);
                      $el = (String)($el);
                      return $el;
                    }, $input['status_type']);
               
             if(count($input['status_type'])>0)
               $uncovered=$uncovered->whereIn('status',$input['status_type']);
          }
           if(isset($input['outlet_type']))
           {
             $input['outlet_type']=explode(",",$input['outlet_type']);
              $input['outlet_type']= array_map(function($el) {
                       $el=str_replace("'","",$el);
                      $el = (Int)($el);
                      return $el;
                    }, $input['outlet_type']);
               if(isset($input['outlet_type']) && count($input['outlet_type'])>0 && !in_array(2,$input['outlet_type']))
                 $uncovered=$uncovered->where([['status','=','NO']]);
           }
         
          
       }
      $uncovered=$uncovered->limit(30)->offset(30);
       // if(isset($input['cluster_id']))
       //   $uncovered=$uncovered->where([['cluster_id','=',$input['cluster_id']]]);
       $uncovered=$uncovered->get();

       $uncovered_count=count($uncovered);
       $cluster_list=[];

       for($k=0;$k<$uncovered_count;$k++)
       {

        if(!isset($input['cluster_id']))
        {
           

            if(!array_key_exists($uncovered[$k]->cluster_id,$cluster_list))
            {
                $cluster_list[$uncovered[$k]->cluster_id]['cluster_id']=$uncovered[$k]->cluster_id;
                $cluster_list[$uncovered[$k]->cluster_id]['color']='#fff';
                $cluster_list[$uncovered[$k]->cluster_id]['cluster_size']=0;
                $cluster_list[$uncovered[$k]->cluster_id]['High']=0;
                $cluster_list[$uncovered[$k]->cluster_id]['Low']=0;
                $cluster_list[$uncovered[$k]->cluster_id]['Medium']=0;
                $cluster_list[$uncovered[$k]->cluster_id]['retailer_list']=[];
                $cluster_list[$uncovered[$k]->cluster_id]['retailer_location']=[];

            }
            $cluster_list[$uncovered[$k]->cluster_id]['cluster_size']++;
            $cluster_list[$uncovered[$k]->cluster_id][$uncovered[$k]->outlet_potential_status]++;
            array_push($cluster_list[$uncovered[$k]->cluster_id]['retailer_location'],['lat'=>$uncovered[$k]->latitude,'lng'=>$uncovered[$k]->longitude]);
            
        }


            $temp=[];
            $temp['id']=$uncovered[$k]->refid;
            $temp['city']=$uncovered[$k]->city;
            $temp['city_id']=$uncovered[$k]->city_id;
            $temp['sector']=$uncovered[$k]->Sector;
            $temp['nbrhd_name']=$uncovered[$k]->nbrhd_name;
            $temp['retailer_name']=$uncovered[$k]->CCP_Name;
            // $temp['cluster_id']=$uncovered[$k]->cluster_id;
            $temp['address']=$uncovered[$k]->address;
            $temp['latitude']=$uncovered[$k]->latitude;
            $temp['longitude']=$uncovered[$k]->longitude;
            $temp['icon']='https://analytics.brandidea.com/bilocaview/public/'.$uncovered[$k]->icon;
            $temp['shop_image']=$uncovered[$k]->shop_image;
            $temp['outlet_status']=$uncovered[$k]->outlet_status;
            $temp['outlet_potential_status']=$uncovered[$k]->outlet_potential_status;
            $temp['type']=$uncovered[$k]->type;
            $temp['sub_type']=$uncovered[$k]->sub_type;
            $temp['potential_status']=$uncovered[$k]->potential_status;
             if(!isset($input['cluster_id']))
                  array_push($cluster_list[$uncovered[$k]->cluster_id]['retailer_list'],$temp);
             else
                  array_push($message['uncovered'],$temp);

            if(isset($input['cluster_id'])) 
            {
                 $temp=[];
                 $temp=['row_id'=>$k+1,'retailer_name'=>$uncovered[$k]->CCP_Name,'type'=>$uncovered[$k]->type,'address'=>$uncovered[$k]->address,'outlet_potential_status'=>$uncovered[$k]->outlet_potential_status,'outlet_status'=>$uncovered[$k]->outlet_status];
                    array_push($message['tabledata']['value'],$temp);
            }
           
       }
       if(!isset($input['cluster_id']))
       {
            $count=1;
            foreach($cluster_list as $k=>$v)
            {
                 $coordinate=self::get_center($v['retailer_location']);
                 $cluster_list[$k]['latitude']=$coordinate[0];
                 $cluster_list[$k]['longitude']=$coordinate[1];
                 unset($cluster_list[$k]['retailer_location']);
                
                 $temp=[];
                 $temp=['row_id'=>$count,'cluster_name'=>'Cluster '.$k,'high'=>$v['High'],'medium'=>$v['Medium'],'low'=>$v['Low'],'total'=>$v['cluster_size']];
                    array_push($message['tabledata']['value'],$temp);

                $count++;
            }
            $message['uncovered']=array_values($cluster_list);
            
       }
       $message['head']='';

        $message['status']=true;$message['message']='Uncovered Data.';
        return response()->json($message, $this->successStatus);
    }
      public function hri_uncovered_outlets(Request $request)
    {
         $input = $request->all();
       $message=['covered'=>[],'uncovered'=>[],'ward_id'=>[$input['ward_id']],'tabledata'=>['column'=>['#','Retailer ID','Name','Sub type','Potential Status','Address','Contact','City','Neighborhood','Status'],'value'=>[]]];

      
       $beat_list=explode(",",$input['ward_id']);

      $covered_sql="SELECT `refid`,  `loc12`,`beat_id`, `loc13`, `loc14`, `loc15`, `loc16`, `loc25`, `mapping_id`, `division`, `zone`, `state`, `mapped_user_name`, `fld2020`, `desination`, `fld2018`, `beat_name`, `area_name`, `name`, `latitude`, `longitude`, `fld2019`, `outet_classification`,  `city_name`,channel_type,address  FROM `hri_mumbai_andheri_outlet_master` where stat='A' and latitude!=0 and longitude!=0 and beat_id in (".implode(',',$beat_list).") order by refid asc";
   
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);


         $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {

                $temp=[];
                
              $temp['icon']='images/default_covered.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
               $temp['retailer_name']=$covered_res[$s]['name'];
                $temp['address']=$covered_res[$s]['address'];
              $temp['info']=[];
          
              array_push($temp['info'],['key'=>'Neighborhood','value'=>$covered_res[$s]['beat_name'],'type'=>'text']);
              array_push($temp['info'],['key'=>'City','value'=>$covered_res[$s]['city_name'],'type'=>'text']);
              array_push($temp['info'],['key'=>'Sub Channel','value'=>$covered_res[$s]['channel_type'],'type'=>'text']);
               array_push($temp['info'],['key'=>'Name','value'=>$covered_res[$s]['name'],'type'=>'text']);
               array_push($temp['info'],['key'=>'Address','value'=>$covered_res[$s]['address'],'type'=>'text']);

              

                 array_push($message['covered'],$temp);
        }


      
       $uncovered=DB::table("hri_uncvrd_outlets")->select( "refid", "retailer_id", "name", "type", "sub_type", "outlet_potential", "app_status","fld1923", "address", "contact", "latitude", "longitude", "city","city_id",   "nbhrd", "locality_name", "beat_id","nbhrd as beat_name", "rd_code", "rd_name", "beat_choco_consmptn", "beat_biscuit_consmptn", "beat_confec_consmptn", "beat_premium_index", "beat_snacking_index", "loc16","status","stat",DB::raw("if(status='N','New',if(status='A','Found',if(status='R','Not Found',''))) as outlet_status"),"icon","shop_image",DB::raw("if(fld1923=3,'High',if(fld1923=2,'Medium',if(fld1923=1,'Low',''))) as potential_status"))->whereIn("beat_id",$beat_list);
        if(isset($input['filter']))
       {
          
          if(isset($input['channel_type']))
          {
               $input['channel_type']=explode(",",$input['channel_type']);
               $input['channel_type']= array_map(function($el) {
                       $el=str_replace("'","",$el);
                      $el = (String)($el);
                      return $el;
                    }, $input['channel_type']);
             if(count($input['channel_type'])>0)
               $uncovered=$uncovered->whereIn('sub_type',$input['channel_type']);
          }
            if(isset($input['potential_type']))
          {
               $input['potential_type']=explode(",",$input['potential_type']);
               $input['potential_type']= array_map(function($el) {
                       $el=str_replace("'","",$el);
                      $el = (Int)($el);
                      return $el;
                    }, $input['potential_type']);
               
             if(count($input['potential_type'])>0)
               $uncovered=$uncovered->whereIn('fld1923',$input['potential_type']);
          }
          if(isset($input['status_type']))
          {
               $input['status_type']=explode(",",$input['status_type']);
               $input['status_type']= array_map(function($el) {
                    $el=str_replace("'","",$el);
                      $el = (String)($el);
                      return $el;
                    }, $input['status_type']);
               
             if(count($input['status_type'])>0)
               $uncovered=$uncovered->whereIn('status',$input['status_type']);
          }
           
         
          
       }
      $uncovered=$uncovered->limit(30)->offset(30);
       // if(isset($input['cluster_id']))
       //   $uncovered=$uncovered->where([['cluster_id','=',$input['cluster_id']]]);
       $uncovered=$uncovered->get();

      
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['status','=','A'],['client_id','=',0]])               
               ->select('outlet_id','outlet_image')
             //  ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
            if(!array_key_exists($data_outlet_imagelist[$i]->outlet_id,$imagelist))
                    $imagelist[$data_outlet_imagelist[$i]->outlet_id]=[];
            array_push($imagelist[$data_outlet_imagelist[$i]->outlet_id],'https://analytics.brandidea.com/bilocaview/public/'.$data_outlet_imagelist[$i]->outlet_image);
            
          }
      if(isset($input['outlet_type']))
       {
         $input['outlet_type']=explode(",",$input['outlet_type']);
         if(!in_array(1,$input['outlet_type']))
             $message['covered']=[];
         if(!in_array(2,$input['outlet_type']))
             $uncovered=[];
          

          
       }
        $uncovered_count=count($uncovered);
       for($k=0;$k<$uncovered_count;$k++)
       {

            $temp=[];
            $temp['retailer_id']=$uncovered[$k]->retailer_id;
            $temp['apt_for']=$uncovered[$k]->app_status;
            $temp['beat_id']=$uncovered[$k]->beat_id;
            $temp['beat_name']=$uncovered[$k]->beat_name;
            $temp['retailer_name']=$uncovered[$k]->name;
            $temp['address']=$uncovered[$k]->address;
            $temp['latitude']=$uncovered[$k]->latitude;
            $temp['longitude']=$uncovered[$k]->longitude;
            $temp['icon']='https://analytics.brandidea.com/bilocaview/public/'.$uncovered[$k]->icon;
             if($uncovered[$k]->status=='A')
                $temp['icon']='https://analytics.brandidea.com/bilocaview/public/images/uncovered.png';
              if($uncovered[$k]->status=='NF')
                $temp['icon']='https://analytics.brandidea.com/bilocaview/public/images/nr.png';
            $temp['shop_image']=$uncovered[$k]->shop_image;
            $temp['outlet_status']=$uncovered[$k]->status;
            $temp['type']=$uncovered[$k]->type;
            $temp['sub_type']=$uncovered[$k]->sub_type;
            $temp['info']=[];
             array_push($temp['info'],['key'=>'Name','value'=>$uncovered[$k]->name,'type'=>'text']);
             
             array_push($temp['info'],['key'=>'Neighborhood','value'=>$uncovered[$k]->nbhrd,'type'=>'text']);
             array_push($temp['info'],['key'=>'City','value'=>$uncovered[$k]->city,'type'=>'text']);
             array_push($temp['info'],['key'=>'Sub-Channel','value'=>$uncovered[$k]->sub_type,'type'=>'text']);
             array_push($temp['info'],['key'=>'Address','value'=>$uncovered[$k]->address,'type'=>'text']);
             array_push($temp['info'],['key'=>'Contact','value'=>$uncovered[$k]->contact,'type'=>'phone']);
             array_push($temp['info'],['key'=>'Outlet Potential','value'=>$uncovered[$k]->outlet_potential,'type'=>'text']);
             array_push($temp['info'],['key'=>'Outlet Potential','value'=>$uncovered[$k]->outlet_potential,'type'=>'text']); 
              $temp['picked_shop_image']=(isset($imagelist[$uncovered[$k]->retailer_id])) ? $imagelist[$uncovered[$k]->retailer_id] : [];
            array_push($message['uncovered'],$temp);
             $temp=[];
                 $temp=['row_id'=>$k+1,'retailer_ID'=>$uncovered[$k]->retailer_id,'Name'=>$uncovered[$k]->name,'sub_type'=>$uncovered[$k]->sub_type,'outlet_potential_status'=>$uncovered[$k]->potential_status,'address'=>$uncovered[$k]->address,'contact'=>$uncovered[$k]->contact,'city'=>$uncovered[$k]->city,'neighborhood'=>$uncovered[$k]->nbhrd,'outlet_status'=>$uncovered[$k]->outlet_status];
                  
            $temp['info']=[];
             array_push($temp['info'],['key'=>'row_id','value'=>$k+1,'type'=>'number']);
             array_push($temp['info'],['key'=>'retailer_ID','value'=>$uncovered[$k]->retailer_id,'type'=>'number']);
             array_push($temp['info'],['key'=>'Name','value'=>$uncovered[$k]->name,'type'=>'text']);
             array_push($temp['info'],['key'=>'sub_type','value'=>$uncovered[$k]->sub_type,'type'=>'text']);
             array_push($temp['info'],['key'=>'Outlet Potential status','value'=>$uncovered[$k]->potential_status,'type'=>'text']);
             array_push($temp['info'],['key'=>'Address','value'=>$uncovered[$k]->address,'type'=>'text']);
             array_push($temp['info'],['key'=>'Contact','value'=>$uncovered[$k]->contact,'type'=>'number']);
             array_push($temp['info'],['key'=>'City','value'=>$uncovered[$k]->city,'type'=>'text']);
             array_push($temp['info'],['key'=>'Neighborhood','value'=>$uncovered[$k]->nbhrd,'type'=>'text']);
             array_push($temp['info'],['key'=>'Outlet status','value'=>$uncovered[$k]->outlet_status,'type'=>'text']);
             array_push($message['tabledata']['value'],$temp); 
       }
        if((count($uncovered) > 0))
        {
             $message['status']=true;$message['message']=((count($uncovered) > 0) ? $uncovered[0]->nbhrd : '').'  N\'bhrd Uncovered Data.';
        }
        else
        {
             $message['status']=true;$message['message']='Data not available';
        }
       
        return response()->json($message, $this->successStatus);
    }

  
    public static function get_center($coords)
    {
        $count_coords = count($coords);
        $xcos=0.0;
        $ycos=0.0;
        $zsin=0.0;
        
            foreach ($coords as $lnglat)
            {
                $lat = $lnglat['lat'] * pi() / 180;
                $lon = $lnglat['lng'] * pi() / 180;
                
                $acos = cos($lat) * cos($lon);
                $bcos = cos($lat) * sin($lon);
                $csin = sin($lat);
                $xcos += $acos;
                $ycos += $bcos;
                $zsin += $csin;
            }
        
        $xcos /= $count_coords;
        $ycos /= $count_coords;
        $zsin /= $count_coords;
        $lon = atan2($ycos, $xcos);
        $sqrt = sqrt($xcos * $xcos + $ycos * $ycos);
        $lat = atan2($zsin, $sqrt);
        
        return array($lat * 180 / pi(), $lon * 180 / pi());
    }
    public function getfilter_param(Request $req)
    {
        $message=['outlet_type'=>[],'channel_type'=>[],'potential_type'=>[],'status_type'=>[]];
        $input = $req->all();
        $user = Auth::user();
        $client_id = $user->client_id;
        $getdata_tbl=[1000=>'haldirams_sample_data_cluster'];
        if(in_array($client_id,[0,1000]))
        {
            $message['outlet_type']=[['id'=>1,'name'=>'Covered'],['id'=>2,'name'=>'Uncovered']];
            $message['potential_type']=[['id'=>1,'name'=>'Low'],['id'=>2,'name'=>'Medium'],['id'=>3,'name'=>'High']];
            $message['status_type']=[['id'=>'A','name'=>'Found'],['id'=>'R','name'=>'Not Found'],['id'=>'N','name'=>'Not Visited']];
            $channel=DB::table($getdata_tbl[$client_id])->select(['sub_type as name'])->distinct()->get();
            for($i=0;$i<count($channel);$i++)
                array_push($message['channel_type'],['name'=>$channel[$i]->name]);
            $message['status']=true;$message['message']='Filter Param';
            return response()->json($message, $this->successStatus);


        }
        $message['status']=false;$message['message']='No Data Available';
         return response()->json($message, $this->failure);
         


    }
   
      public function addoutlet_image(Request $request)
    {

        $input = $request->all();
        $user = Auth::user();
        $userid=$user->id;
        $client_id=$user->client_id;

        
        $message = ['status'=>true,'message'=>'Image Upload successfully.'];
        $message['picked_shop_image']=[];
        $date = date("Y-m-d H:i:s");
       
        $data = $request->img;
        // var_dump($data);die;

        //    list($type, $data) = explode(';', $data);
        //     list(, $data)      = explode(',', $data);
        
        $data = base64_decode($data);
       

         $imageName=date("d-m-y") .rand().'_mobileupload.jpg';
        file_put_contents('shop_image/'.$imageName, $data);  
         $path = 'shop_image/'.$imageName;

        if (isset($request->img)) {
            
                if ($path) {
                    $result = DB::table("jj_outlet_image")->insert([
                        [
                            "outlet_id" => $input["retailer_id"],
                            "user_id" => $userid,
                            "client_id" => $client_id,
                            "outlet_image" => $path,
                            "created_date" => $date,
                            "status" => "A",
                        ],
                    ]);
                }
            if ($path) {
                $message["status"] = true;
                $message["msg"] = "Outlet added successfully";
            }
        } else {
            $message["status"] = false;
            $message["msg"] = "Upload the Image";
        }
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['status','=','A'],['client_id','=',0],['outlet_id','=',$input['retailer_id']]])
               ->select('outlet_id','outlet_image')
              // ->groupBy('outlet_id')
               ->get();

         $imagelist=[];
         $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
            $message['picked_shop_image'][$i]='https://analytics.brandidea.com/bilocaview/public/'.$data_outlet_imagelist[$i]->outlet_image;
            
          }
        
        return json_encode($message);
    }
     public function ooh_outlets(Request $request)
    {
       $message=['outlet_list'=>[],'map_list'=>[],'tabledata'=>['column'=>['#','Name','Address','SubD Name','SubD Code','Market UID','Outlet Potential (Nos.)','MDLZ Cvrg Nos','Population (Nos.)','Villg. Choc Consumption (Annual) (Rs.)'],'value'=>[]]];
        $input = $request->all();
      
        $sql="SELECT  `refid`, `name`, `address`, `shop_image`, `subd_code`, `subd_name`, `state_name`, `district_name`, `taluk_name`, `city_village_name`, `loc14`, `rpi`, `sector`, `2011_census`, `market_UID`, `fmcg_retlr_univ_nos`, `mdlz_cvrg_nos`, `choc_consptn`, `popn`, `latitude`, `longitude`, `icon`,if(status='N','New',if(status='A','Found',if(status='NF','Not Found',''))) as status FROM `ooh_data`";
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);

         $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['status','=','A']])               
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
       

       $uncovered_count=count($res);
       $cluster_list=[];

       for($s=0;$s<$uncovered_count;$s++)
       {

            $temp=[];
            $temp['retailer_id']=$res[$s]['refid'];             
            $temp['address']=$res[$s]['address'];               
            $temp['status']=$res[$s]['status']; 
            $temp['latitude']=$res[$s]['latitude'];
            $temp['longitude']=$res[$s]['longitude'];
            $temp['icon']='https://analytics.brandidea.com/bilocaview/public/'.$res[$s]['icon'];
            $style_code='';$found='';$not_found='';
            $found=($res[$s]['status']=='A') ? 'checked' : '';
            $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
            if($res[$s]['status']=='A')
                $temp['icon']='https://analytics.brandidea.com/bilocaview/public/images/uncovered.png';
            if($res[$s]['status']=='NF')
                $temp['icon']='https://analytics.brandidea.com/bilocaview/public/images/nr.png';
            $temp['cicle_count']=(isset($imagelist[$res[$s]['refid']])) ? $imagelist[$res[$s]['refid']] : 0;
            $temp['info']=[];
            array_push($temp['info'],['key'=>'Address','value'=>$res[$s]['address'],'type'=>'text']);
          
            array_push($temp['info'],['key'=>'Population (Nos.)','value'=>number_format($res[$s]['popn'],0),'type'=>'text']);
            array_push($temp['info'],['key'=>'Outlet Potential (Nos.)','value'=>number_format($res[$s]['fmcg_retlr_univ_nos'],0),'type'=>'text']);
            array_push($temp['info'],['key'=>'MDLZ Cvrg Nos','value'=>number_format($res[$s]['mdlz_cvrg_nos'],0),'type'=>'text']);
      
            array_push($temp['info'],['key'=>'Villg. Choc Consumption (Annual) (Rs.)','value'=>number_format($res[$s]['choc_consptn'],0),'type'=>'img']);
         array_push($temp['info'],['key'=>'Subrd Name','value'=>$res[$s]['subd_name'],'type'=>'text']);
         array_push($temp['info'],['key'=>'Subrd Code','value'=>$res[$s]['subd_code'],'type'=>'text']);

         array_push($temp['info'],['key'=>'Market UID','value'=>$res[$s]['market_UID'],'type'=>'text']);

                  array_push($message['outlet_list'],$temp);

           
                $temp=[];
               
                 $temp=['row_id'=>$s+1,'retailer_name'=>$res[$s]['name'],'address'=>$res[$s]['address'],'subd_name'=>$res[$s]['subd_name'],'subd_code'=>$res[$s]['subd_code'],'Market_UID'=>$res[$s]['market_UID'],'fmcg_retailer_universe'=>number_format($res[$s]['fmcg_retlr_univ_nos'],0),'mdlz_cvrg_nos'=>number_format($res[$s]['mdlz_cvrg_nos'],0),'choc_consptn'=>number_format($res[$s]['choc_consptn'],0),'population'=>number_format($res[$s]['popn'],0)];
                    array_push($message['tabledata']['value'],$temp);
          
           
       }
     
       $message['head']='';

        $message['status']=true;$message['message']='Uncovered Data.';
        return response()->json($message, $this->successStatus);
    }
     public function getfilter_hriparam(Request $req)
    {
        $message=['outlet_type'=>[],'channel_type'=>[],'potential_type'=>[],'status_type'=>[]];
        $input = $req->all();
        $user = Auth::user();
        $client_id = $user->client_id;
       
       // if(in_array($client_id,[0,1000]))
       // {
            $message['outlet_type']=[['id'=>1,'name'=>'Covered'],['id'=>2,'name'=>'Uncovered']];
            $message['potential_type']=[['id'=>1,'name'=>'Low'],['id'=>2,'name'=>'Medium'],['id'=>3,'name'=>'High']];
            $message['status_type']=[['id'=>'A','name'=>'Found'],['id'=>'R','name'=>'Not Found'],['id'=>'N','name'=>'Not Visited']];
            $channel=DB::table('hri_uncvrd_outlets')->select(['sub_type as name'])->distinct()->get();
            for($i=0;$i<count($channel);$i++)
                array_push($message['channel_type'],['name'=>$channel[$i]->name]);
            $message['status']=true;$message['message']='Filter Param';
            return response()->json($message, $this->successStatus);


       // }
        $message['status']=false;$message['message']='No Data Available';
         return response()->json($message, $this->failure);
         


    }




}