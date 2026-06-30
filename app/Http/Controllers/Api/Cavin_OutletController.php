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

class Cavin_OutletController extends Controller
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
        $getBeat=BeatMaster::select("beat_master.id","beat_master.beat_name")->distinct()->join('97_uncovered_outlets as b','beat_master.id','=','b.beat_id')->where([['beat_master.client_id','=',$client_id]])->get();
        $message=['status'=>true,'message'=>'BeatList Data.','data'=>[]];
        $message['data']=$getBeat;
        return response()->json($message, $this->successStatus);

    }

    public function uncovered_outlets(Request $request)
    {
       $message=['covered'=>[],'uncovered'=>[],'tabledata'=>['column'=>['#','Outlet Name','Channel','Address','Estimated Potential','Status'],'value'=>[]]];
       $input = $request->all();
       $beat_list=$input['beat_id'];


       $uncovered=DB::table("97_uncovered_outlets")->select( "refid",  "fld189", "fld1586", "sub_type_id", "fld1054", "rtlr_id", "client_id", "address","contact_no", "latitude", "longitude", "Estimtd_potntl", "catgrys_sell", "remarks", "fld1923", "stat", "beat_id", "salesman_id", "beat_code", "beat_name", "sales_rep_code", "sales_rep_name", "status", "maintype_id", "maintype_icon", "main_type", "subtype", "ccp", "potential_store",DB::raw("if(status='N','New',if(status='A','Found',if(status='R','Not Found',''))) as outlet_status"),DB::raw("if(fld1923=3,'High',if(fld1923=2,'Medium',if(fld1923=1,'Low',''))) as outlet_potential_status"))->whereIn('beat_id',$beat_list);
     
       $uncovered=$uncovered->get();
       

       $uncovered_count=count($uncovered);
       $cluster_list=[];

       for($k=0;$k<$uncovered_count;$k++)
       {

        
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