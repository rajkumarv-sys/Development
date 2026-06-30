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

class FilterController extends Controller
{
    public $successStatus = 200;    
    public $filenotfound = 404;
    public $failure =500;
    private $isolate=[166, 63, 26];
    private $low=[5,69,54];
    private $high=[151,83,34];

    public function Cityfilter(Request $request)
    {
         $message=[];
        $input = $request->all();
        $user = Auth::user();
        $client_id = $user->client_id;
        $tbl=[120=>'mdlz_rd_outlets',112=>'coke_uncvrd_outlets',133=>'pepsi_uncvrd_outlets'];
        $getBeat="select distinct city,city_id from ".$tbl[$user->client_id]."";
        $getBeat_res = DB::select(DB::raw($getBeat));
        $message=['status'=>true,'message'=>'City Data.','data'=>[]];
        for($i=0;$i<count($getBeat_res);$i++)
        {
               array_push($message['data'],['city'=>$getBeat_res[$i]->city,'city_id'=>$getBeat_res[$i]->city_id]);
        }
        return response()->json($message, $this->successStatus);

    }
    public function nbhrdfilter(Request $request)
    {
         $message=[];
        $input = $request->all();
        $user = Auth::user();
        $client_id = $user->client_id;    
        $tbl=[120=>'mdlz_rd_outlets',112=>'coke_uncvrd_outlets',133=>'pepsi_uncvrd_outlets'];
        $getBeat="select distinct loc15,nbhrd from ".$tbl[$client_id]." where city_id=".$input['city_id']." and loc15!=0 order by nbhrd asc";
        $getBeat_res = DB::select(DB::raw($getBeat));
        $message=['status'=>true,'message'=>'Ward Data.','data'=>[]];
        $ward_list=[];
        for($i=0;$i<count($getBeat_res);$i++)
        {
            if(!in_array($getBeat_res[$i]->loc15,$ward_list))
            {
                  array_push($ward_list,$getBeat_res[$i]->loc15);
                  array_push($message['data'],['ward'=>$getBeat_res[$i]->nbhrd,'ward_id'=>$getBeat_res[$i]->loc15]);

            }

             
        }
        return response()->json($message, $this->successStatus);

    }

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
     $input = $request->all();
      $user = Auth::user();
       $message=['covered'=>[],'uncovered'=>[],'ward_id'=>[$input['ward_id']],'tabledata'=>['column'=>['#','Retailer ID','Name','Type','Sub Type','Potential Status','Address','Contact','RD Code','RD Name','Beat Name','City','Neighborhood','Status'],'value'=>[]]];
       if($user->client_id==112)
         $message=['covered'=>[],'uncovered'=>[],'ward_id'=>[$input['ward_id']],'tabledata'=>['column'=>['#','Retailer ID','Name','Type','Sub Type','Potential Status','Address','Contact','City','Neighborhood','Status'],'value'=>[]]];
         if($user->client_id==133)
         $message=['covered'=>[],'uncovered'=>[],'ward_id'=>[$input['ward_id']],'tabledata'=>['column'=>['#','Retailer ID','Name','Sub Type','Potential Status','Address','Contact','City','Neighborhood','Status'],'value'=>[]]];
    
       $loc15=explode(",",$input['ward_id']);
   $filter_str='';
   if(isset($input['sub_type']) && $input['sub_type']!='')
         $filter_str .='and channel_type="'.$input['sub_type'].'"';
    $covered_tbl=[120=>'mdlz_urban_outlet_master',133=>'pepsi_uncvrd_outlets'];
   
   if(isset($covered_tbl[$user->client_id]))
   {
      $covered_sql="SELECT `refid`,`loc12`, locality,`name`, `channel_type`, nbhrd ,`address`, `latitude`, `longitude`,locality, `stat`,city,'' as shop_image,rd_code,rd_name,beat_name FROM `mdlz_urban_outlet_master` where stat='A' and latitude!=0 and longitude!=0 and loc15 in (".$input['ward_id'].") order by refid asc";
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);


