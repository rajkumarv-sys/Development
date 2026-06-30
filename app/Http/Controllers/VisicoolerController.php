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
use App\Http\Controllers\CommonController;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\User;
use DB;

class VisicoolerController extends Controller
{

    private $low=[5,69,54];
    private $high=[151,83,34];
    private $isolate=[166, 63, 26];
    private $low_town=[0,0,100];
    private $high_town=[241, 41, 36];  
    private $isolate_town=[241, 41, 36];

    const GEO_LEVEL_ISSUE = "The data not shown in this level";
    const NO_DATA = "Data not available";
    const MAP_ISSUE = "Map not available";
    const MENU_ISSUE="Please select single menu";
      

    public function index()
    {
        
    }
    public function show()
    {
    	
    }
    public static function getchannel()
    {
        $sql="SELECT a.refid,concat(b.name,' / ',a.name) as type,b.icon,b.shop_image FROM hul_alsi_master as a,hul_alsi_maintype_master as b where a.maintype_id=b.refid";
        $result = DB::select(DB::raw($sql));
        $result=CommonController::getarray($result);
        $channel=[];
        $c_count=count($result);
        for($i=0;$i<$c_count;$i++)
        {
             $channel[$result[$i]['refid']]=[];
             $channel[$result[$i]['refid']]['name']=$result[$i]['type'];
             $channel[$result[$i]['refid']]['icon']=$result[$i]['icon'];
              $channel[$result[$i]['refid']]['shop_image']=$result[$i]['shop_image'];

        }
        return $channel;
    }
   
