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

    public function uncovered_outlets(Request $request)
    {
       $message=['covered'=>[],'uncovered'=>[],'tabledata'=>['column'=>['#','Outlet Name','Channel','Address','Estimated Potential','Status'],'value'=>[]]];
       $input = $request->all();
       $beat_list=$input['beat_id'];

     

       if(!isset($input['cluster_id']))
       {
         
         $message['tabledata']=['column'=>['#','Cluster Name','High','Medium','Low','Total'],'value'=>[]];
       }

       $uncovered=DB::table("haldirams_sample_data_cluster")->select( "id", "refid", "State", "District", "Taluk", "City/Villg", "Sector", "nbrhd_name", "CCP_Name", "address", "latitude", "longitude", "Contact", "Prirotity", "icon", "shop_image", "status",DB::raw("if(status='N','New',if(status='A','Found',if(status='R','Not Found',''))) as outlet_status"),DB::raw("if(fld1923=3,'High',if(fld1923=2,'Medium',if(fld1923=1,'Low',''))) as outlet_potential_status"), "type", "sub_type", "pincode", "beat_id", "fld1923", "city_id", "city", "potential_status","cluster_id")->whereIn('beat_id',$beat_list);
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

       if(isset($input['cluster_id']))
         $uncovered=$uncovered->where([['cluster_id','=',$input['cluster_id']]]);

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
            $temp['cluster_id']=$uncovered[$k]->cluster_id;
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
       $message['head']='Cluster '.implode(",",array_unique(array_column($message['uncovered'],'cluster_id')));

        $message['status']=true;$message['message']='Uncovered Data.';
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



}