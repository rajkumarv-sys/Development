@extends('layout.master')
@push('plugin-styles')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
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
                <table id="griddata" class="table display responsive nowrap" style="width:100%"></table>
                
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

        ////////////////////////////////////////Declaration//////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////////Map section ////////////////////////////////////////////////////////////////////////////////////////////


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
            "Map": gl,
            "Earth": streets
        };


        // L.control.layers(baseLayers,{position: 'bottomright'}).addTo(map);
        layerControl = L.control.layers(null, baseLayers, {
            position: 'bottomleft'
        });
        layerControl.addTo(map);
        map.doubleClickZoom.disable();

        map.createPane('labels');

        map.on('click', function(e) {
            console.log("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
        });

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

        function changeopacity(e) {

            if (overlay_arr.length > 0) {
                map.removeControl(overlay_arr[0]);
                overlay_arr = [];
                opacityval = 1;

                $.each(layer_bound, function(k, v) {

                    if (v !== undefined) {
                        layer = v;
                        layer.setStyle({
                            'fillOpacity': opacityval
                        });

                    }


                });

            } else {


                overlay_arr.push(control);

            }


        }
        var control = L.control.range({
            orient: 'horizontal',
            value: 100,
            position: 'bottomright',

        });
        overlay_arr[0] = 1;
        control.on('change input', function(e) {

            opacityval = e.value / 100;
            overlay_arr[0] = opacityval;

            $.each(layer_bound, function(k, v) {

                if (v !== undefined) {
                    layer = v;
                    layer.setStyle({
                        'fillOpacity': opacityval
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
                onClick: function(control) {


                    if (!isEmpty(layerclick['colony_id']) && layerclick['colony_id'] != '') {

                        str = "<div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='statuschange' id='statuschange' value='1'><label class='form-check-label' for='inlineRadio1'>Completed</label></div><div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='statuschange' id='statuschange' value='2' checked><label class='form-check-label' for='inlineRadio2'>Not completed</label></div> </div>";
                        $("#changeradio").html("");
                        $("#changeradio").html(str);
                        $('#mymodal').modal('show');

                        layer_select = layer_bound[layerclick['colony_id']];
                        layer_select.setStyle({
                            fillColor: '#A8A8A8',
                            color: '#808080',
                            weight: 5,
                            stroke: 8,
                            fillOpacity: overlay_arr[0]
                        });
                        layer_select.openTooltip();




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
                                    layer_select.setStyle({
                                        fillColor: '#ffffff',
                                        color: '#808080',
                                        weight: 5,
                                        stroke: 8,
                                        fillOpacity: overlay_arr[0]
                                    });
                                    layer_select.closeTooltip();
                                    layerclick['colony_id'] = '';


                                }
                            });



                        });

                    }





                }
            }]
        });

        map.addControl(backbut1);



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



                    onEachFeature: function(feature, layer) {

                        layer_bound[feature.properties.ID] = layer;




                        layer.on({


                            click: featureclick,
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

        function style(feature) {

            return {
                fillColor: '#ffffff',
                color: '#000000',
                weight: 2,
                stroke: 3,
                fillOpacity: overlay_arr[0]
            };

        }

        function touch(e) {

            mapTapHoldTimeout = setTimeout(function() {
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
                    color: '#808080',
                    weight: 0.5,
                    stroke: 0.7,
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
            layer.setStyle({
                color: "#808080",
                weight: 1.7,
                opacity: 1.5,
                stroke: 3.5,
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


            return true;
        }

        function clickOnMapItem(itemId) {
            var id = parseInt(itemId);
            //get target layer by it's id
            var layer = geo_layer[0].getLayer(id);

            console.log(layer);
            //fire event 'click' on target layer 
            layer.fireEvent('dblclick');
        }

        function highlightFeature(e) {
            var layer = e.target;
            layer.setStyle({

                color: "#808080",
                weight: 1.7,
                opacity: 1.5,
                stroke: 3.5,
                dashArray: '0'
            });


        }

        function resetHighlight(e) {
            var layer = e.target;
            layer.setStyle({
                color: '#808080',
                weight: 0.5,
                stroke: 0.7,
                fillOpacity: overlay_arr[0]
            });


        }

        function initial(input_obj, initialmap, type) // First - input parameter //second - 1-forward 2-load currentlevel data -1 back
        {


            loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': type
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

                        if (res.hasOwnProperty('griddata')) {
                            changeproperty(res);
                            tablebuild(res);
                            // combine_legend(res['maplegend']);
                        } else {
                            loadmap(res, '');
                        }
                    }

                }
            });
        }
        $("doucment").ready(function() {

            initial(input_obj, 0, '');

            $(".show_case_result").click(function() {
                $(".navbar-toggler").trigger("click");
                tooglericon();
                type = $(this).attr("id");
                legendremove();
                input_obj = {
                    'type': type
                };
                initial(input_obj, 2, type);


            });
            $(".navbar-toggler").click(function() {
                tooglericon();
            });

            function tooglericon() {
                if ($(".navbar-toggler i").hasClass("fa-bars")) {
                    $(".navbar-toggler i").removeClass("fa-bars");
                    $(".navbar-toggler i").addClass("fa-times");
                } else if ($(".navbar-toggler i").hasClass("fa-times")) {
                    $(".navbar-toggler i").removeClass("fa-times");
                    $(".navbar-toggler i").addClass("fa-bars");
                }
            }
            // $("body").find(".leaflet-control-container div.easy-button-container").click(function(){
            //   alert("test");
            //         $("body").find(".leaflet-control-container div.easy-button-container .status-change").remove();
            //  });

        });

        /////////////////////////////////////////Map section//////////////////////////////////////////////////////////////////////////////////////////////////  


        ////////////////////////////////////////Result Section ///////////////////////////////////////////////////////////////////////////////////////////////


        function isEmpty(obj) {
            for (var key in obj) {
                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }

        function changeproperty(res) {


            $.each(res['map_nextlevel_info'], function(key, value) {


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
                    layer.setStyle({
                        fillColor: '#ffffff',
                        color: '#808080',
                        weight: 0.5,
                        stroke: 0.8,
                        fillOpacity: overlay_arr[0]
                    });


                    if (value.hasOwnProperty('color')) {


                        layer.setStyle({
                            fillColor: value.color,
                            color: '#808080',
                            weight: 0.5,
                            stroke: 0.8,
                            fillOpacity: overlay_arr[0]
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
                    info: false,
                    sorting: true,
                    responsive: true,
                });


            } else {
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    //retrieve: true,
                    paging: true,
                    searching: true,
                    info: false,
                    sorting: true,
                    responsive: true,
                    


                });


            }
            $(".dataTables_length").remove();


            return true;
        }

        function combine_legend(data) {


            var legend = L.control({
                position: "bottomleft"
            });

            legend.onAdd = function(map) {
                var div = L.DomUtil.create("div", "legend");
                div.innerHTML += " <i style=' width: 50px;height: 10px;float: left;margin: 0 8px 0 0; opacity: 0.7;background-image: linear-gradient(to right,darkgreen,limegreen);'></i><span style='color:#ffffff;'>" + data + "</span>";

                return div;
            };
            legend_arr.push(legend);
            legend.addTo(map);


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

        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            // for (i = 0; i < tablinks.length; i++) {
            //     tablinks[i].className = tablinks[i].className.replace(" active", "");
            // }
            document.getElementById(cityName).style.display = "block";
            // if (evt.currentTarget)
            //     evt.currentTarget.className += " active";

        }
        $("document").ready(function() {
            $(".tab-link a").click(function() {
                $(".tab-link a").removeClass("active");
                $(this).addClass("active");
            });
            $("#showmap").click();
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

        inputElements.forEach(handleInput)
    </script>
    @endsection


    @push('plugin-scripts')
   
	<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    
	
    @endpush

