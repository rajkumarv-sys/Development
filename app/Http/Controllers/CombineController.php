<?php
namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 180);
use App\Models\MasterKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CommonController;
use App\User;
use DB;

class CombineController extends Controller
{
    public function index()
    {

        $stat = auth()->user()->status;
        $user = auth()->user();
        $userid = $user->id;
        $packageid = $user->package_id;
        $contents = Storage::get('client_menu/client_menu_' . $userid . '.json');

        if ($stat == 'Active')
        {
            return view('pages.dashboard', ['menulist' => $contents, 'package_id' => $packageid]);
        }
        else
        {
            return Redirect::to('/auth/login')->with('message', "Get approval from Admin Team from BrandIdea !!! Thank You");
        }

    }
    public function show()
    {

    }
    public function showlayerinfo($maparray,$type,$main_location,$sub_location,$so_id)
    {
        $data = [];
        $data['result'] = array();
        $data['mapdata'] = array();
        $user = auth()->user();
        $userid = $user->id;
        $key = array_keys($maparray);
        $value = array_values($maparray);

        $loc15 = array_unique(array_column($value, 'loc15'));
        $loc12 = array_unique(array_column($value, 'loc12'));


        $condition = [];
        $total_data_array = [];
        $covered_condition = [];
        $total_uncovered_data_array = [];
             
        $sql_covered="SELECT colony_id,user_id,status,modified_date FROM `salesman_covered_ward` where user_id in (".$userid.")";
        $covered_result = DB::select(DB::raw($sql_covered));

        $covered_details_array=[];

        for($i=0;$i<count($covered_result);$i++)
        {
             $temp=[];
             $temp['colony_id']=$covered_result[$i]->colony_id;
             $temp['user_id']=$covered_result[$i]->user_id;
             $temp['status']=$covered_result[$i]->status;
             $temp['modified_date']=$covered_result[$i]->modified_date;     
             $covered_details_array[$temp['colony_id']]=$temp;     

        }
        $getdetail=[];
        foreach ($maparray as $key => $value) {

            $pc_uid = DB::table('loclty_pc_link')->where('loc16', $value['loc_id'])->select(['pc_uid'])->first();
            $pc_uid=$pc_uid->pc_uid;
            if (!array_key_exists($pc_uid,$getdetail))
                $getdetail[$pc_uid]=CommonController::getreportee($pc_uid,$value['loc_id']);

            if(isset($covered_details_array[$key]))
            {
                $temp=[];$temp['color']='#ffffff';

               

                $temp['location_id']=$value['loc_id'];
                $temp['location_name']=$value['location_name'];
                $temp['status']=($covered_details_array[$key]['status'] ==1 ) ? 'Visited' : 'Not Visited';
                $temp['action_date']=$covered_details_array[$key]['modified_date'];
                $temp['color']=($covered_details_array[$key]['status'] ==1 ) ? '#DADD21' : '#DD7921';
                $temp['covered_stat']=($covered_details_array[$key]['status'] ==1 ) ? 'Visited' : 'Not Visited';
                $temp['loc12']=$value['loc12'];
                $temp['loc15']=$value['loc15'];
                $temp['pc_uid']=$pc_uid;
                $temp['so_id']=$getdetail[$pc_uid]['so_id'];
                $temp['asm_id']=$getdetail[$pc_uid]['asm_id'];
                $temp['bsm_id']=$getdetail[$pc_uid]['bsm_id'];
                $temp['pc_name']=$getdetail[$pc_uid]['pc_name'];
                $temp['so_name']=$getdetail[$pc_uid]['so_name'];
                $temp['asm_name']=$getdetail[$pc_uid]['asm_name'];
                $temp['bsm_name']=$getdetail[$pc_uid]['bsm_name'];
                

                //$info='<b>'.$value['location_name'].'</b><br>Status:'.$temp['covered_stat'].'<br>'.'Action Date: '.date('d-m-Y H:i a',strtotime($temp['action_date']));
                $info = "<div class='tooltip-data visited-tooltip'><div class='card'><div class='card-header'>". $value['location_name'] ."</div><ul class='list-group list-group-flush'><li class='list-group-item'>Status <span>" . $temp['covered_stat'] . "</span></li><li class='list-group-item'>Action Date <span> ".date('d M Y H:i A',strtotime($temp['action_date'])) . "</span></li></ul></div></div>";

                $temp['info']=$info;

               $maparray[$value['loc_id']] = array_merge($maparray[$value['loc_id']], $temp);

               array_push($data['result'], $temp);
               
            }
            else
            {
                $temp=[];$temp['color']='#ffffff';
                $temp['location_id']=$value['loc_id'];
                $temp['location_name']=$value['location_name'];
                $temp['status']= 'Not Visited';
                $temp['action_date']='';
                $temp['covered_stat']='Not Visited';
                $temp['color']= '#DD7921';
              //  $info='<b>'.$value['location_name'].'</b><br>Status:'.$temp['covered_stat'];
                 $info = "<div class='tooltip-data notvisited-tooltip'><div class='card'><div class='card-header'>". $value['location_name'] ."</div><ul class='list-group list-group-flush'><li class='list-group-item'>Status <span>" . $temp['covered_stat'] . "</span></li></ul></div></div>";
                $temp['info']=$info;
                $temp['loc12']=$value['loc12'];
                $temp['loc15']=$value['loc15'];
                $temp['pc_uid']=$pc_uid;
                $temp['so_id']=$getdetail[$pc_uid]['so_id'];
                $temp['asm_id']=$getdetail[$pc_uid]['asm_id'];
                $temp['bsm_id']=$getdetail[$pc_uid]['bsm_id'];
                $temp['pc_name']=$getdetail[$pc_uid]['pc_name'];
                $temp['so_name']=$getdetail[$pc_uid]['so_name'];
                $temp['asm_name']=$getdetail[$pc_uid]['asm_name'];
                $temp['bsm_name']=$getdetail[$pc_uid]['bsm_name'];
                
                $maparray[$value['loc_id']] = array_merge($maparray[$value['loc_id']], $temp);
                array_push($data['result'], $temp);
            }
        }

        $data['legend'] = [];
        //array_push($data['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
         array_push($data['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
        
        
        $data['mapdata'] = $maparray;
        $data['griddata'] = array();

        $data['griddata'] = $this->gridcolumn_bystatus($data['result'], $loc15, $loc12);

        $head = CommonController::headline($loc12);
        $data['head'] = $head;

        return $data;
    }
    public function biapp_activity($maparray,$type,$main_location,$sub_location,$input_obj,$current_location)
     {
        $final_result=[];
        $additional_result=[];
        $query=json_decode($input_obj,true);
       
        $menu_id=array_unique(array_column($query['menu_list'],'menu_id'));
        $level_id=array_unique(array_column($query['menu_list'],'level_id'));
         $parent_id=array_unique(array_column($query['menu_list'],'parent_id'));
          $view_optn=array_unique(array_column($query['menu_list'],'view_optn'));

         
        
        $sql=DB::table("bid_application_master.menu_object_master")->where([['refid','=',$menu_id[0]]])->first();
        $common=new CommonController();
        $common_result=$common->preaction_getdetails($query,$sql->table_name,$maparray);
         

         if($level_id[0]==1821 && (in_array($parent_id[0],[186,187])))
            return MdlzvsindexController::premium_sales($common_result,$maparray,$query);
        if($level_id[0]==1821 && (in_array($parent_id[0],[202])))
            return percaptiasalesController::percaptia($common_result,$maparray,$query);
        if($level_id[0]==1787)
            return PremiumindexController::premiumindex($common_result,$maparray,$query);
        if($level_id[0]==786)
            return SecController::sec($common_result,$maparray,$query);
        if($level_id[0]==983)
            return DealerperlacController::dealerperlac($common_result,$maparray,$query);
        if($level_id[0]==479)
           return ConsmptionController::consmption($common_result,$maparray,$query);
        if($level_id[0]==1821 || $level_id[0]==1829)
        {
            if($parent_id[0]==81)
                 return CategoryshareController::categoryshare($common_result,$maparray,$query);
             else if($parent_id[0]==82)
                 return Numeric_distribution_Controller::numeric_distribution($common_result,$maparray,$query);
             else if($parent_id[0]==113)
                 return Premium_sales_Controller::premium_sales($common_result,$maparray,$query);
              else if($parent_id[0]==126)
                 return Unique_linebiller_Controller::unique_line($common_result,$maparray,$query);
             else if($parent_id[0]==171 || $parent_id[0]==179)
                 return VisicoolerController::visicooler($common_result,$maparray,$query);
               else if($parent_id[0]==207)
                 return ReportController::mc_score($common_result,$maparray,$query);
             else if($parent_id[0]==215)
                 return ReportController::woa_score($common_result,$maparray,$query);
             else if($parent_id[0]==222)
                 return ReportController::store_penetration($common_result,$maparray,$query);
              else if($parent_id[0]==237)
                 return ReportController::vc_penetration($common_result,$maparray,$query);
              else if($parent_id[0]==242)
                 return ReportController::WD($common_result,$maparray,$query);
              else if($parent_id[0]==250)
                 return ReportController::PC_overall_target_achievement($common_result,$maparray,$query);
               else if($parent_id[0]==258)
                 return ReportController::pc_audit_store($common_result,$maparray,$query);
               else if($parent_id[0]==266)
                 return ReportController::overall_target_achievement($common_result,$maparray,$query);
               else if($parent_id[0]==274)
                 return ReportController::pc_woa($common_result,$maparray,$query);
        }
     }
      public function combine_consolidate_subrd($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {

        $tbllist='subrd_consolidation_data';
        $consmtp='Villg. Choc Consmptn';       
        $data = [];$getdetail=[];
        $color=['green','lavender','pink','orange','fgreen','chaani'];
        $user = auth()->user();
        $userid = $user->id;

        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
        $getfilter=json_decode($input_obj);
       
        $summary_count=[];
        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
        $summary_count['show_summary']=0;
        $summary_count['new_village_current']=0;
        $summary_count['new_village_recommand']=0;
       
        $orwhere=[];
        if(isset($getfilter->filter_byconsolidatedist) && count($getfilter->filter_byconsolidatedist)>0)
            array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_byconsolidatedist).")");
        if(isset($getfilter->filter_byconsolidatetaluk) && count($getfilter->filter_byconsolidatetaluk)>0)
            array_push($orwhere,"  a.taluk_census in (".implode(",",$getfilter->filter_byconsolidatetaluk).")");
       
        $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
       
   


 $sql="SELECT b.state_code, a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`,a.`proposed_subd_code`,a.proposed_subd_name, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale FROM ".$tbllist." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";


         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);
          
          $final_result=[];
          $inc=0;
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'district_name');
          $district_name=array_unique($district_name);
          $state_code=array_column($result,'state_code');
          $state_code=array_unique($state_code);
          $table_data=[];
          $priority=['Priority 1'=>'rural_icon/r_p1.png','Priority 2'=>'rural_icon/r_p2.png','Priority 3'=>'rural_icon/r_p3.png',''=>'rural_icon/recommendation.png'];
          $without_hub=$result;
          $non_cluster_color=[];
          $child_list=[];
          $type_view=[1];



         
         for($i=0;$i<count($result);$i++)
         {
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'],$type_view))
             {
                  
                  $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                  $final_result[$inc]['child']=[];
                  $filter_id=$result[$i]['cluster_id'];
                    $final_result[$inc]['subrd_marker']='rural_icon/efficient-subrd.png';
                                 
                  // $final_result[$inc]['subrd_marker']=($result[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($result[$i]['subrd_type']==2) ? $priority[$result[$i]['subrd_priority']] : (($result[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';
                    $hub_child_list = array_filter($result, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                   });
                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                   });

                              
                  $final_result[$inc]['child']=$hub_child_list; 
                  $res_arr=$result[$i];
                  $child_list[$filter_id]=$hub_child_list;

                  $res_arr['child']=htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                  $res_arr['child_count']=count($hub_child_list);
                    $res_arr['child_d']=$hub_child_list;
                  
                 $inc++;
                 array_push($table_data,$res_arr);
                }
                  
             }
             else if($result[$i]['subrd_type'] ==0 || !in_array($result[$i]['subrd_type'],$type_view))
             {
                $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                    $final_result[$inc]['child']=[];
                     $final_result[$inc]['child_d']=[];
                    $final_result[$inc]['subrd_marker']='NA';
                     $child_list[$result[$i]['cluster_id']]=[];
                    $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
             }
         }
         $without_hub=array_values($without_hub);
         $without_hub_count=count($without_hub);
      
         for($i=0;$i<$without_hub_count;$i++)
         {
      
              $without_hub[$i]['village_census']=ltrim($without_hub[$i]['village_census'], 0);

                if(isset($maparray[$without_hub[$i]['village_census']]))
                {
                    if($without_hub[$i]['subrd_type']==1 && $without_hub[$i]['active_stat'] =='N')
                        $summary_count['new_village_current']++;
                     if($without_hub[$i]['subrd_type']==2)
                        $summary_count['new_village_recommand']++;
                       
                     if(in_array($without_hub[$i]['subrd_type'],[1,2,3]))   
                     {
                        if(in_array($without_hub[$i]['subrd_type'],[2,3]) && in_array($without_hub[$i]['subrd_type'],$type_view))   
                            $summary_count['show_summary']=$without_hub[$i]['subrd_type']; 
                     
                        
                     }  
                       
                  
                    $final_result[$inc]=$without_hub[$i];
                    $final_result[$inc]['child']=[];
                    $final_result[$inc]['subrd_marker']= 'rural_icon/efficient-subrd.png';
                    // $final_result[$inc]['subrd_marker']=($without_hub[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($without_hub[$i]['subrd_type']==2) ? $priority[$without_hub[$i]['subrd_priority']] : (($without_hub[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$without_hub[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$without_hub[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
         }
      
         $result_count=count($final_result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            $temp=$final_result[$k];
           if($temp['subrd_type']==1 && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                if(($temp['subrd_type']==1) && $temp['is_hub']==1)
               {
                  $range=array_rand(range(0,(count($color)-1)));
                  $split_color=$color[$range];
               }

            }
           

           else if($temp['subrd_type']==0)
              $split_color='none';
           else
              $split_color='none';
            // if(in_array($temp['subrd_type'],[2,3]) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            // {
            //     $summary_count['total_village']++;   
            //     if( $summary_count['show_summary']=='')           
            //     $summary_count['show_summary']=$temp['subrd_type'];
            // }

            unset($temp['child']);
           //  var_dump($temp);die;
             
            // if($temp['is_hub'] != 1 && $temp['subrd_type']==1)
            //  {

            //     $hub='#ffffff';$child='';
                
              
                  
            //      if($temp['exist_subrd_code'] != '' )
            //      {
            //         echo 'test';die;
            //          if($temp['exist_subrd_code']!=$temp['proposed_subd_code'])
            //             $hub='red';
            //          else
            //             $hub='grey';
            //      }  
            //      else
            //      {
            //          $range=array_rand(range(0,(count($color)-1)));
            //          $split_color=$color[$range];
            //          $hub= CommonController::getcolor_bysubrd('l_'.$split_color); 
            //          $non_cluster_color[$temp['cluster_name']]=$split_color; 
            //      }             
                 
              
                
            //  }             
            //   else
                 $hub= CommonController::getcolor_bysubrd('d_'.$split_color); 
             $label='';
             $legend="";
             $temp['color']=$hub; 

              // $cluster_type=(isset($subrd_name[$user->client_id])) ? $subrd_name[$user->client_id][0] : $final_result[$k]['subrd_loaction'];
              // if($user->client_id==1000)
               $cluster_type=$final_result[$k]['subrd_loaction'];
             
             $final_result[$k]['activate_status']=$final_result[$k]['company_service_id'];
             $cluster_tag=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'SubRD Existing' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommended' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $cluster_hub=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existing SubRD' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommd SubRD' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $temp['activate_marker']=($final_result[$k]['company_service_id']==1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($final_result[$k]['company_service_id']==4) ? 'rural_icon/activated.png' :(($final_result[$k]['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             if($temp['is_hub']!=0)
            {
                $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
                $temp['subrd_marker']='rural_icon/efficient-subrd.png';
               // $temp['subrd_marker']=(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? $priority[$final_result[$k]['subrd_priority']] :   (($final_result[$k]['subrd_type']==1 && $temp['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/urban-distributor.png' :  (($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/efficient-subrd.png' : (($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/Wholesale.png' : ''))));
             $temp['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$final_result[$k]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$cluster_tag.'</li></ul> </div></div></div>';
            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['subrd_marker']='NA';             
                 $temp['subrd_tooltip']='';
            }


             // 
if($final_result[$k]['subrd_type']!=0 && in_array($final_result[$k]['subrd_type'],$type_view))
{
$temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.; '.$consmtp.' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].';SubRD Priority: '.$final_result[$k]['subrd_priority'].'; SubRD Cluster Priority: '.$final_result[$k]['subrd_priority'].'; ';

 // $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? number_format($final_result[$k]['village_choc_consmptn'],0) : $final_result[$k]['village_choc_consmptn'];
$final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? $final_result[$k]['village_choc_consmptn'] : 0;
 $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);


            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendatn:</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$final_result[$k]['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from '.$cluster_hub.' (km): </span>0 kms</p>';
          
            $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
           if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
            $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';

           if($final_result[$k]['subrd_type']==1 &&  $user->client_id==120)
              $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">MDLZ Cvrg Nos: </span>'.$final_result[$k]['mdlz_retlr_universe'].' Nos.</p>';
           if($user->client_id!=1000)
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp.' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
            if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp.' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
         
            $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
           
            

             if(in_array($final_result[$k]['subrd_type'],[2,3]) &&  $user->client_id==120)
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$final_result[$k]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$final_result[$k]['subrd_priority'].'</p>';
          if(in_array($final_result[$k]['subrd_type'],[1]) &&  $user->client_id==120)
              $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Census: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
          
          if($user->client_id==120)
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p>';
         if($user->client_id!=120)
         {
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
             if(in_array($final_result[$k]['subrd_type'],[1]))
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Census: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
         }

            $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
            $final_result[$k]['cluster_type']=$cluster_type;
$detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
             $temp['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';
       
            
}
 else
             {
                $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
$final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);
 $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].'; ';
                 $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
          if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
                 $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;"> '.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
            if($user->client_id!=1000)
                 $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;"> '.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
                
               
          $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
          $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index2: </span><span>'.$rural_img.'</span></p>';
       if($user->client_id==120)
         $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p>';
        if($user->client_id!=120)            
          $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
       
           // $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
           // $final_result[$k]['village_choc_consmptn']=number_format($final_result[$k]['village_choc_consmptn'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
          $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

             $temp['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';  
             }
              if($user->client_id==133)
         {
             $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
             $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
            $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>
<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index3: </span><span >'.$rural_img.'</span></p><div ></div></div>';
         }
             $temp['size']=15;
             $temp['activate_status_icon']=$temp['activate_marker'];
             $temp['activate_status']=$final_result[$k]['activate_status'];
            
            $maparray[$final_result[$k]['village_census']]=array_merge($maparray[$final_result[$k]['village_census']],$temp);

            $temp2=[];
            
            foreach($final_result[$k]['child'] as $key=>$value)
            {

                 $temp2=$value;
                 if($value['subrd_type']==1 && $value['active_stat'] =='No')
                    $summary_count['new_village_current']++;
                 if($value['subrd_type']==2)
                    $summary_count['new_village_recommand']++;
                 if(in_array($value['subrd_type'],[2,3])){
                     $summary_count['new_village']++;

                   if(isset($summary_count[$value['rpi']]))
                            $summary_count[$value['rpi']]++;
                 }
                    //$temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
               
                    if($value['exist_subrd_code'] != '')
                    {
                         if($value['exist_subrd_code']!=$value['proposed_subd_code'])
                         {
                             $temp2['color']='#9d9a98';

                         }
                         else
                            $temp2['color']= 'yellow';
                        $temp['subrd_marker']='rural_icon/efficient-subrd.png';
                    }
                    else
                    {
                         $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                         $temp2['subrd_marker']='NA';
                         $value['exist_subrd_code']= $value['proposed_subd_code'];  
                         $value['exist_subrd_name']= $value['proposed_subd_name'];              
                              
                    }
             
                 // else                 
                 //    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                
                 // $cluster_type=(isset($subrd_name[$user->client_id])) ? $subrd_name[$user->client_id][1] : $value['subrd_loaction'];
                 $cluster_type=$value['subrd_loaction'];
                 $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommended' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($value['subrd_type']==1) ? 'Existing SubRD' :(($value['subrd_type']==2) ? 'Recommd SubRD' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                   $value['village_census']=ltrim($value['village_census'], 0);
                  if(isset($maparray[$value['village_census']]))
                {
                   
                    $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ?  $value['village_choc_consmptn'] : 0;
                     $value['village_choc_consmptn']=is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$value['village_choc_consmptn']),0);
                     $value['cluster_type']=$cluster_type;
$temp2['shareinfo']='Village: '.$value['village_name'].'; Taluk: '.$value['taluk_name'].'; Distt: '.$value['district_name'].'; State: '.$value['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$value['population'].' Nos.; Rural Progressive Index: '.$value['rpi'].'; Outlet Potential: '.$value['outlet_potential'].' Nos.;  '.$consmtp.' (Annual) (Rs.): '.$value['village_choc_consmptn'].'; Market UID: '.$value['market_id'].'; BI Location ID: '.$value['bi_id'].';SubRD Priority: '.$value['subrd_priority'].'; SubRD Cluster Priority: '.$value['subrd_priority'].'; ';

                       $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendatn:</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$value['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from  '.$cluster_hub.' (km): </span>'.$value['distance_subrd'].' kms</p>';
            if($user->client_id==1000 && $value['sector']=='Rural')
                $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p>';
        if($user->client_id!=1000)
            $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p>';

       if($value['subrd_type']==1 &&  $user->client_id==120)
               $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">MDLZ Cvrg Nos: </span>'.$value['mdlz_retlr_universe'].' Nos.</p>';
             if($user->client_id==1000 && $value['sector']=='Rural')          
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp.' (Annual) (Rs.): </span>'.$value['village_choc_consmptn'].' </p>';
             if($user->client_id!=1000)
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp.' (Annual) (Rs.): </span>'.$value['village_choc_consmptn'].' </p>';
                  
                $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';

           if(in_array($value['subrd_type'],[2,3]) && $user->client_id==120)                
             $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$value['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$value['subrd_priority'].'</p>';
          if($user->client_id==120)
             $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$value['market_id'].'</span></p>';
         if(in_array($value['subrd_type'],[1]) && $user->client_id==120)  
              $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Census: </span><span style="background-color:white;color:black;" >'. $value['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($value['exist_subrd_name'])).' </span></p>';
            if($user->client_id!=120)
            {
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$value['bi_id'].' </span></p>';
              if(in_array($value['subrd_type'],[1]))
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Census: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
            }
          
            
           $value['population']= number_format($value['population'],0);
            $value['village_name']=$maparray[$value['village_census']]['location_name'];
            $child_val=[0=>$value];
                  $value_json=htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
             $temp2['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$value_json.')">More Info</span></div></div>';
             if($user->client_id==133)
             {
                  $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                 $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.$value['population'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><div ></div></div>'; 
             }
             $value['activate_status']=$value['company_service_id'];
             $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
             $value['activate_marker']=($value['company_service_id']==1) ? 'rural_icon/active.png' : (($value['company_service_id']==2) ? 'rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'rural_icon/activated.png' :(($value['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             $temp2['size']=8;
             $temp2['activate_status_icon']=$value['activate_marker'];
             $temp2['activate_status']=$value['activate_status'];
             $temp2['subrd_status']=0;

             $temp2['subrd_tooltip']='';
             // $temp2['village_census']=ltrim($value['village_census'],0);
           
            $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                }

             

            }
         
         }

        $data['legend']=[];
        $data['legend'][0] = $summary_count;
      
        $data['griddata'] = $this->getsubrd($table_data,1);
        $data['child_list']=$child_list;
        $data['mapdata'] = $maparray;
        if(isset($getfilter->filter_byconsolidatetaluk) && count($getfilter->filter_byconsolidatetaluk)>0)
            $data['head']=implode(", ", $taluk_name). ' sub-distt, '.implode(", ", $district_name);
        else if(isset($getfilter->filter_byconsolidatedist) && count($getfilter->filter_byconsolidatedist)>0)
             $data['head']=implode(", ", $district_name). ' distt, '.implode(", ", $state_code);
         else
             $data['head']='';

        return $data;

    }
    public function show_outletlist_bycategory($maparray,$type,$main_location,$sub_location,$so_id,$input_obj,$current_location)
    {


        $data = [];
        $data['result'] = array();      
        $data['channel_list'] = array();    
        $user = auth()->user();
        $userid = $user->id;   
        $key = array_keys($maparray);
        $value = array_values($maparray);
        $loc15 = array_unique(array_column($value, 'loc15'));
        $loc12 = array_unique(array_column($value, 'loc12')); 
        $condionarr=array('key'=>array(),'value'=>array(),'icon'=>array());
        $condionarr['key'][5]=[29,30,224,228];         
        $condionarr['key'][6]=[43,181];
        $condionarr['key'][7]=[203,16,17];


        $user = auth()->user();
        $userid=$user->id;
        $obj=json_decode($input_obj,true);


        if($type==9)
        {
           
            $lat=$current_location[0];
            $lon=$current_location[1];
            $data_outlet_list=[];
            $data_uncovered_outlet_list=[];
             $user = auth()->user();
          $client_id=$user->client_id;
          $feedback_question=[];

          $get_headline= DB::table('question_type')->where([['client_id','=', $client_id],['stat','=', 'A']])->get();
          $get_headline_count=count($get_headline);
          for($i=0;$i<$get_headline_count;$i++)
          {
             $feedback_question[$get_headline[$i]->refid]=['title'=>[$get_headline[$i]->question_type],'question'=>[]];
             $feedback_question_sl=DB::table('feedback_question')->where([['question_type','=', $get_headline[$i]->refid],['client_id','=', $client_id],['stat','=', 'A']])->get();
            $feed_question_count=count($feedback_question_sl);
             for($j=0;$j<$feed_question_count;$j++)
             {
                $temp=[];
                $temp['refid']=$feedback_question_sl[$j]->refid;
                $temp['question']=$feedback_question_sl[$j]->question;
                $temp['option_1']=$feedback_question_sl[$j]->option_1;
                $temp['option_2']=$feedback_question_sl[$j]->option_2;
                $temp['option_3']=$feedback_question_sl[$j]->option_3;
                $temp['option_4']=$feedback_question_sl[$j]->option_4;
                $temp['parent']=$feedback_question_sl[$j]->parent;
                $temp['type']=$feedback_question_sl[$j]->type;

                array_push($feedback_question[$get_headline[$i]->refid]['question'],$temp);
             }
          }


            $data_outlet_list =  DB::table('covered_outlets')
            ->join('beat_master', 'covered_outlets.beat_id', '=', 'beat_master.id')
            ->whereIn('covered_outlets.salesman_id',[$userid]);
            if(isset($obj['filter_beat']) && count($obj['filter_beat'])>0)
              $data_outlet_list->whereIn('covered_outlets.beat_id',$obj['filter_beat']);
             if(isset($obj['show_beat']) && $obj['show_beat']!='')
              $data_outlet_list->whereIn('covered_outlets.beat_id',[$obj['show_beat']]);


            $data_outlet_list->select('covered_outlets.id as refid'  , 'covered_outlets.channel as channel', 'covered_outlets.secondary_channel_type as subchannel', 'covered_outlets.name as outlet_name', 'covered_outlets.address as address', 'covered_outlets.latitude as lat', 'covered_outlets.longitude as lon','beat_master.beat_name','beat_master.id as beat_id');

            $data_outlet_list=$data_outlet_list->get();


            $filterchannel='';$filterpotential='';$filter_beat='';$show_beat=''; $status_outlet='';
           //  if(isset($obj['filter_bychannel']) && $obj['filter_bychannel']!='' && $obj['filter_bychannel']!=0 && count($obj['filter_bychannel'])>0)
           //    $filterchannel=' and maintype_id in ('.implode(",",$obj['filter_bychannel']).')';
           // // if(isset($obj['filter_bypotential']) && $obj['filter_bypotential']!='' && $obj['filter_bypotential']!=0)
           // //    $filterpotential=' and fld1923 in ('.implode(",",$obj['filter_bypotential']).')'; //fld1923
           //  if(isset($obj['filter_beat'])  && count($obj['filter_beat']) > 0)
           //    $filter_beat=' and beat_id in ('.implode(",",$obj['filter_beat']).')';
           //   if(isset($obj['show_beat']) && $obj['show_beat']!='')
           //    $show_beat=' and beat_id in ('.$obj['show_beat'].')';

           //   if(isset($obj['filter_bystatus']) && (count($obj['filter_bystatus']) > 0))
           //   {
           //      $temp='(';
           //      foreach ($obj['filter_bystatus'] as $key => $value) {
           //        $temp .= '"'.$value.'",';
           //      }
           //      $temp=trim($temp,",");
           //      $temp=$temp.")";
           //      $status_outlet=" and a.status in $temp ";
           //   }

            


            $data_uncovered_outlet_list = "SELECT a.refid,rtlr_id,main_type as channel,SubType as subchannel,ccp as outlet_name,address as address,latitude as lat,longitude as lon,status,if(a.fld1923=3,c.high,if(a.fld1923=2,c.medium,if(a.fld1923=1 ,c.low,c.icon))) as maintype_icon,maintype_id,if(a.potential_store=1,'Low',if(a.potential_store=2,'Medium',if((a.potential_store=3 || a.potential_store=4),'High',''))) as feed_potential_status,if(a.fld1923=3,'High',if(a.fld1923=2,'Medium',if(a.fld1923=1,'Low',''))) as potential_status, c.shop_image,(((acos(sin((".$lat."*pi()/180)) * sin((`latitude`*pi()/180)) + cos((".$lat."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$lon."- `longitude`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance,b.beat_name,b.id as beat_id  FROM uncovered_outlets as a,uncovered_user as bb,beat_master as b, hul_alsi_maintype_master as c   where a.stat='A' and a.rtlr_id=bb.uncovered_id  and a.beat_id=b.id and a.maintype_id=c.refid  and latitude!='' and latitude!=0 ".$filterchannel." ".$filterpotential." ".$filter_beat." ".$show_beat." ".$status_outlet."order by distance asc";
       // echo $data_uncovered_outlet_list;die;
          $data_uncovered_outlet_list = DB::select(DB::raw($data_uncovered_outlet_list));


           $uncovered_outlet_details="SELECT a.* FROM `uncovered_outlet_feedback` as a,uncovered_outlets as b  where a.outlet_id=b.refid and b.rtlr_id in (select uncovered_id from uncovered_user where user_id='".$userid."')";
          //$uncovered_outlet_details="select a.*,b.potention from (SELECT * FROM `uncovered_outlet_feedback` where outlet_id in (select uncovered_id from uncovered_user where user_id='".$userid."')) as a ,(SELECT sum(ifnull(ans,0)) as potention,outlet_id,user_id FROM `uncovered_outlet_feedback` where outlet_id in (select uncovered_id from uncovered_user where user_id='".$userid."') and question=5 group by question) as b where a.outlet_id=b.outlet_id and a.user_id=b.user_id";
          $uncovered_outlet_details_list = DB::select(DB::raw($uncovered_outlet_details));    
          $uncovered_info=[];
          for($i=0;$i<count($uncovered_outlet_details_list);$i++)
          {
            if(!array_key_exists($uncovered_outlet_details_list[$i]->outlet_id, $uncovered_info))
              $uncovered_info[$uncovered_outlet_details_list[$i]->outlet_id]=[];

            $uncovered_info[$uncovered_outlet_details_list[$i]->outlet_id][$uncovered_outlet_details_list[$i]->question]=$uncovered_outlet_details_list[$i];
          


             // array_push($uncovered_info[$uncovered_outlet_details_list[$i]->outlet_id],$uncovered_outlet_details_list[$i]);
          }

          $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          
           if(isset($obj['outlet_type']))
          {
             if(!in_array(1, $obj['outlet_type']))
                  $data_outlet_list=[];
             if(!in_array(2, $obj['outlet_type']))
                 $data_uncovered_outlet_list=[];

          }
         



           //   $data_uncovered_outlet_list =  DB::table('uncovered_outlets')->whereIn('salesman_id',[$userid])             
           // ->select('refid'  , 'rtlr_id', 'main_type as channel','maintype_id', 'SubType as subchannel', 'ccp as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','status','maintype_icon','maintype_id');
           // if(isset($obj['filter_bychannel']) && $obj['filter_bychannel']!='' && $obj['filter_bychannel']!=0)
           //   $data_uncovered_outlet_list->whereIn('maintype_id',[$obj['filter_bychannel']]);
           // if(isset($obj['filter_bypotential']) && $obj['filter_bypotential']!=''  && $obj['filter_bypotential']!=0)
           //   $data_uncovered_outlet_list->whereIn('Estimtd_potntl',[$obj['filter_bypotential']]);
           

           //  $data_uncovered_outlet_list = $data_uncovered_outlet_list->get();

        }
        else if($type==10)
        {
            

           //  $data_outlet_list =  DB::table('uncovered_outlets')            
           // ->select('fld580 as refid'  , 'fld1054', 'name as channel', 'name as subchannel', 'name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image')
           //  ->get();
               $data_outlet_list =  DB::table('uncovered_outlets')->whereIn('salesman_id',[$userid])         
           ->select('refid'  , 'rtlr_id', 'main_type as channel','main_type_id',  'subtype as subchannel', 'ccp as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','status','maintype_icon','maintype_id')
            ->get();
        }
      
       else if($type ==8)
       {
          $data_outlet_list =  DB::table('ref_nungambakkam')  
           ->whereIn('loc15',[1300105,1300106]) 
           ->select('fld580 as refid'  , 'fld1054', 'type as channel', 'subtype as subchannel', 'loc16', 'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image')
            ->get();
       }
        else if($type==11)
       {

             $user = auth()->user();
             $userid=$user->id;
             // $data_outlet_list =  DB::table('ref_24sep2021')      
             // // ->where([['status_1','=','A'],['status','=','N']])     
             //  ->select('refid'  ,  'type as channel', 'subtype as subchannel', 'loc16', 'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status')
             //  ->get();
        if($user->client_id==100000)
        {
          if(isset($obj['filter_beat'])  && count($obj['filter_beat']) > 0)
              $filter_beat=$obj['filter_beat'];
            else
              $filter_beat=[];
           // $data_outlet_list =  DB::table('ref_08oct2021')   
           //  ->where([['user_id','=',$userid]]) 
           //   ->whereIn('beat_id',$filter_beat)  
           //   //  ->where([['status_1','=','C'],['status','=','N']])  
           //   // ->whereIn('fld1054',$condionarr['key'][$type])
           //    ->select('refid'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','potential_status','perimium')
           //    ->get();
               $data_outlet_list =  DB::table('whole')   
            ->where([['user_id','=',$userid]]) 
             ->whereIn('beat_id',$filter_beat)  
             //  ->where([['status_1','=','C'],['status','=','N']])  
             // ->whereIn('fld1054',$condionarr['key'][$type])
              ->select('refid'  ,'type as channel' ,  'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','stock_confectionary','stock_chocolate')
              ->get();
              //var_dump($data_outlet_list);
              $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

               $imagelist=[];$imagename=[];
               $c=count($data_outlet_imagelist);
              for($i=0;$i<$c;$i++)
              {
                 $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
                 $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
              }

        }
         if($user->client_id==86 || $user->client_id==120 || $user->client_id == 115 || $user->client_id == 123 || $user->client_id == 1 || $user->client_id == 0 || $user->client_id == 1000 || $user->client_id == 133)
        {
           
          if(isset($obj['filter_beat'])  && count($obj['filter_beat']) > 0)
              $filter_beat=$obj['filter_beat'];
            else
              $filter_beat=[];
          if(isset($obj['filter_bychannel'])  && count($obj['filter_bychannel']) > 0)
              $filter_bychannel=$obj['filter_bychannel'];
            else
              $filter_bychannel=[];
          if(isset($obj['filter_bysubchannel'])  && count($obj['filter_bysubchannel']) > 0)
              $filter_bysubchannel=$obj['filter_bysubchannel'];
            else
              $filter_bysubchannel=[];
          if(isset($obj['filter_bypotential'])  && count($obj['filter_bypotential']) > 0)
              $filter_bypotential=$obj['filter_bypotential'];
            else
              $filter_bypotential=[];
           if(isset($obj['filter_bystatus'])  && count($obj['filter_bystatus']) > 0)
              $filter_bystatus=$obj['filter_bystatus'];
            else
              $filter_bystatus=[];
           if(isset($obj['filter_bycluster'])  && count($obj['filter_bycluster']) > 0)
              $filter_bycluster=$obj['filter_bycluster'];
            else
              $filter_bycluster=[];
           // $data_outlet_list =  DB::table('ref_08oct2021')   
           //  ->where([['user_id','=',$userid]]) 
           //   ->whereIn('beat_id',$filter_beat)  
           //   //  ->where([['status_1','=','C'],['status','=','N']])  
           //   // ->whereIn('fld1054',$condionarr['key'][$type])
           //    ->select('refid'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','potential_status','perimium')
           //    ->get();
                if($user->client_id == 86 || $user->client_id == 120)
                    $tbl='nestle';
                else if($user->client_id==115)
                    $tbl='pedilite';
                 else if($user->client_id==1)
                    $tbl='whole_saler_data';
                else if($user->client_id==123)
                    $tbl='perfetti_whole';
                else if($user->client_id==0)
                    $tbl='anderi_west_retlrs_saloon_data';
                else if($user->client_id==1000)
                    $tbl='haldirams_sample_data';
                 else if($user->client_id==133)
                    $tbl='pepsi_uncovered_outlets_unnao';
            if($user->client_id==133)

                $data_outlet_list =  DB::table($tbl)   
            ->where([['user_id','=',$userid],['stat','=','A']]) 
             ->whereIn('city_id',[460]);
            else
                $data_outlet_list =  DB::table($tbl)   
            ->where([['user_id','=',$userid],['stat','=','A']]) 
             ->whereIn('beat_id',$filter_beat);

             // var_dump($filter_bychannel);die;
              if(count($filter_bypotential) > 0 && $user->client_id!=115 && $user->client_id!=1)
                $data_outlet_list=$data_outlet_list->whereIn('fld1923',$filter_bypotential);
             
             if(count($filter_bychannel) > 0)
              $data_outlet_list=$data_outlet_list->whereIn('type',$filter_bychannel);
           if(count($filter_bysubchannel) > 0)
              $data_outlet_list=$data_outlet_list->whereIn('sub_type',$filter_bysubchannel);
            if(count($filter_bystatus) > 0)
              $data_outlet_list=$data_outlet_list->whereIn('status',$filter_bystatus);
            if(count($filter_bycluster) > 0 && $user->client_id!=115 && $user->client_id!=1)
              $data_outlet_list=$data_outlet_list->whereIn('cluster_id',$filter_bycluster);

             //  ->where([['status_1','=','C'],['status','=','N']])  
             // ->whereIn('fld1054',$condionarr['key'][$type])
      
           if((isset($obj['show_cluster']) && $obj['show_cluster'] == 'false') || $user->client_id==115 || $user->client_id==123 || $user->client_id==1 || $user->client_id==1000 || $user->client_id==133  || $user->client_id==0)
           {


            if(isset($obj['filter_datatype']) && $obj['filter_datatype']!='')
                $data_outlet_list=$data_outlet_list->where([['data_type','=',$obj['filter_datatype']]]);
            if($user->client_id==133)
            {
                $data_outlet_list=$data_outlet_list->select('refid'  ,'retailer_id as outlet_id','type as channel' ,'sub_type as subchannel' , 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','stock_confectionary','stock_chocolate','fld1923 
                as potential_status','nbrhd_name as nbhrd','potential_status as predict_potential','cluster_id','nbrhd_name as pincode','retailer_name','contact_no','remark','retailer_id','locality_name','city','sector','state_name','district_name','sub_district_name')
              ->where([['status','!=','D']]); 
        
             $data_outlet_list=$data_outlet_list->get();
            }
                
            else
                $data_outlet_list=$data_outlet_list->select('refid'  ,'type as channel' ,  'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','stock_confectionary','stock_chocolate','fld1923 
                as potential_status','nbrhd_name as nbhrd','potential_status as predict_potential','cluster_id','nbrhd_name as pincode','retailer_name','contact_no','remark')
              ->where([['status','!=','D']])  
              ->get();

            
           }
           else
           {
            $data_outlet_list=$data_outlet_list->select('refid'  ,'type as channel' ,  'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','stock_confectionary','stock_chocolate','fld1923 
                as potential_status','potential_status as predict_potential','cluster_id','nbrhd_name as pincode','retailer_name','contact_no','remark')
              ->where([['status','!=','D'],['cluster_id','!=','']])
              ->get();
           }
              
              
              $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

               $imagelist=[];$imagename=[];
               $c=count($data_outlet_imagelist);
              for($i=0;$i<$c;$i++)
              {
                 $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
                 $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
              }

        }
        else if($user->client_id!=2)
          {
            

             $data_outlet_list =  DB::table('alwarpet_uncvrd');     
              // ->where([['user_id','=',$userid]]) 
            
              $data_outlet_list->select('refid','refid as outlet_id'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status')->get();
          }          
          else
          {
            if(isset($obj['filter_beat'])  && count($obj['filter_beat']) > 0)
              $filter_beat=$obj['filter_beat'];
            else
              $filter_beat=[];

            $data_outlet_list =  DB::table('pg_mumbai_uncvrd_3ward')     
              // ->where([['user_id','=',$userid]])  
             // ->whereIn('fld1054',$condionarr['key'][$type])
            
              ->whereIn('beat_id',$filter_beat)

              ->select('refid','refid as outlet_id'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status')->get();
          }
                
        
       }
       
       else
       {


           
        
            $data_outlet_list =  DB::table('ref_08oct2021')   
            ->where([['user_id','=',$userid]])   
             //  ->where([['status_1','=','C'],['status','=','N']])  
             // ->whereIn('fld1054',$condionarr['key'][$type])
              ->select('refid'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status')
              ->get();
       }
       
       $cluster=[]; $heading=[];$clusterlist=[];
        for($i=0;$i<count($data_outlet_list);$i++)        
        {
             $potential=[''=>'',0=>'',1=>'Low',2=>'Medium',3=>'High'];
             $perimium=[0=>'',1=>'Yes',2=>'No'];
              
             if($user->client_id!= 115 && $user->client_id!= 1 && $user->client_id!=123 && $user->client_id!=1000 && $user->client_id!=133 && $user->client_id!=0){
               if(!in_array($data_outlet_list[$i]->pincode,$heading))           
                       array_push($heading,$data_outlet_list[$i]->pincode);
             if(isset($data_outlet_list[$i]->cluster_id))
             {
                if(array_key_exists($data_outlet_list[$i]->cluster_id, $cluster))
               {
                   $cluster[$data_outlet_list[$i]->cluster_id][$potential[$data_outlet_list[$i]->potential_status]]++;
                   $cluster[$data_outlet_list[$i]->cluster_id]['total']++;
               }
               else
               {
                    $cluster[$data_outlet_list[$i]->cluster_id]=[];
                    if($data_outlet_list[$i]->cluster_id==0)
                        $cluster[$data_outlet_list[$i]->cluster_id]['name']='High Potential - Non-Cluster Outlets';
                    else
                         $cluster[$data_outlet_list[$i]->cluster_id]['name']='Cluster '.$data_outlet_list[$i]->cluster_id;
                    $cluster[$data_outlet_list[$i]->cluster_id]['refid']=$data_outlet_list[$i]->cluster_id;
                    $cluster[$data_outlet_list[$i]->cluster_id]['High']=0;
                    $cluster[$data_outlet_list[$i]->cluster_id]['Low']=0;
                    $cluster[$data_outlet_list[$i]->cluster_id]['Medium']=0;
                    $cluster[$data_outlet_list[$i]->cluster_id]['total']=0;
                    $cluster[$data_outlet_list[$i]->cluster_id][$potential[$data_outlet_list[$i]->potential_status]]++;
                    $cluster[$data_outlet_list[$i]->cluster_id]['total']++;


               }
             }
         }
              $temp=[];
             
             $temp['refid']=$data_outlet_list[$i]->refid;
             $temp['outlet_name']=$data_outlet_list[$i]->outlet_name;            
             $temp['channel_name']= (isset($data_outlet_list[$i]->channel)) ? $data_outlet_list[$i]->channel : '';
             $temp['sub_channel_name']= (isset($data_outlet_list[$i]->subchannel)) ? $data_outlet_list[$i]->subchannel : '';
            $temp['retailer_id']= (isset($data_outlet_list[$i]->retailer_id)) ? $data_outlet_list[$i]->retailer_id : '';
            $temp['city']= (isset($data_outlet_list[$i]->city)) ? $data_outlet_list[$i]->city : '';
             $temp['nbhrd']= (isset($data_outlet_list[$i]->nbhrd)) ? $data_outlet_list[$i]->nbhrd : '';
            if($user->client_id==133)
            {
                if($data_outlet_list[$i]->sector==1)
                {

                 $temp['order_3']=$data_outlet_list[$i]->sub_district_name .' Taluk';
                 $temp['order_2']=$data_outlet_list[$i]->district_name.' District';
                 $temp['order_1']=$data_outlet_list[$i]->city. ' Village';
                }
                if($data_outlet_list[$i]->sector==2)
                {

                 $temp['order_1']=$data_outlet_list[$i]->locality_name .' Locality';
                 $temp['order_2']=$data_outlet_list[$i]->nbhrd.' Neighborhood';
                 $temp['order_3']=$data_outlet_list[$i]->city. ' City';
                }
            }
            
            $temp['locality_name']= (isset($data_outlet_list[$i]->locality_name)) ? $data_outlet_list[$i]->locality_name : '';
            $temp['sub_channel_name']= (isset($data_outlet_list[$i]->subchannel)) ? $data_outlet_list[$i]->subchannel : '';

             $temp['address']=ucwords(strtolower($data_outlet_list[$i]->address));
               $temp['retailer_name']=(isset($data_outlet_list[$i]->retailer_name)) ? ucwords(strtolower($data_outlet_list[$i]->retailer_name)) : '';
             $temp['contact_no']=(isset($data_outlet_list[$i]->contact_no)) ? ucwords(strtolower($data_outlet_list[$i]->contact_no)) : '';
              $temp['remark']=(isset($data_outlet_list[$i]->remark)) ? ucwords(strtolower($data_outlet_list[$i]->remark)) : '';
             $temp['status']=(isset($data_outlet_list[$i]->status)) ? $data_outlet_list[$i]->status : '';
              if(isset($data_outlet_list[$i]->nbhrd))
                 if(!in_array($data_outlet_list[$i]->nbhrd,$clusterlist))
                        array_push($clusterlist,$data_outlet_list[$i]->nbhrd);
              if(!in_array($user->client_id,[115,123]))
              {
             if(isset($data_outlet_list[$i]->potential_status))
             {
              $temp['potential_status']=(isset($data_outlet_list[$i]->potential_status)) ? $data_outlet_list[$i]->potential_status : '';   
              $temp['predict_potential']=(isset($data_outlet_list[$i]->predict_potential)) ? $data_outlet_list[$i]->predict_potential : '';  

               $temp['potential_status_name']=(isset($data_outlet_list[$i]->potential_status)) ? $potential[$data_outlet_list[$i]->potential_status] : '';
               $temp['perimium']=(isset($data_outlet_list[$i]->perimium)) ? $data_outlet_list[$i]->perimium : '';
               $temp['perimium_name']=(isset($data_outlet_list[$i]->perimium)) ? $perimium[$data_outlet_list[$i]->perimium] : '';
            
             }

              if((isset($obj['filter_bycluster'])  && count($obj['filter_bycluster']) >0) || (isset($obj['show_cluster']) && $obj['show_cluster'] == 'false'))
                $temp['cluster']=false;
              else
                $temp['cluster']=true;

                if((isset($obj['filter_bycluster'])  && count($obj['filter_bycluster']) >0))
                    $temp['cluster_view']=true;
                else if((isset($obj['show_cluster']) && $obj['show_cluster'] == 'true'))
                    $temp['cluster_view']=true;
                else
                     $temp['cluster_view']=false;


  

               $temp['cluster_id']=(isset($data_outlet_list[$i]->cluster_id)) ? $data_outlet_list[$i]->cluster_id : '';
                // $temp['cluster_name']=(isset($data_outlet_list[$i]->cluster_id) && $data_outlet_list[$i]->cluster_id!='') ? 'Cluster '.$data_outlet_list[$i]->cluster_id : '';
              
                if(isset($data_outlet_list[$i]->cluster_id) && $data_outlet_list[$i]->cluster_id=='')
                 {
                     $temp['cluster_name']='';
                     
                 }
               else if(isset($data_outlet_list[$i]->cluster_id) && $data_outlet_list[$i]->cluster_id==0)
                 {
                     $temp['cluster_name']='High Potential - Non-Cluster Outlets';       
                     if(in_array($temp['cluster_name'],$clusterlist))
                        array_push($clusterlist,$temp['cluster_name']);

                     
                 }
                 else if(isset($data_outlet_list[$i]->cluster_id) && $data_outlet_list[$i]->cluster_id!='')
                 {
                     $temp['cluster_name']='Cluster '.$data_outlet_list[$i]->cluster_id;
                      if(in_array($temp['cluster_name'],$clusterlist))
                        array_push($clusterlist,$temp['cluster_name']);
                     
                 }
                
            
              
              
           

               $temp['stock_confectionary']=(isset($data_outlet_list[$i]->stock_confectionary)) ? $data_outlet_list[$i]->stock_confectionary : '';
              $temp['stock_chocolate']=(isset($data_outlet_list[$i]->stock_chocolate)) ? $data_outlet_list[$i]->stock_chocolate : '';
              if($user->client_id!=133)
              {
                $temp['stock_confectionary_name']=(isset($data_outlet_list[$i]->stock_confectionary)) ? $perimium[$data_outlet_list[$i]->stock_confectionary] : '';
              $temp['stock_chocolate_name']=(isset($data_outlet_list[$i]->stock_chocolate)) ? $perimium[$data_outlet_list[$i]->stock_chocolate] : '';
              }
              
           }
           if($user->client_id==133)
            $temp['image_count']=(isset($imagelist[$data_outlet_list[$i]->retailer_id])) ? $imagelist[$data_outlet_list[$i]->retailer_id]  : 0;
           else
              $temp['image_count']=(isset($imagelist[$data_outlet_list[$i]->refid])) ? $imagelist[$data_outlet_list[$i]->refid]  : 0;



             


             if($type==9)
             {
                $temp['beat_name']=ucfirst(strtolower($data_outlet_list[$i]->beat_name));
                $temp['icon']= 'images/covered.png';
                $temp['type']='covered';
             }
             else if($type==10)
             {
                $temp['icon']= ($data_outlet_list[$i]->status=='N') ? $data_outlet_list[$i]->maintype_icon : (($data_outlet_list[$i]->status=='A') ? 'images/coveredblue.png' : 'images/nr.png');                
                $temp['type']='uncovered';
             }
             else
             {

                  if(in_array($data_outlet_list[$i]->status,['A','U','NU','SR','NSR']))
                      $temp['icon']= 'images/uncovered.png';
               else if($data_outlet_list[$i]->status=='R' || $data_outlet_list[$i]->status=='NR') 
                      $temp['icon']= 'images/nr.png';
               else
                $temp['icon']=$data_outlet_list[$i]->icon;
             }
             


             $temp['shop_image']=  ($type==9 || $type==10) ? '' : $data_outlet_list[$i]->shop_image; 
              $temp['shop_image']=(isset($imagename[$data_outlet_list[$i]->refid])) ?  $imagename[$data_outlet_list[$i]->refid] : (isset($data_uncovered_outlet_list[$i]->shop_image) ? $data_outlet_list[$i]->shop_image : $temp['shop_image']);          
             
             $temp['lat']=(isset($data_outlet_list[$i]->lat)) ? $data_outlet_list[$i]->lat : ''; 
             $temp['lon']=(isset($data_outlet_list[$i]->lon)) ? $data_outlet_list[$i]->lon : ''; 

             array_push($data['result'],$temp);

        }
       
          if($type==9)
        {
           $data['uncovered_result']=[];$data['channel_list']=[]; $channel_list='';
           for($i=0;$i<count($data_uncovered_outlet_list);$i++)        
          {
               if(!in_array($data_uncovered_outlet_list[$i]->maintype_id,$data['channel_list']) && $data_uncovered_outlet_list[$i]->maintype_id !=0 && $data_uncovered_outlet_list[$i]->maintype_id!='')
               {
                  array_push($data['channel_list'],$data_uncovered_outlet_list[$i]->maintype_id);
                  $channel_list .='<option value="'.$data_uncovered_outlet_list[$i]->maintype_id.'">'.$data_uncovered_outlet_list[$i]->channel.'</option>';
               }
               $temp=[];

               $temp['refid']=$data_uncovered_outlet_list[$i]->refid;
               $temp['outlet_name']=$data_uncovered_outlet_list[$i]->outlet_name;            
               $temp['channel_name']=$data_uncovered_outlet_list[$i]->channel;
               $temp['maintype_id']=$data_uncovered_outlet_list[$i]->maintype_id;
             //  $temp['potential_status']=$data_uncovered_outlet_list[$i]->potential_status;
               $temp['sub_channel_name']=$data_uncovered_outlet_list[$i]->subchannel;
               $temp['address']=ucwords(strtolower($data_uncovered_outlet_list[$i]->address));
               $temp['beat_name']=ucfirst(strtolower($data_uncovered_outlet_list[$i]->beat_name));
                 if(isset($data_uncovered_outlet_list[$i]->feed_potential_status) && $data_uncovered_outlet_list[$i]->feed_potential_status  != "")
               {
                    $temp['potential_status']=$data_uncovered_outlet_list[$i]->feed_potential_status;             
                    $temp['potential_status_name']=$data_uncovered_outlet_list[$i]->feed_potential_status;
               }
               else
               {
                 $temp['potential_status']=(isset($data_uncovered_outlet_list[$i]->potential_status)) ? $data_uncovered_outlet_list[$i]->potential_status : '';             
                  $temp['potential_status_name']=(isset($data_uncovered_outlet_list[$i]->potential_status)) ? $data_uncovered_outlet_list[$i]->potential_status: '';
               }

               
               
              
                 $temp['beat_id']=ucfirst(strtolower($data_uncovered_outlet_list[$i]->beat_id));
                 $temp['image_count']=(isset($imagelist[$data_uncovered_outlet_list[$i]->refid])) ? $imagelist[$data_uncovered_outlet_list[$i]->refid]  : 0;
                $temp['icon']= ($data_uncovered_outlet_list[$i]->status=='N') ? $data_uncovered_outlet_list[$i]->maintype_icon : (($data_uncovered_outlet_list[$i]->status=='A') ? 'images/coveredblue.png' : (($data_uncovered_outlet_list[$i]->status=='E') ? 'images/existing.png' : 'images/nr.png')); 

              
               $temp['lat']=(isset($data_uncovered_outlet_list[$i]->lat)) ? $data_uncovered_outlet_list[$i]->lat : ''; 
               $temp['lon']=(isset($data_uncovered_outlet_list[$i]->lon)) ? $data_uncovered_outlet_list[$i]->lon : ''; 
               $temp['type']='uncovered';
               $temp['status']=$data_uncovered_outlet_list[$i]->status;
               $temp['jj_stock']='';$temp['jj_baby']='';$temp['competition_baby']='';$temp['potential_store']='';$temp['jj_female']='';$temp['jj_otc']='';$temp['competition_female']='';$temp['competition_facewash']='';$temp['competition_stock']='';$temp['potential_baby']='';$temp['potential_female']='';
               $temp['potential_otc']=''; $temp['potential_skincare']='';

              
                $temp['shop_image']=(isset($imagename[$data_uncovered_outlet_list[$i]->refid])) ?  $imagename[$data_uncovered_outlet_list[$i]->refid] : (isset($data_uncovered_outlet_list[$i]->shop_image) ? $data_uncovered_outlet_list[$i]->shop_image : '');

               if(isset($uncovered_info[$data_uncovered_outlet_list[$i]->refid]))
               {
                  $temp['feedback_result']=$uncovered_info[$data_uncovered_outlet_list[$i]->refid];
                  $res=reset($uncovered_info[$data_uncovered_outlet_list[$i]->refid]);
                 
                 
                  $temp['channel_id']=$res->channel_id;
                   $temp['freezer']=$res->freezer;


               }
 
 
               


               array_push($data['uncovered_result'],$temp);

          }
        }


         $data['channel_list']=[];

        $data['legend'] = [];
        if($type==9)
        {
           $result=array_merge($data['result'],$data['uncovered_result']);
           
           $data['mapdata'] =$result;
           $data['channel_list']=$channel_list; 
            $data['feedback_question']=$feedback_question;
           
         
        }
        else
        {
          $data['mapdata'] =$data['result'];

        }

        
        $data['griddata'] = array();

        $head='';
        if($type==9)
        $data['griddata'] = $this->gridcolumn_byoutletlist_bycategory($data['uncovered_result']);
   
      else if($user->client_id==86 || $user->client_id==120 )
        if((isset($obj['filter_bycluster'])  && count($obj['filter_bycluster']) >0) || (isset($obj['show_cluster']) && $obj['show_cluster'] == 'false'))
        {
           

           
        if((isset($obj['show_cluster']) && $obj['show_cluster'] == 'false'))
        {
            $data['griddata'] = $this->gridcolumn_byoutletlist_bycategory($data['result'],'false');
            $head='All Outlets - '.implode(",",$heading);
            if(strlen(implode(",",$heading)) >= 50)
                $head='All Outlets - '.$heading[0].'...';
        }
        else{
            $data['griddata'] = $this->gridcolumn_byoutletlist_bycategory($data['result'],'true');
           $clusterlist=(count($clusterlist) > 0) ? implode(",",$clusterlist).' - ' : '';
           $head='Cluster - '.$clusterlist.implode(",",$heading);
            if(strlen(implode(",",$heading)) >= 50)
                  $head='Cluster - '.$clusterlist.$heading[0].'...';

        }
           

        }
        else{

          $data['griddata'] = $this->gridcolumn_bycluster(array_values($cluster)); 
          $clusterlist=(count($clusterlist) > 0) ? implode(",",$clusterlist).' - ' : '';
           $head='Cluster - '.$clusterlist.implode(",",$heading);
             if(strlen(implode(",",$heading)) >= 50)
                  $head='Cluster - '.$clusterlist.$heading[0].'...';


        }
                
      else{
        
        $data['griddata'] = $this->gridcolumn_byoutletlist_bycategory($data['result']);
      }
        
//      var_dump($data['griddata']);die;
        //if($user->client_id!=86 && $user->client_id!=120 && $user->client_id!=115)
        if(!in_array($user->client_id,[86,120,115,1,123,0,1000,100,133]))
           $head = CommonController::headline($loc12);
        if(in_array($user->client_id,[100]))
           $head = '';//$result[0]['beat_name'];
        if(in_array($user->client_id,[133]))
        {
            // $sector=[1=>'Villg',2=>'City'];
            // $head =$data_outlet_list[0]->city.' '. $sector[(int)$data_outlet_list[0]->sector];
             $head =$data_outlet_list[0]->district_name.' '. 'distt.';
        }

           
       
       if(in_array($user->client_id,[115,1,123,0,1000]))
        {

            $clusterlist=(count($clusterlist) > 0) ? implode(",",$clusterlist).' - ' : '';
              if(isset($obj['filter_datatype']) && $obj['filter_datatype']!='')
                $head=$clusterlist.$obj['filter_datatype'];
        }
        $data['head'] = $head;
 
        return $data;


    }
    public function get_villagesubrd($data)
    {
        $column=[];
        $value=[];
       
      
         array_push($column, array(
             'title' => '#', 'className' => 'text-right','data'=>'s_no'
         ));

         
          array_push($column, array(
             'title' => 'Distt. Name', 'className' => 'text-left','data'=>'district_name'
         ));
           array_push($column, array(
             'title' => 'Sub-Distt. Name', 'className' => 'text-left','data'=>'taluk_name'
         ));
            array_push($column, array(
             'title' => 'Town / Village Name', 'className' => 'text-left','data'=>'village_name'
         ));
           
            array_push($column, array(
             'title' => 'Market UID', 'className' => 'text-right','data'=>'market_id'
         ));
           
             array_push($column, array(
             'title' => 'Outlet Potential (Nos.)', 'className' => 'text-right','data'=>'outlet_otential'
         ));
             array_push($column, array(
             'title' => 'Population (Nos.)', 'className' => 'text-right','data'=>'population'
         ));
              array_push($column, array(
             'title' => 'Consmption (Annual) (Rs.)',  'className' => 'text-right','data'=>'village_choc_consmptn'
         ));
           

              array_push($column, array(
             'title' => 'Exist SubRD Code', 'className' => 'text-left','data'=>'exist_subrd_code'
         ));

              array_push($column, array(
             'title' => 'Exist SubRD Name', 'className' => 'text-left','data'=>'exist_subrd_name'
         ));
             
             array_push($column, array(
             'title' => 'Nearest RD', 'className' => 'text-right','data'=>'rd_code'
         ));

        for($i=0;$i<count($data);$i++)
        {
             $data[$i]['village_census']=ltrim($data[$i]['village_census'], 0);
             
            
            $temp=array(
                's_no'=>($i+1),
                

                'district_name'=>$data[$i]['district_name'],
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
                // '<a href="#" style="text-decoration:underline;" onClick="view_village_detail('.$detail.')">'.$data[$i]['village_name'].'</a>',
                 'market_id'=> $data[$i]['market_UID'],
                 
                  'outlet_otential'=>number_format($data[$i]['fmcg_retlr_universe'],0),
                  'population'=>number_format($data[$i]['population'],0),
                  'village_choc_consmptn'=>number_format($data[$i]['consumption'],0),
                
                  'exist_subrd_name'=>$data[$i]['subrd_name'],
                  'exist_subrd_code'=>$data[$i]['subrd_code'],
                  
                  'rd_code'=>$data[$i]['rd_code']


            );
       
       
            array_push($value,$temp);

        }
            
            return array(
            'column' => $column,
            'value' => $value
        );



    }
     public function get_village_details($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {

       
     $data = [];$getdetail=[];$data['result'] = array();$data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
        $getfilter=json_decode($input_obj);
       
        $summary_count=[];
        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
      
        $orwhere=[];
        if(isset($getfilter->filter_byvillagedist) && count($getfilter->filter_byvillagedist)>0)
            array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_byvillagedist).")");
        if(isset($getfilter->filter_byvillagetaluk) && count($getfilter->filter_byvillagetaluk)>0)
            array_push($orwhere,"  a.taluk_census in (".implode(",",$getfilter->filter_byvillagetaluk).")");

        $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";

        $sql="select b.state_code,a.refid, a.loc7, a.loc9, a.loc10, a.loc12, a.loc13, a.loc14, a.state_census, a.district_census, a.taluk_census, a.village_census, a.taluk_name, a.branch, a.bsm_area, a.bsm_area_1, a.state as state_name, a.district_name, a.asm_area, a.so_territory, a.rd_code, a.nearest_rd_code, a.nearest_rd_distance, a.nearest_sst_code, a.nearest_sst_distance, a.tsi_uid, a.tsi_code, a.tsi_name, a.subrd_code, a.subrd_name, a.subrd_loc14, a.subrd_latitude, a.subrd_longitude, a.subrd_under_subERP, a.silk_opened, a.beat_pjp_uploaded, a.beat_UID, a.beat_name, a.market_UID, a.village_code_1, a.village_name, a.sector, a.latitude, a.longitude, a.population, a.fmcg_retlr_universe, a.consumption, a.rural_progressive_index,  a.villg_population, a.visicooler_ols, a.ws_outlets, a.total_ols_billed, a.total_village_value_billed, a.current_month_frequency_of_visit, a.month_1_frequency_of_visit, a.month_2_frequency_of_visit, a.total, a.l3m_visited, a.total_village, a.planned_beat_pjp, a.pop_bucket, a.village_status, a.village_type, a.rla_in_villg_but_not_reflecting_in_pro_report, a.rla_in_rural_sales_report, a.subrd_status, a.stat,if(rural_progressive_index='Transition','T',if(rural_progressive_index='Develpd','D',if(rural_progressive_index='Most Develpd','MD',if(rural_progressive_index='Under-Develpd','UD',if(rural_progressive_index='Not Rated','NR',''))))) as rpi_img,if(rural_progressive_index='Transition','T',if(rural_progressive_index='Develpd','D',if(rural_progressive_index='Most Develpd','MD',if(rural_progressive_index='Under-Develpd','UD',if(rural_progressive_index='Not Rated','NR',''))))) as rpi_name FROM mdlz_village_with_zero_rla as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";

         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);
       
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'district_name');
          $district_name=array_unique($district_name);
          $state_code=array_column($result,'state_code');
          $state_code=array_unique($state_code);
          $table_data=[];
         
         $result_count=count($result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            array_push($table_data,$result[$k]);
            $temp=$result[$k];
            $temp['color']='red';
          
             $label='';
             $legend="";
              $rural_img=($result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$result[$k]['rpi_img'].'.jpg"></img>';

             $temp['shareinfo']='Village: '.$result[$k]['village_name'].'; Taluk: '.$result[$k]['taluk_name'].'; Distt: '.$result[$k]['district_name'].'; State: '.$result[$k]['state_name'].';Population: '.$result[$k]['villg_population'].' Nos.; Rural Progressive Index: '.$result[$k]['rural_progressive_index'].'; Outlet Potential: '.$result[$k]['fmcg_retlr_universe'].' Nos.;  Consmption (Annual) (Rs.): '.$result[$k]['consumption'].';  ';
            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[$k]['latitude'].'" lon="'.$result[$k]['longitude'].'" id="share_'.$result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$result[$k]['latitude'].','.$result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.number_format($result[$k]['fmcg_retlr_universe'],0).' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;"> Consmptn (Annual) (Rs.): </span>'.number_format($result[$k]['consumption'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;"> Rural Progrsv Index: </span>'.$rural_img.' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Census: </span><span style="background-color:white;color:black;" >'.$result[$k]['subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($result[$k]['subrd_name'])).' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Nearest RD: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($result[$k]['rd_code'])).' </span></p></div>';
          
            
         $temp['size']=8;
         $maparray[$result[$k]['village_census']]=array_merge($maparray[$result[$k]['village_census']],$temp);
        }

        //$data['griddata'] =[];
        $data['griddata'] = $this->get_villagesubrd($table_data);
        $data['mapdata'] = $maparray;
        $data['legend']='';
        if(isset($getfilter->filter_byvillagetaluk) && count($getfilter->filter_byvillagetaluk)>0)
            $data['head']=implode(", ", $taluk_name). ' sub-distt, '.implode(", ", $district_name);
        else if(isset($getfilter->filter_byvillagedist) && count($getfilter->filter_byvillagedist)>0)
             $data['head']=implode(", ", $district_name). ' distt, '.implode(", ", $state_code);
         else
             $data['head']='';

        return $data;

    }
    public function show_added_outletlist($maparray,$type,$main_location,$sub_location,$so_id)
    {
        $data = [];
        $data['result'] = array();       
        $user = auth()->user();
        $userid = $user->id;   
        $key = array_keys($maparray);
        $value = array_values($maparray);
        $loc15 = array_unique(array_column($value, 'loc15'));
        $loc12 = array_unique(array_column($value, 'loc12'));   
       if($user->client_id==120)
        $data_outlet_list =  DB::table('outlet_list')
            ->join('users', 'users.id', '=', 'outlet_list.user_id')          
            ->join('mdlz_main_channel_master', 'mdlz_main_channel_master.refid', '=', 'outlet_list.channel_name')
            ->join('mdlz_channel_master', 'mdlz_channel_master.refid', '=', 'outlet_list.sub_channel_name')
             ->where('outlet_list.user_id',$user->id)
            ->select('outlet_list.*', 'users.firstname', 'users.lastname','mdlz_main_channel_master.name as channel','mdlz_channel_master.name as subchannel','mdlz_channel_master.icon as icon')
            ->get();
        if($user->client_id==100)
             $data_outlet_list =  DB::table('outlet_list')
            ->join('users', 'users.id', '=', 'outlet_list.user_id')          
            ->join('j_and_j_main_channel_master', 'j_and_j_main_channel_master.refid', '=', 'outlet_list.channel_name')
            ->join('j_and_j_channel_master', 'j_and_j_channel_master.refid', '=', 'outlet_list.sub_channel_name')
             ->where('outlet_list.user_id',$user->id)
            ->select('outlet_list.*', 'users.firstname', 'users.lastname','j_and_j_main_channel_master.name as channel','j_and_j_channel_master.name as subchannel','j_and_j_channel_master.icon as icon')
            ->get();
             if($user->client_id==86)
             $data_outlet_list =  DB::table('outlet_list')
            ->join('users', 'users.id', '=', 'outlet_list.user_id')          
            ->join('nestle_channel_master', 'nestle_channel_master.refid', '=', 'outlet_list.sub_channel_name')
           // ->join('nestle_channel_master', 'nestle_channel_master.refid', '=', 'outlet_list.sub_channel_name')
             ->where('outlet_list.user_id',$user->id)
            ->select('outlet_list.*', 'users.firstname', 'users.lastname','nestle_channel_master.name as channel','nestle_channel_master.name as subchannel','nestle_channel_master.icon as icon')
            ->get();
            if($user->client_id==115)
             $data_outlet_list =  DB::table('outlet_list')
            ->join('users', 'users.id', '=', 'outlet_list.user_id')          
            ->join('pidilite_channel_master', 'pidilite_channel_master.refid', '=', 'outlet_list.sub_channel_name')
           // ->join('nestle_channel_master', 'nestle_channel_master.refid', '=', 'outlet_list.sub_channel_name')
             ->where('outlet_list.user_id',$user->id)
            ->select('outlet_list.*', 'users.firstname', 'users.lastname','pidilite_channel_master.name as channel','pidilite_channel_master.name as subchannel','pidilite_channel_master.icon as icon')
            ->get();

        for($i=0;$i<count($data_outlet_list);$i++)        
        {
             $temp=[];
             $temp['refid']=$data_outlet_list[$i]->refid;
             $temp['outlet_name']=$data_outlet_list[$i]->outlet_name;
             $temp['owner_name']=$data_outlet_list[$i]->owner_name;
             $temp['channel_name']=$data_outlet_list[$i]->channel;
             $temp['sub_channel_name']=$data_outlet_list[$i]->subchannel;
             $temp['address']=ucwords(strtolower($data_outlet_list[$i]->address));               
             $temp['shop_image']=$data_outlet_list[$i]->shop_image;
             $temp['created_at']=date('d M Y H:i:s A',strtotime($data_outlet_list[$i]->created_at));
             $temp['updated_at']= date('d M Y H:i:s A',strtotime($data_outlet_list[$i]->updated_at));
             $temp['user_id']=$data_outlet_list[$i]->user_id;
             $temp['pan_no']=$data_outlet_list[$i]->pan_no;
             $temp['mobile_no']=$data_outlet_list[$i]->mobile_no;     
             $temp['tan_no']=$data_outlet_list[$i]->tan_no; 
             $temp['shop_establish_no']=$data_outlet_list[$i]->shop_establish_no; 
             $temp['gst_no']=$data_outlet_list[$i]->gst_no; 
             $temp['icon']=$data_outlet_list[$i]->icon; 
             $temp['lat']=(isset($data_outlet_list[$i]->lat)) ? $data_outlet_list[$i]->lat : ''; 
             $temp['lon']=(isset($data_outlet_list[$i]->lon)) ? $data_outlet_list[$i]->lon : ''; 

             array_push($data['result'],$temp);

        }
        

        $data['legend'] = [];
          
        $data['mapdata'] =$data['result'];
        $data['griddata'] = array();

        $data['griddata'] = $this->gridcolumn_byoutletlist($data['result']);
        $user = auth()->user();
        if($user->client_id==86 || $user->client_id==115)
          $head='Added Outlets';
        else
          $head = CommonController::headline($loc12);
        $data['head'] = $head;

        return $data;

    } 
   
   /* public function Combine_subrd($maparray, $type, $main_location, $sub_location, $input_obj, $current_location)
    {   
        // Decode input explicitly as an object
        $getfilter = json_decode($input_obj ?? '{}');
        
        if (!isset($getfilter->type_view)) {
            $type_view = [];
        } else {
            $type_view = explode(",", $getfilter->type_view);
        } 

        // Extract cluster_id
        $cluster_id = data_get($getfilter, 'cluster_id');

        // FIX: Ensure JavaScript string literals like "undefined" or empty states reset cluster_id to true null
        if (empty($cluster_id) || $cluster_id === 'undefined' || $cluster_id === 'null' || $cluster_id === '') {
            $cluster_id = null;
        }

        if (in_array(4, $type_view)) {
            return $this->Combine_krishnagiri_subrd($maparray, $type, $main_location, $sub_location, $input_obj, $current_location);
        }

         //Feeder menu for coke
         if (in_array(15, $type_view)) {

             return $this->Combine_subrd_feederMenu($maparray, $type, $main_location, $sub_location, $input_obj, $current_location);
        }

        $user = auth()->user();
        $userid = $user->id;

        if ($user->id == 13947 || $user->id == 21040 || $user->id == 21043 || $user->id == 21041 || $user->id == 21042 || $user->id == 21129 || $user->id == 21130 || $user->id == 12933 || $user->id == 22102) {
            $tbllist = [120 => 'subrd_data', 123 => 'subrd_data_perfetti', 112 => 'coke_subrd_data_all', 133 => 'subrd_data', 1000 => 'subrd_data_haldiram', 9999 => 'subrd_data_mars'];
        } else {
            $tbllist = [120 => 'subrd_data', 123 => 'subrd_data_perfetti', 112 => 'coke_subrd_data_all', 133 => 'subrd_data', 1000 => 'subrd_data_haldiram', 9999 => 'subrd_data_mars'];   
        }

        $consmtp = [120 => 'Villg. Choc Consmptn', 123 => 'Confectionery Consmptn', 112 => 'Confectionery Consmptn', 133 => '', 1000 => '', 9999 => 'Confectionery Consmptn'];
        $subrd_name = [112 => [0 => 'Spoke Reco', 1 => 'Reco Villg.', 133 => '', 1000 => '', 9999 => '']];
        
        $data = [];
        $getdetail = [];
        $color = ['green', 'red', 'lavender', 'pink', 'orange', 'fgreen', 'chaani'];
        
        if ($userid == 13285) {
            $consmtp[120] = 'Catgry Consmptn';
        }
        
        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
       
        $summary_count = [];
        $summary_count['Develpd'] = 0;
        $summary_count['Most Develpd'] = 0;
        $summary_count['Under-develpd'] = 0;
        $summary_count['Transition'] = 0;
        $summary_count['Not Rated'] = 0;
        $summary_count['total_village'] = 0;
        $summary_count['new_village'] = 0;
        $summary_count['show_summary'] = 0;
        $summary_count['new_village_current'] = 0;
        $summary_count['new_village_recommand'] = 0;
        $summary_count['new_villageexport'] = 0;
       
        $orwhere = [];
        if (isset($getfilter->filter_district) && is_array($getfilter->filter_district) && count($getfilter->filter_district) > 0) {
            array_push($orwhere, "  a.loc9 in (" . implode(",", $getfilter->filter_district) . ")");
        }
        if (isset($getfilter->filter_taluk) && is_array($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0) {
            array_push($orwhere, "  a.taluk_census in (" . implode(",", $getfilter->filter_taluk) . ")");
        }

        $str = '';
           
        if (filled($cluster_id)) {
            if (is_array($cluster_id)) {
                $cluster_id = implode(',', $cluster_id);
            }
            $str .= " AND a.cluster_id='" . addslashes($cluster_id) . "'";
        }

        if (count($orwhere) > 0) {
            $str .= " and (" . join(" or ", $orwhere) . ") ";
        }
        
        if (isset($getfilter->filter_priority) && $getfilter->filter_priority != '') {
             $str .= ' and a.subrd_priority="' . $getfilter->filter_priority . '"';
        }
        if (isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd != '') {
             $str .= ' and a.exist_subrd_code="' . $getfilter->filter_existsubrd . '"';
        }
        
        $select = '';
        if ($user->client_id == 9999) {
            $select = ',no_of_schools,no_of_colleges,hh,if(atm="-","No",atm) atm,if(bank="-","No",bank) bank,if(nh="-","No",nh) nh,if(sh="-","No",sh) sh,if(rly_stn="-","No",rly_stn) rly_stn';
        }

        $sql = "SELECT  a.village_cover_status,b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`,a.`subrd_type_whlsl`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale" . $select . " FROM " . $tbllist[$user->client_id] . " as a,town_village_polygon as b where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code " . $str . " and b.stat='A' ";
        
        $result = DB::select(DB::raw($sql));
        $result = CommonController::getarray($result);
          
        $final_result = [];
        $inc = 0;
        $taluk_name = array_unique(array_column($result, 'taluk_name'));
        $district_name = array_unique(array_column($result, 'district_name'));
        $state_name = array_unique(array_column($result, 'state_code'));
        $table_data = [];
        $priority = ['Priority 1' => 'rural_icon/r_p1.png', 'Priority 2' => 'rural_icon/r_p2.png', 'Priority 3' => 'rural_icon/r_p3.png', '' => 'rural_icon/recommendation.png', 'P1' => 'rural_icon/r_p1.png', 'P2' => 'rural_icon/r_p2.png'];
        $without_hub = $result;
        $non_cluster_color = [];
        $child_list = [];
         
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['is_hub'] == 1 && in_array($result[$i]['subrd_type'], $type_view)) {
                $result[$i]['village_census'] = ltrim($result[$i]['village_census'], 0);
                if (isset($maparray[$result[$i]['village_census']])) {
                    $final_result[$inc] = $result[$i];
                    $final_result[$inc]['child'] = [];
                    $filter_id = $result[$i]['cluster_id'];

                    $final_result[$inc]['subrd_marker'] = ($result[$i]['subrd_type'] == 1) ? 'rural_icon/efficient-subrd.png' : (($result[$i]['subrd_type'] == 2) ? $priority[$result[$i]['subrd_priority']] : (($result[$i]['subrd_type'] == 5) ? 'rural_icon/D.png' : 'NA'));
                    $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$result[$i]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $result[$i]['cluster_name'] . '</li></ul> </div></div></div>';
                    
                    $sqlCluseter = "SELECT  a.village_cover_status,b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`,a.`subrd_type_whlsl`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale" . $select . " FROM " . $tbllist[$user->client_id] . " as a,town_village_polygon as b where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code and a.cluster_id='" . $result[$i]['cluster_id'] . "' and b.stat='A' ";
    
                    $resultCluseter = DB::select(DB::raw($sqlCluseter));
                    $resultCluseter = CommonController::getarray($resultCluseter);

                    $hub_child_list = array_filter($resultCluseter, function ($var) use ($filter_id) {
                        return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                    });

                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                    });

                    $final_result[$inc]['child'] = $hub_child_list; 
                    $res_arr = $result[$i];
                    $child_list[$filter_id] = $hub_child_list;

                    $res_arr['child'] = htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                    $res_arr['child_count'] = count($hub_child_list);
                    $res_arr['child_d'] = $hub_child_list;
                  
                    $inc++;
                    array_push($table_data, $res_arr);
                }
            } else if ($result[$i]['subrd_type'] == 0 || !in_array($result[$i]['subrd_type'], $type_view)) {
                $result[$i]['village_census'] = ltrim($result[$i]['village_census'], 0);
                if (isset($maparray[$result[$i]['village_census']])) {
                    $final_result[$inc] = $result[$i];
                    $final_result[$inc]['child'] = [];
                    $final_result[$inc]['child_d'] = [];
                    $final_result[$inc]['subrd_marker'] = 'NA';
                    $child_list[$result[$i]['cluster_id']] = [];
                    $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$result[$i]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $result[$i]['cluster_name'] . '</li></ul> </div></div></div>';                           
                    $inc++;
                }
            }
        }
       
        $without_hub = array_values($without_hub);
        $without_hub_count = count($without_hub);
        $mdlz = ($user->id == 13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";
        
        for ($i = 0; $i < $without_hub_count; $i++) {
            $without_hub[$i]['village_census'] = ltrim($without_hub[$i]['village_census'], 0);

            if (isset($maparray[$without_hub[$i]['village_census']])) {
                if ($without_hub[$i]['subrd_type'] == 1 && $without_hub[$i]['active_stat'] == 'No') {
                    $summary_count['new_village_current']++;
                }
                if ($without_hub[$i]['subrd_type'] == 2) {
                    $summary_count['new_village_recommand']++;
                }
                   
                if (in_array($without_hub[$i]['subrd_type'], [1, 2, 3])) {
                    if (in_array($without_hub[$i]['subrd_type'], [2, 3]) && in_array($without_hub[$i]['subrd_type'], $type_view)) {
                        $summary_count['show_summary'] = $without_hub[$i]['subrd_type']; 
                    }
                }  
                  
                $final_result[$inc] = $without_hub[$i];
                $final_result[$inc]['child'] = [];
                $final_result[$inc]['subrd_marker'] = ($without_hub[$i]['subrd_type'] == 1) ? 'rural_icon/efficient-subrd.png' : (($without_hub[$i]['subrd_type'] == 2) ? $priority[$without_hub[$i]['subrd_priority']] : (($without_hub[$i]['subrd_type'] == 5) ? 'rural_icon/D.png' : 'NA'));
                $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$without_hub[$i]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $without_hub[$i]['cluster_name'] . '</li></ul> </div></div></div>';                           
                $inc++;
            }
        }
      
        $result_count = count($final_result);
        $temp = [];
        
        for ($k = 0; $k < $result_count; $k++) {
            $temp = $final_result[$k];
            
            if ($temp['subrd_type'] == 1 && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
                if ($temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' || $temp['subrd_loaction'] == 'Existing Urban Distbtr') {
                    $split_color = 'lblue';
                } else {
                    $split_color = 'grey';
                }
            } else if (($temp['subrd_type'] == 2) && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
                $range = array_rand(range(0, (count($color) - 1)));
                $split_color = $color[$range];
            } else if (($temp['subrd_type'] == 3) && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
                 $split_color = 'fgreen';
            } else if ($temp['subrd_type'] == 5 && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
                $split_color = 'blue';
                $hub = CommonController::getcolor_bysubrd('d_' . $split_color); 
            } else if ($temp['subrd_type'] == 0) {
                $split_color = 'none';
            } else {
                $split_color = 'none';
            }
            
            if (in_array($temp['subrd_type'], [2, 3]) && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
                $summary_count['total_village']++;   
                if ($summary_count['show_summary'] == '') {
                    $summary_count['show_summary'] = $temp['subrd_type'];
                }
            }
    
            unset($temp['child']);
            
            if ($temp['is_hub'] != 1 && $temp['subrd_type'] != 0) {
                $hub = '#ffffff';
                if (($temp['active_stat'] == 'Yes' || $temp['active_stat'] == '') && ($temp['subrd_type'] == 1) && in_array($temp['subrd_type'], $type_view)) {
                    $hub = CommonController::getcolor_bysubrd('l_grey');
                }
                if ($temp['active_stat'] == 'No' && ($temp['subrd_type'] == 1) && in_array($temp['subrd_type'], $type_view)) {
                    $hub = CommonController::getcolor_bysubrd('yellow');
                }
                if ($temp['subrd_loaction'] == 'Existing Urban Distbtr' && ($temp['subrd_type'] == 1) && in_array($temp['subrd_type'], $type_view)) {
                    $hub = CommonController::getcolor_bysubrd('l_lblue'); 
                }
                if ((($temp['subrd_type'] == 2) || ($temp['subrd_type'] == 3)) && in_array($temp['subrd_type'], $type_view)) {
                    if (isset($non_cluster_color[$temp['cluster_name']]) && $temp['subrd_type'] != 3) {
                        $hub = CommonController::getcolor_bysubrd('l_' . $non_cluster_color[$temp['cluster_name']]); 
                    } else if ($temp['subrd_type'] != 3) {
                        $range = array_rand(range(0, (count($color) - 1)));
                        $split_color = $color[$range];
                        $hub = CommonController::getcolor_bysubrd('l_' . $split_color); 
                        $non_cluster_color[$temp['cluster_name']] = $split_color;
                    } else if ($temp['subrd_type'] == 3) {
                        $hub = CommonController::getcolor_bysubrd('l_fgreen');
                    }
                }
            } else {
                $hub = CommonController::getcolor_bysubrd('d_' . $split_color); 
            }
            
            $label = '';
            $legend = "";

            // CRITICAL FIX: Ensure $cluster_id is valid and strictly not null before resetting colors to white
            if (!empty($cluster_id) && $cluster_id !== null) {
                if (trim($final_result[$k]['cluster_id']) != trim($cluster_id)) {
                    $hub = '#ffffff'; 
                            // ✅ Suppress hub markers too
                $temp['subrd_marker']    = 'NA';
                $temp['activate_marker'] = 'NA';
                $temp['subrd_status']    = 0;
                $temp['subrd_tooltip']   = '';
                $temp['markers']         = []; // ✅ Clear combined markers array
                }
            }

            $temp['color'] = $hub;     

            $cluster_type = $final_result[$k]['subrd_loaction'];
            if ($user->client_id == 1000) {
                $cluster_type = $final_result[$k]['subrd_loaction'];
            }
			 
            $final_result[$k]['activate_status'] = $final_result[$k]['company_service_id'];
            $cluster_tag = (($final_result[$k]['subrd_type'] == 1 || $final_result[$k]['subrd_type'] == 5) && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'SubRD Existg' : (($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Recommdd' : (($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Wholesaler' : ''));
            $cluster_hub = ($final_result[$k]['subrd_type'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Existg SubRD' : (($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Recommdd SubRD' : (($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Wholesaler' : ''));
            $temp['activate_marker'] = ($final_result[$k]['company_service_id'] == 1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id'] == 2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id'] == 3) ? 'rural_icon/deactivated.png' : (($final_result[$k]['company_service_id'] == 4) ? 'rural_icon/activated.png' : (($final_result[$k]['company_service_id'] == 5) ? 'rural_icon/deactivated.png' : 'NA'))));
            
            if ($temp['is_hub'] != 0) {
                $temp['subrd_status'] = (in_array($final_result[$k]['subrd_type'], $type_view)) ? $final_result[$k]['subrd_type'] : 0;

               // $temp['subrd_marker'] = (($final_result[$k]['subrd_type'] == 5) ? 'rural_icon/Distributr.png' : (($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? $priority[$final_result[$k]['subrd_priority']] : (($final_result[$k]['subrd_type'] == 1 && $temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'rural_icon/urban-distributor.png' : (($final_result[$k]['subrd_type'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'rural_icon/efficient-subrd.png' : (($final_result[$k]['subrd_type_whlsl'] == 3 && in_array($final_result[$k]['subrd_type_whlsl'], $type_view)) ? 'rural_icon/Wholesale.png' : '')))));

                 $subrd_marker = 'NA';

                if ($final_result[$k]['subrd_type'] == 5) {

                    $subrd_marker = 'rural_icon/Distributr.png';

                } elseif (
                    $final_result[$k]['subrd_type'] == 2 &&
                    in_array($final_result[$k]['subrd_type'], $type_view)
                ) {

                    $subrd_marker = $priority[$final_result[$k]['subrd_priority']];

                } elseif (
                    $final_result[$k]['subrd_type'] == 1 &&
                    $temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' &&
                    in_array($final_result[$k]['subrd_type'], $type_view)
                ) {

                    $subrd_marker = 'rural_icon/urban-distributor.png';

                } elseif (
                    $final_result[$k]['subrd_type'] == 1 &&
                    in_array($final_result[$k]['subrd_type'], $type_view)
                ) {

                    $subrd_marker = 'rural_icon/efficient-subrd.png';

                } elseif (
                    $final_result[$k]['subrd_type_whlsl'] == 3 &&
                    in_array($final_result[$k]['subrd_type_whlsl'], $type_view)
                ) {

                    $subrd_marker = 'rural_icon/Wholesale.png';
                }

                $temp['subrd_marker'] = $subrd_marker;
                $temp['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$final_result[$k]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $cluster_tag . '</li></ul> </div></div></div>';
            } else {
                 $temp['subrd_status'] = 0;
                 $temp['subrd_marker'] = 'NA';             
                 $temp['subrd_tooltip'] = '';
            }

            if ($final_result[$k]['subrd_type'] != 0 && in_array($final_result[$k]['subrd_type'], $type_view)) {
                $temp['shareinfo'] = 'Village: ' . $final_result[$k]['village_name'] . '; Taluk: ' . $final_result[$k]['taluk_name'] . '; Distt: ' . $final_result[$k]['district_name'] . '; State: ' . $final_result[$k]['state_name'] . ';Recommendation: ' . $cluster_type . ';Distance from ' . $cluster_hub . ' (km): 0 kms; Population: ' . $final_result[$k]['population'] . ' Nos.; Rural Progressive Index: ' . $final_result[$k]['rpi'] . '; Outlet Potential: ' . $final_result[$k]['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $final_result[$k]['village_choc_consmptn'] . '; Market UID: ' . $final_result[$k]['market_id'] . '; BI Location ID: ' . $final_result[$k]['bi_id'] . ';SubRD Priority: ' . $final_result[$k]['subrd_priority'] . '; SubRD Cluster Priority: ' . $final_result[$k]['subrd_priority'] . '; ';

                $final_result[$k]['village_choc_consmptn'] = ($final_result[$k]['village_choc_consmptn'] != '') ? $final_result[$k]['village_choc_consmptn'] : 0;
                $final_result[$k]['village_choc_consmptn'] = is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $final_result[$k]['village_choc_consmptn']), 0);

                $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $result[0]['latitude'] . '" lon="' . $result[0]['longitude'] . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">' . (($userid == 13285) ? "Recommendatn" : "Recommendatn") . ':</span> ' . $cluster_type . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>' . $final_result[$k]['cluster_id'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from ' . $cluster_hub . ' (km): </span>0 kms</p>';
                if ($user->client_id != 1000) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
                }
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Coca-Cola Cvrg Nos.: </span> ' . number_format($final_result[$k]['mdlz_retlr_universe'], 0) . ' Nos.</p>';
                if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
                }

                if ($final_result[$k]['subrd_type'] == 1 && $user->client_id == 120) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $mdlz . ': </span>' . $final_result[$k]['mdlz_retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>' . number_format($final_result[$k]['avg_monthly_sale'], 0) . ' Nos.</p>';
                }
                if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
                }
                if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
                }
                if ($user->client_id == 9999) {
                     $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $final_result[$k]['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $final_result[$k]['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $final_result[$k]['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $final_result[$k]['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $final_result[$k]['rly_stn'] . '</p>';
                }
                $rural_img = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >' . $rural_img . '</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>' . $cluster_tag . ' </p>';
               
                if (in_array($final_result[$k]['subrd_type'], [2, 3]) && $user->client_id == 120) {
                     $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> ' . $final_result[$k]['subrd_priority'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>' . $final_result[$k]['subrd_priority'] . '</p>';
                }
                if (in_array($final_result[$k]['subrd_type'], [1]) && $user->client_id == 120) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD' . (($userid == 13285) ? "" : " Name") . ': </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                }
              
                if ($user->client_id == 120) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['market_id'] . '</span></p>';
                }
                if ($user->client_id != 120) {
                     $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['bi_id'] . ' </span></p>';
                     if (in_array($final_result[$k]['subrd_type'], [1])) {
                        $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                     }
                }

                $final_result[$k]['population'] = number_format($final_result[$k]['population'], 0);
                $final_result[$k]['village_name'] = $maparray[$final_result[$k]['village_census']]['location_name'];
                $final_result[$k]['cluster_type'] = $cluster_type;
                $detail = htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

                $temp['info'] .= '<div class="popup-footer" style="cursor:pointer;padding:10px;text-align:center;" onclick="view_village_detail(' . $detail . ')">More Info</span></div></div>';
            } else {
                $final_result[$k]['population'] = is_numeric($final_result[$k]['population']) ? $final_result[$k]['population'] : 0;
                $final_result[$k]['village_choc_consmptn'] = is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $final_result[$k]['village_choc_consmptn']), 0);
                $temp['shareinfo'] = 'Village: ' . $final_result[$k]['village_name'] . '; Taluk: ' . $final_result[$k]['taluk_name'] . '; Distt: ' . $final_result[$k]['district_name'] . '; State: ' . $final_result[$k]['state_name'] . ';Population: ' . $final_result[$k]['population'] . ' Nos.; Rural Progressive Index: ' . $final_result[$k]['rpi'] . '; Outlet Potential: ' . $final_result[$k]['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $final_result[$k]['village_choc_consmptn'] . '; Market UID: ' . $final_result[$k]['market_id'] . '; BI Location ID: ' . $final_result[$k]['bi_id'] . '; ';
                $mdlz = ($user->id == 13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";

                $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $result[0]['latitude'] . '" lon="' . $result[0]['longitude'] . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;">';
                if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
                }
                if ($user->client_id != 1000) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
                }
                if ($user->client_id != 112 && $user->client_id != 9999) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;"> ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
                }  
                if ($user->client_id == 9999) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $final_result[$k]['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $final_result[$k]['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $final_result[$k]['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $final_result[$k]['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $final_result[$k]['rly_stn'] . '</p>';
                }
                    
                $rural_img = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p>';
                if ($user->client_id == 120) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['market_id'] . '</span></p>';
                }
                if ($user->client_id != 120) {            
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['bi_id'] . ' </span></p>';
                }
            
                $final_result[$k]['village_name'] = $maparray[$final_result[$k]['village_census']]['location_name'];
                $detail = htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

                $temp['info'] .= '<div class="popup-footer" style="text-align:center;cursor:pointer;padding:10px;" onclick="view_village_detail(' . $detail . ')"><span class="navigate_location" style="background-color:none;">More Info</span></div></div>';  
            }
            if ($user->client_id == 133) {
                $final_result[$k]['population'] = is_numeric($final_result[$k]['population']) ? $final_result[$k]['population'] : 0;
                $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $result[0]['latitude'] . '" lon="' . $result[0]['longitude'] . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;">';
                $rural_img = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >' . $rural_img . '</span></p><div ></div></div>';
            }
            $temp['size'] = 15;
            //$temp['activate_status_icon'] = $temp['activate_marker'];
            //$temp['activate_status'] = $final_result[$k]['activate_status'];

            $temp['activate_status'] = $final_result[$k]['activate_status'];

            $temp = $this->buildVillageMarkers(
                $temp,
                $temp['subrd_marker'],
                $temp['activate_marker']
            );
                    
           // $maparray[$final_result[$k]['village_census']] = array_merge($maparray[$final_result[$k]['village_census']], $temp);

            $temp['markers'] = [];

            if (
                isset($temp['subrd_marker']) &&
                $temp['subrd_marker'] != '' &&
                $temp['subrd_marker'] != 'NA'
            ) {
                $temp['markers'][] = [
                    'icon' => $temp['subrd_marker']
                ];
            }

            if (
                isset($temp['activate_marker']) &&
                $temp['activate_marker'] != '' &&
                $temp['activate_marker'] != 'NA'
            ) {
                $temp['markers'][] = [
                    'icon' => $temp['activate_marker']
                ];
            }
            $maparray[$final_result[$k]['village_census']] = array_merge($maparray[$final_result[$k]['village_census']], $temp);
            $temp2 = [];
                    
            foreach ($final_result[$k]['child'] as $key => $value) {
                $temp2 = $value;
                if ($value['subrd_type'] == 1 && $value['active_stat'] == 'No') {
                    $summary_count['new_village_current']++;
                }
                if ($value['subrd_type'] == 2) {
                    $summary_count['new_village_recommand']++;
                }
                if (in_array($value['subrd_type'], [2, 3])) {
                    $summary_count['new_villageexport']++; 
                    if (isset($summary_count[$value['rpi']])) {
                        $summary_count[$value['rpi']]++; 
                    }
                }
                $temp2['color'] = CommonController::getcolor_bysubrd('l_' . $split_color);
                
                if ($value['subrd_type'] == 2) {
                    if ($value['active_stat'] == 'Yes') {
                        $temp2['color'] = CommonController::getcolor_bysubrd('l_grey');
                    }
                    if ($value['active_stat'] == 'No') {
                        $temp2['color'] = CommonController::getcolor_bysubrd('l_' . $split_color);   
                    }
                } 
                if ($value['subrd_type'] == 1) {
                    if ($value['active_stat'] == 'Yes' && $value['is_hub'] == 0) {
                        $temp2['color'] = CommonController::getcolor_bysubrd('l_grey');
                    }
                    if ($value['active_stat'] == 'No') {
                        $temp2['color'] = CommonController::getcolor_bysubrd('yellow');   
                    }
                }
                if ($temp['subrd_type'] == 5) {
                    $temp2['color'] = CommonController::getcolor_bysubrd('yellow');   
                }  
                        
                $cluster_type = $value['subrd_loaction'];
                $cluster_tag = ($value['subrd_type'] == 1 || $value['subrd_type'] == 5) ? 'Existg' : (($value['subrd_type'] == 2) ? 'Recommdd' : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));
                $cluster_hub = ($value['subrd_type'] == 1) ? 'Existg SubRD' : (($value['subrd_type'] == 2) ? 'Recommd SubRD' : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));
                $value['village_census'] = ltrim($value['village_census'], 0);
                
                if (isset($maparray[$value['village_census']])) {
                    $value['village_choc_consmptn'] = ($value['village_choc_consmptn'] != '') ? $value['village_choc_consmptn'] : 0;
                    $value['village_choc_consmptn'] = is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $value['village_choc_consmptn']), 0);
                    $value['cluster_type'] = $cluster_type;
                    $temp2['shareinfo'] = 'Village: ' . $value['village_name'] . '; Taluk: ' . $value['taluk_name'] . '; Distt: ' . $value['district_name'] . '; State: ' . $value['state_name'] . ';Recommendation: ' . $cluster_type . ';Distance from ' . $cluster_hub . ' (km): 0 kms; Population: ' . $value['population'] . ' Nos.; Rural Progressive Index: ' . $value['rpi'] . '; Outlet Potential: ' . $value['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $value['village_choc_consmptn'] . '; Market UID: ' . $value['market_id'] . '; BI Location ID: ' . $value['bi_id'] . ';SubRD Priority: ' . $value['subrd_priority'] . '; SubRD Cluster Priority: ' . $value['subrd_priority'] . '; ';

                    $temp2['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$value['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp2['shareinfo'] . '\',this)" lat="' . $value['latitude'] . '" lon="' . $value['longitude'] . '" id="share_' . $value['village_census'] . '" ><img class="ml-1" style="cursor:pointer;" geocode="' . $value['latitude'] . ',' . $value['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $value['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $value['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $value['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">' . (($userid == 13285) ? "Recommendatn" : "Recommendatn") . ':</span> ' . $cluster_type . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>' . $value['cluster_id'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from ' . $cluster_hub . ' (km): </span>' . $value['distance_subrd'] . ' kms</p>';
                    if ($user->client_id == 1000 && $value['sector'] == 'Rural') {
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($value['population'], 0) . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p>';
                    }
                    if ($user->client_id != 1000) {
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($value['population'], 0) . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Coca-Cola Cvrg Nos.: </span> ' . number_format($final_result[$k]['mdlz_retlr_universe'], 0) . ' Nos.</p>';
                    }

                    if ($value['subrd_type'] == 1 && $user->client_id == 120) {
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $mdlz . ': </span>' . $value['mdlz_retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>' . number_format($value['avg_monthly_sale'], 0) . ' Nos.</p>';
                    }
                    if ($user->client_id == 1000 && $value['sector'] == 'Rural') {          
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $value['village_choc_consmptn'] . ' </p>';
                    }
                    if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999) {
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $value['village_choc_consmptn'] . ' </p>';
                    }
                    if ($user->client_id == 9999) {
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $value['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $value['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $value['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $value['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $value['rly_stn'] . '</p>';
                    }
                        
                    $rural_img = ($value['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $value['rpi_img'] . '.jpg"></img>';
                    $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >' . $rural_img . '</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>' . $cluster_tag . ' </p>';

                    if (in_array($value['subrd_type'], [2, 3]) && $user->client_id == 120) {                
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> ' . $value['subrd_priority'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>' . $value['subrd_priority'] . '</p>';
                    }
                    if ($user->client_id == 120) {
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $value['market_id'] . '</span></p>';
                    }
                    if (in_array($value['subrd_type'], [1]) && $user->client_id == 120) {  
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD ' . (($userid == 13285) ? "" : " Name") . ': </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                    }
                    if ($user->client_id != 120 && $user->client_id != 112) {
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >' . $value['bi_id'] . ' </span></p>';
                        if (in_array($value['subrd_type'], [1])) {
                            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                        }
                    }

                    if ($user->client_id == 112) {
                        if (in_array($value['subrd_type'], [1])) {
                            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                        }
                        if (in_array($value['subrd_type'], [5])) {
                            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Name: </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                        }
                    }
                
                    $value['population'] = number_format($value['population'], 0);
                    $value['village_name'] = $maparray[$value['village_census']]['location_name'];
                    $child_val = [0 => $value];
                    $value_json = htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
                    $temp2['info'] .= '<div class="popup-footer" style="text-align:center;cursor:pointer;padding:10px;" onclick="view_village_detail(' . $value_json . ')"><span class="navigate_location" style="background-color:none;">More Info</span></div></div>';
                    
                    if ($user->client_id == 133) {
                        $rural_img = ($value['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $value['rpi_img'] . '.jpg"></img>';
                        $temp2['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$value['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp2['shareinfo'] . '\',this)" lat="' . $value['latitude'] . '" lon="' . $value['longitude'] . '" id="share_' . $value['village_census'] . '" ><img class="ml-1" style="cursor:pointer;" geocode="' . $value['latitude'] . ',' . $value['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $value['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $value['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $value['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>' . $value['population'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >' . $rural_img . '</span></p><div ></div></div>'; 
                    }
                    $value['activate_status'] = $value['company_service_id'];
                    $cluster_tag = ($value['subrd_type'] == 1) ? 'Existg' : (($value['subrd_type'] == 2) ? 'Recommdd' : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));
                    $value['activate_marker'] = ($value['company_service_id'] == 1) ? 'rural_icon/active.png' : (($value['company_service_id'] == 2) ? 'rural_icon/initiated.png' : (($value['company_service_id'] == 3) ? 'rural_icon/deactivated.png' : (($value['company_service_id'] == 4) ? 'rural_icon/activated.png' : (($value['company_service_id'] == 5) ? 'rural_icon/deactivated.png' : 'NA'))));
                    
                    $temp2['size'] = 8;
                   /* $temp2['activate_status_icon'] = $value['activate_marker'];
                    $temp2['activate_status'] = $value['activate_status'];
                    $temp2['subrd_status'] = 0;
                    $temp2['subrd_marker'] = 'NA';             
                    $temp2['subrd_tooltip'] = '';

                        $temp2['activate_status'] = $value['activate_status'];
                        $temp2['subrd_status'] = 0;
                        $temp2['subrd_tooltip'] = '';

                        $temp2 = $this->buildVillageMarkers(
                            $temp2,
                            $temp2['subrd_marker'] ?? 'NA',
                            $value['activate_marker']
                        );
                
                    // CRITICAL FIX: Ensure $cluster_id is valid and strictly not null before resetting child village colors to white
                    if (!empty($cluster_id) && $cluster_id !== null) {
                        if (trim($value['cluster_id']) != trim($cluster_id)) {
                            $temp2['color']          = '#ffffff';
                            $temp2['fillColor']      = '#ffffff';
                            $temp2['fillOpacity']    = 1;

                            // ✅ Suppress child markers too
                            $temp2['subrd_marker']    = 'NA';
                            $temp2['activate_marker'] = 'NA';
                            $temp2['subrd_status']    = 0;
                            $temp2['subrd_tooltip']   = '';
                            $temp2['markers']         = []; // ✅ Clear combined markers array
                        }
                    }

                   // $maparray[$value['village_census']] = array_merge($maparray[$value['village_census']], $temp2);

                                    $temp2['markers'] = [];

                    if (
                        isset($temp2['subrd_marker']) &&
                        $temp2['subrd_marker'] != '' &&
                        $temp2['subrd_marker'] != 'NA'
                    ) {
                        $temp2['markers'][] = [
                            'icon' => $temp2['subrd_marker']
                        ];
                    }

                    if (
                        isset($value['activate_marker']) &&
                        $value['activate_marker'] != '' &&
                        $value['activate_marker'] != 'NA'
                    ) {
                        $temp2['markers'][] = [
                            'icon' => $value['activate_marker']
                        ];
                    }
                    $maparray[$value['village_census']] = array_merge($maparray[$value['village_census']], $temp2);
                }
            }
        }
                
        $data['legend'] = [];
        $data['legend'][0] = $summary_count;
        if ($user->client_id == 133) {
             $data['griddata'] = $this->getsubrd_pepsi($table_data);
        } else {
             $data['griddata'] = $this->getsubrd($table_data);
        }
        $data['child_list'] = $child_list;
        $data['mapdata'] = $maparray;
        
        if (isset($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0) {
            $data['head'] = implode(", ", $taluk_name) . ' sub-distt, ' . implode(", ", $district_name);
        } else if (isset($getfilter->filter_district) && count($getfilter->filter_district) > 0) {
             $data['head'] = implode(", ", $district_name) . ' distt, ' . implode(", ", $state_name);
        } else {
             $data['head'] = '';
        }

        return $data;
    }*/

public function Combine_subrd_backup23062026($maparray, $type, $main_location, $sub_location, $input_obj, $current_location)
{
$getfilter = json_decode($input_obj ?? '{}');

if (!isset($getfilter->type_view)) {
    $type_view = [];
} else {
    $type_view = explode(",", $getfilter->type_view);
}

$cluster_id = data_get($getfilter, 'cluster_id');
if (empty($cluster_id) || $cluster_id === 'undefined' || $cluster_id === 'null' || $cluster_id === '') {
    $cluster_id = null;
}

if (in_array(4, $type_view)) {
    return $this->Combine_krishnagiri_subrd($maparray, $type, $main_location, $sub_location, $input_obj, $current_location);
}
if (in_array(15, $type_view)) {
    return $this->Combine_subrd_feederMenu($maparray, $type, $main_location, $sub_location, $input_obj, $current_location);
}

$user   = auth()->user();
$userid = $user->id;

$tbllist = [120 => 'subrd_data', 123 => 'subrd_data_perfetti', 112 => 'coke_subrd_data_all', 133 => 'subrd_data', 1000 => 'subrd_data_haldiram', 9999 => 'subrd_data_mars'];
$consmtp = [120 => 'Villg. Choc Consmptn', 123 => 'Confectionery Consmptn', 112 => 'Confectionery Consmptn', 133 => '', 1000 => '', 9999 => 'Confectionery Consmptn'];

$data       = [];
$getdetail  = [];
$color      = ['green', 'red', 'lavender', 'pink', 'orange', 'fgreen', 'chaani'];

if ($userid == 13285) {
    $consmtp[120] = 'Catgry Consmptn';
}

$data['result']  = [];
$data['mapdata'] = [];

$summary_count = [
    'Develpd'               => 0,
    'Most Develpd'          => 0,
    'Under-develpd'         => 0,
    'Transition'            => 0,
    'Not Rated'             => 0,
    'total_village'         => 0,
    'new_village'           => 0,
    'show_summary'          => 0,
    'new_village_current'   => 0,
    'new_village_recommand' => 0,
    'new_villageexport'     => 0,
];

$orwhere = [];
if (isset($getfilter->filter_district) && is_array($getfilter->filter_district) && count($getfilter->filter_district) > 0) {
    array_push($orwhere, " a.loc9 in (" . implode(",", $getfilter->filter_district) . ")");
}
if (isset($getfilter->filter_taluk) && is_array($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0) {
    array_push($orwhere, " a.taluk_census in (" . implode(",", $getfilter->filter_taluk) . ")");
}

$str = '';
if (filled($cluster_id)) {
    if (is_array($cluster_id)) $cluster_id = implode(',', $cluster_id);
    $str .= " AND a.cluster_id='" . addslashes($cluster_id) . "'";
}
if (count($orwhere) > 0) {
    $str .= " and (" . join(" or ", $orwhere) . ") ";
}
if (isset($getfilter->filter_priority) && $getfilter->filter_priority != '') {
    $str .= ' and a.subrd_priority="' . $getfilter->filter_priority . '"';
}
if (isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd != '') {
    $str .= ' and a.exist_subrd_code="' . $getfilter->filter_existsubrd . '"';
}

$select = '';
if ($user->client_id == 9999) {
    $select = ',no_of_schools,no_of_colleges,hh,if(atm="-","No",atm) atm,if(bank="-","No",bank) bank,if(nh="-","No",nh) nh,if(sh="-","No",sh) sh,if(rly_stn="-","No",rly_stn) rly_stn';
}

$sql    = "SELECT a.village_cover_status,b.state_code,a.`refid`,a.`cluster_id`,a.`cluster_name`,a.`state_name`,a.`district_name`,a.`taluk_name`,a.`village_name`,a.`sector`,a.`loc7`,a.`loc9`,a.`loc10`,a.`loc13`,a.`loc12`,a.`market_id`,a.`bi_id`,a.`distance_subrd`,a.`subrd_loaction`,a.`outlet_potential`,a.`population`,a.`taluk_census`,a.`village_census`,a.village_choc_consmptn as village_choc_consmptn,a.`cluster_tag`,a.`stat`,a.`subrd_type`,a.`subrd_type_whlsl`,a.`is_hub`,a.`hub_id`,a.`subrd_priority`,a.active_stat,a.`tsm_id`,a.`village_2011_census`,a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale" . $select . " FROM " . $tbllist[$user->client_id] . " as a,town_village_polygon as b where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code " . $str . " and b.stat='A'";
\Log::info('SQL: ' . $sql);
$result = DB::select(DB::raw($sql));
$result = CommonController::getarray($result);

$final_result  = [];
$inc           = 0;
$taluk_name    = array_unique(array_column($result, 'taluk_name'));
$district_name = array_unique(array_column($result, 'district_name'));
$state_name    = array_unique(array_column($result, 'state_code'));
$table_data    = [];
$priority      = ['Priority 1' => 'rural_icon/r_p1.png', 'Priority 2' => 'rural_icon/r_p2.png', 'Priority 3' => 'rural_icon/r_p3.png', '' => 'rural_icon/recommendation.png', 'P1' => 'rural_icon/r_p1.png', 'P2' => 'rural_icon/r_p2.png'];
$without_hub   = $result;
$non_cluster_color = [];
$child_list    = [];

for ($i = 0; $i < count($result); $i++) {
    if ($result[$i]['is_hub'] == 1 && in_array($result[$i]['subrd_type'], $type_view)) {
        $result[$i]['village_census'] = ltrim($result[$i]['village_census'], 0);
        if (isset($maparray[$result[$i]['village_census']])) {
            $final_result[$inc]                  = $result[$i];
            $final_result[$inc]['child']          = [];
            $filter_id                            = $result[$i]['cluster_id'];
            $final_result[$inc]['subrd_marker']   = ($result[$i]['subrd_type'] == 1) ? 'rural_icon/efficient-subrd.png' : (($result[$i]['subrd_type'] == 2) ? $priority[$result[$i]['subrd_priority']] : (($result[$i]['subrd_type'] == 5) ? 'rural_icon/D.png' : 'NA'));
            $final_result[$inc]['subrd_tooltip']  = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$result[$i]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $result[$i]['cluster_name'] . '</li></ul></div></div></div>';

            $sqlCluster    = "SELECT a.village_cover_status,b.state_code,a.`refid`,a.`cluster_id`,a.`cluster_name`,a.`state_name`,a.`district_name`,a.`taluk_name`,a.`village_name`,a.`sector`,a.`loc7`,a.`loc9`,a.`loc10`,a.`loc13`,a.`loc12`,a.`market_id`,a.`bi_id`,a.`distance_subrd`,a.`subrd_loaction`,a.`outlet_potential`,a.`population`,a.`taluk_census`,a.`village_census`,a.village_choc_consmptn as village_choc_consmptn,a.`cluster_tag`,a.`stat`,a.`subrd_type`,a.`subrd_type_whlsl`,a.`is_hub`,a.`hub_id`,a.`subrd_priority`,a.`tsm_id`,a.`village_2011_census`,a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale" . $select . " FROM " . $tbllist[$user->client_id] . " as a,town_village_polygon as b where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code and a.cluster_id='" . $result[$i]['cluster_id'] . "' and b.stat='A'";
            $resultCluster = DB::select(DB::raw($sqlCluster));
            $resultCluster = CommonController::getarray($resultCluster);

            $hub_child_list = array_filter($resultCluster, function ($var) use ($filter_id) {
                return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
            });
            $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                return ($var['cluster_id'] != $filter_id);
            });

            $final_result[$inc]['child'] = $hub_child_list;
            $res_arr                     = $result[$i];
            $child_list[$filter_id]      = $hub_child_list;
            $res_arr['child']            = htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
            $res_arr['child_count']      = count($hub_child_list);
            $res_arr['child_d']          = $hub_child_list;
            $inc++;
            array_push($table_data, $res_arr);
        }
    } elseif ($result[$i]['subrd_type'] == 0 || !in_array($result[$i]['subrd_type'], $type_view)) {
        $result[$i]['village_census'] = ltrim($result[$i]['village_census'], 0);
        if (isset($maparray[$result[$i]['village_census']])) {
            $final_result[$inc]                 = $result[$i];
            $final_result[$inc]['child']         = [];
            $final_result[$inc]['child_d']       = [];
            $final_result[$inc]['subrd_marker']  = 'NA';
            $child_list[$result[$i]['cluster_id']] = [];
            $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$result[$i]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $result[$i]['cluster_name'] . '</li></ul></div></div></div>';
            $inc++;
        }
    }
}

$without_hub       = array_values($without_hub);
$without_hub_count = count($without_hub);
$mdlz              = ($user->id == 13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";

for ($i = 0; $i < $without_hub_count; $i++) {
    $without_hub[$i]['village_census'] = ltrim($without_hub[$i]['village_census'], 0);
    if (isset($maparray[$without_hub[$i]['village_census']])) {
        if ($without_hub[$i]['subrd_type'] == 1 && $without_hub[$i]['active_stat'] == 'No') $summary_count['new_village_current']++;
        if ($without_hub[$i]['subrd_type'] == 2) $summary_count['new_village_recommand']++;
        if (in_array($without_hub[$i]['subrd_type'], [1, 2, 3])) {
            if (in_array($without_hub[$i]['subrd_type'], [2, 3]) && in_array($without_hub[$i]['subrd_type'], $type_view)) {
                $summary_count['show_summary'] = $without_hub[$i]['subrd_type'];
            }
        }
        $final_result[$inc]                = $without_hub[$i];
        $final_result[$inc]['child']       = [];
        $final_result[$inc]['subrd_marker'] = ($without_hub[$i]['subrd_type'] == 1) ? 'rural_icon/efficient-subrd.png' : (($without_hub[$i]['subrd_type'] == 2) ? $priority[$without_hub[$i]['subrd_priority']] : (($without_hub[$i]['subrd_type'] == 5) ? 'rural_icon/D.png' : 'NA'));
        $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$without_hub[$i]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $without_hub[$i]['cluster_name'] . '</li></ul></div></div></div>';
        $inc++;
    }
}

$result_count = count($final_result);
$temp         = [];
$split_color  = 'none';

for ($k = 0; $k < $result_count; $k++) {
    $temp = $final_result[$k];

    // Determine split_color for this hub
    if ($temp['subrd_type'] == 1 && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
        $split_color = ($temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' || $temp['subrd_loaction'] == 'Existing Urban Distbtr') ? 'lblue' : 'grey';
    } elseif ($temp['subrd_type'] == 2 && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
        $range       = array_rand(range(0, count($color) - 1));
        $split_color = $color[$range];
    } elseif ($temp['subrd_type'] == 3 && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
        $split_color = 'fgreen';
    } elseif ($temp['subrd_type'] == 5 && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
        $split_color = 'blue';
        $hub         = CommonController::getcolor_bysubrd('d_' . $split_color);
    } elseif ($temp['subrd_type'] == 0) {
        $split_color = 'none';
    } else {
        $split_color = 'none';
    }

    if (in_array($temp['subrd_type'], [2, 3]) && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) {
        $summary_count['total_village']++;
        if ($summary_count['show_summary'] == '') $summary_count['show_summary'] = $temp['subrd_type'];
    }

    unset($temp['child']);

    // Determine hub color
    if ($temp['is_hub'] != 1 && $temp['subrd_type'] != 0) {
        $hub = '#ffffff';
        if (($temp['active_stat'] == 'Yes' || $temp['active_stat'] == '') && $temp['subrd_type'] == 1 && in_array($temp['subrd_type'], $type_view)) {
            $hub = CommonController::getcolor_bysubrd('l_grey');
        }
        if ($temp['active_stat'] == 'No' && $temp['subrd_type'] == 1 && in_array($temp['subrd_type'], $type_view)) {
            $hub = CommonController::getcolor_bysubrd('yellow');
        }
        if ($temp['subrd_loaction'] == 'Existing Urban Distbtr' && $temp['subrd_type'] == 1 && in_array($temp['subrd_type'], $type_view)) {
            $hub = CommonController::getcolor_bysubrd('l_lblue');
        }
        if (($temp['subrd_type'] == 2 || $temp['subrd_type'] == 3) && in_array($temp['subrd_type'], $type_view)) {
            if (isset($non_cluster_color[$temp['cluster_name']]) && $temp['subrd_type'] != 3) {
                $hub = CommonController::getcolor_bysubrd('l_' . $non_cluster_color[$temp['cluster_name']]);
            } elseif ($temp['subrd_type'] != 3) {
                $range       = array_rand(range(0, count($color) - 1));
                $split_color = $color[$range];
                $hub         = CommonController::getcolor_bysubrd('l_' . $split_color);
                $non_cluster_color[$temp['cluster_name']] = $split_color;
            } else {
                $hub = CommonController::getcolor_bysubrd('l_fgreen');
            }
        }
    } else {
        $hub = CommonController::getcolor_bysubrd('d_' . $split_color);
    }

    $cluster_type = $final_result[$k]['subrd_loaction'];
    $final_result[$k]['activate_status'] = $final_result[$k]['company_service_id'];

    $cluster_tag = (($final_result[$k]['subrd_type'] == 1 || $final_result[$k]['subrd_type'] == 5) && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'SubRD Existg' : (($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Recommdd' : (($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Wholesaler' : ''));
    $cluster_hub  = ($final_result[$k]['subrd_type'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Existg SubRD' : (($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Recommdd SubRD' : (($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Wholesaler' : ''));

    $temp['activate_marker'] = ($final_result[$k]['company_service_id'] == 1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id'] == 2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id'] == 3) ? 'rural_icon/deactivated.png' : (($final_result[$k]['company_service_id'] == 4) ? 'rural_icon/activated.png' : (($final_result[$k]['company_service_id'] == 5) ? 'rural_icon/deactivated.png' : 'NA'))));

    if ($temp['is_hub'] != 0) {
        $temp['subrd_status'] = in_array($final_result[$k]['subrd_type'], $type_view) ? $final_result[$k]['subrd_type'] : 0;

        $subrd_marker = 'NA';
        if ($final_result[$k]['subrd_type'] == 5) {
            $subrd_marker = 'rural_icon/Distributr.png';
        } elseif ($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) {
            $subrd_marker = $priority[$final_result[$k]['subrd_priority']];
        } elseif ($final_result[$k]['subrd_type'] == 1 && $temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'], $type_view)) {
            $subrd_marker = 'rural_icon/urban-distributor.png';
        } elseif ($final_result[$k]['subrd_type'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) {
            $subrd_marker = 'rural_icon/efficient-subrd.png';
        } elseif ($final_result[$k]['subrd_type_whlsl'] == 3 && in_array($final_result[$k]['subrd_type_whlsl'], $type_view)) {
            $subrd_marker = 'rural_icon/Wholesale.png';
        }

        $temp['subrd_marker']  = $subrd_marker;
        $temp['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$final_result[$k]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $cluster_tag . '</li></ul></div></div></div>';
    } else {
        $temp['subrd_status']  = 0;
        $temp['subrd_marker']  = 'NA';
        $temp['subrd_tooltip'] = '';
    }

    // Build info HTML (unchanged from your original)
    if ($final_result[$k]['subrd_type'] != 0 && in_array($final_result[$k]['subrd_type'], $type_view)) {
        $temp['shareinfo'] = 'Village: ' . $final_result[$k]['village_name'] . '; Taluk: ' . $final_result[$k]['taluk_name'] . '; Distt: ' . $final_result[$k]['district_name'] . '; State: ' . $final_result[$k]['state_name'] . ';Recommendation: ' . $cluster_type . ';Distance from ' . $cluster_hub . ' (km): 0 kms; Population: ' . $final_result[$k]['population'] . ' Nos.; Rural Progressive Index: ' . $final_result[$k]['rpi'] . '; Outlet Potential: ' . $final_result[$k]['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $final_result[$k]['village_choc_consmptn'] . '; Market UID: ' . $final_result[$k]['market_id'] . '; BI Location ID: ' . $final_result[$k]['bi_id'] . ';SubRD Priority: ' . $final_result[$k]['subrd_priority'] . '; SubRD Cluster Priority: ' . $final_result[$k]['subrd_priority'] . '; ';
        $final_result[$k]['village_choc_consmptn'] = ($final_result[$k]['village_choc_consmptn'] != '') ? $final_result[$k]['village_choc_consmptn'] : 0;
        $final_result[$k]['village_choc_consmptn'] = is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $final_result[$k]['village_choc_consmptn']), 0);
        $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $result[0]['latitude'] . '" lon="' . $result[0]['longitude'] . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">' . (($userid == 13285) ? "Recommendatn" : "Recommendatn") . ':</span> ' . $cluster_type . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>' . $final_result[$k]['cluster_id'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from ' . $cluster_hub . ' (km): </span>0 kms</p>';
        if ($user->client_id != 1000) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
        }
        $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Coca-Cola Cvrg Nos.: </span> ' . number_format($final_result[$k]['mdlz_retlr_universe'], 0) . ' Nos.</p>';
        if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
        }
        if ($final_result[$k]['subrd_type'] == 1 && $user->client_id == 120) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $mdlz . ': </span>' . $final_result[$k]['mdlz_retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>' . number_format($final_result[$k]['avg_monthly_sale'], 0) . ' Nos.</p>';
        }
        if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
        }
        if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
        }
        if ($user->client_id == 9999) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $final_result[$k]['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $final_result[$k]['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $final_result[$k]['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $final_result[$k]['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $final_result[$k]['rly_stn'] . '</p>';
        }
        $rural_img     = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
        $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>' . $cluster_tag . ' </p>';
        if (in_array($final_result[$k]['subrd_type'], [2, 3]) && $user->client_id == 120) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> ' . $final_result[$k]['subrd_priority'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>' . $final_result[$k]['subrd_priority'] . '</p>';
        }
        if (in_array($final_result[$k]['subrd_type'], [1]) && $user->client_id == 120) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD' . (($userid == 13285) ? "" : " Name") . ': </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
        }
        if ($user->client_id == 120) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['market_id'] . '</span></p>';
        }
        if ($user->client_id != 120) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['bi_id'] . ' </span></p>';
            if (in_array($final_result[$k]['subrd_type'], [1])) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
            }
        }
        $final_result[$k]['population']              = number_format($final_result[$k]['population'], 0);
        $final_result[$k]['village_name']            = $maparray[$final_result[$k]['village_census']]['location_name'];
        $final_result[$k]['cluster_type']            = $cluster_type;
        $detail        = htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
        $temp['info'] .= '<div class="popup-footer" style="cursor:pointer;padding:10px;text-align:center;" onclick="view_village_detail(' . $detail . ')">More Info</span></div></div>';
    } else {
        $final_result[$k]['population']              = is_numeric($final_result[$k]['population']) ? $final_result[$k]['population'] : 0;
        $final_result[$k]['village_choc_consmptn']   = is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $final_result[$k]['village_choc_consmptn']), 0);
        $temp['shareinfo'] = 'Village: ' . $final_result[$k]['village_name'] . '; Taluk: ' . $final_result[$k]['taluk_name'] . '; Distt: ' . $final_result[$k]['district_name'] . '; State: ' . $final_result[$k]['state_name'] . ';Population: ' . $final_result[$k]['population'] . ' Nos.; Rural Progressive Index: ' . $final_result[$k]['rpi'] . '; Outlet Potential: ' . $final_result[$k]['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $final_result[$k]['village_choc_consmptn'] . '; Market UID: ' . $final_result[$k]['market_id'] . '; BI Location ID: ' . $final_result[$k]['bi_id'] . '; ';
        $temp['info']  = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $result[0]['latitude'] . '" lon="' . $result[0]['longitude'] . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;">';
        if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
        }
        if ($user->client_id != 1000) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
        }
        if ($user->client_id != 112 && $user->client_id != 9999) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;"> ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
        }
        if ($user->client_id == 9999) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $final_result[$k]['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $final_result[$k]['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $final_result[$k]['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $final_result[$k]['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $final_result[$k]['rly_stn'] . '</p>';
        }
        $rural_img     = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
        $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p>';
        if ($user->client_id == 120) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['market_id'] . '</span></p>';
        }
        if ($user->client_id != 120) {
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['bi_id'] . ' </span></p>';
        }
        $final_result[$k]['village_name'] = $maparray[$final_result[$k]['village_census']]['location_name'];
        $detail        = htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
        $temp['info'] .= '<div class="popup-footer" style="text-align:center;cursor:pointer;padding:10px;" onclick="view_village_detail(' . $detail . ')"><span class="navigate_location" style="background-color:none;">More Info</span></div></div>';
    }

    if ($user->client_id == 133) {
        $final_result[$k]['population'] = is_numeric($final_result[$k]['population']) ? $final_result[$k]['population'] : 0;
        $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $result[0]['latitude'] . '" lon="' . $result[0]['longitude'] . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;">';
        $rural_img     = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
        $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p><div></div></div>';
    }

    $temp['size']            = 15;
    $temp['activate_status'] = $final_result[$k]['activate_status'];

    $temp = $this->buildVillageMarkers($temp, $temp['subrd_marker'], $temp['activate_marker']);

    // ─────────────────────────────────────────────────────────────────
    // BUILD markers array FIRST, then CRITICAL FIX suppresses if needed
    // ─────────────────────────────────────────────────────────────────
    $temp['markers'] = [];
    if (isset($temp['subrd_marker']) && $temp['subrd_marker'] != '' && $temp['subrd_marker'] != 'NA') {
        $temp['markers'][] = ['icon' => $temp['subrd_marker']];
    }
    if (isset($temp['activate_marker']) && $temp['activate_marker'] != '' && $temp['activate_marker'] != 'NA') {
        $temp['markers'][] = ['icon' => $temp['activate_marker']];
    }

    // ✅ CRITICAL FIX — runs AFTER markers built so suppression wins
    if (!empty($cluster_id) && $cluster_id !== null) {
        if (trim($final_result[$k]['cluster_id']) != trim($cluster_id)) {
            $hub                     = '#ffffff';
            $temp['color']           = '#ffffff';
            $temp['fillColor']       = '#ffffff';
            $temp['fillOpacity']     = 1;
            $temp['subrd_marker']    = 'NA';
            $temp['activate_marker'] = 'NA';
            $temp['subrd_status']    = 0;
            $temp['subrd_tooltip']   = '';
            $temp['markers']         = []; // ✅ Wins — last write
        }
    }

    $temp['color'] = $hub;

    $maparray[$final_result[$k]['village_census']] = array_merge(
        $maparray[$final_result[$k]['village_census']], $temp
    );

    // ── CHILD VILLAGES ───────────────────────────────────────────────
    foreach ($final_result[$k]['child'] as $key => $value) {
        $temp2 = $value;

        if ($value['subrd_type'] == 1 && $value['active_stat'] == 'No') $summary_count['new_village_current']++;
        if ($value['subrd_type'] == 2)                                    $summary_count['new_village_recommand']++;
        if (in_array($value['subrd_type'], [2, 3])) {
            $summary_count['new_villageexport']++;
            if (isset($summary_count[$value['rpi']])) $summary_count[$value['rpi']]++;
        }

        $temp2['color'] = CommonController::getcolor_bysubrd('l_' . $split_color);
        if ($value['subrd_type'] == 2) {
            $temp2['color'] = ($value['active_stat'] == 'Yes') ? CommonController::getcolor_bysubrd('l_grey') : CommonController::getcolor_bysubrd('l_' . $split_color);
        }
        if ($value['subrd_type'] == 1) {
            if ($value['active_stat'] == 'Yes' && $value['is_hub'] == 0) $temp2['color'] = CommonController::getcolor_bysubrd('l_grey');
            if ($value['active_stat'] == 'No')                           $temp2['color'] = CommonController::getcolor_bysubrd('yellow');
        }
        if ($temp['subrd_type'] == 5) {
            $temp2['color'] = CommonController::getcolor_bysubrd('yellow');
        }

        $cluster_type = $value['subrd_loaction'];
        $cluster_tag  = ($value['subrd_type'] == 1 || $value['subrd_type'] == 5) ? 'Existg' : (($value['subrd_type'] == 2) ? 'Recommdd' : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));
        $cluster_hub  = ($value['subrd_type'] == 1) ? 'Existg SubRD' : (($value['subrd_type'] == 2) ? 'Recommd SubRD' : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));
        $value['village_census'] = ltrim($value['village_census'], 0);

        if (!isset($maparray[$value['village_census']])) continue;

        $value['village_choc_consmptn'] = ($value['village_choc_consmptn'] != '') ? $value['village_choc_consmptn'] : 0;
        $value['village_choc_consmptn'] = is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $value['village_choc_consmptn']), 0);
        $value['cluster_type']          = $cluster_type;

        $temp2['shareinfo'] = 'Village: ' . $value['village_name'] . '; Taluk: ' . $value['taluk_name'] . '; Distt: ' . $value['district_name'] . '; State: ' . $value['state_name'] . ';Recommendation: ' . $cluster_type . ';Distance from ' . $cluster_hub . ' (km): 0 kms; Population: ' . $value['population'] . ' Nos.; Rural Progressive Index: ' . $value['rpi'] . '; Outlet Potential: ' . $value['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $value['village_choc_consmptn'] . '; Market UID: ' . $value['market_id'] . '; BI Location ID: ' . $value['bi_id'] . ';SubRD Priority: ' . $value['subrd_priority'] . '; SubRD Cluster Priority: ' . $value['subrd_priority'] . '; ';
        $temp2['info']      = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$value['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp2['shareinfo'] . '\',this)" lat="' . $value['latitude'] . '" lon="' . $value['longitude'] . '" id="share_' . $value['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $value['latitude'] . ',' . $value['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $value['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $value['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $value['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">' . (($userid == 13285) ? "Recommendatn" : "Recommendatn") . ':</span> ' . $cluster_type . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>' . $value['cluster_id'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from ' . $cluster_hub . ' (km): </span>' . $value['distance_subrd'] . ' kms</p>';
        if ($user->client_id == 1000 && $value['sector'] == 'Rural') {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($value['population'], 0) . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p>';
        }
        if ($user->client_id != 1000) {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($value['population'], 0) . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Coca-Cola Cvrg Nos.: </span> ' . number_format($final_result[$k]['mdlz_retlr_universe'], 0) . ' Nos.</p>';
        }
        if ($value['subrd_type'] == 1 && $user->client_id == 120) {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $mdlz . ': </span>' . $value['mdlz_retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>' . number_format($value['avg_monthly_sale'], 0) . ' Nos.</p>';
        }
        if ($user->client_id == 1000 && $value['sector'] == 'Rural') {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $value['village_choc_consmptn'] . ' </p>';
        }
        if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999) {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $value['village_choc_consmptn'] . ' </p>';
        }
        if ($user->client_id == 9999) {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $value['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $value['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $value['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $value['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $value['rly_stn'] . '</p>';
        }
        $rural_img      = ($value['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $value['rpi_img'] . '.jpg"></img>';
        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>' . $cluster_tag . ' </p>';
        if (in_array($value['subrd_type'], [2, 3]) && $user->client_id == 120) {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> ' . $value['subrd_priority'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>' . $value['subrd_priority'] . '</p>';
        }
        if ($user->client_id == 120) {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $value['market_id'] . '</span></p>';
        }
        if (in_array($value['subrd_type'], [1]) && $user->client_id == 120) {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD ' . (($userid == 13285) ? "" : " Name") . ': </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
        }
        if ($user->client_id != 120 && $user->client_id != 112) {
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;">' . $value['bi_id'] . ' </span></p>';
            if (in_array($value['subrd_type'], [1])) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
            }
        }
        if ($user->client_id == 112) {
            if (in_array($value['subrd_type'], [1])) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
            }
            if (in_array($value['subrd_type'], [5])) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Name: </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
            }
        }

        $value['population']  = number_format($value['population'], 0);
        $value['village_name'] = $maparray[$value['village_census']]['location_name'];
        $child_val             = [0 => $value];
        $value_json            = htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
        $temp2['info']        .= '<div class="popup-footer" style="text-align:center;cursor:pointer;padding:10px;" onclick="view_village_detail(' . $value_json . ')"><span class="navigate_location" style="background-color:none;">More Info</span></div></div>';

        if ($user->client_id == 133) {
            $rural_img      = ($value['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $value['rpi_img'] . '.jpg"></img>';
            $temp2['info']  = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$value['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp2['shareinfo'] . '\',this)" lat="' . $value['latitude'] . '" lon="' . $value['longitude'] . '" id="share_' . $value['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $value['latitude'] . ',' . $value['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $value['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $value['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $value['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>' . $value['population'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p><div></div></div>';
        }

        $value['activate_status']  = $value['company_service_id'];
        $cluster_tag               = ($value['subrd_type'] == 1) ? 'Existg' : (($value['subrd_type'] == 2) ? 'Recommdd' : (($value['subrd_type'] == 3) ? 'Wholesaler' : ''));
        $value['activate_marker']  = ($value['company_service_id'] == 1) ? 'rural_icon/active.png' : (($value['company_service_id'] == 2) ? 'rural_icon/initiated.png' : (($value['company_service_id'] == 3) ? 'rural_icon/deactivated.png' : (($value['company_service_id'] == 4) ? 'rural_icon/activated.png' : (($value['company_service_id'] == 5) ? 'rural_icon/deactivated.png' : 'NA'))));

        $temp2['size']           = 8;
        $temp2['activate_status'] = $value['activate_status'];
        $temp2['subrd_status']   = 0;
        $temp2['subrd_tooltip']  = '';

        $temp2 = $this->buildVillageMarkers($temp2, $temp2['subrd_marker'] ?? 'NA', $value['activate_marker']);

        // ─────────────────────────────────────────────────────────────
        // BUILD child markers FIRST, then CRITICAL FIX suppresses
        // ─────────────────────────────────────────────────────────────
        $temp2['markers'] = [];
        if (isset($temp2['subrd_marker']) && $temp2['subrd_marker'] != '' && $temp2['subrd_marker'] != 'NA') {
            $temp2['markers'][] = ['icon' => $temp2['subrd_marker']];
        }
        if (isset($value['activate_marker']) && $value['activate_marker'] != '' && $value['activate_marker'] != 'NA') {
            $temp2['markers'][] = ['icon' => $value['activate_marker']];
        }

        // ✅ CRITICAL FIX — runs AFTER child markers built so suppression wins
        if (!empty($cluster_id) && $cluster_id !== null) {
            if (trim($value['cluster_id']) != trim($cluster_id)) {
                $temp2['color']           = '#ffffff';
                $temp2['fillColor']       = '#ffffff';
                $temp2['fillOpacity']     = 1;
                $temp2['subrd_marker']    = 'NA';
                $temp2['activate_marker'] = 'NA';
                $temp2['subrd_status']    = 0;
                $temp2['subrd_tooltip']   = '';
                $temp2['markers']         = []; // ✅ Wins — last write
            }
        }

            $maparray[$value['village_census']] = array_merge(
            $maparray[$value['village_census']], $temp2
        );
    }
}

$data['legend']    = [];
$data['legend'][0] = $summary_count;
$data['griddata']  = ($user->client_id == 133) ? $this->getsubrd_pepsi($table_data) : $this->getsubrd($table_data);
$data['child_list'] = $child_list;
$data['mapdata']   = $maparray;

if (isset($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0) {
    $data['head'] = implode(", ", $taluk_name) . ' sub-distt, ' . implode(", ", $district_name);
} elseif (isset($getfilter->filter_district) && count($getfilter->filter_district) > 0) {
    $data['head'] = implode(", ", $district_name) . ' distt, ' . implode(", ", $state_name);
} else {
    $data['head'] = '';
}

return $data;
}
public function Combine_subrd($maparray, $type, $main_location, $sub_location, $input_obj, $current_location)
{
    $getfilter = json_decode($input_obj ?? '{}');

    if (!isset($getfilter->type_view)) {
        $type_view = [];
    } else {
        $type_view = explode(",", $getfilter->type_view);
    }
    // Flip for O(1) lookups instead of O(N) in_array calls
    $type_view_map = array_flip($type_view);

    $cluster_id = data_get($getfilter, 'cluster_id');
    if (empty($cluster_id) || $cluster_id === 'undefined' || $cluster_id === 'null' || $cluster_id === '') {
        $cluster_id = null;
    }

    if (isset($type_view_map[4])) {
        return $this->Combine_krishnagiri_subrd($maparray, $type, $main_location, $sub_location, $input_obj, $current_location);
    }
    if (isset($type_view_map[15])) {
        return $this->Combine_subrd_feederMenu($maparray, $type, $main_location, $sub_location, $input_obj, $current_location);
    }

    $user   = auth()->user();
    $userid = $user->id;

    $tbllist = [120 => 'subrd_data', 123 => 'subrd_data_perfetti', 112 => 'coke_subrd_data_all', 133 => 'subrd_data', 1000 => 'subrd_data_haldiram', 9999 => 'subrd_data_mars'];
    $consmtp = [120 => 'Villg. Choc Consmptn', 123 => 'Confectionery Consmptn', 112 => 'Confectionery Consmptn', 133 => '', 1000 => '', 9999 => 'Confectionery Consmptn'];

    if ($userid == 13285) {
        $consmtp[120] = 'Catgry Consmptn';
    }

    $color = ['green', 'red', 'lavender', 'pink', 'orange', 'fgreen', 'chaani'];
    $color_count = count($color);

    $summary_count = [
        'Develpd'               => 0,
        'Most Develpd'          => 0,
        'Under-develpd'         => 0,
        'Transition'            => 0,
        'Not Rated'             => 0,
        'total_village'         => 0,
        'new_village'           => 0,
        'show_summary'          => 0,
        'new_village_current'   => 0,
        'new_village_recommand' => 0,
        'new_villageexport'     => 0,
    ];

    $orwhere = [];
    if (isset($getfilter->filter_district) && is_array($getfilter->filter_district) && count($getfilter->filter_district) > 0) {
        array_push($orwhere, " a.loc9 in (" . implode(",", $getfilter->filter_district) . ")");
    }
    if (isset($getfilter->filter_taluk) && is_array($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0) {
        array_push($orwhere, " a.taluk_census in (" . implode(",", $getfilter->filter_taluk) . ")");
    }

    $str = '';
    if (filled($cluster_id)) {
        if (is_array($cluster_id)) $cluster_id = implode(',', $cluster_id);
        $str .= " AND a.cluster_id='" . addslashes($cluster_id) . "'";
    }
    if (count($orwhere) > 0) {
        $str .= " and (" . join(" or ", $orwhere) . ") ";
    }
    if (isset($getfilter->filter_priority) && $getfilter->filter_priority != '') {
        $str .= ' and a.subrd_priority="' . $getfilter->filter_priority . '"';
    }
    if (isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd != '') {
        $str .= ' and a.exist_subrd_code="' . $getfilter->filter_existsubrd . '"';
    }

    $select = '';
    if ($user->client_id == 9999) {
        $select = ',no_of_schools,no_of_colleges,hh,if(atm="-","No",atm) atm,if(bank="-","No",bank) bank,if(nh="-","No",nh) nh,if(sh="-","No",sh) sh,if(rly_stn="-","No",rly_stn) rly_stn';
    }

    $tableName = $tbllist[$user->client_id];
    $fields = "a.village_cover_status,b.state_code,a.`refid`,a.`cluster_id`,a.`cluster_name`,a.`state_name`,a.`district_name`,a.`taluk_name`,a.`village_name`,a.`sector`,a.`loc7`,a.`loc9`,a.`loc10`,a.`loc13`,a.`loc12`,a.`market_id`,a.`bi_id`,a.`distance_subrd`,a.`subrd_loaction`,a.`outlet_potential`,a.`population`,a.`taluk_census`,a.`village_census`,a.village_choc_consmptn as village_choc_consmptn,a.`cluster_tag`,a.`stat`,a.`subrd_type`,a.`subrd_type_whlsl`,a.`is_hub`,a.`hub_id`,a.`subrd_priority`,a.active_stat,a.`tsm_id`,a.`village_2011_census`,a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale" . $select;
    
    $sql = "SELECT " . $fields . " FROM " . $tableName . " as a,town_village_polygon as b where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code " . $str . " and b.stat='A'";
    
    \Log::info('SQL: ' . $sql);
    $result = CommonController::getarray(DB::select(DB::raw($sql)));

    $taluk_name    = array_unique(array_column($result, 'taluk_name'));
    $district_name = array_unique(array_column($result, 'district_name'));
    $state_name    = array_unique(array_column($result, 'state_code'));
    
    $priority      = ['Priority 1' => 'rural_icon/r_p1.png', 'Priority 2' => 'rural_icon/r_p2.png', 'Priority 3' => 'rural_icon/r_p3.png', '' => 'rural_icon/recommendation.png', 'P1' => 'rural_icon/r_p1.png', 'P2' => 'rural_icon/r_p2.png'];
    
    // Gather unique cluster IDs for hubs to fetch everything in ONE batch query
    $hub_cluster_ids = [];
    foreach ($result as $row) {
        if ($row['is_hub'] == 1 && isset($type_view_map[$row['subrd_type']])) {
            $hub_cluster_ids[] = $row['cluster_id'];
        }
    }
    $hub_cluster_ids = array_unique($hub_cluster_ids);

    // Eager loading clusters map setup
    $cluster_data_grouped = [];
    if (count($hub_cluster_ids) > 0) {
        $escaped_ids = array_map(function($id) { return "'" . addslashes($id) . "'"; }, $hub_cluster_ids);
        $sqlCluster = "SELECT " . $fields . " FROM " . $tableName . " as a,town_village_polygon as b where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code and a.cluster_id IN (" . implode(",", $escaped_ids) . ") and b.stat='A'";
        $clusterResult = CommonController::getarray(DB::select(DB::raw($sqlCluster)));
        
        foreach ($clusterResult as $row) {
            $cluster_data_grouped[$row['cluster_id']][] = $row;
        }
    }

    $final_result  = [];
    $inc           = 0;
    $table_data    = [];
    $non_cluster_color = [];
    $child_list    = [];
    $removed_clusters = [];

    // First loop: Process Hub and Non-Hub elements
    foreach ($result as $row) {
        $subrd_type = $row['subrd_type'];
        if ($row['is_hub'] == 1 && isset($type_view_map[$subrd_type])) {
            $row['village_census'] = ltrim($row['village_census'], '0');
            if (isset($maparray[$row['village_census']])) {
                $final_result[$inc] = $row;
                $final_result[$inc]['child'] = [];
                $filter_id = $row['cluster_id'];
                $final_result[$inc]['subrd_marker'] = ($subrd_type == 1) ? 'rural_icon/efficient-subrd.png' : (($subrd_type == 2) ? $priority[$row['subrd_priority']] : (($subrd_type == 5) ? 'rural_icon/D.png' : 'NA'));
                $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$row['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $row['cluster_name'] . '</li></ul></div></div></div>';

                // Fetch from pre-loaded memory grid instead of database execution
                $resultCluster = $cluster_data_grouped[$filter_id] ?? [];
                
                $hub_child_list = [];
                foreach ($resultCluster as $cRow) {
                    if ($cRow['cluster_id'] == $filter_id && $cRow['is_hub'] != 1) {
                        $hub_child_list[] = $cRow;
                    }
                }
                
                // Track clusters removed from without_hub using memory pointers instead of array_filter
                $removed_clusters[$filter_id] = true;

                $final_result[$inc]['child'] = $hub_child_list;
                $res_arr = $row;
                $child_list[$filter_id] = $hub_child_list;
                $res_arr['child'] = htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                $res_arr['child_count'] = count($hub_child_list);
                $res_arr['child_d'] = $hub_child_list;
                $inc++;
                array_push($table_data, $res_arr);
            }
        } elseif ($subrd_type == 0 || !isset($type_view_map[$subrd_type])) {
            $row['village_census'] = ltrim($row['village_census'], '0');
            if (isset($maparray[$row['village_census']])) {
                $final_result[$inc] = $row;
                $final_result[$inc]['child'] = [];
                $final_result[$inc]['child_d'] = [];
                $final_result[$inc]['subrd_marker'] = 'NA';
                $child_list[$row['cluster_id']] = [];
                $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$row['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $row['cluster_name'] . '</li></ul></div></div></div>';
                $inc++;
            }
        }
    }

    // Process leftover elements that don't belong to a hub cluster
    $mdlz = ($user->id == 13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";
    foreach ($result as $row) {
        if (isset($removed_clusters[$row['cluster_id']])) {
            continue; // Skipped instantly in O(1) time complexity
        }
        $row['village_census'] = ltrim($row['village_census'], '0');
        if (isset($maparray[$row['village_census']])) {
            $subrd_type = $row['subrd_type'];
            if ($subrd_type == 1 && $row['active_stat'] == 'No') $summary_count['new_village_current']++;
            if ($subrd_type == 2) $summary_count['new_village_recommand']++;
            if (($subrd_type == 2 || $subrd_type == 3) && isset($type_view_map[$subrd_type])) {
                $summary_count['show_summary'] = $subrd_type;
            }
            $final_result[$inc] = $row;
            $final_result[$inc]['child'] = [];
            $final_result[$inc]['subrd_marker'] = ($subrd_type == 1) ? 'rural_icon/efficient-subrd.png' : (($subrd_type == 2) ? $priority[$row['subrd_priority']] : (($subrd_type == 5) ? 'rural_icon/D.png' : 'NA'));
            $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$row['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $row['cluster_name'] . '</li></ul></div></div></div>';
            $inc++;
        }
    }

    $result_count = count($final_result);
    $first_lat = $result[0]['latitude'] ?? '';
    $first_lon = $result[0]['longitude'] ?? '';

    for ($k = 0; $k < $result_count; $k++) {
        $temp = $final_result[$k];
        $subrd_type = $temp['subrd_type'];
        $is_viewable = isset($type_view_map[$subrd_type]);

        // Determine split_color for this hub
        if ($subrd_type == 1 && $temp['is_hub'] == 1 && $is_viewable) {
            $split_color = ($temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' || $temp['subrd_loaction'] == 'Existing Urban Distbtr') ? 'lblue' : 'grey';
        } elseif ($subrd_type == 2 && $temp['is_hub'] == 1 && $is_viewable) {
            $split_color = $color[mt_rand(0, $color_count - 1)];
        } elseif ($subrd_type == 3 && $temp['is_hub'] == 1 && $is_viewable) {
            $split_color = 'fgreen';
        } elseif ($subrd_type == 5 && $temp['is_hub'] == 1 && $is_viewable) {
            $split_color = 'blue';
            $hub         = CommonController::getcolor_bysubrd('d_' . $split_color);
        } else {
            $split_color = 'none';
        }

        if (($subrd_type == 2 || $subrd_type == 3) && $temp['is_hub'] == 1 && $is_viewable) {
            $summary_count['total_village']++;
            if ($summary_count['show_summary'] == '') $summary_count['show_summary'] = $subrd_type;
        }

        unset($temp['child']);

        // Determine hub color
        if ($temp['is_hub'] != 1 && $subrd_type != 0) {
            $hub = '#ffffff';
            if (($temp['active_stat'] == 'Yes' || $temp['active_stat'] == '') && $subrd_type == 1 && $is_viewable) {
                $hub = CommonController::getcolor_bysubrd('l_grey');
            }
            if ($temp['active_stat'] == 'No' && $subrd_type == 1 && $is_viewable) {
                $hub = CommonController::getcolor_bysubrd('yellow');
            }
            if ($temp['subrd_loaction'] == 'Existing Urban Distbtr' && $subrd_type == 1 && $is_viewable) {
                $hub = CommonController::getcolor_bysubrd('l_lblue');
            }
            if (($subrd_type == 2 || $subrd_type == 3) && $is_viewable) {
                if (isset($non_cluster_color[$temp['cluster_name']]) && $subrd_type != 3) {
                    $hub = CommonController::getcolor_bysubrd('l_' . $non_cluster_color[$temp['cluster_name']]);
                } elseif ($subrd_type != 3) {
                    $split_color = $color[mt_rand(0, $color_count - 1)];
                    $hub         = CommonController::getcolor_bysubrd('l_' . $split_color);
                    $non_cluster_color[$temp['cluster_name']] = $split_color;
                } else {
                    $hub = CommonController::getcolor_bysubrd('l_fgreen');
                }
            }
        } else {
            $hub = CommonController::getcolor_bysubrd('d_' . $split_color);
        }

        $cluster_type = $final_result[$k]['subrd_loaction'];
        $final_result[$k]['activate_status'] = $final_result[$k]['company_service_id'];

        $cluster_tag = (($subrd_type == 1 || $subrd_type == 5) && $is_viewable) ? 'SubRD Existg' : (($subrd_type == 2 && $is_viewable) ? 'Recommdd' : (($subrd_type == 3 && $is_viewable) ? 'Wholesaler' : ''));
        $cluster_hub  = ($subrd_type == 1 && $is_viewable) ? 'Existg SubRD' : (($subrd_type == 2 && $is_viewable) ? 'Recommdd SubRD' : (($subrd_type == 3 && $is_viewable) ? 'Wholesaler' : ''));

        $temp['activate_marker'] = ($final_result[$k]['company_service_id'] == 1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id'] == 2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id'] == 3) ? 'rural_icon/deactivated.png' : (($final_result[$k]['company_service_id'] == 4) ? 'rural_icon/activated.png' : (($final_result[$k]['company_service_id'] == 5) ? 'rural_icon/deactivated.png' : 'NA'))));

        if ($temp['is_hub'] != 0) {
            $temp['subrd_status'] = $is_viewable ? $subrd_type : 0;

            $subrd_marker = 'NA';
            if ($final_result[$k]['subrd_type'] == 5) {
                $subrd_marker = 'rural_icon/Distributr.png';
            } elseif ($final_result[$k]['subrd_type'] == 2 && $is_viewable) {
                $subrd_marker = $priority[$final_result[$k]['subrd_priority']];
            } elseif ($final_result[$k]['subrd_type'] == 1 && $temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' && $is_viewable) {
                $subrd_marker = 'rural_icon/urban-distributor.png';
            } elseif ($final_result[$k]['subrd_type'] == 1 && $is_viewable) {
                $subrd_marker = 'rural_icon/efficient-subrd.png';
            } elseif ($final_result[$k]['subrd_type_whlsl'] == 3 && isset($type_view_map[$final_result[$k]['subrd_type_whlsl']])) {
                $subrd_marker = 'rural_icon/Wholesale.png';
            }

            $temp['subrd_marker']  = $subrd_marker;
            $temp['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>' . $maparray[$final_result[$k]['village_census']]['location_name'] . '</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">' . $cluster_tag . '</li></ul></div></div></div>';
        } else {
            $temp['subrd_status']  = 0;
            $temp['subrd_marker']  = 'NA';
            $temp['subrd_tooltip'] = '';
        }

        // Build info HTML directly mapping localized metrics
        if ($subrd_type != 0 && $is_viewable) {
            $temp['shareinfo'] = 'Village: ' . $final_result[$k]['village_name'] . '; Taluk: ' . $final_result[$k]['taluk_name'] . '; Distt: ' . $final_result[$k]['district_name'] . '; State: ' . $final_result[$k]['state_name'] . ';Recommendation: ' . $cluster_type . ';Distance from ' . $cluster_hub . ' (km): 0 kms; Population: ' . $final_result[$k]['population'] . ' Nos.; Rural Progressive Index: ' . $final_result[$k]['rpi'] . '; Outlet Potential: ' . $final_result[$k]['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $final_result[$k]['village_choc_consmptn'] . '; Market UID: ' . $final_result[$k]['market_id'] . '; BI Location ID: ' . $final_result[$k]['bi_id'] . ';SubRD Priority: ' . $final_result[$k]['subrd_priority'] . '; SubRD Cluster Priority: ' . $final_result[$k]['subrd_priority'] . '; ';
            $final_result[$k]['village_choc_consmptn'] = ($final_result[$k]['village_choc_consmptn'] != '') ? $final_result[$k]['village_choc_consmptn'] : 0;
            $final_result[$k]['village_choc_consmptn'] = is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $final_result[$k]['village_choc_consmptn']), 0);
            $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $first_lat . '" lon="' . $first_lon . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendatn:</span> ' . $cluster_type . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>' . $final_result[$k]['cluster_id'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from ' . $cluster_hub . ' (km): </span>0 kms</p>';
            if ($user->client_id != 1000) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
            }
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Coca-Cola Cvrg Nos.: </span> ' . number_format($final_result[$k]['mdlz_retlr_universe'], 0) . ' Nos.</p>';
            if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
            }
            if ($subrd_type == 1 && $user->client_id == 120) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $mdlz . ': </span>' . $final_result[$k]['mdlz_retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>' . number_format($final_result[$k]['avg_monthly_sale'], 0) . ' Nos.</p>';
            }
            if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
            }
            if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
            }
            if ($user->client_id == 9999) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $final_result[$k]['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $final_result[$k]['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $final_result[$k]['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $final_result[$k]['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $final_result[$k]['rly_stn'] . '</p>';
            }
            $rural_img     = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>' . $cluster_tag . ' </p>';
            if (in_array($subrd_type, [2, 3]) && $user->client_id == 120) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> ' . $final_result[$k]['subrd_priority'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>' . $final_result[$k]['subrd_priority'] . '</p>';
            }
            if (in_array($subrd_type, [1]) && $user->client_id == 120) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD' . (($userid == 13285) ? "" : " Name") . ': </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
            }
            if ($user->client_id == 120) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['market_id'] . '</span></p>';
            }
            if ($user->client_id != 120) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['bi_id'] . ' </span></p>';
                if (in_array($subrd_type, [1])) {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                }
            }
            $final_result[$k]['population']              = number_format($final_result[$k]['population'], 0);
            $final_result[$k]['village_name']            = $maparray[$final_result[$k]['village_census']]['location_name'];
            $final_result[$k]['cluster_type']            = $cluster_type;
            $detail        = htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
            $temp['info'] .= '<div class="popup-footer" style="cursor:pointer;padding:10px;text-align:center;" onclick="view_village_detail(' . $detail . ')">More Info</span></div></div>';
        } else {
            $final_result[$k]['population']              = is_numeric($final_result[$k]['population']) ? $final_result[$k]['population'] : 0;
            $final_result[$k]['village_choc_consmptn']   = is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $final_result[$k]['village_choc_consmptn']), 0);
            $temp['shareinfo'] = 'Village: ' . $final_result[$k]['village_name'] . '; Taluk: ' . $final_result[$k]['taluk_name'] . '; Distt: ' . $final_result[$k]['district_name'] . '; State: ' . $final_result[$k]['state_name'] . ';Population: ' . $final_result[$k]['population'] . ' Nos.; Rural Progressive Index: ' . $final_result[$k]['rpi'] . '; Outlet Potential: ' . $final_result[$k]['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $final_result[$k]['village_choc_consmptn'] . '; Market UID: ' . $final_result[$k]['market_id'] . '; BI Location ID: ' . $final_result[$k]['bi_id'] . '; ';
            $temp['info']  = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $first_lat . '" lon="' . $first_lon . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;">';
            if ($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural') {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
            }
            if ($user->client_id != 1000) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p>';
            }
            if ($user->client_id != 112 && $user->client_id != 9999) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;"> ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $final_result[$k]['village_choc_consmptn'] . ' </p>';
            }
            if ($user->client_id == 9999) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $final_result[$k]['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $final_result[$k]['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $final_result[$k]['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $final_result[$k]['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $final_result[$k]['rly_stn'] . '</p>';
            }
            $rural_img     = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p>';
            if ($user->client_id == 120) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['market_id'] . '</span></p>';
            }
            if ($user->client_id != 120) {
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['bi_id'] . ' </span></p>';
            }
            $final_result[$k]['village_name'] = $maparray[$final_result[$k]['village_census']]['location_name'];
            $detail        = htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
            $temp['info'] .= '<div class="popup-footer" style="text-align:center;cursor:pointer;padding:10px;" onclick="view_village_detail(' . $detail . ')"><span class="navigate_location" style="background-color:none;">More Info</span></div></div>';
        }

        if ($user->client_id == 133) {
            $final_result[$k]['population'] = is_numeric($final_result[$k]['population']) ? $final_result[$k]['population'] : 0;
            $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$final_result[$k]['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp['shareinfo'] . '\',this)" lat="' . $first_lat . '" lon="' . $first_lon . '" id="share_' . $final_result[$k]['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $final_result[$k]['latitude'] . ',' . $final_result[$k]['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $final_result[$k]['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $final_result[$k]['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $final_result[$k]['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;">';
            $rural_img     = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $final_result[$k]['rpi_img'] . '.jpg"></img>';
            $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $final_result[$k]['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p><div></div></div>';
        }

        $temp['size']            = 15;
        $temp['activate_status'] = $final_result[$k]['activate_status'];

        $temp = $this->buildVillageMarkers($temp, $temp['subrd_marker'], $temp['activate_marker']);

        $temp['markers'] = [];
        if (isset($temp['subrd_marker']) && $temp['subrd_marker'] != '' && $temp['subrd_marker'] != 'NA') {
            $temp['markers'][] = ['icon' => $temp['subrd_marker']];
        }
        if (isset($temp['activate_marker']) && $temp['activate_marker'] != '' && $temp['activate_marker'] != 'NA') {
            $temp['markers'][] = ['icon' => $temp['activate_marker']];
        }

        if (!empty($cluster_id) && $cluster_id !== null) {
            if (trim($final_result[$k]['cluster_id']) != trim($cluster_id)) {
                $hub                     = '#ffffff';
                $temp['color']           = '#ffffff';
                $temp['fillColor']       = '#ffffff';
                $temp['fillOpacity']     = 1;
                $temp['subrd_marker']    = 'NA';
                $temp['activate_marker'] = 'NA';
                $temp['subrd_status']    = 0;
                $temp['subrd_tooltip']   = '';
                $temp['markers']         = [];
            }
        }

        $temp['color'] = $hub;

        $maparray[$final_result[$k]['village_census']] = array_merge(
            $maparray[$final_result[$k]['village_census']], $temp
        );

        // Child loop handling
        foreach ($final_result[$k]['child'] as $key => $value) {
            $temp2 = $value;
            $c_subrd_type = $value['subrd_type'];

            if ($c_subrd_type == 1 && $value['active_stat'] == 'No') $summary_count['new_village_current']++;
            if ($c_subrd_type == 2)                                    $summary_count['new_village_recommand']++;
            if (in_array($c_subrd_type, [2, 3])) {
                $summary_count['new_villageexport']++;
                if (isset($summary_count[$value['rpi']])) $summary_count[$value['rpi']]++;
            }

            $temp2['color'] = CommonController::getcolor_bysubrd('l_' . $split_color);
            if ($c_subrd_type == 2) {
                $temp2['color'] = ($value['active_stat'] == 'Yes') ? CommonController::getcolor_bysubrd('l_grey') : CommonController::getcolor_bysubrd('l_' . $split_color);
            }
            if ($c_subrd_type == 1) {
                if ($value['active_stat'] == 'Yes' && $value['is_hub'] == 0) $temp2['color'] = CommonController::getcolor_bysubrd('l_grey');
                if ($value['active_stat'] == 'No')                           $temp2['color'] = CommonController::getcolor_bysubrd('yellow');
            }
            if ($temp['subrd_type'] == 5) {
                $temp2['color'] = CommonController::getcolor_bysubrd('yellow');
            }

            $cluster_type = $value['subrd_loaction'];
            $cluster_tag  = ($c_subrd_type == 1 || $c_subrd_type == 5) ? 'Existg' : (($c_subrd_type == 2) ? 'Recommdd' : (($c_subrd_type == 3) ? 'Wholesaler' : ''));
            $cluster_hub  = ($c_subrd_type == 1) ? 'Existg SubRD' : (($c_subrd_type == 2) ? 'Recommd SubRD' : (($c_subrd_type == 3) ? 'Wholesaler' : ''));
            $value['village_census'] = ltrim($value['village_census'], '0');

            if (!isset($maparray[$value['village_census']])) continue;

            $value['village_choc_consmptn'] = ($value['village_choc_consmptn'] != '') ? $value['village_choc_consmptn'] : 0;
            $value['village_choc_consmptn'] = is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $value['village_choc_consmptn']), 0);
            $value['cluster_type']          = $cluster_type;

            $temp2['shareinfo'] = 'Village: ' . $value['village_name'] . '; Taluk: ' . $value['taluk_name'] . '; Distt: ' . $value['district_name'] . '; State: ' . $value['state_name'] . ';Recommendation: ' . $cluster_type . ';Distance from ' . $cluster_hub . ' (km): 0 kms; Population: ' . $value['population'] . ' Nos.; Rural Progressive Index: ' . $value['rpi'] . '; Outlet Potential: ' . $value['outlet_potential'] . ' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): ' . $value['village_choc_consmptn'] . '; Market UID: ' . $value['market_id'] . '; BI Location ID: ' . $value['bi_id'] . ';SubRD Priority: ' . $value['subrd_priority'] . '; SubRD Cluster Priority: ' . $value['subrd_priority'] . '; ';
            $temp2['info']      = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$value['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp2['shareinfo'] . '\',this)" lat="' . $value['latitude'] . '" lon="' . $value['longitude'] . '" id="share_' . $value['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $value['latitude'] . ',' . $value['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $value['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $value['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $value['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendatn:</span> ' . $cluster_type . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>' . $value['cluster_id'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from ' . $cluster_hub . ' (km): </span>' . $value['distance_subrd'] . ' kms</p>';
            if ($user->client_id == 1000 && $value['sector'] == 'Rural') {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($value['population'], 0) . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p>';
            }
            if ($user->client_id != 1000) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($value['population'], 0) . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Coca-Cola Cvrg Nos.: </span> ' . number_format($final_result[$k]['mdlz_retlr_universe'], 0) . ' Nos.</p>';
            }
            if ($c_subrd_type == 1 && $user->client_id == 120) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $mdlz . ': </span>' . $value['mdlz_retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>' . number_format($value['avg_monthly_sale'], 0) . ' Nos.</p>';
            }
            if ($user->client_id == 1000 && $value['sector'] == 'Rural') {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $value['village_choc_consmptn'] . ' </p>';
            }
            if ($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>' . $value['village_choc_consmptn'] . ' </p>';
            }
            if ($user->client_id == 9999) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>' . $value['atm'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>' . $value['bank'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>' . $value['nh'] . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>' . $value['sh'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>' . $value['rly_stn'] . '</p>';
            }
            $rural_img      = ($value['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $value['rpi_img'] . '.jpg"></img>';
            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>' . $cluster_tag . ' </p>';
            if (in_array($c_subrd_type, [2, 3]) && $user->client_id == 120) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> ' . $value['subrd_priority'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>' . $value['subrd_priority'] . '</p>';
            }
            if ($user->client_id == 120) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $value['market_id'] . '</span></p>';
            }
            if (in_array($c_subrd_type, [1]) && $user->client_id == 120) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD ' . (($userid == 13285) ? "" : " Name") . ': </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
            }
            if ($user->client_id != 120 && $user->client_id != 112) {
                $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;">' . $value['bi_id'] . ' </span></p>';
                if (in_array($c_subrd_type, [1])) {
                    $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                }
            }
            if ($user->client_id == 112) {
                if (in_array($c_subrd_type, [1])) {
                    $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                }
                if (in_array($c_subrd_type, [5])) {
                    $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Code: </span><span style="background-color:white;color:black;">' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Name: </span><span style="background-color:white;color:black;">' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                }
            }

            $value['population']  = number_format($value['population'], 0);
            $value['village_name'] = $maparray[$value['village_census']]['location_name'];
            $child_val             = [0 => $value];
            $value_json            = htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
            $temp2['info']        .= '<div class="popup-footer" style="text-align:center;cursor:pointer;padding:10px;" onclick="view_village_detail(' . $value_json . ')"><span class="navigate_location" style="background-color:none;">More Info</span></div></div>';

            if ($user->client_id == 133) {
                $rural_img      = ($value['rpi_img'] == '') ? '' : '<img src="rural_icon/' . $value['rpi_img'] . '.jpg"></img>';
                $temp2['info']  = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">' . $maparray[$value['village_census']]['location_name'] . ' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'' . $temp2['shareinfo'] . '\',this)" lat="' . $value['latitude'] . '" lon="' . $value['longitude'] . '" id="share_' . $value['village_census'] . '"><img class="ml-1" style="cursor:pointer;" geocode="' . $value['latitude'] . ',' . $value['longitude'] . '" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="' . $value['village_census'] . '" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">' . $value['taluk_name'] . ' sub-distt</span><br><span style="line-height:1rem;">' . $value['district_name'] . ' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>' . $value['population'] . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>' . $value['retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p><div></div></div>';
            }

            $value['activate_status']  = $value['company_service_id'];
            $value['activate_marker']  = ($value['company_service_id'] == 1) ? 'rural_icon/active.png' : (($value['company_service_id'] == 2) ? 'rural_icon/initiated.png' : (($value['company_service_id'] == 3) ? 'rural_icon/deactivated.png' : (($value['company_service_id'] == 4) ? 'rural_icon/activated.png' : (($value['company_service_id'] == 5) ? 'rural_icon/deactivated.png' : 'NA'))));

            $temp2['size']           = 8;
            $temp2['activate_status'] = $value['activate_status'];
            $temp2['subrd_status']   = 0;
            $temp2['subrd_tooltip']  = '';

            $temp2 = $this->buildVillageMarkers($temp2, $temp2['subrd_marker'] ?? 'NA', $value['activate_marker']);

            $temp2['markers'] = [];
            if (isset($temp2['subrd_marker']) && $temp2['subrd_marker'] != '' && $temp2['subrd_marker'] != 'NA') {
                $temp2['markers'][] = ['icon' => $temp2['subrd_marker']];
            }
            if (isset($value['activate_marker']) && $value['activate_marker'] != '' && $value['activate_marker'] != 'NA') {
                $temp2['markers'][] = ['icon' => $value['activate_marker']];
            }

            if (!empty($cluster_id) && $cluster_id !== null) {
                if (trim($value['cluster_id']) != trim($cluster_id)) {
                    $temp2['color']           = '#ffffff';
                    $temp2['fillColor']       = '#ffffff';
                    $temp2['fillOpacity']     = 1;
                    $temp2['subrd_marker']    = 'NA';
                    $temp2['activate_marker'] = 'NA';
                    $temp2['subrd_status']    = 0;
                    $temp2['subrd_tooltip']   = '';
                    $temp2['markers']         = [];
                }
            }

            $maparray[$value['village_census']] = array_merge(
                $maparray[$value['village_census']], $temp2
            );
        }
    }

    $data['legend']    = [$summary_count];
    $data['griddata']  = ($user->client_id == 133) ? $this->getsubrd_pepsi($table_data) : $this->getsubrd($table_data);
    $data['child_list'] = $child_list;
    $data['mapdata']   = $maparray;

    if (isset($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0) {
        $data['head'] = implode(", ", $taluk_name) . ' sub-distt, ' . implode(", ", $district_name);
    } elseif (isset($getfilter->filter_district) && count($getfilter->filter_district) > 0) {
        $data['head'] = implode(", ", $district_name) . ' distt, ' . implode(", ", $state_name);
    } else {
        $data['head'] = '';
    }

    return $data;
}
    public function Combine_subrd_mdlz($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {   
        
         $getfilter = json_decode($input_obj ?? '{}');

        if (!isset($getfilter->type_view)) {
            $type_view = [];
        } else {
            $type_view = explode(",", $getfilter->type_view);
        }
        // Flip for O(1) lookups instead of O(N) in_array calls
        $type_view_map = array_flip($type_view);

        $cluster_id = data_get($getfilter, 'cluster_id');
        if (empty($cluster_id) || $cluster_id === 'undefined' || $cluster_id === 'null' || $cluster_id === '') {
            $cluster_id = null;
        }

        if(in_array(4,$type_view))
        {
            return $this->Combine_krishnagiri_subrd($maparray, $type, $main_location, $sub_location,$input_obj,$current_location);
        }

          $user = auth()->user();
          $userid = $user->id;

         //$SpecificStateUserID=array(21043,21040,21041,21042);
         if($user->id == 13947 || $user->id == 21040 || $user->id == 21043 || $user->id == 21041 || $user->id == 21042 || $user->id == 21129 || $user->id == 21130 || $user->id == 12933 || $user->id == 22102 || auth()->user()->designation == 'ASM' || $user->id == 22956 )
        {
              $tbllist=[120=>'subrd_data',123=>'subrd_data_perfetti',112=>'coke_subrd_data_all',133=>'subrd_data',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];

        }
        else
        {
           $tbllist=[120=>'subrd_data',123=>'subrd_data_perfetti',112=>'coke_subrd_data',133=>'subrd_data',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];   
        }

        $consmtp=[120=> 'Villg. Choc Consmptn',123=>'Confectionery Consmptn',112=>'Confectionery Consmptn',133=>'',1000=>'',9999=>'Confectionery Consmptn'];

        $subrd_name=[112=>[0=>'Spoke Reco',1=>'Reco Villg.',133=>'',1000=>'',9999=>'']];
         $data = [];$getdetail=[];
         $color = ['green','red','lavender','pink','orange','fgreen','chaani'];
        $user = auth()->user();
        $userid = $user->id;
        if($userid==13285)
        {
            $consmtp[120]='Catgry Consmptn';
        }
        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
       
       
        $summary_count=[];
        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
        $summary_count['show_summary']=0;
        $summary_count['new_village_current']=0;
        $summary_count['new_village_recommand']=0;
       
            $orwhere = [];
        if (isset($getfilter->filter_district) && count($getfilter->filter_district) > 0)
            array_push($orwhere, "  a.loc9 in (" . implode(",", $getfilter->filter_district) . ")");
        if (isset($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0)
            array_push($orwhere, "  a.taluk_census in (" . implode(",", $getfilter->filter_taluk) . ")");

        // ✅ Build cluster filter separately so it never gets overwritten
        $clusterStr = '';
        if (filled($cluster_id)) {
            if (is_array($cluster_id)) $cluster_id = implode(',', $cluster_id);
            $clusterStr = " AND a.cluster_id='" . addslashes($cluster_id) . "'";
        }

            $str = '';
            if (count($orwhere) > 0)
                $str = " AND (" . join(" OR ", $orwhere) . ")";

            $str .= $clusterStr; // cluster filter always appended, never lost

            if (isset($getfilter->filter_priority) && $getfilter->filter_priority != '')
                $str .= ' AND a.subrd_priority="' . $getfilter->filter_priority . '"';
            if (isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd != '')
                $str .= ' AND a.exist_subrd_code="' . $getfilter->filter_existsubrd . '"';

         $select ='';
         if($user->client_id==9999)
          $select =',no_of_schools,no_of_colleges,hh,if(atm="-","No",atm) atm,if(bank="-","No",bank) bank,if(nh="-","No",nh) nh,if(sh="-","No",sh) sh,if(rly_stn="-","No",rly_stn) rly_stn';
         



        $sql="SELECT  a.cluster_village_biscuits_consmptn,a.village_biscuits_consmptn,a.cluster_village_choc_consmptn,b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=7,'LT',if(a.rpi_id=8,'MT',if(a.rpi_id=9,'UT',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',''))))))) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=7,'LT' , if(a.rpi_id=8,'MT' ,if(a.rpi_id=9,'UT',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',''))))))) as rpi_img,a.avg_monthly_sale".$select." FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";
         //echo $sql;die;
        // \Log::info('sql: ' . $sql);
 
         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);

       // ✅ ADD HERE — after result is fetched
        \Log::info('CLUSTER_DEBUG cluster_id: ' . $cluster_id);
        \Log::info('CLUSTER_DEBUG sql: ' . $sql);
        \Log::info('CLUSTER_DEBUG result count: ' . count($result));
          
          $final_result=[];
          $inc=0;
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'district_name');
          $district_name=array_unique($district_name);
          $state_name=array_column($result,'state_code');
          $state_name=array_unique($state_name);
          $table_data=[];
          $priority=['Priority 1'=>'rural_icon/r_p1.png','Priority 2'=>'rural_icon/r_p2.png','Priority 3'=>'rural_icon/r_p3.png',''=>'rural_icon/recommendation.png','P1'=>'rural_icon/r_p1.png','P2'=>'rural_icon/r_p2.png'];
          $without_hub=$result;
          $non_cluster_color=[];
          $child_list=[];


         
         
         for($i=0;$i<count($result);$i++)
         {
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'],$type_view))
             {
                  
                  $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                  $final_result[$inc]['child']=[];
                  $filter_id=$result[$i]['cluster_id'];

                                 
                  $final_result[$inc]['subrd_marker']=($result[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($result[$i]['subrd_type']==2) ? $priority[$result[$i]['subrd_priority']] : (($result[$i]['subrd_type']==5) ? 'rural_icon/D.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';
                    
                    //ClusterID base display child condition Rajkumar 19-01-2026
                    $sqlCluseter="SELECT  a.cluster_village_biscuits_consmptn,a.village_biscuits_consmptn,a.cluster_village_choc_consmptn,b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=7,'LT',if(a.rpi_id=8,'MT',if(a.rpi_id=9,'UT',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',''))))))) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=7,'LT' , if(a.rpi_id=8,'MT' ,if(a.rpi_id=9,'UT',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',''))))))) as rpi_img,a.avg_monthly_sale".$select." FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code and  a.cluster_id='".$result[$i]['cluster_id']."' and b.stat='A' ";
                    // echo $sqlCluseter;die;
    
                     
                        $resultCluseter = DB::select(DB::raw($sqlCluseter));
                        $resultCluseter=CommonController::getarray($resultCluseter);

                        $hub_child_list = array_filter($resultCluseter, function ($var) use ($filter_id) {
                            return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                    });
                    //ClusterID base display child condition Rajkumar 19-01-2026
                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                   });

                              
                  $final_result[$inc]['child']=$hub_child_list; 
                  $res_arr=$result[$i];
                  $child_list[$filter_id]=$hub_child_list;

                  $res_arr['child']=htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                  $res_arr['child_count']=count($hub_child_list);
                    $res_arr['child_d']=$hub_child_list;
                  
                 $inc++;
                 array_push($table_data,$res_arr);
                }
                  
             }
             else if($result[$i]['subrd_type'] ==0 || !in_array($result[$i]['subrd_type'],$type_view))
             {
                $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                    $final_result[$inc]['child']=[];
                     $final_result[$inc]['child_d']=[];
                    $final_result[$inc]['subrd_marker']='NA';
                     $child_list[$result[$i]['cluster_id']]=[];
                    $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
             }
         }
         $without_hub=array_values($without_hub);
         $without_hub_count=count($without_hub);
      $mdlz=($user->id==13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";
         for($i=0;$i<$without_hub_count;$i++)
         {
      
              $without_hub[$i]['village_census']=ltrim($without_hub[$i]['village_census'], 0);

                if(isset($maparray[$without_hub[$i]['village_census']]))
                {
                    if($without_hub[$i]['subrd_type']==1 && $without_hub[$i]['active_stat'] =='No')
                        $summary_count['new_village_current']++;
                     if($without_hub[$i]['subrd_type']==2)
                        $summary_count['new_village_recommand']++;
                       
                     if(in_array($without_hub[$i]['subrd_type'],[1,2,3]))   
                     {
                        if(in_array($without_hub[$i]['subrd_type'],[2,3]) && in_array($without_hub[$i]['subrd_type'],$type_view))   
                            $summary_count['show_summary']=$without_hub[$i]['subrd_type']; 
                     
                        
                     }  
                       
                  
                    $final_result[$inc]=$without_hub[$i];
                    $final_result[$inc]['child']=[];
                    $final_result[$inc]['subrd_marker']=($without_hub[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($without_hub[$i]['subrd_type']==2) ? $priority[$without_hub[$i]['subrd_priority']] : (($without_hub[$i]['subrd_type']==5) ? 'rural_icon/D.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$without_hub[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$without_hub[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
         }
      
         $result_count=count($final_result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            $temp=$final_result[$k];
           if($temp['subrd_type']==1 && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                 \Log::info('subrd_type: ' . $temp['subrd_type']);
                if($temp['subrd_loaction']=='Existing Urban Distbtr Hub' || $temp['subrd_loaction']=='Existing Urban Distbtr')
                    $split_color='lblue';
                else
                    $split_color='goldbrown';

                
            }
           else if(($temp['subrd_type']==2) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
              $range=array_rand(range(0,(count($color)-1)));
              $split_color=$color[$range];
           }
           else if(($temp['subrd_type']==3) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
                 $split_color='fgreen';
           }
            else if (
                        $temp['subrd_type'] == 5 &&
                        $temp['is_hub'] == 1 &&
                        in_array($temp['subrd_type'], $type_view)
            ) {
                $split_color = 'blue';
                 //\Log::info('Color applied', ['color' => $split_color, 'subrd_type' => $temp['subrd_type']]);
            }

           else if($temp['subrd_type']==0)
              $split_color='none';
           else
              $split_color='none';
            if(in_array($temp['subrd_type'],[2,3]) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                $summary_count['total_village']++;   
                if( $summary_count['show_summary']=='')           
                $summary_count['show_summary']=$temp['subrd_type'];
            }
    
            unset($temp['child']);
            
             
            if($temp['is_hub'] != 1 && $temp['subrd_type']!=0)
             {
                $hub='#ffffff';$child='';
                if(($temp['active_stat']=='Yes' || $temp['active_stat']=='') && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                          $hub= CommonController::getcolor_bysubrd('l_goldbrown');
                if($temp['active_stat']=='No'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                     $hub= CommonController::getcolor_bysubrd('yellow');
                if($temp['subrd_loaction']=='Existing Urban Distbtr'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                           $hub= CommonController::getcolor_bysubrd('l_lblue'); 
                if((($temp['subrd_type']==2) || ($temp['subrd_type']==3)) && in_array($temp['subrd_type'],$type_view))
               {
                  if(isset($non_cluster_color[$temp['cluster_name']]) && $temp['subrd_type'] !=3)
                            $hub= CommonController::getcolor_bysubrd('l_'.$non_cluster_color[$temp['cluster_name']]); 
                  else if($temp['subrd_type'] !=3){

                     $range=array_rand(range(0,(count($color)-1)));
                     $split_color=$color[$range];
                     $hub= CommonController::getcolor_bysubrd('l_'.$split_color); 
                     $non_cluster_color[$temp['cluster_name']]=$split_color;
                  }
                  else if($temp['subrd_type'] ==3)
                  {
                      $hub= CommonController::getcolor_bysubrd('l_fgreen');
                  }
                   
                 
               }
            }             
             else
                $hub= CommonController::getcolor_bysubrd('d_'.$split_color); 
             $label='';
             $legend="";
             $temp['color']=$hub; 

           
            

              $cluster_type=$final_result[$k]['subrd_loaction'];
              if($user->client_id==1000)
               $cluster_type=$final_result[$k]['subrd_loaction'];
			 
             $final_result[$k]['activate_status']=$final_result[$k]['company_service_id'];
             $cluster_tag=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'SubRD Existing' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Reco' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $cluster_hub=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existing SubRD' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Reco SubRD' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $temp['activate_marker']=($final_result[$k]['company_service_id']==1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($final_result[$k]['company_service_id']==4) ? 'rural_icon/activated.png' :(($final_result[$k]['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             if($temp['is_hub']!=0)
            {
                $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
              $temp['subrd_marker'] = (
        ($final_result[$k]['subrd_type'] == 5) 
            ? 'rural_icon/Distributr.png' 
        : (
            ($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) 
                ? $priority[$final_result[$k]['subrd_priority']] 
            : (
                ($final_result[$k]['subrd_type'] == 1 && $temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'], $type_view)) 
                    ? 'rural_icon/urban-distributor.png' 
                : (
                    ($final_result[$k]['subrd_type'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) 
                        ? 'rural_icon/efficient-subrd.png' 
                    : (
                        ($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) 
                            ? 'rural_icon/Wholesale.png' 
                        : ''
                    )
                )
            )
        )
     );
                $temp['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$final_result[$k]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$cluster_tag.'</li></ul> </div></div></div>';
            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['subrd_marker']='NA';             
                 $temp['subrd_tooltip']='';
            }


             // 
        if($final_result[$k]['subrd_type']!=0 && in_array($final_result[$k]['subrd_type'],$type_view))
        {
            $temp['shareinfo'] =
            'Village: '.($final_result[$k]['village_name'] ?? '').
            '; Taluk: '.($final_result[$k]['taluk_name'] ?? '').
            '; Distt: '.($final_result[$k]['district_name'] ?? '').
            '; State: '.($final_result[$k]['state_name'] ?? '').
            '; Recommendation: '.$cluster_type.
            '; Distance from '.$cluster_hub.' (km): 0 kms'.
            '; Total Cluster Consumption (Snacks)(Annual)(Rs.): '.($final_result[$k]['cluster_village_choc_consmptn'] ?? 0).' Nos.'.
            '; Population: '.($final_result[$k]['population'] ?? 0).' Nos.'.
            '; Rural Progressive Index: '.($final_result[$k]['rpi'] ?? 0).
            '; Outlet Potential: '.($final_result[$k]['outlet_potential'] ?? 0).' Nos.'.
            '; '.($consmtp[$user->client_id] ?? 'Consumption').' (Annual) (Rs.): '.($final_result[$k]['village_choc_consmptn'] ?? 0).
            '; Villg. Biscuit Consmptn (Annual) (Rs.): '.($final_result[$k]['village_biscuits_consmptn'] ?? 0).
            '; Market UID: '.($final_result[$k]['market_id'] ?? '').
            '; BI Location ID: '.($final_result[$k]['bi_id'] ?? '').
            '; SubRD Priority: '.($final_result[$k]['subrd_priority'] ?? '').
            '; SubRD Cluster Priority: '.($final_result[$k]['subrd_priority'] ?? '').';';

        // $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? number_format($final_result[$k]['village_choc_consmptn'],0) : $final_result[$k]['village_choc_consmptn'];
        $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? $final_result[$k]['village_choc_consmptn'] : 0;
        $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);

           $final_result[$k]['village_biscuits_consmptn']=($final_result[$k]['village_biscuits_consmptn']!='') ? $final_result[$k]['village_biscuits_consmptn'] : 0;
        $final_result[$k]['village_biscuits_consmptn']=is_numeric($final_result[$k]['village_biscuits_consmptn']) ? number_format($final_result[$k]['village_biscuits_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_biscuits_consmptn']),0);



            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">'.(($userid==13285) ? "Recommendatn" : "Recommendatn").':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$final_result[$k]['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from '.$cluster_hub.' (km): </span>0 kms</p>';
           if($user->client_id!=1000)
            $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Total Cluster Consumption (Snacks)(Annual)(Rs.): </span>'.number_format($final_result[$k]['cluster_village_choc_consmptn'],0).' </p>';

           if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
            $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';

           if($final_result[$k]['subrd_type']==1 &&  $user->client_id==120)
              $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$mdlz.': </span>'.$final_result[$k]['mdlz_retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>'.number_format($final_result[$k]['avg_monthly_sale'],0).' Nos.</p>';
           if($user->client_id!=1000 && $user->client_id!=112 && $user->client_id!=9999)
             //$temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
            if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
               // $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
            /* <p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$final_result[$k]['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$final_result[$k]['no_of_schools'].' Nos. </p>*/
            if($user->client_id==9999)
                 $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$final_result[$k]['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$final_result[$k]['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$final_result[$k]['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$final_result[$k]['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$final_result[$k]['rly_stn'].'</p>';
            $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
           
            

             if(in_array($final_result[$k]['subrd_type'],[2,3]) &&  $user->client_id==120)
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$final_result[$k]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$final_result[$k]['subrd_priority'].'</p>';
          if(in_array($final_result[$k]['subrd_type'],[1]) &&  $user->client_id==120)
              $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD'.(($userid==13285) ? "" : " Name").': </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
          
          if($user->client_id==120)
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p>';
         if($user->client_id!=120)
         {
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
             if(in_array($final_result[$k]['subrd_type'],[1]))
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
         }

            $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
            $final_result[$k]['cluster_type']=$cluster_type;
        $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
                    $temp['info'] .='<div class="popup-footer" 
     style="text-align:center;cursor:pointer;padding:10px;" 
     onclick="view_village_detail('.$detail.')">

        <span class="navigate_location" style="background-color:none;">
            More Info
        </span>

        </div></div>';
                    
                            
                }
                else
                    {
                        $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
        $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);
        $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Villg. Biscuit Consmptn: '.$final_result[$k]['village_biscuits_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].'; ';
        $mdlz=($user->id==13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";

                        $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
                if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
                        $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
                    if($user->client_id!=1000)
                        $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
                    if($user->client_id!=112 && $user->client_id!=9999)
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;"> '.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';  
                    /*<p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$final_result[$k]['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$final_result[$k]['no_of_schools'].' Nos. </p>*/
                if($user->client_id==9999)
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$final_result[$k]['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$final_result[$k]['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$final_result[$k]['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$final_result[$k]['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$final_result[$k]['rly_stn'].'</p>';
                    
                $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>'.$rural_img.'</span></p>';
              if($user->client_id==120)
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p>';
                if($user->client_id!=120)            
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
            
                // $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
                // $final_result[$k]['village_choc_consmptn']=number_format($final_result[$k]['village_choc_consmptn'],0);
                    $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
                $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

                    $temp['info'] .='<div class="popup-footer" 
     style="text-align:center;cursor:pointer;padding:10px;" 
     onclick="view_village_detail('.$detail.')">

        <span class="navigate_location" style="background-color:none;">
            More Info
        </span>

     </div></div>';  
                    }
                    if($user->client_id==133)
                {
                    $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
                    $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
                    $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
                    $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>
                 <p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><div ></div></div>';
                }
                    $temp['size']=15;
                    $temp['activate_status_icon']=$temp['activate_marker'];
                    $temp['activate_status']=$final_result[$k]['activate_status'];
                    
                    $maparray[$final_result[$k]['village_census']]=array_merge($maparray[$final_result[$k]['village_census']],$temp);

                    $temp2=[];
                    
                    foreach($final_result[$k]['child'] as $key=>$value)
                    {
                        $temp2=$value;
                        if($value['subrd_type']==1 && $value['active_stat'] =='No')
                            $summary_count['new_village_current']++;
                        if($value['subrd_type']==2)
                            $summary_count['new_village_recommand']++;
                        if(in_array($value['subrd_type'],[2,3])){
                            $summary_count['new_village']++;

                        if(isset($summary_count[$value['rpi']]))
                                    $summary_count[$value['rpi']]++; 
                        }
                            $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                        if($value['subrd_type']==2)    //subrd_type 1 is Existing 2 is Reco
                        {
                            // child cluster color change if active yes  it will appear in grey color
                            if($value['active_stat']=='Yes')
                                $temp2['color']= CommonController::getcolor_bysubrd('l_goldbrown');
                                
                            if($value['active_stat']=='No')
                                $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);   
                                
                        } 
                        if($value['subrd_type']==1)    //subrd_type 1 is Existing 2 is Reco
                        {
                            // child cluster color change if active yes  it will appear in grey color
                            if($value['active_stat']=='Yes' && $value['is_hub'] == 0)
                                $temp2['color']= CommonController::getcolor_bysubrd('l_goldbrown');
                                
                            if($value['active_stat']=='No')
                                $temp2['color']= CommonController::getcolor_bysubrd('yellow');   
                                
                        }
                        if($temp['subrd_type'] ==5)
                        {
                            $temp2['color']= CommonController::getcolor_bysubrd('yellow');   
                        }            
                        // else                 
                        //    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                        
                        // $cluster_type=(isset($subrd_name[$user->client_id])) ? $subrd_name[$user->client_id][1] : $value['subrd_loaction'];
                        $cluster_type=$value['subrd_loaction'];
                        $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Reco' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                        $cluster_hub=($value['subrd_type']==1) ? 'Existing SubRD' :(($value['subrd_type']==2) ? 'Reco SubRD' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                        $value['village_census']=ltrim($value['village_census'], 0);
                        if(isset($maparray[$value['village_census']]))
                        {
                        
                            $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ?  $value['village_choc_consmptn'] : 0;
                            $value['village_choc_consmptn']=is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$value['village_choc_consmptn']),0);
                            $value['cluster_type']=$cluster_type;
                $temp2['shareinfo']='Village: '.$value['village_name'].'; Taluk: '.$value['taluk_name'].'; Distt: '.$value['district_name'].'; State: '.$value['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$value['population'].' Nos.; Rural Progressive Index: '.$value['rpi'].'; Outlet Potential: '.$value['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$value['village_choc_consmptn'].'; Market UID: '.$value['market_id'].'; BI Location ID: '.$value['bi_id'].';SubRD Priority: '.$value['subrd_priority'].'; SubRD Cluster Priority: '.$value['subrd_priority'].'; ';

                            $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">'.(($userid==13285) ? "Recommendatn" : "Recommendatn").':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$value['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from  '.$cluster_hub.' (km): </span>'.$value['distance_subrd'].' kms</p>';
                    if($user->client_id==1000 && $value['sector']=='Rural')
                        $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p>';
                if($user->client_id!=1000)
                    $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p>';

            if($value['subrd_type']==1 &&  $user->client_id==120)
                    $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$mdlz.': </span>'.$value['mdlz_retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>'.number_format($value['avg_monthly_sale'],0).' Nos.</p>';
                    if($user->client_id==1000 && $value['sector']=='Rural')          
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$value['village_choc_consmptn'].' </p>';
                    if($user->client_id!=1000 && $user->client_id!=112 && $user->client_id!=9999)
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$value['village_choc_consmptn'].' </p>';
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;"> Villg. Biscuit Consmptn (Annual) (Rs.): </span>'.number_format($value['village_biscuits_consmptn'],0).' </p>';
                    /*<p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$value['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$value['no_of_schools'].' Nos. </p>*/
                    if($user->client_id==9999)
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$value['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$value['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$value['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$value['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$value['rly_stn'].'</p>';
                        
                        $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';

                if(in_array($value['subrd_type'],[2,3]) && $user->client_id==120)                
                    $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$value['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$value['subrd_priority'].'</p>';
                if($user->client_id==120)
                    $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$value['market_id'].'</span></p>';
                if(in_array($value['subrd_type'],[1]) && $user->client_id==120)  
                    $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD '.(($userid==13285) ? "" : " Name").': </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
                    if($user->client_id!=120 && $user->client_id!=112)
                    {
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$value['bi_id'].' </span></p>';
                    if(in_array($value['subrd_type'],[1]))
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
                    }

                    if($user->client_id == 112)
                    {
                        // $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$value['bi_id'].' </span></p>';

                    if(in_array($value['subrd_type'],[1]))
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';

                      
                    if(in_array($value['subrd_type'],[5]))
                        $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
                    }
                
                    
                $value['population']= number_format($value['population'],0);
                    $value['village_name']=$maparray[$value['village_census']]['location_name'];
                    $child_val=[0=>$value];
                        $value_json=htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
                    $temp2['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$value_json.')">More Info</span></div></div>';
                    if($user->client_id==133)
                    {
                        $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                        $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.$value['population'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><div ></div></div>'; 
                    }
                    $value['activate_status']=$value['company_service_id'];
                    $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Reco' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                    $value['activate_marker']=($value['company_service_id']==1) ? 'rural_icon/active.png' : (($value['company_service_id']==2) ? 'rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'rural_icon/activated.png' :(($value['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
                    
                    $temp2['size']=8;
                    $temp2['activate_status_icon']=$value['activate_marker'];
                    $temp2['activate_status']=$value['activate_status'];
                    $temp2['subrd_status']=0;
                    $temp2['subrd_marker']='NA';             
                    $temp2['subrd_tooltip']='';

                    // $temp2['village_census']=ltrim($value['village_census'],0);
                
                    $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                        }

                    

                    }
                
                }
            
        $data['legend']=[];
        $data['legend'][0] = $summary_count;
       // $data['griddata'] = $this->getsubrdMdlziRural($table_data);
        // AFTER — filter table_data by target cluster
        if (!empty($cluster_id)) {
            $filtered_table_data = array_filter($table_data, function($row) use ($cluster_id) {
                $baseCluster = explode('_', (string)($row['cluster_id'] ?? ''))[0];
                return trim($baseCluster) === trim((string)$cluster_id);
            });
            $data['griddata'] = $this->getsubrdMdlziRural(array_values($filtered_table_data));
        } else {
            $data['griddata'] = $this->getsubrdMdlziRural($table_data);
        }
        $data['child_list']=$child_list;
        $data['mapdata'] = $maparray;
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            $data['head']=implode(", ", $taluk_name). ' sub-distt, '.implode(", ", $district_name);
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
             $data['head']=implode(", ", $district_name). ' distt, '.implode(", ", $state_name);
         else
             $data['head']='';

        return $data;

    }

       public function Combine_subrd_feederMenu($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
     {   
        $getfilter = json_decode($input_obj);
        $type_view = explode(",", $getfilter->type_view);
        \Log::info('feeder type_view: ' . json_encode($type_view));

        $user = auth()->user();
        $userid = $user->id;

        $tbllist = [120=>'subrd_data', 123=>'subrd_data_perfetti', 112=>'coke_feeder_mkt', 133=>'subrd_data', 1000=>'subrd_data_haldiram', 9999=>'subrd_data_mars'];   
        $consmtp = [120=>'Villg. Choc Consmptn', 123=>'Confectionery Consmptn', 112=>'Confectionery Consmptn', 133=>'', 1000=>'', 9999=>'Confectionery Consmptn'];
        $subrd_name = [112=>[0=>'Spoke Reco', 1=>'Reco Villg.', 133=>'', 1000=>'', 9999=>'']];
        
        $data = [];
        $getdetail = [];
        $color = ['green', 'red', 'lavender', 'pink', 'orange', 'fgreen', 'chaani'];

        if($userid == 13285) {
            $consmtp[120] = 'Catgry Consmptn';
        }

        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
    
        $summary_count = [];
        $summary_count['Develpd'] = 0;
        $summary_count['Most Develpd'] = 0;
        $summary_count['Under-develpd'] = 0;
        $summary_count['Transition'] = 0;
        $summary_count['Not Rated'] = 0;
        $summary_count['total_village'] = 0;
        $summary_count['new_village'] = 0;
        $summary_count['show_summary'] = 0;
        $summary_count['new_village_current'] = 0;
        $summary_count['new_village_recommand'] = 0;
    
        $orwhere = [];
        if(isset($getfilter->filter_district) && count($getfilter->filter_district) > 0)
            array_push($orwhere, "  a.loc9 in (" . implode(",", $getfilter->filter_district) . ")");
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0)
            array_push($orwhere, "  a.taluk_census in (" . implode(",", $getfilter->filter_taluk) . ")");

        $str = '';
        if(count($orwhere) > 0)
            $str = " and (" . join(" or ", $orwhere) . ") ";

        if(isset($getfilter->filter_priority) && $getfilter->filter_priority != '')
            $str .= ' and a.subrd_priority="' . $getfilter->filter_priority . '"';
        if(isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd != '')
            $str .= ' and a.exist_subrd_code="' . $getfilter->filter_existsubrd . '"';

        $select = '';
        if($user->client_id == 9999)
            $select = ',no_of_schools,no_of_colleges,hh,if(atm="-","No",atm) atm,if(bank="-","No",bank) bank,if(nh="-","No",nh) nh,if(sh="-","No",sh) sh,if(rly_stn="-","No",rly_stn) rly_stn';

        $sql = "SELECT b.state_code, a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`, a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`, a.retlr_universe, a.mdlz_retlr_universe, a.exist_subrd_code, a.exist_subrd_name, if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng, b.latitude, b.longitude, a.rpi, if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name, if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img, a.avg_monthly_sale" . $select . " FROM " . $tbllist[$user->client_id] . " as a, town_village_polygon as b where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code " . $str . " and b.stat='A' ";
        
        \Log::info('feeder sql: ' . $sql);

        $result = DB::select(DB::raw($sql));
        $result = CommonController::getarray($result);
        
        $final_result = [];
        $inc = 0;
        $taluk_name = array_column($result, 'taluk_name');
        $taluk_name = array_unique($taluk_name);
        $district_name = array_column($result, 'district_name');
        $district_name = array_unique($district_name);
        $state_name = array_column($result, 'state_code');
        $state_name = array_unique($state_name);
        $table_data = [];
        $priority = ['Priority 1'=>'rural_icon/r_p1.png', 'Priority 2'=>'rural_icon/r_p2.png', 'Priority 3'=>'rural_icon/r_p3.png', ''=>'rural_icon/recommendation.png', 'P1'=>'rural_icon/r_p1.png', 'P2'=>'rural_icon/r_p2.png'];
        $without_hub = $result;
        $cluster_color_map = []; 
        $child_list = [];

        for($i=0; $i<count($result); $i++)
        {
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'], $type_view))
            {
                $result[$i]['village_census'] = ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc] = $result[$i];
                    $final_result[$inc]['child'] = [];
                    $filter_id = $result[$i]['cluster_id'];

                    $final_result[$inc]['subrd_marker'] = ($result[$i]['subrd_type']==1) ? 'rural_icon/efficient-subrd.png' : (($result[$i]['subrd_type']==2) ? $priority[$result[$i]['subrd_priority']] : (($result[$i]['subrd_type']==5) ? 'rural_icon/D.png' : 'NA'));
                    $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';
                    
                    $sqlCluseter = "SELECT b.state_code, a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`, a.retlr_universe, a.mdlz_retlr_universe, a.exist_subrd_code, a.exist_subrd_name, if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng, b.latitude, b.longitude, a.rpi, a.active_stat, if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name, if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img, a.avg_monthly_sale" . $select . " FROM " . $tbllist[$user->client_id] . " as a, town_village_polygon as b where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code and a.cluster_id='" . $result[$i]['cluster_id'] . "' and b.stat='A' ";
                    
                    $resultCluseter = DB::select(DB::raw($sqlCluseter));
                    $resultCluseter = CommonController::getarray($resultCluseter);

                    $hub_child_list = array_filter($resultCluseter, function ($var) use ($filter_id) {
                        return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                    });

                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                        return ($var['cluster_id'] != $filter_id);
                    });

                    $final_result[$inc]['child'] = $hub_child_list; 
                    $res_arr = $result[$i];
                    $child_list[$filter_id] = $hub_child_list;

                    $res_arr['child'] = htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                    $res_arr['child_count'] = count($hub_child_list);
                    $res_arr['child_d'] = $hub_child_list;
                
                    $inc++;
                    array_push($table_data, $res_arr);
                }
            }
            else if($result[$i]['subrd_type'] == 0 || !in_array($result[$i]['subrd_type'], $type_view))
            {
                $result[$i]['village_census'] = ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc] = $result[$i];
                    $final_result[$inc]['child'] = [];
                    $final_result[$inc]['child_d'] = [];
                    $final_result[$inc]['subrd_marker'] = 'NA';
                    $child_list[$result[$i]['cluster_id']] = [];
                    $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                }
            }
        }

        $without_hub = array_values($without_hub);
        $without_hub_count = count($without_hub);
        $mdlz = ($user->id==13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";

        for($i=0; $i<$without_hub_count; $i++)
        {
            $without_hub[$i]['village_census'] = ltrim($without_hub[$i]['village_census'], 0);

            if(isset($maparray[$without_hub[$i]['village_census']]))
            {
                if($without_hub[$i]['subrd_type']==1 && $without_hub[$i]['active_stat'] =='No')
                    $summary_count['new_village_current']++;
                if($without_hub[$i]['subrd_type']==2)
                    $summary_count['new_village_recommand']++;
                
                if(in_array($without_hub[$i]['subrd_type'], [1,2,3]))   
                {
                    if(in_array($without_hub[$i]['subrd_type'], [2,3]) && in_array($without_hub[$i]['subrd_type'], $type_view))   
                        $summary_count['show_summary'] = $without_hub[$i]['subrd_type']; 
                }  
                
                $final_result[$inc] = $without_hub[$i];
                $final_result[$inc]['child'] = [];
                $final_result[$inc]['subrd_marker'] = ($without_hub[$i]['subrd_type']==1) ? 'rural_icon/efficient-subrd.png' : (($without_hub[$i]['subrd_type']==2) ? $priority[$without_hub[$i]['subrd_priority']] : (($without_hub[$i]['subrd_type']==5) ? 'rural_icon/D.png' : 'NA'));
                $final_result[$inc]['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$without_hub[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$without_hub[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                $inc++;
            }
        }
    
        $result_count = count($final_result);
        $temp = [];

        for($k=0; $k<$result_count; $k++)
        {
            $temp = $final_result[$k];
            $current_cluster_id = $temp['cluster_id'];

            // Assign a dedicated random color context to this cluster ID if not already tracked
            if(!isset($cluster_color_map[$current_cluster_id])) {
                $random_key = array_rand($color);
                $cluster_color_map[$current_cluster_id] = $color[$random_key];
            }
            $split_color = $cluster_color_map[$current_cluster_id];

            // Specific overrides configured to be dynamic and random
            if($temp['subrd_type'] == 15 && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view))
            {
                $random_key = array_rand($color);
                $split_color = $color[$random_key];
            }
            else if(($temp['subrd_type'] == 3) && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view))
            {
                $random_key = array_rand($color);
                $split_color = $color[$random_key];
            }
            else if ($temp['subrd_type'] == 5 && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view)) 
            {
                $random_key = array_rand($color);
                $split_color = $color[$random_key];
            }
            else if($temp['subrd_type'] == 0)
            {
                $split_color = 'none';
            }

            if(in_array($temp['subrd_type'], [2,3]) && $temp['is_hub'] == 1 && in_array($temp['subrd_type'], $type_view))
            {
                $summary_count['total_village']++;   
                if($summary_count['show_summary'] == '')           
                    $summary_count['show_summary'] = $temp['subrd_type'];
            }

            unset($temp['child']);
            
            if($temp['is_hub'] != 1 && $temp['subrd_type'] != 0)
            {
                $hub = '#ffffff';
                if(($temp['active_stat']=='Yes' || $temp['active_stat']=='') && ($temp['subrd_type'] == 15) && in_array($temp['subrd_type'], $type_view))
                    $hub = CommonController::getcolor_bysubrd('l_'.$split_color);
                if($temp['active_stat']=='No' && ($temp['subrd_type'] == 15) && in_array($temp['subrd_type'], $type_view))
                    $hub = CommonController::getcolor_bysubrd('l_'.$split_color);
                if($temp['subrd_loaction']=='Existing SubRD - Active Village' && ($temp['subrd_type'] == 15) && in_array($temp['subrd_type'], $type_view))
                    $hub = CommonController::getcolor_bysubrd('l_'.$split_color); 
                
                if((($temp['subrd_type']==2) || ($temp['subrd_type']==3)) && in_array($temp['subrd_type'], $type_view))
                {
                    $hub = CommonController::getcolor_bysubrd('l_'.$split_color); 
                }
            }             
            else
            {
                $hub = CommonController::getcolor_bysubrd('d_'.$split_color); 
            }

            $label = '';
            $legend = "";
            $temp['color'] = $hub; 

            $cluster_type = $final_result[$k]['subrd_loaction'];
            if($user->client_id == 1000)
                $cluster_type = $final_result[$k]['subrd_loaction'];
            
            $final_result[$k]['activate_status'] = $final_result[$k]['company_service_id'];
            $cluster_tag = ($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'SubRD Existing' : (($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Recommended' : (($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Wholesaler' : ''));
            $cluster_hub = ($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Existing SubRD' : (($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Recommd SubRD' : (($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'Wholesaler' : ''));
            $temp['activate_marker'] = ($final_result[$k]['company_service_id']==1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'rural_icon/deactivated.png' : (($final_result[$k]['company_service_id']==4) ? 'rural_icon/activated.png' : (($final_result[$k]['company_service_id']==5) ? 'rural_icon/deactivated.png' : 'NA'))));
            
            $cluster_tag = "Feeder";
            if($temp['is_hub'] != 0)
            {
                $temp['subrd_status'] = (in_array($final_result[$k]['subrd_type'], $type_view)) ? $final_result[$k]['subrd_type'] : 0;
                $temp['subrd_marker'] = (($final_result[$k]['subrd_type'] == 5) ? 'rural_icon/Distributr.png' : (($final_result[$k]['subrd_type'] == 2 && in_array($final_result[$k]['subrd_type'], $type_view)) ? $priority[$final_result[$k]['subrd_priority']] : (($final_result[$k]['subrd_type'] == 1 && $temp['subrd_loaction'] == 'Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'rural_icon/urban-distributor.png' : (($final_result[$k]['subrd_type'] == 1 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'rural_icon/efficient-subrd.png' : (($final_result[$k]['subrd_type'] == 3 && in_array($final_result[$k]['subrd_type'], $type_view)) ? 'rural_icon/Wholesale.png' : '')))));
                $temp['subrd_tooltip'] = '<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$final_result[$k]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$cluster_tag.'</li></ul> </div></div></div>';
            }
            else
            {
                $temp['subrd_status'] = 0;
                $temp['subrd_marker'] = 'NA';             
                $temp['subrd_tooltip'] = '';
            }

            if($final_result[$k]['subrd_type'] != 0 && in_array($final_result[$k]['subrd_type'], $type_view))
            {
                $temp['shareinfo'] = 'Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.; '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID7: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].';SubRD Priority: '.$final_result[$k]['subrd_priority'].'; SubRD Cluster Priority: '.$final_result[$k]['subrd_priority'].'; ';

                $final_result[$k]['village_choc_consmptn'] = ($final_result[$k]['village_choc_consmptn'] != '') ? $final_result[$k]['village_choc_consmptn'] : 0;
                $final_result[$k]['village_choc_consmptn'] = is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $final_result[$k]['village_choc_consmptn']), 0);

                $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.__LINE__.'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">' . (($userid==13285) ? "Feeder Mkt" : "Feeder Mkt") . ':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$final_result[$k]['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from '.$cluster_hub.' (km): </span>0 kms</p>';
                
                if($user->client_id != 1000)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
                if($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural')
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';

                if($final_result[$k]['subrd_type'] == 1 && $user->client_id == 120)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$mdlz.': </span>' . $final_result[$k]['mdlz_retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>' . number_format($final_result[$k]['avg_monthly_sale'], 0) . ' Nos.</p>';
                if($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
                if($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural')
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
                
                if($user->client_id == 9999)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$final_result[$k]['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$final_result[$k]['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$final_result[$k]['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$final_result[$k]['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$final_result[$k]['rly_stn'].'</p>';
                
                $rural_img = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >' . $rural_img . '</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
            
                if(in_array($final_result[$k]['subrd_type'], [2,3]) && $user->client_id == 120)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$final_result[$k]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$final_result[$k]['subrd_priority'].'</p>';
                if(in_array($final_result[$k]['subrd_type'], [1]) && $user->client_id == 120)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD' . (($userid==13285) ? "" : " Name") . ': </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
            
                if($user->client_id == 120)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['market_id'] . '</span></p>';
                if($user->client_id != 120)
                {
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['bi_id'] . ' </span></p>';
                    if(in_array($final_result[$k]['subrd_type'], [1]))
                        $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                }

                $final_result[$k]['population'] = number_format($final_result[$k]['population'], 0);
                $final_result[$k]['village_name'] = $maparray[$final_result[$k]['village_census']]['location_name'];
                $final_result[$k]['cluster_type'] = $cluster_type;
                $detail = htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
                $temp['info'] .= '<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';
            }
            else
            {
                $final_result[$k]['population'] = is_numeric($final_result[$k]['population']) ? $final_result[$k]['population'] : 0;
                $final_result[$k]['village_choc_consmptn'] = is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $final_result[$k]['village_choc_consmptn']), 0);
                $temp['shareinfo'] = 'Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].'; ';
                $mdlz = ($user->id==13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";

                $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
                
                if($user->client_id == 1000 && $final_result[$k]['sector'] == 'Rural')
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
                if($user->client_id != 1000)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
                if($user->client_id != 112 && $user->client_id != 9999)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;"> ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>'; 
                
                if($user->client_id == 9999)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$final_result[$k]['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$final_result[$k]['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$final_result[$k]['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$final_result[$k]['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$final_result[$k]['rly_stn'].'</p>';
                
                $rural_img = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>' . $rural_img . '</span></p>';
                if($user->client_id == 120)
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $final_result[$k]['market_id'] . '</span></p>';
                if($user->client_id != 120)            
                    $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['bi_id'] . ' </span></p>';
            
                $final_result[$k]['village_name'] = $maparray[$final_result[$k]['village_census']]['location_name'];
                $detail = htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
                $temp['info'] .= '<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';  
            }

            if($user->client_id == 133)
            {
                $final_result[$k]['population'] = is_numeric($final_result[$k]['population']) ? $final_result[$k]['population'] : 0;
                $temp['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$result[0]['latitude'].','.$result[0]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
                $rural_img = ($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
                $temp['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($final_result[$k]['population'], 0) . ' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >' . $rural_img . '</span></p><div ></div></div>';
            }

            $temp['size'] = 15;
            $temp['activate_status_icon'] = $temp['activate_marker'];
            $temp['activate_status'] = $final_result[$k]['activate_status'];
            
            $maparray[$final_result[$k]['village_census']] = array_merge($maparray[$final_result[$k]['village_census']], $temp);

            // --- Child Processing: NOW COMPLETELY RANDOM/DYNAMIC ---
            $temp2 = [];
            foreach($final_result[$k]['child'] as $key=>$value)
            {
                $temp2 = $value;
                if($value['subrd_type'] == 1 && $value['active_stat'] == 'No')
                    $summary_count['new_village_current']++;
                if($value['subrd_type'] == 2)
                    $summary_count['new_village_recommand']++;
                if(in_array($value['subrd_type'], [2,3])){
                    $summary_count['new_village']++;
                    if(isset($summary_count[$value['rpi']]))
                        $summary_count[$value['rpi']]++; 
                }

                // Child Variant Color Mapping using the dynamically generated random $split_color context
                if(($value['subrd_type'] == 15 || $temp['subrd_type'] == 15) && in_array(15, $type_view))
                {
                    $temp2['color'] = CommonController::getcolor_bysubrd('l_'.$split_color);
                }
                else if($value['subrd_type'] == 2) 
                {
                    $temp2['color'] = CommonController::getcolor_bysubrd('l_'.$split_color);
                } 
                else if($value['subrd_type'] == 1) 
                {
                    $temp2['color'] = CommonController::getcolor_bysubrd('l_'.$split_color);
                }
                else if($temp['subrd_type'] == 5)
                {
                    $temp2['color'] = CommonController::getcolor_bysubrd('l_'.$split_color);   
                }
                else 
                {
                    $temp2['color'] = CommonController::getcolor_bysubrd('l_'.$split_color);
                }

                // Safety guard block against empty properties or white/grey fallbacks
                if(empty($temp2['color']) || $temp2['color'] == '#ffffff' || $temp2['color'] == 'grey') {
                    $temp2['color'] = CommonController::getcolor_bysubrd('l_'.$split_color);
                }
                
                $cluster_type = $value['subrd_loaction'];
                $cluster_tag = ($value['subrd_type']==1) ? 'Existing' : (($value['subrd_type']==2) ? 'Recommended' : (($value['subrd_type']==3) ? 'Wholesaler' : ''));
                $cluster_hub = ($value['subrd_type']==1) ? 'Existing SubRD' : (($value['subrd_type']==2) ? 'Recommd SubRD' : (($value['subrd_type']==3) ? 'Wholesaler' : ''));
                $value['village_census'] = ltrim($value['village_census'], 0);
                 $cluster_tag = "Feeder";
                if(isset($maparray[$value['village_census']]))
                {
                    $value['village_choc_consmptn'] = ($value['village_choc_consmptn'] != '') ? $value['village_choc_consmptn'] : 0;
                    $value['village_choc_consmptn'] = is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'], 0) : number_format((int)str_replace(",", "", $value['village_choc_consmptn']), 0);
                    $value['cluster_type'] = $cluster_type;
                    $temp2['shareinfo'] = 'Village: '.$value['village_name'].'; Taluk: '.$value['taluk_name'].'; Distt: '.$value['district_name'].'; State: '.$value['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$value['population'].' Nos.; Rural Progressive Index: '.$value['rpi'].'; Outlet Potential: '.$value['outlet_potential'].' Nos.; ' . $consmtp[$user->client_id] . ' (Annual) (Rs.): '.$value['village_choc_consmptn'].'; Market UID: '.$value['market_id'].'; BI Location ID: '.$value['bi_id'].';SubRD Priority: '.$value['subrd_priority'].'; SubRD Cluster Priority: '.$value['subrd_priority'].'; ';

                    $temp2['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">' . (($userid==13285) ? "Feeder Mkt" : "Feeder Mkt") . ':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$value['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from ' . $cluster_hub . ' (km): </span>'.$value['distance_subrd'].' kms</p>';
                    
                    if($user->client_id == 1000 && $value['sector'] == 'Rural')
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($value['population'], 0) . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p>';
                    if($user->client_id != 1000)
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2025): </span>' . number_format($value['population'], 0) . '</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p>';

                    if($value['subrd_type'] == 1 && $user->client_id == 120)
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$mdlz.': </span>' . $value['mdlz_retlr_universe'] . ' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>' . number_format($value['avg_monthly_sale'], 0) . ' Nos.</p>';
                    if($user->client_id == 1000 && $value['sector'] == 'Rural') 
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$value['village_choc_consmptn'].' </p>';
                    if($user->client_id != 1000 && $user->client_id != 112 && $user->client_id != 9999)
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$value['village_choc_consmptn'].' </p>';
                    if($user->client_id == 9999)
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$value['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$value['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$value['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$value['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$value['rly_stn'].'</p>';
                        
                    $rural_img = ($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                    $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >' . $rural_img . '</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';

                    if(in_array($value['subrd_type'], [2,3]) && $user->client_id == 120) 
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$value['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$value['subrd_priority'].'</p>';
                    if($user->client_id == 120)
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">' . $value['market_id'] . '</span></p>';
                    if(in_array($value['subrd_type'], [1]) && $user->client_id == 120) 
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD ' . (($userid==13285) ? "" : " Name") . ': </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                    if($user->client_id != 120 && $user->client_id != 112)
                    {
                        $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >' . $value['bi_id'] . ' </span></p>';
                        if(in_array($value['subrd_type'], [1]))
                            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                    }

                    if($user->client_id == 112)
                    {
                        if(in_array($value['subrd_type'], [1]))
                            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Name: </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                        if(in_array($value['subrd_type'], [5]))
                            $temp2['info'] .= '<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Code: </span><span style="background-color:white;color:black;" >' . $final_result[$k]['exist_subrd_code'] . ' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist DBR Name: </span><span style="background-color:white;color:black;" >' . ucwords(strtolower($final_result[$k]['exist_subrd_name'])) . ' </span></p>';
                    }
                
                    $value['population'] = number_format($value['population'], 0);
                    $value['village_name'] = $maparray[$value['village_census']]['location_name'];
                    $child_val = [0=>$value];
                    $value_json = htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
                    $temp2['info'] .= '<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$value_json.')">More Info</span></div></div>';
                    
                    if($user->client_id == 133)
                    {
                        $rural_img = ($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                        $temp2['info'] = '<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2025): </span>'.$value['population'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >' . $rural_img . '</span></p><div ></div></div>'; 
                    }

                    $value['activate_status'] = $value['company_service_id'];
                    $cluster_tag = ($value['subrd_type']==1) ? 'Existing' : (($value['subrd_type']==2) ? 'Recommanded' : (($value['subrd_type']==3) ? 'Wholesaler' : ''));
                    $value['activate_marker'] = ($value['company_service_id']==1) ? 'rural_icon/active.png' : (($value['company_service_id']==2) ? 'rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'rural_icon/deactivated.png' : (($value['company_service_id']==4) ? 'rural_icon/activated.png' : (($value['company_service_id']==5) ? 'rural_icon/deactivated.png' : 'NA'))));
                    
                    $temp2['size'] = 8;
                    $temp2['activate_status_icon'] = $value['activate_marker'];
                    $temp2['activate_status'] = $value['activate_status'];
                    $temp2['subrd_status'] = 0;
                    $temp2['subrd_marker'] = 'NA';             
                    $temp2['subrd_tooltip'] = '';
                
                    $maparray[$value['village_census']] = array_merge($maparray[$value['village_census']], $temp2);
                }
            }
        }
        
        $data['legend'] = [];
        $data['legend'][0] = $summary_count;
       
            $data['griddata'] = $this->getsubrdFeeder($table_data);
            
        $data['child_list'] = $child_list;
        $data['mapdata'] = $maparray;
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk) > 0)
            $data['head'] = implode(", ", $taluk_name) . ' sub-distt, ' . implode(", ", $district_name);
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district) > 0)
            $data['head'] = implode(", ", $district_name) . ' distt, ' . implode(", ", $state_name);
        else
            $data['head'] = '';

        return $data;
        }
public function Combine_krishnagiri_subrd($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
{
         $getfilter=json_decode($input_obj);
         $type_view=[1,2];

       
       
        $tbllist=[112=>'coke_subrd_data_krishnagiri'];
        $consmtp=[112=>'Confectionery Consmptn'];
       
        //\Log::info('Confectionery Consmptn');
        $subrd_name=[112=>[0=>'Spoke Reco',1=>'Reco Villg.']];
         $data = [];$getdetail=[];
         $color=['green','red','lavender','pink','orange','fgreen','chaani'];
        $user = auth()->user();
        $userid = $user->id;
       
        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
       
       
        $summary_count=[];
        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
        $summary_count['show_summary']=0;
        $summary_count['new_village_current']=0;
        $summary_count['new_village_recommand']=0;
       
    
        $orwhere=[];
        if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
            array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_district).")");
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            array_push($orwhere,"  a.taluk_census in (".implode(",",$getfilter->filter_taluk).")");

        $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
        // if(isset($getfilter->type_view) && $getfilter->type_view!='')
        //     $str .=' and subrd_type in ('.$getfilter->type_view.',0)';
        if(isset($getfilter->filter_priority) && $getfilter->filter_priority!='')
             $str .=' and a.subrd_priority="'.$getfilter->filter_priority.'"';
        if(isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd!='')
             $str .=' and a.exist_subrd_code="'.$getfilter->filter_existsubrd.'"';
         $select ='';

        $sql="SELECT  b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale".$select." FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and a.stat='A' and  b.stat='A' ";
  
 
         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);
          
          $final_result=[];
          $inc=0;
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'district_name');
          $district_name=array_unique($district_name);
          $state_name=array_column($result,'state_code');
          $state_name=array_unique($state_name);
          $table_data=[];         
          $without_hub=$result;
          $non_cluster_color=[];
          $child_list=[];



         
         for($i=0;$i<count($result);$i++)
         {
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'],$type_view))
             {
                  
                  $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                  $final_result[$inc]['child']=[];
                  $filter_id=$result[$i]['cluster_id'];

                                 
                  $final_result[$inc]['subrd_marker']=($result[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($result[$i]['subrd_type']==2) ? 'rural_icon/recommended-subrd.png' : (($result[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';
                    $hub_child_list = array_filter($result, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                   });
                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                   });

                              
                  $final_result[$inc]['child']=$hub_child_list; 
                  $res_arr=$result[$i];
                  $child_list[$filter_id]=$hub_child_list;

                  $res_arr['child']=htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                  $res_arr['child_count']=count($hub_child_list);
                    $res_arr['child_d']=$hub_child_list;
                  
                 $inc++;
                 array_push($table_data,$res_arr);
                }
                  
             }
             else if($result[$i]['subrd_type'] ==0 || !in_array($result[$i]['subrd_type'],$type_view))
             {
                $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                    $final_result[$inc]['child']=[];
                     $final_result[$inc]['child_d']=[];
                    $final_result[$inc]['subrd_marker']='NA';
                     $child_list[$result[$i]['cluster_id']]=[];
                    $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
             }
         }
         $without_hub=array_values($without_hub);
         $without_hub_count=count($without_hub);
      $mdlz=($user->id==13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";
         for($i=0;$i<$without_hub_count;$i++)
         {
      
              $without_hub[$i]['village_census']=ltrim($without_hub[$i]['village_census'], 0);

                if(isset($maparray[$without_hub[$i]['village_census']]))
                {
                    if($without_hub[$i]['subrd_type']==1 && $without_hub[$i]['active_stat'] =='No')
                        $summary_count['new_village_current']++;
                     if($without_hub[$i]['subrd_type']==2)
                        $summary_count['new_village_recommand']++;
                       
                     if(in_array($without_hub[$i]['subrd_type'],[1,2,3]))   
                     {
                        if(in_array($without_hub[$i]['subrd_type'],[2,3]) && in_array($without_hub[$i]['subrd_type'],$type_view))   
                            $summary_count['show_summary']=$without_hub[$i]['subrd_type']; 
                     
                        
                     }  
                       
                  
                    $final_result[$inc]=$without_hub[$i];
                    $final_result[$inc]['child']=[];
                    $final_result[$inc]['subrd_marker']=($without_hub[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($without_hub[$i]['subrd_type']==2) ? 'rural_icon/recommendation_new.png' : (($without_hub[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$without_hub[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$without_hub[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
         }
      
         $result_count=count($final_result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            $temp=$final_result[$k];
           if($temp['subrd_type']==1 && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                if($temp['subrd_loaction']=='Existing Urban Distbtr Hub' || $temp['subrd_loaction']=='Existing Urban Distbtr')
                    $split_color='lblue';
                else
                    $split_color='grey';
            }
           else if(($temp['subrd_type']==2) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
              $range=array_rand(range(0,(count($color)-1)));
              $split_color=$color[$range];
           }
           else if(($temp['subrd_type']==3) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
                 $split_color='fgreen';
           }

           else if($temp['subrd_type']==0)
              $split_color='none';
           else
              $split_color='none';
            if(in_array($temp['subrd_type'],[2,3]) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                $summary_count['total_village']++;   
                if( $summary_count['show_summary']=='')           
                $summary_count['show_summary']=$temp['subrd_type'];
            }

            unset($temp['child']);
            
             
            if($temp['is_hub'] != 1 && $temp['subrd_type']!=0)
             {
                $hub='#ffffff';$child='';
                if(($temp['active_stat']=='Yes' || $temp['active_stat']=='') && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                          $hub= CommonController::getcolor_bysubrd('l_grey');
                if($temp['active_stat']=='No'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                     $hub= CommonController::getcolor_bysubrd('yellow');
                if($temp['subrd_loaction']=='Existing Urban Distbtr'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                           $hub= CommonController::getcolor_bysubrd('l_lblue'); 
                if((($temp['subrd_type']==2) || ($temp['subrd_type']==3)) && in_array($temp['subrd_type'],$type_view))
               {
                  if(isset($non_cluster_color[$temp['cluster_name']]) && $temp['subrd_type'] !=3)
                            $hub= CommonController::getcolor_bysubrd('l_'.$non_cluster_color[$temp['cluster_name']]); 
                  else if($temp['subrd_type'] !=3){

                     $range=array_rand(range(0,(count($color)-1)));
                     $split_color=$color[$range];
                     $hub= CommonController::getcolor_bysubrd('l_'.$split_color); 
                     $non_cluster_color[$temp['cluster_name']]=$split_color;
                  }
                  else if($temp['subrd_type'] ==3)
                  {
                      $hub= CommonController::getcolor_bysubrd('l_fgreen');
                  }
                 
               }
            }             
             else
                $hub= CommonController::getcolor_bysubrd('d_'.$split_color); 
             $label='';
             $legend="";
             $temp['color']=$hub; 

              $cluster_type=$final_result[$k]['subrd_loaction'];             
             
             $final_result[$k]['activate_status']=$final_result[$k]['company_service_id'];
             $cluster_tag=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'SubRD Existg' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommended' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $cluster_hub=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existg SubRD' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommd SubRD' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $temp['activate_marker']=($final_result[$k]['company_service_id']==1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($final_result[$k]['company_service_id']==4) ? 'rural_icon/activated.png' :(($final_result[$k]['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             if($temp['is_hub']!=0)
            {
                $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
               $temp['subrd_marker']=(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/recommendation_new.png' :   (($final_result[$k]['subrd_type']==1 && $temp['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/urban-distributor.png' :  (($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/efficient-subrd.png' : (($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/Wholesale.png' : ''))));
             $temp['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$final_result[$k]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$cluster_tag.'</li></ul> </div></div></div>';
            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['subrd_marker']='NA';             
                 $temp['subrd_tooltip']='';
            }


             // 
    if($final_result[$k]['subrd_type']!=0 && in_array($final_result[$k]['subrd_type'],$type_view))
    {
    $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.; '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].';SubRD Priority: '.$final_result[$k]['subrd_priority'].'; SubRD Cluster Priority: '.$final_result[$k]['subrd_priority'].'; ';

    
    $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? $final_result[$k]['village_choc_consmptn'] : 0;
    $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);



            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">'.(($userid==13285) ? "Recommendatn" : "Recommendatn").':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$final_result[$k]['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from '.$cluster_hub.' (km): </span>0 kms</p>';
           if($user->client_id!=1000)
            $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn: </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
          
           
          
            $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
           
            

          
          
          
        
         if($user->client_id!=120)
         {
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
           
         }

            $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
            $final_result[$k]['cluster_type']=$cluster_type;
    $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
                $temp['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';
        
                
    }
    else
                {
                    $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
    $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);
    $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].'; ';
    $mdlz=($user->id==13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";

                 $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
          if($user->client_id!=1000)
                 $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn: </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
            
         
               
          $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
          $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>'.$rural_img.'</span></p>';
       
        if($user->client_id!=120)            
          $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
       
          
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
          $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

             $temp['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';  
             }
        
             $temp['size']=15;
             $temp['activate_status_icon']=$temp['activate_marker'];
             $temp['activate_status']=$final_result[$k]['activate_status'];
            
            $maparray[$final_result[$k]['village_census']]=array_merge($maparray[$final_result[$k]['village_census']],$temp);

            $temp2=[];
            
            foreach($final_result[$k]['child'] as $key=>$value)
            {
                 $temp2=$value;
                 if($value['subrd_type']==1 && $value['active_stat'] =='No')
                    $summary_count['new_village_current']++;
                 if($value['subrd_type']==2)
                    $summary_count['new_village_recommand']++;
                 if(in_array($value['subrd_type'],[2,3])){
                     $summary_count['new_village']++;

                   if(isset($summary_count[$value['rpi']]))
                            $summary_count[$value['rpi']]++;
                 }
                    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                 if($value['subrd_type']==1)    
                 {
                       if($value['active_stat']=='Yes')
                          $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                       if($value['active_stat']=='No')
                           $temp2['color']= CommonController::getcolor_bysubrd('yellow');                      
                 }             
                 // else                 
                 //    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                
                 // $cluster_type=(isset($subrd_name[$user->client_id])) ? $subrd_name[$user->client_id][1] : $value['subrd_loaction'];
                 $cluster_type=$value['subrd_loaction'];
                 $cluster_tag=($value['subrd_type']==1) ? 'Existg' :(($value['subrd_type']==2) ? 'Recommended' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($value['subrd_type']==1) ? 'Existg SubRD' :(($value['subrd_type']==2) ? 'Recommd SubRD' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                   $value['village_census']=ltrim($value['village_census'], 0);
                  if(isset($maparray[$value['village_census']]))
                {
                   
                    $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ?  $value['village_choc_consmptn'] : 0;
                     $value['village_choc_consmptn']=is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$value['village_choc_consmptn']),0);
                     $value['cluster_type']=$cluster_type;
    $temp2['shareinfo']='Village: '.$value['village_name'].'; Taluk: '.$value['taluk_name'].'; Distt: '.$value['district_name'].'; State: '.$value['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$value['population'].' Nos.; Rural Progressive Index: '.$value['rpi'].'; Outlet Potential: '.$value['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$value['village_choc_consmptn'].'; Market UID: '.$value['market_id'].'; BI Location ID: '.$value['bi_id'].';SubRD Priority: '.$value['subrd_priority'].'; SubRD Cluster Priority: '.$value['subrd_priority'].'; ';

                       $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Recommendatn:</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$value['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from  '.$cluster_hub.' (km): </span>'.$value['distance_subrd'].' kms</p>';
            
        if($user->client_id!=1000)
            $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn: </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p>';

     
           
                  
                $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';

         
            if($user->client_id!=120)
            {
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$value['bi_id'].' </span></p>';
             
            }
          
            
           $value['population']= number_format($value['population'],0);
            $value['village_name']=$maparray[$value['village_census']]['location_name'];
            $child_val=[0=>$value];
                  $value_json=htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
             $temp2['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$value_json.')">More Info</span></div></div>';
            
             $value['activate_status']=$value['company_service_id'];
             $cluster_tag=($value['subrd_type']==1) ? 'Existg' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
             $value['activate_marker']=($value['company_service_id']==1) ? 'rural_icon/active.png' : (($value['company_service_id']==2) ? 'rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'rural_icon/activated.png' :(($value['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             $temp2['size']=8;
             $temp2['activate_status_icon']=$value['activate_marker'];
             $temp2['activate_status']=$value['activate_status'];
             $temp2['subrd_status']=0;
             $temp2['subrd_marker']='NA';             
             $temp2['subrd_tooltip']='';

             // $temp2['village_census']=ltrim($value['village_census'],0);
           
            $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                }

             

            }
         
         }

        $data['legend']=[];
        $data['legend'][0] = $summary_count;
        
        $data['griddata'] = $this->getsubrd_krishnagiri($table_data);
        $data['child_list']=$child_list;
        $data['mapdata'] = $maparray;
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            $data['head']=implode(", ", $taluk_name). ' sub-distt, '.implode(", ", $district_name);
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
             $data['head']=implode(", ", $district_name). ' distt, '.implode(", ", $state_name);
         else
             $data['head']='';

        return $data;

    }
     public function demo_combine_subrd($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {

          $user = auth()->user();
          $userid = $user->id;
         
          if($user->role=='SM' && $user->client_id == 112)
          {
              $tbllist=[120=>'subrd_data_demo',123=>'subrd_data_perfetti',112=>'coke_subrd_data_all',133=>'subrd_data',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];
          }
          else
          {
             $tbllist=[120=>'subrd_data_demo',123=>'subrd_data_perfetti',112=>'coke_subrd_data',133=>'subrd_data',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];
          }

           
       
        $consmtp=[120=>'Villg. Choc Consmptn',123=>'Confectionery Consmptn',112=>'Confectionery Consmptn',133=>'',1000=>'',9999=>'Confectionery Consmptn'];

        $subrd_name=[112=>[0=>'Spoke Reco',1=>'Reco Villg.',133=>'',1000=>'',9999=>'']];
         $data = [];$getdetail=[];
         $color=['green','red','lavender','pink','orange','fgreen','chaani'];
       
        if($userid==13285)
        {
            $consmtp[120]='Catgry Consmptn';
        }
        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
        $getfilter=json_decode($input_obj);
       
        $summary_count=[];
        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
        $summary_count['show_summary']=0;
        $summary_count['new_village_current']=0;
        $summary_count['new_village_recommand']=0;
        $type_view=explode(",",$getfilter->type_view);
    
        $orwhere=[];
        if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
            array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_district).")");
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            array_push($orwhere,"  a.taluk_census in (".implode(",",$getfilter->filter_taluk).")");

        $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
        // if(isset($getfilter->type_view) && $getfilter->type_view!='')
        //     $str .=' and subrd_type in ('.$getfilter->type_view.',0)';
        if(isset($getfilter->filter_priority) && $getfilter->filter_priority!='')
             $str .=' and a.subrd_priority="'.$getfilter->filter_priority.'"';
        if(isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd!='')
             $str .=' and a.exist_subrd_code="'.$getfilter->filter_existsubrd.'"';
         $select ='';
         if($user->client_id==9999)
          $select =',no_of_schools,no_of_colleges,hh,if(atm="-","No",atm) atm,if(bank="-","No",bank) bank,if(nh="-","No",nh) nh,if(sh="-","No",sh) sh,if(rly_stn="-","No",rly_stn) rly_stn';
         



 $sql="SELECT  a.catgry_shr,b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale".$select." FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";
  // echo $sql;die;
 
         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);
          
          $final_result=[];
          $inc=0;
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'district_name');
          $district_name=array_unique($district_name);
          $state_name=array_column($result,'state_code');
          $state_name=array_unique($state_name);
          $table_data=[];
          $priority=['Priority 1'=>'rural_icon/r_p1.png','Priority 2'=>'rural_icon/r_p2.png','Priority 3'=>'rural_icon/r_p3.png',''=>'rural_icon/recommendation.png','P1'=>'rural_icon/r_p1.png','P2'=>'rural_icon/r_p2.png'];
          $without_hub=$result;
          $non_cluster_color=[];
          $child_list=[];

       $result = array_map(function ($item) use ($maparray) {
            if (isset($maparray[$item['village_census']])) {
                $item['village_name'] = $maparray[$item['village_census']]['location_name'];
                $item['district_name']=$item['district_name'].' distt';
                 $item['taluk_name']=$item['taluk_name'].' sub-distt';
            } else {
                $item['village_name'] = null; // fallback if not found
            }
            return $item;
        }, $result);

         
         for($i=0;$i<count($result);$i++)
         {
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'],$type_view))
             {
                  
                  $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                  $result[$i]['location']=$maparray[$result[$i]['village_census']]['location_name'];
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                  $final_result[$inc]['child']=[];
                  $filter_id=$result[$i]['cluster_id'];

                                 
                  $final_result[$inc]['subrd_marker']=($result[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($result[$i]['subrd_type']==2) ? $priority[$result[$i]['subrd_priority']] : (($result[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';
                    $hub_child_list = array_filter($result, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                   });
                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                   });

                              
                  $final_result[$inc]['child']=$hub_child_list; 
                  $res_arr=$result[$i];
                  $child_list[$filter_id]=$hub_child_list;

                  $res_arr['child']=htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                  $res_arr['child_count']=count($hub_child_list);
                    $res_arr['child_d']=$hub_child_list;
                  
                 $inc++;
                 array_push($table_data,$res_arr);
                }
                  
             }
             else if($result[$i]['subrd_type'] ==0 || !in_array($result[$i]['subrd_type'],$type_view))
             {
                $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                 $result[$i]['location']=$maparray[$result[$i]['village_census']]['location_name'];
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                    $final_result[$inc]['child']=[];
                     $final_result[$inc]['child_d']=[];
                    $final_result[$inc]['subrd_marker']='NA';
                     $child_list[$result[$i]['cluster_id']]=[];
                    $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
             }
         }
         $without_hub=array_values($without_hub);
         $without_hub_count=count($without_hub);
      $mdlz=($user->id==13285) ? " Retlr Covrge" : "MDLZ Cvrg";
         for($i=0;$i<$without_hub_count;$i++)
         {
      
              $without_hub[$i]['village_census']=ltrim($without_hub[$i]['village_census'], 0);
               $without_hub[$i]['location']=$maparray[$without_hub[$i]['village_census']]['location_name'];

                if(isset($maparray[$without_hub[$i]['village_census']]))
                {
                    if($without_hub[$i]['subrd_type']==1 && $without_hub[$i]['active_stat'] =='No')
                        $summary_count['new_village_current']++;
                     if($without_hub[$i]['subrd_type']==2)
                        $summary_count['new_village_recommand']++;
                       
                     if(in_array($without_hub[$i]['subrd_type'],[1,2,3]))   
                     {
                        if(in_array($without_hub[$i]['subrd_type'],[2,3]) && in_array($without_hub[$i]['subrd_type'],$type_view))   
                            $summary_count['show_summary']=$without_hub[$i]['subrd_type']; 
                     
                        
                     }  
                       
                  
                    $final_result[$inc]=$without_hub[$i];
                    $final_result[$inc]['child']=[];
                    $final_result[$inc]['subrd_marker']=($without_hub[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($without_hub[$i]['subrd_type']==2) ? $priority[$without_hub[$i]['subrd_priority']] : (($without_hub[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$without_hub[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$without_hub[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
         }
      
         $result_count=count($final_result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            $temp=$final_result[$k];
           if($temp['subrd_type']==1 && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                if($temp['subrd_loaction']=='Existg Urban Distbtr Hub' || $temp['subrd_loaction']=='Existg Urban Distbtr')
                    $split_color='lblue';
                else
                    $split_color='grey';
            }
           else if(($temp['subrd_type']==2) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
              $range=array_rand(range(0,(count($color)-1)));
              $split_color=$color[$range];
           }
           else if(($temp['subrd_type']==3) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
                 $split_color='fgreen';
           }

           else if($temp['subrd_type']==0)
              $split_color='none';
           else
              $split_color='none';
            if(in_array($temp['subrd_type'],[2,3]) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                $summary_count['total_village']++;   
                if( $summary_count['show_summary']=='')           
                $summary_count['show_summary']=$temp['subrd_type'];
            }

            unset($temp['child']);
            
             
            if($temp['is_hub'] != 1 && $temp['subrd_type']!=0)
             {
                $hub='#ffffff';$child='';
                if(($temp['active_stat']=='Yes' || $temp['active_stat']=='') && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                          $hub= CommonController::getcolor_bysubrd('l_grey');
                if($temp['active_stat']=='No'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                     $hub= CommonController::getcolor_bysubrd('yellow');
                if($temp['subrd_loaction']=='Existg Urban Distbtr'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                           $hub= CommonController::getcolor_bysubrd('l_lblue'); 
                if((($temp['subrd_type']==2) || ($temp['subrd_type']==3)) && in_array($temp['subrd_type'],$type_view))
               {
                  if(isset($non_cluster_color[$temp['cluster_name']]) && $temp['subrd_type'] !=3)
                            $hub= CommonController::getcolor_bysubrd('l_'.$non_cluster_color[$temp['cluster_name']]); 
                  else if($temp['subrd_type'] !=3){

                     $range=array_rand(range(0,(count($color)-1)));
                     $split_color=$color[$range];
                     $hub= CommonController::getcolor_bysubrd('l_'.$split_color); 
                     $non_cluster_color[$temp['cluster_name']]=$split_color;
                  }
                  else if($temp['subrd_type'] ==3)
                  {
                      $hub= CommonController::getcolor_bysubrd('l_fgreen');
                  }
                 
               }
            }             
             else
                $hub= CommonController::getcolor_bysubrd('d_'.$split_color); 
             $label='';
             $legend="";
             $temp['color']=$hub; 

              $cluster_type=$final_result[$k]['subrd_loaction'];
              if($user->client_id==1000)
               $cluster_type=$final_result[$k]['subrd_loaction'];
             
             $final_result[$k]['activate_status']=$final_result[$k]['company_service_id'];
             $cluster_tag=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'SubRD Existg' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommended' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $cluster_hub=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existg SubRD' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommd SubRD' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $temp['activate_marker']=($final_result[$k]['company_service_id']==1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($final_result[$k]['company_service_id']==4) ? 'rural_icon/activated.png' :(($final_result[$k]['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             if($temp['is_hub']!=0)
            {
                $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
               $temp['subrd_marker']=(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? $priority[$final_result[$k]['subrd_priority']] :   (($final_result[$k]['subrd_type']==1 && $temp['subrd_loaction']=='Existg Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/urban-distributor.png' :  (($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/efficient-subrd.png' : (($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/Wholesale.png' : ''))));
             $temp['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$final_result[$k]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$cluster_tag.'</li></ul> </div></div></div>';
            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['subrd_marker']='NA';             
                 $temp['subrd_tooltip']='';
            }


             // 
    if($final_result[$k]['subrd_type']!=0 && in_array($final_result[$k]['subrd_type'],$type_view))
    {
    $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.; '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].';SubRD Priority: '.$final_result[$k]['subrd_priority'].'; SubRD Cluster Priority: '.$final_result[$k]['subrd_priority'].'; ';

    // $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? number_format($final_result[$k]['village_choc_consmptn'],0) : $final_result[$k]['village_choc_consmptn'];
    $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? $final_result[$k]['village_choc_consmptn'] : 0;
    $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);



            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].',</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].'</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">'.(($userid==13285) ? "Recommendatn" : "Recommendatn").':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$final_result[$k]['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from '.$cluster_hub.' (km): </span>0 kms</p>';
           if($user->client_id!=1000)
            $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
           if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
            $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';

           if($final_result[$k]['subrd_type']==1 &&  $user->client_id==120)
              $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$mdlz.': </span>'.$final_result[$k]['mdlz_retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>'.number_format($final_result[$k]['avg_monthly_sale'],0).'</p>';
           if($user->client_id!=1000 && $user->client_id!=112 && $user->client_id!=9999)
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Catgry Shr: </span><span style="background-color:white;color:black;" >'.number_format($final_result[$k]['catgry_shr'],2).' %</span></p>';
            if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
            /* <p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$final_result[$k]['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$final_result[$k]['no_of_schools'].' Nos. </p>*/
            if($user->client_id==9999)
                 $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$final_result[$k]['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$final_result[$k]['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$final_result[$k]['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$final_result[$k]['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$final_result[$k]['rly_stn'].'</p>';
            $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
           
            

             if(in_array($final_result[$k]['subrd_type'],[2,3]) &&  $user->client_id==120)
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$final_result[$k]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$final_result[$k]['subrd_priority'].'</p>';
          if(in_array($final_result[$k]['subrd_type'],[1]) &&  $user->client_id==120)
              $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existg SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existg SubRD'.(($userid==13285) ? "" : " Name").': </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
          
          if($user->client_id==120)
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p>';
         if($user->client_id!=120)
         {
             $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
             if(in_array($final_result[$k]['subrd_type'],[1]))
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existg SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existg SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
         }

            $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
            $final_result[$k]['cluster_type']=$cluster_type;
    $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
                $temp['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';
        
                
    }
    else
             {
                $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
$final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);
 $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].'; ';
$mdlz=($user->id==13285) ? "Covrge" : "MDLZ Cvrg";

                 $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].',</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].'</span></span></h5><hr style="border-top: 1px solid white;">';
          if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
                 $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
            if($user->client_id!=1000)
                 $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
              if($user->client_id!=112 && $user->client_id!=9999)
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;"> '.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Catgry Shr: </span><span style="background-color:white;color:black;" >'.number_format($final_result[$k]['catgry_shr'],2).' %</span></p>';  
            /*<p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$final_result[$k]['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$final_result[$k]['no_of_schools'].' Nos. </p>*/
          if($user->client_id==9999)
                 $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$final_result[$k]['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$final_result[$k]['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$final_result[$k]['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$final_result[$k]['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$final_result[$k]['rly_stn'].'</p>';
               
          $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
          $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>'.$rural_img.'</span></p>';
       if($user->client_id==120)
         $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p>';
        if($user->client_id!=120)            
          $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
       
           // $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
           // $final_result[$k]['village_choc_consmptn']=number_format($final_result[$k]['village_choc_consmptn'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
          $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

             $temp['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">More Info</span></div></div>';  
             }
              if($user->client_id==133)
         {
             $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
             $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].',</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].'</span></span></h5><hr style="border-top: 1px solid white;">';
            $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>
<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><div ></div></div>';
         }
             $temp['size']=15;
             $temp['activate_status_icon']=$temp['activate_marker'];
             $temp['activate_status']=$final_result[$k]['activate_status'];
            
            $maparray[$final_result[$k]['village_census']]=array_merge($maparray[$final_result[$k]['village_census']],$temp);

            $temp2=[];
            
            foreach($final_result[$k]['child'] as $key=>$value)
            {
                 $temp2=$value;
                 if($value['subrd_type']==1 && $value['active_stat'] =='No')
                    $summary_count['new_village_current']++;
                 if($value['subrd_type']==2)
                    $summary_count['new_village_recommand']++;
                 if(in_array($value['subrd_type'],[2,3])){
                     $summary_count['new_village']++;

                   if(isset($summary_count[$value['rpi']]))
                            $summary_count[$value['rpi']]++;
                 }
                    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                 if($value['subrd_type']==1)    
                 {
                       if($value['active_stat']=='Yes')
                          $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                       if($value['active_stat']=='No')
                           $temp2['color']= CommonController::getcolor_bysubrd('yellow');                      
                 }             
                 // else                 
                 //    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                
                 // $cluster_type=(isset($subrd_name[$user->client_id])) ? $subrd_name[$user->client_id][1] : $value['subrd_loaction'];
                 $cluster_type=$value['subrd_loaction'];
                 $cluster_tag=($value['subrd_type']==1) ? 'Existg' :(($value['subrd_type']==2) ? 'Recommended' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($value['subrd_type']==1) ? 'Existg SubRD' :(($value['subrd_type']==2) ? 'Recommd SubRD' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                   $value['village_census']=ltrim($value['village_census'], 0);
                  if(isset($maparray[$value['village_census']]))
                {
                   
                    $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ?  $value['village_choc_consmptn'] : 0;
                     $value['village_choc_consmptn']=is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$value['village_choc_consmptn']),0);
                     $value['cluster_type']=$cluster_type;
$temp2['shareinfo']='Village: '.$value['village_name'].'; Taluk: '.$value['taluk_name'].'; Distt: '.$value['district_name'].'; State: '.$value['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$value['population'].' Nos.; Rural Progressive Index: '.$value['rpi'].'; Outlet Potential: '.$value['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$value['village_choc_consmptn'].'; Market UID: '.$value['market_id'].'; BI Location ID: '.$value['bi_id'].';SubRD Priority: '.$value['subrd_priority'].'; SubRD Cluster Priority: '.$value['subrd_priority'].'; ';

                       $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].',</span><br><span style="line-height:1rem;">'.$value['district_name'].'</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">'.(($userid==13285) ? "Recommendatn" : "Recommendatn").':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$value['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from  '.$cluster_hub.' (km): </span>'.$value['distance_subrd'].' kms</p>';
            if($user->client_id==1000 && $value['sector']=='Rural')
                $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn (2021): </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ: </span>'.$value['retlr_universe'].' Nos.</p>';
        if($user->client_id!=1000)
            $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn (2021): </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ: </span>'.$value['retlr_universe'].' Nos.</p>';

       if($value['subrd_type']==1 &&  $user->client_id==120)
               $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$mdlz.': </span>'.$value['mdlz_retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>'.number_format($value['avg_monthly_sale'],0).' </p>';
             if($user->client_id==1000 && $value['sector']=='Rural')          
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$value['village_choc_consmptn'].' </p>';
             if($user->client_id!=1000 && $user->client_id!=112 && $user->client_id!=9999)
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' (Annual) (Rs.): </span>'.$value['village_choc_consmptn'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Catgry Shr: </span><span style="background-color:white;color:black;" >'.number_format($value['catgry_shr'],2).' %</span></p>';
             /*<p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$value['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$value['no_of_schools'].' Nos. </p>*/
              if($user->client_id==9999)
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$value['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$value['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$value['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$value['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$value['rly_stn'].'</p>';
                  
                $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';

           if(in_array($value['subrd_type'],[2,3]) && $user->client_id==120)                
             $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$value['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$value['subrd_priority'].'</p>';
          if($user->client_id==120)
             $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$value['market_id'].'</span></p>';
         if(in_array($value['subrd_type'],[1]) && $user->client_id==120)  
              $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existg SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existg SubRD '.(($userid==13285) ? "" : " Name").': </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
            if($user->client_id!=120)
            {
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$value['bi_id'].' </span></p>';
              if(in_array($value['subrd_type'],[1]))
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existg SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existg SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
            }
          
            
           $value['population']= number_format($value['population'],0);
            $value['village_name']=$maparray[$value['village_census']]['location_name'];
            $child_val=[0=>$value];
                  $value_json=htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
             $temp2['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$value_json.')">More Info</span></div></div>';
             if($user->client_id==133)
             {
                  $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                 $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Popn (2021): </span>'.$value['population'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ: </span>'.$value['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><div ></div></div>'; 
             }
             $value['activate_status']=$value['company_service_id'];
             $cluster_tag=($value['subrd_type']==1) ? 'Existg' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
             $value['activate_marker']=($value['company_service_id']==1) ? 'rural_icon/active.png' : (($value['company_service_id']==2) ? 'rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'rural_icon/activated.png' :(($value['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             $temp2['size']=8;
             $temp2['activate_status_icon']=$value['activate_marker'];
             $temp2['activate_status']=$value['activate_status'];
             $temp2['subrd_status']=0;
             $temp2['subrd_marker']='NA';             
             $temp2['subrd_tooltip']='';

             // $temp2['village_census']=ltrim($value['village_census'],0);
           
            $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                }

             

            }
         
         }

        $data['legend']=[];
        $data['legend'][0] = $summary_count;
        if($user->client_id==133)
             $data['griddata'] = $this->getsubrd_pepsi($table_data);
        else
        $data['griddata'] = $this->getsubrd($table_data);
        $data['child_list']=$child_list;
        $data['mapdata'] = $maparray;
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            $data['head']=implode(", ", $taluk_name). ' sub-distt, '.implode(", ", $district_name);
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
             $data['head']=implode(", ", $district_name). ' distt, '.implode(", ", $state_name);
         else
             $data['head']='';

        return $data;

    }
     
public function Distributor_whitespace($maparray,$type,$main_location,$sub_location,$input_obj,$current_location)
{
          $getfilter=json_decode($input_obj);
          $type_view=explode(",",$getfilter->type_view);

         
         

           /* $maparray[] = [
        'state_code' => $row->state_code,
        'district_name' => $row->district_name,
        'taluk_name' => $row->taluk_name,
        'village_name' => $row->town_village_name,
        'lat' => $row->latitude,
        'lng' => $row->longitude,
        'color' => $color,
        'icon' => $priority[$row->fld2124] ?? 'rural_icon/recommendation.png'
    ]; */
        //\Log::info($tbllist);
        
          $user = auth()->user();
          $userid = $user->id;

        if(($user->role=='HO' || $user->role=='SM') && $user->client_id == 112) //change-25-02-2025
        {
              $tbllist=[120=>'subrd_data',123=>'subrd_data_perfetti',112=>'coke_subrd_data_all',133=>'pepsi_subrd_data',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];

        }
        else
        {
           $tbllist=[120=>'subrd_data',123=>'subrd_data_perfetti',112=>'coke_subrd_data',133=>'pepsi.pepsi_sales',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];   
        }
        
        
        // \Log::info($tbllist);
         $consmtp=[120=>'Villg. Choc Consmptn',123=>'Confectionery Consmptn',112=>'Confectionery Consmptn',133=>'',1000=>'',9999=>'Confectionery Consmptn']; //change-25-02-2025

         $subrd_name=[112=>[0=>'Spoke Reco',1=>'Reco Villg.',133=>'',1000=>'',9999=>'']];
         $data = [];$getdetail=[];

        
         $color=['green','red','lavender','pink','orange','fgreen','chaani','grey'];
        $user = auth()->user();
        $userid = $user->id;
        if($userid==13285)
        {
            $consmtp[120]='Catgry Consmptn';
        }
        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
       
       
        $summary_count=[];
        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
        $summary_count['show_summary']=0;
        $summary_count['new_village_current']=0;
        $summary_count['new_village_recommand']=0;

        $orwhere=[];
        if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
           array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_district).")");
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            array_push($orwhere,"  b.taluk_name in (".implode(",",$getfilter->filter_taluk).")");

        $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
        // if(isset($getfilter->type_view) && $getfilter->type_view!='')
        //     $str .=' and subrd_type in ('.$getfilter->type_view.',0)';
        if(isset($getfilter->filter_priority) && $getfilter->filter_priority!='')
             $str .=' and a.subrd_priority="'.$getfilter->filter_priority.'"';
        if(isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd!='')
             $str .=' and a.exist_subrd_code="'.$getfilter->filter_existsubrd.'"';
         $select ='';
         if($user->client_id==9999)
          $select =',no_of_schools,no_of_colleges,hh,if(atm="-","No",atm) atm,if(bank="-","No",bank) bank,if(nh="-","No",nh) nh,if(sh="-","No",sh) sh,if(rly_stn="-","No",rly_stn) rly_stn';
         
        $sql="SELECT sum(sub2_Q1+sub2_Q2+sub2_Q3+sub2_Q4) as saleCnt,b.loc9,
            b.state_code,
            b.town_village_code as village_census,
            b.state_name,
            b.district_name,
            b.taluk_name,
            b.town_village_name,
            b.latitude,
            b.longitude,
            
        
            a.fld2124,
            a.fld2119 as retailer_id,
            a.distbtr_name,count(distinct(a.fld2119)) as retlr_cnt
        FROM ".$tbllist[$user->client_id]." as a
        JOIN town_village_polygon b 
            ON a.loc9=b.loc9
        WHERE b.stat='A'
        AND a.period_Y=2025
        $str
        GROUP BY a.loc14,a.fld2124";
  
      \Log::info($sql);  
         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);
         //\Log::info($result);  
         // \Log::info($maparray);  

         // Define your palette of colors
                    $colors = [
                '#FF5733', '#33FF57', '#3357FF', '#F1C40F', '#8E44AD', '#E67E22',
                '#1ABC9C', '#2ECC71', '#3498DB', '#9B59B6', '#34495E', '#16A085',
                '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400',
                '#C0392B', '#7F8C8D', '#E74C3C', '#95A5A6', '#00BCD4', '#4CAF50',
                '#CDDC39', '#FFC107', '#FF9800', '#9C27B0', '#3F51B5', '#009688'
            ];
            // Loop over your result
            $table_data=[];
            $distributorColor = [];
            $distributorIcon = [];
            $iconIndex = 0;
            $distributorColor = [];
            $grandTotal=0;
            $saleCnt=0;
            for ($i = 0; $i < count($result); $i++) {
                $villageId = $result[$i]['village_census'];
                 $distributor_id = trim($result[$i]['fld2124']);
               
               $grandTotal += (float)$result[$i]['saleCnt'];

                //$saleCntArr[$distributor_id] += $saleCnt; // add sales


              
            }
            //Step 2: calculate percentage
           // Step 2: Calculate Percentage
            for ($k = 0; $k < count($result); $k++) {

                $villageId = $result[$k]['village_census'];
                $distributor_id = trim($result[$k]['fld2124']);
                $distributor = trim($result[$k]['distbtr_name']);
                $saleCnt = (float)$result[$k]['saleCnt'];

                // Calculate percentage
                $percentage = ($grandTotal > 0) ? ($saleCnt / $grandTotal) * 100 : 0;
                $percentage = round($percentage);

                // Assign color based on percentage
                $fillColor = '#f0f0f0';
                if ($percentage > 0 && $percentage<=5) {
                    $fillColor = '#d6082aff'; // light pink
                } 
                elseif ($percentage>=6 && $percentage <= 10) {
                    $fillColor = '#FFD700'; // yellow
                } elseif ($percentage>=11 && $percentage <= 20) {
                    $fillColor = '#b2e9b2ff'; // green
                } 
                elseif ($percentage>=21 && $percentage <= 30) {
                    $fillColor = '#FF5733'; // yellow
                } elseif ($percentage>=31 && $percentage <= 40) {
                    $fillColor = '#adab1eff'; // green
                }
                 elseif ($percentage>=41 && $percentage <= 50) {
                    $fillColor = '#869c86ff'; // green
                 }
                 elseif ($percentage>=51 && $percentage <= 60) {
                    $fillColor = '#342c46ff'; // green
                 }
                 elseif ($percentage>=61 && $percentage <= 70) {
                    $fillColor = '#570426ff'; // green
                 }
                  elseif ($percentage>=71 && $percentage <= 80) {
                    $fillColor = '#4d4007ff'; // green
                  }
                 elseif ($percentage>=81 && $percentage <= 90) {
                    $fillColor = '#08c3f1ff'; // green
                 }
                  elseif ($percentage>=91 && $percentage <= 100) {
                    $fillColor = '#8a948aff'; // green

                } elseif ($percentage == 0) {
                   // $fillColor = 'rgb(80, 78, 73)'; // green
                    $fillColor = '#f0f0f0';

                }
                elseif ($percentage == 100) {
                    $fillColor = '#12fc7bff'; // green

                }
                 else {
                    $fillColor = 'rgb(139, 85, 151)'; // blue
                }


                // Distributor icon (default if not set)
                $iconPath = isset($distributorIcon[$distributor])
                    ? $distributorIcon[$distributor]
                    : 'rural_icon/distributor-icon.png';

                // Add row to table data
                $res_arr = (array)$result[$k];
                $res_arr['percentage'] = $percentage."%";
                array_push($table_data, $res_arr);

                // Unique key for village + distributor to prevent overwrite
            // $key = $villageId . '_' . $distributor_id;
                $key = $villageId;

            
                 $maparray[$key] = array_merge(
                    $maparray[$key] ?? [],
                    $result[$k],
                    [
                        'fillColor' => $fillColor,
                        'color'     => $fillColor,
                        'icon'      => $iconPath
                    ]
                );


                
                    $maparray[$villageId]['distributors'][] = [
            'distributor' => $distributor,
            'saleCnt' => $saleCnt,
            'percentage' => round($percentage),
            'color' => $fillColor,
            'icon' => $iconPath,
            'latitude' => $result[$k]['latitude'],
            'longitude' => $result[$k]['longitude']
        ];
                }

            
            $legend = [
                ['label' => '0%', 'color' => 'rgb(80, 78, 73)'],
                ['label' => '1 - 5%', 'color' => '#d6082aff'],
                ['label' => '6 - 10%', 'color' => '#FFD700'],
                ['label' => '11 - 20%', 'color' => '#b2e9b2ff'],
                ['label' => '21 - 30%', 'color' => '#FF5733'],
                ['label' => '31 - 40%', 'color' => '#adab1eff'],
                ['label' => '41 - 50%', 'color' => '#869c86ff'],
                ['label' => '51 - 60%', 'color' => '#342c46ff'],
                ['label' => '61 - 70%', 'color' => '#570426ff'],
                ['label' => '71 - 80%', 'color' => '#4d4007ff'],
                ['label' => '81 - 90%', 'color' => '#08c3f1ff'],
                ['label' => '91 - 100%', 'color' => '#8a948aff'],
                ['label' => '100%', 'color' => '#12fc7bff']
            ];

            // assign legend
            $data['legend'] = $legend;

          //\Log::info($maparray);  
          $final_result=[];
          $inc=0;
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'district_name');
          $district_name=array_unique($district_name);
          $state_name=array_column($result,'state_code');
          $state_name=array_unique($state_name);
          
          $priority=['Priority 1'=>'rural_icon/r_p1.png','Priority 2'=>'rural_icon/r_p2.png','Priority 3'=>'rural_icon/r_p3.png',''=>'rural_icon/recommendation.png','P1'=>'rural_icon/r_p1.png','P2'=>'rural_icon/r_p2.png'];
          $without_hub=$result;
          $non_cluster_color=[];
          $child_list=[];
          $temp=[];
          
        //$maparray[$final_result[$k]['village_census']]=array_merge($maparray[$final_result[$k]['village_census']],$temp)
        $data['legend']=[];
        $data['legend'][0] = $summary_count;
        $data['griddata'] = $this->getsubrdwhitespace($table_data);
        $data['child_list']=$child_list;
        $data['mapdata'] = $maparray;
     //  \Log::info($maparray);
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            $data['head']=implode(", ", $taluk_name). ' sub-distt, '.implode(", ", $district_name);
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
             $data['head']=implode(", ", $district_name). ' distt, '.implode(", ", $state_name);
         else
             $data['head']='';

        return $data;
   
}
          
    
     public function Combine_subrd_pepsi($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {
          $getfilter=json_decode($input_obj);
          $type_view=explode(",",$getfilter->type_view);

        //\Log::info($type_view);

           
        if(in_array(33,$type_view))
        {
            return $this->Distributor_whitespace($maparray, $type, $main_location, $sub_location,$input_obj,$current_location);
        }
        
          $user = auth()->user();
          $userid = $user->id;

        if(($user->role=='HO' || $user->role=='SM') && $user->client_id == 112) //change-25-02-2025
        {
              $tbllist=[120=>'subrd_data',123=>'subrd_data_perfetti',112=>'coke_subrd_data_all',133=>'pepsi_subrd_data',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];

        }
        else
        {
           $tbllist=[120=>'subrd_data',123=>'subrd_data_perfetti',112=>'coke_subrd_data',133=>'pepsi_subrd_data',1000=>'subrd_data_haldiram',9999=>'subrd_data_mars'];   
        }
        
        
         //\Log::info($tbllist);
         $consmtp=[120=>'Villg. Choc Consmptn',123=>'Confectionery Consmptn',112=>'Confectionery Consmptn',133=>'',1000=>'',9999=>'Confectionery Consmptn']; //change-25-02-2025

         $subrd_name=[112=>[0=>'Spoke Reco',1=>'Reco Villg.',133=>'',1000=>'',9999=>'']];
         $data = [];$getdetail=[];

        
         $color=['green','red','lavender','pink','orange','fgreen','chaani'];
        $user = auth()->user();
        $userid = $user->id;
        if($userid==13285)
        {
            $consmtp[120]='Catgry Consmptn';
        }
        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
       
       
        $summary_count=[];
        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
        $summary_count['spoke_village']=0;
        $summary_count['existing_village_count']=0;
        $summary_count['distribtr_new_village']=0;
        
        $summary_count['show_summary']=0;
        $summary_count['new_count']=0;
        $summary_count['new_village_current']=0;
        $summary_count['new_village_recommand']=0;
       
    
        $orwhere=[];
        if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
           array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_district).")");
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            array_push($orwhere,"  a.taluk_census in (".implode(",",$getfilter->filter_taluk).")");

        $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
        // if(isset($getfilter->type_view) && $getfilter->type_view!='')
        //     $str .=' and subrd_type in ('.$getfilter->type_view.',0)';
        if(isset($getfilter->filter_priority) && $getfilter->filter_priority!='')
             $str .=' and a.subrd_priority="'.$getfilter->filter_priority.'"';
        if(isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd!='')
             $str .=' and a.exist_subrd_code="'.$getfilter->filter_existsubrd.'"';
         $select ='';
         if($user->client_id==9999)
          $select =',no_of_schools,no_of_colleges,hh,if(atm="-","No",atm) atm,if(bank="-","No",bank) bank,if(nh="-","No",nh) nh,if(sh="-","No",sh) sh,if(rly_stn="-","No",rly_stn) rly_stn';
         


        //Old query 19-01-2026
        //$sql="SELECT  b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale".$select." FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";

            /* $clusterIds = DB::table('coke_subrd_data_all')  todo
            ->where('stat', 'A')
            ->where('loc9', $getfilter->filter_district)
            ->whereNotIn('cluster_id', function ($q) use ($getfilter) {
                $q->select('bi_id')
                ->from('coke_subrd_data_all')
                ->whereIn('loc9', $getfilter->filter_district);
            })->selectRaw('GROUP_CONCAT(DISTINCT cluster_id) as cluster_ids')->value('cluster_ids');*/

        $condition="";
        if(in_array(30,$type_view))
        {
            $condition = ' and a.subrd_type in(1,0)'; //Merge with Existing DBR
            $summary_count['new_count']=30;
        }
        else if(in_array(31,$type_view))
        {
            $condition = ' and a.subrd_type in(5,0)'; // New DBR
             $summary_count['new_count']=31;
        }
        else if(in_array(32,$type_view))
        {
            $condition = ' and a.subrd_type in(2,0)'; //New Sub DBR
            $summary_count['new_count']=32;
        }
        $sql="SELECT  b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale".$select." FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' $condition";
        // echo $sql;die;
  
        //\Log::info($sql);  
         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);

          
          
          $final_result=[];
          $inc=0;
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'district_name');
          $district_name=array_unique($district_name);
          $state_name=array_column($result,'state_code');
          $state_name=array_unique($state_name);
          $table_data=[];
          $priority=['Priority 1'=>'rural_icon/r_p1.png','Priority 2'=>'rural_icon/r_p2.png','Priority 3'=>'rural_icon/r_p3.png',''=>'rural_icon/efficient-subrd.png','P1'=>'rural_icon/r_p1.png','P2'=>'rural_icon/r_p2.png'];
          $without_hub=$result;
          $non_cluster_color=[];
          $child_list=[];



         
         for($i=0;$i<count($result);$i++)
         {
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'],$type_view))
             {
                  
                  $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                  $final_result[$inc]=$result[$i];
                  $final_result[$inc]['child']=[];
                  $filter_id=$result[$i]['cluster_id'];

                                 
                  $final_result[$inc]['subrd_marker']=($result[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($result[$i]['subrd_type']==2) ? $priority[$result[$i]['subrd_priority']] : (($result[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';


              
                     //ClusterID base display child condition Rajkumar 19-01-2026
                    $sqlCluseter="SELECT  b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn as  village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.avg_monthly_sale".$select." FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code and  a.cluster_id='".$result[$i]['cluster_id']."' and b.stat='A' $condition ";
                    // echo $sqlCluseter;die;
                         //\Log::info($sqlCluseter);  
                        $resultCluseter = DB::select(DB::raw($sqlCluseter));
                        $resultCluseter=CommonController::getarray($resultCluseter);

                        $hub_child_list = array_filter($resultCluseter, function ($var) use ($filter_id) {
                            return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                    });
                    //ClusterID base display child condition Rajkumar 19-01-2026
                
                   
                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                   });

                              
                  $final_result[$inc]['child']=$hub_child_list; 
                  $res_arr=$result[$i];
                  $child_list[$filter_id]=$hub_child_list;

                  $res_arr['child']=htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                  $res_arr['child_count']=count($hub_child_list);
                    $res_arr['child_d']=$hub_child_list;
                  
                 $inc++;
                 array_push($table_data,$res_arr);
                }
                  
             }
             else if($result[$i]['subrd_type'] ==0 || !in_array($result[$i]['subrd_type'],$type_view))
             {
                $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                    $final_result[$inc]['child']=[];
                     $final_result[$inc]['child_d']=[];
                    $final_result[$inc]['subrd_marker']='NA';
                     $child_list[$result[$i]['cluster_id']]=[];
                    $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
             }
         }
         $without_hub=array_values($without_hub);
         $without_hub_count=count($without_hub);
      $mdlz=($user->id==13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";
         for($i=0;$i<$without_hub_count;$i++)
         { 
      
              $without_hub[$i]['village_census']=ltrim($without_hub[$i]['village_census'], 0);

                if(isset($maparray[$without_hub[$i]['village_census']]))
                {
                    if($without_hub[$i]['subrd_type']==1 && $without_hub[$i]['active_stat'] =='No')
                        $summary_count['new_village_current']++;
                     if($without_hub[$i]['subrd_type']==2)
                        $summary_count['new_village_recommand']++;
                       
                     if(in_array($without_hub[$i]['subrd_type'],[1,2,3,5]))   
                     {
                        if(in_array($without_hub[$i]['subrd_type'],[2,3]) && in_array($without_hub[$i]['subrd_type'],$type_view))   
                            $summary_count['show_summary']=$without_hub[$i]['subrd_type']; 
                     
                        
                     }  
                       
                  
                    $final_result[$inc]=$without_hub[$i];
                    $final_result[$inc]['child']=[];
                    $final_result[$inc]['subrd_marker']=($without_hub[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($without_hub[$i]['subrd_type']==2) ? $priority[$without_hub[$i]['subrd_priority']] : (($without_hub[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$without_hub[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$without_hub[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
         }
      
         $result_count=count($final_result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            $temp=$final_result[$k];

           /*if($temp['subrd_type']==2 && $temp['active_stat'] == 'Yes')
            {
                $split_color=CommonController::getcolor_bysubrd('l_grey');
                
                $hub='#ffffff'
                //$hub= CommonController::getcolor_bysubrd('fgreen');
                //\Log::info($temp['active_stat']);
            }*/

            /* if($temp['active_stat'] == 'Yes' && $temp['is_hub'] == 0 && $temp['cluster_tag'] == 'Existing')
             {
                 $hub= CommonController::getcolor_bysubrd('l_grey');
                 die;
             }*/
           
          //\Log::info($type_view);
           if($temp['subrd_type']==1 && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                 $summary_count['existing_village_count']++;
                if($temp['subrd_loaction']=='Existing Urban Distbtr Hub' || $temp['subrd_loaction']=='Existing Urban Distbtr')
                    $split_color='lblue';
                else
                    $split_color='blue';
                //CommonController::getcolor_bysubrd('d_blue');
                // $range=array_rand(range(0,(count($color)-1)));
                // $split_color=$color[$range];
                
            }
           else if(($temp['subrd_type']==2) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
               $summary_count['spoke_village']++; 
              $range=array_rand(range(0,(count($color)-1)));
              $split_color=$color[$range];
           }
           else if(($temp['subrd_type']==3) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
                 $split_color='fgreen';
           }

           else if($temp['subrd_type']==0)
              $split_color='none';
           else
              $split_color='none';
            if(in_array($temp['subrd_type'],[5]) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                $summary_count['total_village']++;   
               
                
            }
            
             if( $summary_count['show_summary']=='')           
                $summary_count['show_summary']=$temp['subrd_type'];
         //  \Log::info($split_color);
            unset($temp['child']);
            
           
             
            if($temp['is_hub'] != 1 && $temp['subrd_type']!=0)
             {
                $hub='#ffffff';$child='';
                
                if(($temp['active_stat']=='Yes' || $temp['active_stat']=='') && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                          $hub= CommonController::getcolor_bysubrd('l_grey');
                if($temp['active_stat']=='No'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                     $hub= CommonController::getcolor_bysubrd('yellow');
                if($temp['subrd_loaction']=='Existing Urban Distbtr'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                           $hub= CommonController::getcolor_bysubrd('l_lblue'); 
                if((($temp['subrd_type']==2) || ($temp['subrd_type']==3)) && in_array($temp['subrd_type'],$type_view))
               {
                  if(isset($non_cluster_color[$temp['cluster_name']]) && $temp['subrd_type'] !=3)
                            $hub= CommonController::getcolor_bysubrd('l_'.$non_cluster_color[$temp['cluster_name']]); 
                  else if($temp['subrd_type'] !=3){

                     $range=array_rand(range(0,(count($color)-1)));
                     $split_color=$color[$range];
                     $hub= CommonController::getcolor_bysubrd('l_'.$split_color); 
                     $non_cluster_color[$temp['cluster_name']]=$split_color;
                  }
                  else if($temp['subrd_type'] ==3)
                  {
                      $hub= CommonController::getcolor_bysubrd('l_fgreen');
                  }
                 
               }

                    
            }             
             else
                 
                if($temp['subrd_type'] == '5')  //change-25-02-2025  subrd_type 5 means 'Existing Distrbtr' 1 means 'Existing subrd
                {
                   //$hub= CommonController::getcolor_bysubrd('d_blue');

                   // $range=array_rand(range(0,(count($color)-1)));
                     $split_color = $color[array_rand($color)];   // ✅ random color
                     $hub= CommonController::getcolor_bysubrd('d_'.$split_color); 
                    $rural_icon ='rural_icon/ND.png'; 
                   // \Log::info($split_color);
                }
                else
                {
                    // $summary_count['existing_village_count']++; 
                     $hub= CommonController::getcolor_bysubrd('d_'.$split_color); 
                     $rural_icon ='rural_icon/ED.png'; 
                }

                if($temp['subrd_type'] == '1')  //change-25-02-2025  subrd_type 5 means 'Existing Distrbtr' 1 means 'Existing subrd
                {
                   //$hub= CommonController::getcolor_bysubrd('d_blue');

                   // $range=array_rand(range(0,(count($color)-1)));
                     //$summary_count['existing_village_count']++;  
                     $split_color = $color[array_rand($color)];   // ✅ random color
                     $hub= CommonController::getcolor_bysubrd('d_blue'); 
                    $rural_icon ='rural_icon/EuuD.png'; 
                   // \Log::info($split_color);
                }
                
             $label='';
             $legend="";
             $temp['color']=$hub; 

              $cluster_type=$final_result[$k]['subrd_loaction'];
              if($user->client_id==1000)
               $cluster_type=$final_result[$k]['subrd_loaction'];
			 
             $final_result[$k]['activate_status']=$final_result[$k]['company_service_id'];

             //$cluster_tag=(($final_result[$k]['subrd_type']==5) && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existing Distribtr' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommended' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));


                $type = $final_result[$k]['subrd_type'];

                $map = [
                5 => 'Recommended Distbtr',
                2 => 'Recommended SubRD',
                3 => 'Wholesaler',
                1 => 'Existing Distbtr'
                ];

                $cluster_tag = (in_array($type, $type_view) && isset($map[$type])) 
                ? $map[$type] 
                : '';
             
             $cluster_hub=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existing DBR Anchor' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommended SubRD' :(($final_result[$k]['subrd_type']==5 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'RECO DBR Anchor' : ''));
             $temp['activate_marker']=($final_result[$k]['company_service_id']==1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($final_result[$k]['company_service_id']==4) ? 'rural_icon/activated.png' :(($final_result[$k]['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             if($temp['is_hub']!=0)
            {
                $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
               $temp['subrd_marker']=(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? $priority[$final_result[$k]['subrd_priority']] :   (($final_result[$k]['subrd_type']==1 && $temp['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/urban-distributor.png' :  (($final_result[$k]
               ['subrd_type']==5 && in_array($final_result[$k]['subrd_type'],$type_view)) ? $rural_icon : (($final_result[$k]
               ['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/ED.png' : (($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/Wholesale.png' : '')))));

               

             //  \Log::info($final_result[$k]['subrd_type']);  

               
               
               
             $temp['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$final_result[$k]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$cluster_tag.'</li></ul> </div></div></div>';
            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['subrd_marker']='NA';             
                 $temp['subrd_tooltip']='';
            }


                        // 
            if($final_result[$k]['subrd_type']!=0 && in_array($final_result[$k]['subrd_type'],$type_view))
            {

   
                      // \Log::info("if".$final_result[$k]['subrd_type']);
                      $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.; '.$consmtp[$user->client_id].' (Consumption) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].';SubRD Priority: '.$final_result[$k]['subrd_priority'].'; SubRD Cluster Priority: '.$final_result[$k]['subrd_priority'].'; ';

                        // $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? number_format($final_result[$k]['village_choc_consmptn'],0) : $final_result[$k]['village_choc_consmptn'];
                    $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? $final_result[$k]['village_choc_consmptn'] : 0;
                    $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);



                        $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">'.(($userid==13285) ? "Recommendatn" : "Recommendation").':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$final_result[$k]['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from  '.$cluster_hub.' (km): </span>0 kms</p>';
                    if($user->client_id!=1000)
                        $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2025): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
                    if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
                        $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2025): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';

                    if($final_result[$k]['subrd_type']==1 &&  $user->client_id==120)
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$mdlz.': </span>'.$final_result[$k]['mdlz_retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>'.number_format($final_result[$k]['avg_monthly_sale'],0).' Nos.</p>';
                    if($user->client_id!=1000 && $user->client_id!=112 && $user->client_id!=9999)
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' Category Consumption (Snacks) (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
                        if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
                            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' Category Consumption (Snacks) (Annual) (Rs.): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';
                        /* <p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$final_result[$k]['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$final_result[$k]['no_of_schools'].' Nos. </p>*/
                        if($user->client_id==9999)
                            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$final_result[$k]['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$final_result[$k]['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$final_result[$k]['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$final_result[$k]['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$final_result[$k]['rly_stn'].'</p>';
                        $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';
                    
                        

                        if(in_array($final_result[$k]['subrd_type'],[2,3]) &&  $user->client_id==120)
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$final_result[$k]['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$final_result[$k]['subrd_priority'].'</p>';
                    if(in_array($final_result[$k]['subrd_type'],[1]) &&  $user->client_id==120)
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existing DBR Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist Distribtr'.(($userid==13285) ? "" : " Name").': </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
                    
                    if($user->client_id==120)
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p>';
                    if($user->client_id!=120)
                    {
                        $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
                        if(in_array($final_result[$k]['subrd_type'],[1]))
                            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existing DBR Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existing DBR Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
                    }

                        $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
                        $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
                        $final_result[$k]['cluster_type']=$cluster_type;
                        
                        $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
                       // $temp['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">Action Info</span></div></div>';

                       $temp['info'] .= '<div class="popup-footer" 
                    style="cursor:pointer;" 
                    onclick="view_village_detail('.$detail.')">
                    <span style="background-color:none;text-align:right;cursor:pointer;">
                        Action Info
                    </span>
                 </div>';
                
                        
            }
            else
             {
                 //\Log::info("else".$final_result[$k]['subrd_type']);

                $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
                $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);
                $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' Category Consumption (Snacks) (Annual) (Rs): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].'; ';
                $mdlz=($user->id==13285) ? "Covrge Nos" : "MDLZ Cvrg Nos";

                 $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
          if($user->client_id==1000  && $final_result[$k]['sector']=='Rural')
                 $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2025): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
            if($user->client_id!=1000)
                 $temp['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2025): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>';
              if($user->client_id!=112 && $user->client_id!=9999)
                $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;"> '.$consmtp[$user->client_id].' Category Consumption (Snacks) (Annual) (Rs): </span>'.$final_result[$k]['village_choc_consmptn'].' </p>';  
            /*<p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$final_result[$k]['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$final_result[$k]['no_of_schools'].' Nos. </p>*/
          if($user->client_id==9999)
                 $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$final_result[$k]['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$final_result[$k]['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$final_result[$k]['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$final_result[$k]['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$final_result[$k]['rly_stn'].'</p>';
               
          $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
          $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span>'.$rural_img.'</span></p>';
       if($user->client_id==120)
         $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p>';
        if($user->client_id!=120)            
          $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['bi_id'].' </span></p>';
       
           // $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
           // $final_result[$k]['village_choc_consmptn']=number_format($final_result[$k]['village_choc_consmptn'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
            $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

             $temp['info'] .='<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="view_village_detail('.$detail.')">Action</span></div></div>';  
             }
              /*if($user->client_id==133) //change 25-02-2026
         {
             $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
             $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;">';
            $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
            $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Populatn (2021): </span>'.number_format($final_result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$final_result[$k]['retlr_universe'].' Nos.</p>
          <p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index9: </span><span >'.$rural_img.'</span></p><div ></div></div>';
         }*/
             $temp['size']=15;
             $temp['activate_status_icon']=$temp['activate_marker'];
             $temp['activate_status']=$final_result[$k]['activate_status'];
            
            $maparray[$final_result[$k]['village_census']]=array_merge($maparray[$final_result[$k]['village_census']],$temp);

            $temp2=[];
			
            foreach($final_result[$k]['child'] as $key=>$value)
            {
                 $temp2=$value;
                 if($value['subrd_type']==1 && $value['active_stat'] =='No')
                    $summary_count['new_village_current']++;
                 if($value['subrd_type']==5 && $value['active_stat'] =='No' && $value['is_hub'] == 0)
                    $summary_count['distribtr_new_village']++;
                 if($value['subrd_type']==2)
                    $summary_count['new_village_recommand']++;
                 if(in_array($value['subrd_type'],[1]) && $value['active_stat'] =='No' && $value['is_hub'] == 0){
                     $summary_count['new_village']++;

                  // if(isset($summary_count[$value['rpi']]))
						//	$summary_count[$value['rpi']]++;
                 }

                  /*if(in_array($value['subrd_type'],[1]) && $value['active_stat'] == 'No'){
                     $summary_count['new_village']++;

                   if(isset($summary_count[$value['rpi']]))
							$summary_count[$value['rpi']]++;
                 }

                  if(in_array($value['subrd_type'],[5]) && $value['active_stat'] == 'No'){ 
                     $summary_count['distribtr_new_village']++;

                   if(isset($summary_count[$value['rpi']]))
							$summary_count[$value['rpi']]++;
                 }*/
                    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                 if($value['subrd_type']==2)    //subrd_type 1 is Existing 2 is Reco
                 {
                       // child cluster color change if active yes  it will appear in grey color
                       if($value['active_stat']=='Yes')
                          $temp2['color']= CommonController::getcolor_bysubrd('l_grey');
                        
                       if($value['active_stat']=='No')
                           $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);   
                        
                 } 
                 if($value['subrd_type']==1)    //subrd_type 1 is Existing 2 is Reco
                 {

                       
                       // child cluster color change if active yes  it will appear in grey color
                       if($value['active_stat']=='Yes' && $value['is_hub'] == 0)
                          //$temp2['color']= CommonController::getcolor_bysubrd('l_grey');
                          $temp2['color']= CommonController::getcolor_bysubrd('l_lblue');    
                        
                       if($value['active_stat']=='No' && $value['subrd_type'] == '1')
                          // $temp2['color']= CommonController::getcolor_bysubrd('yellow'); 
                             $temp2['color']= CommonController::getcolor_bysubrd('yellow');    

                           
                        
                 } 
                 //pepsi subrd child color change-25-02-2025
                 if($value['subrd_type'] == '5' && $value['subrd_loaction'] == 'Recommend Distbtr - New Spoke Village')  
                {
                   
                      //\Log::info($split_color);
                     $temp2['color'] = CommonController::getcolor_bysubrd('l_'.$split_color); 
                   // $temp2['color']= CommonController::getcolor_bysubrd('l_lblue');
                }
                 if($value['subrd_loaction'] == 'Recommend Distbtr - Active Village' && $value['subrd_type'] == '5')
                {
                    $temp2['color']= CommonController::getcolor_bysubrd('l_grey');
                }

                


                  
                      
                 // else                 
                 //    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                
                 // $cluster_type=(isset($subrd_name[$user->client_id])) ? $subrd_name[$user->client_id][1] : $value['subrd_loaction'];
                 $cluster_type=$value['subrd_loaction'];
                // $cluster_tag=($value['subrd_type']==1 || $value['subrd_type']==5) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommended' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                
                $type = $value['subrd_type'];

                $map = [
                5 => 'Recommended Distbtr',
                2 => 'Recommended SubRD',
                3 => 'Wholesaler',
                1 => 'Existing Distbtr'
                ];

                $cluster_tag = (in_array($type, $type_view) && isset($map[$type])) 
                ? $map[$type] 
                : '';

                  $cluster_hub=($value['subrd_type']==1) ? 'Existing DBR Anchor' :(($value['subrd_type']==2) ? 'Recommended SubRD' :(($value['subrd_type']==5) ?'RECO DBR Anchor' : ''));
                   $value['village_census']=ltrim($value['village_census'], 0);
                 
                   if(isset($maparray[$value['village_census']]))
                {
                   
                    $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ?  $value['village_choc_consmptn'] : 0;
                     $value['village_choc_consmptn']=is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$value['village_choc_consmptn']),0);
                     $value['cluster_type']=$cluster_type;
                    $temp2['shareinfo']='Village: '.$value['village_name'].'; Taluk: '.$value['taluk_name'].'; Distt: '.$value['district_name'].'; State: '.$value['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$value['population'].' Nos.; Rural Progressive Index: '.$value['rpi'].'; Outlet Potential: '.$value['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].'Category Consumption (Snacks) (Annual) (Rs): '.$value['village_choc_consmptn'].'; Market UID: '.$value['market_id'].'; BI Location ID: '.$value['bi_id'].';SubRD Priority: '.$value['subrd_priority'].'; SubRD Cluster Priority: '.$value['subrd_priority'].'; ';

                       $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">'.(($userid==13285) ? "Recommendatn" : "Recommendatn").':</span> '.$cluster_type.'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster ID: </span>'.$value['cluster_id'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Distance from  '.$cluster_hub.' (km): </span>'.$value['distance_subrd'].' kms</p>';
            if($user->client_id==1000 && $value['sector']=='Rural')
                $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2025): </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p>';
        if($user->client_id!=1000)
            $temp2['info'].='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2025): </span>'.number_format($value['population'],0).'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">West\'n Salty Outlets.: </span>'.$value['retlr_universe'].' Nos.</p>';

       if($value['subrd_type']==1 &&  $user->client_id==120)
               $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$mdlz.': </span>'.$value['mdlz_retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span>'.number_format($value['avg_monthly_sale'],0).' Nos.</p>';
             if($user->client_id==1000 && $value['sector']=='Rural')          
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' Category Consumption (Snacks) (Annual) (Rs): </span>'.$value['village_choc_consmptn'].' </p>';
             if($user->client_id!=1000 && $user->client_id!=112 && $user->client_id!=9999)
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$consmtp[$user->client_id].' Category Consumption (Snacks) (Annual) (Rs): </span>'.$value['village_choc_consmptn'].' </p>';
             /*<p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Colleges: </span>'.$value['no_of_colleges'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">No. of Schools: </span>'.$value['no_of_schools'].' Nos. </p>*/
              if($user->client_id==9999)
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">ATM: </span>'.$value['atm'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Bank: </span>'.$value['bank'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">National Highway: </span>'.$value['nh'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">State Highway: </span>'.$value['sh'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Railway Station: </span>'.$value['rly_stn'].'</p>';
                  
                $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index: </span><span >'.$rural_img.'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Cluster Tag: </span>'.$cluster_tag.' </p>';

           if(in_array($value['subrd_type'],[2,3]) && $user->client_id==120)                
             $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Priority: </span> '.$value['subrd_priority'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Cluster Priority: </span>'.$value['subrd_priority'].'</p>';
          if($user->client_id==120)
             $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$value['market_id'].'</span></p>';
         if(in_array($value['subrd_type'],[1]) && $user->client_id==120)  
              $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD Census: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Exist SubRD '.(($userid==13285) ? "" : " Name").': </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
            if($user->client_id!=120)
            {
                 $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Location ID: </span><span style="background-color:white;color:black;" >'.$value['bi_id'].' </span></p>';
              if(in_array($value['subrd_type'],[1]))
                $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existing DBR Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Existing DBR Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p>';
            }
           
            
           $value['population']= number_format($value['population'],0);
            $value['village_name']=$maparray[$value['village_census']]['location_name'];
            $value['summary_count']=$summary_count['total_village'];
            $value['type']=$type;
             $value['active_stat']=$value['active_stat'];
           
            $child_val=[0=>$value];
                  $value_json=htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
           
        
             $temp2['info'] .=' <div class="popup-footer"
         style="cursor:pointer; padding:10px; width:100%;"
         onclick=\'view_village_detail('.$value_json.')\'>
        <span style="display:block; width:100%;">
            Action
        </span>
         </div>
         </div>';
            /* if($user->client_id==133) //change 25-02-2026 
             {
                  $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
                 $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2021): </span>'.$value['population'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$value['retlr_universe'].' Nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Rural Progrsv Index11: </span><span >'.$rural_img.'</span></p><div ></div></div>'; 
             }*/
             $value['activate_status']=$value['company_service_id'];
             $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommend' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
             $value['activate_marker']=($value['company_service_id']==1) ? 'rural_icon/active.png' : (($value['company_service_id']==2) ? 'rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'rural_icon/activated.png' :(($value['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             $temp2['size']=8;
             $temp2['activate_status_icon']=$value['activate_marker'];
             $temp2['activate_status']=$value['activate_status'];
             $temp2['subrd_status']=0;
             $temp2['subrd_marker']='NA';             
             $temp2['subrd_tooltip']='';

             // $temp2['village_census']=ltrim($value['village_census'],0);
           
            $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                }

             

            }
         
         }

      
       // \Log::info($summary_count['new_count']);
        $data['legend']=[];
        $data['legend'][0] = $summary_count;
        if($user->client_id==133)
             $data['griddata'] = $this->getsubrdPepsiRural($table_data); //change-25-02-2025
        else
        $data['griddata'] = $this->getsubrdPepsiRural($table_data);
        $data['child_list']=$child_list;
        $data['mapdata'] = $maparray;
       // \Log::info($maparray);
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            $data['head']=implode(", ", $taluk_name). ' sub-distt, '.implode(", ", $district_name);
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
             $data['head']=implode(", ", $district_name). ' distt, '.implode(", ", $state_name);
         else
             $data['head']='';

        return $data;

    }
    public function Combine_subrd_($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {
          $user = auth()->user();
        $userid = $user->id;

        if($user->role=='SM' && $user->client_id == 112)
        {
             $tbllist=[120=>'subrd_data',123=>'subrd_data_perfetti',112=>'coke_subrd_data'];
        }
        else
        {
             $tbllist=[120=>'subrd_data',123=>'subrd_data_perfetti',112=>'coke_subrd_data_all'];
        }
        
        $consmtp=[120=>'Villg. Choc Consumption',123=>'Confectionery Consmptn',112=>'Confectionery Consmptn'];
        $data = [];$getdetail=[];
        $color=['green','red','lavender','pink','orange','fgreen','chaani'];
      

        $data['result'] = array();
        $data['mapdata'] = array();       
        $getfilter=json_decode($input_obj);
       
        $summary_count=[1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,'total_village'=>0,'new_village'=>0,'show_summary'=>0];
        
        $type_view=explode(",",$getfilter->type_view);
       
        $orwhere=[];
        if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
            array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_district).")");
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            array_push($orwhere,"  a.taluk_census in (".implode(",",$getfilter->filter_taluk).")");

        $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";      
        if(isset($getfilter->filter_priority) && $getfilter->filter_priority!='')
             $str .=' and a.subrd_priority="'.$getfilter->filter_priority.'"';
        if(isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd!='')
             $str .=' and a.exist_subrd_code="'.$getfilter->filter_existsubrd.'"';

     $sql="SELECT  a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.`village_choc_consmptn`, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,a.rpi_id,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";

         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);
         $final_result=[];$non_cluster_color=[];$table_data=[];$inc=0;$taluk_name=[];$district_name=[];
          $priority=['Priority 1'=>'rural_icon/r_p1.png','Priority 2'=>'rural_icon/r_p2.png','Priority 3'=>'rural_icon/r_p3.png',''=>'rural_icon/recommendation.png'];
          $subd_img=[1=> 'rural_icon/efficient-subrd.png',3=>'rural_icon/Wholesaler.png',0=>'NA',''=>'NA'];
          $active_mark=[1=>'rural_icon/active.png',2=>'rural_icon/initiated.png',3=>'rural_icon/deactivated.png',4=>'rural_icon/activated.png',5=>'rural_icon/deactivated.png',0=>'NA',''=>'NA'];
           
          $without_hub=$result;
          $count_result=count($result);
         for($i=0;$i<$count_result;$i++)
         {
            
                array_push($taluk_name,$result[$i]['taluk_name']);           
                array_push($district_name,$result[$i]['district_name']);
            
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'],$type_view))
             {
                   $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                 
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                    $final_result[$inc]['child']=[];
                    $filter_id=$result[$i]['cluster_id'];             
                    $final_result[$inc]['subrd_marker']=($result[$i]['subrd_type']==2) ?   $priority[$result[$i]['subrd_priority']] : $subd_img[$result[$i]['subrd_type']] ;
                    $hub_child_list = array_filter($result, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                    });
                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                   });
                  $final_result[$inc]['child']=$hub_child_list; 
                  $res_arr=$result[$i];
                  $res_arr['child']=htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                  $res_arr['child_count']=count($hub_child_list);
                   $inc++;
                  array_push($table_data,$res_arr);
                }
                  
             }
             else if($result[$i]['subrd_type'] ==0 || !in_array($result[$i]['subrd_type'],$type_view))
             {
                $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                    $final_result[$inc]['child']=[];
                    $final_result[$inc]['subrd_marker']='NA';
                    $inc++;
                   
                }
             }
         }
         $without_hub=array_values($without_hub);
         $without_hub_count=count($without_hub);
      
         for($i=0;$i<$without_hub_count;$i++)
         {
      
              $without_hub[$i]['village_census']=ltrim($without_hub[$i]['village_census'], 0);
                if(isset($maparray[$without_hub[$i]['village_census']]))
                {
                    $final_result[$inc]=$without_hub[$i];
                    $final_result[$inc]['child']=[];
                    $final_result[$inc]['subrd_marker']=($without_hub[$i]['subrd_type']==2) ?   $priority[$without_hub[$i]['subrd_priority']] : $subd_img[$without_hub[$i]['subrd_type']] ;
                    $inc++;
                   
                }
         }

         $result_count=count($final_result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            $temp=$final_result[$k];
           if($temp['subrd_type']==1 && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                if($temp['subrd_loaction']=='Existing Urban Distbtr Hub' || $temp['subrd_loaction']=='Existing Urban Distbtr')
                    $split_color='lblue';
                else
                    $split_color='grey';
            }
           else if(($temp['subrd_type']==2) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
              $range=array_rand(range(0,(count($color)-1)));
              $split_color=$color[$range];
           }
           else if(($temp['subrd_type']==3) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
                 $split_color='fgreen';
           }

           else if($temp['subrd_type']==0)
              $split_color='none';
           else
              $split_color='none';
            if(in_array($temp['subrd_type'],[2,3]) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                $summary_count['total_village']++;               
                $summary_count['show_summary']=$temp['subrd_type'];
            }

            unset($temp['child']);
            
             
            if($temp['is_hub'] != 1 && $temp['subrd_type']!=0)
             {
                $hub='#ffffff';$child='';
                if(($temp['active_stat']=='Yes' || $temp['active_stat']=='') && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                          $hub= CommonController::getcolor_bysubrd('l_grey');
                if($temp['active_stat']=='No'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                           $hub= CommonController::getcolor_bysubrd('yellow');
                if($temp['subrd_loaction']=='Existing Urban Distbtr'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                           $hub= CommonController::getcolor_bysubrd('l_lblue'); 
                if((($temp['subrd_type']==2) || ($temp['subrd_type']==3)) && in_array($temp['subrd_type'],$type_view))
               {
                  if(isset($non_cluster_color[$temp['cluster_name']]) && $temp['subrd_type'] !=3)
                            $hub= CommonController::getcolor_bysubrd('l_'.$non_cluster_color[$temp['cluster_name']]); 
                  else if($temp['subrd_type'] !=3){

                     $range=array_rand(range(0,(count($color)-1)));
                     $split_color=$color[$range];
                     $hub= CommonController::getcolor_bysubrd('l_'.$split_color); 
                     $non_cluster_color[$temp['cluster_name']]=$split_color;
                  }
                  else if($temp['subrd_type'] ==3)
                  {
                      $hub= CommonController::getcolor_bysubrd('l_fgreen');
                  }
                 
               }
            }             
             else
                $hub= CommonController::getcolor_bysubrd('d_'.$split_color); 
             $label='';$legend="";
             $temp['color']=$hub; 
             $temp['cluster_type']=$final_result[$k]['subrd_loaction'];
             
             $final_result[$k]['activate_status']=$final_result[$k]['company_service_id'];
             $temp['cluster_tag']=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'SubRD Existing' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommended' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $temp['cluster_hub']=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existing SubRD' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommd SubRD' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $temp['activate_marker']=$active_mark[$final_result[$k]['company_service_id']];
            
             if($temp['is_hub']!=0)
            {
                $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
               $temp['subrd_marker']=(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? $priority[$final_result[$k]['subrd_priority']] :   (($final_result[$k]['subrd_type']==1 && $temp['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/urban-distributor.png' :  (($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/efficient-subrd.png' : (($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/Wholesale.png' : ''))));

            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['subrd_marker']='NA';             
                
            }


             // 
if($final_result[$k]['subrd_type']!=0 && in_array($final_result[$k]['subrd_type'],$type_view))
{

            $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? $final_result[$k]['village_choc_consmptn'] : 0;
            $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);
            $temp['info']='';
            $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
            $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
             
}
 else
             {
                $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
                $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);
                $temp['shareinfo']='';
                 $temp['info']='';
       
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
          $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

             }
             $temp['size']=15;
             $temp['activate_status_icon']=$temp['activate_marker'];
             $temp['activate_status']=$final_result[$k]['activate_status'];
            
            $maparray[$final_result[$k]['village_census']]=array_merge($maparray[$final_result[$k]['village_census']],$temp);

            $temp2=[];
            
            foreach($final_result[$k]['child'] as $key=>$value)
            {
                 $temp2=$value;
                 if(in_array($value['subrd_type'],[2,3])){
                     $summary_count['new_village']++;
                   if(isset($summary_count[$value['rpi_id']]))
                            $summary_count[$value['rpi_id']]++;
                 }
                    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                 if($value['subrd_type']==1)    
                 {
                       if($value['active_stat']=='Yes')
                          $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                       if($value['active_stat']=='N')
                           $temp2['color']= CommonController::getcolor_bysubrd('yellow');                      
                 }             
                 // else                 
                 //    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                
                 $temp2['cluster_type']=$value['subrd_loaction'];
                 $temp2['cluster_tag']=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommended' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                  $temp2['cluster_hub']=($value['subrd_type']==1) ? 'Existing SubRD' :(($value['subrd_type']==2) ? 'Recommd SubRD' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                   $value['village_census']=ltrim($value['village_census'], 0);
                  if(isset($maparray[$value['village_census']]))
                {
                   
                    $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ?  $value['village_choc_consmptn'] : 0;
                     $value['village_choc_consmptn']=is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$value['village_choc_consmptn']),0);
                        $temp2['shareinfo']='';

                       $temp2['info']='';
            
            $value['population']= number_format($value['population'],0);
            $value['village_name']=$maparray[$value['village_census']]['location_name'];
            $child_val=[0=>$value];
            $value_json=htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
           
             $value['activate_status']=$value['company_service_id'];
             $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
             $value['activate_marker']=($value['company_service_id']==1) ? 'rural_icon/active.png' : (($value['company_service_id']==2) ? 'rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'rural_icon/activated.png' :(($value['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             $temp2['size']=8;
             $temp2['activate_status_icon']=$value['activate_marker'];
             $temp2['activate_status']=$value['activate_status'];
             $temp2['subrd_status']=0;
             $temp2['subrd_marker']='NA';             
             $temp2['subrd_tooltip']='';
             // $temp2['village_census']=ltrim($value['village_census'],0);
           
            $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                }

             

            }
         
         }

        $data['legend']=[];
        $data['legend'][0] = $summary_count;
        $data['griddata'] = $this->getsubrd($table_data);
        $data['mapdata'] = $maparray;
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            $data['head']=implode(", ", array_unique($taluk_name)). ' sub-distt';
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
             $data['head']=implode(", ", array_unique($district_name)). ' distt';
         else
             $data['head']='';

        return $data;

    }
     public function getmdlzsubrd($data,$type)
    {
        $column=[];
        $value=[];
        
       

         array_push($column, array(
             'title' => '#','className' => 'text-right'
         ));

          array_push($column, array(
             'title' => 'Desa Code', 'className' => 'text-right'
         ));
          array_push($column, array(
             'title' => 'Desa', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Province', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Regency', 'className' => 'text-left'
         ));
          
            array_push($column, array(
             'title' => 'Kecamatan', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Indvdls (nos.)', 'className' => 'text-right'
         ));
             array_push($column, array(
             'title' => 'Total HHs (nos.)', 'className' => 'text-right'
         ));
             array_push($column, array(
             'title' => 'Area (&#13218;)', 'className' => 'text-right'
         ));
              array_push($column, array(
             'title' => 'Retailers', 'className' => 'text-right'
         ));
              
            
              array_push($column, array(
             'title' => 'Covrd By', 'className' => 'text-left'
         ));
              

        for($i=0;$i<count($data);$i++)
        {
           if($type==1)
           {
             $sub_distt= '<a href="#" id="' . $data[$i]['sub_distt_id'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['sub_district'] . '</a>';
             $village=$data[$i]['villg_name'] ;
           }
           if($type==2)
           {
             $sub_distt=  $data[$i]['sub_district'];
             $village='<a href="#" id="' . $data[$i]['village_id'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['villg_name'] . '</a>';
           }

            $temp=array(
                 ($i+1),
                 $data[$i]['villg_code'],
                  $village,
                 $data[$i]['province'],
                 $data[$i]['regency'],
                 $sub_distt,
                
                 number_format((int)$data[$i]['population']),
                  number_format((int)$data[$i]['house_hold']),
                  $data[$i]['area'],
                  $data[$i]['retailers'],
                  $data[$i]['type']
                  


            );
            array_push($value,$temp);
         
        }
            return array(
            'column' => $column,
            'value' => $value
        );
    }
     public function country_subrd($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {

       $data=['result'=>[],'mapdata'=>[]];
       $sql="SELECT `refid`, `objectid`, `villg_code`, `villg_name`, `province_no`, `regency_no`, `sub_district_no`, `province`, `regency`, `district_toen`, `sub_district`, `population`, `house_hold`, `area`, `retailers`, `latitude`, `longitude`, if(`type`='Village','',if(type='Distributor','Distributor Hub',if(type='Sub-Distributor','SubD Hub',''))) as type, `Coverage`, `DistributorID_SubD_ID`, `sub_distt_id`,type_id,round(density,0) density FROM `subrd_country` where  province_no=12";

        $result = DB::select(DB::raw($sql));
        $result=CommonController::getarray($result);

        $sub_district_detail=[];$village_details=[];$summary_count=['show_summary'=>4,'Distributor'=>0,'Sub-Distributor'=>0];
        $result_count=count($result);
        

        for($i=0;$i<$result_count;$i++)
        {

            if($result[$i]['type_id']==1)
                $summary_count['Distributor']++;
            if($result[$i]['type_id']==2)
                $summary_count['Sub-Distributor']++;
            


            if(!array_key_exists($result[$i]['sub_distt_id'],$sub_district_detail))
            {
                $sub_district_detail[$result[$i]['sub_distt_id']]=[];
                $sub_district_detail[$result[$i]['sub_distt_id']]['population']=0;
                $sub_district_detail[$result[$i]['sub_distt_id']]['area']=0;
                $sub_district_detail[$result[$i]['sub_distt_id']]['density']=0;
                $sub_district_detail[$result[$i]['sub_distt_id']]['retailers']=0;
                $sub_district_detail[$result[$i]['sub_distt_id']]['house_hold']=0;
                $sub_district_detail[$result[$i]['sub_distt_id']]['sub_distt_name']=$result[$i]['sub_district'];
                $sub_district_detail[$result[$i]['sub_distt_id']]['type_id']=$result[$i]['type_id'];
                $sub_district_detail[$result[$i]['sub_distt_id']]['sub_distt_id']=$result[$i]['sub_distt_id'];
                $sub_district_detail[$result[$i]['sub_distt_id']]['province']=$result[$i]['province'];
                $sub_district_detail[$result[$i]['sub_distt_id']]['regency']=$result[$i]['regency'];
                $sub_district_detail[$result[$i]['sub_distt_id']]['type']=$result[$i]['type'];
            }
            $sub_district_detail[$result[$i]['sub_distt_id']]['population']=$sub_district_detail[$result[$i]['sub_distt_id']]['population']+(int)$result[$i]['population'];
             $sub_district_detail[$result[$i]['sub_distt_id']]['area']=$sub_district_detail[$result[$i]['sub_distt_id']]['area']+(int)$result[$i]['area'];
              $sub_district_detail[$result[$i]['sub_distt_id']]['density']=$sub_district_detail[$result[$i]['sub_distt_id']]['density']+$result[$i]['density'];
               $sub_district_detail[$result[$i]['sub_distt_id']]['house_hold']=$sub_district_detail[$result[$i]['sub_distt_id']]['house_hold']+$result[$i]['house_hold'];
              $sub_district_detail[$result[$i]['sub_distt_id']]['retailers']=$sub_district_detail[$result[$i]['sub_distt_id']]['retailers']+(int)$result[$i]['retailers'];

            $temp=[];
            $temp['refid']=$result[$i]['refid'];
            $temp['village_code']=$result[$i]['villg_code'];
            $temp['villg_name']=$result[$i]['villg_name'];
            $temp['province']=$result[$i]['province'];
            $temp['regency']=$result[$i]['regency'];
            $temp['sub_district']=$result[$i]['sub_district'];
            $temp['population']=$result[$i]['population'];
            $temp['house_hold']=$result[$i]['house_hold'];
            $temp['latitude']=$result[$i]['latitude'];
            $temp['longitude']=$result[$i]['longitude'];
            $temp['latitude']=$result[$i]['latitude'];
            $temp['type']=$result[$i]['type'];
             $temp['type_id']=$result[$i]['type_id'];
            $temp['Coverage']=$result[$i]['Coverage'];
            $temp['retailers']=$result[$i]['retailers'];
            $temp['area']=$result[$i]['area'];
            $temp['cover']='';
             if($result[$i]['type_id']==1)
             {
                 $temp['circleround']=30000;
                 $temp['colorround']='#0475ff';
                 $temp['cover']='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Covrd by: </span>'.$result[$i]['type'].'</p>';
             }
              if($result[$i]['type_id']==2)
              {
                $temp['circleround']=20000;
                $temp['colorround']='#5fb924';
                $temp['cover']='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Covrd by: </span>'.$result[$i]['type'].'</p>';
              }
                
            $temp['marker']=($result[$i]['type_id']== 1) ? 'rural_icon/Distributor.png' : (($result[$i]['type_id']== 2) ?  'rural_icon/efficient-subrd.png' : '' );  
            $temp['shareinfo']='';
            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$result[$i]['villg_name'].' desa &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="25px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[$i]['latitude'].'" lon="'.$result[$i]['longitude'].'" id="share_'.$result[$i]['refid'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$result[$i]['latitude'].','.$result[$i]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="25px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$result[$i]['refid'].'" src="icons/close-icon.png" height="25px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$result[$i]['sub_district'].' kecamatan</span><br><span style="line-height:1rem;">'.$result[$i]['regency'].' regency</span><br><span style="line-height:1rem;">'.$result[$i]['province'].' province</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Indvdls: </span>'.number_format($result[$i]['population'],0).' nos. </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Total HHs: </span>'.number_format((int)$result[$i]['house_hold']).' nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$result[$i]['retailers'].' nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Pop. Density: </span>'.$result[$i]['density'].'</p>'.$temp['cover'].'</div>';
            array_push($village_details,$temp);
        }
        $value_arr=array_values($sub_district_detail);
        $all_pop=array_column($value_arr,'population');
        $max_pop=max($all_pop);
        $total_pop=array_sum($all_pop);


        // $distributor_data=array_filter($result, function ($item){
        //         if (stripos($item['type_id'], '1') !== false) {
        //             return true;
        //         }        
        //         return false;
        //     });
        //  $distributor_data_pop=array_column($distributor_data,'population');
        //  $sub_distributor_data=array_filter($result, function ($item){
        //         if (stripos($item['type_id'], '2') !== false) {
        //             return true;
        //         }        
        //         return false;
        //     });
        //   $sub_distributor_data_pop=array_column($sub_distributor_data,'population');

        // $max_distributor=max($distributor_data_pop);
        // $max_dis_population=   array_sum($distributor_data_pop);
        // $max_subdistributor=max($sub_distributor_data_pop);
        // $max_subd_population=   array_sum($sub_distributor_data_pop);
         $distributor=array('hex'=>'#01875B','from_1'=>'rgb(228, 242, 231)','to_1'=>'rgb(0, 242, 43)','from_2'=>'rgb(0, 242, 43)','to_2'=>'rgb(1, 135, 91)');//green
       

        foreach($sub_district_detail as $k=>$v)
        {
            $temp_subrd=[];
             
                   $from50=$distributor['from_1'];
                   $to50=$distributor['to_1'];
                   $from100=$distributor['from_2'];
                   $to100=$distributor['to_2'];    
                   $color_critiea=((int)$v['population']/(int)$max_pop)*100;
//echo (int)$v['population'].' '.(int)$total_pop;die;
                   $contribtn=((int)$v['population']/(int)$total_pop)*100;
                   $contribtn=((int)$contribtn<=5) ? 5 : $contribtn;
             
              $size=round((50*($contribtn/100)),0);
             //      $size=5;
             
              $color="#fff";
              if($color_critiea < 50)
                  $color= CommonController::Gradient($from50,$to50,50,abs($color_critiea));
             else
                  $color= CommonController::Gradient($from100,$to100,100,abs($color_critiea));
             

              $temp_subrd['color']=$color;
               $temp_subrd['refid']=$v['sub_distt_id'];
              $temp_subrd['size']=$size;
               $temp_subrd['type_id']=$v['type_id'];
              $temp_subrd['shareinfo']='';
              $temp_subrd['info']='';
              $temp_subrd['province']=$v['province'];
              $temp_subrd['subrd_type']=$v['type_id'];
              $temp_subrd['cover']='';
              if($v['type_id']==1)
             {
                 
                 $temp_subrd['cover']='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Covrd by: </span>'.$v['type'].' </p>';
             }
              if($v['type_id']==2)
              {
               
                $temp_subrd['cover']='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Covrd by: </span>'.$v['type'].' </p>';
              }
              if(isset($maparray[$v['sub_distt_id']]))
              $temp_subrd['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$v['sub_distt_name'].' kecamatan &nbsp;</h5>
              <div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="25px" onclick="share(\''.$temp_subrd['shareinfo'].'\',this)"  lat="'.$maparray[$v['sub_distt_id']]['latitude'].'" lon="'.$maparray[$v['sub_distt_id']]['longitude'].'" id="share_'.$v['sub_distt_id'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$maparray[$v['sub_distt_id']]['latitude'].','.$maparray[$v['sub_distt_id']]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="25px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$v['sub_distt_id'].'" src="icons/close-icon.png" height="25px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$v['regency'].' regency</span><br><span style="line-height:1rem;">'.$v['province'].' province</span></span></h5><hr style="border-top: 1px solid white;">'.$temp_subrd['cover'].'<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Indvdls: </span>'.number_format((int)$v['population'],0).' nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Total HHs: </span>'.number_format((int)$v['house_hold']).' nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Area: </span>'.$v['area'].' &#13218;</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Pop. Density: </span>'.$v['density'].' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univrs: </span>'.$v['retailers'].' nos.</p></div>';

            $maparray[$v['sub_distt_id']]=array_merge($maparray[$v['sub_distt_id']],$temp_subrd);
               
                 
        }
        $data['legend']=[];
        $data['legend'][0] = $summary_count;
        $data['griddata'] = $this->getmdlzsubrd($result,1);
        $data['village_subrd']=$village_details;
        $data['mapdata'] = $maparray;
        $data['head']='Sumatera Utara province';

        return $data;
        
    }
    public function village_subrd($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {

       $data=['result'=>[],'mapdata'=>[]];
        $input_object=json_decode($input_obj);
       $sql="SELECT `refid`, `objectid`, `villg_code`, `villg_name`, `province_no`, `regency_no`, `sub_district_no`, `province`, `regency`, `district_toen`, `sub_district`, `population`, `house_hold`, `area`, `retailers`, `latitude`, `longitude`,  if(`type`='Village','',if(type='Distributor','Distributor Hub',if(type='Sub-Distributor','SubD Hub',''))) as type, `Coverage`, `DistributorID_SubD_ID`, `sub_distt_id`,type_id,village_id,round(density,0) as density FROM `subrd_country` where  province_no=12 and sub_distt_id='".$input_object->filter_village[0]."'";

        $result = DB::select(DB::raw($sql));
        $result=CommonController::getarray($result);

        $sub_district_detail=[];$village_details=[];$summary_count=['show_summary'=>4,'Distributor'=>0,'Sub-Distributor'=>0];
        $result_count=count($result);
        $value_arr=array_values($result);
        $all_pop=array_column($value_arr,'population');
        $max_pop=max($all_pop);
        $total_pop=array_sum($all_pop);

         $distributor=array('hex'=>'#01875B','from_1'=>'rgb(228, 242, 231)','to_1'=>'rgb(0, 242, 43)','from_2'=>'rgb(0, 242, 43)','to_2'=>'rgb(1, 135, 91)');//green
          

        

        for($i=0;$i<$result_count;$i++)
        {

            if($result[$i]['type_id']==1)
                $summary_count['Distributor']++;
            if($result[$i]['type_id']==2)
                $summary_count['Sub-Distributor']++;

            $temp=[];
            $temp['refid']=$result[$i]['refid'];
            $temp['village_code']=$result[$i]['villg_code'];
            $temp['villg_name']=$result[$i]['villg_name'];
            $temp['province']=$result[$i]['province'];
            $temp['regency']=$result[$i]['regency'];
            $temp['sub_district']=$result[$i]['sub_district'];
            $temp['population']=$result[$i]['population'];
            $temp['house_hold']=$result[$i]['house_hold'];
            $temp['latitude']=$result[$i]['latitude'];
            $temp['longitude']=$result[$i]['longitude'];
            $temp['latitude']=$result[$i]['latitude'];
            $temp['type']=$result[$i]['type'];
             $temp['type_id']=$result[$i]['type_id'];
            $temp['Coverage']=$result[$i]['Coverage'];
            $temp['retailers']=$result[$i]['retailers'];
            $temp['area']=$result[$i]['area'];
            $temp['cover']='';
            $from50=$distributor['from_1'];
            $to50=$distributor['to_1'];
           $from100=$distributor['from_2'];
           $to100=$distributor['to_2'];    
           $color_critiea=((int)$result[$i]['population']/(int)$max_pop)*100;
           $contribtn=((int)$result[$i]['population']/(int)$total_pop)*100;
           $contribtn=((int)$contribtn<=0) ? 1 : $contribtn;
           $size=5;
             
              $size=round((50*($contribtn/100)),0);
                   
             
              $color="#fff";
              if($color_critiea < 50)
                  $color= CommonController::Gradient($from50,$to50,50,abs($color_critiea));
             else
                  $color= CommonController::Gradient($from100,$to100,100,abs($color_critiea));
             

              $temp['color']=$color;
              $temp['size']=$size;
             if($result[$i]['type_id']==1)
             {
                 $temp['circleround']=30000;
                 $temp['colorround']='#0475ff';
                 $temp['cover']='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Covrd by: </span>'.$result[$i]['type'].'</p>';
             }
              if($result[$i]['type_id']==2)
              {
                $temp['circleround']=20000;
                $temp['colorround']='#5fb924';

                $temp['cover']='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Covrd by: </span>'.$result[$i]['type'].'</p>';
              }
                
            $temp['marker']=($result[$i]['type_id']== 1) ? 'rural_icon/Distributor.png' : (($result[$i]['type_id']== 2) ?  'rural_icon/efficient-subrd.png' : '' );  
            $temp['shareinfo']='';
            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$result[$i]['villg_name'].' desa &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="25px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[$i]['latitude'].'" lon="'.$result[$i]['longitude'].'" id="share_'.$result[$i]['refid'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$result[$i]['latitude'].','.$result[$i]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="25px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$result[$i]['refid'].'" src="icons/close-icon.png" height="25px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$result[$i]['sub_district'].' kecamatan</span><br><span style="line-height:1rem;">'.$result[$i]['regency'].' regency</span><br><span style="line-height:1rem;">'.$result[$i]['province'].' province</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Indvdls: </span>'.number_format($result[$i]['population'],0).' nos. </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Total HHs: </span>'.number_format((int)$result[$i]['house_hold']).' nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">FMCG Retlr Univ Nos.: </span>'.$result[$i]['retailers'].' nos.</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Area: </span>'.$result[$i]['area'].' &#13218;</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Pop. Density: </span>'.$result[$i]['density'].'</p>'.$temp['cover'].'</div>';
            array_push($village_details,$temp);
            $maparray[$result[$i]['village_id']]=array_merge($maparray[$result[$i]['village_id']],$temp);
        }
        
       
        $data['legend']=[];
        $data['legend'][0] = $summary_count;
        $data['griddata'] = $this->getmdlzsubrd($result,2);
        $data['village_subrd']=$village_details;
        $data['mapdata'] = $maparray;
        $data['head']='Dolok Sanggul kecamatan';

        return $data;
        
    }
    public function getsubrdwhitespace($data, $type = 0)
{
    $column = [];
    $value = [];

    // Column definitions
    $column[] = [
        'title' => '#',
         //'className' => 'dt-control',
        'data' => 's_no'
    ];

    $column[] = [
        'title' => 'State Name',
        'className' => 'text-left',
        'data' => 'state_name' // match this with your data keys
    ];

     $column[] = [
        'title' => 'District Name',
        'className' => 'text-left',
        'data' => 'district_name' // match this with your data keys
    ];

    $column[] = [
        'title' => 'Taluk Name',
        'className' => 'text-left',
        'data' => 'taluk_name' // match this with your data keys
    ];

    $column[] = [
        'title' => 'Town Village Name',
        'className' => 'text-left',
        'data' => 'town_village_name' // match this with your data keys
    ];

     $column[] = [
        'title' => 'Census Code',
        'className' => 'text-left',
        'data' => 'bi_id' // match this with your data keys
    ];

    $column[] = [
        'title' => 'District Name',
        'className' => 'text-left',
        'data' => 'distbtr_name' // match this with your data keys
    ];

     $column[] = [
        'title' => 'Retailer Count',
        'className' => 'text-left',
        'data' => 'retlr_cnt' // match this with your data keys
    ];
      $column[] = [
        'title' => 'Potential',
        'className' => 'text-left',
        'data' => 'potential' // match this with your data keys
    ];
     $column[] = [
        'title' => 'Percentage',
        'className' => 'text-left',
        'data' => 'percentage' // match this with your data keys
    ];



    

    // Build rows
    for ($i = 0; $i < count($data); $i++) {

    $temp = [ 
        's_no' => $i + 1,
        'state_name' => $data[$i]['state_name'] ?? '',
        'district_name' => $data[$i]['district_name'] ?? '',
        'taluk_name' => $data[$i]['taluk_name'] ?? '',
        'town_village_name' => $data[$i]['town_village_name'] ?? '',
        'bi_id' => $data[$i]['bi_id'] ?? '',
        'distbtr_name' => $data[$i]['distbtr_name'] ?? '',
        'retlr_cnt' => $data[$i]['retlr_cnt'] ?? 0,

        // check if potential exists
        'potential' => isset($data[$i]['potential']) ? round($data[$i]['potential'],2) : 0,
        'percentage' => $data[$i]['percentage'] ?? 0,
    ];

    $value[] = $temp;
}
    return [
        'column' => $column,
        'value' => $value
    ];
}

    public function getsubrd($data,$type=0)
    {

        $column=[];
        $value=[];
         $user=auth()->user();
         \Log::info('feeder type get subrd: ' . $type);

        $consmtp=[120=>'Villg. Choc Consumption',123=>'Confectionery Consmptn',112=>'Confectionery Consmptn',133=>'Snacks Consmptn',1000=>'Choc Consmption',9999=>'Confectionery Consumption']; //change 25-02-2026
        if($user->id==13285)
            $consmtp[120]='Catgry Consumptn';
          array_push($column, array(
             'title' => '#', 'className' => 'dt-control','data'=>'s_no'
         ));

           

          array_push($column, array(
             'title' => 'SubRD Cluster ID', 'className' => 'text-left','data'=>'cluster_name'
         ));
         if($user->client_id == 112)
            {
                array_push($column, array(  'title' => 'Is Coca-Cola Wholesaler?', 'className' => 'text-left','data'=>'subrd_type_whlsl'  ));
                 
            }
          array_push($column, array(
             'title' => 'Distt', 'className' => 'text-left','data'=>'district_name'
         ));
           array_push($column, array(
             'title' => 'Sub-distt', 'className' => 'text-left','data'=>'taluk_name'
         ));
            array_push($column, array(
             'title' => 'Town / Villg', 'className' => 'text-left','data'=>'village_name'
         ));
             if($user->client_id==120)
            array_push($column, array(
             'title' => 'Market UID', 'className' => 'text-right','data'=>'market_id'
         ));
            array_push($column, array(
             'title' => 'Distance from <br> Recmmd SubRD Locatn (km)', 'className' => 'text-right','data'=>'distance_subrd'
         ));
            if($user->client_id!=9999)
             array_push($column, array(
             'title' => 'Outlet Potential (Nos.)', 'className' => 'text-right','data'=>'outlet_otential'
         ));
             array_push($column, array(
             'title' => 'Popn (Nos.)', 'className' => 'text-right','data'=>'population'
         ));
             if(($user->client_id==120 && $type==0) )
            array_push($column, array(
             'title' => 'Avg. SubRD Sales (Rs.) (Last 6 mnths)', 'className' => 'text-right','data'=>'avg_monthly_sale'
         ));
               if($user->client_id!=112  && $user->client_id!=9999)
              array_push($column, array(
             'title' => $consmtp[$user->client_id].' (Annual) (Rs.)',  'className' => 'text-right','data'=>'village_choc_consmptn'
         ));
           if($user->id==13285)
              array_push($column, array(
                 'title' => 'Catgry Shr (%)',  'className' => 'text-right','data'=>'catgry_shr'
             ));
           if($user->client_id==9999)
           {
                 //      array_push($column, array(
                 //     'title' => 'No. of Colleges', 'className' => 'text-right','data'=>'no_of_colleges'
                 // ));
                      
                    
                 //      array_push($column, array(
                 //     'title' => 'No. of Schools', 'className' => 'text-right','data'=>'no_of_schools'
                 // ));

                 //      array_push($column, array(
                 //     'title' => 'Total HHs.', 'className' => 'text-right','data'=>'hh'
                 // ));
                       array_push($column, array(
                     'title' => 'ATM', 'className' => 'text-right','data'=>'atm'
                 ));
                        array_push($column, array(
                     'title' => 'Bank', 'className' => 'text-right','data'=>'bank'
                 ));
                         array_push($column, array(
                     'title' => 'National Highway', 'className' => 'text-right','data'=>'nh'
                 ));
                          array_push($column, array(
                     'title' => 'State Highway', 'className' => 'text-right','data'=>'sh'
                 ));
                           array_push($column, array(
                     'title' => 'Railway Station', 'className' => 'text-right','data'=>'rly_stn'
                 ));
                       
          }
               if($user->client_id==120  || $user->client_id==9999)
              array_push($column, array(
             'title' => 'SubRD Priority', 'className' => 'text-left','data'=>'subrd_priority'
         ));
              
            
              array_push($column, array(
             'title' => 'Cluster Type', 'className' => 'text-left','data'=>'cluster_tag'
         ));

              array_push($column, array(
             'title' => 'Existg SubRD Code', 'className' => 'text-right','data'=>'exist_subrd_code'
         ));

              array_push($column, array(
             'title' => 'Existg SubRD', 'className' => 'text-left','data'=>'exist_subrd_name'
         ));
               array_push($column, array(
             'title' => 'No of Active Location', 'className' => 'text-right','data'=>'subrd_count'
         ));

         
        
       $wholesaleIcon="";
        for($i=0;$i<count($data);$i++)
        {
                
               if($user->client_id==112)
                {
                        if ($data[$i]['subrd_type_whlsl'] == 3) {

                        $wholesaleIcon = '<a href="#"
                            id="'.$data[$i]['village_census'].'"
                            onClick="showbound(this)"
                            style="text-decoration:underline; font-weight:bold; color:blue; cursor:pointer;">
                            Yes
                        </a>';
                    }
                   else
                    {
                        $wholesaleIcon='';
                    }

                }
            if($type!=0)
            {
                 $exist=$data[$i]['exist_subrd_code'] ;
            }
            else
            {
                $exist='<a href="#" id="' . $data[$i]['exist_subrd_code'] . '" district="'.$data[$i]['loc9'].'" taluk="'.$data[$i]['taluk_census'].'" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_existsubrd(this)">' . $data[$i]['exist_subrd_code'] . '</a>';
            }
             $data[$i]['village_census']=ltrim($data[$i]['village_census'], 0);
             
             $detail=htmlspecialchars(json_encode([$data[$i]]), ENT_QUOTES, 'UTF-8');

             $count_of_subrd=(in_array($data[$i]['subrd_type'],[1,3])) ? $data[$i]['child_count'] : '';
            if($user->client_id==9999)
             $temp=array(
                
                's_no'=>($i+1),
                'cluster_name'=>'Cluster '.$data[$i]['cluster_id'],

                'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .'</a>',
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
                // '<a href="#" style="text-decoration:underline;" onClick="view_village_detail('.$detail.')">'.$data[$i]['village_name'].'</a>',
                 // 'market_id'=> $data[$i]['market_id'],
                  'distance_subrd'=>$data[$i]['distance_subrd'],
                  'population'=>number_format($data[$i]['population'],0),
                   // 'avg_monthly_sale'=>number_format($data[$i]['avg_monthly_sale'],0),
                  // 'village_choc_consmptn'=>number_format($data[$i]['village_choc_consmptn'],0),
                  //  'no_of_colleges'=>number_format($data[$i]['no_of_colleges'],0),
                  //   'no_of_schools'=>number_format($data[$i]['no_of_schools'],0),
                     // 'hh'=>number_format($data[$i]['hh'],0),
                     'atm'=>$data[$i]['atm'],
                     'bank'=>$data[$i]['bank'],
                     'nh'=>$data[$i]['nh'],
                     'sh'=>$data[$i]['sh'],
                     'rly_stn'=>$data[$i]['rly_stn'],
                  'subrd_priority'=>'<a href="#" id="' . $data[$i]['subrd_priority'] . '" district="'.$data[$i]['loc9'].'" taluk="'.$data[$i]['taluk_census'].'" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_priority(this)">' . $data[$i]['subrd_priority'] . '</a>',
                  
                 
                  'cluster_tag'=>$data[$i]['subrd_loaction'],
                  'exist_subrd_code'=>$data[$i]['exist_subrd_code'],
                  'exist_subrd_name'=>$data[$i]['exist_subrd_name'],
                  'subrd_count'=> $count_of_subrd,
                  'child'=>$data[$i]['child_d']

 
            );
             if(($user->client_id==120 || $user->client_id==133) && $type==0 && $user->id!=13285)
                $temp=array(
                    
                    's_no'=>($i+1),
                    'cluster_name'=>'Cluster '.$data[$i]['cluster_id'],

                    'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .' distt</a>',
                     'taluk_name'=>$data[$i]['taluk_name']. ' sub-distt',
                     'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
                    // '<a href="#" style="text-decoration:underline;" onClick="view_village_detail('.$detail.')">'.$data[$i]['village_name'].'</a>',
                     'market_id'=> $data[$i]['market_id'],
                      'distance_subrd'=>$data[$i]['distance_subrd'],
                      'outlet_otential'=>number_format($data[$i]['outlet_potential'],0),
                      'population'=>number_format((float)$data[$i]['population'],0),
                       'avg_monthly_sale'=>number_format((float)$data[$i]['avg_monthly_sale'],0),
                      'village_choc_consmptn'=>number_format($data[$i]['village_choc_consmptn'],0), //change 25-02-2026
                      'subrd_priority'=>'<a href="#" id="' . $data[$i]['subrd_priority'] . '" district="'.$data[$i]['loc9'].'" taluk="'.$data[$i]['taluk_census'].'" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_priority(this)">' . $data[$i]['subrd_priority'] . '</a>',
                      
                     
                      'cluster_tag'=>$data[$i]['subrd_loaction'],
                      'exist_subrd_code'=>$exist,
                      'exist_subrd_name'=>$data[$i]['exist_subrd_name'],
                      'subrd_count'=> $count_of_subrd,
                      'child'=>$data[$i]['child_d']


                );
             if(($user->client_id==120 && $user->id==13285))
                $temp=array(
                    
                    's_no'=>($i+1),
                    'cluster_name'=>'Cluster '.$data[$i]['cluster_id'],

                    'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .'</a>',
                     'taluk_name'=>$data[$i]['taluk_name'],
                     'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['location'] . '</a>',
                    // '<a href="#" style="text-decoration:underline;" onClick="view_village_detail('.$detail.')">'.$data[$i]['village_name'].'</a>',
                     'market_id'=> $data[$i]['market_id'],
                      'distance_subrd'=>$data[$i]['distance_subrd'],
                      'outlet_otential'=>number_format($data[$i]['outlet_potential'],0),
                      'population'=>number_format($data[$i]['population'],0),
                       'avg_monthly_sale'=>number_format($data[$i]['avg_monthly_sale'],0),
                      'village_choc_consmptn'=>number_format($data[$i]['village_choc_consmptn'],0),
                       'catgry_shr'=>number_format($data[$i]['catgry_shr'],0),
                      'subrd_priority'=>'<a href="#" id="' . $data[$i]['subrd_priority'] . '" district="'.$data[$i]['loc9'].'" taluk="'.$data[$i]['taluk_census'].'" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_priority(this)">' . $data[$i]['subrd_priority'] . '</a>',
                      
                     
                      'cluster_tag'=>$data[$i]['subrd_loaction'],
                      'exist_subrd_code'=>$exist,
                      'exist_subrd_name'=>$data[$i]['exist_subrd_name'],
                      'subrd_count'=> $count_of_subrd,
                      'child'=>$data[$i]['child_d']


                );
         if(($user->client_id==120) && $type==1) 
            $temp=array(
                
                's_no'=>($i+1),
                'cluster_name'=>'Cluster '.$data[$i]['cluster_id'],

                'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .'</a>',
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
                // '<a href="#" style="text-decoration:underline;" onClick="view_village_detail('.$detail.')">'.$data[$i]['village_name'].'</a>',
                 'market_id'=> $data[$i]['market_id'],
                  'distance_subrd'=>$data[$i]['distance_subrd'],
                  'outlet_otential'=>number_format($data[$i]['outlet_potential'],0),
                  'population'=>number_format($data[$i]['population'],0),
                  
                  'village_choc_consmptn'=>number_format($data[$i]['village_choc_consmptn'],0),
                  'subrd_priority'=>'<a href="#" id="' . $data[$i]['subrd_priority'] . '" district="'.$data[$i]['loc9'].'" taluk="'.$data[$i]['taluk_census'].'" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_priority(this)">' . $data[$i]['subrd_priority'] . '</a>',
                  
                 
                  'cluster_tag'=>$data[$i]['subrd_loaction'],
                  'exist_subrd_code'=>$exist,
                  'exist_subrd_name'=>$data[$i]['exist_subrd_name'],
                  'subrd_count'=> $count_of_subrd,
                  'child'=>$data[$i]['child_d']


            );
         
         if($user->client_id==1000)
            $temp=array(
                's_no'=>($i+1),
                'cluster_name'=>'Cluster '.$data[$i]['cluster_id'],

                'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .'</a>',
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
               
                  'distance_subrd'=>$data[$i]['distance_subrd'],
                  'outlet_otential'=>$data[$i]['outlet_potential'],
                  'population'=>$data[$i]['population'],
                  'village_choc_consmptn'=>$data[$i]['village_choc_consmptn'],
                  'cluster_tag'=>$data[$i]['cluster_tag'].' SubRD Hub',
                  'exist_subrd_name'=>'<a href="#" id="' . $data[$i]['exist_subrd_code'] . '" district="'.$data[$i]['loc9'].'" taluk="'.$data[$i]['taluk_census'].'" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_existsubrd(this)">' . $data[$i]['exist_subrd_code'] . '</a>',
                  'exist_subrd_code'=>$data[$i]['exist_subrd_name'],
                  'subrd_count'=> $count_of_subrd,
                  // 'child'=>$data[$i]['child_d']


            );

        if($user->client_id==123 || $user->client_id==112 || $user->client_id==133)  
            
        $temp=array('s_no'=>($i+1),
               // 'cluster_name'=>'Cluster '.$data[$i]['cluster_id'].' ',
               'cluster_name'=>'<a href="#" id="'.$data[$i]['cluster_id'].'"style="text-decoration:underline" onClick="filterCluster(this.id,\''.$data[$i]['village_census'].'\')">Cluster '.$data[$i]['cluster_id'].'</a>',

                'subrd_type_whlsl'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration: underline; color: blue;" onClick="showbound(this)">'.$wholesaleIcon. '</a>',

                'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .'</a>',
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
                // '<a href="#" style="text-decoration:underline;" onClick="view_village_detail('.$detail.')">'.$data[$i]['village_name'].'</a>',
                
                  'distance_subrd'=>round($data[$i]['distance_subrd'],2),
                  'outlet_otential'=>$data[$i]['outlet_potential'],
                  'population'=>number_format($data[$i]['population'],0),
                   'village_choc_consmptn'=>number_format($data[$i]['village_choc_consmptn'],0), //change 25-02-2026
                  
                  'cluster_tag'=>$data[$i]['cluster_tag'].' SubRD Hub',
                  'exist_subrd_code'=>'<a href="#" id="' . $data[$i]['exist_subrd_code'] . '" district="'.$data[$i]['loc9'].'" taluk="'.$data[$i]['taluk_census'].'" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_existsubrd(this)">' . $data[$i]['exist_subrd_code'] . '</a>',
                  'exist_subrd_name'=>$data[$i]['exist_subrd_name'],
                  'subrd_count'=> $count_of_subrd,
                  'child'=>$data[$i]['child_d']);
            array_push($value,$temp);

        }
            
            return array(
            'column' => $column,
            'value' => $value
        );



    }

public function getsubrdMdlziRural($data, $type = 0)
{
    $column = [];
    $value  = [];
    $user   = auth()->user();

    $consmtp = [
        120  => 'Villg. Choc Consumption',
        123  => 'Confectionery Consmptn',
        112  => 'Confectionery Consmptn',
        133  => 'Category Consumption of Villg./Town (Snacks)',
        1000 => 'Choc Consmption',
        9999 => 'Confectionery Consumption'
    ];

    if ($user->id == 13285) {
        $consmtp[120] = 'Catgry Consumptn';
    }

    array_push($column, [
        'title'     => '#',
        'className' => 'dt-control',
        'data'      => 's_no'
    ]);

    array_push($column, [
        'title'     => 'Cluster ID',
        'className' => 'text-left',
        'data'      => 'cluster_name'
    ]);

    array_push($column, [
        'title'     => 'Distt',
        'className' => 'text-left',
        'data'      => 'district_name'
    ]);

    array_push($column, [
        'title'     => 'Sub-distt',
        'className' => 'text-left',
        'data'      => 'taluk_name'
    ]);

    array_push($column, [
        'title'     => 'Town / Villg',
        'className' => 'text-left',
        'data'      => 'village_name'
    ]);

    if ($user->client_id == 120) {
        array_push($column, [
            'title'     => 'Market UID',
            'className' => 'text-right',
            'data'      => 'market_id'
        ]);
    }

    // FIXED: show cluster consumption column when is_hub == 1, else show distance column
    if (!empty($data) && isset($data[0]['is_hub']) && $data[0]['is_hub'] == 1) {

       

    } else {

        array_push($column, [
            'title'     => 'Distance from <br> Anchor  Locatn (km)',
            'className' => 'text-right',
            'data'      => 'distance_subrd'
        ]);
    }

    if ($user->client_id != 9999) {
        array_push($column, [
            'title'     => 'FMCG Outlets',
            'className' => 'text-right',
            'data'      => 'outlet_otential'
        ]);
    }

    array_push($column, [
        'title'     => 'Popn (Nos.)',
        'className' => 'text-right',
        'data'      => 'population'
    ]);

    if (($user->client_id == 120 && $type == 0)) {
       

         array_push($column, [
            'title'     => 'Villg. Biscuit Consmptn (Annual) (Rs.)',
            'className' => 'text-right',
            'data'      => 'cluster_village_biscuits_consmptn'
        ]);

    }

    if ($user->client_id != 112 && $user->client_id != 9999) {
        array_push($column, [
            'title'     => $consmtp[$user->client_id] . ' (Annual) (Rs.)',
            'className' => 'text-right',
            'data'      => 'cluster_village_choc_consmptn'
        ]);
    }

    if ($user->id == 13285) {
        array_push($column, [
            'title'     => 'Catgry Shr (%)',
            'className' => 'text-right',
            'data'      => 'catgry_shr'
        ]);
    }

    if ($user->client_id == 120 || $user->client_id == 9999) {
        array_push($column, [
            'title'     => 'SubRD Priority',
            'className' => 'text-left',
            'data'      => 'subrd_priority'
        ]);
    }

    array_push($column, [
        'title'     => 'Cluster Type',
        'className' => 'text-left',
        'data'      => 'cluster_tag'
    ]);

    array_push($column, [
        'title'     => 'Existg Anchor Code',
        'className' => 'text-right',
        'data'      => 'exist_subrd_code'
    ]);

    array_push($column, [
        'title'     => 'Existg Anchor',
        'className' => 'text-left',
        'data'      => 'exist_subrd_name'
    ]);

    array_push($column, [
        'title'     => 'No. of Villgs. in the cluster',
        'className' => 'text-right',
        'data'      => 'subrd_count'
    ]);

    for ($i = 0; $i < count($data); $i++) {

        $exist = ($type != 0)
            ? $data[$i]['exist_subrd_code']
            : '<a href="#" id="' . $data[$i]['exist_subrd_code'] . '" district="' . $data[$i]['loc9'] . '" taluk="' . $data[$i]['taluk_census'] . '" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_existsubrd(this)">' . $data[$i]['exist_subrd_code'] . '</a>';

       $data[$i]['village_census'] = ltrim($data[$i]['village_census'], 0);

        $count_of_subrd = in_array($data[$i]['subrd_type'], [1, 3])
            ? $data[$i]['child_count']
            : '';

        $temp = [
            's_no'        => ($i + 1),
            //'cluster_name'=> 'Cluster ' . $data[$i]['cluster_id'],
          //  'cluster_name'=>'<a href="#" id="'.$data[$i]['cluster_id'].'"style="text-decoration:underline"onClick="filterCluster(this.id,"'.$data[$i]['village_census'].'")">Cluster '.$data[$i]['cluster_id'].'</a>',
          'cluster_name' => '<a href="#" id="'.$data[$i]['cluster_id'].'" style="text-decoration:underline" onClick="filterCluster(this.id,\''.$data[$i]['village_census'].'\')">Cluster '.$data[$i]['cluster_id'].'</a>',
           // 'district_name' => '<a href="#" id="' . $data[$i]['child'] . '" class="getchild_' . ($i + 1) . '">' . $data[$i]['district_name'] . '</a>',
             'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .' distt</a>',
            'taluk_name'    => $data[$i]['taluk_name'],
            //'village_name'  => '<a href="#" data-id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',

              'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',

            // keep both values available
            'distance_subrd'                 => round($data[$i]['distance_subrd'], 2),
           // 'cluster_village_choc_consmptn' => number_format($data[$i]['cluster_village_choc_consmptn'], 0),

            'market_id'         => $data[$i]['market_id'] ?? '',
            'outlet_otential'   => number_format($data[$i]['outlet_potential'] ?? 0, 0),
            'population'        => number_format($data[$i]['population'] ?? 0, 0),
            'cluster_village_biscuits_consmptn'  => number_format($data[$i]['cluster_village_biscuits_consmptn'] ?? 0, 0),
            'cluster_village_choc_consmptn' => number_format($data[$i]['cluster_village_choc_consmptn'] ?? 0, 0),
            'catgry_shr'        => number_format($data[$i]['catgry_shr'] ?? 0, 0),

            'subrd_priority' => '<a href="#" id="' . $data[$i]['subrd_priority'] . '" district="' . $data[$i]['loc9'] . '" taluk="' . $data[$i]['taluk_census'] . '" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_priority(this)">' . $data[$i]['subrd_priority'] . '</a>',

            'cluster_tag'      => $data[$i]['subrd_loaction'] ?? ($data[$i]['cluster_tag'] . ' Anchor'),
            'exist_subrd_code' => $exist,
            'exist_subrd_name' => $data[$i]['exist_subrd_name'],
            'subrd_count'      => $count_of_subrd,
            'child'            => $data[$i]['child_d'] ?? ''
        ];

        $value[] = $temp;
    }

    return [
        'column' => $column,
        'value'  => $value
    ];
}
public function getsubrdPepsiRural($data, $type = 0)
{
    $column = [];
    $value  = [];
    $user   = auth()->user();

    $consmtp = [
        120  => 'Villg. Choc Consumption',
        123  => 'Confectionery Consmptn',
        112  => 'Confectionery Consmptn',
        133  => 'Category Consumption of Villg./Town (Snacks)',
        1000 => 'Choc Consmption',
        9999 => 'Confectionery Consumption'
    ];

    if ($user->id == 13285) {
        $consmtp[120] = 'Catgry Consumptn';
    }

    array_push($column, [
        'title'     => '#',
        'className' => 'dt-control',
        'data'      => 's_no'
    ]);

    array_push($column, [
        'title'     => 'Cluster ID',
        'className' => 'text-left',
        'data'      => 'cluster_name'
    ]);

    array_push($column, [
        'title'     => 'Distt',
        'className' => 'text-left',
        'data'      => 'district_name'
    ]);

    array_push($column, [
        'title'     => 'Sub-distt',
        'className' => 'text-left',
        'data'      => 'taluk_name'
    ]);

    array_push($column, [
        'title'     => 'Town / Villg',
        'className' => 'text-left',
        'data'      => 'village_name'
    ]);

    if ($user->client_id == 120) {
        array_push($column, [
            'title'     => 'Market UID',
            'className' => 'text-right',
            'data'      => 'market_id'
        ]);
    }

    // FIXED: show cluster consumption column when is_hub == 1, else show distance column
    if (!empty($data) && isset($data[0]['is_hub']) && $data[0]['is_hub'] == 1) {

        array_push($column, [
            'title'     => 'Total Cluster Consumption (Snacks)(Annual) (Rs.)',
            'className' => 'text-right',
            'data'      => 'cluster_village_choc_consmptn'
        ]);

    } else {

        array_push($column, [
            'title'     => 'Distance from <br> Anchor  Locatn (km)',
            'className' => 'text-right',
            'data'      => 'distance_subrd'
        ]);
    }

    if ($user->client_id != 9999) {
        array_push($column, [
            'title'     => 'West\'n Salty Outlets',
            'className' => 'text-right',
            'data'      => 'outlet_otential'
        ]);
    }

    array_push($column, [
        'title'     => 'Popn (Nos.)',
        'className' => 'text-right',
        'data'      => 'population'
    ]);

    if (($user->client_id == 120 && $type == 0)) {
        array_push($column, [
            'title'     => 'Avg. SubRD Sales (Rs.) (Last 6 mnths)',
            'className' => 'text-right',
            'data'      => 'avg_monthly_sale'
        ]);
    }

    if ($user->client_id != 112 && $user->client_id != 9999) {
        array_push($column, [
            'title'     => $consmtp[$user->client_id] . ' (Annual) (Rs.)',
            'className' => 'text-right',
            'data'      => 'village_choc_consmptn'
        ]);
    }

    if ($user->id == 13285) {
        array_push($column, [
            'title'     => 'Catgry Shr (%)',
            'className' => 'text-right',
            'data'      => 'catgry_shr'
        ]);
    }

    if ($user->client_id == 120 || $user->client_id == 9999) {
        array_push($column, [
            'title'     => 'SubRD Priority',
            'className' => 'text-left',
            'data'      => 'subrd_priority'
        ]);
    }

    array_push($column, [
        'title'     => 'Cluster Type',
        'className' => 'text-left',
        'data'      => 'cluster_tag'
    ]);

    array_push($column, [
        'title'     => 'Existg Anchor Code',
        'className' => 'text-right',
        'data'      => 'exist_subrd_code'
    ]);

    array_push($column, [
        'title'     => 'Existg Anchor',
        'className' => 'text-left',
        'data'      => 'exist_subrd_name'
    ]);

    array_push($column, [
        'title'     => 'No. of Villgs. in the cluster',
        'className' => 'text-right',
        'data'      => 'subrd_count'
    ]);

    for ($i = 0; $i < count($data); $i++) {

        $exist = ($type != 0)
            ? $data[$i]['exist_subrd_code']
            : '<a href="#" id="' . $data[$i]['exist_subrd_code'] . '" district="' . $data[$i]['loc9'] . '" taluk="' . $data[$i]['taluk_census'] . '" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_existsubrd(this)">' . $data[$i]['exist_subrd_code'] . '</a>';

       $data[$i]['village_census'] = ltrim($data[$i]['village_census'], 0);

        $count_of_subrd = in_array($data[$i]['subrd_type'], [1, 3])
            ? $data[$i]['child_count']
            : '';

        $temp = [
            's_no'        => ($i + 1),
            'cluster_name'=> 'Cluster ' . $data[$i]['cluster_id'],
            'district_name' => '<a href="#" id="' . $data[$i]['child'] . '" class="getchild_' . ($i + 1) . '">' . $data[$i]['district_name'] . '</a>',
            'taluk_name'    => $data[$i]['taluk_name'],
            'village_name'  => '<a href="#" data-id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',

            // keep both values available
            'distance_subrd'                 => round($data[$i]['distance_subrd'], 2),
            'cluster_village_choc_consmptn' => number_format($data[$i]['cluster_village_choc_consmptn'], 0),

            'market_id'         => $data[$i]['market_id'] ?? '',
            'outlet_otential'   => number_format($data[$i]['outlet_potential'] ?? 0, 0),
            'population'        => number_format($data[$i]['population'] ?? 0, 0),
            'avg_monthly_sale'  => number_format($data[$i]['avg_monthly_sale'] ?? 0, 0),
            'village_choc_consmptn' => number_format($data[$i]['village_choc_consmptn'] ?? 0, 0),
            'catgry_shr'        => number_format($data[$i]['catgry_shr'] ?? 0, 0),

            'subrd_priority' => '<a href="#" id="' . $data[$i]['subrd_priority'] . '" district="' . $data[$i]['loc9'] . '" taluk="' . $data[$i]['taluk_census'] . '" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_priority(this)">' . $data[$i]['subrd_priority'] . '</a>',

            'cluster_tag'      => $data[$i]['subrd_loaction'] ?? ($data[$i]['cluster_tag'] . ' Anchor'),
            'exist_subrd_code' => $exist,
            'exist_subrd_name' => $data[$i]['exist_subrd_name'],
            'subrd_count'      => $count_of_subrd,
            'child'            => $data[$i]['child_d'] ?? ''
        ];

        $value[] = $temp;
    }

    return [
        'column' => $column,
        'value'  => $value
    ];
}
     public function getsubrd_krishnagiri($data,$type=0)
    {
        $column=[];
        $value=[];
         $user=auth()->user();

       
      
          array_push($column, array(
             'title' => '#', 'className' => 'dt-control','data'=>'s_no'
         ));

          array_push($column, array(
             'title' => 'SubRD Cluster ID', 'className' => 'text-left','data'=>'cluster_name'
         ));
          array_push($column, array(
             'title' => 'Distt', 'className' => 'text-left','data'=>'district_name'
         ));
           array_push($column, array(
             'title' => 'Sub-distt', 'className' => 'text-left','data'=>'taluk_name'
         ));
            array_push($column, array(
             'title' => 'Town / Villg', 'className' => 'text-left','data'=>'village_name'
         ));
         
            array_push($column, array(
             'title' => 'Distance from <br> Recmmd SubRD Locatn (km)', 'className' => 'text-right','data'=>'distance_subrd'
         ));
            if($user->client_id!=9999)
             array_push($column, array(
             'title' => 'Outlet Potential (Nos.)', 'className' => 'text-right','data'=>'outlet_otential'
         ));
             array_push($column, array(
             'title' => 'Popn (Nos.)', 'className' => 'text-right','data'=>'population'
         ));
              array_push($column, array(
             'title' => 'Rural Progrsv Index', 'className' => 'text-left','data'=>'rpi'
         ));
            
          
              
            
              array_push($column, array(
             'title' => 'Cluster Type', 'className' => 'text-left','data'=>'cluster_tag'
         ));

            
               array_push($column, array(
             'title' => 'No of Active Location', 'className' => 'text-right','data'=>'subrd_count'
         ));
        

        for($i=0;$i<count($data);$i++)
        {

           
                 $exist=$data[$i]['exist_subrd_code'] ;
            
             $data[$i]['village_census']=ltrim($data[$i]['village_census'], 0);
             
             $detail=htmlspecialchars(json_encode([$data[$i]]), ENT_QUOTES, 'UTF-8');

             $count_of_subrd=(in_array($data[$i]['subrd_type'],[1,3])) ? $data[$i]['child_count'] : '';
           
            
                $temp=array(
                    
                    's_no'=>($i+1),
                    'cluster_name'=>'Cluster '.$data[$i]['cluster_id'],

                    'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .'</a>',
                     'taluk_name'=>$data[$i]['taluk_name'],
                     'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
                    
                      'distance_subrd'=>$data[$i]['distance_subrd'],
                      'outlet_otential'=>number_format($data[$i]['outlet_potential'],0),
                      'population'=>number_format($data[$i]['population'],0),
                    
                     'rpi'=>$data[$i]['rpi'],
                      'cluster_tag'=>$data[$i]['subrd_loaction'],
                    
                      'subrd_count'=> $count_of_subrd,
                      'child'=>$data[$i]['child_d']


                );
               array_push($value,$temp);

        }
            
            return array(
            'column' => $column,
            'value' => $value
        );



    }
     public function getsubrd_rla($data)
    {
        $column=[];
        $value=[];
         $user=auth()->user();

        $consmtp=[120=>'Villg. Choc Consumption'];
          array_push($column, array(
             'title' => '#', 'className' => 'text-right','data'=>'s_no'
         ));

          
          array_push($column, array(
             'title' => 'Distt. Name', 'className' => 'text-left','data'=>'district_name'
         ));
           array_push($column, array(
             'title' => 'Sub-Distt. Name', 'className' => 'text-left','data'=>'taluk_name'
         ));
            array_push($column, array(
             'title' => 'Town / Village Name', 'className' => 'text-left','data'=>'village_name'
         ));
          
              array_push($column, array(
             'title' => 'SubRD Code', 'className' => 'text-right','data'=>'exist_subrd_code'
         ));
       
              array_push($column, array(
             'title' => 'SubRD Name', 'className' => 'text-left','data'=>'exist_subrd_name'
         ));
               array_push($column, array(
             'title' => 'TSI UID', 'className' => 'text-right','data'=>'tsi_name'
         ));
                array_push($column, array(
             'title' => 'TSI Code', 'className' => 'text-right','data'=>'tsi_code'
         ));
             array_push($column, array(
             'title' => 'TSI Name', 'className' => 'text-left','data'=>'tsi_name'
         ));
              array_push($column, array(
             'title' => 'Market UID', 'className' => 'text-right','data'=>'market_id'
         ));

            
              array_push($column, array(
             'title' => 'Villg. With Zero RLA (Active / Inactive)', 'className' => 'text-left','data'=>'cluster_tag'
         ));
                array_push($column, array(
             'title' => 'Distance from Recmmd SubRD Locatn (km)', 'className' => 'text-right','data'=>'distance_subrd'
         ));
             array_push($column, array(
             'title' => 'Outlet Potential (Nos.)', 'className' => 'text-right','data'=>'outlet_otential'
         ));
             array_push($column, array(
             'title' => 'Population (Nos.)', 'className' => 'text-right','data'=>'population'
         ));


             
              
        

        for($i=0;$i<count($data);$i++)
        {
             $data[$i]['village_census']=ltrim($data[$i]['village_census'], 0);
             
           
            if($user->client_id==120)
            $temp=array(
                
                's_no'=>($i+1),
              

                'district_name'=>$data[$i]['district_name'],
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
                  'exist_subrd_code'=> $data[$i]['exist_subrd_code'],
                  'exist_subrd_name'=>$data[$i]['exist_subrd_name'],
                  'tsi_uid'=>$data[$i]['tsi_uid'],
                  'tsi_code'=>$data[$i]['tsi_code'],
                  'tsi_name'=>$data[$i]['tsi_name'],

                // '<a href="#" style="text-decoration:underline;" onClick="view_village_detail('.$detail.')">'.$data[$i]['village_name'].'</a>',
                 'market_id'=> $data[$i]['market_id'],
                    'cluster_tag'=>'Villg. with Zero RLA (Inactive)',
                  'distance_subrd'=>$data[$i]['distance_subrd'],
                  'outlet_otential'=>number_format($data[$i]['outlet_potential'],0),
                  'population'=>number_format($data[$i]['population'],0),
                  
                 
               
                 
               
              


            );
         

     
            array_push($value,$temp);

        }
            
            return array(
            'column' => $column,
            'value' => $value
        );



    }
    public function getsubrd_pepsi($data)
    {
        $column=[];
        $value=[];
       
    
      
          array_push($column, array(
             'title' => '#', 'className' => 'text-left','data'=>'s_no'
         ));

          array_push($column, array(
             'title' => 'Distt. Name', 'className' => 'text-left','data'=>'district_name'
         ));
           array_push($column, array(
             'title' => 'Sub-Distt. Name', 'className' => 'text-left','data'=>'taluk_name'
         ));
            array_push($column, array(
             'title' => 'Town / Village Name', 'className' => 'text-left','data'=>'village_name'
         ));
            
               array_push($column, array(
             'title' => 'Rural Progressive Index', 'className' => 'text-left','data'=>'rpi'
         ));

                 array_push($column, array(
             'title' => 'Population (2023)', 'className' => 'text-right','data'=>'population'
         ));
        
         /* array_push($column, array(
             'title' => 'Total HHs.', 'className' => 'text-right','data'=>'hhs'
         ));
        
          array_push($column, array(
             'title' => 'Snacks Consmptn.', 'className' => 'text-right','data'=>'snacks_cnsptn'
         ));
          array_push($column, array(
             'title' => 'FMCG Retlrs.', 'className' => 'text-right','data'=>'fmcg_retlrs'
         ));
          array_push($column, array(
             'title' => 'Dealer per Lac(s).', 'className' => 'text-right','data'=>'dpl'
         ));
          array_push($column, array(
             'title' => 'Bank', 'className' => 'text-left','data'=>'bank'
         ));
          array_push($column, array(
             'title' => 'ATM', 'className' => 'text-left','data'=>'atm'
         ));
          array_push($column, array(
             'title' => 'School', 'className' => 'text-left','data'=>'school'
         ));
          array_push($column, array(
             'title' => 'College', 'className' => 'text-left','data'=>'college'
         ));
          array_push($column, array(
             'title' => 'Highway(s).', 'className' => 'text-left','data'=>'highways'
         ));*/
        
     $s=1;
        for($i=0;$i<count($data);$i++)
        {
             $data[$i]['village_census']=ltrim($data[$i]['village_census'], 0);
             
            $temp=array(
                
                's_no'=>($s),
               
                'district_name'=> $data[$i]['district_name'],
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
               
                 'rpi'=> $data[$i]['rpi'],
                 'population'=> number_format($data[$i]['population'],0)
                  /*'hhs'=> number_format($data[$i]['hhs'],0),
                   'snacks_cnsptn'=> number_format($data[$i]['snacks_cnsptn'],0),
                    'fmcg_retlrs'=> number_format($data[$i]['fmcg_retlrs'],0),
                     'dpl'=> number_format($data[$i]['dpl'],0),
                      'bank'=> $data[$i]['bank'],
                       'atm'=> $data[$i]['atm'],
                        'school'=> $data[$i]['school'],
                         'college'=> $data[$i]['college'],
                          'highways'=> $data[$i]['highways']*/



            );
            $s++;
       //  'child'=>$data[$i]['child_d']
            array_push($value,$temp);
            $data[$i]['child_count']=0;
        if($data[$i]['child_count']>0)
        {
            foreach($data[$i]['child_d'] as $k=>$v)
            {
            
                $temp=array(
                    
                    's_no'=>($s),
                
                    'district_name'=>$v['district_name'],
                    'taluk_name'=>$v['taluk_name'],
                    'village_name'=>'<a href="#" id="' . $v['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $v['village_name'] . '</a>',
                
                    'rpi'=> $v['rpi']
                );
        $s++;
                array_push($value,$temp); 
            }
        }
          

        }
            
            return array(
            'column' => $column,
            'value' => $value
        );



    }
     public function rpi_action(Request $request)
    {
         $input=$request->all();
         $user = auth()->user();
         $userid=$user->id;
         $msg=[];

         $village_id=$input['village_id'];
         $action_id=$input['action_id'];

         if (DB::table('subrd_data')->where([['village_census','=',$village_id ]])->exists()) 
        {

          if(DB::table('subrd_data')->where([['village_census','=',$village_id ]])->update(['company_service_id' => $action_id])){
               $msg['statuschange']='success';
               $msg['msg']='Details updated';
           }
          
        }
        else
        {
             $msg['statuschange']='failure';
             $msg['msg']='Not Available';

        }

        return response()->json($msg);
    }
    public function Combine($maparray, $type, $main_location, $sub_location,$input_obj,$so_id)
    {
        $data = [];$getdetail=[];
        $user = auth()->user();
        $userid = $user->id;

        $data['result'] = array();
        $data['mapdata'] = array();



        $key = array_keys($maparray);
        $value = array_values($maparray);



        $loc15 = array_unique(array_column($value, 'loc15'));
        $loc12 = array_unique(array_column($value, 'loc12'));
        $loc16 = array_unique($key);
        $pc_uid = array_unique(array_column($value, 'pc_uid'));


         $getfilter=json_decode($input_obj);
         $condn=[];
      
         if(isset($getfilter->filter_pc) && (count($getfilter->filter_pc) > 0))
          {
             $pc_user=implode(",",$getfilter->filter_pc);
             if($pc_user != '')
              array_push($condn, "and pc_uid in (".$pc_user.")");
            

          }
          if(isset($getfilter->filter_distributor) && (count($getfilter->filter_distributor) > 0))
          {
              $distributor_list=implode(",",$getfilter->filter_distributor);
              array_push($condn, "and fld1744 in (".$distributor_list.")");
          }
          $criteria=join(" ",$condn);

        $condition = [];
        $total_data_array = [];
        $covered_condition = [];
        $total_uncovered_data_array = [];

        if (count($loc15) > 0)
        {
            array_push($condition, "ward_id in (" . implode(',', $loc15) . ")");
            array_push($covered_condition, " loc15 in (" . implode(',', $loc15) . ")");


        }

        if (count($loc12) > 0)
        {
            array_push($condition, "city_id in (" . implode(',', $loc12) . ")");
            array_push($covered_condition, "loc12 in (" . implode(',', $loc12) . ")");

        }
         if (count($loc16) > 0)
        {
            array_push($condition, "colony_id in (" . implode(',', $loc16) . ")");
            array_push($covered_condition, "loc16 in (" . implode(',', $loc16) . ")");

        }
        if(count($pc_uid) > 0)
        {
           array_push($covered_condition,"pc_uid in (" . implode(',', $pc_uid) . ")");
        }
        

         $condn="";$covered_condn="";

         if(count($condition) > 0 )
         {
                $condn = ltrim(join(" and ", $condition),"and");

                $condn = $condn.' and';

         }

          if(count($covered_condition) > 0 )
         {
                $covered_condn = ltrim(join(" and ", $covered_condition),"and");

                $covered_condn = $covered_condn.' and';

         }



         
     //    $covered_condn = join(" and ", $covered_condition);


         if ($type == 1) $total_data_sql = "select (s.fld_21+s.fld_3+s.fld_22) as total_shop,s.locid,s.ward_id,s.city_id from (SELECT colony_id locid,round((sum(prvsn)+sum(gens)),0) fld_21,round(sum(fb_mdlz),0) fld_3,round(sum(chemist_lsi),0) fld_22,ward_id,city_id FROM all_retailer_colony WHERE  " . $condn . "  ( fld189 = '2') and  ( colony_id != '0') and ( colony_id != '0') and ( stat != 'R') GROUP BY city_id,ward_id,locid) as s";
        
        if ($type == 2) $total_data_sql = "select (s.fld_22) as total_shop,s.locid,s.ward_id,s.city_id from (SELECT colony_id locid,round(sum(chemist_lsi),0) fld_22,ward_id,city_id FROM all_retailer_colony WHERE   " . $condn . " ( fld189 = '2') and  ( colony_id != '0') and ( colony_id != '0') and ( stat != 'R') GROUP BY city_id,ward_id,locid) as s";




        $result = DB::select(DB::raw($total_data_sql));


        for ($i = 0;$i < count($result);$i++)
        {
            $total_data_array[$result[$i]->locid]['total'] = array(
                'total_shop' => $result[$i]->total_shop,
                'colony_id' => $result[$i]->locid,
                'ward_id' => $result[$i]->ward_id,
                'city_id' => $result[$i]->city_id
            );
        }

        if ($type == 1) $total_covered_sql = "SELECT count(*) as covered_shop,a.loc16 as locid,a.loc12 as city_id,a.loc15 as ward_id,a.pc_uid FROM `mdlz_retailer_master` as a  WHERE " . $covered_condn . "  a.`sheet_ref` LIKE '18 Town Data'  and a.stat='A' and a.loc16 != 0    $criteria group by a.pc_uid,a.loc12,a.loc15,locid";
        if ($type == 2) $total_covered_sql = "SELECT count(*) as covered_shop,a.loc16 as locid,a.loc12 as city_id,a.loc15 as ward_id,a.pc_uid FROM `mdlz_retailer_master` as a  WHERE " . $covered_condn . "  a.`fld1746` in(2) and a.`sheet_ref` LIKE '18 Town Data'  and a.stat='A' and a.loc16 != 0    $criteria group by a.pc_uid,a.loc12,a.loc15,locid";

        //echo $total_covered_sql;die;

      
        $covered_result = DB::select(DB::raw($total_covered_sql));

    
        for ($i = 0;$i < count($covered_result);$i++)
        {
          // $covered_result[$i]->pc_uid= 1872;

          if (!array_key_exists($covered_result[$i]->pc_uid,$getdetail))
               $getdetail[$covered_result[$i]->pc_uid]=CommonController::getreportee($covered_result[$i]->pc_uid,$covered_result[$i]->locid);

            $total_data_array[$covered_result[$i]->locid]['retailer'] = array(
                'covered_shop' => $covered_result[$i]->covered_shop,
                'colony_id' => $covered_result[$i]->locid,
                'ward_id' => $covered_result[$i]->ward_id,
                'city_id' => $covered_result[$i]->city_id,
                'pc_uid'=>$covered_result[$i]->pc_uid,                 
                'so_id'=>$getdetail[$covered_result[$i]->pc_uid]['so_id'],
                'asm_id'=>$getdetail[$covered_result[$i]->pc_uid]['asm_id'],
                'bsm_id'=>$getdetail[$covered_result[$i]->pc_uid]['bsm_id'],
                'pc_name'=>$getdetail[$covered_result[$i]->pc_uid]['pc_name'],
                'so_name'=>$getdetail[$covered_result[$i]->pc_uid]['so_name'],
                'asm_name'=>$getdetail[$covered_result[$i]->pc_uid]['asm_name'],
                'bsm_name'=>$getdetail[$covered_result[$i]->pc_uid]['bsm_name'],
                'distributor'=>$getdetail[$covered_result[$i]->pc_uid]['distributor']
                //'distributor'=>$covered_result[$i]->name
            );

           
        }
        //var_dump($total_data_array);die;

        $detail_array = []; $non_potential_array=[];

        foreach ($maparray as $key => $value)
        {

            if (isset($total_data_array[$key]))
            {
                 if(!(isset($total_data_array[$key]['retailer']['pc_uid'])))
                {
                    $pc_uid = DB::table('loclty_pc_link')->where('loc16', $value['loc_id'])->select(['pc_uid'])->first();
                    $pc_uid=$pc_uid->pc_uid;
                    if (!array_key_exists($pc_uid,$getdetail))
                        $getdetail[$pc_uid]=CommonController::getreportee($pc_uid,$value['loc_id']);
                    $total_data_array[$key]['retailer']['pc_uid']=$pc_uid;
                    $total_data_array[$key]['retailer']['so_id']=$getdetail[$pc_uid]['so_id'];
                    $total_data_array[$key]['retailer']['asm_id']=$getdetail[$pc_uid]['asm_id'];
                    $total_data_array[$key]['retailer']['bsm_id']=$getdetail[$pc_uid]['bsm_id'];
                    $total_data_array[$key]['retailer']['pc_name']=$getdetail[$pc_uid]['pc_name'];
                    $total_data_array[$key]['retailer']['so_name']=$getdetail[$pc_uid]['so_name'];
                    $total_data_array[$key]['retailer']['asm_name']=$getdetail[$pc_uid]['asm_name'];
                    $total_data_array[$key]['retailer']['bsm_name']=$getdetail[$pc_uid]['bsm_name'];
                    $total_data_array[$key]['retailer']['distributor']=$getdetail[$pc_uid]['distributor'];

                   
                }
                $total_shop = 0;
                $retailer_shop = 0;
                $uncovered_shop = 0;
                if (isset($total_data_array[$key]['total'])) $total_shop = $total_data_array[$key]['total']['total_shop'];
                if (isset($total_data_array[$key]['retailer']['covered_shop'])) $retailer_shop = $total_data_array[$key]['retailer']['covered_shop'];

               // if($total_shop !=0 && $retailer_shop !=0 )
              //  {
                    if ($total_shop > $retailer_shop) $uncovered_shop = $total_shop - $retailer_shop;
                    if ($total_shop < $retailer_shop)
                    {
                        $total_shop = $retailer_shop;
                        $uncovered_shop = $total_shop - $retailer_shop;
                    }

                   if($uncovered_shop > 0)
                    array_push($detail_array, array(
                        'total_shop' => $total_shop,
                        'covered_shop' => $retailer_shop,
                        'uncovered_shop' => $uncovered_shop,
                        'city_id' => $value['loc12'],
                        'ward_id' => $value['loc15'],
                        'colony_id' => $value['loc_id'],
                       // 'distributor' => $value['distributor'],
                        'pc_uid'=> $total_data_array[$key]['retailer']['pc_uid'],
                        'so_id'=> $total_data_array[$key]['retailer']['so_id'],
                        'asm_id'=> $total_data_array[$key]['retailer']['asm_id'],
                        'bsm_id'=> $total_data_array[$key]['retailer']['bsm_id'],
                        'pc_name'=>$total_data_array[$key]['retailer']['pc_name'],
                        'so_name'=>$total_data_array[$key]['retailer']['so_name'],
                        'asm_name'=>$total_data_array[$key]['retailer']['asm_name'],
                        'bsm_name'=>$total_data_array[$key]['retailer']['bsm_name'],
                        'distributor'=>$total_data_array[$key]['retailer']['distributor']
                       // 'distributor'=>$getdetail[$covered_result[$i]->pc_uid]['distributor']
                    ));
                 else if($uncovered_shop <=0)
                    array_push($non_potential_array, array(
                        'total_shop' => $total_shop,
                        'covered_shop' => $retailer_shop,
                        'uncovered_shop' => $uncovered_shop,
                        'city_id' => $value['loc12'],
                        'ward_id' => $value['loc15'],
                        'colony_id' => $value['loc_id'],
                       //  'distributor' => $value['distributor'],
                        'pc_uid'=> $total_data_array[$key]['retailer']['pc_uid'],
                        'so_id'=> $total_data_array[$key]['retailer']['so_id'],
                        'asm_id'=> $total_data_array[$key]['retailer']['asm_id'],
                        'bsm_id'=> $total_data_array[$key]['retailer']['bsm_id'],
                        'pc_name'=>$total_data_array[$key]['retailer']['pc_name'],
                        'so_name'=>$total_data_array[$key]['retailer']['so_name'],
                        'asm_name'=>$total_data_array[$key]['retailer']['asm_name'],
                        'bsm_name'=>$total_data_array[$key]['retailer']['bsm_name'],
                        'distributor'=>$total_data_array[$key]['retailer']['distributor']
                        //'distributor'=>$getdetail[$covered_result[$i]->pc_uid]['name']
                    ));


             //   }

                

            }

        }

        $uncoverval_arr = array_column($detail_array, 'uncovered_shop');

        array_multisort($uncoverval_arr, SORT_DESC, $detail_array);

        $totaldata=count($detail_array);
        $clr_code = array("G"=>"#01875B","Y"=>"#e0d006","R"=>"#eb3136");
        $clr_split_cnt = array("G"=>round(($totaldata*33)/100),"Y"=>round(($totaldata*33)/100),"R"=>round(($totaldata*34)/100));

        $lolctyColrSplit = array();
         if($totaldata == 1)   {    
             $lolctyColrSplit['G'] = array_slice($detail_array,0,1,TRUE);}
         if($totaldata == 2){
             $lolctyColrSplit['G'] = array_slice($detail_array,0,1,TRUE);
             $lolctyColrSplit['Y'] = array_slice($detail_array,1,1,TRUE);
         }
         if($totaldata == 3){
             $lolctyColrSplit['G'] = array_slice($detail_array,0,1,TRUE);
             $lolctyColrSplit['Y'] = array_slice($detail_array,1,1,TRUE);
             $lolctyColrSplit['R'] = array_slice($detail_array,2,1,TRUE);
         }
          if($totaldata == 4){
             $lolctyColrSplit['G'] = array_slice($detail_array,0,1,TRUE);
             $lolctyColrSplit['Y'] = array_slice($detail_array,1,1,TRUE);
             $lolctyColrSplit['R'] = array_slice($detail_array,2,1,TRUE);
             $lolctyColrSplit['R'] = array_slice($detail_array,3,2,TRUE);
         }
         if($totaldata > 4)
         {
            $lolctyColrSplit['G'] = array_slice($detail_array,0,round(($totaldata*33)/100),TRUE);
            $lolctyColrSplit['Y'] = array_slice($detail_array,round(($totaldata*33)/100),round(($totaldata*33)/100),TRUE);
            $lolctyColrSplit['R'] = array_slice($detail_array,round(($totaldata*33)/100)*2,round(($totaldata*34)/100),TRUE);
         }
         $rank=1;
         $total_count=count($detail_array)+count($non_potential_array);

        foreach($lolctyColrSplit as $clr => $lolctyVal)
        {
             $clr_tot = array_sum(array_column($lolctyVal,'uncovered_shop'));
             $add_shr = 0;
             foreach($lolctyVal as $key => $val)
            {
                $shr = ($val['uncovered_shop']/$clr_tot)*100;
                $add_shr = $add_shr + $shr;
                $inc = (ceil($add_shr/10)*10)-10; // To get Color Percent               
                $inc = $inc > 90 ? 90 : $inc;  
                if(count($lolctyColrSplit[$clr]) <= 3)
                    $final_color = $clr_code[$clr];                
                else
                    $final_color = $this->getColorCodeByPercent($clr_code[$clr], $inc);
                $type=($clr=='G') ? 'High' : (($clr=='Y') ? 'Medium' : 'Low');

                

                // $info_text = '<b>' . $maparray[$val['colony_id']]['location_name'] . '<br>Total Retailers : ' . $val['total_shop'] . '<br>Covered Retailers :  ' . $val['covered_shop'] . '<br>Uncovered Retailers: ' . $val['uncovered_shop'];
                // $info_text = "<div class='tooltip-data'><div class='card'><div class='card-header'>". $maparray[$val['colony_id']]['location_name'] ." <span class='".strtolower($type)."' style='background-color:".$final_color."'>".$type."</span></div><ul class='list-group list-group-flush'><li class='list-group-item'>Total Retailers (Nos.) <span>" . $val['total_shop'] . "</span></li><li class='list-group-item'>Mondelez Retailers (Nos.) <span> ". $val['covered_shop'] . "</span></li><li class='list-group-item' style='background-color:".$final_color."'>Uncovered Retailers (Nos.) <span>" . $val['uncovered_shop']."</span></li></ul></div></div>";

                 $info_text='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$val['colony_id']]['location_name'].' <small>Rank   '.$rank.'/'.$total_count.'</small></h3> <span class="'.strtolower($type).'" style="background-color:'.$final_color.'">'.$type.'</span></div><ul class="list-group list-group-flush"><li class="list-group-item">Total Retailers (Nos.) <span>'. $val['total_shop'] .'</span></li><li class="list-group-item">Mondelez Retailers (Nos.) <span>'. $val['covered_shop'] .'</span></li><li class="list-group-item" style="background-color:'.$final_color.';color:#fff !important;">Uncovered Retailers (Nos.) <span>'. $val['uncovered_shop'].'</span></li></ul><div class="adtnl-details"><ul class="list-group list-group-flush"><li class="list-group-item">'.$val['asm_name'].' <span>ASM</span></li><li class="list-group-item">'.$val['so_name'].' <span> SO</span></li><li class="list-group-item" >'.$val['pc_name'].' <span>PC</span></li><li class="list-group-item" >'.$val['distributor'].' <span>Distrbtr</span></li></ul></div></div></div>';

            if ($val['total_shop'] == 0) $val['total_shop'] = 1;

            $temp = array(
                'location_id' => $val['colony_id'],
                'location_name' => $maparray[$val['colony_id']]['location_name'],
                'total_shop' => $val['total_shop'],
                'covered_shop' => $val['covered_shop'],
                'uncovered_shop' => $val['uncovered_shop'],
                'percentage' => round(((int)$val['covered_shop'] / (int)$val['total_shop']) * 100) ,
                'color' => $final_color ,
                'info' => $info_text,
                'loc15' => $val['ward_id'],
                'pc_uid' => $val['pc_uid'],
                'so_id' => $val['so_id'],
                'asm_id' => $val['asm_id'],
                'bsm_id' => $val['bsm_id'],
                'loc12' => $val['city_id'],
                'pc_name'=>$val['pc_name'],
                'so_name'=>$val['so_name'],
                'asm_name'=>$val['asm_name'],
                'bsm_name'=>$val['bsm_name'],
            );

            $maparray[$val['colony_id']] = array_merge($maparray[$val['colony_id']], $temp);

            array_push($data['result'], $temp);


            $rank++;

                
             
            }
        }

        for($k=0;$k<count($non_potential_array);$k++)
        {
              $final_color='#fff';$type='No data';
              $val=$non_potential_array[$k];
              // $info_text = "<div class='tooltip-data'><div class='card'><div class='card-header'>". $maparray[$val['colony_id']]['location_name'] ." <span class='".strtolower($type)."' style='background-color:".$final_color."'>".$type."</span></div><ul class='list-group list-group-flush'><li class='list-group-item'>Total Retailers (Nos.) <span>" . $val['total_shop'] . "</span></li><li class='list-group-item'>Mondelez Retailers (Nos.) <span> ". $val['covered_shop'] . "</span></li><li class='list-group-item' style='background-color:".$final_color."'>Uncovered Retailers (Nos.) <span>" . $val['uncovered_shop']."</span></li></ul></div></div>";


               //  $info_text='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$val['colony_id']]['location_name'].' <small>Rank:  1/1000</small></h3> <span class="'.strtolower($type).'" style="background-color:'.$final_color.'">'.$type.'</span></div><ul class="list-group list-group-flush"><li class="list-group-item">Total Retailers (Nos.) <span>'. $val['total_shop'] .'</span></li><li class="list-group-item">Mondelez Retailers (Nos.) <span>'. $val['covered_shop'] .'</span></li><li class="list-group-item" style="background-color:'.$final_color.'">Uncovered Retailers (Nos.) <span>'. $val['uncovered_shop'].'</span></li></ul><div class="adtnl-details"><ul class="list-group list-group-flush"><li class="list-group-item">Lalit Mohan <span>ASM</span></li><li class="list-group-item">Gupta Saurabh <span> SO</span></li><li class="list-group-item" >Yakub Sayed <span>PC</span></li><li class="list-group-item" >Mehta Marketing <span>Distrbtr</span></li></ul></div></div></div>';

                 $info_text='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$val['colony_id']]['location_name'].' <small>Rank   '.$rank.'/'.$total_count.'</small></h3> <span class="'.strtolower($type).'" style="background-color:'.$final_color.'">'.$type.'</span></div><ul class="list-group list-group-flush"><li class="list-group-item">Total Retailers (Nos.) <span>'. $val['total_shop'] .'</span></li><li class="list-group-item">Mondelez Retailers (Nos.) <span>'. $val['covered_shop'] .'</span></li><li class="list-group-item" style="background-color:'.$final_color.';color:#fff !important;">Uncovered Retailers (Nos.) <span>'. $val['uncovered_shop'].'</span></li><li></li></ul><div class="adtnl-details"><ul class="list-group list-group-flush"><li class="list-group-item">'.$val['asm_name'].' <span>ASM</span></li><li class="list-group-item">'.$val['so_name'].' <span> SO</span></li><li class="list-group-item" >'.$val['pc_name'].' <span>PC</span></li></li><li class="list-group-item" >'.$val['distributor'].' <span>Distrbtr</span></li></ul></div></div></div>';

               

                $temp = array(
                    'location_id' => $val['colony_id'],
                    'location_name' => $maparray[$val['colony_id']]['location_name'],
                    'total_shop' => $val['total_shop'],
                    'covered_shop' => $val['covered_shop'],
                    'uncovered_shop' => $val['uncovered_shop'],
                    'percentage' =>0,
                    'color' => $final_color ,
                    'info' => $info_text,
                    'loc15' => $val['ward_id'],
                    'loc12' => $val['city_id'],
                    'pc_uid' => $val['pc_uid'],
                    'so_id' => $val['so_id'],
                    'asm_id' => $val['asm_id'],
                    'bsm_id' => $val['bsm_id'],
                    'pc_name'=>$val['pc_name'],
                    'so_name'=>$val['so_name'],
                    'asm_name'=>$val['asm_name'],
                    'bsm_name'=>$val['bsm_name'],
                );

                $maparray[$val['colony_id']] = array_merge($maparray[$val['colony_id']], $temp);

                array_push($data['result'], $temp);

                $rank++;


        }

        $data['legend'] = [];
        array_push($data['legend'],array('High'=>'#01875B','Medium'=>'#e0d006','Low'=>'#eb3136'));

        $data['mapdata'] = $maparray;
        $data['griddata'] = array();

        $data['griddata'] = $this->gridcolumn($data['result'], $loc15, $loc12);

        $head = CommonController::headline($loc12);
        $data['head'] = $head;

        return $data;

    }
    // public function gridcolumn_byoutletlist_bycategory($data)
    // {
    //    $column = array();
    //      $value = array();



    //      array_push($column, array(
    //         'title' => '#', 'className' => 'text-right'
    //     ));
    //        array_push($column, array(
    //         'title' => ucwords('Outlet Name')
    //     ));
    //        array_push($column, array(
    //         'title' => ucwords('Channel')
    //     ));
          
    //        array_push($column, array(
    //         'title' => ucwords('Sub-channel')
    //     ));
       
    //         array_push($column, array(
    //         'title' => ucwords('Address')
    //     ));
    //         array_push($column, array(
    //         'title' => ucwords('Status')
    //     ));
            

    //     for ($i = 0;$i < count($data);$i++)
    //     {

    //       if(!isset($data[0]['status']) )
    //          $temp = array(
    //             ($i + 1) ,   
                
    //              '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',
                 
    //             $data[$i]['channel_name'],
    //                $data[$i]['sub_channel_name'],
               
                 
    //               // $data[$i]['beat_name'],
              
    //             $data[$i]['address'],
                
    //             //  $data[$i]['lat'],
    //             // $data[$i]['lon'],
                 
                 

    //         );

    //        else if(isset($data[0]['beat_id']))
    //          $temp = array(
    //             ($i + 1) ,   
                
    //              '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',
    //              ((!isset($data[$i]['maintype_id'])) ? $data[$i]['channel_name'] :
    //               '<a href="#" style="text-decoration:underline" onClick="showuncovered('.$data[$i]['maintype_id'].')">'.$data[$i]['channel_name'].'</a>'),
    //            // $data[$i]['channel_name'],
    //                $data[$i]['sub_channel_name'],
    //               '<a href="#" style="text-decoration:underline" onClick="showbeat('.$data[$i]['beat_id'].')">'.$data[$i]['beat_name'].'</a>',
                 
    //               // $data[$i]['beat_name'],
              
    //             $data[$i]['address'],
                
    //             //  $data[$i]['lat'],
    //             // $data[$i]['lon'],
    //              ((isset($data[$i]['maintype_id'])) ?  (($data[$i]['status']=='R') ? 'Not Relevent' : (($data[$i]['status']=='A') ? 'Activated' : 'Uncovered')) : 
    //               (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
    //             )

                 

    //         );

    //        else
    //         $temp = array(
    //             ($i + 1) ,   
    //             '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',

    //             $data[$i]['channel_name'],
               
    //             $data[$i]['sub_channel_name'],
    //             $data[$i]['address'],
              
    //             (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
    //             //  $data[$i]['lat'],
    //             // $data[$i]['lon'],
                 

    //         );
    //      //    var_dump($data);continue;

    //         array_push($value, $temp);

    //     }

    //     return array(
    //         'column' => $column,
    //         'value' => $value
    //     );

    // }
    public function gridcolumn_byoutletlist_bycategory($data,$stat='false')
    {

       $column = array();
         $value = array();
          $user = auth()->user();
      $userid=$user->id;
      



         array_push($column, array(
            'title' => '#', 'className' => 'text-right'
        ));
           array_push($column, array(
            'title' => ucwords('Outlet Name')
        ));
           array_push($column, array(
            'title' => ucwords('Channel')
        ));
          if($user->client_id !=86 && $user->client_id !=120 && $user->client_id != 115 && $user->client_id != 123  && $user->client_id != 1 && $user->client_id != 0 && $user->client_id != 1000)
           {
             array_push($column, array(
              'title' => ucwords('Sub-channel')
          ));
         }
          if($user->client_id == 86 || $user->client_id == 120)
          array_push($column, array(
              'title' => ucwords('Cluster')
          ));

            if(isset($data[0]['beat_id']))
               array_push($column, array(
            'title' => ucwords('Beat')
        ));
           
            array_push($column, array(
            'title' => ucwords('Address')
        ));
            if(isset($data[0]['potential_status']))
                array_push($column, array(
            'title' => ucwords('Estimated Potential')
        ));

        //      array_push($column, array(
        //     'title' => ucwords('Latitude')
        // ));
        //       array_push($column, array(
        //     'title' => ucwords('Longitude')
        // ));
             if(isset($data[0]['stock_confectionary']) && $user->client_id!=86 && $user->client_id !=120 && $user->client_id!=1 && $user->client_id!=1000 && $user->client_id!=0 && $user->client_id!=133)
                array_push($column, array(
            'title' => ucwords('Stock Confectionary')
        ));
              if(isset($data[0]['stock_chocolate']) && $user->client_id!=86 && $user->client_id !=120 && $user->client_id!=1 && $user->client_id!=1000 && $user->client_id!=0 && $user->client_id!=133)
                array_push($column, array(
            'title' => ucwords('Stock Chocolate')
        ));
              if(isset($data[0]['status']))
                array_push($column, array(
            'title' => ucwords('Status')
        ));

             

        for ($i = 0;$i < count($data);$i++)
        {
            if($user->client_id==133)
             $temp = array(
                ($i + 1) ,   
                
                 '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',
                 
                  '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\''.$data[$i]['channel_name'].'\')">'.$data[$i]['channel_name'].'</a>',
          '<a href="#" style="text-decoration:underline" onClick="mdlz_filter(\'\',\''.$data[$i]['sub_channel_name'].'\')">'.$data[$i]['sub_channel_name'].'</a>',
               
                $data[$i]['address'],
                 '<a onClick="mdlz_filter(\'\',\'\',\'\',\'\',\'\',\'\',\''.$data[$i]['potential_status'].'\')" style="text-decoration:underline;cursor:pointer;">'.$data[$i]['potential_status_name'].'</a>',
               
               
                
                 ((isset($data[$i]['maintype_id'])) ?  (($data[$i]['status']=='R') ? 'Not Relevent' : (($data[$i]['status']=='A') ? 'Activated' : (($data[$i]['status']=='NF') ? 'Not Found' : (($data[$i]['status']=='E') ? 'Existing':'Uncovered')))) : 
                  (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
                )

                 

            );

          else if(!isset($data[0]['status']) && $user->client_id!=1000 && $user->client_id!=0)
             $temp = array(
                ($i + 1) ,   
                
                 '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',
                 ((!isset($data[$i]['maintype_id'])) ? $data[$i]['channel_name'] :
                  '<a href="#" style="text-decoration:underline" onClick="showuncovered('.$data[$i]['maintype_id'].')">'.$data[$i]['channel_name'].'</a>'),
               // $data[$i]['channel_name'],
                   $data[$i]['sub_channel_name'],
               
                $data[$i]['address'],
                
                //  $data[$i]['lat'],
                // $data[$i]['lon'],
                 ((isset($data[$i]['maintype_id'])) ?  (($data[$i]['status']=='R') ? 'Not Relevent' : (($data[$i]['status']=='A') ? 'Activated' : (($data[$i]['status']=='NF') ? 'Not Found' : (($data[$i]['status']=='E') ? 'Existing':'Uncovered')))) : 
                  (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
                )

                 

            );
             else if(isset($data[0]['beat_id']) && isset($data[0]['potential_status']) && $user->client_id!=1 && $user->client_id!=1000 && $user->client_id!=0)

             $temp = array(
                ($i + 1) ,   
                
                 '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',
                 ((!isset($data[$i]['maintype_id'])) ? $data[$i]['channel_name'] :
                  '<a href="#" style="text-decoration:underline" onClick="showuncovered('.$data[$i]['maintype_id'].')">'.$data[$i]['channel_name'].'</a>'),   
                   $data[$i]['sub_channel_name'],
                  '<a href="#" style="text-decoration:underline" onClick="showbeat('.$data[$i]['beat_id'].')">'.$data[$i]['beat_name'].'</a>', 
                $data[$i]['address'],
                $data[$i]['potential_status_name'],

                 ((isset($data[$i]['maintype_id'])) ?  (($data[$i]['status']=='R') ? '<span id="tbl_'.$data[$i]['refid'].'">Not Relevent</span>' : (($data[$i]['status']=='A') ? '<span id="tbl_'.$data[$i]['refid'].'">Visited</span>' : (($data[$i]['status']=='NF') ? '<span id="tbl_'.$data[$i]['refid'].'">Not Found</span>': (($data[$i]['status']=='E') ? '<span id="tbl_'.$data[$i]['refid'].'">Existing</span>' :'<span id="tbl_'.$data[$i]['refid'].'">Uncovered</span>')))) : 
                  (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
                )

                 

            );

           else if(isset($data[0]['beat_id']) && $user->client_id!=1000 && $user->client_id!=0)

             $temp = array(
                ($i + 1) ,   
                
                 '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',
                 ((!isset($data[$i]['maintype_id'])) ? $data[$i]['channel_name'] :
                  '<a href="#" style="text-decoration:underline" onClick="showuncovered('.$data[$i]['maintype_id'].')">'.$data[$i]['channel_name'].'</a>'),   
                   $data[$i]['sub_channel_name'],
                  '<a href="#" style="text-decoration:underline" onClick="showbeat('.$data[$i]['beat_id'].')">'.$data[$i]['beat_name'].'</a>', 
                $data[$i]['address'],
                 ((isset($data[$i]['maintype_id'])) ?  (($data[$i]['status']=='R') ? '<span id="tbl_'.$data[$i]['refid'].'">Not Relevent</span>' : (($data[$i]['status']=='A') ? '<span id="tbl_'.$data[$i]['refid'].'">Visited</span>' : (($data[$i]['status']=='NF') ? '<span id="tbl_'.$data[$i]['refid'].'">Not Found</span>': (($data[$i]['status']=='E') ? '<span id="tbl_'.$data[$i]['refid'].'">Existing</span>' :'<span id="tbl_'.$data[$i]['refid'].'">Uncovered</span>')))) : 
                  (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
                )

                 

            );
           else if(isset($data[0]['potential_status']) && $user->client_id!=86 &&  $user->client_id!=120 &&  $user->client_id!=1 && $user->client_id!=1000 && $user->client_id!=0)
             $temp = array(
                ($i + 1) ,   
                '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',

                $data[$i]['channel_name'],
               
                $data[$i]['sub_channel_name'],
                $data[$i]['address'],
                $data[$i]['potential_status_name'],
                $data[$i]['perimium_name'],

                 (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
                

            );
           else if(isset($data[0]['stock_confectionary']) && $user->client_id!=86  && $user->client_id!=120 && $user->client_id!=1 && $user->client_id!=1000 && $user->client_id!=0)
             $temp = array(
                ($i + 1) ,   
                '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',

                $data[$i]['channel_name'],
               
                $data[$i]['sub_channel_name'],
                $data[$i]['address'],
                $data[$i]['stock_confectionary_name'],
                $data[$i]['stock_chocolate_name'],

                 (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
                

            );
           else if($user->client_id==86 || $user->client_id==120)
           {
            //echo $stat;die;
          //  $res=explode('/', $data[$i]['channel_name']);
             $temp = array(
                ($i + 1) ,   
                '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',

                
                 '<a href="#" style="text-decoration:underline" onClick="showuncovered(\''.$data[$i]['channel_name'].'\',\''.$data[$i]['cluster_id'].'\','.$stat.')">'.$data[$i]['channel_name'].'</a>',
               
               // $explode[1],
                 $data[$i]['cluster_name'],
                $data[$i]['address'],
                 '<a href="#" style="text-decoration:underline" onClick="showpotential(\''.$data[$i]['potential_status_name'].'\',\''.$data[$i]['cluster_id'].'\','.$stat.')">'.$data[$i]['potential_status_name'].'</a>',
                //$data[$i]['potential_status_name'],

                 (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : (($data[$i]['status']=='U') ? 'Under Coverage' : (($data[$i]['status']=='NU') ? 'Not Under Nestle Coverage ' : (($data[$i]['status']=='SR') ? 'Selling Relevant Category' :  (($data[$i]['status']=='NSR') ?  'Does Not Sell Relevant Category' : 'New' )))))))
                

            );
           }
           else if($user->client_id == 115 || $user->client_id == 123 || $user->client_id == 1000 || $user->client_id == 1 || $user->client_id == 0){

                                $res = explode('/', $data[$i]['channel_name']);
                                
              if($user->client_id==1 )                
                $temp = array(
                    ($i + 1),
                    '<a href="#" style="text-decoration:underline" onClick="highlight(' . $data[$i]['refid'] . ',' . $data[$i]['lat'] . ',' . $data[$i]['lon'] . ')">' . $data[$i]['outlet_name'] . '</a>',


                    '<a href="#" style="text-decoration:underline" onClick="showuncovered(\'' . $data[$i]['channel_name'] . '\',0)">' . $res[0] . '</a>',

                 
                    $data[$i]['address'],
                    $data[$i]['potential_status_name'],

                   

                    (($data[$i]['status'] == 'R') ? 'Not Found' : (($data[$i]['status'] == 'A') ? 'Found' : (($data[$i]['status'] == 'V') ?  'Visited' : 'New')))


                );
            else if($user->client_id==1000 || $user->client_id==0)
            {
 $temp = array(
                    ($i + 1),
                    '<a href="#" style="text-decoration:underline" onClick="highlight(' . $data[$i]['refid'] . ',' . $data[$i]['lat'] . ',' . $data[$i]['lon'] . ')">' . $data[$i]['outlet_name'] . '</a>',
                        $data[$i]['channel_name'],

                 
                    $data[$i]['address'],
                    $data[$i]['potential_status_name'],

                   

                    (($data[$i]['status'] == 'R') ? 'Not Found' : (($data[$i]['status'] == 'A') ? 'Found' : (($data[$i]['status'] == 'V') ?  'Visited' : 'New')))


                );
            }
            else
                $temp = array(
                    ($i + 1),
                    '<a href="#" style="text-decoration:underline" onClick="highlight(' . $data[$i]['refid'] . ',' . $data[$i]['lat'] . ',' . $data[$i]['lon'] . ')">' . $data[$i]['outlet_name'] . '</a>',


                    '<a href="#" style="text-decoration:underline" onClick="showuncovered(\'' . $data[$i]['channel_name'] . '\',0)">' . $res[0] . '</a>',

                 
                    $data[$i]['address'],
                   

                    (($data[$i]['status'] == 'R') ? 'Not Found' : (($data[$i]['status'] == 'A') ? 'Found' : (($data[$i]['status'] == 'V') ?  'Visited' : 'New')))


                );

            }
            

           else
            $temp = array(
                ($i + 1) ,   
                '<a href="#" style="text-decoration:underline" onClick="highlight('.$data[$i]['refid'].','.$data[$i]['lat'].','.$data[$i]['lon'].')">'.$data[$i]['outlet_name'].'</a>',

                $data[$i]['channel_name'],
               
                $data[$i]['sub_channel_name'],
                $data[$i]['address'],

                 (($data[$i]['status']=='R') ? 'Not Found' : (($data[$i]['status']=='A') ? 'Found' : (($data[$i]['status']=='V') ?  'Visited' : 'New' )))
                

            );
         //    var_dump($data);continue;

            array_push($value, $temp);

        }

        return array(
            'column' => $column,
            'value' => $value
        );

    }
    public function gridcolumn_byoutletlist($data)
    {
         $column = array();
         $value = array();



         array_push($column, array(
            'title' => '#', 'className' => 'text-right'
        ));
           array_push($column, array(
            'title' => ucwords('Establishment Name')
        ));
           array_push($column, array(
            'title' => ucwords('Channel')
        ));
          
           array_push($column, array(
            'title' => ucwords('Sub-channel')
        ));
          
            array_push($column, array(
            'title' => ucwords('proprietor')
        ));
            array_push($column, array(
            'title' => ucwords('Address')
        ));
             array_push($column, array(
            'title' => ucwords('PAN')
        ));
              array_push($column, array(
            'title' => ucwords('TAN')
        ));
               array_push($column, array(
            'title' => ucwords('Mobile No.')
        ));

      array_push($column, array(
             'title' => ucwords('Shop Establish No.')
        ));
      array_push($column, array(
            'title' => ucwords('GST No.')
        ));
       array_push($column, array(
            'title' => ucwords('Outlet Snap')
        ));

        for ($i = 0;$i < count($data);$i++)
        {



           
            $temp = array(
                ($i + 1) ,   
                 $data[$i]['outlet_name'],
                $data[$i]['channel_name'],
                $data[$i]['sub_channel_name'],                
                $data[$i]['owner_name'],
                $data[$i]['address'],
                //$data[$i]['pan_no'],'',
                'XXXXXXXXXX',
                //$data[$i]['tan_no'],
                'XXXXXXXXXX',
                $data[$i]['mobile_no'],
                'XXXXXX',
                //$data[$i]['shop_establish_no'],
                //$data[$i]['gst_no'],
                'XXXXXXXXXXXXXXX',
                '<img alt="'.($i + 1).'" src="'.$data[$i]['shop_image'].'" class="showimage" onClick="showimage(this)"/>'
                
            );
         //    var_dump($data);continue;

            array_push($value, $temp);

        }

        return array(
            'column' => $column,
            'value' => $value
        );




    }
     public function gridcolumn_bycluster($data)
    {
         $column = array();
         $value = array();



         array_push($column, array(
            'title' => '#', 'className' => 'text-right'
        ));
           array_push($column, array(
            'title' => ucwords('Cluster Name')
        ));
           array_push($column, array(
            'title' => 'No. of Total outlets'
        ));
          
           array_push($column, array(
            'title' => ucwords('No. of High Potntl Stores')
        ));
          
            array_push($column, array(
            'title' => ucwords('No. of Medium Potntl Stores')
        ));
        //     array_push($column, array(
        //     'title' => ucwords('No. of Low Potntl Stores')
        // ));
            

        for ($i = 0;$i < count($data);$i++)
        {



           
            $temp = array(
                ($i + 1) ,   
                  '<a href="#" style="text-decoration:underline" onClick="getmaker('.$data[$i]['refid'].',true)">'.$data[$i]['name'].'</a>',
                $data[$i]['total'],
                $data[$i]['High'],                
                $data[$i]['Medium'],
                //$data[$i]['Low'],
              
                
            );
         //    var_dump($data);continue;

            array_push($value, $temp);

        }

        return array(
            'column' => $column,
            'value' => $value
        );




    }
    public function gridcolumn($data, $loc15, $loc12)
    {
        $column = array();
        $value = array();

        $citydata = CommonController::getcity($loc12);
        $warddata = CommonController::getward($loc15);

        array_push($column, array(
            'title' => '#', 'className' => 'text-right'
        ));
        // array_push($column, array(
        //     'title' => ucwords('city')
        // ));
         array_push($column, array(
            'title' => ucwords('Locality Name')
        ));
        array_push($column, array(
            'title' => ucwords('N\'Bhrhd Name')
        ));       
         array_push($column, array(
            'title' => ucwords('PC')
        ));
        array_push($column, array(
            'title' => ucwords('SO')
        ));
        array_push($column, array(
            'title' => ucwords('ASM')
        ));
        array_push($column, array(
            'title' => ucwords('BSM')
        ));
        array_push($column, array(
            'title' => ucwords('Retlr Univrs (Nos.)') ,
            'className' => 'text-right'
        ));
        array_push($column, array(
            'title' => ucwords('Mdlz coverage (Nos.)') ,
            'className' => 'text-right'
        ));
        array_push($column, array(
            'title' => ucwords('Mdlz Opportunity (Nos.)') ,
            'className' => 'text-right'
        ));
        // array_push($column, array(
        //     'title' => ucwords('ND %') ,
        //     'className' => 'text-right'
        // ));
        $user = auth()->user();




        for ($i = 0;$i < count($data);$i++)
        {

            $temp = array(
                ($i + 1) ,
                $data[$i]['location_name'], 
               // $citydata[$data[$i]['loc12']],
                // '<a href="#" id="' . $data[$i]['location_id'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['location_name'] . '</a>',

                $warddata[$data[$i]['loc15']],
                
              '<a href="#" id="' . $data[$i]['pc_uid'] . '" style="text-decoration:underline" onClick="showboundbyusertype(this)">' . $data[$i]['pc_name'] . '</a>',
              ($user->user_type == 'SO') ?  '<a href="#" id="" style="text-decoration:underline" onClick="showboundbyusertype(this)">' . $data[$i]['so_name'] . '</a>' :  '<a href="#" so_id="' . $data[$i]['so_id'] . '" style="text-decoration:underline" onClick="showboundbyusertype(this)">' . $data[$i]['so_name'] . '</a>',

               //$data[$i]['pc_name'],
               // $data[$i]['so_name'],
                $data[$i]['asm_name'],
                $data[$i]['bsm_name'],
                $data[$i]['total_shop'],
                $data[$i]['covered_shop'],
                $data[$i]['uncovered_shop']
               // $data[$i]['percentage'] . '%'
            );
         //    var_dump($data);continue;

            array_push($value, $temp);

        }

        return array(
            'column' => $column,
            'value' => $value
        );

    }
    public function gridcolumn_bystatus($data, $loc15, $loc12)
    {
        $column = array();
        $value = array();

        $citydata = CommonController::getcity($loc12);
        $warddata = CommonController::getward($loc15);
        $user = auth()->user();

        array_push($column, array(
            'title' => '#', 'className' => 'text-right'
        ));
        // array_push($column, array(
        //     'title' => ucwords('city')
        // ));
         array_push($column, array(
            'title' => ucwords('Locality Name')
        ));
        array_push($column, array(
            'title' => ucwords('N\'Bhrhd Name')
        ));
          array_push($column, array(
            'title' => ucwords('PC')
        ));
        array_push($column, array(
            'title' => ucwords('SO')
        ));
        array_push($column, array(
            'title' => ucwords('ASM')
        ));
        array_push($column, array(
            'title' => ucwords('BSM')
        ));
       
        array_push($column, array(
            'title' => ucwords('Status') ,
            'className' => 'text-right'
        ));
        array_push($column, array(
            'title' => ucwords('Action Date') ,
            'className' => 'text-right'
        ));
        

        for ($i = 0;$i < count($data);$i++)
        {

            $temp = array(
                ($i + 1) ,
                //$citydata[$data[$i]['loc12']],
                  '<a href="#" id="' . $data[$i]['location_id'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['location_name'] . '</a>',
                $warddata[$data[$i]['loc15']],
                '<a href="#" id="' . $data[$i]['pc_uid'] . '" style="text-decoration:underline" onClick="showboundbyusertype(this)">' . $data[$i]['pc_name'] . '</a>',
              ($user->user_type == 'SO') ?  '<a href="#" id="" style="text-decoration:underline" onClick="showboundbyusertype(this)">' . $data[$i]['so_name'] . '</a>' :  '<a href="#" id="' . $data[$i]['so_id'] . '" style="text-decoration:underline" onClick="showboundbyusertype(this)">' . $data[$i]['so_name'] . '</a>',

                $data[$i]['asm_name'],
                $data[$i]['bsm_name'],

              
                $data[$i]['covered_stat'],
                ($data[$i]['action_date'] != '') ? date('d M Y H:i A',strtotime($data[$i]['action_date'])) : ''
            );

            array_push($value, $temp);

        }

        return array(
            'column' => $column,
            'value' => $value
        );

    }
    public function getColorCodeByPercent($hexCode, $adjustPercent) 
    {
       
        $hexCode = ltrim($hexCode, '#');
        
        $hexCode = array_map('hexdec', str_split($hexCode, 2));
        
        foreach ($hexCode as &$color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustPercent / 100);
            
            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }
        
        return '#'.implode($hexCode);
    }
    public function ldf($maparray,$type,$main_location,$sub_location,$so_id,$input_obj,$current_location)
    {

        $data = [];
        $data['result'] = array();      
        $data['channel_list'] = array();    
        $user = auth()->user();
        $userid = $user->id;   
        $key = array_keys($maparray);
        $value = array_values($maparray);
        $loc15 = array_unique(array_column($value, 'loc15'));
        $loc12 = array_unique(array_column($value, 'loc12')); 
        $condionarr=array('key'=>array(),'value'=>array(),'icon'=>array());
        $condionarr['key'][5]=[29,30,224,228];         
        $condionarr['key'][6]=[43,181];
        $condionarr['key'][7]=[203,16,17];


        $user = auth()->user();
        $userid=$user->id;
        $obj=json_decode($input_obj,true);


        if($type==9)
        {
           
            $lat=$current_location[0];
            $lon=$current_location[1];
            $data_outlet_list=[];
            $data_uncovered_outlet_list=[];
             $user = auth()->user();
          $client_id=$user->client_id;
          $feedback_question=[];

          $get_headline= DB::table('question_type')->where([['client_id','=', $client_id],['stat','=', 'A']])->get();
          $get_headline_count=count($get_headline);
          for($i=0;$i<$get_headline_count;$i++)
          {
             $feedback_question[$get_headline[$i]->refid]=['title'=>[$get_headline[$i]->question_type],'question'=>[]];
             $feedback_question_sl=DB::table('feedback_question')->where([['question_type','=', $get_headline[$i]->refid],['client_id','=', $client_id],['stat','=', 'A']])->get();
            $feed_question_count=count($feedback_question_sl);
             for($j=0;$j<$feed_question_count;$j++)
             {
                $temp=[];
                $temp['refid']=$feedback_question_sl[$j]->refid;
                $temp['question']=$feedback_question_sl[$j]->question;
                $temp['option_1']=$feedback_question_sl[$j]->option_1;
                $temp['option_2']=$feedback_question_sl[$j]->option_2;
                $temp['option_3']=$feedback_question_sl[$j]->option_3;
                $temp['option_4']=$feedback_question_sl[$j]->option_4;
                $temp['parent']=$feedback_question_sl[$j]->parent;
                $temp['type']=$feedback_question_sl[$j]->type;

                array_push($feedback_question[$get_headline[$i]->refid]['question'],$temp);
             }
          }


            $data_outlet_list =  DB::table('covered_outlets')
            ->join('beat_master', 'covered_outlets.beat_id', '=', 'beat_master.id')
            ->whereIn('covered_outlets.salesman_id',[$userid]);
            if(isset($obj['filter_beat']) && count($obj['filter_beat'])>0)
              $data_outlet_list->whereIn('covered_outlets.beat_id',$obj['filter_beat']);
             if(isset($obj['show_beat']) && $obj['show_beat']!='')
              $data_outlet_list->whereIn('covered_outlets.beat_id',[$obj['show_beat']]);


            $data_outlet_list->select('covered_outlets.id as refid'  , 'covered_outlets.channel as channel', 'covered_outlets.secondary_channel_type as subchannel', 'covered_outlets.name as outlet_name', 'covered_outlets.address as address', 'covered_outlets.latitude as lat', 'covered_outlets.longitude as lon','beat_master.beat_name','beat_master.id as beat_id');

            $data_outlet_list=$data_outlet_list->get();


            $filterchannel='';$filterpotential='';$filter_beat='';$show_beat=''; $status_outlet='';
            if(isset($obj['filter_bychannel']) && $obj['filter_bychannel']!='' && $obj['filter_bychannel']!=0)
              $filterchannel=' and maintype_id in ('.implode(",",$obj['filter_bychannel']).')';
           if(isset($obj['filter_bypotential']) && $obj['filter_bypotential']!='' && $obj['filter_bypotential']!=0)
              $filterpotential=' and fld1923 in ('.implode(",",$obj['filter_bypotential']).')'; //fld1923
            if(isset($obj['filter_beat'])  && count($obj['filter_beat']) > 0)
              $filter_beat=' and beat_id in ('.implode(",",$obj['filter_beat']).')';
             if(isset($obj['show_beat']) && $obj['show_beat']!='')
              $show_beat=' and beat_id in ('.$obj['show_beat'].')';

             if(isset($obj['filter_bystatus']) && (count($obj['filter_bystatus']) > 0))
             {
                $temp='(';
                foreach ($obj['filter_bystatus'] as $key => $value) {
                  $temp .= '"'.$value.'",';
                }
                $temp=trim($temp,",");
                $temp=$temp.")";
                $status_outlet=" and a.status in $temp ";
             }

            


         // $data_uncovered_outlet_list = "SELECT a.refid,rtlr_id,main_type as channel,SubType as subchannel,ccp as outlet_name,address as address,latitude as lat,longitude as lon,status,maintype_icon,maintype_id, c.shop_image,(((acos(sin((".$lat."*pi()/180)) * sin((`latitude`*pi()/180)) + cos((".$lat."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$lon."- `longitude`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance,b.beat_name,b.id as beat_id  FROM uncovered_outlets as a,beat_master as b, hul_alsi_maintype_master as c   where a.beat_id=b.id and a.maintype_id=c.refid and salesman_id='".$userid."' and latitude!='' and latitude!=0 ".$filterchannel." ".$filterpotential." ".$filter_beat." ".$show_beat." order by distance asc";

            // $data_uncovered_outlet_list = "SELECT a.refid,rtlr_id,main_type as channel,SubType as subchannel,ccp as outlet_name,address as address,latitude as lat,longitude as lon,status,if(a.fld1923=1,c.high,if(a.fld1923=2,c.medium,if(a.fld1923=3,c.low,c.icon))) as maintype_icon,maintype_id,if(a.fld1923=1,'High',if(a.fld1923=2,'Medium',if(a.fld1923=3,'Low',''))) as potential_status, c.shop_image,(((acos(sin((".$lat."*pi()/180)) * sin((`latitude`*pi()/180)) + cos((".$lat."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$lon."- `longitude`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance,b.beat_name,b.id as beat_id  FROM uncovered_outlets as a,beat_master as b, hul_alsi_maintype_master as c   where a.beat_id=b.id and a.maintype_id=c.refid and salesman_id='".$userid."' and latitude!='' and latitude!=0 ".$filterchannel." ".$filterpotential." ".$filter_beat." ".$show_beat." ".$status_outlet."order by distance asc";

            $data_uncovered_outlet_list = "SELECT a.refid,rtlr_id,main_type as channel,SubType as subchannel,ccp as outlet_name,address as address,latitude as lat,longitude as lon,status,if(a.fld1923=3,c.high,if(a.fld1923=2,c.medium,if(a.fld1923=1 ,c.low,c.icon))) as maintype_icon,maintype_id,if(a.potential_store=1,'Low',if(a.potential_store=2,'Medium',if((a.potential_store=3 || a.potential_store=4),'High',''))) as feed_potential_status,if(a.fld1923=3,'High',if(a.fld1923=2,'Medium',if(a.fld1923=1,'Low',''))) as potential_status, c.shop_image,(((acos(sin((".$lat."*pi()/180)) * sin((`latitude`*pi()/180)) + cos((".$lat."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$lon."- `longitude`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance,b.beat_name,b.id as beat_id  FROM uncovered_outlets as a,uncovered_user as bb,beat_master as b, hul_alsi_maintype_master as c   where a.stat='A' and a.rtlr_id=bb.uncovered_id  and a.beat_id=b.id and a.maintype_id=c.refid and bb.user_id='".$userid."' and latitude!='' and latitude!=0 ".$filterchannel." ".$filterpotential." ".$filter_beat." ".$show_beat." ".$status_outlet."order by distance asc";
        
          $data_uncovered_outlet_list = DB::select(DB::raw($data_uncovered_outlet_list));


           $uncovered_outlet_details="SELECT a.* FROM `uncovered_outlet_feedback` as a,uncovered_outlets as b  where a.outlet_id=b.refid and b.rtlr_id in (select uncovered_id from uncovered_user where user_id='".$userid."')";
          //$uncovered_outlet_details="select a.*,b.potention from (SELECT * FROM `uncovered_outlet_feedback` where outlet_id in (select uncovered_id from uncovered_user where user_id='".$userid."')) as a ,(SELECT sum(ifnull(ans,0)) as potention,outlet_id,user_id FROM `uncovered_outlet_feedback` where outlet_id in (select uncovered_id from uncovered_user where user_id='".$userid."') and question=5 group by question) as b where a.outlet_id=b.outlet_id and a.user_id=b.user_id";
          $uncovered_outlet_details_list = DB::select(DB::raw($uncovered_outlet_details));    
          $uncovered_info=[];
          for($i=0;$i<count($uncovered_outlet_details_list);$i++)
          {
            if(!array_key_exists($uncovered_outlet_details_list[$i]->outlet_id, $uncovered_info))
              $uncovered_info[$uncovered_outlet_details_list[$i]->outlet_id]=[];

            $uncovered_info[$uncovered_outlet_details_list[$i]->outlet_id][$uncovered_outlet_details_list[$i]->question]=$uncovered_outlet_details_list[$i];
          


             // array_push($uncovered_info[$uncovered_outlet_details_list[$i]->outlet_id],$uncovered_outlet_details_list[$i]);
          }

          $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          
           if(isset($obj['outlet_type']))
          {
             if(!in_array(1, $obj['outlet_type']))
                  $data_outlet_list=[];
             if(!in_array(2, $obj['outlet_type']))
                 $data_uncovered_outlet_list=[];

          }
         



           //   $data_uncovered_outlet_list =  DB::table('uncovered_outlets')->whereIn('salesman_id',[$userid])             
           // ->select('refid'  , 'rtlr_id', 'main_type as channel','maintype_id', 'SubType as subchannel', 'ccp as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','status','maintype_icon','maintype_id');
           // if(isset($obj['filter_bychannel']) && $obj['filter_bychannel']!='' && $obj['filter_bychannel']!=0)
           //   $data_uncovered_outlet_list->whereIn('maintype_id',[$obj['filter_bychannel']]);
           // if(isset($obj['filter_bypotential']) && $obj['filter_bypotential']!=''  && $obj['filter_bypotential']!=0)
           //   $data_uncovered_outlet_list->whereIn('Estimtd_potntl',[$obj['filter_bypotential']]);
           

           //  $data_uncovered_outlet_list = $data_uncovered_outlet_list->get();

        }
        else if($type==10)
        {
            

           //  $data_outlet_list =  DB::table('uncovered_outlets')            
           // ->select('fld580 as refid'  , 'fld1054', 'name as channel', 'name as subchannel', 'name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image')
           //  ->get();
               $data_outlet_list =  DB::table('uncovered_outlets')->whereIn('salesman_id',[$userid])         
           ->select('refid'  , 'rtlr_id', 'main_type as channel','main_type_id',  'subtype as subchannel', 'ccp as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','status','maintype_icon','maintype_id')
            ->get();
        }
      
       else if($type ==8)
       {
          $data_outlet_list =  DB::table('ref_nungambakkam')  
           ->whereIn('loc15',[1300105,1300106]) 
           ->select('fld580 as refid'  , 'fld1054', 'type as channel', 'subtype as subchannel', 'loc16', 'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image')
            ->get();
       }
        else if($type==11)
       {

             $user = auth()->user();
             $userid=$user->id;
             // $data_outlet_list =  DB::table('ref_24sep2021')      
             // // ->where([['status_1','=','A'],['status','=','N']])     
             //  ->select('refid'  ,  'type as channel', 'subtype as subchannel', 'loc16', 'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status')
             //  ->get();
        if($user->client_id==1)
        {
          if(isset($obj['filter_beat'])  && count($obj['filter_beat']) > 0)
              $filter_beat=$obj['filter_beat'];
            else
              $filter_beat=[];
           // $data_outlet_list =  DB::table('ref_08oct2021')   
           //  ->where([['user_id','=',$userid]]) 
           //   ->whereIn('beat_id',$filter_beat)  
           //   //  ->where([['status_1','=','C'],['status','=','N']])  
           //   // ->whereIn('fld1054',$condionarr['key'][$type])
           //    ->select('refid'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','potential_status','perimium')
           //    ->get();
               $data_outlet_list =  DB::table('whole')   
            ->where([['user_id','=',$userid]]) 
             ->whereIn('beat_id',$filter_beat)  
             //  ->where([['status_1','=','C'],['status','=','N']])  
             // ->whereIn('fld1054',$condionarr['key'][$type])
              ->select('refid'  ,'type as channel' ,  'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','stock_confectionary','stock_chocolate')
              ->get();
              //var_dump($data_outlet_list);
              $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

               $imagelist=[];$imagename=[];
               $c=count($data_outlet_imagelist);
              for($i=0;$i<$c;$i++)
              {
                 $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
                 $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
              }

        }
         if($user->client_id==86 || $user->client_id==120)
        {
           
          if(isset($obj['filter_beat'])  && count($obj['filter_beat']) > 0)
              $filter_beat=$obj['filter_beat'];
            else
              $filter_beat=[];
          if(isset($obj['filter_bychannel'])  && count($obj['filter_bychannel']) > 0)
              $filter_bychannel=$obj['filter_bychannel'];
            else
              $filter_bychannel=[];
          if(isset($obj['filter_bypotential'])  && count($obj['filter_bypotential']) > 0)
              $filter_bypotential=$obj['filter_bypotential'];
            else
              $filter_bypotential=[];
           if(isset($obj['filter_bystatus'])  && count($obj['filter_bystatus']) > 0)
              $filter_bystatus=$obj['filter_bystatus'];
            else
              $filter_bystatus=[];
           if(isset($obj['filter_bycluster'])  && count($obj['filter_bycluster']) > 0)
              $filter_bycluster=$obj['filter_bycluster'];
            else
              $filter_bycluster=[];
           // $data_outlet_list =  DB::table('ref_08oct2021')   
           //  ->where([['user_id','=',$userid]]) 
           //   ->whereIn('beat_id',$filter_beat)  
           //   //  ->where([['status_1','=','C'],['status','=','N']])  
           //   // ->whereIn('fld1054',$condionarr['key'][$type])
           //    ->select('refid'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','potential_status','perimium')
           //    ->get();

               $data_outlet_list =  DB::table('nestle')   
            ->where([['user_id','=',$userid]]) 
             ->whereIn('beat_id',$filter_beat);
             if(count($filter_bypotential) > 0)
              $data_outlet_list=$data_outlet_list->whereIn('fld1923',$filter_bypotential);
             
             if(count($filter_bychannel) > 0)
              $data_outlet_list=$data_outlet_list->whereIn('type',$filter_bychannel);
            if(count($filter_bystatus) > 0)
              $data_outlet_list=$data_outlet_list->whereIn('status',$filter_bystatus);
            if(count($filter_bycluster) > 0)
              $data_outlet_list=$data_outlet_list->whereIn('cluster_id',$filter_bycluster);

             //  ->where([['status_1','=','C'],['status','=','N']])  
             // ->whereIn('fld1054',$condionarr['key'][$type])
              $data_outlet_list=$data_outlet_list->select('refid'  ,'type as channel' ,  'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status','stock_confectionary','stock_chocolate','fld1923 
                as potential_status','potential_status as predict_potential','cluster_id')
              ->where([['status','!=','D']])  
              ->get();
              
              $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

               $imagelist=[];$imagename=[];
               $c=count($data_outlet_imagelist);
              for($i=0;$i<$c;$i++)
              {
                 $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
                 $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
              }

        }
        else if($user->client_id!=2)
          {
            

             $data_outlet_list =  DB::table('alwarpet_uncvrd');     
              // ->where([['user_id','=',$userid]]) 
            
              $data_outlet_list->select('refid','refid as outlet_id'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status')->get();
          }          
          else
          {
            if(isset($obj['filter_beat'])  && count($obj['filter_beat']) > 0)
              $filter_beat=$obj['filter_beat'];
            else
              $filter_beat=[];

            $data_outlet_list =  DB::table('pg_mumbai_uncvrd_3ward')     
              // ->where([['user_id','=',$userid]])  
             // ->whereIn('fld1054',$condionarr['key'][$type])
            
              ->whereIn('beat_id',$filter_beat)

              ->select('refid','refid as outlet_id'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status')->get();
          }
                
        
       }
       
       else
       {


           
        
            $data_outlet_list =  DB::table('ref_08oct2021')   
            ->where([['user_id','=',$userid]])   
             //  ->where([['status_1','=','C'],['status','=','N']])  
             // ->whereIn('fld1054',$condionarr['key'][$type])
              ->select('refid'  ,  'type as channel', 'sub_type as subchannel',  'fld1054', 'CCP_Name as outlet_name', 'address as address', 'latitude as lat', 'longitude as lon','icon','shop_image','status')
              ->get();
       }
       
       $cluster=[];
        for($i=0;$i<count($data_outlet_list);$i++)        
        {
             $potential=[0=>'',1=>'Low',2=>'Medium',3=>'High'];
             $perimium=[0=>'',1=>'Yes',2=>'No'];
            
             if(isset($data_outlet_list[$i]->cluster_id))
             {
                if(array_key_exists($data_outlet_list[$i]->cluster_id, $cluster))
               {
                   $cluster[$data_outlet_list[$i]->cluster_id][$potential[$data_outlet_list[$i]->potential_status]]++;
                   $cluster[$data_outlet_list[$i]->cluster_id]['total']++;
               }
               else
               {
                    $cluster[$data_outlet_list[$i]->cluster_id]=[];
                    if($data_outlet_list[$i]->cluster_id==0)
                        $cluster[$data_outlet_list[$i]->cluster_id]['name']='High Potential - Non-Cluster Outlets';
                    else
                         $cluster[$data_outlet_list[$i]->cluster_id]['name']='Cluster '.$data_outlet_list[$i]->cluster_id;
                    $cluster[$data_outlet_list[$i]->cluster_id]['refid']=$data_outlet_list[$i]->cluster_id;
                    $cluster[$data_outlet_list[$i]->cluster_id]['High']=0;
                    $cluster[$data_outlet_list[$i]->cluster_id]['Low']=0;
                    $cluster[$data_outlet_list[$i]->cluster_id]['Medium']=0;
                    $cluster[$data_outlet_list[$i]->cluster_id]['total']=0;
                    $cluster[$data_outlet_list[$i]->cluster_id][$potential[$data_outlet_list[$i]->potential_status]]++;
                    $cluster[$data_outlet_list[$i]->cluster_id]['total']++;


               }
             }
              $temp=[];
             
             $temp['refid']=$data_outlet_list[$i]->refid;
             $temp['outlet_name']=$data_outlet_list[$i]->outlet_name;            
             $temp['channel_name']= (isset($data_outlet_list[$i]->channel)) ? $data_outlet_list[$i]->channel : '';
             $temp['sub_channel_name']= (isset($data_outlet_list[$i]->subchannel)) ? $data_outlet_list[$i]->subchannel : '';
             $temp['address']=ucwords(strtolower($data_outlet_list[$i]->address));
             $temp['status']=(isset($data_outlet_list[$i]->status)) ? $data_outlet_list[$i]->status : '';
             if(isset($data_outlet_list[$i]->potential_status))
             {
              $temp['potential_status']=(isset($data_outlet_list[$i]->potential_status)) ? $data_outlet_list[$i]->potential_status : '';   
              $temp['predict_potential']=(isset($data_outlet_list[$i]->predict_potential)) ? $data_outlet_list[$i]->predict_potential : ''; 


               $temp['potential_status_name']=(isset($data_outlet_list[$i]->potential_status)) ? $potential[(int)$data_outlet_list[$i]->potential_status] : '';
               $temp['perimium']=(isset($data_outlet_list[$i]->perimium)) ? $data_outlet_list[$i]->perimium : '';
               $temp['perimium_name']=(isset($data_outlet_list[$i]->perimium)) ? $perimium[$data_outlet_list[$i]->perimium] : '';
            
             }
              if(isset($obj['filter_bycluster'])  && count($obj['filter_bycluster']) >0)
                $temp['cluster']=false;
              else
                $temp['cluster']=true;


               $temp['cluster_id']=(isset($data_outlet_list[$i]->cluster_id)) ? $data_outlet_list[$i]->cluster_id : '';
               if(isset($data_outlet_list[$i]->cluster_id) && $data_outlet_list[$i]->cluster_id==0)
                $temp['cluster_name']='High Potential - Non-Cluster Outlets';
               else
               $temp['cluster_name']=(isset($data_outlet_list[$i]->cluster_id)) ? 'Cluster '.$data_outlet_list[$i]->cluster_id : '';
               $temp['stock_confectionary']=(isset($data_outlet_list[$i]->stock_confectionary)) ? $data_outlet_list[$i]->stock_confectionary : '';
              $temp['stock_chocolate']=(isset($data_outlet_list[$i]->stock_chocolate)) ? $data_outlet_list[$i]->stock_chocolate : '';
              $temp['stock_confectionary_name']=(isset($data_outlet_list[$i]->stock_confectionary)) ? $perimium[$data_outlet_list[$i]->stock_confectionary] : '';
              $temp['stock_chocolate_name']=(isset($data_outlet_list[$i]->stock_chocolate)) ? $perimium[$data_outlet_list[$i]->stock_chocolate] : '';
              $temp['image_count']=(isset($imagelist[$data_outlet_list[$i]->refid])) ? $imagelist[$data_outlet_list[$i]->refid]  : 0;



             


             if($type==9)
             {
                $temp['beat_name']=ucfirst(strtolower($data_outlet_list[$i]->beat_name));
                $temp['icon']= 'images/covered.png';
                $temp['type']='covered';
             }
             else if($type==10)
             {
                $temp['icon']= ($data_outlet_list[$i]->status=='N') ? $data_outlet_list[$i]->maintype_icon : (($data_outlet_list[$i]->status=='A') ? 'images/coveredblue.png' : 'images/nr.png');                
                $temp['type']='uncovered';
             }
             else
             {

             	 if($data_outlet_list[$i]->status=='A')
                      $temp['icon']= 'images/uncovered.png';
               else if($data_outlet_list[$i]->status=='R' || $data_outlet_list[$i]->status=='V')
                      $temp['icon']= 'images/nr.png';
               else
                $temp['icon']=$data_outlet_list[$i]->icon;
             }
             


             $temp['shop_image']=  ($type==9 || $type==10) ? '' : $data_outlet_list[$i]->shop_image; 
              $temp['shop_image']=(isset($imagename[$data_outlet_list[$i]->refid])) ?  $imagename[$data_outlet_list[$i]->refid] : (isset($data_uncovered_outlet_list[$i]->shop_image) ? $data_outlet_list[$i]->shop_image : $temp['shop_image']);          
             
             $temp['lat']=(isset($data_outlet_list[$i]->lat)) ? $data_outlet_list[$i]->lat : ''; 
             $temp['lon']=(isset($data_outlet_list[$i]->lon)) ? $data_outlet_list[$i]->lon : ''; 

             array_push($data['result'],$temp);

        }
       
          if($type==9)
        {
           $data['uncovered_result']=[];$data['channel_list']=[]; $channel_list='';
           for($i=0;$i<count($data_uncovered_outlet_list);$i++)        
          {
               if(!in_array($data_uncovered_outlet_list[$i]->maintype_id,$data['channel_list']) && $data_uncovered_outlet_list[$i]->maintype_id !=0 && $data_uncovered_outlet_list[$i]->maintype_id!='')
               {
                  array_push($data['channel_list'],$data_uncovered_outlet_list[$i]->maintype_id);
                  $channel_list .='<option value="'.$data_uncovered_outlet_list[$i]->maintype_id.'">'.$data_uncovered_outlet_list[$i]->channel.'</option>';
               }
               $temp=[];

               $temp['refid']=$data_uncovered_outlet_list[$i]->refid;
               $temp['outlet_name']=$data_uncovered_outlet_list[$i]->outlet_name;            
               $temp['channel_name']=$data_uncovered_outlet_list[$i]->channel;
               $temp['maintype_id']=$data_uncovered_outlet_list[$i]->maintype_id;
             //  $temp['potential_status']=$data_uncovered_outlet_list[$i]->potential_status;
               $temp['sub_channel_name']=$data_uncovered_outlet_list[$i]->subchannel;
               $temp['address']=ucwords(strtolower($data_uncovered_outlet_list[$i]->address));
               $temp['beat_name']=ucfirst(strtolower($data_uncovered_outlet_list[$i]->beat_name));
                 if(isset($data_uncovered_outlet_list[$i]->feed_potential_status) && $data_uncovered_outlet_list[$i]->feed_potential_status  != "")
               {
                    $temp['potential_status']=$data_uncovered_outlet_list[$i]->feed_potential_status;             
                    $temp['potential_status_name']=$data_uncovered_outlet_list[$i]->feed_potential_status;
               }
               else
               {
                 $temp['potential_status']=(isset($data_uncovered_outlet_list[$i]->potential_status)) ? $data_uncovered_outlet_list[$i]->potential_status : '';             
                  $temp['potential_status_name']=(isset($data_uncovered_outlet_list[$i]->potential_status)) ? $data_uncovered_outlet_list[$i]->potential_status: '';
               }

               
               
              
                 $temp['beat_id']=ucfirst(strtolower($data_uncovered_outlet_list[$i]->beat_id));
                 $temp['image_count']=(isset($imagelist[$data_uncovered_outlet_list[$i]->refid])) ? $imagelist[$data_uncovered_outlet_list[$i]->refid]  : 0;
                $temp['icon']= ($data_uncovered_outlet_list[$i]->status=='N') ? $data_uncovered_outlet_list[$i]->maintype_icon : (($data_uncovered_outlet_list[$i]->status=='A') ? 'images/coveredblue.png' : (($data_uncovered_outlet_list[$i]->status=='E') ? 'images/existing.png' : 'images/nr.png')); 

              
               $temp['lat']=(isset($data_uncovered_outlet_list[$i]->lat)) ? $data_uncovered_outlet_list[$i]->lat : ''; 
               $temp['lon']=(isset($data_uncovered_outlet_list[$i]->lon)) ? $data_uncovered_outlet_list[$i]->lon : ''; 
               $temp['type']='uncovered';
               $temp['status']=$data_uncovered_outlet_list[$i]->status;
               $temp['jj_stock']='';$temp['jj_baby']='';$temp['competition_baby']='';$temp['potential_store']='';$temp['jj_female']='';$temp['jj_otc']='';$temp['competition_female']='';$temp['competition_facewash']='';$temp['competition_stock']='';$temp['potential_baby']='';$temp['potential_female']='';
               $temp['potential_otc']=''; $temp['potential_skincare']='';

              
                $temp['shop_image']=(isset($imagename[$data_uncovered_outlet_list[$i]->refid])) ?  $imagename[$data_uncovered_outlet_list[$i]->refid] : (isset($data_uncovered_outlet_list[$i]->shop_image) ? $data_uncovered_outlet_list[$i]->shop_image : '');

               if(isset($uncovered_info[$data_uncovered_outlet_list[$i]->refid]))
               {
                  $temp['feedback_result']=$uncovered_info[$data_uncovered_outlet_list[$i]->refid];
                  $res=reset($uncovered_info[$data_uncovered_outlet_list[$i]->refid]);
                 
                 
                  $temp['channel_id']=$res->channel_id;
                   $temp['freezer']=$res->freezer;


               }
 
 
               


               array_push($data['uncovered_result'],$temp);

          }
        }


         $data['channel_list']=[];

        $data['legend'] = [];
        if($type==9)
        {
           $result=array_merge($data['result'],$data['uncovered_result']);
           
           $data['mapdata'] =$result;
           $data['channel_list']=$channel_list; 
            $data['feedback_question']=$feedback_question;
           
         
        }
        else
        {
          $data['mapdata'] =$data['result'];

        }

        
        $data['griddata'] = array();

        $head='';
        if($type==9)
        $data['griddata'] = $this->gridcolumn_byoutletlist_bycategory($data['uncovered_result']);
   
      else if($user->client_id==86 || $user->client_id==120 || $user->client_id==115)
        if(isset($obj['filter_bycluster'])  && count($obj['filter_bycluster']) >0)
        {
           

           $data['griddata'] = $this->gridcolumn_byoutletlist_bycategory($data['result']);
          
           $head='Cluster '.implode(",",array_unique(array_column($data['result'],'cluster_id')));
        }
        else{

          $data['griddata'] = $this->gridcolumn_bycluster(array_values($cluster));  
        }
                
      else{
        echo 'tertre';die;
        $data['griddata'] = $this->gridcolumn_byoutletlist_bycategory($data['result']);
      }
        
     
        if($user->client_id!=86 && $user->client_id!=120 && $user->client_id!=0 )
           $head = CommonController::headline($loc12);
        

        $data['head'] = $head;
 
        return $data;


    }
     public function get_haldirams_data($maparray,$type,$main_location,$sub_location,$so_id,$input_obj,$current_location)
    {
       
//echo 'test'; die;
	   $input_query=json_decode($input_obj);
          $column=[];       $value_data=[];
       
        if(isset($input_query->cluster_id) && count($input_query->cluster_id) <= 0)
        {
                array_push($column, array(
                 'title' => '#', 'className' => 'text-left'
             ));
                 array_push($column, array(
                 'title' => 'Cluster ID', 'className' => 'text-left'
             ));

                  array_push($column, array(
                 'title' => 'No. of Outlets in Cluster', 'className' => 'text-right'
             ));
                    array_push($column, array(
                 'title' => 'High Potential Outlets Nos.', 'className' => 'text-left'
             ));
                      array_push($column, array(
                 'title' => 'Medium Potential Outlets Nos.', 'className' => 'text-left'
             ));
                        array_push($column, array(
                 'title' => 'Low Potential Outlets Nos.', 'className' => 'text-left'
             ));
        }
        else
        {
            
         
          array_push($column, array(
             'title' => 'Visit Order', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Retailer ID', 'className' => 'text-right'
         ));
           array_push($column, array(
             'title' => 'Name', 'className' => 'text-left'
         ));
          array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Sub Type', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Potential Status', 'className' => 'text-left'
         ));
            
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'Contact', 'className' => 'text-left'
         ));
         
            array_push($column, array(
             'title' => 'City', 'className' => 'text-left'
         ));
           array_push($column, array(
             'title' => 'Neighborhood', 'className' => 'text-left'
         ));
            
            array_push($column, array(
             'title' => 'Status', 'className' => 'text-left'
         ));
            
        }
      
        $user = auth()->user();
        $userid = $user->id;$legend=[];$head='';$uncovered_str='';
         $district_view=false;
        // if(isset($input_query->cluster_id) && (count($input_query->cluster_id) > 0)  )
        // {

        //  $uncovered_str .=" and a.cluster_id in (".implode(',',$input_query->cluster_id).")"; 
             
        // }
         if(isset($input_query->filter_bychannel) && (count($input_query->filter_bychannel) > 0)  )
        {

         $uncovered_str .=" and a.type  in ('".join("','",$input_query->filter_bychannel)."')"; 
             
        }
         if(isset($input_query->filter_bysubchannel) && (count($input_query->filter_bysubchannel) > 0)  )
        {

         $uncovered_str .=" and a.sub_type in ('".join("','",$input_query->filter_bysubchannel)."')";
             
        }
        if(isset($input_query->filter_bypotential) && (count($input_query->filter_bypotential) > 0)  )
        {

         $uncovered_str .=" and a.fld1923 in ('".join("','",$input_query->filter_bypotential)."')";
             
        }
     if(isset($input_query->filter_beat) && (count($input_query->filter_beat) > 0)  )
        {

         $uncovered_str .=" and a.beat_id in (".implode(',',$input_query->filter_beat).")";
             
        }
        
         if(isset($input_query->filter_bydistrict) && (count($input_query->filter_bydistrict) > 0)  )
        {
            $district_view=true;
         $uncovered_str .=" and a.loc9 in ('".join("','",$input_query->filter_bydistrict)."')";
             
        }
        if(isset($input_query->filter_bytaluk) && (count($input_query->filter_bytaluk) > 0)  )
        {

         $uncovered_str .=" and a.loc10 in ('".join("','",$input_query->filter_bytaluk)."')";
             
        }
         if(isset($input_query->filter_bystatus) && (count($input_query->filter_bystatus) > 0)  )
        {

        $uncovered_str .=" and a.status in ('".join("','",$input_query->filter_bystatus)."')";
             
        }
		//auth()->user()->id
		$table=array(1000=>'haldirams_sample_data_new',150=>'maamis_uncovered_outlets');
		$str="";
      //if(auth()->user()->client_id==150)
     // {
         // $str= " and user_id=".auth()->user()->id."";
     // }
     $sql="SELECT a.loc7,a.loc9,a.loc10,a.refid as retailer_id,a.State,a.District,a.Taluk,a.Sector,a.nbrhd_name as nbhrd,a.CCP_Name as retailer_name,a.address,a.latitude,a.longitude,a.Contact as contact,a.Prirotity,a.icon,a.shop_image,a.status,a.stock_chocolate,a.stock_confectionary,a.assigned_to,a.user_id,a.user_lat,a.user_lon,a.created_date,a.type,a.sub_type,a.pincode as beat_name,a.beat_id,a.fld1923,a.city_id,a.city,a.potential_status,0 cluster_id,a.contact_no,a.remark,a.stat,'' as cluster_size,0 as visit_order,'' as catgry,'' as store_status,if(a.status='A','Found',if(a.status='NF','Not Found',if(a.status='C','Store Closed','New'))) as outlet_status,if(a.fld1923=1,'Low',if(a.fld1923=2,'Medium',if(a.fld1923=3,'High',''))) as outlet_potential FROM ".$table[$user->client_id]." as a left join (SELECT `refid`, `outlet_id`, `user_id`, `outlet_image`, `created_date`, `status`, `client_id` from jj_outlet_image where client_id=".$user->client_id." and status='A') as b on a.refid=b.outlet_id where stat='A'  ".$str."  ".$uncovered_str."";

        $res = DB::select(DB::raw($sql));
        $res=CommonController::getarray($res);

       
        $head=[];$retailer_list=[];
      
        $total_outlets=count($res);
        $data_outlet_imagelist =  DB::table('jj_outlet_image')      
               ->where([['user_id','=',$userid],['status','=','A']])               
               ->select('outlet_id', DB::raw('count(*) as total,outlet_image'))
               ->groupBy('outlet_id')
               ->get();

           $imagelist=[];$imagename=[];
           $c=count($data_outlet_imagelist);
          for($i=0;$i<$c;$i++)
          {
             $imagelist[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->total;
             $imagename[$data_outlet_imagelist[$i]->outlet_id]=$data_outlet_imagelist[$i]->outlet_image;
          }
          $cluster_list=[];
        
        for($s=0;$s<$total_outlets;$s++)
        {
           if(!in_array($res[$s]['cluster_id'],$head))
           {

             array_push($head,$res[$s]['cluster_id']);
             $cluster_list[$res[$s]['cluster_id']]=[];
             $cluster_list[$res[$s]['cluster_id']]=[1=>0,2=>0,3=>0,'cluster'=>0];
           }
           if(isset($cluster_list[$res[$s]['cluster_id']]))
             $cluster_list[$res[$s]['cluster_id']]['cluster']++;
           if(isset($cluster_list[$res[$s]['cluster_id']][$res[$s]['fld1923']]))
            $cluster_list[$res[$s]['cluster_id']][$res[$s]['fld1923']]++;
         if(isset($input_query->cluster_id) && count($input_query->cluster_id) >0) 
             {  
                if($district_view)
                    $res[$s]['loc10']=0;
                else
                    $res[$s]['loc9']=0;

                //haldrim_filter(\'\',\''+value['sub_type']+'\',\'\',\''+value['cluster']+'\')
                $val_data=array($res[$s]['visit_order'],$res[$s]['retailer_id'],'<a href="#" style="text-decoration:underline" onClick="highlight('.$res[$s]['retailer_id'].','.$res[$s]['latitude'].','.$res[$s]['longitude'].')">'.$res[$s]['retailer_name'].'</a>', '<a href="#" style="text-decoration:underline" onClick="haldiram_filter(\''.$res[$s]['type'].'\',\'\',\'\',\''.$res[$s]['loc9'].'\',\''.$res[$s]['loc10'].'\')">'.$res[$s]['type'].'</a>','<a href="#" style="text-decoration:underline" id="'.$res[$s]['sub_type'].'"  onClick="haldiram_filter(\'\',\''.$res[$s]['sub_type'].'\',\'\',\''.$res[$s]['loc9'].'\',\''.$res[$s]['loc10'].'\')">'.$res[$s]['sub_type'].'</a>','<a href="#" style="text-decoration:underline"  onClick="haldiram_filter(\'\',\'\',\''.$res[$s]['fld1923'].'\',\''.$res[$s]['loc9'].'\',\''.$res[$s]['loc10'].'\')">'.$res[$s]['outlet_potential'].'</a>',$res[$s]['address'],$res[$s]['contact'],$res[$s]['city'],$res[$s]['nbhrd'],$res[$s]['outlet_status']);

             array_push($value_data,$val_data);
         }
                $temp=[];
                $temp['retailer_id']=$res[$s]['retailer_id'];
                $temp['refid']=$res[$s]['retailer_id'];
                $temp['beat_id']=$res[$s]['beat_id'];  
                $temp['beat_name']=$res[$s]['beat_name'];  
             if(isset($input_query->cluster_id) && (count($input_query->cluster_id) <= 0)  )
             {
                 $temp['cluster_id']=$res[$s]['cluster_id'];  
             }
               $temp['cluster']=$res[$s]['cluster_id'];  
                 $temp['outlet_potential']=$res[$s]['outlet_potential'];
                 $temp['potential']=$res[$s]['fld1923'];
                  $temp['visit_order']=$res[$s]['visit_order'];
                  $temp['contact']=$res[$s]['contact'];
                   $temp['nbhrd']=$res[$s]['nbhrd'];
                  $temp['city']=$res[$s]['city'];
                $temp['name']=$res[$s]['retailer_name']; 
                $temp['address']=$res[$s]['address'];
                $temp['type']=$res[$s]['type'];
                $temp['icon']=$res[$s]['icon'];
                $temp['shop_image']=$res[$s]['shop_image'];
                $temp['sub_type']=$res[$s]['sub_type'];
                $temp['latitude']=$res[$s]['latitude'];
                $temp['longitude']=$res[$s]['longitude'];
                $temp['status']=$res[$s]['status'];
                $temp['potential_status']=$res[$s]['potential_status'];
                $temp['shareinfo']='Outlet ID:'.$res[$s]['retailer_id'].'Outlet Name '.$res[$s]['retailer_name'].'Address:'.$res[$s]['address'];
                $temp['style_code']='';
                if($res[$s]['fld1923']==3)
                  $temp['style_code']='background-color:#51c82c';
                if($res[$s]['fld1923']==2)
                  $temp['style_code']='background-color:#ed8102';
                if($res[$s]['fld1923']==1)
                  $temp['style_code']='background-color:#bf1414';

              if($res[$s]['status']=='A')
                $temp['icon']='images/uncovered.png';
              if($res[$s]['status']=='NF' || $res[$s]['status']=='C')
                $temp['icon']='images/nr.png';
              $temp['cicle_count']=(isset($imagelist[$res[$s]['retailer_id']])) ? $imagelist[$res[$s]['retailer_id']] : 0;
            array_push($retailer_list,$temp);
        }
 if(isset($input_query->cluster_id) && count($input_query->cluster_id) <=0){
    $count=1;
      foreach($cluster_list as $k=>$v)
        {

          
               $val_data=array(($count),'<a href="#" style="text-decoration:underline" onClick="getmaker('.$k.')">Cluster '.$k.'</a>', $v['cluster'],$v[3],$v[2],$v[1]);
               array_push($value_data,$val_data);
           $count++;
        }
 }
       
        
        $data=[];

        $data['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );  

        $data['legend']=[];$data['head']=[];
        array_push($data['legend'],array('Covered'=>'#DADD21','Uncovered'=>'#DD7921'));
         $data['mapdata']=$retailer_list;
        
      
        $data['maplist']=[];    
        $data['retailer_list']=$retailer_list;
        $data['head']=$res[0]['District'].' Distt.';
        // if(count($head)> 0)
        //       $data['head']=(strlen('Cluster ' .implode(", ",$head)) > 10) ? 'Cluster '.$head[0].'...' : 'Cluster '.  implode(", ",$head);
       
        $data['result']=$retailer_list;
     
        
         return $data;
    }
     public function adani_data($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {
        
         $data = [];$getdetail=[];
         $color=['green','yellow'];
        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
        $getfilter=json_decode($input_obj);
       
        $orwhere=[];
        if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
            array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_district).")");
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            array_push($orwhere,"  a.taluk_census in (".implode(",",$getfilter->filter_taluk).")");
         if(isset($getfilter->filter_byward) && count($getfilter->filter_byward)>0)
         {
            $sql="SELECT a.refid,a.loc7,a.loc9,a.loc10,a.loc15,a.`set1`, a.`geo_district` as geo_dist_name, a.`geo_dist_desc`, a.`geo_taluk`, a.`geo_taluk_desc`,a.`city`, `city_desc`, `city_desc_1`, `id`, a.`latitude`, a.`longitude`, `loc14`, `city_villg_name`, a.`loc15`, a.`nbrhd_name`, a.`status`, a.`district_code`, a.`taluk_code` as taluk_census, a.loc15 `town_villg_code`,a.`loc15` as village_census, a.`dist_code`, a.`bi_taluk_code`, a.`bi_state`, a.`bi_dist` as bi_distt, a.`bi_subdistt`, a.`bi_sector`, a.`bi_town_villg_name`, a.`found_taluk_name` as taluk_name, a.`found_district_name`,a.stat,a.`rpi`, a.`rpi_name` as rpi_, a.`population`, a.`fmcg_universe`,if(a.rpi=2,'D',if(a.rpi=1,'MD',if(a.rpi=3,'T',if(a.rpi=4,'UD',if(a.rpi=5,'NR',if(a.rpi=6,'NR-U','')))))) as rpi_img ,if(a.rpi=2,'D',if(a.rpi=1,'MD',if(a.rpi=3,'T',if(a.rpi=4,'UD',if(a.rpi=5,'NR',if(a.rpi=6,'NR-U','')))))) as rpi_name   FROM `ahmadabad_gandhinagar_nbrhd_mapping` as a,ward_master as b  where a.loc15=b.refid and a.loc12=13941 and a.stat='A' and b.stat='A'";
         }
         else
         {


         $str ='';
          if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
        

        $sql="SELECT a.`refid`,a.`loc7`, a.`loc9`, a.`loc10`, `geo_dist_name`, `geo_dist_desc`, `geo_taluk`, `geo_taluk_desc`, a.`city`, `city_desc`, `city_desc_1`, a.`district_code`, a.`taluk_census`, a.`town_villg_code`,`town_villg_code` as village_census, `bi_state`, `bi_distt`, a.`taluk_name`, `bi_sector`, `bi_town_villg_name`, a.`stat`,b.latitude,b.longitude,a.`rpi`, a.`rpi_name` as rpi_, a.`population`, a.`fmcg_universe`,if(a.rpi=2,'D',if(a.rpi=1,'MD',if(a.rpi=3,'T',if(a.rpi=4,'UD',if(a.rpi=5,'NR',if(a.rpi=6,'NR-U','')))))) as rpi_img ,if(a.rpi=2,'D',if(a.rpi=1,'MD',if(a.rpi=3,'T',if(a.rpi=4,'UD',if(a.rpi=5,'NR',if(a.rpi=6,'NR-U','')))))) as rpi_name FROM `adani_shape_data` as a,town_village_polygon as b  where a.town_villg_code=b.town_village_code and a.taluk_census=b.taluk_code ".$str." and a.stat='A' and b.stat='A'  ";
         }
          

         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);
          
          $final_result=[];
          $inc=0;
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'bi_distt');
          $district_name=array_unique($district_name);
          $city_name=array_column($result,'city_villg_name');
          $city_name=array_unique($city_name);
          $table_data=[];
         
      
         $result_count=count($result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            array_push($table_data,$result[$k]);
            $temp=$result[$k];
            $temp['color']='#000';
            $temp['sector_name']='';
             $temp['size']=0;

            if($result[$k]['bi_sector']=='Rural')
            {
                 $temp['sector_name']='Village';
                 $temp['color']='#01855b';
                  $temp['size']=6;
            }
            if($result[$k]['bi_sector']=='Urban')
            {
                 $temp['sector_name']='City';
                 $temp['color']='#373782'; 
                  $temp['size']=8;
            }
             $label='';
             $legend="";
             $temp['shareinfo']='Village: '.$result[$k]['bi_town_villg_name'].'; Taluk: '.$result[$k]['taluk_name'].'; Distt: '.$result[$k]['bi_distt'].'; State: '.$result[$k]['bi_state'].';Geo District: '.$result[$k]['geo_dist_name'].';Geo Distt. Description: '.$result[$k]['geo_dist_desc'].'; Geo Taluk: '.$result[$k]['geo_taluk'].'; Geo Taluk. Description: '.$result[$k]['geo_taluk_desc'].'; City: '.$result[$k]['city'].'; City Description: '.$result[$k]['city_desc'].'; BI Sector:'.$result[$k]['bi_sector'].';';
             $rural_img=($result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$result[$k]['rpi_img'].'.jpg"></img>';
          if(isset($maparray[$result[$k]['town_villg_code']]))  
             $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$result[$k]['town_villg_code']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[$k]['latitude'].'" lon="'.$result[$k]['longitude'].'" id="share_'.$result[$k]['town_villg_code'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$result[$k]['latitude'].','.$result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$result[$k]['town_villg_code'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$result[$k]['taluk_name'].' Sub-Distt</span><br><span style="line-height:1rem;">'.$result[$k]['bi_distt'].' Distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Population (2023): </span>'.number_format($result[$k]['population'],0).' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;"> Rural Progressive Index: </span>'.$rural_img.' </p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">BI Sector: </span>'.$result[$k]['bi_sector'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Geo District:</span> '.$result[$k]['geo_dist_name'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Geo Distt. Description: </span>'.$result[$k]['geo_dist_desc'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Geo Taluk: </span>'.$result[$k]['geo_taluk'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Geo Taluk Description: </span>'.$result[$k]['geo_taluk_desc'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$temp['sector_name'].': </span>'.$result[$k]['city'].'</p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">'.$temp['sector_name'].' Description: </span>'.$result[$k]['city_desc'].'</p></div>';

        if(isset($maparray[$result[$k]['town_villg_code']]))
            $maparray[$result[$k]['town_villg_code']]=array_merge($maparray[$result[$k]['town_villg_code']],$temp);

            
         
         }

        $data['legend']=[];
        $data['legend'][0] = '';
        $data['griddata'] = $this->getsubrd_adani($table_data);
       
        
        $data['mapdata'] = $maparray;
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            $data['head']=implode(", ", $taluk_name). ' Sub-distt';
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
             $data['head']=implode(", ", $district_name). ' Distt';
          else if(isset($getfilter->filter_byward) && count($getfilter->filter_byward)>0)
             $data['head']=implode(", ", $city_name). ' City';
         else
             $data['head']='';

        return $data;

    }
     public function getsubrd_adani($data)
    {
        $column=[];
        $value=[];
       
      
          array_push($column, array(
             'title' => '#', 'className' => 'text-left','data'=>'s_no'
         ));

          array_push($column, array(
             'title' => 'Distt. Name', 'className' => 'text-left','data'=>'district_name'
         ));
           array_push($column, array(
             'title' => 'Sub-Distt. Name', 'className' => 'text-left','data'=>'taluk_name'
         ));
            array_push($column, array(
             'title' => 'Town / Village Name', 'className' => 'text-left','data'=>'village_name'
         ));
            
               array_push($column, array(
             'title' => 'Geo District', 'className' => 'text-left','data'=>'geo_distt'
         ));
                array_push($column, array(
             'title' => 'Geo Distt. Description', 'className' => 'text-left','data'=>'geo_distt_desc'
         ));
                 array_push($column, array(
             'title' => 'Geo Taluk', 'className' => 'text-left','data'=>'geo_taluk'
         ));
                array_push($column, array(
             'title' => 'Geo Taluk Description', 'className' => 'text-left','data'=>'geo_taluk_desc'
         ));
                   array_push($column, array(
             'title' => 'Population', 'className' => 'text-right','data'=>'population'
         ));
                      array_push($column, array(
             'title' => 'Fmcg Retailer Univrs', 'className' => 'text-right','data'=>'fmcg_retailer'
         ));
                         array_push($column, array(
             'title' => 'Rural Progressive Index', 'className' => 'text-left','data'=>'rpi'
         ));
        
  $s=1;
        for($i=0;$i<count($data);$i++)
        {
             $data[$i]['village_census']=ltrim($data[$i]['village_census'], 0);
             // var_dump($data[$i]);die;
            $temp=array(
                
                's_no'=>($s),
               
                'district_name'=> $data[$i]['bi_distt'],
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['town_villg_code'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['bi_town_villg_name'] . '</a>',
               
                 'geo_distt'=> $data[$i]['geo_dist_name'],
                  'geo_distt_desc'=> $data[$i]['geo_dist_desc'],
                   'geo_taluk'=> $data[$i]['geo_taluk'],
                    'geo_taluk_desc'=> $data[$i]['geo_taluk_desc'],
                    'population'=> number_format($data[$i]['population'],0),
                   'fmcg_retailer'=> number_format($data[$i]['fmcg_universe'],0),
                    'rpi'=> $data[$i]['rpi_']
                 
                


            );
           
            $s++;
       //  'child'=>$data[$i]['child_d']
            array_push($value,$temp);
   
          

        }
            
            return array(
            'column' => $column,
            'value' => $value
        );

    }
     public function zerorla_subrd($maparray, $type, $main_location, $sub_location,$input_obj,$current_location)
    {
        $tbllist=[120=>'tsi_subrd_data'];
        $consmtp=[120=>'Villg. Choc Consmptn'];
        $subrd_name=[120=>[0=>'Spoke Reco',1=>'Reco Villg.']];
         $data = [];$getdetail=[];
         $color=['green','red','lavender','pink','orange','fgreen','chaani'];
         $user = auth()->user();
        $userid = $user->id;

        $data['result'] = array();
        $data['mapdata'] = array();
        $key = array_keys($maparray);
        $value = array_values($maparray);
        $getfilter=json_decode($input_obj);
       
        $summary_count=[];
        
        $summary_count['Develpd']=0;
        $summary_count['Most Develpd']=0;
        $summary_count['Under-develpd']=0;
        $summary_count['Transition']=0;
        $summary_count['Not Rated']=0;
        $summary_count['total_village']=0;
        $summary_count['new_village']=0;
        $summary_count['show_summary']=0;
        $summary_count['new_village_current']=0;
        $summary_count['new_village_recommand']=0;
        $type_view=[1,2];
    
        $orwhere=[];
        if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
            array_push($orwhere,"  a.loc9 in (".implode(",",$getfilter->filter_district).")");
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            array_push($orwhere,"  a.taluk_census in (".implode(",",$getfilter->filter_taluk).")");

        $str ='';
        if(count($orwhere)>0)
            $str=" and (".join(" or ",$orwhere).") ";
       
        if(isset($getfilter->filter_priority) && $getfilter->filter_priority!='')
             $str .=' and a.subrd_priority="'.$getfilter->filter_priority.'"';
        if(isset($getfilter->filter_existsubrd) && $getfilter->filter_existsubrd!='')
             $str .=' and a.exist_subrd_code="'.$getfilter->filter_existsubrd.'"';
         
        


 $sql="SELECT  b.state_code,a.`refid`, a.`cluster_id`, a.`cluster_name`, a.`state_name`, a.`district_name`, a.`taluk_name`, a.`village_name`, a.`sector`, a.`loc7`, a.`loc9`, a.`loc10`, a.`loc13`, a.`loc12`, a.`market_id`, a.`bi_id`, a.`distance_subrd`, a.`subrd_loaction`, a.`outlet_potential`, a.`population`, a.`taluk_census`, a.`village_census`, a.village_choc_consmptn, a.`cluster_tag`, a.`stat`, a.`subrd_type`, a.`is_hub`, a.`hub_id`, a.`subrd_priority`,a.active_stat, a.`tsm_id`, a.`village_2011_census`, a.`company_service_id`,a.retlr_universe,a.mdlz_retlr_universe,a.exist_subrd_code,a.exist_subrd_name,if(a.company_service_id=1,'Active',if(a.company_service_id=2,'Initd',if(a.company_service_id=3,'Inactive',if(a.company_service_id=4,'Activtd',if(a.company_service_id=5,'Deactivtd',''))))) company_servcng,b.latitude,b.longitude,a.rpi,a.active_stat,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD','')) as rpi_name,if(a.rpi_id=2,'D',if(a.rpi_id=1,'MD',if(a.rpi_id=3,'T',if(a.rpi_id=4,'UD',if(a.rpi_id=5,'NR',if(a.rpi_id=6,'NR-U','')))))) as rpi_img,a.tsi_uid,a.tsi_code,a.tsi_name,a.avg_monthly_sale FROM ".$tbllist[$user->client_id]." as a,town_village_polygon as b  where a.village_census=b.town_village_code and a.taluk_census=b.taluk_code   ".$str."  and b.stat='A' ";


         $result = DB::select(DB::raw($sql));
         $result=CommonController::getarray($result);
          
          $final_result=[];
          $inc=0;
          $taluk_name=array_column($result,'taluk_name');
          $taluk_name=array_unique($taluk_name);
          $district_name=array_column($result,'district_name');
          $district_name=array_unique($district_name);
           $state_code=array_column($result,'state_code');
          $state_code=array_unique($state_code);
          $table_data=[];
          $priority=['Priority 1'=>'rural_icon/r_p1.png','Priority 2'=>'rural_icon/r_p2.png','Priority 3'=>'rural_icon/r_p3.png',''=>'rural_icon/recommendation.png'];
          $without_hub=$result;
          $non_cluster_color=[];
          $child_list=[];



         
         for($i=0;$i<count($result);$i++)
         {
            if($result[$i]['is_hub']==1 && in_array($result[$i]['subrd_type'],$type_view))
             {
                  
                  $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                  $final_result[$inc]['child']=[];
                  $filter_id=$result[$i]['cluster_id'];

                                 
                  $final_result[$inc]['subrd_marker']=($result[$i]['subrd_type']==1) ?  'rural_icon/mdlz_subrd_purple.png' :  (($result[$i]['subrd_type']==2) ? $priority[$result[$i]['subrd_priority']] : (($result[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';
                    $hub_child_list = array_filter($result, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] == $filter_id && $var['is_hub'] != 1);
                   });
                    $without_hub = array_filter($without_hub, function ($var) use ($filter_id) {
                         return ($var['cluster_id'] != $filter_id);
                   });

                              
                  $final_result[$inc]['child']=$hub_child_list; 
                  $res_arr=$result[$i];
                  $child_list[$filter_id]=$hub_child_list;

                  $res_arr['child']=htmlspecialchars(json_encode([$hub_child_list]), ENT_QUOTES, 'UTF-8');
                  $res_arr['child_count']=count($hub_child_list);
                    $res_arr['child_d']=$hub_child_list;
                  
                 $inc++;
               
                }
                  
             }
             else if($result[$i]['subrd_type'] ==0 || !in_array($result[$i]['subrd_type'],$type_view))
             {
                $result[$i]['village_census']=ltrim($result[$i]['village_census'], 0);
                if(isset($maparray[$result[$i]['village_census']]))
                {
                    $final_result[$inc]=$result[$i];
                    $final_result[$inc]['child']=[];
                     $final_result[$inc]['child_d']=[];
                    $final_result[$inc]['subrd_marker']='NA';
                     $child_list[$result[$i]['cluster_id']]=[];
                    $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$result[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$result[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
             }
         }
         $without_hub=array_values($without_hub);
         $without_hub_count=count($without_hub);
      
         for($i=0;$i<$without_hub_count;$i++)
         {
      
              $without_hub[$i]['village_census']=ltrim($without_hub[$i]['village_census'], 0);

                if(isset($maparray[$without_hub[$i]['village_census']]))
                {
                    if($without_hub[$i]['subrd_type']==1 && $without_hub[$i]['active_stat'] =='No')
                        $summary_count['new_village_current']++;
                     if($without_hub[$i]['subrd_type']==2)
                        $summary_count['new_village_recommand']++;
                       
                     if(in_array($without_hub[$i]['subrd_type'],[1,2,3]))   
                     {
                        if(in_array($without_hub[$i]['subrd_type'],[2,3]) && in_array($without_hub[$i]['subrd_type'],$type_view))   
                            $summary_count['show_summary']=$without_hub[$i]['subrd_type']; 
                     
                        
                     }  
                       
                  
                    $final_result[$inc]=$without_hub[$i];
                    $final_result[$inc]['child']=[];
                    $final_result[$inc]['subrd_marker']=($without_hub[$i]['subrd_type']==1) ?  'rural_icon/efficient-subrd.png' :  (($without_hub[$i]['subrd_type']==2) ? $priority[$without_hub[$i]['subrd_priority']] : (($without_hub[$i]['subrd_type']==3) ? 'rural_icon/Wholesaler.png' :'NA'));
                  $final_result[$inc]['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$without_hub[$i]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$without_hub[$i]['cluster_name'].'</li></ul> </div></div></div>';                           
                    $inc++;
                   
                }
         }
      
         $result_count=count($final_result);

         $temp=[];
         for($k=0;$k<$result_count;$k++)
         {
            $temp=$final_result[$k];
           if($temp['subrd_type']==1 && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                if($temp['subrd_loaction']=='Existing Urban Distbtr Hub' || $temp['subrd_loaction']=='Existing Urban Distbtr')
                    $split_color='lblue';
                else
                    $split_color='grey';
            }
           else if(($temp['subrd_type']==2) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
              $range=array_rand(range(0,(count($color)-1)));
              $split_color=$color[$range];
           }
           else if(($temp['subrd_type']==3) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
           {
                 $split_color='fgreen';
           }

           else if($temp['subrd_type']==0)
              $split_color='none';
           else
              $split_color='none';
            if(in_array($temp['subrd_type'],[2,3]) && $temp['is_hub']==1 && in_array($temp['subrd_type'],$type_view))
            {
                $summary_count['total_village']++;   
                if( $summary_count['show_summary']=='')           
                $summary_count['show_summary']=$temp['subrd_type'];
            }

            unset($temp['child']);
            
             
            if($temp['is_hub'] != 1 && $temp['subrd_type']!=0)
             {
                $hub='#ffffff';$child='';
                // if(($temp['active_stat']=='Yes' || $temp['active_stat']=='') && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                //           $hub= CommonController::getcolor_bysubrd('l_grey');
                // if($temp['active_stat']=='No'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                     $hub= CommonController::getcolor_bysubrd('d_grey');
                // if($temp['subrd_loaction']=='Existing Urban Distbtr'  && ($temp['subrd_type']==1) && in_array($temp['subrd_type'],$type_view))
                //            $hub= CommonController::getcolor_bysubrd('l_lblue'); 
               //  if((($temp['subrd_type']==2) || ($temp['subrd_type']==3)) && in_array($temp['subrd_type'],$type_view))
               // {
               //    if(isset($non_cluster_color[$temp['cluster_name']]) && $temp['subrd_type'] !=3)
               //              $hub= CommonController::getcolor_bysubrd('l_'.$non_cluster_color[$temp['cluster_name']]); 
               //    else if($temp['subrd_type'] !=3){

               //       $range=array_rand(range(0,(count($color)-1)));
               //       $split_color=$color[$range];
               //       $hub= CommonController::getcolor_bysubrd('l_'.$split_color); 
               //       $non_cluster_color[$temp['cluster_name']]=$split_color;
               //    }
               //    else if($temp['subrd_type'] ==3)
               //    {
               //        $hub= CommonController::getcolor_bysubrd('l_fgreen');
               //    }
                 
               // }
            }             
             else
                $hub= CommonController::getcolor_bysubrd('d_'.$split_color); 
             $label='';
             $legend="";
             $temp['color']=$hub; 

              $cluster_type=(isset($subrd_name[$user->client_id])) ? $subrd_name[$user->client_id][0] : $final_result[$k]['subrd_loaction'];
              if($user->client_id==1000)
               $cluster_type=$final_result[$k]['subrd_loaction'];
             
             $final_result[$k]['activate_status']=$final_result[$k]['company_service_id'];
             $cluster_tag=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'SubRD Existing' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommended' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $cluster_hub=($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Existing SubRD' :(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'Recommd SubRD' :(($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ?'Wholesaler' : ''));
             $temp['activate_marker']=($final_result[$k]['company_service_id']==1) ? 'rural_icon/active.png' : (($final_result[$k]['company_service_id']==2) ? 'rural_icon/initiated.png' : (($final_result[$k]['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($final_result[$k]['company_service_id']==4) ? 'rural_icon/activated.png' :(($final_result[$k]['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             if($temp['is_hub']!=0)
            {
                $temp['subrd_status']=(in_array($final_result[$k]['subrd_type'],$type_view)) ? $final_result[$k]['subrd_type'] : 0;
               $temp['subrd_marker']=(($final_result[$k]['subrd_type']==2 && in_array($final_result[$k]['subrd_type'],$type_view)) ? $priority[$final_result[$k]['subrd_priority']] :   (($final_result[$k]['subrd_type']==1 && $temp['subrd_loaction']=='Existing Urban Distbtr Hub' && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/urban-distributor.png' :  (($final_result[$k]['subrd_type']==1 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/mdlz_subrd_purple.png' : (($final_result[$k]['subrd_type']==3 && in_array($final_result[$k]['subrd_type'],$type_view)) ? 'rural_icon/Wholesale.png' : ''))));
             $temp['subrd_tooltip']='<div class="tooltip-data"><div class="card"><div class="card-header"><h3>'.$maparray[$final_result[$k]['village_census']]['location_name'].'</h3></div><ul class="list-group list-group-flush"><li class="list-group-item">'.$cluster_tag.'</li></ul> </div></div></div>';
            }
            else
            {
                 $temp['subrd_status']=0;
                 $temp['subrd_marker']='NA';             
                 $temp['subrd_tooltip']='';
            }


             // 
if($final_result[$k]['subrd_type']!=0 && in_array($final_result[$k]['subrd_type'],$type_view))
{
$temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.; '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].';SubRD Priority: '.$final_result[$k]['subrd_priority'].'; SubRD Cluster Priority: '.$final_result[$k]['subrd_priority'].'; ';

 // $final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? number_format($final_result[$k]['village_choc_consmptn'],0) : $final_result[$k]['village_choc_consmptn'];
$final_result[$k]['village_choc_consmptn']=($final_result[$k]['village_choc_consmptn']!='') ? $final_result[$k]['village_choc_consmptn'] : 0;
 $final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);


            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Current Sub-Distributor</span> </p>';
         
         
            $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
          
            

         
          if(in_array($final_result[$k]['subrd_type'],[1]) &&  $user->client_id==120)
              $temp['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">TSI UID: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['tsi_uid'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">TSI Code: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['tsi_code'])).' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">TSI Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['tsi_name'])).' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$final_result[$k]['market_id'].'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span><span style="background-color:white;color:black;">'.$final_result[$k]['avg_monthly_sale'].'</span></p>';
          
          

            $final_result[$k]['population']=number_format($final_result[$k]['population'],0);
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
            $final_result[$k]['cluster_type']=$cluster_type;
$detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');
             $temp['info'] .='</div>';
       
            
}
 else
             {
                $final_result[$k]['population']=is_numeric($final_result[$k]['population'])  ? $final_result[$k]['population']  :0;
$final_result[$k]['village_choc_consmptn']=is_numeric($final_result[$k]['village_choc_consmptn']) ? number_format($final_result[$k]['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$final_result[$k]['village_choc_consmptn']),0);
 $temp['shareinfo']='Village: '.$final_result[$k]['village_name'].'; Taluk: '.$final_result[$k]['taluk_name'].'; Distt: '.$final_result[$k]['district_name'].'; State: '.$final_result[$k]['state_name'].';Population: '.$final_result[$k]['population'].' Nos.; Rural Progressive Index: '.$final_result[$k]['rpi'].'; Outlet Potential: '.$final_result[$k]['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$final_result[$k]['village_choc_consmptn'].'; Market UID: '.$final_result[$k]['market_id'].'; BI Location ID: '.$final_result[$k]['bi_id'].'; ';
                 $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$final_result[$k]['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex float-right" style="height:max-content;"><img class="ml-1" style="cursor:pointer;"  src="icons/share-icon.png" height="30px" onclick="share(\''.$temp['shareinfo'].'\',this)"  lat="'.$result[0]['latitude'].'" lon="'.$result[0]['longitude'].'" id="share_'.$final_result[$k]['village_census'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$final_result[$k]['latitude'].','.$final_result[$k]['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$final_result[$k]['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$final_result[$k]['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$final_result[$k]['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Villg. with Zero RLA (Inactive) </p>';
        
                
               
          $rural_img=($final_result[$k]['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$final_result[$k]['rpi_img'].'.jpg"></img>';
         
         
       
            $final_result[$k]['village_name']=$maparray[$final_result[$k]['village_census']]['location_name'];
          $detail=htmlspecialchars(json_encode([$final_result[$k]]), ENT_QUOTES, 'UTF-8');

           
             }
           
             $temp['size']=0;
             $temp['activate_status_icon']=$temp['activate_marker'];
             $temp['activate_status']=$final_result[$k]['activate_status'];
            
            $maparray[$final_result[$k]['village_census']]=array_merge($maparray[$final_result[$k]['village_census']],$temp);

            $temp2=[];
            
            foreach($final_result[$k]['child'] as $key=>$value)
            {
                  array_push($table_data,$value);
                 $temp2=$value;
                 if($value['subrd_type']==1 && $value['active_stat'] =='No')
                    $summary_count['new_village_current']++;
                 if($value['subrd_type']==2)
                    $summary_count['new_village_recommand']++;
                 if(in_array($value['subrd_type'],[2,3])){
                     $summary_count['new_village']++;

                   if(isset($summary_count[$value['rpi']]))
                            $summary_count[$value['rpi']]++;
                 }
                    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                 if($value['subrd_type']==1)    
                 {
                       // if($value['active_stat']=='Yes')
                       //    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                       // if($value['active_stat']=='No')
                           $temp2['color']= CommonController::getcolor_bysubrd('d_red');                      
                 }             
                 // else                 
                 //    $temp2['color']= CommonController::getcolor_bysubrd('l_'.$split_color);
                
                 // $cluster_type=(isset($subrd_name[$user->client_id])) ? $subrd_name[$user->client_id][1] : $value['subrd_loaction'];
                 $cluster_type=$value['subrd_loaction'];
                 $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommended' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                  $cluster_hub=($value['subrd_type']==1) ? 'Existing SubRD' :(($value['subrd_type']==2) ? 'Recommd SubRD' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
                   $value['village_census']=ltrim($value['village_census'], 0);
                  if(isset($maparray[$value['village_census']]))
                {
                   
                    $value['village_choc_consmptn']=($value['village_choc_consmptn']!='') ?  $value['village_choc_consmptn'] : 0;
                     $value['village_choc_consmptn']=is_numeric($value['village_choc_consmptn']) ? number_format($value['village_choc_consmptn'],0)  : number_format((int)str_replace(",","",$value['village_choc_consmptn']),0);
                     $value['cluster_type']=$cluster_type;
$temp2['shareinfo']='Village: '.$value['village_name'].'; Taluk: '.$value['taluk_name'].'; Distt: '.$value['district_name'].'; State: '.$value['state_name'].';Recommendation: '.$cluster_type.';Distance from '.$cluster_hub.' (km): 0 kms; Population: '.$value['population'].' Nos.; Rural Progressive Index: '.$value['rpi'].'; Outlet Potential: '.$value['outlet_potential'].' Nos.;  '.$consmtp[$user->client_id].' (Annual) (Rs.): '.$value['village_choc_consmptn'].'; Market UID: '.$value['market_id'].'; BI Location ID: '.$value['bi_id'].';SubRD Priority: '.$value['subrd_priority'].'; SubRD Cluster Priority: '.$value['subrd_priority'].'; ';

                       $temp2['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$maparray[$value['village_census']]['location_name'].' &nbsp;</h5><div class="d-flex" style="height:max-content;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\''.$temp2['shareinfo'].'\',this)"  lat="'.$value['latitude'].'" lon="'.$value['longitude'].'" id="share_'.$value['village_census'].'" ><img class="ml-1" style="cursor:pointer;" geocode="'.$value['latitude'].','.$value['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup " style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$value['village_census'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$value['taluk_name'].' sub-distt</span><br><span style="line-height:1rem;">'.$value['district_name'].' distt</span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;text-decoration:underline;">Villg. with Zero RLA (Inactive)</span> </p>';
          
                $rural_img=($value['rpi_img'] == '') ? '' : '<img src="rural_icon/'.$value['rpi_img'].'.jpg"></img>';
            
         
        
         if(in_array($value['subrd_type'],[1]) && $user->client_id==120)  
              $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Code: </span><span style="background-color:white;color:black;" >'.$final_result[$k]['exist_subrd_code'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">SubRD Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($final_result[$k]['exist_subrd_name'])).' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">TSI UID: </span><span style="background-color:white;color:black;" >'.$value['tsi_uid'].' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">TSI Code: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($value['tsi_code'])).' </span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">TSI Name: </span><span style="background-color:white;color:black;" >'.ucwords(strtolower($value['tsi_name'])).' </span></p>';
               $temp2['info'] .='<p><span style="color:rgb(242, 101, 34);font-weight:bold;">Market UID: </span><span style="background-color:white;color:black;">'.$value['market_id'].'</span></p><p><span style="color:rgb(242, 101, 34);font-weight:bold;">Avg. SubRD Sales (Rs.) (Last 6 mnths): </span><span style="background-color:white;color:black;">'.$value['avg_monthly_sale'].'</span></p>';
          
          
            
           $value['population']= number_format($value['population'],0);
            $value['village_name']=$maparray[$value['village_census']]['location_name'];
            $child_val=[0=>$value];
                  $value_json=htmlspecialchars(json_encode($child_val), ENT_QUOTES, 'UTF-8');
             $temp2['info'] .='</div>';
             
             $value['activate_status']=$value['company_service_id'];
             $cluster_tag=($value['subrd_type']==1) ? 'Existing' :(($value['subrd_type']==2) ? 'Recommanded' :(($value['subrd_type']==3) ?'Wholesaler' : ''));
             $value['activate_marker']=($value['company_service_id']==1) ? 'rural_icon/active.png' : (($value['company_service_id']==2) ? 'rural_icon/initiated.png' : (($value['company_service_id']==3) ? 'rural_icon/deactivated.png' :(($value['company_service_id']==4) ? 'rural_icon/activated.png' :(($value['company_service_id']==5) ? 'rural_icon/deactivated.png'  : 'NA'))));
            
             $temp2['size']=8;
             $temp2['activate_status_icon']=$value['activate_marker'];
             $temp2['activate_status']=$value['activate_status'];
             $temp2['subrd_status']=0;
             $temp2['subrd_marker']='NA';             
             $temp2['subrd_tooltip']='';
             // $temp2['village_census']=ltrim($value['village_census'],0);
           
            $maparray[$value['village_census']]=array_merge($maparray[$value['village_census']],$temp2);
                }

             

            }
         
         }

        $data['legend']=[];
        $data['legend'][0] = $summary_count;
        if($user->client_id==133)
             $data['griddata'] = $this->getsubrd_pepsi($table_data);
        else
        $data['griddata'] = $this->getsubrd_rla($table_data);
        $data['child_list']=$child_list;
        $data['mapdata'] = $maparray;
        if(isset($getfilter->filter_taluk) && count($getfilter->filter_taluk)>0)
            $data['head']=implode(", ", $taluk_name). ' sub-distt, '.implode(", ", $district_name);
        else if(isset($getfilter->filter_district) && count($getfilter->filter_district)>0)
             $data['head']=implode(", ", $district_name). ' distt, '.implode(", ", $state_code);
         else
             $data['head']='';

        return $data;

    }
    

/*public function get_clusterid(Request $request)
{
    // 1. Build or capture the request filter payload
    if ($request->has('input_obj')) {
        $raw_input = $request->input('input_obj');
        $decoded = is_string($raw_input) ? json_decode($raw_input, true) : $raw_input;
    } else {
        $decoded = [
            'type'               => 12,
            'filter_pc'          => [],
            'filter_distributor' => [],
            'filter_so'          => [],
            'filter_beat'        => [],
            'filter_district'    => [],
            'type_view'          => '1,2,5,3',
            'cluster_id'         => $request->cluster_id ? trim($request->cluster_id) : null
        ];
    }

    // Capture target cluster BEFORE passing to engine
    $target_cluster = null;
    if (isset($decoded['cluster_id']) && trim($decoded['cluster_id']) !== '') {
        $target_cluster = trim($decoded['cluster_id']);
        $decoded['cluster_id'] = trim($decoded['cluster_id']);
    } else {
        $decoded['cluster_id'] = null;
    }

    $input_obj_json = json_encode($decoded);

    // 2. Identify the dynamic client data source table
    $user = auth()->user();
    $tbllist = [
        120  => 'subrd_data',
        123  => 'subrd_data_perfetti',
        112  => 'coke_subrd_data_all',
        133  => 'subrd_data',
        1000 => 'subrd_data_haldiram',
        9999 => 'subrd_data_mars'
    ];
    $tableName = $tbllist[$user->client_id] ?? 'subrd_data';

    // 3. BUILD FULL MAPARRAY + CENSUS-TO-CLUSTER LOOKUP
    $query = \DB::table($tableName)->select('village_census', 'village_name', 'cluster_id');

    if (!empty($decoded['filter_district'])) {
        try { $query->whereIn('loc9', $decoded['filter_district']); } catch (\Exception $e) {}
    }
    if (!empty($decoded['filter_taluk'])) {
        try { $query->whereIn('taluk_census', $decoded['filter_taluk']); } catch (\Exception $e) {}
    }

    $townCodes = $query->get();


    // Add right after $townCodes = $query->get();
    $sampleTown = $townCodes->first();
   // \Log::info('SAMPLE DB ROW:', [
      //  'village_census' => $sampleTown->village_census ?? null,
     //   'cluster_id'     => $sampleTown->cluster_id ?? null,
    //    'village_name'   => $sampleTown->village_name ?? null,
   // ]);

    // Also log target cluster villages specifically
    $matchingSample = $townCodes->where('cluster_id', $target_cluster)->first();
  //  \Log::info('MATCHING CLUSTER ROW:', (array)$matchingSample);
  //  \Log::info('TARGET CLUSTER VALUE:', [$target_cluster]);
  //  \Log::info('TOTAL TOWN CODES:', [$townCodes->count()]);

    $maparray          = [];
    $censusClusterMap  = []; // DB-based lookup: censusCode → cluster_id

    foreach ($townCodes as $town) {
        $cleanCensusCode = ltrim($town->village_census, '0');
        if (empty($cleanCensusCode)) {
            $cleanCensusCode = $town->village_census;
        }

        $maparray[$cleanCensusCode] = [
            'location_name' => $town->village_name,
            'cluster_id'    => $town->cluster_id
        ];

        // Store raw DB cluster_id keyed by clean census code
        $censusClusterMap[$cleanCensusCode] = (string)$town->cluster_id;
    }

    // 4. Fire the primary engine calculation function
    $result = $this->Combine_subrd($maparray, '', '', '', $input_obj_json, '');

    if (is_object($result)) {
        $result = (array) $result;
    }

    // 5. COLOR MASK using DB census lookup (engine overwrites cluster_id to 0, so we bypass it)
     // 5. COLOR MASK using DB census lookup
 if (!empty($target_cluster) && isset($result['mapdata']) && is_array($result['mapdata'])) {

    $matchCount = 0;
    $missCount  = 0;

    foreach ($result['mapdata'] as $censusCode => $villageData) {

        // Lookup cluster from DB mapping
        $mapCluster = $censusClusterMap[$censusCode] ?? null;

        // Handle values like 634464_504899377
        $baseCluster = $mapCluster ? explode('_', $mapCluster)[0] : null;

           $isMatch = (
        $baseCluster !== null &&
        trim((string)$baseCluster) === trim((string)$target_cluster)
    );

        if ($isMatch) {

            $matchCount++;

            // Keep original styling for selected cluster
            continue;
        }

        $missCount++;

        // Make all other clusters WHITE
        $result['mapdata'][$censusCode]['color']       = '#ffffff';
        $result['mapdata'][$censusCode]['fillColor']   = '#ffffff';
        $result['mapdata'][$censusCode]['fillOpacity'] = 1;
        $result['mapdata'][$censusCode]['opacity']     = 1;
        $result['mapdata'][$censusCode]['weight']      = 0;

        // Remove tooltip / click actions
        $result['mapdata'][$censusCode]['info']           = '';
        $result['mapdata'][$censusCode]['subrd_tooltip'] = '';
        $result['mapdata'][$censusCode]['shareinfo']     = '';
        $result['mapdata'][$censusCode]['clickable']     = false;

        if (
            isset($result['mapdata'][$censusCode]['child']) &&
            is_array($result['mapdata'][$censusCode]['child'])
        ) {
            $result['mapdata'][$censusCode]['child'] = [];
        }
    }

    \Log::info('CLUSTER FILTER RESULT', [
        'target_cluster' => $target_cluster,
        'matched'        => $matchCount,
        'whited_out'     => $missCount,
        'total'          => $matchCount + $missCount
    ]);
 }

    // 6. Gather table rows
    $griddata = $result['griddata'] ?? null;
    if (isset($result['result']) && count($result['result']) > 0) {
        $tableDataRows = $result['result'];
    } elseif (isset($griddata['value']) && count($griddata['value']) > 0) {
        $tableDataRows = $griddata['value'];
    } else {
        $tableDataRows = [];
    }

    // 7. Child list parser
    $childList = [];

    if (isset($result['child_list']) && is_array($result['child_list'])) {
        foreach ($result['child_list'] as $cid => $cdata) {
            $childList[(string)$cid] = is_string($cdata) ? json_decode($cdata, true) : $cdata;
        }
    }

    foreach ($tableDataRows as $row) {
        $rowArr       = (array)$row;
        $cId          = $rowArr['cluster_id'] ?? ($rowArr['cluster_name'] ?? ($rowArr['id'] ?? null));
        $rawChildData = $rowArr['child_d']    ?? ($rowArr['child_list'] ?? null);

        if (!$cId && isset($rowArr[1])) {
            $cId = strip_tags($rowArr[1]);
            $cId = trim(str_replace('Cluster', '', $cId));
        }

        if ($cId && $rawChildData) {
            $stringKey = (string)$cId;
            if (is_string($rawChildData)) {
                $decodedChild      = json_decode($rawChildData, true);
                $childList[$stringKey] = (json_last_error() === JSON_ERROR_NONE) ? $decodedChild : $rawChildData;
            } else {
                $childList[$stringKey] = $rawChildData;
            }
        }
    }
       \Log::info($result['legend']);
            // 8. FILTER LEGEND ALSO FOR SELECTED CLUSTER
      // 8. FILTER LEGEND
    if (!empty($target_cluster) && isset($result['legend']) && is_array($result['legend'])) {

        $filteredLegend = [];

        foreach ($result['legend'] as $legendKey => $legendValue) {

            if (is_array($legendValue)) {

                $legendColor = strtolower(
                    $legendValue['color']
                    ?? $legendValue['fillColor']
                    ?? ''
                );

                if (
                    $legendColor !== '#ffffff' && 
                    $legendColor !== 'white' &&
                    $legendColor !== '#fff'
                ) {
                    $filteredLegend[$legendKey] = $legendValue;
                }
            } else {
                $filteredLegend[$legendKey] = $legendValue;
            }
        }

        $result['legend'] = $filteredLegend;
    }
    return response()->json([
        'status'     => true,
        'mapdata'    => $result['mapdata'] ?? null,
        'legend'     => $result['legend'] ?? [],
        'griddata'   => [
            'column' => $griddata['column'] ?? [],
            'value'  => $tableDataRows
        ],
        'child_list' => (object)$childList
    ]);
}*/

public function get_clusterid(Request $request)
{
    // 1. Build or capture the request filter payload
    if ($request->has('input_obj')) {
        $raw_input = $request->input('input_obj');
        $decoded = is_string($raw_input) ? json_decode($raw_input, true) : $raw_input;
    } else {
        $decoded = [
            'type'               => 12,
            'filter_pc'          => [],
            'filter_distributor' => [],
            'filter_so'          => [],
            'filter_beat'        => [],
            'filter_district'    => [],
            'type_view'          => '1,2,5,3',
            'cluster_id'         => $request->cluster_id ? trim($request->cluster_id) : null
        ];
    }

    // Capture target cluster BEFORE encoding
    $target_cluster = null;
    if (
        isset($decoded['cluster_id']) &&
        trim((string)$decoded['cluster_id']) !== '' &&
        $decoded['cluster_id'] !== 'undefined' &&
        $decoded['cluster_id'] !== 'null'
    ) {
        $target_cluster = trim((string)$decoded['cluster_id']);
        $decoded['cluster_id'] = $target_cluster; // ✅ keep it correctly in decoded
    } else {
        $decoded['cluster_id'] = null;
        $target_cluster = null;
    }

    // Encode AFTER cluster_id is correctly set
    $input_obj_json = json_encode($decoded);

  //  \Log::info('GET_CLUSTERID input_obj_json: ' . $input_obj_json);
  //  \Log::info('GET_CLUSTERID target_cluster: ' . ($target_cluster ?? 'NULL'));

    // 2. Identify the dynamic client data source table
    $user = auth()->user();
    $tbllist = [
        120  => 'subrd_data',
        123  => 'subrd_data_perfetti',
        112  => 'coke_subrd_data_all',
        133  => 'subrd_data',
        1000 => 'subrd_data_haldiram',
        9999 => 'subrd_data_mars'
    ];
    $tableName = $tbllist[$user->client_id] ?? 'subrd_data';

    // 3. BUILD FULL MAPARRAY + CENSUS-TO-CLUSTER LOOKUP
    $query = \DB::table($tableName)->select('village_census', 'village_name', 'cluster_id');

    if (!empty($decoded['filter_district'])) {
        try { $query->whereIn('loc9', $decoded['filter_district']); } catch (\Exception $e) {}
    }
    if (!empty($decoded['filter_taluk'])) {
        try { $query->whereIn('taluk_census', $decoded['filter_taluk']); } catch (\Exception $e) {}
    }

    $townCodes = $query->get();

    $maparray         = [];
    $censusClusterMap = [];

    foreach ($townCodes as $town) {
        $cleanCensusCode = ltrim($town->village_census, '0');
        if (empty($cleanCensusCode)) {
            $cleanCensusCode = $town->village_census;
        }

        $maparray[$cleanCensusCode] = [
            'location_name' => $town->village_name,
            'cluster_id'    => $town->cluster_id
        ];

        $censusClusterMap[$cleanCensusCode] = (string)$town->cluster_id;
    }

    // 4. Fire the primary engine calculation function
    if ($user->client_id == 120) {
        $result = $this->Combine_subrd_mdlz($maparray, '', '', '', $input_obj_json, '');
    } else {
        $result = $this->Combine_subrd($maparray, '', '', '', $input_obj_json, '');
    }

    if (is_object($result)) {
        $result = (array) $result;
    }

    // 5. COLOR MASK using DB census lookup
    if (!empty($target_cluster) && isset($result['mapdata']) && is_array($result['mapdata'])) {

        foreach ($result['mapdata'] as $censusCode => &$villageData) {

            $mapCluster  = $censusClusterMap[$censusCode] ?? '';
            $baseCluster = explode('_', (string)$mapCluster)[0];

            $isMatch = (
                !empty($baseCluster) &&
                trim($baseCluster) === trim((string)$target_cluster)
            );

            if ($isMatch) {
                continue;
            }

            $villageData['color']                = '#ffffff';
            $villageData['fillColor']            = '#ffffff';
            $villageData['fillOpacity']          = 1;
            $villageData['opacity']              = 1;
            $villageData['weight']               = 1;
            $villageData['strokeColor']          = '#ffffff';
            $villageData['subrd_marker']         = 'NA';
            $villageData['activate_marker']      = 'NA';
            $villageData['activate_status_icon'] = 'NA';
            $villageData['subrd_status']         = 0;
            $villageData['subrd_tooltip']        = '';
            $villageData['markers']              = [];
        }

        unset($villageData);
    }

    // 6. Gather table rows
    $griddata = $result['griddata'] ?? null;
    if (isset($result['result']) && count($result['result']) > 0) {
        $tableDataRows = $result['result'];
    } elseif (isset($griddata['value']) && count($griddata['value']) > 0) {
        $tableDataRows = $griddata['value'];
    } else {
        $tableDataRows = [];
    }

    // 7. Child list parser
    $childList = [];

    if (isset($result['child_list']) && is_array($result['child_list'])) {
        foreach ($result['child_list'] as $cid => $cdata) {
            $childList[(string)$cid] = is_string($cdata) ? json_decode($cdata, true) : $cdata;
        }
    }

    foreach ($tableDataRows as $row) {
        $rowArr       = (array)$row;
        $cId          = $rowArr['cluster_id'] ?? ($rowArr['cluster_name'] ?? ($rowArr['id'] ?? null));
        $rawChildData = $rowArr['child_d']    ?? ($rowArr['child_list'] ?? null);

        if (!$cId && isset($rowArr[1])) {
            $cId = strip_tags($rowArr[1]);
            $cId = trim(str_replace('Cluster', '', $cId));
        }

        if ($cId && $rawChildData) {
            $stringKey = (string)$cId;
            if (is_string($rawChildData)) {
                $decodedChild          = json_decode($rawChildData, true);
                $childList[$stringKey] = (json_last_error() === JSON_ERROR_NONE) ? $decodedChild : $rawChildData;
            } else {
                $childList[$stringKey] = $rawChildData;
            }
        }
    }

    \Log::info($result['legend']);

    // 8. FILTER LEGEND
    if (!empty($target_cluster) && isset($result['legend']) && is_array($result['legend'])) {

        $filteredLegend = [];

        foreach ($result['legend'] as $legendKey => $legendValue) {
            if (is_array($legendValue)) {
                $legendColor = strtolower(
                    $legendValue['color']
                    ?? $legendValue['fillColor']
                    ?? ''
                );
                if (
                    $legendColor !== '#ffffff' &&
                    $legendColor !== 'white' &&
                    $legendColor !== '#fff'
                ) {
                    $filteredLegend[$legendKey] = $legendValue;
                }
            } else {
                $filteredLegend[$legendKey] = $legendValue;
            }
        }

        $result['legend'] = $filteredLegend;
    }

    return response()->json([
        'status'     => true,
        'mapdata'    => $result['mapdata'] ?? null,
        'legend'     => $result['legend']  ?? [],
        'griddata'   => [
            'column' => $griddata['column'] ?? [],
            'value'  => $tableDataRows
        ],
        'child_list' => (object)$childList
    ]);
}

   public function getsubrdfeeder($data,$type=0)
    {

        $column=[];
        $value=[];
         $user=auth()->user();
       //  \Log::info('feeder type get subrd: ' . $type);

        $consmtp=[120=>'Villg. Choc Consumption',123=>'Confectionery Consmptn',112=>'Confectionery Consmptn',133=>'Snacks Consmptn',1000=>'Choc Consmption',9999=>'Confectionery Consumption']; //change 25-02-2026
      
          array_push($column, array(
             'title' => '#', 'className' => 'dt-control','data'=>'s_no'
         ));

           

          array_push($column, array(
             'title' => 'SubRD Cluster ID', 'className' => 'text-left','data'=>'cluster_name'
         ));
        
          array_push($column, array(
             'title' => 'Distt', 'className' => 'text-left','data'=>'district_name'
         ));
           array_push($column, array(
             'title' => 'Sub-distt', 'className' => 'text-left','data'=>'taluk_name'
         ));
            array_push($column, array(
             'title' => 'Town / Villg', 'className' => 'text-left','data'=>'village_name'
         ));
             if($user->client_id==120)
            array_push($column, array(
             'title' => 'Market UID', 'className' => 'text-right','data'=>'market_id'
         ));
            array_push($column, array(
             'title' => 'Distance from <br> Recmmd SubRD Locatn (km)', 'className' => 'text-right','data'=>'distance_subrd'
         ));
            if($user->client_id!=9999)
             array_push($column, array(
             'title' => 'Outlet Potential (Nos.)', 'className' => 'text-right','data'=>'outlet_otential'
         ));
             array_push($column, array(
             'title' => 'Popn (Nos.)', 'className' => 'text-right','data'=>'population'
         ));
             if(($user->client_id==120 && $type==0) )
            array_push($column, array(
             'title' => 'Avg. SubRD Sales (Rs.) (Last 6 mnths)', 'className' => 'text-right','data'=>'avg_monthly_sale'
         ));
               if($user->client_id!=112  && $user->client_id!=9999)
              array_push($column, array(
             'title' => $consmtp[$user->client_id].' (Annual) (Rs.)',  'className' => 'text-right','data'=>'village_choc_consmptn'
         ));
           if($user->id==13285)
              array_push($column, array(
                 'title' => 'Catgry Shr (%)',  'className' => 'text-right','data'=>'catgry_shr'
             ));
          
        
       $wholesaleIcon="";
        for($i=0;$i<count($data);$i++)
        {
                
             $data[$i]['village_census']=ltrim($data[$i]['village_census'], 0);
             
             $detail=htmlspecialchars(json_encode([$data[$i]]), ENT_QUOTES, 'UTF-8');

             $count_of_subrd=(in_array($data[$i]['subrd_type'],[1,3])) ? $data[$i]['child_count'] : '';
            

        if($user->client_id==123 || $user->client_id==112 || $user->client_id==133) 
            
        $temp=array('s_no'=>($i+1),
                'cluster_name'=>'Cluster '.$data[$i]['cluster_id'].' ',
             //  'cluster_name'=>'<a href="#" id="'.$data[$i]['cluster_id'].'"style="text-decoration:underline"onClick="filterCluster(this.id)">Cluster '.$data[$i]['cluster_id'].'</a>',


                'district_name'=>'<a href="#"  id="'.$data[$i]['child'].'" class="getchild_'.($i+1).'">'. $data[$i]['district_name'] .'</a>',
                 'taluk_name'=>$data[$i]['taluk_name'],
                 'village_name'=>'<a href="#" id="' . $data[$i]['village_census'] . '" style="text-decoration:underline" onClick="showbound(this)">' . $data[$i]['village_name'] . '</a>',
                // '<a href="#" style="text-decoration:underline;" onClick="view_village_detail('.$detail.')">'.$data[$i]['village_name'].'</a>',
                
                  'distance_subrd'=>round($data[$i]['distance_subrd'],2),
                  'outlet_otential'=>$data[$i]['outlet_potential'],
                  'population'=>number_format($data[$i]['population'],0),
                   'village_choc_consmptn'=>number_format($data[$i]['village_choc_consmptn'],0), //change 25-02-2026
                  
                  'cluster_tag'=>$data[$i]['cluster_tag'].' SubRD Hub',
                  'exist_subrd_code'=>'<a href="#" id="' . $data[$i]['exist_subrd_code'] . '" district="'.$data[$i]['loc9'].'" taluk="'.$data[$i]['taluk_census'].'" subrd_type="' . $data[$i]['subrd_type'] . '" style="text-decoration:underline" onClick="show_existsubrd(this)">' . $data[$i]['exist_subrd_code'] . '</a>',
                  'exist_subrd_name'=>$data[$i]['exist_subrd_name'],
                  'subrd_count'=> $count_of_subrd,
                  'child'=>$data[$i]['child_d']);
            array_push($value,$temp);

        }
            
            return array(
            'column' => $column,
            'value' => $value
        );



    }
    
  // ADD THIS HELPER FUNCTION INSIDE CONTROLLER
private function buildVillageMarkers(&$temp, $subrd_marker, $activate_marker)
{
    // Old compatibility
    $temp['subrd_marker'] = $subrd_marker;
    $temp['activate_status_icon'] = $activate_marker;

    // New multiple icon support
    $temp['markers'] = [];

    // Add SubRD / Distributor icon
    if (!empty($subrd_marker) && $subrd_marker != 'NA') {
        $temp['markers'][] = [
            'type' => 'subrd',
            'icon' => $subrd_marker
        ];
    }

    // Add Active / Initiated / Deactivated icon
    if (!empty($activate_marker) && $activate_marker != 'NA') {
        $temp['markers'][] = [
            'type' => 'status',
            'icon' => $activate_marker
        ];
    }

    return $temp;
}
}