    public static function visicooler($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
         $user = auth()->user();

        


       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  
         $view_optn=array_unique(array_column($input_obj['menu_list'],'view_optn'));

        if($input_obj['flag']=='C' && $view_optn[0]==1)
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $consmption_id=[];
          $fetch_table='bid_application_master.uncovered_retlr_universe';

         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          array_push($where,'a.stat="A"');
           array_push($where,'FIND_IN_SET('.$user->client_id.',client_id)');
           array_push($where,'a.fld2006 = 1 ');



          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

       
          if( $details['main_location']==16 || $details['sub_location']==16)
             $sql= 'SELECT a.loc'.$details["sub_location"].' loc_id,a.loc15,rtlr_id split_id,COUNT(DISTINCT(rtlr_id)) result,a.latitude,a.longitude,a.sub_type_id,address,contact_no,b.location_name as nbhrd,c.name,e.location_name as district_name,d.location_name as state_name,f.location_name as city_name,if(a.fld1923=1,"High",if(a.fld1923=2,"Medium",if(a.fld1923=3,"Low",""))) potential_status,a.fld1923 FROM '.$fetch_table.' as a,ward_master  as b ,state_master as d,district_master as e,city_master as f,hul_ccp_master as c WHERE a.rtlr_id=c.refid and a.loc15=b.refid  and  '.join(" and ",$where).' and b.district_id=e.refid and b.state_id=d.refid and b.loc12=f.refid GROUP BY loc_id,split_id ';
          else
             $sql= 'SELECT a.loc'.$details["sub_location"].' loc_id,rtlr_id split_id,COUNT(DISTINCT(rtlr_id)) result,a.latitude,a.longitude,a.sub_type_id,address,a.contact_no,c.name,\'\' district_name,\'\' state_name,\'\' city_name,if(a.fld1923=1,"High",if(a.fld1923=2,"Medium",if(a.fld1923=3,"Low",""))) potential_status,a.fld1923  FROM '.$fetch_table.' as a,hul_ccp_master as c WHERE a.rtlr_id=c.refid and '.join(" and ",$where).'  GROUP BY loc_id,split_id ';
          $index=$sql." order by result desc";
        
          $result = DB::select(DB::raw($index));
          $result=CommonController::getarray($result);

          $additional_result['column']=[];
          $additional_result['values']=[];

          $subtype_list=VisicoolerController::getchannel();

         

        $already_exist=[];
   
        $additional_result['column'][3]=array('src'=>'result','type'=>'I','subarray' => true,'align'=>'right','label'=>'Uncovered Retailr nos.');
          
        if( $details['main_location']==16 || $details['sub_location']==16)
            $additional_result['column'][2]=array('src'=>'nbhrd','type'=>'T','align'=>'left','label'=>'N\'brhd');

               
        $details['tooltip']=['Uncovered Retailr nos'=>['result','Nos.',0]];

        for($k=0;$k<count($result);$k++)
        {
            if(!isset($final_result[$result[$k]['loc_id']])){

             $final_result[$result[$k]['loc_id']]=[];
             $final_result[$result[$k]['loc_id']]['result']=0;
             $final_result[$result[$k]['loc_id']]['retailer_list']=[];
             if( $details['main_location']==16 || $details['sub_location']==16)
             {

                 $final_result[$result[$k]['loc_id']]['nbhrd']=$result[$k]['nbhrd'];
               $final_result[$result[$k]['loc_id']]['city_name']=$result[$k]['city_name'];
                $final_result[$result[$k]['loc_id']]['district_name']=$result[$k]['district_name'];
                $final_result[$result[$k]['loc_id']]['state_name']=$result[$k]['state_name'];
             }
              

            }

            $final_result[$result[$k]['loc_id']]['loc_id']=$result[$k]['loc_id'];
            $final_result[$result[$k]['loc_id']]['result']++;
            $subtype=(isset($subtype_list[$result[$k]['sub_type_id']])) ?  $subtype_list[$result[$k]['sub_type_id']]['name'] : '';
            $icon=(isset($subtype_list[$result[$k]['sub_type_id']])) ?  $subtype_list[$result[$k]['sub_type_id']]['icon'] : '';
             $shop_image=(isset($subtype_list[$result[$k]['sub_type_id']])) ?  $subtype_list[$result[$k]['sub_type_id']]['shop_image'] : '';
                 array_push($final_result[$result[$k]['loc_id']]['retailer_list'],['split_id'=>$result[$k]['split_id'],'address'=>$result[$k]['address'],'sub_type'=>$result[$k]['sub_type_id'],'name'=>$result[$k]['name'],'latitude'=>$result[$k]['latitude'],'longitude'=>$result[$k]['longitude'],'subtype'=>$subtype,'shop_image'=>$shop_image,'icon'=>$icon,'city'=>$result[$k]['city_name'],'state'=>$result[$k]['state_name'],'district'=>$result[$k]['district_name'],'potential'=>$result[$k]['potential_status'],'fld1923'=>$result[$k]['fld1923']]);


        }
     
        $final_result_=array_values($final_result);
     
        $total_result=array_sum(array_column($final_result,'result'));
        
          for($i=0;$i<count($final_result_);$i++)
          {

            $final_result[$i]=[];
            $final_result[$i]['result']=0;                              
            $final_result[$i]['loc_id']=$final_result_[$i]['loc_id'];
            $final_result[$i]['result']=$final_result_[$i]['result'];
            $final_result[$i]['nbhrd']='';
            $final_result[$i]['city']='';
            $final_result[$i]['district']='';
            $final_result[$i]['state']='';
             if( $details['main_location']==16 || $details['sub_location']==16)
             {
              
                $final_result[$i]['nbhrd']=$final_result_[$i]['nbhrd'];
                 $final_result[$i]['city']=$final_result_[$i]['city_name'];
                  $final_result[$i]['district']=$final_result_[$i]['district_name'];
                   $final_result[$i]['state']=$final_result_[$i]['state_name'];
             }

                 
             if(isset($details['maparray'][$final_result_[$i]['loc_id']]))
             {
                 
                   
                    $additional_result['values'][$final_result_[$i]['loc_id']]=array('loc_id'=>$final_result_[$i]['loc_id'],'location_name'=>$details['maparray'][$final_result_[$i]['loc_id']]['location_name'],'result'=>$final_result_[$i]['result'],'subarray'=>$final_result_[$i]['retailer_list'],'nbhrd'=>$final_result[$i]['nbhrd'],'state'=>$final_result[$i]['state'],'district'=>$final_result[$i]['district'],'city'=>$final_result[$i]['city']);
                
             }
            
            
             

          }

        
          $template='Combinecummulative_splittbl';
       
       
        }
      if($input_obj['flag']=='C' && $view_optn[0]==2)
        {

          $population=[];
          $column='a.loc'.$details['sub_location'];
          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $consmption_id=[];
          $fetch_table='mdlz.mdlz_urban_3cities_sales';

         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

       
         
           array_push($where,'a.fld2006 = 1 ');

             if(count($index_type)>0)
            array_push($where,' a.fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');




          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

        

          if( $details['main_location']==16 || $details['sub_location']==16)
              $sql= 'SELECT a.loc'.$details["sub_location"].' loc_id,a.fld1986 split_id,a.retailer_code,COUNT(DISTINCT(a.retailer_code)) result,b.name,b.address,c.location_name as nbhrd,b.latitude,b.longitude,d.location_name as state_name,e.location_name as district_name,f.location_name as city_name FROM  '.$fetch_table.' as a ,mdlz_urban_outlet_master as b,ward_master as c,state_master as d,district_master as e,city_master as f WHERE a.retailer_code=b.outlet_code and a.loc15=c.refid and  '.join(" and ",$where).' and c.state_id=d.refid and c.district_id=e.refid and c.loc12=f.refid GROUP BY loc_id,split_id';
          else
             $sql= 'SELECT a.loc'.$details["sub_location"].' loc_id,a.fld1986 split_id,a.retailer_code,COUNT(DISTINCT(a.retailer_code)) result,b.name,b.address,b.latitude,b.longitude FROM  '.$fetch_table.' as a ,mdlz_urban_outlet_master as b WHERE a.retailer_code=b.outlet_code and  '.join(" and ",$where).' GROUP BY loc_id,split_id';
          $index=$sql." order by result desc";
        
          $result = DB::select(DB::raw($index));
          $result=CommonController::getarray($result);

          $additional_result['column']=[];
          $additional_result['values']=[];
         

        $already_exist=[];
   
        $additional_result['column'][3]=array('src'=>'result','type'=>'I','subarray' => true,'align'=>'right','label'=>'Covered Retlrs with VISI Reco (Nos.)');
          
        if( $details['main_location']==16 || $details['sub_location']==16)
            $additional_result['column'][2]=array('src'=>'nbhrd','type'=>'T','align'=>'left','label'=>'N\'brhd');

               
        $details['tooltip']=['Covered Retlrs with VISI Reco (Nos.)'=>['result','Nos.',0]];

        for($k=0;$k<count($result);$k++)
        {
            if(!isset($final_result[$result[$k]['loc_id']])){

             $final_result[$result[$k]['loc_id']]=[];
             $final_result[$result[$k]['loc_id']]['result']=0;
             $final_result[$result[$k]['loc_id']]['retailer_list']=[];
             if( $details['main_location']==16 || $details['sub_location']==16)
                 $final_result[$result[$k]['loc_id']]['nbhrd']=$result[$k]['nbhrd'];

            }

            $final_result[$result[$k]['loc_id']]['loc_id']=$result[$k]['loc_id'];
            $final_result[$result[$k]['loc_id']]['result']++;
         if( $details['main_location']==16 || $details['sub_location']==16)
           array_push($final_result[$result[$k]['loc_id']]['retailer_list'],['split_id'=>$result[$k]['split_id'],'address'=>$result[$k]['address'],'name'=>$result[$k]['name'],'latitude'=>$result[$k]['latitude'],'longitude'=>$result[$k]['longitude'],'subtype'=>'','icon'=>'','state'=>$result[$k]['state_name'],'district'=>$result[$k]['district_name'],'city'=>$result[$k]['city_name'],'shop_image'=>'','fld1923'=>0,'potential'=>'']);

        }
     
        $final_result_=array_values($final_result);
       
     
        $total_result=array_sum(array_column($final_result,'result'));
        
          for($i=0;$i<count($final_result_);$i++)
          {

            $final_result[$i]=[];
            $final_result[$i]['result']=0;                              
            $final_result[$i]['loc_id']=$final_result_[$i]['loc_id'];
            $final_result[$i]['result']=$final_result_[$i]['result'];
            $final_result[$i]['nbhrd']='';
             if( $details['main_location']==16 || $details['sub_location']==16)
                 $final_result[$i]['nbhrd']=$final_result_[$i]['nbhrd'];
             if(isset($details['maparray'][$final_result_[$i]['loc_id']]))
             {
                 
                   
                    $additional_result['values'][$final_result_[$i]['loc_id']]=array('loc_id'=>$final_result_[$i]['loc_id'],'location_name'=>$details['maparray'][$final_result_[$i]['loc_id']]['location_name'],'result'=>$final_result_[$i]['result'],'subarray'=>$final_result_[$i]['retailer_list'],'nbhrd'=>$final_result[$i]['nbhrd']);
                
             }

          }

        
         
       
       
        }
 $template='Combinecummulative_splittbl';
        $flag=$input_obj['flag'];
       // $template=$action->gettemplate($details['view_type'],$details['period_result_type'],$flag,$split_combine_table_details->template_id);
        $namespace = "App\Http\Controllers\\";
         $controllerName = $namespace . $template.'Controller';         
        $template_controller = new $controllerName();
        if($flag=='C')
          return $template_controller->$template($final_result,$details,$additional_result,'%');
        if($flag=='S')
          return $template_controller->$template($final_result,$details,$additional_result,$split_master,'%');


    }
   
    
}