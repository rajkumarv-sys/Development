<?php

namespace App\Http\Controllers;

use App\Models\MasterKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\User;
use DB;

class ShowoutletController extends Controller
{
    public function index()
    {

      
    }
    public function show()
    {
    	
    }
      public static function cokedata($input)
    {
        $input_query=json_decode($input['input']);
        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['rd_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
         
           array_push($column, array(
             'title' => 'Channel', 'className' => 'text-left'
         ));
           
            
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
          
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Outlet Potential', 'className' => 'text-left'
         ));
         
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
          }
           if(isset($input_query->filter_potential) && ($input_query->filter_potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->filter_potential."'"; 
          }
            if(isset($input_query->filter_channel) && ($input_query->filter_channel!='')  )
          {
             $rd_str .=" and a.sub_type in ('".join("','",$input_query->filter_channel)."')"; 
          }
         
           if(isset($input_query->filter_status) && ($input_query->filter_status!='')  )
          {
             $rd_str .=" and a.status in ('".join("','",$input_query->filter_status)."')"; 
          }
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
            
          }
       
         
          if(isset($input_query->filter_bynbhrd) && (count($input_query->filter_bynbhrd) > 0)  )
          {
             if($input_query->filter_bynbhrd[0]!=null){
                 $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_bynbhrd).")"; 
            
             }
            
          }
         

         
      // if(isset($input['current_location']))
      //     {
      //        $rd_str .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
             
      //     } 
 
         $sql="SELECT  a.retailer_id, a.city, a.`nbhrd` as nbhrd, a.name, a.`address`, a.`latitude`, a.`longitude`, a.contact, a.`icon`, a.`shop_image`,a.status,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.`fld1923`,if(a.`fld1923`=1,'Low',if(a.`fld1923`=2,'Medium',if(a.`fld1923`=3,'High',''))) as outlet_potential, a.`type`, a.`beat_id`, a.`city_id`, a.`city`, a.`sub_type` FROM `coke_uncvrd_outlets` as a left join (SELECT `refid`, `outlet_id`, `user_id`, `outlet_image`, `created_date`, `status`, `client_id` FROM `jj_outlet_image` where client_id='".auth()->user()->client_id."') as b on a.refid=b.outlet_id where a.stat='A' and a.icon!='' ".$rd_str."  order by a.refid asc";
