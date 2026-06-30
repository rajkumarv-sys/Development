@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css"> -->

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
  border: 1px solid #ccc;
  border-top: none;
}
.legend {
    line-height: 18px;
    color: #555;
}
.legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
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
                <table id="griddata" class="table display responsive nowrap table-border" style="width:100%"></table>
                
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
<div id="mymodal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body" id="changeradio">

            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div id="mymodal-new" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
              <div class='form-control-lg'>

 <form action="{{url('/outlet/store')}}" method="post" enctype="multipart/form-data">
     {{ csrf_field() }}
    <div class="row">
  <div class="col-md-6 grid-margin">
   
        <h6 class="card-title">Add Outlets</h6>
       
          <div class="form-group">
            <label for="exampleInputText1">Outlet Name</label>
            <input type="text" class="form-control" id="outlet_name" name="outlet_name"  value="" placeholder="Outlet Name">
          </div>
          <div class="form-group">
            <label for="exampleInputText1">Proprietor Name</label>
            <input type="text" class="form-control" id="owner_name" name="owner_name" value="" placeholder="Owner Name">
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Channel</label>
            <select class="form-control" id="channel_name" name="channel_name">
            <option selected="" disabled="">Select Channel</option>
              @for ($i = 0; $i < count($channel); $i++)
              <option value="{{ $channel[$i]->refid }}">{{ $channel[$i]->name }}</option>
            @endfor
             
             
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Sub Channel</label>
            <select class="form-control" id="sub_channel_name" name="sub_channel_name">
              <option selected="" disabled="">Select Subchannel</option>
             
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputMobile" >Mobile</label>
            
              <input type="number" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile number">
            
          </div>

           <div class="form-group">
            <label for="exampleInputMobile" >PAN Number</label>
            
              <input type="number" class="form-control" id="pan_no" name="pan_no" placeholder="PAN number">
            
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
            <label for="exampleInputMobile">TAN Number</label>
           
              <input type="number" class="form-control" id="tan_no" name="tan_no" placeholder="TAN number">
           
          </div>
           <div class="form-group">
            <label for="exampleInputMobile">Shop and Establishment Number</label>
           
              <input type="number" class="form-control" id="shop_establish_no" name="shop_establish_no" placeholder="Establishment number">
            
          </div>
          <div class="form-group">
            <label for="exampleInputMobile">GST Number</label>
           
              <input type="number" class="form-control" id="gst_no" name="gst_no" placeholder="GST number">
            
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Address</label>
            <textarea class="form-control" id="address" rows="2" name="address"></textarea>
          </div>
          
            
          <div class="form-group">
            <label>File upload</label>           
            <input type="file" name="img[]" class="file-upload-default" accept="image/*" capture="camera">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
              </span>
            </div>
          </div>
           <button class="btn btn-primary" type="submit">Submit form</button>
  
  </div>

</div>
</form>
    </div>
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div id="mymodal-filter" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-body" id="dropdown">
             
        @if(Auth::user()->user_type =='SO')         
               <div class="form-group">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="filter"  value="PC">
                PC
              <i class="input-frame"></i></label>
            </div>
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="filter" value="Distributor">
                Distributor
              <i class="input-frame"></i></label>
            </div>
            
          </div>
           <i class="fa fa-filter" aria-hidden="true" id="filterresult"></i>
       @endif

       <div style="display:none;" id="showlist_user">

        
       </div>

    
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script>
Globalobject = new Array();
var input_obj = {};

////////////////////////////////////////Declaration /////////////////////////////////////////////////////////////////////////////////////////////////
var map;
var geojson;
var geo_layer_json;
var geo_layer = [];
var history_map = [];
var history_pos = 0;
var table;
var global_chart = [];
var dblclick = false;
combinelegend = [];
var piechart_data = [];
var current_level_map = {};
legend_arr = [];
var marker_icon = [];
var overlay_arr = [];
var grayscale;
var streets;
var layers_base = [];
var circle_marker = [];
var layer_group = [];
var bubble_layer = [];
var bubble_data = [];
var result = [];
var layer_bound = [];
var layerclick = [];
var table_obj=[];
var showlist_user_id=[];
var last_clicked_type=[];

////////////////////////////////////////Declaration//////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////Map section ////////////////////////////////////////////////////////////////////////////////////////////


