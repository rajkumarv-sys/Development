<?php
namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 180);
use App\Models\MasterKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CommonController;
use App\User;
use DB;

class PerfettiController extends Controller
{
    public function index()
    {

    }
    public function show()
    {

    }
     public static function getuncoveredoutlets($input)
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
             'title' => 'Category Stocking', 'className' => 'text-left'
         ));
            
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Contact', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Outlet Potential', 'className' => 'text-left'
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


           if(isset($input_query->filter_bychannel) && count($input_query->filter_bychannel) >0  )
          {
             $rd_str .=" and a.type in ('".join("','",$input_query->filter_bychannel)."')"; 
          }
          if(isset($input_query->filter_bypotential) && count($input_query->filter_bypotential)>0  )
          {
             $rd_str .=" and a.fld1923 in ('".join("','",$input_query->filter_bypotential)."')"; 
          }
          //   if(isset($input_query->filter_channel) && ($input_query->filter_channel!='')  )
          // {
          //    $rd_str .=" and a.sub_type in ('".join("','",$input_query->filter_channel)."')"; 
          // }
          if(isset($input_query->catgry) && ($input_query->catgry!='')  )
          {
             $rd_str .=" and a.catgry in ('".join("','",$input_query->catgry)."')"; 
          }
         
            if(isset($input_query->filter_category) && ($input_query->filter_category!='')  )
          {
             $rd_str .=" and a.catgry ='".$input_query->filter_category."'"; 
          }
        
           if(isset($input_query->filter_bystatus) && ($input_query->filter_bystatus!='')  )
          {
             $rd_str .=" and a.status in ('".join("','",$input_query->filter_bystatus)."')"; 
          }
          if(isset($input_query->filter_subchannel) && ($input_query->filter_subchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_subchannel."'";
            
          }
          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'";
            
          }
       
         
          if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          {
             if($input_query->filter_rd[0]!=null){
                 $rd_str .=" and a.nbrhd_name in ('".join("','",$input_query->filter_rd)."')"; 
                 $exit_rd .=" and a.nbrhd_name in ('".join("','",$input_query->filter_rd)."')"; 
            
             }
            
          }
          

         


         $sql="SELECT  a.`refid` as retailer_id, a.`State`, a.`District`, a.`Taluk`, a.`City/Villg`, a.`Sector`, a.`nbrhd_name` as nbhrd, a.`CCP_Name` as name, a.`address`, a.`latitude`, a.`longitude`, a.`Contact` as contact, a.`Prirotity`, a.`icon`, a.`shop_image`,a.status,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.`fld1923`,if(a.`fld1923`=1,'Low',if(a.`fld1923`=2,'Medium',if(a.`fld1923`=3,'High',''))) as outlet_potential, a.`type`, a.`beat_id`, a.`city_id`, a.`city`, a.`potential_status`, a.`cluster_id`, a.`retailer_name`, a.`Contact` as contact, a.`remark`, a.`store_status`, a.`catgry`, a.`sub_type`,a.outlet_type FROM `perfetti_uncovered_outlets` as a where stat='A' and a.outlet_type=2 ".$rd_str."  order by a.refid asc";

        $exist_sql="SELECT  a.`refid` as retailer_id, a.`City/Villg`, a.`Sector`, a.`nbrhd_name` as nbhrd, a.`CCP_Name` as name, a.`address`, a.`latitude`, a.`longitude`, a.`type`, a.`beat_id`, a.`city_id`, a.`city`,  a.`sub_type`,a.outlet_type FROM `perfetti_uncovered_outlets` as a where stat='A' and a.outlet_type=1 ".$exit_rd."  order by a.refid asc";  

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);

         $exist_res = DB::select(DB::raw($exist_sql));
        $exist_res=CommonController::getarray($exist_res);
        if(isset($input_query->outlet_type) && count($input_query->outlet_type)>0)
        {
            if(!in_array(1,$input_query->outlet_type))
                $exist_res=[];
            if(!in_array(2,$input_query->outlet_type))
                $res=[];


        }

        $message=[];
        $message['maplist']=[];
        $retailer_id=[];

        $dist_list=['dist'=>[],'rd'=>[]];
        $total_potential=count($res);
         $total_potential_=count($exist_res);
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
          for($s=0;$s<$total_potential_;$s++)
        { 
             
         
                $temp=[];
                $temp['icon']="images/coveredblue.png";
                  $temp['latitude']=$exist_res[$s]['latitude'];
                  $temp['longitude']=$exist_res[$s]['longitude'];
           
                $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$exist_res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$exist_res[$s]['latitude'].','.$exist_res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$exist_res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$exist_res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$exist_res[$s]['city'].' City</span></span></h5><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span>'.$exist_res[$s]['type'].'</p><p><span style="color:rgb(242, 101, 34)">Address: </span>'.$exist_res[$s]['address'].'  </p></div>';
             
                    array_push($rd['exist_rd'],$temp);
           
               

        }
        for($s=0;$s<$total_potential;$s++)
        { 
             

          if($res[$s]['outlet_type']==2) // uncovered
          {
            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="perfetti_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="perfetti_filter(\'\',\'\',\''.$res[$s]['catgry'].'\')">'.$res[$s]['catgry'].'</a>',$res[$s]['address'],'<a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a>','<a href="#" style="text-decoration:underline" onClick="perfetti_filter(\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
             array_push($value_data,$val_data);

          }   
             
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
                  $style_code='';$high_status='';$low_status='';$medium_status='';
                if($res[$s]['potential_status']==3)
                    $high_status='checked';
                 if($res[$s]['potential_status']==2)
                    $medium_status='checked';
                 if($res[$s]['potential_status']==1)
                    $low_status='checked';

                 if($res[$s]['fld1923']==3)
                    $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                    $medium_status='checked';                 
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
             $contact=($res[$s]['contact']!='') ? '<p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p>' : '';
              $potential=($res[$s]['outlet_potential']!='') ? '<p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'">'.$res[$s]['outlet_potential'].'</span></p>' : '';
          
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span>'.$res[$s]['sub_type'].'</p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Category Stocking: </span>'.$res[$s]['catgry'].'</p>'.$potential.'<p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p>'.$contact.'<div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  value="A" id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"   value="NF" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div></p><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">Estimated Potential: </span></p><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="uncovered_outlet_potential_status(1,'.$res[$s]['retailer_id'].')"  id="flexRadioDefaultp'.$res[$s]['retailer_id'].'" '.$low_status.' >  <label class="form-check-label" for="flexRadioDefaultp'.$res[$s]['retailer_id'].'" >    Low  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="uncovered_outlet_potential_status(2,'.$res[$s]['retailer_id'].')" id="flexRadioDefaultp'.$res[$s]['retailer_id'].'" '.$medium_status.'>  <label class="form-check-label" for="flexRadioDefaultp'.$res[$s]['retailer_id'].'" > Medium </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="uncovered_outlet_potential_status(3,'.$res[$s]['retailer_id'].')" id="flexRadioDefaultp'.$res[$s]['retailer_id'].'" '.$high_status.'>  <label class="form-check-label" for="flexRadioDefaultp'.$res[$s]['retailer_id'].'" > High </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';
             if($res[$s]['outlet_type']==1) // covered
                    array_push($rd['exist_rd'],$temp);
             if($res[$s]['outlet_type']==2) // uncovered
                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
       
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
        
       $head=array_unique(array_column($res,'nbhrd'));
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
        $message['head']=join(', ',$head). ' Uncovered Outlets';
       
         return json_encode($message);
    }
    
     public static function getuncoveredoutlets_old($input)
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
             'title' => 'Category Stocking', 'className' => 'text-left'
         ));
            
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Contact', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Outlet Potential', 'className' => 'text-left'
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


           if(isset($input_query->filter_bychannel) && count($input_query->filter_bychannel) >0  )
          {
             $rd_str .=" and a.type in ('".join("','",$input_query->filter_bychannel)."')"; 
          }
          if(isset($input_query->filter_bypotential) && count($input_query->filter_bypotential)>0  )
          {
             $rd_str .=" and a.fld1923 in ('".join("','",$input_query->filter_bypotential)."')"; 
          }
          //   if(isset($input_query->filter_channel) && ($input_query->filter_channel!='')  )
          // {
          //    $rd_str .=" and a.sub_type in ('".join("','",$input_query->filter_channel)."')"; 
          // }
          if(isset($input_query->catgry) && ($input_query->catgry!='')  )
          {
             $rd_str .=" and a.catgry in ('".join("','",$input_query->catgry)."')"; 
          }
         
            if(isset($input_query->filter_category) && ($input_query->filter_category!='')  )
          {
             $rd_str .=" and a.catgry ='".$input_query->filter_category."'"; 
          }
        
           if(isset($input_query->filter_bystatus) && ($input_query->filter_bystatus!='')  )
          {
             $rd_str .=" and a.status in ('".join("','",$input_query->filter_bystatus)."')"; 
          }
          if(isset($input_query->filter_subchannel) && ($input_query->filter_subchannel!='')  )
          {
             $rd_str .=" and a.sub_type ='".$input_query->filter_subchannel."'";
            
          }
          if(isset($input_query->potential) && ($input_query->potential!='')  )
          {
             $rd_str .=" and a.fld1923 ='".$input_query->potential."'";
            
          }
       
         
          if(isset($input_query->filter_rd) && (count($input_query->filter_rd) > 0)  )
          {
             if($input_query->filter_rd[0]!=null){
                 $rd_str .=" and a.nbrhd_name in ('".join("','",$input_query->filter_rd)."')"; 
            
             }
            
          }
      

         


         $sql="SELECT  a.`refid` as retailer_id, a.`State`, a.`District`, a.`Taluk`, a.`City/Villg`, a.`Sector`, a.`nbrhd_name` as nbhrd, a.`CCP_Name` as name, a.`address`, a.`latitude`, a.`longitude`, a.`Contact` as contact, a.`Prirotity`, a.`icon`, a.`shop_image`,a.status,if(a.status='A','Found',if(a.status='NF','Not Found','New')) as outlet_status,a.`fld1923`,if(a.`fld1923`=1,'Low',if(a.`fld1923`=2,'Medium',if(a.`fld1923`=3,'High',''))) as outlet_potential, a.`type`, a.`beat_id`, a.`city_id`, a.`city`, a.`potential_status`, a.`cluster_id`, a.`retailer_name`, a.`Contact` as contact, a.`remark`, a.`store_status`, a.`catgry`, a.`sub_type` FROM `perfetti_uncovered_outlets` as a left join (SELECT `refid`, `outlet_id`, `user_id`, `outlet_image`, `created_date`, `status`, `client_id` FROM `jj_outlet_image` where client_id='".auth()->user()->client_id."') as b on a.refid=b.outlet_id where stat='A' ".$rd_str."  order by a.refid asc";

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
             

            $val_data=array(($s+1),$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['name'].'</a>', '<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="perfetti_filter(\'\',\''.$res[$s]['sub_type'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="perfetti_filter(\'\',\'\',\''.$res[$s]['catgry'].'\')">'.$res[$s]['catgry'].'</a>',$res[$s]['address'],'<a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a>','<a href="#" style="text-decoration:underline" onClick="perfetti_filter(\'\',\'\',\'\',\''.$res[$s]['fld1923'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);
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
                  $style_code='';$high_status='';$low_status='';$medium_status='';
                if($res[$s]['potential_status']==3)
                    $high_status='checked';
                 if($res[$s]['potential_status']==2)
                    $medium_status='checked';
                 if($res[$s]['potential_status']==1)
                    $low_status='checked';

                 if($res[$s]['fld1923']==3)
                    $style_code='background-color:#51c82c';
                 if($res[$s]['fld1923']==2)
                    $medium_status='checked';                 
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
             $contact=($res[$s]['contact']!='') ? '<p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'.$res[$s]['contact'].'" style="text-decoration:underline;">'.$res[$s]['contact'].' </a></p>' : '';
              $potential=($res[$s]['outlet_potential']!='') ? '<p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'.$style_code.'">'.$res[$s]['outlet_potential'].'</span></p>' : '';
                
                 $temp['info']='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'.$res[$s]['name'].'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$res[$s]['latitude'].','.$res[$s]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onClick="closeicon(this)" id="'.$res[$s]['retailer_id'].'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$res[$s]['nbhrd'].' Neighborhood</span><br><span style="line-height:1rem;">'.$res[$s]['city'].' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'.$res[$s]['shop_image'].'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Channel: </span>'.$res[$s]['sub_type'].'</p><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Category Stocking: </span>'.$res[$s]['catgry'].'</p>'.$potential.'<p><span style="color:rgb(242, 101, 34)">Address: </span>'.$res[$s]['address'].'  </p>'.$contact.'<div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'A\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"  value="A" id="flexRadioDefault1" '.$found.' >  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault'.$res[$s]['retailer_id'].'" onClick="outlet_status_mdlz(\'NF\','.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')"   value="NF" id="flexRadioDefault2" '.$not_found.'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div></p><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">Estimated Potential: </span></p><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="uncovered_outlet_potential_status(1,'.$res[$s]['retailer_id'].')"  id="flexRadioDefaultp'.$res[$s]['retailer_id'].'" '.$low_status.' >  <label class="form-check-label" for="flexRadioDefaultp'.$res[$s]['retailer_id'].'" >    Low  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="uncovered_outlet_potential_status(2,'.$res[$s]['retailer_id'].')" id="flexRadioDefaultp'.$res[$s]['retailer_id'].'" '.$medium_status.'>  <label class="form-check-label" for="flexRadioDefaultp'.$res[$s]['retailer_id'].'" > Medium </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="uncovered_outlet_potential_status(3,'.$res[$s]['retailer_id'].')" id="flexRadioDefaultp'.$res[$s]['retailer_id'].'" '.$high_status.'>  <label class="form-check-label" for="flexRadioDefaultp'.$res[$s]['retailer_id'].'" > High </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('.$res[$s]['retailer_id'].');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'.$cicle_count.'</span></div></div>';

                 array_push($rd['rd_list'],$temp);

            }
               

        }
        $message['legend']=[];
       
        if(isset($input_query->outlet_type) && count($input_query->outlet_type) > 0)
        {
             if(!in_array(2,$input_query->outlet_type))
                 $rd['rd_list']=[];
        }
        $message['result']=$rd;     
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  
        
       $head=array_unique(array_column($res,'nbhrd'));
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
        $message['head']=join(',',$head). ' Uncovered Outlets';
       
         return json_encode($message);
    }

}

