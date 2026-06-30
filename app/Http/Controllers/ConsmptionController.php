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

class ConsmptionController extends Controller
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
    public static function consmption($details,$maparray,$input_obj,$get_result_data=false)
    {
     //$details['year']=[2022];
        $final_result=[];
        $additional_result=[];
        $split_master=[];

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $pop_strata="SELECT refid,name FROM `pop_strata_master` where area='U'  order by order_urban asc";
          $pop_strata = DB::select(DB::raw($pop_strata));
          $pop_strata=CommonController::getarray($pop_strata);
          $pop[0]='';
          $pop['']='';
           foreach ($pop_strata as $key => $value) {
              $pop[$value['refid']]=$value['name'];
          }

          $column='a.loc'.$details['sub_location'];
          $fetch_table=[12=>'catgry_consmptn.catgry_consmptn_timeseries_city',15=>'catgry_consmptn.catgry_consmptn_timeseries_ward',16=>'catgry_consmptn.catgry_consmptn_timeseries_colony'];
         $fetch_table_population=[12=>'pca_combo_2011.fifth_combo_city',15=>'pca_combo_2011.fourth_combo_ward',16=>'pca_combo_2011.fourth_combo_colony'];
         
          $temp=' a.stat="A"';
          array_push($where,$temp); 

         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'refid');
          if(count($index_type)>0)
            array_push($where,' a.fld572  in ('.implode(",",$index_type).')');
        

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[]; 
         
          
               $details['yearlist']=[];
               $count_year=count($details['year']);
               $select =[];$select_monthquarter=[];

                if($details['calendar_type']==2)
                {
                  for($j=0;$j<$count_year;$j++)
                  {
                        if($details['year'][$j] != date('Y'))
                            $select[$details['year'][$j]]=['sub2_M1','sub2_M2','sub2_M3','sub2_M4','sub2_M5','sub2_M6','sub2_M7','sub2_M8','sub2_M9','sub2_M10','sub2_M11','sub2_M12'];
                        else
                        {
                            $select[$details['year'][$j]]=[];
                            $month_num=date('m');
                            for($m=1;$m<=5;$m++)
                                 array_push($select[$details['year'][$j]],'sub2_M'.$m);
                        }

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
       
               


           $yearlist=count($details['yearlist']);
           $query=[];
           for($i=0;$i<$yearlist;$i++)
           {
          
             $subquery = 'SELECT a.loc'.$details["sub_location"].' as loc_id,sum('.join('+',$select[$details['yearlist'][$i]]).') result ,'.((isset($select_monthquarter[$details['yearlist'][$i]])) ? implode(",",$select_monthquarter[$details['yearlist'][$i]]).',' : '' ).' period_Y as period ,"" location_type,fld1225 as population  FROM '.$fetch_table[$details['sub_location']].' as a  WHERE '.join(" and ",$where).'  and a.period_Y='.$details['yearlist'][$i].' GROUP BY loc_id ';
             array_push($query,$subquery);
           }
          
        
          $query=join(" union ",$query);
          $result=$query." order by period asc,result desc"; 

          $result = DB::select(DB::raw($result));
          $result=CommonController::getarray($result);

          $location_name=[];
          $location_name['7']='state_id';
          $location_name['9']='district_id';
          $location_name['10']='taluk_id';
          $location_name['12']='city_id';
          $location_name['15']='ward_id';
          $location_name['16']='colony_id';
          $population=[];

          if($details['view_optn'][0]==2)
          {
            $query=[];
 
            for($i=0;$i<$yearlist;$i++)
           {
             $yer_temp=2023;
            
            
             $pop_sql="SELECT ".$location_name[$details['sub_location']]." locid,round(sum(age_5_9+((age_5_9*pop".$yer_temp.")/100 )),0)+round(sum(age_10_14+((age_10_14*pop".$yer_temp.")/100 )),0)+round(sum(age_15_19+((age_15_19*pop".$yer_temp.")/100 )),0)+round(sum(age_20_24+((age_20_24*pop".$yer_temp.")/100 )),0)+round(sum(age_25_29+((age_25_29*pop".$yer_temp.")/100 )),0)+round(sum(age_30_34+((age_30_34*pop".$yer_temp.")/100 )),0)+round(sum(age_35_39+((age_35_39*pop".$yer_temp.")/100 )),0)+round(sum(age_40_44+((age_40_44*pop".$yer_temp.")/100 )),0)+round(sum(age_45_49+((age_45_49*pop".$yer_temp.")/100 )),0)+round(sum(age_50_54+((age_50_54*pop".$yer_temp.")/100 )),0)+round(sum(age_55_59+((age_55_59*pop".$yer_temp.")/100 )),0)+round(sum(age_60_64+((age_60_64*pop".$yer_temp.")/100 )),0)+round(sum(age_65_69+((age_65_69*pop".$yer_temp.")/100 )),0)+round(sum(age_70_74+((age_70_74*pop".$yer_temp.")/100 )),0)+round(sum(age_75_79+((age_75_79*pop".$yer_temp.")/100 )),0)+round(sum(age_80+((age_80*pop".$yer_temp.")/100 )),0)+round(sum(age_not_stated+((age_not_stated*pop".$yer_temp.")/100 )),0)+round(sum(age_0_4+((age_0_4*pop".$yer_temp.")/100 )),0) result,".$details['yearlist'][$i]." period  FROM ".$fetch_table_population[$details['sub_location']]." where  ( stat != 'R')  AND ( ".$location_name[$details['sub_location']]." != '0')  AND ( ".$location_name[$details['main_location']]." = ".$details['selected_location'].")  GROUP BY locid  ";
             array_push($query,$pop_sql);
             }
             $query=join(" union ",$query);
             $pop_result=$query." order by period asc,result desc"; 

              $pop_sql_result = DB::select(DB::raw($pop_result));
              $pop_sql_result=CommonController::getarray($pop_sql_result);
              $pop_count=count($pop_sql_result);
              for($k=0;$k<$pop_count;$k++)
               {
                  $population[$pop_sql_result[$k]['locid'].'-'.$pop_sql_result[$k]['period']]=[];
                  $population[$pop_sql_result[$k]['locid'].'-'.$pop_sql_result[$k]['period']]['loc_id']=$pop_sql_result[$k]['locid'];
                  $population[$pop_sql_result[$k]['locid'].'-'.$pop_sql_result[$k]['period']]['pop_data']=$pop_sql_result[$k]['result'];
                  $population[$pop_sql_result[$k]['locid'].'-'.$pop_sql_result[$k]['period']]['period']=$pop_sql_result[$k]['period'];

               }

          }

         if($details['view_optn'][0]==2)          
                $details['tooltip']=['Total Indvdls'=>['pop_data','Indvdls',0],str_replace(' Consmptn', '', implode(',',$details['title']))=>['consmptn_result','Rs.',0,1],'Per Capita Consmptn'=>['result','Rs.',0,1],'Contrbtn Share %'=>['contribution_result','%',0]];
         else
               $details['tooltip']=[str_replace(' Consmptn', '', $details['menu_axis']). ' Consmptn'=>['result','Rs.',1,1],'Contrbtn Share %'=>['contribution_result','%',0]];
           
        
        $already_exist=[];
        $cumulative_share=0;
        $contrib_share=0;        
        $total_result=array_sum(array_column($result,'result'));
        
        if($get_result_data)
            $details['view_optn'][0]=0;
         if($details['view_optn'][0]==2)
         {
            $total_result=0;
            for($i=0;$i<count($result);$i++)
             {
               
                 if(!isset($population[$result[$i]['loc_id'].'-'.$result[$i]['period']]['pop_data']))
                     $population[$result[$i]['loc_id'].'-'.$result[$i]['period']]['pop_data']=1;
                 $total_result=$total_result+round(($result[$i]['result']/$population[$result[$i]['loc_id'].'-'.$result[$i]['period']]['pop_data']),2);

             }


         }
        if(($details['view_master']==1) && (in_array($details['period_type'],[3,2,1]))) 
        {
                      $additional_result=ConsmptionController::getcolumn($details);
                      
                      $location_id=array_column($result,'loc_id');
                       if($details['view_optn'][0]!=2)
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
                    $final_result[$i]['location_type']='';
                    $final_result[$i]['loc_id']=$filter_id;
                    $final_result[$i]['population']=0;
                    $final_result[$i]['consmptn_result']=0;

                   $location_wise_result=array_values($location_wise_result);


                     for($j=0;$j<count($location_wise_result);$j++)
                     {    

                        if(!empty($location_wise_result[$j]))
                        {
                          
                          $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                          $final_result[$i]['consmptn_result']=$final_result[$i]['consmptn_result']+$location_wise_result[$j]['result'];
                           if($details['view_optn'][0]==2)
                             {
                                 $population_result=1;
                                 //var_dump($population);
                                // echo $filter_id.'-'.$location_wise_result[$j]['period'];die;
                                if(isset($population[$filter_id.'-'.$location_wise_result[$j]['period']]))
                                     $population_result=$population[$filter_id.'-'.$location_wise_result[$j]['period']];
                                
                                $location_wise_result[$j]['result']=($location_wise_result[$j]['result']/$population_result['pop_data']);
                                $final_result[$i]['population']=$final_result[$i]['population']+$population_result['pop_data'];

                             }

                          $final_result[$i]['result']=$final_result[$i]['result']+$location_wise_result[$j]['result'];
                          $final_result[$i]['pop_id']=$location_wise_result[$j]['population']; 
                        }            
                      
                     }
                     $contrib_share=round((($final_result[$i]['result']/$total_result)*100),2);                    
                     $cumulative_share=$cumulative_share+$contrib_share;
                     $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'result'=>round($final_result[$i]['result'],2),'contribution_result'=>round($contrib_share,1),'cumulative_result'=>$cumulative_share,'pop_id'=>$pop[$final_result[$i]['pop_id']],'pop_data'=>number_format($final_result[$i]['population'],0),'consmptn_result'=>number_format(round($final_result[$i]['consmptn_result'],2),0));

                   
          }
          

           $template='Combinecummulative';
           
       }
        if(($details['view_master']==2) && (in_array($details['period_type'],[3,2]))) // timeseries cummulative
        {

          $additional_result['column']=[];
          $additional_result['values']=[];
           
            $additional_result['column'][2]=array('src'=>'','type'=>'I','align'=>'right','label'=>str_replace('Consmptn', '', $details['menu_axis']). 'Consmptn','colspan'=>count($details['year']));
           $additional_result['column'][3]=array('src'=>'total_result','type'=>'I','align'=>'right','label'=>'Total for Selectd Periods (Rs.)');
            $additional_result['column'][4]=array('src'=>'average','type'=>'I','align'=>'right','label'=>'Avg for Selectd Periods (Rs.)');
           
          

          $location_id=array_column($result,'loc_id');
          $filtered_location=array_unique($location_id);
          $cumulative_share=0;
          $contrib_share=0;
          $total_result=array_sum(array_column($result,'result'));
         
          for($i=0;$i<count($filtered_location);$i++)
          {
             $filter_id=$filtered_location[$i];
             $location_wise_result = array_filter($result, function ($var) use ($filter_id) {
                  return ($var['loc_id'] == $filter_id);
              });

            $final_result[$i]=[];
            $final_result[$i]['result']=0;   
            $final_result[$i]['total_result']=0;
            $final_result[$i]['location_type']='';
            $final_result[$i]['loc_id']=$filter_id;
            $final_result[$i]['average']=0;

           $location_wise_result=array_values($location_wise_result);
           

             for($j=0;$j<count($location_wise_result);$j++)
             { 
                if($j==0)
                {
                   $a=$details['year'];
                   $b=array_fill(0,count($a),0);
                   $period=array_combine($a,$b);   
                   $year_count=count($period);

                }
                if(!empty($location_wise_result[$j]))
                {
                  
                  $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                  if($details['view_optn'][0]==2)
                 {
                     $population_result=1;
                    if(isset($population[$filter_id.'-'.$location_wise_result[$j]['period']]))
                         $population_result=$population[$filter_id.'-'.$location_wise_result[$j]['period']];

                     $location_wise_result[$j]['result']=($location_wise_result[$j]['result']/$population_result['pop_data']);


                 }
                  $final_result[$i]['result']=$final_result[$i]['result']+$location_wise_result[$j]['result'];
                  $final_result[$i][$location_wise_result[$j]['period']]=$final_result[$i]['result'];
                
                  foreach($period as $k=>$v)  
                  {
                   
                    if($details['calendar_type']==2)              
                    $period[$k]=$final_result[$i][$k]; 
                   if(in_array($details['calendar_type'],[4,6]))              
                     $period[$k]=$location_wise_result[$j][$k]; 
                  }


                }
             }

             $contrib_share=round((($final_result[$i]['result']/$total_result)*100),2);
             $cumulative_share=$cumulative_share+$contrib_share;
            $average=($final_result[$i]['result'])/($year_count);
            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'total_result'=>$final_result[$i]['result'],'period'=>$period,'average'=>$average,'contribution_result'=>round($contrib_share,1),'cumulative_result'=>$cumulative_share);
          }
          $template='combinetimeseries';

           $details['tooltip']=[$details['menu_axis']=>['total_result','Rs.',''],'Contrbtn Share %'=>['contribution_result','%',0]];
         }
          if(($details['view_master']==3) && (in_array($details['period_type'],[3,2]))) // Growth combine
        {

          $additional_result['column']=[];
          $additional_result['values']=[];
        
          $additional_result['column'][2]=array('src'=>'','type'=>'I','align'=>'right','label'=>str_replace('Consmptn', '', $details['menu_axis']). 'Consmptn','colspan'=>count($details['year']));
           $additional_result['column'][3]=array('src'=>'percentage','type'=>'P','align'=>'right','label'=>'Growth (%)','colspan'=>0);

          $location_id=array_column($result,'loc_id');
          $filtered_location=array_unique($location_id);
          $cumulative_share=0;
          $contrib_share=0;
          $total_result=array_sum(array_column($result,'result'));
         
          for($i=0;$i<count($filtered_location);$i++)
          {
             $filter_id=$filtered_location[$i];
             $location_wise_result = array_filter($result, function ($var) use ($filter_id) {
                  return ($var['loc_id'] == $filter_id);
              });

            $final_result[$i]=[];
            $final_result[$i]['result']=0;   
            $final_result[$i]['total_result']=0;
            $final_result[$i]['location_type']='';
            $final_result[$i]['loc_id']=$filter_id;
            $final_result[$i]['average']=0;

           $location_wise_result=array_values($location_wise_result);
           

             for($j=0;$j<count($location_wise_result);$j++)
             { 
                if($j==0)
                {
                   $a=$details['year'];
                   $b=array_fill(0,count($a),0);
                   $period=array_combine($a,$b);   
                   $year_count=count($period);

                }
                if(!empty($location_wise_result[$j]))
                {
                  
                  $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                   if($details['view_optn'][0]==2)
                 {
                     $population_result=1;
                    if(isset($population[$filter_id.'-'.$location_wise_result[$j]['period']]))
                         $population_result=$population[$filter_id.'-'.$location_wise_result[$j]['period']];

                    $location_wise_result[$j]['result']=($location_wise_result[$j]['result']/$population_result['pop_data']);


                 }

                  $final_result[$i]['result']=$final_result[$i]['result']+$location_wise_result[$j]['result'];
                  $final_result[$i][$location_wise_result[$j]['period']]=$final_result[$i]['result'];
                
                  foreach($period as $k=>$v)  
                  {
                   
                    if($details['calendar_type']==2)              
                    $period[$k]=$final_result[$i][$k]; 
                   if(in_array($details['calendar_type'],[4,6]))              
                     $period[$k]=$location_wise_result[$j][$k]; 
                  }
                 

                }
             }
             $period_values=array_values($period);
             $past_year_result=($period_values[0] <=0) ? 1 : $period_values[0];
             $present_year_result=$period_values[count($period_values)-1];
             $final_result[$i]['percentage']=(($present_year_result-$past_year_result)/($past_year_result))*100;
             $contrib_share=round((($final_result[$i]['result']/$total_result)*100),2);
             $cumulative_share=$cumulative_share+$contrib_share;
            $average=($final_result[$i]['result'])/($year_count);
            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'total_result'=>$final_result[$i]['result'],'period'=>$period,'average'=>$average,'contribution_result'=>round($contrib_share,1),'cumulative_result'=>$cumulative_share,'percentage'=>$final_result[$i]['percentage']);
          }
           $template='Combinegrowth';
          $details['tooltip']=['Growth'=>['percentage','%',0],$details['menu_axis']=>['total_result','Rs.','']];
         }
         if(($details['view_master']==4) && (in_array($details['period_type'],[2,3]))) //Combine moving growth
        {

          $additional_result['column']=[];
          $additional_result['values']=[];
        
         $additional_result['column'][2]=array('src'=>'','type'=>'I','align'=>'right','label'=>str_replace('Consmptn', '', $details['menu_axis']). 'Consmptn','colspan'=>count($details['year'])-1);
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
                    $year_count=count($period);
                }
                if(!empty($location_wise_result[$j]))
                {
                  
                  $final_result[$i]['location_type']=$location_wise_result[$j]['location_type'];
                   if($details['view_optn'][0]==2)
                 {
                     $population_result=1;
                    if(isset($population[$filter_id.'-'.$location_wise_result[$j]['period']]))
                         $population_result=$population[$filter_id.'-'.$location_wise_result[$j]['period']];

                     $location_wise_result[$j]['result']=($location_wise_result[$j]['result']/$population_result['pop_data']);

                 }
                  $final_result[$i]['result']=$location_wise_result[$j]['result'];
                  foreach($period as $k=>$v)  
                  {
                    if($details['calendar_type']==2)   
                       if($period[$k]==$location_wise_result[$j]['period'])           
                            $period[$k]=$final_result[$i]['result']; 
                   if(in_array($details['calendar_type'],[4,6]))              
                     $period[$k]=$location_wise_result[$j][$k]; 
                  }
                  //$period[$location_wise_result[$j]['period']]=$location_wise_result[$j]['result'];
                  $final_result[$i]['total_result']=$final_result[$i]['total_result']+ $location_wise_result[$j]['result'];
                
                }
             }

              
            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'result'=>round($final_result[$i]['total_result'],1),'total_result'=>round($final_result[$i]['total_result'],1),'period'=>$period);
          }
          
          $template='combinemovinggrowth';
          $details['tooltip']=[$details['menu_axis']=>['total_result','Rs.','']];
         }
          if(($details['view_master']==5) && (in_array($details['period_type'],[2,3])))
          {
             $additional_result['column']=[];
          $additional_result['values']=[];
        
           $additional_result['column'][2]=array('src'=>'','type'=>'I','align'=>'right','label'=>str_replace('Consmptn', '', $details['menu_axis']). 'Consmptn','colspan'=>count($details['year']));
          $additional_result['column'][3]=array('src'=>'total_result','type'=>'I','align'=>'right','label'=>'Total for selectd period','colspan'=>0);
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
                   if($details['view_optn'][0]==2)
                 {
                     $population_result=1;
                    if(isset($population[$filter_id.'-'.$location_wise_result[$j]['period']]))
                         $population_result=$population[$filter_id.'-'.$location_wise_result[$j]['period']];

                    $location_wise_result[$j]['result']=($location_wise_result[$j]['result']/$population_result['pop_data']);


                 }
                   $final_result[$i]['result']=$location_wise_result[$j]['result']; 
                   foreach($period as $k=>$v)  
                  {
                    if($details['calendar_type']==2)   
                       if($period[$k]==$location_wise_result[$j]['period'])           
                            $period[$k]=$final_result[$i]['result']; 
                   if(in_array($details['calendar_type'],[4,6]))              
                     $period[$k]=$location_wise_result[$j][$k]; 
                  }

                 // $period[$location_wise_result[$j]['period']]=$location_wise_result[$j]['result']; 
                  $final_result[$i]['total_result']=$final_result[$i]['total_result']+$location_wise_result[$j]['result'];


                }
             }
       

          if(($period[$details['past_year']] <=  0))
            $period[$details['past_year']]=1;
         
          
           

            $final_result[$i]['result']=round((pow(($period[$details['present_year']])/($period[$details['past_year']]),(1/max((count($location_wise_result)-1),1))) - 1)*100,2);

            $final_result[$i]['percentage']=$final_result[$i]['result'];
            
           
            $additional_result['values'][$filter_id]=array('loc_id'=>$filter_id,'location_name'=>$details['maparray'][$filter_id]['location_name'],'result'=>$final_result[$i]['percentage'],'period'=>$period,'cagr'=>round($final_result[$i]['percentage'],1),'total_result'=>$final_result[$i]['total_result']);
          }
         // var_dump($final_result);die;
          $details['tooltip']=[$details['menu_axis']=>['total_result','Rs.','']];
          $template='Combinecagr';
          }
            
       
       
        }
      

        $flag=$input_obj['flag'];
       // $template=$action->gettemplate($details['view_type'],$details['period_result_type'],$flag,$split_combine_table_details->template_id);
        $namespace = "App\Http\Controllers\\";
         $controllerName = $namespace . $template.'Controller';         
        $template_controller = new $controllerName();
        if($flag=='C')
          return $template_controller->$template($final_result,$details,$additional_result,'Rs.');
        if($flag=='S')
          return $template_controller->$template($final_result,$details,$additional_result,$split_master,'Rs.');


    }

    public static function getcolumn($details)
    {
          $additional_result=[];
          $additional_result['column']=[];
          $additional_result['values']=[];

         if($details['view_optn'][0]==2)
           {
             //if($details['main_location']==$details['sub_location'] && $details['main_location']==12)
               $additional_result['column'][2]=array('src'=>'pop_data','type'=>'I','align'=>'right','label'=>'Total Indvdls');
               $additional_result['column'][3]=array('src'=>'consmptn_result','type'=>'I','align'=>'right','label'=>str_replace('Consmptn', '', implode(',',$details['title'])). ' Consmptn');
                $additional_result['column'][4]=array('src'=>'result','type'=>'I','align'=>'right','label'=>'Per Capita Consmptn (Rs.)');
               $additional_result['column'][5]=array('src'=>'cumulative_result','type'=>'I','align'=>'right','label'=>'Cumltv Share %');
               $additional_result['column'][6]=array('src'=>'contribution_result','type'=>'I','align'=>'right','label'=>'Contrbtn Share (%)');

                $details['tooltip']=['Population'=>['pop_data','Nos.',0],str_replace(' Consmptn', '', implode(',',$details['title'])). ' Consmptn'=>['consmptn_result','Rs.','',1],'Per Capita Consmptn'=>['result','Rs.',0,1],'Contrbtn Share %'=>['contribution_result','%',0]];
           }
           else
           {


               $additional_result['column'][2]=array('src'=>'result','type'=>'I','align'=>'right','label'=>str_replace('Consmptn', '', $details['menu_axis']). 'Consmptn');
               $additional_result['column'][3]=array('src'=>'cumulative_result','type'=>'I','align'=>'right','label'=>'Cumltv Share %');
               $additional_result['column'][4]=array('src'=>'contribution_result','type'=>'I','align'=>'right','label'=>'Contrbtn Share (%)');

               $details['tooltip']=[str_replace(' Consmptn', '', $details['menu_axis']). ' Consmptn'=>['result','Rs.',1,1],'Contrbtn Share %'=>['contribution_result','%',0]];
           }

        return $additional_result;
    }
   
    
}