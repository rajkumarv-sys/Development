<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\TSI;
use App\Http\Controllers\CommonController;

class TsiController extends Controller
{
    public $successStatus = 200;
    public $filenotfound = 404;
    public $failure =500;
    private $isolate=[166, 63, 26];
    private $low=[5,69,54];
    private $high=[151,83,34];
  
    public function getTsi(Request $request)
    {
         $tsi_list = [];
         $tsi_list = ['maplist'=>[],'beatlist'=>[]];
         $cluster=$request->get('cluster_name');
           if(!isset($cluster))
            $tsi_list['tabledata']= [
                'column'=> [
                '#','Cluster Name','No. of subRD in cluster','No. of Sr. TSI Reqd.','Total RLA Nos.','Total VC Nos.','Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)','Cluster Radius (km)'],
                'value'=>[]
            ];
            else
              $tsi_list['tabledata']= [
                'column'=> [
                '#','State','Year','Month','Branch','Region','ASM Area','SO Territory','Existing SubRD Code','Existing SubRD Name','SubRD Type','SubRD Tier','SST Code','SST Name','SST Town','Town Class','TSI Name','TSI Code','Total RLA Nos.','Total VC Nos.','Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)','Batch','Cluster Radius (km)','Cluster','No. of SubRD in cluster','No. of Sr. TSI Reqd.'],
                'value'=>[]
            ];

       
        $value_data=[];
        $user = auth()->user();
        $userid = $user->id;
        $legend=[];

        if(!isset($cluster))
           $getTsi = TSI::select("sr_tsi_cluster_name as cluster_name", "cluster_centroid_latitude as latitude", "cluster_centroid_longitude as longitude","no_of_subrd_in_cluster as no_of_subrd", "no_of_sr_tsi_requird as no_of_tsi","sub_rd_rla", "vc_count", "avg_sale_monthly",DB::raw("max(distacnce_km) distacnce_km"))->groupBy("cluster_name")->get();
       //  else
       //      $getTsi = Tsi::select( "state", "year", "month", "branch_name", "region_name", "asm_area", "so_territory", "subrd_villg_bi_id", "subrd_villg_marketuid", "subd_state_name", "subd_distt_name", "subd_taluk_name", "subd_villg_name", "existing_subrd_uid", "existing_subrd_name", "subrd_type", "subrd_tier", "sst_code", "sst_latitude", "sst_longitude", "sst_village_bi_id", "sst_village_market_uid", "2011_census", "sst_state_name", "sst_distt_name", "sst_taluk_name", "sst_villg_name", "sst_name", "sst_town", "town_class", "tsi_name", "tsi_uid", "sub_rd_rla", "vc_count", "avg_sale_monthly", "batch", "distacnce_km", "cluster_centroid_latitude as latitude", "cluster_centroid_longitude as longitude", "sr_tsi_cluster_name as cluster_name", "no_of_subrd_in_cluster as no_of_subrd", "no_of_sr_tsi_requird as no_of_tsi", "refid","latitude as subd_latitude","longitude as subd_longitude")->where(["sr_tsi_cluster_name"=>$request->get('cluster_name')])->get();
        
      
       //  $getTsi->orderByAsc("b.cluster_name");
        
       // // DB::enableQueryLog();
       //  $res = $qSubrd->get()->toArray();
        echo '<pre>';
        var_dump($res);
        dd(DB::getQueryLog());
        die;
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
            // $val_data=array(($s+1),$res[$s]['subrd_id'],$res[$s]['subrd_code'],'<a href="#" style="text-decoration:underline;" onClick="show_subrdbeat(0,'.$res[$s]['subrd_id'].')">'.ucwords(strtolower($res[$s]['subrd_name'])).'</a>',$res[$s]['subrd_district'],$res[$s]['subrd_taluk'],$res[$s]['village_name'],'<a href="#" style="text-decoration:underline;" onClick="show_subrdbeat('.$res[$s]['beat_id'].',0)">'.$res[$s]['beat_name'].'</a>',$res[$s]['beat_unique_id'],$res[$s]['village_market_id'],$res[$s]['visit_order'],$res[$s]['village_taluk'],$res[$s]['village_district'],$res[$s]['village_state'],$res[$s]['oneway_distance'],$res[$s]['beatween_distance'],$res[$s]['oneway_distance_per_beat'],$res[$s]['covered_outlets'],$res[$s]['covered_village'],$res[$s]['covered_wholesaler'],$res[$s]['covered_visicooler'],$res[$s]['beat_wholesaler'],$res[$s]['covered_cooler_outlets'],$type_subrd[$res[$s]['subrd_type']],$res[$s]['overall_time'],$res[$s]['premium']);
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
            $val_data['premium']=$res[$s]['premium'];
            
            array_push($subrd['tabledata']['value'],$val_data);

            $loadmap ="http://192.168.10.49/mapshapes/beat_path/".$res[$s]['beat_file'];

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
                
        
            
                // $tempSubBeat['info']='<div class="tooltip-data popupdata"><div class="card"><div class="card-header"><h3>'.$res[$s]['beat_name'].'</h3></div><ul class="list-group list-group-flush"><li>State:<span>'.$res[$s]['village_state'].'</span></li><li>District:<span>'.$res[$s]['village_district'].'</span></li><li>Taluk:<span>'.$res[$s]['village_taluk'].'</span></li><li>Covered Outlets:<span>'.$res[$s]['covered_outlets_beat'].' Nos.</span</li><li>Covered Wholesaler:<span>'.$res[$s]['covered_wholesaler_beat'].' Nos.</span</li><li>Classification:<span>'.$res[$s]['premium'].'</span></li></ul></div></div>';

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
                    "value" => $res[$s]['premium'],
                    "type" => "text"
                ));

                array_push($subrd['beatlist'],$tempSubBeat);
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
                
                // $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$temp['subrd_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['subrd_latitude'].','.$res[$s]['subrd_longitude'].'" onclick="location_navigate(this)" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">SubRD Code: </span>'.$res[$s]['subrd_code'].'</p><p><span style="color:rgb(242, 101, 34)">State: </span>'.$res[$s]['village_state'].'</p><p><span style="color:rgb(242, 101, 34)">District: </span>'.$res[$s]['subrd_district'].' </p><p><span style="color:rgb(242, 101, 34)">Taluk: </span>'.$res[$s]['subrd_taluk'].' </p><p><span style="color:rgb(242, 101, 34)">Village: </span>'.$res[$s]['subrd_village'].' </p></div>';
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
            
            // $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['village_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['village_latitude'].','.$res[$s]['village_longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Beat Name: </span>'.$res[$s]['beat_name'].' </p><p><span style="color:rgb(242, 101, 34)">Village Market ID: </span>'.$res[$s]['village_market_id'].' </p><p><span style="color:rgb(242, 101, 34)">Visit Order: </span>'.$res[$s]['visit_order'].' </p><p><span style="color:rgb(242, 101, 34)">Actual or Assumed Outlet Nos.: </span>'.$type_subrd[$res[$s]['subrd_type']].' </p><p><span style="color:rgb(242, 101, 34)">Covered Outlets: </span>'.$res[$s]['covered_outlets'].' </p><p><span style="color:rgb(242, 101, 34)">Covered VisiCooler: </span>'.$res[$s]['covered_visicooler'].' </p><p><span style="color:rgb(242, 101, 34)">Covered Wholesaler: </span>'.$res[$s]['covered_wholesaler'].' </p><p><span style="color:rgb(242, 101, 34)">State: </span>'.$res[$s]['village_state'].'</p><p><span style="color:rgb(242, 101, 34)">District: </span>'.$res[$s]['village_district'].' </p><p><span style="color:rgb(242, 101, 34)">Taluk: </span>'.$res[$s]['village_taluk'].'</p><p><span style="color:rgb(242, 101, 34)">Village: </span>'.$res[$s]['village'].'</p></div>';

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
        // $message['griddata']=array(
        //     'column' => $column,
        //     'value' => $value_data
        // );  
        ksort($legend);
        $message['legend']=[];
        foreach($legend as $k=>$v)
            foreach($v as $key=>$val)
                        $message['legend'][0][$key]=$val;

                   
        $message['label'] = '';
        // $message['loc_level'] = 0;
        // $message['loc_id'] = 0;
        // $message['main_location'] = 0;
        // $message['sub_location'] =0;
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
}