<style>
    .accordion {
        width: 100%;
        /* max-width: 360px; */
        margin: 30px auto 20px;
        background: #FFF;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .accordion .link {
        cursor: pointer;
        display: block;
        padding: 15px 15px 15px 42px;
        color: #4D4D4D;
        font-size: 14px;
        font-weight: 700;
        border-bottom: 1px solid #CCC;
        position: relative;
        -webkit-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    .accordion li:last-child .link {
        border-bottom: 0;
    }

    .accordion li i {
        position: absolute;
        top: 16px;
        left: 12px;
        font-size: 18px;
        -webkit-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    .accordion li i.fa-chevron-down {
        right: 12px;
        left: auto;
        font-size: 16px;
    }

    .accordion li.open .link {
        color: #b63b4d;
    }

    /* .accordion li.open i { color: #b63b4d; } */

    .accordion li.open i.fa-chevron-down {
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .submenu {
        /* display: none !important; */
        /* background: #444359; */
        background: #28282B;
        font-size: 14px;
    }

    .submenu li {
        border-bottom: 1px solid #4b4a5e;
    }

    .submenu a {
        display: block;
        text-decoration: none;
        color: #d9d9d9;
        padding: 12px;
        padding-left: 42px;
        -webkit-transition: all 0.25s ease;
        -o-transition: all 0.25s ease;
        transition: all 0.25s ease;
    }

    .submenu a:hover {
        background: #b63b4d;
        color: #FFF;
    }

    .menu-nav ul.submenu {
        display: none;
    }

    ul li a {
        text-decoration: underline !important;
    }

    .d-block:hover {
        background: #116357 !important;
        color: #fff;
    }
</style>
<script type="text/javascript">
    $(function() {
        var Accordion = function(el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

            // Variables privadas
            var links = this.el.find(".link");
            // Evento
            links.on("click", {
                el: this.el,
                multiple: this.multiple
            }, this.dropdown);
        };

        Accordion.prototype.dropdown = function(e) {
            var $el = e.data.el;
            ($this = $(this)), ($next = $this.next());

            $next.slideToggle();
            $this.parent().toggleClass("open");

            if (!e.data.multiple) {
                $el.find(".submenu").not($next).slideUp().parent().removeClass("open");
            }
        };

        var accordion = new Accordion($("#accordion"), false);
    });
</script>

<div class="horizontal-menu">
    <nav class="navbar navbar-inverse navbar-expand-lg">
        <a href="#" target="_blank" class="navbar-brand logo">
            @php

            $user_type=Auth::user()->user_type;
                    $clientid=Auth::user()->client_id;

                   $userid=Auth::user()->userid;
                    $user_id=Auth::user()->id;   

                    $role=Auth::user()->role;
                    $login_type_mdlz=Auth::user()->login_type_mdlz;
            if($clientid!=100 && $clientid!=2 && $clientid!=130 && $clientid!=86 && $clientid!=115 && $userid!='10528' && $clientid!=1  && $clientid!=123  && $clientid!=1000 && $clientid!=112 && $clientid!=0 && $clientid!=15 && $role!='Country-HO' && $login_type_mdlz!='Urban')
                    {
                         @endphp
            <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>
                        <div class="col" style="margin-left: -8px;"><img class="mtl mohg" src="{{ url('/storage/logo_64-2.jpg') }}" alt="brandidea.ai" title="" ></div>
                        </div>

             @php
             }else if($clientid==86 && $clientid!=1)
             {
                 @endphp

                 <img class="mtl" src="{{ url('/storage/nestle-logo_64-2.jpg') }}" alt="brandidea.ai" title="" width="120px">
                  @php
                  }else if($clientid==123)
             {
                 @endphp
                 <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>
                        <div class="col" style="margin-left: -17px;"><img class="mtl mohg" src="{{ url('/storage/perfetti.jpg') }}" alt="brandidea.ai" title="" ></div>
                        </div>

                 <!-- <img class="mtl" src="{{ url('/storage/perfetti.jpg') }}" alt="brandidea.ai" title="" width="120px"> -->
                  @php
                  }
                
                  else if($user_type=='TSM' && ($clientid==120) &&  $login_type_mdlz=='Urban')
             {
                 @endphp
                   <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>
                        <div class="col" style="margin-left: -17px;"><img class="mtl mohg" src="{{ url('/storage/mdlz-logo-urban-64-2.jpg') }}" alt="brandidea.ai" title="" ></div>
                        </div>

                 <!-- <img class="mtl" src="{{ url('/storage/mdlz-logo-urban-64-2.jpg') }}" alt="brandidea.ai" title="" width="120px"> -->
                  @php
                  }else if($clientid==0)
             {
                 @endphp

                 <img class="mtl" src="{{ url('/storage/hri-logo-urban-64-2.png') }}" alt="brandidea.ai" title="" width="120px">
                  @php
                  }else if($clientid==15)
             {
                 @endphp

                 <img class="mtl" src="{{ url('/storage/hul-logo.jpg') }}" alt="brandidea.ai" title="" width="120px">
                  @php
                  }else if($clientid==1000)
             {
                 @endphp

                 <img class="mtl" src="{{ url('/storage/haldirams-logo-urban-64-2.png') }}" alt="brandidea.ai" title="" width="120px">
                  @php
                  }
                    @endphp
        </a>
        <span id="maphead"><h3></h3> </span>
        <div class="row tab-link">
            <a href='#' class="col" id="showmap" onclick="openCity(event, 'maptab')">map</a>
            <a href='#' class="col" id="showdata" onclick="openCity(event, 'tabletab')">data</a>
            <button class="navbar-toggler desktop-btn" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i></button>
        </div>
        <button class="navbar-toggler mobile-btn" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="menu-nav" id="header-mainmenu">
           
                <ul class="nav">
                <li class="nav-item pt-2" style="text-align: center;">
                    @php
                    $user_type=Auth::user()->user_type;
                    $clientid=Auth::user()->client_id;
                    $userid=Auth::user()->userid;
                    
                    @endphp
                    <img src="{{ url('/storage/Rural-Expansion-Tool-Logo.png') }}" alt="" style="width:67%;padding:5px 0;magin:0.5rem;">
                    @php
                    
                    @endphp

                </li>
                <div class="dropdown-divider" style="margin-top:0;"></div>
                <li class="nav-item" >
                        <a class="nav-link" href="#" id="userName" style="padding: 4px 5px 4px 20px;"><i data-feather="user"></i><span class="">{{ Auth::user()->firstname }}</span> <button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i></button></a>
                    </li>
@php
$user_type=Auth::user()->user_type;
$clientid=Auth::user()->client_id;
if($user_type!='SUPPORT' && $user_type!='TSM' && $role!='Country-HO' && $clientid==120)
{
@endphp

                    <div class="dropdown-divider"></div>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="1" href="#">All Channel Potential</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="2" href="#">Chemist Potential</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="3" href="#">By Status</a>
                    </li>
                   
                      <li class="nav-item" style="color:#fff;cursor: pointer;">
                            <a href="#" class="nav-link outlet-popup">
                                <span>Add Outlets</span>
                            </a>
                        </li>
                         <li class="nav-item" style="color:#fff;cursor: pointer;">
                          <a href="#" class="nav-link show_case_result" id="4" href="#">
                          <span> Outlet List</span>
                        </a>
                     
                        </li>
@php
}


if($role=='Country-HO' && $clientid==120)
{
@endphp

                    <div class="dropdown-divider"></div>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="20" type="1,2" href="#">Infra-Reco</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" href="#">Retailers</a>
                    </li>
                  
@php
}
$login_type_mdlz=Auth::user()->login_type_mdlz;
$userid=Auth::user()->id;
if($user_type=='TSM' && ($clientid==120) && $login_type_mdlz=='' && $role!='Country-HO')
{
@endphp

                   <div class="dropdown-divider"></div>
                    <ul id="accordion" class="accordion">
                       
                        <li>
                            <div class="link text-white pl-2" style=" background-color:#0b4038;"><img class="" src="{{ url('/storage/recommendation-icon.png') }}" alt="brandidea.ai" title="" width="auto" height="32px"><span class="m-2">Recommendation</span><i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                                <li> <a class="nav-link show_case_result" id="13" href="#">Highway Outlets</a></li>
                                <li><a class="nav-link show_case_result" id="12" type="1,2" href="#">SubRD Recommendation</a></li>
                                  @php
                                if(in_array($userid,[11748,11751,11789])){
                                @endphp
                                <li> <a class="nav-link show_case_result" id="12" type="3" href="#">Whlsl Recommendation</a></li>
                                 @php

                                }
                                @endphp
                                <li><a class="nav-link show_case_result" id="14" href="#">SubRD Beats (Jul 2023)</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="link text-white pl-2" style=" background-color:#0b4038;"><img class="" src="{{ url('/storage/recommendation-icon.png') }}" alt="brandidea.ai" title="" width="auto" height="32px"><span class="m-2">Additional Tools</span><i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                            <li><a class="nav-link show_case_result" id="15" href="#">Hugli SubRD Beats</a></li>
                            <li><a class="nav-link show_case_result" id="16" href="#">SST Beats</a></li>


                    @php
                    if(in_array($userid,[11748,11751,11789])){
                    @endphp
                            <li><a class="nav-link show_case_result" id="19" href="#">SST Coverage Map</a></li>
                     @php

                    }
                    @endphp
                            <li><a class="nav-link show_case_result" id="21" href="#">Sr. TSI Clusters</a></li>
                            <li><a class="nav-link show_case_result" id="22" href="#">Sr. TSI Clusters (150 SubDs)</a></li>
                            </ul>
                        </li>
                    </ul>
                    
                    
@php
}

if($user_type=='TSM' && ($clientid==112 || $clientid==123))
{
    if($clientid==112)
     $name="FMCG";
    if($clientid==123)
     $name="Uncovered";
     
@endphp

                    <div class="dropdown-divider"></div>
                   
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
            <a class="nav-link show_case_result" id="12" type="1,2" href="#">SubRD Recommendation</a>
                    </li>
                @php
                if(($clientid==123 && $role=='HO') || ($clientid==112))
                {
                    @endphp
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">{{$name}} Wholesaler</a>
                    </li>
                     
                      @php

                    if($user_type=='TSM' && ($clientid!=112))
                    {
                    @endphp
                  <!--   <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="12" type="3" href="#">Whlsl Recommendation</a>
                    </li> -->
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" href="#">Uncovered Retailers</a>
                    </li> 

                   @php
                    }
                }
                    if($user_type=='TSM' && ($clientid!=123) && $clientid!=112)
                    {
                    @endphp
                   
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="14" href="#">SubRD Beats</a>
                    </li>

                     
                    
@php
  }
}
//0-hri 1000-haldrim
if( $clientid==1000) 
{
    @endphp
     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">Uncovered Outlets</a>
                    </li>

    @php

}
if($clientid==1 or $clientid==2)
{
    if($user_id!=12930){
@endphp

                    <div class="dropdown-divider"></div>
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">Wholesaler</a>
                    </li>
                    
                   <!--  <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="6" href="#">Gen. Provision Outlets</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="7" href="#">F&B Outlets</a>
                    </li>
                    
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">Outlets </a>
                    </li> -->

@php
}
else
{
    @endphp
     <div class="dropdown-divider"></div>
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">Outletlist</a>
                    </li>
                    
    @php
}
}
if($clientid==86 || $clientid==115){
if($clientid==86)
{
@endphp

                    <div class="dropdown-divider"></div>
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#" cluster="true">Clustered Outlets</a>
                    </li>
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#" cluster="false">All Outlets</a>
                    </li>
                    @php
                    }
                    @endphp
                    @php 
                    if($clientid==115){
                    @endphp
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#" cluster="false" data_type="Dealers">Dealers</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#" cluster="false" data_type="Influencers">Influencers</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#" cluster="false" data_type="Infra Projects">Infra Projects</a>
                    </li>
                    @php

                    }
                    @endphp

                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                            <a href="#" class="nav-link outlet-popup">
                                <span>Add Outlets</span>
                            </a>
                        </li>
                         <li class="nav-item" style="color:#fff;cursor: pointer;">
                          <a href="#" class="nav-link show_case_result" id="4" href="#">
                          <span>View Added Outlets
</span>
                        </a>
                     
                        </li>
                    @php

                    }
                    @endphp
                   <!--  <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="6" href="#">Gen. Provision Outlets</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="7" href="#">F&B Outlets</a>
                    </li>
                    
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">Outlets </a>
                    </li> -->

@php

if($user_type=='SUPPORT' && $clientid==120)
{
@endphp
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="8" href="#">Chennai Outlets</a>
                    </li>
@php
}
if($user_type=='SUPPORT' && ($clientid==100 || $clientid==130))
{
@endphp
            <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="9" href="#">Covered / Uncovered Outlets</a>

                         <!-- <a class="nav-link show_case_result" id="10" href="#"> Uncovered Outlets</a> -->
            </li>
              <li class="nav-item" style="color:#fff;cursor: pointer;">
                            <a href="#" class="nav-link outlet-popup">
                                <span>Add Outlets</span>
                            </a>
                        </li>
                         <li class="nav-item" style="color:#fff;cursor: pointer;">
                          <a href="#" class="nav-link show_case_result" id="4" href="#">
                          <span> You Added Outlets</span>
                        </a>
                     
                        </li>

@php
}
   if($user_type=='TSM' && ($clientid==120) &&  $login_type_mdlz=='Urban')
{
@endphp

                   <div class="dropdown-divider"></div>
                    <ul id="accordion" class="accordion">

                    @php
                    $menu_section = DB::table("menu_section")->where([["stat","=", "A"]])->get(["refid", "menu_name","icon"]);
                    $menu_section_count=count($menu_section);
                    for($k=0;$k<$menu_section_count;$k++) {
                    @endphp

                        <li>
                            <div class="link text-white pl-2" style=" background-color:#0b4038;"><img class="" src="{{ url($menu_section[$k]->icon) }}" alt="brandidea.ai" title="" width="auto" height="32px"><span class="">{{$menu_section[$k]->menu_name}}</span><i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                    @php
                    $menu_master = DB::table("menu_master")->where([["stat","=", "A"],["parent_id","=",0],["menu_section","=",$menu_section[$k]->refid]])->orderBy("order_id")->get(["refid", "menu_name","view_optn","menu_parent_level_id"]);
                    $menu_count=count($menu_master);
                    for($i=0;$i<$menu_count;$i++) { 
                   
                     if($menu_master[$i]->view_optn==17){
                     @endphp
                            <li>
                                <a class="nav-link show_case_result" id="17" href="#">Uncovered Outlets</a>
                            </li>
                 @php
                }
                else{
                @endphp
                                 <li><a class="nav-link show_case_result" view_optn="{{$menu_master[$i]->view_optn}}" menu_id="{{$menu_master[$i]->refid}}" menu_parent_levelid="{{$menu_master[$i]->menu_parent_level_id}}" id=0 href="#">{{$menu_master[$i]->menu_name}}</a></li>
                           

                               
                     @php
                            }
                        }
                     @endphp
                               
                            </ul>
                        </li>

                      @php
                       
                    }
                        @endphp
                    </ul>
            @php
}
@endphp
 @php
if($clientid==0 || $clientid==15)
{
@endphp
<li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" href="#">Uncovered Outlets</a>
                    </li>
@php
}
@endphp  
                     <div class="dropdown-divider"></div>
                    <li class="nav-item" style="bottom:0;position:fixed;">
                        <a href="{{url('/logout')}}" class="nav-link"><i data-feather="log-out"></i><span>Logout</span></a>
                    </li>
                      @php
            $user_type=Auth::user()->user_type;
                    $clientid=Auth::user()->client_id;
                    $userid=Auth::user()->userid;
            if($clientid==120 && $userid!='10528')
                    {
                         @endphp
                    <!-- <li class="fomo" style="position: absolute;bottom: 20px;font-size: 12px;line-height: 1.6;left: 0;bottom: 0;width: 100%;color: grey;text-align: center;padding-bottom: 1rem;z-index:0;">The information here is strictly<br> confidential and solely for the use of<br> Mondelez International and may not be<br> reproduced or circulated.</li> -->
                    <!-- <div class="plfo" style="font-size: 12px;line-height: 1.6;position: fixed;left: 0;bottom: 10px;width: 100%;color: grey;text-align: center;z-index:0;"><span>The information here is strictly confidential and solely for the use of Mondelez International and may not be reproduced or circulated.</span></div> -->
                    <li class="fomo" style="position: absolute;bottom: 20px;font-size: 12px;line-height: 1.6;left: 0;bottom: 0;width: 100%;color: grey;text-align: center;padding-bottom: 1rem;">The information here is strictly<br> confidential and solely for the use of<br> Mondelez International and may not be<br> reproduced or circulated.</li>


                    <!-- <div class="plfo" style="font-size: 12px;line-height: 1.6;position: fixed;bottom: 10px;width: 100%;color: grey;text-align: center;z-index:0;right:2rem;"><span>The information here is strictly confidential and solely for the use of Mondelez International and may not be reproduced or circulated.</span></div> -->

                      @php
           }
                         @endphp
                     <!-- <div style="font-size: 12px;;line-height: 1.6;position: fixed;left: 0;bottom: 0;width: 100%;color: white;text-align: center;"><span style="background-color: lightgrey">The information here is strictly confidential andsolely for the use of Mondelez International and may not be reproduced or circulated.</span></div> -->
                </ul>
            </div>
        </div>
    </nav>
</div>