var map = L.map('map', {
  zoomControl: false,
  zoomSnap: 0.25,
  contextmenu: true,
    contextmenuWidth: 140,
  contextmenuItems: [{
      text: 'clear',
      callback: clear_overlay_map
  }],
 

}).setView([23.473324, 77.947998], 5);
map.createPane('tool');
map.getPane('tool').style.zIndex = 999;
map.doubleClickZoom.disable(); 

var gl = L.mapboxGL({
        attribution: "",
        style: 'https://api.maptiler.com/maps/e4b2799f-08dd-4143-9dcb-58dae190b16f/style.json?key=t48sy8w2bGMZMaxREggf'
      }).addTo(map);


grayscale = L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {

    id: 'mapbox.light'
  }),
  streets = L.esri.basemapLayer('Imagery');

// var baseLayers = {
//   "Map": gl,
//   "Earth": streets
// };


// // L.control.layers(baseLayers,{position: 'bottomright'}).addTo(map);
// layerControl = L.control.layers(null, baseLayers, {position: 'bottomright'});

// layerControl.addTo(map);
// map.doubleClickZoom.disable();

        var baseLayers = {
            "<img class='map-opt' src='{{ url('/storage/normal.png') }}' alt='Map View' />": gl,
             "<img class='map-opt' src='{{ url('/storage/satelite.png') }}' alt='satelite View' />": streets
        };

        var baseLayers2 = {
           
        };

        // layerControl2 = L.control.layers(null, baseLayers2, {
        //     position: 'bottomright'
        // });

        layerControl = L.control.layers(null, baseLayers, {
            position: 'bottomright'
        });

        

        // layerControl2.addTo(map);
        layerControl.addTo(map);
      map.createPane('labels');

      map.getPane('labels').style.zIndex = 650;
      map.getPane('labels').style.pointerEvents = 'none';

// L.Routing.control({
//     waypoints: [
//         L.latLng(57.74, 11.94),
//         L.latLng(57.6792, 11.949)
//     ]
// }).addTo(map);


/////////////Context menu function ///////////////////////

function legendshow(e) {
  $(".legend").toggle();
}

// function changeopacity(e) {

//   if (overlay_arr.length > 0) {
//     map.removeControl(overlay_arr[0]);
//     overlay_arr = [];
//     opacityval = 1;

//     $.each(layer_bound, function (k, v) {

//       if (v !== undefined) {
//         layer = v;
//         layer.setStyle({
//           'fillOpacity': opacityval
//         });

//       }


//     });

//   } else {


//     overlay_arr.push(control);

//   }


// }
 var control = L.control.range({
  orient: 'horizontal',
  value: 100,
  position: 'bottomright',

});
overlay_arr[0]=1;
control.on('change input', function (e) {

  opacityval = e.value / 100;
  overlay_arr[0]=opacityval;

  $.each(layer_bound, function (k, v) {

    if (v !== undefined) {
      layer = v;
      layer.setStyle({
        'fillOpacity': 1*opacityval
      });

    }


  });
});

map.addControl(control);
var backbut1 = L.easyButton({
  position: 'bottomright',
  states: [{
    stateName: 'globe-layer',
    icon: 'fas fa-plus',
    title: 'Change Status',
    onClick: function (control) {

          $(".leaflet-range-control").toggle();

      



    }
  }]
});

map.addControl(backbut1);
var filter = L.easyButton({
  position: 'bottomright',
  states: [{
    stateName: 'globe-layer',
    icon: 'fa fa-filter',
    title: 'Filter',
    onClick: function (control) {

         $('#mymodal-filter').modal('show');

      



    }
  }]
});

map.addControl(filter);



// var Locationpath = L.easyButton({
//   position: 'topright',
//   states: [{
//     stateName: 'globe-layer',
//     icon: 'fas fa-plus',
//     title: 'find location',
//     onClick: function (control) {


//           if (navigator.geolocation) {
//             console.log(navigator.geolocation.getCurrentPosition(showPosition));
//           } else {
//            console.log( "Geolocation is not supported by this browser.");
//           }


//     }
//   }]
// });

// map.addControl(Locationpath);

// function showPosition(position) {

//   return [position.coords.latitude,position.coords.longitude];

