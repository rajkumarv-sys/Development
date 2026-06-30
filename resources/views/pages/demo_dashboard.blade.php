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
  color:#000 !important;
  border:none !important;
  font-style: bold;
  border-style:none !important;
  box-shadow:none !important;
  
}
.textclass_text
{
    background:transparent;
  font-size:12px;
  color:#fff !important;
  border:none !important;
  font-style: bold !important;
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
    padding: 5px 10px;
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
  
     /*display: static; */
    background: #186b57;
    color: #fff;
    border-radius: 5px;
    align-items: right; 
    justify-content: space-between;
    text-align: right;
    /* float: right; */
    font-weight: bold;
/*    text-decoration: underline;*/
}
.popup-footer {
       padding: 7px;
   display:block;
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

.legend-wraper2 {
    display: flex;
    align-items: center;
    font-size: 12px;
    color: black;
    font-weight: bold;
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
/*
input[type=checkbox] {
  display: none;
}*/

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
/*  padding: 2px 6px;*/
  border-radius: 3px;
  width: 100%;
  color: #fff;
  text-align: center;

}

.btn, .fc .fc-button, .swal2-modal .swal2-actions button, .wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions .disabled a {
  font-size: 12px;
  line-height: 1;
  padding: .5rem 1rem .4rem;
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
.square
{
    height: 15px !important;
    width: 15px !important;
    background-color: #555;
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
.align-self-start { display: block; }

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
 /*width: 25px !important;
    height: 25px !important;
    line-height: 25px !important;
    border-radius: 50% !important;
   /* font-size: 16px !important;*/
    /*color: #fff !important;
    text-align: center !important;
    background: #0f493b !important;
    padding: 6px 10px !important;*/
    /*margin: 0px 0px 0px 34px;*/
    /*font-weight: bold !important;*/
    width: 25px !important;
  height: 25px !important;
  line-height: 29px !important;
  border-radius: 50% !important;
  font-size: 16px !important;
  color: #fff !important;
  text-align: center !important;
  background: #0f493b !important;
    background-color: rgb(15, 73, 59);
  padding: 5px 11px !important;
  margin: 0px 9px 0px 0px;
  font-weight: bold !important;
  margin-bottom: 23.5px;

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
  input[type=checkbox] {
          accent-color:#f26522d9;
          width:22px;
          height:25px;
          margin-top:-2px;
    
        }
 .modal-body {
        color: #fff;
    }
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
/*    height: 80vh;*/
    overflow-y: auto;
}
    .btn6 {
        border: 1px solid rgb(0, 102, 102);
        border-radius: 5px;
        background-color: transparent;
        color: white;
        padding: auto;
        font-size: 14px;
        cursor: pointer;
        text-transform: capitalize !important;
    }

    .vtgm {
        border-color: #333737;
        color: white;
    }

    .vtgmsel {
        background-color: #aa454c;
        color: white;
    }

    .selbg {
        color: white !important;
        background-color: rgb(170, 69, 76) !important;
        border: rgb(170, 69, 76) !important;
    }

    .lnrd {
        border-top: 1px solid rgb(170, 69, 76) !important;
    }
    .selected_btn
    {
        background-color: #f26522;
    }
    .btn:hover{
        color:#fff;
        background-color: #f26522;
    }
    
   #griddata_paginate {
        position: fixed;
        bottom: 9vh;
        right: 0;
    }
    .table-responsive{
        height: -webkit-fill-available !important;
        margin-bottom: 6em;
    }
 .btn-check{
        visibility: hidden;
    }
    .channelinfo{
        accent-color: #f26522d9; 
        transform: scale(1.2);
}
.villagedistrict_listout,.talukstatelist,.zerotaluklist,.districtbeat_listout,.RD_listout,.districtsstbeat_listout,.district_taluk,.subrdbeatlist_,.sstsubrdbeatlist_,.sstbeatlist_,.rdbeatlist_,.highwaystate_list,.sstbeat_list,.district_listout{
    height: 40vh !important;
   
    overflow-y: scroll;
}
.citylistout{
    height: 40vh !important;
    width: 40vh !important;
    overflow-y: scroll;
}

</style>
<script>
    showstate='<?php echo $multiple_state;?>';
    </script>
 <div class="col-md-12" id="alertstatus_list">

                    </div>
<div class="customize-row">
    <div class="col-lg-12 col-xl-12 map-section tabcontent active" id="maptab">
        <div class="card" style="margin-bottom: 0rem !important;">
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
<div id="mymodal-state_highway" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="highwaystate_list" style="color:#fff;overflow-y: auto">

               @foreach($statehighway_list as $k=>$v) 
              <div class="form-check form-check-inline filter-data highwaystate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="highwaystate_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_highwaydetail({{$k}},'{{$v}}',this,2)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
             <div class="modal-footer" id="menu_footer">
   
                <div class="form-group">
                    <button class="btn btn-primary" name="state_highwaylist" id="state_highwaylist">Apply</button>
                </div>

            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-state_highwaylist" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State Highway</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="statehighway_list" style="color:#fff;overflow-y: auto">

              
            </div>
             <div class="modal-footer" id="menu_footer">
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_statehighway')" id="back_statehighway">Back</button>
                </div>
                <div class="form-group">

                    <button class="btn btn-primary" name="state_highwaylist" id="state_highwaylist">Apply</button>
                </div>

            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-listmenu" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menu_title">Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="menu_list" style="color:#fff;overflow-y: auto">

               
            </div>

             <div class="modal-footer" id="menu_footer">
                <div  class="modal-body " id="diagonis">
                </div>
   
                <div class="form-group">
                    <button class="btn btn-primary" name="show_result" id="showmenu_result">Apply</button>
                </div>

            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-subordinate" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose SO </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="subordinatelist" style="color:#fff; overflow-y: auto;">



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

<div id="mymodal-beat" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="beat_city_name">Choose Beat </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="beatlist" style="color:#fff;overflow-y: auto;">

                @for ($i = 0; $i < count($beat_list); $i++) <div class="form-check form-check-inline filter-data">
                    <a href="#" style="color:white;"> <label class="form-check-label" style="text-decoration: underline">
                        <input type="checkbox" class="form-check-input show_beat" name="beat" value="{{$beat_list[$i]->id}}">
                        <a href="#"  style="color:white;" >{{$beat_list[$i]->beat_name}}</a>
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label></a>
            </div>
        
            @endfor
           
            




        </div><!-- /.modal-content -->
 <div class="modal-footer">
    <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_beatcity')" id="back_city">Back</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_beat" id="filter_bybeat">Apply</button>
                </div>
            </div>

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<div id="mymodal-image" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Outlet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" style="overflow-y: auto">

                <div id="imageview">
                </div>

            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div id="mymodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Locality Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" style="overflow-y: auto">

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
            <div class="modal-body" style="overflow-y: auto">
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
            <div class="modal-body" id="dropdown" style="overflow-y: auto">


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
            <div class="modal-body" id="channel_filter" style="color:#fff;overflow-y: auto">
               <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                @php
                if((Auth::user()->client_id)!=115)
                {
                    @endphp
                <li class="nav-item">                	
                    <a class="nav-link active" id="home-line-tab-0" data-toggle="tab" href="#home-0" role="tab" aria-controls="home-0" onclick="openCity1(event, 'home-line-tab-0')" aria-selected="true">Outlets</a>
                  </li>
                   @php
               }
                    @endphp
                  <li class="nav-item">
                    <a class="nav-link active" id="home-line-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" onclick="openCity1(event, 'home-line-tab')" aria-selected="true">Channel</a>
                  </li>
                   @php
                if((Auth::user()->client_id)!=115 && (Auth::user()->client_id)!=100)
                {
                    @endphp
                  <li class="nav-item">
                    <a class="nav-link" id="profile-line-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" onclick="openCity1(event, 'profile-line-tab')" aria-selected="false">Potential</a>
                  </li>
                   @php
               }
                    @endphp
                    <li class="nav-item">
                    <a class="nav-link" id="status-line-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" onclick="openCity1(event, 'status-line-tab')" aria-selected="false">Status</a>
                  </li>
                   @php
                if((Auth::user()->client_id)==15)
                {
                    @endphp
                <li class="nav-item">                   
                    <a class="nav-link active" id="revenue-line-tab" data-toggle="tab" href="#revenue" role="tab" aria-controls="revenue" onclick="openCity1(event, 'revenue-line-tab')" aria-selected="true">Revenue</a>
                  </li>
                   @php
               }
                    @endphp
                 
                </ul>
                <div class="col-md-12 grid-margin">
                <div class="tab-content mt-3" id="lineTabContent">
                     @php
                    if((Auth::user()->client_id)!=115 ){
                    @endphp
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
                               @php
                    }
                    @endphp
                  <div class="tab-pane" id="home-line-tab" role="tabpanel" aria-labelledby="home-line-tab">
                   
                     
                       @for ($i = 0; $i < count($channel_list); $i++)                        
                       <div class="form-check form-check-inline filter-data-0 type_id{{$channel_list[$i]->data_type}}">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="channellist_" name="tag_list" data_type="{{$channel_list[$i]->data_type}}" value="{{$channel_list[$i]->maintype_id}}" checked/>
                        @php
                        
                      @endphp

                         &nbsp;{{$channel_list[$i]->main_type}}
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                    @endfor

                      
                   
                  <!--     <select class="form-control form-control-sm mb-3" id="channellist" name="tag_list" > -->
                       
               
            </div>
             <div class="tab-pane" id="revenue-line-tab" role="tabpanel" aria-labelledby="revenue-line-tab">
                   
                     
                       @foreach($revenue_list as $k=>$v)                     
                       <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="revenuelist_" name="revenue_list"  value="{{$k}}" checked/>
                       

                         &nbsp;{{$v}}
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                    @endforeach

                      
                   
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
                   @php
          if((Auth::user()->client_id)==0){
          @endphp
                <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="potentiallist_" name="potentiallist" value="0" checked/>
                         &nbsp;NA
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
          @php
      }
      @endphp
                  
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
                    <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="statuslist_" name="statuslist" value="U" checked/>
                         &nbsp;Under Coverage
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
                   <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="statuslist_" name="statuslist" value="NR" checked/>
                         &nbsp;Selling Non-Nestle Categories
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
            <div class="form-group" style="float:left;">
                       
                        <button class="btn btn-primary" type="button" onclick="clearfilter()">Clear Filter</button>
                         
                    </div>
                    <div class="form-group">
                       
                        <button class="btn btn-primary" type="button" onclick="filter_bychannel()">Apply</button>
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
            </div>

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
   
</div>

<div id="mymodal-villagemap_state" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="villagemapstate_list" style="color:#fff;overflow-y: auto">

               @foreach($village_state_list as $k=>$v) 
              <div class="form-check form-check-inline filter-data villagemapstate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="village_state_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_villagedistrictdetail({{$k}},'{{$v}}',this)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<div id="mymodal-villagetaluk" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="villagedistrict_head">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body villagedistrict_taluk" id="villagetaluklist" style="color:#fff;display:block;overflow-y: auto">
              

             
        
          </div>
         


            <div class="modal-footer">
                
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_villagetalukdistrict')" id="back_state">Back</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_taluk" id="filter_byvillagetaluk">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<div id="mymodal-villagedistrict" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" style="overflow:visible !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="villagedistrict_title">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
<div class="modal-body villagedistrict_listout" id="villagedistrictlist" style="color:#fff;min-height: 5rem !important;overflow-y: auto !important;"  >
    
</div>
  
                    
            <div class="modal-footer">

                 @php
   if($multiple_state)
   {
@endphp
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_villagestate')" id="back_state">Back</button>
                </div>
    @php
}
@endphp
               
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_villagedist" id="filter_byvillagedist">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-taluk_state" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body talukstatelist" id="talukstate_list" style="color:#fff;overflow-y: auto">

               @foreach($taluk_list as $k=>$v) 
              <div class="form-check form-check-inline filter-data talukstate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="talukstate_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_districtdetail({{$k}},'{{$v}}',this)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-taluk_state_wholesaler" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body talukstatelist" id="talukstate_list" style="color:#fff;overflow-y: auto">

               @foreach($whole_sale_taluk_list as $k=>$v) 
              <div class="form-check form-check-inline filter-data talukstate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="talukstate_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_districtdetail({{$k}},'{{$v}}',this)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-taluk_state_zerorla" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body zerotaluklist" id="zerotalukstate_list" style="color:#fff;overflow-y: auto">

               @foreach($zero_taluk_list as $k=>$v) 
              <div class="form-check form-check-inline filter-data talukstate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="zerotalukstate_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_zerodistrictdetail({{$k}},'{{$v}}',this)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-country_data" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="country_level_view">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="country_data_list" style="color:#fff;overflow-y: auto">
           

            </div>
           <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
               
                 <div class="form-group" style="float:left;" id="country_back">
                    <button class="btn btn-primary" onClick="" id="back_country">Back</button>
                </div>
                
                <div class="form-group" id="country_filter">
                    <button class="btn btn-primary" name="filter_dist" id="filter_bycountrydata">Apply</button>
                </div>
            </div>





        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<div id="mymodal-beat_state" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="beatstate_list" style="color:#fff;overflow-y: auto">

               @foreach($subrd_beat as $k=>$v) 
              <div class="form-check form-check-inline filter-data beatstate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="beatstate_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_beatdistrictdetail({{$k}},'{{$v}}',this)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@php
if((Auth::user()->client_id)==120 && (Auth::user()->login_type_mdlz)=='Urban'  )
{
@endphp
<div class="modal fade bd-example-modal-md" id="prdSelect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modhead modshadow">

            <div class="modal-header bgred" style="position:sticky;visible:true;top:0 !important;z-index:1000 !important">
                <h5 class="modal-title" id="myModalLabel" style="filter: drop-shadow(0.35rem 0.35rem 0.4rem rgba(0, 0, 0, 0.5));"><strong>Period Selection</strong>&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-calendar-alt'></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body container-fluid mb-3">
                <label class="headfont row col my-3" style="filter: drop-shadow(0.35rem 0.35rem 0.4rem rgba(0, 0, 0, 0.5));">
                    <h5 style="text-decoration:underline;"><b>Select Type & Periodicity </b></h5>
                </label>
                <div class="row">
                    
                    @foreach($calendar['timeline'] as $k=>$v) 
                    <div class="col">
                        <select id="{{$v['refid']}}_viewcalendar" class="calyr2 form-select rounded type2-group calendar_list" style="background-color:grey;color:white;" aria-label="{{$v['name']}}" onchange="call_viewcalendar({{$v['refid']}})">
                             <option class="text-white" value="calde" style="background-color:white;color:black !important;" selected disabled>{{$v['name']}}</option>
                            @foreach($calendar['period_type'] as $key=>$value)
                           
                            <option class="text-white" value="{{$value['refid']}}" id="single" style="background-color:white;color:black !important;"><button id="single" alt="single" class=" bycalyr-btn2 btn btn-primary" style="border-radius:60px;" onClick="setperiod(1,'')">{{$value['name']}}</button> </option>

                            @endforeach
                        </select>
                         <span id="calyrbdg" class="badge bg-secondary"></span>
                    </div>
                     @endforeach
                       
                
                </div>
            </div>
               <div class="modal-body" style="display:block;text-align: center">

                <div class="blk_calendar_1" style="display:block;text-align: left">
                    <div class="row">
                        <div class="col-4"> <label style="filter: drop-shadow(0.35rem 0.35rem 0.4rem rgba(0, 0, 0, 0.5));"><b>Select Year :</b></label></div>
                        <div class="col-6">
                            <select class="form-select rounded" name="calendar_1[]" id="calendar_1" aria-label="Default select example">
                                <option value=''> Year</option>
                            </select>
                        </div>
                    </div>
                </div>
                 <div class="blk_calendar_2" style="display:none;text-align: left;margin-top:5px">
                    <div class="row">
                        <div class="col-4"> <label style="filter: drop-shadow(0.35rem 0.35rem 0.4rem rgba(0, 0, 0, 0.5));"><b>Select Year :</b></label></div>
                        <div class="col-6">
                            <select class="form-select rounded" id="calendar_2" aria-label="Default select example">
                                <option value=''> Year</option>
                            </select>
                        </div>
                    </div>
                </div>
                  <div class="blk_calendar_3" style="display:none;text-align: left;margin-top:5px">
                    <div class="row">
                        <div class="col-4"> <label style="filter: drop-shadow(0.35rem 0.35rem 0.4rem rgba(0, 0, 0, 0.5));"><b>Select Year :</b></label></div>
                        <div class="col-6">
                            <select class="js-example-basic-multiple"  name="calendar_3[]" multiple="multiple" id="calendar_3" aria-label="Default select example">
                                <option value=''> Year</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
            </div>


             <div class="modal-body calyr2-div" style="line-height: 50px;display:flex;flex-wrap:wrap;margin:10px;">

             @foreach($calendar['view_type'] as $k=>$v)

                <div class="col-4 text-center view_type" style="margin-top: 10px;">
                  
                    <button id="btn-cum_{{$v['refid']}}" type="button" class="btn btn6 vtgm btn-block btn_list" onClick="call_viewcalendar(0,{{$v['refid']}},this)">{{$v['name']}}</button>
                </div>
             @endforeach
              
            </div> 
            <div class="modal-footer lnrd">
                <button type="button" class="btn" style="background-color:#f26522;color:white;text-transform:capitalize;" onclick="calendar_apply()">Apply</button>
                <button type="button" class="btn" data-dismiss="modal" style="background-color:#f26522;color:white;text-transform:capitalize;">Close</button>
                <!-- <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button id="" class="btn btn-primary">Apply</button> -->
            </div>

        </div>


    </div>
</div>
@php
}
@endphp

<div id="mymodal-city_RD" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
  

            <div class="modal-body citylistout" id="city_list" style="color:#fff;overflow-y: auto">
  
               @foreach($city_master as $k=>$v) 
              <div class="form-check form-check-inline filter-data citylist">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="city_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_RD('{{$k}}','{{addslashes($v)}}',this,show_cluster[1])"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>

            @endforeach
           
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<div id="mymodal-city_delhi" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
   

            <div class="modal-body citylistout" id="city_list" style="color:#fff;overflow-y: auto">
  
               @foreach($city_list[2] as $k=>$v) 
              <div class="form-check form-check-inline filter-data citylist">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="city_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_nbhrd('{{$k}}','{{addslashes($v)}}',this,2)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>

            @endforeach
           
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<div id="mymodal-city_remain" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
  

            <div class="modal-body citylistout" id="city_list" style="color:#fff;overflow-y: auto">
  
               @foreach($city_list[3] as $k=>$v) 
              <div class="form-check form-check-inline filter-data citylist">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="city_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_nbhrd('{{$k}}','{{addslashes($v)}}',this,3)"> {{$v}}</input>
                        
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>

            @endforeach
           
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-SST_beat_state" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="sstbeatstate_list" style="color:#fff;overflow-y: auto">

               @foreach($sst_beat as $k=>$v) 
              <div class="form-check form-check-inline filter-data sstbeatstate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="sstbeatstate_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_sstbeatdistrictdetail({{$k}},'{{$v}}',this)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@php
$state=[];
@endphp

@php
$state=[];
@endphp
<div id="mymodal-beatdistrict" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" style="overflow:visible !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="beatdistrict_title">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body districtbeat_listout" id="districtlistbeat" style="color:#fff;overflow-y: auto">

            </div>
           
                    
            <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
                 @php
               if($multiple_state)
               {
            @endphp
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_beatstate')" id="back_state">Back</button>
                </div>
                    @php
                }
                @endphp
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_dist" id="filter_bybeatdist">Apply</button>
                </div>
            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-RD_list" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="title" id="uncovered_title">Select RD. / Drill down into Beat.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body RD_listout" id="rdlistbeat" style="color:#fff;overflow-y: auto">

            </div>
           
                    
            <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_RDcity')" id="back_rdcity">Back</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_RD" id="filter_byRD">Apply</button>
                </div>
            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-nbhrd_list" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="title" id="nbhrd_title">Select RD. / Drill down into Beat.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body nbhrd_listout" id="nbhrd_list" style="color:#fff;overflow-y: auto">

            </div>
           
                    
            <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_nbhrd')"  id="back_nbhrd">Back</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_nbhrd" id="filter_bynbhrd">Apply</button>
                </div>
            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-sstbeatdistrict" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" style="overflow:visible !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="sstbeatdistrict_title">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body districtsstbeat_listout" id="districtlistsstbeat" style="color:#fff;overflow-y: auto">

            </div>
           
                    
            <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
                 @php
               if($multiple_state)
               {
            @endphp
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_sstbeatstate')" id="back_state">Back</button>
                </div>
                    @php
                }
                @endphp
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_dist" id="filter_bysstbeatdist">Apply</button>
                </div>
            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-taluk" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="district_head">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body district_taluk" id="taluklist" style="color:#fff;display:block;overflow-y: auto">
              

             
        
          </div>
         


            <div class="modal-footer">
                
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_talukdistrict')" id="back_state">Back</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_taluk" id="filter_bytaluk">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-taluk_zerorla" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="district_head">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body district_taluk" id="zerotaluklist" style="color:#fff;display:block;overflow-y: auto">
              

             
        
          </div>
         


            <div class="modal-footer">
                
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_zerotalukdistrict')" id="back_state">Back</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="zerofilter_taluk" id="zerofilter_bytaluk">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-subrdbeat" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose SubRD </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body subrdbeatlist_" id="subrdbeatlist" style="color:#fff;overflow-y: auto">

      </div>
       
            <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
                 @php
               if($multiple_state)
               {
            @endphp
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_beatdistrict')" id="back_state">Back</button>
                </div>
                    @php
                }
                @endphp
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_subrdbeat" id="filter_bysubrdbeat">Apply</button>
                </div>
            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-sstsubrdbeat" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose SST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body sstsubrdbeatlist_" id="sstsubrdbeatlist" style="color:#fff;overflow-y: auto">

      </div>
       
            <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
                 @php
               if($multiple_state)
               {
            @endphp
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_sstbeatdistrict')" id="back_state">Back</button>
                </div>
                    @php
                }
                @endphp
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_sstsubrdbeat" id="filter_bysstsubrdbeat">Apply</button>
                </div>
            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-sst_list" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose SST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body sstbeatlist_" id="sstlist" style="color:#fff;overflow-y: auto">

      </div>
       
            <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
                 @php
               if($multiple_state)
               {
            @endphp
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_sststate')" id="back_state">Back</button>
                </div>
                    @php
                }
                @endphp
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_sstsubrdbeat" id="filter_bysstbeat">Apply</button>
                </div>
            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-rdbeat" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Beat </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body rdbeatlist_" id="rdbeatlist" style="color:#fff;overflow-y: auto">

      </div>
       
            <div class="modal-footer" style="position: -webkit-sticky;position: sticky;top: 0;">
                
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_rdbeat')" id="back_rdbeat">Back</button>
                </div>
                   
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_rdbeat" id="filter_byrdbeat">Apply</button>
                </div>
            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-district" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" style="overflow:visible !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="district_title">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
<div class="modal-body district_listout" id="districtlist" style="color:#fff;min-height: 5rem !important;overflow-y: auto !important;"  >
    
</div>
  
                    
            <div class="modal-footer">

                 @php
   if($multiple_state)
   {
@endphp
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_taluk')" id="back_state">Back</button>
                </div>
    @php
}
@endphp
               
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_dist" id="filter_bydist">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-consolidatedistrict" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="consolidatedistrict_title">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
<div class="modal-body district_listout" id="consolidatedistrictlist" style="color:#fff;min-height: 5rem !important;overflow-y: auto !important;"  >
    
</div>
  
                    
            <div class="modal-footer">

                 @php
   if($multiple_state)
   {
@endphp
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_consolidatestate')" id="back_state">Back</button>
                </div>
    @php
}
@endphp
               
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_dist" id="filter_byconsolidatedist">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-consolidate_taluk_state" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="talukstate_list" style="color:#fff;overflow-y: auto">

               @foreach($consolidate_taluk_list as $k=>$v) 
              <div class="form-check form-check-inline filter-data consolidatestate_list">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="consolidatestate_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_consolidate_districtdetail({{$k}},'{{$v}}',this)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-consolidatetaluk" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="consolidatedistrict_title">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
<div class="modal-body district_listout" id="consolidate_taluk_list" style="color:#fff;min-height: 5rem !important;overflow-y: auto !important;"  >
    
</div>
  
                    
            <div class="modal-footer">

                 @php
   if($multiple_state)
   {
@endphp
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_consolidatetaluk')" id="back_state">Back</button>
                </div>
    @php
}
@endphp
               
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_dist" id="filter_byconsolidatetaluk">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-district_zerorla" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" style="overflow:visible !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="zerodistrict_title">Select distt. / Drill down into Sub-distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
<div class="modal-body district_listout" id="zerodistrictlist" style="color:#fff;min-height: 5rem !important;overflow-y: auto !important;"  >
    
</div>
  
                    
            <div class="modal-footer">

                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_zerotaluk')" id="back_state">Back</button>
                </div>
     
                <div class="form-group">
                    <button class="btn btn-primary" name="zerofilter_dist" id="zerofilter_bydist">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-highway_state" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body highwaystate_list" id="highwaystate_list" style="color:#fff;overflow-y: auto">

               @foreach($highway_list as $k=>$v) 
              <div class="form-check form-check-inline filter-data highwaystate">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="highwaystate_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_highwaydetail({{$k}},'{{$v}}',this,1)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-sst_state_beat" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body sstbeat_list" id="sstbeat_list" style="color:#fff;overflow-y: auto">

               @foreach($sst_state_beat as $k=>$v) 
              <div class="form-check form-check-inline filter-data sstbeatlist">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="sstbeat_list" value="{{$k}}" class="show_subordinate" hidden="true" onClick="show_sstbeat({{$k}},'{{$v}}',this,1)"> {{$v}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endforeach
            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-citylist" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="location_title">List of City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body citylistout" id="citylist" style="color:#fff;overflow-y: auto">
@php
$result=DB::table('city_master')->select('refid','location_name')->whereIn('refid',[13346,15278,786])->orderBy("location_name","ASC")->get();
$count_=count($result);

@endphp
@foreach($result as $k=>$v) 
                <div class="form-check form-check-inline filter-data menulist">
                   
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="list_city" value="{{$v->refid}}"  class="show_subordinate" hidden="true" onClick="show_result(this)">{{$v->location_name}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>@endforeach
            </div>
             <div class="modal-footer" id="menu_footer">
   
                <div class="form-group">
                    <button class="btn btn-primary" name="show_result" id="showmenu_result">Apply</button>
                </div>

            </div>
           




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-highway" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="highway_title">Select Assigned Highway(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

 
            <div class="modal-body highway_listout" id="highwaylist" style="color:#fff;overflow-y: auto">
              
          </div>
           
            
            <div class="modal-footer">
   @php
   if($multiple_state)
   {
@endphp
                 <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_state')" id="back_state">Back</button>
                </div>
    @php
}
@endphp
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_byhighway" id="filter_byhighway">Apply</button>
                </div>
            </div>
 </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-village" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
             <p>
                <h4 class="modal-title" style="color:rgb(206,86,29);" id="village_name">Bairi Dariyon Villg.&nbsp;</h4><p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body p-2"  style="color:#fff;overflow-y: auto">
            <div class="row" style="font-weight: bold;"> 
              <div class="col-sm-6">
                <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Cluster ID</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="cluster_id" name="fname" value="Cluster 1763" readonly></span></div>
                <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">State</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="state_name" name="fname" value="Cluster 1763" readonly></span></div>
                 <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Distt</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="district_name" name="fname" value="Cluster 1763" readonly></span></div>
                <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Sub-Distt </label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="sub_distt_name" name="fname" value="Cluster 1763" readonly></span></div>
                 <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Town / Villg </label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="town_village_name" name="fname" value="Cluster 1763" readonly></span></div>
                  <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Market UID</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="market_uid" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                   <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">BI Locatn ID</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="bi_id" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                   <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Villg Census</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="village_census" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                    <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Distance from Recmmd SubRD / Wholesale Locatn (Km)</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="distance" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                     <!-- <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Recommndd SubRD / Wholesale Location</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="recommand_subrd" name="fname" value="Cluster 1763"></span></div> -->
                      <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Outlet potential</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="outlet_potential" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                       <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Population 2021</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="pop_2021" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                        <!-- <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Taluk Census</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="taluk_census" name="fname" value="Cluster 1763"></span></div> -->
                        

                          <!-- <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Village Chocolate Consmptn (Rs.)</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="consmptn" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div> -->
                           <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Catgry Consmptn (Rs.)</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="consmptn" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                           <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Cluster Tag</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="cluster_tag" name="fname" value="Cluster 1763" readonly></span></div>
                            <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">SubRD Priority</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="sub_priority" name="fname" value="Cluster 1763" readonly></span></div>
                             <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">SubRD Cluster Priority</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="subd_priority" name="fname" value="Cluster 1763" readonly></span></div>
                              
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

 <div id="mymodal-fileupload" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

   
   
      <form action="{{url('/outlet/store')}}" id="outlet_image" method="post" enctype="multipart/form-data">
      <div class="modal-body" style="overflow-y: auto">
        <div class='form-control-lg'>

           
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-12" id="alertstatus_1">
                 </div>
        <div class="outlet-image">
      <h6><span class="outlet-image-heading"><i>Important</i></span></h6>
         <div class="Important-title">
         <p class="outlet-content"><i>1. Open your camera's settings</i></p>
         <p class="outlet-content"><i>2. Turn on Location tags before capturing the photo</i></p>
           </div>
       </div>
    
             


            
              <div class="form-group">
                 

                  <input type="hidden" class="form-control" id="outlet_id" name="outlet_id" placeholder="Outlet ID">

                </div>



              <div class="col-md-12 grid-margin">

                <div class="form-group">
                  <label>File upload</label>
                  <input type="file" name="img[]"  capture="environment"  class="file-upload-default" accept="image/*" multiple="true">
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
             @php
                if((Auth::user()->client_id)==115)
                {
                    @endphp
                    <button class="btn btn-primary upload-Store-Photos" type="submit">Upload Photo(s)</button>
            @php
        }
            else
            {
                @endphp
            <button class="btn btn-primary upload-Store-Photos" type="submit">Upload Store Photo(s)</button>
            @php
        }
        @endphp
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
     var showpop_temp=[];
var show_cluster=[];

  var menu_list=[];
    var location_list=[];
   var history_map=[];
   var current_maplevel=[];



var initiated=[];
var activated=[];
var active=[];
var inactive=[];
var deactivated=[];
var rpi_layer=[];
var recomand_subrd=[];
var exist_subrd=[];
var whole_subrd=[];
var urban_subrd=[];
var villg_distributor=[];
var villg_subd=[];
var circle_distributor=[];
var circle_subd=[];
dynamic_control['rpi_action']=[];
 dynamic_control['rpi_action_1']=[];
var rpi_tooltip=[];
var rpi_show_hide=true;
var subrd_popup=[];
var rpi_popup=[];
var active_popup=[];
var calendar_data={};
var villg_subrd;
var filterid=[];


var active_layer,initiated_layer,activated_layer,inactive_layer,deactivated_layer,recomand_subrd_layer,exist_subrd_layer,whole_subrd_layer,urban_subrd_layer,villg_distributor_layer,villg_subd_layer,circle_distributor_layer,circle_subd_layer;


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
     var uncovered_markercluster_mdlz = new L.MarkerClusterGroup({ 
          iconCreateFunction: function (cluster) {
              var markers = cluster.getAllChildMarkers();
            if(("{{Auth::user()->client_id}}")==120)
              var html = '<div class="covered_circle" style="border: 2px solid #502172;background-color:#502172 !important;">  <div class="inner_covered" style="background-color:#502172 !important;">' + markers.length + '</div></div>';

               if(("{{Auth::user()->client_id}}")!=120)
                  var html = '<div class="covered_circle" style="border: 2px solid #0475ff;background-color:#0475ff !important;">  <div class="inner_covered" style="background-color:#0475ff !important;">' + markers.length + '</div></div>';
              return L.divIcon({ html: html, className: 'mycluster', iconSize: L.point(32, 32) });
          },
          spiderfyOnMaxZoom: true, showCoverageOnHover: true, zoomToBoundsOnClick: true 
      });
      
      




    ////////////////////////////////////////Declaration///////////////////////////////////////////////////////

    /////////////////////////////////////////////Map section /////////////////////////////////////////////////////////////


    // var map = L.map('map', {
   
    //     zoomControl: false,
    //     zoomSnap: 0.25,
    //     maxZoom: 25,
    //      contextmenu: true,  
    //         contextmenuItems: [
    //         {
    //             text: 'Show Direction',
    //             //icon: 'images/zoom-out.png',
    //             callback: direction

    //         }],
    // }).setView([23.473324, 77.947998], 5);
if(("{{Auth::user()->user_type}}") == 'TSM' && (("{{Auth::user()->client_id}}")==120))
    item=[
        {
                text: 'Whats here?',
                icon: 'images/i.png',
                callback: find_recommadation

            },
            {
                text: 'Show Direction',
                icon: 'images/navigation.png',

                callback: direction

            }
            ];
else
     item=[
            {
                text: 'Show Direction',
                //icon: 'images/zoom-out.png',
                callback: direction

            }];

 if(("{{Auth::user()->role}}") != 'Country-HO')
        coordinate=[23.473324, 77.947998,5];
    else
            coordinate=[47.2650611121747, 58.437662078181965,2];
 
    var map = L.map('map', {
   
        zoomControl: false,
        zoomSnap: 0.25,
        maxZoom: 25,
         contextmenu: true,  
            contextmenuItems: item,
    }).setView([coordinate[0],coordinate[1]], coordinate[2]);

L.control.zoom({
     position:'bottomright'
}).addTo(map);

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

    //     $.each(layer_bound, function(k, v) {

    //         layer = v;

    //         if (v !== undefined) {
    //             if (bound_type[k] == 1) {
    //                 if (layer.feature.id !== undefined)
    //                     layer.setStyle({
    //                         weight: (zoomrange >= 16) ? 5 : 0.5,
    //                         stroke: (zoomrange >= 16) ? 5 : 0.5,
    //                     });
    //             }
    //             if (bound_type[k] == 2) {
    //                 for (i = 0; i < v.length; i++) {
    //                     layer = v[i].layer_id;
    //                     if (layer !== undefined) {

    //                         if (layer.feature.id !== undefined)
    //                             layer.setStyle({
    //                                 weight: (zoomrange >= 16) ? 5 : 0.5,
    //                                 stroke: (zoomrange >= 16) ? 5 : 0.5,
    //                             });
    //                     }

    //                 }

    //             }
    //         }
    //     });


      

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

if(zoomrange>=10)       
         {   if(rpi_tooltip.length>0 && rpi_show_hide==true)
                  if(!map.hasLayer(dynamic_control["rpi_tool"]))
                    dynamic_control["rpi_tool"].addTo(map);
                }
       
    else{
       if(rpi_tooltip.length>0)
        {
            
             dynamic_control["rpi_tool"].remove(map);
        }
      }   

    });
function searchoutlet(e)
{
   alert();
}
function view_village_detail(data)
{
 if(data[0].cluster_name=='')
 {
    $("#cluster_id").prop("disabled",true);
    $("#sub_priority").prop("disabled",true);

    $("#subd_priority").prop("disabled",true);

    $("#cluster_tag").prop("disabled",true);

 }
 else
 {
     $("#cluster_id").prop("disabled",false);
    $("#sub_priority").prop("disabled",false);

    $("#subd_priority").prop("disabled",false);

    $("#cluster_tag").prop("disabled",false);

 }

  $("#village_name").html(data[0].village_name +'<img class="ml-2 float-right"  src="icons/navigation-icon.png" height="30px" id="navigation_popup" geocode="'+data[0]['latitude']+','+data[0]['longitude']+'" onClick=location_navigate_popup(this)>');
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
  $("#village_census").val(data[0].village_census);
  $("#consmptn").val(data[0].village_choc_consmptn);
  $("#cluster_tag").val(data[0].subrd_loaction);
  $("#sub_priority").val(data[0].subrd_priority);
   $("#subd_priority").val(data[0].subrd_priority);
   $("#showmap").click();
  // $("#navigation_popup").attr("geocode",data[0]['latitude']+','+data[0]['longitude']);
   
    $('#mymodal-village').modal('show'); 
  // $("#navigation_popup").attr("onClick",location_navigate_popup(this));

}
$("#navigation").click(function(){
   
          getLocation();
          
         
         clicked_shop_location=$(this).attr("geocode");
       //  console.log(clicked_shop_location);
         shop_location=clicked_shop_location.split(",");

         shop_lat=shop_location[0];
         shop_lon=shop_location[1];     
       
         
         str = "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + shop_lat + "," + shop_lon + "'/";
         window.open(str, 'window name', 'window settings');
});
function show_result_popup(district_id,result_type,location_name='',loc7=0){
    if(result_type==1 || result_type==2)//Exist subrd, Recommand subrd
    {
         input_obj = {
                        'type': 12,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_district':[district_id],
                        'type_view':(result_type==1) ? '1,2' : ((result_type==2) ? '3' : 0)
                        
                        };
         initial(input_obj, 0,12, '');
            
     }     
     if(result_type==3) //subrd_beat
     {
       
         ajax_action(loc7,location_name,'Getsubrd_district',[district_id]);
          ajax_action(district_id,location_name,'Getsubrd_subrd');
        
     }
      if(result_type==4) //highway
     {
        if(district_id != '0')
          { 
             highwaylist=JSON.parse(district_id);
             str ='';
             for(i=0;i<highwaylist.length;i++)
             {
                 str +='<div class="form-check form-check-inline filter-data" id="checkchng" ><a href="#" style="color:white;"><input type="checkbox" class="form-check-input"  name="highwaylist" value="'+highwaylist[i].id+'"/><a href="#" id="'+highwaylist[i].id+'" style="color:white;">'+highwaylist[i].highway_name+' ('+highwaylist[i].distance+' Kms.)</a><i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></a></div>';
             }
              $("#highway_title").html('Select Highway(s) based on distance from your current location');
             
              $('#mymodal-highway').modal('show'); 
              $('#highwaylist').html(str);

          }
        else
            alert("No Highways");
     }

          
    
}
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
function back(name,id)
{
     if(name=='back_state')
     {
        $('#mymodal-highway').modal('hide'); 
        $('#mymodal-highway_state').modal('show');
     }
     if(name=='back_taluk')
     {
        $('#mymodal-district').modal('hide'); 
        if(type_view[0]==3)        
         $('#mymodal-taluk_state_wholesaler').modal('show');
         else
            $('#mymodal-taluk_state').modal('show');

     }
     if(name=='back_beatstate')
     {
        $('#mymodal-beatdistrict').modal('hide'); 
        $('#mymodal-beat_state').modal('show');
     }
     if(name=='back_beatdistrict')
     {
        $('#mymodal-subrdbeat').modal('hide');
        $('#mymodal-beatdistrict').modal('show'); 
        
     }
      if(name=='back_zerotaluk')
     {
        $('#mymodal-district_zerorla').modal('hide'); 
        $('#mymodal-taluk_state_zerorla').modal('show');
     }
    if(name=='back_zerotalukdistrict')
     {
        $('#mymodal-taluk_zerorla').modal('hide');
         $('#mymodal-district_zerorla').modal('show');
     }
     
     if(name=='back_talukdistrict')
     {
        $('#mymodal-taluk').modal('hide');
         $('#mymodal-district').modal('show');
     }
      if(name=='back_sstbeatdistrict')
     {
        $('#mymodal-sstsubrdbeat').modal('hide');
        $('#mymodal-sstbeatdistrict').modal('show'); 
     }
     if(name=='back_sstbeatstate')
     {
         $('#mymodal-sstsubrdbeat').modal('hide'); 
        $('#mymodal-SST_beat_state').modal('show');
     }
     if(name=='back_RDcity')
     {
        $('#mymodal-RD_list').modal('hide'); 
        $('#mymodal-city_list').modal('show');
     }
     if(name=='back_rdbeat')
     {
         $('#mymodal-rdbeat').modal('hide'); 
         $('#mymodal-RD_list').modal('show'); 
     }
     if(name=='back_beatcity')
     {
        $('#mymodal-beat').modal('hide'); 
        $('#mymodal-city_RD').modal('show');
     }
      if(name=='back_statehighway')
     {
        $('#mymodal-state_highwaylist').modal('hide');
        $('#mymodal-state_highway').modal('show');
     }
     if(name=='back_sststate')
     {
        $('#mymodal-sst_list').modal('hide');
        $('#mymodal-sst_state_beat').modal('show');
     }
      if(name=='back_villagestate')
     {
        $('#mymodal-villagedistrict').modal('hide');
        $('#mymodal-villagemap_state').modal('show');
     }
     if(name=='back_villagetalukdistrict')
     {
        $('#mymodal-villagetaluk').modal('hide');
        $('#mymodal-villagedistrict').modal('show');
     }
       if(name=="back_consolidatetaluk")
     {
          $('#mymodal-consolidatetaluk').modal('hide');
        $('#mymodal-consolidatedistrict').modal('show');
     }
      if(name=="back_consolidatestate")
     {
          $('#mymodal-consolidatedistrict').modal('hide');
        $('#mymodal-consolidate_taluk_state').modal('show');
     }

     if(id==1 || id==2 || id==3 || id==4)
     {
        console.log( $('.'+name+'_list_1,.'+name+'_list_2,.'+name+'_list_3,.'+name+'_list_4').attr('style','display:none'));
                 $('.'+name+'_list_'+id).attr('style','display:block');
     }
        
  

}
function isNumber(evt) {
             
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
           
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
function back_old(name)
{
     if(name=='back_state')
     {
        $('#mymodal-highway').modal('hide'); 
        $('#mymodal-highway_state').modal('show');
     }
     if(name=='back_taluk')
     {
        $('#mymodal-district').modal('hide'); 
        $('#mymodal-taluk_state').modal('show');
     }
     if(name=='back_beatstate')
     {
        $('#mymodal-beatdistrict').modal('hide'); 
        $('#mymodal-beat_state').modal('show');
     }
     if(name=='back_beatdistrict')
     {
        $('#mymodal-subrdbeat').modal('hide');
        $('#mymodal-beatdistrict').modal('show'); 
        
     }
     if(name=='back_talukdistrict')
     {
        $('#mymodal-taluk').modal('hide');
         $('#mymodal-district').modal('show');
     }
        
  

}
function show_beatdistrictdetail(state_id,location_name,data)
{
     beat_state=$(data).parent().parent();
     $(".beatstate").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");         
        }
    });   
    beat_state.addClass("filter-data2");
      district='<?php echo json_encode($user_district);?>';
                  district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
    ajax_action(state_id,location_name,'Getsubrd_district',district_);
     
 //    setTimeout(function(){
 //    $("#beatdistrict_title").html('Select '+statename+' Distt. / Drill Down into Distt.');
 //    $('#mymodal-beat_state').modal('hide');
 //   $('#mymodal-beatdistrict').modal('show'); 
 //    $( ".districtbeat_listout" ).each(function(  ) {
 //    $(this).hide();
 //  });
 //    $('#districtlistbeat_'+state_id).show();
 //     $.each($("input[name='districtlistbeat']:checked"), function() {
 //    $(this).prop("checked",false);
 //   });
 // },200);
}

