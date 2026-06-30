@extends('layouts.master')
@push('plugin-styles')

<link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.dataTables.min.css') }}">
<!-- <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" /> -->
<link href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.dataTables.min.css" rel="stylesheet" />

<!------ Include the above in your HEAD tag ---------->

<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="X-UA-Compatible" content="ie=edge">


   
   

@endpush

@section('content')
<style>
 .donate-now {
  list-style-type: none;
  margin: 25px 0 0 0;
  padding: 0;
}

.donate-now li {
  float: left;
  margin: 0 5px 0 0;
  width: 100px;
  height: 40px;
  position: relative;
}

.donate-now label,
.donate-now input {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}

.donate-now input[type="radio"] {
  opacity: 0.01;
  z-index: 100;
}

.donate-now input[type="radio"]:checked+label,
.Checked+label {
  background: yellow;
}

.donate-now label {
  padding: 5px;
  border: 1px solid #CCC;
  cursor: pointer;
  z-index: 90;
}
.textclass
{
  background:transparent;
  font-size:12px;
  color:#000;
  border:none !important;
  font-style: bold;
  border-style:none !important;
  box-shadow:none !important;
}
.donate-now label:hover {
  background: #DDD;
}
.btn-age-select-wrapper input[type='radio'] {
   /* visibility: hidden;*/
}

.form-check.btn-age-select-wrapper {
    display: inline !important;
   background:#767a7a;
    border: #767a7a;
}
label.btn-age-wrapper.form-check-label {
    display: inline !important;
    margin: 0px!important;
}
label.btn-age-wrapper.form-check-label.brandstock {
    display: inline !important;
    margin: 0px!important;
    margin: 17px!important;
    padding-left: 4px;
}

  .btn-age-select-wrapper {
   background:#767a7a;
    border: #767a7a;
    color: #fff !important;
    padding: 6px 10px!important;
    margin: 0px 3px!important;
    border-radius: 3px!important;
}

.inline-wrapper ul li {
    display:inline !important;
    padding:0px 2px;
}
.product-stocked ul li {
    color:#fff;
}

.product-stocked {
    margin: 0px 0px;
 padding-bottom: 11px;
 padding-top: 11px;
}

.Capture-btn-relevant {
background-color: #bd2728;
    color: #fff;
    border: 1px solid #bd2728;
    padding: 10px 30px;
    border-radius: 3px;
    margin: 0 auto;
    text-align: center;
    width: 100%;
}
.bg-Product-wrappers {
    background-color: #186b57;
    color: #fff;
    margin: 0px 11px;
    border-radius: 3px;
    padding-top: 12px;
  margin-bottom: 4px;
  padding-bottom: 4px;
}
.not-relevant-btn {
    
}
#show-potential {
    padding-bottom:15px;
}
.j-product-title{
    padding-bottom:10px;
}
button.easy-button-button.leaflet-bar-part.leaflet-interactive.beat-list-active.Capture-btn {
    color: #fff;
}
#bg-align {
    padding-bottom:10px;
}
.bg-titles {
    border-bottom:1px solid #fff;
}
.bg-next {
    border-bottom:1px solid #fff;
    color:#fff;
}
.title-checkbox {
    padding-left:8px;
    font-size:16px;
}
.menubar-top {
    background-color: #186b57;
    color: #fff;
    padding: 5px 0px;
    border-radius:3px;
}
#bg-store {
    background-color: #186b57;
    color: #fff;
    padding: 8px 0px;
    padding-top: 20px;
    border-radius: 3px;
}
#bg-align {
    padding-top: 26px;
    padding-bottom: 16px;
}
.alignleft {
    float: left;
    color: #fff;
    padding-top: 0px;
    padding-bottom: 8px;
}
.alignright {
    float: right;
    color: #fff;
    padding-top: 0px;
    padding-bottom: 8px;
    
}

.store-bg {
margin-top: 30px;
}
.menu-bg-title {
     color: #fff;
     padding-bottom: 10px;
}

.jj-products-wrapper {
    background-color: #186b57;
    color: #fff;
    margin: 0px 10px;
    border-radius: 3px;
}


.jj-product-title h6{
    color:#fff;
padding: 10px 0px;
}
.next-btn {
    text-align:right;
     color:#fff;
}
.next-btn ul li a {
    color:#fff;
}
.card-body ul li {
    border:none;
}
.Capture-btn {
    background-color:#186b57;
    border:1px solid#186b57;
    padding: 10px 30px;
    border-radius: 3px;
    margin: 0 auto;
    text-align: center;
    width: 100%;
}
.Capture-btn:hover {
    background-color:#079c78;
    border:1px solid#079c78;
    padding: 10px 30px;
    border-radius: 3px;
    margin: 0 auto;
    text-align: center;
    width: 100%;
}

.capturedetails {
    text-align:center;
}

.form-check.capturedetails {
    background-color: #186b57;
    padding: 4px 10px;
    border-radius: 3px;
}
.list-group-item {
    background-color: transparent !important;
  
}

.popup-footer span {
    color: #fff;
  text-align:center;
    text-decoration: none;
    /* background: #000; */
}

.popup-footer {
    margin: .5rem 0 0px;
    padding: 3px 7px;
    display: flex;
    background: #186b57;
    color: #fff;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    align-items: center;
    justify-content: space-between;
}
.popup-footer {
  
     display: static; 
    background: #186b57;
    color: #fff;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    align-items: right; 
    justify-content: space-between;
    text-align: right;
    /* float: right; */
}
.popup-footer {
        padding-bottom: 9px;
     background: #186b57 !important; 
    color: #fff;
    text-align:center;
   
}
.form-check.bg-wrapper {
    background-color: #186b57;
    color: #fff;
    padding: 0px 10px;
    padding-top: 16px;
    padding-bottom: 6px;
    border-radius: 5px;
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
    .legend1{
        line-height: 18px;
        color: #555;
    }

    .legend1 span {
        width: 20px;
        height: 7px;
        float: left;
        margin-right: 8px;

    }

    .leaflet-control-container .leaflet-routing-container-hide {
        display: none;
    }
.circle {
  border: 2px solid #FFF;
  border-radius: 50%;
  display: inline-block;
}
.covered_circle {
  border: 2px solid #9b5df7;
  border-radius: 25px;

  display: inline-block;
}


.inner {
   width: 51px;
    height: 51px;
    line-height: 15px;
    color: 'red';
    background-color: #fff;
    border-radius: 50%;
    margin: 1px;
    padding-top: 25%;
    text-align: center;
    color: #d11212;
    font-size: 11px;
   /* width: 70px;
    height: 70px;
    line-height: 17px;
    color:'red';
    background-color: #fff;
   
    border-radius: 50%;
    margin: 1px;
    padding-top: 25%;
    text-align: center;
    color: #d11212;
    font-size: 13px;*/
       /* width: 50px;
    height: 50px;
    line-height: 45px;
    color: 'red';
    background-color: #fff;
    border-radius: 50%;
    margin: 1px;
    text-align: center;
    color: #d11212;
    font-size: 10px;*/
}
.inner_small
{
  width: 32px;
    height: 32px;
    line-height: 32px;
    color:'red';
    background-color: #fff;
   
    border-radius: 50%;
    margin: 1px;
    text-align: center;
    color: #d11212;
    font-size: 12px;
}
.inner_cluster
{
  width: 40px;
    height: 40px;
    line-height: 40px;
   color: 'red';
    background-color: #fff;

   
    border-radius: 50%;
    margin: 1px;
    text-align: center;
    color: #d11212;
    font-size: 10px;
}
.inner_covered {
     width: 32px;
    height: 32px;
    line-height: 32px;
  background-color: #9b5df7;
  border-radius: 15px;
  margin: 3px;
  font-weight: bold;
/*  height: 30px;
  width: 30px;*/
  text-align: center;
  color:#FFF;
 font-size: 10px;
}
.dot {
  height: 15px !important;
  width: 15px !important;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
}
.form-check-input {
    position: absolute;
    margin-top: 0.3rem;
     margin-left: 0rem !important; */
}
.legend-wraper {
    display: flex;
    align-items: center;
    font-size: 12px;
    color: #fff;
    /* padding: 9px 0px; */
    padding: 2px 0px;
}
.tab-content {
    background: #141313;
}
.nav.nav-tabs.nav-tabs-line .nav-link.active {
    border-bottom: none;
    border-top: 2px solid #d93637;
    border-left: 2px solid #d93637;
    border-right: 2px solid #d93637;
    border-radius: 3px;
}
.nav.nav-tabs .nav-item .nav-link.active {
    background-color: #000;
    color: #ffffff;
    border-bottom: none;
}
.nav.nav-tabs.nav-tabs-line .nav-link {
    border: 0;
    background-color: #201e1e00;
    color: #fff;
    border-top: 2px solid #d93637;
    border-left: 2px solid #d93637;
    border-right: 2px solid #d93637;

}
.tab-pane {
     padding: 0px !important;
}

 /*  memubar section  */

.Capture-btn-details{
    background-color: #186b57 !important;
    color: #fff;
    border: 1px solid #186b57 !important;
}
/*.Relevant-Store-wrapper {
    margin-top:10px;
    padding: 17px 0px;
}*/
.Relevant-Store-wrapper {
    margin-top: 10px;
        padding: 0px 0px 5px;
}
.Brand-Availability {
    color:#fff;
    border-bottom:1px solid #fff;
}
.Brand-wrapper {
    padding-top:10px;
}
li.list-group-item.Brand-wrapper {
    padding-top: 12px;
}
li.list-group-item.form-wrapper {
    background-color: #186b57 !important;
    /*border: 1px solid#186b57;*/
       padding: 0px 10px;
    border-radius: 3px;
        margin-bottom: 12px;
}
.Next {
    color:#fff;
    text-align: right;
}
.Next-btn {
    padding-top:10px;
    border-bottom: 1px solid #fff;
}

#bg-box-title {
    padding-bottom:10px;
}
.Competition-title {
    padding-bottom:10px;
}
div#textbox {
    margin: 0px 5px;
}
i.fa.fa-pencil-square-o {
   margin-top: -20px!important;
    position: absolute;
    bottom: 3px;
    background-color: #186b57;
    padding: 10px 12px;
    width: 13%;
    border-radius: 3px;
    right: 13px;
    color: #fff;
}
button.btn.btn-success.Capture-btn.edit-button {
background-color: #186b57;
 border: 1px solid#186b57;
    padding: 10px 30px;
    border-radius: 3px;
    margin: 0 auto;
    text-align: center;
    width: 73%;
}

span.edit-bar {
    float: right;
}
.not-relevant-edit-button
{

    padding: 10px 30px;
    border-radius: 3px;
    margin: 0 -3px;
    text-align: center;
    width: 73%;
}

.leaflet-popup-content p {
    margin: 0px 0 !important;
}


input[type=checkbox] {
       
               background: #f26522 !important;
               color: #fff;
    }

    .form-check-wrapper {
    position: relative !important;
    margin-top: -2px !important;
    margin-bottom: -2px !important;
    padding-left: 0 !important;
        padding-bottom: 3px!important;
}


input[type=checkbox] + label {
  display: block;
  margin: 0.2em;
  cursor: pointer;
  font-family: 'Arial'
}

input[type=checkbox] {
  display: none;
}

input[type=checkbox] + label:before {
  content: "\2714";
  border: 0.1em solid #fff;
  border-radius: 0.2em;
  display: inline-block;
  width: 1.5em;
  height: 1.5em;
  padding-left: 0.2em;
  padding-bottom: 0.3em;
  margin-right: 0.2em;
  vertical-align: bottom;
  color: transparent;
  transition: .2s;
}

input[type=checkbox] + label:active:before {
  transform: scale(0);
}

input[type=checkbox]:checked + label:before {
  background-color: #ED820A;
  border-color: #ED820A;
  color: #fff;
}

input[type=radio]:checked + label:before {
  background-color: #f26522;
  border-color: #f26522;
  color: #fff;
}

input[type=checkbox]:disabled + label:before {
  transform: scale(1);
  border-color: #aaa;
}

input[type=checkbox]:checked:disabled + label:before {
  transform: scale(1);
  background-color: #F7C28F;
  border-color: #F7C28F;
}
/*
.form-check .form-check-label {
    margin-left: 0.5rem !important;
    font-size: 0.875rem;
    line-height: 1.5;
}*/
label.checkbox-wrapper.form-check-label {
    margin-left: 0.0rem!important;
}
/*
.Brand-Availability-wrapper input[type='radio']:after {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: transparent;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white;
    }

.Brand-Availability-wrapper input[type='radio']:checked:after {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #ffa500;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white;
    }
*/
.channeltype {
  margin: 0px 0px !important;
}
label.form-check-label.jj-products-stocked {
  margin-left: 0px !important;
}

.choose-stored-type {
  margin:0px 0px !important;
}
p.alignleft.btn-primary.back {
    padding: 1px 10px;
    border-radius: 3px;
    background: #f26522d9;
    border: #f26522;
  margin-bottom: 14px !important;
}
p.alignright.btn-primary.next {
    padding: 1px 10px;
    border-radius: 3px;
    background: #f26522d9;
    border: #f26522;
  margin-bottom: 14px !important;
}
span.jj-product-align-check-box {
    padding-left: 4px;
}


.next-alignment {
    padding-top: 10px !important;
padding-bottom: 10px !important;
}
li.list-group-item.form-wrapper.edit {
    padding: 0px 0px;
}
label.form-check-label.check-wrapper.from-Brand-Availability {
  margin-left:3.5px !important;
}

label.form-check-label.check-wrapper.check-box-top {
    margin-left: 0px;
}
label.form-check-label.check-wrapper {
    margin-left: 0px;
}
.form-baby-care {
  margin:0px 0px !important;
}
.potential-header {
  margin:0px 0px !important;
}
.next-alignment-Competition {
  padding-bottom:5px !important;
  padding-top:7px !important;
}

.choose-stored-type {
    margin: 0px 0px!important;
    background: #186b57;
    padding: 0px 12px;
    padding-top: 10px;
   padding-bottom: 2px;
}
.Choose-Channel-type {
  background: #186b57;
    padding: 0px 12px;
    padding-top: 10px;
   padding-bottom: 2px;
}
.button.btn.btn-success.Capture-btn:hover {
  background: #f26522;
    color: #fff;
    border-color: #f26522;
}
.relevant-high {
    background-color: #186b57;
    padding: 3px 10px!important;
    border-radius: 3px;
   color: #ffff !important;
    margin-left: 10px;

}
.Capture-btn-relevant:hover {
  background-color: #d53839;
  border:1px solid #d53839;
}
.Store-right {
  background-color: #186b57;
    border: 1px solid#186b57;
  color:#fff;
}
#store-high {
  background-color: #186b57;
border: 1px
solid#186b57;
color: #fff;
 border-radius: 3px;
padding: 7px 10px;
margin-right: 12px;
margin-top: 0px;
float: right;

}
.store-high {
  color:#fff;
  float: right;
    margin-top: -30px;
     color: #fff !important;
}
.leaflet-popup-close-button {
  display:none;
}
/*
.store-high:before {
  content: "";
    height: 57px;
    left: 0px;
    margin: 0 auto;
    position: absolute;
    right: 0;
    top: -26px;
    width: 100%;
    border-bottom: 2px solid #fff !important;
  color: #fff !important;
}
*/

.outlet-list ul li h3 {
   /* border-bottom: none !important;*/
}

.top-capture-wrapper {
  width:100%;
  float:left;
}
.upload-image ul {
  list-style-type: none;
}
.upload-image ul li{
float: left;
   padding: 7px 14px;
   position: relative;

}
.upload-image ul li a {
  text-decoration: none;
}
.close-outer-image {
  color: #ffff;
    font-size: 20px;
    position: absolute;
    top: -2px;
right: -11px;
}
.form-check.capturedetails-upload {
    background-color: #186b57;
    padding: 4px 6px;
    border-radius: 3px;
    width: 100%;
  color: #fff;
  text-align: center;
}
.upload-edit-button-icon {
  margin-top: -20px!important;
position: absolute;
bottom: 0px;
background-color: #186b57;   
width: 26%;
border-radius: 3px;
right: -73px;
color: #fff !important;
}
i.fa.fa-upload.upload-button-icons {
    padding: 13px 7px;
}
button.btn.btn-default.upload {
    color: #ffff;
}
.outlet-image-heading {
  color: #ca6a3a;
  border-bottom: 1px solid #ca6a3a;
}
.outlet-content {
  color: #ca6a3a;
  font-size: 13px;
}
.Important-title {
    padding-top: 15px;
padding-bottom: 15px;
}
.outletupload {
  border-radius: 0px;
}
button.btn.btn-secondary.upload-Store-Photos-Cancel {
background-color: #737478 !important;
color: #fff;
border:1px solid #737478 !important;
}

.ring
{
    height: 15px !important;
    width: 15px !important;
    border-radius: 50%;
    display: inline-block;
    
}
#upload-wrapper {
  position: relative;
}
.filter-active {
  border: 1px solid #808080;
    margin-bottom: 0.7rem!important;
    margin-top: 0 !important;
    padding: 0 0.425rem;
    border-radius: 3px;
    background: #808080;
}
.align-self-start {
    width: 100%;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    object-fit: contain;
}
/* hidden on default */
.align-self-start { display: none; }

/* use a media query to filter small devices */
@media only screen and (min-device-width:400px) {
    /* show the popup */
    .align-self-start { display: block; }
    .outlet-list ul li {font-size: 12px;}
}
button.btn-close {
   float: right;
    background-color: transparent;
    border: 0px;
}
.title-box {
  /*margin-bottom:30px;*/
  margin-bottom:10px;
}
h3 {
   padding-bottom:7px !important; 
}

[type="radio"]:checked+label:after {
  background-color: #f26522;
  border: 2px solid #f26522;
  
}
.outlet-list ul li span {
    padding: 0px 4px;
    color: #000000;
    font-weight: bold;
}
.ClicktoNavigate {
  border-bottom:2px solid #fff; 
}
span.upload-edit-button-icon {
    display: none;
}
.circle_count {
 width: 25px !important;
    height: 25px !important;
    line-height: 25px !important;
    border-radius: 50% !important;
   /* font-size: 16px !important;*/
    color: #fff !important;
    text-align: center !important;
    background: #0f493b !important;
    padding: 6px 10px !important;
    /*margin: 0px 0px 0px 34px;*/
    font-weight: bold !important;
}
button.btn-close {
    background-color: transparent;
    border: 0px;
    position: absolute;
    right: -4px;
    top: 0px;
}
.layout {
    
    display: inline-flex !important;
    position: relative;
    margin: 0px 11px 0px 2px;
    
}
.layout > .form-check-input {
    position: absolute;
    margin-top: 0.3rem;
    margin-left: 0.5rem !important;
     ;
}
.table-striped>tbody>tr:nth-child(odd)>td, 
.table-striped>tbody>tr:nth-child(odd)>th {
   background-color: rgb(255,238,186);
 }
</style>
 <div class="col-md-12" id="alertstatus_list">

                    </div>
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
                    <table id="griddata" class="table display " style="width:100%;margin-top:3rem;"></table>
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
<div id="mymodal-beat" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Beat </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="beatlist" style="color:#fff;">

                @for ($i = 0; $i < count($beat_list); $i++) <div class="form-check form-check-inline filter-data">
                    <a href="#" style="color:white;"> <label class="form-check-label" style="text-decoration: underline">
                        <input type="checkbox" class="form-check-input show_beat" name="beat" value="{{$beat_list[$i]->id}}">
                        <a href="#"  style="color:white;" >{{$beat_list[$i]->beat_name}}</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label></a>
            </div>
        
            @endfor
            <div class="modal-footer">
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_beat" id="filter_bybeat">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-subrdbeat" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Subrd </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="subrdbeatlist" style="color:#fff;">

                @for ($i = 0; $i < count($subrd_beat); $i++) <div class="form-check form-check-inline filter-data">
                    <a href="#" style="color:white;"> <label class="form-check-label" style="text-decoration: underline">
                        <input type="checkbox" class="form-check-input show_beat" name="subrd_beat" value="{{$subrd_beat[$i]->refid}}">
                        <a href="#"  style="color:white;" >{{ucwords(strtolower($subrd_beat[$i]->subrd_code))}}: {{ucwords(strtolower($subrd_beat[$i]->subrd_name))}}</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label></a>
            </div>
        
            @endfor
            <div class="modal-footer">
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_subrdbeat" id="filter_bysubrdbeat">Apply</button>
                </div>
            </div>

            




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
                <h5 class="modal-title">New outlet </h5>
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
                                         @for ($i = 0; $i < count($sub_channel_list); $i++)

                                            <option value='{{$sub_channel_list[$i]->refid}}'>{{$sub_channel_list[$i]->name}}</option>

                                         @endfor
                                        
                                      <!--   <option value='2'>Chats & Snacks</option>
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
                                        <option value='18'>Wholesale</option> -->
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
                                    <input type="file" name="img" id="fileupload" class="file-upload-default" accept="image/*" >
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

<div id="mymodal-filterchannel" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Channel Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="channel_filter" style="color:#fff;">
               <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                <li class="nav-item">                	
                    <a class="nav-link active" id="home-line-tab-0" data-toggle="tab" href="#home-0" role="tab" aria-controls="home-0" onclick="openCity1(event, 'home-line-tab-0')" aria-selected="true">Outlets</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" id="home-line-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" onclick="openCity1(event, 'home-line-tab')" aria-selected="true">Channel</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-line-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" onclick="openCity1(event, 'profile-line-tab')" aria-selected="false">Potential</a>
                  </li>
                    <li class="nav-item">
                    <a class="nav-link" id="status-line-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" onclick="openCity1(event, 'status-line-tab')" aria-selected="false">Status</a>
                  </li>
                 
                </ul>
                <div class="col-md-12 grid-margin">
                <div class="tab-content mt-3" id="lineTabContent">
                   <div class="tab-pane fade show active" id="home-line-tab-0" role="tabpanel" aria-labelledby="home-line-tab-0">
                  
                    
                    
					@php
					if((Auth::user()->client_id)!=100 && (Auth::user()->client_id)!=86){
					@endphp
                    <div class="form-check form-check-inline filter-data-0">

                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input show_outlet" name="outlets" value="1" checked>
                        Covered
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                   @php
					}
					@endphp

                    <div class="form-check form-check-inline filter-data-0">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input show_outlet" name="outlets" value="2" checked>
                        Uncovered
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                     
              
            </div>
                  <div class="tab-pane" id="home-line-tab" role="tabpanel" aria-labelledby="home-line-tab">
                   
                     
                       @for ($i = 0; $i < count($channel_list); $i++)                        
                       <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="channellist_" name="tag_list" value="{{$channel_list[$i]->maintype_id}}" checked/>
                        @php
                        if((Auth::user()->client_id)==86){
                          $channel= explode("/",$channel_list[$i]->main_type);
                          $channel_list[$i]->main_type=$channel[1];
                      }
                      @endphp

                         &nbsp;{{$channel_list[$i]->main_type}}
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                    @endfor

                      
                   
                  <!--     <select class="form-control form-control-sm mb-3" id="channellist" name="tag_list" > -->
                       
               
            </div>
                  <div class="tab-pane fade" id="profile-line-tab" role="tabpanel" aria-labelledby="profile-line-tab">
                  	 <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="potentiallist_" name="potentiallist" value="3" checked/>
                         &nbsp;High
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                    <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="potentiallist_" name="potentiallist" value="2" checked/>
                         &nbsp;Medium
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                    <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="potentiallist_" name="potentiallist" value="1" checked/>
                         &nbsp;Low
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                  
                </div>

                 <div class="tab-pane fade" id="status-line-tab" role="tabpanel" aria-labelledby="status-line-tab">
                 		 <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="statuslist_" name="statuslist" value="N" checked/>
                         &nbsp;Not Visited
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                   @php
          if((Auth::user()->client_id)==86){
          @endphp
                   	 <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="statuslist_" name="statuslist" value="R" checked/>
                         &nbsp;Not Found
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                    @php
                  }
          else{
          @endphp
          <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="statuslist_" name="statuslist" value="NF" checked/>
                         &nbsp;Not Found
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
          @php
                  }
          
          @endphp
                   	 <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="statuslist_" name="statuslist" value="A" checked/>
                         &nbsp;Visited-Relevant
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                   	   @php
          if((Auth::user()->client_id)==100){
          @endphp
                     <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="statuslist_" name="statuslist" value="R" checked/>
                         &nbsp;Visited-Not Relevant
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                   @php
          }
          @endphp
                   
                </div>
                             
                </div>
            </div>


        </div><!-- /.modal-content -->
        <div class="modal-footer">
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="button" onclick="filter_bychannel()">Filter</button>
                    </div>
            </div>

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
   
