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

class SplitcummulativeController extends Controller
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

    public function Splitcummulative($result,$detailed_result,$additional_result,$split_master,$suffix_of_result)
    {

    	 $data=['result'=>[],'mapdata'=>[],'chartdata'=>[],'griddata'=>[],'head'=>[],'legend'=>[]];
    	 $cumulative_year_locwise_result=CommonController::getlocwisegroup($result,'loc_id'); 
    	 $formated_result=CommonController::getlocwisegroup_array($result,'loc_id'); 
    	 arsort($cumulative_year_locwise_result);
       $find_maxresult=array_column($cumulative_year_locwise_result, 'result');      
       $max_value_bylocationwise=(count($find_maxresult) > 0) ? max($find_maxresult) :  1;
    	 $locationwise_totalresult=array_sum(array_column($cumulative_year_locwise_result,'result'));  

    	 $format=CommonController::formattype(1);


    	 /* get the max value of each split */
        $split_max_value=[];

     
          foreach($split_master as $split_id=>$splitname)
           {
                 $result_bysplit=array_column(array_column($formated_result,$split_id),'result');
                 $split_max_value[$split_id]= (!empty($result_bysplit))  ? max($result_bysplit) : 0;
           }
           
           arsort($split_max_value, 1);
          

    
    	
    	
    	 /* get the max value of each split */



    	 /* get the legend */  	
    	
    	 $rank=0;$split_order=[];$keys_array=[];

         foreach ($split_max_value as $splitid => $split_value) {
           array_push($keys_array,$splitid);
             if($rank < 10)
             {
                $split_order[$splitid]=array('result'=>$split_value,'color'=>CommonController::split_color_variation($rank+1));             
                $legend ='<div class="row"><div class="legend_split" style="background-color:'.$split_order[$splitid]['color']['hex'].'"></div><span> '.$split_master[$splitid].'</span></div>';
                array_push($data['legend'],$legend);

                $rank++;
             }            
            
         } 
         $data['legend']=array_reverse($data['legend']);
         
        /*  cumulative split data */

        $split_data=[];$increment=0;
       
        $split_master_2=[];
        foreach($keys_array as $v){
          $split_master_2[$v]=$split_master[$v];
        }
       
      $split_master=$split_master_2;



        for($k=0;$k<count($formated_result);$k++)
        {
        	$other=['value'=>0,'contribution'=>0];$dataf=[];$split_poly_color=[];
        	$location=$formated_result[$k]['loc_id'];
        	unset($formated_result[$k]['loc_id']);
        	$info_text='<div class="tooltip-data split-tooltip"><div class="card"><div class="card-header"><h3>'.$detailed_result['maparray'][(string)$location]['location_name'].'</h3>  </div><ul class="list-group list-group-flush">';
            $split_data[$location]=array();   

            $split_data[$location]['total']=array_sum(array_column(array_values($formated_result[$k]),'result'));  
            $split_data[$location]['contribution']=((float)$split_data[$location]['total']/(float)$max_value_bylocationwise)*100;            
            $split_data[$location]['size']=round((50*($split_data[$location]['contribution']/100)),0);


             foreach($split_master as $split_id=>$splitname)
             {            	
                $piedata=[];          
                $result_data=isset($formated_result[$k][$split_id]['result']) ? $formated_result[$k][$split_id]['result'] : 0; 
               // $max_splitresult_data=max(array_column(array_column($formated_result, $split_id),'result'));   
                $result_data=$result_data/$format['divideby'];
                $split_data[$location][$split_id]=[];
                $split_data[$location]['color']='';

                $split_data[$location][$split_id]['values']=$result_data;   
                $split_data[$location]['total']=($split_data[$location]['total'] > 0) ? $split_data[$location]['total'] : 1;             
                $split_data[$location][$split_id]['contribution']=round((($result_data/(float)$split_data[$location]['total'])*100),2); 
                
                if(array_key_exists($split_id,$split_order))
               {    

                  $split_max_value[$split_id]=((float)$split_max_value[$split_id] <=0) ? 1 : (float)$split_max_value[$split_id];
                  if(isset($formated_result[$k][$split_id]['result']))       
                    $color_critiea=((float)$formated_result[$k][$split_id]['result']/(float)$split_max_value[$split_id])*100;
                  else
                    $color_critiea=0; 
                   $from50=$split_order[$split_id]['color']['from_1'];
                   $to50=$split_order[$split_id]['color']['to_1'];
                   $from100=$split_order[$split_id]['color']['from_2'];
                   $to100=$split_order[$split_id]['color']['to_2'];    
                   if($color_critiea < 50)
                      $color= CommonController::Gradient($from50,$to50,50,abs($color_critiea));
                   else
                      $color= CommonController::Gradient($from100,$to100,100,abs($color_critiea));

                   $split_data[$location]['color']=$color;                  
                  
                   if($color != '')
                   {
                   	  

                   	  $info_text .= '<li class="list-group-item"><i style=" width: 10px;height: 10px;background-color:'.$color.'"></i>  '.$splitname.' : <span class="split-contrib">'.$split_data[$location][$split_id]['contribution'].'%</span><span>'.number_format($split_data[$location][$split_id]['values']).$format['rangename'].' '.$suffix_of_result.' </span> </li>';

                      
                   	  $piedata['name']=$splitname;              
                      $piedata['value']=(float)$result_data;
                      $piedata['style']['fillStyle']=$color;
                      $piedata['style']['lineWidth']=2;
                      $piedata['style']['strokeStyle']="white";
                      array_push($split_poly_color,array($color=>round($split_data[$location][$split_id]['contribution'],2)));
                      array_push($dataf,$piedata);
                      $increment++; 

                   }

               }
               else
                   {
                   	    $other['contribution']=$other['contribution']+$split_data[$location][$split_id]['contribution'];
                        $other['value']=$other['value']+$split_data[$location][$split_id]['values'];
                   }


              }


              $info_text .=($other['value'] > 0 ) ? '<li class="list-group-item"> Others: <span class="split-contrib">'.$other['contribution'].'%</span><span>'.number_format($other['value']).$format['rangename'].' '.$suffix_of_result.' </span> </li>' : '';  

	          $temp=array('location_id'=>$location,'location_name'=>$detailed_result['maparray'][(string)$location]['location_name'],'result'=>$formated_result[$k],'contribution'=>$split_data[$location][$split_id]['contribution'],'info'=>$info_text,"split_variable"=>$split_order,"piedata"=>json_encode($dataf),'split_polygon_data'=>json_encode($split_poly_color),'size'=>(($split_data[$location]['size'] < 3 ) ?  3  : $split_data[$location]['size']));

	     

	         $split_data[$location]['location']= $detailed_result['maparray'][(string)$location];
           if(isset($detailed_result['maparray'][(string)$location]))
           {
            $detailed_result['maparray'][(string)$location]=array_merge($detailed_result['maparray'][(string)$location],$temp);
             array_push($data['result'],$temp);
           }
          
            
         }

       $data['mapdata']=$detailed_result['maparray'];
		  $data['head']=$detailed_result['head'];
      $data['griddata']=self::gettable($data['result'],$detailed_result,$additional_result,$suffix_of_result);

		  array_push($data['chartdata'],['label'=>'Stack Chart','function_name'=>'stackchart','structure'=>self::stackchart($data['result'],$detailed_result,$format['chartsymbol'],$split_master,$suffix_of_result)]);
          array_push($data['chartdata'],['label'=>'Pyramid Chart','function_name'=>'columnpyramidchart','structure'=>self::columnpyramid($data['result'],$detailed_result,$format['chartsymbol'],$split_master,$suffix_of_result)]);
		
		  return $data;

         /*        @Map color Processing          */


    }

    public static function stackchart($processed_result,$detailed_result,$formatsymbol,$split_master,$suffix_of_result)
    {
       // Bar chart 
       $stackchart=['chart'=>[],'lang'=>[],'title'=>[],'xAxis'=>['title'=>[]],'yAxis'=>['categories'=>[]],'credits'=>[],'tooltip'=>[],'plotOptions'=>['bar'=>['datalabels'=>['enabled'=>false]]],'legend'=>[],'series'=>[]]; 

       $stackchart['chart']=['type'=>'column'];
       $stackchart['chart']['backgroundColor']='rgba(255, 255, 255, 0.0)';	
       $stackchart['lang']['numericSymbols']=' '.$formatsymbol;  
	   $stackchart['chart']['zoomType']="x";
	   $stackchart['chart']['panning']=true;
	   $stackchart['chart']['panKey']='shift';
      // $stackchart['title']=['text'=>$detailed_result['head']];
       $stackchart['subtitle']=['text'=>''];
       $stackchart['credits']['enabled']=false;	  
       $stackchart['xAxis']['title']['text']=$detailed_result['loc_axis'];
       $stackchart['xAxis']['categories']=array_column($processed_result, 'location_name');
       $stackchart['yAxis']['title']['text']=$detailed_result['menu_axis'].' ('.$suffix_of_result.')';
       $stackchart['yAxis']['labels']['overflow']='justify';
       $stackchart['yAxis']['min']=0;  
       $stackchart['tooltip']['valueSuffix']=$formatsymbol; 
       $stackchart['legend']['layout']='vertical'; 
       $stackchart['legend']['align']='right'; 
       $stackchart['legend']['verticalAlign']='top'; 
       $stackchart['legend']['x']=-40; 
       $stackchart['legend']['y']=80; 
       $stackchart['legend']['floating']=true; 
       $stackchart['legend']['borderWidth']=1; 
       $stackchart['plotOptions']=['column'=>['staking'=>'normal','datalabels'=>['enabled'=>true]]];

	 	if(isset($processed_result[0]['split_variable']))
		{
		   $color_arr=array_column($processed_result[0]['split_variable'],'color');     
		   $color_arr=array_column($color_arr,'to_2');      
		    $stackchart['colors']=$color_arr;
		}
      
		$chart_data=[];$chartdata_series=[];
        $chartdata_series['showInLegend']=false;
        $chartdata_series['data']=array();
        $inr=0;
        
      if(isset($processed_result[0]['split_variable']))
      {
          foreach ($processed_result[0]['split_variable'] as $key => $value) { 

          $temp=[];
          $temp['name']= $split_master[$key];
          $temp['data']=array();  

          for($j=0;$j<count($processed_result);$j++)
          {       
              $temp['info']=$processed_result[$j]['info'];

              if(isset($processed_result[$j]['result'][$key]))
              {
                array_push($temp["data"],(int)$processed_result[$j]['result'][$key]['result']);                
                $inr++;
              }
              else
              {
                array_push($temp["data"],0);                      
              }
          }
         array_push($chartdata_series['data'],$temp);              
       }
      }
		
        
        $stackchart['series']=$chartdata_series['data'];

        return $stackchart;

    }
     public static function columnpyramid($processed_result,$detailed_result,$formatsymbol,$split_master,$suffix_of_result)
    {
       // Bar chart 
       $stackchart=['chart'=>[],'lang'=>[],'title'=>[],'xAxis'=>['title'=>[]],'yAxis'=>['categories'=>[]],'credits'=>[],'tooltip'=>[],'plotOptions'=>['bar'=>['datalabels'=>['enabled'=>false]]],'legend'=>[],'series'=>[]]; 

       $stackchart['chart']=['type'=>'columnpyramid'];
       $stackchart['chart']['backgroundColor']='rgba(255, 255, 255, 0.0)';	
       $stackchart['lang']['numericSymbols']=' '.$formatsymbol;  
	   $stackchart['chart']['zoomType']="x";
	   $stackchart['chart']['panning']=true;
	   $stackchart['chart']['panKey']='shift';
      // $stackchart['title']=['text'=>$detailed_result['head']];
       $stackchart['subtitle']=['text'=>''];
       $stackchart['credits']['enabled']=false;	  
       $stackchart['xAxis']['title']['text']=$detailed_result['loc_axis'];
       $stackchart['xAxis']['categories']=array_column($processed_result, 'location_name');
       $stackchart['yAxis']['title']['text']=$detailed_result['menu_axis']. '('.$suffix_of_result.')';
       $stackchart['yAxis']['labels']['overflow']='justify';
       $stackchart['yAxis']['min']=0;  
       $stackchart['tooltip']['valueSuffix']=$formatsymbol; 
       $stackchart['legend']['layout']='vertical'; 
       $stackchart['legend']['align']='right'; 
       $stackchart['legend']['verticalAlign']='top'; 
       $stackchart['legend']['x']=-40; 
       $stackchart['legend']['y']=80; 
       $stackchart['legend']['floating']=true; 
       $stackchart['legend']['borderWidth']=1; 
       $stackchart['plotOptions']=['column'=>['staking'=>'normal','datalabels'=>['enabled'=>true]]];


	 	if(isset($processed_result[0]['split_variable']))
		{
		   $color_arr=array_column($processed_result[0]['split_variable'],'color');     
		   $color_arr=array_column($color_arr,'to_2');      
		   $stackchart['colors']=$color_arr;
		}
		$chart_data=[];$chartdata_series=[];
        $chartdata_series['showInLegend']=false;
        $chartdata_series['data']=array();
        $inr=0;
        if(isset($processed_result[0]['split_variable'])){
		foreach ($processed_result[0]['split_variable'] as $key => $value) { 

          $temp=[];
          $temp['name']= $split_master[$key];
          $temp['data']=array();  

          for($j=0;$j<count($processed_result);$j++)
          {       
              $temp['info']=$processed_result[$j]['info'];      	
              if(isset($processed_result[$j]['result'][$key]))
              {
                array_push($temp["data"],(int)$processed_result[$j]['result'][$key]['result']);                
                $inr++;
              }
              else
              {
                array_push($temp["data"],0);                      
              }
          }
         array_push($chartdata_series['data'],$temp);              
       }
        }
        $stackchart['series']=$chartdata_series['data'];

        return $stackchart;

    }
 
   public function gettable($processed_result,$detailed_result,$table_result,$suffix_of_result)
  {

      $column=$table_result['column'];
      $column_value=$table_result['values'];    
      ksort($column);
      $column_val=array_values($column_value);
     
      $content_tbl='';
      $content_tbl .='<tbody>';  
       
      $maketbl='';
      $maketbl.='<thead><tr>';
      $maketbl.='<td>#</td>';
      $maketbl.='<td align="left">'.$detailed_result['loc_axis'].'</td>';
      $show_treeview=false;

      foreach ($column as $key => $value) {

        if(isset($value['subarray']) && $value['subarray']==true)
        {
         
          if(count($value['split_master']) <= 5){
            $show_treeview=false;
            $split_master=$value['split_master'];

            foreach ($value['split_master'] as $k => $v) {
              $maketbl.='<td align="right">'.$v.'('.$suffix_of_result.')</td>';
            }
          }
          else
          {
            $split_master=$value['split_master'];
            $show_treeview=true;
              $maketbl.='<td align="'.$value['align'].'">'.$value['label'].'</td>';
          }
      
        }
        else{
           $maketbl.='<td align="'.$value['align'].'">'.$value['label'].'</td>';
        
        }
      }
     

      $column=array_values($column);
      $result=array_sum(array_column($column_val,'result'));     
     
     // $maketbl.='<td align="right">Contribtn Share(%)</td>';
      $maketbl.='</tr>';
      $maketbl.='</thead>';
      $count=1;$cumulative=0;
   
     foreach ($column_value as $k => $v) {

          if($show_treeview)
          {
             
             
             $child=htmlspecialchars(json_encode(array_values($v['subarray'])), ENT_QUOTES, 'UTF-8');
            
              $content_tbl .='<tr json_attr="'.$child.'">';
             $content_tbl.='<td align="right" class=" dt-control"> '.$count.'</td>';
          }
          else
          {
              $content_tbl .='<tr>';
              $content_tbl.='<td align="right">'.$count.'</td>';
          }

         
          $content_tbl.='<td align="left"><a href="#" id="'.$v['loc_id'].'" style="text-decoration:underline;" onClick="showbound_(this)">'.$v['location_name'].'</a></td>';
         
          for($i=0;$i<count($column);$i++)
          {

            if(isset($column[$i]['subarray']))
            {
                  if(!$show_treeview)
                  {
                    foreach ($split_master as $key => $value) {

                      if(isset($v['subarray'][$key]['split_result']))
                       $content_tbl.='<td align="right">'.$v['subarray'][$key]['split_result'].'</td>';
                     else
                        $content_tbl.='<td align="right"></td>';
                      # code...
                    }

                      // foreach ($v['subarray'] as $key => $value) {

                      //   $content_tbl.='<td align="right">'.$value['split_result'].'</td>';
                      // }
                  }
                  else
                     $content_tbl.='<td align="'.$column[$i]['align'].'">'.$v[$column[$i]['src']].'</td>';
            }
            else
            {
               $content_tbl.='<td align="'.$column[$i]['align'].'">'.$v[$column[$i]['src']].'</td>';
            }
             
            
          }
          

         // $contribution=round((($v['result']/$result)*100),2);
             
       //   $content_tbl.='<td align="right">'.$contribution.'</td>';
          $content_tbl .='</tr>';
          $count++;
      }
      $content_tbl .='</tbody>';


      return $maketbl.$content_tbl;


  }


      
}