function show_RD(city_id,location_name,data,type='')
{
   citylist=$(data).parent().parent();
     $(".citylist").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");         
        }
    });   
     citylist.addClass("filter-data2");
     if(("{{Auth::user()->client_id}}")==115 || ("{{Auth::user()->client_id}}")==1 || ("{{Auth::user()->client_id}}")==123 ||  ("{{Auth::user()->client_id}}")==1000)
        ajax_action(city_id,location_name,'Get_Beat',[],type);
     else
      ajax_action(city_id,location_name,'Get_RD',[]);
}

function show_nbhrd(city_id,location_name,data,type)
{
   citylist=$(data).parent().parent();
     $(".citylist").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");         
        }
    });   
     citylist.addClass("filter-data2");
    
      ajax_action(city_id,location_name,'Get_nbhrd',[],type);
}
function show_sstbeatdistrictdetail(state_id,location_name,data)
{
     sstbeat_state=$(data).parent().parent();
     $(".sstbeatstate").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");         
        }
    });   
    sstbeat_state.addClass("filter-data2");
      district='<?php echo json_encode($user_district);?>';
                  district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
    ajax_action(state_id,location_name,'Getsstbeat_district',district_);
  
}
function show_beatdistrictdetail(state_id,location_name,data)
{
     beat_state=$(data).parent().parent();
     $(".beatstate").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");         
        }
    });   
    beat_state.addClass("filter-data2");
      district='<?php echo json_encode($user_district);?>';
                  district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
    ajax_action(state_id,location_name,'Getsubrd_district',district_);
  
}
function ajax_action(id,location_name,show_level,district=[],type='',country_id=0,level_id=0,highway_type=0)
{

obj = {
            'id': id,
            'show_level':show_level,
            'district':district,
            'type':0,
            'data_type':type,
             'country_id':country_id,
            'level_id':level_id,
            'highway_type':highway_type
            
          };
 loaddata = {
           
            'input': JSON.stringify(obj),
            
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
            async: true,
            data:loaddata,

            beforeSend: function() {
                $(".spin-loader").attr('style', 'display:block');
            },
            complete: function() {
                $(".spin-loader").attr('style', 'display:none');
            },

            success: function(res) {
                if(res['status']=='success')
                {
                     if(show_level=='Get_nbhrd')
                     {
                        $('#mymodal-city_delhi,#mymodal-city_remain').modal('hide');
                        $('#mymodal-nbhrd_list').modal('show');
                        $("#nbhrd_list").html('');
                         $("#nbhrd_list").html(res['data']);
                        $("#nbhrd_title").html(location_name+'  City - N\'bhrd (s)');
                     }
                     if(show_level=='Getsubrd_district')
                     {
                         $("#districtlistbeat").html('');
                         $("#districtlistbeat").html(res['data']);
                         $("#beatdistrict_title").html('Select '+location_name+' distt. / Drill down into Sub-distt.');
                         $('#mymodal-beat_state').modal('hide');
                         $('#mymodal-beatdistrict').modal('show'); 

                     } 
                     if(show_level=='Get_zerosubrddistrict')
                     {
                          $("#zerodistrict_title").html('Select Assigned '+location_name+' Highway(s)');
                          $('#mymodal-taluk_state_zerorla').modal('hide');
                          $('#mymodal-district_zerorla').modal('show'); 
                          $('#zerodistrictlist').html(res['data']);
                     }
                      if(show_level=='Get_zerosubrdtaluk')
                     {
                         $('#mymodal-district_zerorla').modal('hide');
                        $('#mymodal-taluk_zerorla').modal('show'); 
                          $('#zerotaluklist').html(res['data']);
                     }
                       if(show_level=='Get_villagedistrict')
                     {
                         $("#villlagedistrict_title").html('Select Assigned '+location_name+' District(s)');
                          $('#mymodal-villagemap_state').modal('hide');
                          $('#mymodal-villagedistrict').modal('show'); 
                          $('#villagedistrictlist').html(res['data']);

                     }
                      if(show_level=='Get_villagetaluk')
                     {
                         $('#mymodal-villagedistrict').modal('hide');
                        $('#mymodal-villagetaluk').modal('show'); 
                          $('#villagetaluklist').html(res['data']);
                     }
                     
                     if(show_level=='Getsubrd_subrd')
                     {
                        $('#subrdbeatlist').html('');
                        $('#subrdbeatlist').html(res['data']);
                        $('#mymodal-beatdistrict').modal('hide');
                        $('#mymodal-subrdbeat').modal('show'); 
   
                     }
                      if(show_level=='Get_consolidatesubrddistrict')
                     {
                          $("#consolidatedistrict_title").html('Select Assigned '+location_name+' Subrd(s)');
                          $('#mymodal-consolidate_taluk_state').modal('hide');
                          $('#mymodal-consolidatedistrict').modal('show'); 
                          $('#consolidatedistrictlist').html(res['data']);
                     }
                       if(show_level=='Get_consolidatesubrdtaluk')
                     {
                         $('#mymodal-consolidatedistrict').modal('hide');
                        $('#mymodal-consolidatetaluk').modal('show'); 
                          $('#consolidate_taluk_list').html(res['data']);
                     }
                     if(show_level=="get_nextlevel")
                     {
                        $("#country_data_list").html();
                        $("#country_data_list").html(res['data']);
                        $("#country_level_view").html(res['level_name']);
                        $("#country_back,#country_filter").hide();
                        if(res['is_back'])
                        {
                            $("#country_back").show();
                            (id,location_name,show_level,district=[],view_optn='',country_id=0,level_id=0)
                            $("#back_country").attr("onClick","ajax_action('back','','get_nextlevel',[],'',"+res['country_id']+","+res['level_id']+")");

                        }
                        if(res['is_apply'])
                            $("#country_filter").show();

                     }
                       if(show_level=='Get_RD')
                     {
                         $("#RD_list").html('');
                         $("#rdlistbeat").html(res['data']);
                         
                         $('#mymodal-city_RD').modal('hide');
                         $('#mymodal-RD_list').modal('show');
                         if(("{{Auth::user()->client_id}}") == 0 || ("{{Auth::user()->client_id}}") == 15) 
                             $("#uncovered_title").html(location_name+'  City - N\'bhrd (s)');
                        if(("{{Auth::user()->client_id}}") == 120) 
                             $("#uncovered_title").html('Select RD. / Drill down into Beat.');
 

                     }
                      if(show_level=='Get_Beat')
                     {
                         $("#beatlist").html('');
                         $("#beatlist").html(res['data']);
                         
                         $('#mymodal-city_RD').modal('hide');
                         $('#mymodal-beat').modal('show'); 

                     }
                     
                     if(show_level=='Get_RD_beat')
                     {
                        $('#rdbeatlist').html('');
                        $('#rdbeatlist').html(res['data']);
                        $('#mymodal-RD_list').modal('hide');
                        $('#mymodal-rdbeat').modal('show'); 
   
                     }
                     if(show_level=='Getsst_subrd')
                     {
                        $('#sstsubrdbeatlist').html('');
                        $('#sstsubrdbeatlist').html(res['data']);
                        $('#mymodal-sstbeatdistrict').modal('hide');
                        $('#mymodal-sstsubrdbeat').modal('show'); 
   
                     }
                     if(show_level=='Get_SST')
                     {
                        $('#sstlist').html('');
                        $('#sstlist').html(res['data']);
                        $('#mymodal-sst_state_beat').modal('hide');
                        $('#mymodal-sst_list').modal('show'); 
   
                     }
                     // if(show_level=='Get_highway')
                     // {
                     //      $("#highway_title").html('Select Assigned '+location_name+' Highway(s)');
                     //      $('#mymodal-highway_state').modal('hide');
                     //      $('#mymodal-highway').modal('show'); 
                     //      $('#highwaylist').html(res['data']);
                     // }
                     if(show_level=='Get_highway')
                     {

                          $("#highway_title").html('Select Assigned '+location_name+' Highway(s)');
                         
                          
                         if(highway_type==1)
                         {
                             $('#mymodal-highway_state').modal('hide');
                             $('#mymodal-highway').modal('show'); 
                             $('#highwaylist').html(res['data']);
                         }
                         if(highway_type==2)
                         {
                             $('#mymodal-state_highway').modal('hide');
                             $('#mymodal-state_highwaylist').modal('show'); 
                             $('#statehighway_list').html(res['data']);
                             
                         }
                         
                     }



                     if(show_level=='Get_subrddistrict')
                     {
                          $("#district_title").html('Select Assigned '+location_name+' Highway(s)');
                          $('#mymodal-taluk_state').modal('hide');
                          $('#mymodal-taluk_state_wholesaler').modal('hide');
                        
                          $('#mymodal-district').modal('show'); 
                          $('#districtlist').html(res['data']);
                     }
                      if(show_level=='Getsstbeat_district')
                     {
                        $("#districtlistsstbeat").html('');
                         $("#districtlistsstbeat").html(res['data']);
                         $("#sstbeatdistrict_title").html('Select '+location_name+' distt. / Drill down into Sub-distt.');                         
                         $('#mymodal-SST_beat_state').modal('hide');
                         $('#mymodal-sstbeatdistrict').modal('show'); 
                     }
                      if(show_level=='Get_subrdtaluk')
                     {
                         $('#mymodal-district').modal('hide');
                        $('#mymodal-taluk').modal('show'); 
                          $('#taluklist').html(res['data']);
                     }
                     if(show_level=='Getchild')
                     {
                        $('#mymodal-district').modal('hide');
                        $('#mymodal-taluk').modal('hide'); 
                        $('#mymodal-listmenu').modal('show'); 
                        $('#menu_list').html(res['data']);
                        $("#menu_title").html(location_name);
                        $('#menu_footer').show();
                        $("#diagonis").html('');
                        if(res['radio']!=undefined && res['radio']!=null)
                        {
                             option='';
                             $.each(res['radio'],function(k,v){

                                option +='<div class="form-check form-check-inline filter-data orngchk"><input type="radio" class="form-check-input" id="'+id+'" name="diagonis_by" value="'+k+'" onclick="show_diagnois(this)"><label for="'+v+'">'+v+'</label></div>';
                             });

                             $("#diagonis").html(option);
                        }

                        $(".nextmenu_section").click(function(){
                              type=$(this).attr("id");
                              menu_name=$(this).text();
                              ajax_action(type,menu_name,'Getchild');
                        });

                        

                        
                     }
                }
                else
                {
                     alert(res['msg']);
                }

            }});

}

function show_districtdetail(state_id,statename,data)
{
    if(data !='')
    {
         taluk_state=$(data).parent().parent();
    $(".talukstate").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");
           // $(this).addClass("filter-data");
        }
    });
    // taluk_state.removeClass("filter-data");
    taluk_state.addClass("filter-data2");
    }
      district='<?php echo json_encode($user_district);?>';
                  district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
   
  ajax_action(state_id,statename,'Get_subrddistrict',district_);
  //   setTimeout(function(){
  //       $("#district_title").html('Select '+statename+' Distt. / Drill Down into Distt.');
  //   $('#mymodal-taluk_state').modal('hide');
  //  $('#mymodal-district').modal('show'); 
  //   $( ".district_listout" ).each(function(  ) {
  //   $(this).hide();
  // });
  //   $('#districtlist_'+state_id).show();
  //    $.each($("input[name='districtlist']:checked"), function() {
  //   $(this).prop("checked",false);
  //  });
  //   },500);
     
}
function showconsolidatetaluk(data)
{
  district_id=$(data).attr('id');
  district_name=$(data).attr('district_name');
  $("#district_head").html($(data).attr('district_name')+ ' distt. - Select Sub-distt.');
  ajax_action(district_id,district_name,'Get_consolidatesubrdtaluk')
 
}
function show_consolidate_districtdetail(state_id,statename,data)
{
    if(data !='')
    {
         taluk_state=$(data).parent().parent();
    $(".consolidatestate_list").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");
           // $(this).addClass("filter-data");
        }
    });
    // taluk_state.removeClass("filter-data");
    taluk_state.addClass("filter-data2");
    }
      district='<?php echo json_encode($user_district);?>';
                  district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
   
  ajax_action(state_id,statename,'Get_consolidatesubrddistrict',district_);
 
     
}
function show_zerodistrictdetail(state_id,statename,data)
{
    if(data !='')
    {
         taluk_state=$(data).parent().parent();
    $(".talukstate").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");
           // $(this).addClass("filter-data");
        }
    });
    // taluk_state.removeClass("filter-data");
    taluk_state.addClass("filter-data2");
    }
      
                    
   
  ajax_action(state_id,statename,'Get_zerosubrddistrict',[]);
  
     
}
// function show_highwaydetail(state_id,statename,data)
// {

//      highway_state=$(data).parent().parent();
//     $(".highwaystate").each(function(){
//         if($(this).hasClass("filter-data2"))
//         {
//             $(this).removeClass("filter-data2");
           
//         }
//     });
//     // taluk_state.removeClass("filter-data");
//     highway_state.addClass("filter-data2");
//     ajax_action(state_id,statename,'Get_highway');
// //     setTimeout(function(){
  
// //   $("#highway_title").html('Select Assigned '+statename+' Highway(s)');
// //   $('#mymodal-highway_state').modal('hide');
// //   $('#mymodal-highway').modal('show'); 
// //   $( ".highway_listout" ).each(function(  ) {
// //     $(this).hide();
// //   });
// //   $('#highwaylist_'+state_id).show();
// //    $.each($("input[name='highwaylist']:checked"), function() {
// //     $(this).prop("checked",false);
// //    });
// // },200);
// }
function show_highwaydetail(state_id,statename,data,highway_type)
{

     highway_state=$(data).parent().parent();
    $(".highwaystate").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");
           
        }
    });
    // taluk_state.removeClass("filter-data");
    highway_state.addClass("filter-data2");
    
    ajax_action(state_id,statename,'Get_highway',[],'',0,0,highway_type);

}
function show_sstbeat(state_id,statename,data,highway_type)
{

    sstbeat_state=$(data).parent().parent();
    $(".sstbeatlist").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");
           
        }
    });
    // taluk_state.removeClass("filter-data");
    sstbeat_state.addClass("filter-data2");
    
    ajax_action(state_id,statename,'Get_SST',[],'',0,0);
}
function show_subrd(data)
{
  district_id=$(data).attr('id');
  location_name=$(data).attr('district_name');
  ajax_action(district_id,location_name,'Getsubrd_subrd');
}
function show_sstsubrd(data)
{
  district_id=$(data).attr('id');
  location_name=$(data).attr('district_name');
  ajax_action(district_id,location_name,'Getsst_subrd');
  
}
function show_rdlist(data)
{
  rd_code=$(data).attr('id');
  location_name=$(data).attr('rd_name');
  ajax_action(rd_code,location_name,'Get_RD_beat');
  
}
function villageshowtaluk(data)
{
  district_id=$(data).attr('id');
  district_name=$(data).attr('district_name');
  $("#villagedistrict_head").html($(data).attr('district_name')+ ' distt. - Select Sub-distt.');
  ajax_action(district_id,district_name,'Get_villagetaluk')
  
}
function zeroshowtaluk(data)
{
  district_id=$(data).attr('id');
  district_name=$(data).attr('district_name');
  $("#zerodistrict_head").html($(data).attr('district_name')+ ' distt. - Select Sub-distt.');
  ajax_action(district_id,district_name,'Get_zerosubrdtaluk')
  
}
function showtaluk(data)
{
  district_id=$(data).attr('id');
  district_name=$(data).attr('district_name');
  $("#district_head").html($(data).attr('district_name')+ ' distt. - Select Sub-distt.');
  ajax_action(district_id,district_name,'Get_subrdtaluk')
 
}
    /////////////Easy Buttonfunction ///////////////////////
