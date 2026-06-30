@extends('layout.master')
@push('plugin-styles')

<link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.dataTables.min.css') }}">
<link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.dataTables.min.css" rel="stylesheet" />

<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
@endpush

@section('content')
<style>
    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        /* display: none;*/
        padding: 0px 0;
        border: none;
    }

    .legend {
        line-height: 18px;
        color: #555;
    }

    .legend span {
        width: 20px;
        height: 7px;
        float: left;
        margin-right: 8px;

    }

    .leaflet-control-container .leaflet-routing-container-hide {
        display: none;
    }
.circle {
  border: 1px solid #CCC;
  border-radius: 19px;
  display: inline-block;
}

.inner {
     width: 32px;
    height: 32px;
    line-height: 32px;
  background-color: #71c019;
  border-radius: 15px;
  margin: 3px;
/*  height: 30px;
  width: 30px;*/
  text-align: center;
  color:#fff;
 font-size: 12px;
}
</style>
<div class="customize-row">
    <div class="col-lg-12 col-xl-12 map-section tabcontent active" id="maptab">
        <div class="card">
            <div class="card-body map-view map-section" id="map"></div>
        </div>

    </div>
    <div class="col-lg-12 col-xl-12 data-section tabcontent" id="tabletab">
        <div class="card">
            <div class="card-body grid-section">
                <div class="table-responsive">
                    <table id="griddata" class="table display " style="width:100%"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="spin-loader" style="display:none">
    <div class="sk-chase">
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
    </div>
</div>

<div id="mymodal-subordinate" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose SO </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="subordinatelist" style="color:#fff;">



                @if(Auth::user()->user_type =='ASM')

                @for ($i = 0; $i < count($subordinate); $i++) <div class="form-check form-check-inline filter-data">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input show_subordinate" name="subordinate" value="{{$subordinate[$i]->id}}">
                        {{$subordinate[$i]->firstname}} {{$subordinate[$i]->lastname}}
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>


            <!--  <input type="radio" name="subordinate" value="{{$subordinate[$i]->id}}" class="show_subordinate"> {{$subordinate[$i]->firstname}} {{$subordinate[$i]->lastname}}</input><br> -->
            @endfor
            <div class="modal-footer">
                <div class="form-group">
                    <button class="btn btn-primary" name="filter" id="filter_byso">Apply</button>
                </div>
            </div>

            

            @endif





        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-image" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Outlet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">

                <div id="imageview">
                </div>

            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div id="mymodal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Locality Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">

                <div id="changeradio">
                </div>

            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div id="mymodal-new" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter outlet details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/outlet/store')}}" id="outlet" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class='form-control-lg'>

                   
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12" id="alertstatus">

                            </div>

                            <div class="col-md-6 grid-margin">



                                <div class="form-group">
                                    <label for="exampleInputText1">Outlet Name*</label>
                                    <input type="text" class="form-control" id="outlet_name" name="outlet_name" value="" placeholder="Outlet Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputText1">Proprietor Name*</label>
                                    <input type="text" class="form-control" id="owner_name" name="owner_name" value="" placeholder="Owner Name">
                                </div>
                               <!--  <div class="form-group">
                                    <label for="exampleFormControlSelect1">Channel</label>
                                    <select class="form-control" id="channel_name" name="channel_name">
                                        <option selected="" disabled="">Select Channel</option>
                                        @for ($i = 0; $i < count($channel); $i++) <option value="{{ $channel[$i]->refid }}">{{ $channel[$i]->name }}</option>
                                            @endfor


                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Sub Channel</label>
                                    <select class="form-control" id="sub_channel_name" name="sub_channel_name">
                                        <option selected="" disabled="">Select Category*</option>
                                        <option value='1'>Bakery</option>
                                        <option value='2'>Chats & Snacks</option>
                                        <option value='3'>Chemist</option>
                                        <option value='4'>Cig / Paan Kiosk</option>
                                        <option value='5'>Coffee Shop</option>
                                        <option value='6'>Cosmetc / Fancy Str</option>
                                        <option value='7'>Dairy Str</option>
                                        <option value='8'>Dry Fruit Str</option>
                                        <option value='9'>Hot Tea Shop</option>
                                        <option value='10'>Hotel / Lodge</option>
                                        <option value='11'>Ice Cream Parlour</option>
                                        <option value='12'>Juice Centr</option>
                                        <option value='13'>Kirana Str</option>
                                        <option value='14'>Liquor Str</option>
                                        <option value='15'>Restaurnt</option>
                                        <option value='16'>Supermarket</option>
                                        <option value='17'>Sweet Shop</option>
                                        <option value='18'>Wholesale</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin: 0 0 1.5rem;">
                                    <label for="exampleFormControlTextarea1">Address*</label>
                                    <textarea class="form-control" id="address" rows="2" name="address" placeholder="Address"></textarea>
                                    <input type="hidden" name="gio_point" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputMobile">Mobile</label>
                                    <input type="text" class="form-control"  id="mobile_no" name="mobile_no"  placeholder="Mobile number">
                                </div>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6 grid-margin ">
                                <div class="form-group">
                                    <label for="exampleInputMobile">PAN Number</label>
                                    <input type="text" class="form-control" id="pan_no" name="pan_no" placeholder="PAN number">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputMobile">TAN Number</label>

                                    <input type="text" class="form-control" id="tan_no" name="tan_no" placeholder="TAN number">

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputMobile">Shop and Establishment Number</label>

                                    <input type="text" class="form-control" id="shop_establish_no" name="shop_establish_no" placeholder="Establishment number">

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputMobile">GST Number</label>

                                    <input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="GST number">

                                </div>
                                


                                <div class="form-group">
                                    <label>File upload</label>
                                    <input type="file" name="img" class="file-upload-default" accept="image/*" >
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                        </span>
                                    </div>
                                </div>
                                


                            </div>

                        </div>
                   
                </div>
            </div><!-- /.modal-content -->
            <div class="modal-footer">
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Add Outlet</button>
                    </div>
            </div>
            </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div id="mymodal-new-outlet" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12" id="alertstatus_list">

                    </div>
                    <div class="col-md-12">
                        <h6>Outlet List</h6>
                        <table id="outlet_list_tbl" class="table dataTable no-footer" role="grid" aria-describedby="outlet_info">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Outlet</th>
                                    <th>Channel</th>
                                    <th>Sub Channel</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>

                                @for ($i = 0; $i < count($list_outlet); $i++) <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$list_outlet[$i]->outlet_name}}</td>
                                    <td>{{$list_outlet[$i]->channel}}</td>
                                    <td>{{$list_outlet[$i]->subchannel}}</td>
                                    <td><i class="fas fa-eye"></i>
                                        <i onclick="deleteoutlet(this)" id="{{$list_outlet[$i]->refid}}" class="fa fa-trash" /></i>
                                    </td>
                                    </tr>

                                    @endfor


                            </tbody>

                        </table>

                    </div>
                </div>



            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div id="mymodal-filter" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Locality Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="dropdown">


                @if(Auth::user()->user_type =='SO')
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="filter" value="PC">
                            PC
                            <i class="input-frame"></i></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="filter" value="Distributor">
                            Distributor
                            <i class="input-frame"></i></label>
                    </div>

                    <div class="filter_action" style="display: none;">
                        <i class="fa fa-filter" aria-hidden="true" id="filterresult"></i>
                        <i class="far fa-trash-alt" aria-hidden="true" id="clearresult"></i>
                    </div>

                </div>

                @endif

                <div style="display:none;" id="showlist_user">


                </div>


            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@php
$currtime = "";
$currtime = date("m:d:Y h:i:s");
$str = str_replace(
array(":"," "),
array(" "),
$currtime
);

use Nullix\CryptoJsAes\CryptoJsAes;

include ('./CryptoJsAes.php');

