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

class CombinemovinggrowthController extends Controller
{
    private $low=[5,69,54];
    private $high=[151,83,34];
    private $isolate=[166, 63, 26];
    private $low_town=[0,0,100];
    private $high_town=[241, 41, 36];  
    private $isolate_town=[241, 41, 36];
    public  $details=[];

    const GEO_LEVEL_ISSUE = "The data not shown in this level";
    const NO_DATA = "Data not available";
    const MAP_ISSUE = "Map not available";
    const MENU_ISSUE="Please select single menu";

    public function Combinemovinggrowth($result,$detailed_result,$additional_result,$suffix_of_result)
    {

    	  $data=['result'=>[],'mapdata'=>[],'chartdata'=>[],'griddata'=>[],'head'=>[],'legend'=>[]];
        
        $countresult=count($detailed_result['year']);

        $xAxis=[];$chart_data=[];
        if($detailed_result['calendar_type']==6)
        $period_name=[1=>'Ja-Ma',2=>'Ap-Ju',3=>'Jul-Se',4=>'Oc-De'];
        if($detailed_result['calendar_type']==4)
            $period_name=[1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'];

        for($i=0;$i<count($result);$i++)
        {
          $v=$additional_result['values'][$result[$i]['loc_id']];
          
              $temp=[];             
              $temp['growth_result']=[];
              $temp['name']=$detailed_result['maparray'][(string)$result[$i]['loc_id']]['location_name'];
              $temp['data']=[];
              $additional_result['values'][$result[$i]['loc_id']]['period_result']=[];
              $year=$detailed_result['year'];

              while(count($year) >  1)
              {
                 $present_year=$year[count($year)-1];
                  $past_year=$year[count($year)-2];
                  
                  if(((count($xAxis)) <= count($year)) && ($i<=0))
                  {
                    if($detailed_result['calendar_type']==2)
                        array_push($xAxis,$present_year.' on '.$past_year);
                     if(in_array($detailed_result['calendar_type'],[4,6]))  
                    {
                        $present_year_=explode("_",$present_year);
                        $past_year_=explode("_",$past_year);

                        array_push($xAxis,$period_name[$present_year_[0]].' '.$present_year_[1].' on '.$period_name[$past_year_[0]].' '.$past_year_[1]);
                     
                    }


                  }
                         
                 
                  if(($v['period'][$past_year] <=  0))
                    $v['period'][$past_year]=$v['period'][$present_year];
                  if(($v['period'][$past_year] <=  0))
                    $v['period'][$past_year]=1;
                  $additional_result['values'][$result[$i]['loc_id']]['period_result'][$present_year.' on '.$past_year]=round(((($v['period'][$present_year]-$v['period'][$past_year])/($v['period'][$past_year]))*100),2);
                  array_pop($year);
                  array_push($temp['growth_result'], $additional_result['values'][$result[$i]['loc_id']]['period_result'][$present_year.' on '.$past_year]);
                  array_push($temp['data'], (float)$additional_result['values'][$result[$i]['loc_id']]['period_result'][$present_year.' on '.$past_year]);
                  $additional_result['values'][$result[$i]['loc_id']]['total_result']=$result[$i]['total_result'];


              }
             // var_dump($temp['data']);die;
              array_reverse($temp['data']);
            
              $temp['result']=round((array_sum($temp['growth_result'])/$countresult),2);
              $additional_result['values'][$result[$i]['loc_id']]['result']=$temp['result'];
          
         $result[$i]['result']=$temp['result'];

         $chart_data[$i]=array('name'=>$temp['name'],'data'=>$temp['data']);

        }
      
        $xAxis=array_reverse($xAxis);

        $result_value = array_column($result, 'result');

         $totalcount=count($result);    
         $total_value=(count($result_value) > 0) ? array_sum($result_value) : 1 ;
         $maxval=(count($result_value) > 0) ?  max($result_value) : 1 ;      
         $minval=(count($result_value) > 0) ?  min($result_value) : 0 ; 
         $format=CommonController::formattype(1);
         //$formated_result=CommonController::getlocwisegroup_array($result,'loc_id'); 
         $cumulative=0; $legend=''; $label='';

         /*        @Map color Processing          */

         if(isset($result[0]['location_type']) && $result[0]['location_type'] != '')
         {        
                   
          
            $town_data=array_filter($result, function ($item){
                if (stripos($item['location_type'], 'town') !== false) {
                    return true;
                }        
                return false;
            });
             $village_data=array_filter($result, function ($item){
                if (stripos($item['location_type'], 'village') !== false) {
                    return true;
                }        
                return false;
            });

             $town_totalcount=count($town_data); $village_totalcount=count($village_data); 
             $town_village_criteria=[];

             if($town_totalcount > 0)
             {
               $max_town = array_column($town_data, 'result');                
               $town_maxval=(count($max_town) > 0) ?  max($max_town) : 1 ; 
               $town_minval=(count($max_town) > 0) ?  min($max_town) : 0 ;
               $town_village_criteria['town']=array('max'=>$town_maxval,'min'=>$town_minval);

             }
             if($village_totalcount > 0)
             {
               $village_totalcount=count($village_data);
               $max_village = array_column($village_data, 'result');              
               $village_maxval=(count($max_village) > 0) ?  max($max_village) : 1 ; 
               $village_minval=(count($max_village) > 0) ?  min($max_village) : 0 ;                
               $town_village_criteria['village']=array('max'=>$village_maxval,'min'=>$village_minval);

             }
       }
         
         $result_count=count($result);
         for($k=0;$k<$result_count;$k++)
         { 

          if(isset($result[$k]['location_type']) && $result[$k]['location_type'] != '')
          {
              if($result[$k]['location_type']=='village')
              {
                   $color_critiea=((float)$result[$k]['result']/max((float)$town_village_criteria['village']['max'],1))*100;
                   $remain=((float)$town_village_criteria['village']['max']-(float)$town_village_criteria['village']['min']);
                    if($remain==0)
                   {
                      $color="hsl(".$this->isolate[0].", ".$this->isolate[1]."%, ".$this->isolate[2]."%)";
                      $legend="background-color:".$color.";";
                      $label='';
                   }
                   else
                   {
                     $delta=((float)$result[$k]['result']-(float)$town_village_criteria['village']['min'])/$remain;
                     $color=CommonController::getColor((float)$town_village_criteria['village']['max'], (float)$town_village_criteria['village']['min'], $delta,$this->low,$this->high);
                     $label='<div class="range-label"><span>High</span><span>Low</span></div>';
                     $legend=" background: linear-gradient( to left, #db4639 0%, #db7f29 17%, #d1bf1f 33%, #92c51b 50%, #48ba17 67%, #12ab24 83%, #0f9f59 100% );";
                   }

              }
              if($result[$k]['location_type']=='town')
              {
                  $color_critiea=((float)$result[$k]['result']/(float)$town_village_criteria['town']['max'])*100;
                  $remain=((float)$town_village_criteria['town']['max']-(float)$town_village_criteria['town']['min']);

                   if($remain==0)
                   {
                      $color="hsl(".$this->isolate_town[0].", ".$this->isolate_town[1]."%, ".$this->isolate_town[2]."%)";
                      $legend="background-color:".$color.";";
                      $label='';
                   }
                   else
                   {
                     $delta=((float)$result[$k]['result']-(float)$town_village_criteria['town']['min'])/$remain;
                     $color=CommonController::getColor((float)$town_village_criteria['town']['max'], (float)$town_village_criteria['town']['min'], $delta,$this->low_town,$this->high_town);
                     $label='<div class="range-label"><span>High</span><span>Low</span></div>';
                     $legend="background-color:".$color.";";
                   }
                $legend ='<div class="col-md-12">'.$label.'<div class="combine-color"><i style="flex: 1;-webkit-box-flex: 1;margin: 4px 5px;text-align: left;font-size: 1em;line-height: 1em;display: block; width: 100px;height: 10px;'.$legend.';"></i><span>'.$detailed_result['menu_axis'].'</span></div></div>';
                 array_push($data['legend'],$legend);
              }

          }
          else
          {

              $color_critiea=((float)$result[$k]['result']/max((float)$maxval,1))*100;
              $remain=($maxval-$minval);
               if($remain==0)
               {
                  $color="hsl(".$this->isolate[0].", ".$this->isolate[1]."%, ".$this->isolate[2]."%)";
                  $legend="background-color:".$color.";";
                  $label='';
               }
               else
               {
                 $delta=((float)$result[$k]['result']-$minval)/$remain;
                 $color=CommonController::getColor($maxval, $minval, $delta,$this->low,$this->high);
                 $label='<div class="range-label"><span>High</span><span>Low</span></div>';
                 $legend=" background: linear-gradient( to left, #db4639 0%, #db7f29 17%, #d1bf1f 33%, #92c51b 50%, #48ba17 67%, #12ab24 83%, #0f9f59 100% );";
               }

          }
         
          $contribution=round((($result[$k]['result']/max($total_value,1))*100),2);
          $cumulative=$contribution+$cumulative;
          $size=round((50*($color_critiea/100)),2);
          $size=($size > 1) ? $size : 1; 
          $result[$k]['result']=$result[$k]['result']/$format['divideby'];          
          $rank_info=((count($result) > 0) ? '<small>Rank  '.($k+1).'/'.$totalcount.'</small>' : '' );          

        if(isset($detailed_result['maparray'][(string)$result[$k]['loc_id']]))
         {
          $info_text='<div class="container-fluid p-3 popupbox" id="ttpm" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h6 style="padding-top:0.3rem;max-width: 60%;">'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['location_name'].' &nbsp;</h6><div style="height:max-content;margin-right: -0.7rem;"><img class="ml-1"  src="icons/share-icon.png" height="30px"><img class="ml-1" geocode="'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['latitude'].','.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px"></span></div></span>'.$rank_info.'<div id="rem_lddis"><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg Growth : </span>'.$result[$k]['result'].' </p>';
        // foreach($detailed_result['tooltip'] as $k1=>$v1)
        // {
        //    if(isset($v1[3]) && $v1[3]==1)
        //    {
        //         if($v1[2]!='')
        //          $info_text .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$k1.' : </span>'.$v1[1].' '. number_format($additional_result['values'][$result[$k]['loc_id']][$v1[0]],$v1[2]).' </p>';
        //         else
        //           $info_text .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$k1.' : </span>'.$v1[1].' '. $additional_result['values'][$result[$k]['loc_id']][$v1[0]].'</p>';
        //    }
        //    else
        //    {
        //         if($v1[2]!='')
        //          $info_text .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$k1.' : </span>'. number_format($additional_result['values'][$result[$k]['loc_id']][$v1[0]],$v1[2]).' '.$v1[1].' </p>';
        //         else
        //           $info_text .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$k1.' : </span>'. $additional_result['values'][$result[$k]['loc_id']][$v1[0]].' '.$v1[1].' </p>';
        //    }
            
        // }
      // <p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$detailed_result['menu_axis'].' : </span>'. number_format(round($result[$k]['result'],2),0).$format['rangename'].' '.$suffix_of_result.' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Contribtn Share : </span>'.(float)$contribution.' %</p>
      $info_text .='</div>';
      }

          $temp=array('location_id'=>$result[$k]['loc_id'],'location_name'=>$detailed_result['maparray'][(string)$result[$k]['loc_id']]['location_name'],'result'=>round($result[$k]['result'],2),'rank'=>($k+1).'/'.$totalcount,'color'=>$color,'info'=>$info_text,'size'=>$size); 
         
          $detailed_result['maparray'][(string)$result[$k]['loc_id']]=array_merge($detailed_result['maparray'][(string)$result[$k]['loc_id']],$temp);
          array_push($data['result'],$temp);
         }

       $data['mapdata']=$detailed_result['maparray'];
       $data['head']=$detailed_result['head'];

       /*        @Map Legend Processing          */
      
       $legend ='<div class="col-md-12">'.$label.'<div class="combine-color"><i style="flex: 1;-webkit-box-flex: 1;margin: 4px 5px;text-align: left;font-size: 1em;line-height: 1em;display: block; width: 100px;height: 10px;'.$legend.';"></i><span>'.$detailed_result['menu_axis'].'</span></div></div>';
       array_push($data['legend'],$legend);
       

       /*        @Chart Processing          */

        $data['griddata']=self::gettable($data['result'],$detailed_result,$additional_result,$format['chartsymbol'],$xAxis);
        //array_push($data['chartdata'],['label'=>'Timeseries Chart','function_name'=>'timelinechart','structure'=>self::timelinechart($xAxis,$chart_data,$detailed_result)]);

       return $data;
       


    }

     public static function timelinechart($xAxis,$chart_data,$detailed_result,$formatsymbol='')
  {

 // var_dump($additional_result['values']);die;
          $timelinechart=[];
          $year=$detailed_result['year'];
          $timelinechart=['chart'=>[],'lang'=>[],'title'=>[],'xAxis'=>['title'=>[]],'yAxis'=>['categories'=>[]],'credits'=>[],'plotOptions'=>['bar'=>['datalabels'=>['enabled'=>true]]],'legend'=>['layout'=>'vertical','align'=>'right','verticalAlign'=>'middle'],'series'=>[]]; 
          $timelinechart['chart']['backgroundColor']='rgba(255, 255, 255, 0.0)';
          $timelinechart['lang']['numericSymbols']=$formatsymbol;        
          $timelinechart['chart']['zoomType']="y";
          $timelinechart['chart']['panning']=true;
          $timelinechart['chart']['panKey']='shift';
         // $bubble_chart['title']['text']=$detailed_result['head'];
          $timelinechart['xAxis']['title']['text']=$detailed_result['loc_axis'];
          $timelinechart['yAxis']['title']['text']=$detailed_result['menu_axis'];         
          $timelinechart['yAxis']['min']=0;
          $timelinechart['xAxis']['categories']=$xAxis;
          $timelinechart['credits']['enabled']=false;
          
          $timelinechart['series']=$chart_data; 
        
        
          return $timelinechart;

  }

	public function gettable($processed_result,$detailed_result,$table_result,$suffix_of_result,$xAxis)
  {
    

      $column=$table_result['column'];
      //var_dump($column);die;
      $column_value=$table_result['values'];    
      ksort($column);
      $content_tbl='';
      $content_tbl .='<tbody>';  
       
     $maketbl='';
      $maketbl.='<thead><tr>';
      $maketbl.='<th>#</th>';
      $maketbl.='<th align="left">'.$detailed_result['loc_axis'].'</th>';
      foreach($column as $k=>$v)
      {
          $maketbl.='<th align="right" colspan="'.$v['colspan'].'">'.$v['label'].'</th>';
      }      
      
      $maketbl .='</tr>';
    
      $maketbl.='<tr>';
      $maketbl.='<th>&nbsp;</th>';
      $maketbl.='<th align="left">&nbsp;</th>';

      for($i=0;$i<count($xAxis);$i++)
         $maketbl.='<th align="right">'.$xAxis[$i].'</th>';
      $maketbl.='<th>&nbsp;</th>';
       $maketbl.='<th>&nbsp;</th>';

            
      $maketbl .='</tr>';      
     
      $maketbl.='</thead>';
      $column_val=array_values($column_value);
      $column=array_values($column);
      $result=array_sum(array_column($column_val,'result'));     
     
     
      $count=1;$cumulative=0;
     
     foreach ($column_value as $k => $v) {
          $content_tbl .='<tr>';
          $content_tbl.='<td align="right">'.$count.'</td>';
          $content_tbl.='<td align="left"><a href="#" id="'.$v['loc_id'].'" style="text-decoration:underline;" onClick="showbound(this)">'.$v['location_name'].'</a></td>';
          for($i=0;$i<count($column);$i++)
          {
            if($column[$i]['src'] =='')
             {

                array_reverse($v['period_result']);
               //// var_dump($v['period_result']);die;
                foreach($v['period_result'] as $k=>$y)
                {
                                   
                   $content_tbl.='<td align="'.$column[$i]['align'].'">'.$y.'</td>';
                }

             }
             else
               $content_tbl.='<td align="'.$column[$i]['align'].'">'.round($v[$column[$i]['src']],2).'</td>';
          }

          $content_tbl .='</tr>';
          $count++;
      }
      $content_tbl .='</tbody>';
//echo $maketbl.$content_tbl;die;

      return $maketbl.$content_tbl;


  }
      
}