@extends('layout.master')

@push('plugin-styles')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

@endpush

@section('content')



    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif


   <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Outlet List</h6>
       
        <div class="table-responsive pt-3">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th >#</th>
                <th >Outlet Name</th>
                <th >Owner Name</th>
                <th >Channel</th>
                <th >Sub Channel</th>
              </tr>
            </thead>
            <tbody>
              @foreach($outlet as $outlet)
            <tr>
                <th >{{$outlet->refid}}</th>
                <td>{{$outlet->outlet_name}}</td>
                <td>{{$outlet->owner_name}}</td>
                <td>{{$outlet->channel_name}}</td>
                <td>{{$outlet->sub_channel_name}}</td>
                
               
            </tr>
        @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

    
@endsection



@push('custom-scripts')



@endpush

