<!DOCTYPE html>
<html>

<head>
   <title>BrandIdea App</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="_token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ asset('assets/images/bi_favicon.ico') }}">
<link rel="manifest" href="../manifest.json">
<!-- plugin css -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.checkboxes.css') }}"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.dataTables.min.css">
<link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/font-awesome/css/all.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
<link rel="stylesheet" href="{{ asset('css/MarkerCluster.css') }}" />
<link rel="stylesheet" href="{{ asset('css/MarkerCluster.Default.css') }}" />


<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.css" /> -->
    <link rel="stylesheet" href="https://cdn.maptiler.com/mapbox-gl-js/v1.5.1/mapbox-gl.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.css" />




<link rel="stylesheet" href="{{ asset('css/easy-button.css') }}">
<link rel="stylesheet" href="{{ asset('css/jquery.tree-multiselect.css') }}">
<link rel="stylesheet" href="{{ asset('css/leaflet.contextmenu.css') }}">
<link rel="stylesheet" href="{{ asset('css/L.Control.Range.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />

<script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> -->

<!-- 
<script src="{{ asset('js/leaflet.js') }}"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.js"></script>
    <script src="https://cdn.maptiler.com/mapbox-gl-js/v1.5.1/mapbox-gl.js"></script>
    <script src="https://cdn.maptiler.com/mapbox-gl-leaflet/latest/leaflet-mapbox-gl.js"></script>
   
<script src="{{ asset('js/L.Control.Range.js') }}"></script>



<script src="http://sashakavun.github.io/leaflet-canvasicon/leaflet-canvasicon.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>


<script type="text/javascript" src="{{ asset('js/geojson2svg.min.js') }}"></script>

<!-- Load Esri Leaflet from CDN -->


<script type="text/javascript" src="{{ asset('assets/js/leaflet-piechart.js') }}"></script>




<!-- <link rel="stylesheet" href="http://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
   <script src="http://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script> -->
<!-- <script src="{{ asset('assets/L.KML.js') }}"></script> -->
<!--  <script src="{{ asset('assets/js/leaflet.label.js') }}"></script> -->


<!--  
   -->
<!-- <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
   <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.min.js"></script> -->
<!-- JQUERY CDN -->
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<!-- FONT AWESOME CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Leaflet v1.0.2 -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.2/leaflet.css" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.2/leaflet-src.js"></script>
   
   <script src="{{ asset('assets/js/Leaflet.Control.Custom.js') }}"></script>
   
   <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>
   
    -->
<script src="https://unpkg.com/esri-leaflet@3.0.1/dist/esri-leaflet.js"
   integrity="sha512-JmpptMCcCg+Rd6x0Dbg6w+mmyzs1M7chHCd9W8HPovnImG2nLAQWn3yltwxXRM7WjKKFFHOAKjjF2SC4CgiFBg=="
   crossorigin=""></script>
