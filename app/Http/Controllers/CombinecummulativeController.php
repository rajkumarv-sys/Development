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

class CombinecummulativeController extends Controller
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

    public function Combinecummulative($result,$detailed_result,$additional_result,$suffix_of_result)
    {

    	  $data=['result'=>[],'mapdata'=>[],'chartdata'=>[],'griddata'=>[],'head'=>[],'legend'=>[]];
           
        $result=CommonController::getlocwisegroup($result,'loc_id'); 
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
                   $color_critiea=((float)$result[$k]['result']/(float)$town_village_criteria['village']['max'])*100;
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
                     $label='<div class="range-label"><span>High</span><span>&emsp;&emsp;&emsp;Low</span></div>';
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
                     $label='<div class="range-label"><span>High</span><span>&emsp;&emsp;&emsp;&emsp;Low</span></div>';
                     $legend="background-color:".$color.";";
                   }
                $legend ='<div class="col-md-12">'.$label.'<div class="combine-color"><i style="flex: 1;-webkit-box-flex: 1;margin: 1px 1px;text-align: left;font-size: 1em;line-height: 1em;display: block; width: 100px;height: 10px;'.$legend.';"></i><span>'.$detailed_result['menu_axis'].'</span></div></div>';
                 array_push($data['legend'],$legend);
              }

          }
          else
          {
                $maxval=((int)$maxval <=0) ? 1 : $maxval;
              //echo $result[$k]['result']; echo $maxval;die;

              $color_critiea=((float)$result[$k]['result']/(float)$maxval)*100;
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
                 $label='<div class="range-label"><span>High</span><span>&emsp;&emsp;&emsp;Low</span></div>';
                 $legend=" background: linear-gradient( to left, #db4639 0%, #db7f29 17%, #d1bf1f 33%, #92c51b 50%, #48ba17 67%, #12ab24 83%, #0f9f59 100% );";
               }

          }
            $total_value=((int)$total_value <=0) ? 1 : $total_value;
          $contribution=round((($result[$k]['result']/$total_value)*100),2);
          $cumulative=$contribution+$cumulative;
          $size=round((50*($color_critiea/100)),2);
          $size=($size > 1) ? $size : 1; 
          $result[$k]['result']=$result[$k]['result']/$format['divideby'];  
          $rank_info='';
        if($totalcount > 1)        
          $rank_info=((count($result) > 0) ? '<h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;"><small>Rank  '.($k+1).'/'.$totalcount.'</small></span></span></h5>' : '' );
 $info_text ='';
   if(isset($detailed_result['maparray'][(string)$result[$k]['loc_id']]))
  { 
     $loc_name=str_replace("'","",$detailed_result['maparray'][(string)$result[$k]['loc_id']]['location_name']);

        $temp['shareinfo']='Location: '.$loc_name.';';

        foreach($detailed_result['tooltip'] as $k1=>$v1)
        {
        if((in_array($v1[0],['contrib_share','contribution_result','contribution_share']))  && ($detailed_result['main_location']== $detailed_result['sub_location']))
            continue;


           if(isset($v1[3]) && $v1[3]==1)
           {
                if($v1[2]!='')
                {
                 $info_text .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$k1.': </span>'.$v1[1].' '. number_format($additional_result['values'][$result[$k]['loc_id']][$v1[0]],$v1[2]).' </p>';
                 $temp['shareinfo'] .=$k1.' : '.$v1[1].' '. number_format($additional_result['values'][$result[$k]['loc_id']][$v1[0]],$v1[2]).';';
                }
                else{

                  $info_text .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$k1.': </span>'.$v1[1].' '. $additional_result['values'][$result[$k]['loc_id']][$v1[0]].'</p>';
                  $temp['shareinfo'] .=$k1.' : '.$v1[1].' '. $additional_result['values'][$result[$k]['loc_id']][$v1[0]].';';
                }
           }
           else
           {
                if($v1[2]!=''){
                 $info_text .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$k1.': </span>'. number_format($additional_result['values'][$result[$k]['loc_id']][$v1[0]],$v1[2]).' '.$v1[1].' </p>';
                  $temp['shareinfo'] .=$k1.' : '.$v1[1].' '. number_format($additional_result['values'][$result[$k]['loc_id']][$v1[0]],$v1[2]).' '.$v1[1].';';
                }
                else{
                    $v1[1]=($v1[1]=='%') ? $v1[1] : ' '.$v1[1];
                  $info_text .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$k1.': </span>'. $additional_result['values'][$result[$k]['loc_id']][$v1[0]].''.$v1[1].' </p>';
                 $temp['shareinfo'] .=$k1.' : '. $additional_result['values'][$result[$k]['loc_id']][$v1[0]].' '.$v1[1].';';
                }
           }
            
        }
   // if($detailed_result['main_location']==12 && $detailed_result['sub_location']==15)
      $info_text .='<p><a href="#" onClick="show_info('.$result[$k]['loc_id'].','.$detailed_result['sub_location'].')"><button type="button" class="btn text-light mt-2" style="background:#0b4038">Show Info</button></a></p>';
      $info_text .='</div>';

        $info_text1='<div class="container-fluid p-3 popupbox" id="ttpm" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h6 style="padding-top:0.3rem;max-width: 60%;">'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['location_name'].' &nbsp;</h6><div style="height:max-content;margin-right: -0.7rem;"><img class="ml-1"  src="icons/share-icon.png" height="30px"  onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['latitude'].'" lon="'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['longitude'].'" id="share_'.$result[$k]['loc_id'].'"><img class="ml-1" geocode="'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['latitude'].','.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" id="'.$result[$k]['loc_id'].'" onClick="closeicon_map(this)"></span></div></span>'.$rank_info.'<div id="rem_lddis"><hr style="border-top: 1px solid white;">'.$info_text;
     } 

          
          
          if(isset($detailed_result['maparray'][(string)$result[$k]['loc_id']]))
          {
            $temp=array('location_id'=>$result[$k]['loc_id'],'location_name'=>$detailed_result['maparray'][(string)$result[$k]['loc_id']]['location_name'],'result'=>round($result[$k]['result'],2),'rank'=>($k+1).'/'.$totalcount,'color'=>$color,'info'=>$info_text1,'size'=>$size); 
            $detailed_result['maparray'][(string)$result[$k]['loc_id']]=array_merge($detailed_result['maparray'][(string)$result[$k]['loc_id']],$temp);
          array_push($data['result'],$temp);
          }
        
          
         }

       $data['mapdata']=$detailed_result['maparray'];
       $data['head']=$detailed_result['head'];

       /*        @Map Legend Processing          */
     
       $legend ='<div class="col-md-12">'.$label.'<div class="combine-color"><i style="flex: 1;-webkit-box-flex: 1;margin: 1px 1px;text-align: left;font-size: 1em;line-height: 1em;display: block; width: 100px;height: 10px;'.$legend.';"></i></div><hr style="background-color:#fff; margin:2px;margin-top: 5px;"><p><span style="color:#fff;font-weight:bold;margin: 0px;">Catgry: </span><font style="color:rgb(242, 101, 34);">'.$detailed_result['menu_axis'].'</font> </p><p><span style="color:#fff;font-weight:bold;margin: 0px;">Period: </span><font style="color:rgb(242, 101, 34);">'.implode(",",$detailed_result['year']).' </font></p><p><span style="color:#fff;font-weight:bold;margin: 0px;">Metric: </span><font style="color:rgb(242, 101, 34);">'.implode(",",$detailed_result['title']).'</font></p></div>';
       array_push($data['legend'],$legend);

       /*        @Chart Processing          */

        $data['griddata']=self::gettable($data['result'],$detailed_result,$additional_result,$format['chartsymbol']);
       array_push($data['chartdata'],['label'=>'Bar Chart','function_name'=>'barchart','structure'=>self::barchart($data['result'],$detailed_result,$format['chartsymbol'],$suffix_of_result)]);
       array_push($data['chartdata'],['label'=>'Bubble Chart','function_name'=>'bubblechart','structure'=>self::bubblechart($data['result'],$detailed_result,$format['chartsymbol'],$suffix_of_result)]);

       return $data;
       


    }

    public static function barchart($processed_result,$detailed_result,$formatsymbol,$suffix_of_result)
    {
       // Bar chart 
       $barchart=['chart'=>[],'lang'=>[],'title'=>[],'xAxis'=>['title'=>[]],'yAxis'=>['title'=>[],'categories'=>[]],'credits'=>[],'tooltip'=>[],'plotOptions'=>['bar'=>['datalabels'=>['enabled'=>false]]],'legend'=>[],'series'=>[]]; 

       $barchart['chart']=['type'=>'bar'];
       $barchart['chart']['backgroundColor']='rgba(255, 255, 255, 0.0)';	
       $barchart['lang']['numericSymbols']=' '.$formatsymbol;  
  	   $barchart['chart']['zoomType']="x";
  	   $barchart['chart']['panning']=true;
  	   $barchart['chart']['panKey']='shift';
      // $barchart['title']=['text'=>$detailed_result['head']];
       $barchart['subtitle']=['text'=>''];
       $barchart['credits']['enabled']=false;
	  
       $barchart['xAxis']['title']['text']=$detailed_result['loc_axis'];
       $barchart['xAxis']['categories']=array_column($processed_result, 'location_name');      
       $barchart['yAxis']['title']['text']=$detailed_result['menu_axis'].'('.$suffix_of_result.')';
       $barchart['yAxis']['labels']['overflow']='justify';
       $barchart['yAxis']['min']=0;  

       $barchart['tooltip']['valueSuffix']=$formatsymbol; 

       $barchart['legend']['layout']='vertical'; 
       $barchart['legend']['align']='right'; 
       $barchart['legend']['verticalAlign']='top'; 
       $barchart['legend']['x']=-40; 
       $barchart['legend']['y']=80; 
       $barchart['legend']['floating']=true; 
       $barchart['legend']['borderWidth']=1; 


        $chart_data=[];$chartdata_series=[];
        $chartdata_series['showInLegend']=false;
        $chartdata_series['data']=array();
        for($i=0;$i<count($processed_result);$i++)
        {
           array_push($chartdata_series['data'],array('y'=>(float)$processed_result[$i]['result'],'name'=>$processed_result[$i]['location_name'],'color'=>$processed_result[$i]['color'],'info'=>$processed_result[$i]['info'],'loc_id'=>(int)$processed_result[$i]['location_id']));
        }
        array_push($chart_data, $chartdata_series);
        $barchart['series']=$chart_data;

        return $barchart;

    }
    public static function bubblechart($processed_result,$detailed_result,$formatsymbol,$suffix_of_result)
	{

	
	        $bubble_chart=[];
	        $bubble_chart=['chart'=>[],'lang'=>[],'title'=>[],'xAxis'=>['title'=>[]],'yAxis'=>['categories'=>[]],'credits'=>[],'tooltip'=>[],'plotOptions'=>['bar'=>['datalabels'=>['enabled'=>false]]],'legend'=>[],'series'=>[]]; 
	        $bubble_chart['chart']['backgroundColor']='rgba(255, 255, 255, 0.0)';
	        $bubble_chart['lang']['numericSymbols']=$formatsymbol;
	        $bubble_chart['chart']['type']='bubble';
	        $bubble_chart['chart']['zoomType']="x";
	        $bubble_chart['chart']['panning']=true;
	        $bubble_chart['chart']['panKey']='shift';
	       // $bubble_chart['title']['text']=$detailed_result['head'];
	        $bubble_chart['xAxis']['title']['text']=$detailed_result['loc_axis'];
	        $bubble_chart['yAxis']['title']['text']=$detailed_result['menu_axis'].'('.$suffix_of_result.')';
	        $bubble_chart['plotLines']=["color"=>"black","dashStyle"=>"dot","width"=>2,"label"=>["align"=>"right","style"=>[ "fontStyle"=>"italic"]],"text"=>"","x"=>-10];	       
	        $bubble_chart['yAxis']['min']=0;
	        $bubble_chart['xAxis']['categories']=array_column($processed_result, 'location_name');
	        $bubble_chart['credits']['enabled']=false;
	        
	        $data=[];
	        $chartdata_series['showInLegend']=false;
	        $chartdata_series['type']='bubble';
	        $chartdata_series['data']=array();
	        $column_count=array_column($processed_result, 'location_name');

	       for($i=0;$i<count($processed_result);$i++)
	          {
	             array_push($chartdata_series['data'],array('y'=>(int)$processed_result[$i]['result'],'name'=>$processed_result[$i]['location_name'],'color'=>$processed_result[$i]['color'],'info'=>$processed_result[$i]['info'],'loc_id'=>(int)$processed_result[$i]['location_id']));
	          }

	        array_push($data, $chartdata_series);
	        $bubble_chart['series']=$data;
	        return $bubble_chart;

	}

	public function gettable($processed_result,$detailed_result,$table_result,$suffix_of_result)
	{

      $column=$table_result['column'];
      $column_value=$table_result['values'];    
      ksort($column);
      $content_tbl='';
      $content_tbl .='<tbody>';  
       
      $maketbl='';
      $maketbl.='<thead><tr>';
      $maketbl.='<th>#</th>';
      $maketbl.='<th align="left">'.$detailed_result['loc_axis'].'</th>';
      foreach ($column as $key => $value) {
          $maketbl.='<th align="'.$value['align'].'">'.$value['label'].'</th>';
      }
      $column_val=array_values($column_value);
      $column=array_values($column);
      $result=array_sum(array_column($column_val,'result'));     
      // $maketbl.='<td align="left">Cumultv Share(%)</td>';
      // $maketbl.='<td align="left">Contribtn Share(%)</td>';
      $maketbl.='</tr>';
      $maketbl.='</thead>';
      $count=1;$cumulative=0;
     
     foreach ($column_value as $k => $v) {
          $content_tbl .='<tr>';
          $content_tbl.='<td align="right">'.$count.'</td>';
          $content_tbl.='<td align="left"><a href="#" id="'.$v['loc_id'].'" style="text-decoration:underline;" onClick="showbound(this)">'.$v['location_name'].'</a></td>';
          for($i=0;$i<count($column);$i++)
          {
             if($suffix_of_result=='Nos.' || $suffix_of_result=='HHs.')
                 $data_value=($column[$i]['src']=='result') ? number_format($v[$column[$i]['src']],0) :   $v[$column[$i]['src']];
             else
                 $data_value=($column[$i]['src']=='result') ? number_format($v[$column[$i]['src']],2) :   $v[$column[$i]['src']]; 
             $content_tbl.='<td align="'.$column[$i]['align'].'">'.$data_value.'</td>';
          }
          $result=($result<=0) ? 1 :$result;
          $contribution=round((($v['result']/$result)*100),1);
          $cumulative=$contribution+$cumulative;
          // $content_tbl.='<td align="right">'.$cumulative.'</td>';
          // $content_tbl.='<td align="right">'.$contribution.'</td>';
          $content_tbl .='</tr>';
          $count++;
      }
      $content_tbl .='</tbody>';


      return $maketbl.$content_tbl;


	}

      
}