</div>
<div id="mymodal-district" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Distt. / Drill Down into Distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="districtlist" style="color:#fff;">

              @foreach ($taluk_list as $k=>$v) 

              <div class="form-check form-check-inline filter-data">
                   <a href="#" style="color:white;"> <label class="form-check-label" style="text-decoration: underline">
                        <input type="checkbox" class="form-check-input show_district" name="districtlist" value="{{$k}}" />
                       <a href="#" id="{{$k}}" district_name="{{$v['district']}}" style="color:white;text-decoration: underline" onClick=showtaluk(this)>{{$v['district']}}</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label></a>
            </div>
        
            @endforeach
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_dist" id="filter_bydist">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-highway" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Assigned Highway(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="highwaylist" style="color:#fff;">

               @for ($i = 0; $i < count($highway_list); $i++)

              <div class="form-check form-check-inline filter-data">
                   <a href="#" style="color:white;"> <label class="form-check-label" style="text-decoration: underline">
                        <input type="checkbox" class="form-check-input show_district" name="highwaylist" value="{{$highway_list[$i]->refid}}" />
                       <a href="#"  style="color:white;" >{{$highway_list[$i]->highway_name}}</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label></a>
            </div>
        
            @endfor
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_byhighway" id="filter_byhighway">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-village" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
             <p>
                <h4 class="modal-title" style="color:rgb(206,86,29);" id="village_name">Bairi Dariyon Villg.&nbsp;</h4><span class="mt-1"  style="height:1.5rem;width: 1.5rem;background-color: #00CCCC;border-radius: 50%;text-align: center;margin-left:0.50rem;"><i class="fa fa-location-arrow fa-1x" id="navigation" aria-hidden="true"></i></span><p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body p-2"  style="color:#fff;">
            <div class="row"> 
              <div class="col-sm-6">
                <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Cluster ID</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="cluster_id" name="fname" value="Cluster 1763"></span></div>
                <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">State Name</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="state_name" name="fname" value="Cluster 1763"></span></div>
                 <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Distt Name</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="district_name" name="fname" value="Cluster 1763"></span></div>
                <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Sub-Distt Name</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="sub_distt_name" name="fname" value="Cluster 1763"></span></div>
                 <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Town / Village Name</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="town_village_name" name="fname" value="Cluster 1763"></span></div>
                  <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Market UID</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="market_uid" name="fname" value="Cluster 1763"></span></div>
                   <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">BI Locatn ID</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="bi_id" name="fname" value="Cluster 1763"></span></div>
                    <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Distance from Recmmd SubRD / Wholesale Locatn (Km)</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="distance" name="fname" value="Cluster 1763"></span></div>
                     <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Recommndd SubRD / Wholesale Location</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="recommand_subrd" name="fname" value="Cluster 1763"></span></div>
                      <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Outlet potential</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="outlet_potential" name="fname" value="Cluster 1763"></span></div>
                       <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Population 2021</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="pop_2021" name="fname" value="Cluster 1763"></span></div>
                        <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Taluk Census</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="taluk_census" name="fname" value="Cluster 1763"></span></div>
                         <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Village Census</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="village_census" name="fname" value="Cluster 1763"></span></div>
                          <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Village Chocolate Consmptn (Rs.)</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="consmptn" name="fname" value="Cluster 1763"></span></div>
                           <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Cluster Tag</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="cluster_tag" name="fname" value="Cluster 1763"></span></div>
                            <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">SubD Priority</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="sub_priority" name="fname" value="Cluster 1763"></span></div>
                             <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">SubD Cluster Priority</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="subd_priority" name="fname" value="Cluster 1763"></span></div>
                              
            </div>
            <div class="col-sm-6">
                   <div class="card p-2" style="background-color: transparent;border: 1px solid white;">
                         <div class="d-flex flex-row justify-content-around"> 
                          <button type="button" class="btn btn-primary">Action 1</button>
                            <button type="button" class="btn btn-primary">Action 2</button>
                              <button type="button" class="btn btn-primary">Action 3</button>
                                <button type="button" class="btn btn-primary">Action 4</button>
                                  <button type="button" class="btn btn-primary">Action 5</button>  </div>
                   </div>
            </div>
          </div>
             
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <!-- <button class="btn btn-primary" name="filter_dist" id="filter_bydist">Apply</button> -->
                </div>
            </div>



        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-taluk" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="district_head">Select Distt. / Drill Down into Distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            

              @foreach ($taluk_list as $k=>$v) 
            <div class="modal-body district_taluk" id="taluklist_{{$k}}" style="color:#fff;display:none;">
               @foreach ($v['taluk_list'] as $kt=>$vt) 

              <div class="form-check form-check-inline filter-data" >
                    <a href="#" style="color:white;"> <label class="form-check-label" style="text-decoration: underline">
                        <input type="checkbox" class="form-check-input show_taluk dist_{{$k}}" district_id="{{$k}}" name="taluklist" value="{{$vt['id']}}"/>
                       <a href="#" id="{{$vt['id']}}" style="color:white;">{{$vt['taluk']}}</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label></a>
            </div>
            @endforeach
          </div>
            @endforeach
            


            <div class="modal-footer">
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_taluk" id="filter_bytaluk">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
 <div id="mymodal-fileupload" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Outlet Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

   
   
      <form action="{{url('/outlet/store')}}" id="outlet_image" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <div class='form-control-lg'>

           
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-12" id="alertstatus_1">
                 </div>
        <div class="outlet-image">
      <h6><span class="outlet-image-heading"><i>Important</i></span></h6>
         <div class="Important-title">
         <p class="outlet-content"><i>1. Open your camera's settings</i></p>
         <p class="outlet-content"><i>2. Turn on or off Location tags before capturing the photo</i></p>
           </div>
       </div>
    
             


            
              <div class="form-group">
                 

                  <input type="hidden" class="form-control" id="outlet_id" name="outlet_id" placeholder="Outlet ID">

                </div>



              <div class="col-md-12 grid-margin">

                <div class="form-group">
                  <label>File upload</label>
                  <input type="file" name="img[]" class="file-upload-default" accept="image/*" multiple="true">
                  <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Photo">
                    <span class="input-group-append">
                      <button class="file-upload-browse btn btn-primary outletupload" type="button">Select</button>
                    </span>
                  </div>
               </div>

              </div>

               <div class="col-md-12" id="Imagelist">

              </div>


            </div>
           
        </div>
      </div><!-- /.modal-content -->
      <div class="modal-footer">
          <div class="form-group">
            
            <button class="btn btn-primary upload-Store-Photos" type="submit">Upload Store Photo(s)</button>
            <button type="button" class="btn btn-secondary upload-Store-Photos-Cancel" data-dismiss="modal">Cancel</button>
          </div>
      </div>
      </form>
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

@php
if((Auth::user()->client_id)==100){
@endphp
<script>

    var channel=<?php echo $jj_channel;?>;
  jjchannel=JSON.stringify(channel);
  jjchannel=JSON.parse(jjchannel);
 
</script>
@php
}
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
    var circle_marker_arr = [];
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
    var uncovered_outlet_markerarray = [];
    var outlet_marker_cluster = [];  
    var filter_so = [];
    var centercoordinates=[];
    var type_of_view=[];
    var showarray=[];
    var showarray_uncovered=[];
    var filter_by_channel=[];
    var filter_beat=[];
    var detailed_array={};
    var uncovered_outlet_detail=[];
    var marker_cluster_list=[];
    var find_val=[];
    var cluster_layer=[];
    var bubble_data=[];
    var bubble_data_highlight=[];
    var geo_layer_json;
    var geo_layer = [];  
    var overlay_arr = [];
    var grayscale;
    var streets;
    var layers_base=[];
    var layer_group=[];
    var bubble_layer=[];
    var bubble_data=[];
    var list_of_retailer_highway=[];
    var highway_pop=[];
    var highway_subrd=[];
    var type_view=[];



var initiated=[];
var activated=[];
var active=[];
var inactive=[];
var deactivated=[];
var rpi_layer=[];
var recomand_subrd=[];
var exist_subrd=[];
var whole_subrd=[];
dynamic_control['rpi_action']=[];

var active_layer,initiated_layer,activated_layer,inactive_layer,deactivated_layer,recomand_subrd_layer,exist_subrd_layer,whole_subrd_layer;


     vars={};
     vars_2={};
    var markercluster = new L.MarkerClusterGroup({ 
          iconCreateFunction: function (cluster) {
              var markers = cluster.getAllChildMarkers();
              var html = '<div class="circle">  <div class="inner_small">' + markers.length + '</div></div>';
              return L.divIcon({ html: html, className: 'mycluster', iconSize: L.point(32, 32) });
          },
          spiderfyOnMaxZoom: true, showCoverageOnHover: true, zoomToBoundsOnClick: true 
      });


     var uncovered_markercluster = new L.MarkerClusterGroup({ 
          iconCreateFunction: function (cluster) {
              var markers = cluster.getAllChildMarkers();
              var html = '<div class="covered_circle">  <div class="inner_covered">' + markers.length + '</div></div>';
              return L.divIcon({ html: html, className: 'mycluster', iconSize: L.point(32, 32) });
          },
          spiderfyOnMaxZoom: true, showCoverageOnHover: true, zoomToBoundsOnClick: true 
      });
      
      




    ////////////////////////////////////////Declaration///////////////////////////////////////////////////////

    /////////////////////////////////////////////Map section /////////////////////////////////////////////////////////////


    var map = L.map('map', {
   
        zoomControl: false,
        zoomSnap: 0.25,
        maxZoom: 25,
         contextmenu: true,  
            contextmenuItems: [
            {
                text: 'Show Direction',
                //icon: 'images/zoom-out.png',
                callback: direction

            }],
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
       //streets = L.esri.basemapLayer('Imagery', { maxNativeZoom: 23});


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
// var greenIcon = L.icon({
//     iconUrl: 'css/images/marker-icon.png',
   

//     iconSize:     [25,41], // size of the icon
//     shadowSize:   [0, 0], // size of the shadow
    
// });

//     var marker = L.marker([26.884197, 81.047005], {icon: greenIcon}).addTo(map);

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


      

        // if(type_of_view[0]==9)
        // {
        //     center_lat=map.getCenter().lat;
        //     center_lng=map.getCenter().lng;
        //     centercoordinates=[center_lat,center_lng];
           

        //             $.ajaxSetup({
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });
        //             $.ajax({
        //                 url: 'dashboard/shownearoutlet',
        //                 type: "POST",
        //                 data: {
        //                     'center_coordinates': centercoordinates
        //                 },
        //                 dataType: "json",
        //                 success: function(response) {

        //                      uncovered_res=response;
        //                       if (uncovered_outlet_markerarray.length > 0) {
        //                                     for (i = 0; i < uncovered_outlet_markerarray.length; i++) {

        //                                         if (map.hasLayer(uncovered_outlet_markerarray[i])) {
        //                                             map.removeLayer(uncovered_outlet_markerarray[i]);
        //                                         }
        //                                     }
        //                                     uncovered_outlet_markerarray = [];
        //                        }


        //                      $.each(uncovered_res, function(key, value) {

        //                         if ((value.lat != '' && value.lon != '') && (value.lat !== undefined && value.lon !== undefined) && (value.lat !== 'undefined' && value.lon !== 'undefined')) {
        //                              info = '';
                        
        //                              info = '<div class="media outlet-list"><img class="align-self-start" src="' + value.shop_image + '" width="100px" alt=""><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li></ul></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)">Click to Navigate</span></div></div>';

        //                             if (value.icon != '' && value.icon !== undefined) {

        //                                 var greenIcon = L.icon({
        //                                     iconUrl: value.icon,
        //                                     iconSize: [24, 24], // size of the icon
        //                                     // iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
        //                                     // shadowAnchor: [4, 62], // the same for the shadow
        //                                     //  popupAnchor: [-7, -86] // point from which the popup should open relative to the iconAnchor
        //                                 });

        //                                 var m = new L.Marker(new L.LatLng(value.lat, value.lon), {
        //                                     icon: greenIcon,
        //                                      contextmenu: true,
        //                                       contextmenuItems: [{
        //                                         text: 'Activate',
        //                                         callback: function() {
        //                                           circleContextClick(value.refid,'A');
        //                                         }
        //                                       },
        //                                       {
        //                                         text: 'Not Relevant',
        //                                         callback: function() {
        //                                           circleContextClick(value.refid,'R');
        //                                         }
        //                                       },
        //                                       ]
        //                                 });

        //                             } else {
        //                                 var m = new L.Marker(new L.LatLng(value.lat, value.lon));
        //                             }
        //                             m.bindPopup(info, {
        //                                 'sticky': true,
        //                                 pane: 'tool',
        //                                 direction: 'top'
        //                             }).addTo(map);
        //                             uncovered_outlet_markerarray.push(m);

        //                             k++;


        //                         }

        //                     });
                          
        //                 }
        //             });
                   
              
        // }



    });
function searchoutlet(e)
{
   alert();
}
function view_village_detail(data)
{
 
  $("#village_name").html(data[0].village_name);
  $("#cluster_id").val(data[0].cluster_name);
  $("#state_name").val(data[0].state_name);
  $("#district_name").val(data[0].district_name);
  $("#sub_distt_name").val(data[0].taluk_name);
  $("#town_village_name").val(data[0].village_name);

   $("#market_uid").val(data[0].market_id);
  $("#bi_id").val(data[0].bi_id);
  $("#distance").val(data[0].distance_subrd);
  $("#recommand_subrd").val(data[0].cluster_tag);
  $("#outlet_potential").val(data[0].outlet_potential);
  $("#pop_2021").val(data[0].population);
  $("#taluk_census").val(data[0].taluk_census);
  $("#consmptn").val(data[0].village_choc_consmptn);
  $("#cluster_tag").val(data[0].subrd_loaction);
  $("#sub_priority").val(data[0].subrd_priority);
   $("#subd_priority").val(data[0].subrd_priority);
   $("#showmap").click();
   $("#navigation").attr("geocode",data[0]['latitude']+','+data[0]['longitude']);
   
    $('#mymodal-village').modal('show'); 
    $("#navigation").attr("onClick",location_navigate(this));

}
$("#navigation").click(function(){
   
          getLocation();
          
         
         clicked_shop_location=$(this).attr("geocode");
         console.log(clicked_shop_location);
         shop_location=clicked_shop_location.split(",");

         shop_lat=shop_location[0];
         shop_lon=shop_location[1];     
       
         
         str = "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + shop_lat + "," + shop_lon + "'/";
         window.open(str, 'window name', 'window settings');
});
function selectchild(id)
{
  $("input[name='districtlist']").each(function(){

    if($(this).prop("checked")){
      id=$(this).val();
      $(".dist_"+id).each(function(){
       
        $(this).prop("checked",true);
      });

    }
    else
       {
         id=$(this).val();
      $(".dist_"+id).each(function(){
       
        $(this).prop("checked",false);
      });
       }
      
  });
}
function showtaluk(data)
{
  district_id=$(data).attr('id');
  $("#district_head").html($(data).attr('district_name')+ ' Distt. - Select Sub-Distt.');
  $('#mymodal-district').modal('hide');
  $('#mymodal-taluk').modal('show'); 
  $( ".district_taluk" ).each(function(  ) {
    $(this).hide();
  });
  $('#taluklist_'+district_id).show();
   $.each($("input[name='taluklist']:checked"), function() {
    $(this).prop("checked",false);
   });
}
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
     if(("{{Auth::user()->user_type}}") == 'SUPPORT' && (("{{Auth::user()->client_id}}")==100 || ("{{Auth::user()->client_id}}")==130))
    {
         var filter_channel = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-filter',
                title: 'Filter',
                onClick: function(control) {
                    $('#mymodal-filterchannel').modal('show');
                }
            }]
        });
        map.addControl(filter_channel);
         dynamic_control.push(filter_channel);
         dynamic_control[0].disable();

        var filer_clear = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'Clear Filter',
                icon: '<i class="fa fa-trash"></i>',
                title: 'Clear',
                onClick: function(control) {
                  $("#channellist option:eq(0)").prop("selected", true);
                  $("#potentiallist option:eq(0)").prop("selected", true);
                  $("#statuslist option:eq(0)").prop("selected", true);
                   // $("#channellist").val("");
                   // $("#potentiallist").val("");
                   deletefilter();


                }
            }]
        });
         map.addControl(filer_clear);
         dynamic_control.push(filer_clear);
         dynamic_control[1].disable();

           var filter = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'beat-list',
                icon: 'fa fa-road',
                title: 'beat-list',
                onClick: function(control) {
                    $('#mymodal-beat').modal('show');
                }
            }]
        });
        map.addControl(filter);
    }
   
    if(("{{Auth::user()->client_id}}")==86)
    {

         var backbtn = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-arrow-left',
                title: 'Back',
                onClick: function(control) {
                   
                    filter_beat = [];

                    $.each($("input[name='beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });


                    outlet_type=[];selected_id=[];potential_selected_id=[];status_selected_id=[];

                 $('input[name="outlets"]:checked').each(function() {
                      outlet_type.push(this.value);
              });
                   $('input[name="tag_list"]:checked').each(function() {
                      selected_id.push(parseInt(this.value));
              });
                    $('input[name="potentiallist"]:checked').each(function() {
                      potential_selected_id.push(parseInt(this.value));
              });
                    $('input[name="statuslist"]:checked').each(function() {
                      status_selected_id.push(this.value);
              });

                   input_obj = {
                      'type': 11,
                         
                      'filter_bypotential':potential_selected_id,
                      'filter_beat':filter_beat,
                      'filter_bystatus':status_selected_id
                      };
                    initial(input_obj, 0,11, '');

                }
            }]
        });
        map.addControl(backbtn);
         dynamic_control[5]=backbtn;
         dynamic_control[5].disable();
    
         var filter = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'beat-list',
                icon: 'fa fa-road',
                title: 'beat-list',
                onClick: function(control) {
                    $('#mymodal-beat').modal('show');
                }
            }]
        });
        map.addControl(filter);

        var filer_clear = L.easyButton({
        position: 'bottomright',
        states: [{
            stateName: 'Clear Filter',
            icon: '<i class="fa fa-trash"></i>',
            title: 'Clear',
            onClick: function(control) {
                $("#clearresult").click();
                  clearfilter();
            }
        }]
    });
    map.addControl(filer_clear);
     var filter_channel = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-filter',
                title: 'Filter',
                onClick: function(control) {
                    $('#mymodal-filterchannel').modal('show');
                }
            }]
        });
        map.addControl(filter_channel);
    }
 if(("{{Auth::user()->user_type}}") == 'SUPPORT' && (("{{Auth::user()->client_id}}")==2) || (("{{Auth::user()->client_id}}")==1)  )
    {
     var filter = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'beat-list',
                icon: 'fa fa-road',
                title: 'beat-list',
                onClick: function(control) {
                    $('#mymodal-beat').modal('show');
                    
                }
            }]
        });
        map.addControl(filter);

}
if(("{{Auth::user()->user_type}}") == 'TSM' && (("{{Auth::user()->client_id}}")==120))
    {
     
       
    var locationcontrol = L.control.locate({
        position: 'bottomright',
        flyTo: true,
        keepCurrentZoomLevel: true,
        setView: false,
        drawMarker: true,
        showCompass: true,
        icon: 'fa fa-crosshairs',
        enableHighAccuracy: true,
        watch:true,
        // maxZoom: 20,
        strings: {
            title: "Show me where I am."
        },

        getLocationBounds: function(locationEvent) {

            return locationEvent.bounds;
        },


    }); 
    map.addControl(locationcontrol);
    locationcontrol.start();


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
               // showboundbyusertype('');
                $('#maphead').html('');
                legendremove();
                removelayer();
                $("#showdata").css("display", "none");
            }
        }]
    });
     map.addControl(findway);
 }
