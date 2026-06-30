<style>
    .sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 999 !important;
      top: 0;
      left: 0;
      background-color: #fff;
      overflow-y: scroll; /* Enable vertical scrolling */
      overflow-x: hidden; /* Prevent horizontal scrolling */
      transition: 0.5s;
      padding-top: 60px;

    }

    /* Hide the scrollbar */
    .sidenav::-webkit-scrollbar {
      display: none; /* For Chrome, Safari, and Edge */
    }

    .sidenav {
      -ms-overflow-style: none; /* For Internet Explorer and Edge */
      scrollbar-width: none; /* For Firefox */
    }

    .sidenav a {
      padding: 5px;
      text-decoration: none;
      font-size: 25px;
      font-weight: 400;
      color: #fff;
      display: block;
      transition: 0.3s;
    }

    .sidenav a:hover {
      color: #fff;
    }

    .sidenav .closebtn {
    /*  position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;*/
        position: absolute;
        background-color: #000;
        border-radius: 50px;
        font-size: 36px;
        margin-top: -140px;  
        margin-left: 460px;
    }

    @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
      .sidenav a {font-size: 18px;}
    }
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
@media only screen and (max-width: 600px) {
  .logout {
    bottom:7em;
  }
  .acc-hei{
    height: calc(100vh - 17rem);
    background: transparent;
    overflow-y: auto;
  }
}
  @media only screen and (min-width: 601px) {
  .logout {
    bottom:1em;
  }
 .radio-inputs {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        border-radius: 0.5rem;
        background-color: slategrey;
        box-sizing: border-box;
        box-shadow: 0 0 0px 1px rgba(0, 0, 0, 0.06);
        padding: 0.25rem;
        width: 300px;
        font-size: 14px;
    }

    .radio-inputs .radio {
        flex: 1 1 auto;
        text-align: center;
    }

    .radio-inputs .radio input {
        display: none;
    }

    .radio-inputs .radio .name {
        display: flex;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        border: none;
        /* padding: .5rem 0; */
        color: white;
        transition: all .15s ease-in-out;
    }

    .radio-inputs .radio input:checked+.name {
        /* background-color: #fff; */
        font-weight: 600;
        color: orange;
    }

    label {
        margin-bottom: 0px !important;
    }

   .vscomp-toggle-button{
    border-radius: 5px;
    }
    .table-days {
      border-spacing: 5px;
      border-collapse: separate;
      background-color:transparent;
    }
    .td-tab-days {
    background-color:grey;
    height:10px;
    width:10px;
    font-size:10px;
    font-weight:bolder;
    }

    /* Custom scrollbar */

    .style-2::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3) !important;
        border-radius: 10px !important;
        background-color: #F5F5F5 !important;
    }

    .style-2::-webkit-scrollbar
    {
        width: 12px !important;
        background-color: #F5F5F5 !important;
    }

    .style-2::-webkit-scrollbar-thumb
    {
        border-radius: 10px !important;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3) !important;
        background-color: rgb(1,82,67) !important;
    }


    /* LTx33 */


    .container {
        background: #e5e5e5;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 600px;
            width: 95%;
            margin-left: 10px;
            margin-bottom: 10px;
    }

     .left-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

    .left-section div {
            background: #000;
            color: #fff;
            border-radius: 5px;
            text-align: end;
            padding: 10px 15px;
            font-size: 1.1rem;
            font-weight: bold;
            display: inline-block;
        }

        .left-section p {
            margin: 0;
            font-size: 0.9rem;
            color: #333;
            font-weight: 600;
            text-decoration: underline;
        }

        .divider {
            width: 2px;
            background: #000;
            height: 100px;
        }

        .right-section {
            text-align: center;
            display: flex;
        }

        .right-section img {
            margin-bottom: 10px;
            width: 100px;
            padding-top: 20px;
        }

        .right-section h4 {
            font-size: 2rem;
            font-weight: 200;
            margin-bottom: 5px;
            color: #22b8a0;
        }

        .right-section .index {
            background: #575d5d;
            color: #eed212;
            font-size: 2rem;
            font-weight: bold;
            padding: 15px 10px;
            border-radius: 5px;
            display: inline-block;
        }
    
        .calen {
            background: #e5e5e5;
            border-radius: 7px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            width: 95%;
            max-width: 500px;
            margin-left: 10px;
            margin-bottom: 10px;
        }

        .icon {
            width: 20px;
            height: 20px;
            color: #3fe1ca;
        }

        .calentext {
            color: #45968a !important;
            font-size: 14px !important;
            font-weight: bold;
            text-decoration: underline !important;
            white-space: nowrap;
        }

        .calentext:hover {
            text-decoration: underline;
        }
        .organizer {
            background: #e5e5e5;
            border-radius: 10px;
            padding: 20px;
            max-width: 500px;
            margin-left: 10px;
            margin-bottom: 10px;
            width: 95%;
        }

        .organizerheader {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #45968a;
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .organizerheader img {
            width: 24px;
            height: 24px;
        }

        .details {
            line-height: 1.6;
            font-size: 0.8rem;
        }

        .details h4 {
            font-size: 0.8rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .details a {
            color: #de814a;
            font-size: 0.8rem;
            text-decoration: none;
            padding-left: 0px;
        }

        .details a:hover {
            text-decoration: underline;
            color: #de814a;
        }

        .tourism a {
            color: #5a55df;
            margin-top: -10px;
            padding-left: 0px;
        }
        .tourism a:hover{
            color: #5a55df;
        }


        .geographicintel {
            background: #e5e5e5;
            border-radius: 10px;
            padding: 20px;
            max-width: 600px;
            margin-left: 10px;
            margin-bottom: 10px;
            width: 95%;
        }

        .headerintel {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #45968a;
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .headerintel img {
            width: 24px;
            height: 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .item {
            text-align: center;
            border-right: 1px solid #ddd;
        }

        .item:last-child {
            border-right: none;
        }

        .item h4 {
            font-size: 0.6rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #7f7f7f;
        }

        .item .value {
           
           
            font-size: 1rem;
            font-weight: bold;
            color: #000;
        }

        .item .rank {
            background-color: #7f7f7f;
            border-radius: 5px;
            font-size: 0.6rem;
            color: #fff;
            width: 70%;
            margin-left: 30px;
        }

        .highlight {
            color: #22b8a0;
        }

        .map-container {
            background:rgb(0, 0, 0);
            border-radius: 10px;
            overflow: hidden;
            width: 95%;
            margin-left: 10px;
            max-width: 500px;
        }
        

        .map {
            width: 100%;
            height: 200px;
            border: none;
            filter: 
            grayscale(100%)
            invert(100%)
            contrast(90%)
            brightness(110%);
                }

        .scroll-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }

        .scroll-to-top {
            background: #000;
            color: #22b8a0;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 5px;
            font-size: 40px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .scroll-to-top:hover {
            background: #000;
            color: #22b8a0;  
            transform: scale(1.1);
        }
       .lfix{
        margin-left: -9px;
       }
       @media only screen and (max-width: 600px){
            .lfix{
            margin-left: -24px !important;   
           }     
       }  

</style>
<script type="text/javascript"> 
    $(function() {
        var Accordion = function(el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

          
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

<div id="mySidenav" class="sidenav" style="z-index: 999 !important;">

    <div style="background-color: rgb(26, 69, 62);width: 100%;height: auto;margin-top: -84px;color:#fff;" id="topmap">
        <div class="d-flex flex-row mb-2">
            <div style="width:8rem;">

                <div class="text-white ml-2 mt-4 d-flex flex-row"
                    style="font-family: \'Myriad Pro\', system-ui;font-weight: bold;font-size: 11px;">
                    <div class="p-1 d-flex flex-column">
                        <h2 id="startd">01</h2>
                        <p><strong id="startm">Mar</strong></p>
                    </div>
                    <div class="p-1 mt-3 font-weight-bold" id="highlight_symbol">-</div>
                    <div class="p-1 d-flex flex-column mt-2 font-weight-bold">
                        <p id="endd">06</p>
                        <p><strong id="endm">Mar</strong></p>
                    </div>
                    <div class="mt-5" style="min-width: 22rem;margin-top: 0.6rem !important;">
                        <div style="min-width: 22rem; margin-top: 0.6rem !important;" id="icon_section">
                           
                        </div>

                        <div>
                            <h4 class="ml-3" style="color:rgb(64,227,204);font-family: 'impact', 'IBM Plex Sans';letter-spacing: 1px;font-weight: 10;
    font-size: 24px;" id="festival_name">test</h4>
                        </div>
                        <div class="mt-2 ml-2 text-white" style="font-size:11px;">
                            <img class="map-opt" src="storage/calendar_01.svg"
                                alt="Map View" style="border:2px solid transparent;height:2em;"><span
                                id="startperiod">01 Sep - 01 Sep(2024)</span><br>
                            <img class="map-opt" src="storage/location-info-01.svg"
                                alt="Map View" style="border:2px solid transparent;height:2em;"><span
                                id="event_name">xyz</span><br>
                            <div class="event-location"
                                style="font-weight: 400;margin-left: 33px;white-space: nowrap;font-size: 10px;">
                                <p>
                                    <span>State:</span> <span class="highlight" id="highlight_state">Rajasthan</span> |
                                    <span>District:</span> <span class="highlight" id="highlight_district">Karauli</span> |
                                    <span>Sub-distt.:</span> <span class="highlight" id="highlight_subdistrict">Karauli</span> |
                                    <span>Village:</span> <span class="highlight" id="highlight_village">Karauli</span>
                                </p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2 ml-2 text-white" style="font-size:smaller;width: 283px;">

        </div>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


    </div>
    <div id="event_image" style="
    border-radius: 231px !important;
    padding: 0px 4px 10px 2px;">

        <img src="slide/img_20240916.png" width="460px" height="250px"></img>
    </div>

    <div style="background-color: #e5e5e5; border-radius: 7px; margin: 0px 10px; padding: 15px;">
        <!-- Title with hamburger icon -->
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <img src="https://img.icons8.com/ios-filled/15/000000/menu.png" alt="Hamburger Icon"
                style="margin-right: 8px;">
            <h3 style="margin: 0; color: #45968a; font-size: 16px; text-decoration: underline; padding: 0 !important;">
                EVENT DETAILS
            </h3>
        </div>

        <!-- Paragraph content -->
        <div style="margin-left: 28px;"> <!-- Aligns the paragraph and link -->
            <p id="event_desc" style="margin: 0; font-size: 12px;">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap
                into electronic typesetting, remaining essentially unchanged.
            </p>
            <!-- Link text -->
            <a href="#"
                style="color: #45968a; text-decoration: underline; font-size: 14px; display: block; margin-top: -3px; padding: 0;">More...</a>
        </div>
    </div>

    <div style="background-color:#fff; padding: 7px; text-align: center; clear: both;">
        <div
            style="background-color: #e5e5e5; border-radius: 7px; width: 48%; font-size: 12px; text-align: left; padding: 8px 12px; float: left; margin-right: 4px;">
            <div style="line-height: 1.4;" id="timeline_date">
               <!-- 
                <img src="storage/event-time.png" alt="Clock"
                    style="margin-right: 8px; width: 14px; height: 14px;" id="timeline_time">9:00 AM -
                6:00
                PM (Everyday) -->
            </div>
        </div>

        <div
            style="background-color: #e5e5e5; border-radius: 7px; width: 48%; font-size: 12px; text-align: left; padding: 8px 12px; float: right;">
            <div style="line-height: 1.4; white-space: pre-wrap;" id="address">
                
                <!-- <img src="storage/location-info-01.svg" alt="Location"
                    style="margin-right: 8px; width: 14px; height: 14px;" >Kailadevi
                Temple, Karauli,Rajasthan - 322243 -->
            </div>
            <span style="color: green; text-decoration: underline; cursor: pointer; margin-top: 4px; display: block;">
            See Other Events
        </span>
        </div>
    </div>

    <div style="background-color:#fff;text-align:center;padding:7px;">
        <div style="background-color: #e5e5e5; border-radius: 7px; margin-top: 50px;  width: 46%; margin-left:4px; padding-top:10px; " id="timeline_days">Test Test</div>
        <!--   <div style="    background-color: #e5e5e5;    width: 20%;     font-size: 12px;   text-align: left;
  float: left;    margin-right: 10px;" id="address"></div>   -->
    </div>

    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <p>Local Individuals (Nos.):</p>
            <div id="local_indivual">50,00,000</div>
            <p>Festive Day Audience (Nos.):</p>
            <div id="festive_audience">100,00,000</div>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Right Section -->
        <div class="right-section">
            <div>
            <img src="storage/People-man-Icon2.svg" alt="Footfall Icon">
            </div>
            <div>
            <h4>Footfall <br> Index</h4>
            <div class="index" id="x_population"></div>
            </div>                
        </div>
    </div>
    <div class="calen">
        <!-- Calendar Icon -->
        <img class="icon" src="https://img.icons8.com/ios-filled/50/00bfa5/calendar-plus.png" alt="Calendar Icon">
        <!-- Link Text -->
        <a href="#" class="calentext">Add event to Calendar</a>
    </div>
    <div class="organizer">
        <!-- Header -->
        <div class="organizerheader">
           <img src="https://img.icons8.com/ios-filled/50/3fe1ca/management.png" alt="Organizer Icon">
            <span><strong>Organiser(s)</strong></span>
        </div>

        <!-- Details -->
        <div class="details">
            <h4><strong id="dept">Department of Tourism and District Administration</strong></h4>
            <p id="nodal"><strong >Mrs. Tina Yadav</strong><br>
                Tourist Reception Centre, Alwar<br>
                01442-347348
                <a href="mailto:trcalwar-dtor@rajasthan.gov.in">trcalwar-dtor@rajasthan.gov.in</a>
            <div class="tourism" id="website">
                

            </div>
            </p>
        </div>
    </div>
    <div class="geographicintel">
        <!-- Header -->
        <div class="headerintel">
            <img src="https://img.icons8.com/ios-filled/50/3fe1ca/marker.png" alt="Map Pin Icon">
            <span id="village_detail">Geographic Intel</span>
        </div>

        <!-- Grid Section -->
       
        <div class="grid">
            <div class="item">
                <h4>TOTAL INDIVIDUALS</h4>
                <div class="value" id="total_indidual"><i class="fas fa-user" style="padding-right:7px"></i>126,189,673</div>
                <div class="rank" id="totalindi_rank">Rank : 5 / 36</div>
            </div>
            <div class="item">
                <h4>TOTAL HHs</h4>
                <div class="value" id="total_hh"><i class="fas fa-home" style="padding-right:7px"></i>27,855,763</div>
                <div class="rank" id="totalhh_rank">Rank : 6 / 36</div>
            </div>
            <div class="item">
                <h4>PER CAPITA INCOME</h4>
                <div class="value highlight"  id="percapita"><i class="fas fa-money-bill-wave" style="padding-right:7px"></i>₹251,000</div>
                <div class="rank" id="totalpercapita_rank">Rank : 3 / 36</div>
            </div>
            <div class="item">
                <h4>AREA</h4>
                <div class="value"  id="area"><i class="fas fa-map" style="padding-right:7px"></i>307,713 km²</div>
            </div>
            <div class="item">
                <h4>POPULATION / SQ.KM</h4>
                <div class="value" id="sqft"><i class="fas fa-chart-area" style="padding-right:7px"></i>410</div>
            </div>
            <div class="item">
                <h4>OFFICIAL LANGUAGE</h4>
                <div class="value" id="language">Marathi</div>
            </div>
        </div>

    </div>
    <div class="map-container" id="mapclass">
       <iframe 
  width="500" 
  height="170" 
  frameborder="0" 
  scrolling="no" 
  marginheight="0" 
  marginwidth="0" 
  src="https://maps.google.com/maps?q=12.9558951,77.5342701&hl=es&z=14&amp;output=embed"
 >
 </iframe>
 
    </div>


    <!-- Scroll to Top Button -->
    <div class="scroll-container">
        <a href="#topmap">
            <img class="scroll-to-top" src="{{ url('/storage/map.png') }}" alt="Scroll to top">
        </a>
    </div>





</div>
<script>
    // Fallback JS Smooth Scrolling for older browsers
    document.querySelector('.scroll-to-top').addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('#topmap').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
</script>
<style>
    #horizontal
    {
        border:0px;
    }
</style>
<div class="horizontal-menu" id="horizontal">
    <nav class="navbar navbar-inverse navbar-expand-lg">
        <a href="#" target="_blank" class="navbar-brand logo">
            @php

            $user_type=Auth::user()->user_type;
                    $clientid=Auth::user()->client_id;

                   $userid=Auth::user()->userid;
                    $user_id=Auth::user()->id;   

                    $role=Auth::user()->role;
                    $login_type_mdlz=Auth::user()->login_type_mdlz;
                     if($user_id==13285)
                    {
                         @endphp 
           
                     <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>
                        <!-- <div class="col" style="margin-left: -8px;"><img class="mtl mohg" src="{{ url('/storage/logo_64-2.jpg') }}" alt="brandidea.ai" title="" ></div> -->
                        </div>
                       

             @php
             }
            if($clientid!=100 && $clientid!=2 && $clientid!=97 && $clientid!=133 && $clientid!=130 && $clientid!=86 && $clientid!=115 && $userid!='10528' && $clientid!=1  && $clientid!=123  && $clientid!=1000 && $clientid!=112 && $clientid!=0 && $clientid!=15 && $role!='Country-HO' && $login_type_mdlz!='Urban' && $user_id!=13285 && $clientid!=240 && $clientid!=999 && $clientid!=9999 && $clientid!=150)
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
                  } else if($clientid==240)
             {
                 @endphp

              
                  <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div> 
                        <div class="col" style="margin-left: -10px !important;"><img class="mtl mohg" src="{{ url('/storage/adani_logo_64-2.jpg') }}" alt="brandidea.ai" title="" ></div>
                        </div>
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
                  else if($clientid==999)
             {
                 @endphp
                 <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div> 
                      <div class="col" style="margin-left: -7px;"><img class="mtl mohg" src="{{ url('/storage/biotique-Logo.jpg') }}" alt="brandidea.ai" title="" ></div>
                        </div>  

                 <!-- <img class="mtl" src="{{ url('/storage/perfetti.jpg') }}" alt="brandidea.ai" title="" width="120px"> -->
                  @php
                  }
                  else if($clientid==133)
             {
                 @endphp 
                 <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>
                        <div class="col" style="margin-left: -22px;"><img class="mtl mohg" src="{{ url('/storage/pepsi-logo.jpg') }}" style="height:37px;width:80px;" alt="brandidea.ai" title="" ></div>
                        </div>

               
                  @php
                  }
                  else if($clientid==97 && $user_id!=13720)    
             {
                 @endphp
                 <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>      
                         <div class="col lfix"><img class="mtl mohg" src="{{ url('/storage/ckpl-logo.jpg') }}" style="height:37px;width:80px;" alt="brandidea.ai" title="" ></div>
                        </div>

                          
                  @php 
                  }     
                  else if($user_id==13720)
                 {
                 @endphp
                 <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>      
                       
                        </div>
 
                  @php
                  }
                
                  else if($user_type=='TSM' && ($clientid==120) &&  $login_type_mdlz=='Urban' && $user_id!=13285)
             {
                 @endphp
                   <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>
                        <div class="col" style="margin-left: -7px;"><img class="mtl mohg" src="{{ url('/storage/mdlz-logo-urban-64-2.jpg') }}" alt="brandidea.ai" title="" ></div>
                        </div>
 
                  @php
                  }else if($clientid==0)
             {
                 @endphp
                  <div class="row d-flex">
                        <div class="col mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title="" width="auto" height="37px"></div>
                        <div class="col" style="margin-left: -8px;"><img class="mtl mohg" src="{{ url('/storage/hri-logo-urban-64-2.png') }}" alt="brandidea.ai" title="" ></div>
                        </div>

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
				  else if($clientid==150)
             {
                 @endphp

                 <img class="mtl" src="{{ url('/storage/maamis_logo.png') }}" alt="brandidea.ai" title="" width="120px">
                  @php
                  }
                  
                    else if($clientid==112)
             {
                 @endphp
                 <div class="d-flex">
                        <div class="mobh"><img class="mtl" src="{{ url('/storage/bi-logo.svg') }}" alt="brandidea.ai" title=""style="margin-top:-2px;" width="auto" height="37px"></div>
                        <div class="md-l"><img class="mohg" src="{{ url('/storage/CCI-locaview-logo.jpg') }}" alt="brandidea.ai" title="" style="margin-top:-2px;" height="38" width="40" ></div>
                </div>
                  @php
                  }
                    @endphp
        </a>
        <style>
            #maphead::before,
#maphead::after {
   content: none;
}
            </style>
        <span id="maphead"> </span> 
       
        <div class="row tab-link">
            <a href='#' class="col" id="showmap" onclick="openCity(event, 'maptab')">map</a>
            <?php
            if($clientid==112){
            ?>
             <a href='#' class="col" id="showcalendar" onclick="openCity(event, 'calendartab')" >Calendar</a>
         <?php } ?>
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
                                <li><a class="nav-link show_case_result" id="26" href="#">Khoj - Villgs. with Zero RLA</a></li>  
                                
                                 <li> <a class="nav-link show_case_result" id="13" highway_type="1" href="#">National Highway</a></li>
                                 <li> <a class="nav-link show_case_result" id="13" highway_type="2" href="#">State Highway</a></li>

                                <li><a class="nav-link show_case_result" id="12" type="1,2" href="#">Biscuit SubRD Recommendation</a></li>
                                  @php
                                if(in_array($userid,[11748,11751,11789])){
                                @endphp
                               <!-- <li> <a class="nav-link show_case_result" id="12" type="3" href="#">Whlsl Recommendation</a></li> -->
                                 @php 

                                }
                                @endphp
                                <li><a class="nav-link show_case_result" id="14" href="#">SubRD Beats</a></li>
                                  
                                 
                                
                            </ul>
                        </li>
                        <li>
                            <div class="link text-white pl-2" style=" background-color:#0b4038;"><img class="" src="{{ url('/storage/additional-tools-icon.png') }}" alt="brandidea.ai" title="" width="auto" height="32px"><span class="m-2">Additional Tools</span><i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                            <li><a class="nav-link show_case_result" id="15" href="#">Hugli SST Beats</a></li>
                             <li><a class="nav-link show_case_result" id="23" href="#">SST Van Beats</a></li>
                            <li><a class="nav-link show_case_result" id="16" href="#">SST Beats</a></li>
                            <li><a class="nav-link show_case_result" id="25" href="#">Village with no RLA</a></li>
                          <li><a class="nav-link show_case_result" id="28" href="#">Subrd Consolidation</a></li>
                            

                            



                    @php 
                    if(in_array($userid,[11748,11751,11789])){
                    @endphp
                            <li><a class="nav-link show_case_result" id="19" href="#">SST Coverage Map</a></li>
                     @php

                    }
                    @endphp
                            <li><a class="nav-link show_case_result" id="21" href="#">Sr. TSI Clusters</a></li>
                            <!-- <li><a class="nav-link show_case_result" id="22" href="#">Sr. TSI Clusters (150 SubDs)</a></li> -->
                            
                            <li><a class="nav-link show_case_result" id="24" href="#">OOH Activity</a></li>
                            </ul>
                        </li>
                            @php 
                    if(in_array($userid,[13285])){
                    @endphp
                            <li>
                                <div class="link text-white pl-2" style=" background-color:#0b4038;"><img class="" src="{{ url('/storage/additional-tools-icon.png') }}" alt="brandidea.ai" title="" width="auto" height="32px"><span class="m-2">Urban</span><i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <a class="nav-link show_case_result" id="17" href="#">Uncovered Outlets</a>
                            </li> 
                            </ul>
                            </li>
                     @php

                    }
                    @endphp
                    </ul>
                    
                    
@php
}

if($clientid==999)
{
  
@endphp

                    <div class="dropdown-divider"></div>
                   
                   
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" href="#">Outlets</a>
                    </li> 
                     
                    
@php
  
}
if($clientid==9999)
{
  
@endphp

                    <div class="dropdown-divider"></div>
                   
                    <li><a class="nav-link show_case_result" id="12" type="1,2" href="#">SubRD Recommendation</a></li>
                    
                    
@php
  
}
if($user_type=='TSM' && ($clientid==112 || $clientid==123) )
{
    if($clientid==112)
     $name="FMCG";
    if($clientid==123)
     $name="Uncovered";
     
@endphp

                    <div class="dropdown-divider"></div>
                   
                   <!--  <li class="nav-item" style="color:#fff;cursor: pointer;">
            <a class="nav-link show_case_result" id="12" type="1,2" href="#">SubRD Recommendation</a>
                    </li> -->
                    <li class="nav-item" style="color:#fff;cursor: pointer;"> 
                 
                         @php if(in_array($user_id, [13947,21037,21036,21039,21038,22853], true)) {  @endphp<a class="nav-link show_case_result" id="12" type="1,2,5"  href="#">Spoke Coverage / Reco</a>
                         <li> <a class="nav-link show_case_result" id="13" highway_type="1" href="#">National Highway</a></li>
                         <li> <a class="nav-link show_case_result" id="12" type="15"  href="#">Feedr Market</a> </li>
                         @php } @endphp
                         
                          @php if(!in_array($user_id, [13947,21037,21036,21039,21038,13946,22853], true) ) {  @endphp<a class="nav-link show_case_result" id="12" type="4"  href="#">Spoke Coverage / Reco</a>@php } @endphp
                    </li>                
                    <!-- <li><a class="nav-link show_case_result" id="23" href="#">Calendar</a> </li> -->
                @php
                if(($clientid==123 && $role=='HO'))
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
if($clientid==112 && !in_array($user_id, [13947,21037,21036,21039,21038], true))
{
                    @endphp
					 <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" href="#">Uncovered Retailers</a>
                    </li> 

                       
@php
  }
if($clientid==112 && $role=='' && $userid!=13730)
{
                    @endphp
                   
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" href="#">Rings of Magic</a>
                    </li>
					
					 <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">Uncovered Outlets</a>
                    </li>

                       
@php
  }
  if($clientid==112 && $role=='' && $userid==13730)
{
                    @endphp
                   
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="180"  href="#">FMCG Universe</a>
                    </li>

                       
@php
  }
  if($clientid==240)
{
                    @endphp
                   
                     <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="12" href="#">Adani Geoographies</a>
                    </li>

                     
                    
@php
  }
//0-hri 1000-haldrim
if( $clientid==1000) 
{
    @endphp
                <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="11" href="#">Uncovered Outlets</a>
                    </li>

                     <li><a class="nav-link show_case_result" id="12" type="1,2" href="#">SubRD Recommendation</a></li>


    @php

}
if( $clientid==150) 
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
                    <ul id="accordion" class="accordion acc-hei style-2">

                    @php
                    $menu_section = DB::table("menu_section")->where([["stat","=", "A"]])->orderBy('order_fld')->get(["refid", "menu_name","icon"]);
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
if($clientid==0 || $clientid==15 || $clientid==133)
{
    if($clientid!=133)
    {
@endphp

<li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" href="#">Uncovered Outlets</a>
                        
                    </li> 
@php
}
@endphp
                    <!--  <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" type_id=1 href="#">FMCG Retlrs</a>
                    </li>
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" type_id=2 href="#">Delhi - HRI Visited Retlrs</a>
                    </li> 
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" type_id=3 href="#">Alipur Retlrs</a>
                    </li> -->
                  @php
if($clientid==133 ) 
{
@endphp  
 
<!-- <li><a class="nav-link show_case_result" id="12" type="1" href="#">RPI</a></li>
                   <li><a class="nav-link show_case_result" id="12" type="1,2" href="#">Rural Progrsv Index</a></li>-->


 @php
if($clientid==133 && (Auth::user()->login_type_mdlz!= 'Rural' && Auth::user()->login_type_mdlz!= 'Rural/Urban')) 
{
@endphp  

        <li> <a class="nav-link show_case_result" id="17" href="#">Uncovered Outlets</a> </li>
      <!-- <li><a class="nav-link show_case_result" id="12" type="1,2,33" href="#">Distributor Whitespace</a></li> -->
      
         
     
    @php
    if($userid == 20895)
    {
    @endphp  
   <li><a class="nav-link show_case_result" id="17" href="#">MI - Uncovered Outlets</a></li>
    

@php
    }
}
@endphp 


@php
if($clientid==133 && Auth::user()->login_type_mdlz == 'Rural/Urban') 
{
@endphp  
  <!-- <li><a class="nav-link show_case_result" id="12" type="1,2,5" href="#">SubRD Recommendation</a></li> 
     
    <li> <a class="nav-link show_case_result" id="17" href="#">Uncovered Outlets</a> </li> 

     @php
    if($userid == 20895)
    {
    @endphp  
   <li><a class="nav-link show_case_result" id="17" href="#">MI - Uncovered Outlets</a></li>
    

@php
    }
@endphp -->
    <li><a class="nav-link show_case_result" id="12" type="1,2,5" href="#">GTM – Rural Expansion</a></li>
    <li><a class="nav-link show_case_result" id="12" type="1,2,5,30" href="#">Merge with Existing DBR</a></li>
    <li><a class="nav-link show_case_result" id="12" type="1,2,5,31" href="#">New DBR</a></li>
    <li><a class="nav-link show_case_result" id="12" type="1,2,5,32" href="#">New Sub DBR</a></li>
        
         


@php
}
@endphp 
   
@php
}}
@endphp 


@php
 
if(Auth::user()->client_id==97)
{

if(Auth::user()->id==13720)
{
@endphp
<li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="185" href="#">Beats</a>
                    </li>  
                  
   @php 
}

if(Auth::user()->id==13721)
{
@endphp
                    <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="18" type="1" href="javascript:void(0)">Uncovered Outlets</a>
                    </li>   
                  
   @php 
}
if(Auth::user()->id!=13721)
{
@endphp  
                    
                      <li class="nav-item" style="color:#fff;cursor: pointer;">
                        <a class="nav-link show_case_result" id="17" type="0"  href="#">Uncovered Outlets (New)</a>
                    </li> 
 
@php
 }
}
@endphp  
 
                     <div class="dropdown-divider"></div>
                    <li class="nav-item logout" style="position:fixed;">
                         <div class="dropdown-divider" style="margin-top:0;"></div>
                        <a href="{{url('/logout')}}" class="nav-link"><i data-feather="log-out"></i><span>Logout</span></a>
                    </li>
                      @php
            $user_type=Auth::user()->user_type;
                    $clientid=Auth::user()->client_id;
                    $userid=Auth::user()->id;
                 
            if($clientid==120 && $userid!='10528' && $userid!='13285') 
                    {
                         @endphp
                    <li class="fomo" style="position: absolute;bottom: 20px;font-size: 12px;line-height: 1.6;left: 0;bottom: 0;width: 100%;color: grey;text-align: center;padding-bottom: 1rem;z-index:0;">The information here is strictly<br> confidential and solely for the use of<br> Mondelez International and may not be<br> reproduced or circulated.</li>
                    <!-- <div class="plfo" style="font-size: 12px;line-height: 1.6;position: fixed;left: 0;bottom: 10px;width: 100%;color: grey;text-align: center;z-index:0;"><span>The information here is strictly confidential and solely for the use of Mondelez International and may not be reproduced or circulated.</span></div> -->
                    <!-- <li class="fomo" style="position: absolute;bottom: 20px;font-size: 12px;line-height: 1.6;left: 0;bottom: 0;width: 100%;color: grey;text-align: center;padding-bottom: 1rem;">The information here is strictly<br> confidential and solely for the use of<br> Mondelez International and may not be<br> reproduced or circulated.</li> -->


                    <div class="plfo" style="font-size: 12px;line-height: 1.6;position: fixed;bottom: 10px;width: 100%;color: grey;text-align: center;z-index:0;right:3rem;width:90%"><span>The information here is strictly confidential and solely for the use of Mondelez International and may not be reproduced or circulated.</span></div>

                      @php
           }
                         @endphp
                     <!-- <div style="font-size: 12px;;line-height: 1.6;position: fixed;left: 0;bottom: 0;width: 100%;color: white;text-align: center;"><span style="background-color: lightgrey">The information here is strictly confidential andsolely for the use of Mondelez International and may not be reproduced or circulated.</span></div> -->
                </ul>
            </div>
        </div>
    </nav>
</div>

<script type="text/javascript">
        function setactive(data)
        {
            $(".tabview").each(function(){
                if($(this).hasClass("active"))
                {
                    $(this).removeClass("active");
                    $(this).attr("style","");
                }

            });
        //         var curr = new Date; // get current date
        // var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
        // var last = first + 6; // last day is the first day + 6

        // var firstday = new Date(curr.setDate(first));
        // var lastday = new Date(curr.setDate(last));
        // console.log(firstday+'   '+lastday);
            $(data).addClass("active");
            $(data).attr("style","background-color:rgb(242,101,34);border-color:rgb(242,101,34);");
            state_id=$('#state_list option:selected').val();
            district_id=$('#district_list option:selected').val();
            if($(data).attr('id')=='current_month')
                 getcurrentdata(state_id=0,district_id=0,month=0,year=0,view_type='m');
             if($(data).attr('id')=='current_day')
                 getcurrentdata(state_id=0,district_id=0,month=0,year=0,view_type='d');
              if($(data).attr('id')=='current_week')
                 getcurrentdata(state_id=0,district_id=0,month=0,year=0,view_type='w');




        }

 
    function openNav(data,calendar_id,calendar_ida=0,count_data=0,ind_rank=0,hh_rank=0,percapita=0) {
       
          document.getElementById("mySidenav").style.width = "500px"; 
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
             url: 'calendar/getcalendardata_byid',
             async: true, 
             data:{"id":calendar_id},

            beforeSend: function() {
                $(".spin-loader").attr('style', 'display:block');
            },
            complete: function() {
                $(".spin-loader").attr('style', 'display:none');
            },
            success: function(res) {
               
                $("#highlight_state").html(res.state); 
                $("#highlight_district").html(res.district); 
                $("#highlight_subdistrict").html(res.sub_distt); 
                $("#highlight_village").html(res.town_village); 
                // geo_location='';
                // if(res.town_village=='')
                //         geo_location=res.sub_distt+ 'Villg.';    
                //     if(res.sub_distt=='')
                //             geo_location=res.district+ 'Distt.';
                //         if(res.district=='')                           
                //              geo_location=res.state+ 'State';
                //         else
                //              geo_location=res.district+ 'Distt.';
                //     else
                //          geo_location=res.sub_distt+ ' Sub-Distt.';
                // else

                //     geo_location=res.town_village+' Villg.';

                  

                 $("#village_detail").html(res.location_details+' - Geographic Intel');
                 $("#nodal,#totalindi_rank,#totalhh_rank,#totalpercapita_rank").html("");  
                $("#nodal").html(res.nodal);
                $("#totalindi_rank").html('Rank : '+ind_rank+' / '+count_data);
                $("#totalhh_rank").html('Rank : '+hh_rank+' / '+count_data);
                $("#totalpercapita_rank").html('Rank : '+percapita+' / '+count_data);
                // $("#website").html('<a href="'+res.website+'">'+res.website+'</a>');  
                $("#highlight_state").html(res.department_name); 
                $("#total_indidual").html('<i class="fas fa-user" style="padding-right:7px"></i>'+res.total_individuals);  
                 $("#total_hh").html('<i class="fas fa-home" style="padding-right:7px"></i>'+res.total_hhs); 
                $("#percapita").html('<i class="fas fa-money-bill-wave" style="padding-right:7px"></i> ₹'+res.per_captita_incme); 
                $("#area").html('<i class="fas fa-map" style="padding-right:7px"></i>'+res.area_km+'km²'); 

                $("#dept").html('Department of '+res.department_name);    
                       
                // $("#nodal").html(res.Organisers);
                $("#language").html(res.official_language);
                $("#local_indivual").html(res.local_individuals); 

                $("#festive_audience").html(res.event_participants); 
                 $("#event_desc").html(res.descptn);               
                 $("#startperiod").html(res.timeline);                 
                 $("#highlight_symbol").hide();
                 $("#icon_section").html(res.icon);
                 $("#endd,#endm").html("");                
                 if(res.start!=res.end)
                    {
                        $("#endd").html(res.end);
                        $("#endm").html(res.end_month);  
                        $("#highlight_symbol").show();
                    }

                 $("#startd").html(res.start);
                 $("#startm").html(res.start_month);
                 $("#festival_name").html(res.festival_name);
                 $("#event_name").html(res.address);
                 $("#event_image").html('<img src="'+res.event_url+'" width="477px" height="250px" style="border: none;border-radius: 10px;margin-left:10px;"></img> ');
                 $("#timeline").html('<i class="fa fa-calendar" aria-hidden="true"></i> '+res.timeline);
                 $("#timeline_date").html('<span style="margin-right: 8px;">📅</span>'+res.timeline+'<div style="border-top: 1px solid #000; margin: 6px 0; width: 70%;"></div><span style="margin-right: 8px;">⏰</span>NA');
                 $("#sqft").html('<i class="fas fa-chart-area" style="padding-right:7px"></i>'+res.population_sqft);
                 $("#address").html('<span style="margin-right: 8px;">📍</span> '+res.address);
                 
                 frame_str='';
                
                 remaining=res.remainingdays.toString();
                 remaining= remaining.replace("+", "");
                 pagination=res.totaldays/10;
                 remainder = res.totaldays % 10;
                 remain_days_count=1; 
                 count_days= (res.totaldays>30) ? 4 : 3;
                    for(i=0;i<count_days;i++)
                    {
                       frame_str +='<tr>';
                       length=10;
                       if(i==2)
                          lenght=remainder;
                       for(j=0;j<length;j++)
                       {
                           if(i==3 && res.totaldays>30)
                            j=length;
                            style='';
                          if(res.remainingdays>=remain_days_count)
                            style='background-color:#7cd4c8';
                          frame_str +='<td class="td-tab-days slctd-dates-lv" style="'+style+'"></td>';
                          remain_days_count++;

                       }
                        frame_str +='</tr>';
                    }
                 // $("#timeline_date").html(res.timeline);     
                 $("#x_population").html(res.total_xpopulation);          
                 $("#timeline_days").html('<div class="align-items-center col-12  text-warning"><table class="table-days">'+frame_str+'<tr><td colspan=8 style="color:#45968a;background-color:transparent; font-weight: bold;">'+res.remainingdays+' DAYS LEFT</td></tr></table></div>');
                 $(".map-container").html("");
                 $(".map-container").html('<iframe width="500" height="170" frameborder="0" scrolling="no" marginheight="0"   marginwidth="0"   src="https://maps.google.com/maps?q='+res.latitude+','+res.longitude+'&hl=en&z=14&amp;output=embed"> </iframe>');
               
            }
        });
        if(calendar_ida!=1)
          $(data).attr("onClick","closeNav("+calendar_id+",this)");
   }

function closeNav(calendar_id,data) {
             document.getElementById("mySidenav").style.width = "0";
             $(data).attr("onClick","openNav("+calendar_id+",this)");
}

//Header menu hide and show based on open popup.
L.Map.addInitHook(function () {
    this.on('popupopen', function () {
        document.getElementById('horizontal').style.display = 'none';
    });

    this.on('popupclose', function () {
        document.getElementById('horizontal').style.display = 'block';
    });
});
//Header menu hide and show based on open popup.
</script>
