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

class Numeric_distribution_Controller extends Controller
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
    public static function numeric_distribution($details,$maparray,$input_obj)
    {
    
          $final_result=[];
          $additional_result=[];
          $split_master=[];
          $location_name=[];
          $location_name['7']='state_id';
          $location_name['9']='district_id';
          $location_name['10']='taluk_id';
          $location_name['12']='city_id';
          $location_name['15']='ward_id';
          $location_name['16']='colony_id';

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.'.$location_name[$details['sub_location']];
          $fetch_table_retailer='mdlz.mdlz_urban_3cities_sales';
          if($details['sub_location']==16)
            $fetch_table='economics_bi_2005_split.all_retailer_colony';
          else
          $fetch_table='economics_bi_2005_split.all_retailer';

       
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.'.$location_name[$details['sub_location']].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.'.$location_name[$details['main_location']].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
//

          

         $retailer_sql="SELECT ".$location_name[$details['sub_location']]." loc_id,round((sum(food_cgrat) * 0.25)+sum(a.cosmatic)+(sum(a.prvsn)+sum(a.gens)),0) result, ".(($details['sub_location']!=16) ?  'a.fld1225' : 1)." as pop_id   FROM ".$fetch_table." as a WHERE   ".join(" and ",$where)." and ( a.stat != 'R')  GROUP BY loc_id";
          
          $retailer_sql = DB::select(DB::raw($retailer_sql));
          $retailer_sql=CommonController::getarray($retailer_sql);
          $retailer=[];
           foreach ($retailer_sql as $key => $value) {
              $retailer[$value['loc_id']]=['result'=>$value['result'],'pop_id'=>$value['pop_id']];
          }


          $pop_strata="SELECT refid,name FROM `pop_strata_master` where area='U'  order by order_urban asc";
          $pop_strata = DB::select(DB::raw($pop_strata));
          $pop_strata=CommonController::getarray($pop_strata);
          $population[0]='';
          $population['']='';
           foreach ($pop_strata as $key => $value) {
              $population[$value['refid']]=$value['name'];
          }
          $temp=[];$where=[];
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $category_id=[];

          if(count($index_type)>0)
            array_push($where,' a.fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  a.period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

 //           select a.loc_id as loc15,((a.result/b.result)*100) as result,a.period,a.fld1987,a.loc12,0,'nd',1 from
 // (SELECT a.loc12,a.loc15 as loc_id,COUNT(DISTINCT(fld1986)) result,period_Y as period,a.fld1987
 // FROM mdlz.mdlz_urban_3cities_sales as a
 // WHERE  a.fld1987 in (3,4,6,5) and period_Y in (2023,202) and loc12 in (13346,15278,786) GROUP BY loc_id,loc12,period,fld1987 ) as a,
 // (SELECT ward_id loc_id,round((sum(food_cgrat) * 0.25)+sum(a.cosmatic)+(sum(a.prvsn)+sum(a.gens)),0) result
 // FROM economics_bi_2005_split.all_retailer as a WHERE  ( a.stat != 'R') GROUP BY loc_id) as b where a.loc_id=b.loc_id
 // group by a.loc12,a.loc_id,a.period,a.fld1987;

          // $sql= 'SELECT a.loc'.$details["sub_location"].' as loc_id,COUNT(DISTINCT(fld1986)) result,period_Y as period ,"" location_type  FROM '.$fetch_table_retailer.' as a  WHERE '.join(" and ",$where).' and a.loc'.$details["sub_location"].' !=0 and a.loc'.$details["sub_location"].'!=""  GROUP BY loc_id ';
          // $index=$sql." order by period asc,result desc";

            $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];

   $mscore="select loc".$details["sub_location"]." as loc_id,avg(ifnull(result,0)) as result,mdlz_cnt,fmcg_cnt from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']."  and period in (".implode(",",$details['year']).") and menu_id in (".implode(",",$index_type).")  and type_id=1 group by loc_id,period order by result desc" ; 

          $result = DB::select(DB::raw($mscore));
          $result=CommonController::getarray($result);


          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
        // if($details['main_location']==$details['sub_location'] && $details['main_location']==12)
        //    $additional_result['column'][2]=array('src'=>'population','type'=>'I','align'=>'right','label'=>'Popn Strata');
           $additional_result['column'][3]=array('src'=>'mdlz_retailer','type'=>'I','align'=>'right','label'=>'MDLZ Retlr Nos.');
           $additional_result['column'][4]=array('src'=>'fmcg_retailer','type'=>'I','align'=>'right','label'=>'FMCG Retlr Nos.');
           $additional_result['column'][5]=array('src'=>'result','type'=>'I','align'=>'right','label'=>'Numeric Distrbtn');
               
         $details['tooltip']=['MDLZ Retlr Nos.'=>['mdlz_retailer','Nos.',''],'FMCG Retlr Nos.'=>['fmcg_retailer','Nos.',''],'Numeric Distrbtn'=>['result','%',0]];
  
         
        
          
        $cumulative_share=0;
        $contrib_share=0;        
        $total_result=array_sum(array_column($result,'result'));
        $total_result=array_sum(array_column($result,'result'));
          for($i=0;$i<count($result);$i++)
          {
            $final_result[$i]=[];
            $final_result[$i]['result']=0;                              
            $final_result[$i]['loc_id']=$result[$i]['loc_id'];
            $final_result[$i]['mdlz_retailer']=$result[$i]['mdlz_cnt'];
            $final_result[$i]['fmcg_retailer']= $result[$i]['fmcg_cnt'];
               $final_result[$i]['result']= number_format($result[$i]['result'],2);

            $final_result[$i]['population']='';

         if(isset($details['maparray'][$result[$i]['loc_id']]))
         {
               $additional_result['values'][$result[$i]['loc_id']]=array('loc_id'=>$result[$i]['loc_id'],'location_name'=>$details['maparray'][$result[$i]['loc_id']]['location_name'],'result'=>$final_result[$i]['result'],'mdlz_retailer'=>number_format($final_result[$i]['mdlz_retailer'],0),'fmcg_retailer'=>number_format($final_result[$i]['fmcg_retailer'],0),'population'=>0);

          
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