if (("{{Auth::user()->user_type}}") != 'SUPPORT') {
    dynamic_control.push(filer_clear);
     map.addControl(filer_clear);
     // if(dynamic_control[0] !='' && dynamic_control[0] != null && dynamic_control[0]!=undefined)
     //       dynamic_control[0].disable();
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



    function loadmap(res, view,highway=false,subrd=false) {

        layer_bound = [];
        bound_type = [];
        bound_type = [];
        bubble_data=[];
        bubble_data_highlight = [];

        for (i = 0; i < res['maplist'].length; i++) {

            //load(res['maplist'][i]);
            var message;

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

           // var decrypted = JSON.parse(code.decryptMessage(message, mapkeystr));
          
          if(highway)
          {

              var geojson = L.geoJson(JSON.parse(message), {
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
                        click: featureclick_1,
                       // dblclick: change_status_byuser
                        //  mouseover: highlightFeature,
                        //mouseout: resetHighlight,touchstart:touch
                    });
                    layer.setStyle({
                            fillColor: 'blue',
                            color: 'blue',
                            weight: 3,
                            stroke: 5,
                            fillOpacity: 2,
                            opacity: 1
                        });

                    if(feature.properties.ID==undefined)
                      if(feature.properties.DB_ID!=undefined)
                        feature.properties.ID=feature.properties.DB_ID;


                    if (res['map_nextlevel_info'].hasOwnProperty(feature.properties.ID)) {
                        nextinfo = res['map_nextlevel_info'][feature.properties.ID];                        
                        feature.id = feature.properties.ID;   
                       if (!/Android|iPhone/i.test(navigator.userAgent)) {
                                layer.bindTooltip(nextinfo.info, {
                                    sticky: true,
                                    pane: 'tool',
                                    direction: 'top'
                                });
                        }
                        
                       
                        layer.bindPopup(nextinfo.info, {
                            sticky: true,
                            pane: 'tool',
                            direction: 'top'
                        });

                        layer.setStyle({
                            fillColor: nextinfo.color,
                            color: nextinfo.color,
                            weight: 3,
                            stroke: 5,
                            fillOpacity: 2,
                            opacity: 1
                        });

                    } 
                }
            });
              geo_layer.push(geojson); 



              

       
                 

            
           //  if(highway_pop.length > 0)
           // {
           //   var retailers = L.featureGroup(highway_pop);
           //   var bounds = retailers.getBounds();
           //   var latLng = bounds.getCenter();
           //    map.fitBounds(bounds);
           //    window.fitcenter = latLng; 
           // }
           // else
           // {
           //   map.fitBounds(bounds);
           // }

          }
          else if(subrd)
          {

             style={
                            fillColor: '#fff',
                            color: '#837979',
                            weight: 0,
                            stroke: 0,
                            fillOpacity: 0,
                            opacity: 0
                        };

              var geojson = L.geoJson(JSON.parse(message), {
                style: style,
                onEachFeature: function(feature, layer) {

                    if (res['map_nextlevel_info'].hasOwnProperty(feature.properties.Beat_unique_id)) {


                      
                      if (bound_check.indexOf(feature.properties.Beat_unique_id) == -1) {

                        bound_check.push(feature.properties.Beat_unique_id);
                        bound_type[feature.properties.Beat_unique_id] = 1; // to check multiple polygon
                        layer_bound[feature.properties.Beat_unique_id] = layer;
                    } else {

                        lastlayer = layer_bound[feature.properties.Beat_unique_id];
                        layer_bound[feature.properties.Beat_unique_id] = [];
                        bound_type[feature.properties.Beat_unique_id] = 2;

                        if (!($.isArray(lastlayer))) {
                            layer_id = feature.properties.Beat_unique_id;
                            layer_bound[feature.properties.Beat_unique_id].push({
                                layer_id: lastlayer
                            });
                            layer_bound[feature.properties.Beat_unique_id].push({
                                layer_id: layer
                            });

                        }
                        if (($.isArray(lastlayer))) {
                            layer_id = feature.properties.Beat_unique_id;
                            for (i_l = 0; i_l < lastlayer.length; i_l++) {
                                layer_bound[feature.properties.Beat_unique_id].push(lastlayer[i_l]);
                            }


                            layer_bound[feature.properties.Beat_unique_id].push({
                                layer_id: layer
                            });

                        }

                    }





                    layer.on({
                        click: featureclick_1,
                        dblclick: show_subrdbeat_filter
                        //  mouseover: highlightFeature,
                        //mouseout: resetHighlight,touchstart:touch
                    });
                    
                        nextinfo = res['map_nextlevel_info'][feature.properties.Beat_unique_id];                        
                        feature.id = feature.properties.Beat_unique_id;   
                        feature.properties.beat_id=nextinfo['beat_id'];  
                          if (!/Android|iPhone/i.test(navigator.userAgent)) {               
                        layer.bindTooltip(nextinfo.info, {
                            sticky: true,
                            pane: 'tool',
                            direction: 'top'
                        });
                    }
                        layer.bindPopup(nextinfo.info, {
                            sticky: true,
                            pane: 'tool',
                            direction: 'top'
                        });


                        layer.setStyle({
                            fillColor: nextinfo.color,
                            color: '#837979',
                            weight: 3,
                            stroke: 5,
                            fillOpacity: 2,
                            opacity: 1
                        });
                       // layer.setText('test');
                         //layer.setText(nextinfo.beat_name, {center: true});
                             geo_layer.push(layer);
                    } 
                     

                }
            });
             
      
              


        

          }
          else
          {
               var geojson = L.geoJson(JSON.parse(message), {
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

        }
      

        if(geo_layer.length>0)
        {
              var featureGroup = L.featureGroup(geo_layer).addTo(map);
              map.fitBounds(featureGroup.getBounds());              
              overlay_arr['geolayer'] = featureGroup;
        }
        if(subrd) {
        	//alert();
          retailer_list=res['result']['subrd_retailer'];

              for(i=0;i<retailer_list.length;i++)
                {

                //  if(retailer_list[i].beat_name!='Beat1' && retailer_list[i].visit_order!=1)
                  //{

                     var circle_marker = L.circleMarker([retailer_list[i].latitude,retailer_list[i].longitude], {
                        "radius": 10,
                        "fillColor":retailer_list[i].color,
                        "color": retailer_list[i].color,
                        "weight": 1,
                        "opacity": 1,
                        "fillOpacity": 1,
                        "stroke": 1,
                       
                    });
                      if (!/Android|iPhone/i.test(navigator.userAgent)) {
                   circle_marker.bindTooltip(retailer_list[i].info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'top'
                              });
                }

                   circle_marker.bindPopup(retailer_list[i].info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'right'
                              });
                  //  circle_marker.bindLabel(12);
                    if(list_of_retailer_highway.hasOwnProperty(retailer_list[i].beat_id))                                         
                         list_of_retailer_highway[retailer_list[i].beat_id].push(circle_marker); 
                    else
                        { 
                          list_of_retailer_highway[retailer_list[i].beat_id]=[];
                       list_of_retailer_highway[retailer_list[i].beat_id].push(circle_marker); 
                     }
                    
                        highway_pop.push(circle_marker);

                   
                   circle_marker.addTo(map);

                   var text = L.tooltip({
                          permanent: true,
                          direction: 'center',
                          className: 'textclass'
                      })
                      .setContent(''+retailer_list[i].visit_order+'')
                      .setLatLng([retailer_list[i].latitude,retailer_list[i].longitude]);
                      highway_pop.push(text);
                      text.addTo(map); 
                 // }

                    


                   
                }
                for(i=0;i<res['result']['subrd_list'].length;i++)   {
              v=res['result']['subrd_list'][i];
               if(v.latitude != '' && v.longitude != '' && v.latitude !==undefined)
               {
                 var greenIcon = L.icon({
                        iconUrl: v.icon,
                        iconSize: [20, 20],
                    });
                    var marker = L.marker([v.latitude, v.longitude], {
                      icon: greenIcon
                  });
                             
                    if (!/Android|iPhone/i.test(navigator.userAgent)) {
                     marker.bindTooltip(v.info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'top'
                              });
                    }
                     marker.bindPopup(v.info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'right'
                              });
                     //marker.setContent(8);
                     if(list_of_retailer_highway.hasOwnProperty(v.beat_id))
                            list_of_retailer_highway[v.beat_id].push(marker); 
                    else
                    {
                      list_of_retailer_highway[v.beat_id]=[];
                       list_of_retailer_highway[v.beat_id].push(marker); 
                    }
                    highway_pop.push(marker);
                    marker.addTo(map);
                    
               }
        } 
}

          if(highway)
        {
           retailer_list=res['result']['highway_retailer'];

              for(i=0;i<retailer_list.length;i++)
                {

                   
                    var circle_marker = L.circleMarker([retailer_list[i].latitude,retailer_list[i].longitude], {
                        "radius": 6,
                        "fillColor":retailer_list[i].color,
                        "color": retailer_list[i].color,
                        "weight": 1,
                        "opacity": 1,
                        "fillOpacity": 0.5,
                        "stroke": 1,
                       
                    });
                     if (!/Android|iPhone/i.test(navigator.userAgent)) {
                   circle_marker.bindTooltip(retailer_list[i].info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'top'
                              });
               }
                   circle_marker.bindPopup(retailer_list[i].info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'right'
                              });
                    if(list_of_retailer_highway.hasOwnProperty(retailer_list[i].highway_id))                                         
                         list_of_retailer_highway[retailer_list[i].highway_id].push(circle_marker); 
                    else
                        { 
                          list_of_retailer_highway[retailer_list[i].highway_id]=[];
                       list_of_retailer_highway[retailer_list[i].highway_id].push(circle_marker); 
                     }
                    
                        highway_pop.push(circle_marker);
                        circle_marker_arr.push(circle_marker);

                        if(retailer_list[i].cluster !=0 && retailer_list[i].cluster !=undefined && retailer_list[i].cluster!='')
                   {
                   	  
                      if(retailer_list[i].cluster in marker_cluster_list){
                   
                     marker_cluster_list[retailer_list[i].cluster].push(circle_marker);

                     
	                  }
	                  else
	                  {
	                     marker_cluster_list[retailer_list[i].cluster]=[];                     
	                     marker_cluster_list[retailer_list[i].cluster].push(circle_marker);
	                     

	                  }
                  }
                 
                 
                  // circle_marker.addTo(map);

                   
                }
                console.log(marker_cluster_list);
                if(marker_cluster_list.length > 0)
                {
                	 markergroup=[];
              var bounds = L.latLngBounds();

           

                $.each(marker_cluster_list,function(k,v){
                 
                  if(k !=0 && k!='' && k!=undefined && v!=undefined)
                  {
                   
                       vars['mark' + k] = new L.MarkerClusterGroup({ 
                        id:k,
                      iconCreateFunction: function (cluster) {
                          var markers = cluster.getAllChildMarkers();
                         /// var html = '<div class="circle">  <div class="inner" >C'+k+' : '+markers.length + '</div></div>';
                        //  var html = '<div class="circle">  <div class="inner"><strong style="font-weight:900 !important;color:black;font-size:10px">C'+k+'</strong> : <b style="color:blue">'+markers.length + '</b</div></div>';
                           var html = '<div class="circle">  <div class="inner"><strong style="font-weight:900 !important;color:black;font-size:10px">C'+k+'</strong> :<br><b style="color:green">'+markers.length+'</b></div></div>';
                          return L.divIcon({ html: html, className: 'mycluster', iconSize: L.point(32, 32) });
                      },
                      spiderfyOnMaxZoom: true, showCoverageOnHover: true, zoomToBoundsOnClick: false,disableClusteringAtZoom:15, maxClusterRadius: 300
                  });

              
                      vars['mark' + k].addLayers(v);
                      bounds.extend(vars['mark' + k].getBounds());
                     
                     
                      markergroup.push(vars['mark' + k]);
                      // vars['mark' + k].freezeAtZoom(15);
                     // vars['mark' + k].addTo(map);
                     // vars['mark' + k].on('clusterclick', function() {getmaker(this.options.id);});

                  }
                  // if(k=="" && v!=undefined)
                  // {
                  //   for(i=0;i<v.length;i++)
                  //   {
                  //     map.addLayer(v[i]);
                      
                  //   }
                  // } 
                  
                });
               // dynamic_control[5].disable();
              //  var featureGroup_ = L.featureGroup(markergroup).addTo(map);
                // map.fitBounds(bounds);
                 //map.scrollWheelZoom.disable();
                }
                if(marker_cluster_list.length>0)
		        {
		        	console.log(marker_cluster_list);
		              var featureGroup_cluster = L.featureGroup(markergroup);//.addTo(map);
		             // map.fitBounds(featureGroup_cluster.getBounds());              
		              overlay_arr['cluster_layer'] = featureGroup_cluster;
		        }
		        if(circle_marker_arr.length>0)
		        {
		              var featureGroup_circle = L.featureGroup(circle_marker_arr).addTo(map);
		              map.fitBounds(featureGroup_circle.getBounds());              
		              overlay_arr['circlemarker_layer'] = featureGroup_circle;
		        }


                 for(i=0;i<res['result']['subrd_list'].length;i++)   {
              v=res['result']['subrd_list'][i];
               if(v.latitude != '' && v.longitude != '' && v.latitude !==undefined)
               {
                 var greenIcon = L.icon({
                        iconUrl: v.icon,
                        iconSize: [20, 20],
                    });
                    var marker = L.marker([v.latitude, v.longitude], {
                      icon: greenIcon
                  });
                           if (!/Android|iPhone/i.test(navigator.userAgent)) {   
                   
                     marker.bindTooltip(v.info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'top'
                              });
                 }
                     marker.bindPopup(v.info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'right'
                              });
                     if(list_of_retailer_highway.hasOwnProperty(v.highway_id))
                            list_of_retailer_highway[v.highway_id].push(marker); 
                    else
                    {
                      list_of_retailer_highway[v.highway_id]=[];
                       list_of_retailer_highway[v.highway_id].push(marker); 
                    }
                    highway_pop.push(marker);
                    marker.addTo(map);
               }
            
        
           }  
 

        }  
        
     if(highway)
     {
         var circlemap_2 = L.easyButton({
        position: 'bottomright',
        states: [{
            stateName: 'Cluster',
            icon: '<i class="fa fa-circle"></i>',
            title: 'Icon/Cluster Layer',
            onClick: function(control) {
               if(map.hasLayer(overlay_arr['circlemarker_layer']))
               {  
                   overlay_arr['circlemarker_layer'].remove(map);
                   overlay_arr['cluster_layer'].addTo(map);
                   
                   $(".Cluster-active").html('');
                   $(".Cluster-active").html('<i class="fa fa-map-pin"></i>');
               }
               else 
               {
                   overlay_arr['cluster_layer'].remove(map);
                   overlay_arr['circlemarker_layer'].addTo(map);
                   
                   $(".Cluster-active").html('');
                   $(".Cluster-active").html('<i class="fa fa-circle"></i>');
               }
                   
              
                               



                        }
                    }]
                });
            map.addControl(circlemap_2);
            dynamic_control['rpi_action'].push(circlemap_2); 
     }

        //  map.setMaxBounds(map.getBounds());

    }
    function highlightFeature(layer) {
        //var layer = e.target;
        layer.setStyle({
            color: "#fff",
            weight: (zoomrange >= 16) ? 5 : 0.5,
            stroke: (zoomrange >= 16) ? 5 : 0.8,
            fillOpacity: overlay_arr[0],
            // weight: 1.7,
            opacity: 1.5,
            // stroke: 3.5,
            dashArray: '0'
        });
    }
    function resetHighlight(layer) {
        //var layer = e.target;
        layer.setStyle({
            color: 'black',
             weight: (zoomrange >= 16) ? 5 : 0.5,
            stroke: (zoomrange >= 16) ? 5 : 0.8,
            fillOpacity: overlay_arr[0]
        });
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
        layer.openTooltip();
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
    function featureclick_1(e) {

        var layer = e.target;
        layer.openTooltip();
        
    }

    function removelayer() {
        //Geojson file layer
      map.scrollWheelZoom.enable();
        $.each(vars,function(k,v){

           if (outlet_markerarray.length > 0) {
             for (i = 0; i < outlet_markerarray.length; i++) {
                if (vars[k].hasLayer(outlet_markerarray[i])) {
                  
                    vars[k].removeLayer(outlet_markerarray[i]);
                }
                if (map.hasLayer(outlet_markerarray[i])) {
                     map.removeLayer(outlet_markerarray[i]);
                  }
            }

           }
               map.removeLayer(vars[k]);
               delete vars[k];
               
        });
         for (i = 0; i < rpi_layer.length; i++) {
            if (map.hasLayer(rpi_layer[i])) {
                map.removeLayer(rpi_layer[i]);
            }
        }
       for (i = 0; i < bubble_data.length; i++) {

              if (map.hasLayer(bubble_data[i])) {
                  map.removeLayer(bubble_data[i]);
              }
          }
      if (!isEmpty(bubble_layer) || bubble_data.length > 0) {
              if (bubble_data.length > 0) {
                  for (i = 0; i < bubble_data.length; i++) {
                      bubble_layer[0].removeLayer(bubble_data[i]);
                  }
              }
              map.removeLayer(bubble_layer);
          }
           for (i_ = 0; i_ < dynamic_control['rpi_action'].length; i_++) {
                  map.removeControl(dynamic_control['rpi_action'][i_]);
              }
    //           for (i_ = 0; i_ < overlay_arr.length; i_++) {
    //             console.log(overlay_arr[i_]);
    //                    map.removeControl(overlay_arr[i_]);
    // }
             
          // for (i_ = 0; i_ < overlay_arr.length; i_++) {
                 // map.removeControl(v);
          //     }

        if (outlet_markerarray.length > 0) {
            for (i = 0; i < outlet_markerarray.length; i++) {
                if (markercluster.hasLayer(outlet_markerarray[i])) {
                    markercluster.removeLayer(outlet_markerarray[i]);
                }
                if (map.hasLayer(outlet_markerarray[i])) {
                     map.removeLayer(outlet_markerarray[i]);
                  }
            }
        }
        if (uncovered_outlet_markerarray.length > 0) {
            for (i = 0; i < uncovered_outlet_markerarray.length; i++) {
                if (uncovered_markercluster.hasLayer(uncovered_outlet_markerarray[i])) {
                    uncovered_markercluster.removeLayer(uncovered_outlet_markerarray[i]);
                }
            }
            uncovered_outlet_markerarray = [];
           
        }

        for (i = 0; i < geo_layer.length; i++) {
            if (map.hasLayer(geo_layer[i])) {
                map.removeLayer(geo_layer[i]);
            }
        }
        if(list_of_retailer_highway.length >0){
      
    $.each(list_of_retailer_highway,function(k,v){
      
       if(v!==undefined){

              for (i = 0; i < v.length; i++) {


              if (map.hasLayer(v[i])) {
                  map.removeLayer(v[i]);
              }
          }

       }
        

    });
    } 
     for (i = 0; i < highway_pop.length; i++) {
        if (map.hasLayer(highway_pop[i])) {
            map.removeLayer(highway_pop[i]);
        }
    }
    for (i = 0; i < circle_marker_arr.length; i++) {
        if (map.hasLayer(circle_marker_arr[i])) {
            map.removeLayer(circle_marker_arr[i]);
        }
    }
    

        geo_layer = [];
        marker_cluster_list=[];
        outlet_markerarray = [];
        find_val=[];
        bubble_data = [];   
        bubble_layer = [];
        bubble_data_highlight = [];    
        active=[];
        initiated=[];
        activated=[];
        deactivated=[];
        recomand_subrd=[];
        exist_subrd=[];
        whole_subrd=[];
        list_of_retailer_highway=[];
        highway_pop=[];
        circle_marker_arr=[];
        return true;
    }

    function clickOnMapItem(itemId) {
        var id = parseInt(itemId);
        //get target layer by it's id
        var layer = geo_layer[0].getLayer(id);


        //fire event 'click' on target layer 
        layer.fireEvent('dblclick');
    }



    function initial(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false,subrd=false,filter_subrd=false) // First - input parameter //second - 1-forward 2-load currentlevel data -1 back
    {
       if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }


        if (!filter)
            loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': type,
                'filter_so': filter_so,
                'current_location':[current_location['lat'],current_location['lon']],
            };
        else if(input_obj.type ==9)
        {

             loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': type,
                'filter_so': filter_so,
                'current_location':[current_location['lat'],current_location['lon']],
            };
        }
        else
            loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': input_obj.type,
                'filter_so': filter_so,
                'current_location':[current_location['lat'],current_location['lon']],
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

                if(page_text==true)
                {
                     tablebuild(res,type);
                }
                else
                {
                      if ($('#mymodal-subordinate').hasClass('show')) {
                    $("#mymodal-subordinate").modal('hide');
                    removelayer();

                }
                 if ($('#mymodal-beat').hasClass('show')) {
                    $("#mymodal-beat").modal('hide');
                    removelayer();

                }
                if ($('#mymodal-district').hasClass('show')) {
                    $("#mymodal-district").modal('hide');
                    removelayer();

                }
                if($("#mymodal-taluk").hasClass('show'))
                {
                     $("#mymodal-taluk").modal('hide');
                    removelayer();
                }
                if($("#mymodal-highway").hasClass('show'))
                {
                     $("#mymodal-highway").modal('hide');
                    removelayer();
                }
                if($("#mymodal-subrdbeat").hasClass('show'))
                {
                     $("#mymodal-subrdbeat").modal('hide');
                    removelayer();
                }
                if(type==12 || type==13 || type==14 || type==11){

                  removelayer();
                  
                 
                }
                
                


                if (isEmpty(geo_layer) && (type !=5 && type!=6 && type!=7 && type!=8 && type!=9 && type!=10 && type!=11)) {      
               
                    removelayer();
                   
                    if(type==12)
                    {
                       loadmap(res, '');
                       if(rpi_action!='')
                          $(".state-" + rpi_action).click();
                    }
                    else if(type==13){

                      loadmap(res, '',true);
                      legend(13);
                    }
                    else if(type==14){
                      legendremove();
                            legend(res['legend']);
                           loadmap(res, '',false,true);
                    }


                    //changeproperty(res, type);
                }
               
               


                if (!isEmpty(res['maplist'])) {

                    Globalobject[0] = res["tbl"];

                    $("#maphead h3").html(res['head']);
                    if (filter) {
                        removelayer();
                        if (res.hasOwnProperty('griddata')) {
                          if(type==13)
                            loadmap(res, '',true);
                           else if(type==14){
                                    loadmap(res, '',false,true);

                           }
                      
                          else
                            loadmap(res, '');
                          if(type!=13 && type!=14){
                          	changeproperty(res, type);
                          	legendremove();
                            legend(res['maplegend']);
                          }
                            
                            tablebuild(res, type);
                            
                        }
                        $('#mymodal-filter').modal('hide');
                    } else {
                       

                        if (res.hasOwnProperty('griddata')) {
                           if(type!=13 && type!=14){
                           	 changeproperty(res, type);
                           	 legendremove();
                            legend(res['maplegend']);
                           }
                           
                            tablebuild(res, type);
                            
                            $("#maphead h3").html(res['head']);
                        }
                    }
                }
                else {
                       

                        if (res.hasOwnProperty('griddata')) {


                            changeproperty(res, type);
                            tablebuild(res, type);
                            legendremove();
                             if(filter){
                                $(".close").click();
                                $('#filter_bychannel').modal('hide');
                             }
                             if(type==9)
                             {
                                dynamic_control[0].enable();
                                dynamic_control[1].enable();
                                
                             }
                             // else
                             // {
                             //     dynamic_control[0].disable();
                             //    dynamic_control[1].disable();
                             // }
                             if(type==11)
                             {
                               legendremove();
                               console.log(input_obj.filter_bycluster);
                               if(input_obj.filter_bycluster !== undefined)
                                if(input_obj.filter_bycluster.length > 0)
                                  legend(type);

                             }
                             if(type==14)
                             {
                               legend(res['legend']);

                             }
                             else
                             legend(type);
                             $("#maphead h3").html(res['head']);
                           // legend(res['maplegend']);
                        }
                       
                    }
                }
                if(filter_subrd)
                {
                      dynamic_control['rpi_action']=[];
           
        var backbtn = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-arrow-left',
                title: 'Back',
                onClick: function(control) {
                   
                    filter_subrdbeat = [];

                    $.each($("input[name='subrd_beat']:checked"), function() {
                        filter_subrdbeat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 14,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_subrdbeat':[],
                        'filter_subrd':filter_subrdbeat
                    };


                    initial(input_obj, 0,14, false,false,'',false,true);

                }
            }]
        });
        map.addControl(backbtn);
         dynamic_control['rpi_action'].push(backbtn); 
                }
               
               //  map.invalidateSize();

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
       if (("{{Auth::user()->user_type}}") == 'TSM' && ("{{Auth::user()->client_id}}") != 100) {
         //$("#mymodal-district").modal('show');
         $("#filter_bybeat").click(function() {
                    filter_beat = [];

                    $.each($("input[name='beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 11,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':filter_beat
                    };


                    initial(input_obj, 0,11, '');


                });
          $("#filter_bysubrdbeat").click(function() {
          //  dynamic_control[5].disable();
                    filter_subrdbeat = [];

                    $.each($("input[name='subrd_beat']:checked"), function() {
                        filter_subrdbeat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 14,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_subrdbeat':[],
                        'filter_subrd':filter_subrdbeat
                    };


                    initial(input_obj, 0,14, false,false,'',false,true);


                });

        $("#filter_byhighway").click(function(){
                    filter_highway=[];
                    $.each($("input[name='highwaylist']:checked"), function() {
                          filter_highway.push($(this).val());
              });
                    input_obj = {
                        'type': 13,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_highway':filter_highway,
                        
                        };
                        //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
                        initial(input_obj, 0,13, false,false,'',true);
        });
      $("#filter_bydist,#filter_bytaluk").click(function(){
      //  dynamic_control[5].disable();
        filter_dist=[];filter_taluk=[];check_district=[];check_district[0]=0;
        id=$(this).attr('id');


        input_obj = {
                        'type': 12,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_district':filter_dist,
                        'type_view':type_view[0]
                        
                        };
        if(id=='filter_bydist')
           {
              $.each($("input[name='districtlist']:checked"), function() {
                          filter_dist.push($(this).val());
              });
               input_obj['filter_district']=filter_dist;
      
           }
          if(id=='filter_bytaluk')
          {
               
             $.each($("input[name='taluklist']:checked"), function() {
               filter_taluk.push($(this).val());
                       
                       
            });
            input_obj['filter_taluk']=filter_taluk;
            
          }     

          initial(input_obj, 0,12, '');

      });
    }
       if (("{{Auth::user()->user_type}}") == 'SUPPORT' && ("{{Auth::user()->client_id}}") != 100 && ("{{Auth::user()->client_id}}") != 130) {
          $("#mymodal-beat").modal('show');
            $("#filter_bybeat").click(function() {
                    filter_beat = [];

                    $.each($("input[name='beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 11,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':filter_beat
                    };


                    initial(input_obj, 0,11, '');


                });

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
        } 
        else if(("{{Auth::user()->client_id}}") == 100 || ("{{Auth::user()->client_id}}") == 130)
          {

            $("#mymodal-beat").modal('show');
            $("#filter_bybeat").click(function() {
                    filter_beat = [];

                    $.each($("input[name='beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 9,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':filter_beat
                    };


                    initial(input_obj, 0,9, '');


                });

          }
          else {
                initial(input_obj, 0, '');
            }
         


        $(".show_case_result").click(function() {

            $(".navbar-toggler").trigger("click");
            type = $(this).attr("id");
            type_of_view[0]=type;
            legendremove();
            input_obj = {
                'type': type,
                'filter_pc': showlist_user_id,
                'filter_distributor': showlist_distributor_id,
                'filter_so': filter_so
            };
            if(type==9)
            {
            	 $('input[name="tag_list"]').each(function() {
			             $('input[name="tag_list"]').prop('checked', true);
      			      });
      			     $('input[name="potentiallist"]').each(function() {
      			             $('input[name="potentiallist"]').prop('checked', true);
      			     });
      			     $('input[name="statuslist"]').each(function() {
      			           $('input[name="statuslist"]').prop('checked', true);
      			    });
      			     $('input[name="outlets"]').each(function() {
      			           $('input[name="outlets"]').prop('checked', true);
      			    });

                      input_obj.filter_beat=filter_beat;
                      initial(input_obj, 2, type);
            }
            if(type==11){

              $('#mymodal-beat').modal('show');
                input_obj.filter_beat=filter_beat;
                // initial(input_obj, 2, type);
            }
            if(type==12)
            {
               $('#mymodal-district').modal('show');
               type_view[0]=$(this).attr('type');
              // dynamic_control[10].enable();
             //  dynamic_control[11].disable();


            }
             if(type==13)
            {
             // dynamic_control[11].enable();
              
               $('#mymodal-highway').modal('show');
             //  dynamic_control[10].disable();

            }
            if(type==14)
            {

               $('#mymodal-subrdbeat').modal('show');
               
            }

            


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


        if (type != 4 && type !=5 && type !=6 && type!=7 && type!=8 && type!=9 && type!=10 && type!=11 && type!=12 && type!=13) {
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

        if(type==12)
        {
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
           var bubble = L.layerGroup(bubble_data);
      overlays = {
          "circle": bubble
      };
      bubble_layer.push(bubble);    
      overlay_arr['circlelayer'] = bubble;
    layer_enable={"active":0,"initiated":0,"activated":0,"deactivated":0,"recomand_subrd":0,"exist_subrd":0,"whole_subrd":0};
    dynamic_control['rpi_action']=[];
     var circlemap = L.easyButton({
                    position: 'bottomright',
                    states: [{
                        stateName: 'Circle',
                        icon: '<i class="fa fa-life-ring"></i>',
                        title: 'Geo Layer/Circle Layer',
                        onClick: function(control) {
                           if(map.hasLayer(overlay_arr['geolayer'])){
                            
                               overlay_arr['geolayer'].remove(map);
                               overlay_arr['circlelayer'].addTo(map);
                               $(".Circle-active").html('');
                               $(".Circle-active").html('<i class="fa fa-map"></i>');
                           
                               
                           }
                           else
                           {
                               overlay_arr['circlelayer'].remove(map);
                               overlay_arr['geolayer'].addTo(map);
                               $(".Circle-active").html('');
                               $(".Circle-active").html('<i class="fa fa-life-ring"></i>');
                           }
                           
                               



                        }
                    }]
                });
            map.addControl(circlemap);
            dynamic_control['rpi_action'].push(circlemap); 
 
    if(active.length>0){

      var active_layer = L.layerGroup(active);
      overlays["Active"]=active_layer;
      overlay_arr['Active'] =active_layer;
      rpi_layer.push(active_layer);      

      var active_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Active',
              icon: '<img src="rural_icon/active.png" width="20px" height="20px"/>',
              title: 'Active',
              onClick: function(control) {

                 if(layer_enable["active"] == 0){
                    overlay_arr['Active'].addTo(map);
                    layer_enable["active"]=1;
                 }
                 else
                 {
                    overlay_arr['Active'].remove(map);
                    layer_enable["active"]=0;
                 }
                  
              }
          }]
      });
      map.addControl(active_button);

    dynamic_control['rpi_action'].push(active_button); 

    }
    if(initiated.length>0){
        var initiated_layer = L.layerGroup(initiated);
        rpi_layer.push(initiated_layer);
        overlays["initiated"]=initiated_layer;
        overlay_arr['initiated'] =initiated_layer;
     
        var initiated_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Initiated',
              icon: '<img src="rural_icon/initiated.png" width="20px" height="20px"/>',
              title: 'Initiated',
              onClick: function(control) {


                 if(layer_enable["initiated"] == 0){
                    overlay_arr['initiated'].addTo(map);
                    layer_enable["initiated"]=1;
                 }
                 else
                 {
                    overlay_arr['initiated'].remove(map);
                    layer_enable["initiated"]=0;
                 }

              }
          }]
      });
      map.addControl(initiated_button);
      dynamic_control['rpi_action'].push(initiated_button); 

    }

    if(activated.length>0){
        var activated_layer = L.layerGroup(activated);
        rpi_layer.push(activated_layer);
        overlays["activated"]=activated_layer;
        overlay_arr['activated'] =activated_layer;

     
         var activated_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Activated',
              icon: '<img src="rural_icon/activated.png" width="20px" height="20px"/>',
              title: 'Activated',
              onClick: function(control) {


                 if(layer_enable["activated"] == 0){
                    overlay_arr['activated'].addTo(map);
                    layer_enable["activated"]=1;
                 }
                 else
                 {
                    overlay_arr['activated'].remove(map);
                    layer_enable["activated"]=0;
                 }

              }
          }]
      });
      map.addControl(activated_button);
      dynamic_control['rpi_action'].push(activated_button);
    }
    if(deactivated.length>0){
        var deactivated_layer = L.layerGroup(deactivated);
        rpi_layer.push(deactivated_layer);
        overlays["deactivated"]=deactivated_layer;
        overlay_arr['deactivated'] =deactivated_layer;
     
        var deactivated_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Deactivated',
              icon: '<img src="rural_icon/deactivated.png" width="20px" height="20px"/>',
              title: 'Deactivated',
              onClick: function(control) {


                 if(layer_enable["deactivated"] == 0){
                    overlay_arr['deactivated'].addTo(map);
                    layer_enable["deactivated"]=1;
                 }
                 else
                 {
                    overlay_arr['deactivated'].remove(map);
                    layer_enable["deactivated"]=0;
                 }

              }
          }]
      });
      map.addControl(deactivated_button);
      dynamic_control['rpi_action'].push(deactivated_button);
    }
     if(recomand_subrd.length>0){
        var recomand_subrd_layer = L.layerGroup(recomand_subrd);
        rpi_layer.push(recomand_subrd_layer);
        overlays["recomand_subrd"]=recomand_subrd_layer;
        overlay_arr['recomand_subrd'] =recomand_subrd_layer;
     
        var recomand_subrd_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Recomndd SubRD',
              icon: '<img src="rural_icon/recommendation.png" width="20px" height="20px"/>',
              title: 'Recomndd SubRD',
              onClick: function(control) {


                 if(layer_enable["recomand_subrd"] == 0){
                    overlay_arr['recomand_subrd'].addTo(map);
                    layer_enable["recomand_subrd"]=1;
                 }
                 else
                 {
                    overlay_arr['recomand_subrd'].remove(map);
                    layer_enable["recomand_subrd"]=0;
                 }

              }
          }]
      });
      map.addControl(recomand_subrd_button);
      dynamic_control['rpi_action'].push(recomand_subrd_button);
    }
   if(exist_subrd.length>0){
        var exist_subrd_layer = L.layerGroup(exist_subrd);
        rpi_layer.push(exist_subrd_layer);
        overlays["exist_subrd"]=exist_subrd_layer;
        overlay_arr['exist_subrd'] =exist_subrd_layer;
     
        var exist_subrd_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Exist SubRD',
              icon: '<img src="rural_icon/efficient-subrd.png" width="20px" height="20px"/>',
              title: 'Exist SubRD',
              onClick: function(control) {


                 if(layer_enable["exist_subrd"] == 0){
                    overlay_arr['exist_subrd'].addTo(map);
                    layer_enable["exist_subrd"]=1;
                 }
                 else
                 {
                    overlay_arr['exist_subrd'].remove(map);
                    layer_enable["exist_subrd"]=0;
                 }

              }
          }]
      });
      map.addControl(exist_subrd_button);
      dynamic_control['rpi_action'].push(exist_subrd_button);
    }
   
    if(whole_subrd.length>0){
        var whole_subrd_layer = L.layerGroup(whole_subrd);
        rpi_layer.push(whole_subrd_layer);
        overlays["whole_subrd"]=whole_subrd_layer;
        overlay_arr['whole_subrd'] =whole_subrd_layer;
     
        var whole_subrd_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Exist SubRD',
              icon: '<img src="rural_icon/Wholesale.png" width="20px" height="20px"/>',
              title: 'Recomndd Whlsl',
              onClick: function(control) {


                 if(layer_enable["whole_subrd"] == 0){
                    overlay_arr['whole_subrd'].addTo(map);
                    layer_enable["whole_subrd"]=1;
                 }
                 else
                 {
                    overlay_arr['whole_subrd'].remove(map);
                    layer_enable["whole_subrd"]=0;
                 }

              }
          }]
      });
      map.addControl(whole_subrd_button);
      dynamic_control['rpi_action'].push(whole_subrd_button);
    }
        }


        if (type == 4 || type ==5 || type ==6 || type==7 || type==8 || type==9 || type==10 || type==11) {

            removelayer();
            k = 1; style_code='';
           
            $.each(res['map_nextlevel_info'], function(key, value) {

                if ((value.lat != '' && value.lon != '') && (value.lat !== undefined && value.lon !== undefined) && (value.lat !== 'undefined' && value.lon !== 'undefined')) {

                     info = '';
                    if(type==9)
                     {
                     

                         if(typeof(value.type) != "undefined" && value.type !== null)
                         {
                              if(value.type=='covered')
                                 info = '<div class="media outlet-list"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3> </li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li></ul></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';
                                if(value.type=='uncovered')
                                {
                                    uncovered_outlet_detail[value.refid]=value;
                                    found='';not_found='';visited='';
                                    
                                    if(value.status=='A')
                                        found='checked';
                                    if(value.status=='R')
                                        not_found='checked';
                                     if(value.status=='V')
                                        visited='checked';

                                     if((value.status=='A' || value.status=='R' || value.status=='NF' || value.status=='E'))
                                       info=current_content(value,value.status,res['feedback_question']);
                                    else{
                                      client_name="{{Auth::user()->Organization}}";
                                      count_radio=0;
                                      style_code='';
                                      if(value.potential_status=='High')
                                        style_code='background-color:#51c82c';
                                       if(value.potential_status=='Medium')
                                        style_code='background-color:#ed8102';
                                       if(value.potential_status=='Low')
                                        style_code='background-color:#bf1414';
                                    
                                        info ='';
                                        circle_count='';
                                        if(parseInt(value.image_count) > 0)
                                           circle_count='<span class="circle_count">'+value.image_count+'</span>';
                                        info = '<div class="media outlet-list zero'+value.refid+'"  ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3><span class="store-high" style="'+style_code+'">'+value.potential_status+'</span></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li> <li class="list-group-item"><div class="form-check capturedetails"><div id="currentstatus'+value.refid+'" ><button class="btn btn-success Capture-btn-details" type="button" title="beat-list" id="capture" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')">Capture Details<span class="button-state state-beat-list beat-list-active"></button></div></div><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'</div><div class="form-check"><button type="button" class="btn btn-default Capture-btn-relevant" onClick="notfound('+value.refid+',\''+value.lat+'\',\''+value.lon+'\');">Store not found</button><a href="#"> <span class="upload-edit-button-icon"> <i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div><div class="form-check">';
                                        if(("{{Auth::user()->client_id}}")==100)
                                        {
                                          info +='<button type="button" class="btn btn-default Capture-btn-relevant" onClick="existing('+value.refid+',\''+value.lat+'\',\''+value.lon+'\');">Existing '+client_name+' Store</button>';
                                        }
                                        
                                         info +='<a href="#"> <span class="upload-edit-button-icon"> <i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li></ul></div>  <div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';
                                      if(("{{Auth::user()->client_id}}")==100)
                                      {
                                      
                                         info +='<div class="Relevant-Store-wrapper first_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" height="250px" alt=""><ul class="list-group"><li class="list-group-item"><a href="#"><button type="button" class="btn btn-success Capture-btn" onClick="next(\'second_div'+value.refid+'\',2,'+value.refid+')">Relevant Store</button></a></li> <li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant" onClick="notrelevant('+value.refid+',\''+value.shop_image+'\',\''+value.outlet_name+'\',\''+value.channel_name+'\',\''+value.sub_channel_name+'\',\''+value.address+'\',\''+value.lat+'\',\''+value.lon+'\')">Not Relevant Store</button></a></li></ul></div>';

                                        info +='<div class="Brand-Availability-wrapper initial_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" height="250px" alt=""><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">Choose Channel type</span></li> <li class="list-group-item form-wrapper"></li>';
                                       

                                        for(c=0;c<jjchannel.length;c++)
                                        {

                                            info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input channelinfo" type="radio" name="channelinfo" value="'+jjchannel[c].refid+'" id="flexRadioDefault'+count_radio+'">  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+jjchannel[c].name+'</label></div></li>';
                                         count_radio++;
                                        }


                                        info +='<li ><p class="alignleft" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'second_div'+value.refid+'\',2,'+value.refid+')">Next</p></li></ul></div>';
               
                                          info+='<div class="Brand-Availability-wrapper second_div'+value.refid+'"  style="display:none;" ><ul><li></li></ul><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][1]['title']+'</span></li>';
                                         $.each(res['feedback_question'][1]['question'], function(k1, v1) {

                                            info +='<li class="list-group-item form-wrapper"><div class="form-check">  <input class="form-check-input stockinfo" type="checkbox" name="'+v1['refid']+'" value=1 id="flexRadioDefault'+count_radio+'"">  <label class="form-check-label checkbox-wrapper" for="flexRadioDefault'+count_radio+'"> '+v1['question']+' </label></div></li>';
                                            count_radio++;
                                          });
                                         feed=res['feedback_question'][1]['question'];
                                          info +='<li ><p class="alignleft" onClick="next(\'initial_div'+value.refid+'\',0,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'third_div'+value.refid+'\',3,'+value.refid+')">Next</p></li>            </ul></div>'
                                          info +='<div class="top-wrapper third_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px">';
                                          info +='<div class="producked-stocked second_info_sub'+feed[0]['refid']+value.refid+'" style="display:none;"><ul class="list-group">';
                                           info +='<li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][2]['title']+'</span></li></ul><div class="bg-Product-wrappers "><ul class="list-group">';

                                         $.each(res['feedback_question'][2]['question'], function(k2, v2) {  
                                         

                                          info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input sec'+feed[0]['refid']+' productlists_1" type="checkbox"  name="'+v2['refid']+'" value=1 id="flexRadioDefault'+count_radio+'"><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v2['question']+'</label></div></li>';
                                          count_radio++;
                                        });
                                          info +='</ul></div></div>';
                                          info +='<div class="competition-title second_info_sub'+feed[1]['refid']+value.refid+'" style="display:none;"><div class="Competition-title"><ul class="list-group"><li class="list-group-item"><span class="Brand-Availability">'+res['feedback_question'][3]['title']+'</span></li></ul></div><div class="bg-Product-wrappers"><ul class="list-group">';
                                       $.each(res['feedback_question'][3]['question'], function(k3, v3) {  
                                          info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input sec'+feed[1]['refid']+' productlists_2" type="checkbox"  name="'+v3['refid']+'"  value=1 id="flexRadioDefault'+count_radio+'"><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v3['question']+'</label></div></li>';
                                          count_radio++;
                                        });
                                          info +='</ul></div></div><div id="textbox"><ul><li><p class="alignleft" onClick="next(\'second_div'+value.refid+'\',2,'+value.refid+')">Back</p></li><li><p class="alignright" onClick="next(\'third_between_div'+value.refid+'\',6,'+value.refid+')" >Next</p></li></ul></div><div style="clear: both;"></div></div>';

                                            info +='<div class="Brand-Availability-wrapper third_between_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group "> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][4]['title']+'</span></li>';

                        


                                          // Rega Need to code start
                                         $.each(res['feedback_question'][4]['question'], function(k4, v4) {

                                           // detailed_array[v4['refid']]="NA"; 
                                            //+value.refid+        
                                            info +='<div class="inline-fwrappers jj_'+v4['parent']+'" style="display:none;"><div class="product-stocked"><ul class="list-group"><li class="list-group-item">'+v4['question']+'</li></ul></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_1']+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_1']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"> <input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_1" value="'+v4['option_1']+'" > <label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_1" > 1-5 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_1']+'" onClick="changestyle_radio('+v4['refid']+',\''+v4['option_2']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_2"  value="'+v4['option_2']+'"  ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_2" > 5-10 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_1']+'" onClick="changestyle_radio('+v4['refid']+',\''+v4['option_3']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_3" value="'+v4['option_3']+'"   ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_3" > 10-15 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_1']+'" onClick="changestyle_radio('+v4['refid']+',\''+v4['option_4']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'"  id="jj_'+v4['refid']+'_4" value="'+v4['option_4']+'"  ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_4" > Above 15</label></div></div>';
                                          });

                                         
                                            info +='<li class="next-alignment"><p class="alignleft" onClick="next(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'fourth_div'+value.refid+'\',4,'+value.refid+')">Next</p></li></ul></div>';
                                         

                                             info +='<div class="potential-store fourth_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][5]['title']+'</span></li></ul><div class="bg-Product-wrappers"><ul class="list-group">';
                                        $.each(res['feedback_question'][5]['question'], function(k5, v5) {
                                             info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input potential" type="checkbox" name="'+v5['refid']+'" value=1 id="flexRadioDefault'+count_radio+'"><label class="form-check-label checkbox-wrapper jj-products-stocked" for="flexRadioDefault'+count_radio+'"> <span class="jj-product-align-check-box">'+v5['question']+' </span></label></div></li>';
                                             count_radio++;
                                            });
                                            
                                             info +='</ul></div> <div id="textbox"><ul> <li><p class="alignleft" onClick="next(\'third_between_div'+value.refid+'\',6,'+value.refid+')">Back</p> </li><li><p class="alignright" onclick="next(\'final\',5,'+value.refid+')">Save</p></li></ul></div> <div style="clear: both;"></div></div></div></div>';
                                      }
                                      else
                                      {
                                         info +='<div class="Brand-Availability-wrapper first_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group "> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][6]['title']+'</span></li>';

                                          // Rega Need to code start
                                         $.each(res['feedback_question'][6]['question'], function(k6, v6) {

                                            if(v6['type']=='text')
                                            {
                                                info +='<div class="inline-fwrappers showfeedback" style="display:none;"><div class="product-stocked" ><ul class="list-group"><li class="list-group-item">'+v6['question']+'</li></ul></div><textarea id="jj_'+v6['parent']+'_'+value.refid+'" name="'+v6['refid']+'" rows="3" cols="30" maxlength="25"></textarea><span id="jj_'+v6['refid']+'_length"> </span></div>';
                                           

                                            }
                                            else
                                            {

                                              info +='<div class="inline-fwrappers"><div class="product-stocked"><ul class="list-group"><li class="list-group-item">'+v6['question']+'</li></ul></div><div class="form-check btn-age-select-wrapper" onClick="changestyle_radio('+v6['refid']+',\'yes\',this,\'jj_'+v6['parent']+value.refid+'\')"> <input class="form-check-input btn-check brand_info" type="radio" name="'+v6['refid']+'" id="jj_'+v6['refid']+'_1" value="yes" hidden> <label class="form-check-label btn-age-wrapper brandstock" for="jj_'+v6['refid']+'_1" >Yes</label></div><div class="form-check btn-age-select-wrapper" onClick="changestyle_radio('+v6['refid']+',\'no\',this,\'jj_'+v6['parent']+value.refid+'\')""><input class="form-check-input btn-check brand_info" type="radio" name="'+v6['refid']+'" id="jj_'+v6['refid']+'_2"  value="no"  hidden><label class="form-check-label btn-age-wrapper brandstock " for="jj_'+v6['refid']+'_2" > No </label></div></div>';
                                            }



                                          });
                                         
                                         
                                            info +='<li class="next-alignment"><p class="alignleft" onClick="mcchain(\'zero'+value.refid+'\',0,'+value.refid+')">Back</p><p class="alignright" id="shownwxtmoments" onClick="mcchain(\'second_div'+value.refid+'\',2,'+value.refid+')">Next</p></li></ul></div>';

                                       info +='<div class="Brand-Availability-wrapper second_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][7]['title']+'</span></li> <li class="list-group-item form-wrapper"></li>';
                                       

                                         $.each(res['feedback_question'][7]['question'], function(k7, v7) {


                                            info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input channelinfo" type="radio" name="channelinfo" value="'+v7['refid']+'" id="flexRadioDefault'+count_radio+'">  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+v7['question']+'</label></div></li>';
                                            count_radio++;
                                        });


                                        info +='<li ><p class="alignleft" onClick="mcchain(\'first_div'+value.refid+'\',1,'+value.refid+')">Back</p><p class="alignright" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Next</p></li></ul></div>';
                                   info +='<div class="top-wrapper third_div'+value.refid+'" style="display:none;"><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul>';
                                          info +='<div class="producked-stocked"><ul class="list-group">';
                                           info +='<li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][8]['title']+'</span></li></ul><div class="bg-Product-wrappers "><ul class="list-group">';

                                         $.each(res['feedback_question'][8]['question'], function(k8, v8) {  
                                         

                                          info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input productlists_1" type="checkbox"  name="'+v8['refid']+'" value=1 id="flexRadioDefault'+count_radio+'"><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v8['question']+'</label></div></li>';
                                          count_radio++;
                                        });
                                          info +='</ul></div></div>';
                                           info +='<div class="Competition-title">';
                                      // info +='<div class="Competition-title"><ul class="list-group">';
                                       //    info +='<li class="list-group-item"><span class="Brand-Availability">'+res['feedback_question'][9]['title']+'</span></li></ul></div><div class="bg-Product-wrappers"><ul class="list-group">';
                                       // $.each(res['feedback_question'][9]['question'], function(k9, v9) {  
                                       //    info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input productlists_2" type="checkbox"  name="'+v9['refid']+'"  value=1 id="flexRadioDefault'+count_radio+'"><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v9['question']+'</label></div></li>';
                                       //    count_radio++;
                                       //  });
                                       //  info +='</ul></div></div>';
                                       info +='</div>';
                                          info +='<div id="textbox"><ul><li><p class="alignleft" onClick="mcchain(\'second_div'+value.refid+'\',2,'+value.refid+')">Back</p></li><li><p class="alignright" onClick="mcchain(\'fourth_div'+value.refid+'\',4,'+value.refid+')" >Next</p></li></ul></div><div style="clear: both;"></div></div>';

                                        //    info +='<div class="potential-store fourth_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][10]['title']+'</span></li></ul><div class="bg-Product-wrappers"><ul class="list-group">';
                                        // $.each(res['feedback_question'][10]['question'], function(k10, v10) {
                                        //      info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input potential" type="radio" name="'+v10['refid']+'" value=1 id="flexRadioDefault'+count_radio+'"><label class="form-check-label checkbox-wrapper jj-products-stocked" for="flexRadioDefault'+count_radio+'"> <span class="jj-product-align-check-box">'+v10['question']+' </span></label></div></li>';
                                        //      count_radio++;
                                        //     });
                                            
                                        //      info +='</ul></div> <div id="textbox"><ul> <li><p class="alignleft" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p> </li><li><p class="alignright" onclick="mcchain(\'final\',5,'+value.refid+')">Save</p></li></ul></div> <div style="clear: both;"></div></div></div></div>';
                                        info +='<div class="Brand-Availability-wrapper fourth_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+res['feedback_question'][10]['title']+'</span></li> <li class="list-group-item form-wrapper"></li>';
                                       

                                         $.each(res['feedback_question'][10]['question'], function(k10, v10) {


                                            info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input potential" type="radio" name="freezer" value="'+v10['refid']+'" id="flexRadioDefault'+count_radio+'">  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+v10['question']+'</label></div></li>';
                                            count_radio++;
                                        });


                                        info +='<li ><p class="alignleft" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p><p class="alignright" onClick="mcchain(\'final\',5,'+value.refid+')">Save</p></li></ul></div><div style="clear: both;"></div></div></div></div>';



                                      }
                                      
                                    }
                                }

                         }

                     }
                     else if(type ==5 || type==6 || type==7 || type==11)   
                     {
                      
                        found='';not_found='';visited='';circle_count='';
                        low_status='';medium_status='';high_status='';
                      if(value.predict_potential==1)
                          low_status='checked';
                      if(value.predict_potential==2)
                          medium_status='checked';
                      if(value.predict_potential==3)
                          high_status='checked';
                        if(value.status=='A')
                            found='checked';
                        if(value.status=='R')
                            not_found='checked';

                        if(value.status=='V')
                            visited='checked';
                        

                        
                      if(type!=11 || ("{{Auth::user()->client_id}}")==86 ||  ("{{Auth::user()->client_id}}")==120)   
                      {
                         if(value.potential_status_name=='High')
                                        style_code='background-color:#51c82c';
                                       if(value.potential_status_name=='Medium')
                                        style_code='background-color:#ed8102';
                                       if(value.potential_status_name=='Low')
                                        style_code='background-color:#bf1414';

                        if(value.image_count > 0)
                                 circle_count='<span class="circle_count">'+value.image_count+'</span>';
                               info = '<div class="media outlet-list"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3 class="title-box">' + value.outlet_name + '</h3><span class="store-high" style="'+style_code+'">'+value.potential_status_name+'</span></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li><li><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'A\','+value.refid+',\''+value.cluster_id+'\')" id="flexRadioDefault1" '+found+'>  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'R\','+value.refid+',\''+value.cluster_id+'\')" id="flexRadioDefault2" '+not_found+'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'V\','+value.refid+',\''+value.cluster_id+'\')" id="flexRadioDefault2" '+visited+'>  <label class="form-check-label" for="flexRadioDefault2" > Visited </label></div></li><li class="list-group-item chnl-typ">Estimated Potential</li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault66" onClick="outlet_potential_status(\'1\','+value.refid+',\''+value.cluster_id+'\')" id="flexRadioDefault66" '+low_status+'>  <label class="form-check-label" for="flexRadioDefault66" >    Low  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault67" onClick="outlet_potential_status(\'2\','+value.refid+',\''+value.cluster_id+'\')" id="flexRadioDefault67" '+medium_status+'>  <label class="form-check-label" for="flexRadioDefault67" > Medium </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault68" onClick="outlet_potential_status(\'3\','+value.refid+',\''+value.cluster_id+'\')" id="flexRadioDefault68" '+high_status+'>  <label class="form-check-label" for="flexRadioDefault68" > High </label></div></li></ul></div><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 75%;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'</div></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';

                      }                                   
                        
                      else if(type==11)
                      {
                              // low_status='';medium_status='';high_status='';
                              // if(value.potential_status==1)
                              //     low_status='checked';
                              // if(value.potential_status==2)
                              //     medium_status='checked';
                              // if(value.potential_status==3)
                              //     high_status='checked';
                              // premium='';not_premium='';

                              //  if(value.perimium==1)
                              //     premium='checked';
                              // if(value.perimium==2)
                              //     not_premium='checked';

                              // info = '<div class="media outlet-list"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3 class="title-box">' + value.outlet_name + '</h3></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'A\','+value.refid+')" id="flexRadioDefault1" '+found+'>  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'R\','+value.refid+')" id="flexRadioDefault2" '+not_found+'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'V\','+value.refid+')" id="flexRadioDefault2" '+visited+'>  <label class="form-check-label" for="flexRadioDefault2" > Visited </label></div></li><li class="list-group-item chnl-typ">Estimated Potential</li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault66" onClick="outlet_potential_status(\'1\','+value.refid+')" id="flexRadioDefault66" '+low_status+'>  <label class="form-check-label" for="flexRadioDefault66" >    Low  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault67" onClick="outlet_potential_status(\'2\','+value.refid+')" id="flexRadioDefault67" '+medium_status+'>  <label class="form-check-label" for="flexRadioDefault67" > Medium </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault68" onClick="outlet_potential_status(\'3\','+value.refid+')" id="flexRadioDefault68" '+high_status+'>  <label class="form-check-label" for="flexRadioDefault68" > High </label></div></li><li class="list-group-item chnl-typ">Is Premium Wholesaler?</li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault70" onClick="outlet_premium_status(\'1\','+value.refid+')" id="flexRadioDefault70" '+premium+'>  <label class="form-check-label" for="flexRadioDefault70" >    Yes  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault71" onClick="outlet_premium_status(\'2\','+value.refid+')" id="flexRadioDefault71" '+not_premium+'>  <label class="form-check-label" for="flexRadioDefault71" > No </label></div></li></ul></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';
                               low_status='';medium_status='';high_status='';circle_count='';
                              if(value.potential_status==1)
                                  low_status='checked';
                              if(value.potential_status==2)
                                  medium_status='checked';
                              if(value.potential_status==3)
                                  high_status='checked';
                              if(value.image_count > 0)
                                 circle_count='<span class="circle_count">'+value.image_count+'</span>';
                              stock_confectionary='';not_stock_confectionary='';stock_chocolate='';not_stock_chocolate='';

                               if(value.stock_confectionary==1)
                                  stock_confectionary='checked';
                              if(value.stock_confectionary==2)
                                  not_stock_confectionary='checked';

                                 if(value.stock_chocolate==1)
                                  stock_chocolate='checked';
                              if(value.stock_chocolate==2)
                                  not_stock_chocolate='checked';

                              info = '<div class="media outlet-list"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3 class="title-box">' + value.outlet_name + '</h3></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'A\','+value.refid+',0)" id="flexRadioDefault1" '+found+'>  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'R\','+value.refid+',0)" id="flexRadioDefault2" '+not_found+'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'V\','+value.refid+',0)" id="flexRadioDefault2" '+visited+'>  <label class="form-check-label" for="flexRadioDefault2" > Visited </label></div></li><li class="list-group-item chnl-typ">Stocking Confectionery? </li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault70" onClick="outlet_premium_status(\'1\','+value.refid+',\'stock_confectionary\')" id="flexRadioDefault70" '+stock_confectionary+'>  <label class="form-check-label" for="flexRadioDefault70" >    Yes  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault71" onClick="outlet_premium_status(\'2\','+value.refid+',\'stock_confectionary\')" id="flexRadioDefault71" '+not_stock_confectionary+'>  <label class="form-check-label" for="flexRadioDefault71" > No </label></div></li><li class="list-group-item chnl-typ">Stocking Chocolate?</li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault700" onClick="outlet_premium_status(\'1\','+value.refid+',\'stock_chocolate\')" id="flexRadioDefault70" '+stock_chocolate+'>  <label class="form-check-label" for="flexRadioDefault70" >    Yes  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault710" onClick="outlet_premium_status(\'2\','+value.refid+',\'stock_chocolate\')" id="flexRadioDefault71" '+not_stock_chocolate+'>  <label class="form-check-label" for="flexRadioDefault71" > No </label></div></li></ul><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 75%;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'</div></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';

                      }

                     }    
                     else
                     {
                         info = '<div class="media outlet-list"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li></ul></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';
                     }
        
                    

                    if (value.icon != '' && value.icon !== undefined) {

                        var greenIcon = L.icon({
                            iconUrl: value.icon,
                            iconSize: [24, 24], // size of the icon
                            // iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                            // shadowAnchor: [4, 62], // the same for the shadow
                            //  popupAnchor: [-7, -86] // point from which the popup should open relative to the iconAnchor
                        });

                       

                    } else {
                      var greenIcon = L.icon({
                            iconUrl: 'https://analytics.brandidea.com/bilocaview/public/css/images/marker-icon.png',
                            iconSize: [28, 45], // size of the icon
                             iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                             shadowAnchor: [4, 62], // the same for the shadow
                              popupAnchor: [-7, -86] // point from which the popup should open relative to the iconAnchor
                        });

                        
                        //var m = new L.Marker(new L.LatLng(value.lat, value.lon));
                    }
                     var m = new L.Marker(new L.LatLng(value.lat, value.lon), {
                            icon: greenIcon,
                             iconSize: [5, 5]
                        });
                    m.bindPopup(info, {
                        'sticky': true,
                        pane: 'tool',
                        direction: 'top'
                    });
                     if(type == 9)
                     {
                         
                        if(value.type=='covered')
                        {
                            // showarray[value.refid]=m;
                          outlet_markerarray.push(m);
                        }
                        if(value.type=='uncovered')
                        {
                            showarray[value.refid]=m;
                            showarray_uncovered[value.refid]=m;
                           // m.on('click', clickZoom);
                            //m.addTo(map);
                            uncovered_outlet_markerarray.push(m);
                        }
                       
                     }
                     else if(type==10)
                     {
                         showarray[value.refid]=m;
                          uncovered_outlet_markerarray.push(m);
                          
                     }
                     else if(type==11 && ((("{{Auth::user()->client_id}}")==86) || ("{{Auth::user()->client_id}}")==100 || ("{{Auth::user()->client_id}}")==120) )  
                      {
                         showarray[value.refid]=m;
                         if(value.cluster)
                         {
                              if(value.cluster_id in marker_cluster_list){
                           
                             marker_cluster_list[value.cluster_id].push(m);

                             find_val[value.cluster_id][value.potential_status]++;
                          }
                          else
                          {
                             marker_cluster_list[value.cluster_id]=[];
                             find_val[value.cluster_id]=[];
                             find_val[value.cluster_id][1]=0;
                             find_val[value.cluster_id][2]=0;
                             find_val[value.cluster_id][3]=0;
                              marker_cluster_list[value.cluster_id].push(m);
                              find_val[value.cluster_id][value.potential_status]++;

                          }
                         }
                        
                       
                          outlet_markerarray.push(m);


                      }
                     else
                     {
                          showarray[value.refid]=m;
                          outlet_markerarray.push(m);

                     }
                    

                    k++;


                }

            });
           if(type == 9)
           {
        
                markercluster.addLayers(outlet_markerarray);
                markercluster.addTo(map);               
                uncovered_markercluster.addLayers(uncovered_outlet_markerarray);
                uncovered_markercluster.addTo(map);
                if(uncovered_outlet_markerarray.length>0)
                {
                    var featureGroup1 = L.featureGroup(uncovered_outlet_markerarray);
                    map.fitBounds(featureGroup1.getBounds());

                }
                else if(outlet_markerarray.length>0)
                {
                      var featureGroup2 = L.featureGroup(outlet_markerarray);
                      map.fitBounds(featureGroup2.getBounds());
                }
                
     
                

           }
           else if(type==10)
           {
                uncovered_markercluster.addLayers(uncovered_outlet_markerarray);
                uncovered_markercluster.addTo(map);
              
           }

          else if(((type==11 || ("{{Auth::user()->client_id}}")==86 || ("{{Auth::user()->client_id}}")==120))   && marker_cluster_list.length > 0)
            {


              markergroup=[];
              var bounds = L.latLngBounds();

             console.log(marker_cluster_list);

                $.each(marker_cluster_list,function(k,v){
                 
                  if(k !=0 && k!='' && k!=undefined && v!=undefined)
                  {
                   
                       vars['mark' + k] = new L.MarkerClusterGroup({ 
                        id:k,
                      iconCreateFunction: function (cluster) {
                          var markers = cluster.getAllChildMarkers();
                         // var html = '<div class="circle">  <div class="inner" >C'+k+' : '+markers.length + ':'+find_val[k][3]+':'+find_val[k][2]+'</div></div>';
                          var html = '<div class="circle">  <div class="inner"><strong style="font-weight:900 !important;color:black;font-size:10px">C'+k+'</strong>  <b style="color:blue">'+markers.length + '</b><br><b style="color:green">'+find_val[k][3]+'</b> <span style="color:black">|</span> <b style="color: #FF6037">'+find_val[k][2]+'</b></div></div>';
                          return L.divIcon({ html: html, className: 'mycluster', iconSize: L.point(32, 32) });
                      },
                      spiderfyOnMaxZoom: false, showCoverageOnHover: true, zoomToBoundsOnClick: false,disableClusteringAtZoom:20, maxClusterRadius: 300
                  });

              
                      vars['mark' + k].addLayers(v);
                      bounds.extend(vars['mark' + k].getBounds());
                     
                     
                      markergroup.push(vars['mark' + k]);
                      // vars['mark' + k].freezeAtZoom(15);
                      vars['mark' + k].addTo(map);
                      vars['mark' + k].on('clusterclick', function() {getmaker(this.options.id);});

                  }
                  if(k=="" && v!=undefined)
                  {
                    for(i=0;i<v.length;i++)
                    {
                      map.addLayer(v[i]);
                      
                    }
                  } 
                  
                });
              //  dynamic_control[5].disable();
              //  var featureGroup_ = L.featureGroup(markergroup).addTo(map);
                 map.fitBounds(bounds);
                 map.scrollWheelZoom.disable();
            } 
           else{

             markercluster.addLayers(outlet_markerarray);
             markercluster.addTo(map);
             if(((type==11 && (("{{Auth::user()->client_id}}")==86 || ("{{Auth::user()->client_id}}")==120))))
             {
                map.scrollWheelZoom.enable();
                //dynamic_control[5].enable();
             }


           }
           

        }




    }
   function getColor(maxvalue, minvalue, delta,low,high) {
    color=[];
    for(i=0;i<3;i++)
    {
       
       val=((high[i]-low[i])*delta+low[i]);
       color.push(val);

    }

    color="hsl("+color[0]+ ","+color[1]+"%," +color[2]+"%)";

    return color;

  }

    function changestyle_byresult(layer, result) {


     layer_enable={"active":0,"initiated":0,"activated":0,"deactivated":0,"recomand_subrd":0,"exist_subrd":0};

        if (layer !== undefined && (layer.feature.id !== undefined)) {
          context_layer=layer;

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

             if ((result.hasOwnProperty('activate_status_icon')) && result.activate_status_icon!='') {

                      
                       if(result.activate_status_icon !='NA')
                       {
                           var greenIcon = L.icon({
                              iconUrl:result.activate_status_icon,
                              iconSize: [20, 20],
                          });
                            var marker = L.marker([nextinfo['latitude'], nextinfo['longitude']], {
                              icon: greenIcon
                          });
                            marker.bindTooltip(nextinfo['info'], {
                        sticky: true,
                        pane: 'tool',
                        direction: 'top'
                    });

                       }

                       
                       if(result.activate_status == 1)
                       {
                              active.push(marker);

                       }
                           
                       if(result.activate_status== 2)
                       {
                            initiated.push(marker);
                            // layer.bindContextMenu({
                            //     contextmenu: true,
                            //     contextmenuItems: [{text: 'Temp Activation',  callback: function() {
                            //                 rpi_action(layer.feature.properties.ID,4);
                            //               }},{text: 'Temp Deactivation',callback: function() {
                            //                 rpi_action(layer.feature.properties.ID,5);
                            //               }}]
                            // });
                       }
                           
                        if(result.activate_status== 3 || result.activate_status== 0)
                        {
                          
                            // layer.bindContextMenu({
                            //     contextmenu: true,
                            //     contextmenuItems: [{text: 'Temp Initiation',callback: function() {
                            //                 rpi_action(layer.feature.properties.ID,2);
                            //               }},{text: 'Temp Activation',  callback: function() {
                            //                 rpi_action(layer.feature.properties.ID,4);
                            //               }},{text: 'Temp Deactivation',callback: function() {
                            //                 rpi_action(layer.feature.properties.ID,5);
                            //               }}]
                            // });                    
                        }
                       if(result.activate_status == 4)
                       {
                           activated.push(marker);
                           // layer.bindContextMenu({
                           //      contextmenu: true,
                           //      contextmenuItems: [{text: 'Temp Deactivation',callback: function() {
                           //                  rpi_action(layer.feature.properties.ID,5);
                           //                }}]
                           //  });
                       }                           
                       if(result.activate_status == 5)
                       {
                           deactivated.push(marker);  
                           // layer.bindContextMenu({
                           //      contextmenu: true,
                           //      contextmenuItems: [{text: 'Temp Activation',  callback: function() {
                           //                  rpi_action(layer.feature.properties.ID,4);
                           //                }}]
                           //  });     
                       }   
                                     

                }
                if(result.subrd_status != '')
                {

                   var greenIcon = L.icon({
                              iconUrl: result.subrd_marker,
                              iconSize: [25, 25],
                          });
                var marker = L.marker([nextinfo['latitude'], nextinfo['longitude']], {
                  icon: greenIcon
              });
                
                marker.bindTooltip(result.info, {
                        sticky: true,
                        pane: 'tool',
                        direction: 'top'
                    });

                        if(result.subrd_status == 2)   
                             recomand_subrd.push(marker);
                         if(result.subrd_status == 1)   
                             exist_subrd.push(marker);
                        if(result.subrd_status == 3)   
                             whole_subrd.push(marker);

                }
                
                
                   
            if (result.hasOwnProperty('size') && nextinfo['latitude']!='' && nextinfo['longitude']!='') {
                    // dynamic_control['circle'][0].enable();
                    // dynamic_control['clear'][0].enable();
                   
                    var circle = L.circleMarker([nextinfo['latitude'], nextinfo['longitude']], {
                        "radius": nextinfo['size'],
                        "fillColor": nextinfo['color'],
                        "color": "#C8C8C8",
                        "weight": 1,
                        "opacity": 1,
                        "fillOpacity": 0.8,
                        "stroke": 1,
                        "ID": layer.feature.properties.ID,
                        "DB_ID": layer.feature.properties.ID,
                        "main_location": nextinfo['main_location'],
                        "sub_location": nextinfo['sub_location'],
                        "location_name": nextinfo['location_name'],                      
                        "loc_id": nextinfo['loc_id'],
                        "latitude": nextinfo['latitude'],
                        "longitude": nextinfo['longitude'],
                        "view_type": "circle"
                    }).bindTooltip(result.info);
                     circle.bindPopup(result.info, {
                    
                    sticky: true,
                    direction: 'top'
                });

                
                    bubble_data.push(circle);
                    bubble_data_highlight[layer.feature.properties.ID] = circle;
                   
                    layer.bindTooltip(result.info, {
                        sticky: true,
                        direction: 'top'
                    });

                }
            if (result.hasOwnProperty('color')) {
                layer.setStyle({
                    fillColor: result.color,
                    color: '#808080',
                    weight: (zoomrange >= 16) ? 5 : 0.5,
                    stroke: (zoomrange >= 16) ? 5 : 0.8,
                    fillOpacity: overlay_arr[0]
                });
                   // result.info='<div class="container-fluid" style="width:20rem;height:fit-content"><span class="d-flex flex-row  justify-content-between pt-2"><h5>Bisayakpur Villg.&nbsp;</h5><span class="" style="height:1.5rem;width: 1.5rem;background-color: #00CCCC;border-radius: 50%;text-align: center;"><i class="fa fa-location-arrow" aria-hidden="true" style="font-size:17px;color:black;"></i></span></span><hr style="border-top: 1px solid white;"><p style="font-size:12px;"><span style="color:#00CCCC">Recommendation: </span>SubRD Reco Cluster Hub</p><p style="font-size:12px;"><span style="color:rgb(242, 101, 34)">Distance from Recommd Hub(km): </span>0 kms</p><p><span style="color:rgb(242, 101, 34)">Population (2021): </span>8,427</p><p style="font-size:12px;"><span style="color:rgb(242, 101, 34)">Outlet Potential: </span>15</p><p style="font-size:12px;"><span style="color:rgb(242, 101, 34)">Village chocolate Consumptn(Rs.): </span>14,7064</p><p style="font-size:12px;"><span style="color:rgb(242, 101, 34)">Cluster Tag: </span>SubRD Reco</p><p style="font-size:12px;"><span style="color:rgb(242, 101, 34)">SubD Priority: </span>Priority 2</p><p style="font-size:12px;"><span style="color:rgb(242, 101, 34)">SubD Cluster Priority: </span>Priority 2</p><p style="font-size:12px;"><span style="color:rgb(242, 101, 34)">Market UID: </span><span style="background-color:white;color:black;">8170739</span></p><p style="font-size:12px;"><span style="color:rgb(242, 101, 34)">BI Location ID: </span><span style="background-color:white;color:black;" >995071</span></p></div>';
                layer.bindTooltip(result.info, {
                    
                    sticky: true,
                    direction: 'top'
                });
                //result.info='';
                layer.bindPopup(result.info, {
                    
                    sticky: true,
                    direction: 'top'
                });
                
                // layer.openTooltip();
            }

        }
       
      if(result.hasOwnProperty('cluster_id'))
       {
       
          if (layer !== undefined && (layer.feature.id !== undefined)) {
                     layer.feature.properties.cluster_id = nextinfo['cluster_id'];
                     layer.feature.properties.status = 'hub';
                     if (cluster_layer.hasOwnProperty(nextinfo['cluster_id'])) {
                      cluster_layer[nextinfo['cluster_id']].push(layer);
                     }
                     else
                     {
                       cluster_layer[nextinfo['cluster_id']]=[];
                     }
                     
                     layer.on('mouseover',function(ev) 
                     {
                        if(ev.target.feature.properties.status == 'hub')
                        {
                            cluster_id=ev.target.feature.properties.cluster_id;
                            $.each( cluster_layer[cluster_id], function( key, value ) {
                                 highlightFeature(value);
                            });
                            
                        }
                     });
                      layer.on('mouseout',function(ev) 
                     {
                        if(ev.target.feature.properties.status == 'hub')
                        {
                            cluster_id=ev.target.feature.properties.cluster_id;
                            $.each( cluster_layer[cluster_id], function( key, value ) {
                                 resetHighlight(value);
                            });
                            
                        }
                     });
          }
       }
     
     
      layers_base.push(grayscale);
      layers_base.push(streets);
      layers_base.push(geojson);
      
       

    }
    function rpi_action(village_id, action_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'combine/rpi_action',
            async: true,
            data: {
                "rpi_action": 1,
                "village_id": village_id,
                "action_id": action_id
            },

            beforeSend: function() {
                $(".spin-loader").attr('style', 'display:block');
            },
            complete: function() {
                $(".spin-loader").attr('style', 'display:none');
            },

            success: function(res) {
                // rpi_split();
                action_name = (action_id == 2) ? 'Initiated' : ((action_id == 4) ? 'Activated' : ((action_id == 5) ? 'Deactivated' : 'Active'));
                alert(res.msg);
                 filter_dist=[];filter_taluk=[];
               $('input[name="districtlist"]:checked').each(function() {
                   filter_dist.push(parseInt($(this).val()));
                  });
               $('input[name="taluklist"]:checked').each(function() {
                   filter_taluk.push(parseInt($(this).val()));
                   filter_dist.push(parseInt($(this).attr('district_id')));
                  });
               input_obj.filter_district=filter_dist;
               input_obj.filter_taluk=filter_taluk;
               input_obj.type=12;
               initial(input_obj, 2, 12,false,false,action_name);
                //initial(input_obj, 2, current_level_map, '', moneyformattype, action_name);

            }
        });
    }

    function tablebuild(res, type) {
        tablefoot = false;
        if ($.fn.dataTable.isDataTable('#griddata')) {

            table.destroy();


            $("#griddata").html("");
            if (type == 4 || type==5 || type==6 || type==7 || type==8 || type==9 || type==10 || type==11  || type==13 || type==14) {
               
  
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                   // searching:true,
                   // dom: 'Bfrtip',
                  //  buttons: ['excel', 'pdf', 'print'],
                    paging: true,
                    info: false,
                    responsive: false,
                    "pageLength": 15,
                     "deferRender": true

                });


            } else {
              
  
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                   // dom: 'Bfrtip',
                  //  buttons: ['excel', 'pdf', 'print'],
                    paging: true,
                    //searching:true,
                    info: false,
                    "pageLength": 15,
                    responsive: false, "deferRender": true,
                    

                    fnFooterCallback: function(row, data, start, end, display) {

                        if (tablefoot == false && type != 3 && type != 4 && type!=5 && type!=6 && type!=7 && type!=8 && type!=9 && type!=10 && type!=11 && type!=12 && type!=13 && type!=14) {
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
            if (type == 4 || type==5 || type==6 || type==7 || type==8 || type==9 || type==10 || type==11 || type==12 || type==13 || type==14) {
             
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                 //   dom: 'Bfrtip',
                   // buttons: ['excel', 'pdf', 'print'],
                    paging: true,
                    //searching:true,
                    info: false,"pageLength": 15,
                    responsive: false, "deferRender": true

                });
            } else {
              
  
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                   // dom: 'Bfrtip',
                   // buttons: ['excel', 'pdf', 'print'],
                    paging: true,
                    //searching:true,
                    info: false,"pageLength": 15,
                    responsive: false, "deferRender": true,

                    fnFooterCallback: function(row, data, start, end, display) {

                        if (tablefoot == false && type != 3 && type != 4 && type != 3 && type != 4 && type!=5 && type!=6 && type!=7 && type!=8 && type!=9 && type!=10 && type!=11 && type !=12 && type!=13 && type!=14) {
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
        $('#griddata tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            id=$(this).html();

            row.child(format(id)).show();
            tr.addClass('shown');
        }
    });

        $(".dataTables_length").remove();
        $("#showdata").css("display", "flex")

        return true;
    }
    function format(id)
    {
      json_str=$(".getchild_"+id).attr("id");
      var decoded = JSON.parse($("<div/>").html(json_str).text());
      str = '<table class="table table-striped table-bordered" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
    
      k=1;
      $.each(decoded[0], function (key, val) {
           str += '<tr class="table-info">';
         str +='<td style="width:2rem;text-align:right;">'+k+'</td>';
            str +='<td style="width:10rem;text-align:center;">Cluster '+val['cluster_id']+'</td>';
             str +='<td style="text-align:left;width:7.5rem;">'+val['district_name']+'</td>';
              str +='<td style="text-align:left;width:7.5rem;">'+val['taluk_name']+'</td>';
              val2=JSON.stringify(val);
               str +='<td style="text-align:left;width:12rem;padding-left:2rem;"><a href="#"  id="'+val['village_census']+'" style="text-decoration:underline;" onClick="showbound(this)">'+val['village_name']+'</a></td>';
                str +='<td style="text-align:right;width:7rem;">'+val['market_id']+'</td>';
                 str +='<td style="text-align:right;width:20rem;">'+val['distance_subrd']+'</td>';
                  str +='<td style="text-align:right;width:10rem;">'+val['outlet_potential']+'</td>';
                   str +='<td style="text-align:right;width:10rem;">'+val['population']+'</td>';
                    str +='<td style="text-align:right;width:10rem;">'+val['village_choc_consmptn']+'</td>';
                   
                     str +='<td style="text-align:right;width:10rem;"><a href="#" id="'+val['subrd_priority']+'" taluk="'+val['taluk_census']+'" subrd_type="'+val['subrd_type']+'" district="'+val['loc9']+'" style="text-decoration:underline" onClick="show_priority(this)">'+val['subrd_priority']+'</a></td>';
                     str +='<td style="text-align:right;width:10rem;">'+val['cluster_tag']+'</td>';
            
            str += '</tr>';
            k++;
    });
      
       str += '</table>';
       
        return str;

      
    }

    function legendremove() {

        for (i = 0; i < legend_arr.length; i++) {
            legend_arr[i].remove();
        }
        legend_arr = [];
    }

    function legend(data) {
        
    	legendremove();
        var legend = L.control({
            position: 'bottomleft'
        });

        legend.onAdd = function(map) {

            var div = L.DomUtil.create('div', 'info legend');

                var labels = [];

            if(Array.isArray(data))
            {
            	
                  $.each(data[0], function(index, value) {
                div.innerHTML +=
                    '<div class="legend-wraper"><span style="background-image:linear-gradient(to right, ' + value + ' , ' + value + ')"></span>' + index + '</div>';

              });

            }
            else
            {
                 
                  if(data==9)
                {

                  div.innerHTML +='<div id="div-to-toggle"><button onclick="myFunction()" class="btn-close" > <img src="assets/images/info-icon.png" alt="" width="20" height="20"></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper"> <span class="dot" style="background-color:#FFF"></span> Covered</div><div class="legend-wraper"><span class="dot" style="background-color:#9b5df7"></span> Uncovered</div><div class="legend-wraper"><span class="dot" style="background-color:#0470f4"></span> Visited - Relevant</div><div class="legend-wraper"><span class="dot" style="background-color:#808080"></span> Visited - Not Relevant</div><div class="legend-wraper"><span class="dot" style="background-color:#f21919"></span> Existing</div><hr style="margin:0px 0px 5px 0px;"><div class="legend-wraper">Store Potential</div><hr style="background-color:#fff;margin:0px 0px 4px 0px;"><div class="legend-wraper"><span class="ring" style="border: 2px solid #51c82c"></span> High</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #ff8b02"></span> Medium</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #f21919"></span> Low</div> </div></div>';

                      
                      return div;

                }
                 if(data==5 || data==11)
                {

 
                     div.innerHTML +='<div class="legend-wraper"><span class="dot" style="background-color:#5fb924"></span> Found</div><div class="legend-wraper"><span class="dot" style="background-color:#808080"></span> Not Found / Visited</div>';
                      return div;

                }
                if(data==10)
                {
                    div.innerHTML +='<div class="legend-wraper"><span class="dot" style="background-color:#5fb924"></span>  Uncovered</div>';
                     return div;
                }
                if(data==13)
                {
                    div.innerHTML +='<div class="legend-wraper"><img src="highway/actual_subrd.png" width="15px" height="15px" />&nbsp;Actual Subrd</div><div class="legend-wraper"><img src="highway/recomnd_subrd.png" width="15px" height="15px" />  &nbsp;Recommended Subrd</div><div class="legend-wraper"><img src="highway/group_a_retailer.png" width="15px" height="15px" />  &nbsp;Group A</div><div class="legend-wraper"><img src="highway/group_b_retailer.png" width="15px" height="15px" />  &nbsp;Group B</div>';
                   
                     return div;
                }

               

            }
               
           
            return div;
        };

         if(Array.isArray(data) && data.length >0)
            legend.addTo(map);
         else if(data!='' && data!=undefined)
            legend.addTo(map);

        legend_arr.push(legend);

    }
    function show_priority(data)
    {
       district=$(data).attr('district');
       taluk=$(data).attr('taluk');
       subrd_type=$(data).attr('subrd_type');
       priority=$(data).attr('id');
        input_obj = {
                        'type': 12,                        
                        'filter_district':[district],
                       // 'filter_taluk':[taluk],
                        'type_view':subrd_type,
                        'filter_priority':priority
                        
                        };
                        removelayer();
                      
                        $("#showmap").click();
                        map.invalidateSize();
                        initial(input_obj, 0,12, '');
                      
    }
    function show_subrdbeat_filter(e)
    {

       layer=e.target;
       console.log(layer);
       id=layer.feature.properties.beat_id;
       filter_subrdbeat=[];
      // dynamic_control[5].enable();
       filter_subrdbeat.push(id);
         input_obj = {
                        'type': 14,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_subrdbeat':filter_subrdbeat,
                        'filter_subrd':[],
                        
                        };
                        //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
                        removelayer();
                      
                        $("#showmap").click();
                          map.invalidateSize();
                        initial(input_obj, 0,14, false,false,'',false,true,true);
    }
    function show_subrdbeat(beat_id,subrd_id)
    {
    	filter_subrdbeat=[];filter_subrd=[];
    	if(beat_id != 0)
    	{
			filter_subrdbeat.push(beat_id);
			$.each($("input[name='subrd_beat']:checked"), function() {
                        filter_subrd.push($(this).val());
                    });
    	}
    	else {
    		
    	     filter_subrd.push(subrd_id);

    	}
    	 
         
            input_obj = {
                        'type': 14,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_subrdbeat':filter_subrdbeat,
                        'filter_subrd':filter_subrd,
                        
                        };
                        //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
                        removelayer();
                      
                        $("#showmap").click();
                          map.invalidateSize();
                        if(beat_id != 0)
                        initial(input_obj, 0,14, false,false,'',false,true,true);
                    else
                        initial(input_obj, 0,14, false,false,'',false,true);
    }
    function show_highway(highway_id,channel='',subrd_code=0)
         {
           filter_highway=[];filter_channel='';filter_subrd=0;
           filter_highway.push(highway_id);
           if(channel!='')
             filter_channel=channel;
           if(subrd_code!=0)
             filter_subrd=subrd_code;
            input_obj = {
                        'type': 13,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_highway':filter_highway,
                        'filter_channel':filter_channel,
                        'filter_subrd':filter_subrd
                        
                        };
                        //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
                        removelayer();
                        map.invalidateSize();
                        $("#showmap").click();
                        initial(input_obj, 0,13, false,false,'',true);
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
                   // layer.openPopup();

                    bounds.push(layer);


                }


            }
             $("#showmap").click();
                map.invalidateSize();
            var featureGroup = L.featureGroup(bounds).addTo(map);
            map.fitBounds(featureGroup.getBounds());
            //$("#showmap").click();

        } else {
           
            layer = layer_bound[id];
            if (layer !== undefined && (layer.feature.id !== undefined)) {

                layer.setStyle({
                    color: "red",
                    weight: (zoomrange >= 16) ? 5 : 0.5,
                    stroke: (zoomrange >= 16) ? 5 : 0.8,
                    opacity: 1

                });
                bounds=[];
                //layer.openPopup();
                bounds.push(layer);
                $("#showmap").click();
                map.invalidateSize();


                var featureGroup = L.featureGroup(bounds).addTo(map);
              
                map.fitBounds(featureGroup.getBounds());
                //setTimeout(function(){map.fitBounds(featureGroup.getBounds());},500);
                
                //map.fitBounds(layer.getBounds());
                


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
        if (showlist_user_id.length <= 0 && (dynamic_control[0]!=undefined && dynamic_control[0]!=null && dynamic_control[0]!='' ))
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
        
                       
        $("#showmap").click(function(){
            map.invalidateSize();
        });
     
        $(".file-upload-browse").click(function(event){
            event.stopPropagation();
        });
         $('#mobile_no').keypress(function (e) {    
    
                var charCode = (e.which) ? e.which : event.keyCode    
    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
    
                    return false;                        
            });

       

        $(".fa-map-marker").click();

        // function getLocation() {
        //     if (navigator.geolocation) {
        //         navigator.geolocation.getCurrentPosition(showPosition);
        //     } else {
        //         alert("Geolocation is not supported by this browser.");
        //     }
        // }

        // function showPosition(position) {

        //     current_location['lat'] = position.coords.latitude;
        //     current_location['lon'] = position.coords.longitude;



        // }


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
            $('#outlet_name,#owner_name,#sub_channel_name,#address,#fileupload').each(function() {
                
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
                    if($(this).attr("id")=="fileupload")
                    {
                        alert("Kindly upload the outlet image.");
                    }
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
                        setTimeout(function() {
                            $(".alert").hide('slow');
                        }, 3000);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

        });
        $("form#outlet_image").submit(function(e) {

       e.preventDefault();
      var formData = new FormData(this);

      var isValid = true;
      
      if (isValid == true) {
        $.ajax({
          url: 'dashboard/addoutlet_image',
          type: 'POST',
          data: formData,
          success: function(data) {
            result_form = JSON.parse(data);
            if (result_form['status'] == 'success') {
              $("#alertstatus_1").html('<div class="alert alert-success" role="alert">' + result_form['msg'] + '</div>');
              document.getElementById("outlet_image").reset();
              $('#mymodal-fileupload').modal('hide');

            } else {
              $("#alertstatus_1").html('<div class="alert alert-danger" role="alert">' + result_form['msg'] + '</div>');



            }
            setTimeout(function() {
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
                setTimeout(function() {
                    $(".alert").hide('slow');
                }, 3000);
            }
        });

    }
     function outlet_status_byshopstatus(status,refid) {
        outlet_id =refid;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updateoutlet',
            type: "POST",
            data: {
                'outlet_id': outlet_id,"status":status
            },
            dataType: "json",
            success: function(response) {
                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
                    if(status==1)
                       alert("Outlet found.");
                   if(status==2)
                       alert("Outlet Not found.");


                } else {
                    alert("Not updated");
                }
             
            }
        });

    }
    function outlet_premium_status(status,refid,column) {
        outlet_id =refid;
        if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updateoutlet_premium',
            type: "POST",
            data: {
                'outlet_id': outlet_id,"column_name":column,"status":status,"lat":current_location['lat'],"lon":current_location['lon']
            },
            dataType: "json",
            success: function(response) {

                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
                  filter_beat = [];

                    $.each($("input[name='beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 11,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':filter_beat
                    };


                    initial(input_obj, 0,11, '',false);
                    setTimeout(function showpop(){showarray[outlet_id].openPopup();},1000);
                    

                  


                } else {
                    alert("Not updated");
                }
             
            }
        });

    }
    function outlet_potential_status(status,refid,cluster_id) {
        outlet_id =refid;
        if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updateoutlet_potential',
            type: "POST",
            data: {
                'outlet_id': outlet_id,"status":status,"lat":current_location['lat'],"lon":current_location['lon']
            },
            dataType: "json",
            success: function(response) {

                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
                  filter_beat = [];

                    $.each($("input[name='beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });



                    input_obj = {
                        'type': 11,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':filter_beat,
                        'filter_bycluster':[cluster_id]
                    };


                    initial(input_obj, 0,11, '',false);
                    setTimeout(function showpop(){showarray[outlet_id].openPopup();},1000);

                  


                } else {
                    alert("Not updated");
                }
             
            }
        });

    }
    function outlet_status(status,refid,cluster_id) {
        outlet_id =refid;
        if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updateoutlet',
            type: "POST",
            data: {
                'outlet_id': outlet_id,"status":status,"lat":current_location['lat'],"lon":current_location['lon']
            },
            dataType: "json",
            success: function(response) {

                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
                  filter_beat = [];

                    $.each($("input[name='beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 11,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':filter_beat,
                        'filter_bycluster':[cluster_id]
                    };


                    initial(input_obj, 0,11, '',false);

                    if(status=='A')
                    {
                       
                        var greenIcon = L.icon({
                            iconUrl: 'images/uncovered.png',
                            iconSize: [24, 24]
                        });
                        showarray[outlet_id].setIcon(greenIcon);
                        setTimeout(function showpop(){showarray[outlet_id].openPopup();},1000);
                       // showarray_uncovered[outlet_id].setIcon(greenIcon);
                       alert("Outlet Founded.");

                    }
                   if(status=='R')
                   {
                       var greenIcon = L.icon({
                            iconUrl: 'images/nr.png',
                            iconSize: [24, 24]
                        });
                       // showarray_uncovered[outlet_id].setIcon(greenIcon);
                        showarray[outlet_id].setIcon(greenIcon);
                        setTimeout(function showpop(){showarray[outlet_id].openPopup();},1000);
                       alert("Not Found.");
                   }
                    if(status=='V')
                   {
                       var greenIcon = L.icon({
                            iconUrl: 'images/nr.png',
                            iconSize: [24, 24]
                        });
                       // showarray_uncovered[outlet_id].setIcon(greenIcon);
                        showarray[outlet_id].setIcon(greenIcon);
                       setTimeout(function showpop(){showarray[outlet_id].openPopup();},1000);
                       alert("Outlet Visited.");
                   }


                } else {
                    alert("Not updated");
                }
             
            }
        });

    }
    function outlet_status_uncovered(status,refid) {
        outlet_id =refid;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updateoutlet_byid',
            type: "POST",
            data: {
                'outlet_id': outlet_id,"status":status
            },
            dataType: "json",
            success: function(response) {
                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {

                    if(status=='A')
                    {
                        var greenIcon = L.icon({
                            iconUrl: 'images/coveredblue.png',
                            iconSize: [24, 24]
                        });
                        showarray_uncovered[outlet_id].setIcon(greenIcon);
                       alert("Outlet is activated.");
                    }
                   if(status=='R' || status=='V' )
                   {
                       var greenIcon = L.icon({
                            iconUrl: 'images/nr.png',
                            iconSize: [24, 24]
                        });
                        showarray_uncovered[outlet_id].setIcon(greenIcon);

                       alert("Not Relevant/Visited Outlet .");
                   }
                   


                } else {
                    alert("Not updated");
                }
             
            }
        });

    }
      function highlight(id,lat,lon)
    {
        
        $("#showmap").click();
        map.invalidateSize();
       
        var bounds = L.marker([lat,lon]);
       
         var featureGroup = L.featureGroup([bounds]);
         map.fitBounds(featureGroup.getBounds());

         setTimeout(function() {
                    showarray[id].openPopup();
                }, 500);


      //  console.log(showarray[id].openPopup());
       
      
    }



    function showimage(data) {
        src = $(data).attr('src');
        $('#mymodal-image').modal('show');
        $('#imageview').html('');
        $('#imageview').html('<img id="theImg" src="' + src + '" />');

    }

    function location_navigate(data)
    {
          getLocation();
          geo = current_location['lat'] + ',' + current_location['lon'];
         
         clicked_shop_location=$(data).attr("geocode");  
         console.log(clicked_shop_location);
         shop_location=clicked_shop_location.split(",");

         shop_lat=shop_location[0];
         shop_lon=shop_location[1];     
       
         
         str = "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + shop_lat + "," + shop_lon + "'/";
         window.open(str, 'window name', 'window settings');
    }
    function direction(e)
    {
        
          getLocation();
          geo = current_location['lat'] + ',' + current_location['lon'];
         clicked_lat=e.latlng.lat;
         clicked_lon=e.latlng.lng;    
       
         
         str = "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + clicked_lat + "," + clicked_lon + "'/";
         window.open(str, 'window name', 'window settings');
    }
    function circleContextClick(id,status)
    {
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updatestatus',
            type: "POST",
            data: {
                'outlet_id': id,'status':status
            },
            dataType: "json",
            success: function(response) {
                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
                    $("#alertstatus_list").html('<div class="alert alert-success" role="alert">' + response['msg'] + '</div>');

                    

                } else {
                    $("#alertstatus_list").html('<div class="alert alert-danger" role="alert">' + response['msg'] + '</div>');
                }
                setTimeout(function() {
                    $(".alert").hide('slow');
                }, 3000);
            }
        });
    }
     function userhistory()
    {
         if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/userhistory',
            type: "POST",
            data: {
                'lat': current_location['lat'],'lon':current_location['lon']
            },
            dataType: "json",
            success: function(response) {
             
               
            }
        });
    }

    userhistory();
     setInterval(function() {
                    userhistory();
                }, 600000);

     setInterval(function() {
                   // refresh_outlet();
                }, 60000);

     function getmaker(cluster_id)
    {
          outlet_type=[];selected_id=[];potential_selected_id=[];status_selected_id=[];
          cluster=[cluster_id];

       $('input[name="outlets"]:checked').each(function() {
            outlet_type.push(this.value);
    });
         $('input[name="tag_list"]:checked').each(function() {
            selected_id.push(this.value);
    });
          $('input[name="potentiallist"]:checked').each(function() {
            potential_selected_id.push(parseInt(this.value));
    });
          $('input[name="statuslist"]:checked').each(function() {
            status_selected_id.push(this.value);
    });
         
        
         obj = {
            'type': input_obj.type,
            'filter_bychannel':selected_id,
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,
            'outlet_type':outlet_type,
            'filter_bystatus':status_selected_id,
            'filter_bycluster':cluster
               };
               
        initial(obj, 2, input_obj.type, true);

    }
    function refresh_outlet()
    {
        outlet_type=[];selected_id=[];potential_selected_id=[];status_selected_id=[];

       $('input[name="outlets"]:checked').each(function() {
            outlet_type.push(this.value);
    });
         $('input[name="tag_list"]:checked').each(function() {
            selected_id.push(parseInt(this.value));
    });
          $('input[name="potentiallist"]:checked').each(function() {
            potential_selected_id.push(parseInt(this.value));
    });
          $('input[name="statuslist"]:checked').each(function() {
            status_selected_id.push(this.value);
    });
         
        
          obj = {
            'type': input_obj.type,
            'filter_bychannel':selected_id,
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,
            'outlet_type':outlet_type,
            'filter_bystatus':status_selected_id
          };
      if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
   {
       current_location['lat']=map.getCenter().lat;
       current_location['lon']=map.getCenter().lng;
   }
      loaddata = {
            'initialmap':0,
            'input': JSON.stringify(obj),
            'type': input_obj.type,
            'filter_so': filter_so,
            'current_location':[current_location['lat'],current_location['lon']],
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
            success: function(res) {
               $.each(res['map_nextlevel_info'], function(key, value) {
                     if(value.type=='uncovered')
                     {                      
                      uncovered_outlet_detail[value.refid]=value;
                      found='';not_found='';visited='';
                                                        
                        if(value.status=='A')
                            found='checked';
                        if(value.status=='R')
                            not_found='checked';
                         if(value.status=='V')
                            visited='checked';
                         if(value.status=='A' || value.status=='R' || value.status=='NF')
                            info=current_content(value,value.status);
                         

                          if (value.icon != '' && value.icon !== undefined) {

                            var greenIcon = L.icon({
                                iconUrl: value.icon,
                                iconSize: [24, 24], // size of the icon
                                // iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                                // shadowAnchor: [4, 62], // the same for the shadow
                                //  popupAnchor: [-7, -86] // point from which the popup should open relative to the iconAnchor
                            });

                           

                        } else {
                          var greenIcon = L.icon({
                                iconUrl: 'https://analytics.brandidea.com/bilocaview/public/css/images/marker-icon.png',
                                iconSize: [28, 45], // size of the icon
                                 iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                                 shadowAnchor: [4, 62], // the same for the shadow
                                  popupAnchor: [-7, -86] // point from which the popup should open relative to the iconAnchor
                            });

                            
                            //var m = new L.Marker(new L.LatLng(value.lat, value.lon));
                        }
                     
                        if (showarray_uncovered[value.refid] && value.status !='N') 
                          {
                                 
                             showarray_uncovered[value.refid].bindPopup(info);
                             showarray_uncovered[value.refid].setIcon(greenIcon);
                          }
                     }

                    });

                 tablebuild(res,input_obj.type);

            }
          });
    }
  
    function filter_bychannel()
    {

       // var selected_id=$("#channellist option:selected").val();
        //var potential_selected_id=$("#potentiallist option:selected").val();
        //var status_selected_id=$("#statuslist option:selected").val();
         outlet_type=[];selected_id=[];potential_selected_id=[];status_selected_id=[];

       $('input[name="outlets"]:checked').each(function() {
            outlet_type.push(this.value);
    });
         $('input[name="tag_list"]:checked').each(function() {
            selected_id.push(this.value);
    });
          $('input[name="potentiallist"]:checked').each(function() {
            potential_selected_id.push(parseInt(this.value));
    });
          $('input[name="statuslist"]:checked').each(function() {
            status_selected_id.push(this.value);
    });
         
        
         obj = {
            'type': input_obj.type,
            'filter_bychannel':selected_id,
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,
            'outlet_type':outlet_type,
            'filter_bystatus':status_selected_id
               };
               
        initial(obj, 2, input_obj.type, true);
    }
    function deletefilter()
    {
    	 $('input[name="tag_list"]').each(function() {
             $(this).prop('checked', true);
         });
         $('input[name="potentiallist"]').each(function() {
             $(this).prop('checked', true);
    });
         $('input[name="statuslist"]').each(function() {
           $(this).prop('checked', true);
    });
          $('input[name="outlets"]').each(function() {
           $(this).prop('checked', true);
    });

         obj = {
            'type': input_obj.type,
            'filter_beat':filter_beat
            
               };
               
          initial(obj, 2, input_obj.type, false);
    }
    function clearfilter()
    {
       $('input[name="tag_list"]').each(function() {
             $('input[name="tag_list"]').prop('checked', true);
         });
         $('input[name="potentiallist"]').each(function() {
             $('input[name="potentiallist"]').prop('checked', true);
    });
         $('input[name="statuslist"]').each(function() {
           $('input[name="statuslist"]').prop('checked', true);
    });
          $('input[name="outlets"]').each(function() {
           $('input[name="outlets"]').prop('checked', true);
    });


         obj = {
            'type': input_obj.type,
            'filter_beat':filter_beat,
            'filter_bychannel':[],
            
               };
               
          initial(obj, 2, input_obj.type, false);
    }
    function showpotential(id,cluster_id)
    {
       potential=[];
       potential['Low']=1;
       potential['Medium']=2;
       potential['High']=3;
       potential['']=0;
       potential['NA']=0;


         obj = {
            'type': input_obj.type,
            'filter_beat':filter_beat,
            'filter_bypotential':[potential[id]],
            'filter_bycluster':[cluster_id]
            
               };
               
          initial(obj, 2, input_obj.type, false);
    }
    function showbeat(id)
    {
          outlet_type=[];selected_id=[];potential_selected_id=[];status_selected_id=[];

       $('input[name="outlets"]:checked').each(function() {
            outlet_type.push(this.value);
    });
         $('input[name="tag_list"]:checked').each(function() {
            selected_id.push(parseInt(this.value));
    });
          $('input[name="potentiallist"]:checked').each(function() {
            potential_selected_id.push(parseInt(this.value));
    });
          $('input[name="statuslist"]:checked').each(function() {
            status_selected_id.push(this.value);
    });

         obj = {
            'type': input_obj.type,
             'filter_bychannel':selected_id,           
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,
            'show_beat':id,'filter_bystatus':status_selected_id
            };
               
        initial(obj, 2, input_obj.type, true);
    }
    function showuncovered(id,cluster_id)
    {
       outlet_type=[];potential_selected_id=[];status_selected_id=[];cluster=[cluster_id];
       $('input[name="outlets"]:checked').each(function() {
            outlet_type.push(this.value);
    });
        
          $('input[name="potentiallist"]:checked').each(function() {
            potential_selected_id.push(parseInt(this.value));
    });
          $('input[name="statuslist"]:checked').each(function() {
            status_selected_id.push(this.value);
    });
        $('input[name="tag_list"]').each(function() {
             $('input[name="tag_list"]').prop('checked', false);
         });

       $('input[name="tag_list"][value="'+id+'"]').prop('checked', true);

        selected_id=[];
        selected_id.push(id);


        var potential_selected_id=$("#potentiallist option:selected").val();
        var status_selected_id=$("#statuslist option:selected").val();
         obj = {
            'type': input_obj.type,
            'filter_bychannel':selected_id,
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,'filter_bystatus':status_selected_id,"filter_bycluster":cluster
            };
               
        initial(obj, 2, input_obj.type, true);
    }

    function openCity1(evt, cityName) {
          var i, tabcontent, tablinks;
          // tabcontent = document.getElementsByClassName("tab-content");
          // for (i = 0; i < tabcontent.length; i++) {
          //   tabcontent[i].style.display = "none";
          // }
          tablinks = document.getElementsByClassName("tab-pane");
          for (i = 0; i < tablinks.length; i++) {
            
            tablinks[i].className = tablinks[i].className.replace(" show active", "");
            tablinks[i].style.display ="none";

          }
          if(!$("div >#"+cityName).hasClass("acitve")){

            $("div > #"+cityName).addClass("show active");
            $("div > #"+cityName).attr("style","display:block;");

          }
            

           evt.currentTarget.className += " active";
   }
 
   $("#showmap").click(function(){
        map.invalidateSize();
   });
   setInterval(function(){
      // map.on('locationfound', onLocationFound);
      // map.on('locationerror', onLocationError);
      map.invalidateSize();

     
       }, 100);

   function onLocationFound(e) {
    var radius = e.accuracy;

    L.marker(e.latlng).addTo(map)
        .bindPopup("You are within " + radius + " meters from this point").openPopup();

    L.circle(e.latlng, radius).addTo(map);
}
function onLocationError(e) {
    alert(e.message);
}

