<div class="horizontal-menu">
    <nav class="navbar navbar-inverse navbar-expand-lg">
        <a href="#" target="_blank" class="navbar-brand logo">
            <img src="{{ url('/storage/logo_64-2.png') }}" alt="brandidea.ai" title="">
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
                <li class="nav-item" style="background: #d5f2db;text-align: center;">
                    <img src="{{ url('/storage/mondelez-logo.svg') }}" alt="" style="width:50%;padding:5px 0;">
                </li>
                <div class="dropdown-divider" style="margin-top:0;"></div>
                <li class="nav-item" >
                        <a class="nav-link" href="#" id="userName" style="padding: 4px 5px 4px 20px;"><i data-feather="user"></i><span class="">{{ Auth::user()->firstname }}</span> <button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i></button></a>
                    </li>
@php
$user_type=Auth::user()->user_type;
if($user_type!='SUPPORT')
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
@endphp

                    <div class="dropdown-divider"></div>
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="5" href="#">Chemist</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="6" href="#">Gen. Provision Outlets</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="7" href="#">F&B Outlets</a>
                    </li>
@php
if($user_type=='SUPPORT')
{
@endphp
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="8" href="#">Chennai Outlets</a>
                    </li>
@php
}
@endphp

                     <div class="dropdown-divider"></div>
                    <li class="nav-item">
                        <a href="{{url('/logout')}}" class="nav-link"><i data-feather="log-out"></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>