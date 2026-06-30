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

class SecController extends Controller
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
    public static function sec($details,$maparray,$input_obj)
    {

        $final_result=[];
        $additional_result=[];
        $split_master=[];

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name','irs_column'])->get();  

        if($input_obj['flag']=='C')
        {
           $year_count=count($details['year']);
           $location_name=[];
          $location_name['7']='state_id';
          $location_name['9']='district_id';
          $location_name['10']='taluk_id';
          $location_name['12']='city_id';
          $location_name['15']='ward_id';
          $location_name['16']='colony_id';

           for($y=0;$y<$year_count;$y++)
           {
               ${"select".$y}=[];
             //  $temp=$location_name[$details['sub_location']].' as loc_id';
             //  array_push(${"select".$y},$temp); 
               $temp=''; $sql_count=count($sql);
               for($i=0;$i<$sql_count;$i++)
                {
                  // $temp .='round(sum('.$sql[$i]->irs_column.'+(('.$sql[$i]->irs_column.'* pop'.$details['year'][$y].')/100)),0)+';
                   $temp .='round(sum('.$sql[$i]->irs_column.'+(('.$sql[$i]->irs_column.'* pop2023)/100)),0)+';
                             
                }
               array_push(${"select".$y},trim($temp,"+"));
               ${"select".$y} = '('.join(" , ",${"select".$y}).')';
            }

          $column='loc'.$details['sub_location'];
          if($details['main_location']==12 && $details['sub_location']==12)
            $fetch_table='irs_sec_hhs_cluster.all_india_pop_stra_sec';
          if(($details['main_location']==12 || $details['main_location']==15) && $details['sub_location']==15)
            $fetch_table='irs_sec_hhs_cluster.ward_sec_hhs';
          if($details['sub_location'] == 16)
          {

            $fetch_table='irs_sec_hhs_cluster.colony_sec_hhs_final';
            $temp=$location_name[$details['sub_location']].'!=0';
            array_push($where,$temp); 

          }
            
          $where_sub=[];
           $temp=' stat="A"';
          array_push($where_sub,$temp); 
        if($details['main_location']==$details['sub_location'])         
          $temp ='loc'.$details['sub_location'].'="'.$details['selected_location'].'"';
        if($details['main_location']!=$details['sub_location'])     
          $temp ='loc'.$details['main_location'].'="'.$details['selected_location'].'"';    
          array_push($where_sub,$temp); 

          $temp=' stat="A"';
          array_push($where,$temp); 
        if($details['main_location']==$details['sub_location'])         
          $temp =$location_name[$details['sub_location']].'="'.$details['selected_location'].'"';
        if($details['main_location']!=$details['sub_location'])     
          $temp =$location_name[$details['main_location']].'="'.$details['selected_location'].'"';

          array_push($where,$temp);         
       

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[]; 
          $year_c=count($details['year']);
          
          for($y=0;$y <$year_c ;$y++)
          {
           if($details['sub_location'] == 14)
             $query=" select a.loc_id,a.result,b.total_hh as total_hh,round(((a.result/b.total_hh)*100),2) as penetration,a.location_type,period from  (SELECT ".$location_name[$details['sub_location']]." as loc_id,".${"select".$y}." as result,".$details['year'][$y]." period,if(loc13!=0,'village','town') as location_type   FROM ".$fetch_table." WHERE  ".join(" and ",$where)." and country_id!='0' and country_id!='' and stat!='R' GROUP BY loc_id) as a, (select loc".$details['sub_location']." as loc_id,sum(ifnull(hhs2023,0)) as total_hh from pca_2001_household.hh_data_2001 where ".join(" and ",$where_sub)."  group by loc_id) as b  where a.loc_id=b.loc_id  ";
           else
            $query=" select a.loc_id,a.result,b.total_hh as total_hh,round(((a.result/b.total_hh)*100),2) as penetration,'' location_type,period from  (SELECT ".$location_name[$details['sub_location']]." as loc_id,".${"select".$y}." as result,".$details['year'][$y]." period  FROM ".$fetch_table." WHERE  ".join(" and ",$where)."  GROUP BY loc_id) as a, (select ".(($details['sub_location']==16) ? $location_name[$details['sub_location']]  : "loc".$details['sub_location'])." as loc_id,sum(ifnull(hhs2023,0)) as total_hh from ".(($details['sub_location']==16) ? "pca_2001_household.hh_data_2001_colony" : "pca_2001_household.hh_data_2001")." where ".(($details['sub_location']==16) ? join(" and ",$where) :  join(" and ",$where_sub))."   group by loc_id) as b  where a.loc_id=b.loc_id";
            array_push($subquery,$query);
          }
/*
//$query=" select a.loc_id,a.result,'' location_type,period,0 total_hh,0 penetration from  (SELECT ".${"select".$y}." as result,".$details['year'][$y]." period  FROM ".$fetch_table." WHERE  ".join(" and ",$where)."  GROUP BY loc_id) as a ";

           //$query=" select a.loc_id,a.result,b.total_hh as total_hh,round(((a.result/b.total_hh)*100),2) as penetration,'' location_type,period from  (SELECT ".${"select".$y}." as result,".$details['year'][$y]." period  FROM ".$fetch_table." WHERE  ".join(" and ",$where)."  GROUP BY loc_id) as a, (select ".$location_name[$details['sub_location']]." as loc_id,sum(ifnull(hhs".$details['year'][$y].",0)) as total_hh from hh_data_2001 where ".join(" and ",$where)."  group by loc_id) as b  where a.loc_id=b.loc_id";
*/
          $subquery=join(" union ",$subquery);
          $sec_combine=$subquery." order by period asc,result desc";   
         // echo $sec_combine;die;      
          $result = DB::select(DB::raw($sec_combine));
          $result=CommonController::getarray($result);

          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];

        // var_dump($details['period_type']);
        // var_dump($details['view_master']);
        // die;
       if(($details['period_type']==1) && ($details['view_master']==1)) //single cummulative
       {
             $additional_result['column'][2]=array('src'=>'total_hh','type'=>'I','align'=>'right','label'=>'Total HHs (HHs)');
             $additional_result['column'][3]=array('src'=>'result','type'=>'I','align'=>'right','label'=>'NCCS / SEC HHs (HHs)');
             $additional_result['column'][4]=array('src'=>'penetration','type'=>'I','align'=>'right','label'=>'Penetration(%)');
             $additional_result['column'][5]=array('src'=>'cumulative_share','type'=>'P','align'=>'right','label'=>'Cumultv Share(%)');
             $additional_result['column'][6]=array('src'=>'contrib_share','type'=>'P','align'=>'right','label'=>'Contrbn Share(%)');
       
          
        $cumulative_share=0;
        $contrib_share=0;
        $total_result=array_sum(array_column($result,'result'));
          for($i=0;$i<count($result);$i++)
          {
              
               
                $final_result[$i]=[];
                $final_result[$i]['result']=0;                              
                $final_result[$i]['loc_id']=$result[$i]['loc_id'];
                $final_result[$i]['result']=$result[$i]['result'];
                $final_result[$i]['location_type']=$result[$i]['location_type'];
                $contrib_share=round((($result[$i]['result']/$total_result)*100),2);
                $cumulative_share=$cumulative_share+$contrib_share;           
                $final_result[$i]['penetration']=round($result[$i]['penetration'],1);
            if(isset($details['maparray'][$result[$i]['loc_id']]))  
                $additional_result['values'][$result[$i]['loc_id']]=array('loc_id'=>$result[$i]['loc_id'],'location_name'=>$details['maparray'][$result[$i]['loc_id']]['location_name'],'result_tool'=>number_format((int)$result[$i]['result']),'result'=>(int)$result[$i]['result'],'cumulative_share'=>$cumulative_share,'contrib_share'=>$contrib_share,'penetration'=>round($result[$i]['penetration'],1),'total_hh'=>number_format($result[$i]['total_hh']));
             

          }
          $template='Combinecummulative';
          $details['tooltip']=[$details['menu_axis']=>['result_tool','HHs.',''],'Total HHs'=>['total_hh','HHs.',''],'Contrbtn Share %'=>['contrib_share','%',1]];
                
        }
         if(($details['view_master']==1) && (in_array($details['period_type'],[3,2]))) //mixed cummulative
        {
           $additional_result['column'][2]=array('src'=>'total_hh','type'=>'I','align'=>'right','label'=>'Total HHs (HHs)');
            $additional_result['column'][3]=array('src'=>'result','type'=>'I','align'=>'right','label'=>'NCCS / SEC HHs (HHs)');
             $additional_result['column'][4]=array('src'=>'cumulative_share','type'=>'P','align'=>'right','label'=>'Cumultv Share(%)');
            $additional_result['column'][5]=array('src'=>'contrib_share','type'=>'P','align'=>'right','label'=>'Contrbn Share(%)');
        
          $location_id=array_column($result,'loc_id');
           $total_result=array_sum(array_column($result,'result'));
          $filtered_location=array_values(array_unique($location_id));
          $cumulative_share=0;
          $contrib_share=0;
         
          for($i=0;$i<count($filtered_location);$i++)
          {
             $filter_id=$filtered_location[$i];
             $location_wise_result = array_filter($result, function ($var) use ($filter_id) {
                  return ($var['loc_id'] == $filter_id);
              });
            $final_result[$i]=[];
            $final_result[$i]['result']=0;   
            $final_result[$i]['penetration']=0; 
            $final_result[$i]['total_hh']=0;
            $final_result[$i]['location_type']='';
            $final_result[$i]['loc_id']=$filter_id;

           $location_wise_result=array_values($location_wise_result);

             for($j=0;$j<count($location_wise_result);$j++)
             {    

                if(!empty($location_wise_result[$j]))
                {
                  
                  $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                  $final_result[$i]['result']=$final_result[$i]['result']+$location_wise_result[$j]['result'];
                  $final_result[$i]['total_hh']=$final_result[$i]['total_hh']+$location_wise_result[$j]['total_hh'];      

                  $final_result[$i]['penetration']=$final_result[$i]['penetration']+$location_wise_result[$j]['penetration'];                
                   
                }            
              
             }
             $contrib_share=round((($final_result[$i]['result']/$total_result)*100),2);
             $cumulative_share=$cumulative_share+$contrib_share;

            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'total_hh'=>number_format(round($final_result[$i]['total_hh'],0)),'result_tool'=>number_format((int)$final_result[$i]['result']),'result'=>$final_result[$i]['result'],'penetration'=>round($final_result[$i]['penetration'],1),'cumulative_share'=>$cumulative_share,'contrib_share'=>$contrib_share);
          }
           $template='Combinecummulative';
          $details['tooltip']=[$details['menu_axis']=>['result_tool','HHs.',0],'Total HHs'=>['total_hh','HHs.',''],'Contrbtn Share %'=>['contrib_share','%',1]];
         }
         if(in_array($details['period_type'],[2,3]) && ($details['view_master']==2)) // timeseries cummulative
        {

          $additional_result['column']=[];
          $additional_result['values']=[];
        
          $additional_result['column'][2]=array('src'=>'','type'=>'I','align'=>'right','label'=>'NCCS / SEC HHs (HHs)','colspan'=>count($details['year']));
          $additional_result['column'][3]=array('src'=>'total_hh','type'=>'I','align'=>'right','label'=>'Total for Selectd Periods (HHs)');
          $additional_result['column'][4]=array('src'=>'average','type'=>'I','align'=>'right','label'=>'Avg for Selectd Periods (HHs)');

          $location_id=array_column($result,'loc_id');
          $filtered_location=array_unique($location_id);
         
          for($i=0;$i<count($filtered_location);$i++)
          {
             $filter_id=$filtered_location[$i];
             $location_wise_result = array_filter($result, function ($var) use ($filter_id) {
                  return ($var['loc_id'] == $filter_id);
              });

            $final_result[$i]=[];
            $final_result[$i]['result']=0;   
            $final_result[$i]['penetration']=0; 
            $final_result[$i]['total_hh']=0;
            $final_result[$i]['location_type']='';
            $final_result[$i]['loc_id']=$filter_id;
            $final_result[$i]['avg_total_hh']=0;

           $location_wise_result=array_values($location_wise_result);
           

             for($j=0;$j<count($location_wise_result);$j++)
             { 
                if($j==0)
                {
                   $a=$details['year'];
                   $b=array_fill(0,count($a),0);
                   $period=array_combine($a,$b);                   
                }
                if(!empty($location_wise_result[$j]))
                {
                  
                  $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                  $final_result[$i]['result']=$final_result[$i]['result']+$location_wise_result[$j]['result'];
                  $final_result[$i]['total_hh']=$final_result[$i]['total_hh']+$final_result[$i]['result'];
                  $final_result[$i]['penetration']=$final_result[$i]['penetration']+$location_wise_result[$j]['penetration']; 
                  $period[$location_wise_result[$j]['period']]=$final_result[$i]['result']; 

                }
             }
            $average_of_hhs=($final_result[$i]['total_hh'])/($year_c);
            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'total_hh'=>$final_result[$i]['total_hh'],'result'=>$final_result[$i]['result'],'penetration'=>round($final_result[$i]['penetration'],1),'period'=>$period,'average'=>$average_of_hhs);
          }
          $template='combinetimeseries';
           $details['tooltip']=[$details['menu_axis']=>['average','HHs.',0],'Total HHs'=>['total_hh','HHs.','']];
         }
          if(($details['view_master']==3) && (in_array($details['period_type'],[2,3]))) //Combine growth
        {

          $additional_result['column']=[];
          $additional_result['values']=[];
        
            $additional_result['column'][2]=array('src'=>'','type'=>'I','align'=>'right','label'=>'NCCS/SEC HHS (HHs)','colspan'=>count($details['year']));
          $additional_result['column'][3]=array('src'=>'growth','type'=>'P','align'=>'right','label'=>'Growth (%)','colspan'=>0);
           // $location_id=array_column($result,'loc_id');            
           // $result=CommonController::location_wise_groupby_result($result);
            $total_result=array_sum(array_column($result,'result'));
            $contrib_share=0;$cumulative_share=0;
          $location_id=array_column($result,'loc_id');
          $filtered_location=array_unique($location_id);
         
          for($i=0;$i<count($filtered_location);$i++)
          {
             $filter_id=$filtered_location[$i];
             $location_wise_result = array_filter($result, function ($var) use ($filter_id) {
                  return ($var['loc_id'] == $filter_id);
              });

            $final_result[$i]=[];
            $final_result[$i]['result']=0;   
            $final_result[$i]['percentage']=0;             
            $final_result[$i]['location_type']='';
            $final_result[$i]['loc_id']=$filter_id;
            $final_result[$i]['penetration']=0;
            $period=[];

           $location_wise_result=array_values($location_wise_result);
           

             for($j=0;$j<count($location_wise_result);$j++)
             { 
                if($j==0)
                {
                   $a=$details['year'];
                   $b=array_fill(0,count($a),0);
                   $period=array_combine($a,$b); 
                }
                if(!empty($location_wise_result[$j]))
                {
                  
                  $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                   $final_result[$i]['result']=$location_wise_result[$j]['result'];                
                  $period[$location_wise_result[$j]['period']]=$location_wise_result[$j]['result']; 
                  $final_result[$i]['penetration']=$final_result[$i]['penetration']+$location_wise_result[$j]['penetration']; 


                }
                $contrib_share=round((($final_result[$i]['result']/$total_result)*100),2);
                $cumulative_share=$cumulative_share+$contrib_share;
             }
            if(($period[$details['past_year']] <=  0))

            $period[$details['past_year']]=$period[$details['present_year']];

          if(($period[$details['past_year']] <=  0))
            $period[$details['past_year']]=1;

            $final_result[$i]['percentage']=(($period[$details['present_year']]-$period[$details['past_year']])/($period[$details['past_year']]))*100;
            
            $final_result[$i]['result']=$final_result[$i]['percentage'];    
            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'result'=>$final_result[$i]['result'],'penetration'=>round($final_result[$i]['penetration']),'period'=>$period,'growth'=>round($final_result[$i]['percentage']),'contrib_share'=>$contrib_share,'cummulative_share'=>$cumulative_share);
          }
         // var_dump($final_result);die;
          $template='Combinegrowth';
          $details['tooltip']=[$details['menu_axis']=>['growth','%',0],'Total HHs'=>['result','HHs.',''],'Contrbtn Share %'=>['contrib_share','%',0]];
         }
         if(($details['view_master']==4) && (in_array($details['period_type'],[2,3]))) //Combine moving growth
        {

          $additional_result['column']=[];
          $additional_result['values']=[];
        
            $additional_result['column'][2]=array('src'=>'','type'=>'I','align'=>'right','label'=>'NCCS/SEC HHS (HHs)','colspan'=>count($details['year']));
              $additional_result['column'][3]=array('src'=>'total_result','type'=>'I','align'=>'right','label'=>'Total for selectd period','colspan'=>0);
          $additional_result['column'][4]=array('src'=>'result','type'=>'P','align'=>'right','label'=>'Avg Growth (%)','colspan'=>0);
           // $location_id=array_column($result,'loc_id');            
           // $result=CommonController::location_wise_groupby_result($result);


          $location_id=array_column($result,'loc_id');
          $filtered_location=array_unique($location_id);
         
          for($i=0;$i<count($filtered_location);$i++)
          {
             $filter_id=$filtered_location[$i];
             $location_wise_result = array_filter($result, function ($var) use ($filter_id) {
                  return ($var['loc_id'] == $filter_id);
              });

            $final_result[$i]=[];
            $final_result[$i]['result']=0;   
            $final_result[$i]['percentage']=0;             
            $final_result[$i]['location_type']='';
            $final_result[$i]['loc_id']=$filter_id;
            $final_result[$i]['penetration']=0;
            $final_result[$i]['total_result']=0;
            $period=[];

           $location_wise_result=array_values($location_wise_result);
           

             for($j=0;$j<count($location_wise_result);$j++)
             { 
                if($j==0)
                {
                   $a=$details['year'];
                   $b=array_fill(0,count($a),0);
                   $period=array_combine($a,$b); 
                }
                if(!empty($location_wise_result[$j]))
                {
                  
                  $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                  $final_result[$i]['result']=$location_wise_result[$j]['result'];
                  $period[$location_wise_result[$j]['period']]=$location_wise_result[$j]['result'];
                  $final_result[$i]['total_result']=$final_result[$i]['total_result']+ $location_wise_result[$j]['result'];
                  $final_result[$i]['penetration']=$final_result[$i]['penetration']+$location_wise_result[$j]['penetration']; 
                }
             }
              
            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'result'=>round($final_result[$i]['penetration'],1),'penetration'=>round($final_result[$i]['penetration'],1),'period'=>$period,'total_result'=>$final_result[$i]['total_result']);
          }
         // var_dump($final_result);die;
          $template='combinemovinggrowth';
         }
         if(($details['view_master']==5) && (in_array($details['period_type'],[2,3])))
          {
             $additional_result['column']=[];
          $additional_result['values']=[];
        
            $additional_result['column'][2]=array('src'=>'','type'=>'I','align'=>'right','label'=>'NCCS/SEC HHS (HHs)','colspan'=>count($details['year']));
             $additional_result['column'][3]=array('src'=>'total_result','type'=>'I','align'=>'right','label'=>'Total for selectd period. ','colspan'=>0);
          $additional_result['column'][4]=array('src'=>'cagr','type'=>'P','align'=>'right','label'=>'CAGR (%)','colspan'=>0);
           // $location_id=array_column($result,'loc_id');            
           // $result=CommonController::location_wise_groupby_result($result);


          $location_id=array_column($result,'loc_id');
          $filtered_location=array_unique($location_id);
         
          for($i=0;$i<count($filtered_location);$i++)
          {
             $filter_id=$filtered_location[$i];
             $location_wise_result = array_filter($result, function ($var) use ($filter_id) {
                  return ($var['loc_id'] == $filter_id);
              });

            $final_result[$i]=[];
            $final_result[$i]['result']=0;   
            $final_result[$i]['total_result']=0;   
            $final_result[$i]['percentage']=0;             
            $final_result[$i]['location_type']='';
            $final_result[$i]['loc_id']=$filter_id;
            $final_result[$i]['penetration']=0;
            $period=[];

           $location_wise_result=array_values($location_wise_result);
           

             for($j=0;$j<count($location_wise_result);$j++)
             { 
                if($j==0)
                {
                   $a=$details['year'];
                   $b=array_fill(0,count($a),0);
                   $period=array_combine($a,$b); 
                }
                if(!empty($location_wise_result[$j]))
                {
                  
                  $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                   $final_result[$i]['result']=$location_wise_result[$j]['result'];                
                  $period[$location_wise_result[$j]['period']]=$location_wise_result[$j]['result']; 
                  $final_result[$i]['penetration']=$final_result[$i]['penetration']+$location_wise_result[$j]['penetration']; 
                  $final_result[$i]['total_result']=$final_result[$i]['total_result']+$location_wise_result[$j]['result'];


                }
             }
            if(($period[$details['past_year']] <=  0))

            $period[$details['past_year']]=$period[$details['present_year']];

          if(($period[$details['past_year']] <=  0))
            $period[$details['past_year']]=1;

          
           

            $final_result[$i]['result']=round((pow(($period[$details['present_year']])/($period[$details['past_year']]),(1/(count($location_wise_result)-1))) - 1)*100,2);

            $final_result[$i]['percentage']=$final_result[$i]['result'];
            
           
            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'result'=>$final_result[$i]['percentage'],'penetration'=>round($final_result[$i]['penetration'],1),'period'=>$period,'cagr'=>round($final_result[$i]['percentage'],1),'total_result'=>$final_result[$i]['total_result']);
          }
         // var_dump($final_result);die;
          $template='combinecagr';
          }
       
        }
        

        $flag=$input_obj['flag'];
       // $template=$action->gettemplate($details['view_type'],$details['period_result_type'],$flag,$split_combine_table_details->template_id);
        $namespace = "App\Http\Controllers\\";
         $controllerName = $namespace . $template.'Controller';         
        $template_controller = new $controllerName();
        if($flag=='C')
          return $template_controller->$template($final_result,$details,$additional_result,'HHs');
        if($flag=='S')
          return $template_controller->$template($final_result,$details,$additional_result,$split_master,'HHs');


    }
   
    
}