function changestatus(refid)
{
    $("#store_outletid").val(refid);
}
function notrelevant(refid,shop_image,outlet_name,channel_name,sub_channel_name,address,lat,lon)
{
     outlet_id=refid;
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/notrelavantoutlet',
            type: "POST",
            data: {
                'outlet_id': outlet_id,'lat': current_location['lat'],'lon':current_location['lon']
            },
            dataType: "json",
            success: function(response) {
                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
                  $('#exampleModal').click();

                       var greenIcon = L.icon({
                            iconUrl: 'images/nr.png',
                            iconSize: [24, 24]
                        });
                        info=changecontent(uncovered_outlet_detail[outlet_id],[],'R');
                 

                        showarray_uncovered[outlet_id].bindPopup(info);

                        // showarray_uncovered[outlet_id].closePopup();
                         showarray_uncovered[outlet_id].setIcon(greenIcon);
                        
                        alert("Status updated");
                          initial(input_obj, 2, 9,false,true);

                } 
                else
                {
                      alert("Status not updated");
                      
                }
            }
        });
     return true;
}
function mcchain(class_name,step,id)
{
  if(detailed_array['outlet_id'] != id)
    {
         detailed_array={};
    }
    detailed_array['outlet_id']=id;

     $(".zero"+id).hide();     
     $(".second_div"+id).hide();
     $(".first_div"+id).hide();
     $(".fourth_div"+id).hide();
     $(".third_div"+id).hide();

    if(step==0 || step==1)
    {
        
         $("."+class_name).show();
         $("."+class_name).attr("style","display:block;");
    }

     if(step==2)
     {
         
         $(".brand_info").each(function(){
              detailed_array[this.name]="NA";
              
          });
           
           $(".brand_info:checked").each(function(){

              if(this.checked)
              {
                  detailed_array[this.name]=this.value;  
                   name_of_var=$("#jj_"+this.name+"_"+id).attr("name");
                   if(this.value=='yes')
                   {
                    console.log("#jj_"+this.name+"_"+id);
                    
                          feedback=$("#jj_"+this.name+"_"+id).val();
                         
                         
                               detailed_array[name_of_var]=feedback; 
                              $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/relavantoutlet',
            type: "POST",
            data: {
                'outlet_id': id,'detail':JSON.stringify(detailed_array),'lat': current_location['lat'],'lon':current_location['lon']
            },
           
            success: function(response) {
                response=JSON.parse(response); 
                console.log(response);                             
                if (response['status'] == 'success') {                  
                
                       var greenIcon = L.icon({
                            iconUrl: 'images/coveredblue.png',
                            iconSize: [24, 24]
                        });  
                       info=changecontent(uncovered_outlet_detail[id],detailed_array,'A',response['feedback_question']);


                        showarray_uncovered[id].setIcon(greenIcon);
                        showarray_uncovered[id].bindPopup(info);
                         $(".zero"+id).show();
                         $(".second_div"+id).hide();
                         $(".first_div"+id).hide();
                         $(".third_div"+id).hide();
                         $(".fourth_div"+id).hide();
                        showarray_uncovered[id].closePopup();


                         initial(input_obj, 2, 9,false,true);
                        
                        alert("Status updated");

                } 
                else
                {
                      alert("Status not updated");
                      
                }
            }
        });
                               // $("."+class_name).show();
                               // $("."+class_name).attr("style","display:block;");
                              
                               //$("#shownwxtmoments").attr('onClick',notrelevant());
                         
                   }
                    else
                    {
                       detailed_array[name_of_var]='';
                         $("."+class_name).show();
                         $("."+class_name).attr("style","display:block;");
                    }


              }
             
             
           });
       
        
     }
     if(step==3)
     {
          if($("input[name='channelinfo']:checked").val()  != '' && $("input[name='channelinfo']:checked").val()  != undefined )
         {
               detailed_array['channel_id']=$("input[name='channelinfo']:checked").val();
            
               $("."+class_name).show();
               $("."+class_name).attr("style","display:block;");
         }
         else
         {
            $(".second_div"+id).show();  

         }
       
     }
     if(step==4)
    {
         $("."+class_name).show();
         $("."+class_name).attr("style","display:block;");
         $(".productlists_1,.productlists_2").each(function(){
              if(this.checked)
              {
                  detailed_array[this.name]=1;
              }
              else
              {                    
                  detailed_array[this.name]=0;
              }
         });
      }
    
      if(step==5)
    {
         detailed_array['freezer']=0;
        if($("input[name='freezer']:checked").val()  != '' && $("input[name='freezer']:checked").val()  != undefined )
         {
               detailed_array['freezer']=$("input[name='freezer']:checked").val();
            
               $("."+class_name).show();
               $("."+class_name).attr("style","display:block;");
         
      
      
        
        
        console.log(detailed_array);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/relavantoutlet',
            type: "POST",
            data: {
                'outlet_id': id,'detail':JSON.stringify(detailed_array),'lat': current_location['lat'],'lon':current_location['lon']
            },
           
            success: function(response) {
                response=JSON.parse(response); 
                console.log(response);                             
                if (response['status'] == 'success') {                  
                
                       var greenIcon = L.icon({
                            iconUrl: 'images/coveredblue.png',
                            iconSize: [24, 24]
                        });  
                       info=changecontent(uncovered_outlet_detail[id],detailed_array,'A',response['feedback_question']);


                        showarray_uncovered[id].setIcon(greenIcon);
                        showarray_uncovered[id].bindPopup(info);
                         $(".zero"+id).show();
                         $(".second_div"+id).hide();
                         $(".first_div"+id).hide();
                         $(".third_div"+id).hide();
                         $(".fourth_div"+id).hide();
                        showarray_uncovered[id].closePopup();


                         initial(input_obj, 2, 9,false,true);
                        
                        alert("Status updated");

                } 
                else
                {
                      alert("Status not updated");
                      
                }
            }
        });
      }
       else
       {
          $(".fourth_div"+id).show();  

       }

    }
     
}
function next(class_name,step,id)
{
    if(detailed_array['outlet_id'] != id && step != 4)
    {
         detailed_array={};
    }
    detailed_array['outlet_id']=id;

     $(".zero"+id).hide();
     $(".initial_div"+id).hide();
     $(".second_div"+id).hide();
     $(".first_div"+id).hide();
     $(".fourth_div"+id).hide();
     $(".third_div"+id).hide();
     $(".third_between_div"+id).hide();
     $(".second_info_sub1"+id).hide();
     $(".second_info_sub2"+id).hide();

     
     
    
    
    if(step==1)
    {
        
         $("."+class_name).show();
         $("."+class_name).attr("style","display:block;");

    }
    else if(step==0)
    {
         
         $("."+class_name).show();
         $("."+class_name).attr("style","display:block;");
    }
    else if(step==2)
    {
        

         
        
         if($("input[name='channelinfo']:checked").val()  != '' && $("input[name='channelinfo']:checked").val()  != undefined )
         {
         
             detailed_array['channel_id']=$("input[name='channelinfo']:checked").val();
            
               $("."+class_name).show();
               $("."+class_name).attr("style","display:block;");
         }
         else
         {
            $(".initial_div"+id).show();  

         }
       
        
         

    }
    else if(step==3)
    {
        
         
          $(".second_div"+id).show();
          
          if($('.stockinfo:checked').length > 0)
         {
            $("."+class_name).show();
            $("."+class_name).attr("style","display:block;");
            $(".second_div"+id).hide();
            $('.stockinfo').each(function() {
              if(this.checked)
              {
                 $(".second_info_sub"+this.name+id).show();


                 detailed_array[this.name]=1;
              }
              else
              {
                  $(".second_info_sub"+this.name+id).hide();
                  classid=this.name;
                  $(".sec"+classid).each(function(e){
                   
                     $(".sec"+classid+":eq("+e+")").prop("checked",false);
                         console.log(e);
                     
                   });
                  detailed_array[this.name]=0;

              }
              

            });
         }
         

        


    }
    else if(step==6)
    {
         str='';
         $("."+class_name).show();
         $("."+class_name).attr("style","display:block;");
         $(".productlists_1,.productlists_2").each(function(){
              if(this.checked)
              {

                  $(".jj_"+this.name).show();

                  detailed_array[this.name]=1;


              }
              else
              {
                  $(".jj_"+this.name).hide();
                  classname=this.name;
                  $(".packsize"+classname).each(function(e){
                  
                  $(".packsize"+classname+":eq("+e+")").prop("checked",false);
                  $(".parent"+classname+":eq("+e+")").attr("style","");
                        
                     
                   });
                  detailed_array[this.name]=0;
              }
         });
         

      
    }
    else if(step==4)
    {

      
        
        pack_info=$(".pack_info").length;
        pack_info_checked=$(".pack_info:checked").length;
     
       $(".pack_info").each(function(){
              detailed_array[this.name]="NA";
              
           });
           detailed_array['potential']=0;
           $(".pack_info:checked").each(function(){

              if(this.checked)
              {
                  detailed_array[this.name]=this.value;
                  detailed_array['potential']++;

              }
              else
              {                  
                  detailed_array[this.name]="NA";
              }
              
           });
       
         $("."+class_name).show();
     $("."+class_name).attr("style","display:block;");
    
      

         

    }
    else if(step==5)
    {
      
      $(".potential").each(function(){
              if(this.checked)
              {
                  detailed_array[this.name]=1;
              }
              else
              {                  
                  detailed_array[this.name]=0;
              }
         });
        
        
        console.log(detailed_array);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/relavantoutlet',
            type: "POST",
            data: {
                'outlet_id': id,'detail':JSON.stringify(detailed_array),'lat': current_location['lat'],'lon':current_location['lon']
            },
           
            success: function(response) {
                response=JSON.parse(response); 
                console.log(response);                             
                if (response['status'] == 'success') {                  
                
                       var greenIcon = L.icon({
                            iconUrl: 'images/coveredblue.png',
                            iconSize: [24, 24]
                        });  
                       info=changecontent(uncovered_outlet_detail[id],detailed_array,'A',response['feedback_question']);


                        showarray_uncovered[id].setIcon(greenIcon);
                        showarray_uncovered[id].bindPopup(info);
                         $(".zero"+id).show();
                         $(".second_div"+id).hide();
                         $(".first_div"+id).hide();
                         $(".third_div"+id).hide();
                         $(".fourth_div"+id).hide();
                        showarray_uncovered[id].closePopup();


                         initial(input_obj, 2, 9,false,true);
                        
                        alert("Status updated");

                } 
                else
                {
                      alert("Status not updated");
                      
                }
            }
        });

    }


}

