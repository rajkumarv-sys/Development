@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css"> -->

<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

@endpush

@section('content')

<div class='form-control-lg'>

 <form action="{{url('/outlet/store')}}" method="post" enctype="multipart/form-data">
     {{ csrf_field() }}
    <div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
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
    </div>
  </div>
  <div class="col-md-6 grid-margin stretch-card">
 <div class="card">
      <div class="card-body">
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
  </div>

</div>

    </div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://www.nobleui.com/laravel/template/light/assets/js/file-upload.js"></script>

@endpush


@push('custom-scripts')


<script type="text/javascript">
    $(document).ready(function ()
    {

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
                     url : 'getsubchannel/' +channel,
                     type : "POST",
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
    });
    </script>
<!-- <script src="{{ asset('assets/js/leaflet-search.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script> -->
<script src="{{ asset('assets/js/datepicker.js') }}"></script>



@endpush
