<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\Tsi;
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
         $tsi_list = ['tsi_list'=>[],'sst_list'=>[],'subrd_list'=>[]];
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
                '#','State','Year','Month','Branch','Region','ASM Area','SO Territory','Existing SubRD Code','Existing SubRD Name','SubRD Type','SubRD Tier','SST Code','SST Name','SST Town','Town Class','TSI Name','TSI Code','Total RLA Nos.','Total VC Nos.','Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)','Batch','Cluster Radius (km)','Cluster'],
                'value'=>[]
            ];

       
        $value_data=[];
        $user = auth()->user();
        $userid = $user->id;
        $legend=[];

        if(!isset($cluster))
           $getTsi = Tsi::select("sr_tsi_cluster_name as cluster_name","so_territory", "cluster_centroid_latitude as latitude", "cluster_centroid_longitude as longitude","no_of_subrd_in_cluster as no_of_subrd","loc7", DB::raw("sum(ifnull(sub_rd_rla,0)) sub_rd_rla"),DB::raw("sum(ifnull(vc_count,0)) vc_count"),DB::raw("sum(ifnull(avg_sale_monthly,0)) avg_sale_monthly"),DB::raw("max(distacnce_km) distacnce_km"))->groupBy("cluster_name");
        else
           $getTsi = Tsi::select( "state", "year", "month", "branch_name", "region_name", "loc7","asm_area", "so_territory", "subrd_villg_bi_id", "subrd_villg_marketuid", "subd_state_name", "subd_distt_name", "subd_taluk_name", "subd_villg_name", "existing_subrd_uid", "existing_subrd_name", "subrd_type", "subrd_tier", "sst_code", "sst_latitude", "sst_longitude", "sst_village_bi_id", "sst_village_market_uid", "2011_census", "sst_state_name", "sst_distt_name", "sst_taluk_name", DB::raw(" if(sst_villg_name!='',concat(`sst_villg_name`,' Villg.'),concat(sst_town,' Town')) as sst_villg_name"), "sst_name", "sst_town", "town_class", "tsi_name", "tsi_uid", "sub_rd_rla", "vc_count", "avg_sale_monthly", "batch", "distacnce_km", "cluster_centroid_latitude as latitude", "cluster_centroid_longitude as longitude", "sr_tsi_cluster_name as cluster_name", "no_of_subrd_in_cluster as no_of_subrd", "no_of_sr_tsi_requird as no_of_tsi", "refid","latitude as subd_latitude","longitude as subd_longitude")->where([["sr_tsi_cluster_name","=",$request->get('cluster_name')],["stat","=","A"]])->groupBy("cluster_name");
     
         $getTsi->orderBy("cluster_name");
        
      
        $res = $getTsi->get()->toArray();
     
        $message=[];
        $sub=[];

        $dist_list=['dist'=>[],'subrd'=>[]];
        $total_potential=count($res);
      
        $subrd_arr=range(0,30);$colorval=0;$premium=[];
        
        $value_distance=array_column($res,'distacnce_km');
        array_push($value_distance,10);
        $radious_default=(max($value_distance))/2;
        $sst_list=[];
       $subrd_list=[];

        for($s=0;$s<$total_potential;$s++)
        {

          if(!isset($cluster))
          {
             $temp=[];
                 $temp=['row_id'=>$s+1,'Cluster Name'=>$res[$s]['cluster_name'],'No. of Sr. TSI Reqd.'=>1,'Total RLA Nos.'=>$res[$s]['sub_rd_rla'],'Total VC Nos.'=>$res[$s]['vc_count'],'Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)'=>number_format($res[$s]['avg_sale_monthly'],0)];
                  
            
          }
           else
           {
             $temp=[];  
              $temp=array("row_id"=>($s+1),"State"=>$res[$s]['state'],"Year"=>$res[$s]['year'],"Month"=>$res[$s]['month'],"Branch"=>$res[$s]['branch_name'],"Region"=>$res[$s]['region_name'],"ASM Area"=>$res[$s]['asm_area'],"SO Territory"=>$res[$s]['so_territory'],"Existing SubRD Code"=>$res[$s]['existing_subrd_uid'],"Existing SubRD Name"=>$res[$s]['existing_subrd_name'],"SubRD Type"=>$res[$s]['subrd_type'],"SubRD Tier"=>$res[$s]['subrd_tier'],"SST Code"=>$res[$s]['sst_code'],"SST Name"=>$res[$s]['sst_name'],"SST Town"=>$res[$s]['sst_town'],"Town Class"=>$res[$s]['town_class'],"TSI Name"=>$res[$s]['tsi_name'],"TSI Code"=>$res[$s]['tsi_uid'],"Total RLA Nos."=>$res[$s]['sub_rd_rla'],"Total VC Nos."=>$res[$s]['vc_count'],"Total Avg. Monthly Sale (Rs.)(Lacs)(L6M)"=>round($res[$s]['avg_sale_monthly'],2),"Batch"=>$res[$s]['batch'],"Cluster Radius (km)"=>round($res[$s]['distacnce_km'],2),"Cluster"=>$res[$s]['cluster_name']);
           }
           
            
            array_push($tsi_list['tabledata']['value'],$temp);
            
        
            
                     $temp=[];
                     $temp['cluster_name']=$res[$s]['cluster_name'];
                     $temp['cluster_id']=str_replace("Cluster ","C",$res[$s]['cluster_name']);
                     $temp['latitude']=$res[$s]['latitude'];
                     $temp['longitude']=$res[$s]['longitude'];
                     $temp['id']=$res[$s]['loc7'];
                     $temp['no_of_subrd']=1;
                     $temp['so_territory']=$res[$s]['so_territory'];
                     $temp['no_of_tsi']=1;
                     $temp['sub_rd_rla']=$res[$s]['sub_rd_rla'];
                     $temp['vc_count']=$res[$s]['vc_count'];
                     $temp['avg_sale_monthly']=$res[$s]['avg_sale_monthly'];
                     $temp['distacnce_km']=($res[$s]['distacnce_km']>0) ? $res[$s]['distacnce_km'] : $radious_default;
                     $temp['color']='#9459cf';
                     $temp['opacity']=0.3;
                     $temp['info'] = [];
                    array_push($temp['info'],array(
                        "key" => "No. of SubRD in cluster",
                        "value" => $res[$s]['no_of_subrd'],
                        "type" => "text"
                    ));

                    array_push($temp['info'],array(
                        "key" => "Total RLA Nos.",
                        "value" => $res[$s]['sub_rd_rla'],
                        "type" => "text"
                    ));

                    array_push($temp['info'],array(
                        "key" => "Total VC Nos.",
                        "value" => $res[$s]['vc_count'],
                        "type" => "text"
                    ));

                    array_push($temp['info'],array(
                        "key" => "Total Avg. Cluster Sale (Rs.)(Lacs)(L6M)",
                        "value" => $res[$s]['avg_sale_monthly'],
                        "type" => "number"
                    ));

                    array_push($temp['info'],array(
                        "key" => "Cluster Radius (km)",
                        "value" =>round($res[$s]['distacnce_km'],2),
                        "type" => "number"
                    ));

                    array_push($temp['info'],array(
                        "key" => "SO Territory",
                        "value" => $res[$s]['so_territory'],
                        "type" => "text"
                    ));

                 array_push($tsi_list['tsi_list'],$temp);
             if(isset($cluster))
             {
                     if(!in_array($res[$s]['sst_code'],$sst_list))
                        {
                            array_push($sst_list,$res[$s]['sst_code']);
                            $temp=[];
                            $temp['refid']=$res[$s]['sst_code'];               
                            $temp['latitude']=$res[$s]['sst_latitude'];
                            $temp['longitude']=$res[$s]['sst_longitude'];
                            $temp['image']='https://analytics.brandidea.com/bilocaview/public/images/sst.png';
                            $temp['info']=[];
                              array_push($temp['info'],array(
                                    "key" => "State",
                                    "value" => $res[$s]['sst_state_name'],
                                    "type" => "text"
                                ));
                                array_push($temp['info'],array(
                                    "key" => "District",
                                    "value" => $res[$s]['sst_distt_name'],
                                    "type" => "text"
                                ));
                                  array_push($temp['info'],array(
                                    "key" => "Sub -Distt Name",
                                    "value" => $res[$s]['sst_taluk_name'],
                                    "type" => "text"
                                ));

                              array_push($temp['info'],array(
                                    "key" => "Village Name",
                                    "value" => $res[$s]['sst_villg_name'],
                                    "type" => "text"
                                ));
                              
                                array_push($temp['info'],array(
                                    "key" => "Servicing SST Code",
                                    "value" => $res[$s]['sst_code'],
                                    "type" => "number"
                                ));
                                 array_push($temp['info'],array(
                                    "key" => "Servicing SST Name",
                                    "value" => $res[$s]['sst_name'],
                                    "type" => "text"
                                ));



                                array_push($temp['info'],array(
                                    "key" => "TSI UID",
                                    "value" => $res[$s]['tsi_uid'],
                                    "type" => "number"
                                ));
                                 array_push($temp['info'],array(
                                    "key" => "TSI Name",
                                    "value" => $res[$s]['tsi_name'],
                                    "type" => "text"
                                ));

                                array_push($temp['info'],array(
                                    "key" => "BI ID",
                                    "value" => $res[$s]['sst_village_bi_id'],
                                    "type" => "number"
                                ));
                                  array_push($temp['info'],array(
                                    "key" => "MarketUID",
                                    "value" => $res[$s]['sst_village_market_uid'],
                                    "type" => "number"
                                ));

                            
                            array_push($tsi_list['sst_list'],$temp);
                        }
                       
                          if(!in_array($res[$s]['existing_subrd_uid'],$subrd_list))
                        {
                            array_push($subrd_list,$res[$s]['existing_subrd_uid']);
                             $temp=[];
                            $temp['refid']=$res[$s]['existing_subrd_uid'];
                            $temp['subrd_name']=$res[$s]['existing_subrd_name'];   
                            $temp['subrd_type']=$res[$s]['subrd_type'];
                            $temp['latitude']=$res[$s]['subd_latitude'];
                            $temp['longitude']=$res[$s]['subd_longitude'];
                            $temp['image']='https://analytics.brandidea.com/bilocaview/public/rural_icon/efficient-subrd.png';
                            $temp['info']=[];
                         
                              array_push($temp['info'],array(
                                    "key" => "State",
                                    "value" => $res[$s]['subd_state_name'],
                                    "type" => "text"
                                ));
                                array_push($temp['info'],array(
                                    "key" => "District",
                                    "value" => $res[$s]['subd_distt_name'],
                                    "type" => "text"
                                ));
                                  array_push($temp['info'],array(
                                    "key" => "Sub -Distt Name",
                                    "value" => $res[$s]['subd_taluk_name'],
                                    "type" => "text"
                                ));

                              array_push($temp['info'],array(
                                    "key" => "Village Name",
                                    "value" => $res[$s]['subd_villg_name'],
                                    "type" => "text"
                                ));
                              
                                array_push($temp['info'],array(
                                    "key" => "Existng SubRD Code",
                                    "value" => $res[$s]['existing_subrd_uid'],
                                    "type" => "number"
                                ));
                                 array_push($temp['info'],array(
                                    "key" => "Existng SubRD Name",
                                    "value" => $res[$s]['existing_subrd_name'],
                                    "type" => "text"
                                ));



                                array_push($temp['info'],array(
                                    "key" => "SubRD Type",
                                    "value" => $res[$s]['subrd_type'],
                                    "type" => "number"
                                ));
                                 array_push($temp['info'],array(
                                    "key" => "SubRD Tier",
                                    "value" => $res[$s]['subrd_tier'],
                                    "type" => "text"
                                ));

                                array_push($temp['info'],array(
                                    "key" => "RLA Nos.",
                                    "value" => $res[$s]['sub_rd_rla'],
                                    "type" => "number"
                                ));
                                  array_push($temp['info'],array(
                                    "key" => "VC Nos.",
                                    "value" => $res[$s]['vc_count'],
                                    "type" => "number"
                                ));

                                    array_push($temp['info'],array(
                                    "key" => "Avg. Monthly Sale (Rs.)(Lacs)(L6M)",
                                    "value" => $res[$s]['avg_sale_monthly'],
                                    "type" => "number"
                                ));
                                 array_push($temp['info'],array(
                                    "key" => "Servicing SST Code",
                                    "value" => $res[$s]['sst_code'],
                                    "type" => "text"
                                ));

                                array_push($temp['info'],array(
                                    "key" => "Servicing SST Name",
                                    "value" => $res[$s]['sst_name'],
                                    "type" => "number"
                                ));
                                  array_push($temp['info'],array(
                                    "key" => "TSI UID",
                                    "value" => $res[$s]['tsi_uid'],
                                    "type" => "number"
                                ));

                                    array_push($temp['info'],array(
                                    "key" => "TSI Name",
                                    "value" => $res[$s]['tsi_name'],
                                    "type" => "number"
                                ));
                                 array_push($temp['info'],array(
                                    "key" => "Servicing SST Code",
                                    "value" => $res[$s]['sst_code'],
                                    "type" => "text"
                                ));

                                array_push($temp['info'],array(
                                    "key" => "Servicing SST Name",
                                    "value" => $res[$s]['sst_name'],
                                    "type" => "number"
                                ));
                                  array_push($temp['info'],array(
                                    "key" => "TSI UID",
                                    "value" => $res[$s]['tsi_uid'],
                                    "type" => "number"
                                ));
                                   array_push($temp['info'],array(
                                    "key" => "BI ID",
                                    "value" => $res[$s]['subrd_villg_bi_id'],
                                    "type" => "number"
                                ));
                                  array_push($temp['info'],array(
                                    "key" => "MarketUID",
                                    "value" => $res[$s]['subrd_villg_marketuid'],
                                    "type" => "number"
                                ));
                                     array_push($temp['info'],array(
                                    "key" => "Distance from Cluster Centroid (km)",
                                    "value" => round($res[$s]['distacnce_km'],2),
                                    "type" => "number"
                                ));
                            
                                array_push($temp['info'],array(
                                    "key" => "SO Territory",
                                    "value" => $res[$s]['so_territory'],
                                    "type" => "number"
                                ));
                            
                            array_push($tsi_list['subrd_list'],$temp);
                        }
             }
            
            
          
        }
        
        
        $message['result']=$tsi_list;      
      
      
        $message['legend']=[];
                   
        $message["maplist"]=['https://analytics.brandidea.com/mapshapes/1/1/5_7/1_5_7_tsi.geojson'];
        $message['label'] = '';
     
        $message['status'] = true;
        $message['message'] = 'Data loaded successfully.';
     
        $message['head'] ='';
        return response()->json($message);
    }
}