         $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {

                $temp=[];
                
              $temp['icon']='https://analytics.brandidea.com/bilocaview/public/images/mdlz_covered.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
               $temp['retailer_name']=$covered_res[$s]['name'];
                $temp['address']=$covered_res[$s]['address'];
                $temp['retailer_id']=$covered_res[$s]['refid'];
                 $temp['city']=$covered_res[$s]['city'];
                     $temp['locality']=$covered_res[$s]['locality'];

                     $temp['nbhrd']=$covered_res[$s]['nbhrd'];


                  $temp['info']=[];
          
             
            
               array_push($temp['info'],['key'=>'Name','value'=>$covered_res[$s]['name'],'type'=>'text']);
                 array_push($temp['info'],['key'=>'Sub Channel','value'=>$covered_res[$s]['channel_type'],'type'=>'text']);
               array_push($temp['info'],['key'=>'Address','value'=>$covered_res[$s]['address'],'type'=>'text']);
                array_push($temp['info'],['key'=>'RD Code','value'=>$covered_res[$s]['rd_code'],'type'=>'text']);
              array_push($temp['info'],['key'=>'RD Name','value'=>$covered_res[$s]['rd_name'],'type'=>'text']);
               array_push($temp['info'],['key'=>'Beat Name','value'=>$covered_res[$s]['beat_name'],'type'=>'text']);

              

                 array_push($message['covered'],$temp);
        }
      
    
   }
      $tbl=[120=>'mdlz_rd_outlets',112=>'coke_uncvrd_outlets',133=>'pepsi_uncvrd_outlets'];
       $uncovered=DB::table($tbl[$user->client_id])->select( "refid", "retailer_id", "name", "type", "sub_type", "outlet_potential", "locality_name", "nbhrd", "address", "latitude", "longitude", "contact", "beat_id", "icon", "shop_image", "status",DB::raw("if(status='N','New',if(status='A','Found',if(status='NF','Not Found',''))) as outlet_status"),DB::raw("if(fld1923=3,'High',if(fld1923=2,'Medium',if(fld1923=1,'Low',''))) as outlet_potential_status"),"loc15","loc16", "beat_id", "fld1923", "city_id", "city", "beat_name as beat_name","rd_code","rd_name");

      

       if(isset($loc15) && $loc15!='')
         $uncovered=$uncovered->whereIn("loc15",$loc15);
        if(isset($input['type']) && $input['type']!='')
         $uncovered=$uncovered->where([['type','=',$input['type']]]);
        if(isset($input['sub_type']) && $input['sub_type']!='')
         $uncovered=$uncovered->where([['sub_type','=',$input['sub_type']]]);
       if(isset($input['potential']) && $input['potential']!='')
         $uncovered=$uncovered->where([['outlet_potential','=',$input['potential']]]);
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

      
       $cluster_list=[];

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
            $temp['id']=$uncovered[$k]->refid;
           ///  $temp['apt_for']=$uncovered[$k]->app_status;
           
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
            $temp['outlet_status']=$uncovered[$k]->outlet_potential_status;
             $temp['status']=$uncovered[$k]->status;
            $temp['locality']=$uncovered[$k]->locality_name;
            $temp['beat_name']=$uncovered[$k]->beat_name;
            $temp['info']=[];
            $temp['picked_shop_image']=(isset($imagelist[$uncovered[$k]->retailer_id])) ? $imagelist[$uncovered[$k]->retailer_id] : [];
            array_push($temp['info'],['key'=>'Name','value'=>$uncovered[$k]->name,'type'=>'text']);
            array_push($temp['info'],['key'=>'Channel','value'=>$uncovered[$k]->type,'type'=>'text']);
            array_push($temp['info'],['key'=>'Sub-Channel','value'=>$uncovered[$k]->sub_type,'type'=>'text']);
            array_push($temp['info'],['key'=>'Address','value'=>$uncovered[$k]->address,'type'=>'text']);
            if($user->client_id!=112 && $user->client_id!=133)
            {
                array_push($temp['info'],['key'=>'RD Code','value'=>$uncovered[$k]->rd_code,'type'=>'text']);
            array_push($temp['info'],['key'=>'RD Name','value'=>$uncovered[$k]->rd_name,'type'=>'text']);
            array_push($temp['info'],['key'=>'Beat Name','value'=>$uncovered[$k]->beat_name,'type'=>'text']);
            }
            
            array_push($message['uncovered'],$temp);
            $temp=[];
            if($user->client_id==120)
            $temp=['row_id'=>$k+1,'retailer_ID'=>$uncovered[$k]->retailer_id,'Name'=>$uncovered[$k]->name,'Type'=>$uncovered[$k]->type,'Sub Type'=>$uncovered[$k]->sub_type,'Potential Status'=>$uncovered[$k]->outlet_potential_status,'Address'=>$uncovered[$k]->address,'Contact'=>$uncovered[$k]->contact,'RD Code'=>$uncovered[$k]->rd_code,'RD Name'=>$uncovered[$k]->rd_name,'Beat Name'=>$uncovered[$k]->beat_name,'City'=>$uncovered[$k]->city,'Neighborhood'=>$uncovered[$k]->nbhrd,'Status'=>$uncovered[$k]->outlet_status];
            if($user->client_id==112)
            $temp=['row_id'=>$k+1,'retailer_ID'=>$uncovered[$k]->retailer_id,'Name'=>$uncovered[$k]->name,'Type'=>$uncovered[$k]->type,'Sub Type'=>$uncovered[$k]->sub_type,'Potential Status'=>$uncovered[$k]->outlet_potential_status,'Address'=>$uncovered[$k]->address,'Contact'=>$uncovered[$k]->contact,'City'=>$uncovered[$k]->city,'Neighborhood'=>$uncovered[$k]->nbhrd,'Status'=>$uncovered[$k]->outlet_status];
         if($user->client_id==133)
            $temp=['row_id'=>$k+1,'retailer_ID'=>$uncovered[$k]->retailer_id,'Name'=>$uncovered[$k]->name,'Sub Type'=>$uncovered[$k]->sub_type,'Potential Status'=>$uncovered[$k]->outlet_potential_status,'Address'=>$uncovered[$k]->address,'Contact'=>$uncovered[$k]->contact,'City'=>$uncovered[$k]->city,'Neighborhood'=>$uncovered[$k]->nbhrd,'Status'=>$uncovered[$k]->outlet_status];
             $temp['info']=[];
             array_push($temp['info'],['key'=>'row_id','value'=>$k+1,'type'=>'number']);
             array_push($temp['info'],['key'=>'retailer_ID','value'=>$uncovered[$k]->retailer_id,'type'=>'number']);
             array_push($temp['info'],['key'=>'Name','value'=>$uncovered[$k]->name,'type'=>'text']);
             array_push($temp['info'],['key'=>'type','value'=>$uncovered[$k]->type,'type'=>'text']);
             array_push($temp['info'],['key'=>'sub_type','value'=>$uncovered[$k]->sub_type,'type'=>'text']);
             array_push($temp['info'],['key'=>'Outlet Potential status','value'=>$uncovered[$k]->outlet_status,'type'=>'text']);
             array_push($temp['info'],['key'=>'Address','value'=>$uncovered[$k]->address,'type'=>'text']);
             array_push($temp['info'],['key'=>'Contact','value'=>$uncovered[$k]->contact,'type'=>'number']);
              array_push($temp['info'],['key'=>'RD Code','value'=>$uncovered[$k]->rd_code,'type'=>'text']);
               array_push($temp['info'],['key'=>'RD Name','value'=>$uncovered[$k]->rd_name,'type'=>'text']);
               array_push($temp['info'],['key'=>'Beat Name','value'=>$uncovered[$k]->beat_name,'type'=>'text']);
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
   
    /* public function  outlet_action(Request $request)
    {
        $message=['message'=>'Outlet updated','status'=>true];
        $input = $request->all();
        $retailer_id=$input['retailer_id'];
        $action=$input['action'];
        $lat = $input["lat"];
        $lon = $input["lon"];
        $user=Auth::user();

        $message['action_status']= $input["action"];
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");
        $tbl = [
        120 => 'mdlz_rd_outlets',
        112 => 'coke_uncvrd_outlets',
        133 => 'pepsi_uncovered_outlets'
        ];

        // Check if table exists for this client
        if (!isset($tbl[$user->client_id])) {
            return response()->json([
                'error' => 'Table not found for client.'
            ], 400);
        }

        try {
            $result = DB::table($tbl[$user->client_id])
                ->where('retailer_id', $input['retailer_id'])
                ->update([
                    'status' => $input['action'],
                    'user_lat' => $lat,
                    'user_lon' => $lon,
                    'created_date' => $date,
                ]);

            if ($result === 0) {
                // No rows updated
                return response()->json([
                    'error' => 'No matching retailer found or update failed.'
                ], 404);
            }

            // Success
            return response()->json([
                'message' => 'Update successful.'
            ], 200);

        } catch (\Exception $e) {
            // Catch any DB errors
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);
        }

        return response()->json($message, $this->successStatus);
    }*/

