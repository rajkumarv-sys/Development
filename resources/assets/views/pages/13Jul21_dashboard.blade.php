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
                    <table id="griddata" class="table display responsive nowrap" style="width:100%"></table>
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
<div id="mymodal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Locality Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>


            <div class="modal-body" >
               
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
            <h5 class="modal-title">Add Outlets</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">
              <div class='form-control-lg'>

 <form action="{{url('/outlet/store')}}" id="outlet" method="post" enctype="multipart/form-data">
     {{ csrf_field() }}
    <div class="row">
      <div class="col-md-12" id="alertstatus">
     
     </div>
         
  <div class="col-md-6 grid-margin">
   
       
       
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
            
              <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile number">
            
          </div>

           <div class="form-group">
            <label for="exampleInputMobile" >PAN Number</label>
            
              <input type="text" class="form-control" id="pan_no" name="pan_no" placeholder="PAN number">
            
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
            <label for="exampleFormControlTextarea1">Address</label>
            <textarea class="form-control" id="address" rows="2" name="address"></textarea>
            <input type="hidden" name="gio_point" /> 
          </div>
          
            
          <div class="form-group">
            <label>File upload</label>           
            <input type="file" name="img" class="file-upload-default" accept="image/*" capture="camera">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
              </span>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">&nbsp;</label>
            <button class="btn btn-primary"  type="submit">Add Outlet</button>
          </div>
           
  
  </div>

