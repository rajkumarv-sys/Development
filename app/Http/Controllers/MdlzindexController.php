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

class MdlzindexController extends Controller
{
    private $low=[5,69,54];
    private $high=[151,83,34];
    private $isolate=[166, 63, 26];
    private $low_town=[0,0,100];
    private $high_town=[241, 41, 36];  
    private $isolate_town=[241, 41, 36];
    public  $details=[];
    private $red=[5,69,54];
    private $green=[151,83,34];
    private $orange=[255,165,0];
    private $yellow=[255,255,0];
   
    private $mdlz_scale=['index_score'=>30,'sales'=>10000];


    const GEO_LEVEL_ISSUE = "The data not shown in this level";
    const NO_DATA = "Data not available";
    const MAP_ISSUE = "Map not available";
    const MENU_ISSUE="Please select single menu";

    public function Mdlzindex($result,$detailed_result,$additional_result,$suffix_of_result)
    {

    	  $data=['result'=>[],'mapdata'=>[],'chartdata'=>[],'griddata'=>[],'head'=>[],'legend'=>[]];
           
       
         $cumulative=0; $legend=''; $label='';

         /*        @Map color Processing          */

        
         
         $result_count=count($result);
         $pi='';$si='';
         if(!in_array(6,$detailed_result['cndn_value']))  {
            $pi='PI';$si='PS';
         } 
         else{
            $pi='SI';$si='SS';
         }
         for($k=0;$k<$result_count;$k++)
         { 
         
      
          $label='<div class="range-label"><span>High</span><span>&emsp;&emsp;&emsp;Low</span></div>';
          $legend=" background: linear-gradient( to left, #db4639 0%, #db7f29 17%, #d1bf1f 33%, #92c51b 50%, #48ba17 67%, #12ab24 83%, #0f9f59 100% );";
          

      $temp['shareinfo']='';
   if(isset($detailed_result['maparray'][(string)$result[$k]['loc_id']]))
  { 
            $info_text='<div class="container-fluid p-3 popupbox" id="ttpm" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h6 style="padding-top:0.3rem;max-width: 60%;">'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['location_name'].' &nbsp;</h6><div style="height:max-content;margin-right: -0.7rem;"><img class="ml-1"  src="icons/share-icon.png" height="30px"  onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['latitude'].'" lon="'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['longitude'].'" id="share_'.$result[$k]['loc_id'].'"><img class="ml-1" geocode="'.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['latitude'].','.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" id="'.$result[$k]['loc_id'].'" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:'.$result[$k]['color'].';><span style="line-height:1rem;"><small>'.$result[$k]['potential'].'</small></span></span></h5><div id="rem_lddis"><hr style="border-top: 1px solid white;">';
        $temp['shareinfo']='Location: '.$detailed_result['maparray'][(string)$result[$k]['loc_id']]['location_name'].';';

        foreach($detailed_result['tooltip'] as $k1=>$v1)
        {
      

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
      $info_text .='<p><a href="#" onClick="show_info('.$result[$k]['loc_id'].','.$detailed_result['sub_location'].')"><button type="button" class="btn text-light mt-2" style="background:#0b4038">Show Info</button></a></p>';
      $info_text .='</div>';
     }
          if(isset($detailed_result['maparray'][(string)$result[$k]['loc_id']]))
          {
           

            $temp=array('location_id'=>$result[$k]['loc_id'],'location_name'=>$detailed_result['maparray'][(string)$result[$k]['loc_id']]['location_name'],'color'=>$result[$k]['color'],'info'=>$info_text,'size'=>30,'mdlz_score'=>$result[$k]['mdlz_score'],'mdlz_sales'=>$result[$k]['mdlz_sales']); 
            $detailed_result['maparray'][(string)$result[$k]['loc_id']]=array_merge($detailed_result['maparray'][(string)$result[$k]['loc_id']],$temp);
          array_push($data['result'],$temp);
          }
        
          
         }

       $data['mapdata']=$detailed_result['maparray'];
       $data['head']=$detailed_result['head'];
       /*        @Map Legend Processing          */

        

         $legend ='<div class="row" style="margin: 5px 2px; !important"><div class="legend_split" style="background-color:#01875b;width:35px"></div><span> &nbsp;High-'.$pi.' / High-'.$si.'</span><br></div><div class="row" style="margin: 5px 2px; !important"><div class="legend_split" style="background-color:#f2020a;width:35px"></div><span> &nbsp;Low-'.$pi.' / High-'.$si.'</span><br></div><div class="row" style="margin: 5px 2px; !important"><div class="legend_split" style="background-color:#fcff00;width:35px"></div><span> &nbsp;High-'.$pi.' / Low-'.$si.'</span><br></div><div class="row" style="margin: 5px 2px; !important"><div class="legend_split" style="background-color:#ff7f02;width:35px"></div><span> &nbsp;Low-'.$pi.' / Low-'.$si.'</span><br></div>'; 
  
                   array_push($data['legend'],$legend); 
      
       
       array_push($data['legend'],$legend);

       /*        @Chart Processing          */
       $data['griddata']=self::gettable($data['result'],$detailed_result,$additional_result,'');
       

       return $data;
       


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
      $maketbl.='<td align="right">#</td>';
      $maketbl.='<td align="left">'.$detailed_result['loc_axis'].'</td>';
      foreach ($column as $key => $value) {
          $maketbl.='<td align="'.$value['align'].'">'.$value['label'].'</td>';
      }
      $column_val=array_values($column_value);
      $column=array_values($column);
      $result=array_sum(array_column($column_val,'result'));     
      
      $maketbl.='</tr>';
      $maketbl.='</thead>';
      $count=1;
     
     foreach ($column_value as $k => $v) {
          $content_tbl .='<tr>';
          $content_tbl.='<td align="right">'.$count.'</td>';
          $content_tbl.='<td align="left"><a href="#" id="'.$v['loc_id'].'" style="text-decoration:underline;" onClick="showbound(this)">'.$v['location_name'].'</a></td>';

          for($i=0;$i<count($column);$i++)
          {             
             $content_tbl.='<td align="'.$column[$i]['align'].'">'.$v[$column[$i]['src']].'</td>';
          }

         
       
          $content_tbl .='</tr>';
          $count++;
      }
      $content_tbl .='</tbody>';


      return $maketbl.$content_tbl;


    }

      
}