//echo $sql;die;
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
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
          
        for($s=0;$s<$total_potential;$s++)
        { 
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="coke_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>',$res[$s]['address'],$res[$s]['city'],$res[$s]['nbhrd'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="coke_filter(\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            { 
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                array_push($dist_list['dist'],$res[$s]['nbhrd']);
             
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                 $temp['status']=$res[$s]['status'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span>'.$res[$s]['sub_type'].'</p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><hr style="border-top: 1px solid white;"><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_coke(\'A\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_coke(\'NF\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);


            }
               

        }
        
        $message['legend']=[];
        
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
       
        $head='';
        $dist_list['dist']=array_unique($dist_list['dist']);
            $head=implode(",",$dist_list['dist']);
        
            
        $message['head'] =$head. ' N\'bhrd (s)';
         return json_encode($message);
    }
     public static function ck_getrd($input)
    {

        $input_query=json_decode($input['input']);

        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['uncovered_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Locality', 'className' => 'text-left'
         ));
             
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Relevant', 'className' => 'text-left'
         ));
              array_push($column, array(
             'title' => 'Has Cooler', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


          if(isset($input_query->city_id) && ($input_query->city_id !=0)  )
          {
             $rd_str .=" and a.city_id=".$input_query->city_id.""; 
             $exit_rd .=" and loc12=".$input_query->city_id."";
          }
          //   if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
          // {
          //   if($input_query->sub_location==15)
          //   {
          //        $rd_str .=" and a.loc15=".$input_query->ward_id.""; 
          //       $exit_rd .=" and loc15=".$input_query->ward_id."";
          //   }
          //   else
          //   {
          //        $rd_str .=" and a.loc16=".$input_query->ward_id.""; 
          //       $exit_rd .=" and loc16=".$input_query->ward_id."";
          //   }

            
          // }
           if(isset($input_query->filter_nbhrd) && (count($input_query->filter_nbhrd) > 0)  )
          {
             $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_nbhrd).")"; 
             $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_nbhrd).")";
          }
          // // if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // // {
          // //    $rd_str .=" and a.rd_code in (".implode(',',$input_query->filter_rd).")"; 
          // //    $exit_rd .=" and RD_code in (".implode(',',$input_query->filter_rd).")";
          // // }
           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             if(is_array($input_query->filter_bychannel))
                 {
                     $rd_str .=" and a.type  in ('".implode("','",$input_query->filter_bychannel)."')"; 

                 }
                 else
                 {
                     $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
                 }
            
          }
           if(isset($input_query->filter_bypotential) && ($input_query->filter_bypotential!='')  )
          {
             $rd_str .=" and a.fld1923 in (".implode(',',$input_query->filter_bypotential).")"; 
          }
          
          if(isset($input_query->filter_bystatus) && ($input_query->filter_bystatus!='')  )
          {
             $rd_str .=" and a.status in  ('".implode("','",$input_query->filter_bystatus)."')";
             

          }
          
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             $exit_rd .=" and channel_type ='".$input_query->filter_bysubchannel."'";  
          }
          if(isset($input_query->locality) && ($input_query->locality!='')  )
          {
             $rd_str .=" and a.loc16 ='".$input_query->locality."'"; 
             $exit_rd .=" and loc16 ='".$input_query->locality."'"; 
          }
          // if(isset($input_query->premium_index) && ($input_query->premium_index!='')  )
          // {
          //    $rd_str .=" and a.beat_premium_index ='".$input_query->premium_index."'"; 
          //    $exit_rd .=" and premium_index_name ='".$input_query->premium_index."'"; 
             
          // }
          // if(isset($input_query->snacking_index) && ($input_query->snacking_index!='')  )
          // {
          //    $rd_str .=" and a.beat_snacking_index ='".$input_query->snacking_index."'"; 
          // }
          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
          // // if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // // {
          // //    if($input_query->filter_beat[0]!=null){
          // //        $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_beat).")"; 
          // //    $exit_rd .=" and fld1995 in (".implode(',',$input_query->filter_beat).")";
          // //    }
            
          // // }
          //   if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // {
          //    if($input_query->filter_beat[0]!=null){
          //        $rd_str .=" and a.loc16 in (".implode(',',$input_query->filter_beat).")"; 
          //    $exit_rd .=" and loc16 in (".implode(',',$input_query->filter_beat).")";
          //    }
            
          // }
        //$input['current_location']=[19.13645800,72.88651360];
          //  if(isset($input['current_location']))
          // {
          //    $rd_str .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
          //     $exit_rd .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
          // } 
 
      $covered_sql="SELECT `refid`,`loc12`,  `name`, `channel_type`, `address`, `latitude`, `longitude`,`stat`,nbhrd,locatlity,city_name,'' as shop_image FROM `ckpl_mumbai_outlet_master` where loc12=13346 and stat='A' and latitude!=0 and longitude!=0 ".$exit_rd." order by refid asc";
    
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);
      // var_dump($covered_res);die; 

     //

       $sql="SELECT a.`refid`, `retailer_id`, `name`, `type`, `sub_type`, `outlet_potential`, `fld1923`, `address`, `contact`, `latitude`, `longitude`, `city_id`, `city`, `nbhrd`, `locality_name`, `stat`, a.`status`, a.`created_date`, `shop_image`, `icon`, `user_lat`,loc15,loc16, `user_lon`,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,if(a.relevant='R','Relevant',if(a.relevant='NR','Not Relevant','')) as outlet_relevant,if(a.cooler='C','Yes',if(a.cooler='NC','No','')) as outlet_cooler,relevant,cooler,b.outlet_id,b.user_id,b.outlet_image FROM `ckpl_uncvrd_outlets` as a  left join jj_outlet_image as b on a.retailer_id=b.outlet_id where a.period='New Data' and a.stat='A'   ".$rd_str." group by retailer_id order by refid asc";

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);


        if(isset($input_query->outlet_type))
        {
              if(!in_array(1,$input_query->outlet_type))
                 $covered_res=[];
             if(!in_array(2,$input_query->outlet_type))
                 $res=[];
        }

        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head_list=[];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
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
          $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {

                $temp=[];
                
              $temp['icon']='images/coveredblue_2.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
              $temp['refid']=$covered_res[$s]['refid'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$covered_res[$s]['locatlity'].' Locality</span><br><span style="line-height:1rem;">'.$covered_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city_name'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        for($s=0;$s<$total_potential;$s++)
        {
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\''.$res[$s]['loc16'].'\')">'.$res[$s]['locality_name'].'</a>',$res[$s]['outlet_status'],$res[$s]['outlet_relevant'],$res[$s]['outlet_cooler']);//

            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\''.trim($res[$s]['beat_snacking_index']).'\')">'.$res[$s]['beat_snacking_index'].'</a>',
            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\''.$res[$s]['beat_premium_index'].'\')">'.$res[$s]['beat_premium_index'].'</a>',

             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                $temp['locality_name']=$res[$s]['locality_name'];
                $temp['city']=$res[$s]['city'];
                $temp['nbhrd']=$res[$s]['nbhrd'];
                $temp['cooler']=$res[$s]['cooler'];
                $temp['relevant']=$res[$s]['relevant'];
                 $temp['status']=$res[$s]['status'];
                 $temp['name']=$res[$s]['name'];
                 $temp['outlet_potential']=$res[$s]['outlet_potential'];
                 $temp['contact']=$res[$s]['contact'];

                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
             $temp['style_code']= $style_code;
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';

               $relevant='';$not_relevant='';
              $relevant=($res[$s]['relevant']=='R') ? 'checked' : '';
              $not_relevant=($res[$s]['relevant']=='NR') ? 'checked' : '';

               $cooler='';$not_cooler='';
              $cooler=($res[$s]['cooler']=='C') ? 'checked' : '';
              $not_cooler=($res[$s]['cooler']=='NC') ? 'checked' : '';


              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';

             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
             $temp['circle_count']=$cicle_count;
            
             //  if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
             // {
             //    if($input_query->sub_location==15)
             //    {
             //        if(!in_array($res[$s]['nbhrd'],$head_list))
             //        array_push($head_list,$res[$s]['nbhrd']);
             //    } 
             //    else
             //      if(!in_array($res[$s]['locality_name'],$head_list))
             //        array_push($head_list,$res[$s]['locality_name']);

             // }
            
             //  else
             // {
                

             // }
             if(!in_array($res[$s]['nbhrd'],$head_list))
                    array_push($head_list,$res[$s]['nbhrd']);
                 $temp['info']='';


                 $temp['info'] .='</div>';

                 array_push($rd['uncovered_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        $head='';
        $head=implode(",",$head_list);
      
          $message['head'] =$head. ' N\'bhrd (s)';
         return json_encode($message);
    }
    public static function ckverify_getrd($input)
    {

        $input_query=json_decode($input['input']);

        
         $rd=[];
         $rd['beat_list']=[];         
         $rd['exist_rd']=[];
         $rd['uncovered_list']=[];
         $rd['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Locality', 'className' => 'text-left'
         ));
             
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
         
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


          if(isset($input_query->city_id) && ($input_query->city_id !=0)  )
          {
             $rd_str .=" and a.city_id=".$input_query->city_id.""; 
             $exit_rd .=" and loc12=".$input_query->city_id."";
          }
          //   if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
          // {
          //   if($input_query->sub_location==15)
          //   {
          //        $rd_str .=" and a.loc15=".$input_query->ward_id.""; 
          //       $exit_rd .=" and loc15=".$input_query->ward_id."";
          //   }
          //   else
          //   {
          //        $rd_str .=" and a.loc16=".$input_query->ward_id.""; 
          //       $exit_rd .=" and loc16=".$input_query->ward_id."";
          //   }

            
          // }
           if(isset($input_query->filter_nbhrd) && (count($input_query->filter_nbhrd) > 0)  )
          {
             $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_nbhrd).")"; 
             $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_nbhrd).")";
          }
          // // if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // // {
          // //    $rd_str .=" and a.rd_code in (".implode(',',$input_query->filter_rd).")"; 
          // //    $exit_rd .=" and RD_code in (".implode(',',$input_query->filter_rd).")";
          // // }
           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             if(is_array($input_query->filter_bychannel))
                 {
                     $rd_str .=" and a.type  in ('".implode("','",$input_query->filter_bychannel)."')"; 

                 }
                 else
                 {
                     $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
                 }
            
          }
           if(isset($input_query->filter_bypotential) && ($input_query->filter_bypotential!='')  )
          {
             $rd_str .=" and a.fld1923 in (".implode(',',$input_query->filter_bypotential).")"; 
          }
          
          if(isset($input_query->filter_bystatus) && ($input_query->filter_bystatus!='')  )
          {
             $rd_str .=" and a.status in  ('".implode("','",$input_query->filter_bystatus)."')"; 
          }
          
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             $exit_rd .=" and channel_type ='".$input_query->filter_bysubchannel."'";  
          }
          if(isset($input_query->locality) && ($input_query->locality!='')  )
          {
             $rd_str .=" and a.loc16 ='".$input_query->locality."'"; 
             $exit_rd .=" and loc16 ='".$input_query->locality."'"; 
          }
          // if(isset($input_query->premium_index) && ($input_query->premium_index!='')  )
          // {
          //    $rd_str .=" and a.beat_premium_index ='".$input_query->premium_index."'"; 
          //    $exit_rd .=" and premium_index_name ='".$input_query->premium_index."'"; 
             
          // }
          // if(isset($input_query->snacking_index) && ($input_query->snacking_index!='')  )
          // {
          //    $rd_str .=" and a.beat_snacking_index ='".$input_query->snacking_index."'"; 
          // }
          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          }
          // // if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // // {
          // //    if($input_query->filter_beat[0]!=null){
          // //        $rd_str .=" and a.beat_id in (".implode(',',$input_query->filter_beat).")"; 
          // //    $exit_rd .=" and fld1995 in (".implode(',',$input_query->filter_beat).")";
          // //    }
            
          // // }
          //   if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
          // {
          //    if($input_query->filter_beat[0]!=null){
          //        $rd_str .=" and a.loc16 in (".implode(',',$input_query->filter_beat).")"; 
          //    $exit_rd .=" and loc16 in (".implode(',',$input_query->filter_beat).")";
          //    }
            
          // }
        //$input['current_location']=[19.13645800,72.88651360];
          //  if(isset($input['current_location']))
          // {
          //    $rd_str .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
          //     $exit_rd .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < 0.248548';
          // } 
 
      $covered_sql="SELECT `refid`,`loc12`,  `name`, `channel_type`, `address`, `latitude`, `longitude`,`stat`,nbhrd,locatlity,city_name,'' as shop_image FROM `ckpl_mumbai_outlet_master` where loc12=13346 and stat='A' and latitude!=0 and longitude!=0 ".$exit_rd." order by refid asc";
    
           $covered_res = DB::select(DB::raw($covered_sql));
        $covered_res=CommonController::getarray($covered_res);
      // var_dump($covered_res);die; 

     //

       $sql="SELECT a.`refid`, `retailer_id`, `name`, `type`, `sub_type`, `outlet_potential`, `fld1923`, `address`, `contact`, `latitude`, `longitude`, `city_id`, `city`, `nbhrd`, `locality_name`, `stat`, a.`status`, a.`created_date`, `shop_image`, `icon`, `user_lat`,loc15,loc16, `user_lon`,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,if(a.relevant='R','Relevant',if(a.relevant='NR','Not Relevant','')) as outlet_relevant,if(a.cooler='C','Yes',if(a.cooler='NC','No','')) as outlet_cooler,relevant,cooler,b.outlet_id,b.user_id,b.outlet_image FROM `ckpl_uncvrd_outlets_test` as a  left join jj_outlet_image as b on a.retailer_id=b.outlet_id where a.period='New Data' and a.stat='A'   ".$rd_str." group by a.retailer_id  order by refid asc";

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);


        if(isset($input_query->outlet_type))
        {
              if(!in_array(1,$input_query->outlet_type))
                 $covered_res=[];
             if(!in_array(2,$input_query->outlet_type))
                 $res=[];
        }

        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head_list=[];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
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
          $covered_res_count=count($covered_res);
        for($s=0;$s<0;$s++)
        {

                $temp=[];
                
              $temp['icon']='images/coveredblue_2.png';               
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
              $temp['refid']=$covered_res[$s]['refid'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$covered_res[$s]['locatlity'].' Locality</span><br><span style="line-height:1rem;">'.$covered_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city_name'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        for($s=0;$s<$total_potential;$s++)
        {
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\''.$res[$s]['loc16'].'\')">'.$res[$s]['locality_name'].'</a>',$res[$s]['outlet_status']);//

            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\''.trim($res[$s]['beat_snacking_index']).'\')">'.$res[$s]['beat_snacking_index'].'</a>',
            //'<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\''.$res[$s]['beat_premium_index'].'\')">'.$res[$s]['beat_premium_index'].'</a>',

             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                $temp['locality_name']=$res[$s]['locality_name'];
                $temp['city']=$res[$s]['city'];
                $temp['nbhrd']=$res[$s]['nbhrd'];
                $temp['cooler']=$res[$s]['cooler'];
                $temp['relevant']=$res[$s]['relevant'];
                 $temp['status']=$res[$s]['status'];
                 $temp['name']=$res[$s]['name'];
                 $temp['outlet_potential']=$res[$s]['outlet_potential'];
                 $temp['contact']=$res[$s]['contact'];

                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
             $temp['style_code']= $style_code;
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';

               $relevant='';$not_relevant='';
              $relevant=($res[$s]['relevant']=='R') ? 'checked' : '';
              $not_relevant=($res[$s]['relevant']=='NR') ? 'checked' : '';

               $cooler='';$not_cooler='';
              $cooler=($res[$s]['cooler']=='C') ? 'checked' : '';
              $not_cooler=($res[$s]['cooler']=='NC') ? 'checked' : '';


              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';

             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
             $temp['circle_count']=$cicle_count;
              $temp['is_catgry_outlet']=$res[$s]['is_catgry_outlet'];;
            
             //  if(isset($input_query->ward_id) && ($input_query->ward_id !=0)  )
             // {
             //    if($input_query->sub_location==15)
             //    {
             //        if(!in_array($res[$s]['nbhrd'],$head_list))
             //        array_push($head_list,$res[$s]['nbhrd']);
             //    } 
             //    else
             //      if(!in_array($res[$s]['locality_name'],$head_list))
             //        array_push($head_list,$res[$s]['locality_name']);

             // }
            
             //  else
             // {
                

             // }
             if(!in_array($res[$s]['nbhrd'],$head_list))
                    array_push($head_list,$res[$s]['nbhrd']);
                 $temp['info']='';


                 $temp['info'] .='</div>';

                 array_push($rd['uncovered_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        $head='';
        $head=implode(",",$head_list);
      
          $message['head'] =$head. ' N\'bhrd (s)';
         return json_encode($message);
    }
    public static function pwc_getuncovereddata($input)
  {

     $input_query=json_decode($input['input']);
        
         $rd=[];         $rd['beat_list']=[];   $rd['exist_rd']=[];
         $rd['rd_list']=[];         $rd['map_list']=[];         $column=[];       $value_data=[];


         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

         
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
          
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
        
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          $head='';

        $covered_res=[];

     if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
      {
         $rd_str .=" and a.loc15  in ('".implode("','",$input_query->filter_beat)."')"; 
      }
        if(isset($input_query->filter_potential) && (count($input_query->filter_potential) > 0)  )
      {
         $rd_str .=" and a.fld1923  in ('".implode("','",$input_query->filter_potential)."')"; 
      }
         if(isset($input_query->filter_bychannel) && (count($input_query->filter_bychannel) > 0)  )
          {
             $rd_str .=" and a.store_type  in ('".implode("','",$input_query->filter_bychannel)."')"; 
          }
           
           
     $sql="SELECT a.`refid` as retailer_id, a.`loc12`, a.`loc15`, a.`bi_refid`, a.`city`, a.`ward` as nbhrd, a.`name`, a.`address`, a.`store_type` as type, a.`store_potential` as outlet_potential,a.fld1923, a.`contact`, a.`latitude`, a.`longitude`, a.`icon`, a.`shop_image`,  a.`stat`, a.`potential_status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.status,b.outlet_id,b.user_id,b.outlet_image  FROM `dabar_and_coloba_biotique` as a
           left join jj_outlet_image as b on a.refid=b.outlet_id where a.stat='A' ".$rd_str." order by a.refid asc";
   
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);

       
        
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head=[];
       
       
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
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
         
        
        for($s=0;$s<$total_potential;$s++)
        {
           if(!in_array($res[$s]['nbhrd'],$head))
             array_push($head,$res[$s]['nbhrd']);
            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', 
                '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
               
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];
                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
                
               
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span><a href="#" style="text-decoration:underline;cursor:pointer;color:#fff;" id="'.$res[$s]['type'].'"  onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a></p></p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'"><a onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')" style="text-decoration:underline;cursor:pointer;">'.$res[$s]['outlet_potential'].'</a></span> </p><hr style="border-top: 1px solid white;"><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].',0,0)"  id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$found.' >  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].',0,0)" id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        if(count($head)> 0)
             $message['head']=(strlen(implode(", ",$head)) > 10) ? $head[0].'...' : implode(", ",$head). ' N\'Bhrhd (s).';
        
        
         return json_encode($message);
  }
     public static function mdlz_outlet($input)
     {
         $input_query=json_decode($input['input']);
        
         $data=[];
         $data['beat_list']=[];         
         $data['exist_rd']=[];
         $data['rd_list']=[];
         $data['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
         
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'SubD Name', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'SubD Code', 'className' => 'text-left'
         ));
              array_push($column, array(
             'title' => 'Market UID', 'className' => 'text-right'
         ));
               array_push($column, array(
             'title' => 'Outlet Potential (Nos.)', 'className' => 'text-right'
         ));
                 array_push($column, array(
             'title' => 'MDLZ Cvrg Nos', 'className' => 'text-right'
         ));
               
                array_push($column, array(
             'title' => 'Population (Nos.)', 'className' => 'text-right'
         ));
                 array_push($column, array(
             'title' => 'Villg. Choc Consumption (Annual) (Rs.)', 'className' => 'text-right'
         ));
            
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


         $sql="SELECT  `refid`, `name`, `address`, `shop_image`, `subd_code`, `subd_name`, `state_name`, `district_name`, `taluk_name`, `city_village_name`, `loc14`, `rpi`, `sector`, `2011_census`, `market_UID`, `fmcg_retlr_univ_nos`, `mdlz_cvrg_nos`, `choc_consptn`, `popn`, `latitude`, `longitude`, `icon`,if(status='N','New',if(status='A','Found',if(status='NF','Not Found',''))) as status FROM `ooh_data`";

 

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
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
          
        for($s=0;$s<$total_potential;$s++)
        { 
             

            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['refid'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>',$res[$s]['address'],$res[$s]['subd_name'],$res[$s]['subd_code'],$res[$s]['market_UID'],number_format($res[$s]['fmcg_retlr_univ_nos'],0),number_format($res[$s]['mdlz_cvrg_nos'],0),number_format($res[$s]['choc_consptn'],0),number_format($res[$s]['popn'],0));
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['refid'], $retailer_id))
            { 
                array_push($retailer_id,$res[$s]['refid']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['refid'];             
                $temp['address']=$res[$s]['address'];               
                $temp['status']=$res[$s]['status']; 
                $temp['latitude']=$res[$s]['latitude'];
                $temp['longitude']=$res[$s]['longitude'];
                $temp['icon']=$res[$s]['icon'];
                $style_code='';$found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
             $cicle_count=(isset($imagelist[$res[$s]['refid']])) ? $imagelist[$res[$s]['refid']] : 0;
                //<span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br>
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$res[$s]['district_name'].' distt</span><br><span style="line-height:1rem;">'.$res[$s]['state_name'].' state</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Populatn (Nos.): </span>'.number_format($res[$s]['popn'],0).'  </p><p><span style="color:rgb(242, 101, 34)">Outlet Potential (Nos.): </span>'.number_format($res[$s]['fmcg_retlr_univ_nos'],0).'  </p><p><span style="color:rgb(242, 101, 34)">MDLZ Cvrg Nos: </span>'.number_format($res[$s]['mdlz_cvrg_nos'],0).'  </p><p><span style="color:rgb(242, 101, 34)">Villg. Choc Consmptn (Annual) (Rs.): </span>'.number_format($res[$s]['choc_consptn'],0).'  </p><p><span style="color:rgb(242, 101, 34)">Subrd Name: </span>'.$res[$s]['subd_name'].'  </p><p><span style="color:rgb(242, 101, 34)">Subrd Code: </span>'.$res[$s]['subd_code'].'  </p><p><span style="color:rgb(242, 101, 34)">Market UID: </span>'.$res[$s]['market_UID'].'  </p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"></div></div>';
                  array_push($data['rd_list'],$temp);
 
            }  
               

        }
        $message['legend']=[];
       
        
        $message['result']=$data;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        // $head='';
        // if(isset($input_query->filter_subrdbeat_district) && (count($input_query->filter_subrdbeat_district)>0))
        // {
        //     $dist_list['dist']=array_unique($dist_list['dist']);
        //     $head=implode(",",$dist_list['dist']). ' Distt(s) - ';
        // }
        // else
        // {
        //     $dist_list['sst']=array_unique($dist_list['sst']);
        //     $head=implode(",",$dist_list['sst']);
        // }
        // $message['head'] =$head. ' SST(s)';
         return json_encode($message);
     }
    public static function pepsi_getuncovereddata($input)
	{
          $input_query=json_decode($input['input']);
          //\Log::info($input['current_location']); 
        
        if(auth()->user()->lock_lat!=0) // location locked condition
        {
             $input['current_location'][0]=auth()->user()->lock_lat;
             $input['current_location'][1]=auth()->user()->lock_long;
        } // location locked condition

        //\Log::info($input['current_location']); 

         $rd=[];         $rd['beat_list']=[];   $rd['exist_rd']=[];
         $rd['rd_list']=[];         $rd['map_list']=[];         $column=[];       $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
         //    array_push($column, array(
         //     'title' => 'Estmtd. mthly Revenue (Rs.)', 'className' => 'text-left'
         // ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
        
         
         
          $user = auth()->user();
          $userid = $user->id;
          if($userid!=13878)
          {
             array_push($column, array(
             'title' => 'Is PepsiCo Snacks Visible in the outlet?', 'className' => 'text-left'
         ));
            
            array_push($column, array(
             'title' => 'Outlet purchase stock from?', 'className' => 'text-left'
         ));
          }
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd=''; $nc_rd="";
          $head='';
          $statuses = [];
           
          if(isset($input_query->filter_distance) && $input_query->filter_distance!=''  )
           {
             if(isset($input['current_location']))
          {
            //$input_query->filter_distance=$input_query->filter_distance*100;
             $rd_str .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < '.$input_query->filter_distance;
              $exit_rd .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < '.$input_query->filter_distance;
          } 
          //     $rd_str .=" and a.sub_type in ('".implode("','",$input_query->filter_bychannel)."')"; 
          // //   // $exit_rd .=" and channel ='".$input_query->filter_bychannel."'"; 
           }
          
          
          // if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          // {
          //    $rd_str .=" and a.loc15 in (".implode(',',$input_query->filter_rd).")"; 
          //    $exit_rd .=" and loc15 in (".implode(',',$input_query->filter_rd).")";
          // }
            if(isset($input_query->filter_bychannel) && (count($input_query->filter_bychannel) > 0)  )
           {
              $rd_str .=" and a.sub_type in ('".implode("','",$input_query->filter_bychannel)."')"; 

               if (!in_array("PC", $input_query->filter_bystatus) &&  !in_array("PUC", $input_query->filter_bystatus))
              {
                  $exit_rd .=" and sub_type in ('".implode("','",$input_query->filter_bychannel)."')";
              }

           }
		   
		   //  if(isset($input_query->filter_bysubchannel) && (count($input_query->filter_bysubchannel) > 0)  )
           // {
           //    $rd_str .=" and a.sub_type in ('".implode("','",$input_query->filter_bysubchannel)."')"; 
           //   $exit_rd .=" and sub_type in ('".implode("','",$input_query->filter_bysubchannel)."')";
           // }
          //  if(isset($input_query->filter_channel) && (count($input_query->filter_channel) > 0)  )
          // {
          //    $rd_str .=" and a.type  in ('".implode("','",$input_query->filter_channel)."')";
          //    // $exit_rd .=" and channel in ('".implode("','",$input_query->filter_channel)."')"; 
          // }
          // if(isset($input_query->filter_channel) && (count($input_query->filter_channel) > 0)  )
          // {
          //    $rd_str .=" and a.type  in ('".implode("','",$input_query->filter_channel)."')"; 
          // }
          if(isset($input_query->filter_bypotential) && (count($input_query->filter_bypotential) > 0)  )
           {
              $rd_str .=" and a.fld1923  in (".implode(",",$input_query->filter_bypotential).")"; 
           }
          else
          {
              $rd_str .=" and a.fld1923  in (3,2)"; 
          }

           if(isset($input_query->filter_bystatus) && (count($input_query->filter_bystatus) > 0)  )
           {
              $rd_str .=" and a.status  in ('".implode("','",$input_query->filter_bystatus)."')"; 

                 
                  //check condition  pc and puc if start
                  if (!empty($input_query->filter_bystatus)) {

                      if (in_array("PC", $input_query->filter_bystatus)) {
                          $statuses[] = "PC";
                      }

                      if (in_array("PUC", $input_query->filter_bystatus)) {
                          $statuses[] = "PUC";
                      }
                  }

                  if (!empty($statuses)) {
                      $quoted = array_map(function ($val) {
                          return "'".$val."'";
                      }, $statuses);

                      $nc_rd = " AND statuss IN (" . implode(",", $quoted) . ")";
                  } else {
                      // BOTH unchecked → no condition
                      $nc_rd = "";
                  } //check condition  pc and puc if end

                 if (!in_array("PC", $input_query->filter_bystatus) &&  !in_array("PUC", $input_query->filter_bystatus)) 
                  {
                     

                     // \Log::info("Tested value");
                     $nc_rd= " ";
                }
                // \Log::info($$input['current_location']);         
           }
          // if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          // {
          //    $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
             
          // }
          // if(isset($input_query->filter_revenue) && (count($input_query->filter_revenue) > 0)  )
          // {
          //    $rd_str .=" and a.revenue  in ('".implode("','",$input_query->filter_revenue)."')"; 
          // }
          

          // if(isset($input_query->filter_bypotential) && ($input_query->filter_bypotential!='')  )
          // {
          //    $rd_str .=" and a.fld1923 ='".$input_query->potential."'"; 
          // }
          //  if(isset($input_query->revenue) && ($input_query->revenue!='')  )
          // {
          //    $rd_str .=" and a.revenue ='".$input_query->revenue."'"; 
          // }
           if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
           {
             if($input_query->filter_beat[0]!=null){
                 $rd_str .=" and a.loc16 in (".implode(',',$input_query->filter_beat).")";
                 
                 if (!in_array("PC", $input_query->filter_bystatus) &&  !in_array("PUC", $input_query->filter_bystatus)) 
                 {
                     $exit_rd .=" and loc16 in (".implode(',',$input_query->filter_beat).")";
                 }
             }
            
           }
           


           if($user->id==13878) 
            {
                 $covered_sql="SELECT `refid`, `loc12`, `loc15`, `loc16`, `retailer_name` as name, `address`, `contact`, `latitude`, `longitude`, `sub_type` as channel_type, `segmentation`, `city` as city_name, `nbhrd`, `locality`,'A' as stat,'' as shop_image FROM `pepsi_covered_tbl` WHERE loc16=17379 and  latitude!=0 and longitude!=0 ".$exit_rd." order by refid asc";

                 

                  $sql="SELECT  a.`ccp_id`,a.`refid`,a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, a.`contact`, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`city` as city, a.`nbhrd`, a.`locality_name`,a.loc15 as beat_id, a.`beat_name`, a.`rd_code`,a. `rd_name`, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.is_catgry_outlet, a.shop_image,a.icon,b.outlet_id,b.user_id,b.outlet_image FROM `pepsi_uncovered_outlets` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A' and a.loc16=17379 ".$rd_str." order by refid asc";
    
            }
           

             if($user->id== 21035 ) //suresh login
            {

                  $covered_sql="SELECT `ccp_id`,`refid`, `loc12`, `loc15`, `loc16`, `retailer_name` as name, `address`, `contact`, `latitude`, `longitude`, `sub_type` as channel_type, `segmentation`, `city` as city_name, `nbhrd`, `locality`,'A' as stat,'' as shop_image,statuss FROM `pepsi_covered_outlets` WHERE latitude!=0 and longitude!=0 ".$exit_rd." and statuss ='PC'  order by refid asc";
                   
                 
                 $sql=" SELECT a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, if(a.`contact`='' || a.contact=0,'NA',a.contact) as contact, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`city` as city, a.`nbhrd`, a.`locality_name`,a.loc15 as beat_id, a.`beat_name`, a.`rd_code`,a. `rd_name`, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,a.outlet_stock,a.snack_purchase,a.is_catgry_outlet,if(a.snack_purchase='Y','Yes',if(a.snack_purchase='N','N','')) as snack,if(a.outlet_stock='W','Wholesale',if(a.outlet_stock='D','Distributor','')) as outletstock,group_concat(b.outlet_image)  FROM `pepsi_chennai_notfound_outlets` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str."  group by a.retailer_id,b.outlet_id order by refid asc";
            }

            
              //\Log::info($input['input']);
     
             if($user->id==13289) //BI User for covered outlets will come
            {

                if(isset($input_query->filter_bystatus) && (count($input_query->filter_bystatus) > 0)  )
                {
                  
                    $covered_sql="SELECT `ccp_id`,`refid`, `loc12`, `loc15`, `loc16`, `retailer_name` as name, `address`, `contact`, `latitude`, `longitude`, `sub_type` as channel_type, `segmentation`, `city` as city_name, `nbhrd`, `locality`,'A' as stat,'' as shop_image,statuss FROM `pepsi_covered_outlets` WHERE latitude!=0 and longitude!=0 ".$exit_rd." ".$nc_rd."  order by refid asc";
                      // \Log::info($covered_sql);
                       //  \Log::info($nc_rd);
                }
                else
                  {
                     
                     $covered_sql="SELECT `ccp_id`,`refid`, `loc12`, `loc15`, `loc16`, `retailer_name` as name, `address`, `contact`, `latitude`, `longitude`, `sub_type` as channel_type, `segmentation`, `city` as city_name, `nbhrd`, `locality`,'A' as stat,'' as shop_image,statuss FROM `pepsi_covered_outlets` WHERE latitude!=0 and longitude!=0 ".$exit_rd." ".$nc_rd."  order by refid asc";

                     


                  }

                  $sql="SELECT  a.`ccp_id`,a.`refid`,a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, a.`contact`, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`city` as city, a.`nbhrd`, a.`locality_name`,a.loc15 as beat_id, a.`beat_name`, a.`rd_code`,a. `rd_name`, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,b.outlet_id,b.user_id,b.outlet_image FROM `pepsi_uncovered_outlets` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str."  order by refid asc"; //".$rd_str."
    
            }
            else
            {

                       if($nc_rd == '')
                      {
                           $nc_rd =  " AND statuss IN ('PC','PUC')";
                      }
                       $covered_sql="SELECT  `ccp_id`,`refid`, `loc12`, `loc15`, `loc16`, `retailer_name` as name, `address`, `contact`, `latitude`, `longitude`, `sub_type` as channel_type, `segmentation`, `city` as city_name, `nbhrd`, `locality`,'A' as stat,'' as shop_image,statuss FROM `pepsi_covered_outlets` WHERE latitude!=0 and longitude!=0 and ccp_id=0  ".$exit_rd." ".$nc_rd."  order by refid asc";

                       // \Log::info($covered_sql);

              
                 // $sql="SELECT a.`refid`,a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, if(a.`contact`='' || a.contact=0,'NA',a.contact) as contact, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`city` as city, a.`nbhrd`, a.`locality_name`,a.loc15 as beat_id, a.`beat_name`, a.`rd_code`,a. `rd_name`, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,a.outlet_stock,a.snack_purchase,if(a.snack_purchase='Y','Yes',if(a.snack_purchase='N','N','')) as snack,if(a.outlet_stock='W','Wholesale',if(a.outlet_stock='D','Distributor','')) as outletstock  FROM `pepsi_uncovered_outlets` as a where stat='A' ".$rd_str."  order by refid asc";

                   $sql=" SELECT  a.`ccp_id`,a.`refid`,a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, if(a.`contact`='' || a.contact=0,'NA',a.contact) as contact, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`city` as city, a.`nbhrd`, a.`locality_name`,a.loc15 as beat_id, a.`beat_name`, a.`rd_code`,a. `rd_name`, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,a.outlet_stock,a.snack_purchase,if(a.snack_purchase='Y','Yes',if(a.snack_purchase='N','N','')) as snack,if(a.outlet_stock='W','Wholesale',if(a.outlet_stock='D','Distributor','')) as outletstock,group_concat(b.outlet_image)  FROM `pepsi_uncovered_outlets` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str."  group by a.retailer_id,b.outlet_id order by refid asc";
            }
          \Log::info($covered_sql);
         // \Log::info($nc_rd);
            
           $covered_res = DB::select(DB::raw($covered_sql));
           \Log::info($sql); //&& $res[$s]['ccp_id']!=0
           $covered_res=CommonController::getarray($covered_res);
 
        
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);

        
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head=[];
       
        $revenue_scale=['<20000'=>'< 20k','20000-45000'=>'20k - 45k','45000-75000'=> '45k - 75k','75000-150000'=>'75k - 1.5L','150000-250000'=>'1.5L - 2.5L','250000-400000'=>'2.5L - 4L','400000+'=>'4L +'];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
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
		  $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {
           // \Log::info($covered_res[$s]['ccp_id']);
             $temp=[];  
             if($user->id==13289) // pepsi admin login
              {
                  if($covered_res[$s]['statuss'] === 'PC') //PC- pepsi covered 
                  {
                      $temp['icon']='images/coveredblue_old.png';
                  }
                  elseif($covered_res[$s]['statuss'] === 'PUC')
                  {
                      $temp['icon']='images/coveredpurple.png';
                  }
                  else
                  {
                      $temp['icon']='images/coveredred.png';
                  }
                        
              }
              else
                {
                  if($covered_res[$s]['statuss'] === 'PUC') //PUC - pepsi uncovered
                  {
                      $temp['icon']='images/coveredpurple.png'; 
                  }
                  else
                  {
                      $temp['icon']='images/coveredblue_old.png';
                  }

                  // $temp['icon']='images/coveredblue_old.png';     
                }          
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
              $temp['refid']=$covered_res[$s]['refid'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$covered_res[$s]['locality'].' Locality</span><br><span style="line-height:1rem;">'.$covered_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city_name'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        
        for($s=0;$s<$total_potential;$s++)
        {
           if(!in_array($res[$s]['locality_name'],$head))
             array_push($head,$res[$s]['locality_name']);
         if($user->id==13878) //,
            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
         else
            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status'],$res[$s]['outlet_status'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
                $temp['beat_name']=$res[$s]['beat_name'];  
                $temp['address']=$res[$s]['address'];
                $temp['status']=$res[$s]['status'];
                $temp['nbhrd']=$res[$s]['nbhrd'];
                $temp['contact']=$res[$s]['contact'];
                $temp['name']=$res[$s]['name'];
                $temp['type']=$res[$s]['type'];
                //Change 02-03-2026 Rajkumar
                $temp['icon'] = $res[$s]['ccp_id'] == 0 ? $res[$s]['icon'] : 'potential_image/circle.png';
                 //Change 02-03-2026 Rajkumar end
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                $temp['latitude']=$res[$s]['latitude'];
                $temp['longitude']=$res[$s]['longitude'];
                $temp['locality_name']=$res[$s]['locality_name'];
                $temp['shareinfo']='Retailer ID:'.$res[$s]['retailer_id'].'Name:'.$res[$s]['name'].'Address:'.$res[$s]['address'].'Channel:'.$res[$s]['sub_type'].'Contact:'.$res[$s]['contact'];
                  $temp['city']=$res[$s]['city'];
                    $temp['outlet_potential']=$res[$s]['outlet_potential'];
                  $style_code='';
                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $temp['style_code']=$style_code;
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              //change 25-02-2026
              if($res[$s]['status']=='A' && $res[$s]['ccp_id']==0)//&& $res[$s]['ccp_id']==0
                $temp['icon']='images/uncovered.png'; 
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
            if(isset($res[$s]['outlet_stock']))
            {
                 $temp['outlet_stock']=$res[$s]['outlet_stock'];
                  $temp['snacks_purchase']=$res[$s]['snack_purchase'];
            }
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;

             $temp['circle_count']=$cicle_count;
            // $temp['is_catgry_outlet']=$res[$s]['is_catgry_outlet'];
             if($user->id==13878)     
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['locality_name'].' Locality</span><br><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span><a href="#" style="text-decoration:underline;cursor:pointer;color:#fff;" id="'.$res[$s]['type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a></p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span><a href="#" style="text-decoration:underline;cursor:pointer;color:#fff;" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a></p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'"><a onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')" style="text-decoration:underline;cursor:pointer;">'.$res[$s]['outlet_potential'].'</a></span> </p><hr style="border-top: 1px solid white;"><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].',0,0)"  id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$found.' >  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].',0,0)" id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        if(count($head)> 0)
             $message['head']=(strlen(implode(", ",$head)) > 20) ? $head[0].'...' : implode(", ",$head). ' Locality(s)';
        
        
         return json_encode($message);
    }
    public static function pepsi_beverage_getuncovereddata($input)
	{
          $input_query=json_decode($input['input']);
          //\Log::info($input['current_location']); 
        
        if(auth()->user()->lock_lat!=0) // location locked condition
        {
             $input['current_location'][0]=auth()->user()->lock_lat;
             $input['current_location'][1]=auth()->user()->lock_long;
        } // location locked condition

        //\Log::info($input['current_location']); 

         $rd=[];         $rd['beat_list']=[];   $rd['exist_rd']=[];
         $rd['rd_list']=[];         $rd['map_list']=[];         $column=[];       $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
         //    array_push($column, array(
         //     'title' => 'Estmtd. mthly Revenue (Rs.)', 'className' => 'text-left'
         // ));
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
        
         
         
          $user = auth()->user();
          $userid = $user->id;
          
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd=''; $nc_rd="";
          $head='';
          $statuses = [];
           
          if(isset($input_query->filter_distance) && $input_query->filter_distance!=''  )
           {
             if(isset($input['current_location']))
          {
            //$input_query->filter_distance=$input_query->filter_distance*100;
             $rd_str .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < '.$input_query->filter_distance;
              $exit_rd .=' and (ST_Distance_Sphere(point(longitude, latitude), point('.$input['current_location'][1].','.$input['current_location'][0].')) *.000621371192) < '.$input_query->filter_distance;
          } 
          //     $rd_str .=" and a.sub_type in ('".implode("','",$input_query->filter_bychannel)."')"; 
          // //   // $exit_rd .=" and channel ='".$input_query->filter_bychannel."'"; 
           }
          
          
        
            if(isset($input_query->filter_bychannel) && (count($input_query->filter_bychannel) > 0)  )
           {
              $rd_str .=" and a.sub_type in ('".implode("','",$input_query->filter_bychannel)."')"; 

               if (!in_array("PC", $input_query->filter_bystatus) &&  !in_array("PUC", $input_query->filter_bystatus))
              {
                  $exit_rd .=" and sub_type in ('".implode("','",$input_query->filter_bychannel)."')";
              }

           }
		 
          if(isset($input_query->filter_bypotential) && (count($input_query->filter_bypotential) > 0)  )
           {
              $rd_str .=" and a.fld1923  in (".implode(",",$input_query->filter_bypotential).")"; 
           }
          else
          {
              $rd_str .=" and a.fld1923  in (3,2)"; 
          }

           if(isset($input_query->filter_bystatus) && (count($input_query->filter_bystatus) > 0)  )
           {
              $rd_str .=" and a.status  in ('".implode("','",$input_query->filter_bystatus)."')"; 

                 
                  //check condition  pc and puc if start
                  if (!empty($input_query->filter_bystatus)) {

                      if (in_array("PC", $input_query->filter_bystatus)) {
                          $statuses[] = "PC";
                      }

                      if (in_array("PUC", $input_query->filter_bystatus)) {
                          $statuses[] = "PUC";
                      }
                  }

                  if (!empty($statuses)) {
                      $quoted = array_map(function ($val) {
                          return "'".$val."'";
                      }, $statuses);

                      $nc_rd = " AND statuss IN (" . implode(",", $quoted) . ")";
                  } else {
                      // BOTH unchecked → no condition
                      $nc_rd = "";
                  } //check condition  pc and puc if end

                 if (!in_array("PC", $input_query->filter_bystatus) &&  !in_array("PUC", $input_query->filter_bystatus)) 
                  {
                     

                     // \Log::info("Tested value");
                     $nc_rd= " ";
                }
                // \Log::info($$input['current_location']);         
           }
         
           if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
           {
             if($input_query->filter_beat[0]!=null){
                 $rd_str .=" and a.loc16 in (".implode(',',$input_query->filter_beat).")";
                 
                 if (!in_array("PC", $input_query->filter_bystatus) &&  !in_array("PUC", $input_query->filter_bystatus)) 
                 {
                     $exit_rd .=" and loc16 in (".implode(',',$input_query->filter_beat).")";
                 }
             }
            
           }
           


           

                $covered_sql="SELECT  `ccp_id`,`refid`, `loc12`, `loc15`, `loc16`, `retailer_name` as name, `address`, `contact`, `latitude`, `longitude`, `sub_type` as channel_type, `segmentation`, `city` as city_name, `nbhrd`, `locality`,'A' as stat,'' as shop_image,statuss FROM `pepsi_covered_outlets` WHERE latitude!=0 and longitude!=0 and ccp_id=0  ".$exit_rd." ".$nc_rd."  order by refid asc";

                       // \Log::info($covered_sql);

              
                 // $sql="SELECT a.`refid`,a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, if(a.`contact`='' || a.contact=0,'NA',a.contact) as contact, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`city` as city, a.`nbhrd`, a.`locality_name`,a.loc15 as beat_id, a.`beat_name`, a.`rd_code`,a. `rd_name`, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,a.outlet_stock,a.snack_purchase,if(a.snack_purchase='Y','Yes',if(a.snack_purchase='N','N','')) as snack,if(a.outlet_stock='W','Wholesale',if(a.outlet_stock='D','Distributor','')) as outletstock  FROM `pepsi_uncovered_outlets` as a where stat='A' ".$rd_str."  order by refid asc";

                   $sql=" SELECT  a.`ccp_id`,a.`refid`,a.`retailer_id`, a.`name`, a.`type`, a.`sub_type`, a.`outlet_potential`, a.`fld1923`, a.`address`, if(a.`contact`='' || a.contact=0,'NA',a.contact) as contact, a.`latitude`, a.`longitude`, a.`city_id`, a.`loc15`, a.`loc16`, a.`city` as city, a.`nbhrd`, a.`locality_name`,a.loc15 as beat_id, a.`beat_name`, a.`rd_code`,a. `rd_name`, a.`stat`, a.`status`, if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status, a.shop_image,a.icon,a.outlet_stock,a.snack_purchase,if(a.snack_purchase='Y','Yes',if(a.snack_purchase='N','N','')) as snack,if(a.outlet_stock='W','Wholesale',if(a.outlet_stock='D','Distributor','')) as outletstock,group_concat(b.outlet_image)  FROM `pepsi_uncovered_outlets_beverages` as a left join jj_outlet_image as b on a.retailer_id=b.outlet_id where stat='A'  ".$rd_str."  group by a.retailer_id,b.outlet_id order by refid asc";
         // \Log::info($covered_sql);
         // \Log::info($nc_rd);
            
           $covered_res = DB::select(DB::raw($covered_sql));
         \Log::info($sql); //&& $res[$s]['ccp_id']!=0
           $covered_res=CommonController::getarray($covered_res);
 
        
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);

        
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];
        $head=[];
       
        $revenue_scale=['<20000'=>'< 20k','20000-45000'=>'20k - 45k','45000-75000'=> '45k - 75k','75000-150000'=>'75k - 1.5L','150000-250000'=>'1.5L - 2.5L','250000-400000'=>'2.5L - 4L','400000+'=>'4L +'];
        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
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
		  $covered_res_count=count($covered_res);
        for($s=0;$s<$covered_res_count;$s++)
        {
           // \Log::info($covered_res[$s]['ccp_id']);
             $temp=[];  
             if($user->id==13289) // pepsi admin login
              {
                  if($covered_res[$s]['statuss'] === 'PC') //PC- pepsi covered 
                  {
                      $temp['icon']='images/coveredblue_old.png';
                  }
                  elseif($covered_res[$s]['statuss'] === 'PUC')
                  {
                      $temp['icon']='images/coveredpurple.png';
                  }
                  else
                  {
                      $temp['icon']='images/coveredred.png';
                  }
                        
              }
              else
                {
                  if($covered_res[$s]['statuss'] === 'PUC') //PUC - pepsi uncovered
                  {
                      $temp['icon']='images/coveredpurple.png'; 
                  }
                  else
                  {
                      $temp['icon']='images/coveredblue_old.png';
                  }

                  // $temp['icon']='images/coveredblue_old.png';     
                }          
              $temp['latitude']=$covered_res[$s]['latitude'];
              $temp['longitude']=$covered_res[$s]['longitude'];
              $temp['refid']=$covered_res[$s]['refid'];
               
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$covered_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$covered_res[$s]['latitude'].','.$covered_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$covered_res[$s]['refid'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$covered_res[$s]['locality'].' Locality</span><br><span style="line-height:1rem;">'.$covered_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$covered_res[$s]['city_name'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span>'.$covered_res[$s]['channel_type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$covered_res[$s]['address'].'  </p></div>';

                 array_push($rd['exist_rd'],$temp);
        }
        
        for($s=0;$s<$total_potential;$s++)
        {
           if(!in_array($res[$s]['locality_name'],$head))
             array_push($head,$res[$s]['locality_name']);
         if($user->id==13878) //,
            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
         else
            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status'],$res[$s]['outlet_status'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            {
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
                $temp['beat_name']=$res[$s]['beat_name'];  
                $temp['address']=$res[$s]['address'];
                $temp['status']=$res[$s]['status'];
                $temp['nbhrd']=$res[$s]['nbhrd'];
                $temp['contact']=$res[$s]['contact'];
                $temp['name']=$res[$s]['name'];
                $temp['type']=$res[$s]['type'];
                //Change 02-03-2026 Rajkumar
                $temp['icon'] = $res[$s]['ccp_id'] == 0 ? $res[$s]['icon'] : 'potential_image/circle.png';
                 //Change 02-03-2026 Rajkumar end
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                $temp['latitude']=$res[$s]['latitude'];
                $temp['longitude']=$res[$s]['longitude'];
                $temp['locality_name']=$res[$s]['locality_name'];
                $temp['shareinfo']='Retailer ID:'.$res[$s]['retailer_id'].'Name:'.$res[$s]['name'].'Address:'.$res[$s]['address'].'Channel:'.$res[$s]['sub_type'].'Contact:'.$res[$s]['contact'];
                  $temp['city']=$res[$s]['city'];
                    $temp['outlet_potential']=$res[$s]['outlet_potential'];
                  $style_code='';
                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $temp['style_code']=$style_code;
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              //change 25-02-2026
              if($res[$s]['status']=='A' && $res[$s]['ccp_id']==0)//&& $res[$s]['ccp_id']==0
                $temp['icon']='images/uncovered.png'; 
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
            if(isset($res[$s]['outlet_stock']))
            {
                 $temp['outlet_stock']=$res[$s]['outlet_stock'];
                  $temp['snacks_purchase']=$res[$s]['snack_purchase'];
            }
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;

             $temp['circle_count']=$cicle_count;
            // $temp['is_catgry_outlet']=$res[$s]['is_catgry_outlet'];
             if($user->id==13878)     
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['locality_name'].' Locality</span><br><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span><a href="#" style="text-decoration:underline;cursor:pointer;color:#fff;" id="'.$res[$s]['type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a></p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span><a href="#" style="text-decoration:underline;cursor:pointer;color:#fff;" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a></p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'"><a onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')" style="text-decoration:underline;cursor:pointer;">'.$res[$s]['outlet_potential'].'</a></span> </p><hr style="border-top: 1px solid white;"><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].',0,0)"  id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$found.' >  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].',0,0)" id="flexRadioDefault'.$res[$s]['retailer_id'].'" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault'.$res[$s]['retailer_id'].'" > Not Found </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       array_push($message['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        if(count($head)> 0)
             $message['head']=(strlen(implode(", ",$head)) > 20) ? $head[0].'...' : implode(", ",$head). ' Locality(s)';
        
        
         return json_encode($message);
    }
  public static function ckbeat($input)
    {
        $input_query=json_decode($input['input']);
        
         $data=[];
         $data['beat_list']=[];         
         $data['exist_rd']=[];
         if(isset($input_query->show_cluster))
           $data['rd_list1']=[];
         else
            $data['rd_list']=[];
         $data['map_list']=[];
         $data['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'SS Code', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'SS Name', 'className' => 'text-left'
         ));
         
           array_push($column, array(
             'title' => 'District Cust Code', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Company Cust Code', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Customer', 'className' => 'text-left'
         ));
           
           array_push($column, array(
             'title' => 'Group', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Visit Order', 'className' => 'text-right'
         ));
            array_push($column, array(
             'title' => 'Beat Unique ID', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'State', 'className' => 'text-left'
         ));

           
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';
        
         

           if(isset($input_query->filter_type) && $input_query->filter_type=='filter_byckdistributor') 
          {
              if(is_array($input_query->value))
            {
                 if(count($input_query->value)>0)
                 {
                     $rd_str .=" and ss_code in  ('".join("','",$input_query->value)."')";
                 }
            } 
            else
                if($input_query->value!='')
                    $rd_str .=" and ss_code in ('".$input_query->value."')"; 

          }

          if(isset($input_query->filter_type) && $input_query->filter_type=='filter_byckdistrict') 
          {
              if(is_array($input_query->value))
            {
                 if(count($input_query->value)>0)
                 {
                     $rd_str .=" and loc9 in  ('".join("','",$input_query->value)."')";
                 }
            } 
            else
                if($input_query->value!='')
                    $rd_str .=" and loc9 in ('".$input_query->value."')"; 

          }
             if(isset($input_query->filter_type) && $input_query->filter_type=='filter_byckbeat') 
          {
              if(is_array($input_query->value))
            {
                 if(count($input_query->value)>0)
                 {
                     $rd_str .=" and unique_beat_id in  ('".join("','",$input_query->value)."')";
                 }
            } 
            else
                if($input_query->value!='')
                    $rd_str .=" and unique_beat_id in ('".$input_query->value."')"; 

          }
         
            
         


         $sql="SELECT `id`, `refid`, `ss_code`, `ss_name`, `dist_cust_code`, `cmp_cust_code`, `customer_name`, `group_name`, `city`, `state`, `enroll_date`, `latitude`, `longitude`, `region_id`, `centroids`, `unique_beat_id`, `visit_order`, `loc7`, `loc9` FROM `ck_beats` where stat='A' ".$rd_str."  order by ss_name asc";

       // echo $sql;die;
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $min=max(array_values(array_column($res,'visit_order')));
        $head=implode(",",array_unique((array_values(array_column($res,'ss_name')))));
        $max=1;
         $low=[5,69,54];
        $high=[151,83,34];

     
        for($s=0;$s<$total_potential;$s++)
        { 
             

            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="show_beat(\''.$res[$s]['ss_code'].'\')">'.$res[$s]['ss_code'].'</a>',$res[$s]['ss_name'],$res[$s]['dist_cust_code'],$res[$s]['cmp_cust_code'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['cmp_cust_code'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['customer_name'].'</a>',$res[$s]['group_name'],$res[$s]['visit_order'],'<a href="#" style="text-decoration:underline" onClick="show_beat(\'\',\''.$res[$s]['unique_beat_id'].'\')">'.$res[$s]['unique_beat_id'].'</a>',$res[$s]['city'],$res[$s]['state']);
             array_push($value_data,$val_data);
             
          
                $temp=[];
                $temp['cmp_cust_code']=$res[$s]['cmp_cust_code'];
             
                $temp['ss_code']=$res[$s]['ss_code'];
                $temp['ss_name']=$res[$s]['ss_name'];
                $temp['dist_cust_code']=$res[$s]['dist_cust_code'];
                $temp['cmp_cust_code']=$res[$s]['cmp_cust_code'];
                $temp['customer_name']=$res[$s]['customer_name'];
                $temp['group_name']=$res[$s]['group_name'];
                $temp['visit_order']=$res[$s]['visit_order'];
                $temp['city']=$res[$s]['city'];
                $temp['state']=$res[$s]['state'];
                $temp['latitude']=$res[$s]['latitude'];
                $temp['longitude']=$res[$s]['longitude'];
                 $temp['unique_beat_id']=$res[$s]['unique_beat_id'];
                $color_critiea=((float)$res[$s]['visit_order']/(float)$max)*100;
                $remain=(float)$max-(float)$min;
                $delta=((float)$res[$s]['visit_order']-(float)$min)/$remain;
                $color=CommonController::getColor((float)$max, (float)$min, $delta,$low,$high);
                $temp['color']=$color;
                
                $temp['icon']='app_icon/agrade.png';
                
                 
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['customer_name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['cmp_cust_code'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;">'.$res[$s]['city'].' City<br>'.$res[$s]['state'].' State</span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">SS Name: </span>'.$res[$s]['ss_name'].'</p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">SS Code: </span>'.$res[$s]['ss_code'].'</p><p><span style="color:rgb(242, 101, 34)">Distributor Code: </span>'.$res[$s]['dist_cust_code'].'</p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Company Customer code: </span>'.$res[$s]['cmp_cust_code'].'</p><p><span style="color:rgb(242, 101, 34)">Group: </span>'.$res[$s]['group_name'].'  </p><p><span style="color:rgb(242, 101, 34)">Visit Order: </span>'.$res[$s]['visit_order'].'  </p></p></div>';
                 if(isset($input_query->show_cluster))
                   array_push($data['rd_list1'],$temp);
                 else
                  array_push($data['rd_list'],$temp);
              
            
        }
        $message['legend']=[];
       
        
        $message['result']=$data;
         if(isset($input_query->show_cluster))

          $message['griddata']=array(
              'column' => $column,
              'value' => $value_data
          );  
        else
        {
            $message['griddata']=Self::ckbeat_consolidated($input);
        }

      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=$head;
        
        // $head='';
        // if(isset($input_query->filter_subrdbeat_district) && (count($input_query->filter_subrdbeat_district)>0))
        // {
        //     $dist_list['dist']=array_unique($dist_list['dist']);
        //     $head=implode(",",$dist_list['dist']). ' Distt(s) - ';
        // }
        // else
        // {
        //     $dist_list['sst']=array_unique($dist_list['sst']);
        //     $head=implode(",",$dist_list['sst']);
        // }
        // $message['head'] =$head. ' SST(s)';
         return json_encode($message);
    }
     public static function ckbeat_consolidated($input)
    {
        $input_query=json_decode($input['input']);
        
         $data=[];
         $data['beat_list']=[];         
         $data['exist_rd']=[];
         $data['consolide_list']=[];
         $data['map_list']=[];
         $data['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          
           array_push($column, array(
             'title' => 'SS Name', 'className' => 'text-left'
         ));
          
            array_push($column, array(
             'title' => 'Beat Unique ID', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Total', 'className' => 'text-left'
         ));
          
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';
         

           if(isset($input_query->filter_type) && $input_query->filter_type=='filter_byckdistributor') 
          {
              if(is_array($input_query->value))
            {
                 if(count($input_query->value)>0)
                 {
                     $rd_str .=" and ss_code in  ('".join("','",$input_query->value)."')";
                 }
            } 
            else
                if($input_query->value!='')
                    $rd_str .=" and ss_code in ('".$input_query->value."')"; 

          }

          if(isset($input_query->filter_type) && $input_query->filter_type=='filter_byckdistrict') 
          {
              if(is_array($input_query->value))
            {
                 if(count($input_query->value)>0)
                 {
                     $rd_str .=" and loc9 in  ('".join("','",$input_query->value)."')";
                 }
            } 
            else
                if($input_query->value!='')
                    $rd_str .=" and loc9 in ('".$input_query->value."')"; 

          }
             if(isset($input_query->filter_type) && $input_query->filter_type=='filter_byckbeat') 
          {
              if(is_array($input_query->value))
            {
                 if(count($input_query->value)>0)
                 {
                     $rd_str .=" and unique_beat_id in  ('".join("','",$input_query->value)."')";
                 }
            } 
            else
                if($input_query->value!='')
                    $rd_str .=" and unique_beat_id in ('".$input_query->value."')"; 

          }
         
            
         


         $sql="SELECT  ss_code,`ss_name`,count(*) as total,   `centroids`, `unique_beat_id`,latitude,longitude FROM `ck_beats` where stat='A' ".$rd_str."  group by unique_beat_id order by ss_name asc";

        
        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $total_outlet=array_sum(array_column($res,'total'));

     
        for($s=0;$s<$total_potential;$s++)
        { 
             

            $val_data=array(($s+1),$res[$s]['ss_name'],'<a href="#" style="text-decoration:underline" onClick="show_beat(\'\',\''.$res[$s]['unique_beat_id'].'\')">'.$res[$s]['unique_beat_id'].'</a>',$res[$s]['total']);
             array_push($value_data,$val_data);
             
          
        }
      return array(
            'column' => $column,
            'value' => $value_data
        );  
    }
      public static function coke_college($input)
    {
        $input_query=json_decode($input['input']);
        
         $data=[];
         $data['beat_list']=[];         
         $data['exist_rd']=[];
         $data['rd_list']=[];
         $data['map_list']=[];
         $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

          array_push($column, array(
             'title' => 'College', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Establishment Name', 'className' => 'text-left'
         ));
         
           array_push($column, array(
             'title' => 'Channel', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Sub Channel', 'className' => 'text-left'
         ));
           
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Outlet Potential', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Contact', 'className' => 'text-right'
         ));
           
          

            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
         
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
         
         
          $user = auth()->user();
          $userid = $user->id;
          $rd_id=[];$legend=[];
          $head='';
          $rd_str='';$exit_rd='';
          
          $head='';


           if(isset($input_query->filter_bychannel) && ($input_query->filter_bychannel!='')  )
          {
             $rd_str .=" and a.type ='".$input_query->filter_bychannel."'"; 
          }
            if(isset($input_query->filter_channel) && ($input_query->filter_channel!='')  )
          {
             $rd_str .=" and a.sub_type in ('".join("','",$input_query->filter_channel)."')"; 
          }
          if(isset($input_query->catgry) && ($input_query->catgry!='')  )
          {
             $rd_str .=" and a.catgry in ('".join("','",$input_query->catgry)."')"; 
          }
          if(isset($input_query->verified) && ($input_query->verified!='')  )
          {
             $rd_str .=" and a.verified_status in ('".join("','",$input_query->verified)."')"; 
          }
            if(isset($input_query->filter_category) && ($input_query->filter_category!='')  )
          {
             $rd_str .=" and a.catgry ='".$input_query->filter_category."'"; 
          }
          if(isset($input_query->verified_satus) && ($input_query->verified_satus!='')  )
          {
             $rd_str .=" and a.verified_status ='".$input_query->verified_satus."'"; 
          }
           if(isset($input_query->filter_status) && ($input_query->filter_status!='')  )
          {
             $rd_str .=" and a.status in ('".join("','",$input_query->filter_status)."')"; 
          }
          if(isset($input_query->filter_bysubchannel) && ($input_query->filter_bysubchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_bysubchannel."'";
            
          }
       
         
          if(isset($input_query->filter_beat)) 
          {
              if(is_array($input_query->filter_beat))
            {
                 if(count($input_query->filter_beat)>0)
                 {
                     $rd_str .=" and a.college in  ('".join("','",$input_query->filter_beat)."')";
                 }
            } 
            else
                if($input_query->filter_beat!='')
                    $rd_str .=" and a.college in ('".$input_query->filter_beat."')"; 

          }
            
         


         $sql="SELECT  a.`refid` as retailer_id, college,a.rating,a.reviews,a.`nbrhds_name` as nbhrd,a.locality_name,a.city_villg_name, a.name, a.`address`, a.`latitude`, a.`longitude`, a.contact,  a.`icon`, a.`shop_image`,a.status,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.`fld1923`,a.outlet_potential, a.`type`,a.sub_type,a.catgory as catgry, a.`potential_status`, a.contact as `contact_no`, a.`verified_status`,a.college_latitude,a.college_longitude,a.college_city,a.collge_icon,a.collge_image,a.college_address FROM `colleges_nearby_fmcg_stores` as a left join (SELECT `refid`, `outlet_id`, `user_id`, `outlet_image`, `created_date`, `status`, `client_id` FROM `jj_outlet_image` where client_id='".auth()->user()->client_id."') as b on a.refid=b.outlet_id where a.stat='A' ".$rd_str."  order by a.refid asc";

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);
        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
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
          
        for($s=0;$s<$total_potential;$s++)
        { 
             

            $val_data=array(($s+1),'<a href="#" style="text-decoration:underline" onClick="highlight(0,'.$res[$s]['college_latitude'].','.$res[$s]['college_longitude'].')">'.$res[$s]['college'].'</a>','<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['type'].'"  onClick="mdlz_filter(\''.$res[$s]['type'].'\')">'.$res[$s]['type'].'</a>', '<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="mdlz_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>',$res[$s]['address'],$res[$s]['outlet_potential'],$res[$s]['contact'],$res[$s]['city_villg_name'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);
             
            if(!in_array($res[$s]['retailer_id'], $retailer_id))
            { 
                array_push($retailer_id,$res[$s]['retailer_id']);
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
             
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                 $temp['status']=$res[$s]['status'];
                  $temp['latitude']=$res[$s]['latitude'];
                  $temp['longitude']=$res[$s]['longitude'];

                  $style_code='';

                 if($res[$s]['fld1923']==3)
                  $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                  $style_code='background-color:#ed8102';
                 if($res[$s]['fld1923']==1)
                  $style_code='background-color:#bf1414';
              $found='';$not_found='';
              $found=($res[$s]['status']=='A') ? 'checked' : '';
              $not_found=($res[$s]['status']=='NF') ? 'checked' : '';
              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF')
                $temp['icon']='images/nr.png';
            $temp['shareinfo']='Outlet name:'.$res[$s]['name'].'Channel Type:'.$res[$s]['sub_type'];
             $cicle_count=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
             $nbhrd='';
             if($res[$s]['nbhrd']!='')
                $nbhrd='<span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br>';

                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"  onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$res[$s]['latitude'].'" lon="'.$res[$s]['longitude'].'" id="share_'.$res[$s]['retailer_id'].'"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;">'.$nbhrd.'<span style="line-height:1rem;">'.$res[$s]['city_villg_name'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span>'.$res[$s]['sub_type'].'</p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'">'.$res[$s]['outlet_potential'].'<p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p><hr style="border-top: 1px solid white;"><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Yes  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > No </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';
                  array_push($data['rd_list'],$temp);
                 if($s==0)
                 {
                       $temp=[];
                       $temp['retailer_id']=0;
                        $temp['latitude']=$res[$s]['college_latitude'];
                     $temp['longitude']=$res[$s]['college_longitude'];
                      $temp['shareinfo']='College name:'.$res[$s]['college'];

                     $temp['icon']= $res[$s]['collge_icon'];
                       $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['college'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"  onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$res[$s]['latitude'].'" lon="'.$res[$s]['longitude'].'" id="share_'.$temp['retailer_id'].'"><img class="ml-1" geocode="'.$res[$s]['college_latitude'].','.$res[$s]['college_longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['college_city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['collge_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Total outlets: </span>'.count($res).'</p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['college_address'].'</p></div></div>';
                        array_push($data['rd_list'],$temp);
                 }

                

            }
               

        }
        $message['legend']=[];
       
        
        $message['result']=$data;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
      
        $message['legend']=[];
        $message['label'] = '';
        $message['loc_level'] = 0;
        $message['loc_id'] = 0;
        $message['main_location'] = 0;
        $message['sub_location'] =0;
        $message['status'] = true;
        $message['message'] = 'map loaded successfully.';
        $message['map_nextlevel_info'] = [];
        $message['tbl'] = '';
        $message['head']=[];
        
        // $head='';
        // if(isset($input_query->filter_subrdbeat_district) && (count($input_query->filter_subrdbeat_district)>0))
        // {
        //     $dist_list['dist']=array_unique($dist_list['dist']);
        //     $head=implode(",",$dist_list['dist']). ' Distt(s) - ';
        // }
        // else
        // {
        //     $dist_list['sst']=array_unique($dist_list['sst']);
        //     $head=implode(",",$dist_list['sst']);
        // }
        // $message['head'] =$head. ' SST(s)';
         return json_encode($message);
    }

    

}