$originalValue = "Z4NfsW7qUA8XGiQ/C0pcXtK8fMmaPcP52QX7cTW/cHY=";
$encrypted = CryptoJsAes::encrypt($originalValue, $str);
@endphp
<script>
    Globalobject = new Array();
    var input_obj = {};

    ////////////////////////////////////////Declaration ///////////////////////////////////////////////////////
    var geojson;
    var geo_layer = [];
    var table;
    var global_chart = [];
    var legend_arr = [];
    var overlay_arr = [];
    var grayscale;
    var streets;
    var circle_marker = [];
    var result = [];
    var layer_bound = [];
    var layerclick = [];
    var table_obj = [];
    var showlist_user_id = [];
    var showlist_distributor_id = [];
    var last_clicked_type = [];
    var bound_check = [];
    var bound_type = [];
    var current_location = [];
    var route = false;
    var destination_location = [];
    var outlettbl;
    var filterclear = false;
    var dynamic_control = [];
    var outlet_markerarray = [];
    var outlet_marker_cluster = [];
    var markercluster = new L.MarkerClusterGroup();
    var filter_so = [];
     var markercluster = new L.MarkerClusterGroup({ 
          iconCreateFunction: function (cluster) {
              var markers = cluster.getAllChildMarkers();
              var html = '<div class="circle">  <div class="inner">' + markers.length + '</div></div>';
              return L.divIcon({ html: html, className: 'mycluster', iconSize: L.point(32, 32) });
          },
          spiderfyOnMaxZoom: true, showCoverageOnHover: true, zoomToBoundsOnClick: true 
      });
      




    ////////////////////////////////////////Declaration///////////////////////////////////////////////////////

    /////////////////////////////////////////////Map section /////////////////////////////////////////////////////////////


    var map = L.map('map', {
        zoomControl: false,
        zoomSnap: 0.25,
        maxZoom: 20


    }).setView([23.473324, 77.947998], 5);
    map.createPane('tool');
    map.getPane('tool').style.zIndex = 999;


    var gl = L.mapboxGL({
        attribution: "",
        style: 'https://api.maptiler.com/maps/c32455b0-bf68-4a55-b8d7-e0f8a2e51fdd/style.json?key=t48sy8w2bGMZMaxREggf'
    }).addTo(map);


    grayscale = L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {

            id: 'mapbox.light'
        }),
        streets = L.esri.basemapLayer('Imagery');


    var baseLayers = {
        "<img class='map-opt' src='{{ url('/storage/normal.png') }}' alt='Map View' />": gl,
        "<img class='map-opt' src='{{ url('/storage/satelite.png') }}' alt='satelite View' />": streets
    };

    var baseLayers2 = {

    };



    layerControl = L.control.layers(baseLayers, null, {
        position: 'bottomright'
    });



    layerControl.addTo(map);

    map.doubleClickZoom.disable();

    map.createPane('labels');

    map.on('click', function(e) {
        if (($(".leaflet-range-control").hasClass('show-range')))
            $(".leaflet-range-control").toggleClass('show-range');
        destination_location['lat'] = e.latlng.lat;
        destination_location['lon'] = e.latlng.lng;
        if (route == true) {
            // control_route_map=L.Routing.control({
            //     waypoints: [
            //       L.latLng(current_location['lat'],current_location['lon']),
            //       L.latLng(destination_location['lat'],destination_location['lon'])
            //     ],
            //     createMarker: function (i, start, n){

            //                   var greenIcon = L.icon({
            //                           iconUrl: 'css/images/marker-icon.png',
            //                           shadowUrl: '',
            //                           iconSize:     [10, 10], // size of the icon
            //                           shadowSize:   [10, 10], // size of the shadow
            //                           iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
            //                           shadowAnchor: [10,10],  // the same for the shadow
            //                           popupAnchor:  [10, 10] // point from which the popup should open relative to the iconAnchor
            //                       });

            //                   var marker = L.marker (start.latLng, {
            //                               draggable: true,
            //                               bounceOnAdd: false,
            //                               bounceOnAddOptions: {
            //                                   duration: 1000,
            //                                   height: 800, 
            //                                   function(){
            //                                       (bindPopup(myPopup).openOn(map))
            //                                   }
            //                               },
            //                               icon: greenIcon
            //                   })
            //                   return marker;
            //                 }
            //   }).addTo(map);

            // $(".leaflet-routing-container").remove();

            str = "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + destination_location['lat'] + "," + destination_location['lon'] + "'/";
            window.open(str, 'window name', 'window settings');



        }


        route = false;
    });

    map.getPane('labels').style.zIndex = 650;
    map.getPane('labels').style.pointerEvents = 'none';

    map.on('zoomend', function() {


        zoomrange = map.getZoom();

        $.each(layer_bound, function(k, v) {

            layer = v;

            if (v !== undefined) {
                if (bound_type[k] == 1) {
                    if (layer.feature.id !== undefined)
                        layer.setStyle({
                            weight: (zoomrange >= 16) ? 5 : 0.5,
                            stroke: (zoomrange >= 16) ? 5 : 0.5,
                        });
                }
                if (bound_type[k] == 2) {
                    for (i = 0; i < v.length; i++) {
                        layer = v[i].layer_id;
                        if (layer !== undefined) {

                            if (layer.feature.id !== undefined)
                                layer.setStyle({
                                    weight: (zoomrange >= 16) ? 5 : 0.5,
                                    stroke: (zoomrange >= 16) ? 5 : 0.5,
                                });
                        }

                    }

                }
            }
        });


    });

    /////////////Easy Buttonfunction ///////////////////////

    var opacity_button = L.easyButton({
        position: 'bottomright',
        states: [{
            stateName: 'globe-layer',
            icon: 'fa fa-cog',
            title: 'Change map opacity',
            onClick: function(control) {
                $(".leaflet-range-control").toggleClass('show-range');
            }
        }]
    });


    var range_control_button = L.control.range({
        orient: 'horizontal',
        value: 100,
        position: 'bottomright',

    });
    overlay_arr[0] = 1;
    range_control_button.on('change input', function(e) {
        opacityval = e.value / 100;
        overlay_arr[0] = opacityval;
        change_opacity();
    });

    map.addControl(range_control_button);

    if (("{{Auth::user()->user_type}}") == 'SO') {
        var filter = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-filter',
                title: 'Filter',
                onClick: function(control) {
                    $('#mymodal-filter').modal('show');
                }
            }]
        });
        map.addControl(filter);
    }

    if (("{{Auth::user()->user_type}}") == 'ASM') {

        var filter = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'subordinate-list',
                icon: 'fa fa-users',
                title: 'subordinate-list',
                onClick: function(control) {
                    $('#mymodal-subordinate').modal('show');
                }
            }]
        });
        map.addControl(filter);
    }


    var locationcontrol = L.control.locate({
        position: 'bottomright',
        flyTo: false,
        keepCurrentZoomLevel: true,
        setView: false,
        drawMarker: true,
        showCompass: true,
        icon: 'fa fa-crosshairs',
        strings: {
            title: "Show me where I am."
        },

        getLocationBounds: function(locationEvent) {

            return locationEvent.bounds;
        },


    });
    map.addControl(locationcontrol);


    map.on('locationfound', function(e) {
        var locLat = e.latlng.lat;
        var locLng = e.latlng.lng;
        current_location['lat'] = locLat;
        current_location['lon'] = locLng;


    });

    var findway = L.easyButton({
        position: 'bottomright',
        states: [{
            stateName: 'globe-layer',
            icon: '<i class="fas fa-location-arrow"></i>',
            title: 'Navigate',
            onClick: function(control) {
                locationcontrol.start();
                showCompass = true;
                route = true;

            }
        }]
    });
 

    var filer_clear = L.easyButton({
        position: 'bottomright',
        states: [{
            stateName: 'Clear Filter',
            icon: '<i class="fa fa-trash"></i>',
            title: 'Clear',
            onClick: function(control) {
                $("#clearresult").click();
                showboundbyusertype('');
            }
        }]
    });
     map.addControl(findway);