if((("{{Auth::user()->client_id}}") != 115  && ("{{Auth::user()->client_id}}") != 15) || (("{{Auth::user()->client_id}}")==123 || ("{{Auth::user()->client_id}}")==0 ||  ("{{Auth::user()->client_id}}")==1000))
    {
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
      map.addControl(opacity_button);


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
    }

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
    
     if((("{{Auth::user()->user_type}}") == 'SUPPORT' && (("{{Auth::user()->client_id}}")==100 || ("{{Auth::user()->client_id}}")==130 )))
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
   
    if(("{{Auth::user()->client_id}}")==86 || ("{{Auth::user()->client_id}}")==115)
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
        dynamic_control[5].disable();

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
               // showboundbyusertype('');
                $('#maphead').html('');
                legendremove();
                removelayer();
                $("#showdata").css("display", "none");
                if(dynamic_control[5]!=null && dynamic_control[5] !=undefined)
                 dynamic_control[5].disable();
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
if(("{{Auth::user()->user_type}}") == 'TSM' && ((("{{Auth::user()->client_id}}")==120) || (("{{Auth::user()->client_id}}")==123) || (("{{Auth::user()->client_id}}")==0) || (("{{Auth::user()->client_id}}")==15) || (("{{Auth::user()->client_id}}")==112) || ("{{Auth::user()->client_id}}")==1000 ))
    {
     
        if(("{{Auth::user()->login_type_mdlz}}") == 'Urban')
     {
        var calendar = L.easyButton({
        position: 'bottomright',
        states: [{
            stateName: 'Calendar',
            icon: '<i class="fas fa-calendar"></i>',
            title: 'Calendar',
            onClick: function(control) {
                 $('#prdSelect').modal('show');

            }
        }]
    });
         map.addControl(calendar);  
         var city_list = L.easyButton({
                position: 'bottomright',
                states: [{
                    stateName: 'Citylist',
                    icon: '<i class="fas fa-city"></i>',
                    title: 'Citylist',
                    onClick: function(control) {
                        $("#mymodal-citylist").modal('show');

                    }
                }]
            });
         map.addControl(city_list);
         var filer_clear = L.easyButton({
        position: 'bottomright',
        states: [{
            stateName: 'Clear Filter',
                icon: '<i class="fa fa-trash"></i>',
                title: 'Clear',
                onClick: function(control) {
                    $("#clearresult").click();
                    history_map=[];
                   // showboundbyusertype('');
                    $('#maphead').html('');
                    legendremove();
                    removelayer();
                    $("#showdata").css("display", "none");
                }
            }]
        });
         map.addControl(filer_clear);
     }
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
 if(("{{Auth::user()->client_id}}")==15 || ("{{Auth::user()->client_id}}")==0 || ("{{Auth::user()->client_id}}")==120 )
     {
        if(("{{Auth::user()->client_id}}")!=120)
         {var backbtn = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-arrow-left',
                title: 'Back',
                onClick: function(control) {
                    filter_rd=[];
                    if(filterid[0]==2 || filterid[0]==3){
                        console.log($("input[name='nbhrd_name']:checked").length);
                       $.each($("input[name='nbhrd_name']:checked"), function() {
                        filter_rd.push($(this).val());
                    });

                    }
                          
                    else
                    {
                         $.each($("input[name='rdbeat']:checked"), function() {
                        filter_rd.push($(this).val());
                    });
                         clearfilter();  
                    }

                    
                             
                         obj = {
                        'type': 17,
                        'filter_rd':filter_rd,
                       
                        };
                     if(("{{Auth::user()->client_id}}")==0)
                        obj.type_id=filterid[0];
                    console.log(obj);
                        initial(obj, 0,17, '');
                        $("#showmap").click();
                         setInterval(function(){
                  
                             map.invalidateSize();
                   }, 1000);
                         dynamic_control[10].disable();
                }
            }]
        });
        map.addControl(backbtn);
        dynamic_control[10]=backbtn;
         dynamic_control[10].disable();
     }
          var filter_channel = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-filter',
                title: 'Filter',
                onClick: function(control) {
                    if(("{{Auth::user()->client_id}}")==0)
                    {
                        type_id=filterid[0];
                        $('input[name="tag_list"]').each(function() {
                            
                            if(parseInt($(this).attr("data_type"))==type_id)
                              $(this).prop('checked', true);
                            else
                              $(this).prop('checked', false);
                          });
                        $('.type_id1,.type_id2').each(function() {
                            $(this).hide();
                        });
                        console.log('#type_id'+type_id);
                         $('.type_id'+type_id).each(function() {
                            $(this).show();
                        });

                    }
                    $('#mymodal-filterchannel').modal('show');
                }
            }]
        });
        map.addControl(filter_channel);
        dynamic_control[11]=filter_channel;
        dynamic_control[11].disable();
     }
