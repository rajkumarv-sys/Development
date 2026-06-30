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

class RpitemplateController extends Controller
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

    public function Rpitemplate($result,$detailed_result,$additional_result,$suffix_of_result,$index_type)
    {
         
          $index_id=array_unique($index_type);

    	  $data=['result'=>[],'mapdata'=>[],'chartdata'=>[],'griddata'=>[],'head'=>[],'legend'=>[]];
       
        $format=CommonController::formattype(1);
        $cumulative=0; $legend=''; $label='';
        $color_critiea=['MostPremium'=>60,'Premium'=>55,'VeryHigh'=>50,'High'=>45,'Medium'=>40,'Low'=>20];

        // $color=[1=>'#32854A',2=>'#E7C908',3=>'#E67E22',4=>'#892212',5=>'#808080',0=>'#FFF'];
        //  $color=['MostPremium'=>'#007060','Premium'=>'#d4df4b','VeryHigh'=>'#852213','High'=>'#852213','Medium'=>'#f58f5b','Low'=>'#a20031'];
        $color=[];

        $value_result=array_values($additional_result['values']);
       
         /*        @Map color Processing          */
        

         $result_count=count($additional_result);
         $cluster_data=[];
         $additional_result_val=array_values($value_result);

         $premium_type=array_values(array_unique(array_column($additional_result_val,'result')));
         $score_result=array_values((array_column($additional_result_val,'score_result')));

         $max_premium_type=max($score_result);
         
       
         for($k=0;$k<count($premium_type);$k++)
         {
            $premium=$premium_type[$k];
           $cluster_data[$premium_type[$k]]= array_filter($additional_result_val, function ($item) use($premium) {
                 if($item['result']==$premium)
                         return $item['score_result'];
            });
            $cluster_data[$premium_type[$k]]=max(array_column(array_values($cluster_data[$premium_type[$k]]),'score_result'));

            
         }
         // if($index_id[0]==41)
         // {
         //     foreach ($value_result as $k => $v) 
         //    { 
         //        $size=round((50*($color_critiea[str_replace(" ","",$v['result'])]/100)),2);
         //        $color_=((float)$v['score_result']/(float)$cluster_data[$v['result']])*100;
     
         //        $split_order=CommonController::index_color_variaton($v['result']);

         //        $from50=$split_order['from_1'];
         //        $to50=$split_order['from_1'];
         //        $from100=$split_order['from_1'];
         //        $to100=$split_order['to_1'];  
         //        $color[$v['result']]  =$split_order['hex'];
         //       if($color_ < 50){
                
         //          $color_index= CommonController::Gradient($from50,$to50,50,abs($color_));
         //       }
         //       else{
                
                 
         //       }
         //        $color_index= CommonController::Gradient($from100,$to100,100,abs($color_));
         //    //  $color_index=$color[$v['result']];

         //        $temp['shareinfo']='Location: '.$detailed_result['maparray'][(string)$v['loc_id']]['location_name'].'; '.$detailed_result['menu_axis'].'(Score): '.number_format(round($v['score_result'],2),0).'; '.$detailed_result['menu_axis'].': '.$v['result'].';  ';
                          
         //        $info_text='<div class="container-fluid p-3 popupbox" id="ttpm" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h6 style="padding-top:0.3rem;max-width: 60%;">'.$detailed_result['maparray'][(string)$v['loc_id']]['location_name'].' &nbsp;</h6><div style="height:max-content;margin-right: -0.7rem;"><img class="ml-1"  src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$detailed_result['maparray'][(string)$v['loc_id']]['latitude'].'" lon="'.$detailed_result['maparray'][(string)$v['loc_id']]['longitude'].'" id="share_'.$v['loc_id'].'"><img class="ml-1" geocode="'.$detailed_result['maparray'][(string)$v['loc_id']]['latitude'].','.$detailed_result['maparray'][(string)$v['loc_id']]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" id="tcls" src="icons/close-icon.png" height="30px" id="'.$v['loc_id'].'" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:'.$color_index.';line-height:1rem;"> '.$v['result'].' </span></h5><div id="rem_lddis"><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$detailed_result['menu_axis'].'(Score) : </span>'. number_format(round($v['score_result'],2),0).$format['rangename'].' </p></div>';
         //        $temp=array('location_id'=>$v['loc_id'],'location_name'=>$detailed_result['maparray'][(string)$v['loc_id']]['location_name'],'result'=>$v['result'],'rank'=>'','color'=>$color_index,'info'=>$info_text,'size'=>$size); 

         //        $detailed_result['maparray'][(string)$v['loc_id']]=array_merge($detailed_result['maparray'][(string)$v['loc_id']],$temp);

         //        array_push($data['result'],$temp);
         //     }
         //     $legend='';
         //         $legend .='<div class="row" style="margin: 5px 2px; !important"><div class="legend_split" style="background-color:rgb(1, 135, 91);width:35px"></div><span> &nbsp;Snacking</span><br></div>'; 
         //           array_push($data['legend'],$legend);  
         // }
         if($index_id[0]==2 || $index_id[0]==1)
         {
            $index=[1=>'Premium Index',2=>'Snacking Index'];
            $color_index='#fff';
            
            foreach ($value_result as $k => $v) 
            { 
                $size=round((50*($color_critiea[str_replace(" ","",$v['result'])]/100)),2);
                $color_=((float)$v['score_result']/(float)$max_premium_type)*100;

                if($detailed_result['main_location']==16 || $detailed_result['sub_location']==16)
                {
                     $color_index=CommonController::index_color_variaton($v['result']);
                     $color[$v['result']]  =$color_index['hex'];
                     $color_index=$color_index['hex'];
                }
                else
                {
                      
                 
                   $split_order=array('hex'=>'#01875B','from_1'=>'rgb(228, 242, 231)','to_1'=>'rgb(0, 242, 43)','from_2'=>'rgb(0, 242, 43)','to_2'=>'rgb(1, 135, 91)');//green

                $from50=$split_order['from_1'];
                $to50=$split_order['to_1'];
                $from100=$split_order['from_2'];
                $to100=$split_order['to_2'];  
                 


                         if($color_ <= 50)
                            $color_index= CommonController::Gradient($from50,$to50,50,abs($color_));
                        if($color_>50)
                             $color_index= CommonController::Gradient($from100,$to100,100,abs($color_));

                }
     
                
              
              
            //  $color_index=$color[$v['result']];

                $temp['shareinfo']='Location: '.$detailed_result['maparray'][(string)$v['loc_id']]['location_name'].'; '.$detailed_result['menu_axis'].' (Score): '.number_format(round($v['score_result'],2),0).'; '.$detailed_result['menu_axis'].': '.$v['result'].';  ';
                          
                $info_text='<div class="container-fluid p-3 popupbox" id="ttpm" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h6 style="padding-top:0.3rem;max-width: 60%;">'.$detailed_result['maparray'][(string)$v['loc_id']]['location_name'].' &nbsp;</h6><div style="height:max-content;margin-right: -0.7rem;"><img class="ml-1"  src="icons/share-icon.png" height="30px" onclick="share(\''.htmlentities($temp['shareinfo']).'\',this)"  lat="'.$detailed_result['maparray'][(string)$v['loc_id']]['latitude'].'" lon="'.$detailed_result['maparray'][(string)$v['loc_id']]['longitude'].'" id="share_'.$v['loc_id'].'"><img class="ml-1" geocode="'.$detailed_result['maparray'][(string)$v['loc_id']]['latitude'].','.$detailed_result['maparray'][(string)$v['loc_id']]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" id="'.$v['loc_id'].'" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:'.$color_index.';line-height:1rem;"> '.$v['result'].' </span></h5><div id="rem_lddis"><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$detailed_result['menu_axis'].' (Score): </span>'. number_format(round($v['score_result'],2),0).$format['rangename'].'</p>';
            if($detailed_result['main_location']==12 && $detailed_result['sub_location']==15)
                $info_text .='<p><a href="#" onClick="show_info('.$v['loc_id'].','.$detailed_result['sub_location'].')"><button type="button" class="btn text-light mt-2" style="background:#0b4038">Show Info</button></a></p>';
                $info_text .='</div>';

                $temp=array('location_id'=>$v['loc_id'],'location_name'=>$detailed_result['maparray'][(string)$v['loc_id']]['location_name'],'result'=>$v['result'],'rank'=>'','color'=>$color_index,'info'=>$info_text,'size'=>$size); 

                $detailed_result['maparray'][(string)$v['loc_id']]=array_merge($detailed_result['maparray'][(string)$v['loc_id']],$temp);

                array_push($data['result'],$temp);
             }
             if($detailed_result['main_location']==16 || $detailed_result['sub_location']==16)
            {
                   $legend='';
                   foreach ($color as $key => $value) {
                      $legend .='<div class="row" style="margin: 5px 2px; !important"><div class="legend_split" style="background-color:'.$value.';width:35px"></div><span> &nbsp;'.$key.'</span><br></div>';
                       
                   }   
                   array_push($data['legend'],$legend);   
            }
            else
            {
                 $legend='';
                 $legend .='<div class="row" style="margin: 5px 2px; !important"><div class="legend_split" style="background-color:rgb(1, 135, 91);width:35px"></div><span> &nbsp;'.$index[$index_id[0]].'</span><br></div>'; 
                   array_push($data['legend'],$legend);  
            }
         }
        


       $data['mapdata']=$detailed_result['maparray'];
       $data['head']=$detailed_result['head'];
      

       /*        @Map Legend Processing          */

     //  $data['legend']='<div class="row"><div class="legend_split" style="background-color:'.$color[$key].';width:35px"></div><span> '.$split_master[$key].'</span></div>';

       // ksort($cluster_data);
       
      //$data['legend']=implode(",",$data['legend']);

       /*        @Chart Processing          */

       $data['griddata']=self::gettable($data['result'],$detailed_result,$additional_result,$format['chartsymbol']);
       
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