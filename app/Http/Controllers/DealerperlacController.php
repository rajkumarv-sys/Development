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

class DealerperlacController extends Controller
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
    public static function dealerperlac($details,$maparray,$input_obj)
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
          $fetch_table='economics_bi_2005_split.all_retailer';
          $fetch_table_population=[12=>'pca_combo_2011.fifth_combo_city',15=>'pca_combo_2011.fourth_combo_ward',16=>'pca_combo_2011.fourth_combo_colony'];
          $location_name=[];
          $location_name['7']='state_id';
          $location_name['9']='district_id';
          $location_name['10']='taluk_id';
          $location_name['12']='city_id';
          $location_name['15']='ward_id';
          $location_name['16']='colony_id';
          
           $pop_sql="SELECT ".$location_name[$details['sub_location']]." locid,round(sum(age_5_9+((age_5_9*pop2020)/100 )),0)+round(sum(age_10_14+((age_10_14*pop2020)/100 )),0)+round(sum(age_15_19+((age_15_19*pop2020)/100 )),0)+round(sum(age_20_24+((age_20_24*pop2020)/100 )),0)+round(sum(age_25_29+((age_25_29*pop2020)/100 )),0)+round(sum(age_30_34+((age_30_34*pop2020)/100 )),0)+round(sum(age_35_39+((age_35_39*pop2020)/100 )),0)+round(sum(age_40_44+((age_40_44*pop2020)/100 )),0)+round(sum(age_45_49+((age_45_49*pop2020)/100 )),0)+round(sum(age_50_54+((age_50_54*pop2020)/100 )),0)+round(sum(age_55_59+((age_55_59*pop2020)/100 )),0)+round(sum(age_60_64+((age_60_64*pop2020)/100 )),0)+round(sum(age_65_69+((age_65_69*pop2020)/100 )),0)+round(sum(age_70_74+((age_70_74*pop2020)/100 )),0)+round(sum(age_75_79+((age_75_79*pop2020)/100 )),0)+round(sum(age_80+((age_80*pop2020)/100 )),0)+round(sum(age_not_stated+((age_not_stated*pop2020)/100 )),0)+round(sum(age_0_4+((age_0_4*pop2020)/100 )),0) result,".implode(",",$details['year'])." period  FROM ".$fetch_table_population[$details['sub_location']]." where  ( stat != 'R')  AND ( ".$location_name[$details['sub_location']]." != '0')  AND ( ".$location_name[$details['main_location']]." = ".$details['selected_location'].")  GROUP BY locid ";
            

              $pop_sql_result = DB::select(DB::raw($pop_sql));
              $pop_sql_result=CommonController::getarray($pop_sql_result);
              $pop_count=count($pop_sql_result);
              for($k=0;$k<$pop_count;$k++)
               {
                  $population[$pop_sql_result[$k]['locid']]=[];
                  $population[$pop_sql_result[$k]['locid']]['loc_id']=$pop_sql_result[$k]['locid'];
                  $population[$pop_sql_result[$k]['locid']]['pop_data']=$pop_sql_result[$k]['result'];

               }
        
         
          $pop_strata="SELECT refid,name FROM `pop_strata_master` where area='U'  order by order_urban asc";
          $pop_strata = DB::select(DB::raw($pop_strata));
          $pop_strata=CommonController::getarray($pop_strata);
          $population_name[0]='';
          $population_name['']='';
           foreach ($pop_strata as $key => $value) {
              $population_name[$value['refid']]=$value['name'];
          }

         if($details['main_location']==$details['sub_location'])         
          $temp ='a.'.$location_name[$details['sub_location']].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.'.$location_name[$details['main_location']].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
          $result_str='';
          $menu_list=[3=>'sum(a.food_cgrat)',4=>'sum(a.cosmatic)',21=>'sum(a.gens)+sum(a.prvsn)'];
          foreach($index_type as $k=>$v)
          {
            $result_str .= $menu_list[$v].'+';

          }
          $result_str=trim($result_str,"+"). ' as result';
        
          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];
  

          $retailer_sql='SELECT a.'.$location_name[$details['sub_location']].' as loc_id,fld1225 as pop_id,'.$result_str.'   FROM '.$fetch_table.' as a  WHERE a.'.$location_name[$details['sub_location']].'!=0 and a.'.$location_name[$details['sub_location']].'!="" and  '.join(" and ",$where).'  GROUP BY loc_id';
        
           $retailer_sql = DB::select(DB::raw($retailer_sql));
          $retailer_sql=CommonController::getarray($retailer_sql);
          $retailer_sql_count=count($retailer_sql);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];

          if($details['main_location']==$details['sub_location'] && $details['main_location']==12)
             $additional_result['column'][2]=array('src'=>'population','type'=>'I','align'=>'right','label'=>'Popn Strata');

           $additional_result['column'][3]=array('src'=>'population_data','type'=>'I','align'=>'right','label'=>'Total Indvdls');
           $additional_result['column'][4]=array('src'=>'retailer_data','type'=>'I','align'=>'right','label'=>'Retailer Univrs');
           $additional_result['column'][5]=array('src'=>'result','type'=>'I','align'=>'right','label'=>'Dealers Per Lakh (DPL) (Nos.)');
           $additional_result['column'][6]=array('src'=>'cumulative_share','type'=>'I','align'=>'right','label'=>'Cumultv Share %');
           $additional_result['column'][7]=array('src'=>'contribution_share','type'=>'I','align'=>'right','label'=>'Contrbtn Share %');

           $cumulative_share=0;$contrib_share=0;$total_result=0;
           for($i=0;$i<$retailer_sql_count;$i++)
           {
               $retailer_data=$retailer_sql[$i]['result'];
               $population_data=1;
               if(isset($population[$retailer_sql[$i]['loc_id']]))
                 $population_data=$population[$retailer_sql[$i]['loc_id']]['pop_data'];
               $total_result=(($retailer_data/$population_data)*100000)+$total_result;

           }
           $details['tooltip']=['Retailer Univrs'=>['retailer_data','Nos.',0],'Total Indvdls'=>['population_data','Nos.',0],$details['menu_axis']=>['result_tool','Nos.',0],'Contrbtn Share %'=>['contribution_share','%',0]];
  
         
        
          for($i=0;$i<$retailer_sql_count;$i++)
          {
            $final_result[$i]=[];
            $final_result[$i]['result']=0;                              
            $final_result[$i]['loc_id']=$retailer_sql[$i]['loc_id'];
            $final_result[$i]['population']=$population_name[$retailer_sql[$i]['pop_id']];
            $final_result[$i]['retailer_data']=$retailer_sql[$i]['result'];
            $final_result[$i]['population_data']=(isset($population[$retailer_sql[$i]['loc_id']])) ? $population[$retailer_sql[$i]['loc_id']]['pop_data'] : 1;
            $final_result[$i]['result']=(($final_result[$i]['retailer_data']/$final_result[$i]['population_data'])*100000);

            $contrib_share=round((($final_result[$i]['result']/$total_result)*100),1);
            $cumulative_share=$cumulative_share+$contrib_share;       
         
            if(isset($details['maparray'][$retailer_sql[$i]['loc_id']]))
             $additional_result['values'][$retailer_sql[$i]['loc_id']]=array('loc_id'=>$retailer_sql[$i]['loc_id'],'location_name'=>$details['maparray'][$retailer_sql[$i]['loc_id']]['location_name'],'result'=>round($final_result[$i]['result'],0),'result_tool'=>number_format(round($final_result[$i]['result'],0)),'cumulative_share'=>$cumulative_share,'contribution_share'=>$contrib_share,'retailer_data'=>number_format($final_result[$i]['retailer_data'],0),'population_data'=>number_format($final_result[$i]['population_data'],0),'population'=>$final_result[$i]['population']);
          }

        
          $template='Combinecummulative';
       
     
        }
      

        $flag=$input_obj['flag'];
      
        $namespace = "App\Http\Controllers\\";
         $controllerName = $namespace . $template.'Controller';         
        $template_controller = new $controllerName();
        if($flag=='C')
          return $template_controller->$template($final_result,$details,$additional_result,'Nos.');
        if($flag=='S')
          return $template_controller->$template($final_result,$details,$additional_result,$split_master,'Nos.');


    }
   
    
}