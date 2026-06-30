<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\SST;
use App\Http\Controllers\CommonController;

class SSTController extends Controller
{
    public $successStatus = 200;
    public $filenotfound = 404;
    public $failure =500;
    private $isolate=[166, 63, 26];
    private $low=[5,69,54];
    private $high=[151,83,34];

      public function getsstbeat(Request $request)
    {
        $sst = [];$subrd=[];$dist_list=['dist'=>[],'sst'=>[],'beat_list'=>[]];
        $sst = ['maplist'=>[],'beatlist'=>[],'sst_village'=>[],'sst_list'=>[],'subrd_retailer'=>[],
            'tabledata'=> [
                'column'=> [
                '#','SST Code','SST Name','Beat No','Beat Order','Village','Village Type','Sub-Distt','District','State','Retailer Count in Village','Sub-Distt','District','State','Total Outlets in Beat','Distance from previous Village', 'Total Beat Distance','Highway Name','Total Time (Hrs.)'],
                'value'=>[]
            ]
        ];
         $value_data=[];

      
        $subrd['subrd_list']=[];
      
        $input_sstsubrdbeat = ($request->get('filter_sstsubrdbeat') !== null && $request->get('filter_sstsubrdbeat') !== '') ? explode(',',$request->get('filter_sstsubrdbeat')) : [];
        $input_sstbeat_district = ($request->get('filter_sstbeat_district') !== null && $request->get('filter_sstbeat_district') !== '') ? explode(',',$request->get('filter_sstbeat_district')) : [];
        $input_beat = ($request->get('filter_beat') !== null && $request->get('filter_beat') !== '') ? explode(',',$request->get('filter_beat')) : [];
         $qSubrd = SST::select("refid", "sst", "sst_latitude", "sst_longitude", "beat_no", "village_code", "villg_latitude", "villg_longitude", "villg_type","village_type_id", "retailer_count", "total_retailer_count", "distance_between_villg", "distance_beat", "highway_name", "total_time_hrs", "sst_name", "sst_code", "loc7", "loc9", "sst_file",DB::raw("concat(sst,'#',beat_no) as beat_unique_id"),"state_name","district_name","taluk_name",DB::raw("concat(village_name,' Villg.') as village_name"),"popn as population","rpi","visit_order",DB::raw("if(rpi_id=2,'D',if(rpi_id=1,'MD',if(rpi_id=3,'T',if(rpi_id=4,'UD',if(rpi_id=5,'NR',if(rpi_id=6,'NR-U',''))))))  as rpi_img"))->where("stat","=","A");
          if(isset($input_sstsubrdbeat) && (count($input_sstsubrdbeat) > 0))
                $qSubrd->whereIn("sst",$input_sstsubrdbeat);           
          if(isset($input_sstbeat_district) && (count($input_sstbeat_district) > 0))
                $qSubrd->whereIn("loc9",$input_sstbeat_district); 
          if(isset($input_beat) && (count($input_beat) > 0)  )    
                 $qSubrd->whereIn("beat_no",$input_beat);  
         $res = $qSubrd->get()->toArray();
         
        $total_potential=count($res);
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $type_subrd=[1=>'Actual',2=>'Assumed'];
        $test=['Inefficient'=>3,'No visit'=>3,'Premium'=>0,'Very Good'=>0,'Medium'=>1,'Average'=>1,'Van Beat'=>2,'Good'=>2];
        $subrd_arr=range(0,30);$colorval=0;$premium=[];
        $insertedBeats = [];$sst_id=[];
      
        for($s=0;$s<$total_potential;$s++)
        {
         
            $val_data=[];
            $val_data['row_id']=$s+1;
            $val_data['sst']=$res[$s]['sst'];
            $val_data['sst_name']=$res[$s]['sst_name'];
            $val_data['beat_no']='Beat '.$res[$s]['beat_no'];
            $val_data['visit_order']=$res[$s]['visit_order'];
            $val_data['village_name']=$res[$s]['village_name'];
            $val_data['villg_type']=$res[$s]['villg_type'];
            $val_data['taluk_name']=$res[$s]['taluk_name'];
            $val_data['district_name']=$res[$s]['district_name'];
            $val_data['state_name']=$res[$s]['state_name'];
            $val_data['retailer_count']=$res[$s]['retailer_count'];
            $val_data['total_retailer_count']=$res[$s]['total_retailer_count'];
            $val_data['distance_between_villg']=$res[$s]['distance_between_villg'];
            $val_data['distance_beat']=$res[$s]['distance_beat'];
            $val_data['highway_name']=$res[$s]['highway_name'];
            $val_data['total_time_hrs']=$res[$s]['total_time_hrs'];

            array_push($sst['tabledata']['value'],$val_data);

             if(!in_array($res[$s]['loc7'], $subrd)) 
            {
                 array_push($subrd,$res[$s]['loc7']); 
                array_push($sst['maplist'], 'https://analytics.brandidea.com/mapshapes/sst_path/'.$res[$s]['sst_file']);
                
            }

            array_push($dist_list['dist'],$res[$s]['loc9']);
            array_push($dist_list['sst'],$res[$s]['sst']);


            if(!in_array($res[$s]['beat_unique_id'], $dist_list['beat_list']))
            {
            $beat_id=$res[$s]['beat_unique_id'];
            array_push($dist_list['beat_list'],$res[$s]['beat_unique_id']);
            $tempSubBeat=[];
            $tempSubBeat['beat_unique_id']=$res[$s]['beat_unique_id'];   
            $tempSubBeat['beat_id']=$res[$s]['beat_no'];   
            $tempSubBeat['beat_name']='Beat '.$res[$s]['beat_no'];
            $tempSubBeat['beat_unique_id']=$res[$s]['beat_unique_id'];
            $tempSubBeat['color']=CommonController::random_hex_color();
            $tempSubBeat['village_name']=$res[$s]['village_name'];
            $tempSubBeat['state']=$res[$s]['state_name'];
            $tempSubBeat['district']=$res[$s]['district_name'];
            $tempSubBeat['village_taluk']=$res[$s]['taluk_name'];
            
            $tempSubBeat['info'] = [];
            array_push($tempSubBeat['info'],array(
                "key" => "Beat Name",
                "value" => 'Beat '.$res[$s]['beat_no'],
                "type" => "text"
            ));

            array_push($tempSubBeat['info'],array(
                "key" => "State",
                "value" => $res[$s]['state_name'],
                "type" => "text"
            ));

            array_push($tempSubBeat['info'],array(
                "key" => "District",
                "value" => $res[$s]['district_name'],
                "type" => "text"
            ));

            array_push($tempSubBeat['info'],array(
                "key" => "Total Outlets in Beat",
                "value" => $res[$s]['total_retailer_count'],
                "type" => "text"
            ));

            array_push($tempSubBeat['info'],array(
                "key" => "Total Beat Distance",
                "value" => $res[$s]['distance_beat'].' (Km.)',
                "type" => "number"
            ));
                array_push($sst['beatlist'],$tempSubBeat);

    }
    if(!in_array($res[$s]['sst'], $sst_id))
    {
                array_push($sst_id,$res[$s]['sst']);
        $tempSubBeat=[];
        $tempSubBeat['sst']=$res[$s]['sst'];  
        $tempSubBeat['sst_name']=$res[$s]['sst_name'];  
        $tempSubBeat['village_name']=$res[$s]['village_name'];
        $tempSubBeat['state']=$res[$s]['state_name'];
        $tempSubBeat['district']=$res[$s]['district_name'];
        $tempSubBeat['village_taluk']=$res[$s]['taluk_name'];              
        $tempSubBeat['latitude']=$res[$s]['sst_latitude'];
        $tempSubBeat['longitude']=$res[$s]['sst_longitude'];
        $tempSubBeat['beat_id']=$res[$s]['beat_no'];
        $tempSubBeat['beat_unique_id']=$res[$s]['beat_unique_id'];
        $tempSubBeat['color']='#3cb64a';
        $tempSubBeat['icon']='images/sst.png'; 
        $tempSubBeat['info']=[];
         array_push($tempSubBeat['info'],array(
                "key" => "SST Name",
                "value" => $res[$s]['sst_name'],
                "type" => "text"
            ));

            array_push($tempSubBeat['info'],array(
                "key" => "State",
                "value" => $res[$s]['state_name'],
                "type" => "text"
            ));

            array_push($tempSubBeat['info'],array(
                "key" => "District",
                "value" => $res[$s]['district_name'],
                "type" => "text"
            ));
              array_push($tempSubBeat['info'],array(
                "key" => "Taluk",
                "value" => $res[$s]['taluk_name'],
                "type" => "text"
            ));

            array_push($tempSubBeat['info'],array(
                "key" => "SST Code",
                "value" => $res[$s]['sst_code'],
                "type" => "text"
            ));
            array_push($tempSubBeat['info'],array(
                "key" => "Village",
                "value" => $res[$s]['village_name'],
                "type" => "text"
            ));

            array_push($tempSubBeat['info'],array(
                "key" => "Total Outlets in Beat",
                "value" => $res[$s]['total_retailer_count'].' Nos.',
                "type" => "number"
            ));
                array_push($sst['sst_list'],$tempSubBeat);

                

            }
                $tempSubBeat=[];
                $tempSubBeat['color']=($res[$s]['village_type_id']==1) ? '#ffd700' : '#ffffff';
                $tempSubBeat['beat_id']=$res[$s]['beat_no'];
                $tempSubBeat['latitude']=$res[$s]['villg_latitude'];
                $tempSubBeat['longitude']=$res[$s]['villg_longitude'];
                $tempSubBeat['village_name']=$res[$s]['village_name'];
                $tempSubBeat['state']=$res[$s]['state_name'];
                $tempSubBeat['district']=$res[$s]['district_name'];
                $tempSubBeat['village_taluk']=$res[$s]['taluk_name'];
                $tempSubBeat['villg_type']=$res[$s]['villg_type'];
                $tempSubBeat['visit_order']=$res[$s]['visit_order'];
                $tempSubBeat['village_type_id']=$res[$s]['village_type_id'];                
                $tempSubBeat['retailer_count']=$res[$s]['retailer_count'];
                $tempSubBeat['total_retailer_count']=$res[$s]['total_retailer_count'];
                $tempSubBeat['distance_between_villg']=$res[$s]['distance_between_villg'];
                $tempSubBeat['distance_beat']=$res[$s]['distance_beat'];
                $tempSubBeat['highway_name']=$res[$s]['highway_name'];
                $tempSubBeat['total_time_hrs']=$res[$s]['total_time_hrs'];
                $tempSubBeat['sst_name']=$res[$s]['sst_name'];
                $tempSubBeat['sst_code']=$res[$s]['sst_code'];
                $tempSubBeat['village_code']=$res[$s]['village_code'];
                $rural_img=($res[$s]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$res[$s]['rpi_img'].'.jpg"></img>';
                $tempSubBeat['info']=[];
                array_push($tempSubBeat['info'],array(
                "key" => "Beat Name",
                "value" => $res[$s]['beat_no'],
                "type" => "text"
            ));
                array_push($tempSubBeat['info'],array(
                "key" => "SST Name",
                "value" => $res[$s]['sst_name'],
                "type" => "text"
            ));
                array_push($tempSubBeat['info'],array(
                "key" => "Village Type",
                "value" => $res[$s]['villg_type'],
                "type" => "text"
            ));
                  array_push($tempSubBeat['info'],array(
                "key" => "Population",
                "value" => number_format($res[$s]['population'],0).' Nos.',
                "type" => "text"
            ));

                  array_push($tempSubBeat['info'],array(
                "key" => "Rural Progressive Index",
                "value" => $rural_img,
                "type" => "text"
            ));

              array_push($tempSubBeat['info'],array(
                            "key" => "Retailer Count",
                            "value" =>$res[$s]['retailer_count'].' Nos.',
                            "type" => "text"
                        ));

              array_push($tempSubBeat['info'],array(
                            "key" => "Distance from previous Village",
                            "value" =>$res[$s]['distance_between_villg'].' (Km.)',
                            "type" => "text"
                        ));

              array_push($tempSubBeat['info'],array(
                            "key" => "Visit Order",
                            "value" =>$res[$s]['visit_order'],
                            "type" => "text"
                        ));
              array_push($sst['sst_village'],$tempSubBeat);

        }
        $message['legend']=[]; 

        array_push($message['legend'], ['name'=>'Highway Village','color'=>'#ffd700;']);
        array_push($message['legend'],['name'=>'<2K Pop. Inactive Village','color'=>'#ffffff;']);
        
        $message['result']=$sst;   
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
      
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
       
         $message['head'] =$head. ' SST(s)';
        return response()->json($message);
    }
     public function getstatesst(Request $request)
    {
       $sst = [];
        $sst = ['maplist'=>[],'map_data'=>[],
            'tabledata'=> [
                'column'=> [
                '#','State','District', 'No. of SST'],
                'value'=>[]
            ]
        ];

          $subrd_id=[];$legend=[];
          $head='';
          $sst_str='';
          
          $head='';
        

         $sql="SELECT a.`refid`, a.`district_id`, a.`state`, concat(a.`district`,' Distt.') as district, a.`no_of_sst`,b.latitude,b.longitude FROM `mdlz_sst_master` as a, district_master as b where a.district_id=b.refid order by a.district asc";

         $res = DB::select(DB::raw($sql));
         $res=CommonController::getarray($res);
        $message=[];
       
        $no_sst_bydistrict=array_column($res, 'no_of_sst');
        $maxval=max($no_sst_bydistrict);
        $minval=min($no_sst_bydistrict);
        $total_value=array_sum($no_sst_bydistrict);
       
        $count=count($res);
        
        for($s=0;$s<$count;$s++)
        {
            $val_data=[];
            $val_data['row_id']=$s+1;
            $val_data['state']=$res[$s]['state'];
            $val_data['district']=$res[$s]['district'];
            $val_data['no_of_sst']=$res[$s]['no_of_sst'];
            array_push($sst['tabledata']['value'],$val_data);

            $loadmap ="https://analytics.brandidea.com/mapshapes/district_sst/Mdlz_SST.geojson";

            if (!in_array($loadmap, $sst["maplist"])) {
                array_push($sst["maplist"], $loadmap);
            }
             
            $temp=[];
           
             $color_critiea=((float)$res[$s]['no_of_sst']/(float)$maxval)*100;
             $remain=($maxval-$minval);
             $delta=((float)$res[$s]['no_of_sst']-$minval)/$remain;
             $temp['color']=CommonController::getColor_sst($maxval, $minval, $delta,$this->low,$this->high);
             $temp['color']=CommonController::hsv2rgb($temp['color'][0],$temp['color'][1],$temp['color'][2]); 
             $temp['color']=$temp['color']['html'];
            

              $contribution=round((($res[$s]['no_of_sst']/$total_value)*100),2);
         
             $size=round((50*($contribution/100)),2);
             $temp['size']=($size > 1) ? $size : 1; 
             $temp['latitude']=$res[$s]['latitude'];
             $temp['longitude']=$res[$s]['longitude'];
             $temp['subrd_type']=1;
              $temp['id']=$res[$s]['district_id'];
             $temp['info']=[];
              array_push($temp['info'],array(
                    "key" => "State",
                    "value" => $res[$s]['state'],
                    "type" => "text"
                ));
              array_push($temp['info'],array(
                    "key" => "District",
                    "value" => $res[$s]['district'],
                    "type" => "text"
                ));
            
               array_push($temp['info'],array(
                    "key" => "No. of SST",
                    "value" => $res[$s]['no_of_sst'],
                    "type" => "text"
                ));
               
             array_push($sst['map_data'],$temp);
            

        }
        $message['legend']=[['name'=>'SST','color'=>'#fff']];

       
     
        $message['result']=$sst;    
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $head='India - Distt. SST Coverage';
        $message['head'] =$head;
         return response()->json($message);
    }
}