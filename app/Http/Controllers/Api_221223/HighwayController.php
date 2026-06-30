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

class HighwayController extends Controller
{
    public $successStatus = 200;
    public $filenotfound = 404;
    public $failure =500;
    private $isolate=[166, 63, 26];
    private $low=[5,69,54];
    private $high=[151,83,34];

    public function getHighwayList(Request $request){

        $input = $request->all();
        
        $aHighwayData = HighwayStructure::select('refid','highway_name')->where('state_id',$input['state_id'])->get();

        $message=['status'=>true,'message'=>'Highway List loaded','data'=>[]];
        $message['data']=$aHighwayData;
        return response()->json($message, $this->successStatus);
    }

    public function getHighway(Request $request)
    {
        $highway=[];
        $highway=['maplist'=>[],'mapdata'=>[],'tabledata'=>['column'=>['#','Establishment Name','Channel Type','Address','SubRD Code','SubRD','SubRD Market UID','SubRD Type','Recommended Village','Recommended SubRD Loc ID','Group','Cluster','Highway','City/Village','Taluk','District','State'],'value'=>[]]];
        $highway['highway_retailer']=[];
        $highway['subrd_list']=[];
        $column=[];
        $value_data=[];
    
        $aHighWayInputs = explode(',',$request->get('highway_id'));
        $user = Auth::user();
        $userid = $user->id;
        $subrd_id=[];
        $head='';
        $str='';

        $qHighway = HighwayOutlet::select(
          'highway_outlet.refid as outlet_id','highway_outlet.subrd_id','b.refid as highway_id','b.highway_info','b.highway_name','b.start_point','b.end_point','b.length','highway_outlet.ccp_id','highway_outlet.ccp_name','highway_outlet.address','highway_outlet.ccp_latitude as latitude','highway_outlet.ccp_longitude as longitude','highway_outlet.group_type','highway_outlet.channel','highway_outlet.status','highway_outlet.stocking_confictionary','highway_outlet.stocking_chocolate','b.length','c.state','c.taluk','c.district','c.village','c.subrd_code',DB::raw('if(c.subrd_type=2,c.loc14,"") as recommand_locid'),'c.subrd_lat','c.subrd_lon','c.subrd_type','c.address as subrd_address','c.contact_no',DB::raw('if(c.subrd_type=1,c.subrd_name,"") as subrd_name'),DB::raw('if(c.subrd_type=2,c.subrd_name,"") as recomend_subrd_name'),DB::raw('if(c.subrd_type=1,"Actual SubRD","Recomnd SubRD Location") as subrd_name_type'),DB::raw('if(c.subrd_type=1,"SubRD Code","BI Location ID") as subrd_title'),'c.subrd_type',DB::raw('if( highway_outlet.group_type=1,"Group A","Group B") as group_name'),'highway_outlet.group_type','highway_outlet.cluster','c.subrd_markt_uid as subrd_market_id','c.state','c.district','c.taluk','c.village')
          ->join('highway_structure as b','highway_outlet.highway_id','=','b.refid')
          ->join('highway_subrd as c','highway_outlet.subrd_id','=','c.refid')
          ->whereIn('highway_outlet.highway_id',$aHighWayInputs);

        if($request->has('channel_type'))
            $qHighway->where('highway_outlet.channel',$request->get('channel_type'));
        elseif($request->has('subrd_code'))
            $qHighway->where('c.subrd_code',$request->get('subrd_code'));

        $res = $qHighway->get()->toArray();
        $message=[];
        if($request->has('highway_id')) {
          foreach($aHighWayInputs as $iHighway){
            $oHighWay = HighwayOutlet::where('highway_id',$iHighway)->with('highwayName')->first();
            $sHWName = $oHighWay->highwayName['highway_name'];
            $loadmap ="http://192.168.10.49/mapshapes/highway_path/" . str_replace(' ','',$sHWName) .".geojson";
               
            if (!in_array($loadmap, $highway["maplist"])) {
                array_push($highway["maplist"], $loadmap);
            }
          }
        }
        
        $potential_list=[];
        $insertedHighways = [];
        $total_potential=count($res);
        for($s=0;$s<$total_potential;$s++)
        {
            $cluster_name=($res[$s]['cluster']==0) ? '' :'C'.$res[$s]['cluster'];
             
            // $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['outlet_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['ccp_name'].'</a>','<a href="#" style="text-decoration:underline;" onClick="show_highway(0,\''.$res[$s]['channel'].'\')">'.$res[$s]['channel'].'</a>',$res[$s]['address'], '<a href="#" style="text-decoration:underline;" onClick="show_highway(0,\'\',\''.$res[$s]['subrd_code'].'\')">'.$res[$s]['subrd_code'].'</a>',$res[$s]['subrd_name'],$res[$s]['subrd_market_id'],$res[$s]['subrd_name_type'],$res[$s]['recomend_subrd_name'],$res[$s]['recommand_locid'],$res[$s]['group_name'],$cluster_name,'<a href="#" style="text-decoration:underline;" onClick="show_highway('.$res[$s]['highway_id'].')">'.$res[$s]['highway_name'].'</a>',$res[$s]['village'],$res[$s]['taluk'],$res[$s]['district'],$res[$s]['state']
            //     );

            $val_data = array(
                'row_id' => $s+1,
                'ccp_name' => $res[$s]['ccp_name'],
                'lat' => $res[$s]['latitude'],
                'lng' => $res[$s]['longitude'],
                'ccp_id' => $res[$s]['outlet_id'],
                'channel' => $res[$s]['channel'],
                'address' => $res[$s]['address'],
                'subrd_code' => $res[$s]['subrd_code'],
                'subrd_name' => $res[$s]['subrd_name'],
                'subrd_market_id' => $res[$s]['subrd_market_id'],
                'subrd_name_type' => $res[$s]['subrd_name_type'],
                'recomend_subrd_name' => $res[$s]['recomend_subrd_name'],
                'recommand_locid' => $res[$s]['recommand_locid'],
                'group_name' => $res[$s]['group_name'],
                'cluster' => $cluster_name,
                'highway_name' => $res[$s]['highway_name'],
                'highway_id' => $res[$s]['highway_id'],
                'village' => $res[$s]['village'],
                'taluk' => $res[$s]['taluk'],
                'district' => $res[$s]['district'],
                'state' => $res[$s]['state']
            );

            array_push($value_data,$val_data);
            
            if(!in_array($res[$s]['highway_id'], $insertedHighways))
            {
                array_push($insertedHighways,$res[$s]['highway_id']);
                $highway_id=$res[$s]['highway_id'];
                $higway_potential=array_filter($res, function($k,$v) use ($highway_id) {
                    return $k['highway_id'] == $highway_id;
                }, ARRAY_FILTER_USE_BOTH);
                 
                $tempHighway=[];
                $tempHighway['highway_id'] = $res[$s]['highway_id'];
                $tempHighway['highway_potential']=count($higway_potential);
                array_push($potential_list,$tempHighway['highway_potential']);
                $tempHighway['highway_name']=$res[$s]['highway_name'];                
                $highway_=str_replace(" ", "",$res[$s]['highway_name']);

                $tempHighway['info']=[];
                array_push($tempHighway['info'],array(
                    "key" => "Highway Name",
                    "value" => $res[$s]['highway_name'],
                    "type" => "text"
                ));

                array_push($tempHighway['info'],array(
                    "key" => "Highway Info",
                    "value" => $res[$s]['highway_info'],
                    "type" => "text"
                ));

                array_push($tempHighway['info'],array(
                    "key" => "Stretch Length",
                    "value" => $res[$s]['length'],
                    "type" => "number"
                ));

                array_push($tempHighway['info'],array(
                    "key" => "Outlet Potential",
                    "value" => $tempHighway['highway_potential'].' Nos.',
                    "type" => "text"
                ));

                array_push($highway['mapdata'],$tempHighway);
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
                $temp['Village']=$res[$s]['village'];
                $temp['Taluk']=$res[$s]['taluk'];
                $temp['District']=$res[$s]['district'];
                if($res[$s]['subrd_type']==1)
                {
                    $temp['color']='#3cb64a';
                    $temp['icon']='highway/actual_subrd.png';            
                }
                if($res[$s]['subrd_type']==2)
                {
                  $temp['color']='#f37121';
                  $temp['icon']='highway/recomnd_subrd.png';          
                }
              
                $subrd_name=($res[$s]['subrd_name']!='') ? $res[$s]['subrd_name'] : $res[$s]['recomend_subrd_name'].' Villg.';

                $temp['info'] = [];
                array_push($temp['info'],array(
                    "key" => "SubRD Name",
                    "value" => $subrd_name,
                    "type" => "text"
                ));

                array_push($temp['info'],array(
                    "key" => "SubRD Title",
                    "value" => $res[$s]['subrd_title'],
                    "type" => "text"
                ));

                array_push($temp['info'],array(
                    "key" => "SubRD Code",
                    "value" => $res[$s]['subrd_code'],
                    "type" => "number"
                ));

                array_push($temp['info'],array(
                    "key" => "SubRD Type",
                    "value" => $res[$s]['subrd_name_type'],
                    "type" => "text"
                ));

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
                    "key" => "Taluk",
                    "value" => $res[$s]['taluk'],
                    "type" => "text"
                ));

                if($res[$s]['subrd_type']==1)
                    array_push($temp['info'],array(
                        "key" => "Village",
                        "value" => $res[$s]['village'],
                        "type" => "text"
                    ));

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
            $temp['Village']=$res[$s]['village'];
            $temp['Taluk']=$res[$s]['taluk'];
            $temp['District']=$res[$s]['district'];
            if(!in_array($res[$s]['subrd_id'],$subrd_id))
                array_push($subrd_id,$res[$s]['subrd_id']);


            $subrd_name_=($res[$s]['subrd_name']!='') ? $res[$s]['subrd_name'] : $res[$s]['recomend_subrd_name'];
            $subrd_code_title=($res[$s]['subrd_type']==1) ? 'SubRD Code' : 'Bi Location id';
            $subrd_name_title=($res[$s]['subrd_type']==1) ? 'SubRD Name' : 'Recommended Location';

            $temp['subrd_code_title']=$subrd_code_title;
            $temp['subrd_code']=$res[$s]['subrd_code'];
            $temp['subrd_name']=$subrd_name_;
            $temp['subrd_name_title']=$subrd_name_title;

            $temp['info'] = [];
            array_push($temp['info'],array(
                "key" => "Retailer Address",
                "value" => $res[$s]['address'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Channel",
                "value" => $res[$s]['channel'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => $subrd_code_title,
                "value" =>  $res[$s]['subrd_code'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => $subrd_name_title,
                "value" => $subrd_name_,
                "type" => "text"
            ));

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
                "key" => "Taluk",
                "value" => $res[$s]['taluk'],
                "type" => "text"
            ));

            array_push($temp['info'],array(
                "key" => "Village",
                "value" => $res[$s]['taluk'],
                "type" => "text"
            ));

            array_push($highway['highway_retailer'],$temp);

        }

        $max=1;$min=1;
        if(count($potential_list) > 0)
        {
             $max=max($potential_list);
             $min=min($potential_list);
        }

        foreach ($highway['mapdata'] as $key => $value) {
            if(isset($value['highway_potential'])) {
                $color_critiea=((float)$value['highway_potential']/(float)$max)*100;
                $remain=$max-$min;
                if($remain==0){
                    //$color="hsl(".$this->isolate[0].", ".$this->isolate[1]."%, ".$this->isolate[2]."%)";
                    $color = CommonController::converHslToHex((int)$this->isolate[0],(int)$this->isolate[1],(int)$this->isolate[2]);
                }
                if($remain!=0)
                {
                    $delta=((float)$value['highway_potential']-$min)/$remain;
                    $color=CommonController::getColor($max, $min, $delta,$this->low,$this->high,true);
                }

                // $out = CommonController::hsv2rgb($this->isolate[0],$this->isolate[1],$this->isolate[2]);
                // echo '<pre>';
                // var_dump($out);
                // exit;
                
                $highway['mapdata'][$key]['color']=$color;
            }
        }
        
        $highway['tabledata']['value']=$value_data;
        $highway['legend'] = array(
            ['name' => 'Actual SubRD', 'value' => 'http://192.168.10.49/locaview/public/highway/actual_subrd.png'],
            ['name' => 'Recommended SubRD', 'value' => 'http://192.168.10.49/locaview/public/highway/recomnd_subrd.png'],
            ['name' => 'Group A', 'value' => 'http://192.168.10.49/locaview/public/highway/group_a_retailer.png'],
            ['name' => 'Group B', 'value' => 'http://192.168.10.49/locaview/public/highway/group_b_retailer.png']
        );
        $message['result']=$highway;     
        $message['label'] = '';
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['tbl'] = '';
        $message['head'] = trim($head,","). ' Highway(s)';
        $message['highway_id'] = $request->get('highway_id');
        $message['current_location'][0] = $request->get('current_location')[0];
        $message['current_location'][1] = $request->get('current_location')[1];
        return response()->json($message);
    }
}