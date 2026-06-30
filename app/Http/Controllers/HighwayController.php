<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '512M');
use App\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

use App\User;
use DB;

class HighwayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    private $low=[5,69,54];
    private $high=[151,83,34];
    private $isolate=[166, 63, 26];
    private $low_town=[0,0,100];
    private $high_town=[241, 41, 36];  
    private $isolate_town=[241, 41, 36];
    public function index()
    {
       
    }
     public  function gethighway($input)
     {

         $highway=[];
         $highway['highway_list']=[];         
         $highway['highway_retailer']=[];
         $highway['subrd_list']=[];
         $column=[];
         $value_data=[];

           $user = auth()->user();
           $userid = $user->id;
           //\Log::info($userid."userid");

            $columnTitles = [
                ['title' => '#',                         'className' => 'text-left'],
                ['title' => 'Establishment Name',       'className' => 'text-left'],
                ['title' => 'Channel Type',             'className' => 'text-left'],
                ['title' => 'Address',                  'className' => 'text-left'],
                ['title' => 'Geo Code',             'className' => 'text-left'],
                ['title' => 'SubRD Code',               'className' => 'text-left'],
                ['title' => 'SubRD',                    'className' => 'text-left'],
                ['title' => 'SubRD Market UID',         'className' => 'text-left'],
                ['title' => 'SubRD Type',               'className' => 'text-right'],
                ['title' => 'Recommended Village',      'className' => 'text-left'],
                ['title' => 'Recommended SubRD Loc ID', 'className' => 'text-right'],
                ['title' => 'Group',                    'className' => 'text-right'],
                ['title' => 'Cluster',                  'className' => 'text-right'],
                ['title' => 'Highway',                  'className' => 'text-right'],
                ['title' => 'City/Village',             'className' => 'text-right'],
                ['title' => 'Taluk',                    'className' => 'text-right'],
                ['title' => 'District',                 'className' => 'text-right'],
                ['title' => 'State',                    'className' => 'text-right'],
            ];

                // change specific column titles based on user id
                switch ($user->client_id) {

                    case 112:
                        $columnTitles[5]['title'] = 'DBR/SubDB Code';
                        $columnTitles[6]['title'] = 'DBR/SubDB';
                        $columnTitles[7]['title'] = 'DBR Market UID';
                        $columnTitles[8]['title'] = 'DBR/SubDB Type';
                        $columnTitles[10]['title'] = 'Recommended DBR/SubDB Loc ID'; 
                        break;

                
                }

                // For user id 112 remove SubRD, Market UID and Cluster columns
                if ($user->client_id == 112) {
                    unset(
                        $columnTitles[6],  // SubRD
                        $columnTitles[7],  // SubRD Market UID
                        $columnTitles[12]  // Cluster
                    );

                    // Re-index array
                    $columnTitles = array_values($columnTitles);
                }
                // final array for datatable
                 $column = $columnTitles;
           
          $input_query=json_decode($input['input']);
          $subrd_id=[];
          $head='';
          $str='';
          
          $tbllist = [112 => 'coke_highway_outlet',120 => 'highway_outlet'];
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

       
           $sql = "SELECT b.traffic_code,a.refid AS outlet_id, a.subrd_id,b.refid AS highway_id,b.highway_info,b.highway_name,b.start_point,b.end_point,b.length,a.ccp_id,a.ccp_name,a.address,a.ccp_latitude AS latitude,a.ccp_longitude AS longitude,a.group_type,a.channel,a.status,a.stocking_confictionary,a.stocking_chocolate,b.length,c.state,c.taluk,c.district,c.village, c.subrd_code, IF(c.subrd_type = 2, c.loc14, '') AS recommand_locid,c.subrd_lat,c.subrd_lon,c.subrd_type,c.address AS subrd_address,c.contact_no,IF(c.subrd_type = 1, c.subrd_name, '') AS subrd_name,IF(c.subrd_type = 5, c.subrd_name, '') AS distbtr_name,IF(c.subrd_type = 2, c.subrd_name, '') AS recomend_subrd_name,IF(c.subrd_type = 1,'Actual SubRD',IF(c.subrd_type = 5,'Actual Disbtr','Recomnd SubRD Location')) AS subrd_name_type,IF(c.subrd_type = 1,'SubRD Code', IF(c.subrd_type = 5,'Distributor Name', 'BI Location ID')) AS subrd_title,IF(a.group_type = 1, 'Group A', 'Group B') AS group_name,a.group_type,a.cluster,c.subrd_markt_uid AS subrd_market_id,c.state,c.district,c.taluk,c.village,a.city_village,a.state AS outlet_state,a.district AS outlet_district,a.taluk AS outlet_taluk FROM ".$tbllist[$user->client_id]." AS a LEFT JOIN highway_structure AS b ON a.highway_id = b.refid LEFT JOIN coke_highway_subrd AS c ON a.subrd_id = c.refid WHERE a.highway_id IN (" . implode(',', $input_query->filter_highway) . ") $str";
      
        //\Log::info($sql."highway");
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
       
        $message=[];
        $message['maplist']=[];
        $potential_list=[];
        $total_potential=count($res);
        for($s=0;$s<$total_potential;$s++)
        {
            $cluster_name=($res[$s]['cluster']==0) ? '' :'C'.$res[$s]['cluster'];
             
                $val_data = [
                    ($s + 1),

                   

                    '<a href="#" style="text-decoration:underline" onClick="highlight(' .
                    $res[$s]['outlet_id'] . ',' . $res[$s]['latitude'] . ',' . $res[$s]['longitude'] . ')">' .
                    $res[$s]['ccp_name'] . '</a>',

                    '<a href="#" style="text-decoration:underline;" onClick="show_highway(0,\'' .
                    $res[$s]['channel'] . '\')">' .
                    $res[$s]['channel'] . '</a>',

                     $res[$s]['address'],

                    '<a href="https://www.google.com/maps?q=' . $res[$s]['latitude'] . ',' . $res[$s]['longitude'] . '" target="_blank">' .
    $res[$s]['latitude'] . ', ' . $res[$s]['longitude'] .
'</a>',
                    '<a href="#" style="text-decoration:underline;" onClick="show_highway(0,\'\',\'' .
                    $res[$s]['subrd_code'] . '\')">' .
                    $res[$s]['subrd_code'] . '</a>',

                    $res[$s]['subrd_name'],
                    $res[$s]['subrd_market_id'],
                    $res[$s]['subrd_name_type'],
                    $res[$s]['recomend_subrd_name'],
                    $res[$s]['recommand_locid'],
                    $res[$s]['group_name'],
                    $cluster_name,

                    '<a href="#" style="text-decoration:underline;" onClick="show_highway(' .
                    $res[$s]['highway_id'] . ')">' .
                    $res[$s]['highway_name'] . '</a>',

                    $res[$s]['city_village'],
                    $res[$s]['outlet_taluk'],
                    $res[$s]['outlet_district'],
                    $res[$s]['outlet_state']
                ];

            // remove same values removed in columns
            if ($user->client_id == 112) {
                unset(
                    $val_data[5],   // DBR
                    $val_data[6]  // DBR Market UID
                    //$val_data[11]   // Cluster
                );

                $val_data = array_values($val_data);
            }

            $value_data[] = $val_data;

             //array_push($value_data,$val_data);

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
                
                 $highway['highway_list'][$res[$s]['highway_id']]['highway']='../../mapshapes/highway_path/'.$highway_.'.geojson';
                 \Log::info( $highway['highway_list'][$res[$s]['highway_id']]['highway']);  
                 array_push($message["maplist"], $highway['highway_list'][$res[$s]['highway_id']]['highway']);
                 $highway['highway_list'][$res[$s]['highway_id']]['info']='<div class="tooltip-data popupdata"><div class="card"><div class="card-header"><h3>'.$res[$s]['highway_name'].'</h3></div><ul class="list-group list-group-flush"><li class="text-wrap pb-2" style="max-width:15rem;display: inline-block;">'.$res[$s]['highway_info'].'</li><li>Stretch Length :<span>'.$res[$s]['length'].' Km.</span</li><li>Avg. Traffic :<span>'.$res[$s]['traffic_code'].' Nos.'.'</span</li><li>Highway Retailer(s) :<span>'.$highway['highway_list'][$res[$s]['highway_id']]['highway_potential'].' Nos.</span</li></ul></div></div>';
                 $head .=$res[$s]['highway_name'].', ';
            }
           // \Log::info('subrd_type: '. $res[$s]['subrd_type']);
            if(!in_array($res[$s]['subrd_id'], $subrd_id) && $res[$s]['subrd_id']!='' && !is_null($res[$s]['subrd_id']))
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
                  //\Log::info($res[$s]['subrd_type']);  
                //\Log::info('subrd_type: '. $res[$s]['subrd_type']);

                if((int)$res[$s]['subrd_type'] === 1)
                {
                $temp['color'] = '#3cb64a';
                $temp['icon'] = 'highway/actual_subrd.png';
                }
                elseif((int)$res[$s]['subrd_type'] === 2)
                {
                $temp['color'] = '#f37121';
                $temp['icon'] = 'highway/recomnd_subrd.png';
                }
                elseif((int)$res[$s]['subrd_type'] === 5)
                {
                $temp['color'] = '#071eee';
                $temp['icon'] = 'highway/actural_disbtr.png';
                 $temp['type']= 'Actual Distbtr';
                }
                
                  $subrd_name=($res[$s]['subrd_name']!='') ? $res[$s]['subrd_name'] : $res[$s]['recomend_subrd_name'].' Villg.';

                 //    $temp['info']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$subrd_name.'</h3> </div>'.$res[$s]['sub_text'].'</div></div>';


                     $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$subrd_name.'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['subrd_lat'].','.$res[$s]['subrd_lon'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" onClick="closeicon(this)" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['state'].' state</span><br><span style="line-height:1rem;">'.$res[$s]['district'].' distt</span><br><span style="line-height:1rem;">'.$res[$s]['taluk'].' sub-distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">'.$res[$s]['subrd_title'].': </span>'.$res[$s]['subrd_code'].'</p><p><span style="color:rgb(242, 101, 34)">SubRD Type: </span>'.$res[$s]['subrd_name_type'].' </p>';
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

                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['ccp_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" onClick="closeicon(this)" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['outlet_state'].' state</span><br><span style="line-height:1rem;">'.$res[$s]['outlet_district'].' distt</span><br><span style="line-height:1rem;">'.$res[$s]['outlet_taluk'].' sub-distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><span style="color:#00CCCC;font-weight:bold;">'.$res[$s]['address'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Channel: </span>'.$res[$s]['channel'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$subrd_code_title.': </span>'.$res[$s]['subrd_code'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$subrd_name_title.': </span>'.$subrd_name_.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Village: </span>'.$res[$s]['city_village'].' </p></div>';

               
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
        
      // \Log::info('highway_list: ' . print_r($highway['highway_list'], true));
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
        $message['head'] = trim($head,", "). ' Highway(s)';
         return json_encode($message);


     }
    public  function state_gethighway($input)
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
             'title' => 'Establishment Name', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Channel Type', 'className' => 'text-left'
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




        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $potential_list=[];
        $total_potential=count($res);
        for($s=0;$s<$total_potential;$s++)
        {
            $cluster_name=($res[$s]['cluster']==0) ? '' :'C'.$res[$s]['cluster'];
             
            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['outlet_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['ccp_name'].'</a>','<a href="#" style="text-decoration:underline;" onClick="show_state_highway(0,\''.$res[$s]['channel'].'\')">'.$res[$s]['channel'].'</a>',$res[$s]['address'], '<a href="#" style="text-decoration:underline;" onClick="show_state_highway(0,\'\',\''.$res[$s]['subrd_code'].'\')">'.$res[$s]['subrd_code'].'</a>',$res[$s]['subrd_name'],$res[$s]['subrd_market_id'],$res[$s]['subrd_name_type'],$res[$s]['recomend_subrd_name'],$res[$s]['recommand_locid'],$res[$s]['group_name'],$cluster_name,'<a href="#" style="text-decoration:underline;" onClick="show_state_highway('.$res[$s]['highway_id'].')">'.$res[$s]['highway_name'].'</a>',$res[$s]['city_village'],$res[$s]['taluk'],$res[$s]['district'],$res[$s]['state']
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
                
                 $highway['highway_list'][$res[$s]['highway_id']]['highway']='../../mapshapes/state_highway/'.$highway_.'.geojson';
                 array_push($message["maplist"], $highway['highway_list'][$res[$s]['highway_id']]['highway']);
                 $highway['highway_list'][$res[$s]['highway_id']]['info']='<div class="tooltip-data popupdata"><div class="card"><div class="card-header"><h3>'.$res[$s]['highway_name'].'</h3></div><ul class="list-group list-group-flush"><li class="text-wrap pb-2" style="max-width:15rem;display: inline-block;">'.$res[$s]['highway_info'].'</li><li>Stretch Length :<span>'.$res[$s]['length'].' Km.</span</li><li>Highway Retailer(s) :<span>'.$highway['highway_list'][$res[$s]['highway_id']]['highway_potential'].' Nos.</span</li></ul></div></div>';
                 $head .=$res[$s]['highway_name'].', ';
            }
            if(!in_array($res[$s]['subrd_id'], $subrd_id) && $res[$s]['subrd_id']!=0)
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


                     $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$subrd_name.'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['subrd_lat'].','.$res[$s]['subrd_lon'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" onClick="closeicon(this)" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['state'].' state</span><br><span style="line-height:1rem;">'.$res[$s]['district'].' distt</span><br><span style="line-height:1rem;">'.$res[$s]['taluk'].' sub-distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">'.$res[$s]['subrd_title'].': </span>'.$res[$s]['subrd_code'].'</p><p><span style="color:rgb(242, 101, 34)">SubRD Type: </span>'.$res[$s]['subrd_name_type'].' </p>';
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

                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['ccp_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1"  geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" onClick="closeicon(this)" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['state'].' state</span><br><span style="line-height:1rem;">'.$res[$s]['district'].' distt</span><br><span style="line-height:1rem;">'.$res[$s]['taluk'].' sub-distt</span></span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><span style="color:#00CCCC;font-weight:bold;">'.$res[$s]['address'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Channel: </span>'.$res[$s]['channel'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$subrd_code_title.': </span>'.$res[$s]['subrd_code'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$subrd_name_title.': </span>'.$subrd_name_.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Village: </span>'.$res[$s]['city_village'].' </p></div>';

               
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
        $message['head'] = trim($head,", "). ' State Highway(s)';
         return json_encode($message);


     }

}
