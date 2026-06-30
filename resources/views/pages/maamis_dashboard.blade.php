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
  padding: 2px 6px;
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
          width:18px;
          height:25px;
          margin-top:1.5rem;
    
        }
 .modal-body {
        color: #fff;
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
                if((Auth::user()->client_id)!=115)
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
                       <div class="form-check form-check-inline filter-data-0">
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
                    <div class="form-check form-check-inline filter-data-0">
                         <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="statuslist_" name="statuslist" value="C" checked/>
                         &nbsp;Store Closed
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
                   </div>
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
                <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">State Name</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="state_name" name="fname" value="Cluster 1763" readonly></span></div>
                 <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Distt Name</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="district_name" name="fname" value="Cluster 1763" readonly></span></div>
                <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Sub-Distt Name</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="sub_distt_name" name="fname" value="Cluster 1763" readonly></span></div>
                 <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Town / Village Name</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="town_village_name" name="fname" value="Cluster 1763" readonly></span></div>
                  <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Market UID</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="market_uid" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                   <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">BI Locatn ID</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="bi_id" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                   <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Village Census</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="village_census" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                    <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Distance from Recmmd SubRD / Wholesale Locatn (Km)</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="distance" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                     <!-- <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Recommndd SubRD / Wholesale Location</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="recommand_subrd" name="fname" value="Cluster 1763"></span></div> -->
                      <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Outlet potential</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="outlet_potential" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                       <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Population 2021</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="pop_2021" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
                        <!-- <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Taluk Census</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="taluk_census" name="fname" value="Cluster 1763"></span></div> -->
                         
                          <div class="row"><span class="col-6" style="text-align: right;"><label for="fname" style="color:rgb(206,86,29);text-decoration: underline;">Village Chocolate Consmptn (Rs.)</label>&nbsp;&nbsp;&nbsp;</span><span class="col-6"><input type="text" id="consmptn" name="fname" value="Cluster 1763" style="text-align:right;" readonly></span></div>
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

<div id="mymodal-taluk" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="district_head">Select Distt. / Drill Down into Distt.</h5>
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
<div id="mymodal-district" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="district_title">Select Distt. / Drill Down into Distt.</h5>
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
<div id="mymodal-taluk_state" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="talukstate_list" style="color:#fff;overflow-y: auto">

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
<div id="mymodal-outletdistrict_list" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="district_title">Select Distt. / Drill Down into Distt.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
<div class="modal-body district_listout" id="district_list" style="color:#fff;min-height: 5rem !important;overflow-y: auto !important;"  >
    
</div>
  
            <div class="modal-footer">

                
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_outletdistrict')" id="back_state">Back</button>
                </div>
               
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_outletdist" id="filteroutlet_bydist">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-outlettaluk_list" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="taluk_title">Select Taluk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
<div class="modal-body taluk_listout" id="outlettaluk_list" style="color:#fff;min-height: 5rem !important;overflow-y: auto !important;"  >
    
</div>
  
                    
            <div class="modal-footer">

                
                <div class="form-group" style="float:left;">
                    <button class="btn btn-primary" onClick="back('back_talukdistrict')" id="back_state">Back</button>
                </div>
               
                <div class="form-group">
                    <button class="btn btn-primary" name="filter_outletdist" id="filteroutlet_bytaluk">Apply</button>
                </div>
            </div>

            




        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="mymodal-outletstate_list" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select State</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="outletstate_list" style="color:#fff;overflow-y: auto">

                 @for ($m = 0; $m < count($outlet_state_list); $m++)
              <div class="form-check form-check-inline filter-data outletstate">
                  
                <label class="form-check-label2 pl-2 pr-2">
                        <input type="radio" name="outletstate_list" value="{{$outlet_state_list[$m]->state}}" class="show_subordinate" hidden="true" onClick="show_district('{{$outlet_state_list[$m]->id}}',this)"> {{$outlet_state_list[$m]->state}}</input>
                       
                        <i class="input-frame"></i><i class="input-frame"></i><i class="input-frame"></i></label>
            </div>
        
            @endfor
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
                  <input type="file" name="img[]" capture="environment"  class="file-upload-default" accept="image/*" multiple="true">
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
    var global_data=[];

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

const MAPTILER_API_KEY = "{{ config('services.maptiler.key') }}";
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



     item=[
            {
                text: 'Show Direction',
                //icon: 'images/zoom-out.png',
                callback: direction

            }];

coordinate=[23.473324, 77.947998,5];
 
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
       // style: 'https://api.maptiler.com/maps/c32455b0-bf68-4a55-b8d7-e0f8a2e51fdd/style.json?key=t48sy8w2bGMZMaxREggf'
        style:`${MAPTILER_API_KEY}`
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


     map.on('zoomend', function() {


         zoomrange = map.getZoom();


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

function isNumber(evt) {
             
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
           
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

function ajax_action(id,location_name,show_level,district=[],type='',country_id=0,level_id=0)
{

obj = {
            'id': id,
            'show_level':show_level,
            'district':district,
            'type':0,
            'data_type':type,
             'country_id':country_id,
            'level_id':level_id
            
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
                    if(show_level=='Get_outlettaluk')
                    {
                         $("#outlettaluk_list").html('');
                         $("#outlettaluk_list").html(res['data']);                         
                         $('#mymodal-outletdistrict_list').modal('hide');
                         $('#mymodal-outlettaluk_list').modal('show');
                    }
                     if(show_level=='Getsubrd_district')
                     {
                         $("#districtlistbeat").html('');
                         $("#districtlistbeat").html(res['data']);
                         $("#beatdistrict_title").html('Select '+location_name+' Distt. / Drill Down into Distt.');
                         $('#mymodal-beat_state').modal('hide');
                         $('#mymodal-beatdistrict').modal('show'); 

                     }
                     if(show_level=='Getsubrd_subrd')
                     {
                        $('#subrdbeatlist').html('');
                        $('#subrdbeatlist').html(res['data']);
                        $('#mymodal-beatdistrict').modal('hide');
                        $('#mymodal-subrdbeat').modal('show'); 
   
                     }
                     if(show_level=='Get_outletdistrict')
                     {
                        $('#district_list').html('');
                        $('#district_list').html(res['data']);
                        $('#mymodal-outletstate_list').modal('hide');
                        $('#mymodal-outletdistrict_list').modal('show'); 
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
                             $("#uncovered_title").html('Select the Beat');
                        if(("{{Auth::user()->client_id}}") == 120) 
                             $("#uncovered_title").html('Select RD. / Drill Down into Beat.');
 

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
                     if(show_level=='Get_highway')
                     {
                          $("#highway_title").html('Select Assigned '+location_name+' Highway(s)');
                          $('#mymodal-highway_state').modal('hide');
                          $('#mymodal-highway').modal('show'); 
                          $('#highwaylist').html(res['data']);
                     }

                     if(show_level=='Get_subrddistrict') 
                     {
                          $("#district_title").html('Select Assigned '+location_name+' Highway(s)');
                          $('#mymodal-taluk_state').modal('hide');
                          $('#mymodal-district').modal('show'); 
                          $('#districtlist').html(res['data']);
                     }
                      if(show_level=='Getsstbeat_district')
                     {
                        $("#districtlistsstbeat").html('');
                         $("#districtlistsstbeat").html(res['data']);
                         $("#sstbeatdistrict_title").html('Select '+location_name+' Distt. / Drill Down into Distt.');                         
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

    /////////////Easy Buttonfunction /////////////////////////
 //if((("{{Auth::user()->client_id}}") != 115  && ("{{Auth::user()->client_id}}") != 15) || (("{{Auth::user()->client_id}}")==123 || ("{{Auth::user()->client_id}}")==0 ||  ("{{Auth::user()->client_id}}")==1000))
    //{
    // var opacity_button = L.easyButton({
        // position: 'bottomright',
        // states: [{
            // stateName: 'globe-layer',
            // icon: 'fa fa-cog',
            // title: 'Change map opacity',
            // onClick: function(control) {
                // $(".leaflet-range-control").toggleClass('show-range');
            // }
        // }]
    // });
      // map.addControl(opacity_button);


    // var range_control_button = L.control.range({
        // orient: 'horizontal',
        // value: 100,
        // position: 'bottomright',

    // });
    // overlay_arr[0] = 1;
    // range_control_button.on('change input', function(e) {
        // opacityval = e.value / 100;
        // overlay_arr[0] = opacityval;
        // change_opacity();
    // });

    // map.addControl(range_control_button);
    // }


         // var backbtn = L.easyButton({
            // position: 'bottomright',
            // states: [{
                // stateName: 'globe-layer',
                // icon: 'fa fa-arrow-left',
                // title: 'Back',
                // onClick: function(control) {
                   
                    // filter_beat = [];

                    // $.each($("input[name='beat']:checked"), function() {
                        // filter_beat.push($(this).val());
                    // });


                    // outlet_type=[];selected_id=[];potential_selected_id=[];status_selected_id=[];

                 // $('input[name="outlets"]:checked').each(function() {
                      // outlet_type.push(this.value);
              // });
                   // $('input[name="tag_list"]:checked').each(function() {
                      // selected_id.push(parseInt(this.value));
              // });
                    // $('input[name="potentiallist"]:checked').each(function() {
                      // potential_selected_id.push(parseInt(this.value));
              // });
                    // $('input[name="statuslist"]:checked').each(function() {
                      // status_selected_id.push(this.value);
              // });
        // dynamic_control[5].disable();

                   // input_obj = {
                      // 'type': 11,
                      // 'cluster_id':[],
                         
                      // 'filter_bypotential':potential_selected_id,
                      // 'filter_beat':filter_beat,
                      // 'filter_bystatus':status_selected_id
                      // };
                    // initial(input_obj, 0,11, '');


                // }
            // }]
        // });
        // map.addControl(backbtn);
         // dynamic_control[5]=backbtn;
         // dynamic_control[5].disable();
    
         // var filter = L.easyButton({
            // position: 'bottomright',
            // states: [{
                // stateName: 'beat-list',
                // icon: 'fa fa-road',
                // title: 'beat-list',
                // onClick: function(control) {
                    // $('#mymodal-beat').modal('show');
                // }
            // }]
        // });
        // map.addControl(filter);

        // var filer_clear = L.easyButton({
        // position: 'bottomright',
        // states: [{
            // stateName: 'Clear Filter',
            // icon: '<i class="fa fa-trash"></i>',
            // title: 'Clear',
            // onClick: function(control) {
              
                 // $("#clearresult").click();
               //showboundbyusertype('');
                // $('#maphead').html('');
                // legendremove();
                // removelayer();
                // $("#showdata").css("display", "none");
                // if(dynamic_control[5]!=null && dynamic_control[5] !=undefined)
                 // dynamic_control[5].disable();
            // }
        // }]
    // });
    // map.addControl(filer_clear);
     // var filter_channel = L.easyButton({
            // position: 'bottomright',
            // states: [{
                // stateName: 'globe-layer',
                // icon: 'fa fa-filter',
                // title: 'Filter',
                // onClick: function(control) {
                    // $('#mymodal-filterchannel').modal('show');
                // }
            // }]
        // });
        // map.addControl(filter_channel);
    
 
if(("{{Auth::user()->user_type}}") == 'TSM' && ((("{{Auth::user()->client_id}}")==120) || (("{{Auth::user()->client_id}}")==123) || (("{{Auth::user()->client_id}}")==0) || (("{{Auth::user()->client_id}}")==150) || (("{{Auth::user()->client_id}}")==112) || ("{{Auth::user()->client_id}}")==1000 ))
    {
     
        if(("{{Auth::user()->login_type_mdlz}}") == 'Urban')
     {
        // var calendar = L.easyButton({
        // position: 'bottomright',
        // states: [{
            // stateName: 'Calendar',
            // icon: '<i class="fas fa-calendar"></i>',
            // title: 'Calendar',
            // onClick: function(control) {
                 // $('#prdSelect').modal('show');

            // }
        // }]
    // });
         // map.addControl(calendar);  
         // var city_list = L.easyButton({
                // position: 'bottomright',
                // states: [{
                    // stateName: 'Citylist',
                    // icon: '<i class="fas fa-city"></i>',
                    // title: 'Citylist',
                    // onClick: function(control) {
                        // $("#mymodal-citylist").modal('show');

                    // }
                // }]
            // });
         // map.addControl(city_list);
         // var filer_clear = L.easyButton({
        // position: 'bottomright',
        // states: [{
            // stateName: 'Clear Filter',
                // icon: '<i class="fa fa-trash"></i>',
                // title: 'Clear',
                // onClick: function(control) {
                    // $("#clearresult").click();
                    // history_map=[];
                 //  showboundbyusertype('');
                    // $('#maphead').html('');
                    // legendremove();
                    // removelayer();
                    // $("#showdata").css("display", "none");
                // }
            // }]
        // });
         // map.addControl(filer_clear);
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
 
    
    function style(feature) {
        return {
            fillColor: '#ffffff',
            color: '#808080',
            weight: 1,
            stroke: 2,
            fillOpacity: overlay_arr[0]
        };
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



   function initial(input_obj, initialmap, type, filter = false,page_text=false,rpi_action = '',highway=false,subrd=false,filter_subrd=false,filter_clientsubrd=false,show_highway_outlet=false,back_sst=false)  // First - input parameter //second - 1-forward 2-load currentlevel data -1 back
    {

       if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }
       
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
                  if ($('#mymodal-outletdistrict_list').hasClass('show')) {
                    $("#mymodal-outletdistrict_list").modal('hide');
                    removelayer();

                }    
                 if ($('#mymodal-outlettaluk_list').hasClass('show')) {
                    $("#mymodal-outlettaluk_list").modal('hide');
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
                if(type==12){
                    if(type==12)                       
                        villg_subrd=res['child_list'];
                  removelayer();
                  
                 
                }

                 
                if(type==11)
                  removelayer();

                    if($.inArray(type,[12,20])!=-1)
                    {
                        removelayer();
                        legendremove();
                       loadmap(res, '');
                         changeproperty(res, type);
                       if(rpi_action!='')
                          $(".state-" + rpi_action).click();
                      $("#maphead").html(res['head']);
                       legend(res['maplegend']);
                    }
                   
              

                if (!isEmpty(res['maplist'])) {

                    Globalobject[0] = res["tbl"];

                    $("#maphead").html(res['head']);
                    if (filter) {
                        removelayer();
                       
                          if(type==11){
                          	changeproperty(res, type);
                          	legendremove();
                            legend(res['maplegend']);
                          }
                            
                            tablebuild(res, type);
                            
                        
                        $('#mymodal-filter').modal('hide');
                    } else {
                       

                        if (res.hasOwnProperty('griddata')) {
                           if(type==11){
                           	 changeproperty(res, type);
                           	 legendremove();
                            legend(res['maplegend']);
                           }
                          
                            tablebuild(res, type);
                            
                            $("#maphead").html(res['head']);
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
                             
                             if(type==11)
                             {
                               legendremove();
                             //  console.log(input_obj.filter_bycluster);
                               if(input_obj.filter_bycluster !== undefined)
                                if(input_obj.filter_bycluster.length > 0)
                                  legend(type);

                             }
                            
                             legend(type);
                             $("#maphead").html(res['head']);
                           // legend(res['maplegend']);
                        }
                       
                    }
                }
            
               
               //  map.invalidateSize();

            }
        });
    }
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

         if(message!='' && message!=undefined && message!=null)
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
      
        if(geo_layer.length>0)
        {
              var featureGroup = L.featureGroup(geo_layer).addTo(map);
              if(res['fit_bounds']==undefined && res['fit_bounds']==null && res['fit_bounds']!=1)
                    map.fitBounds(featureGroup.getBounds());          
              overlay_arr['geolayer'] = featureGroup;
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

  $("#village_name").html(data[0].village_name +'<img class="ml-2 float-right"  src="icons/navigation-icon.png" height="30px">');
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
   $("#navigation").attr("geocode",data[0]['latitude']+','+data[0]['longitude']);
   
    $('#mymodal-village').modal('show'); 
    $("#navigation").attr("onClick",location_navigate(this));

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
     function resetHighlight(layer) {
        //var layer = e.target;
        layer.setStyle({
            color: 'black',
             weight: (zoomrange >= 16) ? 5 : 0.5,
            stroke: (zoomrange >= 16) ? 5 : 0.8,
            fillOpacity: overlay_arr[0]
        });
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
       $("#filteroutlet_bydist,#filteroutlet_bytaluk").click(function(){
                filter_beat = [];
                  input_obj = {
                        'type': 11,
                        'cluster_id': [0],                        
                        'filter_beat':[]
                       
                    };
        if($(this).attr('id')=='filteroutlet_bydist')
        {
             $.each($("input[name='outlet_district']:checked"), function() {
                        filter_beat.push($(this).val());
                    });
             input_obj['filter_bydistrict']=filter_beat;
        }
         if($(this).attr('id')=='filteroutlet_bytaluk')
        {
             $.each($("input[name='outlet_taluk']:checked"), function() {
                        filter_beat.push($(this).val());
                    });
             input_obj['filter_bytaluk']=filter_beat;
        }
                   
                  
                    initial(input_obj, 0,11, '');
                });
         $("#filter_bybeat").click(function() {
                    filter_beat = [];

                    $.each($("input[name='beat']:checked"), function() {
                        filter_beat.push($(this).val());
                    });
                    input_obj = {
                        'type': 11,
                        'cluster_id': [],                        
                        'filter_beat':filter_beat
                    };
                    initial(input_obj, 0,11, '');
                });
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

                   // $('#mymodal-beat').modal('show');
                $('#mymodal-outletstate_list').modal('show');
                
                 }
                    
                 
                 
              //
                input_obj.filter_beat=filter_beat;
                show_cluster[0]=show_cluster_;
                console.log(show_cluster[0]);
                // initial(input_obj, 2, type);
            }
             if (type == 12)
            {


                 showstate='<?php echo $multiple_state;?>';

                  if(showstate==true)
                  {
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
             
             
      if(type!=15 && type!=14 && type!=13 && type!=12 && type!=11 && type!=9 && type!=16 && type!=17 && type!=0 && type!=20 && type!=21)
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
    function haldiram_filter(type='',sub_type='',potential='',loc9=0,loc10=0)
    {
        filer_beat=[];
         
         $.each($("input[name='beat']:checked"), function() {
            filter_beat.push($(this).val());
        });

         
       dynamic_control[5].enable();

         obj = {
            'type': 11,
            'filter_beat':[],
            'show_cluster':'true'};
           if(loc9!=0)
               obj['filter_bydistrict']=[loc9];
           if(loc10!=0)
               obj['filter_bytaluk']=[loc10];
           
         if(type!='')
             obj['filter_bychannel']=[type];
         if(sub_type!='')
             obj['filter_bysubchannel']=[sub_type];
         if(potential!='')
             obj['filter_bypotential']=[potential];

        if(cluster_id!='')
             obj['cluster_id']=[cluster_id];

               
        initial(obj, 11, input_obj.type, true);

            $("#showmap").click();
             setInterval(function(){
      
                 map.invalidateSize();
       }, 1000);

         
    }
function show_outlettaluk(data)
{
    district_name=$(data).attr('id');
    ajax_action(district_name,district_name,'Get_outlettaluk');

}
function show_district(statename,data)
{
    if(data !='')
    {
         taluk_state=$(data).parent().parent();
    $(".outletstate").each(function(){
        if($(this).hasClass("filter-data2"))
        {
            $(this).removeClass("filter-data2");
           // $(this).addClass("filter-data");
        }
    });
    // taluk_state.removeClass("filter-data");
    taluk_state.addClass("filter-data2");
    }

  ajax_action(statename,statename,'Get_outletdistrict');
  
     
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
  
     
}
function showtaluk(data)
{
  district_id=$(data).attr('id');
  district_name=$(data).attr('district_name');
  $("#district_head").html($(data).attr('district_name')+ ' Distt. - Select Sub-Distt.');
  ajax_action(district_id,district_name,'Get_subrdtaluk')
  // $('#mymodal-district').modal('hide');
  // $('#mymodal-taluk').modal('show'); 
  // $( ".district_taluk" ).each(function(  ) {
  //   $(this).hide();
  // });
  // $('#taluklist_'+district_id).show();
  //  $.each($("input[name='taluklist']:checked"), function() {
  //   $(this).prop("checked",false);
  //  });
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
     if(name=="back_outlettaluk")
     {

        $('#mymodal-outletdistrict_list').modal('hide');
        $('#mymodal-outletstate_list').modal('show');
     }
     if(name=="back_talukdistrict")
     {
         $('#mymodal-outletdistrict_list').modal('show');
        $('#mymodal-outlettaluk_list').modal('hide');
     }

     if(id==1 || id==2 || id==3 || id==4)
     {
        console.log( $('.'+name+'_list_1,.'+name+'_list_2,.'+name+'_list_3,.'+name+'_list_4').attr('style','display:none'));
                 $('.'+name+'_list_'+id).attr('style','display:block');
     }
        
  

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
                        if(result.subrd_status == 1 && result.subrd_loaction=='Existing Urban Distbtr Hub')  
                             urban_subrd.push(marker);
                         if(result.subrd_status == 1 && result.subrd_loaction!='Existing Urban Distbtr Hub') 
                             exist_subrd.push(marker);
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
                   
                      rpi_tooltip.push(marker);
                                        rpi_popup[nextinfo.loc_id]=marker;
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
    function changeproperty(res, type) {

        global_data=[];
        if($.inArray(type,[12,0,20])!=-1)
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
      map.addControl(exist_subrd_button);
      dynamic_control['rpi_action'].push(exist_subrd_button);
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
        if (type==11) {

            removelayer();
            k = 1; style_code='';
           
            $.each(res['map_nextlevel_info'], function(key, value) {
                global_data[value.refid]=value;
                if ((value.latitude != '' && value.longitude != '') && (value.latitude !== undefined && value.longitude !== undefined) && (value.latitude !== 'undefined' && value.longitude !== 'undefined')) {

                     info = '';
                      if(type==11)   
                     {
                        info='';
                        info=getinfo(value);
                    if (value.icon != '' && value.icon !== undefined) {

                        var greenIcon = L.icon({
                            iconUrl: value.icon,
                            iconSize: [24, 24]
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
                     var m = new L.Marker(new L.LatLng(value.latitude, value.longitude), {
                            icon: greenIcon,
                             iconSize: [5, 5]
                        });
                    m.bindPopup(info, {
                        'sticky': true,
                        pane: 'tool',
                        direction: 'top'
                    });
                     if(type==11 )  
                      {
                       

                         showarray[value.refid]=m;
                         if(value.cluster_id)
                         {
                              if(value.cluster_id in marker_cluster_list){
                           
                             marker_cluster_list[value.cluster_id].push(m);

                             find_val[value.cluster_id][value.potential]++;
                          }
                          else
                          {
                             marker_cluster_list[value.cluster_id]=[];
                             find_val[value.cluster_id]=[];
                             find_val[value.cluster_id][1]=0;
                             find_val[value.cluster_id][2]=0;
                             find_val[value.cluster_id][3]=0;
                              marker_cluster_list[value.cluster_id].push(m);
                              find_val[value.cluster_id][value.potential]++;

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


                }}

            });
            console.log(marker_cluster_list);
            if(type==11  && marker_cluster_list.length > 0)
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
                          var html = '<div class="circle">  <div class="inner"><strong style="font-weight:900 !important;color:black;font-size:10px">C'+k+'</strong>  <b style="color:blue">'+markers.length + '</b><br><b style="color:green">'+find_val[k][3]+'</b> <span style="color:black">|</span> <b style="color: #ed8102">'+find_val[k][2]+'</b> <span style="color:black">|</span> <b style="color: #bf1414">'+find_val[k][1]+'</b></div></div>';
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
             if(type==11)
             {
                map.scrollWheelZoom.enable();
                //dynamic_control[5].enable();
             }


           }
           

        }




    }
  
   
 function getinfo(value,status='',potential_status='')
{

     found='';not_found='';visited='';circle_count='';closed_store='';
     low_status='';medium_status='';high_status='';
    if(potential_status!='')
    {
         value.potential_status=potential_status;
         global_data[value.refid]['potential_status']=value.potential_status;
    }
      value.potential_status=global_data[value.refid]['potential_status'];
      if(value.potential_status==1)
          low_status='checked';
      if(value.potential_status==2)
          medium_status='checked';
      if(value.potential_status==3)
          high_status='checked';
    if(status!='')
    {
         value.status=status;
         global_data[value.refid]['status']=value.status;
    }
    value.status=global_data[value.refid]['status'];
    if(value.status=='A' || value.status=='U' || value.status=='NU' || value.status=='SR' || value.status=='NSR')
            found='checked';
     if(value.status=='R' || value.status=='NF')
            not_found='checked';
         if(value.status=='C')
            closed_store='checked';
    info ='<div class="container-fluid pb-2 popupbox" style="height:fit-content;color:white !important;"><span class="d-flex flex-row  justify-content-between pt-2"><h5 style="padding-top:0.3rem;max-width: 60%;">'+value['name']+'</h5><div class="d-flex" style="height:max-content;"><img class="ml-2 float-right"  src="icons/share-icon.png" height="30px" onclick="share(\''+value['shareinfo']+'\',this)"  lat="'+value['latitude']+'" lon="'+value['longitude']+'" id="share_'+value['retailer_id']+'"><img class="ml-1" geocode="'+value['latitude']+','+value['longitude']+'" onclick="location_navigate(this)" src="icons/navigation-icon.png" height="30px"><span class=" popup" style="background: transparent;"><img class="ml-1"  src="icons/close-icon.png" height="30px" onclick="closeicon(this)" id="'+value['retailer_id']+'"></span></div></span><h5><span class="badge font-italic" style="text-align: left;background-color:#424242;"><span style="line-height:1rem;">'+value['nbhrd']+' Neighborhood</span><br><span style="line-height:1rem;">'+value['city']+' City</span></span></h5><img class="align-self-start" style="margin-top:1rem;" src="'+value['shop_image']+'" width="auto" alt="" height="150px"/><hr style="border-top: 1px solid white;"><p class="text-wrap"><p><span style="color:rgb(242, 101, 34)">Sub Channel: </span><a href="#" style="text-decoration:underline;cursor:pointer;color:#fff;"  onClick="haldiram_filter(\'\',\''+value['sub_type']+'\',\'\',\''+value['cluster']+'\')">'+value['sub_type']+' / '+value['sub_type']+'</a></p><p><span style="color:rgb(242, 101, 34)">Address: </span>'+value['address']+'  </p><p><span style="color:rgb(242, 101, 34)">Contact: </span><a href="tel:'+value['contact']+'" style="text-decoration:underline;">'+value['contact']+' </a></p><p><span style="color:rgb(242, 101, 34)">Outlet Potential: </span><span style="'+value['style_code']+'"><a onClick="haldiram_filter(\'\',\'\',\''+value['potential']+'\',\''+value['cluster']+'\')" style="text-decoration:underline;cursor:pointer;">'+value['outlet_potential']+'</a></span> </p><p><span style="color:rgb(242, 101, 34)">Visit Order: </span>'+value['visit_order']+'  </p><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'A\','+value['retailer_id']+','+value['cluster']+',0,0)"  id="flexRadioDefault'+value['retailer_id']+'" '+found+' >  <label class="form-check-label" for="flexRadioDefault'+value['retailer_id']+'" >    Found  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'NF\','+value['retailer_id']+','+value['cluster']+',0,0)" id="flexRadioDefault'+value['retailer_id']+'" '+not_found+'>  <label class="form-check-label" for="flexRadioDefault'+value['retailer_id']+'" > Not Found </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault" onClick="outlet_status_mdlz(\'C\','+value['retailer_id']+','+value['cluster']+',0,0)" id="flexRadioDefault'+value['retailer_id']+'" '+closed_store+'>  <label class="form-check-label" for="flexRadioDefault'+value['retailer_id']+'" > Store Closed </label></div></p><hr style="border-top: 1px solid white;"><p><span style="color:rgb(242, 101, 34)">Estimated Potential: </span></p><p><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="outlet_potential_status(1,'+value['retailer_id']+','+value['cluster']+',0,0)"  id="flexRadioDefaultp'+value['retailer_id']+'" '+low_status+' >  <label class="form-check-label" for="flexRadioDefaultp'+value['retailer_id']+'" >    Low  </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="outlet_potential_status(2,'+value['retailer_id']+','+value['cluster']+',0,0)" id="flexRadioDefaultp'+value['retailer_id']+'" '+medium_status+'>  <label class="form-check-label" for="flexRadioDefaultp'+value['retailer_id']+'" > Medium </label></div><div class="form-check layout">  <input class="form-check-input" type="radio" name="flexRadioDefault_potential" onClick="outlet_potential_status(3,'+value['retailer_id']+','+value['cluster']+',0,0)" id="flexRadioDefaultp'+value['retailer_id']+'" '+high_status+'>  <label class="form-check-label" for="flexRadioDefaultp'+value['retailer_id']+'" > High </label></div></p><div class="form-check capturedetails-upload" style="margin: 0px 0px 2px 36px; width: 80%;background-color:#f26522 !important;"><button type="button" class="btn btn-default upload" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="showmodal('+value['retailer_id']+');">Upload Store Photo(s)</button><span class="circle_count" style="background-color:#e35512 !important;">'+value['cicle_count']+'</span></div></div>';
    return info;
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
                    html:'<b>rega</b>',
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
           
            if(type==12)
            {
            //       res['griddata']['column'].push({
            //         data: null,
            //         visible: false,
            //         render: function (data, type, row, meta) {
            //           return meta.row;
            //         }
            // });
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
                          [line[1]['text'], line[2]['text'], line[3]['text'], line[4]['text'],line[5]['text'], line[6]['text'], line[7]['text'], line[8]['text'],line[9]['text'], line[10]['text'], line[11]['text'], line[12]['text']]
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
                                          
                                          {text: val['distance_subrd'], style:'defaultStyle'},
                                          {text: val['outlet_potential'], style:'defaultStyle'},
                                          {text: val['population'], style:'defaultStyle'},
                                          {text: val['village_choc_consmptn'], style:'defaultStyle'},
                                         
                                          {text: val['cluster_tag'], style:'defaultStyle'},
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
            title: 'SubRD List',
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
                                '</t></is></c><c  r="F' + rowCount + 
                                '"><v>' + val['distance_subrd'] + 
                                '</v></c><c  r="G' + rowCount + 
                                '"><v>' + val['outlet_potential'] + 
                                '</v></c><c  r="H' + rowCount + 
                                '"><v>' + val['population'] + 
                                '</v></c><c  r="I' + rowCount + 
                                '"><v>' + val['village_choc_consmptn'] + 
                                '</v></c><c t="inlineStr" r="J' + rowCount + 
                                '"><is><t>' +val['cluster_tag'] + 
                                '</t></is></c><c t="inlineStr" r="K' + rowCount + 
                                '"><is><t>' + val['exist_subrd_code'] + 
                                '</t></is></c><c t="inlineStr" r="L' + rowCount + 
                                '"><is><t>' +val['exist_subrd_name'] + 
                                '</t></is></c><c t="inlineStr" r="M' + rowCount + 
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
                   
                    paging: true,
                    searching:true,
                    info: false,"pageLength": 15,
                    responsive: false, "deferRender": true

                });
            }
            else if (type == 4 || type==5 || type==6 || type==7 || type==8 || type==9 || type==10 || type==11  || type==13 || type==14 || type==15 || type==16 || type==17 || type==19 || type==20 || type==21 || type==22 || type==24) {
               
  
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


            } 



        } else {
            tablefoot = false;
            
            if(type==12)
            {
            //       res['griddata']['column'].push({
            //         data: null,
            //         visible: false,
            //         render: function (data, type, row, meta) {
            //           return meta.row;
            //         }
            // });
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
                          [line[1]['text'], line[2]['text'], line[3]['text'], line[4]['text'],line[5]['text'], line[6]['text'], line[7]['text'], line[8]['text'],line[9]['text'], line[10]['text'], line[11]['text'], line[12]['text']]
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
                                          
                                          {text: val['distance_subrd'], style:'defaultStyle'},
                                          {text: val['outlet_potential'], style:'defaultStyle'},
                                          {text: val['population'], style:'defaultStyle'},
                                          {text: val['village_choc_consmptn'], style:'defaultStyle'},
                                         
                                          {text: val['cluster_tag'], style:'defaultStyle'},
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
            title: 'SubRD List',
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
                                '</t></is></c><c  r="F' + rowCount + 
                                '"><v>' + val['distance_subrd'] + 
                                '</v></c><c  r="G' + rowCount + 
                                '"><v>' + val['outlet_potential'] + 
                                '</v></c><c  r="H' + rowCount + 
                                '"><v>' + val['population'] + 
                                '</v></c><c  r="I' + rowCount + 
                                '"><v>' + val['village_choc_consmptn'] + 
                                '</v></c><c t="inlineStr" r="J' + rowCount + 
                                '"><is><t>' +val['cluster_tag'] + 
                                '</t></is></c><c t="inlineStr" r="K' + rowCount + 
                                '"><is><t>' + val['exist_subrd_code'] + 
                                '</t></is></c><c t="inlineStr" r="L' + rowCount + 
                                '"><is><t>' +val['exist_subrd_name'] + 
                                '</t></is></c><c t="inlineStr" r="M' + rowCount + 
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
                   
                    paging: true,
                    searching:true,
                    info: false,"pageLength": 15,
                    responsive: false, "deferRender": true

                });
            }
            else if (type == 4 || type==5 || type==6 || type==7 || type==8 || type==9 || type==10 || type==11  || type==13 || type==14 || type==15 || type==16 || type==17 || type==19 || type==20 || type==21 ||type==22 || type==24) {
             
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
         
           str +='<td style="text-align:right;">'+val['distance_subrd']+'</td>';
           str +='<td style="text-align:right;">'+val['outlet_potential']+'</td>';
           str +='<td style="text-align:right;">'+addCommas(val['population'])+'</td>';
           str +='<td  style="text-align:right;">'+addCommas(val['village_choc_consmptn'])+'</td>';
         
           str +='<td>'+val['cluster_tag']+'</td>';
           str +='<td><a href="#" id="'+val['exist_subrd_code']+'" taluk="'+val['taluk_census']+'" subrd_type="'+val['subrd_type']+'" district="'+val['loc9']+'" style="text-decoration:underline" onClick="show_existsubrd(this)">'+val['exist_subrd_code']+'</a></td>';
           str +='<td>'+val['exist_subrd_name']+'</td>';
           str +='<td>&nbsp;</td>';
           str += '</tr>';
            k++;
    });
      
      return $(str).toArray();
       
        // return str;

      
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
           
            div.innerHTML='';
			div.innerHTML ='';
				div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div class="legend-wraper"><span class="ring" style="border: 2px solid #51c82c"></span> High</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #ff8b02"></span> Medium</div><div class="legend-wraper"><span class="ring" style="border: 2px solid #f21919"></span> Low</div> </div></div>';
            if(Array.isArray(data))
            {
                
                    if(data[0]['show_summary']!=undefined && data[0]['show_summary']!=null &&  data[0]['show_summary']!=0)
                     {
                         var div = L.DomUtil.create('div', 'info2 legend2');

                var labels = [];
                
                    if(data[0]['Distributor'] ==undefined && data[0]['Distributor']==null)
                     {
                            summary_head=(data[0]['show_summary']==2) ? 'Recommended SubRD Location' : (data[0]['show_summary']==3 ? 'Whlsl Location' : '');
                          // div.innerHTML +='<div class="legend-wraper2 " dir="rtl" >'+summary_head+': '+data[0]['total_village']+'</div><div class="legend-wraper2 bgsk" dir="rtl"  >New Villages: '+data[0]['new_village']+'</div>';
                          // if(data[0]['Most Develpd'] !=0)
                          //    div.innerHTML +='<div class="legend-wraper2" dir="rtl" >Most Develpd Villgs: '+data[0]['Most Develpd']+'</div>';
                          // if(data[0]['Develpd'] !=0)
                          //    div.innerHTML +='<div class="legend-wraper2" dir="rtl" >Develpd Villgs: '+data[0]['Develpd']+'</div>';

                          texttml='';
                           // if(data[0]['Most Develpd'] !=0)
                           //   texttml +='<div class="legend-wraper2" dir="rtl" >Most Develpd Villgs: '+data[0]['Most Develpd']+'</div>';
                           // if(data[0]['Develpd'] !=0)
                           //   texttml +='<div class="legend-wraper2" dir="rtl" >Develpd Villgs: '+data[0]['Develpd']+'</div>';
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
                             texttml +='<div class="legend-wraper2" dir="rtl" >New Villages (Reco Subrd): '+data[0]['new_village_recommand']+'</div>';
                           if(data[0]['new_village_current'] !=0)
                             texttml +='<div class="legend-wraper2" dir="rtl" >New Villages (Current Subrd): '+data[0]['new_village_current']+'</div>';
                         data[0]['new_village']=data[0]['new_village_recommand']+data[0]['new_village_current'];
                         }
                         
                           div.innerHTML +='<div id="div-to-toggle"><button onclick="legend_pop()" class="btn-close" style="top:-8px !important;" ><i class="fas fa-close" id="hint" onclick="cley(this)" style="padding: 6px; margin: -8px;height: 25px;width: 25px; background-color: #ffffff;color: #232627;border-radius: 50%;border-color: #000 !important;display: inline-block;"></i></button><div id="myDIV"><div id="round-legend"></div><div class="legend-wraper2 " dir="rtl" >'+summary_head+': '+data[0]['total_village']+'</div><div class="legend-wraper2 bgsk" dir="rtl"  >New Villages: '+data[0]['new_village']+'</div>'+texttml;
                         //  if(data[0]['Transition'] !=0)
                         //     div.innerHTML +='<div class="legend-wraper2" dir="rtl" >Transition Villgs: '+data[0]['Transition']+'</div>';
                          
                         //   if(data[0]['Under-develpd'] !=0)
                         //     div.innerHTML +='<div class="legend-wraper2" dir="rtl" >Under Develpd Villgs: '+data[0]['Under-develpd']+'</div>';
                        
                         // if(data[0]['Not Rated'] !=0)
                         //     div.innerHTML +='<div class="legend-wraper2" dir="rtl" >Not Rated Villgs: '+data[0]['Not Rated']+'</div>';
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
           
            return div;
        };
         if(Array.isArray(data) && data.length >0)          
            legend.addTo(map);        
         else if(data!='' && data!=undefined)
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

      

        outlettbl = $("#outlet_list_tbl").DataTable({
            info: false,
            paging: false
        });


        setInterval(function() {
            // map.locate({setView: true, maxZoom: 16});

            getLocation();

            geo = current_location['lat'] + ',' + current_location['lon'];
          

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
                     info=getinfo(global_data[outlet_id],'',status);
                  
                    showarray[outlet_id].openPopup();
                     showarray[outlet_id]._popup.setContent(info);
                   
                       getmaker(cluster_id,true);



         //            input_obj = {
         //                'type': 11,
         //               'cluster_id':[cluster_id],
         //                'filter_beat':filter_beat,
         //                'show_cluster':status_type,
         //            };

         // if(cluster_id!=0 && status_type=='true')
         //        input_obj['filter_bycluster']=[cluster_id];

         //             initial(input_obj, 0,11, '',true);

         //            setTimeout(function showpop(){showarray[outlet_id].openPopup();},1000);

                  


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
                'outlet_id': outlet_id,"status":status,"lat":current_location['lat'],"lon":current_location['lon']
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
                     if(status=='NF' || status=='C')
                   {
                     msg=[];msg['NF']='Not Found';msg['C']='Store Closed';
                       var greenIcon = L.icon({
                            iconUrl: 'images/nr.png',
                            iconSize: [24, 24]
                        });
                       // showarray_uncovered[outlet_id].setIcon(greenIcon);
                        showarray[outlet_id].setIcon(greenIcon);
                        setTimeout(function showpop(){showarray[outlet_id].openPopup();},1000);
                       alert(msg[status]);
                   }
                   info=getinfo(global_data[outlet_id],status);
                  
                   showarray[outlet_id].openPopup();
                   showarray[outlet_id]._popup.setContent(info);
                   
                  getmaker(cluster_id,true);
                   

                } else {
                    alert("Not updated");
                }
             
            }
        });

        
        
    }
    function outlet_status_potential(status,refid,cluster_id,status_type='',save=false) {
       
        outlet_id =refid;
        
        if(current_location['lat']===undefined || current_location['lat']=='' || current_location['lat']===null)
       {
           current_location['lat']=map.getCenter().lat;
           current_location['lon']=map.getCenter().lng;
       }
       data_json={
                'outlet_id': outlet_id,"status":status,"lat":current_location['lat'],"lon":current_location['lon']
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
                   info=getinfo(global_data[outlet_id],status);
                  
                   showarray[outlet_id].openPopup();
                   showarray[outlet_id]._popup.setContent(info);
                   
                  getmaker(cluster_id,true);
                   

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
       //  console.log(clicked_shop_location);
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

     function getmaker(cluster_id,table_only=false)
    {
        input_obj.cluster_id=cluster_id;
          outlet_type=[];selected_id=[];potential_selected_id=[];status_selected_id=[];
          cluster=[cluster_id];filter_beat=[];

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
          $('input[name="beat"]:checked').each(function() {
            filter_beat.push(this.value);
    });
         
       dynamic_control[5].enable();
         obj = {
            'type': 11,
            'filter_bychannel':selected_id,
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,
            'outlet_type':outlet_type,
            'filter_bystatus':status_selected_id,
            'cluster_id':cluster,
            'show_cluster':'true'
               };
               
        initial(obj, 11, input_obj.type, true,table_only);

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
        filter_beat=[];
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
          $('input[name="beat"]:checked').each(function() {
            filter_beat.push(this.value);
    });
         
  
         obj = {
            'type': input_obj.type,
            'filter_bychannel':selected_id,
            'filter_bypotential':potential_selected_id,
            'filter_beat':filter_beat,
            'outlet_type':outlet_type,
             'cluster_id':[input_obj.cluster_id],
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
  
         // obj = {
         //    'type': input_obj.type,
         //    'filter_beat':filter_beat,
         //    'filter_bychannel':[],
            
         //       };
               
         //  initial(obj, 2, input_obj.type, false);
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

function clickZoom(e) {
  map.setView(e.target.getLatLng(),22);
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

<script>
$(document).ready(function(){
    
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