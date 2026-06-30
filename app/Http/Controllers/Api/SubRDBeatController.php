<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\SubRDOutlet;
use App\Http\Controllers\CommonController;

class SubRDBeatController extends Controller
{
    public $successStatus = 200;
    public $filenotfound = 404;
    public $failure =500;
    private $isolate=[166, 63, 26];
    private $low=[5,69,54];
    private $high=[151,83,34];
  
    public function getSubRDBeats(Request $request)
    {
         $subrd = [];
         $subrd = ['maplist'=>[],'beatlist'=>[],
            'tabledata'=> [
                'column'=> [
                '#','SubRD Market-UID','SubRD Code','SubRD Name','SubRD District','SubRD Sub-Distt','SubRD Village','Beat','Beat Unique ID','Village Market-UID','Visit Order','Sub-Distt','District','State','One Way Distance (Kms) Between Villages','One Way Travelling Time between villages (Mins)','One Way Distance Covered (Kms) per Beat','No. of Outlets in each Village','Total Outlets Covered per Beat','No. of wholesalers in each Village','No. of VisiCoolers in each Village','No. of Wholesalers per Beat','No. of VisiCooler Outlets Per Beat','SubRD Type','Assumed Overall Time (Hrs)','Classification'],
                'value'=>[]
            ]
        ];

        $subrd['subrd_retailer']=[];
        $subrd['subrd_list']=[];
        $value_data=[];

        //$input_query=json_decode($input['input']);
        $inputSubrdDist = ($request->get('subrd_district') !== null && $request->get('subrd_district') !== '') ? explode(',',$request->get('subrd_district')) : '';
        $inputSubrd = ($request->get('subrd') !== null && $request->get('subrd') !== '') ? explode(',',$request->get('subrd')) : '';
         $inputBeatUniqueId = ($request->get('beat_unique_id') !== null && $request->get('beat_unique_id') !== '') ? explode(',',$request->get('beat_unique_id')) : '';

        $user = auth()->user();
        $userid = $user->id;
        $subrd_id=[];$legend=[];

        $qSubrd = SubRDOutlet::select("subrd_outlet.village_name as village","subrd_outlet.refid","subrd_outlet.subrd_code","subrd_outlet.subrd_village","subrd_outlet.subrd_name","subrd_outlet.subrd_id","subrd_outlet.subrd_district","subrd_outlet.subrd_taluk","subrd_outlet.created_date","subrd_outlet.subrd_latitude","subrd_outlet.subrd_longitude","subrd_outlet.beat_id","subrd_outlet.beat_unique_id","subrd_outlet.village_market_id","subrd_outlet.village_state","subrd_outlet.village_district","subrd_outlet.village_taluk","subrd_outlet.oneway_distance","subrd_outlet.beatween_distance","subrd_outlet.oneway_distance_per_beat","subrd_outlet.covered_outlets_beat","subrd_outlet.covered_outlets","subrd_outlet.covered_wholesaler","subrd_outlet.covered_wholesaler_beat","subrd_outlet.covered_visicooler","subrd_outlet.covered_visicooler_beat","subrd_outlet.subrd_type","subrd_outlet.overall_time","subrd_outlet.stat","subrd_outlet.tsm_id","subrd_outlet.loc7",DB::raw("if(subrd_outlet.sector='Rural',concat(subrd_outlet.village_name,' Villg.'),if(subrd_outlet.sector='Urban',concat(subrd_outlet.village_name,' Town'),subrd_outlet.village_name)) as village_name"),"subrd_outlet.visit_order","subrd_outlet.village_latitude","subrd_outlet.village_longitude","subrd_outlet.village_id","b.beat_name","b.refid as beat","b.beat_unique_id","b.beat_file","b.state_id","b.stat","b.premium_id","b.covered_village","b.covered_wholesaler as beat_wholesaler","b.covered_cooler_outlets","b.premium","b.bi_premium")
            ->join("subrd_beat_master as b","subrd_outlet.beat_id","=","b.refid")
            // ->where("b.stat","=","A");
        
            ->where("b.stat","=","A");
        
        if($request->get('subrd') !== null && $request->get('subrd') !== ''){
            $qSubrd->whereIn("subrd_outlet.subrd_id",$inputSubrd);       
        }        
        else if($request->get('subrd_district') !== null && $request->get('subrd_district') !== '')
        {
            $qSubrd->whereIn("subrd_outlet.loc9",$inputSubrdDist);
        }
        else if($request->get('beat_unique_id') !== null && $request->get('beat_unique_id') !== '')
        {
            $qSubrd->whereIn("subrd_outlet.beat_unique_id",$inputBeatUniqueId);
        }
        
        $qSubrd->orderByDesc("b.beat_name");
        
       // DB::enableQueryLog();
        $res = $qSubrd->get()->toArray();
        // echo '<pre>';
        // var_dump($res);
        // dd(DB::getQueryLog());
        
        $message=[];
        $sub=[];

        $dist_list=['dist'=>[],'subrd'=>[]];
        $total_potential=count($res);
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $type_subrd=[1=>'Actual',2=>'Assumed'];
        $test=['Inefficient'=>3,'No visit'=>3,'Premium'=>0,'Very Good'=>0,'Medium'=>1,'Average'=>1,'Van Beat'=>2,'Good'=>2];

        $subrd_arr=range(0,30);$colorval=0;$premium=[];
        $insertedBeats = [];
        for($s=0;$s<$total_potential;$s++)
        {
            
            $val_data=[];
            $val_data['row_id']=$s+1;
            $val_data['subrd_id']=$res[$s]['subrd_id'];
            $val_data['subrd_code']=$res[$s]['subrd_code'];
            $val_data['subrd_name']=ucwords(strtolower($res[$s]['subrd_name']));
            $val_data['subrd_district']=$res[$s]['subrd_district'];
            $val_data['subrd_taluk']=$res[$s]['subrd_taluk'];
            $val_data['village_name']=$res[$s]['village_name'];
            $val_data['beat_name']=$res[$s]['beat_name'];
            $val_data['beat_unique_id']=$res[$s]['beat_unique_id'];
            $val_data['village_market_id']=$res[$s]['village_market_id'];
            $val_data['visit_order']=$res[$s]['visit_order'];
             $val_data['village_taluk']=$res[$s]['village_taluk'];
            $val_data['village_district']=$res[$s]['village_district'];
            $val_data['village_state']=$res[$s]['village_state'];
            $val_data['oneway_distance']=$res[$s]['oneway_distance'];
            $val_data['beatween_distance']=$res[$s]['beatween_distance'];
            $val_data['oneway_distance_per_beat']=$res[$s]['oneway_distance_per_beat'];
             $val_data['covered_outlets']=$res[$s]['covered_outlets'];
            $val_data['covered_village']=$res[$s]['covered_village'];
            $val_data['covered_wholesaler']=$res[$s]['covered_wholesaler'];
            $val_data['covered_visicooler']=$res[$s]['covered_visicooler'];
            $val_data['beat_wholesaler']=$res[$s]['beat_wholesaler'];
            $val_data['covered_cooler_outlets']=$res[$s]['covered_cooler_outlets'];
            $val_data['subrd_type']=$type_subrd[$res[$s]['subrd_type']];
            $val_data['overall_time']=$res[$s]['overall_time'];
            $val_data['premium']=$res[$s]['bi_premium'];
            
            array_push($subrd['tabledata']['value'],$val_data);
            $loadmap ="https://analytics.brandidea.com/mapshapes/subrd_beats/".$res[$s]['loc7']."/sub_code_".$res[$s]['subrd_code'].".geojson";
            if (!in_array($loadmap, $subrd["maplist"])) {
                array_push($subrd["maplist"], $loadmap);
            }
            
            array_push($dist_list['dist'],$res[$s]['village_district']);
            array_push($dist_list['subrd'],$res[$s]['subrd_name']);

            if(!in_array($res[$s]['premium'], $premium))
            {
                array_push($premium,$res[$s]['premium']);
               
                $colorval++;
                //echo $res[$s]['premium'];exit;
                $sub[$res[$s]['premium']]=CommonController::split_color_variation_beat($test[$res[$s]['premium']]);
                $legend[$test[$res[$s]['premium']]]=[ucwords(strtolower($res[$s]['premium']))=>$sub[$res[$s]['premium']]['hex']];

               // $legend[ucwords(strtolower($res[$s]['premium']))]=$sub[$res[$s]['premium']]['hex'];
            }

            if(!array_key_exists($res[$s]['beat_unique_id'], $insertedBeats))
            {
                array_push($insertedBeats,$res[$s]['beat_unique_id']);
                $beat_id=$res[$s]['beat_unique_id'];
                $tempSubBeat=[];
                $tempSubBeat['beat_id']=$res[$s]['beat_id'];   
                $tempSubBeat['beat_name']=$res[$s]['beat_name'];                
                $tempSubBeat['beat_unique_id']=$res[$s]['beat_unique_id'];
                $tempSubBeat['covered_village']=$res[$s]['covered_village'];
                $tempSubBeat['covered_wholesaler']=$res[$s]['covered_wholesaler'];
                $tempSubBeat['premium']=$res[$s]['premium'];
                $tempSubBeat['bi_premium']=$res[$s]['bi_premium'];
                $tempSubBeat['color']=$sub[$res[$s]['premium']]['hex'];
                
        

                $tempSubBeat['info'] = [];
                array_push($tempSubBeat['info'],array(
                    "key" => "Beat Name",
                    "value" => $res[$s]['beat_name'],
                    "type" => "text"
                ));

                array_push($tempSubBeat['info'],array(
                    "key" => "State",
                    "value" => $res[$s]['village_state'],
                    "type" => "text"
                ));

                array_push($tempSubBeat['info'],array(
                    "key" => "District",
                    "value" => $res[$s]['village_district'],
                    "type" => "text"
                ));

                array_push($tempSubBeat['info'],array(
                    "key" => "Taluk",
                    "value" => $res[$s]['village_taluk'],
                    "type" => "text"
                ));

                array_push($tempSubBeat['info'],array(
                    "key" => "Covered Outlets",
                    "value" => $res[$s]['covered_outlets_beat'].' Nos',
                    "type" => "number"
                ));

                array_push($tempSubBeat['info'],array(
                    "key" => "Covered Wholesaler",
                    "value" => $res[$s]['covered_wholesaler_beat'].' Nos',
                    "type" => "number"
                ));

                array_push($tempSubBeat['info'],array(
                    "key" => "Classification",
                    "value" => $res[$s]['bi_premium'],
                    "type" => "text"
                ));

                array_push($subrd['beatlist'],$tempSubBeat);
            }

            if(!in_array($res[$s]['subrd_id'], $subrd_id))
            {
                array_push($subrd_id,$res[$s]['subrd_id']);
                $temp=[];
                $temp['subrd_name']=$res[$s]['subrd_name'];         
                $temp['subrd_code']=$res[$s]['subrd_code'];                
                $temp['type']=$type_subrd[$res[$s]['subrd_type']];
                $temp['latitude']=$res[$s]['subrd_latitude'];
                $temp['longitude']=$res[$s]['subrd_longitude'];
                $temp['beat_id']=$res[$s]['beat_id'];
                $temp['beat_unique_id']=$res[$s]['beat_unique_id'];
                $temp['color']='#3cb64a';
                $temp['icon']='highway/actual_subrd.png'; 
                $temp['State']=$res[$s]['village_state'];
                $temp['District']=$res[$s]['subrd_district'];
                $temp['Taluk']=$res[$s]['subrd_taluk'];
                $temp['Village']=$res[$s]['subrd_village'];
                
                $temp['info'] = [];
                array_push($temp['info'],array(
                    "key" => "Subrd Name",
                    "value" => $res[$s]['subrd_name'],
                    "type" => "text"
                ));

                array_push($temp['info'],array(
                    "key" => "SubRD Code",
                    "value" => $res[$s]['subrd_code'],
                    "type" => "number"
                ));

                array_push($temp['info'],array(
                    "key" => "State",
                    "value" => $res[$s]['village_state'],
                    "type" => "text"
                ));

                array_push($temp['info'],array(
                    "key" => "District",
                    "value" => $res[$s]['subrd_district'],
                    "type" => "text"
                ));

                array_push($temp['info'],array(
                    "key" => "Taluk",
                    "value" => $res[$s]['subrd_taluk'],
                    "type" => "text"
                ));

                array_push($temp['info'],array(
                    "key" => "Village",
                    "value" => $res[$s]['subrd_village'],
                    "type" => "text"
                ));

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
            
            

            $temp['info'] = [];
            array_push($temp['info'],array(
                "key" => "Village Name",
                "value" => $res[$s]['village_name'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Beat Name",
                "value" => $res[$s]['beat_name'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Village Market ID",
                "value" => $res[$s]['village_market_id'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Visit Order",
                "value" => $res[$s]['visit_order'],
                "type" => "number"
            ));

            array_push($temp['info'],array(
                "key" => "Actual or Assumed Outlet Nos.",
                "value" => $type_subrd[$res[$s]['subrd_type']],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Covered Outlets:",
                "value" => $res[$s]['covered_outlets'],
                "type" => "number"
            ));

            array_push($temp['info'],array(
                "key" => "Covered VisiCooler",
                "value" => $res[$s]['covered_visicooler'],
                "type" => "number"
            ));

            array_push($temp['info'],array(
                "key" => "Covered Wholesaler",
                "value" => $res[$s]['covered_wholesaler'],
                "type" => "number"
            ));

            array_push($temp['info'],array(
                "key" => "State",
                "value" => $res[$s]['village_state'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "District",
                "value" => $res[$s]['village_district'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Taluk",
                "value" => $res[$s]['village_taluk'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Village",
                "value" => $res[$s]['village'],
                "type" => "text"
            ));

            array_push($subrd['subrd_retailer'],$temp);
        }
        
        
        $message['result']=$subrd;     
       
        ksort($legend);
        $message['legend']=[];
        foreach($legend as $k=>$v)
            foreach($v as $key=>$val)
                        $message['legend'][0][$key]=$val;

                   
        $message['label'] = '';
       
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        //$message['map_nextlevel_info'] = $subrd['beatlist'];
        $message['tbl'] = '';
        $head='';
        if($request->get('subrd_district') !== null && $request->get('subrd_district') !== '')
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
        return response()->json($message);
    }
    public function get_hugli_sstbeats(Request $request)
    {
         $subrd = [];
         $subrd = ['maplist'=>[],'beatlist'=>[],
            'tabledata'=> [
                'column'=> [
                '#','Beat','Village Market-UID','Village','Sub-Distt','District','State','Visit Order','One Way Distance (Kms)','Time (Mins)','Total Beat Distance(Kms)','Total Beat Time (Mins)'],
                'value'=>[]
            ]
        ];

        $subrd['subrd_retailer']=[];
        $subrd['subrd_list']=[];
        $value_data=[];

        $user = auth()->user();
        $userid = $user->id;
        $subrd_id=[];$legend=[];$subrd_str='';
        $subrd['beat_list']=[];

         if(($request->get('filter_beat') !== null && $request->get('filter_beat') !== '')){
                    $subrd_str .=" where beat_name in ('".$request->get('filter_beat')."')";
            
          }
          

         $sql="SELECT `refid`,state_id, `state`, `District`, `Village`, `population`, `market_uid`, `village_census`,beat, `beat_name`, `order_id`, `oneway_distance`, `time`, `total_beat_distance`, `total_beat_time`, `subrd_type`, `village_lat`, `village_lon` FROM `subrd_beat_client` ".$subrd_str." order by beat_name asc";
        
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);

        
        $message=[];
        $sub=[];
        $dist_list=['dist'=>[],'subrd'=>[]];
        $total_potential=count($res);
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $type_subrd=[1=>'Actual',2=>'Assumed'];
        $test=['Inefficient'=>3,'No visit'=>3,'Premium'=>0,'Very Good'=>0,'Medium'=>1,'Average'=>1,'Van Beat'=>2,'Good'=>2];

        $subrd_arr=range(0,30);$colorval=0;$premium=[];
        $insertedBeats = [];
        for($s=0;$s<$total_potential;$s++)
        {
          

            $val_data=[];
            $val_data['row_id']=$s+1;
            $val_data['beat_name']=$res[$s]['beat'];
            $val_data['market_uid']=$res[$s]['market_uid'];
            $val_data['Village']=ucwords(strtolower($res[$s]['Village']));
            $val_data['District']=$res[$s]['District'];
            $val_data['state']=$res[$s]['state'];
            $val_data['order_id']=$res[$s]['order_id'];
            $val_data['oneway_distance']=$res[$s]['oneway_distance'];
            $val_data['time']=$res[$s]['time'];
            $val_data['total_beat_distance']=$res[$s]['total_beat_distance'];
            $val_data['total_beat_time']=$res[$s]['total_beat_time'];
             
            array_push($subrd['tabledata']['value'],$val_data);

            $loadmap ="https://analytics.brandidea.com/mapshapes/beat_path/Hugli_Visual.geojson";

            if (!in_array($loadmap, $subrd["maplist"])) {
                array_push($subrd["maplist"], $loadmap);
            }
            
            array_push($dist_list['dist'],$res[$s]['District']);
           
             if(!array_key_exists($res[$s]['village_census'], $subrd['beat_list']))
            {

                array_push($insertedBeats,$res[$s]['village_census'].'#'.$res[$s]['beat_name']);
                $beat_id=$res[$s]['village_census'].'#'.$res[$s]['beat_name'];
                $tempSubBeat=[];
                $tempSubBeat['beat_id']=$res[$s]['beat_name'];   
                $tempSubBeat['beat_name']=$res[$s]['beat_name'];                
                $tempSubBeat['beat_unique_id']=$res[$s]['village_census'].'#'.$res[$s]['beat_name'];
                $tempSubBeat['color']='#908D8E';
                
        

                $tempSubBeat['info'] = [];
                array_push($tempSubBeat['info'],array(
                    "key" => "Beat Name",
                    "value" => $res[$s]['beat_name'],
                    "type" => "text"
                ));

                array_push($tempSubBeat['info'],array(
                    "key" => "State",
                    "value" => $res[$s]['state'],
                    "type" => "text"
                ));

                array_push($tempSubBeat['info'],array(
                    "key" => "District",
                    "value" => $res[$s]['District'],
                    "type" => "text"
                ));
                array_push($subrd['beatlist'],$tempSubBeat);
            }

            if($res[$s]['subrd_type']==2)
            {
              
                $temp=[];
                $temp['subrd_name']=$res[$s]['Village'];                
                $temp['type']='';
                $temp['latitude']=$res[$s]['village_lat'];
                $temp['longitude']=$res[$s]['village_lon'];
                $temp['beat_id']=$res[$s]['beat_name'];
                $temp['beat_unique_id']=$res[$s]['village_census'].'#'.$res[$s]['beat_name'];
                $temp['color']='#3cb64a';
                $temp['icon']='images/sst.png';
                
                
                $temp['info'] = [];
                array_push($temp['info'],array(
                    "key" => "Subrd Name",
                    "value" => $res[$s]['Village'],
                    "type" => "text"
                ));

                

                array_push($temp['info'],array(
                    "key" => "State",
                    "value" => $res[$s]['state'],
                    "type" => "text"
                ));

                array_push($temp['info'],array(
                    "key" => "District",
                    "value" => $res[$s]['District'],
                    "type" => "text"
                ));

                array_push($temp['info'],array(
                    "key" => "Village",
                    "value" => $res[$s]['Village'],
                    "type" => "text"
                ));

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
            
            

            $temp['info'] = [];
            array_push($temp['info'],array(
                "key" => "Village Name",
                "value" => $res[$s]['Village'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Beat Name",
                "value" => $res[$s]['beat_name'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Village Market ID",
                "value" => $res[$s]['market_uid'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Visit Order",
                "value" => $res[$s]['order_id'],
                "type" => "number"
            ));

            array_push($temp['info'],array(
                "key" => "Actual or Assumed Outlet Nos.",
                "value" => $type_subrd[$res[$s]['subrd_type']],
                "type" => "text"
            ));

          

            array_push($temp['info'],array(
                "key" => "State",
                "value" => $res[$s]['state'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "District",
                "value" => $res[$s]['District'],
                "type" => "text"
            ));


            array_push($temp['info'],array(
                "key" => "Village",
                "value" => $res[$s]['Village'],
                "type" => "text"
            ));

            array_push($subrd['subrd_retailer'],$temp);
        }
        
        
        $message['result']=$subrd;     
       
        ksort($legend);
        $message['legend']=[];
        foreach($legend as $k=>$v)
            foreach($v as $key=>$val)
                        $message['legend'][0][$key]=$val;

                   
        $message['label'] = '';
       
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        //$message['map_nextlevel_info'] = $subrd['beatlist'];
        $message['tbl'] = '';
        $head='';
       
        $message['head'] ='Hugli SST Beats';
        return response()->json($message);
    }
}