// }


/////////////Context menu function ///////////////////////


function loadmap(res, view) {

  layer_bound = [];

  for (i = 0; i < res['maplist'].length; i++) {


    load(res['maplist'][i]);


    var geojson = L.geoJson(rs, {
      

      style: style,
       


      onEachFeature: function (feature, layer) {

        layer_bound[feature.properties.ID] = layer;




        layer.on({


          mouseover: featureclick,
         dblclick: change_status_byuser
         //  dblclick: change_status_byuser
        //  mouseout: resetHighlight


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


          layer.bindTooltip(feature.properties.location_name, {
            sticky: true,
            pane: 'tool'
          });


        }


      }

    });
   
    geo_layer.push(geojson);


  }


  var featureGroup = L.featureGroup(geo_layer).addTo(map);
  map.fitBounds(featureGroup.getBounds());


}
function change_status_byuser(e)
{

    if( e.target.feature.properties.ID != '' &&  e.target.feature.properties.ID!=undefined)
    {
      layerclick['colony_id']=e.target.feature.properties.ID;
     str="<div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='statuschange' id='statuschange' value='1'><label class='form-check-label' for='inlineRadio1'>Completed</label></div><div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='statuschange' id='statuschange' value='2' checked><label class='form-check-label' for='inlineRadio2'>Not completed</label></div> </div>";
         $("#changeradio").html("");
         $("#changeradio").html(str);          
        $('#mymodal').modal('show');

         layer_select = layer_bound[layerclick['colony_id']];
         layer_select.setStyle({
                  fillColor: '#A8A8A8',
                  color: '#dddddd',
                  weight: 1.5,
                  stroke: 2,
                  fillOpacity: 1*overlay_arr[0]
        });
         layer_select.openTooltip();



      
         $('input[type=radio][name=statuschange]').change(function() {

          status_val=$('input[type=radio][name=statuschange]:checked').val();


               $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });
                $.ajax({
                  type: 'POST',
                  url: "{{ route('loadmap.post') }}",
                  data: {'status':status_val,'statuschange':1,'layer':layerclick['colony_id']},
                  dataType: 'json',
                 
                  beforeSend: function () {

                    $(".spin-loader").attr('style', 'display:block');
                  },
                  complete: function () {
                    $(".spin-loader").attr('style', 'display:none');
                  },
                  error:function(){ $(".spin-loader").attr('style', 'display:none');},

                  success: function (res) {
                    $("#changeradio").html('');
                    $("#changeradio").html(res['msg']);
                    setTimeout(function(){ $('#mymodal').modal('hide'); }, 3000);

                    layer_select = layer_bound[layerclick['colony_id']]
                     layer_select.setStyle({
                              fillColor: '#ffffff',
                              color: '#dddddd',
                              weight: 1.5,
                              stroke: 2,
                              fillOpacity: 1* overlay_arr[0]
                    });
                    layer_select.closeTooltip();
                    layerclick['colony_id']='';


                  }});


             
         });
  }
}
function style(feature) {
  return {
    fillColor: '#ffffff',
    color: '#dddddd',
    weight: 1.5,
    stroke: 2,
    fillOpacity:1* overlay_arr[0]
  };

}

function touch(e) {

  mapTapHoldTimeout = setTimeout(function () {
    alert('Touched for 500ms'), 500
  });

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


  if (!isEmpty(layerclick[0])) {
    layer_selected = layerclick[0];
    layer_selected.setStyle({
      color: '#dddddd',
      weight: 1.5,
      stroke: 2,
      fillOpacity: 1*overlay_arr[0]
    });

  }

  selected_layer = e.target.feature.properties.ID;
  latitude = e.target.feature.properties.latitude;
  longitude = e.target.feature.properties.longitude;
  tbl = Globalobject[0];
  lat = e.latlng.lat;
  lon = e.latlng.lng;

  var layer = e.target;
  layer.setStyle({
    color: "#dddddd",
    weight: 1.5,
    opacity: 1.5,
    stroke: 2,
    dashArray: '0'
  });
  layerclick[0] = layer;
  layerclick['colony_id']=selected_layer;
}


