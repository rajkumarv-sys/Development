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

class PremiumindexController extends Controller
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
    public static function premiumindex($details,$maparray,$input_obj)
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
          
          $column='a.loc'.$details['sub_location'];
          $fetch_table='mdlz.locality_premium_index';
            
          $temp=' a.stat="A"';
          array_push($where,$temp); 

         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'refid');
          if(count($index_type)>0)
            array_push($where,' a.fld1955  in ('.implode(",",$index_type).')');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[]; 
          
          
      $sql= 'SELECT a.loc'.$details["sub_location"].' as loc_id,a.`fld1225`,b.name as popltn,avg(a.`result`) as score_result,'.$details["year"][0].' as period ,"" location_type,premium_index as result  FROM '.$fetch_table.' as a,pop_strata_master as b  WHERE a.fld1225=b.refid and '.join(" and ",$where).'  GROUP BY loc_id ,`fld1225`';
          $index=$sql." order by period asc,result desc";
      
          $result = DB::select(DB::raw($index));
          $result=CommonController::getarray($result);

          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];

            // $additional_result['column'][2]=array('src'=>'total_hh','type'=>'I','align'=>'right','label'=>'Total HHs (HHs)');
           $additional_result['column'][2]=array('src'=>'popltn','type'=>'I','align'=>'right','label'=>'Popn Strata');
           $additional_result['column'][3]=array('src'=>'result','type'=>'I','align'=>'right','label'=>'Premium Index');
           $additional_result['column'][4]=array('src'=>'score_result','type'=>'I','align'=>'right','label'=>'Premium Index (Score)');
          
          
        $cumulative_share=0;
        $contrib_share=0;
        $total_result=array_sum(array_column($result,'result'));
          for($i=0;$i<count($result);$i++)
          {
              
               
                $final_result[$i]=[];
                $final_result[$i]['result']=0;                              
                $final_result[$i]['loc_id']=$result[$i]['loc_id'];
                
                if($details['sub_location']==15)
                {
                  if($result[$i]['score_result'] >= 80)
                    $result[$i]['result']='Most Premium';
                  else if($result[$i]['score_result'] >=60  && $result[$i]['score_result'] <=80)
                      $result[$i]['result']='Premium';
                  else if($result[$i]['score_result'] >=30  && $result[$i]['score_result'] <=60)
                      $result[$i]['result']='Medium';
                  else if($result[$i]['score_result'] <=30)
                      $result[$i]['result']='Low';
                }
                $final_result[$i]['result']=$result[$i]['result'];
                $final_result[$i]['location_type']=$result[$i]['location_type'];
                $final_result[$i]['popltn']=$result[$i]['popltn'];
                //$contrib_share=round((($result[$i]['result']/$total_result)*100),2);
                //$cumulative_share=$cumulative_share+$contrib_share;

                //$final_result[$i]['penetration']=$result[$i]['penetration'];
            if(isset($details['maparray'][$result[$i]['loc_id']]))  
                $additional_result['values'][$result[$i]['loc_id']]=array('loc_id'=>$result[$i]['loc_id'],'location_name'=>$details['maparray'][$result[$i]['loc_id']]['location_name'],'result'=>$result[$i]['result'],'score_result'=>round($result[$i]['score_result'],0),'popltn'=>$result[$i]['popltn']);
             

          }
          $template='Rpitemplate';
       
       
        }
        

        $flag=$input_obj['flag'];
       // $template=$action->gettemplate($details['view_type'],$details['period_result_type'],$flag,$split_combine_table_details->template_id);
        $namespace = "App\Http\Controllers\\";
         $controllerName = $namespace . $template.'Controller';         
        $template_controller = new $controllerName();
        if($flag=='C')
          return $template_controller->$template($final_result,$details,$additional_result,'Score',$index_type);
        if($flag=='S')
          return $template_controller->$template($final_result,$details,$additional_result,$split_master,'Score',$index_type);


    }
   
    
}