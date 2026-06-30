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
use App\User;
use DB;

class CalendarController extends Controller
{
    public function index()
    {

    }
    public function show()
    {

    }
    public function districtlist(Request $request)
    {
        $input = $request->all();
        $state_id=$input['state_id'];
        $district=DB::table('district_master')->where([['stat','=','A'],['state_id','=',$state_id]])->get();
        return $district;

    
    }
    public function statelist(Request $request)
    {
        $input = $request->all();
        $state=DB::table('state_master')->where([['stat','=','A'],['country_id','=',1]])->get();
        return $state;

    
    }
    public function getcalendardata_byid(Request $request)
    {
        $input = $request->all();
        $input["id"]=(int)$input["id"];
        $getcalendar=DB::table('festival')->select(['festival.*','festival_master.*'])->join('festival_master','festival.fld1722','=','festival_master.refid')->whereIn('fld1722',[1,9,4,13])->where([['festival.stat','=','A']])->where([['festival.refid','=',$input["id"]]])->get();
        
       
          $temp=[];
          $getcalendar_length=count($getcalendar);
         for($i=0;$i<$getcalendar_length;$i++)
        {
           
          
            $temp['refid']=$getcalendar[$i]->refid;
            $temp['state']=$getcalendar[$i]->state;
            $temp['district']=$getcalendar[$i]->district;
            $temp['sub_distt']=$getcalendar[$i]->sub_distt;
            $temp['town_village']=$getcalendar[$i]->town_village;
            $temp['name']=$getcalendar[$i]->name;
            $temp['total_individuals_rank']=['rank'=>$i+1,'count'=>count($getcalendar)];
            $temp['location_details']= $temp['town_village'].' Villg.';
            if($temp['location_details']=='')
                 $temp['location_details']= $temp['sub_distt'].' Sub-distt.';
             if($temp['location_details']=='')
                 $temp['location_details']= $temp['district'].' Distt.';
             if($temp['location_details']=='')
                 $temp['location_details']= $temp['state'].'State';
             if($temp['location_details']=='')
                 $temp['location_details']= 'NA';

             $temp['rank_total_individuals']=$getcalendar[$i]->rank_total_individuals;
             $temp['rank_total_hhs']=$getcalendar[$i]->rank_total_hhs;
             $temp['rank_per_capita_incme']=$getcalendar[$i]->rank_per_capita_incme;

            $temp['department_name']=$getcalendar[$i]->department_name;
            $temp['total_individuals']=number_format((int)$getcalendar[$i]->total_individuals,0);

            $temp['total_hhs']=number_format((int)$getcalendar[$i]->total_hhs,0);
            $temp['per_captita_incme']=number_format((int)$getcalendar[$i]->per_captita_incme,0);
            $temp['area_km']=number_format((int)$getcalendar[$i]->area_km,0);
            $temp['population']=number_format((int)$getcalendar[$i]->population,0);

            $temp['population_sqft']=($getcalendar[$i]->area_km > 0) ? round(($getcalendar[$i]->total_individuals/$getcalendar[$i]->area_km),0) : 0;
             $background_arr=[1=>['#1a453e','garlands_3555301-txt.svg','rgb(64,227,204)'],3=>['rgb(137,43,43)','Concert-Icon.svg'],13=>['rgb(36,39,94)','College-fest-icon-txt.svg','rgb(72,182,239)'],4=>['rgb(97,15,247)','Play-Icon-txt.svg','rgb(221,153,251)']];
            $temp['background']='rgb(26, 69, 62)';
            $temp['icon']='garlands_3555301-txt.svg';
            if(isset($background_arr[$getcalendar[$i]->fld1722]))
              {
                $temp['background']=$background_arr[$getcalendar[$i]->fld1722][0];
                $temp['icon']=$background_arr[$getcalendar[$i]->fld1722][1];
              } 
             $temp['icon']='<div style="background-color: #0c1f1d; display: inline-block; padding: 1px 3px;margin-left: 15px; border-radius: 4px;">
                                <img class="map-opt" src="storage/'.$temp['icon'].'" alt="Map View" style="border:2px solid transparent; height:2em; width:20px; vertical-align: middle;">
                                <span style="color: #fff;">'.$temp['name'].'</span>
                            </div>';
              $temp['nodal']='<strong >'.(($getcalendar[$i]->nodal_officier=='') ? '' : $getcalendar[$i]->nodal_officier).' </stong><br>'.(($getcalendar[$i]->address=='') ? '' : $getcalendar[$i]->address).' <br><a href="mailto:'.$getcalendar[$i]->email.'">'.(($getcalendar[$i]->email=='') ? '' : $getcalendar[$i]->email).'</a><br><div class="tourism" id="website">'.(($getcalendar[$i]->website=='' || $getcalendar[$i]->website=='undefined' ) ? '' : $getcalendar[$i]->website).' </div>';
               $temp['total_xpopulation']=((int)$getcalendar[$i]->total_individuals > 0) ? round(((int)$getcalendar[$i]->event_participants/(int)$getcalendar[$i]->total_individuals),0) : 0;

               $temp['total_xpopulation']=($temp['total_xpopulation'] <=0) ? "<1X" : $temp['total_xpopulation']."X";
            $temp['Organisers']=$getcalendar[$i]->Organisers;
            $temp['official_language']=$getcalendar[$i]->official_language;
             $temp['local_individuals']=number_format((int)$getcalendar[$i]->local_individuals,0);
            $temp['event_participants']=number_format((int)$getcalendar[$i]->event_participants,0);
            $temp['festival_name']=$getcalendar[$i]->festival;
            $temp['festival_type']=$getcalendar[$i]->festival_type;
            $temp['address']=$getcalendar[$i]->address;
            $temp['latitude']=$getcalendar[$i]->latitude;
            $temp['longitude']=$getcalendar[$i]->longitude;
            $temp['state']=$getcalendar[$i]->state;
            $temp['start_date_detail']=date('Y-m-d',strtotime($getcalendar[$i]->start_date));
            $temp['end_date_detail']=date('Y-m-d',strtotime($getcalendar[$i]->end_date));
            $temp['start_date']=date('d',strtotime($getcalendar[$i]->start_date));
            $temp['start_month']=date('M',strtotime($getcalendar[$i]->start_date));
            $temp['start']=date('d',strtotime($getcalendar[$i]->start_date));
            $temp['start_year']=date('Y',strtotime($getcalendar[$i]->start_date));
            $temp['end_date']=date('d',strtotime($getcalendar[$i]->end_date));
            $temp['end_month']=date('M',strtotime($getcalendar[$i]->end_date));
            $temp['end']=date('d',strtotime($getcalendar[$i]->end_date));
            $temp['end_year']=date('Y',strtotime($getcalendar[$i]->end_date));
            if(strtotime($getcalendar[$i]->start_date)==strtotime($getcalendar[$i]->end_date))
                  $temp['timeline']=$temp['start_date'].' '.$temp['start_month'].' ('. $temp['end_year'].')';
            else
                 $temp['timeline']=$temp['start_date'].' '.$temp['start_month'].' - '.$temp['end_date'].' '.$temp['end_month'].' ('. $temp['end_year'].')';
            $temp['month']=$getcalendar[$i]->month;
             $temp['current_month']=date('m',strtotime($getcalendar[$i]->start_date));
            $temp['start_date']=$getcalendar[$i]->start_date;
            $temp['period_Y']=$getcalendar[$i]->period_Y;
            $temp['end_date']=$getcalendar[$i]->end_date;
            $temp['address']=$getcalendar[$i]->epi_centre;
            $temp['festival_id']=$getcalendar[$i]->fld1722;
            $diff=date_diff(date_create(date('Y-m-d')),date_create($temp['start_date_detail']));
            $temp['remainingdays']= ($diff->format("%R%a") < 0) ? 0 : $diff->format("%R%a");
            $temp['totaldays']=cal_days_in_month(CAL_GREGORIAN,$temp['current_month'],$getcalendar[$i]->period_Y);
            $temp['descptn']=$getcalendar[$i]->descptn;
            $getcalendar[$i]->img_url=explode("@",$getcalendar[$i]->img_url);
            $temp['event_url']=$getcalendar[$i]->event_url.$getcalendar[$i]->img_url[0].'.png';
           
            

        }
        return $temp;

    }
    public function getcalendardata(Request $request)
    {
        $message=[];
        $message['result']=[];

        $input = $request->all();
        $state_id=$input['state_id'];
        $district_id=$input['district_id'];
        $view_type=$input['view_type'];
        $month=($input['month']==0) ? date('m') :  $input['month'];
          $sort=($input['sort_by']==0) ? 3 :  $input['sort_by'];
        $year=($input['year']==0) ? date('Y') :  $input['year'];
          $day= date('d');
        if(date('D')!='Sun')
        {    
        
          $staticstart = date('Y-m-d',strtotime('last Sunday'));    

        }else{
            $staticstart = date('Y-m-d');   
        }

        //always next saturday

        if(date('D')!='Sat')
        {
            $staticfinish = date('Y-m-d',strtotime('next Saturday'));
        }else{

                $staticfinish = date('Y-m-d');
        }

        $getcalendar_head=($input['month']==0) ? date('M').', '.$year :  date('M, Y',strtotime('01-'.$month.'-'.$year));
        $column=[];
         $value_data=[];
          

         array_push($column, array(
             'title' => '#', 'className' => 'text-left'
         ));

           array_push($column, array(
             'title' => 'Festival', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Type', 'className' => 'text-left'
         ));
         
           array_push($column, array(
             'title' => 'Address', 'className' => 'text-left'
         ));
            array_push($column, array(
             'title' => 'State', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'District', 'className' => 'text-left'
         ));
             array_push($column, array(
             'title' => 'Start Date', 'className' => 'text-left'
         ));
              array_push($column, array(
             'title' => 'End Date', 'className' => 'text-right'
         ));
               array_push($column, array(
             'title' => 'Local Individuals (Nos.)', 'className' => 'text-right'
         ));
             
              array_push($column, array(
             'title' => 'Festive Day Audience (Nos.)', 'className' => 'text-right'
         ));
               array_push($column, array(
             'title' => 'Total Individuals', 'className' => 'text-right'
         ));
                array_push($column, array(
             'title' => 'Total HHs.', 'className' => 'text-right'
         ));
                 array_push($column, array(
             'title' => 'Per Capita Income', 'className' => 'text-right'
         ));
                  array_push($column, array(
             'title' => 'Area', 'className' => 'text-right'
         ));
                   array_push($column, array(
             'title' => 'Population / SQ.KM', 'className' => 'text-right'
         ));
                    array_push($column, array(
             'title' => 'Official Language', 'className' => 'text-left'
         ));
            
       
        $getcalendar=DB::table('festival')->select(['festival.total_individuals','festival.total_hhs','festival.per_captita_incme','festival.area_km','festival.population','festival.official_language','festival.local_individuals','festival.event_participants','festival.festive_day_audience','festival.refid','festival.location_org', 'festival_unique_id', 'loc21', 'loc1', 'loc5', 'loc7', 'loc9', 'loc8', 'loc10', 'loc11', 'loc12', 'loc13', 'loc14', 'loc15', 'loc16', 'loc22', 'loc23', 'loc25', 'fld1225', 'area', 'fld1722', 'festival_type', 'img_url', 'video_url', 'brand_opportunity', 'festival', 'festival_org', 'state', 'month', 'date_org', 'to_date_org', 'start_date', 'period_Y', 'period_Q', 'period_M', 'period_D', 'end_date', 'college_name', 'subtype', 'temple_name', 'address', 'contact_person', 'contact_person_no', 'email', 'fb_link', 'event_participants_link', 'religion', 'religion_id', 'location_org', 'regionality', 'epi_centre', 'epi_centre_bkp', 'epi_centre_org', 'epi_centre_backup_name', 'seating_capacity', 'event_participants', 'event_participants_org', 'venue_name', 'interest', 'avg_ticket_price', 'ticket_link', 'pop', 'mode_of_transport', 'district', 'descptn', 'site_url', 'category', 'department_name', 'nodal_officier', 'facilities', 'activities', 'website', 'work_no', 'remarks', 'latitude', 'longitude', 'festival.stat',DB::raw('replace(start_date,".","-") as start_date'),DB::raw('replace(end_date,".","-") as end_date')])->join('festival_master','festival.fld1722','=','festival_master.refid')->whereIn('fld1722',[1,9,4,13])->where([['festival.stat','=','A']]);
        if(isset($input['state_id']) && $input['state_id']!=0 && $input['state_id']!='')
           $getcalendar=$getcalendar->where([['loc7','=',$input['state_id']]])->orderBy("start_date");
        if(isset($input['district_id']) && $input['district_id']!=0 && $input['district_id']!='')
           $getcalendar=$getcalendar->where([['loc9','=',$input['district_id']]]);
        if($view_type=='m')
           $getcalendar=$getcalendar->where([['period_M','=',$year.$month]]);
        if($view_type=='Y')
           $getcalendar=$getcalendar->where([['period_Y','=',$year]]);
        if($view_type=='d')
           $getcalendar=$getcalendar->where([['period_D','=',$year.$month.$day]]);
        if($view_type=='w')
           $getcalendar=$getcalendar->whereBetween('start_date', [$staticstart, $staticfinish]);
       if($sort==3)
         $getcalendar=$getcalendar->orderBy("start_date","ASC")->orderBy("festival","ASC")->get();
       else if($sort==1)
         $getcalendar=$getcalendar->orderBy("festival","ASC")->get();
       else if($sort==2)
         $getcalendar=$getcalendar->orderBy("festival_type","ASC")->get();
       else if($sort==4)
         $getcalendar=$getcalendar->orderBy("start_date","DESC")->get();
       else
          $getcalendar=$getcalendar->orderBy("start_date","ASC")->orderBy("festival","ASC")->get();

     $statelist=DB::table('state_master')->where([['stat','=','A'],['country_id','=',1]])->get();
     $statelist_count=count($statelist);
     $state=[0=>''];
     for($k=0;$k<$statelist_count;$k++)
        $state[$statelist[$k]->refid]=$statelist[$k]->location_name;
     $districtlist=DB::table('district_master')->where([['stat','=','A'],['country_id','=',1]])->get();
     $districtlist_count=count($districtlist);
     $district=[0=>''];
     for($k=0;$k<$districtlist_count;$k++)
        $district[$districtlist[$k]->refid]=$districtlist[$k]->location_name;
        $calendar_data=[];
        $count_calendar_data=count($getcalendar);

        $total_ind_rank=[];$total_hh_rank=[];$total_percapita_rank=[];$rank_list=['total_ind'=>[],'total_hh'=>[],'percapita'=>[],'event_participants'=>[]];
         for($i=0;$i<$count_calendar_data;$i++)
         {
            $total_ind_rank[$getcalendar[$i]->refid]=$getcalendar[$i]->total_individuals;
            $total_percapita_rank[$getcalendar[$i]->refid]=$getcalendar[$i]->per_captita_incme;
            $total_hh_rank[$getcalendar[$i]->refid]=$getcalendar[$i]->total_hhs;
            array_push($rank_list['event_participants'],(int)$getcalendar[$i]->event_participants);
             
         }
         arsort($total_ind_rank);

          arsort($total_percapita_rank); arsort($total_hh_rank);
         $i1=0;$j=0;$k3=0;
        foreach($total_ind_rank as $k=>$v)
        {
            if($v !=0) 
                $i1++;
              $rank_list['total_ind'][$k]=['rank'=>$i1,'value'=>$v];
        }

        foreach($total_hh_rank as $k1=>$v1)
        {
            if($v1 !=0) 
                $j++;
              $rank_list['total_hh'][$k1]=['rank'=>$j,'value'=>$v1];
        }
        foreach($total_percapita_rank as $k2=>$v2)
        {
            if($v2 !=0) 
                $k3++;
              $rank_list['percapita'][$k2]=['rank'=>$k3,'value'=>$v2];
        }
      
       $max_audience =max($rank_list['event_participants']);
       $min_audience=min($rank_list['event_participants']);
       $high=30;$low=5;



        for($i=0;$i<$count_calendar_data;$i++)
        {
           
            $temp=[];
            $temp['count_data']=$count_calendar_data;
            $temp['total_individuals']=number_format((int)$getcalendar[$i]->total_individuals,0);
            $temp['total_hhs']=number_format((int)$getcalendar[$i]->total_hhs,0);
            $temp['per_captita_incme']=number_format((int)$getcalendar[$i]->per_captita_incme,0);
            $temp['area_km']=number_format((int)$getcalendar[$i]->area_km,0);
            $temp['population']=number_format((int)$getcalendar[$i]->population,0);
            $temp['official_language']=$getcalendar[$i]->official_language;
             $temp['local_individuals']=number_format((int)$getcalendar[$i]->local_individuals,0);
            $temp['event_participants']=number_format((int)$getcalendar[$i]->event_participants,0);
            $temp['sqft']=(($temp['area_km']>0) ? round(((int)$getcalendar[$i]->total_individuals/(int)$getcalendar[$i]->area_km),0) : 0 );
             $temp['total_xpopulation']=((int)$getcalendar[$i]->total_individuals > 0) ? round(((int)$getcalendar[$i]->event_participants/(int)$getcalendar[$i]->total_individuals),0) : 0;

               $temp['total_xpopulation']=($temp['total_xpopulation'] <=0) ? "<1X" : $temp['total_xpopulation']."X";
            $color_critiea=((int)$getcalendar[$i]->event_participants/(float)$max_audience)*100;
            $temp['max_audience']=$max_audience;
            $temp['size']=(($color_critiea < 1) ? 5 : (($color_critiea > 30) ? 30 : $color_critiea));

           

  
            $val_data=array(($i+1),'<a href="#" style="text-decoration:underline" onClick="highlight('.$getcalendar[$i]->refid.','.$getcalendar[$i]->latitude.','.$getcalendar[$i]->longitude.')">'.$getcalendar[$i]->festival.'</a>',$getcalendar[$i]->festival_type,$getcalendar[$i]->address,$state[$getcalendar[$i]->loc7],$district[$getcalendar[$i]->loc9],date('d-m-Y',strtotime($getcalendar[$i]->start_date)),date('d-m-Y',strtotime($getcalendar[$i]->end_date)),$temp['local_individuals'],$temp['event_participants'],$temp['total_individuals'],$temp['total_hhs'],$temp['per_captita_incme'],$temp['area_km'],$temp['sqft'],$temp['official_language']);
             array_push($value_data,$val_data);

            $temp['refid']=$getcalendar[$i]->refid;
            $temp['location']=$getcalendar[$i]->location_org;
            $temp['dept_name']='Department of '.$getcalendar[$i]->department_name;
            $temp['festival_name']=$getcalendar[$i]->festival;
            $temp['festival_type']=$getcalendar[$i]->festival_type;
            $temp['address']=$getcalendar[$i]->location_org;
            $temp['latitude']=$getcalendar[$i]->latitude;
            $temp['longitude']=$getcalendar[$i]->longitude;
            $temp['state']=$getcalendar[$i]->state;
            $temp['start_date_detail']=date('Y-m-d',strtotime($getcalendar[$i]->start_date));
            $temp['end_date_detail']=date('Y-m-d',strtotime($getcalendar[$i]->end_date));
            $temp['start_date']=date('d',strtotime($getcalendar[$i]->start_date));
            $temp['start_month']=date('M',strtotime($getcalendar[$i]->start_date));
            $temp['start_year']=date('Y',strtotime($getcalendar[$i]->start_date));
            $temp['end_date']=date('d',strtotime($getcalendar[$i]->end_date));
            $temp['end_month']=date('M',strtotime($getcalendar[$i]->end_date));
            $temp['end_year']=date('Y',strtotime($getcalendar[$i]->end_date));
             if(strtotime($getcalendar[$i]->start_date)==strtotime($getcalendar[$i]->end_date))
                  $temp['timeline']=$temp['start_date'].' '.$temp['start_month'].' ('. $temp['end_year'].')';
            else
                 $temp['timeline']=$temp['start_date'].' '.$temp['start_month'].' - '.$temp['end_date'].' '.$temp['end_month'].' ('. $temp['end_year'].')';
            $temp['month']=$getcalendar[$i]->month;
             $temp['current_month']=date('m',strtotime($getcalendar[$i]->start_date));
            $temp['start_date']=$getcalendar[$i]->start_date;
            $temp['period_Y']=$getcalendar[$i]->period_Y;
            $temp['end_date']=$getcalendar[$i]->end_date;
            $temp['epi_centre']=$getcalendar[$i]->epi_centre;
            $temp['festival_id']=$getcalendar[$i]->fld1722;
            $diff=date_diff(date_create(date('Y-m-d')),date_create($temp['start_date_detail']));
            $temp['remainingdays']= ($diff->format("%R%a") < 0) ? 0 : $diff->format("%R%a");
            $temp['totaldays']=cal_days_in_month(CAL_GREGORIAN,$temp['current_month'],$getcalendar[$i]->period_Y);
            $temp['info']='';
            $temp['total_ind_rank']=$rank_list['total_ind'][$getcalendar[$i]->refid]['rank'];
            $temp['total_hh_rank']=$rank_list['total_hh'][$getcalendar[$i]->refid]['rank'];
            $temp['percapita_rank']=$rank_list['percapita'][$getcalendar[$i]->refid]['rank'];

            $temp['remainingdays_info']=($temp['remainingdays']<=0) ? 'Past Event' : $temp['remainingdays'].' days Left.';
            $temp['info']='<div class="container-fluid p-3 popupbox" style="z-index: 1000;height:fit-content;color:white !important;"><span class="d-flex flex-row justify-content-between"><h5 style="padding-top:0.3rem;">'.$temp['festival_name'].' &nbsp;</h5><div class="d-flex flex-row" style="height:max-content;margin-right: -0.7rem;"><img class="ml-1" style="cursor:pointer;" src="icons/share-icon.png" height="30px" onclick="share(\'\',this)"  lat="'.$temp['latitude'].'" lon="'.$temp['longitude'].'" id="share_'.$temp['refid'].'"><img class="ml-1" style="cursor:pointer;" geocode="'.$temp['latitude'].','.$temp['longitude'].'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class="popup" style="background: transparent;"><img class="ml-1" style="cursor:pointer;" id="'.$temp['refid'].'" src="icons/close-icon.png" height="30px" onClick="closeicon(this)"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'.$state[$getcalendar[$i]->loc7].' State</span><br><span style="line-height:1rem;">'.$district[$getcalendar[$i]->loc9].' Distt</span><br><span style="line-height:1rem;">'.$temp['timeline'].' </span><br><span style="line-height:1rem;">'.$temp['remainingdays_info'].' </span></span></h5><hr style="border-top: 1px solid white;"><p><span style="color:#1ae3b1;font-weight:bold;">Festival Type:</span> '.$temp['festival_type'].'</p><p><span style="color:#1ae3b1;font-weight:bold;">Total Individuals:</span> '.$temp['total_individuals'].' Nos.</p><p><span style="color:#1ae3b1;font-weight:bold;">Total HHs. :</span> '.$temp['total_hhs'].' HHs.</p><p><span style="color:#1ae3b1;font-weight:bold;">Per Capita Income :</span> Rs.'.$temp['per_captita_incme'].'</p><p><span style="color:#1ae3b1;font-weight:bold;">Local Individuals :</span> '.$temp['local_individuals'].' Nos.</p>
<p><span style="color:#1ae3b1;font-weight:bold;">Festive Day Audience :</span> '.$temp['event_participants'].' Nos.</p><p><span style="color:#1ae3b1;font-weight:bold;">Footfall Index :</span> '.$temp['total_xpopulation'].'</p>
<div class="popup-footer" ><span style="background-color:none;text-align:right;cursor:pointer;" class="navigate_location" onclick="openNav(this,'.$getcalendar[$i]->refid.',0,'.$temp['count_data'].','.$temp['total_ind_rank'].','.$temp['total_hh_rank'].','.$temp['percapita_rank'].')">More Info</span></div></div>';

            array_push($calendar_data,$temp);

        }
        $message['result']=$calendar_data;
        $next_month=['01'=>'02','02'=>'03','03'=>'04','04'=>'05','05'=>'06','06'=>'07','07'=>'08','08'=>'09','09'=>'10','10'=>'11','11'=>'12','12'=>'01'];
        $prev_month=['01'=>'12','02'=>'01','03'=>'02','04'=>'03','05'=>'04','06'=>'05','07'=>'06','08'=>'07','09'=>'08','10'=>'09','11'=>'10','12'=>'11'];
        //$month=(int)$month;
        $message['current_period']=$month.'_'.$year;
        
        $message['next_period']=$next_month[$month].'_'.(($next_month[$month]==1) ? ($year+1) : $year);
        $message['prev_period']=$prev_month[$month].'_'.(($prev_month[$month]==12) ? ($year-1) : $year);
        $message['head']=$getcalendar_head;
        $message['griddata']=array(
            'column' => $column,
            'value' => $value_data
        );
         return $message;

    }
   
  

}