function clickZoom(e) {
  map.setView(e.target.getLatLng(),22);
}

function changecontent(value,detail_array,status,feedback_question)
{
  client_name="{{Auth::user()->Organization}}";
console.log(feedback_question);

    status_info='';
    circle_count=''; style_code='';
   if(parseInt(value.image_count) > 0)
       circle_count='<span class="circle_count">'+value.image_count+'</span>';
    
     if(status=='R')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant not-relevant-edit-button" >Not Relevant  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
      if(status=='NF')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant not-relevant-edit-button" >Store not found  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
    if(status=='E')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant not-relevant-edit-button" >Existing '+client_name+' Store  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';

    if(status=='A')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-success Capture-btn edit-button" >Relevant  </button></a><span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
      
                                      style_code='';
                                      if(value.potential_status=='High')
                                        style_code='background-color:#51c82c';
                                       if(value.potential_status=='Medium')
                                        style_code='background-color:#ed8102';
                                       if(value.potential_status=='Low')
                                        style_code='background-color:#bf1414';

                        info = '<div class="media outlet-list zero'+value.refid+'"  ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3><span class="store-high" style="'+style_code+'">'+value.potential_status+'</span></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li>'+status_info+'</ul></div><div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)">Click to Navigate</span></div></div>';
                   if(("{{Auth::user()->client_id}}") == 100)
                   {
                     info +='<div class="Relevant-Store-wrapper first_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item"><a href="#"><button type="button" class="btn btn-success Capture-btn" onClick="next(\'initial_div'+value.refid+'\',0,'+value.refid+')">Relevant Store</button></a></li><li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant" onClick="notrelevant('+value.refid+',\''+value.shop_image+'\',\''+value.outlet_name+'\',\''+value.channel_name+'\',\''+value.sub_channel_name+'\',\''+value.address+'\',\''+value.lat+'\',\''+value.lon+'\')">Not Relevant Store</button></a></li></ul></div>';
                         info +='<div class="Brand-Availability-wrapper initial_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">Choose Channel type</span></li> <li class="list-group-item form-wrapper"></li>';
                        count_radio=0;

                        for(c=0;c<jjchannel.length;c++)
                        {

                            info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input channelinfo" type="radio" name="channelinfo" value="'+jjchannel[c].refid+'" id="flexRadioDefault'+count_radio+'" '+((parseInt(detail_array["channel_id"])==parseInt(jjchannel[c].refid)) ? 'checked' : '') +'>  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+jjchannel[c].name+'</label></div></li>';
                         count_radio++;
                        }
                        info +='<li ><p class="alignleft" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'second_div'+value.refid+'\',2,'+value.refid+')">Next</p></li></ul></div>';
                        info+='<div class="Brand-Availability-wrapper second_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[1]['title']+'</span></li>';
         $.each(feedback_question[1]['question'], function(k1, v1) {

            info +='<li class="list-group-item form-wrapper"><div class="form-check">  <input class="form-check-input stockinfo" type="checkbox" name="'+v1['refid']+'" value=1 id="flexRadioDefault'+count_radio+'""  '+((parseInt(detail_array[v1['refid']])==1) ? 'checked' : '') +'>  <label class="form-check-label checkbox-wrapper" for="flexRadioDefault'+count_radio+'"> '+v1['question']+' </label></div></li>';
            count_radio++;
          });
         feed=feedback_question[1]['question'];
          info +='<li ><p class="alignleft" onClick="next(\'initial_div'+value.refid+'\',0,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'third_div'+value.refid+'\',3,'+value.refid+')">Next</p></li>            </ul></div>';


         info +='<div class="top-wrapper third_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px">';
          info +='<div class="producked-stocked second_info_sub'+feed[0]['refid']+value.refid+'" style="display:none;"><ul class="list-group">';
           info +='<li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[2]['title']+'</span></li></ul><div class="bg-Product-wrappers "><ul class="list-group">';

         $.each(feedback_question[2]['question'], function(k2, v2) {  

          if(detail_array[v2['refid']]  == undefined || detail_array[v2['refid']] == null)
          detail_array[v2['refid']]="";
         

          info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input sec'+feed[0]['refid']+' productlists_1" type="checkbox" name="'+v2['refid']+'" value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(detail_array[v2['refid']])==1) ? 'checked' : '') +'><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v2['question']+'</label></div></li>';
          count_radio++;
        });
          info +='</ul></div></div>';

          info +='<div class="competition-title second_info_sub'+feed[1]['refid']+value.refid+'" style="display:none;"><div class="Competition-title"><ul class="list-group"><li class="list-group-item"><span class="Brand-Availability">'+feedback_question[3]['title']+'</span></li></ul></div><div class="bg-Product-wrappers"><ul class="list-group">';
       $.each(feedback_question[3]['question'], function(k3, v3) {  
         if(detailed_array[v3['refid']]  == undefined || detailed_array[v3['refid']] == null)
          detailed_array[v3['refid']]="";
          info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input sec'+feed[1]['refid']+' productlists_2" type="checkbox" name="'+v3['refid']+'"  value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(detailed_array[v3['refid']])==1) ? 'checked' : '') +'><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v3['question']+'</label></div></li>';
          count_radio++;
        });
       info +='</ul></div></div><div id="textbox"><ul><li><p class="alignleft" onClick="next(\'second_div'+value.refid+'\',2,'+value.refid+')">Back</p></li><li><p class="alignright" onClick="next(\'third_between_div'+value.refid+'\',6,'+value.refid+')" >Next</p></li></ul></div><div style="clear: both;"></div></div>';
       info +='<div class="Brand-Availability-wrapper third_between_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group "> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[4]['title']+'</span></li>';
                                          
       $.each(feedback_question[4]['question'], function(k4, v4) {
       
        style_color='';style_color_1='';style_color_2='';style_color_3='';style_color_4='';
        if(detail_array[v4['refid']]  === undefined)
        {
        
          detail_array[v4['refid']]="NA";
         
        }
        else
        {
             if(detail_array[v4['refid']]!="NA" || detail_array[v4['refid']]!="")
            {
              if(((detail_array[v4['refid']])==v4['option_1']))
                 style_color_1='background-color:#f26522;';
              if(((detail_array[v4['refid']])==v4['option_2']))
                  style_color_2='background-color:#f26522;';
              if(((detail_array[v4['refid']])==v4['option_3']))
                  style_color_3='background-color:#f26522;';
              if(((detail_array[v4['refid']])==v4['option_4']))
                 style_color_4='background-color:#f26522;';
            }
        }
          
        
//+value.refid
          info +='<div class="inline-wrappers jj_'+v4['parent']+'" style="display:none;"><div class="product-stocked"><ul class="list-group"><li class="list-group-item">'+v4['question']+'</li></ul></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_1']+'" style="'+style_color_1+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_1']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"> <input class="form-check-input btn-check packsize'+v4['parent']+'  pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_1" value="'+v4['option_1']+'" '+(((detail_array[v4['refid']])==v4['option_1']) ? 'checked' : '') +' > <label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_1" > 1-5 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+'  option_'+v4['parent']+value.refid+v4['option_2']+'" style="'+style_color_2+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_2']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_2"  value="'+v4['option_2']+'" '+(((detail_array[v4['refid']])==v4['option_2']) ? 'checked' : '') +' ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_2" > 5-10 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+'   option_'+v4['parent']+value.refid+v4['option_3']+'" style="'+style_color_3+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_3']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_3" value="'+v4['option_3']+'" '+(((detail_array[v4['refid']])==v4['option_3']) ? 'checked' : '') +'  ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_3" > 10-15 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+'  option_'+v4['parent']+value.refid+v4['option_4']+'" style="'+style_color_4+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_4']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'"  id="jj_'+v4['refid']+'_4" value="'+v4['option_4']+'"  '+(((detail_array[v4['refid']])==v4['option_4']) ? 'checked' : '') +'><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_4" > Above 15</label></div></div>';

          
        });
    
          info +='<li class="next-alignment"><p class="alignleft" onClick="next(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'fourth_div'+value.refid+'\',4,'+value.refid+')">Next</p></li></ul></div>';

          info +='<div class="potential-store fourth_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[5]['title']+'</span></li></ul><div class="bg-Product-wrappers"><ul class="list-group">';
    $.each(feedback_question[5]['question'], function(k5, v5) {
       if(detail_array[v5['refid']]  == undefined || detail_array[v5['refid']] == null)
          detail_array[v5['refid']]="";
         info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input potential" type="checkbox" name="'+v5['refid']+'" value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(detail_array[v5['refid']])==1) ? 'checked' : '') +'><label class="form-check-label checkbox-wrapper jj-products-stocked" for="flexRadioDefault'+count_radio+'"> <span class="jj-product-align-check-box">'+v5['question']+' </span></label></div></li>';
         count_radio++;
        });
        
         info +='</ul></div> <div id="textbox"><ul> <li><p class="alignleft" onClick="next(\'third_between_div'+value.refid+'\',6,'+value.refid+')">Back</p> </li><li><p class="alignright" onclick="next(\'final\',5,'+value.refid+')">Save</p></li></ul></div> <div style="clear: both;"></div></div></div></div>';

   }
   else
   {
      info +='<div class="Brand-Availability-wrapper first_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group "> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[6]['title']+'</span></li>';

           feedback_answer='Next';                             // Rega Need to code start
     $.each(feedback_question[6]['question'], function(k6, v6) {
      if(detail_array[v6['refid']]  == undefined || detail_array[v6['refid']] == null)
        detail_array[v6['refid']]="";
    if(v6['type']=='text')
    {
        display_code="display:none;";
        if(detail_array[v6['parent']]=="yes")
          display_code="display:block;";


        info +='<div class="inline-fwrappers showfeedback" style="'+display_code+'"><div class="product-stocked" ><ul class="list-group"><li class="list-group-item">'+v6['question']+'</li></ul></div><textarea id="jj_'+v6['parent']+'_'+value.refid+'" name="'+v6['refid']+'" rows="3" cols="30" length="60" maxlength="25">'+detail_array[v6['refid']]+'</textarea><span id="jj_'+v6['refid']+'_length"> </span></div>';
   

    }
    else
    {
      
        style_color_yes='';style_color_no='';
        if(((detail_array[v6['refid']])=="yes"))
        {
          style_color_yes='background-color:#f26522;';
          feedback_answer='Save';
        }
                 
        if(((detail_array[v6['refid']])=="no"))
        {
           style_color_no='background-color:#f26522;';
           feedback_answer='Next';
        }
                
      info +='<div class="inline-fwrappers"><div class="product-stocked"><ul class="list-group"><li class="list-group-item">'+v6['question']+'</li></ul></div><div class="form-check btn-age-select-wrapper" onClick="changestyle_radio('+v6['refid']+',\'yes\',this,\'jj_'+v6['parent']+value.refid+'\')" style="'+style_color_yes+'"> <input class="form-check-input btn-check brand_info" type="radio" name="'+v6['refid']+'" id="jj_'+v6['refid']+'_1" value="yes" '+(((detail_array[v6['refid']])=="yes") ? 'checked' : '') +' hidden> <label class="form-check-label btn-age-wrapper brandstock" for="jj_'+v6['refid']+'_1" >Yes</label></div><div class="form-check btn-age-select-wrapper" onClick="changestyle_radio('+v6['refid']+',\'no\',this,\'jj_'+v6['parent']+value.refid+'\')"" style="'+style_color_no+'"><input class="form-check-input btn-check brand_info" type="radio" name="'+v6['refid']+'" id="jj_'+v6['refid']+'_2"  value="no" '+(((detail_array[v6['refid']])=="no") ? 'checked' : '') +' hidden><label class="form-check-label btn-age-wrapper brandstock " for="jj_'+v6['refid']+'_2" > No </label></div></div>';
    }



  });


    info +='<li class="next-alignment"><p class="alignleft" onClick="mcchain(\'zero'+value.refid+'\',0,'+value.refid+')">Back</p><p class="alignright" id="shownwxtmoments" onClick="mcchain(\'second_div'+value.refid+'\',2,'+value.refid+')">'+feedback_answer+'</p></li></ul></div>';

  info +='<div class="Brand-Availability-wrapper second_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[7]['title']+'</span></li> <li class="list-group-item form-wrapper"></li>';


  $.each(feedback_question[7]['question'], function(k7, v7) {
  if(detail_array[v7['refid']]  == undefined || detail_array[v7['refid']] == null)
        detail_array[v7['refid']]="";

    info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input channelinfo" type="radio" name="channelinfo" value="'+v7['refid']+'" id="flexRadioDefault'+count_radio+'" '+((parseInt(detail_array["channel_id"])==parseInt(v7['refid'])) ? 'checked' : '') +'>  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+v7['question']+'</label></div></li>';
    count_radio++;
  });


  info +='<li ><p class="alignleft" onClick="mcchain(\'first_div'+value.refid+'\',1,'+value.refid+')">Back</p><p class="alignright" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Next</p></li></ul></div>';
  info +='<div class="top-wrapper third_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px">';
  info +='<div class="producked-stocked"><ul class="list-group">';
   info +='<li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[8]['title']+'</span></li></ul><div class="bg-Product-wrappers "><ul class="list-group">';

  $.each(feedback_question[8]['question'], function(k8, v8) {
  if(detail_array[v8['refid']]  == undefined || detail_array[v8['refid']] == null)
        detail_array[v8['refid']]="NA";


  info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input productlists_1" type="checkbox"  name="'+v8['refid']+'" value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(detailed_array[v8['refid']])==1) ? 'checked' : '') +'><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v8['question']+'</label></div></li>';
  count_radio++;
  });
  info +='</ul></div></div>';
  info +='<div class="competition-title">';
  //info +=<div class="Competition-title"><ul class="list-group"><li class="list-group-item"><span class="Brand-Availability">'+feedback_question[9]['title']+'</span></li></ul></div><div class="bg-Product-wrappers"><ul class="list-group">';
  // $.each(feedback_question[9]['question'], function(k9, v9) {  
  //     if(detail_array[v9['refid']]  == undefined || detail_array[v9['refid']] == null)
  //       detail_array[v9['refid']]="NA";

  // info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input productlists_2" type="checkbox"  name="'+v9['refid']+'"  value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(detailed_array[v9['refid']])==1) ? 'checked' : '') +'><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v9['question']+'</label></div></li>';
  // count_radio++;
  // });
  info+='</div>';
  info +='<div id="textbox"><ul><li><p class="alignleft" onClick="mcchain(\'second_div'+value.refid+'\',2,'+value.refid+')">Back</p></li><li><p class="alignright" onClick="mcchain(\'fourth_div'+value.refid+'\',4,'+value.refid+')" >Next</p></li></ul></div><div style="clear: both;"></div></div>';

  //  info +='<div class="potential-store fourth_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[10]['title']+'</span></li></ul><div class="bg-Product-wrappers"><ul class="list-group">';
  // $.each(feedback_question[10]['question'], function(k10, v10) {
  //    if(detail_array[v10['refid']]  == undefined || detail_array[v10['refid']] == null)
  //       detail_array[v10['refid']]="NA";
  //    info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input potential" type="checkbox" name="'+v10['refid']+'" value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(detailed_array[v10['refid']])==1) ? 'checked' : '') +'><label class="form-check-label checkbox-wrapper jj-products-stocked" for="flexRadioDefault'+count_radio+'"> <span class="jj-product-align-check-box">'+v10['question']+' </span></label></div></li>';
  //    count_radio++;
  //   });
    
  //    info +='</ul></div> <div id="textbox"><ul> <li><p class="alignleft" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p> </li><li><p class="alignright" onclick="mcchain(\'final\',5,'+value.refid+')">Save</p></li></ul></div> <div style="clear: both;"></div></div></div></div>';
      info +='<div class="Brand-Availability-wrapper fourth_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[10]['title']+'</span></li> <li class="list-group-item form-wrapper"></li>';
                                       

       $.each(feedback_question[10]['question'], function(k10, v10) {
        if(detail_array['freezer']  == undefined || detail_array['freezer'] == null)
         detail_array['freezer']="NA";


          info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input potential" type="radio" name="freezer" value="'+v10['refid']+'" id="flexRadioDefault'+count_radio+'" '+((parseInt(detailed_array['freezer'])==v10['refid']) ? 'checked' : '') +'>  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+v10['question']+'</label></div></li>';
          count_radio++;
      });


      info +='<li ><p class="alignleft" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p><p class="alignright" onClick="mcchain(\'final\',5,'+value.refid+')">Save</p></li></ul></div><div style="clear: both;"></div></div></div></div>';

   }
                         

                       return info;
}
function current_content(value,status,feedback_question)
{
console.log(value);
client_name="{{Auth::user()->Organization}}";
     style_code='';
    status_info='';
    circle_count='';
    count_radio=0;
   if(parseInt(value.image_count) > 0)
       circle_count='<span class="circle_count">'+value.image_count+'</span>';
    


      if(status=='R')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant not-relevant-edit-button" >Not Relevant  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
      if(status=='NF')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant not-relevant-edit-button" >Store not found  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
      if(status=='E')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant not-relevant-edit-button" >Existing '+client_name+' Store </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';


    if(status=='A')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-success Capture-btn edit-button" >Relevant  </button></a><span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';

                          style_code='';
                            if(value.potential_status=='High')
                              style_code='background-color:#51c82c';
                             if(value.potential_status=='Medium')
                              style_code='background-color:#ed8102';
                             if(value.potential_status=='Low')
                              style_code='background-color:#bf1414';
 

                        info = '<div class="media outlet-list zero'+value.refid+'"  ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3><span class="store-high" style="'+style_code+'">'+value.potential_status+'</span></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li>'+status_info+'</ul></div><div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)">Click to Navigate</span></div></div>';
                    if(("{{Auth::user()->client_id}}") == 100)
                    {
                       info +='<div class="Relevant-Store-wrapper first_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item"><a href="#"><button type="button" class="btn btn-success Capture-btn" onClick="next(\'initial_div'+value.refid+'\',0,'+value.refid+')">Relevant Store</button></a></li><li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant" onClick="notrelevant('+value.refid+',\''+value.shop_image+'\',\''+value.outlet_name+'\',\''+value.channel_name+'\',\''+value.sub_channel_name+'\',\''+value.address+'\',\''+value.lat+'\',\''+value.lon+'\')">Not Relevant Store</button></a></li></ul></div>';
                         info +='<div class="Brand-Availability-wrapper initial_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">Choose Channel type</span></li> <li class="list-group-item form-wrapper"></li>';
                         count_radio=0;
console.log(value);
                        for(c=0;c<jjchannel.length;c++)
                        {

                        

                            info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input channelinfo" type="radio" name="channelinfo" value="'+jjchannel[c].refid+'" id="flexRadioDefault'+count_radio+'" '+((parseInt(value['channel_id'])==parseInt(jjchannel[c].refid)) ? 'checked' : '') +'>  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+jjchannel[c].name+'</label></div></li>';
                         count_radio++;
                        }
                        info +='<li ><p class="alignleft" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'second_div'+value.refid+'\',2,'+value.refid+')">Next</p></li></ul></div>';

                       


        info+='<div class="Brand-Availability-wrapper second_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[1]['title']+'</span></li>';
         $.each(feedback_question[1]['question'], function(k1, v1) {



        if(value.feedback_result==undefined)
        {
             value.feedback_result={};
             value.feedback_result[v1['refid']]={ans :""};
        }
        else
        {
          if(value.feedback_result[v1['refid']]  == undefined || value.feedback_result[v1['refid']] == null)
               value.feedback_result[v1['refid']]={ans :""};
        }
           
         

            info +='<li class="list-group-item form-wrapper"><div class="form-check">  <input class="form-check-input stockinfo" type="checkbox" name="'+v1['refid']+'" value=1 id="flexRadioDefault'+count_radio+'""  '+((parseInt(value.feedback_result[v1['refid']].ans)==1) ? 'checked' : '') +'>  <label class="form-check-label checkbox-wrapper" for="flexRadioDefault'+count_radio+'"> '+v1['question']+' </label></div></li>';
            count_radio++;
          });
         feed=feedback_question[1]['question'];
          info +='<li ><p class="alignleft" onClick="next(\'initial_div'+value.refid+'\',0,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'third_div'+value.refid+'\',3,'+value.refid+')">Next</p></li>            </ul></div>';



          info +='<div class="top-wrapper third_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px">';
          info +='<div class="producked-stocked second_info_sub'+feed[0]['refid']+value.refid+'" style="display:none;"><ul class="list-group">';
           info +='<li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[2]['title']+'</span></li></ul><div class="bg-Product-wrappers "><ul class="list-group">';

         $.each(feedback_question[2]['question'], function(k2, v2) {  

          if(value.feedback_result[v2['refid']]  == undefined || value.feedback_result[v2['refid']] == null)
          value.feedback_result[v2['refid']]={ans :""};
         

          info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input sec'+feed[0]['refid']+' productlists_1" type="checkbox" name="'+v2['refid']+'" value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(value.feedback_result[v2['refid']].ans)==1) ? 'checked' : '') +'><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v2['question']+'</label></div></li>';
          count_radio++;
        });
          info +='</ul></div></div>';
          info +='<div class="competition-title second_info_sub'+feed[1]['refid']+value.refid+'" style="display:none;"><div class="Competition-title"><ul class="list-group"><li class="list-group-item"><span class="Brand-Availability">'+feedback_question[3]['title']+'</span></li></ul></div><div class="bg-Product-wrappers"><ul class="list-group">';
       $.each(feedback_question[3]['question'], function(k3, v3) {  
         if(value.feedback_result[v3['refid']]  == undefined || value.feedback_result[v3['refid']] == null)
          value.feedback_result[v3['refid']]={ans :""};
          info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input sec'+feed[1]['refid']+' productlists_2" type="checkbox" name="'+v3['refid']+'"  value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(value.feedback_result[v3['refid']].ans)==1) ? 'checked' : '') +'><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v3['question']+'</label></div></li>';
          count_radio++;
        });
       info +='</ul></div></div><div id="textbox"><ul><li><p class="alignleft" onClick="next(\'second_div'+value.refid+'\',2,'+value.refid+')">Back</p></li><li><p class="alignright" onClick="next(\'third_between_div'+value.refid+'\',6,'+value.refid+')" >Next</p></li></ul></div><div style="clear: both;"></div></div>';
      
        info +='<div class="Brand-Availability-wrapper third_between_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group "> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[4]['title']+'</span></li>';
                                          // Rega Need to code start
                                          console.log(detailed_array);
       $.each(feedback_question[4]['question'], function(k4, v4) {
       
        style_color='';style_color_1='';style_color_2='';style_color_3='';style_color_4='';
        if(value.feedback_result[v4['refid']]  === undefined)
        {
        
          value.feedback_result[v4['refid']]={ans :"NA"};
         
        }
        else
        {
             if(value.feedback_result[v4['refid']].ans!="NA" || value.feedback_result[v4['refid']].ans!="")
            {
              if(((value.feedback_result[v4['refid']].ans)==v4['option_1']))
                 style_color_1='background-color:#f26522;';
              if(((value.feedback_result[v4['refid']].ans)==v4['option_2']))
                  style_color_2='background-color:#f26522;';
              if(((value.feedback_result[v4['refid']].ans)==v4['option_3']))
                  style_color_3='background-color:#f26522;';
              if(((value.feedback_result[v4['refid']].ans)==v4['option_4']))
                 style_color_4='background-color:#f26522;';
            }
        }
          
        
//+value.refid
          info +='<div class="inline-wrappers jj_'+v4['parent']+'" style="display:none;"><div class="product-stocked"><ul class="list-group"><li class="list-group-item">'+v4['question']+'</li></ul></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_1']+'" style="'+style_color_1+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_1']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"> <input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_1" value="'+v4['option_1']+'" '+(((value.feedback_result[v4['refid']].ans)==v4['option_1']) ? 'checked' : '') +' > <label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_1" > 1-5 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option_'+v4['parent']+value.refid+v4['option_2']+'" style="'+style_color_2+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_2']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_2"  value="'+v4['option_2']+'" '+(((value.feedback_result[v4['refid']].ans)==v4['option_2']) ? 'checked' : '') +' ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_2" > 5-10 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option_'+v4['parent']+value.refid+v4['option_3']+'" style="'+style_color_3+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_3']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_3" value="'+v4['option_3']+'" '+(((value.feedback_result[v4['refid']].ans)==v4['option_3']) ? 'checked' : '') +'  ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_3" > 10-15 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option_'+v4['parent']+value.refid+v4['option_4']+'" style="'+style_color_4+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_4']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'"  id="jj_'+v4['refid']+'_4" value="'+v4['option_4']+'"  '+(((value.feedback_result[v4['refid']].ans)==v4['option_4']) ? 'checked' : '') +'><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_4" > Above 15</label></div></div>';

          
        });
     console.log(detailed_array);
          info +='<li class="next-alignment"><p class="alignleft" onClick="next(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p><p class="alignright" onClick="next(\'fourth_div'+value.refid+'\',4,'+value.refid+')">Next</p></li></ul></div>';

   info +='<div class="potential-store fourth_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[5]['title']+'</span></li></ul><div class="bg-Product-wrappers"><ul class="list-group">';
    $.each(feedback_question[5]['question'], function(k5, v5) {
       if(value.feedback_result[v5['refid']]  == undefined || value.feedback_result[v5['refid']] == null)
          value.feedback_result[v5['refid']]={ans :""};
         info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input potential" type="checkbox" name="'+v5['refid']+'" value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(value.feedback_result[v5['refid']].ans)==1) ? 'checked' : '') +'><label class="form-check-label checkbox-wrapper jj-products-stocked" for="flexRadioDefault'+count_radio+'"> <span class="jj-product-align-check-box">'+v5['question']+' </span></label></div></li>';
         count_radio++;
        });
        
         info +='</ul></div> <div id="textbox"><ul> <li><p class="alignleft" onClick="next(\'third_between_div'+value.refid+'\',6,'+value.refid+')">Back</p> </li><li><p class="alignright" onclick="next(\'final\',5,'+value.refid+')">Save</p></li></ul></div> <div style="clear: both;"></div></div></div></div>';
                    }
              else
              {
                  info +='<div class="Brand-Availability-wrapper first_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group "> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[6]['title']+'</span></li>';

                                       // Rega Need to code start
                                       feedback_answer='Next';
  $.each(feedback_question[6]['question'], function(k6, v6) {
    if(value.feedback_result==undefined)
        {
             value.feedback_result={};
             value.feedback_result[v6['refid']]={ans :""};
        }
        else
        {
          if(value.feedback_result[v6['refid']]  == undefined || value.feedback_result[v6['refid']] == null)
        value.feedback_result[v6['refid']]={ans:""};
        }
      
   
    if(v6['type']=='text')
    {
        display_code="display:none;";
        if(value.feedback_result[v6['parent']].ans=="yes")
          display_code="display:block;";

        info +='<div class="inline-fwrappers showfeedback" style="'+display_code+'"><div class="product-stocked" ><ul class="list-group"><li class="list-group-item">'+v6['question']+'</li></ul></div><textarea id="jj_'+v6['parent']+'_'+value.refid+'" name="'+v6['refid']+'" rows="3" cols="30" maxlength="25">'+value.feedback_result[v6['refid']].ans+'</textarea><span id="jj_'+v6['refid']+'_length"> </span></div>';
   

    }
    else
    {
        style_color_yes='';style_color_no='';
        if(((value.feedback_result[v6['refid']].ans)=="yes"))
        {
          feedback_answer='Save';
          style_color_yes='background-color:#f26522;';
        }
                 
        if(((value.feedback_result[v6['refid']].ans)=="no"))
        {
          feedback_answer='Next';
          style_color_no='background-color:#f26522;';
        }
                 
      info +='<div class="inline-fwrappers"><div class="product-stocked"><ul class="list-group"><li class="list-group-item">'+v6['question']+'</li></ul></div><div class="form-check btn-age-select-wrapper" onClick="changestyle_radio('+v6['refid']+',\'yes\',this,\'jj_'+v6['parent']+value.refid+'\')" style="'+style_color_yes+'"> <input class="form-check-input btn-check brand_info" type="radio" name="'+v6['refid']+'" id="jj_'+v6['refid']+'_1" value="yes" '+(((value.feedback_result[v6['refid']].ans)=="yes") ? 'checked' : '') +' hidden> <label class="form-check-label btn-age-wrapper brandstock" for="jj_'+v6['refid']+'_1" >Yes</label></div><div class="form-check btn-age-select-wrapper" onClick="changestyle_radio('+v6['refid']+',\'no\',this,\'jj_'+v6['parent']+value.refid+'\')"" style="'+style_color_no+'"><input class="form-check-input btn-check brand_info" type="radio" name="'+v6['refid']+'" id="jj_'+v6['refid']+'_2"  value="no" '+(((value.feedback_result[v6['refid']].ans)=="no") ? 'checked' : '') +' hidden><label class="form-check-label btn-age-wrapper brandstock " for="jj_'+v6['refid']+'_2" > No </label></div></div>';
    }



  });

   
    info +='<li class="next-alignment"><p class="alignleft" onClick="mcchain(\'zero'+value.refid+'\',0,'+value.refid+')">Back</p><p class="alignright" id="shownwxtmoments" onClick="mcchain(\'second_div'+value.refid+'\',2,'+value.refid+')">'+feedback_answer+'</p></li></ul></div>';

  info +='<div class="Brand-Availability-wrapper second_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[7]['title']+'</span></li> <li class="list-group-item form-wrapper"></li>';


  $.each(feedback_question[7]['question'], function(k7, v7) {
 

    info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input channelinfo" type="radio" name="channelinfo" value="'+v7['refid']+'" id="flexRadioDefault'+count_radio+'" '+((parseInt(value["channel_id"])==parseInt(v7['refid'])) ? 'checked' : '') +'>  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+v7['question']+'</label></div></li>';
    count_radio++;
  });


  info +='<li ><p class="alignleft" onClick="mcchain(\'first_div'+value.refid+'\',1,'+value.refid+')">Back</p><p class="alignright" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Next</p></li></ul></div>';
  info +='<div class="top-wrapper third_div'+value.refid+'" style="display:none;"><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul>';
  info +='<div class="producked-stocked"><ul class="list-group">';
   info +='<li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[8]['title']+'</span></li></ul><div class="bg-Product-wrappers "><ul class="list-group">';

  $.each(feedback_question[8]['question'], function(k8, v8) {
  if(value.feedback_result[v8['refid']]  == undefined || value.feedback_result[v8['refid']] == null)
        value.feedback_result[v8['refid']]={ans:"NA"};


  info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input productlists_1" type="checkbox"  name="'+v8['refid']+'" value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(value.feedback_result[v8['refid']].ans)==1) ? 'checked' : '') +'><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v8['question']+'</label></div></li>';
  count_radio++;
  });
  info +='</ul></div></div>';
  info +='<div class="competition-title">';
  // info +='<div class="Competition-title"><ul class="list-group"><li class="list-group-item"><span class="Brand-Availability">'+feedback_question[9]['title']+'</span></li></ul></div><div class="bg-Product-wrappers"><ul class="list-group">';
  // $.each(feedback_question[9]['question'], function(k9, v9) {  
  //     if(value.feedback_result[v9['refid']]  == undefined || value.feedback_result[v9['refid']] == null)
  //       value.feedback_result[v9['refid']]={ans:"NA"};

  // info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input productlists_2" type="checkbox"  name="'+v9['refid']+'"  value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(value.feedback_result[v9['refid']].ans)==1) ? 'checked' : '') +'><label class="form-check-label jj-products-stocked" for="flexRadioDefault'+count_radio+'"> &nbsp;'+v9['question']+'</label></div></li>';
  // count_radio++;
  // });
  //info +='</ul></div>';
  info +='</div><div id="textbox"><ul><li><p class="alignleft" onClick="mcchain(\'second_div'+value.refid+'\',2,'+value.refid+')">Back</p></li><li><p class="alignright" onClick="mcchain(\'fourth_div'+value.refid+'\',4,'+value.refid+')" >Next</p></li></ul></div><div style="clear: both;"></div></div>';

  //  info +='<div class="potential-store fourth_div'+value.refid+'" style="display:none;"><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group"><li class="list-group-item" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[10]['title']+'</span></li></ul><div class="bg-Product-wrappers"><ul class="list-group">';
  // $.each(feedback_question[10]['question'], function(k10, v10) {
  //    if(value.feedback_result[v10['refid']]  == undefined || value.feedback_result[v10['refid']] == null)
  //       value.feedback_result[v10['refid']]={ans:"NA"};
  //    info +='<li class="list-group-item"><div class="form-check form-check-wrapper"><input class="form-check-input potential" type="checkbox" name="'+v10['refid']+'" value=1 id="flexRadioDefault'+count_radio+'" '+((parseInt(value.feedback_result[v10['refid']].ans)==1) ? 'checked' : '') +'><label class="form-check-label checkbox-wrapper jj-products-stocked" for="flexRadioDefault'+count_radio+'"> <span class="jj-product-align-check-box">'+v10['question']+' </span></label></div></li>';
  //    count_radio++;
  //   });
    
  //    info +='</ul></div> <div id="textbox"><ul> <li><p class="alignleft" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p> </li><li><p class="alignright" onclick="mcchain(\'final\',5,'+value.refid+')">Save</p></li></ul></div> <div style="clear: both;"></div></div></div></div>';
   info +='<div class="Brand-Availability-wrapper fourth_div'+value.refid+'"  style="display:none;" ><ul class="list-group"><li class="list-group-item Brand-wrapper" id="bg-box-title"><span ><h5 class="Brand-Availability">' + value.outlet_name + '</h5></span></li></ul><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">'+feedback_question[10]['title']+'</span></li> <li class="list-group-item form-wrapper"></li>';
                             

     $.each(feedback_question[10]['question'], function(k10, v10) {
         console.log(value['freezer']);       
       if(value['freezer']  == undefined || value['freezer'] == null)
              value['freezer'] =0;


        info +='<li class="list-group-item "><div class="form-check channeltype choose-stored-type">  <input class="form-check-input potential" type="radio" name="freezer" value="'+v10['refid']+'" id="flexRadioDefault'+count_radio+'"  '+((parseInt(value['freezer'])==v10['refid']) ? 'checked' : '') +'>  <label class="form-check-label" for="flexRadioDefault'+count_radio+'">'+v10['question']+'</label></div></li>';
        count_radio++;
    });


    info +='<li ><p class="alignleft" onClick="mcchain(\'third_div'+value.refid+'\',3,'+value.refid+')">Back</p><p class="alignright" onClick="mcchain(\'final\',5,'+value.refid+')">Save</p></li></ul></div><div style="clear: both;"></div></div></div></div>';
              }

                       

                       return info;
}
function changestyle_radio(name,value_of_radio,data,class_div)
{
   
  if(("{{Auth::user()->client_id}}") == 100)
   $('.'+class_div+' > .btn-age-select-wrapper').attr("style","");
  else
  {
    $('.btn-age-select-wrapper').attr("style","");

    if(value_of_radio == "yes")
    {

     $(".showfeedback").attr("style","display:block;");
      $("#shownwxtmoments").html('Save');

    }
    else
    {
      $(".showfeedback").attr("style","display:none;");
      $("#shownwxtmoments").html('Next');
    }
  }
   
   

   // trigger_id=$('.'+class_div+' > .btn-age-select-wrapper input').attr('id');
   // selection_name=trigger_id.split("_")

  // value_of_radio=$('.'+class_div+' > .btn-age-select-wrapper input').attr('value');
  $("input[name="+name+"][value='" + value_of_radio + "']").prop('checked', true);
  if($("input[name="+name+"][value='" + value_of_radio + "']").prop('checked'))
  {
     detailed_array[name]=value_of_radio;
  }
  else
  {
    detailed_array[name]="NA";
  }

  $(data).attr("style","background-color:#f26522");


  

   return true;

}