if (("{{Auth::user()->user_type}}") != 'SUPPORT'  ) {
   // dynamic_control.push(filer_clear);
     //map.addControl(filer_clear);
     // if(dynamic_control[0] !='' && dynamic_control[0] != null && dynamic_control[0]!=undefined)
     //       dynamic_control[0].disable();
  

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



    function loadmap(res, view,highway=false,subrd=false,sst=false,retailer=false,rd=false) {

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
style=  {
                            fillColor: 'blue',
                            color: 'blue',
                            weight: 5,
                            stroke: 10,
                            fillOpacity: 2,
                            opacity: 1
                        };

              var geojson = L.geoJson(JSON.parse(message), {
                style: style,
                onEachFeature: function(feature, layer) {
                    
                     if(feature.properties.ID==undefined)
                      if(feature.properties.DB_ID!=undefined)
                        feature.properties.ID=feature.properties.DB_ID;

                  // if (bound_check.indexOf(feature.properties.ID) == -1) {

                  //       bound_check.push(feature.properties.ID);
                  //       bound_type[feature.properties.ID] = 1; // to check multiple polygon
                  //       layer_bound[feature.properties.ID] = layer;
                  //   } else {

                  //       lastlayer = layer_bound[feature.properties.ID];
                  //       layer_bound[feature.properties.ID] = [];
                  //       bound_type[feature.properties.ID] = 2;

                  //       if (!($.isArray(lastlayer))) {
                  //           layer_id = feature.properties.ID;
                  //           layer_bound[feature.properties.ID].push({
                  //               layer_id: lastlayer
                  //           });
                  //           layer_bound[feature.properties.ID].push({
                  //               layer_id: layer
                  //           });

                  //       }
                  //       if (($.isArray(lastlayer))) {
                  //           layer_id = feature.properties.ID;
                  //           for (i_l = 0; i_l < lastlayer.length; i_l++) {
                  //               layer_bound[feature.properties.ID].push(lastlayer[i_l]);
                  //           }


                  //           layer_bound[feature.properties.ID].push({
                  //               layer_id: layer
                  //           });

                  //       }

                  //   }





                    layer.on({
                        click: featureclick_1,
                       // dblclick: change_status_byuser
                        //  mouseover: highlightFeature,
                        //mouseout: resetHighlight,touchstart:touch
                    });
                    layer.setStyle({
                            fillColor: 'blue',
                            color: 'blue',
                            weight: 5,
                            stroke: 10,
                            fillOpacity: 2,
                            opacity: 1
                        });

                 
                    if (res['map_nextlevel_info'].hasOwnProperty(feature.properties.ID)) {
                        console.log("r");
                        nextinfo = res['map_nextlevel_info'][feature.properties.ID];                        
                        feature.id = feature.properties.ID;   
                       if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
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
                            weight: 5,
                            stroke: 10,
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
          else if(subrd || sst)
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


                   if (res['map_nextlevel_info'].hasOwnProperty(feature.properties.Beat_unique_id) || res['map_nextlevel_info'].hasOwnProperty(feature.properties.Village_Cencus_Code+'#'+feature.properties.Beat)) {
                     if (res['map_nextlevel_info'].hasOwnProperty(feature.properties.Village_Cencus_Code+'#'+feature.properties.Beat))
                 {
                     feature.properties.Beat_unique_id=feature.properties.Village_Cencus_Code+'#'+feature.properties.Beat;
                 }  
                 


                      
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





                   if (res['map_nextlevel_info'].hasOwnProperty(feature.properties.Village_Cencus_Code+'#'+feature.properties.Beat))
                     {
                            layer.on({
                                click: featureclick_1,
                                dblclick: show_clientsubrdbeat_filter
                               
                            });
                     }
                     else if (res['map_nextlevel_info'].hasOwnProperty(feature.properties.Beat_unique_id) && input_obj.type==23)
                     {
                            layer.on({
                                click: featureclick_1,
                                dblclick: show_clientsstbeat_filter
                               
                            });
                     }
                     else if(subrd)
                     {
                                layer.on({
                                click: featureclick_1,
                                dblclick: show_subrdbeat_filter
                                
                            });
                     }
                     else if(sst)
                     {
                           layer.on({
                                click: featureclick_1,
                                dblclick: show_village_outlet
                               
                            });
                     }

                        nextinfo = res['map_nextlevel_info'][feature.properties.Beat_unique_id];                        
                        feature.id = feature.properties.Beat_unique_id;   
                        feature.properties.beat_id=nextinfo['beat_id'];  
                          if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {               
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
                            weight: 5,
                            stroke: 10,
                            fillOpacity: 2,
                            opacity: 1
                        });
                    
                             geo_layer.push(layer);
                    } 
                     

                }
            });
             
      
              


        

          }
          else if(message!='' && message!=undefined && message!=null)
          {


            style={
                            fillColor: '#ffffff',
                            color: '#808080',
                            weight: 1,
                            stroke: 2,
                            fillOpacity: 1,
                            opacity: 1
                        };
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
                    if (("{{Auth::user()->role}}") == 'Country-HO')
                        layer.on({
                            click: featureclick,
                            dblclick: featuredblclick_subrd_village
                            //  mouseover: highlightFeature,
                            //mouseout: resetHighlight,touchstart:touch
                        });
                        
                    else 
                    layer.on({
                            click: featureclick,
                            dblclick: featuredblclick
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
                         feature.properties.current_id = nextinfo['current_id'];
                        feature.properties.city_id = nextinfo['city_id'];
                         current_maplevel[0]=({
                                                    'loc_level': nextinfo['current_level'],
                                                    'loc_id': feature.properties.current_id,
                                                    'city_id':nextinfo['city_id']
                                                    
                                                });
                         //console.log(nextinfo.info) ;
                        // if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                        // layer.bindTooltip("<div class='tooltip-data no-border'><div class='card'><div class='card-header'>" + feature.properties.location_name + "</div></div>", {
                        //     sticky: true,
                        //     pane: 'tool',
                        //     direction: 'top'
                        // });
                        // }
                        
                            layer.bindPopup("<div class='tooltip-data no-border'><div class=''><div class='' style='color:#fff;margin-left:5px;padding:5px;'>" + feature.properties.location_name + "</div></div>", {
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
                            fillOpacity: 1,
                            opacity: 1
                        });
                         

                    }
                    
                }
            });

            geo_layer.push(geojson);
          }

        }
         if (parseInt(input_obj['type'])==21 || parseInt(input_obj['type'])==22)
        {
            tsi_count=res['result']['tsi_list'].length;
             for(k=0;k<tsi_count;k++)
             {
               
                  var circle_marker = L.circle([res['result']['tsi_list'][k].latitude,res['result']['tsi_list'][k].longitude], {
                        "radius": parseInt(res['result']['tsi_list'][k]['distacnce_km']*1000),
                        "fillColor":res['result']['tsi_list'][k]['color'],
                        "color": res['result']['tsi_list'][k]['color'],
                        "weight": 1,
                        "opacity": 1,
                        "fillOpacity": res['result']['tsi_list'][k]['opacity'],
                        "stroke": 1,
                        "id":res['result']['tsi_list'][k]['cluster_name']
                       
                    });


                  circle_marker.bindPopup(res['result']['tsi_list'][k].info);
                   outlet_markerarray.push(circle_marker);
                 showarray[res['result']['tsi_list'][k].cluster]=circle_marker;
                 circle_marker.addTo(map);
                
                 res['result']['tsi_list'][k]['cluster_name']=res['result']['tsi_list'][k]['cluster_name'].replace("Sr. TSI Cluster ","");
                   res['result']['tsi_list'][k]['cluster_name']=res['result']['tsi_list'][k]['cluster_name'].replace("Cluster ","");
                text_info='<b>Sr.TSI <br/><span style="color:#fff;text-align:center;font-weight: bold;">C'+res['result']['tsi_list'][k]['cluster_name']+'</span></b>';
               
                 var text = L.tooltip({
                          permanent: true,
                          direction: 'center',
                          className: 'textclass_text'
                      })
                     // .setContent(''+retailer_list[i].visit_order+'')

                    .setContent('<span style="color:#fff !important;text-align:center;font-weight: bold;">C'+res['result']['tsi_list'][k]['cluster_name']+'</span>')
                      .setLatLng([res['result']['tsi_list'][k].latitude,res['result']['tsi_list'][k].longitude]);
                      highway_pop.push(text);
                      text.addTo(map); 
                 circle_marker.on('dblclick', function(e){
                    console.log(e.target);
                         input_obj={'type':parseInt(input_obj['type'])};
                         input_obj['cluster_name']=e.target.options.id;
                         console.log(input_obj);
                           var backbtn = L.easyButton({
                            position: 'bottomright',
                            states: [{
                                stateName: 'globe-layer',
                                icon: 'fa fa-arrow-left',
                                title: 'Back',
                                onClick: function(control) {
                                    for (i_ = 0; i_ < dynamic_control['rpi_action_1'].length; i_++) {
                                             map.removeControl(dynamic_control['rpi_action_1'][i_]);
                                     }
                             dynamic_control['rpi_action_1']=[];
                                   removelayer();
                                  
                                   input_obj = {
                                        'type': parseInt(input_obj['type'])
                                        
                                        };
                            initial(input_obj, 0,parseInt(input_obj['type']), '');
                                }
                            }]
                        });
                         map.addControl(backbtn);
                         dynamic_control['rpi_action_1']=[];
                         dynamic_control['rpi_action_1'].push(backbtn); 
                         initial(input_obj,0,parseInt(input_obj['type']),'');
                             
               });

                    
             }
             // if(tsi_count<=1)
             // {
                var featureGroup_circle = L.featureGroup(outlet_markerarray);
                map.fitBounds(featureGroup_circle.getBounds());
           //  }
             subrd_count=res['result']['subrd_sst_list'].length;
             for(k=0;k<subrd_count;k++)
             {
                  var greenIcon = L.icon({
                        iconUrl: res['result']['subrd_sst_list'][k].image,
                        iconSize: [20, 20],
                    });
               var m = new L.Marker(new L.LatLng(res['result']['subrd_sst_list'][k].latitude, res['result']['subrd_sst_list'][k].longitude), {
                            icon: greenIcon,
                             iconSize: [5, 5]
                        });
                 m.bindPopup(res['result']['subrd_sst_list'][k].info, {
                           'sticky': true,
                            pane: 'tool',
                            direction: 'top'
                    });
                 outlet_markerarray.push(m);
                 showarray[res['result']['subrd_sst_list'][k].refid]=m;
                 m.addTo(map);
             }
            
          
        }
      

        if(geo_layer.length>0 && input_obj.type!=26)
        {
              var featureGroup = L.featureGroup(geo_layer).addTo(map);
              if(res['fit_bounds']==undefined && res['fit_bounds']==null && res['fit_bounds']!=1)
                    map.fitBounds(featureGroup.getBounds());          
              overlay_arr['geolayer'] = featureGroup;
        }

       
        if(rd){
          
               rd_list=res['result']['rd_list'];
               exist_rd=res['result']['exist_rd'];
               
        for(i=0;i<rd_list.length;i++)
        {
             var greenIcon = L.icon({
                        iconUrl: rd_list[i].icon,
                        iconSize: [20, 20],
                    });
               var m = new L.Marker(new L.LatLng(rd_list[i].latitude, rd_list[i].longitude), {
                            icon: greenIcon,
                             iconSize: [5, 5]
                        });
                 m.bindPopup(rd_list[i].info, {
                           'sticky': true,
                            pane: 'tool',
                            direction: 'top'
                    });
                 outlet_markerarray.push(m);
                 showarray[rd_list[i].retailer_id]=m;
                  markercluster.addLayers(outlet_markerarray);
                markercluster.addTo(map); 
        }
        for(i=0;i<exist_rd.length;i++)
        {
             var greenIcon = L.icon({
                        iconUrl: exist_rd[i].icon,
                        iconSize: [20, 20],
                    });
               var m = new L.Marker(new L.LatLng(exist_rd[i].latitude, exist_rd[i].longitude), {
                            icon: greenIcon,
                             iconSize: [5, 5]
                        });
                 m.bindPopup(exist_rd[i].info, {
                           'sticky': true,
                            pane: 'tool',
                            direction: 'top'
                    });
                 showarray[exist_rd[i].refid]=m;
                 uncovered_outlet_markerarray.push(m);
                 
                  uncovered_markercluster_mdlz.addLayers(uncovered_outlet_markerarray);
                 uncovered_markercluster_mdlz.addTo(map); 
        }
        
        if(outlet_markerarray.length > 0)
        { 
            var featureGroup_RD = L.featureGroup(outlet_markerarray);
            map.fitBounds(featureGroup_RD.getBounds());

        }
        
        }
         if(res['village_subrd']!=undefined && res['village_subrd']!=null)
        {
            village_subrd=res['village_subrd'];

              for(i=0;i<village_subrd.length;i++)
                {

                      var greenIcon = L.icon({
                              iconUrl: village_subrd[i].marker,
                              iconSize: [15, 15],
                          });

                var marker = L.marker([village_subrd[i]['latitude'], village_subrd[i]['longitude']], {
                  icon: greenIcon
              });
            if(village_subrd[i]['circleround']!=undefined && village_subrd[i]['circleround']!=null)
            {

                 var circle_marker = L.circle([village_subrd[i]['latitude'],village_subrd[i]['longitude']], {
                                    "radius": village_subrd[i]['circleround'],
                                    "fillColor":'#fff',
                                    "color": village_subrd[i]['colorround'],
                                    "weight": 1,
                                    "opacity": 1,
                                    "fillOpacity": 0,
                                    "stroke": 1,
                                   
                                });
                if(village_subrd[i].type_id==1)
                  {
                     villg_distributor.push(marker);
                      circle_distributor.push(circle_marker);
                  }
                   
                if(village_subrd[i].type_id==2)
                {    

                     circle_subd.push(circle_marker);
                    villg_subd.push(marker);
                }
            }
                
                 if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){  
                marker.bindTooltip(village_subrd[i].info, {
                        sticky: true,
                        pane: 'tool',
                        direction: 'top'
                    });
            }
                  marker.bindPopup(village_subrd[i].info, {
                        sticky: true,
                        pane: 'tool',
                        direction: 'top'
                    });
                  
                }


             
                   

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
                      if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
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
                     // .setContent(''+retailer_list[i].visit_order+'')
                    .setContent(''+retailer_list[i].visit_order+'')
                      .setLatLng([retailer_list[i].latitude,retailer_list[i].longitude]);
                      highway_pop.push(text);
                      text.addTo(map); 
                 // }

                    


                   
                }
                for(i=0;i<res['result']['subrd_list'].length;i++)   {
              v=res['result']['subrd_list'][i];
               icon_size=[];
               icon_size[0]=[20,20];
              if(v.type!=undefined && v.type!='' && v.type!=null)
              {
                icon_size=[];
                icon_size[1]=[30,30];
                icon_size[2]=[20,20];
                icon_size['Actual']=[20,20];
                icon_size['Assumed']=[20,20];

                 //icon_size=[[20,20],[30,30],[20,20];
              }
              else
                v.type=0;
               if(v.latitude != '' && v.longitude != '' && v.latitude !==undefined)
               {
                 var greenIcon = L.icon({
                        iconUrl: v.icon,
                        iconSize: icon_size[v.type],
                    });
                    var marker = L.marker([v.latitude, v.longitude], {
                      icon: greenIcon
                  });
                             
                    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
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
                     if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
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
                 
                 showarray[retailer_list[i].outlet_id]=circle_marker;
                  // circle_marker.addTo(map);

                   
                }
                //console.log(marker_cluster_list);
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
		        	//console.log(marker_cluster_list);
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
                           if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {   
                   
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
      if(sst) {
            //alert();
         
                for(i=0;i<res['result']['sst_list'].length;i++)   {
              v=res['result']['sst_list'][i];
               if(v.latitude != '' && v.longitude != '' && v.latitude !==undefined)
               {
                 var greenIcon = L.icon({
                        iconUrl: v.icon,
                        iconSize: [30, 30],
                    });
                    var marker = L.marker([v.latitude, v.longitude], {
                      icon: greenIcon
                  });
                             
                    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
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
                    circle_sst=L.circle([v.latitude, v.longitude], 60000);
                    circle_sst.setStyle({'fillColor':'#f73648','fillOpacity':0,'color':'#f73648'});
                    highway_pop.push(circle_sst);
                    circle_sst.addTo(map);
                    circle_sst.bringToBack();
                    
               }
        } 
         sst_village=res['result']['sst_village'];

              for(i=0;i<sst_village.length;i++)
                {

                //  if(retailer_list[i].beat_name!='Beat1' && retailer_list[i].visit_order!=1)
                  //{

                     var circle_marker = L.circleMarker([sst_village[i].latitude,sst_village[i].longitude], {
                        "radius": 10,
                        "fillColor":sst_village[i].color,
                        "color": sst_village[i].color,
                        "weight": 1,
                        "opacity": 1,
                        "fillOpacity": 1,
                        "stroke": 1,
                       
                    });
                      if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                   circle_marker.bindTooltip(sst_village[i].info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'top'
                              });
                }

                   circle_marker.bindPopup(sst_village[i].info, {
                                  sticky: true,
                                  pane: 'tool',
                                  direction: 'right'
                              });
                  //  circle_marker.bindLabel(12);
                    if(list_of_retailer_highway.hasOwnProperty(sst_village[i].beat_id))                                         
                         list_of_retailer_highway[sst_village[i].beat_id].push(circle_marker); 
                    else
                        { 
                          list_of_retailer_highway[sst_village[i].beat_id]=[];
                       list_of_retailer_highway[sst_village[i].beat_id].push(circle_marker); 
                     }
                    
                        highway_pop.push(circle_marker);

                   circle_marker.id=sst_village[i].village_code;
                   circle_marker.addTo(map);

                  if(sst_village[i]['village_type_id']==1)
                  {
                       circle_marker.on('dblclick', function(e){

                         input_obj['village_id']=e.target.id;
                         initial(input_obj,0,16,false,false,'',false,false,false,false,true);
                             
                        });
                  }
                   var text = L.tooltip({
                          permanent: true,
                          direction: 'center',
                          className: 'textclass'
                      })
                     // .setContent(''+retailer_list[i].visit_order+'')
                    .setContent(''+sst_village[i].visit_order+'')
                      .setLatLng([sst_village[i].latitude,sst_village[i].longitude]);
                      highway_pop.push(text);
                      text.addTo(map);
                      //rpi_tooltip.push(text);
                 // }

                    


                   
                }
       
}
if(retailer && res['result']['highway_retailer']!=undefined && res['result']['highway_retailer']!=null)
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
                     if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
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
                  
                    
                        highway_pop.push(circle_marker);
                       
                       // circle_marker.addTo(map);
                        var featureGroup_cluster = L.featureGroup(highway_pop).addTo(map);
                        map.fitBounds(featureGroup_cluster.getBounds());              
                        overlay_arr['cluster_layer'] = featureGroup_cluster;
                    }
  }  
     if(highway)
     {
         var circlemap_2 = L.easyButton({
        position: 'bottomright',
        states: [{
            stateName: 'Cluster',
            icon: '<i class="fa fa-dot-circle-o"></i>',
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
                   $(".Cluster-active").html('<i class="fa fa-dot-circle-o"></i>');
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
            color: "#f58216",
            weight: (zoomrange >= 16) ? 5 : 1,
            stroke: (zoomrange >= 16) ? 5 : 1,
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
    function featuredblclick_subrd_village(e)
    {
          selected_layer = e.target.feature.properties.ID;
        if(selected_layer!=17147)
            return false;
         else
         {
             input_obj = {
                        'type': 20,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_village':[selected_layer],
                        'initialmap':0
                        
                        };
            initial(input_obj, 0,20, '');
            var backbtn = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-arrow-left',
                title: 'Back',
                onClick: function(control) {
                   removelayer();
                  
                   input_obj = {
                        'type': 20,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_country':[91],
                        'initialmap':0
                        
                        };
            initial(input_obj, 0,20, '');
                }
            }]
        });
         map.addControl(backbtn);
         dynamic_control['rpi_action_1']=[];
         dynamic_control['rpi_action_1'].push(backbtn); 
      
         }
    }
   function featuredblclick(e) {

       
        if (history_map == null)
            history_map = [];
        else
            history_map = history_map;
        selected_layer = e.target.feature.properties.ID;
        next_layer = e.target.feature.properties.nxt_map;
        next_id = e.target.feature.properties.next_id;
        current_level = e.target.feature.properties.current_level;
        main_location = e.target.feature.properties.main_location;
        sub_location = e.target.feature.properties.sub_location;
        loc_level = e.target.feature.properties.nxt_map;
        loc_id = e.target.feature.properties.loc_id;
        current_id = e.target.feature.properties.current_id;
        view_type = e.target.feature.properties.view_type;
        city_id = e.target.feature.properties.city_id;
        if(main_location==16 && sub_location==16)
        {
            alert("Next Location not available.");
            return false;
        }
        else
        {
            menu_list=[];

         $.each($("input[name='list_menu']:checked"), function() {
                   temp={};
                   temp['menu_id']=$(this).attr('menu_id');
                   temp['menu_item_id']=$(this).attr('menu_item_id');
                   temp['level_id']=$(this).attr('level_id');
                   temp['refid']=$(this).val();
                    temp['view_optn']=$(this).attr('view_optn');
                    temp['parent_id']=$(this).attr('parent_id');
                  
                    menu_list.push(temp);
        });

            if(menu_list.length <=0)
            {
               alert("select the menu");
            }
            else
            {
                   
                    input_obj={
                        'type':0,
                        'menu_list':menu_list,
                        'location':city_id,
                        'flag':'C',
                        'city_id':city_id,
                        'loc_level':loc_level,
                        'loc_id':loc_id,
                        'calendar_data':calendar_data
                        
                    };
                    initial(input_obj,0,0,'');
                     history_map.push({
                        'loc_level': current_level,
                        'loc_id': current_id,
                        'city_id':city_id
                        
                    });
                    
                
            }
        }
        


        
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
              if (bubble_data.length > 0 && bubble_layer.length>0) {
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
                if(uncovered_markercluster_mdlz.hasLayer(uncovered_outlet_markerarray[i]))
                {
                    uncovered_markercluster_mdlz.removeLayer(uncovered_outlet_markerarray[i]);
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
     for (i = 0; i < rpi_tooltip.length; i++) {
        if (map.hasLayer(rpi_tooltip[i])) {
            map.removeLayer(rpi_tooltip[i]);
        }
    }
    
    for (i = 0; i < circle_marker_arr.length; i++) {
        if (map.hasLayer(circle_marker_arr[i])) {
            map.removeLayer(circle_marker_arr[i]);
        }
    }
     for (i = 0; i < showpop_temp.length; i++) {
        if (map.hasLayer(showpop_temp[i])) {
            map.removeLayer(showpop_temp[i]);
        }
    }
    

        geo_layer = [];showpop_temp=[];
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
         urban_subrd=[];
         villg_distributor=[];
        villg_subd=[];
        circle_distributor=[];
        circle_subd=[];
        list_of_retailer_highway=[];
        highway_pop=[];
        rpi_tooltip=[];
        circle_marker_arr=[];
        subrd_popup=[];
        rpi_popup=[];
        active_popup=[];
        

        return true;
    }

    function clickOnMapItem(itemId) {
        var id = parseInt(itemId);
        //get target layer by it's id
        var layer = geo_layer[0].getLayer(id);


        //fire event 'click' on target layer 
        layer.fireEvent('dblclick');
    }



   function initial(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false,subrd=false,filter_subrd=false,filter_clientsubrd=false,show_highway_outlet=false,back_sst=false,filter_clientsst=false)  // First - input parameter //second - 1-forward 2-load currentlevel data -1 back
    {

       if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }
       if(input_obj.type==0)
        {
            $.each($("input[name='list_menu']:checked"), function() {
                                   temp={};
                                   temp['menu_id']=$(this).attr('menu_id');
                                   temp['menu_item_id']=$(this).attr('menu_item_id');
                                   temp['level_id']=$(this).attr('level_id');
                                   temp['refid']=$(this).val();
                                   temp['view_optn']=$(this).attr('view_optn');
                                   temp['parent_id']=$(this).attr('parent_id');
                                    menu_list.push(temp);
                        });
            input_obj.menu_list=menu_list;
           
            loaddata = {
                'initialmap': initialmap,
                input: JSON.stringify(input_obj),
                'type': type,
                'filter_so': filter_so,
                'current_location':[current_location['lat'],current_location['lon']],
                'calender_data':calendar_data
            };
        }


       else if (!filter)
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
                    if ($('#mymodal-consolidatedistrict').hasClass('show')) {
                    $("#mymodal-consolidatedistrict").modal('hide');
                    removelayer();

                }
                   if ($('#mymodal-consolidatetaluk').hasClass('show')) {
                    $("#mymodal-consolidatetaluk").modal('hide');
                    removelayer();

                }
                      if ($('#mymodal-subordinate').hasClass('show')) {
                    $("#mymodal-subordinate").modal('hide');
                    removelayer();

                }
                  if ($('#mymodal-taluk_state_wholesaler').hasClass('show')) {
                    $("#mymodal-taluk_state_wholesaler").modal('hide');
                    removelayer();

                }
                 if($("#mymodal-villagedistrict").hasClass('show'))
                {
                     $("#mymodal-villagedistrict").modal('hide');
                    removelayer();
                }
                 if($("#mymodal-villagetaluk").hasClass('show'))
                {
                     $("#mymodal-villagetaluk").modal('hide');
                    removelayer();
                }
                 if ($('#mymodal-beat').hasClass('show')) {
                    $("#mymodal-beat").modal('hide');
                    removelayer();

                }
                if ($('#mymodal-nbhrd_list').hasClass('show')) {
                    $("#mymodal-nbhrd_list").modal('hide');
                    removelayer();

                }
                
                 if($("#mymodal-state_highwaylist").hasClass('show'))
                {
                     $("#mymodal-state_highwaylist").modal('hide');
                    removelayer();
                }
               if ($('#mymodal-district,#mymodal-district_zerorla').hasClass('show')) {
                    $("#mymodal-district,#mymodal-district_zerorla").modal('hide');
                    removelayer();

                }

                if($("#mymodal-taluk,#mymodal-taluk_zerorla").hasClass('show'))
                {
                     $("#mymodal-taluk,#mymodal-taluk_zerorla").modal('hide');
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
                if($("#mymodal-beatdistrict").hasClass('show'))
                {
                     $("#mymodal-beatdistrict").modal('hide');
                    removelayer();
                }
                 if($("#mymodal-sstsubrdbeat").hasClass('show'))
                {
                    $("#mymodal-sstsubrdbeat").modal('hide');
                    removelayer();
                }
                 if($("#mymodal-sstbeatdistrict").hasClass('show'))
                {
                     $("#mymodal-sstbeatdistrict").modal('hide');
                    removelayer();
                }
                if($("#mymodal-RD_list").hasClass('show'))
                {
                     $("#mymodal-RD_list").modal('hide');
                    removelayer();
                }
                if($("#mymodal-rdbeat").hasClass('show'))
                {
                     $("#mymodal-rdbeat").modal('hide');
                    removelayer();
                }
                 if($("#mymodal-filterchannel").hasClass('show'))
                {
                     $("#mymodal-filterchannel").modal('hide');
                  
                }
                 if($("#mymodal-country_data").hasClass('show'))
                {
                     $("#mymodal-country_data").modal('hide');
                    removelayer();
                }
                  if($("#mymodal-sst_list").hasClass('show'))
                {
                     $("#mymodal-sst_list").modal('hide');
                    removelayer();
                }
                
                if(show_highway_outlet)
                    removelayer();
                
           
                if(type==12 || type==13 || type==14 || type==11 || type==15  || type==19 || type==21 || type==22 || type==0 || type==23 || type==24  || type==25 || type==28){
                    if(type==12 || type==26 || type==28)                       
                        villg_subrd=res['child_list'];
                  removelayer();
                  
                 
                }
                
                if(type==0)
                    {
                       legendremove();
                        $("#maphead").html('<div class="center-maphead">  <div class="text-maphead">'+res['head']+'</div> <div class="text-tooltip-maphead">'+res['head']+'</div></div>');
                        legend(res['maplegend'],0);
                        loadmap(res, '');
                        changeproperty(res, type);
                        tablebuild(res,type);
                        if(history_map.length>0)
                 {
                    var backbut1 = L.easyButton({
                        position: 'bottomright',
                        states: [{
                            stateName: 'globe-layer',
                            icon: 'fa-arrow-left',
                            title: 'globe',
                            onClick: function(control) {
                          
                                    if (history_map.length > 0) {
                                        i = history_map.length - 1;
                                        loc_level = history_map[i].loc_level;
                                        loc_id = history_map[i].loc_id;
                                         city_id = history_map[i].city_id;
                                             

                                             history_map.pop();


                                          // current_maplevel[0]=({
                                          //           'loc_level': loc_level,
                                          //           'loc_id': loc_id,
                                          //           'city_id':city_id
                                                    
                                          //       });
                                         menu_list=[];
                                         $.each($("input[name='list_menu']:checked"), function() {
                                                   temp={};
                                                   temp['menu_id']=$(this).attr('menu_id');
                                                   temp['menu_item_id']=$(this).attr('menu_item_id');
                                                   temp['level_id']=$(this).attr('level_id');
                                                   temp['refid']=$(this).val();
                                                   temp['view_optn']=$(this).attr('view_optn');
                                                   temp['parent_id']=$(this).attr('parent_id');
                                                    menu_list.push(temp);
                                        });

                                        if(menu_list.length <=0)
                                        {
                                           alert("select the menu");
                                        }
                                        else
                                        {
                                               
                                                input_obj={
                                                    'type':0,
                                                    'menu_list':menu_list,
                                                    'location':city_id,
                                                    'flag':'C',
                                                    'city_id':city_id,
                                                    'loc_level':loc_level,
                                                    'loc_id':loc_id,
                                                      'calendar_data':calendar_data
                    
                                                    
                                                };

            
                                                
                                                initial(input_obj,0,0,'');
                                                
                                        }

                                         
                                    }
                                       
                                     
                            }
                        }]
                    });
                    map.addControl(backbut1);
                    dynamic_control['rpi_action'].push(backbut1); 
                 }

                       
                     
                       
                    }

                    if($.inArray(type,[20,21,22])!=-1)
            {
                  removelayer();
                  geo_layer=[];

                  if((input_obj.filter_country!=undefined && input_obj.filter_country!=null))
                  {
                     for (i_ = 0; i_ < dynamic_control['rpi_action_1'].length; i_++) {
                          map.removeControl(dynamic_control['rpi_action_1'][i_]);
                         }
                         dynamic_control['rpi_action_1']=[];
                         
                  }
            }
             else if(type==21 || type==22){
                      legendremove();
                            //legend(res['legend'],type);
                           //loadmap(res, '',false,true);
                              loadmap(res, '');
                    }

                if (isEmpty(geo_layer) && (type !=5 && type!=6 && type!=7 && type!=8 && type!=9 && type!=10 && type!=11 && type!=0 && type!=21 && type!=22  && type!=24)) {      
                    
                   
                    if($.inArray(type,[12,20,25,26,28])!=-1)
                    {
                        removelayer();
                        legendremove();
                       loadmap(res, '');
                       if(rpi_action!='')
                          $(".state-" + rpi_action).click();
                      $("#maphead").html('<div class="center-maphead">  <div class="text-maphead">'+res['head']+'</div> <div class="text-tooltip-maphead">'+res['head']+'</div></div>');
                       legend(res['maplegend']);
                    }
                    else if(type==13){
                        removelayer();
                      loadmap(res, '',true);
                      legend(13);
                    }
                    else if(type==14){
                        removelayer();
                      legendremove();
                            legend(res['legend']);
                           loadmap(res, '',false,true);
                    }
                    else if(type==15 || type==23){
                            removelayer();
                            loadmap(res, '',false,true); 
                           // legend(type);
                            
                    }
                     else if(type==19){
                      legendremove();

                            legend(type);
                           //loadmap(res, '',false,true);
                              loadmap(res, '');
                    }

                     else if(type==16){
                       
                       if(res['status']==0){
                         $("#showdata").css("display", "none");
                         alert(res['message']);
                       }
                      
                     else
                     {
                        removelayer();
                         legend(type);
                      if(show_highway_outlet)
                        loadmap(res, '',false,false,false,true);
                      else
                        loadmap(res, '',false,false,true);
                     }

                           
                    }
                     else if(type==17 ||type==24){
                       
                      legendremove();
                      loadmap(res, '',false,false,false,false,true);
                      legend(type);
                      if(("{{Auth::user()->role}}") != 'Country-HO')
                      {
                        if(filterid!=2 && filterid!=3)
                            dynamic_control[11].enable();

                      }
                       
                    }



                    //changeproperty(res, type);
                }
               
               


                if (!isEmpty(res['maplist'])) {

                    Globalobject[0] = res["tbl"];

                    $("#maphead").html('<div class="center-maphead">  <div class="text-maphead">'+res['head']+'</div> <div class="text-tooltip-maphead">'+res['head']+'</div></div>');
                    if (filter) {
                        removelayer();
                        if (res.hasOwnProperty('griddata')) {
                          if(type==13)
                            loadmap(res, '',true);
                         else if(type==15 || type==23){
                            loadmap(res, '',false,true); 
                           
                            
                           }
                           else if(type==14){
                                    loadmap(res, '',false,true);

                           }
                           else if(type==16)
                           {
                            
                              loadmap(res, '',false,false,true);
                           }
                      
                          else
                            loadmap(res, '');
                          if(type!=13 && type!=14 && type!=16 && type!=17 && type!=0  && type!=21 && type!=22 && type!=15 && type!=23  && type!=24){
                          	changeproperty(res, type);
                          	legendremove();
                            if(type==19)
                                 legend(type);
                            else
                                 legend(res['maplegend']);
                          }
                            
                            tablebuild(res, type);
                            
                        }
                        $('#mymodal-filter').modal('hide');
                    } else {
                       

                        if (res.hasOwnProperty('griddata')) {
                           if(type!=13 && type!=14 && type!=16 && type!=17 && type!=0 && type!=15 && type!=22 && type!=15 && type!=23  && type!=24){
                           	 changeproperty(res, type);
                           	 legendremove();
                            if(type==19)
                                 legend(type);
                            else
                                 legend(res['maplegend']);
                           }
                           if(type==17 || type==24)
                           {
                                removelayer();
                                legendremove();
                                legend(type);
                                loadmap(res, '',false,false,false,false,true);
                                 if(filterid!=2 && filterid!=3)
                                         dynamic_control[11].enable();
                               
                           }
                           
                            tablebuild(res, type);
                            
                             $("#maphead").html('<div class="center-maphead">  <div class="text-maphead">'+res['head']+'</div> <div class="text-tooltip-maphead">'+res['head']+'</div></div>');
                        }
                    }
                }
                else {
                       

                        if (res.hasOwnProperty('griddata') && type!=0 && type!=13) {


                            changeproperty(res, type);
                            tablebuild(res, type);
                            legendremove();
                             if(filter){
                                $(".close").click();
                                $('#filter_bychannel').modal('hide');
                             }
                             if(type==9)
                             {
                                // dynamic_control[0].enable();
                                // dynamic_control[1].enable();
                                
                             }
                             // else
                             // {
                             //     dynamic_control[0].disable();
                             //    dynamic_control[1].disable();
                             // }
                             if(type==11)
                             {
                               legendremove();
                             //  console.log(input_obj.filter_bycluster);
                               if(input_obj.filter_bycluster !== undefined)
                                if(input_obj.filter_bycluster.length > 0)
                                  legend(type);

                             }
                             if(type==14)
                             {
                               legend(res['legend']);

                             }
                             //  if(type==15 || type==23)
                             // {
                             //   legend(type);

                             // }
                              if(type==17 || type==24)
                           {
                                removelayer();
                                legendremove();
                                legend(type);
                                loadmap(res, '',false,false,false,false,true);
                                 tablebuild(res, type);
                                 if(("{{Auth::user()->role}}") != 'Country-HO')
                                      if(filterid!=2 && filterid!=3)
                                         dynamic_control[11].enable();
                                
                           }
                            if(type==21 || type==22)
                           {
                                removelayer();
                                
                                loadmap(res, '',false);
                                 tablebuild(res, type);
                                
                           }
                             else
                             legend(type);
                             $("#maphead").html('<div class="center-maphead">  <div class="text-maphead">'+res['head']+'</div> <div class="text-tooltip-maphead">'+res['head']+'</div></div>');
                           // legend(res['maplegend']);
                        }
                       
                    }
                }
                 if(show_highway_outlet || back_sst)
                {
                      dynamic_control['rpi_action']=[];
           
        var backbtn = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-arrow-left',
                title: 'Back',
                onClick: function(control) {
                   removelayer();
                    filter_sstbeat_district = [];filter_sstsubrdbeat = [];
                     

                    $.each($("input[name='sstsubrd_beat']:checked"), function() {
                        filter_sstsubrdbeat.push($(this).val());
                    });
                    $.each($("input[name='sst_districtlistbeat']:checked"), function() {
                        filter_sstbeat_district.push($(this).val());
                    });
                   
                    input_obj = {
                        'type': 16,
                        'filter_sstbeat_district':filter_sstbeat_district,
                        'filter_sstsubrdbeat':filter_sstsubrdbeat,
                        'fit_bounds':true
                    };


                   initial(input_obj, 0,16, false,false,'',false,true);


                   

                }
            }]
        });
        map.addControl(backbtn);
         dynamic_control['rpi_action'].push(backbtn); 
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
                   
                     if(filter_clientsubrd)
                   {
                        input_obj = {
                        'type': input_obj.type,
                       
                    };


                    initial(input_obj, 0,input_obj.type, false,false,'',false,true,true);
                   }
                   if(filter_clientsst)
                   {
                        input_obj = {
                        'type': input_obj.type,
                        'filter_sstbeat':input_obj.filter_sstbeat
                       
                    };


                    initial(input_obj, 0,input_obj.type, false,false,'',false,true,false);
                   }
                   else
                   {
                        filter_subrdbeat = [];filter_district=[];
                     $.each($("input[name='districtlistbeat']:checked"), function() {
                        filter_district.push($(this).val());
                    });
                    if(filter_district.length <=0){
                         $.each($("input[name='subrd_beat']:checked"), function() {
                        filter_subrdbeat.push($(this).val());
                    });
                    }
                   
                   


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
                        'filter_subrd':filter_subrdbeat,
                        'filter_subrdbeat_district':filter_district
                    };


                    initial(input_obj, 0,14, false,false,'',false,true);
                   }

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
    function show_result(data){
        
            city_id=$(data).val();
            if($(data).attr("type")==3)
            {
                type=$(this).attr("id");
              menu_name=$(this).text();
              ajax_action(type,menu_name,'Getchild');
            }
            else
            {
                 location_list[0]=city_id;
                $("#mymodal-citylist").modal('show');
                $("#mymodal-listmenu").modal('hide');
                 menu_list=[];

                 $.each($("input[name='list_menu']:checked"), function() {
                           temp={};
                           temp['menu_id']=$(this).attr('menu_id');
                           temp['menu_item_id']=$(this).attr('menu_item_id');
                           temp['level_id']=$(this).attr('level_id');
                           temp['refid']=$(this).val();
                           temp['view_optn']=$(this).attr('view_optn');
                           temp['parent_id']=$(this).attr('parent_id');
                          menu_list.push(temp);
                });
            
             if(menu_list.length > 0)
            {    
                input_obj={
                        'type':0,
                        'menu_list':menu_list,
                        'location':location_list[0],
                        'flag':'C',

                };
                $("#mymodal-citylist").modal('hide');
                  
                if(Object.keys(calendar_data).length>0)
                     input_obj['calendar_data']=calendar_data;
                
                if(input_obj['calendar_data']!=undefined && input_obj['calendar_data']!=null && input_obj['calendar_data']!='')
                {
                  
                     //      if(current_maplevel[0]!=null && current_maplevel[0]!=undefined)
                     //      {
                     //              input_obj['location']=current_maplevel[0]['city_id'];
                     //              input_obj['city_id']=current_maplevel[0]['city_id'];
                     //              input_obj['loc_level']=current_maplevel[0]['loc_level'];
                     //              input_obj['loc_id']=current_maplevel[0]['loc_id'];
                     //      }
                         
                     
                      initial(input_obj,0,0,'');

                }
                else
                {
                    $('#prdSelect').modal('show');
                }
                 
            }
            else
            {

                 alert("select the menu");
            }
        }   
 } 
     function show_diagnois(data)
        {
            $("#showmenu_result").click();
            $.each(menu_list,function(k,v){
                  menu_list[k]['diagonis']=$(data).attr('id');
            })
           
        }
    $("doucment").ready(function() {
         $("#filter_bycountrydata").click(function(){
                filter_beat= []; filter_bydistrict=[];

                    $.each($("input[name='pre_level']:checked"), function() {
                        filter_beat.push($(this).val());
                    });
                    $.each($("input[name='post_level']:checked"), function() {
                        filter_bydistrict.push($(this).val());
                    });
                    input_obj = {
                        'type': 17,
                        'filter_beat':filter_beat,
                        'filter_bydistrict':filter_bydistrict
                    };
                     initial(input_obj, 0,17, '');

        });
       if (("{{Auth::user()->user_type}}") == 'TSM' && ("{{Auth::user()->client_id}}") != 100) {
         //$("#mymodal-district").modal('show');
        $("#showmenu_result").click(function(){

            
             menu_list=[];
             $.each($("input[name='list_menu']:checked"), function() {
                       temp={};
                       temp['menu_id']=$(this).attr('menu_id');
                       temp['menu_item_id']=$(this).attr('menu_item_id');
                       temp['level_id']=$(this).attr('level_id');
                       temp['refid']=$(this).val();
                       temp['view_optn']=$(this).attr('view_optn');
                       temp['parent_id']=$(this).attr('parent_id');
                      
                        menu_list.push(temp);
            });

            if(menu_list.length <=0)
            {
               alert("select the menu");
            }
            else
            {
                $("#mymodal-listmenu").modal('hide');
                if(input_obj['location']!=undefined && input_obj['location']!=null && input_obj['location']!='')
                {
                    if(input_obj['calendar_data']!=undefined && input_obj['calendar_data']!=null && input_obj['calendar_data']!='')
                    {
                        if(current_maplevel[0]!=null && current_maplevel[0]!=undefined)
                          {
                                  input_obj['location']=current_maplevel[0]['city_id'];
                                  input_obj['city_id']=current_maplevel[0]['city_id'];
                                  input_obj['loc_level']=current_maplevel[0]['loc_level'];
                                  input_obj['loc_id']=current_maplevel[0]['loc_id'];
                                  initial(input_obj,0,0,'');               
                          }
                    }                   
                              
                    else
                         $('#prdSelect').modal('show');
                }
                else
                    $("#mymodal-citylist").modal('show');
            }
            
            
        });
         $("#filter_byRD").click(function(){
                filter_rd= [];

                    $.each($("input[name='rdbeat']:checked"), function() {
                        filter_rd.push($(this).val());
                    });
                    input_obj = {
                        'type': 17,
                        'filter_rd':filter_rd
                    };
                    if(("{{Auth::user()->client_id}}")==0)
                        input_obj.type_id=(filterid.length>0) ? filterid[0] : 0;

                     initial(input_obj, 0,17, '');

        });
         $("#back_nbhrd").click(function(){
            nbhrd_id=(filterid.length>0) ? filterid[0] : 2;
             $("#mymodal-nbhrd_list").modal("hide");
            if(nbhrd_id==2)
                 $("#mymodal-city_delhi").modal("show");
             else
                 $("#mymodal-city_remain").modal("show");

         });
         $("#filter_bynbhrd").click(function(){

                filter_rd= [];
                dynamic_control[11].disable();

                    $.each($("input[name='nbhrd_name']:checked"), function() {
                        filter_rd.push($(this).val());
                    });
                    input_obj = {
                        'type': 17,
                        'filter_rd':filter_rd,

                    };
                    input_obj.type_id=(filterid.length>0) ? filterid[0] : 0;

                     initial(input_obj, 0,17, '');

        });
         
        $("#filter_byrdbeat").click(function(){
                filter_beat= [];filter_rd=[];

                    $.each($("input[name='rd_beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });
                     $.each($("input[name='rdbeat']:checked"), function() {
                        filter_rd.push($(this).val());
                    });
                    input_obj = {
                        'type': 17,
                        'filter_rd':filter_rd,
                        'filter_beat':filter_beat
                    };
                     initial(input_obj, 0,17, '');

        });
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
          $("#filter_bysstbeatdist").click(function(){
            filter_sstbeat_district = [];

                    $.each($("input[name='sst_districtlistbeat']:checked"), function() {
                        filter_sstbeat_district.push($(this).val());
                    });
                   
                    input_obj = {
                        'type': 16,
                        
                        'filter_sstbeat_district':filter_sstbeat_district,
                        'filter_sstsubrdbeat':[]
                    };


                   initial(input_obj, 0,16, false,false,'',false,true);


         });
            $("#filter_bysstsubrdbeat").click(function() {
          //  dynamic_control[5].disable();
                    filter_sstsubrdbeat = [];

                    $.each($("input[name='sstsubrd_beat']:checked"), function() {
                        filter_sstsubrdbeat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 16,
                        'filter_sstsubrdbeat':filter_sstsubrdbeat
                    };


                    initial(input_obj, 0,16, false,false,'',false,true);


                });
         $("#filter_bybeatdist").click(function(){
            filter_subrdbeat_district = [];

                    $.each($("input[name='districtlistbeat']:checked"), function() {
                        filter_subrdbeat_district.push($(this).val());
                    });
                    filter_subrdbeat=[];
                    input_obj = {
                        'type': 14,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_subrdbeat':[],
                        'filter_subrdbeat_district':filter_subrdbeat_district,
                        'filter_subrd':filter_subrdbeat
                    };


                    initial(input_obj, 0,14, false,false,'',false,true);


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
          $("#filter_bysstbeat").click(function() {
          //  dynamic_control[5].disable();
                    filter_sstbeat = [];

                    $.each($("input[name='sst_beat']:checked"), function() {
                        filter_sstbeat.push($(this).val());
                    });


                    // so_id=$("input[name='subordinate']:checked").val();
                    // console.log(so_id);
                    // filter_so=so_id;


                    input_obj = {
                        'type': 23,
                       
                        'filter_sstbeat':filter_sstbeat
                    };


                    initial(input_obj, 0,23, false,false,'',false,true);


                });

        $("#filter_byhighway,#state_highwaylist").click(function(){
            // // multiple_state='<?php echo $multiple_state;?>';
            // // if(multiple_state)
            // // {
            // //     alert(multiple_state);
            // //         filter_highway=[];
            // //         state_id=$("input[name='highwaystate_list']:checked").val();
                    
            // //         $.each($("highwaylist_"+state_id+" > input[name='highwaylist']:checked"), function() {
            // //               filter_highway.push($(this).val());
            // //   });

            // // }
            // else{
                 highway_list_id=$(this).attr("id");

                    filter_highway=[];
                    if(highway_list_id=='filter_byhighway')
                        $.each($("input[name='highwaylist']:checked"), function() {
                              filter_highway.push($(this).val());
                         });
                    if(highway_list_id=='state_highwaylist')
                        $.each($("input[name='statehighwaylist']:checked"), function() {
                              filter_highway.push($(this).val());
                         });
           // }
                   
                     input_obj = {
                        'type': 13,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_highway':filter_highway,
                        'highway_list_id':highway_list_id
                        
                        };
                        //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
                        initial(input_obj, 0,13, false,false,'',true);
        });
          $("#filter_byvillagedist,#filter_byvillagetaluk").click(function(){
      //  dynamic_control[5].disable();
        filter_dist=[];filter_taluk=[];check_district=[];check_district[0]=0;
        id=$(this).attr('id');


        input_obj = {
                        'type': 25,
                      
                        'filter_byvillagedist':[]
                        
                        
                        };
        if(id=='filter_byvillagedist')
           {
              $.each($("input[name='villagedistrictlist']:checked"), function() {
                          filter_dist.push($(this).val());
              });
               input_obj['filter_byvillagedist']=filter_dist;
      
           }
          if(id=='filter_byvillagetaluk')
          {
               
             $.each($("input[name='village_taluklist']:checked"), function() {

               filter_taluk.push($(this).val());
                       
                       
            });
            input_obj['filter_byvillagetaluk']=filter_taluk;
            
          }     

          initial(input_obj, 0,25, '');

      });

           $("#zerofilter_bydist,#zerofilter_bytaluk").click(function(){
      //  dynamic_control[5].disable();
        filter_dist=[];filter_taluk=[];check_district=[];check_district[0]=0;
        id=$(this).attr('id');
console.log(id);

        input_obj = {
                        'type': 26,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                        'filter_district':filter_dist,
                       
                        
                        };

        if(id=='zerofilter_bydist')
           {
              $.each($("input[name='zerodistrictlist']:checked"), function() {
                          filter_dist.push($(this).val());
                          console.log(filter_dist);
              });
               input_obj['filter_district']=filter_dist;
      
           }
          if(id=='zerofilter_bytaluk')
          {
               
             $.each($("input[name='zerotaluklist']:checked"), function() {
               filter_taluk.push($(this).val());
                       
                       
            });
            input_obj['filter_taluk']=filter_taluk;
            
          }     

          initial(input_obj, 0,26, '');

      });
             $("#filter_byconsolidatedist,#filter_byconsolidatetaluk").click(function(){
      //  dynamic_control[5].disable();
        filter_dist=[];filter_taluk=[];check_district=[];check_district[0]=0;
        id=$(this).attr('id');


        input_obj = {
                        'type': 28,
                        'filter_pc': [],
                        'filter_distributor': [],
                        'filter_so': [],
                        'filter_beat':[],
                       
                       
                        
                        };
        if(id=='filter_byconsolidatedist')
           {
              $.each($("input[name='consolidate_districtlist']:checked"), function() {
                          filter_dist.push($(this).val());
              });
               input_obj['filter_byconsolidatedist']=filter_dist;
      
           }
          if(id=='filter_byconsolidatetaluk')
          {
               
             $.each($("input[name='consolidate_taluklist']:checked"), function() {
               filter_taluk.push($(this).val());
                       
                       
            });
            input_obj['filter_byconsolidatetaluk']=filter_taluk;
            
          }     

          initial(input_obj, 0,28, '');

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
       //   $("#mymodal-beat").modal('show');
            $("#filter_bybeat").click(function() {
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
                         'show_cluster':show_cluster[0]
                    };
                    if(("{{Auth::user()->client_id}}")==115)
                        input_obj['filter_datatype']=show_cluster[1];


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
             if(("{{Auth::user()->client_id}}")==120)
             {
        
                if($.inArray(parseInt(type),[12,13,14,15,16,19,21,22,24,28]) != -1)
                {
                    user_activity(type);
                }
             }
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

              show_cluster_=$(this).attr("cluster");
               if(("{{Auth::user()->client_id}}")==115)
                 {

                      show_data_type=$(this).attr("data_type");
                     $('input[name="tag_list"]').each(function() {

                         $(this).prop('checked', false);
                         $(this).parent().parent().hide();

                         if($(this).attr("data_type")==show_data_type){
                            $(this).parent().parent().show();
                            $(this).prop('checked', true);
                         }
                            
                      });
                      input_obj.filter_datatype=show_data_type;
                      show_cluster[1]=show_data_type;
                      $('#mymodal-city_RD').modal('show');
                 }
                 else if(("{{Auth::user()->client_id}}")==1)
                     $('#mymodal-city_RD').modal('show');
                 else
                 {
                    if(("{{Auth::user()->client_id}}")==123  || ("{{Auth::user()->client_id}}")==0 || ("{{Auth::user()->client_id}}")==1000)
                        {
                             if(("{{Auth::user()->client_id}}")==123)
                                    $("#beat_city_name").html("Select City");
                    $("#back_city").hide();
                }

                    $('#mymodal-beat').modal('show');
                 }
                    
                 
                 
              //
                input_obj.filter_beat=filter_beat;
                show_cluster[0]=show_cluster_;
                console.log(show_cluster[0]);
                // initial(input_obj, 2, type);
            }
            if(type==23)
            {
               
                $('#mymodal-sst_state_beat').modal('show');
            }
               if(type==25)
            {
                 showstate='<?php echo $multiple_state;?>';

                  if(showstate==true) 
                  {
                    $('#mymodal-villagemap_state').modal('show');
                  }
                    
                 else
                 {
                    state='<?php echo json_encode($taluk_list);?>';
                    district='<?php echo json_encode($user_district);?>';
                    state=JSON.parse(state);district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
                     $.each(state, function(k, v) {
                        
                            ajax_action(k,'/'+v+'/','Get_villagedistrict',district_);
                    });
                   
                     // $('#mymodal-district').modal('show');
                 }
               type_view[0]=$(this).attr('type');
            }
              if(type==28)
            {
               
                 showstate='<?php echo $multiple_state;?>';
                  if(showstate==true) 
                  {
                    $('#mymodal-consolidate_taluk_state').modal('show');
                  }
                    
                 else
                 {
                    state='<?php echo json_encode($taluk_list);?>';
                    district='<?php echo json_encode($user_district);?>';
                    state=JSON.parse(state);district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
                     $.each(state, function(k, v) {
                        
                            ajax_action(k,'/'+v+'/','Get_consolidatesubrddistrict',district_);
                    });
                   
                     // $('#mymodal-district').modal('show');
                 }
               
                 type_view[0]=$(this).attr('type');
            }
            if (type == 12 &&  ("{{Auth::user()->role}}") != 'Country-HO')
            {
                type_view[0]=$(this).attr('type');
                 showstate='<?php echo $multiple_state;?>';

                  if(showstate==true) 
                  {
                    if(type_view[0]==3)
                         $('#mymodal-taluk_state_wholesaler').modal('show');
                    else
                         $('#mymodal-taluk_state').modal('show');
                  }
                    
                 else
                 {
                    state='<?php echo json_encode($taluk_list);?>';
                    district='<?php echo json_encode($user_district);?>';
                    state=JSON.parse(state);district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
                     $.each(state, function(k, v) {
                        
                            ajax_action(k,'/'+v+'/','Get_subrddistrict',district_);
                    });
                   
                     // $('#mymodal-district').modal('show');
                 }
                   
            
               
               type_view[0]=$(this).attr('type');
              // dynamic_control[10].enable();
             //  dynamic_control[11].disable();


            }
            if (type == 26 )
            {
                 $('#mymodal-taluk_state_zerorla').modal('show');
                


            }
            if (type == 20 &&  ("{{Auth::user()->role}}") == 'Country-HO')  {  
                 input_obj = {
                                'type': 20,
                                'filter_pc': [],
                                'filter_distributor': [],
                                'filter_so': [],
                                'filter_beat':[],
                                'filter_country':[91],
                                'initialmap':0
                                
                                };
              initial(input_obj, 0,20, '');
              
                
           }
           if (type == 21 || type==22)  {  
                 input_obj = {
                                'type': parseInt(type)
                                
                                
                                };
              initial(input_obj, 0,parseInt(type), '');
              for (i_ = 0; i_ < dynamic_control['rpi_action_1'].length; i_++) {
                          map.removeControl(dynamic_control['rpi_action_1'][i_]);
                         }
                         dynamic_control['rpi_action_1']=[];
                         
              
                
           }
          
           if(type==13)
            {
                highway_type=$(this).attr("highway_type");
              
                showstate='<?php echo $multiple_state;?>';
                if(highway_type==2)
                    $('#mymodal-state_highway').modal('show');
                else
                {
                            //  if(showstate==true)
                                 
                            // else{
                            //     state='<?php echo json_encode($highway_list);?>';
                            //     $('#mymodal-highway').modal('show');
                            //     state=JSON.parse(state);
                            //     $.each(state, function(k, v) {
                                    
                            //             ajax_action(k,'/'+v+'/','Get_highway');
                            //     });
                            // }
                            $('#mymodal-highway_state').modal('show');
                }

               
               
            

            }
            if(type==14)
            {
                showstate='<?php echo $multiple_state;?>';
                if(showstate==true)
                    $('#mymodal-beat_state').modal('show');
                else{
                     state='<?php echo json_encode($subrd_beat);?>';
                    district='<?php echo json_encode($user_district);?>';
                    state=JSON.parse(state);district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
                     $.each(state, function(k, v) {
                        
                            ajax_action(k,'/'+v+'/','Getsubrd_district',district_);
                    });
                  //  $('#mymodal-subrdbeat').modal('show');
                }
               //$('#mymodal-subrdbeat').modal('show');
               
            }
              if (type == 15 || type==19 ) {

      input_obj = {
         'type': type,

      };
      initial(input_obj, type, type);

   }
              if (type == 16) {
    $('#mymodal-SST_beat_state').modal('show');
      showstate = '<?php echo $multiple_state;?>';
      if (showstate == true)
         $('#mymodal-SST_beat_state').modal('show');
      else {
         state = '<?php echo json_encode($sst_beat);?>';
         district = '<?php echo json_encode($user_district);?>';
         state = JSON.parse(state);
         district_ = [];
         district = JSON.parse(district);

         $.each(district, function (k, v) {
            district_.push(v);
         });


         $.each(state, function (k, v) {

            ajax_action(k, '/' + v + '/', 'GetSST_district', district_);
         });
         //  $('#mymodal-subrdbeat').modal('show');
      }
   }
    if (type == 17 &&  ("{{Auth::user()->role}}") != 'Country-HO') {

        filterid=[];
        if(("{{Auth::user()->client_id}}")==0 )
        {

            filterid.push($(this).attr('type_id'));
           
            if(filterid[0]==1)           
                $('#mymodal-city_RD').modal('show');
            
            if(filterid[0]==2)          
                $('#mymodal-city_delhi').modal('show');
         
            if(filterid[0]==3)          
                $('#mymodal-city_remain').modal('show');
           
        }
        else
        {
            $('#mymodal-city_RD').modal('show');
        }
    
     
   }
   if (type == 17 &&  ("{{Auth::user()->role}}") == 'Country-HO')  {  
        ajax_action(0, '', 'get_nextlevel');
        $("#country_level_view").html("Select Country");
        $('#mymodal-country_data').modal('show');
        $('#country_back,#country_filter').hide();

        
   }
   if (type == 0) // Menu section
   {
    
      type=$(this).attr("menu_id");
      menu_name=$(this).text();
      view_optn=$(this).attr("view_optn");
     $(".show_case_result ").each(function(){
        $(this).removeClass("selected_menu");
      })
     $(this).addClass("selected_menu");

      ajax_action(type,menu_name,'Getchild',[],view_optn);
      


   }
    if (type == 24) // Menu section
   {
      input_obj={
        'type':24,'filter_rd':[]
      };
        initial(input_obj, type, type);
      


   }
      if(type!=15 && type!=14 && type!=13 && type!=12 && type!=11 && type!=9 && type!=16 && type!=17 && type!=0 && type!=20 && type!=21 && type!=23 && type!=24)
            initial(input_obj, type, type);
            


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
    function closeicon(data)
    {
        id=$(data).attr("id");
       
        if(layer_bound[id] != undefined && layer_bound[id]!=null)
        layer_bound[id].closePopup();
        if(subrd_popup[id] != undefined && subrd_popup[id]!=null)
            subrd_popup[id].closePopup();
         if(rpi_popup[id] != undefined && rpi_popup[id]!=null)
            rpi_popup[id].closePopup();
         if(active_popup[id] != undefined && active_popup[id]!=null)
            active_popup[id].closePopup();
        if(showarray[id] != undefined && showarray[id]!=null)
            showarray[id].closePopup();

        
    }
    function changeproperty(res, type) {

        if (type != 4 && type !=5 && type !=6 && type!=7 && type!=8 && type!=9 && type!=10 && type!=11 && type!=12 && type!=20 && type!=13 && type!=0 && type!=26 && type!=28) {

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

         if($.inArray(type,[12,0,20,25,26,28])!=-1)
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
      if(input_obj.type==26)
      {
          var featureGroup = L.featureGroup(bubble_data);
          map.fitBounds(featureGroup.getBounds());          
             overlay_arr['geolayer'] = featureGroup;
         overlay_arr['circlelayer'].addTo(map);
      }
    layer_enable={"active":0,"initiated":0,"activated":0,"deactivated":0,"recomand_subrd":0,"exist_subrd":0,"whole_subrd":0,"urban_subrd":0,"villg_distributor":0,"villg_subd":0,"cicle_subrd":0,"circle_distributor":0};
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
        if($.inArray(parseInt(type),[20])==-1)
        {
            var rpi_button = L.easyButton({
                    position: 'bottomright',
                    states: [{
                        stateName: 'Rpi',
                        icon: '<img src="rural_icon/rpi-overlay.png" width="20px" height="20px"/>',
                        title: 'RPI Show/Hide',
                        onClick: function(control) {
                            zoomrange = map.getZoom();


                           if(map.hasLayer(dynamic_control["rpi_tool"])){
                            
                               if(rpi_tooltip.length>0)
                                {                                    
                                     dynamic_control["rpi_tool"].remove(map);
                                }
                                rpi_show_hide=false;
                               $(".Rpi-active").html('');
                               $(".Rpi-active").html('<img src="rural_icon/rpi-overlay-off.png" width="20px" height="20px"/>');
                           
                               
                           }
                           else
                           {
                               if(rpi_tooltip.length>0 && zoomrange>=10)
                                {                                    
                                     dynamic_control["rpi_tool"].addTo(map);
                                }
                                rpi_show_hide=true;
                                $(".Rpi-active").html('');
                               $(".Rpi-active").html('<img src="rural_icon/rpi-overlay.png" width="20px" height="20px"/>');
                           }

                        }
                    }]
                });
            map.addControl(rpi_button);
            dynamic_control['rpi_action'].push(rpi_button); 
        }
             
 
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
      if(villg_subd.length>0){

      var villg_subd_layer = L.layerGroup(villg_subd);
      overlays["villg_subd"]=villg_subd_layer;
      overlay_arr['villg_subd'] =villg_subd_layer;
      rpi_layer.push(villg_subd_layer);      

      var villg_subd_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Active',
              icon: '<img src="rural_icon/efficient-subrd.png" width="20px" height="20px"/>',
              title: 'Sub-Distributor',
              onClick: function(control) {

                 if(layer_enable["villg_subd"] == 0){
                    overlay_arr['villg_subd'].addTo(map);
                    layer_enable["villg_subd"]=1;
                 }
                 else
                 {
                    overlay_arr['villg_subd'].remove(map);
                    layer_enable["villg_subd"]=0;
                 }
                  
              }
          }]
      });
      map.addControl(villg_subd_button);

    dynamic_control['rpi_action'].push(villg_subd_button); 

    }
    
     if(circle_subd.length>0){

      var circle_subd_layer = L.layerGroup(circle_subd);
      overlays["circle_subd"]=circle_subd_layer;
      overlay_arr['circle_subd'] =circle_subd_layer;
      rpi_layer.push(circle_subd_layer);      

      var circle_subd_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Active',
              icon: '<img src="images/uncovered.png" width="20px" height="20px"/>',
              title: 'Sub-Distributor Circle Coverage',
              onClick: function(control) {

                 if(layer_enable["circle_subd"] == 0){
                    overlay_arr['circle_subd'].addTo(map);
                    layer_enable["circle_subd"]=1;
                 }
                 else
                 {
                    overlay_arr['circle_subd'].remove(map);
                    layer_enable["circle_subd"]=0;
                 }
                  
              }
          }]
      });
      map.addControl(circle_subd_button);

    dynamic_control['rpi_action'].push(circle_subd_button); 

    }
     if(circle_distributor.length>0){

      var circle_distributor_layer = L.layerGroup(circle_distributor);
      overlays["circle_distributor"]=circle_distributor_layer;
      overlay_arr['circle_distributor'] =circle_distributor_layer;
      rpi_layer.push(circle_distributor_layer);      

      var circle_distributor_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Active',
              icon: '<img src="images/default_covered.png" width="20px" height="20px"/>',
              title: 'Distributor Circle Coverage',
              onClick: function(control) {

                 if(layer_enable["circle_distributor"] == 0){
                    overlay_arr['circle_distributor'].addTo(map);
                    layer_enable["circle_distributor"]=1;
                 }
                 else
                 {
                    overlay_arr['circle_distributor'].remove(map);
                    layer_enable["circle_distributor"]=0;
                 }
                  
              }
          }]
      });
      map.addControl(circle_distributor_button);

    dynamic_control['rpi_action'].push(circle_distributor_button); 

    }

        if(villg_distributor.length>0){

      var villg_distributor_layer = L.layerGroup(villg_distributor);
      overlays["villg_distributor"]=villg_distributor_layer;
      overlay_arr['villg_distributor'] =villg_distributor_layer;
      rpi_layer.push(villg_distributor_layer);      

      var villg_distributor_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Active',
              icon: '<img src="rural_icon/Distributor.png" width="20px" height="20px"/>',
              title: 'Distributor',
              onClick: function(control) {

                 if(layer_enable["villg_distributor"] == 0){
                    overlay_arr['villg_distributor'].addTo(map);
                    layer_enable["villg_distributor"]=1;
                 }
                 else
                 {
                    overlay_arr['villg_distributor'].remove(map);
                    layer_enable["villg_distributor"]=0;
                 }
                  
              }
          }]
      });
      map.addControl(villg_distributor_button);

    dynamic_control['rpi_action'].push(villg_distributor_button); 

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
              icon: '<img src="rural_icon/activated.png" width="20px" height="20px" style="margin-top:-5px;/>',
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
              icon: '<img src="rural_icon/recommendation.png" width="20px" height="20px" style="margin-top:-5px;"/>',
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
       if(input_obj.type==26)
       overlay_arr['exist_subrd'].addTo(map);
        var exist_subrd_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Exist SubRD',
              icon: '<img src="rural_icon/efficient-subrd.png" width="20px" height="20px" style="margin-top:-5px;"/>',
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
        if(input_obj.type!=26)
        {
              map.addControl(exist_subrd_button);
              dynamic_control['rpi_action'].push(exist_subrd_button);
        }
    
    }
    if(urban_subrd.length>0){
        var urban_subrd_layer = L.layerGroup(urban_subrd);
        rpi_layer.push(urban_subrd_layer);
        overlays["urban_subrd"]=urban_subrd_layer;
        overlay_arr['urban_subrd'] =urban_subrd_layer;
     
        var urban_subrd_button = L.easyButton({
          position: 'bottomright',
          states: [{
              stateName: 'Urban SubRD',
              icon: '<img src="rural_icon/urban-distributor.png" width="20px" height="20px" style="margin-top:-5px;"/>',
              title: 'Urban SubRD',
              onClick: function(control) {


                 if(layer_enable["urban_subrd"] == 0){
                    overlay_arr['urban_subrd'].addTo(map);
                    layer_enable["urban_subrd"]=1;
                 }
                 else
                 {
                    overlay_arr['urban_subrd'].remove(map);
                    layer_enable["urban_subrd"]=0;
                 }

              }
          }]
      });
      map.addControl(urban_subrd_button);
      dynamic_control['rpi_action'].push(urban_subrd_button);
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
              icon: '<img src="rural_icon/Wholesale.png" width="20px" height="20px" style="margin-top:-5px;"/>',
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
                                        info = '<div class="media outlet-list zero'+value.refid+'"  ><img class="p-3 align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3><span class="store-high" style="'+style_code+'">'+value.potential_status+'</span></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li> <li class="list-group-item"><div class="form-check capturedetails"><div id="currentstatus'+value.refid+'" ><button class="btn btn-success Capture-btn-details" type="button" title="beat-list" id="capture" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')">Capture Details<span class="button-state state-beat-list beat-list-active"></button></div></div><div class="form-check capturedetails-upload text-white"><div><button type="button" class="btn bg-transparent Capture-btn-details upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'</div></div><div class="form-check"><button type="button" class="Capture-btn-relevant btn-bgnd" onClick="notfound('+value.refid+',\''+value.lat+'\',\''+value.lon+'\');">Store not found</button><a href="#"> <span class="upload-edit-button-icon"> <i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div><div class="form-check">';
                                        if(("{{Auth::user()->client_id}}")==100)
                                        {
                                          info +='<button type="button" class="Capture-btn-relevant" onClick="existing('+value.refid+',\''+value.lat+'\',\''+value.lon+'\');">Existing '+client_name+' Store</button>';
                                        }
                                        
                                         info +='<a href="#"> <span class="upload-edit-button-icon"> <i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li></ul></div>  <div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';
                                      if(("{{Auth::user()->client_id}}")==100)
                                      {
                                      
                                         info +='<div class="Relevant-Store-wrapper first_div'+value.refid+'" style="display:none;"><img class="p-2 align-self-start" src="' + value.shop_image + '" width="auto" height="250px" alt=""><ul class="list-group"><li class="list-group-item"><a href="#"><button type="button" class="btn-success Capture-btn" style="color:white" onClick="next(\'second_div'+value.refid+'\',2,'+value.refid+')">Relevant Store</button></a></li> <li class="list-group-item"><a href="#"><button type="button" class="Capture-btn-relevant btn-bgnd" onClick="notrelevant('+value.refid+',\''+value.shop_image+'\',\''+value.outlet_name+'\',\''+value.channel_name+'\',\''+value.sub_channel_name+'\',\''+value.address+'\',\''+value.lat+'\',\''+value.lon+'\')">Not Relevant Store</button></a></li></ul></div>';

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
                                            info +='<div class="inline-fwrappers jj_'+v4['parent']+'" style="display:none;"><div class="product-stocked"><ul class="list-group"><li class="list-group-item">'+v4['question']+'</li></ul></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_1']+'"  onClick="changestyle_radio('+v4['refid']+',\''+v4['option_1']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"> <input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_1" value="'+v4['option_1']+'" > <label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_1" > 1-5 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_2']+'" onClick="changestyle_radio('+v4['refid']+',\''+v4['option_2']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_2"  value="'+v4['option_2']+'"  ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_2" > 5-10 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_3']+'" onClick="changestyle_radio('+v4['refid']+',\''+v4['option_3']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'" id="jj_'+v4['refid']+'_3" value="'+v4['option_3']+'"   ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_3" > 10-15 </label></div><div class="form-check btn-age-select-wrapper parent'+v4['parent']+' option'+v4['parent']+value.refid+v4['option_4']+'" onClick="changestyle_radio('+v4['refid']+',\''+v4['option_4']+'\',this,\'jj_'+v4['parent']+value.refid+'\')"><input class="form-check-input btn-check packsize'+v4['parent']+' pack_info" type="radio" name="'+v4['refid']+'"  id="jj_'+v4['refid']+'_4" value="'+v4['option_4']+'"  ><label class="form-check-label btn-age-wrapper" for="jj_'+v4['refid']+'_4" > Above 15</label></div></div>';
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
                        low_status='';medium_status='';high_status='';under_cover='';non_cover='';
                        selling='';non_selling=''
                      if(value.predict_potential==1)
                          low_status='checked';
                      if(value.predict_potential==2)
                          medium_status='checked';
                      if(value.predict_potential==3)
                          high_status='checked';

                    if(value.status=='A' || value.status=='U' || value.status=='NU' || value.status=='SR' || value.status=='NSR')
                            found='checked';
                    if(value.status=='R')
                            not_found='checked';

                    if(value.status=='V')
                            visited='checked';
                      if(value.status=='U')
                          under_cover='checked';
                      if(value.status=='NU' ||  value.status=='SR' || value.status=='NSR')
                          non_cover='checked';
                    if(value.status=='SR')
                          selling='checked';
                      if(value.status=='SR')
                          selling='checked';
                      if(value.status=='NSR')
                          non_selling='checked';
                        

                        
                      if(type!=11 || ("{{Auth::user()->client_id}}")==86 ||  ("{{Auth::user()->client_id}}")==120 || ("{{Auth::user()->client_id}}")==115 || ("{{Auth::user()->client_id}}")==123 || ("{{Auth::user()->client_id}}")==0  || ("{{Auth::user()->client_id}}")==1 || ("{{Auth::user()->client_id}}")==1000)   
                      {
                        
                         style_code='';
                         if(("{{Auth::user()->client_id}}")!=115 && ("{{Auth::user()->client_id}}")!=123 && ("{{Auth::user()->client_id}}")!=0 && ("{{Auth::user()->client_id}}")!=1000)
                            stre_photo='Store';
                         else
                            stre_photo='';
                if(value.potential_status_name=='High' )
                style_code='background-color:#51c82c';
               if(value.potential_status_name=='Medium')
                style_code='background-color:#ed8102';
               if(value.potential_status_name=='Low')
                style_code='background-color:#bf1414';
         
                        if(value.image_count > 0)
                                 circle_count='<span class="circle_count">'+value.image_count+'</span>';
                               info = '<div class="media outlet-list"><img class="p-2 align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body media_1"><ul class="list-group"><li class="list-group-item '+value.refid+'_list_1"><h3 class="title-box">' + value.outlet_name + '</h3><span class="store-high" style="'+style_code+'">'+value.potential_status_name+'</span></li><li class="list-group-item chnl-typ">' + value.channel_name + '</li><li class="list-group-item">' + value.address + '</li><li class="'+value.refid+'_list_1" style="display:block;"><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'A\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault1" '+found+'>  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'R\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault2" '+not_found+'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div> </li>';
                               if(("{{Auth::user()->client_id}}")!=115 && ("{{Auth::user()->client_id}}")!=123 && ("{{Auth::user()->client_id}}")!=1 && ("{{Auth::user()->client_id}}")!=0)
                               info +='<li class="list-group-item chnl-typ '+value.refid+'_list_1">Estimated Potential</li><li class="'+value.refid+'_list_1" ><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault66" onClick="outlet_potential_status(\'1\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault66" '+low_status+'>  <label class="form-check-label" for="flexRadioDefault66" >    Low  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault67" onClick="outlet_potential_status(\'2\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault67" '+medium_status+'> <label class="form-check-label" for="flexRadioDefault67" > Medium </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault68" onClick="outlet_potential_status(\'3\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault68" '+high_status+'>  <label class="form-check-label" for="flexRadioDefault68" > High </label></div></li>';
                             info +=    '<li class="list-group-item '+value.refid+'_list_2" style="display:none;"><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault99" onClick="outlet_status(\'U\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault99" '+under_cover+'>  <label class="form-check-label" for="flexRadioDefault99" >    Under Nestle Coverage  </label></div><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault98" onClick="outlet_status(\'NU\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault98" '+non_cover+'>  <label class="form-check-label" for="flexRadioDefault98" >   Not Under Nestle Coverage </label></div></li><li class="list-group-item '+value.refid+'_list_2" style=display:none;"><span class="chnl-typ " style="width: 50% !important;  display: block;float:left; padding: 0px 0px 8px 0px; cursor:pointer;"  onClick="back('+value.refid+',1)">Back</span> <span class=" chnl-typ " style="display: block;float: right;    padding: 0px 0px 8px 0px; cursor:pointer;"  onClick="back('+value.refid+',3)">Next</span></li>';
                             info +=    '<li class="list-group-item '+value.refid+'_list_3" style="display:none;"><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault97" onClick="outlet_status(\'SR\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault97" '+selling+'>  <label class="form-check-label" for="flexRadioDefault97" >    Selling Relevant Category  </label></div><div class="form-check">  <input class="form-check-input" type="radio" name="flexRadioDefault96" onClick="outlet_status(\'NSR\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\')" id="flexRadioDefault96" '+non_selling+'>  <label class="form-check-label" for="flexRadioDefault96" >    Does Not Sell Relevant Category </label></div></li><li class="list-group-item '+value.refid+'_list_3" style=display:none;"><span class="chnl-typ " style="width: 50% !important;  display: block;float:left; padding: 0px 0px 8px 0px; cursor:pointer;"  onClick="back('+value.refid+',2)">Back</span> <span class=" chnl-typ " style="display: block;float: right;    padding: 0px 0px 8px 0px; cursor:pointer;"  onClick="back('+value.refid+',4)">Next</span></li>';

                                info +=    '<li class="list-group-item '+value.refid+'_list_4" style="display:none;"><label  >   Retailer Name  </label> <input type="text" name="retailer_name_'+value.refid+'" id="retailer_name_'+value.refid+'"  value="'+value.retailer_name+'" /></li>  <li class="list-group-item '+value.refid+'_list_4" style="display:none;"><label for="flexRadioDefault94" >   Contact No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label> <input type="text" id="contact_no_'+value.refid+'" name="contact_no_'+value.refid+'" onkeyup="isNumber(this)"  value="'+value.contact_no+'"/></li><li class="list-group-item '+value.refid+'_list_4" style="display:none;"><label  >   Remark</label> <textarea id="remark_'+value.refid+'" name="remark_'+value.refid+'" rows="2" cols="50">'+value.remark+'</textarea></li><li class="list-group-item '+value.refid+'_list_4" style=display:none;"><span class="chnl-typ " style="width: 50% !important;  display: block;float:left; padding: 0px 0px 8px 0px; cursor:pointer;"  onClick="back('+value.refid+',3)">Back</span> <span class=" chnl-typ " style="display: block;float: right;    padding: 0px 0px 8px 0px; cursor:pointer;"  onClick="outlet_status(\'SR\','+value.refid+',\''+value.cluster_id+'\',\''+value.cluster_view+'\',true)">Save</span></li>';
                                
                               info +=  '</ul></div><div class="form-check capturedetails-upload text-white" style="margin: 0px 0px 2px 36px; width: 80%;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload '+stre_photo+' Photo(s)</button>'+circle_count+'</div></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';
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

                              info = '<div class="p-2 media outlet-list"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3 class="title-box">' + value.outlet_name + '</h3></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'A\','+value.refid+',0)" id="flexRadioDefault1" '+found+'>  <label class="form-check-label" for="flexRadioDefault1" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'R\','+value.refid+',0)" id="flexRadioDefault2" '+not_found+'>  <label class="form-check-label" for="flexRadioDefault2" > Not Found </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status(\'V\','+value.refid+',0)" id="flexRadioDefault2" '+visited+'>  <label class="form-check-label" for="flexRadioDefault2" > Visited </label></div></li><li class="list-group-item chnl-typ">Stocking Confectionery? </li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault70" onClick="outlet_premium_status(\'1\','+value.refid+',\'stock_confectionary\')" id="flexRadioDefault70" '+stock_confectionary+'>  <label class="form-check-label" for="flexRadioDefault70" >    Yes  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault71" onClick="outlet_premium_status(\'2\','+value.refid+',\'stock_confectionary\')" id="flexRadioDefault71" '+not_stock_confectionary+'>  <label class="form-check-label" for="flexRadioDefault71" > No </label></div></li><li class="list-group-item chnl-typ">Stocking Chocolate?</li><li><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault700" onClick="outlet_premium_status(\'1\','+value.refid+',\'stock_chocolate\')" id="flexRadioDefault70" '+stock_chocolate+'>  <label class="form-check-label" for="flexRadioDefault70" >    Yes  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault710" onClick="outlet_premium_status(\'2\','+value.refid+',\'stock_chocolate\')" id="flexRadioDefault71" '+not_stock_chocolate+'>  <label class="form-check-label" for="flexRadioDefault71" > No </label></div></li></ul><div class="form-check capturedetails-upload text-white" style="margin: 0px 0px 2px 36px; width: 80%;"><button type="button" class="btn bg-transparent upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'</div></div><div class="popup-footer" ><span style="background-color:none;text-align:center;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)"><strong class="ClicktoNavigate">Click to Navigate</strong></span></div></div>';

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
              count=0;

           //  console.log(marker_cluster_list);

                $.each(marker_cluster_list,function(k,v){
                 
                  if(k !=0 && k!='' && k!=undefined && v!=undefined)
                  {
                       count++;
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
                     
                     console.log(bounds);
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
                console.log(bounds);
                if(count!=0)
                {
                  map.fitBounds(bounds);
                  map.scrollWheelZoom.disable();
                }
                else
                {
                    var featureGroup_outlet = L.featureGroup(outlet_markerarray).addTo(map);
                    map.fitBounds(featureGroup_outlet.getBounds());
                  
                }
             
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


     layer_enable={"active":0,"initiated":0,"activated":0,"deactivated":0,"recomand_subrd":0,"exist_subrd":0,"urban_subrd":0};

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
      //        if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      //       layer.bindTooltip(layer.feature.properties.location_name, {
      //           sticky: true,
      //           crossOrigin: true,
      //           pane: 'tool',
      //           direction: 'top'
      //       });
      // }

        layer.bindPopup("<div class='tooltip-data no-border'><div class=''><div class='' style='color:#fff;margin-left:5px;padding:5px;'>" +layer.feature.properties.location_name+ "</div></div>", {
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
                              iconSize: [15,15],
                          });
                            var marker = L.marker([nextinfo['latitude'], nextinfo['longitude']], {
                              icon: greenIcon
                          });
                            marker.bindPopup(nextinfo['info'], {
                        sticky: true,
                        pane: 'tool',
                        direction: 'top'
                    });
                        active_popup[nextinfo.loc_id]=marker;
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
                              iconSize: [20, 20],
                          });
                var marker = L.marker([nextinfo['latitude'], nextinfo['longitude']], {
                  icon: greenIcon
              });
            //      if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){  
            //     marker.bindTooltip(result.info, {
            //             sticky: true,
            //             pane: 'tool',
            //             direction: 'top'
            //         });
            // }
                  marker.bindPopup(result.info, {
                        sticky: true,
                        pane: 'tool',
                        direction: 'top'
                    });

                  subrd_popup[nextinfo.loc_id]=marker;

      


                        if(result.subrd_status == 2)   
                             recomand_subrd.push(marker);
                        // if(result.subrd_status == 1 && result.subrd_loaction=='Existing Urban Distbtr Hub')  
                        //      urban_subrd.push(marker);
                        //  if(result.subrd_status == 1 && result.subrd_loaction!='Existing Urban Distbtr Hub') 
                        //      exist_subrd.push(marker);
                          if(input_obj.type==28 && result.subrd_status == 1)
                             exist_subrd.push(marker);
                         else
                         {
                          if(result.subrd_status == 1 && result.subrd_loaction=='Existing Urban Distbtr Hub')  
                             urban_subrd.push(marker);
                          if(result.subrd_status == 1 && result.subrd_loaction!='Existing Urban Distbtr Hub') 
                             exist_subrd.push(marker);
                         }

                        if(result.subrd_status == 3)   
                             whole_subrd.push(marker);

                }
                
                
                   
            if (result.hasOwnProperty('size') && nextinfo['latitude']!='' && nextinfo['longitude']!='' && nextinfo['subrd_type']!=0) {
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
                    });
                    // if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
                    //         circle.bindTooltip(result.info);
                     circle.bindPopup(result.info, {
                    
                    sticky: true,
                    direction: 'top'
                });

                
                    bubble_data.push(circle);
                    bubble_data_highlight[layer.feature.properties.ID] = circle;
                   // if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                   //   layer.bindTooltip(result.info, {
                   //      sticky: true,
                   //      direction: 'top'
                   //  });

                   // } 
                    layer.bindPopup(result.info, {
                        sticky: true,
                        direction: 'top'
                    });
                   
                   
                }
                  if(result.rpi_name=='MD' || result.rpi_name=='D'){
                    
                      var greenIcon = L.icon({
                              iconUrl:'rural_icon/'+result.rpi_name+'.png',
                              iconSize: [15,15],
                          });
                            var marker = L.marker([result.latitude,result.longitude], {
                              icon: greenIcon
                          });
                             marker.bindPopup(result.info, {
                        sticky: true,
                        direction: 'top'
                    });
                            
                    if(input_obj.type==26 && result.subrd_type==1 && result.is_hub!=1)
                     {
                         rpi_tooltip.push(marker);
                          rpi_popup[nextinfo.loc_id]=marker;
                     }
                     else if(input_obj.type!=26)
                     {
                          rpi_tooltip.push(marker);
                          rpi_popup[nextinfo.loc_id]=marker;              
                     }
                     
                   }
            if (result.hasOwnProperty('color')) {
                layer.setStyle({
                    fillColor: result.color,
                    color: '#808080',
                    weight: (zoomrange >= 16) ? 5 : 0.5,
                    stroke: (zoomrange >= 16) ? 5 : 0.8,
                    fillOpacity: overlay_arr[0]
                });
                   
                layer.bindPopup(result.info, {
                    
                    sticky: true,
                    direction: 'top'
                });
                 
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
                             if(cluster_id!=0)
                             {
                                $.each( cluster_layer[cluster_id], function( key, value ) {
                                 highlightFeature(value);
                            });
                             }
                            
                            
                        }
                     });
                      layer.on('mouseout',function(ev) 
                     {
                        if(ev.target.feature.properties.status == 'hub')
                        {
                            cluster_id=ev.target.feature.properties.cluster_id;
                            if(cluster_id!=0)
                            {
                                 $.each( cluster_layer[cluster_id], function( key, value ) {
                                 resetHighlight(value);
                            });
                            }
                           
                            
                        }
                     });
          }
       }
     
     
      layers_base.push(grayscale);
      layers_base.push(streets);
      layers_base.push(geojson);
      var rpi_tooltip_layer = L.layerGroup(rpi_tooltip);
        
        dynamic_control["rpi_tool"]=rpi_tooltip_layer;
      
      
       

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
    function calendar_apply()
    {

            if(calendar_data['calendar_type']!=0)
            {
                range_name=[];
                range_name[1]='Year';
                range_name[2]='Qtr';
                range_name[3]='Month';
                if(calendar_data['period_type']!=undefined && calendar_data['period_type']!=null)
                {
                      calendar_data['year']=[];
                      if(calendar_data['period_type']==1)
                        calendar_data['year']=[$("#calendar_1").val()];
                      if(calendar_data['period_type']==3)
                      {
                         $.each($("#calendar_3").val(),function(k,v){
                          if(v!='')
                            calendar_data['year'].push(v);
                          else
                          {
                             alert("Select the "+range_name[calendar_data['calendar_type']]);
                             return false;
                          }

                         });
                         if(calendar_data['year'].length<=0)
                         {
                             alert("Select the "+range_name[calendar_data['calendar_type']]);
                             return false;
                         }
                      }
                      if(calendar_data['period_type']==2)
                      {
                          calendar_data['start_year']=$("#calendar_1").val();
                          calendar_data['end_year']=$("#calendar_2").val();
                          
                         col_val=['','null','undefined'];
                          if(($.inArray(calendar_data.start_year,col_val))==-1 && (jQuery.inArray(calendar_data.end_year,col_val))==-1)
                        
                          {
                             if(calendar_data['calendar_type'] ==2)
                                if(calendar_data.start_year > calendar_data.end_year )
                                {

                                    alert(" Start year should be less than End Year");
                                    return false;
                                }
                            if(calendar_data['calendar_type'] ==6)
                            {
                                start_year=calendar_data.start_year.substr(0,4);
                                end_year=calendar_data.end_year.substr(0,4);
                                start_month=parseInt(calendar_data.start_year.substr(4,2));
                                end_month=parseInt(calendar_data.end_year.substr(4,2));
                                quarter=[];
                                quarter[1]='01';
                                quarter[2]='04';
                                quarter[3]='07';
                                quarter[4]='10';
                                start_date='01/'+quarter[start_month]+'/'+start_year;
                                end_date='01/'+quarter[end_month]+'/'+end_year;
                                
                                 start_date = new Date(start_date);
                                 end_date = new Date(end_date);
                                
                                if(start_date > end_date)
                                {
                                    alert("from period should be less than to period");
                                    return false;
                                }
                            }
                            if(calendar_data['calendar_type'] ==4)
                            {
                                start_year=calendar_data.start_year.substr(0,4);
                                end_year=calendar_data.end_year.substr(0,4);
                                start_month=parseInt(calendar_data.start_year.substr(4,2));
                                end_month=parseInt(calendar_data.end_year.substr(4,2));
                                
                                  month_arr=[];
                                  month_arr[1]='Jan';
                                  month_arr[2]='Feb';
                                  month_arr[3]='Mar';
                                  month_arr[4]='Apr';
                                  month_arr[5]='May';
                                  month_arr[6]='June';
                                  month_arr[7]='July';
                                  month_arr[8]='Aug';
                                  month_arr[9]='Sep';
                                  month_arr[10]='Oct';
                                  month_arr[11]='Nov';
                                  month_arr[12]='Dec';
                                start_date='01/'+month_arr[start_month]+'/'+start_year;
                                end_date='01/'+month_arr[end_month]+'/'+end_year;
                                
                                 start_date = new Date(start_date);
                                 end_date = new Date(end_date);
                                
                                if(start_date > end_date)
                                {
                                    alert("from period should be less than to period");
                                    return false;
                                }
                            }


                          }
                         else
                         {
                             alert("select the "+range_name[calendar_data['calendar_type']]);
                             return false;
                         }
                      }
                 }
                  if(current_maplevel[0]!=null && current_maplevel[0]!=undefined)
                  {
                          input_obj['location']=current_maplevel[0]['city_id'];
                          input_obj['city_id']=current_maplevel[0]['city_id'];
                          input_obj['loc_level']=current_maplevel[0]['loc_level'];
                          input_obj['loc_id']=current_maplevel[0]['loc_id'];
                  }
                  input_obj['calendar_data']=calendar_data;
                  initial(input_obj,0,0,'');
              
              $('#prdSelect').modal('hide');
            }
    }
    function call_viewcalendar(calendar_type,view_master=0,data_obj='')
    {
        calendar_data['selected_menu']=0;
        if(view_master!=0)
        {
             $('.btn_list').each(function(){
               
                    $(this).removeClass("selected_btn");
             });
             $(data_obj).addClass("selected_btn");
             if($(".selected_menu").length>0)
                calendar_data['selected_menu']=$(".selected_menu").attr("menu_parent_levelid");
        }
        if(view_master==0)
        {
            calendar_data['calendar_type']=calendar_type;
            period_type=$("#"+calendar_type+"_viewcalendar :selected").val(); 
            $(".view_type").show();
            if(period_type==1)
            {
                $(".view_type").hide();
                $(".view_type").eq(0).show();
            }

            calendar_data['period_type']=period_type;
            if($(".selected_menu").length>0)
             calendar_data['selected_menu']=$(".selected_menu").attr("menu_parent_levelid");
            //if(calendar_data['view_master']!=undefined && calendar_data['view_master']!=null)
            view_master=1
           $(".calendar_list").each(function(i){
             drop_id=$(this).attr("id");
             drop_id_=drop_id.split("_");
             if(drop_id_[0]!=calendar_type)
                $("#"+drop_id).val("calde");
               
           });
           
            
        }
        if(view_master!=0)
        {
            
             calendar_type=calendar_data['calendar_type'];
             period_type=calendar_data['period_type'];
             calendar_data['view_master']=view_master;
            if($(".selected_menu").length>0)
              calendar_data['selected_menu']=$(".selected_menu").attr("menu_parent_levelid");

        }
       
    if($.inArray(calendar_data['selected_menu'],[null,undefined,'',0]) != -1)
    {
        alert("select the menu");
        $("#prdSelect").modal("hide");
        calendar_data=[];
        return false;

    }
     if(data_obj=='')
     {
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url: 'dashboard/getcalendardata',
    type: "POST",
    data: {
        'calendar_type': calendar_type,
        'period_type': period_type,
        'view_type': view_master,
        'selected_menu': calendar_data['selected_menu']
    },
    dataType: "json",
    success: function(data) {
        $(".blk_calendar_1,.blk_calendar_2,.blk_calendar_3").hide();
        data = JSON.stringify(data);
        data = JSON.parse(data);
        str = '';
        if (data.length > 0) {

            if (calendar_type == 2) {
                if (period_type == 1 || period_type == 3) // single,Mixed 
                {
                    str += '<option value="">Select the Period</option>';
                    for (k = data[0].period_from; k <= data[0].period_to; k++)
                        str += '<option value="' + k + '">' + k + '</option>';

                    if (period_type == 3) {
                        $("#calendar_3").html('');
                        $("#calendar_3").html(str);
                        $(".blk_calendar_3").show();

                    } else {
                        $("#calendar_1").html('');
                        $("#calendar_1").html(str);
                        $(".blk_calendar_1").show();
                        $("#calendar_1").prop("multiple", "");
                        // $("#calendar_1").select2();
                    }

                }
                if (period_type == 2) // Continous
                {
                    str += '<option value="">Select the Period</option>';
                    for (k = data[0].period_from; k <= data[0].period_to; k++)
                        str += '<option value="' + k + '">' + k + '</option>';
                    $("#calendar_1,#calendar_2").html('');
                    $("#calendar_1,#calendar_2").html(str);
                    $(".blk_calendar_1,.blk_calendar_2").show();
                }
            }
            if (calendar_type == 6) // By Qtr
            {
                qtr_arr = [];
                qtr_arr[1] = 'Ja-Ma Q';
                qtr_arr[2] = 'Ap-Ju Q';
                qtr_arr[3] = 'Ju-Se Q';
                qtr_arr[4] = 'Oc-De Q';

                period_from_month = parseInt(data[0].period_from.substr(4, 2));
                period_to_month = parseInt(data[0].period_to.substr(4, 2));
                period_from_year = parseInt(data[0].period_from.substr(0, 4));
                period_to_year = parseInt(data[0].period_to.substr(0, 4));
                str += '<option value="">Select the Period</option>';
                for (k = period_from_year; k <= period_to_year; k++) {
                    if (period_from_year != period_to_year) {
                        if (period_from_year == k) {

                            for (i = period_from_month; i <= 4; i++)
                                str += '<option value="' + k + '0' + i + '">' + qtr_arr[i] + ' ' + k + '</option>';
                        } else if (period_to_year == k) {

                            for (i = 1; i <= period_to_month; i++)
                                str += '<option value="' + k + '0' + i + '">' + qtr_arr[i] + ' ' + k + '</option>';
                        } else {

                            for (i = 1; i <= 4; i++)
                                str += '<option value="' + k + '0' + i + '">' + qtr_arr[i] + ' ' + k + '</option>';
                        }
                    } else {
                        str += '<option value="">Select the Period</option>';
                        for (i = period_from_month; i <= period_to_month; i++)
                            str += '<option value="' + k + '0' + i + '">' + qtr_arr[i] + ' ' + k + '</option>';
                    }
                }



                if (period_type == 3) {
                    $("#calendar_3").html('');
                    $("#calendar_3").html(str);
                    $(".blk_calendar_3").show();

                } else if (period_type == 1) {
                    $("#calendar_1").html('');
                    $("#calendar_1").html(str);
                    $(".blk_calendar_1").show();
                    $("#calendar_1").prop("multiple", "");
                    // $("#calendar_1").select2();
                }

                //  } 
                if (period_type == 2) // Continous
                {

                    $("#calendar_1,#calendar_2").html('');
                    $("#calendar_1,#calendar_2").html(str);
                    $(".blk_calendar_1,.blk_calendar_2").show();
                }
            }
            if (calendar_type == 4) // By Qtr
            {

                month_arr = [];
                month_arr[1] = 'Jan';
                month_arr[2] = 'Feb';
                month_arr[3] = 'Mar';
                month_arr[4] = 'Apr';
                month_arr[5] = 'May';
                month_arr[6] = 'June';
                month_arr[7] = 'July';
                month_arr[8] = 'Aug';
                month_arr[9] = 'Sep';
                month_arr[10] = 'Oct';
                month_arr[11] = 'Nov';
                month_arr[12] = 'Dec';
                // month_arr=[1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'June',7=>'July',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'];
                period_from_year = data[0].period_from.substr(0, 4);
                period_from_month = parseInt(data[0].period_from.substr(4, 2));
                period_to_year = data[0].period_to.substr(0, 4);
                period_to_month = parseInt(data[0].period_to.substr(4, 2));
                str += '<option value="">Select the Period</option>';
                for (k = period_from_year; k <= period_to_year; k++)
                    if (period_from_year != period_to_year) {
                        if (period_from_year == k) {
                            for (i = period_from_month; i <= 12; i++) {
                                m = (i.length <= 1) ? 0 : '';
                                str += '<option value="' + k + m + i + '">' + month_arr[i] + ' ' + k + '</option>';
                            }

                        } else if (period_to_year == k) {
                            for (i = 1; i <= period_to_month; i++) {
                                m = (i.length <= 1) ? 0 : '';
                                str += '<option value="' + k + m + i + '">' + month_arr[i] + ' ' + k + '</option>';

                            }
                        } else {
                            for (i = 1; i <= 12; i++) {
                                m = (i.length <= 1) ? 0 : '';
                                str += '<option value="' + k + m + i + '">' + month_arr[i] + ' ' + k + '</option>';
                            }

                        }
                    }
                else {
                    for (i = period_from_month; i <= period_to_month; i++) {
                        m = (i.length <= 1) ? 0 : '';
                        str += '<option value="' + k + m + i + '">' + month_arr[i] + ' ' + k + '</option>';

                    }
                }
                if (period_type == 1 || period_type == 3) // single,Mixed 
                {


                    if (period_type == 3) {
                        $("#calendar_3").html('');
                        $("#calendar_3").html(str);
                        $(".blk_calendar_3").show();

                    } else {
                        $("#calendar_1").html('');
                        $("#calendar_1").html(str);
                        $(".blk_calendar_1").show();
                        $("#calendar_1").prop("multiple", "");
                        // $("#calendar_1").select2();
                    }

                }
                if (period_type == 2) // Continous
                {

                    $("#calendar_1,#calendar_2").html('');
                    $("#calendar_1,#calendar_2").html(str);
                    $(".blk_calendar_1,.blk_calendar_2").show();
                }
            }




        }

    }
});
     }
      
     


    }
