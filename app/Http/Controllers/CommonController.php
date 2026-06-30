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
use App\Http\Controllers\ProfileController;

use App\User;
use DB;

class CommonController extends Controller
{
    public function index()
    {

        $stat = auth()->user()->status;
        $user = auth()->user();
        $userid=$user->id;
        $packageid=$user->package_id;
        $contents = Storage::get('client_menu/client_menu_'.$userid.'.json');

        if($stat == 'Active') {
        	return view('pages.dashboard',['menulist'=>$contents,'package_id'=>$packageid]);
        } else {
        	return Redirect::to('/auth/login')->with('message',"Get approval from Admin Team from BrandIdea !!! Thank You");
        }
        
    }
    public function show()
    {
    	
    }

    public function commonactivity($maparray,$maplabel,$type,$main_location,$sub_location,$input_obj,$so_id,$current_location) // 1- universe 2- chemist 3- status $type param

    {
      
       
        $message=array(); 
      
        if($main_location!=0)
        {
        $geo_level = DB::table('Geo_Hrchy_master')->where('refid', $sub_location)->select(['geo_level','name1','name2','master_table'])->first();
        $geo_level_main = DB::table('Geo_Hrchy_master')->where('refid', $main_location)->select(['geo_level','name1','name2','master_table'])->first();        
        $location_level_master= $geo_level->master_table;  
        }    
        $controllername='CombineController';
        $namespace = "App\Http\Controllers\\";
        $controllerName = $namespace . $controllername;          
        $obj = new $controllerName();
        $input_object=json_decode($input_obj);
        $user = auth()->user();
      // \Log::info($type);
        if($type==3)
           $result_json=$obj->showlayerinfo($maparray,$type,$main_location,$sub_location,$so_id);
          
        else if($type==4)
           $result_json=$obj->show_added_outletlist($maparray,$type,$main_location,$sub_location,$so_id);
         else if(in_array($type,[5,6,7,8,9,10,11]) && ($user->client_id!=1000 && $user->client_id!=150))
           $result_json=$obj->show_outletlist_bycategory($maparray,$type,$main_location,$sub_location,$so_id,$input_obj,$current_location); 
        else if(in_array($type,[11]) && ($user->client_id==1000 || $user->client_id==150))
          $result_json=$obj->get_haldirams_data($maparray,$type,$main_location,$sub_location,$so_id,$input_obj,$current_location); 
        else if(in_array($type,[0]))
           $result_json=$obj->biapp_activity($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
        else if(in_array($type,[26]))
           $result_json=$obj->zerorla_subrd($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
        else if(in_array($type,[12,13]) && $user->client_id!=240)
        {
         if(in_array($type,[12,6,7,8]) && $user->client_id==133 && $user->id!=13289)
              //\Log::info($type);
             $result_json=$obj->combine_subrd_pepsi($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
             
             //$result_json=$obj->Combine_subrd($maparray,$type,$main_location,$sub_location,$input_obj,$current_location); // enable pepsi subrd recomentation
         else if($user->id==13289 && $user->login_type_mdlz!= 'Rural/Urban')   
            $result_json=$obj->Distributor_whitespace($maparray,$type,$main_location,$sub_location,$input_obj,$current_location); 
             
           //$result_json=$obj->combine_subrd_pepsi($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
         else if($user->id==13289 && $user->login_type_mdlz == 'Rural/Urban')   
          // $result_json=$obj->Distributor_whitespace($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);  login_type_mdlz
           $result_json=$obj->combine_subrd_pepsi($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
         else if($user->id==13285) // demo
              $result_json=$obj->demo_combine_subrd($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
          else if($user->client_id==120) // mdlz
            $result_json=$obj->Combine_subrd_mdlz($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);        
         else
              $result_json=$obj->combine_subrd($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
             //\Log::info($type);
        }
       else if(in_array($type,[12]) && $user->client_id==240)
           $result_json=$obj->adani_data($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
        else if(in_array($type,[25]))
           $result_json=$obj->get_village_details($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
        else if(in_array($type,[28]))
           $result_json=$obj->combine_consolidate_subrd($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);

        // else if(in_array($type,[12]) && $user->id==11789)
        //    $result_json=$obj->combine_subrd_($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
        else if(in_array($type,[20]) && isset($input_object->filter_village))
            $result_json=$obj->village_subrd($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
        else if(in_array($type,[20]) && isset($input_object->filter_country))
           $result_json=$obj->country_subrd($maparray,$type,$main_location,$sub_location,$input_obj,$current_location);
                      
        else
           $result_json=$obj->combine($maparray,$type,$main_location,$sub_location,$input_obj,$so_id);

       $message['mapdata']=$result_json['mapdata'];
        if(isset($result_json['griddata']))
            $message['griddata']=$result_json['griddata'];    
         if(isset($result_json['icon_data']))
            $message['icon_data']=$result_json['icon_data'];  
              if(isset($result_json['village_subrd']))
            $message['village_subrd']=$result_json['village_subrd'];     
              if(isset($result_json['child_list']))
            $message['child_list']=$result_json['child_list'];      
            
       
       $message['head']=$result_json['head'];
       $message['maplegend']=$result_json['legend'];
       if(isset($result_json['channel_list']))
            $message['channel_list']=$result_json['channel_list'];
           if(isset($result_json['feedback_question']))
            $message['feedback_question']=$result_json['feedback_question'];


        return $message;


    }
     public static function index_color_variaton($range)
    {
       $index=[];
     

       $index['Most Premium']=array('hex'=>'#01875B','from_1'=>'rgb(1, 133, 91)','to_1'=>'rgb(1, 228, 156)','from_2'=>'rgb(1, 228, 156)','to_2'=>'rgb(1, 228, 156)');
       $index['Premium']=array('hex'=>'#dfcf06','from_1'=>'rgb(223, 207, 6)','to_1'=>'rgb(249, 232, 6)','from_2'=>'rgb(249, 232, 6)','to_2'=>'rgb(252, 246, 156)');
       $index['Very High']=array('hex'=>'#852213','from_1'=>'rgb(133,34,19)','to_1'=>'rgb(191,98,84)','from_2'=>'rgb(191,98,84)','to_2'=>'rgb(221,144,143)');
       $index['High']=array('hex'=>'#852213','from_1'=>'rgb(133,34,19)','to_1'=>'rgb(191,98,84)','from_2'=>'rgb(191,98,84)','to_2'=>'rgb(221,144,143)');
       $index['Medium']=array('hex'=>'#ff7f02','from_1'=>'rgb(255, 127, 2)','to_1'=>'rgb(255, 179, 102)','from_2'=>'rgb(255, 179, 102)','to_2'=>'rgb(255, 206, 153)');
       $index['Low']=array('hex'=>'#ab0f13','from_1'=>'rgb(171, 15, 19)','to_1'=>'rgb(237, 44, 50)','from_2'=>'rgb(237, 44, 50)','to_2'=>'rgb(247, 161, 164)');
       return isset($index[$range]) ? $index[$range] : [];
       
    }
    public  function preaction_getdetails($details_param,$table_name,$maparray)
    {

      //


        $this->details['selected_location']=isset($details_param['loc_id']) ? $details_param['loc_id'] : $details_param['location'];
        $this->details['main_location']=$details_param['main_location'];
        $this->details['sub_location']=$details_param['sub_location'];
        $this->details['view_option']=1;
        $this->details['year']=[date('Y')];        
        $this->details['start_year']='';
        $this->details['end_year']='';
        $this->details['title_year']=[];

        // $this->details['view_menu']=(isset($details_param['combine_key'][0]['menu_id'])) ?  $details_param['combine_key'][0]['menu_id'] : $details_param['split_key'][0]['menu_id'];
        $this->details['calendar_type']=2;
        $this->details['period_type']=1;
        $this->details['view_master']=1;
        $viewlist=DB::table('bid_application_master.view_master')->where('refid',$this->details['view_master'])->select('view_name')->first();
        $this->details['view_name']=$viewlist->view_name;



      
        if(isset($details_param['calendar_data']) && isset($details_param['calendar_data']['calendar_type'])) 
        {
          
                $this->details['calendar_type']=$details_param['calendar_data']['calendar_type'];
                $this->details['period_type']=$details_param['calendar_data']['period_type'];
                $this->details['view_master']=$details_param['calendar_data']['view_master'];
                $viewlist=DB::table('bid_application_master.view_master')->where('refid',$details_param['calendar_data']['view_master'])->select('view_name')->first();
                $this->details['view_name']=$viewlist->view_name;

              if($this->details['calendar_type']==2)
               {

                    if(in_array($this->details['period_type'],[1,3]))
                    {
                        
                       sort($details_param['calendar_data']['year']);
                        $this->details['year']=$details_param['calendar_data']['year']; 
                    }
                     
                     if(in_array($this->details['period_type'],[2]))
                     {
                         $this->details['start_year']=$details_param['calendar_data']['start_year']; 
                         $this->details['end_year']=$details_param['calendar_data']['end_year']; 
                         $this->details['year']=range($this->details['start_year'],$this->details['end_year']);
                         
                     }
                     $this->details['title_year']=$this->details['year'];

               }
               if(in_array($this->details['calendar_type'],[4,6]))
               {
                   $this->details['year']=[];
                   
                   
                  
                    if(in_array($this->details['period_type'],[1,3])){
                        sort($details_param['calendar_data']['year']);
                        foreach($details_param['calendar_data']['year'] as $k=>$v)
                        {
                            $year=substr($v,0,4); 
                            $month=(int)(substr($v,4,2)); 
                            array_push($this->details['year'],$month.'_'.$year);
                            if($this->details['calendar_type']==4)
                            {
                                $monthname=CommonController::getmonthname($month);
                                 array_push($this->details['title_year'],$monthname.'_'.$year);
                            }
                            if($this->details['calendar_type']==6)
                            {
                                $quartername=CommonController::getquartername($month);
                                
                                array_push($this->details['title_year'],$quartername.'_'.$year);
                            }




                        }
                       
                    }
                     if(in_array($this->details['period_type'],[2]))
                     {
                         $this->details['start_year']=substr($details_param['calendar_data']['start_year'],0,4); 
                         $this->details['end_year']=substr($details_param['calendar_data']['end_year'],0,4);
                         $this->details['start_month']=(int)substr($details_param['calendar_data']['start_year'],4,2);
                         $this->details['end_month']=(int)substr($details_param['calendar_data']['end_year'],4,2);


                         if($this->details['start_year']==$this->details['end_year']) 
                         {
                             for($k=$this->details['start_month'];$k<=$this->details['end_month'];$k++)
                             {

                                  array_push($this->details['year'],$k.'_'.$this->details['start_year']);
                                  if($this->details['calendar_type']==4)
                                      $period_name=CommonController::getmonthname($k);
                                  if($this->details['calendar_type']==6)
                                       $period_name=CommonController::getquartername($k);
                                array_push($this->details['title_year'],$period_name.'_'.$this->details['start_year']);


                             }
                         }
                         if($this->details['start_year']!=$this->details['end_year']) 
                         {
                              if(in_array($this->details['calendar_type'],[4]))
                            $limit=($this->details['calendar_type']==4) ? 12 :($this->details['calendar_type']==6) ? 4 : 0;

                             for($k=$this->details['start_month'];$k<=$limit;$k++)
                             {
                                  array_push($this->details['year'],$k.'_'.$this->details['start_year']);
                                   if($this->details['calendar_type']==4)
                                      $period_name=CommonController::getmonthname($k);
                                  if($this->details['calendar_type']==6)
                                       $period_name=CommonController::getquartername($k);
                                   array_push($this->details['title_year'],$period_name.'_'.$this->details['start_year']);


                             }
                             for($k=1;$k<=$this->details['end_month'];$k++)
                             {
                                  array_push($this->details['year'],$k.'_'.$this->details['end_year']);
                                  if($this->details['calendar_type']==4)
                                      $period_name=CommonController::getmonthname($k);
                                  if($this->details['calendar_type']==6)
                                       $period_name=CommonController::getquartername($k);
                                   array_push($this->details['title_year'],$period_name.'_'.$this->details['end_year']);
                             }
                         }
                         
                     }
                     
                     
               }
              
          

        }
        $this->details['menulist_details']=$details_param["menu_list"];
        $this->details['menu_id']=array_unique(array_column($details_param["menu_list"], 'menu_id'));
        $this->details['level_id']=array_unique(array_column($details_param["menu_list"], 'level_id'));
        $this->details['view_optn']=array_unique(array_column($details_param["menu_list"], 'view_optn'));
        $this->details['parent_id']=array_unique(array_column($details_param["menu_list"], 'parent_id'));
        $this->details['maparray']=$maparray;
        $this->details['title']=[]; 
        $this->details['menutablelist']=[]; 
        $this->details['where_filter']=[]; 
        $this->details['cndn_value']=[];
        $this->details['get_menu']=[];
        $this->details['tbl']=$table_name;
        $this->details['period_result_type']=1;


        /* Year */  
        sort($this->details['year']);

        if(in_array($this->details['period_result_type'],[1,3])) //1-single period// 3-mixed period
        {           
           $this->details['past_year']=$this->details['year'][0];
           $this->details['present_year']=$this->details['year'][count($this->details['year'])-1];
        }
        if($this->details['period_result_type'] == 2) //continues period
        {
           $this->details['year']=range($this->details['year'][0],$this->details['year'][count($this->details['year'])-1]);
           //var_dump($this->details['year']);die;
           $this->details['past_year']=$this->details['year'][0];
           $this->details['present_year']=$this->details['year'][count($this->details['year'])-1];
           if($this->details['view_type'] == 4)
           {
             $this->details['growth_year']=[];
             $year_count=count($this->details['year']);
             for($n=0;$n<$year_count;$n++)
             {
                 if($n!=count($this->details['year'])-1)
                 array_push($this->details['growth_year'],array($this->details['year'][$n],$this->details['year'][$n+1]));
             }             
           }
        }
//var_dump($this->details['year']);die;
        /* Geo level */

        $main_menu=DB::table('menu_master')->where([['level_id','=',$this->details['level_id']],['menu_id','=',0],['menu_item_id','=',0]])->select(['menu_name'])->first();


         $view_name=DB::table('bid_application_master.view_master')->select(['view_name','flag'])->where('refid',1)->first();
         $this->details['view_details']=['view_name'=>$view_name->view_name,'flag'=>$view_name->flag];
        $geo_level = DB::table('bid_application_master.Geo_Hrchy_master')->whereIn('refid', [$this->details['main_location'],$this->details['sub_location']])->select(['refid','master_table'])->get()->keyBy('refid');
     
        $geotbl=$this->details['main_location'];
        $details_param['loc_id']=isset($details_param['loc_id']) ? $details_param['loc_id'] : $details_param['location'];
        $parent_location= DB::table($geo_level[$geotbl]->master_table)->where('refid', $details_param['loc_id'])->select(['location_name','refid'])->first();

        $this->details['location_level_master']= $geo_level[$this->details['sub_location']]->master_table;
        $master_count=explode(",",$this->details['location_level_master']);

        $menu_tbl=DB::table('bid_application_master.menu_object_master')->whereIn('refid', $this->details['menu_id'])->select(['refid','menu_name','table_name'])->get();

        $tbl_count=count($menu_tbl);


        for($i=0;$i<$tbl_count;$i++)
        {
            if(!in_array($menu_tbl[$i]->menu_name, $this->details['title']))
                    array_push($this->details['title'],trim($menu_tbl[$i]->menu_name," "));
            if(!in_array($menu_tbl[$i]->table_name,$this->details['menutablelist']))
                    array_push($this->details['menutablelist'],$menu_tbl[$i]->table_name);
            //if($menu_tbl[$i]->table_name==$table_name)
            //{
                $tbl_id=$menu_tbl[$i]->refid;  

                $this->details['cndn_value'] = array_map(function($item) use ($tbl_id) {

                    if($item['menu_id']==$tbl_id){

                      return (int)$item['menu_item_id'];
                    }
                }, $this->details['menulist_details']);


                $this->details['where_filter'][$tbl_id]=$this->details['cndn_value'];
                $this->details['get_menu'][$menu_tbl[$i]->table_name]=$this->details['cndn_value'];
               
          //  }
               
        }
        

        $this->details['cndn_value']=array_unique($this->details['cndn_value']);
        $this->details['title']=[];

        if(count($this->details['cndn_value']) > 0)
        {

            foreach ($this->details['get_menu'] as $key => $value) {
                $fetch_tbl='bid_application_master.'.$key;
                if(in_array($key,['sec']))
                    $fetch_tbl=$key;

                 $menu_result=DB::table($fetch_tbl)->select(['name'])->whereIn('refid', $value)->get()->toArray();
                 $menu_result = CommonController::getarray($menu_result);
                 $menu_column=array_column($menu_result, 'name');
                 $this->details['title']=array_merge($this->details['title'],$menu_column);               
            }
           
        }
        $title=[];
        foreach($this->details['title'] as $k=>$v)
        {
            array_push($title,trim($v," "));
        }

        $this->details['title']=$title;
        $sub_title='';
      
         $this->details['menu_axis']=join(", ",$this->details['title']);
         if($this->details['parent_id'][0]==186)
           {
            $this->details['title']=['Mdlz. vs Premium index'];
                $this->details['menu_axis']=$this->details['menu_axis'];
                $sub_title=' Mdlz. vs Premium index'; 
                
           } 
             if($this->details['parent_id'][0]==187)
           {
              $this->details['title']=['Mdlz. vs Snacking index'];
                $this->details['menu_axis']=$this->details['menu_axis'];
               $sub_title=' Biscuit Sales vs Snacking index';
           } 
            if($this->details['parent_id'][0]==21)
           {
              $this->details['title']=['Category Consmption'];
                $this->details['menu_axis']=$this->details['menu_axis'];
               $sub_title='Category Consmption';
           } 
            if($this->details['parent_id'][0]==1)
           {
              $this->details['title']=['SEC'];
                $this->details['menu_axis']=$this->details['menu_axis'];
               $sub_title='SEC';
           } 
         
         if($this->details['parent_id'][0]==81)
           {
             $this->details['title']=['Category Share'];
                $this->details['menu_axis']=$this->details['menu_axis'];
               $sub_title=' Category Share'; 
           } 
        if($this->details['parent_id'][0]==82)
           {
             $this->details['title']=['Numeric Distribution'];
                $this->details['menu_axis']=$this->details['menu_axis'];
               $sub_title=' Numeric Distribution'; 
           } 
        if($this->details['parent_id'][0]==113)
           {
            $this->details['title']=['Premium Sales penetratn'];
                $this->details['menu_axis']=$this->details['menu_axis'];
               $sub_title=' Premium Sales penetratn';  
           } 
            if($this->details['parent_id'][0]==68)
           {
                $this->details['menu_axis']=$this->details['menu_axis'].' - Per Capita Consumption';
                $this->details['title']=['Per Capita Consumption'];
                 $sub_title=' Per Capita Consumption';
           } 
             if($this->details['parent_id'][0]==202)
           {
                $this->details['menu_axis']=$this->details['menu_axis'].' - Per Capita Sales';
                $this->details['title']=['Per Capita Sales'];
                 $sub_title=' Per Capita Sales';
           } 
           if($this->details['parent_id'][0]==167)
           {
             $this->details['title']=['Dealers Per Lakh (DPL)'];
                $this->details['menu_axis']=$this->details['menu_axis'];
                 $sub_title=' - Dealers Per Lakh (DPL)';
               
           } 
            if($this->details['parent_id'][0]==126)
           {
            $this->details['title']=['ULB Nos'];
                $this->details['menu_axis']=$this->details['menu_axis'];
                 $sub_title=' Sale (ULB Nos.)';
                
           } 
            if($this->details['parent_id'][0]==171)
           {
             $this->details['title']=['VISI Deployment Reco (Uncovered Retailrs)'];
                $this->details['menu_axis']=$this->details['menu_axis'];
                 $sub_title=' VISI Deployment Reco (Uncovered Retailrs)';
               
           } 
            if($this->details['parent_id'][0]==179)
           {
            
            if($this->details['view_optn'][0]==1)
                 $sub_title=' VISI Deployment Reco (Uncovered Retailrs)';
            if($this->details['view_optn'][0]==2)
                 $sub_title=' VISI Deployment Reco (Covered Retailrs)';

             $this->details['title']=[$sub_title];
                $this->details['menu_axis']=$this->details['menu_axis'];
               
           } 
            if($this->details['parent_id'][0]==207)
           {
             $this->details['title']=['M Score'];
                $this->details['menu_axis']=$this->details['menu_axis'];
                 $sub_title=' M Score';
               
           }
            if($this->details['parent_id'][0]==215)
           {
             $this->details['title']=['Program Store WOA'];
                $this->details['menu_axis']=$this->details['menu_axis'];
                 $sub_title=' Program Store WOA';
               
           }
            if($this->details['parent_id'][0]==222)
           {
             $this->details['title']=['Program Store penetratn %'];
                $this->details['menu_axis']=$this->details['menu_axis'];
                 $sub_title=' Program Store penetratn %';
               
           }
           if($this->details['parent_id'][0]==237)
           {
             $this->details['title']=['VC penetratn %'];
                $this->details['menu_axis']=$this->details['menu_axis'];
                 $sub_title=' VC penetratn %';
               
           }
     
            $this->details['menu_axis']=ucwords(str_replace("_"," ",$this->details['menu_axis']));
      
        $subname='';$this->details['head']='';$this->details['loc_axis']='';
          $this->details['loc_axis']= $parent_location->location_name .' '.$details_param['subname'];

          $this->details['head']= $this->details['loc_axis'].': '.$this->details['menu_axis'].' - '.$sub_title.' - '.implode("-",$this->details['title_year']). ' - '.$this->details['view_name'] ;
       
        return $this->details;

    }
    public static function getlocwisegroup($data,$groupby) {     
        $groups = array();
        $index=0;
        foreach ($data as $item) {
            $key = $item[$groupby];
            if (!array_key_exists($key, $groups)) {
              $groups[$key]=[];
              
              $groups[$key]['loc_id']=(int)$item['loc_id'];
              if(isset($item['result']))
                 $groups[$key]['result']=(int)$item['result'];
              if(isset($item['location_type']))
                  $groups[$key]['location_type']=$item['location_type'];
              if(isset($item['total_hh']))
                  $groups[$key]['total_hh']=$item['total_hh'];
                 if(isset($item['percentage']))
                  $groups[$key]['percentage']=$item['percentage'];
                  


            } else {
                  if(isset($item['result']))
                  $groups[$key]['result']=$groups[$key]['result']+(int)$item['result'];  
                  if(isset($item['total_hh']))
                       $groups[$key]['total_hh']=$groups[$key]['result']+(int)$item['total_hh'];  
                
        }
      }
        return array_values($groups);
    }

    public static function getlocwisegroup_array($data,$groupby) {     

        $groups = array();$indexpoint=[];
        $index=0;
        foreach ($data as $item) {
            $key = $item[$groupby]; 
            if (!array_key_exists($key, $indexpoint)) {

              $groups[$index]=[];
              $groups[$index]['loc_id']=$key;

              $indexpoint[$key]=$index;
              $index++;
              
            }
            if(!array_key_exists($item['split_id'], $groups[$indexpoint[$key]]))            
            {
                 //$groups[$indexpoint[$key]][$item['split_id']]=[];
                 $groups[$indexpoint[$key]][$item['split_id']]['result']=0;

            }
            $groups[$indexpoint[$key]][$item['split_id']]['result']=$groups[$indexpoint[$key]][$item['split_id']]['result']+$item['result'];
            
            
        }
      
        return $groups;
    }
    public static function getlocwisegroup_array_age($data,$groupby) {     
        $groups = array();$indexpoint=[];
        $index=0;
        foreach ($data as $item) {
            $key = $item[$groupby]; 
            if (!array_key_exists($key, $indexpoint)) {

              $groups[$index]=[];
              $groups[$index]['loc_id']=$key;

              $indexpoint[$key]=$index;
              $index++;
              
            }
            if(!array_key_exists($item[$key], $groups[$indexpoint[$key]]))            
            {
                 //$groups[$indexpoint[$key]][$item['split_id']]=[];
                 $groups[$indexpoint[$key]][$item[$key]]['result']=0;

            }
            $groups[$indexpoint[$key]][$item[$key]]['result']=$groups[$indexpoint[$key]][$item[$key]]['result']+$item['result'];
            
            
        }
      
        return $groups;
    }
     public static function getloc_period_wisegroup_array($data,$groupby) {     
        $groups = array();$indexpoint=[];
        $index=0;
        foreach ($data as $item) {
            $key = $item[$groupby]; 
            if (!array_key_exists($key, $indexpoint)) {

              $groups[$index]=[];
              $groups[$index]['loc_id']=$key;  
              if(isset($item['location_type']))
                  $groups[$index]['location_type']=$item['location_type'];           
              $indexpoint[$key]=$index;
              $index++;
              
            }
            if(!array_key_exists($item['split_id'], $groups[$indexpoint[$key]]))            
            {
                 //$groups[$indexpoint[$key]][$item['split_id']]=[];
                 $groups[$indexpoint[$key]][$item['period']][$item['split_id']]['result']=0;

            }
            $groups[$indexpoint[$key]][$item['period']][$item['split_id']]['result']=$groups[$indexpoint[$key]][$item['period']][$item['split_id']]['result']+$item['result'];
            
            
        }
      
        return $groups;
    }
    public static function location_wise_groupby_result($result)
    {
         $location_wise_groupby_result=[];
        for($i=0;$i<count($result);$i++)
         {
         
            if(!array_key_exists($result[$i]['loc_id'], $location_wise_groupby_result))
                $location_wise_groupby_result[$result[$i]['loc_id']]=[];

              array_push($location_wise_groupby_result[$result[$i]['loc_id']],$result[$i]);
         }

         return $location_wise_groupby_result;
    }
    public static function getcolor_bysubrd($color)
{


        switch($color)
         {
            
                case "yellow":
                       $FillColor = '#fcff00';
                       break;
                case "d_lblue": //For Active RD Hub
                        $FillColor = '#5784b4';
                        break;
                 case "d_blue": //For Active RD Hub
                        $FillColor = '#00008B';
                        break;
                case "l_lblue": //For Active RD child
                        $FillColor = '#b3deee';
                        break;


                case "d_grey": //For Active SubRD Hub
                        $FillColor = '#908d8e';
                        break;


                case "l_goldbrown": //For Active SubRD child
                        $FillColor = '#fad39b';
                        break;

                 case "d_goldbrown": //For Active SubRD child
                        $FillColor = '#7e5a05';
                        break;

                case "l_grey": //For Active SubRD child
                        $FillColor = '#d3d3d3';
                        break;
                

                case "d_green":
                        $FillColor = '#01875b'; //5CDB94
                        break;
                        
                case "l_green":
                        $FillColor = '#01ea9e'; //5CDB94
                        break;
                        
                case "d_blue":
                        $FillColor = '#373784';
                        break;
                        
                case "l_blue":
                        $FillColor = '#7777ee';
                        break;
                
                case "d_lavender":
                        $FillColor = '#982dc5';
                        break;
                        
                case "l_lavender":
                        $FillColor = '#c18ad8';
                        break;
                
                case "d_pink":
                        $FillColor = '#D01176'; //0xFF66CC //CD4457
                        break;
                
                case "l_pink":
                        $FillColor = '#f16bb2'; //0xFF66CC //CD4457
                        break;
                
                case "d_orange":
                        $FillColor = '#FF8000';
                        break;
                
                case "l_orange":
                        $FillColor = '#ffab79';
                        break;
                        
                case "d_fgreen":
                        $FillColor = '#43CB00';
                        break;
                
                case "l_fgreen":
                        $FillColor = '#91FF1D';
                        break;
                        
                case "d_chaani":
                        $FillColor = '#666633';
                        break;
                        
                case "l_chaani":
                        $FillColor = '#ccff33';
                        break;
                case "d_red":
                         $FillColor='#f2020a';
                         break;
                case 'l_red':
                         $FillColor='#f56c70';
                         break;

                default:
                      $FillColor = '#ffffff';
         }
 return $FillColor;
}
 public static function formattype($casetype)
  {
     
          switch ($casetype) {
              case 1:
                  
                  $name = '';
                  $finalval =  1;
                  $chart='';
                  break;
              case 2:
                  
                  $name = 'K';
                  $finalval =  1000;
                  $chart='K';
                  break;
             
              case 3:
                  
                  $name = 'L';
                  $finalval =  100000;
                  $chart='L';
                  break;
            
              case 4:
                  
                  $name = 'Cr';
                  $finalval =  10000000;
                  $chart='Cr';
                  break;
              
              default:
                   $name = '';
                   $finalval = 1;
                   $chart='';
                  
          }

          return array('rangename'=>$name,'divideby'=>$finalval,'chartsymbol'=>$chart);

      }
      public static function getmonthname($month)
      {
        $month_arr=[];
        $month_arr[1]='Jan';
        $month_arr[2]='Feb';
        $month_arr[3]='Mar';
        $month_arr[4]='Apr';
        $month_arr[5]='May';
        $month_arr[6]='June';
        $month_arr[7]='July';
        $month_arr[8]='Aug';
        $month_arr[9]='Sep';
        $month_arr[10]='Oct';
        $month_arr[11]='Nov';
        $month_arr[12]='Dec';
        return $month_arr[$month];
      }
      public static function getquartername($quarter)
      {
         $quarter_arr=['Ja-Ma','Ap-Ju','Jul-Se','Oc-De'];
          return $quarter_arr[$quarter-1];
      }
    public static function getColor($maxvalue, $minvalue, $delta,$low,$high) {
    $color=[];
    for($i=0;$i<3;$i++)
    {
       array_push($color,(($high[$i]-$low[$i])*$delta+$low[$i]));

    }

    $color="hsl(".$color[0]. ",".$color[1]."%," .$color[2]."%)";

    return $color;

  }
  public static function getColor_sst($maxvalue, $minvalue, $delta,$low,$high) {
    $color=[];
    for($i=0;$i<3;$i++)
    {
       array_push($color,(($high[$i]-$low[$i])*$delta+$low[$i]));

    }

    //$color="hsl(".$color[0]. ",".$color[1]."%," .$color[2]."%)";

    return $color;

  }

    public static function getarray($arrayofobj)
    {
       $arrayofobj = array_map(function ($arrayofobj) {
                return (array)$arrayofobj;
            }, $arrayofobj);
       return $arrayofobj;
    }

    public static function split_color_variation($range)
  {
 
      $splitarray=[];
     $org_range=$range;
       $splitarray['active']=array('hex'=>'#01875B','from_1'=>'rgb(228, 242, 231)','to_1'=>'rgb(0, 242, 43)','from_2'=>'rgb(0, 242, 43)','to_2'=>'rgb(1, 135, 91)');//green
       $splitarray['none']=array('hex'=>'#FFFFFF','from_1'=>'rgb(255,255,255)','to_1'=>'rgb(255,255,255)','from_2'=>'rgb(255,255,255)','to_2'=>'rgb(255,255,255)');//gray
        $splitarray[0]=array('hex'=>'#908D8E','from_1'=>'rgb(211, 211, 211)','to_1'=>'rgb(172, 172, 172)','from_2'=>'rgb(172, 172, 172)','to_2'=>'rgb(144, 141, 142)');//gray
      $splitarray[1]=array('hex'=>'#FF8000','from_1'=>'rgb(250, 204, 154)','to_1'=>'rgb(251, 182, 109)','from_2'=>'rgb(251, 182, 109)','to_2'=>'rgb(255, 128, 0)');//orange

       $splitarray[2]=array('hex'=>'#ac0f13','from_1'=>'rgb(254, 231, 220)','to_1'=>'rgb(255, 0, 0)','from_2'=>'rgb(255, 0, 0)','to_2'=>'rgb(172, 15, 19)');//red
        $splitarray[3]=array('hex'=>'#982DC5','from_1'=>'rgb(133, 34, 176)','to_1'=>'rgb(87, 132, 180)','from_2'=>'rgb(87, 132, 180)','to_2'=>'rgb(152, 45, 197)');//lavendar
$splitarray[4]=array('hex'=>'#712664','from_1'=>'rgb(229, 218, 230)','to_1'=>'rgb(204, 51, 255)','from_2'=>'rgb(204, 51, 255)','to_2'=>'rgb(113, 38, 100)');//violet
     // $splitarray[4]=array('hex'=>'#ac0f13','from_1'=>'rgb(254, 231, 220)','to_1'=>'rgb(255, 0, 0)','from_2'=>'rgb(255, 0, 0)','to_2'=>'rgb(172, 15, 19)');//red_2

      $splitarray[5]=array('hex'=>'#373784','from_1'=>'rgb(224, 222, 240)','to_1'=>'rgb(0, 0, 255)','from_2'=>'rgb(0, 0, 255)','to_2'=>'rgb(55, 55, 132)');//blue

      $splitarray[6]=array('hex'=>'#65601F','from_1'=>'rgb(238, 236, 218)','to_1'=>'rgb(198, 221, 32)','from_2'=>'rgb(198, 221, 32)','to_2'=>'rgb(101, 96, 31');//golden

      // $splitarray[7]=array('hex'=>'#2F2D2D','from_1'=>'rgb(230, 231, 232)','to_1'=>'rgb(189, 190, 196)','from_2'=>'rgb(189, 190, 196)','to_2'=>'rgb(47, 45, 45)');//black
      $splitarray[7]=array('hex'=>'#ac0f13','from_1'=>'rgb(254, 231, 220)','to_1'=>'rgb(255, 0, 0)','from_2'=>'rgb(255, 0, 0)','to_2'=>'rgb(172, 15, 19)');//red_2


      $splitarray[8]=array('hex'=>'#d01176','from_1'=>'rgb(253, 233, 241)','to_1'=>'rgb(255, 0, 255)','from_2'=>'rgb(255, 0, 255)','to_2'=>'rgb(208, 17, 118)');//pink

      $splitarray[9]= array('hex'=>'#0096CE','from_1'=>'rgb(225, 244, 253)','to_1'=>'rgb(2, 238, 251)','from_2'=>'rgb(2, 238, 251)','to_2'=>'rgb(0, 150, 206)');//lblue
       
      // $splitarray[9]=array('hex'=>'#712664','from_1'=>'rgb(229, 218, 230)','to_1'=>'rgb(204, 51, 255)','from_2'=>'rgb(204, 51, 255)','to_2'=>'rgb(113, 38, 100)');//violet
      
      $splitarray[10]=array('hex'=>'#713620','from_1'=>'rgb(241, 223, 212)','to_1'=>'rgb(218, 136, 112)','from_2'=>'rgb(218, 136, 112)','to_2'=>'rgb(113, 54, 32)');//brown
       $splitarray[11]=array('hex'=>'#e0d006','from_1'=>'rgb(252, 252, 153)','to_1'=>'rgb(255, 255, 0)','from_2'=>'rgb(255, 255, 0)','to_2'=>'rgb(224, 208, 6)');//brown
        $splitarray[12]=array('hex'=>'#63be7b','from_1'=>'rgb(254, 228, 130)','to_1'=>'rgb(205, 221, 130)','from_2'=>'rgb(205, 221, 130)','to_2'=>'rgb(99, 190, 123)');//grid

          $splitarray[13]=array('hex'=>'#FF8000','from_1'=>'rgb(250, 204, 154)','to_1'=>'rgb(251, 182, 109)','from_2'=>'rgb(251, 182, 109)','to_2'=>'rgb(255, 128, 0)');//orange
       

         $splitarray[14]=array('hex'=>'#2E7ACB','from_1'=>'rgb(41, 95, 153)','to_1'=>'rgb(171, 81, 209)','from_2'=>'rgb(171, 81, 209)','to_2'=>'rgb(46, 122, 203)');//orange
        $splitarray[15]=array('hex'=>'#982DC5','from_1'=>'rgb(133, 34, 176)','to_1'=>'rgb(87, 132, 180)','from_2'=>'rgb(87, 132, 180)','to_2'=>'rgb(152, 45, 197)');//lavendar



         $splitarray[16]=array('hex'=>'#FF8000','from_1'=>'rgb(250, 204, 154)','to_1'=>'rgb(251, 182, 109)','from_2'=>'rgb(251, 182, 109)','to_2'=>'rgb(255, 128, 0)');//orange

      // $splitarray[2]=array('hex'=>'#ac0f13','from_1'=>'rgb(254, 231, 220)','to_1'=>'rgb(255, 0, 0)','from_2'=>'rgb(255, 0, 0)','to_2'=>'rgb(172, 15, 19)');//red
        $splitarray[17]=array('hex'=>'#982DC5','from_1'=>'rgb(133, 34, 176)','to_1'=>'rgb(87, 132, 180)','from_2'=>'rgb(87, 132, 180)','to_2'=>'rgb(152, 45, 197)');//lavendar

      $splitarray[18]=array('hex'=>'#ac0f13','from_1'=>'rgb(254, 231, 220)','to_1'=>'rgb(255, 0, 0)','from_2'=>'rgb(255, 0, 0)','to_2'=>'rgb(172, 15, 19)');//red_2

      $splitarray[19]=array('hex'=>'#373784','from_1'=>'rgb(224, 222, 240)','to_1'=>'rgb(0, 0, 255)','from_2'=>'rgb(0, 0, 255)','to_2'=>'rgb(55, 55, 132)');//blue

      $splitarray[20]=array('hex'=>'#65601F','from_1'=>'rgb(238, 236, 218)','to_1'=>'rgb(198, 221, 32)','from_2'=>'rgb(198, 221, 32)','to_2'=>'rgb(101, 96, 31');//golden

      // $splitarray[21]=array('hex'=>'#2F2D2D','from_1'=>'rgb(230, 231, 232)','to_1'=>'rgb(189, 190, 196)','from_2'=>'rgb(189, 190, 196)','to_2'=>'rgb(47, 45, 45)');//black
      $splitarray[21]=array('hex'=>'#ac0f13','from_1'=>'rgb(254, 231, 220)','to_1'=>'rgb(255, 0, 0)','from_2'=>'rgb(255, 0, 0)','to_2'=>'rgb(172, 15, 19)');//red

      $splitarray[22]=array('hex'=>'#d01176','from_1'=>'rgb(253, 233, 241)','to_1'=>'rgb(255, 0, 255)','from_2'=>'rgb(255, 0, 255)','to_2'=>'rgb(208, 17, 118)');//pink

      $splitarray[23]= array('hex'=>'#0096CE','from_1'=>'rgb(225, 244, 253)','to_1'=>'rgb(2, 238, 251)','from_2'=>'rgb(2, 238, 251)','to_2'=>'rgb(0, 150, 206)');//lblue
       
      $splitarray[24]=array('hex'=>'#712664','from_1'=>'rgb(229, 218, 230)','to_1'=>'rgb(204, 51, 255)','from_2'=>'rgb(204, 51, 255)','to_2'=>'rgb(113, 38, 100)');//violet
      
      $splitarray[25]=array('hex'=>'#713620','from_1'=>'rgb(241, 223, 212)','to_1'=>'rgb(218, 136, 112)','from_2'=>'rgb(218, 136, 112)','to_2'=>'rgb(113, 54, 32)');//brown
       $splitarray[26]=array('hex'=>'#e0d006','from_1'=>'rgb(252, 252, 153)','to_1'=>'rgb(255, 255, 0)','from_2'=>'rgb(255, 255, 0)','to_2'=>'rgb(224, 208, 6)');//brown
        $splitarray[27]=array('hex'=>'#63be7b','from_1'=>'rgb(254, 228, 130)','to_1'=>'rgb(205, 221, 130)','from_2'=>'rgb(205, 221, 130)','to_2'=>'rgb(99, 190, 123)');//grid

          $splitarray[28]=array('hex'=>'#FF8000','from_1'=>'rgb(250, 204, 154)','to_1'=>'rgb(251, 182, 109)','from_2'=>'rgb(251, 182, 109)','to_2'=>'rgb(255, 128, 0)');//orange
        // $splitarray[29]=array('hex'=>'#908D8E','from_1'=>'rgb(211, 211, 211)','to_1'=>'rgb(172, 172, 172)','from_2'=>'rgb(172, 172, 172)','to_2'=>'rgb(144, 141, 142)');//gray

         $splitarray[29]=array('hex'=>'#2E7ACB','from_1'=>'rgb(41, 95, 153)','to_1'=>'rgb(171, 81, 209)','from_2'=>'rgb(171, 81, 209)','to_2'=>'rgb(46, 122, 203)');//orange
        $splitarray[30]=array('hex'=>'#982DC5','from_1'=>'rgb(133, 34, 176)','to_1'=>'rgb(87, 132, 180)','from_2'=>'rgb(87, 132, 180)','to_2'=>'rgb(152, 45, 197)');//lavendar
      if(!isset($splitarray[$range]))
     {
          $range=array_rand(range(1,30));


     }
     
       

if(!isset( $splitarray[$range]))
{
   echo $range.'   '.$org_range;


   die;
}

      return $splitarray[$range];


  }

    public static function split_color_variation_beat($range)
  {
 
      $splitarray=[];

       
        $splitarray[0]=array('hex'=>'#01875B','from_1'=>'rgb(228, 242, 231)','to_1'=>'rgb(0, 242, 43)','from_2'=>'rgb(0, 242, 43)','to_2'=>'rgb(1, 135, 91)');//green
     $splitarray[1]=array('hex'=>'#f3e42e','from_1'=>'rgb(254, 231, 220)','to_1'=>'rgb(255, 0, 0)','from_2'=>'rgb(255, 0, 0)','to_2'=>'rgb(172, 15, 19)');//yellow hex only 
      $splitarray[2]=array('hex'=>'#982DC5','from_1'=>'rgb(133, 34, 176)','to_1'=>'rgb(87, 132, 180)','from_2'=>'rgb(87, 132, 180)','to_2'=>'rgb(152, 45, 197)');//lavendar

    $splitarray[3]=array('hex'=>'#908D8E','from_1'=>'rgb(211, 211, 211)','to_1'=>'rgb(172, 172, 172)','from_2'=>'rgb(172, 172, 172)','to_2'=>'rgb(144, 141, 142)');//gray
        
       
       


      $splitarray[4]=array('hex'=>'#373784','from_1'=>'rgb(224, 222, 240)','to_1'=>'rgb(0, 0, 255)','from_2'=>'rgb(0, 0, 255)','to_2'=>'rgb(55, 55, 132)');//blue

      $splitarray[5]=array('hex'=>'#65601F','from_1'=>'rgb(238, 236, 218)','to_1'=>'rgb(198, 221, 32)','from_2'=>'rgb(198, 221, 32)','to_2'=>'rgb(101, 96, 31');//golden

     
          $splitarray[6]=array('hex'=>'#FF8000','from_1'=>'rgb(250, 204, 154)','to_1'=>'rgb(251, 182, 109)','from_2'=>'rgb(251, 182, 109)','to_2'=>'rgb(255, 128, 0)');//orange
       

       

      return $splitarray[$range];


  }
    public static function Gradient($HexFrom, $HexTo, $ColorSteps,$per) {

        $from =str_replace("rgb(","",$HexFrom);
        $fromstr=str_replace(")","",$from);
        $fromspace=str_replace(" ","",$fromstr);
        $hexfrom=explode(",",$fromspace);


        $to =str_replace("rgb(","",$HexTo);
        $tostr=str_replace(")","",$to);
        $tospace=str_replace(" ","",$tostr);
        $hexto=explode(",",$tospace);
       

        $stepred=(float)(($hexfrom[0]-$hexto[0])/($ColorSteps-1));
        $stepgreen=(float)(($hexfrom[1]-$hexto[1])/($ColorSteps-1));
        $stepblue=(float)(($hexfrom[2]-$hexto[2])/($ColorSteps-1));
        
        $red=round($hexfrom[0]-($stepred * $per));
        $green=round($hexfrom[1]-($stepgreen * $per));
        $blue=round($hexfrom[2]-($stepblue * $per));
        
        $redappr=($red < 0) ? ($red * -1) : $red;
        $greenappr=($green < 0) ? ($green * -1) : $green;
        $blueappr=($blue < 0) ? ($blue * -1) : $blue;

        $GradientColors = sprintf("#%02x%02x%02x", $redappr, $greenappr, $blueappr);
        return $GradientColors;
  }

  public static function getcity($cityidarr)
  {
     $data=[];
     $geo_level = DB::table('city_master')->whereIn('refid', $cityidarr)->select(['refid','location_name'])->get();

     for($i=0;$i<count($geo_level);$i++)
     {
        $data[$geo_level[$i]->refid]=$geo_level[$i]->location_name;
     }

    return $data;



  }
   public static function getward($wardid_arr)
  {
     $data=[];
     $geo_level = DB::table('ward_master')->whereIn('refid', $wardid_arr)->select(['refid','location_name'])->get();

     for($i=0;$i<count($geo_level);$i++)
     {
        $data[$geo_level[$i]->refid]=$geo_level[$i]->location_name;
     }

    return $data;



  }
   public static function headline($city)
  {
     $data=[];
     $geo_level = DB::table('city_master')->whereIn('refid', $city)->select(['refid','location_name'])->get();

     for($i=0;$i<count($geo_level);$i++)
     {
        array_push($data,$geo_level[$i]->location_name);
     }

    return join(",",$data).' Localities';

  }
  public static function getreportee($userid,$wardid)
  {


     $data=[];
      
      $pc_user = DB::table('users')->where('pc_uid', $userid)->select(['id','reports_to','firstname','lastname'])->first();

      $so_user = DB::table('users')->where('id', $pc_user->reports_to)->select(['id','reports_to','firstname','lastname'])->first();
      $asmuser = DB::table('users')->where('id', $so_user->reports_to)->select(['id','reports_to','firstname','lastname'])->first();
      $bsmuser = DB::table('users')->where('id', $asmuser->reports_to)->select(['id','reports_to','firstname','lastname'])->first();

      $distributor = DB::table('loclty_pc_link')->leftJoin('mdlz_distbr_master', 'loclty_pc_link.fld1744', '=', 'mdlz_distbr_master.refid')->where([['loclty_pc_link.loc16','=', $wardid],['loclty_pc_link.pc_uid','=',$userid]])->select(['loclty_pc_link.fld1744','mdlz_distbr_master.name'])->first();

      $data['pc_name']=$pc_user->firstname.' '.$pc_user->lastname;
      $data['so_name']=$so_user->firstname.' '.$so_user->lastname;
      $data['asm_name']=$asmuser->firstname.' '.$asmuser->lastname;
      $data['bsm_name']=$bsmuser->firstname.' '.$bsmuser->lastname;
      $data['distributor']=isset($distributor->name) ? $distributor->name :'-';

      $data['pc_uid']=$pc_user->id;
      $data['so_id']=$so_user->id;
      $data['asm_id']=$asmuser->id;
      $data['bsm_id']=$bsmuser->id;
      //$data['distributor_id']=$distributor->fld1744;


      return $data;

  }
 public static function random_hex_color()
  {
       $hex_color=[];
       $hex_color=['#FF8000','#7FFFD4','#00A693','#4997D0','#6050DC','#DE5D83','#FAD6A5','#74C365','#CC3333'];
       return $hex_color[array_rand($hex_color)];
  }
  public static function hsv2rgb($hue,$sat,$val) {;
    $rgb = array(0,0,0);
    //calc rgb for 100% SV, go +1 for BR-range
    for($i=0;$i<4;$i++) {
      if (abs($hue - $i*120)<120) {
        $distance = max(60,abs($hue - $i*120));
        $rgb[$i % 3] = 1 - (($distance-60) / 60);
      }
    }
    //desaturate by increasing lower levels
    $max = max($rgb);
    $factor = 255 * ($val/100);
    for($i=0;$i<3;$i++) {
      //use distance between 0 and max (1) and multiply with value
      $rgb[$i] = round(($rgb[$i] + ($max - $rgb[$i]) * (1 - $sat/100)) * $factor);
    }
    $rgb['html'] = sprintf('#%02X%02X%02X', $rgb[0], $rgb[1], $rgb[2]);
    return $rgb;
  }

  public static function getColor_array($maxvalue, $minvalue, $delta,$low,$high) {
    $color=[];
    for($i=0;$i<3;$i++)
    {
       array_push($color,(($high[$i]-$low[$i])*$delta+$low[$i]));

    }

    //$color="hsl(".$color[0]. ",".$color[1]."%," .$color[2]."%)";

    return $color;

  }

}