getLocation();
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
   current_location['lat'] = position.coords.latitude;
   current_location['lon'] = position.coords.longitude;
  // console.log("Latitude: " + position.coords.latitude +
  // "<br>Longitude: " + position.coords.longitude);
}


 

    ////////////////////////////////////////////Add Outlets ////////////////////////////////////////////////////////////////////////
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Capture Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="outletid" id="store_outletid" value=""/>
              <div id="Relevant" style="padding:10px 5px 10px 5px !important;">

             

                        <button class="easy-button-button leaflet-bar-part leaflet-interactive beat-list-active Capture-btn" type="button" title="relevant-store" id="capture" onClick="next('first_info')">Relevant Store<span class="button-state state-beat-list beat-list-active"></button>
              </div>

               <div id="Not_Relevant" style="padding: 10px 5px 10px 5px !important;">


                            <button class="easy-button-button leaflet-bar-part leaflet-interactive beat-list-active Capture-btn-relevant" type="button" title="not-relevant-store" id="capture" onClick="notrelevant()">Not Relevant Store<span class="button-state state-beat-list beat-list-active"></button>
               </div>
            
            
            
            <div class="brand-menu-title">
              
                <div class="menu-bg-title first_info" style="display: none;"><span class="bg-titles">Brand Availability</span>
                
                  <div class="form-group form-check" id="bg-store">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input stockinfo" type="checkbox" name="stockinfo" value="1"> Store Stocks J&J Products
                </label>
                  </div>
                  
                   <div class="form-group form-check store-bg" id="bg-store">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input stockinfo" type="checkbox" name="stockinfo" value="2"> Store Stocks Competition Products
                </label>
                  </div>
                  
                  <div class="next-btn">
                  <span class="bg-next" onClick="next('second_info')">Next</span>
                  </div>
                  </div>
                  
                  
                  <div class="product-bg-wrapper second_info">
                  <div class="menu-bg-title j-product-title second_info_sub1" id="j-product-title"  style="display: none;"><span class="bg-titles">J&J Products Stocked</span>
                 <div class="menubar-top">
                  <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox" name="jj_product">J&J Baby Care
                </label>
                  </div>
                  
                   <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox"  name="jj_product"> J&J Fem Care
                </label>
                  </div>
                  
                   <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox" name="jj_product"> J&J OTC
                </label>
                  </div>
                  </div>
                  </div>
                  
                  
                   <div class="menu-bg-title j-product-title second_info_sub2" id="bg-align" style="display: none;"><span class="bg-titles">Competition Products Stocked</span>
                   <div class="menubar-top">
                  <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox" name="competition_product">J&J Baby Care
                </label>
                  </div>
                  
                   <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox" name="competition_product"> J&J Fem Care
                </label>
                  </div>
                  
                   <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox" name="competition_product"> J&J OTC
                </label>
                  </div>
                  </div>
                
                   
                   <div style="clear: both;"></div>
                   </div>
                    <div id="textbox">
                <p class="alignleft"> <span class="bg-next"  onClick="next('first_info')">Back </span></p>
                 <p class="alignright"><span class="bg-next" id="potential-store-show" onClick="next('third_info')">Next </span></p>
                   </div>
                  </div>
                  
                  <div class="menu-bg-title j-product-title third_info" id="show-potential" style="display: none;"><span class="bg-titles"> Potential Store for</span>
                   <div class="menubar-top">
                  <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox" value="1" name="potential"> Baby Care Outlet
                </label>
                  </div>
                  
                   <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox" value="2" name="potential"> Fem Care Outlet
                </label>
                  </div>
                  
                   <div class="form-group form-check">
                <label class="form-check-label title-checkbox">
                  <input class="form-check-input" type="checkbox" value="3" name="potential"> OTC Outlet
                </label>
                  </div>
                  </div>
                  
                  <div id="textbox">
                <p class="alignleft"> <span class="bg-next" onClick="next('second_info')">Back </span></p>
                 <p class="alignright"> <span class="bg-next" data-dismiss="modal" aria-label="Close">Close </span></p>
                   </div>
                   
                   <div style="clear: both;"></div>
                  </div>
                </div>
               </div>

            
        
           
          
            
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>  --->
      
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    $(".first_div").hide();

});
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function delete_outlet(refid,outletid)
{
 
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: 'dashboard/delete_image',
        type: 'POST',
        data: {
        'refid': refid
      },
        beforeSend: function() {
            $(".spin-loader").attr('style', 'display:block');
          },
          complete: function() {
            $(".spin-loader").attr('style', 'display:none');
          },
          error: function() {
            $(".spin-loader").attr('style', 'display:none');
          },
        success: function(data) {
          result_form = JSON.parse(data);
          if (result_form['status'] == 'success') {
            showmodal(outletid);
          } 
        },
       
      });
}
function notfound(refid,lat,lon)
{
  
   outlet_id=refid;
   $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: 'dashboard/notfoundoutlet',
      type: "POST",
      data: {
        'outlet_id': outlet_id,'lat': current_location['lat'],'lon':current_location['lon']
      },
      dataType: "json",
      success: function(response) {
        //response=JSON.parse(response);                              
        if (response['status'] == 'success') {
          $('#exampleModal').click();

             var greenIcon = L.icon({
              iconUrl: 'images/nr.png',
              iconSize: [24, 24]
            });
            info=changecontent(uncovered_outlet_detail[outlet_id],[],'NF',response['feedback_question']);
         

            showarray_uncovered[outlet_id].bindPopup(info);

            // showarray_uncovered[outlet_id].closePopup();
             showarray_uncovered[outlet_id].setIcon(greenIcon);
            
            alert("Status updated");
              initial(input_obj, 2, 9,false,true);

        } 
        else
        {
            alert("Status not updated");
            
        }
      }
    });
   return true;
}
function existing(refid,lat,lon)
{
   outlet_id=refid;
   $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: 'dashboard/existingoutlet',
      type: "POST",
      data: {
        'outlet_id': outlet_id,'lat': current_location['lat'],'lon':current_location['lon']
      },
      dataType: "json",
      success: function(response) {
        //response=JSON.parse(response);                              
        if (response['status'] == 'success') {
          $('#exampleModal').click();

             var greenIcon = L.icon({
              iconUrl: 'images/existing.png',
              iconSize: [24, 24]
            });
            info=changecontent(uncovered_outlet_detail[outlet_id],[],'E',response['feedback_question']);
         

            showarray_uncovered[outlet_id].bindPopup(info);

            // showarray_uncovered[outlet_id].closePopup();
             showarray_uncovered[outlet_id].setIcon(greenIcon);
            
            alert("Status updated");
              initial(input_obj, 2, 9,false,true);

        } 
        else
        {
            alert("Status not updated");
            
        }
      }
    });
   return true;
}
function showmodal(id)
{
  
   $("#outlet_id").val(id);
   $('#mymodal-fileupload').modal('show');
   $("#Imagelist").html("");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: 'dashboard/show_image',
        type: 'POST',
        data: {
        'outlet_id': id
      },
        success: function(data) {
          result_form = JSON.parse(data);
          if (result_form['status'] == 'success') {
            imgstr='<div class="media"><div class="upload-image"><ul>';
             for(i=0;i<result_form['outlet_list'].length;i++)
             {
                imgstr += ' <li><img src="'+result_form['outlet_list'][i]['outlet_image']+'" width="70px" height="70px"/ class="rounded"><span class="close-outer-image" onClick="delete_outlet('+result_form['outlet_list'][i]['refid']+','+result_form['outlet_list'][i]['outlet_id']+')"><sup><img src="assets/images/close.png" width="30" height="30" alt="" class=""></sup></span></li>';
             }
             imgstr +='</ul></div>';
             $("#Imagelist").html("");
             $("#Imagelist").html(imgstr);
          } 
        },
       
      });
}

