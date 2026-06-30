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

class Unique_linebiller_Controller extends Controller
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
    public static function unique_line($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis']=>['result','Nos.',0],'Contrbtn Share %'=>['contribution_share','%',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
        //  $fetch_table='mdlz.mdlz_urban_3cities_sales';mdlz_urban_3cities_sales_redistrbtd
           $fetch_table='mdlz.mdlz_urban_3cities_sales_redistrbtd';
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' a.fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  a.period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];
          $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];
 
//         if(in_array(2023,$details['year']))
//            $ulb_sales_sql='SELECT loc'.$details["sub_location"].' as loc_id, round(SUM(result)/COUNT(distinct(fld1986)),2) as result,period_Y FROM
// (SELECT loc'.$details["sub_location"].',fld1986,period_Y,fld1987, (COUNT(DISTINCT CASE WHEN sub2_M1 != 0 THEN fld1991 END) +COUNT(DISTINCT CASE WHEN sub2_M2!= 0 THEN fld1991 END) +COUNT(DISTINCT CASE WHEN sub2_M3!= 0 THEN fld1991 END) +COUNT(DISTINCT CASE WHEN sub2_M4 != 0 THEN fld1991 END) +
// COUNT(DISTINCT CASE WHEN sub2_M5 != 0 THEN fld1991 END) + COUNT(DISTINCT CASE WHEN sub2_M6 != 0 THEN fld1991 END)+
// COUNT(DISTINCT CASE WHEN sub2_M7 != 0 THEN fld1991 END)+COUNT(DISTINCT CASE WHEN sub2_M8 != 0 THEN fld1991 END)+
// COUNT(DISTINCT CASE WHEN sub2_M9 != 0 THEN fld1991 END)+COUNT(DISTINCT CASE WHEN sub2_M10 != 0 THEN fld1991 END)+
// COUNT(DISTINCT CASE WHEN sub2_M11 != 0 THEN fld1991 END)+COUNT(DISTINCT CASE WHEN sub2_M12 != 0 THEN fld1991 END))/12 as result
// FROM mdlz.mdlz_urban_3cities_sales WHERE loc'.$details['main_location'].' = '.$details['selected_location'].'  and fld1987  in ('.implode(",",$index_type).') and  period_Y in ('.implode(",",$details['year']).')  GROUP BY loc15,fld1986) b GROUP BY loc_id';

//  if(in_array(2024,$details['year']))
//   $ulb_sales_sql='SELECT loc'.$details["sub_location"].' as loc_id, round(SUM(result)/COUNT(distinct(fld1986)),2) as result,period_Y FROM
// (SELECT loc'.$details["sub_location"].',fld1986,period_Y,fld1987, (COUNT(DISTINCT CASE WHEN sub2_M1 != 0 THEN fld1991 END) +COUNT(DISTINCT CASE WHEN sub2_M2!= 0 THEN fld1991 END) +COUNT(DISTINCT CASE WHEN sub2_M3!= 0 THEN fld1991 END) +COUNT(DISTINCT CASE WHEN sub2_M4 != 0 THEN fld1991 END) +
// COUNT(DISTINCT CASE WHEN sub2_M5 != 0 THEN fld1991 END))/5 as result
// FROM mdlz.mdlz_urban_3cities_sales WHERE loc'.$details['main_location'].' = '.$details['selected_location'].'  and fld1987  in ('.implode(",",$index_type).') and  period_Y in ('.implode(",",$details['year']).')  GROUP BY loc15,fld1986) b GROUP BY loc_id';
     $ulb_sales_sql="select loc".$details["sub_location"]." as loc_id,sum(ifnull(result,0)) as result from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']." and menu_id in (".implode(",",$index_type).") and period in (".implode(",",$details['year']).") and type_id=2 group by loc_id,period order by result desc" ; 

           $ulb_sales_result = DB::select(DB::raw($ulb_sales_sql));
          $ulb_sales_result=CommonController::getarray($ulb_sales_result);
          $ulb_sales_result_count=count($ulb_sales_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];


           $additional_result['column'][3]=array('src'=>'result','type'=>'I','align'=>'right','label'=>$details['menu_axis'].' Sale (ULB Nos.)');
           $additional_result['column'][4]=array('src'=>'cumulative_share','type'=>'I','align'=>'right','label'=>'Cumulative Share %');
           $additional_result['column'][5]=array('src'=>'contribution_share','type'=>'I','align'=>'right','label'=>'Contrbtn Share %');

           $cumulative_share=0;$contrib_share=0;
            $total_result=array_sum(array_column($ulb_sales_result,'result'));

        
          for($i=0;$i<count($ulb_sales_result);$i++)
          {
            $final_result[$i]=[];
            $final_result[$i]['result']=0;                              
            $final_result[$i]['loc_id']=$ulb_sales_result[$i]['loc_id'];
            $final_result[$i]['result']=round($ulb_sales_result[$i]['result'],0);
            $contrib_share=round((($ulb_sales_result[$i]['result']/$total_result)*100),1);
            $cumulative_share=$cumulative_share+$contrib_share;       
         
            if(isset($details['maparray'][$ulb_sales_result[$i]['loc_id']]))
             $additional_result['values'][$ulb_sales_result[$i]['loc_id']]=array('loc_id'=>$ulb_sales_result[$i]['loc_id'],'location_name'=>$details['maparray'][$ulb_sales_result[$i]['loc_id']]['location_name'],'result'=>$final_result[$i]['result'],'cumulative_share'=>$cumulative_share,'contribution_share'=>$contrib_share);
             

          }

        
          $template='Combinecummulative';
       
       
        }
      

        $flag=$input_obj['flag'];
       // $template=$action->gettemplate($details['view_type'],$details['period_result_type'],$flag,$split_combine_table_details->template_id);
        $namespace = "App\Http\Controllers\\";
         $controllerName = $namespace . $template.'Controller';         
        $template_controller = new $controllerName();
        if($flag=='C')
          return $template_controller->$template($final_result,$details,$additional_result,'Nos.');
        if($flag=='S')
          return $template_controller->$template($final_result,$details,$additional_result,$split_master,'Nos.');


    }
   
    
}