function removelayer() {
  //Geojson file layer
  for (i = 0; i < geo_layer.length; i++) {
    if (map.hasLayer(geo_layer[i])) {
      map.removeLayer(geo_layer[i]);
    }
  }
  return true;
}
function highlightFeature(e) {
  var layer = e.target;
  layer.setStyle({

    color: "#dddddd",
    weight: 1.5,
    opacity: 1.5,
    stroke: 2,
    dashArray: '0'
  });


}


function initial(input_obj, initialmap, type,showlist) // First - input parameter //second - 1-forward 2-load currentlevel data -1 back
{
console.log(showlist)
  if(showlist != '')
      loaddata = {
        'initialmap': initialmap,
        input: JSON.stringify(input_obj),
        'type': type
      };
  else
      loaddata = {
        'initialmap': initialmap,
        input: JSON.stringify(input_obj),
        'type': type,
        'filter':showlist
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
    beforeSend: function () {
      $(".spin-loader").attr('style', 'display:block');
    },
    complete: function () {
      $(".spin-loader").attr('style', 'display:none');
    },
    error:function(){ $(".spin-loader").attr('style', 'display:none');},

    success: function (res) {

      
      result[0] = res;

      if(!isEmpty(res['maplist']))
      {
          Globalobject[0] = res["tbl"];

          $("#maphead").html(res['head']);

          if (res.hasOwnProperty('griddata')) {
            changeproperty(res);
            tablebuild(res);
            if(type==3)
               legend(res['maplegend']);
            // combine_legend(res['maplegend']);
          } else {
            loadmap(res, '');
          }
      }

    }
  });
}
$("doucment").ready(function () {

  initial(input_obj, 0, '');

  $(".show_case_result").click(function () {
    $(".navbar-toggler").trigger("click");

    type = $(this).attr("id");
    legendremove();
    input_obj = {
      'type': type
    };
    initial(input_obj, 2, type);


  });
  $(".outlet-popup").click(function() {

    $('#mymodal-new').modal('show');

    });

  $("input[name='filter']").click(function(){

     var filterval = $("input[name='filter']:checked").val();
      $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
      type: 'POST',
      url: "{{ route('loadmap.post') }}",
      data: {'showlist':1,'showtype':filterval},
      dataType: 'json',
      //async: true,
      beforeSend: function () {
        $(".spin-loader").attr('style', 'display:block');
      },
      complete: function () {
        $(".spin-loader").attr('style', 'display:none');
      },
      error:function(){ $(".spin-loader").attr('style', 'display:none');},

      success: function (res) {
        $("showlist_user").css("display","none");


           if(res['msg']=='success')
           {
              $("#showlist_user").html('');
              $("#showlist_user").html(res['list_of_user']);
              $("#showlist_user").css("display","block");
               var listtable=$('#showlist').DataTable( {
                 'columnDefs': [
                 {
                    'targets': 0,
                    'checkboxes': {
                       'selectRow': true
                    }
                 }
              ],
              'select': {
                 'style': 'multi'
              },
                  order: [[ 1, 'asc' ]]
              } );
              $("#showlist_length").hide();
                $(".dt-checkboxes").click(function(){
                    var tr = $(this).closest("tr").attr("id");
                    showlist_user_id.push(tr);

              
             
             });

             $("#filterresult").click(function(){



                if(showlist_user_id.length > 0)
                {
                  obj={
                    'type':input_obj.type,
                    'filter_pc':showlist_user_id
                  }
                  console.log(obj);
                   initial(obj, 2, input_obj.type); 
                }

             });
       
             
           }





      },
    });

     
        
  });
  
});

/////////////////////////////////////////Map secction///////////////////////////////////////////////////////////////////////////


////////////////////////////////////////Result Section ///////////////////////////////////////////////////////////

function isEmpty(obj) {
  for (var key in obj) {
    if (obj.hasOwnProperty(key))
      return false;
  }
  return true;
}

function changeproperty(res) {


  $.each(res['map_nextlevel_info'], function (key, value) {


    layer = layer_bound[value['loc_id']]


    if (layer) {


      nextinfo = res['map_nextlevel_info'][layer.feature.properties.ID];
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
        pane: 'tool'
      });
   
      if (value.hasOwnProperty('color')) {


        layer.setStyle({
          fillColor: value.color,
          color: '#dddddd',
          weight: 1.5,
          stroke: 2,
          fillOpacity:2* overlay_arr[0]
        });

        layer.bindTooltip(value.info, {
          sticky: true
        });

      } else {
        console.log(value);
      }


    }

  });

}

