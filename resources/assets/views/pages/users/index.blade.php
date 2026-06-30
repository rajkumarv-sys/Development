@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Users</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Users</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{url('/user/create')}}" class="btn btn-sm btn-primary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Add User
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="companyTable" class="table table-hover table-bordered mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id=""></th>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email or User ID</th>
                                <th>Designation</th>
                                <th>Phone</th>
                                <th>Organization</th>
                                <th>Country</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($userlist))
                            @foreach($userlist as $slist)
                            <tr>
                                <td><input type="checkbox" value="" class="checkSingle" name="select_all[]"></td>
                                <td>{{$slist->id}}</td>
                                <td>{{$slist->firstname}}</td>
                                <td>{{$slist->lastname}}</td>
                                <td>{{$slist->email}}</td>
                                <td>{{$slist->designation}}</td>
                                <td>{{$slist->phone}}</td>
                                <td>{{$slist->Organization}}</td>
                                <td>{{$slist->country}}</td>
                                <td>{{$slist->user_type}}</td>
                                <td>{{$slist->status}}</td>
                                <td>
                                    <a href="{{url('/user/'.$slist->id.'/edit')}}" class="btn btn-sm btn-success btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Edit User Record">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>
                                    
                                    <a href="{{url('/user/'.$slist->id.'/menu')}}" class="btn btn-sm btn-success btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Add Menu Access">
                                        <i class="fas fa-sitemap text-white"></i>
                                    </a>

                                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-success btn-icon-text" onclick="return myReset();" data-toggle="tooltip" data-placement="bottom" title="Reset User Password"> 
                                       <i class="fas fa-lock text-white"></i> 
                                    </a>

                                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-danger btn-icon-text" onclick="return myFunction();" title="Delete User Record" data-toggle="tooltip" data-placement="bottom"> 
                                       <i class="fas fa-trash text-white"></i> 
                                    </a> 

                                    <form id="reset-form-{{$slist->id}}"  action="{{url('/user/resetpwd')}}" method="post"> 
                                        @csrf 
                                        <input type="hidden" name="id" value="{{$slist->id}}">
                                    </form> 
                                             
                                    <form id="delete-form-{{$slist->id}}"  action="{{route('user.destroy', $slist->id)}}"  method="post"> 
                                        @csrf @method('DELETE') 
                                    </form> 
                                                                    
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        $('#companyTable').DataTable();
    });



    function myFunction() {
      var x = confirm("Are You Sure to delete this");
      if(x == true) {
            document.getElementById('delete-form-{{$slist->id}}').submit();
            return false;
      } else {
            return false;
      }
    }

    function myReset() {
      var x = confirm("Are You Sure to Reset Password ....");
      if(x == true) {
            document.getElementById('reset-form-{{$slist->id}}').submit();
            return false;
      } else {
            return false;
      }
    }


</script>
@endpush