if (("{{Auth::user()->user_type}}") != 'SUPPORT') {
    dynamic_control.push(filer_clear);
     map.addControl(filer_clear);
    dynamic_control[0].disable();
    map.addControl(opacity_button);

}


   
   
 




    ///////////////////////////Easy Button End/////////////////////////////////////////////////////////////////////////////////////////////////
    var CryptoJS = CryptoJS || function(u, p) {
        var d = {},
            l = d.lib = {},
            s = function() {},
            t = l.Base = {
                extend: function(a) {
                    s.prototype = this;
                    var c = new s;
                    a && c.mixIn(a);
                    c.hasOwnProperty("init") || (c.init = function() {
                        c.$super.init.apply(this, arguments)
                    });
                    c.init.prototype = c;
                    c.$super = this;
                    return c
                },
                create: function() {
                    var a = this.extend();
                    a.init.apply(a, arguments);
                    return a
                },
                init: function() {},
                mixIn: function(a) {
                    for (var c in a) a.hasOwnProperty(c) && (this[c] = a[c]);
                    a.hasOwnProperty("toString") && (this.toString = a.toString)
                },
                clone: function() {
                    return this.init.prototype.extend(this)
                }
            },
            r = l.WordArray = t.extend({
                init: function(a, c) {
                    a = this.words = a || [];
                    this.sigBytes = c != p ? c : 4 * a.length
                },
                toString: function(a) {
                    return (a || v).stringify(this)
                },
                concat: function(a) {
                    var c = this.words,
                        e = a.words,
                        j = this.sigBytes;
                    a = a.sigBytes;
                    this.clamp();
                    if (j % 4)
                        for (var k = 0; k < a; k++) c[j + k >>> 2] |= (e[k >>> 2] >>> 24 - 8 * (k % 4) & 255) << 24 - 8 * ((j + k) % 4);
                    else if (65535 < e.length)
                        for (k = 0; k < a; k += 4) c[j + k >>> 2] = e[k >>> 2];
                    else c.push.apply(c, e);
                    this.sigBytes += a;
                    return this
                },
                clamp: function() {
                    var a = this.words,
                        c = this.sigBytes;
                    a[c >>> 2] &= 4294967295 <<
                        32 - 8 * (c % 4);
                    a.length = u.ceil(c / 4)
                },
                clone: function() {
                    var a = t.clone.call(this);
                    a.words = this.words.slice(0);
                    return a
                },
                random: function(a) {
                    for (var c = [], e = 0; e < a; e += 4) c.push(4294967296 * u.random() | 0);
                    return new r.init(c, a)
                }
            }),
            w = d.enc = {},
            v = w.Hex = {
                stringify: function(a) {
                    var c = a.words;
                    a = a.sigBytes;
                    for (var e = [], j = 0; j < a; j++) {
                        var k = c[j >>> 2] >>> 24 - 8 * (j % 4) & 255;
                        e.push((k >>> 4).toString(16));
                        e.push((k & 15).toString(16))
                    }
                    return e.join("")
                },
                parse: function(a) {
                    for (var c = a.length, e = [], j = 0; j < c; j += 2) e[j >>> 3] |= parseInt(a.substr(j,
                        2), 16) << 24 - 4 * (j % 8);
                    return new r.init(e, c / 2)
                }
            },
            b = w.Latin1 = {
                stringify: function(a) {
                    var c = a.words;
                    a = a.sigBytes;
                    for (var e = [], j = 0; j < a; j++) e.push(String.fromCharCode(c[j >>> 2] >>> 24 - 8 * (j % 4) & 255));
                    return e.join("")
                },
                parse: function(a) {
                    for (var c = a.length, e = [], j = 0; j < c; j++) e[j >>> 2] |= (a.charCodeAt(j) & 255) << 24 - 8 * (j % 4);
                    return new r.init(e, c)
                }
            },
            x = w.Utf8 = {
                stringify: function(a) {
                    try {
                        return decodeURIComponent(escape(b.stringify(a)))
                    } catch (c) {
                        throw Error("Malformed UTF-8 data");
                    }
                },
                parse: function(a) {
                    return b.parse(unescape(encodeURIComponent(a)))
                }
            },
            q = l.BufferedBlockAlgorithm = t.extend({
                reset: function() {
                    this._data = new r.init;
                    this._nDataBytes = 0
                },
                _append: function(a) {
                    "string" == typeof a && (a = x.parse(a));
                    this._data.concat(a);
                    this._nDataBytes += a.sigBytes
                },
                _process: function(a) {
                    var c = this._data,
                        e = c.words,
                        j = c.sigBytes,
                        k = this.blockSize,
                        b = j / (4 * k),
                        b = a ? u.ceil(b) : u.max((b | 0) - this._minBufferSize, 0);
                    a = b * k;
                    j = u.min(4 * a, j);
                    if (a) {
                        for (var q = 0; q < a; q += k) this._doProcessBlock(e, q);
                        q = e.splice(0, a);
                        c.sigBytes -= j
                    }
                    return new r.init(q, j)
                },
                clone: function() {
                    var a = t.clone.call(this);
                    a._data = this._data.clone();
                    return a
                },
                _minBufferSize: 0
            });
        l.Hasher = q.extend({
            cfg: t.extend(),
            init: function(a) {
                this.cfg = this.cfg.extend(a);
                this.reset()
            },
            reset: function() {
                q.reset.call(this);
                this._doReset()
            },
            update: function(a) {
                this._append(a);
                this._process();
                return this
            },
            finalize: function(a) {
                a && this._append(a);
                return this._doFinalize()
            },
            blockSize: 16,
            _createHelper: function(a) {
                return function(b, e) {
                    return (new a.init(e)).finalize(b)
                }
            },
            _createHmacHelper: function(a) {
                return function(b, e) {
                    return (new n.HMAC.init(a,
                        e)).finalize(b)
                }
            }
        });
        var n = d.algo = {};
        return d
    }(Math);
    (function() {
        var u = CryptoJS,
            p = u.lib.WordArray;
        u.enc.Base64 = {
            stringify: function(d) {
                var l = d.words,
                    p = d.sigBytes,
                    t = this._map;
                d.clamp();
                d = [];
                for (var r = 0; r < p; r += 3)
                    for (var w = (l[r >>> 2] >>> 24 - 8 * (r % 4) & 255) << 16 | (l[r + 1 >>> 2] >>> 24 - 8 * ((r + 1) % 4) & 255) << 8 | l[r + 2 >>> 2] >>> 24 - 8 * ((r + 2) % 4) & 255, v = 0; 4 > v && r + 0.75 * v < p; v++) d.push(t.charAt(w >>> 6 * (3 - v) & 63));
                if (l = t.charAt(64))
                    for (; d.length % 4;) d.push(l);
                return d.join("")
            },
            parse: function(d) {
                var l = d.length,
                    s = this._map,
                    t = s.charAt(64);
                t && (t = d.indexOf(t), -1 != t && (l = t));
                for (var t = [], r = 0, w = 0; w <
                    l; w++)
                    if (w % 4) {
                        var v = s.indexOf(d.charAt(w - 1)) << 2 * (w % 4),
                            b = s.indexOf(d.charAt(w)) >>> 6 - 2 * (w % 4);
                        t[r >>> 2] |= (v | b) << 24 - 8 * (r % 4);
                        r++
                    } return p.create(t, r)
            },
            _map: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="
        }
    })();
    (function(u) {
        function p(b, n, a, c, e, j, k) {
            b = b + (n & a | ~n & c) + e + k;
            return (b << j | b >>> 32 - j) + n
        }

        function d(b, n, a, c, e, j, k) {
            b = b + (n & c | a & ~c) + e + k;
            return (b << j | b >>> 32 - j) + n
        }

        function l(b, n, a, c, e, j, k) {
            b = b + (n ^ a ^ c) + e + k;
            return (b << j | b >>> 32 - j) + n
        }

        function s(b, n, a, c, e, j, k) {
            b = b + (a ^ (n | ~c)) + e + k;
            return (b << j | b >>> 32 - j) + n
        }
        for (var t = CryptoJS, r = t.lib, w = r.WordArray, v = r.Hasher, r = t.algo, b = [], x = 0; 64 > x; x++) b[x] = 4294967296 * u.abs(u.sin(x + 1)) | 0;
        r = r.MD5 = v.extend({
            _doReset: function() {
                this._hash = new w.init([1732584193, 4023233417, 2562383102, 271733878])
            },
            _doProcessBlock: function(q, n) {
                for (var a = 0; 16 > a; a++) {
                    var c = n + a,
                        e = q[c];
                    q[c] = (e << 8 | e >>> 24) & 16711935 | (e << 24 | e >>> 8) & 4278255360
                }
                var a = this._hash.words,
                    c = q[n + 0],
                    e = q[n + 1],
                    j = q[n + 2],
                    k = q[n + 3],
                    z = q[n + 4],
                    r = q[n + 5],
                    t = q[n + 6],
                    w = q[n + 7],
                    v = q[n + 8],
                    A = q[n + 9],
                    B = q[n + 10],
                    C = q[n + 11],
                    u = q[n + 12],
                    D = q[n + 13],
                    E = q[n + 14],
                    x = q[n + 15],
                    f = a[0],
                    m = a[1],
                    g = a[2],
                    h = a[3],
                    f = p(f, m, g, h, c, 7, b[0]),
                    h = p(h, f, m, g, e, 12, b[1]),
                    g = p(g, h, f, m, j, 17, b[2]),
                    m = p(m, g, h, f, k, 22, b[3]),
                    f = p(f, m, g, h, z, 7, b[4]),
                    h = p(h, f, m, g, r, 12, b[5]),
                    g = p(g, h, f, m, t, 17, b[6]),
                    m = p(m, g, h, f, w, 22, b[7]),
                    f = p(f, m, g, h, v, 7, b[8]),
                    h = p(h, f, m, g, A, 12, b[9]),
                    g = p(g, h, f, m, B, 17, b[10]),
                    m = p(m, g, h, f, C, 22, b[11]),
                    f = p(f, m, g, h, u, 7, b[12]),
                    h = p(h, f, m, g, D, 12, b[13]),
                    g = p(g, h, f, m, E, 17, b[14]),
                    m = p(m, g, h, f, x, 22, b[15]),
                    f = d(f, m, g, h, e, 5, b[16]),
                    h = d(h, f, m, g, t, 9, b[17]),
                    g = d(g, h, f, m, C, 14, b[18]),
                    m = d(m, g, h, f, c, 20, b[19]),
                    f = d(f, m, g, h, r, 5, b[20]),
                    h = d(h, f, m, g, B, 9, b[21]),
                    g = d(g, h, f, m, x, 14, b[22]),
                    m = d(m, g, h, f, z, 20, b[23]),
                    f = d(f, m, g, h, A, 5, b[24]),
                    h = d(h, f, m, g, E, 9, b[25]),
                    g = d(g, h, f, m, k, 14, b[26]),
                    m = d(m, g, h, f, v, 20, b[27]),
                    f = d(f, m, g, h, D, 5, b[28]),
                    h = d(h, f,
                        m, g, j, 9, b[29]),
                    g = d(g, h, f, m, w, 14, b[30]),
                    m = d(m, g, h, f, u, 20, b[31]),
                    f = l(f, m, g, h, r, 4, b[32]),
                    h = l(h, f, m, g, v, 11, b[33]),
                    g = l(g, h, f, m, C, 16, b[34]),
                    m = l(m, g, h, f, E, 23, b[35]),
                    f = l(f, m, g, h, e, 4, b[36]),
                    h = l(h, f, m, g, z, 11, b[37]),
                    g = l(g, h, f, m, w, 16, b[38]),
                    m = l(m, g, h, f, B, 23, b[39]),
                    f = l(f, m, g, h, D, 4, b[40]),
                    h = l(h, f, m, g, c, 11, b[41]),
                    g = l(g, h, f, m, k, 16, b[42]),
                    m = l(m, g, h, f, t, 23, b[43]),
                    f = l(f, m, g, h, A, 4, b[44]),
                    h = l(h, f, m, g, u, 11, b[45]),
                    g = l(g, h, f, m, x, 16, b[46]),
                    m = l(m, g, h, f, j, 23, b[47]),
                    f = s(f, m, g, h, c, 6, b[48]),
                    h = s(h, f, m, g, w, 10, b[49]),
                    g = s(g, h, f, m,
                        E, 15, b[50]),
                    m = s(m, g, h, f, r, 21, b[51]),
                    f = s(f, m, g, h, u, 6, b[52]),
                    h = s(h, f, m, g, k, 10, b[53]),
                    g = s(g, h, f, m, B, 15, b[54]),
                    m = s(m, g, h, f, e, 21, b[55]),
                    f = s(f, m, g, h, v, 6, b[56]),
                    h = s(h, f, m, g, x, 10, b[57]),
                    g = s(g, h, f, m, t, 15, b[58]),
                    m = s(m, g, h, f, D, 21, b[59]),
                    f = s(f, m, g, h, z, 6, b[60]),
                    h = s(h, f, m, g, C, 10, b[61]),
                    g = s(g, h, f, m, j, 15, b[62]),
                    m = s(m, g, h, f, A, 21, b[63]);
                a[0] = a[0] + f | 0;
                a[1] = a[1] + m | 0;
                a[2] = a[2] + g | 0;
                a[3] = a[3] + h | 0
            },
            _doFinalize: function() {
                var b = this._data,
                    n = b.words,
                    a = 8 * this._nDataBytes,
                    c = 8 * b.sigBytes;
                n[c >>> 5] |= 128 << 24 - c % 32;
                var e = u.floor(a /
                    4294967296);
                n[(c + 64 >>> 9 << 4) + 15] = (e << 8 | e >>> 24) & 16711935 | (e << 24 | e >>> 8) & 4278255360;
                n[(c + 64 >>> 9 << 4) + 14] = (a << 8 | a >>> 24) & 16711935 | (a << 24 | a >>> 8) & 4278255360;
                b.sigBytes = 4 * (n.length + 1);
                this._process();
                b = this._hash;
                n = b.words;
                for (a = 0; 4 > a; a++) c = n[a], n[a] = (c << 8 | c >>> 24) & 16711935 | (c << 24 | c >>> 8) & 4278255360;
                return b
            },
            clone: function() {
                var b = v.clone.call(this);
                b._hash = this._hash.clone();
                return b
            }
        });
        t.MD5 = v._createHelper(r);
        t.HmacMD5 = v._createHmacHelper(r)
    })(Math);
    (function() {
        var u = CryptoJS,
            p = u.lib,
            d = p.Base,
            l = p.WordArray,
            p = u.algo,
            s = p.EvpKDF = d.extend({
                cfg: d.extend({
                    keySize: 4,
                    hasher: p.MD5,
                    iterations: 1
                }),
                init: function(d) {
                    this.cfg = this.cfg.extend(d)
                },
                compute: function(d, r) {
                    for (var p = this.cfg, s = p.hasher.create(), b = l.create(), u = b.words, q = p.keySize, p = p.iterations; u.length < q;) {
                        n && s.update(n);
                        var n = s.update(d).finalize(r);
                        s.reset();
                        for (var a = 1; a < p; a++) n = s.finalize(n), s.reset();
                        b.concat(n)
                    }
                    b.sigBytes = 4 * q;
                    return b
                }
            });
        u.EvpKDF = function(d, l, p) {
            return s.create(p).compute(d,
                l)
        }
    })();
    CryptoJS.lib.Cipher || function(u) {
        var p = CryptoJS,
            d = p.lib,
            l = d.Base,
            s = d.WordArray,
            t = d.BufferedBlockAlgorithm,
            r = p.enc.Base64,
            w = p.algo.EvpKDF,
            v = d.Cipher = t.extend({
                cfg: l.extend(),
                createEncryptor: function(e, a) {
                    return this.create(this._ENC_XFORM_MODE, e, a)
                },
                createDecryptor: function(e, a) {
                    return this.create(this._DEC_XFORM_MODE, e, a)
                },
                init: function(e, a, b) {
                    this.cfg = this.cfg.extend(b);
                    this._xformMode = e;
                    this._key = a;
                    this.reset()
                },
                reset: function() {
                    t.reset.call(this);
                    this._doReset()
                },
                process: function(e) {
                    this._append(e);
                    return this._process()
                },
                finalize: function(e) {
                    e && this._append(e);
                    return this._doFinalize()
                },
                keySize: 4,
                ivSize: 4,
                _ENC_XFORM_MODE: 1,
                _DEC_XFORM_MODE: 2,
                _createHelper: function(e) {
                    return {
                        encrypt: function(b, k, d) {
                            return ("string" == typeof k ? c : a).encrypt(e, b, k, d)
                        },
                        decrypt: function(b, k, d) {
                            return ("string" == typeof k ? c : a).decrypt(e, b, k, d)
                        }
                    }
                }
            });
        d.StreamCipher = v.extend({
            _doFinalize: function() {
                return this._process(!0)
            },
            blockSize: 1
        });
        var b = p.mode = {},
            x = function(e, a, b) {
                var c = this._iv;
                c ? this._iv = u : c = this._prevBlock;
                for (var d = 0; d < b; d++) e[a + d] ^=
                    c[d]
            },
            q = (d.BlockCipherMode = l.extend({
                createEncryptor: function(e, a) {
                    return this.Encryptor.create(e, a)
                },
                createDecryptor: function(e, a) {
                    return this.Decryptor.create(e, a)
                },
                init: function(e, a) {
                    this._cipher = e;
                    this._iv = a
                }
            })).extend();
        q.Encryptor = q.extend({
            processBlock: function(e, a) {
                var b = this._cipher,
                    c = b.blockSize;
                x.call(this, e, a, c);
                b.encryptBlock(e, a);
                this._prevBlock = e.slice(a, a + c)
            }
        });
        q.Decryptor = q.extend({
            processBlock: function(e, a) {
                var b = this._cipher,
                    c = b.blockSize,
                    d = e.slice(a, a + c);
                b.decryptBlock(e, a);
                x.call(this,
                    e, a, c);
                this._prevBlock = d
            }
        });
        b = b.CBC = q;
        q = (p.pad = {}).Pkcs7 = {
            pad: function(a, b) {
                for (var c = 4 * b, c = c - a.sigBytes % c, d = c << 24 | c << 16 | c << 8 | c, l = [], n = 0; n < c; n += 4) l.push(d);
                c = s.create(l, c);
                a.concat(c)
            },
            unpad: function(a) {
                a.sigBytes -= a.words[a.sigBytes - 1 >>> 2] & 255
            }
        };
        d.BlockCipher = v.extend({
            cfg: v.cfg.extend({
                mode: b,
                padding: q
            }),
            reset: function() {
                v.reset.call(this);
                var a = this.cfg,
                    b = a.iv,
                    a = a.mode;
                if (this._xformMode == this._ENC_XFORM_MODE) var c = a.createEncryptor;
                else c = a.createDecryptor, this._minBufferSize = 1;
                this._mode = c.call(a,
                    this, b && b.words)
            },
            _doProcessBlock: function(a, b) {
                this._mode.processBlock(a, b)
            },
            _doFinalize: function() {
                var a = this.cfg.padding;
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    a.pad(this._data, this.blockSize);
                    var b = this._process(!0)
                } else b = this._process(!0), a.unpad(b);
                return b
            },
            blockSize: 4
        });
        var n = d.CipherParams = l.extend({
                init: function(a) {
                    this.mixIn(a)
                },
                toString: function(a) {
                    return (a || this.formatter).stringify(this)
                }
            }),
            b = (p.format = {}).OpenSSL = {
                stringify: function(a) {
                    var b = a.ciphertext;
                    a = a.salt;
                    return (a ? s.create([1398893684,
                        1701076831
                    ]).concat(a).concat(b) : b).toString(r)
                },
                parse: function(a) {
                    a = r.parse(a);
                    var b = a.words;
                    if (1398893684 == b[0] && 1701076831 == b[1]) {
                        var c = s.create(b.slice(2, 4));
                        b.splice(0, 4);
                        a.sigBytes -= 16
                    }
                    return n.create({
                        ciphertext: a,
                        salt: c
                    })
                }
            },
            a = d.SerializableCipher = l.extend({
                cfg: l.extend({
                    format: b
                }),
                encrypt: function(a, b, c, d) {
                    d = this.cfg.extend(d);
                    var l = a.createEncryptor(c, d);
                    b = l.finalize(b);
                    l = l.cfg;
                    return n.create({
                        ciphertext: b,
                        key: c,
                        iv: l.iv,
                        algorithm: a,
                        mode: l.mode,
                        padding: l.padding,
                        blockSize: a.blockSize,
                        formatter: d.format
                    })
                },
                decrypt: function(a, b, c, d) {
                    d = this.cfg.extend(d);
                    b = this._parse(b, d.format);
                    return a.createDecryptor(c, d).finalize(b.ciphertext)
                },
                _parse: function(a, b) {
                    return "string" == typeof a ? b.parse(a, this) : a
                }
            }),
            p = (p.kdf = {}).OpenSSL = {
                execute: function(a, b, c, d) {
                    d || (d = s.random(8));
                    a = w.create({
                        keySize: b + c
                    }).compute(a, d);
                    c = s.create(a.words.slice(b), 4 * c);
                    a.sigBytes = 4 * b;
                    return n.create({
                        key: a,
                        iv: c,
                        salt: d
                    })
                }
            },
            c = d.PasswordBasedCipher = a.extend({
                cfg: a.cfg.extend({
                    kdf: p
                }),
                encrypt: function(b, c, d, l) {
                    l = this.cfg.extend(l);
                    d = l.kdf.execute(d,
                        b.keySize, b.ivSize);
                    l.iv = d.iv;
                    b = a.encrypt.call(this, b, c, d.key, l);
                    b.mixIn(d);
                    return b
                },
                decrypt: function(b, c, d, l) {
                    l = this.cfg.extend(l);
                    c = this._parse(c, l.format);
                    d = l.kdf.execute(d, b.keySize, b.ivSize, c.salt);
                    l.iv = d.iv;
                    return a.decrypt.call(this, b, c, d.key, l)
                }
            })
    }();
    (function() {
        for (var u = CryptoJS, p = u.lib.BlockCipher, d = u.algo, l = [], s = [], t = [], r = [], w = [], v = [], b = [], x = [], q = [], n = [], a = [], c = 0; 256 > c; c++) a[c] = 128 > c ? c << 1 : c << 1 ^ 283;
        for (var e = 0, j = 0, c = 0; 256 > c; c++) {
            var k = j ^ j << 1 ^ j << 2 ^ j << 3 ^ j << 4,
                k = k >>> 8 ^ k & 255 ^ 99;
            l[e] = k;
            s[k] = e;
            var z = a[e],
                F = a[z],
                G = a[F],
                y = 257 * a[k] ^ 16843008 * k;
            t[e] = y << 24 | y >>> 8;
            r[e] = y << 16 | y >>> 16;
            w[e] = y << 8 | y >>> 24;
            v[e] = y;
            y = 16843009 * G ^ 65537 * F ^ 257 * z ^ 16843008 * e;
            b[k] = y << 24 | y >>> 8;
            x[k] = y << 16 | y >>> 16;
            q[k] = y << 8 | y >>> 24;
            n[k] = y;
            e ? (e = z ^ a[a[a[G ^ z]]], j ^= a[a[j]]) : e = j = 1
        }
        var H = [0, 1, 2, 4, 8,
                16, 32, 64, 128, 27, 54
            ],
            d = d.AES = p.extend({
                _doReset: function() {
                    for (var a = this._key, c = a.words, d = a.sigBytes / 4, a = 4 * ((this._nRounds = d + 6) + 1), e = this._keySchedule = [], j = 0; j < a; j++)
                        if (j < d) e[j] = c[j];
                        else {
                            var k = e[j - 1];
                            j % d ? 6 < d && 4 == j % d && (k = l[k >>> 24] << 24 | l[k >>> 16 & 255] << 16 | l[k >>> 8 & 255] << 8 | l[k & 255]) : (k = k << 8 | k >>> 24, k = l[k >>> 24] << 24 | l[k >>> 16 & 255] << 16 | l[k >>> 8 & 255] << 8 | l[k & 255], k ^= H[j / d | 0] << 24);
                            e[j] = e[j - d] ^ k
                        } c = this._invKeySchedule = [];
                    for (d = 0; d < a; d++) j = a - d, k = d % 4 ? e[j] : e[j - 4], c[d] = 4 > d || 4 >= j ? k : b[l[k >>> 24]] ^ x[l[k >>> 16 & 255]] ^ q[l[k >>>
                        8 & 255]] ^ n[l[k & 255]]
                },
                encryptBlock: function(a, b) {
                    this._doCryptBlock(a, b, this._keySchedule, t, r, w, v, l)
                },
                decryptBlock: function(a, c) {
                    var d = a[c + 1];
                    a[c + 1] = a[c + 3];
                    a[c + 3] = d;
                    this._doCryptBlock(a, c, this._invKeySchedule, b, x, q, n, s);
                    d = a[c + 1];
                    a[c + 1] = a[c + 3];
                    a[c + 3] = d
                },
                _doCryptBlock: function(a, b, c, d, e, j, l, f) {
                    for (var m = this._nRounds, g = a[b] ^ c[0], h = a[b + 1] ^ c[1], k = a[b + 2] ^ c[2], n = a[b + 3] ^ c[3], p = 4, r = 1; r < m; r++) var q = d[g >>> 24] ^ e[h >>> 16 & 255] ^ j[k >>> 8 & 255] ^ l[n & 255] ^ c[p++],
                        s = d[h >>> 24] ^ e[k >>> 16 & 255] ^ j[n >>> 8 & 255] ^ l[g & 255] ^ c[p++],
                        t =
                        d[k >>> 24] ^ e[n >>> 16 & 255] ^ j[g >>> 8 & 255] ^ l[h & 255] ^ c[p++],
                        n = d[n >>> 24] ^ e[g >>> 16 & 255] ^ j[h >>> 8 & 255] ^ l[k & 255] ^ c[p++],
                        g = q,
                        h = s,
                        k = t;
                    q = (f[g >>> 24] << 24 | f[h >>> 16 & 255] << 16 | f[k >>> 8 & 255] << 8 | f[n & 255]) ^ c[p++];
                    s = (f[h >>> 24] << 24 | f[k >>> 16 & 255] << 16 | f[n >>> 8 & 255] << 8 | f[g & 255]) ^ c[p++];
                    t = (f[k >>> 24] << 24 | f[n >>> 16 & 255] << 16 | f[g >>> 8 & 255] << 8 | f[h & 255]) ^ c[p++];
                    n = (f[n >>> 24] << 24 | f[g >>> 16 & 255] << 16 | f[h >>> 8 & 255] << 8 | f[k & 255]) ^ c[p++];
                    a[b] = q;
                    a[b + 1] = s;
                    a[b + 2] = t;
                    a[b + 3] = n
                },
                keySize: 8
            });
        u.AES = p._createHelper(d)
    })();


    var CryptoJSAesJson = {
        /**
         * Encrypt any value
         * @param {*} value
         * @param {string} password
         * @return {string}
         */
        'encrypt': function(value, password) {
            return CryptoJS.AES.encrypt(JSON.stringify(value), password, {
                format: CryptoJSAesJson
            }).toString()
        },
        /**
         * Decrypt a previously encrypted value
         * @param {string} jsonStr
         * @param {string} password
         * @return {*}
         */
        'decrypt': function(jsonStr, password) {
            return JSON.parse(CryptoJS.AES.decrypt(jsonStr, password, {
                format: CryptoJSAesJson
            }).toString(CryptoJS.enc.Utf8))
        },
        /**
         * Stringify cryptojs data
         * @param {Object} cipherParams
         * @return {string}
         */
        'stringify': function(cipherParams) {
            var j = {
                ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)
            }
            if (cipherParams.iv) j.iv = cipherParams.iv.toString()
            if (cipherParams.salt) j.s = cipherParams.salt.toString()
            return JSON.stringify(j).replace(/\s/g, '')
        },
        /**
         * Parse cryptojs data
         * @param {string} jsonStr
         * @return {*}
         */
        'parse': function(jsonStr) {
            var j = JSON.parse(jsonStr)
            var cipherParams = CryptoJS.lib.CipherParams.create({
                ciphertext: CryptoJS.enc.Base64.parse(j.ct)
            })
            if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
            if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
            return cipherParams
        }
    }

    let encrypted = '<?php echo $encrypted; ?>';
    let password = '<?php echo $str; ?>';
    let mapkeystr = CryptoJSAesJson.decrypt(encrypted, password);
    // console.log('Decrypted:', decrypted);

    //var mapkeystr = decrypted;

    let code = (function() {
        return {
            encryptMessage: function(messageToencrypt = '', mapkeystr) {
                let encJson = CryptoJS.AES.encrypt(JSON.stringify(messageToencrypt), mapkeystr).toString()
                let encData = CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(encJson))
                return encData;
            },
            decryptMessage: function(encryptedMessage = '', mapkeystr) {
                let decData = CryptoJS.enc.Base64.parse(encryptedMessage).toString(CryptoJS.enc.Utf8)
                let bytes = CryptoJS.AES.decrypt(decData, mapkeystr).toString(CryptoJS.enc.Utf8)
                return JSON.parse(bytes)
            }
        }
    })();


    // var jqxhr = $.ajax({
    //     type: 'POST',       
    //     url: "{{ url('/getmapkey.php') }}",
    //     dataType: 'json',
    //     context: document.body,
    //     global: false,
    //     async:false,
    //     success: function(data) {
    //         return data;
    //     }
    // }).responseText;

    // // $.each($.parseJSON(jqxhr), function(k, v) {
    // //     //console.log(k+" <<<=== "+v);
    // //     if(k === 'mapkey') { mapkeystr = v; }
    // //     else if (k === 'keysize') { keysizeval = v; }
    // //     else if (k === 'iterations') { iterval = v; }
    // // });

    // //console.log(jqxhr);
    // var mapkeystr = jqxhr;

    // //console.log(mapkeystr + ' is ' + keysizeval + ' is ' + iterval);

    // let code = (function(){
    //     return{
    //       encryptMessage: function(messageToencrypt = '', mapkeystr){
    //         let encJson = CryptoJS.AES.encrypt(JSON.stringify(messageToencrypt), mapkeystr).toString()
    //         let encData = CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(encJson))
    //         return encData;
    //       },
    //       decryptMessage: function(encryptedMessage = '', mapkeystr){
    //         let decData = CryptoJS.enc.Base64.parse(encryptedMessage).toString(CryptoJS.enc.Utf8)
    //         let bytes = CryptoJS.AES.decrypt(decData, mapkeystr).toString(CryptoJS.enc.Utf8)
    //         return JSON.parse(bytes)
    //       }
    //     }
    // })();



    function loadmap(res, view) {

        layer_bound = [];
        bound_type = [];
        bound_type = [];

        for (i = 0; i < res['maplist'].length; i++) {

            //load(res['maplist'][i]);

            var rawFile = new XMLHttpRequest();
            rawFile.open("GET", res['maplist'][i], false);
            rawFile.onreadystatechange = function() {
                if (rawFile.readyState === 4) {
                    if (rawFile.status === 200 || rawFile.status == 0) {
                        message = rawFile.responseText;
                        // console.log(message);
                        // return false;
                    }
                }

            }
            rawFile.send(null);

            var decrypted = JSON.parse(code.decryptMessage(message, mapkeystr));


            var geojson = L.geoJson(decrypted, {
                style: style,
                onEachFeature: function(feature, layer) {

                    if (bound_check.indexOf(feature.properties.ID) == -1) {
                        bound_check.push(feature.properties.ID);
                        bound_type[feature.properties.ID] = 1; // to check multiple polygon
                        layer_bound[feature.properties.ID] = layer;
                    } else {

                        lastlayer = layer_bound[feature.properties.ID];
                        layer_bound[feature.properties.ID] = [];
                        bound_type[feature.properties.ID] = 2;

                        if (!($.isArray(lastlayer))) {
                            layer_id = feature.properties.ID;
                            layer_bound[feature.properties.ID].push({
                                layer_id: lastlayer
                            });
                            layer_bound[feature.properties.ID].push({
                                layer_id: layer
                            });

                        }
                        if (($.isArray(lastlayer))) {
                            layer_id = feature.properties.ID;
                            for (i_l = 0; i_l < lastlayer.length; i_l++) {
                                layer_bound[feature.properties.ID].push(lastlayer[i_l]);
                            }


                            layer_bound[feature.properties.ID].push({
                                layer_id: layer
                            });

                        }

                    }



                    layer.on({
                        click: featureclick,
                        dblclick: change_status_byuser
                        //  mouseover: highlightFeature,
                        //mouseout: resetHighlight,touchstart:touch
                    });
                    if (res['map_nextlevel_info'].hasOwnProperty(feature.properties.ID)) {
                        nextinfo = res['map_nextlevel_info'][feature.properties.ID];
                        nxt_map = nextinfo['nxt_mp_level'];
                        loc_id = nextinfo['loc_id'];
                        current_level = nextinfo['current_level'];
                        feature.properties.nxt_map = nxt_map;
                        feature.properties.next_id = loc_id;
                        feature.properties.current_level = current_level;
                        feature.properties.main_location = nextinfo['main_location'];
                        feature.properties.sub_location = nextinfo['sub_location'];
                        feature.properties.location_name = nextinfo['location_name'];
                        feature.properties.loc_level = current_level;
                        feature.properties.loc_id = feature.properties.ID;
                        feature.id = feature.properties.ID;
                        feature.properties.latitude = nextinfo['latitude'];
                        feature.properties.longitude = nextinfo['longitude'];
                        layer.bindTooltip("<div class='tooltip-data no-border'><div class='card'><div class='card-header'>" + feature.properties.location_name + "</div></div>", {
                            sticky: true,
                            pane: 'tool',
                            direction: 'top'
                        });

                    } else {
                        layer.setStyle({
                            fillColor: '#ffffff',
                            color: '#808080',
                            weight: 1,
                            stroke: 2,
                            fillOpacity: 0,
                            opacity: 0
                        });

                    }
                }
            });
            geo_layer.push(geojson);
        }
        if(geo_layer.length>0)
        {
             var featureGroup = L.featureGroup(geo_layer).addTo(map);
              map.fitBounds(featureGroup.getBounds());
        }
        

        //  map.setMaxBounds(map.getBounds());

    }

    function change_status_byuser(e) {

        if (e.target.feature.id != '' && e.target.feature.id != undefined) {
            layerclick['colony_id'] = e.target.feature.properties.ID;
            str = "<div class='form-check form-check-inline '><label class='form-check-label' for='inlineRadio2'><input class='form-check-input' type='radio' name='statuschange' id='statuschange' value='2' checked>Not Visited<i class='input-frame'></i></label></div><div class='form-check form-check-inline'><label class='form-check-label' for='inlineRadio1'><input class='form-check-input' type='radio' name='statuschange' id='statuschange' value='1'>Visited<i class='input-frame'></i></label></div> ";
            $("#changeradio").html("");
            $("#changeradio").html(str);
            $('#mymodal').modal('show');

            layer_select = layer_bound[layerclick['colony_id']];

            $('input[type=radio][name=statuschange]').change(function() {

                status_val = $('input[type=radio][name=statuschange]:checked').val();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('loadmap.post') }}",
                    data: {
                        'status': status_val,
                        'statuschange': 1,
                        'layer': layerclick['colony_id']
                    },
                    dataType: 'json',

                    beforeSend: function() {
                        $(".spin-loader").attr('style', 'display:block');
                    },
                    complete: function() {
                        $(".spin-loader").attr('style', 'display:none');
                    },
                    error: function() {
                        $(".spin-loader").attr('style', 'display:none');
                    },

                    success: function(res) {
                        $("#changeradio").html('');
                        $("#changeradio").html(res['msg']);
                        setTimeout(function() {
                            $('#mymodal').modal('hide');
                        }, 3000);

                        layer_select = layer_bound[layerclick['colony_id']]
                        layerclick['colony_id'] = '';
                    }
                });
            });
        }
    }

    function style(feature) {
        return {
            fillColor: '#ffffff',
            color: '#808080',
            weight: 1,
            stroke: 2,
            fillOpacity: overlay_arr[0]
        };
    }

    function featuremousemove(e) {
        selected_layer = e.target.feature.properties.DB_ID;
        next_layer = e.target.feature.properties.nxt_map;
        next_id = e.target.feature.properties.next_id;
        current_level = e.target.feature.properties.current_level;
        main_location = e.target.feature.properties.main_location;
        sub_location = e.target.feature.properties.sub_location;
        location_name = e.target.feature.properties.location_name;
    }

    function featureclick(e) {

        zoomrange = map.getZoom();
        if (!isEmpty(layerclick[0])) {
            layer_selected = layerclick[0];
            if (layer_selected.feature.id !== undefined)
                layer_selected.setStyle({
                    color: '#808080',
                    weight: (zoomrange >= 16) ? 5 : 0.5,
                    stroke: (zoomrange >= 16) ? 5 : 0.8,
                    fillOpacity: overlay_arr[0]
                });

        }
        selected_layer = e.target.feature.properties.ID;
        latitude = e.target.feature.properties.latitude;
        longitude = e.target.feature.properties.longitude;
        tbl = Globalobject[0];
        lat = e.latlng.lat;
        lon = e.latlng.lng;

        var layer = e.target;
        if (layer.feature.id !== undefined)
            layer.setStyle({
                color: "#808080",
                weight: (zoomrange >= 16) ? 5 : 0.5,
                stroke: (zoomrange >= 16) ? 5 : 0.8,
                opacity: 1.5,
                dashArray: '0'
            });
        layerclick[0] = layer;
        layerclick['colony_id'] = selected_layer;
    }

    function removelayer() {
        //Geojson file layer

        if (outlet_markerarray.length > 0) {
            for (i = 0; i < outlet_markerarray.length; i++) {
                if (markercluster.hasLayer(outlet_markerarray[i])) {
                    markercluster.removeLayer(outlet_markerarray[i]);
                }
            }
            //   markercluster.removelayer(outlet_markerarray);
            outlet_markerarray = [];
            //   map.removelayer(markercluster);


        }

        for (i = 0; i < geo_layer.length; i++) {
            if (map.hasLayer(geo_layer[i])) {
                map.removeLayer(geo_layer[i]);
            }
        }


        geo_layer = [];


        return true;
    }

    function clickOnMapItem(itemId) {
        var id = parseInt(itemId);
        //get target layer by it's id
        var layer = geo_layer[0].getLayer(id);


        //fire event 'click' on target layer 
        layer.fireEvent('dblclick');
    }



    function initial(input_obj, initialmap, type, filter = false) // First - input parameter //second - 1-forward 2-load currentlevel data -1 back
    {

        if (!filter)
            loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': type,
                'filter_so': filter_so
            };
        else
            loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': input_obj.type,
                'filter_so': filter_so
            };


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('loadmap.post') }}",
            data: loaddata,
            dataType: 'json',
            //async: true,
            beforeSend: function() {
                $(".spin-loader").attr('style', 'display:block');
            },
            complete: function() {
                $(".spin-loader").attr('style', 'display:none');
            },
            error: function() {
                $(".spin-loader").attr('style', 'display:none');
            },

            success: function(res) {


                result[0] = res;

                if ($('#mymodal-subordinate').hasClass('show')) {
                    $("#mymodal-subordinate").modal('hide');
                    removelayer();

                }


                if (isEmpty(geo_layer) && (type !=5 && type!=6 && type!=7 && type!=8)) {      
               
                    removelayer();
                    loadmap(res, '');
                }

                if (!isEmpty(res['maplist'])) {

                    Globalobject[0] = res["tbl"];

                    $("#maphead h3").html(res['head']);
                    if (filter) {
                        removelayer();
                        if (res.hasOwnProperty('griddata')) {
                            loadmap(res, '');
                            changeproperty(res, type);
                            tablebuild(res, type);
                            legendremove();
                            legend(res['maplegend']);
                        }
                        $('#mymodal-filter').modal('hide');
                    } else {
                       

                        if (res.hasOwnProperty('griddata')) {
                            changeproperty(res, type);
                            tablebuild(res, type);
                            legendremove();
                            legend(res['maplegend']);
                        }
                    }
                }
                else {
                       

                        if (res.hasOwnProperty('griddata')) {
                            changeproperty(res, type);
                            tablebuild(res, type);
                            legendremove();
                            legend(res['maplegend']);
                        }
                    }


            }
        });
    }

    function tooglericon() {
        if ($(".navbar-toggler i").hasClass("fa-bars")) {
            $(".navbar-toggler i").removeClass("fa-bars");
            $(".navbar-toggler i").addClass("fa-times");
        } else {
            $(".navbar-toggler i").removeClass("fa-times");
            $(".navbar-toggler i").addClass("fa-bars");
        }
    }
    $("doucment").ready(function() {
        if (("{{Auth::user()->user_type}}") == 'SUPPORT') {


        }
        else if (("{{Auth::user()->user_type}}") == 'ASM') {

            $("#mymodal-subordinate").modal('show');
            $("#filter_byso").click(function() {
                filter_so = [];

                $.each($("input[name='subordinate']:checked"), function() {
                    filter_so.push($(this).val());
                });


                // so_id=$("input[name='subordinate']:checked").val();
                // console.log(so_id);
                // filter_so=so_id;


                input_obj = {
                    'type': '',
                    'filter_pc': showlist_user_id,
                    'filter_distributor': showlist_distributor_id,
                    'filter_so': filter_so
                };


                initial(input_obj, 0, '');


            });
        } else {
            initial(input_obj, 0, '');
        }



        $(".show_case_result").click(function() {
            $(".navbar-toggler").trigger("click");
            type = $(this).attr("id");
            legendremove();

            input_obj = {
                'type': type,
                'filter_pc': showlist_user_id,
                'filter_distributor': showlist_distributor_id,
                'filter_so': filter_so
            };
            initial(input_obj, 2, type);


        });
        $(".navbar-toggler").click(function() {
            tooglericon();
        });

        $(".outlet-popup").click(function() {
            $('#mymodal-new').modal('show');

        });
        $(".outletlist-popup").click(function() {
            $('#mymodal-new-outlet').modal('show');

        });

        $("input[name='filter']").change(function() {

            var filterval = $("input[name='filter']:checked").val();

            showlist_user_id = [];
            showlist_distributor_id = [];


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('loadmap.post') }}",
                data: {
                    'showlist': 1,
                    'showtype': filterval
                },
                dataType: 'json',
                //async: true,

                success: function(res) {
                    $("#showlist_user,.filter_action").css("display", "none");


                    if (res['msg'] == 'success') {

                        $("#showlist_user").html('');
                        $("#showlist_user").html(res['list_of_user']);
                        $("#showlist_user").css("display", "block");
                        $(".filter_action").css("display", "block");

                        var listtable = $('#showlist').DataTable({
                            'paging': false,
                            "ordering": true,
                            columnDefs: [{
                                orderable: false,
                                targets: "no-sort"
                            }]
                        });
                        $('#showlist tbody tr').click(function(event) {
                            if (event.target.type !== 'checkbox') {
                                $(':checkbox', this).trigger('click');
                            }
                        });
                        $("#showlist_length").hide();
                        $(".checking_box").click(function() {

                            if ($(this).hasClass('checked'))
                                $(this).removeClass('checked');
                            else
                                $(this).addClass('checked');

                            val_selected = parseInt($(this).val());

                            if ($(this).hasClass('checked')) {
                                if (res['type'] == 'pc') {
                                    showlist_user_id.push(val_selected);

                                }
                                if (res['type'] == 'distributor') {
                                    showlist_distributor_id.push(val_selected);
                                }
                            } else {
                                if (res['type'] == 'pc') {
                                    showlist_user_id = $(showlist_user_id).not([val_selected]).get();

                                }
                                if (res['type'] == 'distributor') {
                                    showlist_distributor_id = $(showlist_distributor_id).not([val_selected]).get();

                                }
                            }

                            if (showlist_user_id.length > 0 || showlist_distributor_id > 0) {
                                if (!($('.checkbox_all').hasClass('checked'))) {
                                    $('.checkbox_all').addClass("checked");
                                    $('.checkbox_all').prop('checked', true);
                                }
                            } else {
                                if (($('.checkbox_all').hasClass('checked'))) {
                                    $('.checkbox_all').removeClass("checked");
                                    $('.checkbox_all').prop('checked', false);
                                }

                            }




                        });

                        $(".checkbox_all").click(function() {
                            showlist_user_id = [];
                            showlist_distributor_id = [];

                            if ($(this).hasClass('checked'))
                                $(this).removeClass('checked');
                            else
                                $(this).addClass('checked');

                            if ($(this).hasClass('checked')) {
                                $('.checking_box').each(function() {
                                    val_selected = parseInt($(this).val());
                                    if ($(this).hasClass('checked')) {
                                        $(this).removeClass("checked");
                                        $(this).addClass("checked");
                                        $(this).prop('checked', true);


                                        ((res['type'] == 'pc')) ? showlist_user_id.push(val_selected): showlist_distributor_id.push(val_selected);

                                    } else {
                                        $(this).addClass("checked");
                                        $(this).prop('checked', true);
                                        ((res['type'] == 'pc')) ? showlist_user_id.push(val_selected): showlist_distributor_id.push(val_selected);
                                    }

                                });
                            }
                            if (!($(this).hasClass('checked'))) {
                                val_selected = parseInt($(this).val());
                                $('.checking_box').each(function() {
                                    if ($(this).hasClass('checked')) {
                                        $(this).removeClass("checked");
                                    }
                                    $(this).prop('checked', false);
                                    val_selected = parseInt($(this).val());

                                    ((res['type'] == 'pc')) ? $(showlist_user_id).not([val_selected]).get(): $(showlist_distributor_id).not([val_selected]).get();
                                });
                            }


                        });

                        $("#filterresult").unbind().click(function() {


                            if (showlist_user_id.length > 0 || showlist_distributor_id.length > 0) {

                                obj = {
                                    'type': input_obj.type,
                                    'filter_pc': showlist_user_id,
                                    'filter_distributor': showlist_distributor_id,
                                    'filter_so': filter_so
                                }
                                initial(obj, 2, input_obj.type, true);
                                dynamic_control[0].enable();


                            } else {
                                dynamic_control[0].disable();
                                alert("please Choose any filter");
                            }

                        });

                        $("#clearresult").unbind().click(function() {
                            showlist_user_id = [];
                            showlist_distributor_id = [];

                            legendremove();
                            obj = {
                                'type': input_obj.type,
                                'filter_pc': [],
                                'filter_distributor': [],
                                'filter_so': filter_so
                            }
                            initial(obj, 2, input_obj.type, true);
                            $("input[name='filter']:checked").prop('checked', false).removeAttr('checked');
                            $("#showlist_user,.filter_action").css("display", "none");
                            $("#showlist_user").html('');
                            $('#mymodal-filter').modal('hide');

                        });


                    }





                },
            });



        });

    });

    /////////////////////////////////////////Map section///////////////////////////////////////////////////////////////////////


    ////////////////////////////////////////Result Section /////////////////////////////////////////////////////////////////////


    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    function changeproperty(res, type) {

        if (type != 4 && type !=5 && type !=6 && type!=7 && type!=8) {
            $.each(layer_bound, function(key, value) {


                if (res['map_nextlevel_info'][key]) {

                    if (bound_type[key] == 1) {
                        layer = value;
                        changestyle_byresult(layer, res['map_nextlevel_info'][key]);

                    }
                    if (bound_type[key] == 2) {
                        for (i = 0; i < value.length; i++) {

                            layer = value[i].layer_id;
                            changestyle_byresult(layer, res['map_nextlevel_info'][key]);

                        }
                    }
                }


            });

        }
        if (type == 4 || type ==5 || type ==6 || type==7 || type==8) {

            removelayer();
            k = 1;
            $.each(res['map_nextlevel_info'], function(key, value) {

                if ((value.lat != '' && value.lon != '') && (value.lat !== undefined && value.lon !== undefined) && (value.lat !== 'undefined' && value.lon !== 'undefined')) {
                     info = '';
        
                     info = '<div class="media outlet-list"><img class="align-self-start" src="' + value.shop_image + '" width="100px" alt=""><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li></ul></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)">Click to Navigate</span></div></div>';

                    if (value.icon != '' && value.icon !== undefined) {

                        var greenIcon = L.icon({
                            iconUrl: value.icon,
                            iconSize: [24, 24], // size of the icon
                            // iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                            // shadowAnchor: [4, 62], // the same for the shadow
                            //  popupAnchor: [-7, -86] // point from which the popup should open relative to the iconAnchor
                        });

                        var m = new L.Marker(new L.LatLng(value.lat, value.lon), {
                            icon: greenIcon
                        });

                    } else {
                        var m = new L.Marker(new L.LatLng(value.lat, value.lon));
                    }
                    m.bindPopup(info, {
                        'sticky': true,
                        pane: 'tool',
                        direction: 'top'
                    });
                    outlet_markerarray.push(m);

                    k++;


                }

            });
            markercluster.addLayers(outlet_markerarray);
            markercluster.addTo(map);

        }



    }

    function changestyle_byresult(layer, result) {




        if (layer !== undefined && (layer.feature.id !== undefined)) {

            nextinfo = result;
            nxt_map = nextinfo['nxt_mp_level'];
            loc_id = nextinfo['loc_id'];
            current_level = nextinfo['current_level'];

            layer.feature.properties.nxt_map = nxt_map;
            layer.feature.properties.next_id = loc_id;
            layer.feature.properties.current_level = current_level;
            layer.feature.properties.main_location = nextinfo['main_location'];
            layer.feature.properties.sub_location = nextinfo['sub_location'];
            layer.feature.properties.location_name = nextinfo['location_name'];
            layer.feature.properties.loc_level = current_level;
            layer.feature.properties.loc_id = layer.feature.properties.ID;
            layer.feature.id = layer.feature.properties.ID;
            layer.feature.properties.latitude = nextinfo['latitude'];
            layer.feature.properties.longitude = nextinfo['longitude'];
            layer.bindTooltip(layer.feature.properties.location_name, {
                sticky: true,
                crossOrigin: true,
                pane: 'tool',
                direction: 'top'
            });
            zoomrange = map.getZoom();
            layer.setStyle({
                fillColor: '#ffffff',
                color: '#808080',
                weight: (zoomrange >= 16) ? 5 : 0.5,
                stroke: (zoomrange >= 16) ? 5 : 0.8,
                fillOpacity: overlay_arr[0]
            });
            if (result.hasOwnProperty('color')) {
                layer.setStyle({
                    fillColor: result.color,
                    color: '#808080',
                    weight: (zoomrange >= 16) ? 5 : 0.5,
                    stroke: (zoomrange >= 16) ? 5 : 0.8,
                    fillOpacity: overlay_arr[0]
                });

                layer.bindTooltip(result.info, {
                    // layer.bindTooltip('<div class="tooltip-data"><div class="card"><div class="card-header"><h3>Kasaravadi Pt 2 of 2 Loclty <small>Rank:  1000/1000</small></h3> <span class="low" style="background-color:#ed464b">Low</span></div><ul class="list-group list-group-flush"><li class="list-group-item">Total Retailers (Nos.) <span>17</span></li><li class="list-group-item">Mondelez Retailers (Nos.) <span> 0</span></li><li class="list-group-item" style="background-color:#ed464b">Uncovered Retailers (Nos.) <span>17</span></li></ul><div class="adtnl-details"><ul class="list-group list-group-flush"><li class="list-group-item">Lalit Mohan <span>ASM</span></li><li class="list-group-item">Gupta Saurabh <span> SO</span></li><li class="list-group-item" >Yakub Sayed <span>PC</span></li><li class="list-group-item" >Mehta Marketing <span>Distrbtr</span></li></ul></div></div></div>', {
                    sticky: true,
                    direction: 'top'
                });
                // layer.openTooltip();
            }

        }



    }

    function tablebuild(res, type) {
        tablefoot = false;
        if ($.fn.dataTable.isDataTable('#griddata')) {

            table.destroy();

            $("#griddata").html("");
            if (type == 4 || type==5 || type==6 || type==7) {
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf', 'print'],
                    paging: false,
                    info: false,
                    responsive: true

                });

            } else {
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf', 'print'],
                    paging: false,
                    info: false,
                    responsive: false,
                    

                    fnFooterCallback: function(row, data, start, end, display) {

                        if (tablefoot == false && type != 3 && type != 4) {
                            var api = this.api();

                            var footer = '<tfoot><tr>';
                            footer += '<td colspan="7" style="text-align:center;">Total</td>';
                            total_retailer = 0;
                            mdlz_retailer = 0;
                            mdlz_notretailer = 0;

                            for (i = 0; i < data.length; i++) {

                                total_retailer = total_retailer + data[i][7];
                                mdlz_retailer = mdlz_retailer + data[i][8];
                                mdlz_notretailer = mdlz_notretailer + data[i][9];

                            }
                            footer += '<td style="text-align:right;">' + total_retailer + '</td>';
                            footer += '<td style="text-align:right;">' + mdlz_retailer + '</td>';
                            footer += '<td style="text-align:right;">' + mdlz_notretailer + '</td>';

                            footer += '</tr></tfoot>';

                            $(this).append(footer);



                        }
                    },

                });

                // tablefoot = true;
            }



        } else {
            tablefoot = false;
            if (type == 4 || type==5 || type==6 || type==7) {
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf', 'print'],
                    paging: false,
                    info: false,
                    responsive: true

                });
            } else {
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf', 'print'],
                    paging: false,
                    info: false,
                    responsive: false,

                    fnFooterCallback: function(row, data, start, end, display) {

                        if (tablefoot == false && type != 3 && type != 4) {
                            var api = this.api();

                            var footer = '<tfoot><tr>';
                            footer += '<td colspan="7" style="text-align:center;">Total</td>';
                            total_retailer = 0;
                            mdlz_retailer = 0;
                            mdlz_notretailer = 0;

                            for (i = 0; i < data.length; i++) {

                                total_retailer = total_retailer + data[i][7];
                                mdlz_retailer = mdlz_retailer + data[i][8];
                                mdlz_notretailer = mdlz_notretailer + data[i][9];

                            }
                            footer += '<td style="text-align:right;">' + total_retailer + '</td>';
                            footer += '<td style="text-align:right;">' + mdlz_retailer + '</td>';
                            footer += '<td style="text-align:right;">' + mdlz_notretailer + '</td>';

                            footer += '</tr></tfoot>';

                            $(this).append(footer);



                        }
                    },
                });

                // tablefoot = true;

            }



        }

        $(".dataTables_length").remove();
        $("#showdata").css("display", "flex")

        return true;
    }

    function legendremove() {

        for (i = 0; i < legend_arr.length; i++) {
            legend_arr[i].remove();
        }
        legend_arr = [];
    }

    function legend(data) {
        var legend = L.control({
            position: 'bottomleft'
        });

        legend.onAdd = function(map) {

            var div = L.DomUtil.create('div', 'info legend'),

                labels = [];

            $.each(data[0], function(index, value) {
                div.innerHTML +=
                    '<div class="legend-wraper"><span style="background-image:linear-gradient(to right, ' + value + ' , ' + value + ')"></span>' + index + '</div>';

            });
            return div;
        };

        legend.addTo(map);

        legend_arr.push(legend);

    }

    function showbound(data) {


        zoomrange = map.getZoom();

        id = $(data).attr("id");


        //  for(i=0;i<geo_layer.length;i++)
        // {                 
        //       geo_layer[i].eachLayer(function (layer) {  
        //         if(layer !== undefined  && (layer.feature.id !== undefined))
        //                 layer.setStyle({ weight: (zoomrange >= 16) ? 5 : 0.5,
        //                 stroke: (zoomrange >= 16) ? 5 : 0.8, color: '#808080'}); 
        //     });
        // }

        if (bound_type[id] == 2) {
            bounds = [];

            for (i = 0; i < layer_bound[id].length; i++) {
                layer = layer_bound[id][i].layer_id;
                if (layer !== undefined && (layer.feature.id !== undefined)) {

                    layer.setStyle({
                        color: "red",
                        weight: (zoomrange >= 16) ? 5 : 0.5,
                        stroke: (zoomrange >= 16) ? 5 : 0.8,
                        opacity: 1

                    });

                    bounds.push(layer);


                }


            }
            var featureGroup = L.featureGroup(bounds).addTo(map);
            map.fitBounds(featureGroup.getBounds());
            $("#showmap").click();

        } else {
            layer = layer_bound[id];
            if (layer !== undefined && (layer.feature.id !== undefined)) {

                layer.setStyle({
                    color: "red",
                    weight: (zoomrange >= 16) ? 5 : 0.5,
                    stroke: (zoomrange >= 16) ? 5 : 0.8,
                    opacity: 1

                });
                map.fitBounds(layer.getBounds());
                $("#showmap").click();


            }
        }



    }

    function showboundbyusertype(data) {

        zoomrange = map.getZoom();
        if (data == '')
            id = '';
        else
            id = $(data).attr("id");
        showlist_user_id = [];
        showlist_distributor_id = [];
        so_id = $(data).attr("so_id");
        if (id != '')
            showlist_user_id.push(id);

        // if(data=='')
        // {
        //    id='';
        //    showlist_user_id=[];
        //    showlist_distributor_id=[];

        // }

        obj = {
            'type': input_obj.type,
            'filter_pc': showlist_user_id,
            'filter_distributor': showlist_distributor_id,
            'filter_so': filter_so,
            'filter_byso': (so_id != '') ? so_id : ''
        }
        initial(obj, 2, input_obj.type, true);

        $("#showmap").click();
        if (showlist_user_id.length > 0 || showlist_distributor_id.length > 0) {
            dynamic_control[0].enable();

            //map.addControl(dynamic_control[0]);

        }
        if (showlist_user_id.length <= 0)
            dynamic_control[0].disable();

        //map.removeControl(dynamic_control[0]);

    }

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        document.getElementById(cityName).style.display = "block";
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()
            .responsive.recalc();

    }
    $("document").ready(function() {
        $(".tab-link a").click(function() {
            $(".tab-link a").removeClass("active");
            $(this).addClass("active");
        });
        $("#showmap").click();
        $("#showdata").css("display", "none");

        //  $(".leaflet-range-control").hide();
        $('.range-slider').click(function() {
            $('.range-control').css("width", "0");
            $('.range-control').animate({
                width: '100%'
            });
            $('#range-animate').toggle();
        });
        $(".map-opt").click(function() {
            if ($(this).hasClass('chk-active')) {
                $(".map-opt").removeClass("chk-active");
                $(this).addClass("chk-active");

            } else {
                $(".map-opt").removeClass("chk-active");
                $(this).addClass("chk-active");

            }

        });
        $('.leaflet-control-attribution').hide();
        $(".filter-data").click(function(){
                $(this).toggleClass("filter-active");
        });
        $(".nav .nav-link").on("click", function(){
            $(".nav-item").find(".active").removeClass("active");
            $(this).addClass("active");
        });
        
    });

    function change_opacity() {

        $.each(layer_bound, function(k, v) {

            layer = v;

            if (v !== undefined) {

                if (bound_type[k] == 1) {
                    if (layer.feature.id !== undefined)
                        layer.setStyle({
                            'fillOpacity': overlay_arr[0]
                        });
                }
                if (bound_type[k] == 2) {
                    for (i = 0; i < v.length; i++) {

                        layer = v[i].layer_id;

                        if (layer !== undefined) {
                            if (layer.feature.id !== undefined)
                                layer.setStyle({
                                    'fillOpacity': overlay_arr[0]
                                });
                        }
                    }

                }



            }
        });
    }
    ////////////////////////////////////////Result Section /////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////Add Outlets ////////////////////////////////////////////////////////////////////////

        function check()
       {

         var mobile = document.getElementById('mobile_no');  
       
           if(mobile.value!='')
           {
             if(mobile.value.length!=10){
               
                mobile.style.border = "1px solid red";
                // message.style.background = "#FFCECE";
               
            }
           }
     }

    $(document).ready(function() {
        $(".file-upload-browse").click(function(event){
            event.stopPropagation();
        });
         $('#mobile_no').keypress(function (e) {    
    
                var charCode = (e.which) ? e.which : event.keyCode    
    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
    
                    return false;                        
            });


        $(".fa-map-marker").click();

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {

            current_location['lat'] = position.coords.latitude;
            current_location['lon'] = position.coords.longitude;



        }


        outlettbl = $("#outlet_list_tbl").DataTable({
            info: false,
            paging: false
        });


        setInterval(function() {
            // map.locate({setView: true, maxZoom: 16});

            getLocation();

            geo = current_location['lat'] + ',' + current_location['lon'];
            // if(current_location['marker'] == undefined || current_location['marker'] == ''){
            //    current_location['marker']=L.marker([current_location['lat'], current_location['lon']]).addTo(map);
            // }
            // else{
            //  var newLatLng = new L.LatLng(current_location['lat'], current_location['lon']);
            //   current_location['marker'].setLatLng(newLatLng); 
            // }

            $('input[name="gio_point"]').val(geo);

        }, 3000);


        $('select[name="channel_name"]').on('change', function() {
            var channel = $(this).val();
            if (channel) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: 'dashboard/getsubchannel/' + channel,
                    type: "POST",
                    data: {
                        'channel': channel
                    },
                    dataType: "json",
                    success: function(data) {

                        $('select[name="sub_channel_name"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="sub_channel_name"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="sub_channel_name"]').empty();
            }
        });
        $("form#outlet").submit(function(e) {

           e.preventDefault();
            var formData = new FormData(this);

            var isValid = true;
            $('#outlet_name,#owner_name,#sub_channel_name,#address').each(function() {
                
                // if($(this).attr("id")!= 'mobile_no')
                // {
                //      if ($.trim($(this).val()) != '') {

                //         if ($(this).val().length != 10) {
                //             if ($(this).attr(""))
                //                 isValid = false;
                //             $(this).css({
                //                 "border": "1px solid red",
                //                 "background": "#FFCECE"
                //             });


                //         }


                //      }
                //      else
                //      {
                //          $(this).css({
                //         "border": "",
                //         "background": ""
                //         });
                //      }

                // }
                // else
                // {

                // }
                 if ($.trim($(this).val()) == '') {
                    if ($(this).attr(""))
                        isValid = false;
                    $(this).css({
                        "border": "1px solid red",
                        // "background": "#FFCECE"
                    });
                } else {
                    $(this).css({
                        "border": "",
                        "background": ""
                    });
                }
               
            });
            if (isValid == true) {
                $.ajax({
                    url: 'dashboard/addoutlet',
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        result_form = JSON.parse(data);
                        if (result_form['status'] == 'success') {
                            $("#alertstatus").html('<div class="alert alert-success" role="alert">' + result_form['msg'] + '</div>');
                            document.getElementById("outlet").reset();
                        } else {
                            $("#alertstatus").html('<div class="alert alert-danger" role="alert">' + result_form['msg'] + '</div>');



                        }
                        setInterval(function() {
                            $(".alert").hide('slow');
                        }, 3000);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

        });
    });

    function deleteoutlet(data) {
        outlet_id = $(data).attr("id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/deleteoutlet/' + outlet_id,
            type: "POST",
            data: {
                'outlet_id': outlet_id
            },
            dataType: "json",
            success: function(response) {
                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
                    $("#alertstatus_list").html('<div class="alert alert-success" role="alert">' + response['msg'] + '</div>');

                    outlettbl.row($(data).parents('tr')).remove().draw();

                } else {
                    $("#alertstatus_list").html('<div class="alert alert-danger" role="alert">' + response['msg'] + '</div>');
                }
                setInterval(function() {
                    $(".alert").hide('slow');
                }, 3000);
            }
        });

    }

    function showimage(data) {
        src = $(data).attr('src');
        $('#mymodal-image').modal('show');
        $('#imageview').html('');
        $('#imageview').html('<img id="theImg" src="' + src + '" />');

    }

    function location_navigate(data)
    {
         clicked_shop_location=$(data).attr("geocode");
         shop_location=clicked_shop_location.split(",");
         shop_lat=shop_location[0];
         shop_lon=shop_location[1];         
         
         str = "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + shop_lat + "," + shop_lon + "'/";
         window.open(str, 'window name', 'window settings');
    }



    ////////////////////////////////////////////Add Outlets ////////////////////////////////////////////////////////////////////////
</script>
@endsection


@push('plugin-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/pbkdf2.js"></script>

<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="https://www.nobleui.com/laravel/template/light/assets/js/file-upload.js"></script>
<!-- <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script> -->
<!-- <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script> -->


<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script src="{{ asset('/assets/js/dashboard.js') }}"></script>
<script src="{{ asset('/assets/js/datepicker.js') }}"></script>

<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>


@endpush