function share(info,data)
{
      //             document.querySelector('#share_'+result.loc_id)
        // .addEventListener('click', event => {
 // $("#share_"+result.loc_id).click(function(e){
    if (navigator.share) {
                navigator.share({
  
                    // Title that occurs over
                    // web share dialog
                    title: 'Village Location',
                    text:info,
                    html:'<b></b>',
                    url:'https://www.google.com/maps/search/?api=1&query='+ $(data).attr('lat') +','+ $(data).attr('lon')+''
                    // // URL to share
                    // url: "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + clicked_lat + "," + clicked_lon + "'/"
                }).then(() => {
                    console.log('Thanks for sharing!');
                }).catch(err => {
  
                    // Handle errors, if occured
                    console.log(
                    "Error while using Web share API:");
                    console.log(err);
                });
            } else {
  
                // Alerts user if API not available 
                alert("Browser doesn't support this API !");
            }
  //});
            // Fallback, Tries to use API only
            // if navigator.share function is
            // available
            
       // });
}

    function tablebuild(res, type) {
        var btn={
                        buttons: [{
                                extend: 'excel',
                                className: 'btn btn-primary'
                            },
                            {
                                extend: 'pdf',
                                className: 'btn btn-primary'
                            },
                            {
                                extend: 'print',
                                className: 'btn btn-primary'
                            }
                        ]
                    };
        tablefoot = false;
        if ($.fn.dataTable.isDataTable('#griddata')) {

            table.destroy();


            $("#griddata").html("");
            if(type ==0)
            {
                 $("#griddata").html(res['griddata']);
                 table = $('#griddata').DataTable({
                    searching:true,
                    dom: 'Bfrtip',
                    buttons: btn,
                    paging: true,
                    info: false,
                    responsive: false,
                    "pageLength": 20,
                     "deferRender": true
                 });

            }
            if(type==12 || type==28)
            {
                  res['griddata']['column'].push({
                    data: null,
                    visible: false,
                    render: function (data, type, row, meta) {
                      return meta.row;
                    }
            });
           
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: [
                  { 
                    text:'PDF',
                    extend: 'pdf',
                    orientation: 'landscape',
                    title: 'SubRD List',
                    pageSize: 'A3',
                    footer : true,
                    header : true,
                    customize: function (doc) {

                      // Get the row data in in table order and search applied
                      var table = $('#griddata').DataTable();
                      var rowData = table.rows( {order: 'applied', search:'applied'} ).data();
                      var headerLines = 0;  // Offset for accessing rowData array

                      var newBody = []; // this will become our new body (an array of arrays(lines))
                      //Loop over all lines in the table
                      doc.content[1].table.body.forEach(function(line, i){
                       
                        
                        // Remove detail-control column
                        newBody.push(
                          [line[1]['text'], line[2]['text'], line[3]['text'], line[4]['text'],line[5]['text'], line[6]['text'], line[7]['text'], line[8]['text'],line[9]['text'], line[10]['text'], line[11]['text'], line[12]['text'],line[13]['text'], line[14]['text']]
                        );

                        if (line[0].style !== 'tableHeader' && line[0].style !== 'tableFooter') {

                          var data = rowData[i - headerLines];
                          console.log(data);
                          
                          cluster_id=data['cluster_name'].split(" ");
                          
                           
                            if(cluster_id!=undefined)
                            {
                                
                                 var decoded = villg_subrd[parseInt(cluster_id[1])];
                                
                                 m=1;
                          
                                $.each(decoded, function (key, val) {
                                   
                                   
                                     newBody.push(
                                        [
                                          {text: 'child:'+m, style:'defaultStyle'},
                                          {text: val['cluster_id'], style:'defaultStyle'},
                                          {text: val['district_name'], style:'defaultStyle'},
                                          {text: val['taluk_name'], style:'defaultStyle'},
                                          {text: val['village_name'], style:'defaultStyle'},
                                          {text: val['market_id'], style:'defaultStyle'},
                                          {text: val['distance_subrd'], style:'defaultStyle'},
                                          {text: val['outlet_potential'], style:'defaultStyle'},
                                          {text: val['population'], style:'defaultStyle'},
                                          {text: val['village_choc_consmptn'], style:'defaultStyle'},
                                          {text: val['subrd_priority'], style:'defaultStyle'},
                                          {text: val['subrd_loaction'], style:'defaultStyle'},
                                          {text: val['exist_subrd_code'], style:'defaultStyle'},
                                          {text: val['exist_subrd_name'], style:'defaultStyle'},
                                          {text: '', style:'defaultStyle'},

                                        ]
                                     );
                                });
                            }

                             

                          // Append child data, matching number of columns in table
                         

                        } else {
                          headerLines++;
                        }

                      });

                      //Overwrite the old table body with the new one.
                      doc.content[1].table.headerRows = 1;
                      //doc.content[1].table.widths = [50, 50, 50, 50, 50, 50];
                      doc.content[1].table.body = newBody;
                      doc.content[1].layout = 'lightHorizontalLines';

                      doc.styles = {
                        subheader: {
                            fontSize: 10,
                            bold: true,
                            color: 'black'
                        },
                        tableHeader: {
                            bold: true,
                            fontSize: 10.5,
                            color: 'black'
                        },
                        lastLine: {
                            bold: true,
                            fontSize: 11,
                            color: 'blue'
                        },
                        defaultStyle: {
                            fontSize: 10,
                            color: 'black',
                            text:'center'
                        }
                      };
                    }
                  },
                  {
            extend: 'excelHtml5',
            title:res['head']+'. - Current Coverage and Recommendations',
           customize: function( xlsx ) {
        var table = $('#griddata').DataTable();
        
      
        var numColumns = table.columns().header().count();

        var sheet = xlsx.xl.worksheets['sheet1.xml'];

        var col = $('col', sheet);
        
         $(col[1]).attr('width', 20);

       
        var sheetData = $('sheetData', sheet).clone();
        
       
        $('sheetData', sheet).empty();

       
        var rowCount = 1;
        
      
        $(sheetData).children().each(function(index) {

         
          var rowIndex = index - 1;
          
         
          if (index > 0) {
            
            // Get row
            var row = $(this.outerHTML);
           
          
            // Set the Excel row attr to the current Excel row count.
            row.attr('r', rowCount);
            
            var colCount = 1;
            
            // Iterate each cell in the row to change the rwo number.
            row.children().each(function(index) {
              var cell = $(this);
            
              // Set each cell's row value.
              var rc = cell.attr('r');
              rc = rc.replace(/\d+$/, "") + rowCount;
              cell.attr('r', rc);         
            if(rowCount==1 || rowCount==2)
            {
                 if (colCount === numColumns) {
                cell.html('');
              }
            }else
              if (colCount === numColumns-1) {
                cell.html('');
              }
              
              colCount++;
            });

            // Get the row HTML and append to sheetData.
            // console.log(row[0]);
            //   console.log(row[0].childNodes[1].outerText);
           console.log(row[0].childNodes[1]);
            row_head = row[0].outerHTML;
          
            $('sheetData', sheet).append(row_head);
            rowCount++;
           
            parenttxt=row[0].childNodes[1].outerText;
            childnode=parenttxt.split(" ");
           

              if(childnode[1]!=undefined)
            {
                
                 var decoded = villg_subrd[parseInt(childnode[1])];
                
                 m=1;
         
                $.each(decoded, function (key, val) {
                      val['district_name']=val['district_name'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                   val['taluk_name']=val['taluk_name'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                   val['village_name']=val['village_name'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    val['exist_subrd_name']=val['exist_subrd_name'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    
                     childRow = '<row r="' + rowCount + 
                                '"><c  r="A' + rowCount + 
                                '"><v>'+m+'</v></c><c t="inlineStr" r="B' + rowCount + 
                                '"><is><t>Cluster ' + val['cluster_id'] + 
                                '</t></is></c><c t="inlineStr" r="C' + rowCount + 
                                '"><is><t>' + val['district_name'] + 
                                '</t></is></c><c t="inlineStr" r="D' + rowCount + 
                                '"><is><t>' + val['taluk_name'] + 
                                '</t></is></c><c t="inlineStr" r="E' + rowCount + 
                                '"><is><t>' + val['village_name'] + 
                                '</t></is></c><c r="F' + rowCount + 
                                '"><v>' + val['market_id'] + 
                                '</v></c><c  r="G' + rowCount + 
                                '"><v>' + val['distance_subrd'] + 
                                '</v></c><c  r="H' + rowCount + 
                                '"><v>' + val['outlet_potential'] + 
                                '</v></c><c  r="I' + rowCount + 
                                '"><v>' + val['population'] + 
                                '</v></c><c  r="J' + rowCount + 
                                '"><v>' + val['village_choc_consmptn'] + 
                                '</v></c><c t="inlineStr" r="K' + rowCount + 
                                '"><is><t>' +val['subrd_priority'] + 
                                '</t></is></c><c t="inlineStr" r="L' + rowCount + 
                                '"><is><t>' +val['subrd_loaction'] + 
                                '</t></is></c><c t="inlineStr" r="M' + rowCount + 
                                '"><is><t>' + val['exist_subrd_code'] + 
                                '</t></is></c><c t="inlineStr" r="N' + rowCount + 
                                '"><is><t>' +val['exist_subrd_name'] + 
                                '</t></is></c><c t="inlineStr" r="O' + rowCount + 
                                '"><is><t></t></is></c></row>';
                       $('sheetData', sheet).append(childRow);
                       rowCount++;
                       m++;
                });
            }

                     
          } 
          else {
            var row = $(this.outerHTML);
            
            var colCount = 1;
            
            // Remove the last header cell.
            row.children().each(function(index) {
              var cell = $(this);
            
              if (colCount === numColumns) {
                cell.html('');
              }
              
              colCount++;
            });
            row = row[0].outerHTML;
            $('sheetData', sheet).append(row);
            rowCount++;
          }
        });        
      },
            
        }
                ],
                  //  buttons: ['excel', 'pdf', 'print'],
                    paging: true,
                    searching:true,
                    info: false,"pageLength": 15,
                    responsive: false, "deferRender": true

                });
            }
            else if (type == 4 || type==5 || type==6 || type==7 || type==8 || type==9 || type==10 || type==11  || type==13 || type==14 || type==15 || type==16 || type==17 || type==19 || type==20 || type==21 || type==22 || type==23  || type==24 || type==25 || type==26) {
               
  
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    searching:true,
                    dom: 'Bfrtip',
                    buttons: btn,
                    paging: true,
                    info: false,
                    responsive: false,
                    "pageLength": 20,
                     "deferRender": true

                });


            } else {
              
  
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                 dom: 'Bfrtip',
                    buttons: btn,
                    paging: true,
                    searching:true,
                    info: false,
                    "pageLength": 20,
                    responsive: false, "deferRender": true,
                    

                    fnFooterCallback: function(row, data, start, end, display) {

                        if (tablefoot == false && type != 3 && type != 4 && type!=5 && type!=6 && type!=7 && type!=8 && type!=9 && type!=10 && type!=11 && type!=12 && type!=13 && type!=14 && type!=15 && type!=16 && type!=17 && type!=19 && type!=20 && type!=21 && type!=22 && type!=23 && type!=0  && type!=24 && type!=25 && type!=26 && type!=28) {
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
            if(type ==0)
            {
                 $("#griddata").html(res['griddata']);
                 table = $('#griddata').DataTable({searching:true,
                    dom: 'Bfrtip',
                    buttons:btn,
                    paging: true,
                    info: false,
                    responsive: false,
                    "pageLength": 20,
                     "deferRender": true});

            }
            if(type==12 || type==28)
            {
                


                  res['griddata']['column'].push({
                    data: null,
                    visible: false,
                    render: function (data, type, row, meta) {
                      return meta.row;
                    }
            });
             console.log( res['griddata']['column']);
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: [
                  { 
                    text:'PDF',
                    extend: 'pdf',
                    orientation: 'landscape',
                    title: 'SubRD List',
                    pageSize: 'A3',
                    footer : true,
                    header : true,
                    customize: function (doc) {

                      // Get the row data in in table order and search applied
                      var table = $('#griddata').DataTable();
                      var rowData = table.rows( {order: 'applied', search:'applied'} ).data();
                      var headerLines = 0;  // Offset for accessing rowData array

                      var newBody = []; // this will become our new body (an array of arrays(lines))
                      //Loop over all lines in the table
                      doc.content[1].table.body.forEach(function(line, i){
                       
                        
                        // Remove detail-control column
                        newBody.push(
                          [line[1]['text'], line[2]['text'], line[3]['text'], line[4]['text'],line[5]['text'], line[6]['text'], line[7]['text'], line[8]['text'],line[9]['text'], line[10]['text'], line[11]['text'], line[12]['text'],line[13]['text'], line[14]['text']]
                        );

                        if (line[0].style !== 'tableHeader' && line[0].style !== 'tableFooter') {

                          var data = rowData[i - headerLines];
                          console.log(data);
                          
                          cluster_id=data['cluster_name'].split(" ");
                          
                           
                            if(cluster_id!=undefined)
                            {
                                
                                 var decoded = villg_subrd[parseInt(cluster_id[1])];
                                
                                 m=1;
                          
                                $.each(decoded, function (key, val) {
                                   
                                   
                                     newBody.push(
                                        [
                                          {text: 'child:'+m, style:'defaultStyle'},
                                          {text: val['cluster_id'], style:'defaultStyle'},
                                          {text: val['district_name'], style:'defaultStyle'},
                                          {text: val['taluk_name'], style:'defaultStyle'},
                                          {text: val['village_name'], style:'defaultStyle'},
                                          {text: val['market_id'], style:'defaultStyle'},
                                          {text: val['distance_subrd'], style:'defaultStyle'},
                                          {text: val['outlet_potential'], style:'defaultStyle'},
                                          {text: val['population'], style:'defaultStyle'},
                                          {text: val['village_choc_consmptn'], style:'defaultStyle'},
                                          {text: val['subrd_priority'], style:'defaultStyle'},
                                          {text: val['subrd_loaction'], style:'defaultStyle'},
                                          {text: val['exist_subrd_code'], style:'defaultStyle'},
                                          {text: val['exist_subrd_name'], style:'defaultStyle'},
                                          {text: '', style:'defaultStyle'},

                                        ]
                                     );
                                });
                            }

                             

                          // Append child data, matching number of columns in table
                         

                        } else {
                          headerLines++;
                        }

                      });

                      //Overwrite the old table body with the new one.
                      doc.content[1].table.headerRows = 1;
                      //doc.content[1].table.widths = [50, 50, 50, 50, 50, 50];
                      doc.content[1].table.body = newBody;
                      doc.content[1].layout = 'lightHorizontalLines';

                      doc.styles = {
                        subheader: {
                            fontSize: 10,
                            bold: true,
                            color: 'black'
                        },
                        tableHeader: {
                            bold: true,
                            fontSize: 10.5,
                            color: 'black'
                        },
                        lastLine: {
                            bold: true,
                            fontSize: 11,
                            color: 'blue'
                        },
                        defaultStyle: {
                            fontSize: 10,
                            color: 'black',
                            text:'center'
                        }
                      };
                    }
                  },
                  {
            extend: 'excelHtml5',
            title: res['head']+'. -  Current Coverage and Recommendations',
           customize: function( xlsx ) {
        var table = $('#griddata').DataTable();
        
      
        var numColumns = table.columns().header().count();

        var sheet = xlsx.xl.worksheets['sheet1.xml'];

        var col = $('col', sheet);
        
         $(col[1]).attr('width', 20);

       
        var sheetData = $('sheetData', sheet).clone();
        
       
        $('sheetData', sheet).empty();

       
        var rowCount = 1;
        
      
        $(sheetData).children().each(function(index) {

         
          var rowIndex = index - 1;
          
         
          if (index > 0) {
            
            // Get row
            var row = $(this.outerHTML);
           
          
            // Set the Excel row attr to the current Excel row count.
            row.attr('r', rowCount);
            
            var colCount = 1;
            
            // Iterate each cell in the row to change the rwo number.
            row.children().each(function(index) {
              var cell = $(this);
            
              // Set each cell's row value.
              var rc = cell.attr('r');
              rc = rc.replace(/\d+$/, "") + rowCount;
              cell.attr('r', rc);         
            if(rowCount==1 || rowCount==2)
            {
                 if (colCount === numColumns) {
                cell.html('');
              }
            }else
              if (colCount === numColumns-1) {
                cell.html('');
              }
              
              colCount++;
            });
       
            // Get the row HTML and append to sheetData.
             //console.log(row[0]);
            //   console.log(row[0].childNodes[1].outerText);
              // console.log(row[0].childNodes[1]);
              
            row_head = row[0].outerHTML;
         
            $('sheetData', sheet).append(row_head);
            rowCount++;
           
            parenttxt=row[0].childNodes[1].outerText;
            childnode=parenttxt.split(" ");
           

              if(childnode[1]!=undefined)
            {
                
                 var decoded = villg_subrd[parseInt(childnode[1])];
                
                 m=1;
         
                $.each(decoded, function (key, val) {
                   val['district_name']=val['district_name'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                   val['taluk_name']=val['taluk_name'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                   val['village_name']=val['village_name'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    val['exist_subrd_name']=val['exist_subrd_name'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

                    childRow = '<row r="' + rowCount + 
                                '"><c  r="A' + rowCount + 
                                '"><v>'+m+'</v></c><c t="inlineStr" r="B' + rowCount + 
                                '"><is><t>Cluster ' + val['cluster_id'] + 
                                '</t></is></c><c t="inlineStr" r="C' + rowCount + 
                                '"><is><t>' + val['district_name'] + 
                                '</t></is></c><c t="inlineStr" r="D' + rowCount + 
                                '"><is><t>' + val['taluk_name'] + 
                                '</t></is></c><c t="inlineStr" r="E' + rowCount + 
                                '"><is><t>' + val['village_name'] + 
                                '</t></is></c><c r="F' + rowCount + 
                                '"><v>' + val['market_id'] + 
                                '</v></c><c  r="G' + rowCount + 
                                '"><v>' + val['distance_subrd'] + 
                                '</v></c><c  r="H' + rowCount + 
                                '"><v>' + val['outlet_potential'] + 
                                '</v></c><c  r="I' + rowCount + 
                                '"><v>' + val['population'] + 
                                '</v></c><c  r="J' + rowCount + 
                                '"><v>' + val['village_choc_consmptn'] + 
                                '</v></c><c t="inlineStr" r="K' + rowCount + 
                                '"><is><t>' +val['subrd_priority'] + 
                                '</t></is></c><c t="inlineStr" r="L' + rowCount + 
                                '"><is><t>' +val['subrd_loaction'] + 
                                '</t></is></c><c t="inlineStr" r="M' + rowCount + 
                                '"><is><t>' + val['exist_subrd_code'] + 
                                '</t></is></c><c t="inlineStr" r="N' + rowCount + 
                                '"><is><t>' +val['exist_subrd_name'] + 
                                '</t></is></c><c t="inlineStr" r="O' + rowCount + 
                                '"><is><t></t></is></c></row>';
                       $('sheetData', sheet).append(childRow);
                       rowCount++;
                       m++;
                });
            }

                     
          } 
          else {
            var row = $(this.outerHTML);
            
            var colCount = 1;
            
            // Remove the last header cell.
            row.children().each(function(index) {
              var cell = $(this);
            
              if (colCount === numColumns) {
                cell.html('');
              }
              
              colCount++;
            });
            row = row[0].outerHTML;
            $('sheetData', sheet).append(row);
            rowCount++;
          }
        });        
      },
            
        }
                ],
                  //  buttons: ['excel', 'pdf', 'print'],
                    paging: true,
                    searching:true,
                    info: false,"pageLength": 15,
                    responsive: false, "deferRender": true

                });
            }
            else if (type == 4 || type==5 || type==6 || type==7 || type==8 || type==9 || type==10 || type==11  || type==13 || type==14 || type==15 || type==16 || type==17 || type==19 || type==20 || type==21 ||type==22 || type==23  || type==24 || type==25 || type==26) {
             
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf', 'print'],
                    paging: true,
                    searching:true,
                    info: false,"pageLength": 20,
                    responsive: false, "deferRender": true

                });
            } else {
              
  
                table = $('#griddata').DataTable({
                    data: res['griddata']['value'],
                    columns: res['griddata']['column'],
                    dom: 'Bfrtip',
                    buttons: btn,
                    paging: true,
                    //searching:true,
                    info: false,"pageLength": 20,
                    responsive: false, "deferRender": true,

                    fnFooterCallback: function(row, data, start, end, display) {

                        if (tablefoot == false && type != 3 && type != 4 && type != 3 && type != 4 && type!=5 && type!=6 && type!=7 && type!=8 && type!=9 && type!=10 && type!=11 && type !=12 && type!=13 && type!=14 && type!=15 && type!=16 && type!=17 && type!=19 && type!=20 && type!=21 && type!=22 && type!=23 && type!=0 && type!=24 && type!=25 && type!=26 && type!=28) {
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
    // function format(id)
    // {
    //   json_str=$(".getchild_"+id).attr("id");
    //   var decoded = JSON.parse($("<div/>").html(json_str).text());
    //   str = '<table class="table table-striped table-bordered" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
    
    //   k=1;
    //   $.each(decoded[0], function (key, val) {
    //     val['exist_subrd_code']=(val['exist_subrd_code']==null) ? '' : val['exist_subrd_code'];
    //     val['exist_subrd_name']=(val['exist_subrd_name']==null) ? '' : val['exist_subrd_name'];
    //     if(val['village_census'][0]==0)
    //         val['village_census']=val['village_census'].slice(1);

    //        str += '<tr class="table-info">';
    //      str +='<td style="width:2rem;text-align:right;">'+k+'</td>';
    //         str +='<td style="width:10rem;text-align:center;">Cluster '+val['cluster_id']+'</td>';
    //          str +='<td style="text-align:left;width:7.5rem;">'+val['district_name']+'</td>';
    //           str +='<td style="text-align:left;width:7.5rem;">'+val['taluk_name']+'</td>';
    //           val2=JSON.stringify(val);
    //            str +='<td style="text-align:left;width:12rem;padding-left:2rem;"><a href="#"  id="'+val['village_census']+'" style="text-decoration:underline;" onClick="showbound(this)">'+val['village_name']+'</a></td>';
    //             str +='<td style="text-align:right;width:7rem;">'+val['market_id']+'</td>';
    //              str +='<td style="text-align:right;width:20rem;">'+val['distance_subrd']+'</td>';
    //               str +='<td style="text-align:right;width:10rem;">'+val['outlet_potential']+'</td>';
    //                str +='<td style="text-align:right;width:10rem;">'+addCommas(val['population'])+'</td>';
    //                 str +='<td style="text-align:right;width:10rem;">'+addCommas(val['village_choc_consmptn'])+'</td>';
                   
    //                  str +='<td style="text-align:right;width:10rem;"><a href="#" id="'+val['subrd_priority']+'" taluk="'+val['taluk_census']+'" subrd_type="'+val['subrd_type']+'" district="'+val['loc9']+'" style="text-decoration:underline" onClick="show_priority(this)">'+val['subrd_priority']+'</a></td>';
    //                  str +='<td style="text-align:right;width:10rem;">'+val['cluster_tag']+'</td>';
    //                   str +='<td style="text-align:right;width:10rem;"><a href="#" id="'+val['exist_subrd_code']+'" taluk="'+val['taluk_census']+'" subrd_type="'+val['subrd_type']+'" district="'+val['loc9']+'" style="text-decoration:underline" onClick="show_existsubrd(this)">'+val['exist_subrd_code']+'</a></td>';
    //                  str +='<td style="text-align:right;width:10rem;">'+val['exist_subrd_name']+'</td>';
    //                  str +='<td style="text-align:right;width:10rem;">&nbsp;</td>';
            
    //         str += '</tr>';
    //         k++;
    // });
      
    //    str += '</table>';
       
    //     return str;

      
    // }
     function format(id)
    {
      json_str=$(".getchild_"+id).attr("id");
      var decoded = JSON.parse($("<div/>").html(json_str).text());
     str='';
    
      k=1;
      $.each(decoded[0], function (key, val) {
        val['exist_subrd_code']=(val['exist_subrd_code']==null) ? '' : val['exist_subrd_code'];
        val['exist_subrd_name']=(val['exist_subrd_name']==null) ? '' : val['exist_subrd_name'];
        if(val['village_census'][0]==0)
            val['village_census']=val['village_census'].slice(1);

           str += '<tr class="table-info">';
           str +='<td style="text-align:right;">'+k+'</td>';
           str +='<td >Cluster '+val['cluster_id']+'</td>';
           str +='<td >'+val['district_name']+'</td>';
           str +='<td >'+val['taluk_name']+'</td>';
           val2=JSON.stringify(val);
           str +='<td ><a href="#"  id="'+val['village_census']+'" style="text-decoration:underline;" onClick="showbound(this)">'+val['village_name']+'</a></td>';
           str +='<td style="text-align:right;">'+val['market_id']+'</td>';
           str +='<td style="text-align:right;">'+val['distance_subrd']+'</td>';
           str +='<td style="text-align:right;">'+val['outlet_potential']+'</td>';
           str +='<td style="text-align:right;">'+addCommas(val['population'])+'</td>';
           str +='<td style="text-align:right;">'+addCommas(val['avg_monthly_sale'])+'</td>';
           str +='<td  style="text-align:right;">'+addCommas(val['village_choc_consmptn'])+'</td>';
             str +='<td  style="text-align:right;">'+addCommas(val['catgry_shr'])+'</td>';
           str +='<td><a href="#" id="'+val['subrd_priority']+'" taluk="'+val['taluk_census']+'" subrd_type="'+val['subrd_type']+'" district="'+val['loc9']+'" style="text-decoration:underline" onClick="show_priority(this)">'+val['subrd_priority']+'</a></td>';
           str +='<td>'+val['subrd_loaction']+'</td>';
           str +='<td><a href="#" id="'+val['exist_subrd_code']+'" taluk="'+val['taluk_census']+'" subrd_type="'+val['subrd_type']+'" district="'+val['loc9']+'" style="text-decoration:underline" onClick="show_existsubrd(this)">'+val['exist_subrd_code']+'</a></td>';
           str +='<td>'+val['exist_subrd_name']+'</td>';
           str +='<td>&nbsp;</td>';
           str += '</tr>';
            k++;
    });
      
      return $(str).toArray();
       
        // return str;

      
    }
    function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
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
           
             if(($.inArray(parseInt(input_obj['type']),[0])) !=-1) 
            {
                
                 var div = L.DomUtil.create('div', 'info legend');

                var labels = [];
                div.innerHTML =data[0];
                      return div;
            }    

           else if(Array.isArray(data))
            {
                if(input_obj.type==26 && data[0]['show_summary']==0)
                      { 
                         var div = L.DomUtil.create('div', 'info legend');

                            var labels = [];
                            div.innerHTML ='';
             
                                 div.innerHTML +='<div class="legend-wraper"><span class="dot"><img src="rural_icon/mdlz_subrd_purple.png" width="18px" height="18px" /></span>SubRD Location</div><div class="legend-wraper"><span class="dot" style="background-color:#39ef59;"></span> Villgs. with Zero RLA (Activated)</div><div class="legend-wraper"><span class="dot" style="background-color:#f2020a;"></span>Villgs. with Zero RLA (Inactive)</div>';
                                  return div;

                      }
            	    if(data[0]['show_summary']!=undefined && data[0]['show_summary']!=null )
                     {
                         var div = L.DomUtil.create('div', 'info2 legend2');

                var labels = [];
                div.innerHTML ='';
                    if(data[0]['Distributor'] ==undefined && data[0]['Distributor']==null)
                     {
                            summary_head=(data[0]['show_summary']==2) ? 'Recommended SubRD Location' : (data[0]['show_summary']==3 ? 'Whlsl Location' : '');
                          

                          texttml='';
                          
                         if(("{{Auth::user()->client_id}}") != 120)
                         {
                           if(data[0]['Most Develpd'] !=0)
                             texttml +='<div class="legend-wraper2" dir="rtl" >Most Develpd Villgs: '+data[0]['Most Develpd']+'</div>';
                           if(data[0]['Develpd'] !=0)
                             texttml +='<div class="legend-wraper2" dir="rtl" >Develpd Villgs: '+data[0]['Develpd']+'</div>';
                         }
                         else
                         {
                             if(data[0]['new_village_recommand'] !=0)
                             texttml +='<div class="legend-wraper2" dir="rtl" >New Villages (Reco SubRD): '+data[0]['new_village_recommand']+'</div>';
                           if(data[0]['new_village_current'] !=0)
                             texttml +='<div class="legend-wraper2" dir="rtl" >New Villages (Current SubRD): '+data[0]['new_village_current']+'</div>';
                         data[0]['new_village']=data[0]['new_village_recommand']+data[0]['new_village_current'];
                         }
                        if(data[0]['show_summary']!=0) 
                           div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper2 " dir="rtl" >'+summary_head+': '+data[0]['total_village']+'</div><div class="legend-wraper2 bgsk" dir="rtl"  >New Villages: '+data[0]['new_village']+'</div>'+texttml+'<hr><div class="legend-wraper" style="color:#000;font-style:bold;line-height: 1;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#555 !important;"></span>&nbsp;Current/Active SubRD Hub</div><div class="legend-wraper" style="color:#000;font-style:bold;line-height: 1;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#d3d3d3 !important;"></span>&nbsp;Current/Active Villg</div><div class="legend-wraper" style="color:#000;font-style:bold;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#fcff00 !important;"></span>&nbsp;New Villg for Current SubRD</div><div class="legend-wraper" style="color:#000;font-style:bold;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#2184a5 !important;"></span>&nbsp;Newly Activated SubRD Hub</div><div class="legend-wraper" style="color:#000;font-style:bold;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#00EFFF !important;"></span>&nbsp;Newly Activated Spoke Villg</div><br><div class="legend-wraper" style="font-size:12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b>MD:</b> Most Develpd</span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> D:</b> Develpd</span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> T:</b> Transition</span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> UD:</b> Under Develpd</span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> NR:</b> Not Rated</span></div><br><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> Zoom into view RPI</b></span></div><br><div class="legend-wraper" style="font-size:12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b>Other Dark Color(s):</b> Recommended SubRD <br> Hub Location </span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> Ligher Shade of Same Color:</b> New Spoke Locations <br>belonging to that Hub</span></div>';  
                        else

                             div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div class="legend-wraper" style="color:#000;font-style:bold;line-height: 1;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#555 !important;"></span>&nbsp;Current/Active SubRD Hub</div><div class="legend-wraper" style="color:#000;font-style:bold;line-height: 1;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#d3d3d3 !important;"></span>&nbsp;Current/Active Villg</div><div class="legend-wraper" style="color:#000;font-style:bold;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#fcff00 !important;"></span>&nbsp;New Villg for Current SubRD</div><div class="legend-wraper" style="color:#000;font-style:bold;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#2184a5 !important;"></span>&nbsp;Newly Activated SubRD Hub</div><div class="legend-wraper" style="color:#000;font-style:bold;"><span class="square" style="border: 2px solid #d3d3d3;background-color:#00EFFF !important;"></span>&nbsp;Newly Activated Spoke Villg</div><br><div class="legend-wraper" style="font-size:12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b>MD:</b> Most Develpd</span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> D:</b> Develpd</span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> T:</b> Transition</span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> UD:</b> Under Develpd</span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> NR:</b> Not Rated</span></div><br><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> Zoom into view RPI</b></span></div> <br><div class="legend-wraper" style="font-size:12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b>Other Dark Color(s):</b> Recommended SubRD <br> Hub Location </span></div><div class="legend-wraper" style="font-size:`12px !important;color:#000!important; word-break: break-word; overflow-wrap: break-word;line-height: 1;"> <span style="font-size:12px !important;font-style:bold;"><b> Ligher Shade of Same Color:</b> New Spoke Locations <br>belonging to that Hub</span></div>';  

                        } 
                     else
                     {
                        if(data[0]['Distributor'] !=0)
                             div.innerHTML +='<div class="legend-wraper2 " dir="rtl">No. of Distrbtr(s): '+data[0]['Distributor']+'</div>';
                         if(data[0]['Sub-Distributor'] !=0)
                             div.innerHTML +='<div class="legend-wraper2 bgsk" dir="rtl">No.of SubRD(s): '+data[0]['Sub-Distributor']+'</div>';

                     } 
                      return div;
                     
                    }
                     else if(data[0]['show_summary']==null ||data[0]['show_summary']==undefined )
                     {
                         var div = L.DomUtil.create('div', 'info2 legend');

                var labels = [];
                div.innerHTML =''; txthml='';
                        $.each(data[0], function(index, value) {

                txthml +=
                    '<div class="legend-wraper2" dir="rtl"><span style="margin-left:7px;background-image:linear-gradient(to right, ' + value + ' , ' + value + ')"></span>' + index + '</div>';

              });

                      div.innerHTML +=' <div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div>'+txthml+'</div></div>';
                     }
                  

            }
            else
            {
                 
                  if(data==9 || data==17 || data==11)
                {
 var div = L.DomUtil.create('div', 'info legend');

                var labels = [];
                div.innerHTML ='';
                colortxt='#0475ff';
                 if(("{{Auth::user()->client_id}}") == 120)
                    colortxt='#502172';
            if(data==9)
                  div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper"> <span class="dot" style="background-color:#FFF"></span> Covered</div><div class="legend-wraper"><span class="dot" style="background-color:#9b5df7"></span> Uncovered</div><div class="legend-wraper"><span class="dot" style="background-color:#0470f4"></span> Visited - Relevant</div><div class="legend-wraper"><span class="dot" style="background-color:#808080"></span> Visited - Not Relevant</div><div class="legend-wraper"><span class="dot" style="background-color:#f21919"></span> Existing</div><hr style="margin:0px 0px 5px 0px;"><div class="legend-wraper">Store Potential</div><hr style="background-color:#fff;margin:0px 0px 4px 0px;"><div class="legend-wraper"><span class="ring" style="border: 2px solid #51c82c"></span> High</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #ff8b02"></span> Medium</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #f21919"></span> Low</div> </div></div>';
              if(data==17 && ("{{Auth::user()->role}}") == 'Country-HO')
             
                div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper"><span class="dot" style="background-color:#51c82c"></span> Found</div><div class="legend-wraper"><span class="dot" style="background-color:#808080"></span> Not Found</div></div>';
           
              if((data==17 && ("{{Auth::user()->role}}") != 'Country-HO') || data==11)
                if(("{{Auth::user()->id}}") != 13285) 
                     div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper"> <span class="dot" style="background-color:#FFF"></span> Uncovered&nbsp;&nbsp;</div><div class="legend-wraper"><span class="dot" style="background-color:#51c82c"></span> Found</div><div class="legend-wraper"><span class="dot" style="background-color:#808080"></span> Not Found</div><div class="legend-wraper"><span class="dot" style="background-color:'+colortxt+'"></span> Covered</div><hr style="margin:0px 0px 5px 0px;"><div class="legend-wraper">Store Potential</div><hr style="background-color:#fff;margin:0px 0px 4px 0px;"><div class="legend-wraper"><span class="ring" style="border: 2px solid #51c82c"></span> High</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #ff8b02"></span> Medium</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #f21919"></span> Low</div> </div></div>';
                 else
                     div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper"> <span class="dot" style="background-color:#FFF"></span> Uncovered&nbsp;&nbsp;</div><div class="legend-wraper"><span class="dot" style="background-color:#51c82c"></span> Found</div><div class="legend-wraper"><span class="dot" style="background-color:#808080"></span> Not Found</div><hr style="margin:0px 0px 5px 0px;"><div class="legend-wraper">Store Potential</div><hr style="background-color:#fff;margin:0px 0px 4px 0px;"><div class="legend-wraper"><span class="ring" style="border: 2px solid #51c82c"></span> High</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #ff8b02"></span> Medium</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #f21919"></span> Low</div> </div></div>';
                      
                      return div;

                }

                  if(data==19)
                {
 var div = L.DomUtil.create('div', 'info legend');

                var labels = [];
                div.innerHTML ='';
 
                     div.innerHTML +='<div class="legend-wraper"><span class="dot" style="background-color:#ed2211;"></span> No SST</div><div class="legend-wraper"><span class="dot" style="background-color:#f5db05;"></span> 1 SST</div><div class="legend-wraper"><span class="dot" style="background-color:#186b57;"></span> >1 SST</div>';
                      return div;

                }
                 if(data==26)
                {
                 var div = L.DomUtil.create('div', 'info legend');

                var labels = [];
                div.innerHTML ='';
 
                     div.innerHTML +='<div class="legend-wraper"><span class="dot" style="background-color:#01ea9e;"></span> Villgs. with Zero RLA (Active)</div><div class="legend-wraper"><span class="dot" style="background-color:#f2020a;"></span>Villgs. with Zero RLA (Inactive)</div>';
                      return div;

                }
                
                //  if(data==15 || data ==23)
                // {
                // var div = L.DomUtil.create('div', 'info legend');
                // var labels = [];
                // div.innerHTML ='';
                //  div.innerHTML +=' <div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper"><img class="ml-1" src="highway/actual_subrd.png" style=" width: 15px;height: 15px;"/> SST Start Point </div></div></div>';
               
                //       return div;

                // }
                 if(data==5)
                {
 var div = L.DomUtil.create('div', 'info legend');

                var labels = [];
                div.innerHTML ='';
 
                     div.innerHTML +='<div class="legend-wraper"><span class="dot" style="background-color:#5fb924"></span> Found</div><div class="legend-wraper"><span class="dot" style="background-color:#808080"></span> Not Found / Visited</div>';
                      return div;

                }
                if(data==10)
                {
                     var div = L.DomUtil.create('div', 'info legend');

                var labels = [];
                div.innerHTML ='';
                    div.innerHTML +='<div class="legend-wraper"><span class="dot" style="background-color:#5fb924"></span>  Uncovered</div>';
                     return div;
                }
                if(data==13)
                {
                     var div = L.DomUtil.create('div', 'info legend');

                var labels = [];
                div.innerHTML ='';
                    div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="margin-right:-10px;top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper2" style="color:#fff;!important"><img src="highway/actual_subrd.png" width="15px" height="15px" />&nbsp;Actual SubRD</div><div class="legend-wraper2" style="color:#fff;!important"><img src="highway/recomnd_subrd.png" width="15px" height="15px" />  &nbsp;Recommended SubRD</div><div class="legend-wraper2" style="color:#fff;!important"><img src="highway/group_a_retailer.png" width="15px" height="15px" />  &nbsp;Group A</div><div class="legend-wraper2" style="color:#fff;!important"><img src="highway/group_b_retailer.png" width="15px" height="15px" />  &nbsp;Group B</div></div></div>';
                   
                     return div; 
                }
                if(data==16)
                {

                     var div = L.DomUtil.create('div', 'info legend');

                var labels = [];
                div.innerHTML ='';
                    div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper2" style="color:#fff;!important"><span style="height: 20px;  width: 20px;  background-color: #ffd700;  border-radius: 50%;  display: inline-block;"></span> Highway Village</div><div class="legend-wraper2" style="color:#fff;!important"><span style="height: 20px;  width: 20px;  background-color: #ffffff;  border-radius: 50%;  display: inline-block;"></span> Inactive Village</div></div></div>';
                   
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

 function cley(x) {
        x.classList.toggle("fa-info");
    }


    function show_priority(data)
    {
       district=$(data).attr('district');
       taluk=$(data).attr('taluk');
       subrd_type=$(data).attr('subrd_type');
       priority=$(data).attr('id');
       filter_dist=[];filter_taluk=[];
       $.each($("input[name='districtlist']:checked"), function() {
                          filter_dist.push($(this).val());
              });
         $.each($("input[name='taluklist']:checked"), function() {
               filter_taluk.push($(this).val());
                       
                       
            });
           
             
      
        input_obj = {
                        'type': 12,                        
                       // 'filter_district':[district],
                        'filter_taluk':filter_taluk,
                        'type_view':subrd_type,
                        'filter_priority':priority,
                        'filter_district':filter_dist
                        
                        };
                        removelayer();
                      
                        $("#showmap").click();
                        map.invalidateSize();
                        initial(input_obj, 0,12, '');
                      
    }
    function close(){
        console.log("subrd");
    }
    function show_existsubrd(data)
    {
       district=$(data).attr('district');
       taluk=$(data).attr('taluk');
       subrd_type=$(data).attr('subrd_type');
       exist_subrd_code=$(data).attr('id');
        filter_dist=[];filter_taluk=[];
       $.each($("input[name='districtlist']:checked"), function() {
                          filter_dist.push($(this).val());
              });
         $.each($("input[name='taluklist']:checked"), function() {
               filter_taluk.push($(this).val());
                       
                       
            });
        input_obj = {
                        'type': 12,                        
                        //'filter_district':[district],
                       // 'filter_taluk':[taluk],
                        'type_view':subrd_type,
                        'filter_existsubrd':exist_subrd_code,
                         'filter_taluk':filter_taluk,
                        'filter_district':filter_dist
                        
                        };
                        removelayer();
                      
                        $("#showmap").click();
                        map.invalidateSize();
                        initial(input_obj, 0,12, '');
                      
    }
    function show_existsubrd_consolidate(data)
    {
       district=$(data).attr('district');
       taluk=$(data).attr('taluk');
       subrd_type=$(data).attr('subrd_type');
       exist_subrd_code=$(data).attr('id');
        filter_dist=[];filter_taluk=[];
       $.each($("input[name='districtlist']:checked"), function() {
                          filter_dist.push($(this).val());
              });
         $.each($("input[name='taluklist']:checked"), function() {
               filter_taluk.push($(this).val());
                       
                       
            });
        input_obj = {
                        'type': 28,                        
                        
                        'filter_existsubrd':exist_subrd_code,
                         'filter_byconsolidatetaluk':filter_taluk,
                        'filter_byconsolidatedist':filter_dist
                        
                        };
                        removelayer();
                      
                        $("#showmap").click();
                        map.invalidateSize();
                        initial(input_obj, 0,28, '');
                      
    }
     function show_clientsstbeat_filter(e,val=0)
    {
         if(e!=0)
        {

         layer=e.target;
          beat_id=layer.feature.properties.Beat_unique_id;
        }
       if(val!=0)
       {
         beat_id=val;
       }
     
      

      filter_beat=[];
     
    
       filter_beat.push(beat_id);
         input_obj = {
                        'type': 23,
                        'filter_sstbeat':input_obj.filter_sstbeat,
                        'filter_beat':filter_beat,
                        
                        };
                        //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
                        removelayer();
                      
                        $("#showmap").click();
                          map.invalidateSize();
                        initial(input_obj, 0,23, false,false,'',false,true,true,false,false,false,true);
    }
    function show_clientsubrdbeat_filter(e,val=0)
    {
        if(e!=0)
        {

         layer=e.target;
          beat_id=layer.feature.properties.Beat;
        }
       if(val!=0)
       {
         beat_id=val;
       }
     
      

      filter_beat=[];
     
    
       filter_beat.push(beat_id);
         input_obj = {
                        'type': 15,
                        
                        
                        'filter_beat':filter_beat,
                        
                        };
                        //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
                        removelayer();
                      
                        $("#showmap").click();
                          map.invalidateSize();
                        initial(input_obj, 0,15, false,false,'',false,true,true,true);
    }
    function show_village_outlet(e,filter='',filter_1='')
    {
        removelayer();
        filter_sstsubrdbeat=[];$filter_beat=[];
        if(filter!='')
        {  $filter_beat=[];
             id=$(filter).attr("id");
             filter_sstsubrdbeat=[id];
             input_obj = {
            'type': 16,
            'filter_sstsubrdbeat':filter_sstsubrdbeat,
           
        };
        }  
        if(filter_1!='')
        {
             id=$(filter_1).attr("id");
             filter_sstsubrdbeat=[id];
             beat=$(filter_1).attr("beat");
             filter_beat=[beat];
             input_obj = {
            'type': 16,
            'filter_sstsubrdbeat':filter_sstsubrdbeat,
            'filter_beat':filter_beat
        };
        }        
       if(filter=='' && filter_1==''){
             layer=e.target;     
             id=layer.feature.properties.Beat_unique_id;
             id=id.split("#");
             filter_sstsubrdbeat = [id[0]];
             filter_beat=[id[1]];
             input_obj = {
            'type': 16,
            'filter_sstsubrdbeat':filter_sstsubrdbeat,
            'filter_beat':filter_beat
        };
        }
         

        
        $("#showmap").click();
        map.invalidateSize();
       initial(input_obj,0,16,false,false,'',false,false,false,false,false,true)

    }
    function show_subrdbeat_filter(e)
    {

       layer=e.target;
     //  console.log(layer);
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
           $("input[name=subrd_beat][value="+subrd_id+"]").prop("checked",true);
    		
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

function show_villagedistrictdetail(state_id,statename,data)
{
    if(data !='')
    {
         villagemapstate=$(data).parent().parent();
    $(".villagemapstate").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");
           // $(this).addClass("filter-data");
        }
    });
    // taluk_state.removeClass("filter-data");
    villagemapstate.addClass("filter-data2");
    }
      district='<?php echo json_encode($user_district);?>';
                  district_=[];
                    district=JSON.parse(district);
                  
                    $.each(district, function(k,v) {
                            district_.push(v);
                    });
                   
                    
   
  ajax_action(state_id,statename,'Get_villagedistrict',district_);
  
     
}
    // function show_highway(highway_id,channel='',subrd_code=0)
    //      {
    //        filter_highway=[];filter_channel='';filter_subrd=0;
    //        if(highway_id!=0)
    //           filter_highway.push(highway_id);
    //        else
    //        {
    //         $.each($("input[name='highwaylist']:checked"), function() {
    //                       filter_highway.push($(this).val());
    //           });
    //        }
    //        if(channel!='')
    //          filter_channel=channel;
    //        if(subrd_code!=0)
    //          filter_subrd=subrd_code;
    //         input_obj = {
    //                     'type': 13,
    //                     'filter_pc': [],
    //                     'filter_distributor': [],
    //                     'filter_so': [],
    //                     'filter_beat':[],
    //                     'filter_highway':filter_highway,
    //                     'filter_channel':filter_channel,
    //                     'filter_subrd':filter_subrd
                        
    //                     };
    //                     //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
    //                     removelayer();
    //                     map.invalidateSize();
    //                     $("#showmap").click();
    //                     initial(input_obj, 0,13, false,false,'',true);
    //      }
     function show_highway(highway_id,channel='',subrd_code=0)
     {
       filter_highway=[];filter_channel='';filter_subrd=0;
       if(highway_id!=0)
          filter_highway.push(highway_id);
       else
       {
        $.each($("input[name='highwaylist']:checked"), function() {
                      filter_highway.push($(this).val());
          });
       }
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
                    'filter_subrd':filter_subrd,
                    'highway_list_id':'filter_byhighway'
                    
                    };
                    //(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false)
                    removelayer();
                    map.invalidateSize();
                    $("#showmap").click();
                    initial(input_obj, 0,13, false,false,'',true);
     }
      function show_state_highway(highway_id,channel='',subrd_code=0)
     {
       filter_highway=[];filter_channel='';filter_subrd=0;
       if(highway_id!=0)
          filter_highway.push(highway_id);
       else
       {
        $.each($("input[name='statehighwaylist']:checked"), function() {
                      filter_highway.push($(this).val());
          });
       }
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
                    'filter_subrd':filter_subrd,
                    'highway_list_id':'state_highwaylist'
                    
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
                // alert(input_obj.type);
                // console.log(input_obj.type);  
        if(input_obj.type==26)
             var featureGroup = L.featureGroup(bounds);
        else
            var featureGroup = L.featureGroup(bounds).addTo(map);
       // var featureGroup = L.featureGroup(bounds); 
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


                //var featureGroup = L.featureGroup(bounds).addTo(map);
                  if(input_obj.type==26)
                           var featureGroup = L.featureGroup(bounds);
                  else
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
//          $(".leaflet-control-locate-location").on("touchstart,touchend,toouch,tap", (e) => {
//     e.stopPropagation();

//     /* open your modal here */
// });
      
         $('.leaflet-control-locate-location').bind('tap', false);
         $('.leaflet-control-locate-location').bind('touchend', false);
         $('.leaflet-control-locate-location').bind('touchstart', false);
         $('.leaflet-control-locate-location').bind('touch', false);
     // $('.leaflet-control-locate-location').bind('touchstart', false);
        $(".leaflet-control-locate-location").on("click", (e) => {
    e.stopPropagation();

    /* open your modal here */
});
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
    function outlet_potential_status(status,refid,cluster_id,status_type) {
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
                        'show_cluster':status_type,
                    };

  if(cluster_id!=0 && status_type=='true')
                input_obj['filter_bycluster']=[cluster_id];


                    initial(input_obj, 0,11, '',false);
                    setTimeout(function showpop(){showarray[outlet_id].openPopup();},1000);

                  


                } else {
                    alert("Not updated");
                }
             
            }
        });

    }
    function outlet_status_mdlz(status,refid,cluster_id,status_type='',save=false) {
       
        outlet_id =refid;
        
        if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }
       data_json={
                'outlet_id': outlet_id,"status":status,"lat":current_location['lat'],"lon":current_location['lon'],"uncovered":1
            }; 
       
       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updateoutlet',
            type: "POST",
            data: data_json,
            dataType: "json",
            success: function(response) {

                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
 //                    filter_rd=[];
 //                   $.each($("input[name='rdbeat']:checked"), function() {
 //                        filter_rd.push($(this).val());
 //                    });
 // input_obj = {
 //                        'type': 17,
                        
 //                        'filter_rd':filter_rd,
                       
 //                    };
           
 //                    initial(input_obj, 0,17, '',false);

                    
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
                   if(status=='NF')
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
                if(("{{Auth::user()->role}}") != 'Country-HO'){
                         filter_rd=[];
                   $.each($("input[name='rdbeat']:checked"), function() {
                        filter_rd.push($(this).val());
                    });
         input_obj = {
                        'type': 17,
                        
                        'filter_rd':filter_rd,
                       
                    };
           
                   initial(input_obj, 0,17, '',true);
             
                }
                else
                {
                     filter_beat= []; filter_bydistrict=[];

                    $.each($("input[name='pre_level']:checked"), function() {
                        filter_beat.push($(this).val());
                    });
                    $.each($("input[name='post_level']:checked"), function() {
                        filter_bydistrict.push($(this).val());
                    });
                    input_obj = {
                        'type': 17,
                        'filter_beat':filter_beat,
                        'filter_bydistrict':filter_bydistrict
                    };
                     initial(input_obj, 0,17, '',true);
                }
                  
                   

                } else {
                    alert("Not updated");
                }
             
            }
        });

        
        
    }
     function hri_outlet_status_mdlz(status,refid,cluster_id,status_type='',datatype) {
       
        outlet_id =refid;
        
        if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }
       data_json={
                'outlet_id': outlet_id,"status":status,"lat":current_location['lat'],"lon":current_location['lon'],"uncovered":1
            }; 
       
       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updateoutlet_delhi',
            type: "POST",
            data: data_json,
            dataType: "json",
            success: function(response) {

                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {
 //                    filter_rd=[];
 //                   $.each($("input[name='rdbeat']:checked"), function() {
 //                        filter_rd.push($(this).val());
 //                    });
 // input_obj = {
 //                        'type': 17,
                        
 //                        'filter_rd':filter_rd,
                       
 //                    };
           
 //                    initial(input_obj, 0,17, '',false);

                    
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
                   if(status=='NF')
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
                if(("{{Auth::user()->role}}") != 'Country-HO'){
                         filter_rd=[];
                   $.each($("input[name='nbhrd_name']:checked"), function() {
                        filter_rd.push($(this).val());
                    });
         input_obj = {
                        'type': 17,
                        
                        'filter_rd':filter_rd,
                        'type_id':datatype
                       
                    };
           
                   initial(input_obj, 0,17, '',true);
             
                }

                  
                   

                } else {
                    alert("Not updated");
                }
             
            }
        });

        
        
    }
     function outlet_status(status,refid,cluster_id,status_type='',save=false) {
        
          if((("{{Auth::user()->client_id}}") == 86) && ((status=='A' || status=='NU' || status=='SR') && save==false))
        {
            if(status=='A')
            {
                console.log( $('.'+refid+'_list_1,.'+refid+'_list_3,.'+refid+'_list_4').attr('style','display:none'));
                 $('.'+refid+'_list_2').attr('style','display:block');
            }
            if(status=='NU')
            {
               console.log( $('.'+refid+'_list_1,.'+refid+'_list_2,.'+refid+'_list_4').attr('style','display:none'));
                 $('.'+refid+'_list_3').attr('style','display:block');
            }
             if(status=='SR')
            {
               console.log( $('.'+refid+'_list_1,.'+refid+'_list_2,.'+refid+'_list_3').attr('style','display:none'));
                 $('.'+refid+'_list_4').attr('style','display:block');
            }

        }
        else
        {
        outlet_id =refid;
        
        if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }
       data_json={
                'outlet_id': outlet_id,"status":status,"lat":current_location['lat'],"lon":current_location['lon']
            }; 
       
       if(status=="SR")
        {
            data_json['retailer_name']=$("#retailer_name_"+outlet_id).val();
               data_json['contact'] =$("#contact_no_"+outlet_id).val();
               data_json['remark'] =$("#remark_"+outlet_id).val();
               if(data_json['retailer_name'] == '')
               {
                 alert("Fill the all blanks.");
                 return false;
               }
        }
        console.log(data_json);


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/updateoutlet',
            type: "POST",
            data: data_json,
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
                       // 'filter_bycluster':[cluster_id],
                        'show_cluster':status_type,
                    };
            if(cluster_id!=0 && status_type=='true')
                input_obj['filter_bycluster']=[cluster_id];
            if(("{{Auth::user()->client_id}}")==115 || ("{{Auth::user()->client_id}}")==123 || ("{{Auth::user()->client_id}}")==0 || ("{{Auth::user()->client_id}}")==1000)
                        input_obj['filter_datatype']=show_cluster[1];


                    initial(input_obj, 0,11, '',false);

                    
                    console.log(showarray[outlet_id]);

                    if(status=='A' || status=='U'  || status=='NU' || status=='SR' || status=='NSR')
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
                    if(status=='V' || status=='NR')
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
        
    }
    function outlet_status_old(status,refid,cluster_id,status_type='') {
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
                       // 'filter_bycluster':[cluster_id],
                        'show_cluster':status_type,
                    };
            if(cluster_id!=0 && status_type=='true')
                input_obj['filter_bycluster']=[cluster_id];


                    initial(input_obj, 0,11, '',false);

                    
                    console.log(showarray[outlet_id]);

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
                    if(status=='V' || status=='U' || status=='NR' )
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
    function show_subrd_tsi(type,id)
    {
         input_obj={'type':type};
         input_obj['cluster_name']=id;
        
       var backbtn = L.easyButton({
            position: 'bottomright',
            states: [{
                stateName: 'globe-layer',
                icon: 'fa fa-arrow-left',
                title: 'Back',
                onClick: function(control) {
                    for (i_ = 0; i_ < dynamic_control['rpi_action_1'].length; i_++) {
                             map.removeControl(dynamic_control['rpi_action_1'][i_]);
                     }
             dynamic_control['rpi_action_1']=[];
                   removelayer();
                  
                   input_obj = {
                        'type': parseInt(input_obj['type'])
                        
                        };
            initial(input_obj, 0,parseInt(input_obj['type']), '');
                }
            }]
        });
         map.addControl(backbtn);
         dynamic_control['rpi_action_1']=[];
         dynamic_control['rpi_action_1'].push(backbtn); 
         $("#showmap").click();
          map.invalidateSize();
         initial(input_obj,0,type,'');
         
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

      
       if(clicked_shop_location!=undefined)
       {
          shop_location=clicked_shop_location.split(",");

         shop_lat=shop_location[0];
         shop_lon=shop_location[1];     
       
         
         str = "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + shop_lat + "," + shop_lon + "'/";
         window.open(str, 'window name', 'window settings');
       }
         
    }
    function location_navigate_popup(data)
    {
        console.log(data);
          getLocation();
          geo = current_location['lat'] + ',' + current_location['lon'];
         
         clicked_shop_location=$(data).attr("geocode");  

       console.log(clicked_shop_location); 
       if(clicked_shop_location!=undefined)
       {
          shop_location=clicked_shop_location.split(",");

         shop_lat=shop_location[0];
         shop_lon=shop_location[1];     
       
         
         str = "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + shop_lat + "," + shop_lon + "'/";
         window.open(str, 'window name', 'window settings');
       }
         
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
    function find_recommadation(e)
    {
         for (i = 0; i < showpop_temp.length; i++) {
        if (map.hasLayer(showpop_temp[i])) {
            map.removeLayer(showpop_temp[i]);
        }
    }
    showpop_temp=[];
         clicked_lat=e.latlng.lat;
         clicked_lon=e.latlng.lng;   
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'dashboard/getrecommandvillage',
            type: "POST",
            data: {
                'clicked_lat': clicked_lat,'clicked_lon':clicked_lon
            },
            dataType: "json",
              beforeSend: function() {
            $(".spin-loader").attr('style', 'display:block');
          },
          complete: function() {
            $(".spin-loader").attr('style', 'display:none');
          },
          error: function() {
            $(".spin-loader").attr('style', 'display:none');
          },
            success: function(response) {
                //response=JSON.parse(response);                              
                if (response['status'] == 'success') {

                              var greenIcon = L.icon({
                                      iconUrl: 'css/images/marker-icon.png',
                                      shadowUrl: '',
                                      iconSize:     [15, 25], // size of the icon
                                      //shadowSize:   [25, 25], // size of the shadow
                                      // iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
                                      // shadowAnchor: [10,10],  // the same for the shadow
                                      // popupAnchor:  [10, 10] // point from which the popup should open relative to the iconAnchor
                                  });

                    m=L.marker([clicked_lat,clicked_lon],{'icon':greenIcon}).bindPopup(response['info']);
                    m.bindContextMenu({
                                contextmenu: true,
                                contextmenuItems: [{text: 'Remove',icon:'images/delete.png',  callback: function() {
                                            for (i = 0; i < showpop_temp.length; i++) {
                                                if (map.hasLayer(showpop_temp[i])) {
                                                    map.removeLayer(showpop_temp[i]);
                                                }
                                            }
                                            showpop_temp=[];
                                          }}]
                            });  
                    showpop_temp.push(m);
                    m.addTo(map);
                    m.openPopup();
                $(".load_district").hide();
                    $(".load_result").click(function(){
                        $(".load_district").slideToggle("slow");
                        $('#tak').toggleClass('mystyle');
                        $("#rem_lddis").slideToggle("slow");

                        // if ($('#rem_lddis').hasClass('d-none')){
                        // $('#rem_lddis').removeClass('d-none');
                        //  } else {
                        //  $('#rem_lddis').addClass('d-none');
                        // }
                        
                    });
                    $(".popup,#tcls").click(function(){
                     
                       showpop_temp[0].closePopup();
                    });


                    // var text = L.tooltip(response['info'],{
                    //       permanent: false,
                    //       direction: 'center',
                         
                    //   }).setLatLng([clicked_lat,clicked_lon]);
                    //   text.addTo(map);
                 

        document.querySelector('#share')
        .addEventListener('click', event => {
  
            // Fallback, Tries to use API only
            // if navigator.share function is
            // available
            if (navigator.share) {
                navigator.share({
  
                    // Title that occurs over
                    // web share dialog
                    title: 'Village Location',
                    text:response['shareinfo'],
                    html:'<b>rega</b>',
                    url:'https://www.google.com/maps/search/?api=1&query='+ clicked_lat +','+clicked_lon+''
                    // // URL to share
                    // url: "https://www.google.com/maps/dir/'" + current_location['lat'] + "," + current_location['lon'] + "'/'" + clicked_lat + "," + clicked_lon + "'/"
                }).then(() => {
                    console.log('Thanks for sharing!');
                }).catch(err => {
  
                    // Handle errors, if occured
                    console.log(
                    "Error while using Web share API:");
                    console.log(err);
                });
            } else {
  
                // Alerts user if API not available 
                alert("Browser doesn't support this API !");
            }
        });
    

                    

                }
            }
        });

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
      function user_activity(type){

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
            url: 'dashboard/user_activity',
            type: "POST",
            data: {
                'lat': current_location['lat'],'lon':current_location['lon'],'type':type
            },
            dataType: "json",
            success: function(response) {
             
               
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

     function getmaker(cluster_id,show_cluster_type)
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
         
        dynamic_control[5].enable();
         obj = {
            'type': input_obj.type,
            'filter_bychannel':selected_id,
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,
            'outlet_type':outlet_type,
            'filter_bystatus':status_selected_id,
            'filter_bycluster':cluster,
            'show_cluster':'true'
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
         


    if(("{{Auth::user()->client_id}}")==15 || ("{{Auth::user()->client_id}}")==0)
    {
         dynamic_control[10].enable();
         filter_rd=[];revenue=[];
         $.each($("input[name='rdbeat']:checked"), function() {
                        filter_rd.push($(this).val());
          });
        if(("{{Auth::user()->client_id}}")==15)
        {
            $.each($("input[name='revenue_list']:checked"), function() {
                        revenue.push($(this).val());
            });
        }
          
         obj = {
            'type': 17,
            'filter_rd':filter_rd,
            'filter_channel':selected_id, 
            'filter_status':status_selected_id,
            'filter_potential':potential_selected_id,
            'outlet_type':outlet_type,
            'filter_revenue':revenue
            };
        if(("{{Auth::user()->client_id}}")==0)
            obj.type_id=filterid[0];

            initial(obj, 0,17, '');
    }
    else
    {
         obj = {
            'type': input_obj.type,
            'filter_bychannel':selected_id,
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,
            'outlet_type':outlet_type,
            'filter_bystatus':status_selected_id
               };
         if(("{{Auth::user()->id}}")==13285)
         {
            filter_rd=[];
              $.each($("input[name='rdbeat']:checked"), function() {
                        filter_rd.push($(this).val());
          });
              obj['filter_rd']=filter_rd;
         }
               
        initial(obj, 2, input_obj.type, true);
    }
         
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
 if ($('#mymodal-filterchannel').hasClass('show')) {
                    $("#mymodal-filterchannel").modal('hide');
                    

                }
                 if(("{{Auth::user()->client_id}}")==15)
                {
                     $('input[name="revenue_list"]').each(function() {
           $('input[name="revenue_list"]').prop('checked', true);
    });
                     dynamic_control[10].disable();
                     filter_rd=[];
                     $.each($("input[name='rdbeat']:checked"), function() {
                                    filter_rd.push($(this).val());
                      });
                     obj = {
                        'type': 17,
                        'filter_rd':filter_rd,
                        
                        };

                        initial(obj, 0,17, '');
                }
                else
                {
                    filter_bychannel();
                }
    }
    function showpotential(id,cluster_id,status='')
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
            'filter_bycluster':[cluster_id],
            'show_cluster':status.toString()
            
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
    function mdlz_filter(type,sub_type,beat,locality,premium_index,snacking_index,potential,revenue)
    {
         filter_rd= [];filer_beat=[];
         if(beat!='' && beat!=null)
            filter_beat=[beat];
         else
            $.each($("input[name='rd_beat']:checked"), function() {
            filter_beat.push($(this).val());
        });

        $.each($("input[name='rdbeat']:checked"), function() {
            filter_rd.push($(this).val());
        });
                   
             obj = {
            'type': 17,
            'filter_rd':filter_rd,
            'filter_bychannel':type,           
            'filter_bysubchannel':sub_type,
            'filter_beat':filter_beat,
            'locality':locality,
            'premium_index':premium_index,
            'snacking_index':snacking_index,
            'potential':potential,
            'revenue':revenue
            
            };

            initial(obj, 0,17, '');
            dynamic_control[10].enable();
            $("#showmap").click();
             setInterval(function(){
      
                 map.invalidateSize();
       }, 1000);

         
    }
      function hri_filter(type,sub_type,datatype)
    {
         filter_rd= [];

        $.each($("input[name='nbhrd_name']:checked"), function() {
            filter_rd.push($(this).val());
        });
                   
             obj = {
            'type': 17,
            'filter_rd':filter_rd,
            'type_id':datatype,
            'filter_bychannel':type,           
            'filter_bysubchannel':sub_type
            
            };

            initial(obj, 0,17, '');
            dynamic_control[10].enable();
            $("#showmap").click();
             setInterval(function(){
      
                 map.invalidateSize();
       }, 1000);

         
    }
    function showuncovered(id,cluster_id,status='')
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
            'filter_beat':filter_beat,'filter_bystatus':status_selected_id,"filter_bycluster":cluster,'show_cluster':status.toString()
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
                        info=changecontent(uncovered_outlet_detail[outlet_id],[],'R',response['feedback_question']);
                 

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
                  //  console.log("#jj_"+this.name+"_"+id);
                    
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
               // console.log(response);                             
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
         
      
      
        
        
      //  console.log(detailed_array);
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
               // console.log(response);                             
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
        
        
     //   console.log(detailed_array);
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
            //    console.log(response);                             
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
//console.log(feedback_question);

    status_info='';
    circle_count=''; style_code='';
   if(parseInt(value.image_count) > 0)
       circle_count='<span class="circle_count">'+value.image_count+'</span>';
    
     if(status=='R')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-danger Capture-btn-relevant not-relevant-edit-button" >Not Relevant  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload text-white"><button type="button" class="btn bg-transparent upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
      if(status=='NF')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-bgnd Capture-btn-relevant not-relevant-edit-button" >Store not found  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload text-white"><button type="button" class="btn bg-transparent upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
    if(status=='E')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-bgnd Capture-btn-relevant not-relevant-edit-button" >Existing '+client_name+' Store  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload text-white"><button type="button" class="btn bg-transparent upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';

    if(status=='A')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-success Capture-btn edit-button" >Relevant  </button></a><span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload text-white"><button type="button" class="btn bg-transparent upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
      
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
                     info +='<div class="Relevant-Store-wrapper first_div'+value.refid+'" style="display:none;"><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item"><a href="#"><button type="button" class="btn-success Capture-btn" onClick="next(\'initial_div'+value.refid+'\',0,'+value.refid+')">Relevant Store</button></a></li><li class="list-group-item"><a href="#"><button type="button" class="btn btn-bgnd Capture-btn-relevant" onClick="notrelevant('+value.refid+',\''+value.shop_image+'\',\''+value.outlet_name+'\',\''+value.channel_name+'\',\''+value.sub_channel_name+'\',\''+value.address+'\',\''+value.lat+'\',\''+value.lon+'\')">Not Relevant Store</button></a></li></ul></div>';
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
//console.log(value);
client_name="{{Auth::user()->Organization}}";
     style_code='';
    status_info='';
    circle_count='';
    count_radio=0;
   if(parseInt(value.image_count) > 0)
       circle_count='<span class="circle_count">'+value.image_count+'</span>';
    


      if(status=='R')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class=" Capture-btn-relevant not-relevant-edit-button btn-bgnd" >Not Relevant  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload text-white"><button type="button" class="btn bg-transparent upload" style="color:white;" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
      if(status=='NF')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-bgnd Capture-btn-relevant not-relevant-edit-button" >Store not found  </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload text-white"><button type="button" style="color:white;" class="btn bg-transparent upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';
      if(status=='E')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-bgnd Capture-btn-relevant not-relevant-edit-button" >Existing '+client_name+' Store </button></a> <span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload text-white"><button type="button" style="color:white;" class="btn bg-transparent upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';


    if(status=='A')
        status_info='<li class="list-group-item"><a href="#"><button type="button" class="btn btn-success Capture-btn edit-button" >Relevant  </button></a><span class="edit-bar"><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="next(\'first_div'+value.refid+'\',1,'+value.refid+')"></i></span> </li><li><div class="form-check capturedetails-upload text-white"><button type="button" style="color:white;" class="btn bg-transparent upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal(\''+value.refid+'\');">Upload Store Photo(s)</button>'+circle_count+'<a href="#"><span class="upload-edit-button-icon"><i class="fa fa-upload upload-button-icons" aria-hidden="true"></i>('+value.image_count+')</span><a></div></li>';

                          style_code='';
                            if(value.potential_status=='High')
                              style_code='background-color:#51c82c';
                             if(value.potential_status=='Medium')
                              style_code='background-color:#ed8102';
                             if(value.potential_status=='Low')
                              style_code='background-color:#bf1414';
 

                        info = '<div class="media outlet-list zero'+value.refid+'"  ><img class="p-2 align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><div class="media-body"><ul class="list-group"><li class="list-group-item"><h3>' + value.outlet_name + '</h3><span class="store-high" style="'+style_code+'">'+value.potential_status+'</span></li><li class="list-group-item chnl-typ">' + value.channel_name + ' / ' + value.sub_channel_name + '</li><li class="list-group-item">' + value.address + '</li>'+status_info+'</ul></div><div class="popup-footer" ><span style="background-color:none;text-align:right;" class="navigate_location" geocode="'+value.lat+','+value.lon+'" onclick="location_navigate(this)">Click to Navigate</span></div></div>';
                    if(("{{Auth::user()->client_id}}") == 100)
                    {
                       info +='<div class="Relevant-Store-wrapper first_div'+value.refid+'" style="display:none;"><img class="p-2 align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"><li class="list-group-item"><a href="#"><button type="button" class="btn-success bg-transparent Capture-btn-details Capture-btn" onClick="next(\'initial_div'+value.refid+'\',0,'+value.refid+')">Relevant Store</button></a></li><li class="list-group-item"><a href="#"><button type="button" class="btn btn-bgnd Capture-btn-relevant" onClick="notrelevant('+value.refid+',\''+value.shop_image+'\',\''+value.outlet_name+'\',\''+value.channel_name+'\',\''+value.sub_channel_name+'\',\''+value.address+'\',\''+value.lat+'\',\''+value.lon+'\')">Not Relevant Store</button></a></li></ul></div>';
                         info +='<div class="Brand-Availability-wrapper initial_div'+value.refid+'"  style="display:none;" ><img class="align-self-start" src="' + value.shop_image + '" width="auto" alt="" height="250px"><ul class="list-group"> <li class="list-group-item Brand-wrapper" id="bg-box-title"><span class="Brand-Availability">Choose Channel type</span></li> <li class="list-group-item form-wrapper"></li>';
                         count_radio=0;
//console.log(value);
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
                                        //  console.log(detailed_array);
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
    // console.log(detailed_array);
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
       //  console.log(value['freezer']);       
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
  {
     res_div=class_div.split("_");
      result_div=['option'+res_div[1]+'5-10','option'+res_div[1]+'10-15','option'+res_div[1]+'1-5','option'+res_div[1]+'Above','option_'+res_div[1]+'5-10','option_'+res_div[1]+'10-15','option_'+res_div[1]+'1-5','option_'+res_div[1]+'Above'];
      $.each(result_div,function(k,v){
        
        $('.'+v).attr("style","");
      });
      //$('.'+class_div+' > .btn-age-select-wrapper').attr("style","");
     
  }
   
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
      <div class="modal-body" style="overflow-y: auto">
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
 openCity1(event, 'home-line-tab');
    

});



function bgclrch() {
  document.body.style.backgroundColor = "red";
}

function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function legend_pop()
{
    var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  // if($("#hint").hasClass("fas fa-close"))
  // {
  //   $("#hint").removeClass("fas fa-close");
  //   $("#hint").addClass("fas fa-info");

  // }
  // if($("#hint").hasClass("fas fa-info"))
  // {
  //   $("#hint").removeClass("fas fa-info");
  //   $("#hint").addClass("fas fa-close");

  // }
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
      showstate='<?php echo $multiple_state;?>';
        if(!showstate)
        {
            $('#back_state').each(function(){
                $(this).hide();
            })
        }

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