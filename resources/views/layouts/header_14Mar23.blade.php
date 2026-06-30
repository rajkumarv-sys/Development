<div class="horizontal-menu">
    <nav class="navbar navbar-inverse navbar-expand-lg">
        <a href="#" target="_blank" class="navbar-brand logo">
            @php
            $user_type=Auth::user()->user_type;
                    $clientid=Auth::user()->client_id;
                    $userid=Auth::user()->userid;
            if($clientid!=100 && $clientid!=2 && $clientid!=130 && $clientid!=86 && $userid!='10528')
                    {
                         @endphp
            <div class="row m-auto">
                <div class="pr-2" style="padding-left:0.7vw;"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="50px"></div>
                <div class="col">
                    <img class="mtl" src="{{ url('/storage/logo_64-2.jpg') }}" alt="brandidea.ai" title="" width="120px"></div>
            </div>
             @php
             }else if($clientid==86)
             {
                 @endphp

                 <img class="mtl" src="{{ url('/storage/nestle-logo_64-2.jpg') }}" alt="brandidea.ai" title="" width="120px">
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
if($user_type!='SUPPORT' && $user_type!='TSM' && $clientid==120)
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
if($user_type=='TSM' && $clientid==120)
{
@endphp

                    <div class="dropdown-divider"></div>
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="13" href="#">Highway Outlets</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="12" type="1,2" href="#">SubRD Recommendation</a>
                    </li>
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="12" type="3" href="#">Whlsl Recommendation</a>
                    </li>
                   
                     <!-- <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">Uncovered Outlets</a>
                    </li> -->
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="14" href="#">SubRD Beats</a>
                    </li>
                    
@php
}
if($clientid==1 or $clientid==2)
{
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
@endphp
                     <div class="dropdown-divider"></div>
                    <li class="nav-item">
                        <a href="{{url('/logout')}}" class="nav-link"><i data-feather="log-out"></i><span>Logout</span></a>
                    </li>
                      @php
            $user_type=Auth::user()->user_type;
                    $clientid=Auth::user()->client_id;
                    $userid=Auth::user()->userid;
            if($clientid==120 && $userid!='10528')
                    {
                         @endphp
                    <li class="fomo" style="position: absolute;bottom: 20px;font-size: 12px;line-height: 1.6;left: 0;bottom: 0;width: 100%;color: grey;text-align: center;padding-bottom: 1rem;">The information here is strictly<br> confidential and solely for the use of<br> Mondelez International and may not be<br> reproduced or circulated.</li>
                    <div class="plfo" style="font-size: 12px;line-height: 1.6;position: fixed;left: 0;bottom: 10px;width: 100%;color: grey;text-align: center;"><span>The information here is strictly confidential and solely for the use of Mondelez International and may not be reproduced or circulated.</span></div>
                      @php
           }
                         @endphp
                     <!-- <div style="font-size: 12px;;line-height: 1.6;position: fixed;left: 0;bottom: 0;width: 100%;color: white;text-align: center;"><span style="background-color: lightgrey">The information here is strictly confidential andsolely for the use of Mondelez International and may not be reproduced or circulated.</span></div> -->
                </ul>
            </div>
        </div>
    </nav>
</div>