$(document).ready(function() {

     $('body').bind('cut copy paste', function(event) {
     event.preventDefault();
     });
 });
</script>


<script>

    $("#div-to-toggle").click(function(e){
        $("myDiv").hide();
    });
    // $('#click-to-show').click(function (e) {
    //     if ($(e.target).attr('id') != 'close-btn') {
    //         $('#div-to-toggle').show();
    //         event.stopPropagation();
    //     }
    // });
    // $('body, #close-btn').click(function () {
    //     $('#div-to-toggle').hide();
    //   //  event.stopPropagation();
    // })
</script>

<script src="https://www.nobleui.com/laravel/template/demo1/assets/plugins/select2/select2.min.js"></script>

<script>
jquery=$.noConflict();
jquery( document ).ready(function( $ ) {
  // Code that uses jQuery's $ can follow here.
  jquery(".js-example-basic-multiple").select2();
});
// Code that uses other library's $ can follow here.
</script>
@endsection


@push('plugin-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/pbkdf2.js"></script>

<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<!-- <script src="https://www.nobleui.com/laravel/template/light/assets/js/file-upload.js"></script> -->
<!-- <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script> -->
<!-- <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script> -->

<!-- 
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> -->

<script src="{{ asset('/assets/js/dashboard.js') }}"></script>
<script src="{{ asset('/assets/js/datepicker.js') }}"></script>

<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>


@endpush