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

class CategoryshareController extends Controller
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
    
     public static function getcategoryshare($consmption_id,$main_location,$sub_location,$selected_location,$selected_period,$input_obj,$loc15)
    {
         $index_type=array_column($input_obj['menu_list'],'menu_item_id');
         $level_id=array_unique(array_column($input_obj['menu_list'],'level_id'));

         $select_criteria=[];$where=[];$temp=''; $head='';$select=[];
         $fetch_table_category='mdlz.mdlz_urban_3cities_sales_redistrbtd';
        $fetch_table=[12=>'catgry_consmptn.catgry_consmptn_timeseries_city',15=>'catgry_consmptn.catgry_consmptn_timeseries_ward',16=>'catgry_consmptn.catgry_consmptn_timeseries_colony'];
        $where=[];
        $temp=' a.stat="A"';
        array_push($where,$temp); 

        if($main_location==$sub_location)         
          $temp ='a.loc'.$sub_location.'='.$selected_location.'';
        if($main_location!=$sub_location)     
          $temp ='a.loc'.$main_location.'='.$selected_location.'';
         array_push($where,$temp);   

        
        if(count($consmption_id)>0 && in_array($level_id[0],[1821,1829]))
            array_push($where,' a.fld572  in ('.implode(",",$consmption_id).')');
        array_push($where,'  period_Y in ("'.$selected_period.'") ');

        $sql= 'SELECT a.loc'.$sub_location.' as loc_id,sum(`sub2_M1`+ `sub2_M2`+ `sub2_M3`+ `sub2_M4`+ `sub2_M5`+ `sub2_M6`+ `sub2_M7`+ `sub2_M8`+ `sub2_M9`+ `sub2_M10`+ `sub2_M11`+ `sub2_M12`) result ,period_Y as period ,"" location_type,fld1225 as pop_id  FROM '.$fetch_table[$sub_location].' as a  WHERE '.join(" and ",$where).'  GROUP BY loc_id ';
          $index=$sql." order by period asc,result desc";
        
          $result = DB::select(DB::raw($index));
          $result=CommonController::getarray($result);
          $consmption_result=[];

          for($i=0;$i<count($result);$i++)
          {
                $consmption_result[$result[$i]['loc_id']]=['result'=>$result[$i]['result'],'pop_id'=>$result[$i]['pop_id']];
          }
          $where=[];$temp=[];
         if($main_location==$sub_location)         
          $temp ='a.loc'.$sub_location.'='.$selected_location.'';
         if($main_location!=$sub_location)     
          $temp ='a.loc'.$main_location.'='.$selected_location.'';
          array_push($where,$temp);
             if(count($index_type)>0  && in_array($level_id[0],[1821,1829]))
            array_push($where,' a.fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  period_Y in ("'.$selected_period.'") ');

        $sql= 'SELECT a.loc'.$sub_location.' as loc_id,ROUND(SUM(sub2_Q1+ sub2_Q2+sub2_Q3+sub2_Q4),2) result ,period_Y as period ,"" location_type  FROM '.$fetch_table_category.' as a  WHERE '.join(" and ",$where).'  GROUP BY loc_id ';
          $index=$sql." order by period asc,result desc";

          $result = DB::select(DB::raw($index));
          $result=CommonController::getarray($result); 
          $final_result=[]; 
          
            for($i=0;$i<count($result);$i++)
          {
            if(isset($consmption_result[$result[$i]['loc_id']]['result']))
            {
                $final_result[$result[$i]['loc_id']]=0;
                $sale_result=$result[$i]['result'];
                $category_result=isset($consmption_result[$result[$i]['loc_id']]['result']) ? $consmption_result[$result[$i]['loc_id']]['result'] :0;
               $final_result[$result[$i]['loc_id']]=round((($sale_result/$category_result)*100),1);
              
            }
          } 
        arsort($final_result);
        // $bestDistances=[];
        //  $average = array_sum($final_result) / count($final_result);
        //  foreach ($final_result as $k => $v) {
        //     array_push($bestDistances,[$k => $v]);
        // }
        // $filter_array=[];
        // for($k=0;$k<count($bestDistances);$k++)
        // {
        //     $keys=array_keys($bestDistances[$k]);
        //     if($keys[0]==$loc15)
        //     {         
        //         if(isset($bestDistances[$k-2]))       
        //         array_push($filter_array,$bestDistances[$k-2]);
        //     if(isset($bestDistances[$k-1]))  
        //         array_push($filter_array,$bestDistances[$k-1]);
        //     if(isset($bestDistances[$k+1]))  
        //         array_push($filter_array,$bestDistances[$k+1]);
        //     if(isset($bestDistances[$k+2]))  
        //         array_push($filter_array,$bestDistances[$k+2]);
        //     }

        // }
       
        return $final_result;
    }
    public static function getconsmption($consmption_id,$main_location,$sub_location,$selected_location,$selected_period)
    {
         
        $fetch_table=[12=>'catgry_consmptn.catgry_consmptn_timeseries_city',15=>'catgry_consmptn.catgry_consmptn_timeseries_ward',16=>'catgry_consmptn.catgry_consmptn_timeseries_colony'];
        $where=[];
        $temp=' a.stat="A"';
        array_push($where,$temp); 

        if($main_location==$sub_location)         
          $temp ='a.loc'.$sub_location.'='.$selected_location.'';
        if($main_location!=$sub_location)     
          $temp ='a.loc'.$main_location.'='.$selected_location.'';
         array_push($where,$temp);   

        
        if(count($consmption_id)>0)
            array_push($where,' a.fld572  in ('.implode(",",$consmption_id).')');
        array_push($where,'  period_Y in ("'.implode(",",$selected_period).'") ');

if(in_array(2023,$selected_period))
        $sql= 'SELECT a.loc'.$sub_location.' as loc_id,sum(`sub2_M1`+ `sub2_M2`+ `sub2_M3`+ `sub2_M4`+ `sub2_M5`+ `sub2_M6`+ `sub2_M7`+ `sub2_M8`+ `sub2_M9`+ `sub2_M10`+ `sub2_M11`+ `sub2_M12`) result ,period_Y as period ,"" location_type,fld1225 as pop_id  FROM '.$fetch_table[$sub_location].' as a  WHERE '.join(" and ",$where).'  GROUP BY loc_id ';
          
if(in_array(2024,$selected_period))
        $sql= 'SELECT a.loc'.$sub_location.' as loc_id,sum(`sub2_M1`+ `sub2_M2`+ `sub2_M3`+ `sub2_M4`+ `sub2_M5`) result ,period_Y as period ,"" location_type,fld1225 as pop_id  FROM '.$fetch_table[$sub_location].' as a  WHERE '.join(" and ",$where).'  GROUP BY loc_id ';
      
          $index=$sql." order by period asc,result desc";

          $result = DB::select(DB::raw($index));
          $result=CommonController::getarray($result);
          $consmption_result=[];

          for($i=0;$i<count($result);$i++)
          {
                $consmption_result[$result[$i]['loc_id']]=['result'=>$result[$i]['result'],'pop_id'=>$result[$i]['pop_id']];
          }
          return $consmption_result;
    }
    public static function categoryshare($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        //$details['year']=[2022];

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $consmption_id=[];
          //$fetch_table='mdlz.mdlz_urban_3cities_sales';
           $fetch_table='mdlz.mdlz_urban_3cities_sales_redistrbtd';
          

          $fld1987_sql='select distinct bi_catgry_id  from mdlz_urban_brand_master where fld1987 in ('.implode(",",$index_type).') and stat="A"';

          $fld1987_sql = DB::select(DB::raw($fld1987_sql));
          $fld1987_sql=CommonController::getarray($fld1987_sql);

          foreach ($fld1987_sql as $key => $value) {
              array_push($consmption_id,$value['bi_catgry_id']);
          }

          $consmptn_result=self::getconsmption($consmption_id,$details['main_location'],$details['sub_location'],$details['selected_location'],$details['year']);
        //var_dump($consmptn_result);
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

         
          $pop_strata="SELECT refid,name FROM `pop_strata_master` where area='U'  order by order_urban asc";
          $pop_strata = DB::select(DB::raw($pop_strata));
          $pop_strata=CommonController::getarray($pop_strata);
          $population[0]='';
          $population['']='';
           foreach ($pop_strata as $key => $value) {
              $population[$value['refid']]=$value['name'];
          }

          if(count($index_type)>0)
            array_push($where,' a.fld1987  in ('.implode(",",$index_type).')');

         array_push($where,'  period_Y in ("'.implode(",",$details['year']).'") ');

          


          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

          
         

          $sql= 'SELECT a.loc'.$details["sub_location"].' as loc_id,ROUND(SUM(sub2_Q1+ sub2_Q2+sub2_Q3+sub2_Q4),2) result ,period_Y as period ,"" location_type  FROM '.$fetch_table.' as a  WHERE '.join(" and ",$where).'  GROUP BY loc_id ';
          $index=$sql." order by period asc,result desc";

          $result = DB::select(DB::raw($index));
          $result=CommonController::getarray($result);


          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
    if($details['main_location']==$details['sub_location'] && $details['main_location']==12)
           $additional_result['column'][2]=array('src'=>'population','type'=>'I','align'=>'right','label'=>'Popn Strata');
           $additional_result['column'][3]=array('src'=>'sale_result','type'=>'I','align'=>'right','label'=>'Mdlz Sales (Rs.)');
           $additional_result['column'][4]=array('src'=>'category_result','type'=>'I','align'=>'right','label'=>'Catgry Consmptn (Rs.)');
           $additional_result['column'][5]=array('src'=>'result','type'=>'I','align'=>'right','label'=>'Catgry Share %');
               
         $details['tooltip']=['Mdlz Sales'=>['sale_result','Rs.',0,1],'Catgry Consmptn'=>['category_result','Rs.',0,1],$details['menu_axis']=>['result','%',0]];
     
          
        $cumulative_share=0;
        $contrib_share=0;        
        $total_result=array_sum(array_column($result,'result'));
        $total_result=array_sum(array_column($result,'result'));
          for($i=0;$i<count($result);$i++)
          {
            $final_result[$i]=[];
            $final_result[$i]['result']=0;                              
            $final_result[$i]['loc_id']=$result[$i]['loc_id'];
            $final_result[$i]['sale_result']=$result[$i]['result'];
         if(isset($details['maparray'][$result[$i]['loc_id']]))
         {
             if(isset($consmptn_result[$result[$i]['loc_id']]['result']))
            {
                $final_result[$i]['category_result']=$consmptn_result[$result[$i]['loc_id']]['result'];
                $final_result[$i]['result']=round((($final_result[$i]['sale_result']/$final_result[$i]['category_result'])*100),1); 
               $final_result[$i]['result']=( $final_result[$i]['result'] > 100) ? 100 : $final_result[$i]['result'];
                $additional_result['values'][$result[$i]['loc_id']]=array('loc_id'=>$result[$i]['loc_id'],'location_name'=>$details['maparray'][$result[$i]['loc_id']]['location_name'],'result'=>$final_result[$i]['result'],'category_result'=>number_format($final_result[$i]['category_result'],0),'sale_result'=>number_format($final_result[$i]['sale_result'],0),'population'=>$population[$consmptn_result[$result[$i]['loc_id']]['pop_id']]);
            }
            else
            {
                $final_result[$i]['category_result']=0;
                $final_result[$i]['result']=0;

                $additional_result['values'][$result[$i]['loc_id']]=array('loc_id'=>$result[$i]['loc_id'],'location_name'=>$details['maparray'][$result[$i]['loc_id']]['location_name'],'result'=>0,'category_result'=>0,'sale_result'=>0,'population'=>'');
            }
         }
         
             

          }

        
          $template='Combinecummulative';
       
       
        }
      

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