function tablebuild(res) {
  // console.log(res);


  if ($.fn.dataTable.isDataTable('#griddata')) {

    table.destroy();
    $("#griddata").html("");


    table = $('#griddata').DataTable({
      data: res['griddata']['value'],
      columns: res['griddata']['column'],
      //retrieve: true,
      paging: true,
      searching: true,
      "JQueryUI": true,
      info: false,
      sorting: true,
      responsive: true,
      "scrollY": "900px",
      "scrollX": true,
      "scrollCollapse": true,

    });


  } else {
    table = $('#griddata').DataTable({
      data: res['griddata']['value'],
      columns: res['griddata']['column'],
      //retrieve: true,
      "JQueryUI": true,
      paging: true,
      searching: true,
      info: false,
      sorting: true,
      responsive: true,
      "scrollY": "900px",
      "scrollX": true,
      "scrollCollapse": true,


    });
 

  }
  table_obj[0]=table;
  $(".dataTables_length").remove();
   $("#showdata").css("display","flex");


  return true;
}



function legendremove() {
  for (i = 0; i < legend_arr.length; i++) {
    legend_arr[i].remove();
  }
}

function showbound(data) {

  id = $(data).attr("id");
  layer = layer_bound[id];
  if (layer) {
    map.fitBounds(layer.getBounds());
    layer.setStyle({
      color: "red",
      weight: 5,
      opacity: 1,
      stroke: 10,
      dashArray: '0'
    });
    $("#showmap").click();
  }


}

function legend(data)
{
  var legend = L.control({position: 'bottomleft'});

  legend.onAdd = function (map) {

      var div = L.DomUtil.create('div', 'info legend'),
         
          labels = [];

          $.each(data[0], function( index, value ) {
             div.innerHTML +=
              '<i style="background-color:' + value + '"></i>  '+index+'<br>' ;

          });

     
      return div;
  };

  legend.addTo(map);
  legend_arr.push(legend);

}
function clear_overlay_map()
{
   legendremove();
   $.each(layer_bound, function (key, value) {

    if(value !== undefined)
    { 
     value.bindTooltip(value.feature.properties.location_name, {
        sticky: true,
        pane: 'tool'
      });
      value.setStyle({
        fillColor: '#ffffff',
        color: '#dddddd',
        weight: 1.5,
        stroke:2,
        fillOpacity: 1*overlay_arr[0]
    });
    }
  });
   $('#griddata').DataTable().clear().destroy();
  

}
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  if (evt.currentTarget)
    evt.currentTarget.className += " active";

}
$("document").ready(function () {

   $(".tab-link a").click(function() {
                $(".tab-link a").removeClass("active");
                $(this).addClass("active");
            });
  $("#showmap").click();
   $("#showdata").css("display","none");
   $(".leaflet-range-control").hide();
});

////////////////////////////////////////Result Section ///////////////////////////////////////////////////////////////////////////////////////////////
const inputElements = document.querySelectorAll('[type="range"]');

        const handleInput = (inputElement) => {
            let isChanging = false;

            const setCSSProperty = () => {
                const percent =
                    ((inputElement.value - inputElement.min) /
                        (inputElement.max - inputElement.min)) *
                    100;
                // Here comes the magic 🦄🌈
                inputElement.style.setProperty("--webkitProgressPercent", `${percent}%`);
            }

            // Set event listeners
            const handleMove = () => {
                if (!isChanging) return;
                setCSSProperty();
            };
            const handleUpAndLeave = () => isChanging = false;
            const handleDown = () => isChanging = true;

            inputElement.addEventListener("mousemove", handleMove);
            inputElement.addEventListener("mousedown", handleDown);
            inputElement.addEventListener("mouseup", handleUpAndLeave);
            inputElement.addEventListener("mouseleave", handleUpAndLeave);
            inputElement.addEventListener("click", setCSSProperty);

            // Init input
            setCSSProperty();
        }

        inputElements.forEach(handleInput);
</script>
@endsection

    @push('plugin-scripts')
   
  <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    
  
    @endpush