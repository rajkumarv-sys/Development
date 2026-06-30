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

class ReportController extends Controller
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
    public static function getmenudetail($index)
    {
       $menu_list=[];
      $menu_res=DB::table('mdlz_urban_catgry_master')->where([['stat','=','A']])->whereIn('refid',$index)->get();
      for($k=0;$k<count($menu_res);$k++)
      {
        $menu_list[$menu_res[$k]->refid]=$menu_res[$k]->name;

      }

      return $menu_list;
    }
    public static function mc_score($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis'].' <br> M Score'=>['result','',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          // $column='a.loc'.$details['sub_location'];
        
       
           $fetch_table='mdlz.mdlz_urban_3cities_sales';
        
         // if($details['main_location']==$details['sub_location'])         
         //  $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         // if($details['main_location']!=$details['sub_location'])     
         //  $temp ='loc'.$details['main_location'].'='.$details['selected_location'].'';
         //  array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

       
          $mscore='SELECT a.loc'.$details["sub_location"].' loc_id,round(b.result, 2) as result,a.period_Y ,a.fld1987,a.loc12 FROM mdlz.`mdlz_urban_3cities_sales` a JOIN (SELECT loc'.$details["sub_location"].', sum(m_score) / count(refid) as result FROM bid_application_master.`mdlz_urban_outlet_master` WHERE loc'.$details['main_location'].' = '.$details['selected_location'].' AND m_score != 0 AND stat LIKE "A" GROUP BY loc'.$details["sub_location"].') b ON a.loc'.$details["sub_location"].' = b.loc'.$details["sub_location"].' and '.join(" and ",$where).' GROUP BY a.loc'.$details["sub_location"].'';
       
          // $mscore='SELECT a.loc'.$details["sub_location"].' as loc_id,fld1987,round((sum(`m_score`)/count(`fld1986`)),2) as  result , period_Y FROM '.$fetch_table.' as a  WHERE  a.m_score!=0  and '.join(" and ",$where).'  GROUP BY loc_id';

          $mscore_result = DB::select(DB::raw($mscore));
          $mscore_result=CommonController::getarray($mscore_result);
          $mscore_result_count=count($mscore_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
          $k=3;
          $menulist=self::getmenudetail($index_type);
          $index_type=array_unique($index_type);
          // for($m=0;$m<count($index_type);$m++)
          // {
          //    $additional_result['column'][$k]=array('src'=>$index_type[$m],'type'=>'I','align'=>'right','label'=>$menulist[$index_type[$m]].' M Score');
          //    $k++;
          // }

           $additional_result['column'][3]=array('src'=>'results','type'=>'I','align'=>'right','label'=>$details['menu_axis'].' M Score');

           

           $cumulative_share=0;$contrib_share=0;

            $total_result=array_sum(array_column($mscore_result,'result'));
             $final_result=[];
          // for($i=0;$i<$mscore_result_count;$i++)
          // {
             
          //      if(!in_array($mscore_result[$i]['loc_id'],$already_exist))
          //   {
          //       array_push($already_exist,$mscore_result[$i]['loc_id']);
          //        $final_result[$mscore_result[$i]['loc_id']]['result']=0;

          //   } 
          //    $final_result[$mscore_result[$i]['loc_id']][$mscore_result[$i]['fld1987']]=$mscore_result[$i]['result'];
          //    $final_result[$mscore_result[$i]['loc_id']]['result']=$final_result[$mscore_result[$i]['loc_id']]['result']+$mscore_result[$i]['result'];

          // }
          $result=$mscore_result;
          $final_result=[];
          $resultcount=count($result);
          $i=0;
          foreach($result as $key=>$value)
          {
           
            $final_result[$i]=[];            
            $final_result[$i]['loc_id']=$value['loc_id'];
            $final_result[$i]['result']=round($value['result'],0);
    if(isset($details['maparray'][$value['loc_id']]))
    $additional_result['values'][$value['loc_id']]=array('loc_id'=>$value['loc_id'],'location_name'=>$details['maparray'][$value['loc_id']]['location_name'],'results'=>$final_result[$i]['result'],'result'=>$final_result[$i]['result']);
         
            // if(isset($details['maparray'][$key]))
            // {
            //     $additional_result['values'][$key]=array('loc_id'=>$key,'location_name'=>$details['maparray'][$key]['location_name'],'result'=>$final_result[$i]['result']);
                 
            //     foreach($menulist as $k=>$v)  
            //     {
            //        $additional_result['values'][$key][$k]=0;
            //        if(isset($value[$k]))
            //         $additional_result['values'][$key][$k]=$value[$k];
            //     }
                     
            // }
            $i++;
             

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
     
    public static function woa_score($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis'].' <br> Program Store WOA % '=>['result','%',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
       
       
           $fetch_table='mdlz.mdlz_urban_3cities_sales';
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

       
// SELECT loc12,fld1987,sum(`m_score`)/count(`fld1986`) as city_avg FROM `mdlz_urban_3cities_sales` WHERE loc12=13346 and m_score!=0 group by loc12,fld1987

//        $mscore='SELECT a.loc'.$details["sub_location"].' as loc_id,fld1987,round(((((sum(`M1_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M2_achived_status`)/count(DISTINCT(`retailer_code`)))* 100) +((sum(`M3_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M4_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M5_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M6_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M7_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M8_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M9_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M10_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M11_achived_status`)/count(DISTINCT(`retailer_code`)))* 100)+((sum(`M12_achived_status`)/count(DISTINCT(`retailer_code`)))* 100))/12),2) as  result , period_Y FROM '.$fetch_table.' as a  WHERE  a.m_score!=0  and '.join(" and ",$where).'  GROUP BY loc_id';
//           $mscore='SELECT loc'.$details["sub_location"].' as loc_id,((count(DISTINCT(case when `M1_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M2_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M3_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M4_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M5_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100) +
// (count(DISTINCT(case when `M6_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M7_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M8_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M9_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M10_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M11_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100)+
// (count(DISTINCT(case when `M12_achived_status`=1 then `retailer_code` end))/count(DISTINCT(retailer_code))*100))/12 as result,period_Y,fld1987 
// FROM `mdlz`.`mdlz_urban_3cities_sales` where loc'.$details['main_location'].' = '.$details['selected_location'].'  and fld1987  in ('.implode(",",$index_type).') and period_Y in ('.implode(",",$details['year']).') group by loc_id';

            $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];

   $mscore="select loc".$details["sub_location"]." as loc_id,ifnull(result,0) as result from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']."  and period in (".implode(",",$details['year']).") and type_id=11 group by loc_id,period order by result desc" ; 


          $mscore_result = DB::select(DB::raw($mscore));
          $mscore_result=CommonController::getarray($mscore_result);
          $mscore_result_count=count($mscore_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
          $k=3;
          $menulist=self::getmenudetail($index_type);
          $index_type=array_unique($index_type);
          // for($m=0;$m<count($index_type);$m++)
          // {
          //    $additional_result['column'][$k]=array('src'=>$index_type[$m],'type'=>'I','align'=>'right','label'=>$menulist[$index_type[$m]].' WOA Score');
          //    $k++;
          // }

           $additional_result['column'][3]=array('src'=>'results','type'=>'I','align'=>'right','label'=>$details['menu_axis'].' <br> Program Store WOA %');

           

           $cumulative_share=0;$contrib_share=0;

            $total_result=array_sum(array_column($mscore_result,'result'));
              $result=$mscore_result;
          $final_result=[];
          $resultcount=count($result);
          $i=0;
          foreach($result as $key=>$value)
          {
           
            $final_result[$i]=[];            
            $final_result[$i]['loc_id']=$value['loc_id'];
            $final_result[$i]['result']=round($value['result'],2);
     if(isset($details['maparray'][$value['loc_id']]))       
    $additional_result['values'][$value['loc_id']]=array('loc_id'=>$value['loc_id'],'location_name'=>$details['maparray'][$value['loc_id']]['location_name'],'results'=>$final_result[$i]['result'],'result'=>$final_result[$i]['result']);
         
         
            $i++;
             

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
       public static function WD($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis'].' <br> WD % '=>['result','%',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
       
       
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

          $menu_id_list=[];
            foreach($index_type as $k=>$v)
            {
                if($v==5)
                    $v=3;
                array_push($menu_id_list,$v);
            }
            $boolean=0;
            if(in_array(3,$index_type) && in_array(5,$index_type))
                $boolean=1;

            $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];

   $mscore="select loc".$details["sub_location"]." as loc_id,if(( (type_id=9 || type_id=4 || type_id=7) && '.$boolean.'=1 ),avg(ifnull(result,0)),sum(ifnull(result,0))) as result from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']."  and period in (".implode(",",$details['year']).") and menu_id in (".implode(",",$menu_id_list).") and type_id=9 group by loc_id,period order by result desc" ; 


          $mscore_result = DB::select(DB::raw($mscore));
          $mscore_result=CommonController::getarray($mscore_result);
          $mscore_result_count=count($mscore_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
          $k=3;
          $menulist=self::getmenudetail($index_type);
          $index_type=array_unique($index_type);
          // for($m=0;$m<count($index_type);$m++)
          // {
          //    $additional_result['column'][$k]=array('src'=>$index_type[$m],'type'=>'I','align'=>'right','label'=>$menulist[$index_type[$m]].' WOA Score');
          //    $k++;
          // }

           $additional_result['column'][3]=array('src'=>'results','type'=>'I','align'=>'right','label'=>$details['menu_axis'].' <br> WD %');

           

           $cumulative_share=0;$contrib_share=0;

            $total_result=array_sum(array_column($mscore_result,'result'));
              $result=$mscore_result;
          $final_result=[];
          $resultcount=count($result);
          $i=0;
          foreach($result as $key=>$value)
          {
           
            $final_result[$i]=[];            
            $final_result[$i]['loc_id']=$value['loc_id'];
            $final_result[$i]['result']=round($value['result'],2);
     if(isset($details['maparray'][$value['loc_id']]))       
    $additional_result['values'][$value['loc_id']]=array('loc_id'=>$value['loc_id'],'location_name'=>$details['maparray'][$value['loc_id']]['location_name'],'results'=>$final_result[$i]['result'],'result'=>$final_result[$i]['result']);
         
         
            $i++;
             

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
     public static function pc_woa($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis'].' <br> PC WOA % '=>['result','%',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
       
       
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

            $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];

 $mscore="select loc".$details["sub_location"]." as loc_id,result from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']."  and period in (".implode(",",$details['year']).")  and type_id=10 group by loc_id,period order by result desc" ; 


          $mscore_result = DB::select(DB::raw($mscore));
          $mscore_result=CommonController::getarray($mscore_result);
          $mscore_result_count=count($mscore_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
          $k=3;
          $menulist=self::getmenudetail($index_type);
          $index_type=array_unique($index_type);
          // for($m=0;$m<count($index_type);$m++)
          // {
          //    $additional_result['column'][$k]=array('src'=>$index_type[$m],'type'=>'I','align'=>'right','label'=>$menulist[$index_type[$m]].' WOA Score');
          //    $k++;
          // }

           $additional_result['column'][3]=array('src'=>'results','type'=>'I','align'=>'right','label'=>$details['menu_axis'].' <br> PC WOA %');

           

           $cumulative_share=0;$contrib_share=0;

            $total_result=array_sum(array_column($mscore_result,'result'));
              $result=$mscore_result;
          $final_result=[];
          $resultcount=count($result);
          $i=0;
          foreach($result as $key=>$value)
          {
           
            $final_result[$i]=[];            
            $final_result[$i]['loc_id']=$value['loc_id'];
            $final_result[$i]['result']=round($value['result'],2);
     if(isset($details['maparray'][$value['loc_id']]))       
    $additional_result['values'][$value['loc_id']]=array('loc_id'=>$value['loc_id'],'location_name'=>$details['maparray'][$value['loc_id']]['location_name'],'results'=>$final_result[$i]['result'],'result'=>$final_result[$i]['result']);
         
         
            $i++;
             

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

          public static function overall_target_achievement($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis'].' <br> Overall target vs Achievmt % '=>['result','%',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
       
       
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

            $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];

 $mscore="select loc".$details["sub_location"]." as loc_id,result from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']."  and type_id=12 group by loc_id,period order by result desc" ; 


          $mscore_result = DB::select(DB::raw($mscore));
          $mscore_result=CommonController::getarray($mscore_result);
          $mscore_result_count=count($mscore_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
          $k=3;
          $menulist=self::getmenudetail($index_type);
          $index_type=array_unique($index_type);
          // for($m=0;$m<count($index_type);$m++)
          // {
          //    $additional_result['column'][$k]=array('src'=>$index_type[$m],'type'=>'I','align'=>'right','label'=>$menulist[$index_type[$m]].' WOA Score');
          //    $k++;
          // }

           $additional_result['column'][3]=array('src'=>'results','type'=>'I','align'=>'right','label'=>$details['menu_axis'].' <br> Overall target vs Achievmt %');

           

           $cumulative_share=0;$contrib_share=0;

            $total_result=array_sum(array_column($mscore_result,'result'));
              $result=$mscore_result;
          $final_result=[];
          $resultcount=count($result);
          $i=0;
          foreach($result as $key=>$value)
          {
           
            $final_result[$i]=[];            
            $final_result[$i]['loc_id']=$value['loc_id'];
            $final_result[$i]['result']=round($value['result'],2);
     if(isset($details['maparray'][$value['loc_id']]))       
    $additional_result['values'][$value['loc_id']]=array('loc_id'=>$value['loc_id'],'location_name'=>$details['maparray'][$value['loc_id']]['location_name'],'results'=>$final_result[$i]['result'],'result'=>$final_result[$i]['result']);
         
         
            $i++;
             

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
     public static function PC_overall_target_achievement($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis'].' <br> Program Store Overall target vs Achievmt % '=>['result','%',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
       
       
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' fld1987  in ('.implode(",",$index_type).')');
          array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

            $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];

 $mscore="select loc".$details["sub_location"]." as loc_id,result from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']." and  period in (".implode(",",$details['year']).") and type_id=8  group by loc_id,period order by result desc" ; 


          $mscore_result = DB::select(DB::raw($mscore));
          $mscore_result=CommonController::getarray($mscore_result);
          $mscore_result_count=count($mscore_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
          $k=3;
          $menulist=self::getmenudetail($index_type);
          $index_type=array_unique($index_type);
          // for($m=0;$m<count($index_type);$m++)
          // {
          //    $additional_result['column'][$k]=array('src'=>$index_type[$m],'type'=>'I','align'=>'right','label'=>$menulist[$index_type[$m]].' WOA Score');
          //    $k++;
          // }

           $additional_result['column'][3]=array('src'=>'results','type'=>'I','align'=>'right','label'=>$details['menu_axis'].' <br> Program Store Overall target vs Achievmt %');

           

           $cumulative_share=0;$contrib_share=0;

            $total_result=array_sum(array_column($mscore_result,'result'));
              $result=$mscore_result;
          $final_result=[];
          $resultcount=count($result);
          $i=0;
          foreach($result as $key=>$value)
          {
           
            $final_result[$i]=[];            
            $final_result[$i]['loc_id']=$value['loc_id'];
            $final_result[$i]['result']=round($value['result'],2);
     if(isset($details['maparray'][$value['loc_id']]))       
    $additional_result['values'][$value['loc_id']]=array('loc_id'=>$value['loc_id'],'location_name'=>$details['maparray'][$value['loc_id']]['location_name'],'results'=>$final_result[$i]['result'],'result'=>$final_result[$i]['result']);
         
         
            $i++;
             

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
     public static function store_penetration($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis'].' <br>Store Penetratn %'=>['result','%',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
       
       
           $fetch_table='mdlz.mdlz_urban_3cities_sales ';
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' a.fld1987  in ('.implode(",",$index_type).')');
           array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');
        

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

       $boolean=0;
            if(in_array(3,$index_type) && in_array(5,$index_type))
                $boolean=1;
            if($boolean)
               $resl_str=' avg(ifnull(result,0)) ';
            else
                $resl_str=' sum(ifnull(result,0)) ';
            $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];
            
   $mscore="select loc".$details["sub_location"]." as loc_id,".$resl_str." as result from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']." and
       menu_id in (".implode(",",$index_type).") and period in (".implode(",",$details['year']).") and type_id=7
        group by loc_id,period order by result desc" ; 


 //       $mscore='SELECT loc'.$details["sub_location"].' as loc_id,round(((sum(`prgm_target_data`)/count(distinct(fld1986)))),2) as result,period_Y,fld1987 as menu_id FROM mdlz.mdlz_urban_3cities_sales
 // WHERE loc'.$details['main_location'].' = '.$details['selected_location'].' and fld1987  in ('.implode(",",$index_type).') and period_Y in ('.implode(",",$details['year']).') group by loc_id';
          $mscore_result = DB::select(DB::raw($mscore));
          $mscore_result=CommonController::getarray($mscore_result);
          $mscore_result_count=count($mscore_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
          $k=3;
          $menulist=self::getmenudetail($index_type);
          $index_type=array_unique($index_type);
          // for($m=0;$m<count($index_type);$m++)
          // {
          //    $additional_result['column'][$k]=array('src'=>$index_type[$m],'type'=>'I','align'=>'right','label'=>$menulist[$index_type[$m]]);
          //    $k++;
          // }

           $additional_result['column'][3]=array('src'=>'results','type'=>'I','align'=>'right','label'=>$details['menu_axis'].' Store Penetratn');

           

           $cumulative_share=0;$contrib_share=0;

            $total_result=array_sum(array_column($mscore_result,'result'));
             $final_result=[];
           // for($i=0;$i<$mscore_result_count;$i++)
          // {
             
          //      if(!in_array($mscore_result[$i]['loc_id'],$already_exist))
          //   {
          //       array_push($already_exist,$mscore_result[$i]['loc_id']);
          //        $final_result[$mscore_result[$i]['loc_id']]['result']=0;

          //   } 
          //    $final_result[$mscore_result[$i]['loc_id']][$mscore_result[$i]['fld1987']]=$mscore_result[$i]['result'];
          //    $final_result[$mscore_result[$i]['loc_id']]['result']=$final_result[$mscore_result[$i]['loc_id']]['result']+$mscore_result[$i]['result'];

          // }
          $result=$mscore_result;
          $final_result=[];
          $resultcount=count($result);
          $i=0;
          foreach($result as $key=>$value)
          {
           
            $final_result[$i]=[];            
            $final_result[$i]['loc_id']=$value['loc_id'];
            $final_result[$i]['result']=round($value['result'],2);
            if(isset($details['maparray'][$value['loc_id']]))
    $additional_result['values'][$value['loc_id']]=array('loc_id'=>$value['loc_id'],'location_name'=>$details['maparray'][$value['loc_id']]['location_name'],'results'=>$final_result[$i]['result'],'result'=>$final_result[$i]['result']);
         
            // if(isset($details['maparray'][$key]))
            // {
            //     $additional_result['values'][$key]=array('loc_id'=>$key,'location_name'=>$details['maparray'][$key]['location_name'],'result'=>$final_result[$i]['result']);
                 
            //     foreach($menulist as $k=>$v)  
            //     {
            //        $additional_result['values'][$key][$k]=0;
            //        if(isset($value[$k]))
            //         $additional_result['values'][$key][$k]=$value[$k];
            //     }
                     
            // }
            $i++;
             

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
    public static function vc_penetration($details,$maparray,$input_obj)
    {
    
        $final_result=[];
        $additional_result=[];
        $split_master=[];
        $details['tooltip']=[$details['menu_axis'].' <br> VC Penetratn % '=>['result','%',0]];
  

       $select_criteria=[];$where=[];$temp=''; $head='';$select=[];

        if(in_array($details['tbl'], $details['menutablelist']))
           $sql=DB::table($details['tbl'])->whereIn('refid', $details['cndn_value'])->select(['refid','name'])->get();  

        if($input_obj['flag']=='C')
        {
          $population=[];
          $column='a.loc'.$details['sub_location'];
       
       
           $fetch_table='mdlz.mdlz_urban_3cities_sales ';
        
         if($details['main_location']==$details['sub_location'])         
          $temp ='a.loc'.$details['sub_location'].'='.$details['selected_location'].'';
         if($details['main_location']!=$details['sub_location'])     
          $temp ='a.loc'.$details['main_location'].'='.$details['selected_location'].'';
          array_push($where,$temp);   

          $index_type=array_column($input_obj['menu_list'],'menu_item_id');
        
          $category_id=[];


          if(count($index_type)>0)
            array_push($where,' a.fld1987  in ('.implode(",",$index_type).')');
           array_push($where,'  period_Y in ('.implode(",",$details['year']).') ');
        

          $data=[];$data['result']=[];$data['legend']=[];$subquery=[];

    
            $boolean=0;
            if(in_array(3,$index_type) && in_array(5,$index_type))
                $boolean=1;
            if($boolean)
               $resl_str=' avg(ifnull(result,0)) ';
            else
                $resl_str=' sum(ifnull(result,0)) ';
            $tbl=[15=>'mdlz.calendar_result_dump',16=>'mdlz.calendar_result_dump_loc16'];

   $mscore="select loc".$details["sub_location"]." as loc_id,".$resl_str." as result from ".$tbl[$details['sub_location']]." where loc".$details["main_location"]."=".$details['selected_location']." and
       menu_id in (".implode(",",$index_type).") and period in (".implode(",",$details['year']).") and type_id=4 group by loc_id,period order by result desc" ; 

    // $mscore='SELECT loc'.$details["sub_location"].' as loc_id,((sum(`visi_cooler_status`)/count(distinct(fld1986)))) as result,period_Y FROM mdlz.mdlz_urban_3cities_sales  WHERE loc'.$details['main_location'].' = '.$details['selected_location'].'  and fld1987  in ('.implode(",",$index_type).') and period_Y in ('.implode(",",$details['year']).')  group by loc_id';
          $mscore_result = DB::select(DB::raw($mscore));
          $mscore_result=CommonController::getarray($mscore_result);
          $mscore_result_count=count($mscore_result);

          
          $additional_result['column']=[];
          $additional_result['values']=[];
         

          $already_exist=[];
          $k=3;
          $menulist=self::getmenudetail($index_type);
          $index_type=array_unique($index_type);
          // for($m=0;$m<count($index_type);$m++)
          // {
          //    $additional_result['column'][$k]=array('src'=>$index_type[$m],'type'=>'I','align'=>'right','label'=>$menulist[$index_type[$m]]);
          //    $k++;
          // }

           $additional_result['column'][$k]=array('src'=>'results','type'=>'I','align'=>'right','label'=>'VC Penetratn (%)');

           

           $cumulative_share=0;$contrib_share=0;

            $total_result=array_sum(array_column($mscore_result,'result'));
             $final_result=[];
        
          $result=$mscore_result;
          $final_result=[];
          $resultcount=count($result);
          $i=0;
          foreach($result as $key=>$value)
          {
           
            $final_result[$i]=[];            
            $final_result[$i]['loc_id']=$value['loc_id'];
            $final_result[$i]['result']=round($value['result'],2);
     if(isset($details['maparray'][$value['loc_id']]))       
    $additional_result['values'][$value['loc_id']]=array('loc_id'=>$value['loc_id'],'location_name'=>$details['maparray'][$value['loc_id']]['location_name'],'results'=>$final_result[$i]['result'],'result'=>$final_result[$i]['result']);
         
         
            $i++;
             

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