<script  src="https://aratcliffe.github.io/Leaflet.contextmenu/dist/leaflet.contextmenu.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script src="{{ asset('js/leaflet.markercluster-src.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>



 

<style type="text/css">
.form-check-inline
{
    color:#fff;
}
.table thead th
{
    text-transform: none !important;
}
.info {
padding: 6px 8px;
font: 14px/16px Arial, Helvetica, sans-serif;
background: white;
background: rgba(255,255,255,0.8);
box-shadow: 0 0 15px rgba(0,0,0,0.2);
border-radius: 5px;
}
.legend {

}
.showresult:hover {
    color: red;

}
.leaflet-control-locate a
{
    display: block !important;
}
/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
  from {opacity: 0;} 
  to {opacity: 1;}
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity:1 ;}
}
</style>
    <script type="text/javascript">
        function load(url)
    {

        var ajax = new XMLHttpRequest();
            //ajax.open("GET", url);
        ajax.open('GET', url, false);
        ajax.onreadystatechange = function ()
        {
            var script = ajax.response || ajax.responseText;
            if (ajax.readyState === 4)
            {
                switch(ajax.status)
                {
                    case 200:
                        eval.apply( window, [script] );
                        console.log("library loaded: ", url);
                        break;
                    default:
                        console.log("ERROR: library not loaded: ", url);
                }
            }
        };
        ajax.send(null);
    }

/////// Enable below javascript code while move on cloud /////
/////// This code for restrict accessing Browser console operations //////

// !function() {
//  function detectDevTool(allow) {
//    if(isNaN(+allow)) allow = 100;
//     var start = +new Date();
//     debugger;
//     var end = +new Date();
//     if(isNaN(start) || isNaN(end) || end - start > allow) {
//      alert('DEVTOOLS detected. all operations will be terminated.');
//       document.write('DEVTOOLS detected.');
//       javascript:window.close('','_parent','');
//     }
//   }
//   if(window.attachEvent) {
//    if (document.readyState === "complete" || document.readyState === "interactive") {
//      detectDevTool();
//       window.attachEvent('onresize', detectDevTool);
//       window.attachEvent('onmousemove', detectDevTool);
//       window.attachEvent('onfocus', detectDevTool);
//       window.attachEvent('onblur', detectDevTool);
//     } else {
//      setTimeout(argument.callee, 0);
//     }
//   } else {
//    window.addEventListener('load', detectDevTool);
//     window.addEventListener('resize', detectDevTool);
//     window.addEventListener('mousemove', detectDevTool);
//     window.addEventListener('focus', detectDevTool);
//     window.addEventListener('blur', detectDevTool);
//   }
// }();


// $(document).keydown(function(e){
//     if( e.which === 73 && e.ctrlKey && e.shiftKey){
//         alert('This operation not permitted !!!'); 
//     } else if( e.which === 67 && e.ctrlKey && e.shiftKey){
//         alert('This operation not permitted !!!'); 
//     } else if( e.which === 74 && e.ctrlKey && e.shiftKey){
//         alert('This operation not permitted !!!'); 
//     }
// }); 

// document.onkeydown = function (e) { 
//             if (event.keyCode == 123) { 
//                 return false; 
//             } 
//             if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) { 
//                 return false; 
//             } 
//             if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) { 
//                 return false; 
//             } 
//             if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) { 
//                 return false; 
//             } 
//             if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) { 
//                 return false; 
//             } 
//         } 


// document.onkeypress = function (event) {  
// event = (event || window.event);  
// if (event.keyCode == 123) {  
// return false;  
// }  
// }  
// document.onmousedown = function (event) {  
// event = (event || window.event);  
// if (event.keyCode == 123) {  
// return false;  
// }  
// }  
// document.onkeydown = function (event) {  
// event = (event || window.event);  
// if (event.keyCode == 123) {  
// return false;  
// }  
// }  

// document.onkeydown = function(e) {
//     if (e.ctrlKey && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 85 || e.keyCode === 117)) {//Alt+c, Alt+v will also be disabled sadly.
//         alert('not allowed');
//     }
//     return false;
// };

    </script>
       
    <!-- end plugin css -->
    @stack('plugin-styles')
    <!-- common css -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <!-- end common css -->
    @stack('style')
 <link rel="stylesheet" href="{{ asset('css/style.css') }}">
 <link rel="manifest" href="{{ asset('js/manifest.json')}}">
    @push('custom-scripts')
        <script>
            //$(function() {
                //alert("yesssssss");
               // $(document).on('click', '.myspin', function() {
                    //alert("Yessssssssssss");
                  //  $('#psdatasourcSpinner').show();
               // });
          //  });
        </script>
    @endpush

</head>

<body data-base-url="{{url('/')}}">
    <!-- <div class="text-center"> 
        To enable above body tage by prevent right click enable this <body data-base-url="{{url('/')}}" oncontextmenu="return false;"> 
        <div id="psdatasourcSpinner" class="spinner-border text-primary" style="width: 5rem; height: 5rem;display: none; margin-top:25px;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <script src="{{ asset('assets/js/spinner.js') }}"></script>

    <div id="spinner"></div> -->
    <div class="main-wrapper" id="app">
    @laravelPWA
        <div class="page-wrapper">
            @include('layout.header')
            <div class="page-content">
                @yield('content')
            </div>
            @include('layout.footer')
        </div>
    </div>
    <!-- base js -->
    <script src="{{ asset('js/app.js') }}"></script>

  
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>    
  
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.checkboxes.min.js') }}"></script>

    

    <!-- end base js -->
    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->
    <!-- common js -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>    
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    
<script src="{{ asset('/assets/js/file-upload.js') }}"></script>
<script src="asset('/assets/js/dashboard.js')"></script>

    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script>
        if ('serviceWorker' in navigator) {
            console.log("Will the service worker register?");
            navigator.serviceWorker.register('js/service-worker.js')
            .then(function(reg){
                console.log("Yes, it did.");
            }).catch(function(err) {
                console.log("No it didn't. This happened:", err)
            });
        }
    </script>
	<script>
		window.onload = () => {
		  'use strict';

		  if ('serviceWorker' in navigator) {
			   console.log("Will the service worker register new?");
			navigator.serviceWorker
					 .register('./sw.js');
					 console.log("Yes, it did new.");
		  }
		}

	</script>
    <!-- end common js -->
    @stack('custom-scripts')
</body>
</html>