</div>
</form>
    </div>
            </div><!-- /.modal-content -->

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
                    <th>#</th><th>Outlet</th><th>Channel</th><th>Sub Channel</th><th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>

                   @for ($i = 0; $i < count($list_outlet); $i++)
                    <tr>
                    <td>{{$i+1}}</td><td>{{$list_outlet[$i]->outlet_name}}</td><td>{{$list_outlet[$i]->channel}}</td><td>{{$list_outlet[$i]->subchannel}}</td><td><i class="fas fa-eye"></i>
                   <i onclick="deleteoutlet(this)" id="{{$list_outlet[$i]->refid}}" class="fa fa-trash"/></i></td>
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
                <div class="form-check form-check-inline filter-data">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input">
                    Inline checkbox
                <i class="input-frame"></i></label>
                </div>
                
            
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
        var table_obj=[];
        var showlist_user_id=[];
        var showlist_distributor_id=[];
        var last_clicked_type=[];
        var bound_check=[];
        var bound_type=[];
        var current_location=[];
        var route=false;
        var destination_location=[];
        var outlettbl;
        var filterclear=false;
        var dynamic_control=[];

        ////////////////////////////////////////Declaration///////////////////////////////////////////////////////

        /////////////////////////////////////////////Map section /////////////////////////////////////////////////////////////


        var map = L.map('map', {
            zoomControl: false,
            zoomSnap: 0.25,


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

      

        layerControl = L.control.layers( baseLayers, null,{
            position: 'bottomright'
        });

        

        layerControl.addTo(map);
       
        map.doubleClickZoom.disable();

        map.createPane('labels');

        map.on('click', function(e) {
            destination_location['lat']=e.latlng.lat;
            destination_location['lon']=e.latlng.lng;
        if(route==true){
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

          str="https://www.google.com/maps/dir/'"+current_location['lat']+","+current_location['lon']+"'/'"+destination_location['lat']+","+destination_location['lon']+"'/";
          window.open(str, 'window name', 'window settings');



        }
             
       
        route=false;   
        });
        
        map.getPane('labels').style.zIndex = 650;
        map.getPane('labels').style.pointerEvents = 'none';  

        map.on('zoomend', function() {


            zoomrange=map.getZoom();
          
            $.each(layer_bound, function (k, v) {

                   layer = v;

                  if (v !== undefined) {                   
                         if(bound_type[k]==1)  { 
                         if(layer.feature.id !== undefined)
                              layer.setStyle({
                                 weight: (zoomrange >= 16) ? 5 : 0.5,
                                 stroke: (zoomrange >= 16) ? 5 : 0.5,
                              });
                         }
                        if(bound_type[k]==2)  { 
                             for(i=0;i<v.length;i++)                
                             {
                               layer=v[i].layer_id;
                               if(layer !== undefined )
                               {
                                   console.log(layer);
                                  if(layer.feature.id !== undefined)
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
            title: 'Change map opcity',
            onClick: function (control) {
                  $(".leaflet-range-control").toggleClass('show-range');
            }
          }]
        });
      

        var range_control_button = L.control.range({
          orient: 'horizontal',
          value: 100,
          position: 'bottomright',

        });
        overlay_arr[0]=1;
        range_control_button.on('change input', function (e) {
          opacityval = e.value / 100;
          overlay_arr[0]=opacityval;
          change_opacity();
      });

      map.addControl(range_control_button);


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
       var locationcontrol = L.control.locate({
        position: 'bottomright',flyTo:false,keepCurrentZoomLevel:true,setView:false,drawMarker:true,showCompass:false,
        strings: {
            title: "Show me where I am."
        },
        
         getLocationBounds: function (locationEvent) {
             
                return locationEvent.bounds;
            },


    });
    

       map.addControl(locationcontrol);

    
      map.on('locationfound', function (e) {
         var locLat = e.latlng.lat;
         var locLng = e.latlng.lng;
         current_location['lat']=locLat;
         current_location['lon']=locLng;

          
      });

       var findway = L.easyButton({
        position: 'bottomright',
        states: [{
          stateName: 'globe-layer',
          icon: '<i class="fas fa-location-arrow"></i>',
          title: 'Navigate',
          onClick: function (control) {
             locationcontrol.start();

                  route=true;
            
          }
        }]
      });

        var filer_clear = L.easyButton({
        position: 'bottomright',
        states: [{
          stateName: 'Clear Filter',
          icon: '<i class="fa fa-filter"></i><i class="fa fa-times" aria-hidden="true"></i>',
          title: 'Navigate',
          onClick: function (control) {
            showboundbyusertype('');
          }
        }]
      });
        
        dynamic_control.push(filer_clear);
          map.addControl(filer_clear);
          dynamic_control[0].disable();

      map.addControl(findway);
      map.addControl(opacity_button);




///////////////////////////Easy Button End/////////////////////////////////////////////////////////////////////////////////////////////////


        function loadmap(res, view) {
          
            layer_bound = []; bound_type=[];bound_type=[];

            for (i = 0; i < res['maplist'].length; i++) {
              
                load(res['maplist'][i]);
                var geojson = L.geoJson(rs, {
                    style: style,
                    onEachFeature: function(feature, layer) {

                        if(bound_check.indexOf(feature.properties.ID) == -1)
                         {
                              bound_check.push(feature.properties.ID);
                              bound_type[feature.properties.ID]=1;  // to check multiple polygon
                              layer_bound[feature.properties.ID] = layer;
                         }
                         else
                         {
                           
                              lastlayer=layer_bound[feature.properties.ID]; 
                              layer_bound[feature.properties.ID]=[];
                              bound_type[feature.properties.ID]=2; 

                              if(!($.isArray(lastlayer)))
                              {
                                 layer_id=feature.properties.ID;
                                 layer_bound[feature.properties.ID].push({layer_id:lastlayer});
                                 layer_bound[feature.properties.ID].push({layer_id:layer});

                              }
                               if(($.isArray(lastlayer)))
                              {
                                 layer_id=feature.properties.ID;
                                for(i_l=0;i_l<lastlayer.length;i_l++)
                                {
                                   layer_bound[feature.properties.ID].push(lastlayer[i_l]);
                                }

                                
                                 layer_bound[feature.properties.ID].push({layer_id:layer});

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
                            layer.bindTooltip("<div class='tooltip-data no-border'><div class='card'><div class='card-header'>"+feature.properties.location_name+"</div></div>", {
                                sticky: true,
                                pane: 'tool',direction:'top'
                            });
                            
                        }
                        else
                        {
                            layer.setStyle({ fillColor: '#ffffff',
                                color: '#808080',
                                weight: 1,
                                stroke: 2,
                                fillOpacity: 0,
                                opacity:0
                              });

                        }
                    }
                });
                geo_layer.push(geojson);
            }
            var featureGroup = L.featureGroup(geo_layer).addTo(map);
            map.fitBounds(featureGroup.getBounds());
          //  map.setMaxBounds(map.getBounds());
           
        } 
 
        function change_status_byuser(e)
        {

            if( e.target.feature.id != '' &&  e.target.feature.id!=undefined)
            {
              layerclick['colony_id']=e.target.feature.properties.ID;
              str="<div class='form-check form-check-inline '><label class='form-check-label' for='inlineRadio2'><input class='form-check-input' type='radio' name='statuschange' id='statuschange' value='2' checked>Not Visited<i class='input-frame'></i></label></div><div class='form-check form-check-inline'><label class='form-check-label' for='inlineRadio1'><input class='form-check-input' type='radio' name='statuschange' id='statuschange' value='1'>Visited<i class='input-frame'></i></label></div> ";
                 $("#changeradio").html("");
                 $("#changeradio").html(str);          
                 $('#mymodal').modal('show');

                 layer_select = layer_bound[layerclick['colony_id']];
                    
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
                            layerclick['colony_id']='';
                          }});             
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

             zoomrange=map.getZoom();  
            if (!isEmpty(layerclick[0])) {
                layer_selected = layerclick[0];
                 if(layer_selected.feature.id !== undefined)
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
            if(layer.feature.id !== undefined)
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
            for (i = 0; i < geo_layer.length; i++) {
                if (map.hasLayer(geo_layer[i])) {
                   map.removeLayer(geo_layer[i]);
                }
            }

            geo_layer=[];


            return true;
        }

        function clickOnMapItem(itemId) {
            var id = parseInt(itemId);
            //get target layer by it's id
            var layer = geo_layer[0].getLayer(id);

            
            //fire event 'click' on target layer 
            layer.fireEvent('dblclick');
        }

       

        function initial(input_obj, initialmap, type,filter=false) // First - input parameter //second - 1-forward 2-load currentlevel data -1 back
        {
       
            if(!filter)
              loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': type
              };
            else
              loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': input_obj.type
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

                    if (!isEmpty(res['maplist'])) {
                        Globalobject[0] = res["tbl"];

                        $("#maphead h3").html(res['head']);   
                        if(filter)
                        {
                          removelayer();
                          if (res.hasOwnProperty('griddata')) {
                            loadmap(res, '');
                            changeproperty(res);
                            tablebuild(res,type);    
                            legendremove();          
                            legend(res['maplegend']);                          
                            } else {
                              
                                loadmap(res, '');
                            }
                           $('#mymodal-filter').modal('hide');   
                        }
                        else
                        {
                         
                            if (res.hasOwnProperty('griddata')) {
                            changeproperty(res);
                            tablebuild(res,type);              
                             legendremove();
                            legend(res['maplegend']);                          
                            } else {
                              
                                loadmap(res, '');
                            }
                        }


                       
                    }

                }
            });
        }
        function tooglericon() {
                if ($(".navbar-toggler i").hasClass("fa-bars")) {
                    $(".navbar-toggler i").removeClass("fa-bars");
                    $(".navbar-toggler i").addClass("fa-times");
                 } else   {
                    $(".navbar-toggler i").removeClass("fa-times");
                    $(".navbar-toggler i").addClass("fa-bars");
                }
            }
        $("doucment").ready(function() {

            initial(input_obj, 0, '');

            $(".show_case_result").click(function() {
                $(".navbar-toggler").trigger("click");
                type = $(this).attr("id");
                legendremove();
                input_obj = {
                    'type': type,
                     'filter_pc':showlist_user_id,
                     'filter_distributor':showlist_distributor_id
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
            
             $("input[name='filter']").change(function(){

                 var filterval = $("input[name='filter']:checked").val();

                 showlist_user_id=[];showlist_distributor_id=[];


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
                  
                  success: function (res) {
                        $("#showlist_user,.filter_action").css("display","none");


                           if(res['msg']=='success')
                           {

                              $("#showlist_user").html('');
                              $("#showlist_user").html(res['list_of_user']);
                              $("#showlist_user").css("display","block");
                              $(".filter_action").css("display","block");
                              
                               var listtable=$('#showlist').DataTable({'paging':false,"ordering": true,
                                                        columnDefs: [{
                                                          orderable: false,
                                                          targets: "no-sort"
                                                        }]});
                                $('#showlist tbody tr').click(function(event) {
                                      if (event.target.type !== 'checkbox') {
                                        $(':checkbox', this).trigger('click');
                                      }
                                  });
                              $("#showlist_length").hide();
                                $(".checking_box").click(function(){
                                       
                                       if($(this).hasClass('checked'))
                                          $(this).removeClass('checked');
                                       else
                                           $(this).addClass('checked');

                                         val_selected=parseInt($(this).val());

                                    if($(this).hasClass('checked'))
                                    {
                                       if(res['type']=='pc')
                                       {
                                           showlist_user_id.push(val_selected);

                                       }
                                       if(res['type']=='distributor')
                                       {
                                            showlist_distributor_id.push(val_selected);  
                                       }
                                    }
                                    else
                                    {
                                       if(res['type']=='pc')
                                       {
                                           showlist_user_id = $(showlist_user_id).not([val_selected]).get();
                                           
                                       }
                                       if(res['type']=='distributor')
                                       {
                                             showlist_distributor_id = $(showlist_distributor_id).not([val_selected]).get();
                                           
                                       }
                                    }

                                    if(showlist_user_id.length > 0 || showlist_distributor_id > 0)
                                    {
                                                  if(!($('.checkbox_all').hasClass('checked'))){                                                        
                                                        $( '.checkbox_all' ).addClass("checked");
                                                        $( '.checkbox_all' ).prop('checked', true);
                                                   }
                                    }
                                    else
                                    {
                                                  if(($('.checkbox_all').hasClass('checked'))){                                                        
                                                        $( '.checkbox_all' ).removeClass("checked");
                                                        $( '.checkbox_all' ).prop('checked', false);
                                                   }

                                    }


                             

                             });

                                $(".checkbox_all").click(function(){
                                  showlist_user_id=[];showlist_distributor_id=[];

                                        if($(this).hasClass('checked'))
                                          $(this).removeClass('checked');
                                       else
                                           $(this).addClass('checked');

                                          if($(this).hasClass('checked'))
                                          {
                                             $('.checking_box').each(function() {
                                               val_selected=parseInt($(this).val());
                                                if($(this).hasClass('checked')){
                                                  $( this ).removeClass("checked");
                                                  $( this ).addClass("checked");
                                                  $( this ).prop('checked', true);
                                                  

                                                  ((res['type']=='pc')) ? showlist_user_id.push(val_selected) : showlist_distributor_id.push(val_selected);

                                                }                                                    
                                                else
                                                {
                                                    $( this ).addClass("checked");
                                                     $( this ).prop('checked', true);
                                                    ((res['type']=='pc')) ? showlist_user_id.push(val_selected) : showlist_distributor_id.push(val_selected);
                                                }

                                            });  
                                          }
                                          if(!($(this).hasClass('checked')))
                                          {
                                            val_selected=parseInt($(this).val());
                                             $('.checking_box').each(function() {
                                                if($(this).hasClass('checked')){
                                                  $( this ).removeClass("checked");                                                  
                                                 }
                                                 $( this ).prop('checked', false);
                                                   val_selected=parseInt($(this).val());

                                                  ((res['type']=='pc')) ? $(showlist_user_id).not([val_selected]).get() : $(showlist_distributor_id).not([val_selected]).get();
                                            });  
                                          }
                                          

                                });

                             $("#filterresult").unbind().click(function(){    


                                    if(showlist_user_id.length > 0 || showlist_distributor_id.length >0 )
                                    {
                                      
                                        obj={
                                          'type':input_obj.type,
                                          'filter_pc':showlist_user_id,
                                          'filter_distributor':showlist_distributor_id
                                        }                                 
                                       initial(obj, 2, input_obj.type,true); 
                                    }
                                    else
                                    {
                                       alert("please Choose any filter");
                                    }

                             });

                            $("#clearresult").unbind().click(function(){
                              showlist_user_id=[];showlist_distributor_id=[];

                                      legendremove();
                                      obj={
                                        'type':input_obj.type,
                                        'filter_pc':[],
                                        'filter_distributor':[]
                                      }                                 
                                       initial(obj, 2, input_obj.type,true); 
                                        $("input[name='filter']:checked").prop('checked',false).removeAttr('checked');
                                        $("#showlist_user,.filter_action").css("display","none");
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
        function changeproperty(res) {



           $.each(layer_bound, function(key, value) {       


             if(res['map_nextlevel_info'][key])
             { 
                
                      if(bound_type[key]==1)
                      {
                            layer=value;
                            changestyle_byresult(layer,res['map_nextlevel_info'][key]);
                           
                }
                if(bound_type[key]==2)
                {
                    for(i=0;i<value.length;i++)
                    {
                     
                             layer=value[i].layer_id;
                             changestyle_byresult(layer,res['map_nextlevel_info'][key]);
                            
                    }
                }
             }


           });


        }

        function changestyle_byresult(layer,result) {
                   
                   if(layer !== undefined &&  (layer.feature.id !== undefined)){

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
                                    sticky: true,crossOrigin:true,
                                    pane: 'tool',direction:'top'
                            });
                            zoomrange=map.getZoom();                                
                            layer.setStyle({
                                fillColor: '#ffffff',
                                color: '#ffffff',
                                weight: (zoomrange >= 16) ? 5 : 1,
                                stroke: (zoomrange >= 16) ? 5 : 2,
                                fillOpacity: overlay_arr[0]
                            });
                          if (result.hasOwnProperty('color')) {
                              layer.setStyle({
                                  fillColor: result.color,
                                  color: '#ffffff',
                                  weight: (zoomrange >= 16) ? 5 : 1,
                                  stroke: (zoomrange >= 16) ? 5 : 2,
                                  fillOpacity: overlay_arr[0]
                              });

                              layer.bindTooltip(result.info, {
                                  sticky: true,
                                 direction:'top'
                              });

                          }

                   }
                          
                            

        }

        function tablebuild(res,type) {
           tablefoot=false;
            if ($.fn.dataTable.isDataTable('#griddata')) {

                table.destroy();
                $("#griddata").html("");
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf', 'print'],
                    paging: false,
                    info: false,
                    responsive: false,
                    // scrollY:        "85vh",
                    // scrollX:        true,
                    // scrollCollapse: true,
                    // paging:         false,
                    // fixedColumns:   {
                    //     leftColumns: 2
                    // },
                                
                  //  fnFooterCallback: function(row, data, start, end, display) {

                  //     if(tablefoot==false && parseInt(type) !=3){
                  //        var api = this.api();

                  //       var footer = '<tfoot><tr>';
                  //       footer +='<td colspan="7" style="text-align:center;">Total</td>';
                  //       total_retailer=0;mdlz_retailer=0;mdlz_notretailer=0;

                  //       for(i=0;i<data.length;i++)
                  //       {
                          
                  //           total_retailer +=data[i][7];
                  //           mdlz_retailer +=data[i][8];
                  //           mdlz_notretailer +=data[i][9];

                  //       }
                  //        footer +='<td style="text-align:right;">'+total_retailer+'</td>';
                  //        footer +='<td style="text-align:right;">'+mdlz_retailer+'</td>';
                  //        footer +='<td style="text-align:right;">'+mdlz_notretailer+'</td>';
                       
                  //        footer +='</tr></tfoot>';
                  //        console.log(footer);

                  //        $(this).append(footer);
                   
                        
                        
                  //   }
                  //   }, 

                });
              
                // tablefoot=true;

              
            } else {
              tablefoot=false;
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf', 'print'],
                    paging: false,
                    info: false,
                    responsive: false,
                    // scrollY:        "85vh",
                    // scrollX:        true,
                    // scrollCollapse: true,
                    // paging:         false,
                    // fixedColumns:   {
                    //     leftColumns: 2
                    // },
                   // fixedHeader: true,  
                    
                  //  fnFooterCallback: function(row, data, start, end, display) {

                  //     if(tablefoot==false && parseInt(type) !=3){
                  //        var api = this.api();

                  //       var footer = '<tfoot><tr>';
                  //       footer +='<td colspan="7" style="text-align:center;">Total</td>';
                  //       total_retailer=0;mdlz_retailer=0;mdlz_notretailer=0;

                  //       for(i=0;i<data.length;i++)
                  //       {
                         
                  //           total_retailer +=data[i][7];
                  //           mdlz_retailer +=data[i][8];
                  //           mdlz_notretailer +=data[i][9];

                  //       }
                  //        footer +='<td style="text-align:right;">'+total_retailer+'</td>';
                  //        footer +='<td style="text-align:right;">'+mdlz_retailer+'</td>';
                  //        footer +='<td style="text-align:right;">'+mdlz_notretailer+'</td>';
                       
                  //        footer +='</tr></tfoot>';

                  //        $(this).append(footer);
                   
                        
                        
                  //   }
                  //   },                  
                });

                // tablefoot=true;
                

            }            

           $(".dataTables_length").remove();
           $("#showdata").css("display","flex")

           return true;
        }
        
        function legendremove() {

            for (i = 0; i < legend_arr.length; i++) {
                legend_arr[i].remove();
            }
            legend_arr=[];
        }
        function legend(data)
        {
            var legend = L.control({position: 'bottomleft'});

            legend.onAdd = function (map) {

            var div = L.DomUtil.create('div', 'info legend'),
               
            labels = [];             

            $.each(data[0], function( index, value ) {
             div.innerHTML +=
              '<div class="legend-wraper"><span style="background-image:linear-gradient(to right, ' + value + ' , ' + value + ')"></span>'+index+'</div>' ;

            });
          return div;
        };

        legend.addTo(map);

        legend_arr.push(legend);

      }
        function showbound(data) {

       
           zoomrange=map.getZoom();          

            id = $(data).attr("id");

           
            //  for(i=0;i<geo_layer.length;i++)
            // {                 
            //       geo_layer[i].eachLayer(function (layer) {  
            //         if(layer !== undefined  && (layer.feature.id !== undefined))
            //                 layer.setStyle({ weight: (zoomrange >= 16) ? 5 : 0.5,
            //                 stroke: (zoomrange >= 16) ? 5 : 0.8, color: '#808080'}); 
            //     });
            // }
           
            if(bound_type[id]==2)
            {
               bounds=[];
                
               for(i=0;i<layer_bound[id].length;i++)
               {
                   layer=layer_bound[id][i].layer_id;
                   if(layer !== undefined  && (layer.feature.id !== undefined))
                     {
                      
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

            }
            else
            {
                 layer = layer_bound[id];
                if (layer !== undefined  && (layer.feature.id !== undefined)) {
                     
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
       
           zoomrange=map.getZoom(); 
           if(data == '')
             id='';
           else
             id = $(data).attr("id");           
           
           showlist_user_id=[]; showlist_distributor_id=[];
           if(id != '')
              showlist_user_id.push(id);

             obj={
              'type':input_obj.type,
              'filter_pc':showlist_user_id,
              'filter_distributor':showlist_distributor_id
              }                                 
             initial(obj, 2, input_obj.type,true); 
             $("#showmap").click();  
           if(showlist_user_id.length>0)
           {
            dynamic_control[0].enable();

              //map.addControl(dynamic_control[0]);
             
           }
           if(showlist_user_id.length<=0)
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
            $("#showdata").css("display","none");
           
            //  $(".leaflet-range-control").hide();
            $('.range-slider').click(function(){
                $('.range-control').css("width","0");
                $('.range-control').animate({
                    width: '100%'
                });
                $('#range-animate').toggle();
            });
            $(".map-opt").click(function() {
                if($(this).hasClass('chk-active'))
                {
                    $(".map-opt").removeClass("chk-active");
                    $(this).addClass("chk-active");
                    
                }
                else
                {
                     $(".map-opt").removeClass("chk-active");
                    $(this).addClass("chk-active");
                    
                }
                
            });
            $(".filter-data input[type='checkbox']").change(function() {
                if($(this).prop('checked')) {
                    // alert("Checked Box Selected");
                    if($(".filter-data").hasClass('check-active'))
                    {
                        $(".filter-data").toggleClass('check-active')
                    }
                    else
                    {
                        $(".filter-data").toggleClass('check-active')
                    }
                } else {
                    $(".filter-data").toggleClass('check-active')
                }
            });
        });
        function change_opacity()
        {
         
           $.each(layer_bound, function (k, v) {

             layer = v;
                 
            if (v !== undefined) {
             
                   if(bound_type[k]==1)  { 
                    if(layer.feature.id !== undefined)                
                        layer.setStyle({
                          'fillOpacity': overlay_arr[0]
                        });
                   }
                  if(bound_type[k]==2)  { 
                       for(i=0;i<v.length;i++)                
                       {

                         layer=v[i].layer_id;

                          if (layer !== undefined) {
                             if(layer.feature.id !== undefined)
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

       $(document).ready(function ()
        {
           $(".fa-map-marker").click();
            
                  function getLocation() {
                    if (navigator.geolocation) {
                      navigator.geolocation.getCurrentPosition(showPosition);
                    } else {
                     alert("Geolocation is not supported by this browser.");
                    }
                  }
                  function showPosition(position) {
                   
                    current_location['lat']=position.coords.latitude;
                    current_location['lon']=position.coords.longitude;

                    console.log(position.coords.latitude,position.coords.longitude);                   

                  }
                  
                
                 outlettbl= $("#outlet_list_tbl").DataTable({info:false,paging:false});


                setInterval(function(){
                 // map.locate({setView: true, maxZoom: 16});
                 
                  getLocation();
                  
                   geo=current_location['lat']+','+current_location['lon'];
                   // if(current_location['marker'] == undefined || current_location['marker'] == ''){
                   //    current_location['marker']=L.marker([current_location['lat'], current_location['lon']]).addTo(map);
                   // }
                   // else{
                   //  var newLatLng = new L.LatLng(current_location['lat'], current_location['lon']);
                   //   current_location['marker'].setLatLng(newLatLng); 
                   // }

                 $('input[name="gio_point"]').val(geo);
        
                  }, 3000);


                $('select[name="channel_name"]').on('change',function(){
                   var channel = $(this).val();
                   if(channel)
                   {
                    $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                      $.ajax({
                         url : 'dashboard/getsubchannel/' +channel,
                         type : "POST",
                         data:{'channel':channel},
                         dataType : "json",
                         success:function(data)
                         {
                            console.log(data);
                            $('select[name="sub_channel_name"]').empty();
                            $.each(data, function(key,value){
                               $('select[name="sub_channel_name"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                         }
                      });
                   }
                   else
                   {
                      $('select[name="sub_channel_name"]').empty();
                   }
                });
                $("form#outlet").submit(function(e) {
                  
                    e.preventDefault();    
                    var formData = new FormData(this);

                    var isValid = true;
                    $('#outlet_name,#owner_name,#channel_name,#sub_channel_name,#address').each(function () {

                        if ($.trim($(this).val()) == '') {
                            if($(this).attr(""))
                            isValid = false;
                            $(this).css({
                                "border": "1px solid red",
                                "background": "#FFCECE"
                            });
                        }
                        else {
                            $(this).css({
                                "border": "",
                                "background": ""
                            });
                        }
                    });
                    if (isValid == true)
                     {
                            $.ajax({
                            url: 'dashboard/addoutlet',
                            type: 'POST',
                            data: formData,
                            success: function (data) {
                                result_form=JSON.parse(data);                              
                                if(result_form['status']=='success')
                                {
                                    $("#alertstatus").html('<div class="alert alert-success" role="alert">'+result_form['msg']+'</div>');
                                     document.getElementById("outlet").reset();
                                }
                                else
                                {
                                   $("#alertstatus").html('<div class="alert alert-danger" role="alert">'+result_form['msg']+'</div>');
                                    
                                   

                                }
                                 setInterval(function(){ $(".alert").hide('slow');             }, 3000);
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                     }
                    
                });
        });

     function deleteoutlet(data)
     {
        outlet_id=$(data).attr("id");
         $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
           url : 'dashboard/deleteoutlet/' +outlet_id,
           type : "POST",
           data:{'outlet_id':outlet_id},
           dataType : "json",
           success:function(response)
           {
              //response=JSON.parse(response);                              
              if(response['status']=='success')
              {
                  $("#alertstatus_list").html('<div class="alert alert-success" role="alert">'+response['msg']+'</div>');
                  
                   outlettbl.row( $(data).parents('tr') ).remove().draw();
                  
              }
              else
              {
                 $("#alertstatus_list").html('<div class="alert alert-danger" role="alert">'+response['msg']+'</div>');
              }
               setInterval(function(){ $(".alert").hide('slow');             }, 3000);
           }
        });

     }

                      
      
      ////////////////////////////////////////////Add Outlets ////////////////////////////////////////////////////////////////////////
    </script>
    @endsection


    @push('plugin-scripts')
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