public function outlet_action(Request $request)
{
    date_default_timezone_set("Asia/Kolkata");

    $user = auth()->user();

    // ✅ Validation
    $request->validate([
        'retailer_id' => 'required',
       // 'action'      => 'required',
        'lat'         => 'required|numeric',
        'lon'         => 'required|numeric',
        'image'       => 'nullable|string'
    ]);

    $fieldName  = $request->field_name;
    $retailer_id = $request->retailer_id;
    $action      = $request->action;
    $lat         = $request->lat;
    $lon         = $request->lon;
    $imageInput  = $request->image;

    $date = now();

    // ✅ Table mapping
    $tbl = [
        120 => 'mdlz_rd_outlets',
        112 => 'coke_uncvrd_outlets',
        133 => 'pepsi_uncovered_outlets'
    ];

    $imageTable = 'jj_outlet_image';

    if (!isset($tbl[$user->client_id])) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid client mapping'
        ], 400);
    }

    if($user->id == 20895)
    {
        $tbl[$user->client_id] ='suresh_uncovered_outlets';
    }

    $tableName = $tbl[$user->client_id];

    // ✅ 1. Get outlet location
    $outlet = DB::table($tableName)
        ->where('retailer_id', $retailer_id)
        ->select('latitude', 'longitude')
        ->first();

    if (!$outlet) {
        return response()->json([
            'status' => false,
            'message' => 'Outlet not found'
        ], 404);
    }

    // ✅ 2. Calculate distance
    $distance = $this->calculateDistance($lat, $lon, $outlet->latitude, $outlet->longitude);

    // ✅ 3. Block if > 50 meters
    if ($distance > 50) {
        return response()->json([
            'status' => false,
            'message' => 'Warning: Distance is more than 50 meters!',
            'distance' => round($distance, 2) . ' meters'
        ], 403);
    } 

    DB::beginTransaction();

    try {

      if($action!='' && $fieldName!='')
        {
            $updated = DB::table($tableName)
            ->where('retailer_id', $retailer_id)
            ->update([
                $fieldName => $action,
                'user_lat' => $lat,
                'user_lon' => $lon,
                'command'  => 'Updated from mobile. Field: '.$fieldName.' Value: '.$action
            ]);
        }
       
        // ✅ 4. Update outlet
        

        /*if (!$updated) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Retailer not found or no change'
            ], 404);
        }*/

        $imagePath = null;

        // ✅ 5. Image upload
        if (!empty($imageInput)) {

            if (preg_match('/^data:image\/(\w+);base64,/', $imageInput, $type)) {
                $imageData = substr($imageInput, strpos($imageInput, ',') + 1);
                $extension = strtolower($type[1]);

                if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    throw new \Exception('Invalid image type');
                }

            } else {
                throw new \Exception('Invalid base64 format');
            }

            $imageData = base64_decode($imageData);

            if ($imageData === false) {
                throw new \Exception('Base64 decode failed');
            }

            $filename = time() . '_' . $retailer_id . '.' . $extension;

            $folderPath = public_path('shop_image/pepsi/urban/');

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            file_put_contents($folderPath . '/' . $filename, $imageData);

            $imagePath = 'shop_image/pepsi/urban/' . $filename;

            // ✅ Save image record
            DB::table($imageTable)->insert([
                'outlet_id'    => $retailer_id,
                'user_id'      => $user->id,
                'outlet_image' => $imagePath,
                'created_date' => $date,
                'status'       => 'A',
                'client_id'    => $user->client_id,
                'command'      => 'image uploaded from mobile app',
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Outlet updated successfully',
            'distance' => round($distance, 2) . ' meters',
            'image_uploaded' => $imagePath ? true : false,
            'image_url' => $imagePath ? url($imagePath) : null
        ], 200);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
    
private function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000; // meters

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
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
        $client_id = $req->client_id;
        $getdata_tbl=[1000=>'haldirams_sample_data_cluster',120=>'mdlz_rd_outlets',133=>'pepsi_uncvrd_outlets'];
        if(in_array($client_id,[120,0,1000,133]))
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

 /* public function pepsi_getuncovereddata(Request $input)
{
    $input_query = (object) $input['input'];
    $user = Auth::user();
    $userid = $user->id;

    // 🔒 Location lock
   // if ($user->lock_lat != 0) {
       // $input['current_location'][0] = $user->lock_lat;
       // $input['current_location'][1] = $user->lock_long;
    //}

    $column = $this->buildColumns($userid);

    $rd_str = '';
    $exit_rd = '';
    $nc_rd = '';
    $statuses = [];

    // 📏 Distance filter
    if (!empty($input_query->filter_distance) && isset($input['current_location'])) {
        $distance = "(ST_Distance_Sphere(point(longitude, latitude), point({$input['current_location'][1]},{$input['current_location'][0]})) *.000621371192) < {$input_query->filter_distance}";
        $rd_str .= " AND $distance";
        $exit_rd .= " AND $distance";
    }

    // 📦 Channel filter
    if (!empty($input_query->filter_bychannel)) {
        $channels = implode("','", $input_query->filter_bychannel);
        $rd_str .= " AND a.sub_type IN ('$channels')";

        // 👉 Apply to covered only when PC/PUC NOT selected
        if (!in_array("PC", $input_query->filter_bystatus ?? []) &&
            !in_array("PUC", $input_query->filter_bystatus ?? [])) {
            $exit_rd .= " AND sub_type IN ('$channels')";
        }
    }

    // 🎯 Potential filter
    if (!empty($input_query->filter_bypotential)) {
        $rd_str .= " AND a.fld1923 IN (" . implode(",", $input_query->filter_bypotential) . ")";
    } else {
        $rd_str .= " AND a.fld1923 IN (3,2)";
    }

    // 📌 Status filter
    if (!empty($input_query->filter_bystatus)) {

        $status = implode("','", $input_query->filter_bystatus);
        $rd_str .= " AND a.status IN ('$status')";

        // 👉 PC / PUC logic
        if (in_array("PC", $input_query->filter_bystatus)) {
            $statuses[] = "'PC'";
        }
        if (in_array("PUC", $input_query->filter_bystatus)) {
            $statuses[] = "'PUC'";
        }

        if (!empty($statuses)) {
            $nc_rd = " AND statuss IN (" . implode(",", $statuses) . ")";
        } else {
            $nc_rd = "";
        }

        // 👉 If BOTH NOT selected → remove restriction
        if (!in_array("PC", $input_query->filter_bystatus) &&
            !in_array("PUC", $input_query->filter_bystatus)) {
            $nc_rd = "";
        }
    }

    // 🗺 Beat filter
    if (!empty($input_query->filter_beat) && $input_query->filter_beat[0] != null) {

        $beats = implode(",", $input_query->filter_beat);
        $rd_str .= " AND a.loc16 IN ($beats)";

        if (!in_array("PC", $input_query->filter_bystatus ?? []) &&
            !in_array("PUC", $input_query->filter_bystatus ?? [])) {
            $exit_rd .= " AND loc16 IN ($beats)";
        }
    }

    // 🔥 DEFAULT PC/PUC CONDITION (VERY IMPORTANT — missing in your code)
    if ($nc_rd == '') {
        $nc_rd = " AND statuss IN ('PC','PUC')";
    }

    // ================= SQL ==================

    if ($userid == 13289) {

        $covered_sql = "
            SELECT ccp_id,refid,loc12,loc15,loc16,retailer_name as name,address,contact,latitude,longitude,
            sub_type as channel_type,segmentation,city as city_name,nbhrd,locality,'A' as stat,'' as shop_image,statuss
            FROM pepsi_covered_outlets
            WHERE latitude!=0 AND longitude!=0
            $exit_rd $nc_rd
            ORDER BY refid ASC
        ";

        /*$sql = "
            SELECT a.ccp_id,a.refid,a.retailer_id,a.name,a.type,a.sub_type,a.outlet_potential,a.fld1923,a.address,
            a.contact,a.latitude,a.longitude,a.city_id,a.loc15,a.loc16,a.city,a.nbhrd,a.locality_name,
            a.loc15 as beat_id,a.beat_name,a.rd_code,a.rd_name,a.stat,a.status,
            IF(a.status='A','Found',IF(a.status='NF','Not Found','New')) as outlet_status,
            a.shop_image,a.icon,b.outlet_image,a.snack_purchase,a.outlet_stock
            FROM pepsi_uncovered_outlets a
            LEFT JOIN jj_outlet_image b ON a.retailer_id=b.outlet_id
            WHERE stat='A' $rd_str
            ORDER BY refid ASC
        ";
       
          $sql = "
            SELECT a.retailer_id,a.name,a.type,a.sub_type,a.outlet_potential,a.address,
            a.contact,a.latitude,a.longitude,a.city,a.nbhrd,a.locality_name,
            a.rd_name,a.stat,a.status,
            IF(a.status='A','Found',IF(a.status='NF','Not Found','New')) as outlet_status,
            a.shop_image,a.icon,b.outlet_image,a.snack_purchase,a.outlet_stock
            FROM pepsi_uncovered_outlets a
            LEFT JOIN jj_outlet_image b ON a.retailer_id=b.outlet_id
            WHERE stat='A' $rd_str
            ORDER BY refid ASC
        ";

    } else {

        $covered_sql = "
            SELECT ccp_id,refid,loc12,loc15,loc16,retailer_name as name,address,contact,latitude,longitude,
            sub_type as channel_type,segmentation,city as city_name,nbhrd,locality,'A' as stat,'' as shop_image,statuss
            FROM pepsi_covered_outlets
            WHERE latitude!=0 AND longitude!=0 AND ccp_id=0
            $exit_rd $nc_rd
            ORDER BY refid ASC
        ";

      /*  $sql = "
            SELECT a.ccp_id,a.refid,a.retailer_id,a.name,a.type,a.sub_type,a.outlet_potential,a.fld1923,a.address,
            IF(a.contact=''||a.contact=0,'NA',a.contact) as contact,
            a.latitude,a.longitude,a.city_id,a.loc15,a.loc16,a.city,a.nbhrd,a.locality_name,
            a.loc15 as beat_id,a.beat_name,a.rd_code,a.rd_name,a.stat,a.status,
            IF(a.status='A','Found',IF(a.status='NF','Not Found','New')) as outlet_status,
            a.shop_image,a.icon,a.snack_purchase,a.outlet_stock
            FROM pepsi_uncovered_outlets a
            WHERE stat='A' $rd_str
            ORDER BY refid ASC
        ";

        $sql = "SELECT a.retailer_id,a.name,a.type, a.sub_type,a.outlet_potential,a.address,a.contact, a.latitude,  a.longitude, a.city, a.nbhrd,a.locality_name, a.rd_name,a.stat,a.status, IF(a.status='A','Found',
        IF(a.status='NF','Not Found','New') ) as outlet_status, a.shop_image,a.icon, b.outlet_image, a.snack_purchase, a.outlet_stock FROM pepsi_uncovered_outlets a LEFT JOIN (SELECT outlet_id, MAX(outlet_image) as outlet_image
       FROM jj_outlet_image GROUP BY outlet_id) b ON a.retailer_id = b.outlet_id WHERE a.stat='A' $rd_str ORDER BY a.refid ASC";

    }

    // 🚀 Limit
    $sql .= " LIMIT 1000";
    $covered_sql .= " LIMIT 1000";

    \Log::info($covered_sql);

    // ✅ Convert to array
    $covered_res = json_decode(json_encode(DB::select($covered_sql)), true);
    $res = json_decode(json_encode(DB::select($sql)), true);

    // ✅ Merge
    $final = array_merge($res, $covered_res);

    return response()->json([
        'status' => true,
        'message' => ' Go open outlet in HHD',
        'griddata' => $column,
        'data' => $final,
        'legend' => [
            'uncovered' => [
                ['label' => 'Found', 'color' => '#2ecc71'],
                ['label' => 'Not Found', 'color' => '#bdc3c7'],
                ['label' => 'Added to HHD (BI Outlet)', 'color' => '#3498db'],
                ['label' => 'Added to HHD (Non BI Outlet)', 'color' => '#8e44ad'],
                ['label' => 'Locked location', 'color' => '#e74c3c',
                   'icon'  => url('rural_icon/lock-location.png')
                ]
            ],
            'store_potential' => [
                ['label' => 'High', 'color' => '#2ecc71'],
                ['label' => 'Medium', 'color' => '#ff8b02'],
                ['label' => 'Low', 'color' => 'red']
            ]
        ]
    ]);
}*/

public function pepsi_getuncovereddata(Request $request)
{
    try {

        $input_query = (object) $request['input'];

        $user = Auth::user();
        $userid = $user->id;

        $column = $this->buildColumns($userid);

        $rd_str   = "";
        $exit_rd = "";
        $nc_rd   = "";

        // =====================================================
        // DISTANCE FILTER (FAST BOUNDING BOX)
        // =====================================================

        if (
            !empty($input_query->filter_distance) &&
            isset($request['current_location'][0]) &&
            isset($request['current_location'][1])
        ) {

            $lat = (float) $request['current_location'][0];
            $lon = (float) $request['current_location'][1];

            // miles to KM
            $km = (float)$input_query->filter_distance * 1.60934;

            $lat_range = $km / 111;

            $lon_range = $km / (111 * cos(deg2rad($lat)));

            $minLat = $lat - $lat_range;
            $maxLat = $lat + $lat_range;

            $minLon = $lon - $lon_range;
            $maxLon = $lon + $lon_range;

            $rd_str .= "
                AND a.latitude BETWEEN $minLat AND $maxLat
                AND a.longitude BETWEEN $minLon AND $maxLon
            ";

            $exit_rd .= "
                AND latitude BETWEEN $minLat AND $maxLat
                AND longitude BETWEEN $minLon AND $maxLon
            ";
        }

        // =====================================================
        // CHANNEL FILTER
        // =====================================================

        if (!empty($input_query->filter_bychannel)) {

            $channels = array_map(function ($item) {
                return "'" . addslashes($item) . "'";
            }, $input_query->filter_bychannel);

            $channels = implode(",", $channels);

            $rd_str .= " AND a.sub_type IN ($channels)";

            if (
                !in_array("PC", $input_query->filter_bystatus ?? []) &&
                !in_array("PUC", $input_query->filter_bystatus ?? [])
            ) {
                $exit_rd .= " AND sub_type IN ($channels)";
            }
        }

        // =====================================================
        // POTENTIAL FILTER
        // =====================================================

        if (!empty($input_query->filter_bypotential)) {

            $potential = implode(",", array_map('intval', $input_query->filter_bypotential));

            $rd_str .= " AND a.fld1923 IN ($potential)";
        } else {

            $rd_str .= " AND a.fld1923 IN (2,3)";
        }

        // =====================================================
        // STATUS FILTER
        // =====================================================

        if (!empty($input_query->filter_bystatus)) {

            $statuses = array_map(function ($item) {
                return "'" . addslashes($item) . "'";
            }, $input_query->filter_bystatus);

            $status_string = implode(",", $statuses);

            $rd_str .= " AND a.status IN ($status_string)";

            $covered_status = [];

            if (in_array("PC", $input_query->filter_bystatus)) {
                $covered_status[] = "'PC'";
            }

            if (in_array("PUC", $input_query->filter_bystatus)) {
                $covered_status[] = "'PUC'";
            }

            if (!empty($covered_status)) {

                $nc_rd = " AND statuss IN (" . implode(",", $covered_status) . ")";
            }
        }

        // =====================================================
        // DEFAULT PC / PUC
        // =====================================================

        if ($nc_rd == "") {

            $nc_rd = " AND statuss IN ('PC','PUC')";
        }

        // =====================================================
        // BEAT FILTER
        // =====================================================

        if (
            !empty($input_query->filter_beat) &&
            $input_query->filter_beat[0] != null
        ) {

            $beats = implode(",", array_map('intval', $input_query->filter_beat));

            $rd_str .= " AND a.loc16 IN ($beats)";

            if (
                !in_array("PC", $input_query->filter_bystatus ?? []) &&
                !in_array("PUC", $input_query->filter_bystatus ?? [])
            ) {
                $exit_rd .= " AND loc16 IN ($beats)";
            }
        }

        // =====================================================
        // COVERED SQL
        // =====================================================

        if($userid == 20895)
        {
            $table_name='suresh_uncovered_outlets';
             $rd_str ='';
              $beats = '';
        }
        else
            {
                $table_name='pepsi_uncovered_outlets';
            }
        if ($userid == 13289) {

            $covered_sql = "
                SELECT
                    retailer_name AS name,
                    address,
                    contact,
                    latitude,
                    longitude,
                    sub_type AS channel_type,
                    segmentation,
                    city AS city_name,
                    nbhrd,
                    locality,
                    'A' AS stat,
                    statuss

                FROM pepsi_covered_outlets

                WHERE latitude != 0
                AND longitude != 0

                $exit_rd
                $nc_rd

                LIMIT 1000
            ";

        } else {

            $covered_sql = "
                SELECT
                    retailer_name AS name,
                    address,
                    contact,
                    latitude,
                    longitude,
                    sub_type AS channel_type,
                    segmentation,
                    city AS city_name,
                    nbhrd,
                    locality,
                    'A' AS stat,
                    statuss

                FROM pepsi_covered_outlets

                WHERE latitude != 0
                AND longitude != 0
                AND ccp_id = 0

                $exit_rd
                $nc_rd

                LIMIT 1000
            ";
        }

        // =====================================================
        // UNCOVERED SQL
        // =====================================================

       $sql = "
    SELECT
        a.retailer_id,
        a.name,
        a.type,
        a.sub_type,
        a.outlet_potential,
        a.address,

        IF(a.contact = '' OR a.contact = 0, 'NA', a.contact) AS contact,

        a.latitude,
        a.longitude,
        a.city,
        a.nbhrd,
        a.locality_name,
        a.rd_name,
        a.stat,
        a.status,

        CASE
            WHEN a.status = 'A' THEN 'Found'
            WHEN a.status = 'NF' THEN 'Not Found'
            ELSE 'New'
        END AS outlet_status,

        a.shop_image,
        a.icon,

        img.outlet_image,

        a.snack_purchase,
        a.outlet_stock

    FROM {$table_name} a

    LEFT JOIN (
        SELECT
            outlet_id,
            MAX(outlet_image) AS outlet_image
        FROM jj_outlet_image
        GROUP BY outlet_id
    ) img
        ON img.outlet_id = a.retailer_id

    WHERE a.stat = 'A'
    {$rd_str}

    LIMIT 1000
";
  //\Log::info('Outlet Query: '.$sql);
        // =====================================================
        // QUERY EXECUTION
        // =====================================================

        $res = DB::select($sql);

        $covered_res = DB::select($covered_sql);

        // =====================================================
        // MERGE
        // =====================================================

       // $final = [...$res, ...$covered_res];
       $final = array_merge($res, $covered_res);

        // =====================================================
        // RESPONSE
        // =====================================================

        return response()->json([
            'status'  => true,
            'message' => 'Go open outlet in HHD',
            'griddata' => $column,
            'count'   => count($final),
            'data'    => $final,

            'legend' => [

                'uncovered' => [

                    [
                        'label' => 'Found',
                        'color' => '#2ecc71'
                    ],

                    [
                        'label' => 'Not Found',
                        'color' => '#bdc3c7'
                    ],

                    [
                        'label' => 'Added to HHD (BI Outlet)',
                        'color' => '#3498db'
                    ],

                    [
                        'label' => 'Added to HHD (Non BI Outlet)',
                        'color' => '#8e44ad'
                    ],

                    [
                        'label' => 'Locked location',
                        'color' => '#e74c3c',
                        'icon'  => url('rural_icon/lock-location.png')
                    ]
                ],

                'store_potential' => [

                    [
                        'label' => 'High',
                        'color' => '#2ecc71'
                    ],
                    [
                        'label' => 'Medium',
                        'color' => '#ff8b02'
                    ],

                    [
                        'label' => 'Low',
                        'color' => 'red'
                    ]
                ]
            ]

        ], 200);

    } catch (\Exception $e) {

       // \Log::error('pepsi_getuncovereddata Error : ' . $e->getMessage());

        return response()->json([
            'status'  => false,
            'message' => 'Service temporarily unavailable',
            'error'   => $e->getMessage()
        ], 500);
    }
}
    private function buildColumns($userid)
    {
        $cols = [
            ['title' => '#', 'className' => 'text-left'],
            ['title' => 'Retailer ID', 'className' => 'text-right'],
            ['title' => 'Name', 'className' => 'text-left'],
            ['title' => 'Sub Type', 'className' => 'text-left'],
            ['title' => 'Potential Status', 'className' => 'text-left'],
            ['title' => 'Address', 'className' => 'text-left'],
            ['title' => 'Contact', 'className' => 'text-right'],
            ['title' => 'City', 'className' => 'text-left'],
            ['title' => 'Neighborhood', 'className' => 'text-left'],
            ['title' => 'Status', 'className' => 'text-left'],
        ];

        if ($userid != 13878) {
            $cols[] = ['title' => 'Is PepsiCo Snacks Visible in the outlet?', 'className' => 'text-left'];
            $cols[] = ['title' => 'Outlet purchase stock from?', 'className' => 'text-left'];
        }

        return $cols;
    }

    private function buildResponse($res, $columns)
    {
        return [
            'status' => true,
            'message' => 'map loaded successfully.',
            'griddata' => [
                'column' => $columns,
                'value' => $res
            ],
            'data' => [
                'exist_rd' => $res,
                'rd_list' => $res
            ]
        ];
    }

    /**
     * ✅ NEW API ENDPOINT
     */
public function pepsi_getsubrd_new(Request $request)
{
    try {

        $maparray         = $request->maparray ?? [];
        $type             = $request->type ?? '';
        $main_location    = $request->main_location ?? '';
        $sub_location     = $request->sub_location ?? '';
        $input_obj        = $request->input_obj ?? [];
        $current_location = $request->current_location ?? [];

        $response = $this->Combine_subrd_pepsi(
            $maparray,
            $type,
            $main_location,
            $sub_location,
            $input_obj,
            $current_location
        );

        return response()->json([

            'status'  => true,
            'message' => 'Data fetched successfully',

            // ✅ MAP DATA
            'data' => $response['mapdata'] ?? [],

            // ✅ ADD THIS
            'maplist' => $response['maplist'] ?? [],

            // ✅ OTHER DATA
            'legend'      => $response['legend'] ?? [],
            'child_list'  => $response['child_list'] ?? [],
            'tabledata'   => $response['tabledata'] ?? [],
            'action_list' => $response['action_list'] ?? []

        ]);

    } catch (\Exception $e) {

        \Log::error('pepsi_getsubrd_new error : ' . $e->getMessage());

        return response()->json([

            'status'  => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()

        ], 500);
    }
}


/**
 * Combine SubRD Pepsi
 */
public function Combine_subrd_pepsi(
    $maparray,
    $type,
    $main_location,
    $sub_location,
    $input_obj,
    $current_location
    )
 {

        // =========================
        // FILTERS
        // =========================

        $getfilter = is_array($input_obj)
            ? (object)$input_obj
            : json_decode($input_obj);

        $type_view = !empty($getfilter->type_view)
            ? array_map('intval', explode(",", $getfilter->type_view))
            : [];

        // =========================
        // SPECIAL CASE
        // =========================

        if (in_array(4, $type_view)) {

            return $this->Combine_krishnagiri_subrd(
                $maparray,
                $type,
                $main_location,
                $sub_location,
                $input_obj,
                $current_location
            );
        }

        $user = auth()->user();

    // =========================
    // TABLE SELECTION
    // =========================

    if (
        ($user->role == 'HO' || $user->role == 'SM')
        && $user->client_id == 112
    ) {

        $table = 'coke_subrd_data_all';

    } else {

        $tbllist = [
            120  => 'subrd_data',
            123  => 'subrd_data_perfetti',
            112  => 'coke_subrd_data',
            133  => 'pepsi_subrd_data',
            1000 => 'subrd_data_haldiram',
            9999 => 'subrd_data_mars'
        ];

        $table = $tbllist[$user->client_id] ?? 'subrd_data';
    }

    // =========================
    // QUERY
    // =========================

    $query = DB::table($table . ' as a')
        ->join('town_village_polygon as b', function ($join) {

            $join->on('a.village_census', '=', 'b.town_village_code')
                 ->on('a.taluk_census', '=', 'b.taluk_code');

        })
        ->where('b.stat', 'A');

   // =========================
    // FILTERS
    // =========================

    if (!empty($getfilter->filter_state)) {
        $query->whereIn('a.loc7', $getfilter->filter_state);
    }

    // Changed from an OR group to strict AND conditions
    if (!empty($getfilter->filter_district)) {
        $query->whereIn('a.loc9', $getfilter->filter_district);
    }

    if (!empty($getfilter->filter_taluk)) {
        $query->whereIn('a.taluk_census', $getfilter->filter_taluk);
    }

    if (!empty($getfilter->filter_priority)) {
        $query->where('a.subrd_priority', $getfilter->filter_priority);
    }

    if (!empty($getfilter->filter_existsubrd)) {
        $query->where('a.exist_subrd_code', $getfilter->filter_existsubrd);
    }

    // =========================
    // TYPE FILTER
    // =========================

    if (in_array(30, $type_view)) {

        $query->whereIn('a.subrd_type', [1, 0]);

    } elseif (in_array(31, $type_view)) {

        $query->whereIn('a.subrd_type', [5, 0]);

    } elseif (in_array(32, $type_view)) {

        $query->whereIn('a.subrd_type', [2, 0]);
    }

    // =========================
    // FETCH
    // =========================
   // \Log::info($query->toSql());
   //\Log::info($query->getBindings());
   $result = $query
    ->select(
        'a.*',
        'b.latitude',
        'b.longitude'
    )
    ->get();

/*
|--------------------------------------------------------------------------
| Cluster Child Count
|--------------------------------------------------------------------------
*/
$clusterCounts = $result
    ->groupBy('cluster_id')
    ->map(function ($items) {
        return $items->count();
    })
    ->toArray();
        

    // =========================
    // MAP LIST
    // =========================
    
    $maplist = [];

    // District selected
    if (!empty($getfilter->filter_district)) {

    $district_id = $getfilter->filter_district[0];

    $firstRow = $result->first();

    if ($firstRow) {

        $state_id = $firstRow->loc7;

         $loadmap =
            "mapshapes/district_village/" . 
            $state_id . "/" .
            $district_id . "_9" .
            $main_location . "_13" .
            $sub_location . ".geojson";

        $maplist[] =
            "https://analytics.brandidea.com/" . $loadmap;
    }

    } else {

    // Taluk GeoJSON

    $taluks = !empty($getfilter->filter_taluk)
        ? $getfilter->filter_taluk
        : $result->pluck('taluk_census')
            ->unique()
            ->values()
            ->toArray();

    foreach ($taluks as $taluk_id) {

        $firstRow = $result
            ->where('taluk_census', $taluk_id)
            ->first();

        if (!$firstRow) {
            continue;
        }

        $state_id    = $firstRow->loc7;
        $district_id = $firstRow->loc9;

        $loadmap =
            "mapshapes/district_taluk/" .
            $state_id . "/" .
            $district_id . "/" .
            $taluk_id . "_10" .
            $main_location . "_13" .
            $sub_location . ".geojson";

        $maplist[] =
            "https://analytics.brandidea.com/" . $loadmap;
    }
    }

    $maplist = array_values(array_unique($maplist));

    // =========================
    // COLORS
    // =========================

    $color = [
        'green',
        'red',
        'lavender',
        'pink',
        'orange',
        'fgreen',
        'chaani'
    ];

    // =========================
    // PRIORITY ICONS
    // =========================

    $priority_icons = [
        'Priority 1' => 'rural_icon/r_p1.png',
        'Priority 2' => 'rural_icon/r_p2.png',
        'Priority 3' => 'rural_icon/r_p3.png',
        ''           => 'rural_icon/efficient-subrd.png'
    ];

    // =========================
    // MAP DATA
    // =========================

$result = $result->map(function ($row) use (
    $color,
    $type_view,
    $priority_icons,
    $clusterCounts
) {

        $split_color = 'none';

        $row->child_count = $clusterCounts[$row->cluster_id] ?? 0;

        $hub = CommonController::getcolor_bysubrd('none');

        // HUB

        if (
            $row->is_hub == 1
            && in_array($row->subrd_type, $type_view)
        ) {

            if ($row->subrd_type == 1) {

                $hub = CommonController::getcolor_bysubrd('d_blue');

            } elseif ($row->subrd_type == 2) {

                $split_color = $color[array_rand($color)];

                $hub = CommonController::getcolor_bysubrd(
                    'd_' . $split_color
                );

            } elseif ($row->subrd_type == 3) {

                $hub = CommonController::getcolor_bysubrd('d_fgreen');

            } elseif ($row->subrd_type == 5) {

                $split_color = $color[array_rand($color)];

                $hub = CommonController::getcolor_bysubrd(
                    'd_' . $split_color
                );
            }

        } elseif (
            $row->is_hub != 1
            && $row->subrd_type != 0
        ) {

            // NON HUB

            if ($row->subrd_type == 1) {

                $hub = ($row->active_stat == 'No')
                    ? CommonController::getcolor_bysubrd('yellow')
                    : CommonController::getcolor_bysubrd('l_grey');

            } elseif ($row->subrd_type == 2) {

                $split_color = $color[array_rand($color)];

                $hub = CommonController::getcolor_bysubrd(
                    'l_' . $split_color
                );

            } elseif ($row->subrd_type == 3) {

                $hub = CommonController::getcolor_bysubrd('l_fgreen');

            } elseif ($row->subrd_type == 5) {

                $split_color = $color[array_rand($color)];

                $hub = CommonController::getcolor_bysubrd(
                    'l_' . $split_color
                );
            }
        }

        $row->color = $hub;

        // =========================
        // MARKERS
        // =========================

        switch ($row->subrd_type) {

            case 1:
                $row->subrd_marker = 'rural_icon/ED.png';
                $row->subrd_marker_value = 'ED';
                break;

            case 2:
                $row->subrd_marker =
                    $priority_icons[$row->subrd_priority]
                    ?? 'rural_icon/r_p1.png';
                     $row->subrd_marker_value = 'r_p1';
                break;

            case 3:
                $row->subrd_marker = 'rural_icon/Wholesale.png';
                $row->subrd_marker_value = 'Wholesale';
                break;

            case 5:
                $row->subrd_marker = 'rural_icon/ND.png';
                 $row->subrd_marker_value = 'ND';
                break;

            default:
                $row->subrd_marker = 'NA';
                $row->subrd_marker_value = 'NA';
        }

        return $row;
    });

    // =========================
    // SUMMARY
    // =========================

    $anchor_locations = $result
        ->where('is_hub', 1)
        ->count();

    $villages_covered = $result->count();

    $villages_to_merge = $result
        ->filter(function ($r) {
            return $r->subrd_type == 1
                && $r->active_stat == 'No';
        })
        ->count();

    $new_villages = $result
        ->where('subrd_type', 5)
        ->count();

    // =========================
    // LEGEND
    // =========================

    $legend = [

        'summary' => [

            [
                'label' => 'Anchor Locations',
                'value' => (string)$anchor_locations
            ],

            [
                'label' => 'Villages Covered',
                'value' => (string)$villages_covered
            ],

            [
                'label' => 'Villages To Merge',
                'value' => (string)$villages_to_merge
            ],

            [
                'label' => 'New Villages',
                'value' => (string)$new_villages
            ]
        ],

        'items' => [

            [
                'label' => 'Current/Active Village',
                'color' => '#BDBDBD'
            ],

            [
                'label' => 'Potential Active Villg to Merge',
                'color' => '#FFFF00'
            ],

            [
                'label' => 'Existing Distr Anchor',
                'color' => '#00008B'
            ],

            [
                'label' => 'Existing Distr - Active Village',
                'color' => '#ADD8E6'
            ]
        ],

        'rpi' => [

            [
                'label' => 'MD',
                'value' => 'Most Developed'
            ],

            [
                'label' => 'D',
                'value' => 'Developed'
            ],

            [
                'label' => 'T',
                'value' => 'Transition'
            ],

            [
                'label' => 'UD',
                'value' => 'Under Developed'
            ],

            [
                'label' => 'NR',
                'value' => 'Not Rated'
            ]
        ],

        'notes' => [

            [
                'label' => 'Zoom Note',
                'value' => 'Zoom into view RPI'
            ],

            [
                'label' => 'Other Dark Note',
                'value' => 'Other Dark Color(s): Recommended Distributor Anchor Location'
            ],

            [
                'label' => 'Lighter Note',
                'value' => 'Lighter Shade of Same Color: New Spoke Locations'
            ]
        ]
    ];

    // =========================
    // ACTION LIST
    // =========================

    $action_list = [

        [
            'name' => 'Exist Subrd Hub',
            'img'  => asset('rural_icon/efficient-subrd.png')
        ],

        [
            'name' => 'Urban Distributor Hub',
            'img'  => asset('rural_icon/urban-distributor.png')
        ],

        [
            'name' => 'Recommended Subrd Hub',
            'img'  => asset('rural_icon/recommendation.png')
        ],

        [
            'name' => 'Wholesale',
            'img'  => asset('rural_icon/Wholesale.png')
        ]
    ];

    // =========================
    // FINAL RESPONSE
    // =========================

        return [

            'mapdata'     => $result,
            'maplist'     => $maplist,
            'legend'      => $legend,
            'child_list'  => [],
            'tabledata'   => [],
            'action_list' => $action_list

        ];
}

    /**
     * OPTIONAL: EXISTING METHOD PLACEHOLDER
     */
    public function Combine_krishnagiri_subrd($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {
        return [];
    }


   public function user_lock_action(Request $request)
    {
        // ✅ Validate first
    if( $request->lock_status == 1)
    {
            $request->validate([
            'user_id' => 'required',
            'lat' => 'required',
            'lon' => 'required',
            'lock_status' => 'required|in:0,1'
        ]);
    }
    else
        {
            $request->validate([
            'user_id' => 'required',
            'lock_status' => 'required|in:0,1'
            ]);
    
        }
   

    try {
        $result = DB::table('users')
            ->where('id', $request->user_id)
            ->update([
                'lock_status' => $request->lock_status,
                'lock_lat'    => $request->lat,
                'lock_long'   => $request->lon,
                'updated_at'  => now(),
                'command'     => 'user locked location in mobile app',
            ]);

        if ($result === 0) {
            return response()->json([
                'error' => 'No matching user found or update failed.',
                 'status' => false
            ], 404);
        }

        return response()->json([
            'message' => 'User lock updated successfully.',
            'status' => true
           
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'status' => false
        ], 500);
    }
}

}