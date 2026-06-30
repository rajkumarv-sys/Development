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

class Premium_sales_Controller extends Controller
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
    public static function premium_sales($details,$maparray,$input_obj)
    {
   
        $final_result=[];
        $additional_result=[];
        $split_master=[];

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
          //$fetch_table='mdlz.mdlz_urban_3cities_sales';
          $fetch_table='mdlz.mdlz_urban_3cities_sales_redistrbtd';
          
       //   $consmptn_result=ConsmptionController::consmption($details,$maparray,$input_obj,true);
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp); 
           $details['yearlist']=[];
               $count_year=count($details['year']);
               $select =[];$select_monthquarter=[];

                if($details['calendar_type']==2)
                {
                  for($j=0;$j<$count_year;$j++)
                  {
                    $select[$details['year'][$j]]=['sub2_M1','sub2_M2','sub2_M3','sub2_M4','sub2_M5','sub2_M6','sub2_M7','sub2_M8','sub2_M9','sub2_M10','sub2_M11','sub2_M12'];

                    if(!in_array($details['year'][$j],$details['yearlist']))
                         array_push($details['yearlist'],$details['year'][$j]);
                  }

                   
                }
                if(in_array($details['calendar_type'],[4,6]))
                {
                    for($j=0;$j<$count_year;$j++)
                  {
                        $quartermonth_year=explode("_",$details['year'][$j]);

                     if(!isset($select[$quartermonth_year[1]]))
                     {
                        $select[$quartermonth_year[1]]=[];
                        if(in_array($details['calendar_type'],[4,6]))
                            $select_monthquarter[$quartermonth_year[1]]=[];
                        array_push($details['yearlist'],$quartermonth_year[1]);
                     }
                         

                         if($details['calendar_type']==4)
                            array_push($select[$quartermonth_year[1]],'sub2_M'.$quartermonth_year[0]);
                         if($details['calendar_type']==6)
                            array_push($select[$quartermonth_year[1]],'sub2_Q'.$quartermonth_year[0]);


                         if($details['calendar_type']==4)
                            array_push($select_monthquarter[$quartermonth_year[1]],'sum(sub2_M'.$quartermonth_year[0].') as '.$details['year'][$j].'');
                         if($details['calendar_type']==6)
                            array_push($select_monthquarter[$quartermonth_year[1]],'sum(sub2_Q'.$quartermonth_year[0].') as '.$details['year'][$j].'');


                  }
                }  

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $pop_strata="SELECT refid,name FROM `pop_strata_master` where area='U'  order by order_urban asc";
          $pop_strata = DB::select(DB::raw($pop_strata));
          $pop_strata=CommonController::getarray($pop_strata);
          $population[0]='';
          $population['']='';
           foreach ($pop_strata as $key => $value) {
              $population[$value['refid']]=$value['name'];
          }

          $category_id=[];


          // $fld1987_sql='select distinct fld1987 from mdlz_urban_brand_master where bi_catgry_id="'.implode(",",$index_type).'" and stat="A"';
          // $fld1987_sql = DB::select(DB::raw($fld1987_sql));
          // $fld1987_sql=CommonController::getarray($fld1987_sql);

          // foreach ($fld1987_sql as $key => $value) {
          //     array_push($category_id,$value['fld1987']);
          // }

          if(count($index_type)>0)
            array_push($where,' a.fld1987  in ('.implode(",",$index_type).')');
        //  array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];       
          $total_sales=[];
          $query=[]; $yearlist=count($details['yearlist']);
          for($i=0;$i<$yearlist;$i++)
          {
              $total_sql= 'SELECT a.loc'.$details["sub_location"].' as loc_id,sum('.join('+',$select[$details['yearlist'][$i]]).') result ,'.((isset($select_monthquarter[$details['yearlist'][$i]])) ? implode(",",$select_monthquarter[$details['yearlist'][$i]]).',' : '' ).' period_Y as period ,"" location_type,COUNT(DISTINCT(fld1986)) shop  FROM '.$fetch_table.' as a  WHERE '.join(" and ",$where).' and a.period_Y='.$details['yearlist'][$i].' GROUP BY loc_id ';
               array_push($query,$total_sql);
          }
         
         // $index=$total_sql." order by period asc,result desc";
          $query=join(" union ",$query);
          $index=$query." order by period asc,result desc";
          $result = DB::select(DB::raw($index));
          $total_sales_result=CommonController::getarray($result);
          $total_sales_result_count=count($total_sales_result);
          for($i=0;$i<$total_sales_result_count;$i++)
          {
              $total_sales[$total_sales_result[$i]['loc_id'].'-'.$total_sales_result[$i]['period']]=$total_sales_result[$i]['result'];
          }
         
          $query=[]; 
          for($i=0;$i<$yearlist;$i++)
          {
            $prmium_sales_sql='SELECT a.loc'.$details["sub_location"].' as loc_id,sum('.join('+',$select[$details['yearlist'][$i]]).') result ,'.((isset($select_monthquarter[$details['yearlist'][$i]])) ? implode(",",$select_monthquarter[$details['yearlist'][$i]]).',' : '' ).' period_Y as period ,fld1225 FROM '.$fetch_table.' as a  WHERE  '.join(" and ",$where).' and a.period_Y='.$details['yearlist'][$i].' and fld2004=1 GROUP BY loc_id';
            array_push($query,$prmium_sales_sql);
          }
          $query=join(" union ",$query);
          $prmium_sales_sql=$query." order by period asc,result desc";
          $prmium_sales_result = DB::select(DB::raw($prmium_sales_sql));
          $prmium_sales_result=CommonController::getarray($prmium_sales_result);
          $prmium_sales_result_count=count($prmium_sales_result);
          $additional_result['column']=[];
          $additional_result['values']=[];

          if(($details['view_master']==1) && (in_array($details['period_type'],[3,2,1]))) 
          {
          if($details['main_location']==$details['sub_location'] && $details['main_location']==12)
            $additional_result['column'][2]=array('src'=>'population','type'=>'I','align'=>'right','label'=>'Popn Strata');
            $additional_result['column'][3]=array('src'=>'premium_result','type'=>'I','align'=>'right','label'=>'MDLZ Premium Sales (Rs.)');
            $additional_result['column'][4]=array('src'=>'totalsales_result','type'=>'I','align'=>'right','label'=>'MDLZ Portfolio Sales (Rs.)');
           $additional_result['column'][5]=array('src'=>'result','type'=>'I','align'=>'right','label'=>'Penetration %');
            $location_id=array_column($prmium_sales_result,'loc_id');
            $filtered_location=array_values(array_unique($location_id));
            $filter_count=count($filtered_location);
           for($i=0;$i<$filter_count;$i++)
          {

            $filter_id=$filtered_location[$i];

            $location_wise_result = array_filter($prmium_sales_result, function ($var) use ($filter_id) {
                          return ($var['loc_id'] == $filter_id);
                      });
            $location_wise_result=array_values($location_wise_result);
            $final_result[$i]=[];
            $final_result[$i]['result']=0; 
            $final_result[$i]['totalsales_result']=0;
            $final_result[$i]['premium_result']=0;

            for($j=0;$j<count($location_wise_result);$j++)
             {    

                if(!empty($location_wise_result[$j]))
                {
                  $final_result[$i]['premium_result']=$final_result[$i]['premium_result']+$location_wise_result[$j]['result'];
                  $final_result[$i]['totalsales_result']=1;
                  if(isset($total_sales[$location_wise_result[$j]['loc_id'].'-'.$location_wise_result[$j]['period']]))
                    $totalsales_result=$total_sales[$location_wise_result[$j]['loc_id'].'-'.$location_wise_result[$j]['period']];

                  $final_result[$i]['totalsales_result']=$final_result[$i]['totalsales_result']+$totalsales_result;
                  

                  $final_result[$i]['result']=$final_result[$i]['result']+$location_wise_result[$j]['result'];
               
                  $final_result[$i]['fld1225']= $location_wise_result[$j]['fld1225'];
                }            
              
             }
             $final_result[$i]['result']=round((($final_result[$i]['premium_result']/$final_result[$i]['totalsales_result'])*100),0);
             $final_result[$i]['loc_id']=$filter_id;
         if(isset($details['maparray'][$final_result[$i]['loc_id']]))
           $additional_result['values'][$final_result[$i]['loc_id']]=array('loc_id'=>$final_result[$i]['loc_id'],'location_name'=>$details['maparray'][$final_result[$i]['loc_id']]['location_name'],'result'=>$final_result[$i]['result'],'totalsales_result'=>number_format($final_result[$i]['totalsales_result'],0),'premium_result'=>number_format($final_result[$i]['premium_result'],0),'population'=>$population[$final_result[$i]['fld1225']]);

        
         }
            
             $details['tooltip']=['MDLZ Premium Sales'=>['premium_result','Rs.',0,1],'MDLZ Portfolio Sales'=>['totalsales_result','Rs.',0,1],$details['menu_axis']=>['result','%',0]];
  
          $template='Combinecummulative';
             

          }

       
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